<?php
if (!defined('ABSPATH')) {
    exit;
}

function central_build_footer_settings_defaults(): array
{
    return array(
        'company' => array(
            'logo_url'   => get_template_directory_uri() . '/images/674e51fad943a77607127b0b_ENP%20transparent%20white%20cropped.webp',
            'description' => 'Central Build crafts lasting commercial fitout solutions with value, efficiency, and transparency.',
            'licence'     => 'Builder Licence No. CCB-L 100410',
            'email'      => 'thangt@centralbuild.au',
            'phone'      => array(
                'display' => '1300 31 8888',
                'link'    => 'tel:1300318888',
            ),
            'mobile'     => array(
                'display' => 'Mobile: +61 413 058 861',
                'link'    => 'tel:+61413058861',
            ),
        ),
        'quick_links' => array(
            array('label' => 'Home', 'url' => home_url('/')),
            array('label' => 'About Us', 'url' => home_url('/about-us/')),
            array('label' => 'Projects', 'url' => home_url('/projects/')),
            array('label' => 'Contact', 'url' => home_url('/contact/')),
        ),
        'support_links' => array(
            array('label' => 'Repairs & Maintenance', 'url' => home_url('/repairs-and-maintenance/')),
            array('label' => 'Get a Quote', 'url' => home_url('/contact/')),
        ),        // Bottom line of the footer. {year} becomes the current year.
        'copyright' => '© {year} Central Build. All rights reserved.',
        'social_links' => array(
            array('label' => 'Facebook', 'url' => 'https://www.facebook.com/profile.php?id=61580407266348'),
            array('label' => 'YouTube', 'url' => 'https://www.youtube.com/@CENTRALBUILD'),
        ),
    );
}

function central_build_get_footer_settings(): array
{
    $defaults = central_build_footer_settings_defaults();
    $saved    = get_option('central_build_footer_settings', array());

    $settings = wp_parse_args(is_array($saved) ? $saved : array(), $defaults);

    $settings['company'] = wp_parse_args($settings['company'] ?? array(), $defaults['company']);
    $settings['company']['phone'] = wp_parse_args($settings['company']['phone'] ?? array(), $defaults['company']['phone']);
    $settings['company']['mobile'] = wp_parse_args($settings['company']['mobile'] ?? array(), $defaults['company']['mobile']);

    $links = array('quick_links', 'support_links');
    foreach ($links as $link_group) {
        $collection = array();
        if (!empty($settings[$link_group]) && is_array($settings[$link_group])) {
            foreach ($settings[$link_group] as $link) {
                $collection[] = wp_parse_args($link, array('label' => '', 'url' => ''));
            }
        }

        if (empty($collection)) {
            $collection = $defaults[$link_group];
        }

        $settings[$link_group] = $collection;
    }

    $social = array();
    foreach ((array) ($settings['social_links'] ?? array()) as $link) {
        $link = wp_parse_args((array) $link, array('label' => '', 'url' => ''));
        if (trim($link['url']) !== '') {
            $social[] = $link;
        }
    }
    $settings['social_links'] = $social;

    return $settings;
}

function central_build_sanitize_footer_settings(array $input): array
{
    $defaults = central_build_footer_settings_defaults();

    $company = array(
        'logo_url'    => isset($input['company']['logo_url']) ? esc_url_raw(wp_unslash($input['company']['logo_url'])) : $defaults['company']['logo_url'],
        'description' => isset($input['company']['description']) ? wp_kses_post(wp_unslash($input['company']['description'])) : $defaults['company']['description'],
        'licence'     => isset($input['company']['licence']) ? sanitize_text_field(wp_unslash($input['company']['licence'])) : $defaults['company']['licence'],
        'email'       => isset($input['company']['email']) ? sanitize_email(wp_unslash($input['company']['email'])) : $defaults['company']['email'],
        'phone'       => array(
            'display' => isset($input['company']['phone']['display']) ? sanitize_text_field(wp_unslash($input['company']['phone']['display'])) : $defaults['company']['phone']['display'],
            'link'    => isset($input['company']['phone']['link']) ? sanitize_text_field(wp_unslash($input['company']['phone']['link'])) : $defaults['company']['phone']['link'],
        ),
        'mobile'      => array(
            'display' => isset($input['company']['mobile']['display']) ? sanitize_text_field(wp_unslash($input['company']['mobile']['display'])) : $defaults['company']['mobile']['display'],
            'link'    => isset($input['company']['mobile']['link']) ? sanitize_text_field(wp_unslash($input['company']['mobile']['link'])) : $defaults['company']['mobile']['link'],
        ),
    );

    if (empty($company['email'])) {
        $company['email'] = $defaults['company']['email'];
    }

    if ($company['mobile']['display'] !== '' && empty($company['mobile']['link'])) {
        $digits = preg_replace('/[^0-9+]/', '', $company['mobile']['display']);
        $company['mobile']['link'] = $digits ? 'tel:' . $digits : '';
    }

    if (empty($company['phone']['link'])) {
        $digits = preg_replace('/[^0-9+]/', '', $company['phone']['display']);
        $company['phone']['link'] = $digits ? 'tel:' . $digits : $defaults['company']['phone']['link'];
    }

    $sanitize_links = function ($links, $fallback) {
        $sanitized = array();
        if (is_array($links)) {
            foreach ($links as $link) {
                $label = isset($link['label']) ? sanitize_text_field(wp_unslash($link['label'])) : '';
                $url   = isset($link['url']) ? esc_url_raw(wp_unslash($link['url'])) : '';

                if ($label === '' && $url === '') {
                    continue;
                }

                $sanitized[] = array(
                    'label' => $label,
                    'url'   => $url,
                );
            }
        }

        if (empty($sanitized)) {
            $sanitized = $fallback;
        }

        return $sanitized;
    };

    return array(
        'company'       => $company,
        'quick_links'   => $sanitize_links($input['quick_links'] ?? array(), $defaults['quick_links']),
        'support_links' => $sanitize_links($input['support_links'] ?? array(), $defaults['support_links']),
        'copyright'     => sanitize_text_field(wp_unslash($input['copyright'] ?? $defaults['copyright'])),
        'social_links'  => array_values(array_filter($sanitize_links($input['social_links'] ?? array(), array()), static function ($l) {
            return $l['url'] !== '';
        })),
    );
}

function central_build_handle_footer_settings_submit(): void
{
    if (!isset($_POST['central_build_footer_settings_submit'])) {
        return;
    }

    check_admin_referer('central_build_footer_settings');

    $raw = isset($_POST['central_build_footer_settings']) && is_array($_POST['central_build_footer_settings'])
        ? $_POST['central_build_footer_settings']
        : array();

    $sanitized = central_build_sanitize_footer_settings($raw);

    update_option('central_build_footer_settings', $sanitized);

    add_settings_error('central_build_footer_settings', 'central_build_footer_settings_updated', __('Footer settings saved successfully.', 'central-build'), 'updated');
}

function central_build_footer_settings_page_render(): void
{
    central_build_handle_footer_settings_submit();

    $settings = central_build_get_footer_settings();
    $messages = get_settings_errors('central_build_footer_settings');

    ?>
    <div class="wrap">
        <h1><?php esc_html_e('Footer Settings', 'central-build'); ?></h1>

        <?php if (!empty($messages)) :
            foreach ($messages as $message) :
                printf('<div class="%1$s"><p>%2$s</p></div>', esc_attr($message['type']), esc_html($message['message']));
            endforeach;
        endif; ?>

        <form method="post" action="">
            <?php wp_nonce_field('central_build_footer_settings'); ?>

            <h2 class="title"><?php esc_html_e('Company Information', 'central-build'); ?></h2>
            <table class="form-table" role="presentation">
                <tbody>
                    <tr>
                        <th scope="row"><label for="cb-footer-logo-url"><?php esc_html_e('Logo URL', 'central-build'); ?></label></th>
                        <td>
                            <input type="text" id="cb-footer-logo-url" name="central_build_footer_settings[company][logo_url]" class="regular-text" value="<?php echo esc_url($settings['company']['logo_url']); ?>" />
                            <p class="description"><?php esc_html_e('Absolute URL to the footer logo.', 'central-build'); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-footer-description"><?php esc_html_e('Description', 'central-build'); ?></label></th>
                        <td>
                            <textarea id="cb-footer-description" name="central_build_footer_settings[company][description]" rows="3" class="large-text"><?php echo esc_textarea($settings['company']['description']); ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-footer-email"><?php esc_html_e('Email Address', 'central-build'); ?></label></th>
                        <td><input type="email" id="cb-footer-email" name="central_build_footer_settings[company][email]" class="regular-text" value="<?php echo esc_attr($settings['company']['email']); ?>" /></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-footer-phone-display"><?php esc_html_e('Phone (display)', 'central-build'); ?></label></th>
                        <td><input type="text" id="cb-footer-phone-display" name="central_build_footer_settings[company][phone][display]" class="regular-text" value="<?php echo esc_attr($settings['company']['phone']['display']); ?>" /></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-footer-phone-link"><?php esc_html_e('Phone (tel link)', 'central-build'); ?></label></th>
                        <td>
                            <input type="text" id="cb-footer-phone-link" name="central_build_footer_settings[company][phone][link]" class="regular-text" value="<?php echo esc_attr($settings['company']['phone']['link']); ?>" placeholder="tel:0123456789" />
                            <p class="description"><?php esc_html_e('Leave blank to auto-generate from the displayed number.', 'central-build'); ?></p>
                        </td>
                    </tr>
                </tbody>
            </table>

            <h2 class="title"><?php esc_html_e('Quick Links', 'central-build'); ?></h2>
            <div class="central-build-repeatable" id="cb-footer-quick-links">
                <?php foreach ($settings['quick_links'] as $index => $link) : ?>
                    <div class="central-build-repeatable__item">
                        <div class="central-build-repeatable__head">
                            <strong><?php printf(esc_html__('Link %d', 'central-build'), $index + 1); ?></strong>
                            <button type="button" class="button button-link-delete central-build-repeatable__remove" data-repeatable-remove><?php esc_html_e('Remove', 'central-build'); ?></button>
                        </div>
                        <div class="central-build-repeatable__body">
                            <p>
                                <label>
                                    <?php esc_html_e('Label', 'central-build'); ?><br />
                                    <input type="text" name="central_build_footer_settings[quick_links][<?php echo esc_attr($index); ?>][label]" class="regular-text" value="<?php echo esc_attr($link['label']); ?>" />
                                </label>
                            </p>
                            <p>
                                <label>
                                    <?php esc_html_e('URL', 'central-build'); ?><br />
                                    <input type="text" name="central_build_footer_settings[quick_links][<?php echo esc_attr($index); ?>][url]" class="regular-text" value="<?php echo esc_url($link['url']); ?>" />
                                </label>
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="button" class="button" data-repeatable-add data-repeatable-target="cb-footer-quick-links" data-repeatable-template="cb-footer-quick-link-template"><?php esc_html_e('Add Quick Link', 'central-build'); ?></button>

            <h2 class="title"><?php esc_html_e('Support Links', 'central-build'); ?></h2>
            <div class="central-build-repeatable" id="cb-footer-support-links">
                <?php foreach ($settings['support_links'] as $index => $link) : ?>
                    <div class="central-build-repeatable__item">
                        <div class="central-build-repeatable__head">
                            <strong><?php printf(esc_html__('Link %d', 'central-build'), $index + 1); ?></strong>
                            <button type="button" class="button button-link-delete central-build-repeatable__remove" data-repeatable-remove><?php esc_html_e('Remove', 'central-build'); ?></button>
                        </div>
                        <div class="central-build-repeatable__body">
                            <p>
                                <label>
                                    <?php esc_html_e('Label', 'central-build'); ?><br />
                                    <input type="text" name="central_build_footer_settings[support_links][<?php echo esc_attr($index); ?>][label]" class="regular-text" value="<?php echo esc_attr($link['label']); ?>" />
                                </label>
                            </p>
                            <p>
                                <label>
                                    <?php esc_html_e('URL', 'central-build'); ?><br />
                                    <input type="text" name="central_build_footer_settings[support_links][<?php echo esc_attr($index); ?>][url]" class="regular-text" value="<?php echo esc_url($link['url']); ?>" />
                                </label>
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="button" class="button" data-repeatable-add data-repeatable-target="cb-footer-support-links" data-repeatable-template="cb-footer-support-link-template"><?php esc_html_e('Add Support Link', 'central-build'); ?></button>

            <p class="submit">
                <button type="submit" name="central_build_footer_settings_submit" class="button button-primary"><?php esc_html_e('Save Footer Settings', 'central-build'); ?></button>
            </p>
        </form>
    </div>

    <script type="text/template" id="cb-footer-quick-link-template">
        <div class="central-build-repeatable__item">
            <div class="central-build-repeatable__head">
                <strong><?php esc_html_e('Quick Link', 'central-build'); ?></strong>
                <button type="button" class="button button-link-delete central-build-repeatable__remove" data-repeatable-remove><?php esc_html_e('Remove', 'central-build'); ?></button>
            </div>
            <div class="central-build-repeatable__body">
                <p>
                    <label>
                        <?php esc_html_e('Label', 'central-build'); ?><br />
                        <input type="text" name="central_build_footer_settings[quick_links][__INDEX__][label]" class="regular-text" />
                    </label>
                </p>
                <p>
                    <label>
                        <?php esc_html_e('URL', 'central-build'); ?><br />
                        <input type="text" name="central_build_footer_settings[quick_links][__INDEX__][url]" class="regular-text" />
                    </label>
                </p>
            </div>
        </div>
    </script>

    <script type="text/template" id="cb-footer-support-link-template">
        <div class="central-build-repeatable__item">
            <div class="central-build-repeatable__head">
                <strong><?php esc_html_e('Support Link', 'central-build'); ?></strong>
                <button type="button" class="button button-link-delete central-build-repeatable__remove" data-repeatable-remove><?php esc_html_e('Remove', 'central-build'); ?></button>
            </div>
            <div class="central-build-repeatable__body">
                <p>
                    <label>
                        <?php esc_html_e('Label', 'central-build'); ?><br />
                        <input type="text" name="central_build_footer_settings[support_links][__INDEX__][label]" class="regular-text" />
                    </label>
                </p>
                <p>
                    <label>
                        <?php esc_html_e('URL', 'central-build'); ?><br />
                        <input type="text" name="central_build_footer_settings[support_links][__INDEX__][url]" class="regular-text" />
                    </label>
                </p>
            </div>
        </div>
    </script>

    <style>
        .central-build-repeatable { margin: 0 0 1.5rem; }
        .central-build-repeatable__item { border: 1px solid #dcdcde; border-radius: 4px; padding: 1rem; margin-bottom: 1rem; background: #fff; }
        .central-build-repeatable__head { display: flex; align-items: center; justify-content: space-between; margin-bottom: .75rem; }
        .central-build-repeatable__body p { margin: 0 0 1rem; }
    </style>

    <script>
        (function(){
            const addButtons = document.querySelectorAll('[data-repeatable-add]');
            addButtons.forEach(function(button){
                button.addEventListener('click', function(){
                    const targetId = this.getAttribute('data-repeatable-target');
                    const templateId = this.getAttribute('data-repeatable-template');
                    const target = document.getElementById(targetId);
                    const template = document.getElementById(templateId);
                    if (!target || !template) { return; }

                    const index = target.querySelectorAll('.central-build-repeatable__item').length;
                    const markup = template.innerHTML.replace(/__INDEX__/g, index);
                    const wrapper = document.createElement('div');
                    wrapper.innerHTML = markup.trim();
                    target.appendChild(wrapper.firstElementChild);
                });
            });

            document.addEventListener('click', function(event){
                if (event.target && event.target.hasAttribute('data-repeatable-remove')) {
                    const item = event.target.closest('.central-build-repeatable__item');
                    if (item) {
                        item.remove();
                    }
                }
            });
        })();
    </script>
    <?php
}

function central_build_footer_settings_menu(): void
{
    add_theme_page(
        __('Footer Settings', 'central-build'),
        __('Footer Settings', 'central-build'),
        'manage_options',
        'central-build-footer-settings',
        'central_build_footer_settings_page_render'
    );
}
add_action('admin_menu', 'central_build_footer_settings_menu');

/** Brand icon (Font Awesome) for a social link, from its address or name. */
function central_build_social_icon(string $url, string $label = ''): string
{
    $hay = strtolower($url . ' ' . $label);
    foreach (array('facebook' => 'fab fa-facebook-f', 'youtube' => 'fab fa-youtube', 'youtu.be' => 'fab fa-youtube', 'linkedin' => 'fab fa-linkedin-in',
        'instagram' => 'fab fa-instagram', 'tiktok' => 'fab fa-tiktok', 'x.com' => 'fab fa-x-twitter', 'twitter' => 'fab fa-x-twitter') as $needle => $icon) {
        if (strpos($hay, $needle) !== false) {
            return $icon;
        }
    }
    return 'fas fa-link';
}

/** Footer copyright line with {year} replaced by the current year. */
function central_build_footer_copyright(): string
{
    $settings = central_build_get_footer_settings();
    $line     = trim((string) ($settings['copyright'] ?? ''));
    return str_replace('{year}', wp_date('Y'), $line);
}
