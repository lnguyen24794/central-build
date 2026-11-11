<?php
/**
 * Central Build UI components (Nov 2026 redesign). Every page is built from these, so the
 * whole site shares one hero, one section head, one card, one button pair, one form.
 * Styles: css/cb-system.css.
 *
 * @package Central_Build_Pro
 */

if (!defined('ABSPATH')) {
    exit;
}

/** Allowed inline markup in headings (line breaks and spans; colours are reset by the CSS). */
function cb_ui_inline(string $html): string
{
    $html = preg_replace('~\s*style="[^"]*"~i', '', $html);
    return wp_kses($html, array('br' => array(), 'span' => array(), 'strong' => array(), 'em' => array()));
}

/** Plain text from settings that may contain entities or tags. */
function cb_ui_plain($text): string
{
    return trim(wp_strip_all_tags(html_entity_decode((string) $text, ENT_QUOTES, 'UTF-8')));
}

/** Font Awesome / Bootstrap icon class, or a sensible default. */
function cb_ui_icon($class, string $fallback = 'fas fa-check'): string
{
    $class = trim((string) $class);
    return '<i class="' . esc_attr($class !== '' ? $class : $fallback) . '" aria-hidden="true"></i>';
}

/** A theme image (images/...) or an absolute URL. */
function cb_ui_img_url(string $src): string
{
    if ($src === '') {
        return '';
    }
    return preg_match('~^(https?:)?//|^/~', $src) ? $src : get_template_directory_uri() . '/images/' . ltrim($src, '/');
}

/* ------------------------------------------------------------------ layout */

function cb_ui_section_open(string $id = '', string $ground = 'white', string $class = ''): void
{
    printf('<section%s class="cb-section is-%s%s"><div class="cb-wrap">',
        $id !== '' ? ' id="' . esc_attr($id) . '"' : '', esc_attr($ground), $class !== '' ? ' ' . esc_attr($class) : '');
}

function cb_ui_section_close(): void
{
    echo '</div></section>';
}

/**
 * Section head: eyebrow + h2 on the left, lead text on the right (or under it).
 * $layout: 'split' (default), 'single', 'center'.
 */
function cb_ui_head(string $eyebrow, string $title, string $lead = '', string $layout = 'split'): void
{
    if ($title === '' && $eyebrow === '') {
        return;
    }
    $lead = trim($lead);
    $class = $layout === 'split' && $lead !== '' ? '' : ($layout === 'center' ? ' is-center' : ' is-single');
    echo '<div class="cb-head' . $class . '"><div>';
    if ($eyebrow !== '') {
        echo '<span class="cb-eyebrow">' . esc_html(cb_ui_plain($eyebrow)) . '</span>';
    }
    echo '<h2>' . cb_ui_inline($title) . '</h2></div>';
    if ($lead !== '') {
        echo '<p class="cb-lead">' . wp_kses_post($lead) . '</p>';
    }
    echo '</div>';
}

/** Buttons: [ ['label'=>, 'url'=>, 'style'=>'primary'|'outline'], ... ] */
function cb_ui_buttons(array $buttons): void
{
    $buttons = array_values(array_filter($buttons, static function ($b) {
        return is_array($b) && cb_ui_plain($b['label'] ?? '') !== '' && trim((string) ($b['url'] ?? '')) !== '';
    }));
    if (!$buttons) {
        return;
    }
    echo '<div class="cb-btns">';
    foreach ($buttons as $i => $b) {
        $style = ($b['style'] ?? ($i === 0 ? 'primary' : 'outline')) === 'outline' ? ' is-outline' : '';
        printf('<a class="cb-btn%s" href="%s">%s</a>', $style, esc_url((string) $b['url']), esc_html(cb_ui_plain($b['label'])));
    }
    echo '</div>';
}

/* ------------------------------------------------------------------ hero */

/**
 * @param array $a eyebrow, title (may contain <br>/<span>), text, fact, image, buttons, size ('home'|'page')
 */
function cb_ui_hero(array $a): void
{
    $image = cb_ui_img_url((string) ($a['image'] ?? ''));
    $style = $image ? ' style="background-image:url(\'' . esc_url($image) . '\')"' : '';
    $size  = ($a['size'] ?? 'page') === 'home' ? '' : ' is-page';
    echo '<section class="cb-hero' . $size . '"' . $style . '><div class="cb-wrap"><div class="cb-hero__inner">';
    if (!empty($a['eyebrow'])) {
        echo '<span class="cb-eyebrow">' . esc_html(cb_ui_plain($a['eyebrow'])) . '</span>';
    }
    echo '<h1>' . cb_ui_inline((string) ($a['title'] ?? '')) . '</h1>';
    if (!empty($a['text'])) {
        echo '<p class="cb-hero__text">' . esc_html(cb_ui_plain($a['text'])) . '</p>';
    }
    if (!empty($a['fact'])) {
        echo '<span class="cb-hero__fact">' . esc_html(cb_ui_plain($a['fact'])) . '</span>';
    }
    cb_ui_buttons((array) ($a['buttons'] ?? array()));
    echo '</div></div></section>';
}

/* ------------------------------------------------------------------ cards */

/**
 * @param array $items each: icon, label, title, text, url, link_label
 */
function cb_ui_cards(array $items, int $cols = 3): void
{
    $items = array_values(array_filter($items, static function ($i) {
        return is_array($i) && cb_ui_plain($i['title'] ?? '') !== '';
    }));
    if (!$items) {
        return;
    }
    $cols = max(2, min(4, $cols));
    echo '<div class="cb-grid' . ($cols !== 3 ? ' is-' . $cols : '') . '">';
    foreach ($items as $i) {
        $url = trim((string) ($i['url'] ?? ''));
        $tag = $url !== '' ? 'a' : 'div';
        echo '<' . $tag . ' class="cb-card"' . ($url !== '' ? ' href="' . esc_url($url) . '"' : '') . '>';
        if (!empty($i['icon'])) {
            echo '<span class="cb-card__icon">' . cb_ui_icon($i['icon']) . '</span>';
        }
        if (!empty($i['label'])) {
            echo '<span class="cb-card__label">' . esc_html(cb_ui_plain($i['label'])) . '</span>';
        }
        echo '<h3>' . esc_html(cb_ui_plain($i['title'])) . '</h3>';
        if (!empty($i['text'])) {
            echo '<p>' . esc_html(cb_ui_plain($i['text'])) . '</p>';
        }
        if ($url !== '') {
            echo '<span class="cb-link">' . esc_html($i['link_label'] ?? __('Learn more', 'central-build')) . '</span>';
        }
        echo '</' . $tag . '>';
    }
    echo '</div>';
}

/* ------------------------------------------------------------------ split */

/**
 * Photo + text. @param array $a image, image_alt, eyebrow, title, text (string|array of paragraphs), list (array of
 * strings or [title,text]), buttons, reverse (bool), heading_tag
 */
function cb_ui_split(array $a): void
{
    $image = cb_ui_img_url((string) ($a['image'] ?? ''));
    echo '<div class="cb-split' . (!empty($a['reverse']) ? ' is-reverse' : '') . '">';
    if ($image) {
        echo '<div class="cb-split__media"><img src="' . esc_url($image) . '" alt="' . esc_attr(cb_ui_plain($a['image_alt'] ?? ($a['title'] ?? ''))) . '" loading="lazy" decoding="async"></div>';
    }
    echo '<div class="cb-split__body">';
    if (!empty($a['eyebrow']) || !empty($a['title'])) {
        echo '<div>';
        if (!empty($a['eyebrow'])) {
            echo '<span class="cb-eyebrow">' . esc_html(cb_ui_plain($a['eyebrow'])) . '</span>';
        }
        $tag = $a['heading_tag'] ?? 'h2';
        if (!empty($a['title'])) {
            echo '<' . $tag . '>' . cb_ui_inline((string) $a['title']) . '</' . $tag . '>';
        }
        echo '</div>';
    }
    $paras = is_array($a['text'] ?? null) ? $a['text'] : array_filter(preg_split('/\n\s*\n/', (string) ($a['text'] ?? '')));
    $paras = array_values(array_filter(array_map('cb_ui_plain', $paras)));
    if ($paras) {
        echo '<div class="cb-text"><p>' . implode('</p><p>', array_map('esc_html', $paras)) . '</p></div>';
    }
    cb_ui_list((array) ($a['list'] ?? array()));
    cb_ui_buttons((array) ($a['buttons'] ?? array()));
    echo '</div></div>';
}

/** Tick list: strings, or [title, text] pairs. */
function cb_ui_list(array $items): void
{
    $out = array();
    foreach ($items as $item) {
        if (is_array($item)) {
            $t = cb_ui_plain($item['title'] ?? ($item[0] ?? ''));
            $d = cb_ui_plain($item['text'] ?? ($item['description'] ?? ($item[1] ?? '')));
            if ($t !== '' || $d !== '') {
                $out[] = ($t !== '' ? '<strong>' . esc_html($t) . '</strong>' : '') . esc_html($d);
            }
        } elseif (cb_ui_plain($item) !== '') {
            $out[] = esc_html(cb_ui_plain($item));
        }
    }
    if ($out) {
        echo '<ul class="cb-list"><li><span>' . implode('</span></li><li><span>', $out) . '</span></li></ul>';
    }
}

/* ------------------------------------------------------------------ steps & facts */

/** @param array $steps each: title, text (numbers are added by CSS; leading "1." in titles is removed) */
function cb_ui_steps(array $steps): void
{
    $steps = array_values(array_filter($steps, static function ($s) {
        return is_array($s) && cb_ui_plain($s['title'] ?? '') !== '';
    }));
    if (!$steps) {
        return;
    }
    echo '<ol class="cb-steps" style="--n:' . count($steps) . '">';
    foreach ($steps as $s) {
        $title = preg_replace('/^\s*(step\s*)?\d+\s*[.:)\-]\s*/i', '', cb_ui_plain($s['title']));
        echo '<li><h3>' . esc_html($title) . '</h3>';
        if (!empty($s['text'])) {
            echo '<p>' . esc_html(cb_ui_plain($s['text'])) . '</p>';
        }
        echo '</li>';
    }
    echo '</ol>';
}

/** @param array $facts value => label pairs, or [ [value, label] ] */
function cb_ui_facts(array $facts): void
{
    $rows = array();
    foreach ($facts as $k => $v) {
        if (is_array($v)) {
            list($value, $label) = array_pad(array_values($v), 2, '');
        } else {
            list($value, $label) = array($v, $k);
        }
        if (cb_ui_plain($value) !== '') {
            $rows[] = '<div class="cb-fact' . (mb_strlen(cb_ui_plain($value)) > 16 ? ' is-long' : '') . '"><b>' . esc_html(cb_ui_plain($value)) . '</b><span>' . esc_html(cb_ui_plain($label)) . '</span></div>';
        }
    }
    if ($rows) {
        echo '<div class="cb-facts">' . implode('', $rows) . '</div>';
    }
}

/* ------------------------------------------------------------------ projects */

/** Project status from its category: upcoming or completed. */
function cb_ui_project_status(int $post_id): string
{
    return has_term('upcoming-projects', 'fitout_category', $post_id) ? 'Upcoming' : 'Completed';
}

function cb_ui_project_image(int $post_id, string $size = 'large'): string
{
    $url = (string) get_the_post_thumbnail_url($post_id, $size);
    if ($url === '') {
        $url = (string) get_post_meta($post_id, '_fitout_hero_image', true);
    }
    return $url;
}

function cb_ui_project_tile(int $post_id, bool $show_status = false): void
{
    $img      = cb_ui_project_image($post_id);
    $location = cb_ui_plain(get_post_meta($post_id, '_fitout_location', true));
    $location = preg_replace('/^\d+[-\d]*\s+|\s+\d{4}$/', '', $location); // street and suburb, no house number or postcode
    $excerpt  = cb_ui_plain(get_the_excerpt($post_id));
    echo '<a class="cb-tile" href="' . esc_url(get_permalink($post_id)) . '">';
    echo '<span class="cb-tile__img">';
    if ($img) {
        echo '<img src="' . esc_url($img) . '" alt="' . esc_attr(get_the_title($post_id)) . '" loading="lazy" decoding="async">';
    }
    if ($show_status) {
        echo '<span class="cb-tile__status">' . esc_html(cb_ui_project_status($post_id)) . '</span>';
    }
    echo '</span><span>';
    if ($location !== '') {
        echo '<span class="cb-tile__meta">' . esc_html($location) . '</span>';
    }
    echo '<h3>' . esc_html(get_the_title($post_id)) . '</h3>';
    if ($excerpt !== '') {
        echo '<p>' . esc_html(wp_trim_words($excerpt, 22)) . '</p>';
    }
    echo '</span></a>';
}

/**
 * @param array $a count, category (slug), exclude (ids), orderby, show_status, columns
 */
function cb_ui_projects(array $a = array()): int
{
    $args = array(
        'post_type'      => 'fitout_sector',
        'post_status'    => 'publish',
        'posts_per_page' => (int) ($a['count'] ?? 6),
        'post__not_in'   => array_map('intval', (array) ($a['exclude'] ?? array())),
        'orderby'        => $a['orderby'] ?? 'date',
        'order'          => 'DESC',
        'fields'         => 'ids',
        'no_found_rows'  => true,
    );
    if (!empty($a['category'])) {
        $args['tax_query'] = array(array('taxonomy' => 'fitout_category', 'field' => 'slug', 'terms' => (array) $a['category']));
    }
    $ids = get_posts($args);
    if (!$ids) {
        if (!empty($a['empty'])) {
            echo '<p class="cb-empty">' . esc_html($a['empty']) . '</p>';
        }
        return 0;
    }
    $cols = (int) ($a['columns'] ?? 3);
    echo '<div class="cb-grid' . ($cols !== 3 ? ' is-' . $cols : '') . '">';
    foreach ($ids as $id) {
        cb_ui_project_tile((int) $id, !empty($a['show_status']));
    }
    echo '</div>';
    return count($ids);
}

/** Projects section used at the bottom of service pages. */
function cb_ui_projects_section(string $title = 'Recent projects', string $lead = '', string $ground = 'mist'): void
{
    cb_ui_section_open('projects', $ground);
    echo '<div class="cb-head"><div><span class="cb-eyebrow">' . esc_html__('Our work', 'central-build') . '</span><h2>' . esc_html($title) . '</h2></div>';
    echo '<div class="cb-btns" style="justify-self:end"><a class="cb-btn is-outline" href="' . esc_url(home_url('/projects/')) . '">' . esc_html__('View all projects', 'central-build') . '</a></div></div>';
    cb_ui_projects(array('count' => 3, 'category' => 'fitout-projects'));
    cb_ui_section_close();
}

/* ------------------------------------------------------------------ FAQ */

function cb_ui_faq(array $items): void
{
    $items = array_values(array_filter($items, static function ($i) {
        return is_array($i) && cb_ui_plain($i['question'] ?? '') !== '';
    }));
    if (!$items) {
        return;
    }
    echo '<div class="cb-faq">';
    foreach ($items as $n => $i) {
        echo '<details' . ($n === 0 ? ' open' : '') . '><summary>' . esc_html(cb_ui_plain($i['question'])) . '</summary><div class="cb-text"><p>' . esc_html(cb_ui_plain($i['answer'] ?? '')) . '</p></div></details>';
    }
    echo '</div>';
}

/* ------------------------------------------------------------------ contact */

/** Company phone / mobile / email from the header & footer settings. */
function cb_ui_company_contacts(): array
{
    $h = function_exists('central_build_get_header_settings') ? central_build_get_header_settings() : array();
    $f = function_exists('central_build_get_footer_settings') ? central_build_get_footer_settings() : array();
    return array(
        'phone'        => (string) ($h['phone']['display'] ?? '1300 31 8888'),
        'phone_link'   => (string) ($h['phone']['link'] ?? 'tel:1300318888'),
        'mobile'       => trim(str_ireplace('Mobile:', '', (string) ($f['company']['mobile']['display'] ?? '+61 413 058 861'))),
        'mobile_link'  => (string) ($f['company']['mobile']['link'] ?? 'tel:+61413058861'),
        'email'        => (string) ($h['email'] ?? 'admin@centralbuild.au'),
    );
}

/**
 * Contact section with the form (fields come from the form definition, so submissions keep working).
 *
 * @param array $a form_id, eyebrow, title, text, form_title, button, options (select options for project_type/service_type), ground
 */
function cb_ui_contact(array $a): void
{
    $form_id = (string) ($a['form_id'] ?? 'contact_page');
    $defs    = function_exists('central_build_get_form_definitions') ? central_build_get_form_definitions() : array();
    $fields  = $defs[$form_id]['fields'] ?? array();
    $c       = cb_ui_company_contacts();
    $notice  = function_exists('central_build_form_feedback_notice') ? central_build_form_feedback_notice($form_id) : '';
    $options = array_values(array_filter(array_map('cb_ui_plain', (array) ($a['options'] ?? array()))));
    if (!$options) {
        $options = array('Commercial Design', 'Commercial Fitout', 'Services Coordination', 'Commercial Stripout', 'Repairs & Maintenance');
    }

    cb_ui_section_open($a['id'] ?? 'contact', $a['ground'] ?? 'mist');
    echo '<div class="cb-contact"><div class="cb-contact__aside">';
    echo '<div><span class="cb-eyebrow">' . esc_html(cb_ui_plain($a['eyebrow'] ?? __('Get in touch', 'central-build'))) . '</span>';
    echo '<h2>' . cb_ui_inline((string) ($a['title'] ?? __('Tell us about your project', 'central-build'))) . '</h2></div>';
    if (!empty($a['text'])) {
        echo '<p class="cb-lead">' . esc_html(cb_ui_plain($a['text'])) . '</p>';
    }
    echo '<div class="cb-contact__lines">';
    echo '<a href="' . esc_url($c['phone_link']) . '">' . cb_ui_icon('fas fa-phone') . esc_html($c['phone']) . '</a>';
    if ($c['mobile'] !== '') {
        echo '<a href="' . esc_url($c['mobile_link']) . '">' . cb_ui_icon('fas fa-mobile-alt') . esc_html($c['mobile']) . '</a>';
    }
    echo '<a href="mailto:' . esc_attr($c['email']) . '">' . cb_ui_icon('fas fa-envelope') . esc_html($c['email']) . '</a>';
    echo '</div>';
    if (!empty($a['aside_extra'])) {
        echo $a['aside_extra']; // phpcs:ignore -- pre-escaped markup from the template
    }
    echo '</div>';

    echo '<form class="cb-form" method="post" action="' . esc_url(admin_url('admin-post.php')) . '">';
    if ($notice) {
        echo $notice; // phpcs:ignore -- built by the form handler
    }
    echo '<h3>' . esc_html(cb_ui_plain($a['form_title'] ?? __('Send us a message', 'central-build'))) . '</h3>';
    echo '<input type="hidden" name="action" value="central_build_form_submit"><input type="hidden" name="form_id" value="' . esc_attr($form_id) . '">';
    wp_nonce_field('central_build_form_submit', 'central_build_form_nonce');

    $short = array();
    $long  = array();
    foreach ($fields as $name => $def) {
        $id    = 'cb-' . $form_id . '-' . $name;
        $req   = !empty($def['required']);
        $label = esc_html($def['label'] ?? $name) . ($req ? ' <em>*</em>' : '');
        $attr  = ' id="' . esc_attr($id) . '" name="' . esc_attr($name) . '"' . ($req ? ' required' : '');
        if (in_array($name, array('message', 'details'), true)) {
            $long[] = '<div class="cb-field"><label for="' . esc_attr($id) . '">' . $label . '</label><textarea' . $attr . ' rows="4"></textarea></div>';
            continue;
        }
        if (in_array($name, array('project_type', 'service_type'), true)) {
            $opts = '<option value="">' . esc_html__('Choose one', 'central-build') . '</option>';
            foreach ($options as $o) {
                $opts .= '<option>' . esc_html($o) . '</option>';
            }
            $short[] = '<div class="cb-field"><label for="' . esc_attr($id) . '">' . $label . '</label><select' . $attr . '>' . $opts . '</select></div>';
            continue;
        }
        $type = $name === 'email' ? 'email' : ($name === 'phone' ? 'tel' : 'text');
        $auto = array('full_name' => 'name', 'email' => 'email', 'phone' => 'tel', 'company' => 'organization')[$name] ?? 'off';
        $short[] = '<div class="cb-field"><label for="' . esc_attr($id) . '">' . $label . '</label><input type="' . $type . '"' . $attr . ' autocomplete="' . $auto . '"></div>';
    }
    foreach (array_chunk($short, 2) as $pair) {
        echo count($pair) === 2 ? '<div class="cb-form__row">' . implode('', $pair) . '</div>' : $pair[0];
    }
    echo implode('', $long);
    echo '<button type="submit" class="cb-btn">' . esc_html(cb_ui_plain($a['button'] ?? __('Send enquiry', 'central-build'))) . '</button>';
    echo '<p class="cb-form__note">' . esc_html__('We reply within one business day.', 'central-build') . '</p>';
    echo '</form></div>';
    cb_ui_section_close();
}

/** CTA band (no form): title, text, buttons. */
function cb_ui_cta(array $a): void
{
    cb_ui_section_open($a['id'] ?? 'get-started', $a['ground'] ?? 'navy');
    echo '<div class="cb-cta"><div>';
    if (!empty($a['eyebrow'])) {
        echo '<span class="cb-eyebrow">' . esc_html(cb_ui_plain($a['eyebrow'])) . '</span>';
    }
    echo '<h2>' . cb_ui_inline((string) ($a['title'] ?? '')) . '</h2>';
    if (!empty($a['text'])) {
        echo '<p class="cb-lead">' . esc_html(cb_ui_plain($a['text'])) . '</p>';
    }
    echo '</div>';
    cb_ui_buttons((array) ($a['buttons'] ?? array()));
    echo '</div>';
    cb_ui_section_close();
}

/* ------------------------------------------------------------------ shared content */

/** "Why Central Build" – from the Capability Statement 2026. */
function cb_ui_why_points(): array
{
    return array(
        array('icon' => 'fas fa-shield-alt', 'title' => '100% services secured', 'text' => 'A registered and licensed commercial builder (CCB-L 100410), delivering every project to high standards of quality, safety and efficiency.'),
        array('icon' => 'fas fa-tools', 'title' => 'In-house services', 'text' => 'Our own plumbing and electrical teams, partnered architects and an overseas BIM team keep every trade coordinated from concept to completion.'),
        array('icon' => 'fas fa-user-tie', 'title' => 'Experienced management', 'text' => 'Skills from a wide range of projects and trades, so work runs smoothly, on time and within budget.'),
        array('icon' => 'fas fa-handshake', 'title' => 'Client-focused approach', 'text' => 'We work closely with you from start to finish, with transparent, upfront pricing and no hidden costs.'),
        array('icon' => 'fas fa-random', 'title' => 'Flexible management', 'text' => 'An adaptable system that meets your requirements, hits project targets and solves problems on site fast.'),
        array('icon' => 'fas fa-store', 'title' => 'Sectors we build for', 'text' => 'Retail, hospitality, offices, warehouses and factories, and public facilities, including hygiene-focused spaces.'),
    );
}

/** The five services as linked cards (titles and links from Website Content > About Us > Services). */
function cb_ui_service_cards(): array
{
    $about = function_exists('central_build_get_about_settings') ? central_build_get_about_settings() : array();
    $info  = array(
        'design'       => array('fas fa-drafting-compass', 'Design, 3D and VR walkthroughs, and BIM coordination before work starts.'),
        'fitouts'      => array('fas fa-store', 'Turnkey fitouts for shops, restaurants and offices, from permits to handover.'),
        'coordination' => array('fas fa-project-diagram', 'Gas, fire, electrical, mechanical and hydraulic services under one plan.'),
        'stripout'     => array('fas fa-hammer', 'Safe internal demolition and make-good, ready for the next trade.'),
        'repairs'      => array('fas fa-wrench', 'Urgent repairs, 24/7, and planned maintenance contracts.'),
    );
    $cards = array();
    foreach ((array) ($about['services'] ?? array()) as $sv) {
        $url  = (string) ($sv['url'] ?? '');
        $icon = 'fas fa-check';
        $text = '';
        foreach ($info as $key => $row) {
            if (stripos($url, $key) !== false) {
                list($icon, $text) = $row;
            }
        }
        $cards[] = array('icon' => $icon, 'title' => $sv['title'] ?? '', 'text' => $text, 'url' => $url, 'link_label' => __('View service', 'central-build'));
    }
    if (count($cards) % 3 === 2) {
        $cards[] = array('icon' => 'fas fa-comments', 'title' => __('Not sure where to start?', 'central-build'), 'text' => __('Tell us about your space and we will point you to the right team and a realistic budget.', 'central-build'), 'url' => home_url('/contact/'), 'link_label' => __('Talk to us', 'central-build'));
    }
    return $cards;
}

/** Body class for pages built with the system (lets legacy CSS step aside). */
add_filter('body_class', static function (array $classes): array {
    if (is_front_page() || is_singular('fitout_sector') || is_post_type_archive('fitout_sector') || is_tax('fitout_category')
        || is_page(array('about-us', 'contact', 'commercial-design-and-solutions', 'commercial-fitouts', 'services-coordination', 'commercial-stripout', 'repairs-and-maintenance'))) {
        $classes[] = 'cb-system';
    }
    return $classes;
});
