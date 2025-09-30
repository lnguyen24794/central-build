<?php
if (!defined('ABSPATH')) {
    exit;
}

function central_build_header_settings_defaults(): array
{
    $theme_uri = get_template_directory_uri();

    return array(
        'phone' => array(
            'link'    => 'tel:+61431465090',
            'display' => '+61 431 465 090',
        ),
        'email' => 'info@centralbuild.au',
        'social_links' => array(
            array(
                'label'    => 'Facebook',
                'url'      => 'https://www.facebook.com/p/ENP-Fitouts-100079118888496/',
                'icon_url' => $theme_uri . '/images/Footer-Fb.svg',
                'icon_alt' => 'Facebook icon',
            ),
            array(
                'label'    => 'LinkedIn',
                'url'      => 'https://www.linkedin.com/company/enp-fitouts/?originalSubdomain=au',
                'icon_url' => $theme_uri . '/images/Linkedin-Icon-Big.svg',
                'icon_alt' => 'LinkedIn icon',
            ),
            array(
                'label'    => 'Instagram',
                'url'      => 'https://www.instagram.com/enpfitouts',
                'icon_url' => $theme_uri . '/images/Footer-Instra.svg',
                'icon_alt' => 'Instagram icon',
            ),
        ),
        'cta' => array(
            'text' => 'Get A quote',
            'url'  => home_url('/contact'),
        ),
        'logo' => array(
            'width'  => 121,
            'height' => 38,
        ),
    );
}

function central_build_get_header_settings(): array
{
    $defaults = central_build_header_settings_defaults();
    $saved    = get_option('central_build_header_settings', array());

    $settings = wp_parse_args($saved, $defaults);

    $settings['phone'] = wp_parse_args($settings['phone'] ?? array(), $defaults['phone']);
    $settings['cta']   = wp_parse_args($settings['cta'] ?? array(), $defaults['cta']);
    $settings['logo']  = wp_parse_args($settings['logo'] ?? array(), $defaults['logo']);

    $social_links = array();
    if (!empty($settings['social_links']) && is_array($settings['social_links'])) {
        foreach ($settings['social_links'] as $link) {
            $social_links[] = wp_parse_args($link, array(
                'label'    => '',
                'url'      => '',
                'icon_url' => '',
                'icon_alt' => '',
            ));
        }
    }

    if (empty($social_links)) {
        $social_links = $defaults['social_links'];
    }

    $settings['social_links'] = $social_links;

    if (!isset($settings['email']) || !is_string($settings['email'])) {
        $settings['email'] = $defaults['email'];
    }

    return $settings;
}

function central_build_sanitize_header_settings(array $input): array
{
    $defaults = central_build_header_settings_defaults();

    $sanitized = array();

    $sanitized['phone'] = array(
        'link'    => isset($input['phone']['link']) ? sanitize_text_field(wp_unslash($input['phone']['link'])) : $defaults['phone']['link'],
        'display' => isset($input['phone']['display']) ? sanitize_text_field(wp_unslash($input['phone']['display'])) : $defaults['phone']['display'],
    );

    $sanitized['email'] = isset($input['email']) ? sanitize_email(wp_unslash($input['email'])) : $defaults['email'];
    if (empty($sanitized['email'])) {
        $sanitized['email'] = $defaults['email'];
    }

    $sanitized['cta'] = array(
        'text' => isset($input['cta']['text']) ? sanitize_text_field(wp_unslash($input['cta']['text'])) : $defaults['cta']['text'],
        'url'  => isset($input['cta']['url']) ? esc_url_raw(wp_unslash($input['cta']['url'])) : $defaults['cta']['url'],
    );

    $sanitized['logo'] = array(
        'width'  => isset($input['logo']['width']) ? max(0, absint($input['logo']['width'])) : $defaults['logo']['width'],
        'height' => isset($input['logo']['height']) ? max(0, absint($input['logo']['height'])) : $defaults['logo']['height'],
    );

    $social_links = array();
    if (!empty($input['social_links']) && is_array($input['social_links'])) {
        foreach ($input['social_links'] as $link) {
            $label    = isset($link['label']) ? sanitize_text_field(wp_unslash($link['label'])) : '';
            $url      = isset($link['url']) ? esc_url_raw(wp_unslash($link['url'])) : '';
            $icon_url = isset($link['icon_url']) ? esc_url_raw(wp_unslash($link['icon_url'])) : '';
            $icon_alt = isset($link['icon_alt']) ? sanitize_text_field(wp_unslash($link['icon_alt'])) : '';

            if ($label === '' && $url === '') {
                continue;
            }

            $social_links[] = array(
                'label'    => $label,
                'url'      => $url,
                'icon_url' => $icon_url,
                'icon_alt' => $icon_alt,
            );
        }
    }

    if (empty($social_links)) {
        $social_links = $defaults['social_links'];
    }

    $sanitized['social_links'] = $social_links;

    return $sanitized;
}

function central_build_handle_header_settings_submit(): void
{
    if (!isset($_POST['central_build_header_settings_submit'])) {
        return;
    }

    check_admin_referer('central_build_header_settings');

    $raw = isset($_POST['central_build_header_settings']) && is_array($_POST['central_build_header_settings'])
        ? $_POST['central_build_header_settings']
        : array();

    $sanitized = central_build_sanitize_header_settings($raw);

    update_option('central_build_header_settings', $sanitized);

    add_settings_error('central_build_header_settings', 'central_build_header_settings_updated', __('Header settings saved successfully.', 'central-build'), 'updated');
}

function central_build_header_settings_page_render(): void
{
    central_build_handle_header_settings_submit();

    $settings = central_build_get_header_settings();
    $messages = get_settings_errors('central_build_header_settings');
    ?>
    <div class="wrap">
        <h1><?php esc_html_e('Header Settings', 'central-build'); ?></h1>

        <?php if (!empty($messages)) :
            foreach ($messages as $message) :
                printf('<div class="%1$s"><p>%2$s</p></div>', esc_attr($message['type']), esc_html($message['message']));
            endforeach;
        endif; ?>

        <form method="post" action="">
            <?php wp_nonce_field('central_build_header_settings'); ?>

            <h2 class="title"><?php esc_html_e('Top Bar Contact', 'central-build'); ?></h2>
            <table class="form-table" role="presentation">
                <tbody>
                    <tr>
                        <th scope="row"><label for="cb-header-phone-link"><?php esc_html_e('Phone (tel link)', 'central-build'); ?></label></th>
                        <td>
                            <input type="text" id="cb-header-phone-link" name="central_build_header_settings[phone][link]" class="regular-text"
                                value="<?php echo esc_attr($settings['phone']['link']); ?>" placeholder="tel:+61431465090" />
                            <p class="description"><?php esc_html_e('Use tel: format for click-to-call.', 'central-build'); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-header-phone-display"><?php esc_html_e('Phone (display)', 'central-build'); ?></label></th>
                        <td>
                            <input type="text" id="cb-header-phone-display" name="central_build_header_settings[phone][display]" class="regular-text"
                                value="<?php echo esc_attr($settings['phone']['display']); ?>" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-header-email"><?php esc_html_e('Email Address', 'central-build'); ?></label></th>
                        <td>
                            <input type="email" id="cb-header-email" name="central_build_header_settings[email]" class="regular-text"
                                value="<?php echo esc_attr($settings['email']); ?>" />
                        </td>
                    </tr>
                </tbody>
            </table>

            <h2 class="title"><?php esc_html_e('Social Links', 'central-build'); ?></h2>
            <p class="description"><?php esc_html_e('Add social media links displayed in the header top bar.', 'central-build'); ?></p>

            <div class="central-build-repeatable" id="cb-header-social-wrapper">
                <?php foreach ($settings['social_links'] as $index => $link) : ?>
                    <div class="central-build-repeatable__item">
                        <div class="central-build-repeatable__head">
                            <strong><?php printf(esc_html__('Social Link %d', 'central-build'), $index + 1); ?></strong>
                            <button type="button" class="button button-link-delete central-build-repeatable__remove" data-repeatable-remove><?php esc_html_e('Remove', 'central-build'); ?></button>
                        </div>
                        <div class="central-build-repeatable__body">
                            <p>
                                <label>
                                    <?php esc_html_e('Label', 'central-build'); ?><br />
                                    <input type="text" name="central_build_header_settings[social_links][<?php echo esc_attr($index); ?>][label]" class="regular-text" value="<?php echo esc_attr($link['label']); ?>" />
                                </label>
                            </p>
                            <p>
                                <label>
                                    <?php esc_html_e('URL', 'central-build'); ?><br />
                                    <input type="text" name="central_build_header_settings[social_links][<?php echo esc_attr($index); ?>][url]" class="regular-text" value="<?php echo esc_url($link['url']); ?>" />
                                </label>
                            </p>
                            <p>
                                <label>
                                    <?php esc_html_e('Icon URL', 'central-build'); ?><br />
                                    <input type="text" name="central_build_header_settings[social_links][<?php echo esc_attr($index); ?>][icon_url]" class="regular-text" value="<?php echo esc_url($link['icon_url']); ?>" placeholder="<?php echo esc_url(get_template_directory_uri() . '/images/social-icon.svg'); ?>" />
                                </label>
                                <span class="description"><?php esc_html_e('Provide an absolute URL to the icon image.', 'central-build'); ?></span>
                            </p>
                            <p>
                                <label>
                                    <?php esc_html_e('Icon Alt Text', 'central-build'); ?><br />
                                    <input type="text" name="central_build_header_settings[social_links][<?php echo esc_attr($index); ?>][icon_alt]" class="regular-text" value="<?php echo esc_attr($link['icon_alt']); ?>" />
                                </label>
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <button type="button" class="button" data-repeatable-add data-repeatable-target="cb-header-social-wrapper" data-repeatable-template="cb-header-social-template"><?php esc_html_e('Add Social Link', 'central-build'); ?></button>

            <h2 class="title"><?php esc_html_e('Primary CTA', 'central-build'); ?></h2>
            <table class="form-table" role="presentation">
                <tbody>
                    <tr>
                        <th scope="row"><label for="cb-header-cta-text"><?php esc_html_e('Button Text', 'central-build'); ?></label></th>
                        <td><input type="text" id="cb-header-cta-text" name="central_build_header_settings[cta][text]" class="regular-text" value="<?php echo esc_attr($settings['cta']['text']); ?>" /></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-header-cta-url"><?php esc_html_e('Button URL', 'central-build'); ?></label></th>
                        <td><input type="text" id="cb-header-cta-url" name="central_build_header_settings[cta][url]" class="regular-text" value="<?php echo esc_url($settings['cta']['url']); ?>" /></td>
                    </tr>
                </tbody>
            </table>

            <h2 class="title"><?php esc_html_e('Logo Dimensions', 'central-build'); ?></h2>
            <table class="form-table" role="presentation">
                <tbody>
                    <tr>
                        <th scope="row"><label for="cb-header-logo-width"><?php esc_html_e('Logo Width (px)', 'central-build'); ?></label></th>
                        <td><input type="number" min="0" id="cb-header-logo-width" name="central_build_header_settings[logo][width]" value="<?php echo esc_attr((int) $settings['logo']['width']); ?>" /></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-header-logo-height"><?php esc_html_e('Logo Height (px)', 'central-build'); ?></label></th>
                        <td><input type="number" min="0" id="cb-header-logo-height" name="central_build_header_settings[logo][height]" value="<?php echo esc_attr((int) $settings['logo']['height']); ?>" /></td>
                    </tr>
                </tbody>
            </table>

            <p class="submit">
                <button type="submit" name="central_build_header_settings_submit" class="button button-primary"><?php esc_html_e('Save Header Settings', 'central-build'); ?></button>
            </p>
        </form>
    </div>

    <script type="text/template" id="cb-header-social-template">
        <div class="central-build-repeatable__item">
            <div class="central-build-repeatable__head">
                <strong><?php esc_html_e('Social Link', 'central-build'); ?></strong>
                <button type="button" class="button button-link-delete central-build-repeatable__remove" data-repeatable-remove><?php esc_html_e('Remove', 'central-build'); ?></button>
            </div>
            <div class="central-build-repeatable__body">
                <p>
                    <label>
                        <?php esc_html_e('Label', 'central-build'); ?><br />
                        <input type="text" name="central_build_header_settings[social_links][__INDEX__][label]" class="regular-text" />
                    </label>
                </p>
                <p>
                    <label>
                        <?php esc_html_e('URL', 'central-build'); ?><br />
                        <input type="text" name="central_build_header_settings[social_links][__INDEX__][url]" class="regular-text" />
                    </label>
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Icon URL', 'central-build'); ?><br />
                        <input type="text" name="central_build_header_settings[social_links][__INDEX__][icon_url]" class="regular-text" />
                    </label>
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Icon Alt Text', 'central-build'); ?><br />
                        <input type="text" name="central_build_header_settings[social_links][__INDEX__][icon_alt]" class="regular-text" />
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

function central_build_header_settings_menu(): void
{
    add_theme_page(
        __('Header Settings', 'central-build'),
        __('Header Settings', 'central-build'),
        'manage_options',
        'central-build-header-settings',
        'central_build_header_settings_page_render'
    );
}
add_action('admin_menu', 'central_build_header_settings_menu');
