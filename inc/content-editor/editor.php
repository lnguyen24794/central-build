<?php
/**
 * "Website Content" — one simple place for non-technical users to edit
 * every section of every page.
 *
 * - Admin menu: Website Content (Administrators + Editors)
 * - One screen per page, one fold-out box per section, in page order
 * - Image picker (Media Library), icon picker, add / remove / move items
 * - "Undo last save" safety net
 * - "Edit this page" button on the website for logged-in editors
 *
 * Data is read from / written to the same options the theme already uses,
 * through each settings file's own sanitizer, so templates are unchanged.
 */

if (!defined('ABSPATH')) {
    exit;
}

require_once __DIR__ . '/registry.php';
require_once __DIR__ . '/menu-store.php';

const CB_CE_CAP   = 'cb_edit_content';
const CB_CE_SLUG  = 'cb-content';
const CB_CE_CAPV  = 1;

/* =====================================================================
 * Capabilities & menu
 * ===================================================================== */

function cb_ce_grant_caps(): void
{
    if ((int) get_option('cb_ce_caps_version') === CB_CE_CAPV) {
        return;
    }
    foreach (array('administrator', 'editor') as $role_name) {
        $role = get_role($role_name);
        if ($role) {
            $role->add_cap(CB_CE_CAP);
        }
    }
    update_option('cb_ce_caps_version', CB_CE_CAPV);
}
add_action('init', 'cb_ce_grant_caps');

function cb_ce_admin_menu(): void
{
    add_menu_page(
        'Website Content',
        'Website Content',
        CB_CE_CAP,
        CB_CE_SLUG,
        'cb_ce_render_screen',
        'dashicons-edit-page',
        3
    );
    add_submenu_page(CB_CE_SLUG, 'All pages', 'All pages', CB_CE_CAP, CB_CE_SLUG, 'cb_ce_render_screen');
    foreach (cb_ce_pages() as $key => $page) {
        add_submenu_page(CB_CE_SLUG, $page['title'], cb_ce_short_title($page['title']), CB_CE_CAP, CB_CE_SLUG . '&edit=' . $key, '__return_null');
    }
}
add_action('admin_menu', 'cb_ce_admin_menu', 9);

function cb_ce_short_title(string $title): string
{
    $title = preg_replace('/\s*\(.*\)$/', '', $title);
    return str_replace('Commercial Design and Solutions', 'Design and Solutions', $title);
}

/** Point the per-page submenu items at the right URL and highlight them. */
function cb_ce_fix_submenu_links(): void
{
    global $submenu;
    if (empty($submenu[CB_CE_SLUG])) {
        return;
    }
    foreach ($submenu[CB_CE_SLUG] as $i => $item) {
        if (strpos($item[2], CB_CE_SLUG . '&edit=') === 0) {
            $submenu[CB_CE_SLUG][$i][2] = 'admin.php?page=' . $item[2];
        }
    }
}
add_action('admin_menu', 'cb_ce_fix_submenu_links', 999);

function cb_ce_submenu_highlight($submenu_file)
{
    if (isset($_GET['page'], $_GET['edit']) && $_GET['page'] === CB_CE_SLUG) {
        return 'admin.php?page=' . CB_CE_SLUG . '&edit=' . sanitize_key($_GET['edit']);
    }
    return $submenu_file;
}
add_filter('submenu_file', 'cb_ce_submenu_highlight');

/** Hide the old scattered settings screens (still reachable by URL). */
function cb_ce_hide_old_menus(): void
{
    global $submenu;
    remove_menu_page('central-build-options');
    foreach ((array) $submenu as $parent => $items) {
        foreach ((array) $items as $item) {
            if (isset($item[2]) && strpos($item[2], 'central-build-') === 0) {
                remove_submenu_page($parent, $item[2]);
            }
        }
    }
}
add_action('admin_menu', 'cb_ce_hide_old_menus', 1000);

/* =====================================================================
 * Assets
 * ===================================================================== */

function cb_ce_admin_assets(string $hook): void
{
    if (strpos($hook, CB_CE_SLUG) === false) {
        return;
    }
    $base = get_template_directory_uri() . '/inc/content-editor/assets';
    $dir  = __DIR__ . '/assets';
    wp_enqueue_media();
    wp_enqueue_style('cb-ce-fa', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css', array(), '6.5.2');
    wp_enqueue_style('cb-ce-bi', 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css', array(), '1.11.1');
    wp_enqueue_style('cb-ce', $base . '/editor.css', array(), (string) filemtime($dir . '/editor.css'));
    wp_enqueue_script('cb-ce', $base . '/editor.js', array('jquery'), (string) filemtime($dir . '/editor.js'), true);
}
add_action('admin_enqueue_scripts', 'cb_ce_admin_assets');

function cb_ce_admin_title($title)
{
    if (isset($_GET['page'], $_GET['edit']) && $_GET['page'] === CB_CE_SLUG) {
        $page = cb_ce_page(sanitize_key($_GET['edit']));
        if ($page) {
            return 'Edit ' . $page['title'] . ' ‹ ' . get_bloginfo('name');
        }
    }
    return $title;
}
add_filter('admin_title', 'cb_ce_admin_title');

/** Keep the editor calm: hide other plugins' banners on our screens. */
function cb_ce_quiet_notices(): void
{
    $screen = get_current_screen();
    if ($screen && strpos($screen->id, CB_CE_SLUG) !== false) {
        remove_all_actions('admin_notices');
        remove_all_actions('all_admin_notices');
    }
}
add_action('in_admin_header', 'cb_ce_quiet_notices', 1000);

/* =====================================================================
 * Reading data
 * ===================================================================== */

function cb_ce_page(string $key): ?array
{
    $pages = cb_ce_pages();
    return $pages[$key] ?? null;
}

function cb_ce_section_ctx(array $page, array $section): array
{
    $defaults = $page['section_defaults'] ?? array();
    return array(
        'labels'  => array_merge(cb_ce_label_dictionary(), $defaults['labels'] ?? array(), $section['labels'] ?? array()),
        'types'   => array_merge($defaults['types'] ?? array(), $section['types'] ?? array()),
        'choices' => array_merge($defaults['choices'] ?? array(), $section['choices'] ?? array()),
        'items'   => $section['items'] ?? array(),
        'fields'  => $section['fields'] ?? array(),
    );
}

/** Current values of every section of a page: [section_key => value]. */
function cb_ce_get_values(string $page_key): array
{
    $page   = cb_ce_page($page_key);
    $values = array();

    if ($page['store']['type'] === 'group' || $page['store']['type'] === 'custom') {
        $data = call_user_func($page['store']['get']);
        foreach ($page['sections'] as $key => $section) {
            $values[$key] = $data[$key] ?? '';
        }
        return $values;
    }

    $home = function_exists('central_build_get_home_content') ? central_build_get_home_content() : array();
    foreach ($page['sections'] as $key => $section) {
        if (!empty($section['home'])) {
            $values[$key] = $home[$section['home']] ?? array();
            continue;
        }
        $value = array();
        foreach ($section['fields'] ?? array() as $field => $spec) {
            if (!empty($spec['getter']) && function_exists($spec['getter'])) {
                $v = call_user_func($spec['getter']);
                $value[$field] = is_array($v) ? array_values($v) : array();
            } else {
                $v = get_option($spec['option'], $spec['default'] ?? '');
                $value[$field] = ($v === false || $v === null) ? '' : $v;
            }
        }
        $values[$key] = $value;
    }
    return $values;
}

function cb_ce_section_visible(array $section): ?bool
{
    if (empty($section['visible'])) {
        return null;
    }
    return (bool) get_option($section['visible'], true);
}

/** Option names touched by a page (for "Undo last save"). */
function cb_ce_page_options(array $page): array
{
    if ($page['store']['type'] === 'group') {
        return array($page['store']['option']);
    }
    if ($page['store']['type'] === 'custom') {
        return array();
    }
    $names = array();
    foreach ($page['sections'] as $section) {
        if (!empty($section['home'])) {
            $names[] = 'central_build_home_content';
        }
        if (!empty($section['visible'])) {
            $names[] = $section['visible'];
        }
        foreach ($section['fields'] ?? array() as $spec) {
            $names[] = $spec['option'];
        }
    }
    return array_values(array_unique($names));
}

/** Public URL of the page being edited. */
function cb_ce_view_url(array $page): string
{
    if (empty($page['template']) || $page['template'] === 'front') {
        return home_url('/');
    }
    $found = get_posts(array(
        'post_type'      => 'page',
        'post_status'    => 'publish',
        'posts_per_page' => 1,
        'meta_key'       => '_wp_page_template',
        'meta_value'     => $page['template'],
        'fields'         => 'ids',
    ));
    return $found ? get_permalink($found[0]) : home_url('/');
}

/* =====================================================================
 * Field type detection
 * ===================================================================== */

function cb_ce_is_list($value): bool
{
    return is_array($value) && ($value === array() || array_keys($value) === range(0, count($value) - 1));
}

function cb_ce_is_image_url(string $value): bool
{
    return (bool) preg_match('~\.(jpe?g|png|gif|webp|svg|avif)(\?.*)?$~i', $value)
        || (bool) preg_match('~images\.unsplash\.com|/wp-content/uploads/~i', $value);
}

function cb_ce_detect_type(string $key, $value, array $ctx): string
{
    if (isset($ctx['types'][$key])) {
        return $ctx['types'][$key] === 'emails' ? 'list' : $ctx['types'][$key];
    }
    if (isset($ctx['choices'][$key])) {
        return 'select';
    }
    if (is_bool($value)) {
        return 'toggle';
    }
    if (is_int($value) || is_float($value)) {
        return 'number';
    }
    if (is_array($value)) {
        if (!cb_ce_is_list($value)) {
            return 'group';
        }
        $first = $value[0] ?? ($ctx['items'][$key] ?? null);
        if (is_array($first)) {
            return 'repeater';
        }
        if (preg_match('/image|photo|gallery/', $key) || (is_string($first) && cb_ce_is_image_url($first))) {
            return 'images';
        }
        return 'list';
    }
    $value = (string) $value;
    if ($key === 'icon' || $key === 'checkout_icon') {
        return (strpos($value, '/') !== false || strpos($value, '.') !== false) ? 'image' : 'icon';
    }
    if (preg_match('/(^|_)(image|background|logo|photo)$|^(logo_url|icon_url)$/', $key) || cb_ce_is_image_url($value)) {
        return 'image';
    }
    if (preg_match('/(^|_)url$|^redirect$/', $key)) {
        return 'url';
    }
    if ($key === 'email' || $key === 'reply_to') {
        return 'email';
    }
    if (preg_match('/<br\s*\/?>/i', $value) || strlen($value) > 90
        || in_array($key, array('description', 'text', 'content', 'answer', 'paragraph', 'body', 'intro', 'introduction', 'result_text'), true)) {
        return 'textarea';
    }
    return 'text';
}

/** Blank copy of an item, used as the template for "Add another". */
function cb_ce_blank($value)
{
    if (is_array($value)) {
        $out = array();
        foreach ($value as $k => $v) {
            $out[$k] = cb_ce_blank($v);
        }
        return cb_ce_is_list($value) ? array() : $out;
    }
    if (is_bool($value)) {
        return false;
    }
    if (is_int($value) || is_float($value)) {
        return 0;
    }
    return '';
}

/* =====================================================================
 * Simple formatting: *stars* = coloured words, new line = line break
 * ===================================================================== */

function cb_ce_to_edit(string $html): array
{
    $fmt  = array();
    // Show "&" instead of "&amp;" etc. (the sanitizer re-encodes on save).
    $html = str_replace(array('&amp;', '&quot;', '&#039;', '&#39;', '&nbsp;'), array('&', '"', "'", "'", ' '), $html);
    if (preg_match('/<span[^>]*>/i', $html, $m)) {
        $fmt['span'] = $m[0];
        $html = preg_replace('/<span[^>]*>(.*?)<\/span>/is', '*$1*', $html);
    }
    if (preg_match('/<br\s*\/?>/i', $html)) {
        $fmt['br'] = 1;
        $html = preg_replace('/[ \t]*<br\s*\/?>[ \t]*\n?/i', "\n", $html);
    }
    return array($html, $fmt);
}

function cb_ce_from_edit(string $text, array $fmt): string
{
    $text = str_replace(array("\r\n", "\r"), "\n", $text);
    if (!empty($fmt['span']) && preg_match('/^<span(\s[^<>]*)?>$/i', (string) $fmt['span'])) {
        $text = preg_replace('/\*([^*\n]+)\*/', $fmt['span'] . '$1</span>', $text);
    }
    if (!empty($fmt['br'])) {
        $text = preg_replace('/\n+/', ' <br> ', trim($text));
    }
    return $text;
}

/* =====================================================================
 * Rendering
 * ===================================================================== */

function cb_ce_render_screen(): void
{
    if (!current_user_can(CB_CE_CAP)) {
        wp_die(esc_html__('Sorry, you are not allowed to edit website content.', 'central-build'));
    }
    $edit = isset($_GET['edit']) ? sanitize_key($_GET['edit']) : '';
    if ($edit && cb_ce_page($edit)) {
        cb_ce_render_page($edit);
    } else {
        cb_ce_render_hub();
    }
}

function cb_ce_render_hub(): void
{
    $pages = cb_ce_pages();
    $groups = array(
        'pages' => array('title' => 'Pages', 'intro' => 'Pick the page you want to change.'),
        'site'  => array('title' => 'Shown on every page', 'intro' => 'Things that appear across the whole website.'),
    );
    ?>
    <div class="wrap cb-ce">
        <h1 class="cb-ce__title">Website Content</h1>
        <p class="cb-ce__lead">Change the words, pictures and buttons on your website. Click <strong>Edit</strong> on a page, open the part you want to change, then press <strong>Save changes</strong>. Your changes appear on the website straight away.</p>

        <?php foreach ($groups as $gkey => $group) : ?>
            <h2 class="cb-ce__group-title"><?php echo esc_html($group['title']); ?></h2>
            <p class="cb-ce__group-intro"><?php echo esc_html($group['intro']); ?></p>
            <div class="cb-ce__cards">
                <?php foreach ($pages as $key => $page) :
                    if (($page['group'] ?? 'pages') !== $gkey) {
                        continue;
                    }
                    $edit_url = admin_url('admin.php?page=' . CB_CE_SLUG . '&edit=' . $key);
                    ?>
                    <div class="cb-ce__card">
                        <a class="cb-ce__card-main" href="<?php echo esc_url($edit_url); ?>">
                            <span class="dashicons <?php echo esc_attr($page['icon']); ?>"></span>
                            <span class="cb-ce__card-text">
                                <strong><?php echo esc_html($page['title']); ?></strong>
                                <small><?php echo esc_html($page['summary']); ?></small>
                            </span>
                        </a>
                        <div class="cb-ce__card-actions">
                            <a class="button button-primary" href="<?php echo esc_url($edit_url); ?>">Edit</a>
                            <?php if (($page['group'] ?? 'pages') === 'pages') : ?>
                                <a class="button" href="<?php echo esc_url(cb_ce_view_url($page)); ?>" target="_blank" rel="noopener">View page ↗</a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>

        <h2 class="cb-ce__group-title">Other things you can update</h2>
        <div class="cb-ce__cards cb-ce__cards--small">
            <?php
            $others = array(
                array('dashicons-portfolio', 'Projects', 'Add or edit the projects shown in "Our latest work".', 'edit.php?post_type=fitout_sector'),
                array('dashicons-format-image', 'Photos & files', 'Upload new photos to use on the website.', 'upload.php'),
                array('dashicons-feedback', 'Messages from forms', 'Read the enquiries people sent from the website.', 'edit.php?post_type=cb_form_submission'),
                array('dashicons-menu', 'Menu', 'Change the links in the top menu.', 'nav-menus.php'),
            );
            foreach ($others as $o) :
                if ($o[3] === 'nav-menus.php' && !current_user_can('edit_theme_options')) {
                    continue;
                }
                ?>
                <a class="cb-ce__card cb-ce__card-main" href="<?php echo esc_url(admin_url($o[3])); ?>">
                    <span class="dashicons <?php echo esc_attr($o[0]); ?>"></span>
                    <span class="cb-ce__card-text"><strong><?php echo esc_html($o[1]); ?></strong><small><?php echo esc_html($o[2]); ?></small></span>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
}

function cb_ce_render_page(string $page_key): void
{
    $page     = cb_ce_page($page_key);
    $values   = cb_ce_get_values($page_key);
    $backup   = get_option('cb_ce_backup_' . $page_key);
    $view_url = cb_ce_view_url($page);
    $open     = isset($_GET['open']) ? sanitize_key($_GET['open']) : '';
    $status   = isset($_GET['cb_saved']) ? sanitize_key($_GET['cb_saved']) : '';
    ?>
    <div class="wrap cb-ce cb-ce--page">
        <p class="cb-ce__crumbs"><a href="<?php echo esc_url(admin_url('admin.php?page=' . CB_CE_SLUG)); ?>">← All pages</a></p>
        <div class="cb-ce__head">
            <h1 class="cb-ce__title"><span class="dashicons <?php echo esc_attr($page['icon']); ?>"></span> <?php echo esc_html($page['title']); ?></h1>
            <a class="button button-hero" href="<?php echo esc_url($view_url); ?>" target="_blank" rel="noopener">View on website ↗</a>
        </div>

        <?php if ($status === 'saved') : ?>
            <div class="notice notice-success cb-ce__notice"><p><strong>Saved!</strong> Your changes are now live on the website. <a href="<?php echo esc_url($view_url); ?>" target="_blank" rel="noopener">Have a look ↗</a></p></div>
        <?php elseif ($status === 'restored') : ?>
            <div class="notice notice-success cb-ce__notice"><p><strong>Done.</strong> The page is back to how it was before your last save.</p></div>
        <?php elseif ($status === 'error') : ?>
            <div class="notice notice-error cb-ce__notice"><p>Sorry, something went wrong and nothing was saved. Please try again.</p></div>
        <?php endif; ?>

        <ol class="cb-ce__steps">
            <li>Click a part of the page below to open it.</li>
            <li>Change the text or pictures.</li>
            <li>Press <strong>Save changes</strong> at the bottom.</li>
        </ol>

        <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" class="cb-ce__form" id="cb-ce-form">
            <input type="hidden" name="action" value="cb_ce_save" />
            <input type="hidden" name="cb_page" value="<?php echo esc_attr($page_key); ?>" />
            <input type="hidden" name="cb_open" value="" />
            <?php wp_nonce_field('cb_ce_save_' . $page_key); ?>

            <?php
            $n = 0;
            foreach ($page['sections'] as $skey => $section) :
                $n++;
                $ctx     = cb_ce_section_ctx($page, $section);
                $visible = cb_ce_section_visible($section);
                $help    = $section['help'] ?? ($page['section_defaults']['help'] ?? '');
                ?>
                <details class="cb-ce__section" id="section-<?php echo esc_attr($skey); ?>" data-section="<?php echo esc_attr($skey); ?>" <?php echo ($open === $skey) ? 'open' : ''; ?>>
                    <summary>
                        <span class="cb-ce__num"><?php echo (int) $n; ?></span>
                        <span class="cb-ce__sum-text">
                            <strong><?php echo esc_html($section['label']); ?></strong>
                            <?php if ($help) : ?><small><?php echo wp_kses_post($help); ?></small><?php endif; ?>
                        </span>
                        <?php if ($visible === false) : ?><span class="cb-ce__badge cb-ce__badge--off">Hidden</span><?php endif; ?>
                        <span class="cb-ce__chev" aria-hidden="true"></span>
                    </summary>
                    <div class="cb-ce__section-body">
                        <?php if ($visible !== null) : ?>
                            <div class="cb-ce__visibility">
                                <?php cb_ce_toggle('cb_vis[' . $skey . ']', $visible, 'Show this part on the website'); ?>
                            </div>
                        <?php endif; ?>
                        <?php
                        $value = $values[$skey];
                        $name  = 'cb[' . $skey . ']';
                        if (is_array($value) && !cb_ce_is_list($value)) {
                            foreach ($value as $fkey => $fvalue) {
                                $fctx = $ctx;
                                if (isset($ctx['fields'][$fkey]['type'])) {
                                    $fctx['types'][$fkey] = $ctx['fields'][$fkey]['type'];
                                }
                                if (isset($ctx['fields'][$fkey]['label'])) {
                                    $fctx['labels'][$fkey] = $ctx['fields'][$fkey]['label'];
                                }
                                if (isset($ctx['fields'][$fkey]['item'])) {
                                    $fctx['items'][$fkey] = $ctx['fields'][$fkey]['item'];
                                }
                                cb_ce_render_field($name . '[' . $fkey . ']', (string) $fkey, $fvalue, $fctx);
                            }
                        } else {
                            $label_ctx = $ctx;
                            $label_ctx['labels'][$skey] = $section['label'];
                            cb_ce_render_field($name, $skey, $value, $label_ctx);
                        }
                        if (!empty($section['link'])) {
                            printf('<p><a class="button" href="%s">%s →</a></p>', esc_url(admin_url($section['link']['url'])), esc_html($section['link']['label']));
                        }
                        ?>
                        <p class="cb-ce__section-foot">
                            <button type="submit" class="button button-primary">Save changes</button>
                        </p>
                    </div>
                </details>
            <?php endforeach; ?>

            <div class="cb-ce__savebar">
                <span class="cb-ce__dirty" hidden>● You have unsaved changes</span>
                <span class="cb-ce__clean"><?php echo $status === 'saved' ? '<strong style="color:#00a32a">✓ Saved — your changes are live on the website.</strong>' : 'All changes saved'; ?></span>
                <span class="cb-ce__savebar-actions">
                    <?php if (is_array($backup) && !empty($backup['time'])) : ?>
                        <button type="submit" form="cb-ce-restore" class="button cb-ce__undo" title="Saved <?php echo esc_attr(wp_date('j M Y, g:i a', (int) $backup['time'])); ?>">↶ Undo last save</button>
                    <?php endif; ?>
                    <button type="submit" class="button button-primary button-hero">Save changes</button>
                </span>
            </div>
        </form>

        <?php if (is_array($backup) && !empty($backup['time'])) : ?>
            <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" id="cb-ce-restore" data-confirm="Put this page back to how it was before your last save (<?php echo esc_attr(wp_date('j M, g:i a', (int) $backup['time'])); ?>)?">
                <input type="hidden" name="action" value="cb_ce_restore" />
                <input type="hidden" name="cb_page" value="<?php echo esc_attr($page_key); ?>" />
                <?php wp_nonce_field('cb_ce_restore_' . $page_key); ?>
            </form>
        <?php endif; ?>

        <?php cb_ce_icon_palette(); ?>
    </div>
    <?php
}

function cb_ce_label(string $key, array $ctx): string
{
    if (isset($ctx['labels'][$key])) {
        return $ctx['labels'][$key];
    }
    return ucfirst(trim(str_replace('_', ' ', $key)));
}

function cb_ce_toggle(string $name, bool $on, string $label): void
{
    ?>
    <label class="cb-ce__toggle">
        <input type="hidden" name="<?php echo esc_attr($name); ?>" value="0" />
        <input type="checkbox" name="<?php echo esc_attr($name); ?>" value="1" <?php checked($on); ?> />
        <span class="cb-ce__toggle-ui" aria-hidden="true"></span>
        <span><?php echo esc_html($label); ?></span>
    </label>
    <?php
}

function cb_ce_render_field(string $name, string $key, $value, array $ctx): void
{
    $type  = cb_ce_detect_type($key, $value, $ctx);
    $label = cb_ce_label($key, $ctx);
    $id    = 'cb-' . substr(md5($name), 0, 10);

    switch ($type) {
        case 'group':
            echo '<fieldset class="cb-ce__group"><legend>' . esc_html($label) . '</legend>';
            foreach ($value as $k => $v) {
                cb_ce_render_field($name . '[' . $k . ']', (string) $k, $v, $ctx);
            }
            echo '</fieldset>';
            return;

        case 'repeater':
            $template = $ctx['items'][$key] ?? (isset($value[0]) ? cb_ce_blank($value[0]) : array('title' => ''));
            cb_ce_render_repeater($name, $key, (array) $value, $template, $label, $ctx);
            return;

        case 'images':
            cb_ce_render_repeater($name, $key, (array) $value, '', $label, $ctx, 'image');
            return;

        case 'list':
            $lines = implode("\n", array_map('strval', (array) $value));
            $hint  = ($ctx['types'][$key] ?? '') === 'emails' ? 'One email address per line.' : 'One per line.';
            echo '<div class="cb-ce__field">';
            echo '<label for="' . esc_attr($id) . '">' . esc_html($label) . '</label>';
            echo '<textarea id="' . esc_attr($id) . '" name="' . esc_attr($name . '[__lines]') . '" rows="' . max(3, count((array) $value) + 1) . '">' . esc_textarea($lines) . '</textarea>';
            echo '<p class="cb-ce__hint">' . esc_html($hint) . '</p></div>';
            return;

        case 'toggle':
            echo '<div class="cb-ce__field">';
            cb_ce_toggle($name, (bool) $value, $label);
            echo '</div>';
            return;

        case 'number':
            echo '<div class="cb-ce__field cb-ce__field--short"><label for="' . esc_attr($id) . '">' . esc_html($label) . '</label>';
            echo '<input type="number" step="any" id="' . esc_attr($id) . '" name="' . esc_attr($name) . '" value="' . esc_attr((string) $value) . '" /></div>';
            return;

        case 'hidden':
            echo '<input type="hidden" name="' . esc_attr($name) . '" value="' . esc_attr((string) $value) . '" />';
            return;

        case 'select':
            echo '<div class="cb-ce__field cb-ce__field--short"><label for="' . esc_attr($id) . '">' . esc_html($label) . '</label><select id="' . esc_attr($id) . '" name="' . esc_attr($name) . '">';
            $choices = $ctx['choices'][$key];
            if (is_string($choices) && is_callable($choices)) {
                $choices = call_user_func($choices);
            }
            if (!isset($choices[$value]) && $value !== '') {
                $choices[$value] = $value;
            }
            foreach ($choices as $cv => $cl) {
                echo '<option value="' . esc_attr($cv) . '" ' . selected((string) $value, (string) $cv, false) . '>' . esc_html($cl) . '</option>';
            }
            echo '</select></div>';
            return;

        case 'image':
            cb_ce_render_image($name, (string) $value, $label);
            return;

        case 'icon':
            ?>
            <div class="cb-ce__field cb-ce__icon-field">
                <label><?php echo esc_html($label); ?></label>
                <div class="cb-ce__icon-row">
                    <span class="cb-ce__icon-preview"><i class="<?php echo esc_attr((string) $value); ?>"></i></span>
                    <input type="hidden" class="cb-ce__icon-input" name="<?php echo esc_attr($name); ?>" value="<?php echo esc_attr((string) $value); ?>" />
                    <button type="button" class="button cb-ce__icon-btn">Change icon</button>
                </div>
            </div>
            <?php
            return;
    }

    // text / textarea / url / email
    list($edit_value, $fmt) = cb_ce_to_edit((string) $value);
    $hints = array();
    if (!empty($fmt['span'])) {
        $hints[] = 'Words between <code>*stars*</code> are shown in the highlight colour.';
    }
    if (!empty($fmt['br'])) {
        $type    = 'textarea';
        $hints[] = 'Each new line here starts a new line on the website.';
    }
    if ($type === 'url') {
        $hints[] = 'A page on this website (e.g. <code>/contact</code>), a full web address (<code>https://…</code>), <code>tel:+61…</code> or <code>mailto:you@…</code>.';
    }
    echo '<div class="cb-ce__field">';
    echo '<label for="' . esc_attr($id) . '">' . esc_html($label) . '</label>';
    if ($type === 'textarea') {
        $rows = max(2, min(8, (int) ceil(strlen($edit_value) / 90) + substr_count($edit_value, "\n")));
        echo '<textarea id="' . esc_attr($id) . '" name="' . esc_attr($name) . '" rows="' . (int) $rows . '">' . esc_textarea($edit_value) . '</textarea>';
    } else {
        $input_type = $type === 'email' ? 'email' : 'text';
        echo '<input type="' . esc_attr($input_type) . '" id="' . esc_attr($id) . '" name="' . esc_attr($name) . '" value="' . esc_attr($edit_value) . '" />';
    }
    if ($fmt) {
        echo '<input type="hidden" name="' . esc_attr(substr($name, 0, -1) . '__fmt]') . '" value="' . esc_attr(base64_encode(wp_json_encode($fmt))) . '" />';
    }
    if ($hints) {
        echo '<p class="cb-ce__hint">' . wp_kses_post(implode(' ', $hints)) . '</p>';
    }
    echo '</div>';
}

function cb_ce_render_image(string $name, string $value, string $label): void
{
    ?>
    <div class="cb-ce__field cb-ce__image<?php echo $value ? ' has-image' : ''; ?>">
        <label><?php echo esc_html($label); ?></label>
        <div class="cb-ce__image-row">
            <div class="cb-ce__image-preview"><?php if ($value) : ?><img src="<?php echo esc_url($value); ?>" alt="" /><?php else : ?><span>No image</span><?php endif; ?></div>
            <div class="cb-ce__image-actions">
                <input type="hidden" class="cb-ce__image-input" name="<?php echo esc_attr($name); ?>" value="<?php echo esc_attr($value); ?>" />
                <button type="button" class="button button-primary cb-ce__image-choose"><?php echo $value ? 'Change image' : 'Choose image'; ?></button>
                <button type="button" class="button-link cb-ce__image-remove">Remove</button>
            </div>
        </div>
    </div>
    <?php
}

function cb_ce_item_title($item, int $i): string
{
    if (is_array($item)) {
        foreach (array('title', 'heading', 'question', 'name', 'label', 'text', 'number', 'tag') as $k) {
            if (!empty($item[$k]) && is_string($item[$k])) {
                return wp_trim_words(wp_strip_all_tags($item[$k]), 8);
            }
        }
    }
    return 'Item ' . ($i + 1);
}

function cb_ce_render_repeater(string $name, string $key, array $items, $template, string $label, array $ctx, string $scalar = ''): void
{
    $singular = preg_replace('/(ies)$/', 'y', rtrim(strtolower($label)));
    $singular = preg_replace('/s$/', '', $singular);
    $render_item = static function ($item, $index) use ($name, $ctx, $scalar) {
        $base = $name . '[' . $index . ']';
        ob_start();
        ?>
        <div class="cb-ce__item">
            <div class="cb-ce__item-head">
                <button type="button" class="cb-ce__item-toggle" aria-expanded="false"><span class="cb-ce__item-title"><?php echo esc_html(cb_ce_item_title($item, is_int($index) ? $index : 0)); ?></span></button>
                <span class="cb-ce__item-tools">
                    <button type="button" class="button-link cb-ce__move" data-dir="up" title="Move up">↑</button>
                    <button type="button" class="button-link cb-ce__move" data-dir="down" title="Move down">↓</button>
                    <button type="button" class="button-link cb-ce__remove">Remove</button>
                </span>
            </div>
            <div class="cb-ce__item-body">
                <?php
                if ($scalar === 'image') {
                    cb_ce_render_image($base, (string) $item, 'Image');
                } elseif (is_array($item)) {
                    foreach ($item as $k => $v) {
                        cb_ce_render_field($base . '[' . $k . ']', (string) $k, $v, $ctx);
                    }
                } else {
                    cb_ce_render_field($base, 'text', (string) $item, $ctx);
                }
                ?>
            </div>
        </div>
        <?php
        return ob_get_clean();
    };
    ?>
    <div class="cb-ce__repeater" data-base="<?php echo esc_attr($name); ?>">
        <div class="cb-ce__repeater-label"><?php echo esc_html($label); ?> <small>(<?php echo count($items); ?>)</small></div>
        <input type="hidden" name="<?php echo esc_attr($name . '[__list]'); ?>" value="1" />
        <div class="cb-ce__items">
            <?php foreach (array_values($items) as $i => $item) {
                echo $render_item($item, $i); // phpcs:ignore WordPress.Security.EscapeOutput
            } ?>
        </div>
        <template class="cb-ce__tpl"><?php echo $render_item($template, '__i__'); // phpcs:ignore ?></template>
        <button type="button" class="button cb-ce__add">+ Add <?php echo esc_html($singular ?: 'item'); ?></button>
    </div>
    <?php
}

function cb_ce_icon_palette(): void
{
    $icons = array(
        'fas fa-hard-hat', 'fas fa-hammer', 'fas fa-tools', 'fas fa-toolbox', 'fas fa-screwdriver-wrench', 'fas fa-paint-roller',
        'fas fa-ruler-combined', 'fas fa-drafting-compass', 'fas fa-building', 'fas fa-city', 'fas fa-warehouse', 'fas fa-store',
        'fas fa-industry', 'fas fa-house', 'fas fa-key', 'fas fa-door-open', 'fas fa-faucet', 'fas fa-bolt',
        'fas fa-plug', 'fas fa-fire-extinguisher', 'fas fa-shield-alt', 'fas fa-certificate', 'fas fa-award', 'fas fa-medal',
        'fas fa-check-circle', 'fas fa-clipboard-check', 'fas fa-clipboard-list', 'fas fa-tasks', 'fas fa-calendar-check', 'fas fa-calendar-alt',
        'fas fa-clock', 'fas fa-stopwatch', 'fas fa-tachometer-alt', 'fas fa-rocket', 'fas fa-route', 'fas fa-bullseye',
        'fas fa-lightbulb', 'fas fa-search', 'fas fa-chart-line', 'fas fa-percent', 'fas fa-dollar-sign', 'fas fa-hand-holding-dollar',
        'fas fa-file-invoice', 'fas fa-handshake', 'fas fa-users', 'fas fa-users-cog', 'fas fa-user-tie', 'fas fa-headset',
        'fas fa-phone-alt', 'fas fa-phone-volume', 'fas fa-envelope', 'fas fa-envelope-open-text', 'fas fa-map-marker-alt', 'fas fa-comments',
        'fas fa-leaf', 'fas fa-recycle', 'fas fa-first-aid', 'fas fa-exclamation-triangle', 'fas fa-sitemap', 'fas fa-laptop-code',
        'fas fa-cogs', 'fas fa-star', 'fas fa-heart', 'fas fa-thumbs-up',
    );
    echo '<div class="cb-ce__palette" hidden><div class="cb-ce__palette-inner"><div class="cb-ce__palette-head"><strong>Pick an icon</strong><button type="button" class="button-link cb-ce__palette-close">Close ✕</button></div><div class="cb-ce__palette-grid">';
    foreach ($icons as $icon) {
        echo '<button type="button" data-icon="' . esc_attr($icon) . '" title="' . esc_attr(str_replace(array('fas fa-', '-'), array('', ' '), $icon)) . '"><i class="' . esc_attr($icon) . '"></i></button>';
    }
    echo '</div></div></div>';
}

/* =====================================================================
 * Saving
 * ===================================================================== */

/** Turn posted editor data back into stored data (lists, formatting). */
function cb_ce_normalize($value)
{
    if (!is_array($value)) {
        return is_string($value) ? $value : '';
    }
    if (array_key_exists('__lines', $value)) {
        $lines = preg_split('/\r\n|\r|\n/', (string) $value['__lines']);
        return array_values(array_filter(array_map('trim', $lines), 'strlen'));
    }
    $is_list = isset($value['__list']);
    unset($value['__list']);

    $out = array();
    foreach ($value as $k => $v) {
        if (is_string($k) && substr($k, -5) === '__fmt') {
            continue;
        }
        $v = cb_ce_normalize($v);
        if (is_string($v) && isset($value[$k . '__fmt'])) {
            $fmt = json_decode((string) base64_decode((string) $value[$k . '__fmt']), true);
            $v   = cb_ce_from_edit($v, is_array($fmt) ? $fmt : array());
        }
        $out[$k] = $v;
    }
    if ($is_list) {
        $out = array_values(array_filter($out, static function ($row) {
            if (is_array($row)) {
                return trim(implode('', array_map(static function ($x) {
                    return is_array($x) ? wp_json_encode($x) : (string) $x;
                }, $row))) !== '';
            }
            return trim((string) $row) !== '';
        }));
    }
    return $out;
}

/** Restore original value types (bool / number) using the current value as a guide. */
function cb_ce_cast($posted, $schema)
{
    if (is_bool($schema)) {
        return !empty($posted) && $posted !== '0';
    }
    if (is_int($schema)) {
        return (int) $posted;
    }
    if (is_float($schema)) {
        return (float) $posted;
    }
    if (is_array($schema) && is_array($posted)) {
        if (cb_ce_is_list($posted) && cb_ce_is_list($schema)) {
            $item_schema = $schema[0] ?? null;
            return array_map(static function ($p) use ($item_schema) {
                return $item_schema === null ? $p : cb_ce_cast($p, $item_schema);
            }, $posted);
        }
        foreach ($posted as $k => $v) {
            if (array_key_exists($k, $schema)) {
                $posted[$k] = cb_ce_cast($v, $schema[$k]);
            }
        }
        // Keep keys that were not shown in the form (hidden technical values).
        if (!cb_ce_is_list($schema)) {
            foreach ($schema as $k => $v) {
                if (!array_key_exists($k, $posted)) {
                    $posted[$k] = $v;
                }
            }
        }
    }
    return $posted;
}

/** Generic sanitizer for the home page's individual options. */
function cb_ce_sanitize_value($value, string $key = '')
{
    if (is_array($value)) {
        $out = array();
        foreach ($value as $k => $v) {
            $out[$k] = cb_ce_sanitize_value($v, is_string($k) ? $k : $key);
        }
        return $out;
    }
    if (is_bool($value) || is_int($value) || is_float($value)) {
        return $value;
    }
    $value = (string) $value;
    if (preg_match('/(^|_)(url|image|background|logo|photo|icon)$/', $key) && (strpos($value, '/') !== false || strpos($value, ':') !== false)) {
        return esc_url_raw($value);
    }
    return wp_kses_post($value);
}

function cb_ce_handle_save(): void
{
    $page_key = isset($_POST['cb_page']) ? sanitize_key($_POST['cb_page']) : '';
    $page     = cb_ce_page($page_key);
    if (!$page || !current_user_can(CB_CE_CAP)) {
        wp_die(esc_html__('Sorry, you are not allowed to do that.', 'central-build'));
    }
    check_admin_referer('cb_ce_save_' . $page_key);

    // Safety net: keep the previous version.
    $snapshot = array();
    foreach (cb_ce_page_options($page) as $opt) {
        $snapshot[$opt] = get_option($opt, null);
    }
    $custom = $page['store']['type'] === 'custom' ? call_user_func($page['store']['snapshot']) : null;
    update_option('cb_ce_backup_' . $page_key, array('time' => time(), 'user' => get_current_user_id(), 'options' => $snapshot, 'custom' => $custom), false);

    $posted  = isset($_POST['cb']) && is_array($_POST['cb']) ? wp_unslash($_POST['cb']) : array();
    $vis     = isset($_POST['cb_vis']) && is_array($_POST['cb_vis']) ? wp_unslash($_POST['cb_vis']) : array();
    $current = cb_ce_get_values($page_key);

    $new = array();
    foreach ($page['sections'] as $skey => $section) {
        if (!array_key_exists($skey, $posted)) {
            continue;
        }
        $new[$skey] = cb_ce_cast(cb_ce_normalize($posted[$skey]), $current[$skey]);
    }

    if ($page['store']['type'] === 'custom') {
        call_user_func($page['store']['save'], $new);
    } elseif ($page['store']['type'] === 'group') {
        $data = call_user_func($page['store']['get']);
        foreach ($new as $skey => $value) {
            $data[$skey] = $value;
        }
        $clean = call_user_func($page['store']['sanitize'], wp_slash($data));
        update_option($page['store']['option'], $clean);
    } else {
        $home = function_exists('central_build_get_home_content') ? central_build_get_home_content() : array();
        $home_changed = false;
        foreach ($page['sections'] as $skey => $section) {
            if (!empty($section['visible']) && isset($vis[$skey])) {
                update_option($section['visible'], $vis[$skey] === '1' ? '1' : '0');
            }
            if (!isset($new[$skey])) {
                continue;
            }
            if (!empty($section['home'])) {
                $home[$section['home']] = $new[$skey];
                $home_changed = true;
                continue;
            }
            foreach ($section['fields'] ?? array() as $fkey => $spec) {
                if (array_key_exists($fkey, $new[$skey])) {
                    $value = $new[$skey][$fkey];
                    if (!empty($spec['getter']) && !is_array($value)) {
                        $value = array();
                    }
                    update_option($spec['option'], cb_ce_sanitize_value($value, (string) $fkey));
                }
            }
        }
        if ($home_changed) {
            update_option('central_build_home_content', central_build_sanitize_home_content(wp_slash($home)));
        }
    }

    do_action('litespeed_purge_all');

    $open = isset($_POST['cb_open']) ? sanitize_key($_POST['cb_open']) : '';
    wp_safe_redirect(admin_url('admin.php?page=' . CB_CE_SLUG . '&edit=' . $page_key . '&cb_saved=saved' . ($open ? '&open=' . $open . '#section-' . $open : '')));
    exit;
}
add_action('admin_post_cb_ce_save', 'cb_ce_handle_save');

function cb_ce_handle_restore(): void
{
    $page_key = isset($_POST['cb_page']) ? sanitize_key($_POST['cb_page']) : '';
    $page     = cb_ce_page($page_key);
    if (!$page || !current_user_can(CB_CE_CAP)) {
        wp_die(esc_html__('Sorry, you are not allowed to do that.', 'central-build'));
    }
    check_admin_referer('cb_ce_restore_' . $page_key);

    $backup = get_option('cb_ce_backup_' . $page_key);
    if (!is_array($backup) || (empty($backup['options']) && !isset($backup['custom']))) {
        wp_safe_redirect(admin_url('admin.php?page=' . CB_CE_SLUG . '&edit=' . $page_key . '&cb_saved=error'));
        exit;
    }
    if ($page['store']['type'] === 'custom' && is_array($backup['custom'] ?? null)) {
        call_user_func($page['store']['restore'], $backup['custom']);
    }
    foreach ((array) $backup['options'] as $opt => $value) {
        if ($value === null) {
            delete_option($opt);
        } else {
            update_option($opt, $value);
        }
    }
    delete_option('cb_ce_backup_' . $page_key);
    do_action('litespeed_purge_all');

    wp_safe_redirect(admin_url('admin.php?page=' . CB_CE_SLUG . '&edit=' . $page_key . '&cb_saved=restored'));
    exit;
}
add_action('admin_post_cb_ce_restore', 'cb_ce_handle_restore');

/* =====================================================================
 * Shortcuts: dashboard box, admin bar, "Edit this page" on the website
 * ===================================================================== */

/** Which editor page belongs to the page being viewed on the website. */
function cb_ce_current_page_key(): string
{
    if (is_front_page()) {
        return 'home';
    }
    if (is_page()) {
        $template = get_page_template_slug(get_queried_object_id());
        foreach (cb_ce_pages() as $key => $page) {
            if (!empty($page['template']) && $page['template'] === $template) {
                return $key;
            }
        }
    }
    return '';
}

function cb_ce_admin_bar($bar): void
{
    if (is_admin() || !current_user_can(CB_CE_CAP)) {
        return;
    }
    $key = cb_ce_current_page_key();
    $bar->add_node(array(
        'id'    => 'cb-edit-content',
        'title' => '<span class="ab-icon dashicons dashicons-edit-page" style="top:2px"></span>' . ($key ? 'Edit this page\'s content' : 'Website Content'),
        'href'  => admin_url('admin.php?page=' . CB_CE_SLUG . ($key ? '&edit=' . $key : '')),
    ));
}
add_action('admin_bar_menu', 'cb_ce_admin_bar', 40);

function cb_ce_frontend_button(): void
{
    if (!current_user_can(CB_CE_CAP)) {
        return;
    }
    $key = cb_ce_current_page_key();
    if (!$key) {
        return;
    }
    $url = admin_url('admin.php?page=' . CB_CE_SLUG . '&edit=' . $key);
    ?>
    <a href="<?php echo esc_url($url); ?>" class="cb-ce-edit-fab" style="position:fixed;right:20px;bottom:20px;z-index:99999;background:#1d2327;color:#fff;padding:12px 18px;border-radius:999px;font:600 15px/1.2 -apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;text-decoration:none;box-shadow:0 6px 20px rgba(0,0,0,.25)">✏️ Edit this page</a>
    <?php
}
add_action('wp_footer', 'cb_ce_frontend_button', 100);

function cb_ce_dashboard_widget(): void
{
    if (!current_user_can(CB_CE_CAP)) {
        return;
    }
    wp_add_dashboard_widget('cb_ce_dashboard', 'Update your website', static function () {
        echo '<p>Change the words, pictures and buttons on any page:</p><ul style="columns:2;margin:0 0 12px">';
        foreach (cb_ce_pages() as $key => $page) {
            printf('<li><a href="%s">%s</a></li>', esc_url(admin_url('admin.php?page=' . CB_CE_SLUG . '&edit=' . $key)), esc_html(cb_ce_short_title($page['title'])));
        }
        echo '</ul><p><a class="button button-primary" href="' . esc_url(admin_url('admin.php?page=' . CB_CE_SLUG)) . '">Open Website Content</a></p>';
    });

    // Put our box first.
    global $wp_meta_boxes;
    $normal = $wp_meta_boxes['dashboard']['normal']['core'] ?? array();
    if (isset($normal['cb_ce_dashboard'])) {
        $ours = array('cb_ce_dashboard' => $normal['cb_ce_dashboard']);
        $wp_meta_boxes['dashboard']['normal']['core'] = array_merge($ours, $normal);
    }
}
add_action('wp_dashboard_setup', 'cb_ce_dashboard_widget');
