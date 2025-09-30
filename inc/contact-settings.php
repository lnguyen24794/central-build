<?php
if (!defined('ABSPATH')) {
    exit;
}

function central_build_contact_settings_defaults(): array
{
    return array(
        'hero' => array(
            'title'       => "let's work <span>together</span>",
            'description' => "Reach out to Central Build to start your journey. Whether you're looking for a bespoke design, a seamless build, or expert advice, we're here to help make your vision a reality. Let's create something exceptional together.",
        ),
        'contact_info' => array(
            'email' => 'info@centralbuild.au',
            'phone' => array(
                'link'    => 'tel:0123456789',
                'display' => '0123 456 789',
            ),
        ),
        'channels' => array(
            array(
                'title'       => 'Project & Quote Inquiries',
                'description' => 'For new commercial fit-outs, stripouts, or complex coordination requests.',
                'highlight'   => 'Response Goal: Within 24 Hours.',
                'icon'        => 'fas fa-drafting-compass',
                'style'       => 'accent',
                'cta'         => array(
                    'label' => 'Start project form',
                    'url'   => '#form',
                    'type'  => 'anchor',
                ),
            ),
            array(
                'title'       => 'Urgent Repairs (24/7)',
                'description' => 'For critical faults: electrical failure, burst pipes, or immediate site issues.',
                'highlight'   => '+1 (123) 456-7890',
                'icon'        => 'fas fa-headset',
                'style'       => 'emergency',
                'cta'         => array(
                    'label' => 'Call now',
                    'url'   => 'tel:+11234567890',
                    'type'  => 'tel',
                ),
            ),
            array(
                'title'       => 'General & Accounts',
                'description' => 'For general questions, vendor relations, or accounting inquiries.',
                'highlight'   => '',
                'icon'        => 'fas fa-envelope-open-text',
                'style'       => 'primary',
                'cta'         => array(
                    'label' => 'info@centralbuild.com',
                    'url'   => 'mailto:info@centralbuild.com',
                    'type'  => 'mail',
                ),
                'secondary'   => '+1 (123) 456-7899',
            ),
        ),
        'form' => array(
            'title'       => "We're here to help",
            'description' => 'Tell us about your project & goals!',
            'redirect'    => '/thank-you',
        ),
        'checklist' => array(
            'title'       => 'Ready to Connect?',
            'items'       => array(
                'Defined required service (Fitout/Stripout).',
                'Estimated project size or budget range.',
                'Contact information is correct for follow-up.',
            ),
        ),
        'office' => array(
            'title'       => 'Office Hours',
            'description' => 'EMERGENCY SUPPORT 24 Hours / 7 Days a Week',
            'hours'       => array(
                array('label' => 'MON - FRI', 'value' => '8:00 AM - 5:00 PM'),
            ),
            'image'        => 'https://static1.squarespace.com/static/6176ce05013c5128c1ff5aa8/6194da83ea54f441cdb5a7de/64d3736437d050544f081ff3/1707218367383/Construction-recruitment+-+dayin+the+life.jpg?format=1500w',
            'cta_label'    => 'GET DIRECTIONS',
            'cta_url'      => 'path/to/map-link',
            'address_title' => 'Headquarters Address',
            'address_lines' => array(
                'Central Build Construction',
                '123 Commercial Drive, Suite 100',
                'Metropolis, Anytown 12345',
            ),
        ),
    );
}

function central_build_get_contact_settings(): array
{
    $defaults = central_build_contact_settings_defaults();
    $saved    = get_option('central_build_contact_settings', array());

    $settings = wp_parse_args(is_array($saved) ? $saved : array(), $defaults);

    $settings['hero'] = wp_parse_args($settings['hero'] ?? array(), $defaults['hero']);
    $settings['hero']['title'] = $settings['hero']['title'] ?: $defaults['hero']['title'];

    $settings['contact_info'] = wp_parse_args($settings['contact_info'] ?? array(), $defaults['contact_info']);
    $settings['contact_info']['phone'] = wp_parse_args($settings['contact_info']['phone'] ?? array(), $defaults['contact_info']['phone']);

    $settings['channels'] = is_array($settings['channels'] ?? null) ? $settings['channels'] : $defaults['channels'];
    $settings['form']     = wp_parse_args($settings['form'] ?? array(), $defaults['form']);
    $settings['checklist'] = wp_parse_args($settings['checklist'] ?? array(), $defaults['checklist']);
    $settings['office']   = wp_parse_args($settings['office'] ?? array(), $defaults['office']);

    $settings['checklist']['items'] = array_values(array_filter($settings['checklist']['items'] ?? array(), 'strlen'));
    if (empty($settings['checklist']['items'])) {
        $settings['checklist']['items'] = $defaults['checklist']['items'];
    }

    $settings['office']['hours'] = array_values(array_filter($settings['office']['hours'] ?? array(), 'is_array'));
    if (empty($settings['office']['hours'])) {
        $settings['office']['hours'] = $defaults['office']['hours'];
    }

    $settings['office']['address_lines'] = array_values(array_filter($settings['office']['address_lines'] ?? array(), 'strlen'));
    if (empty($settings['office']['address_lines'])) {
        $settings['office']['address_lines'] = $defaults['office']['address_lines'];
    }

    return $settings;
}

function central_build_sanitize_contact_settings(array $input): array
{
    $defaults = central_build_contact_settings_defaults();

    $sanitize_text = static function ($value, $fallback = '') {
        $value = is_string($value) ? wp_unslash($value) : '';
        return $value !== '' ? sanitize_text_field($value) : $fallback;
    };
    $sanitize_rich_text = static function ($value, $fallback = '') {
        $value = is_string($value) ? wp_unslash($value) : '';
        return $value !== '' ? wp_kses_post($value) : $fallback;
    };

    $settings = array();

    $settings['hero'] = array(
        'title'       => $sanitize_rich_text($input['hero']['title'] ?? '', $defaults['hero']['title']),
        'description' => $sanitize_rich_text($input['hero']['description'] ?? '', $defaults['hero']['description']),
    );

    $settings['contact_info'] = array(
        'email' => sanitize_email(wp_unslash($input['contact_info']['email'] ?? $defaults['contact_info']['email'])),
        'phone' => array(
            'link'    => $sanitize_text($input['contact_info']['phone']['link'] ?? '', $defaults['contact_info']['phone']['link']),
            'display' => $sanitize_text($input['contact_info']['phone']['display'] ?? '', $defaults['contact_info']['phone']['display']),
        ),
    );

    $channels = array();
    if (isset($input['channels']) && is_array($input['channels'])) {
        foreach ($input['channels'] as $channel) {
            $title       = $sanitize_text($channel['title'] ?? '');
            $description = $sanitize_rich_text($channel['description'] ?? '');
            $highlight   = $sanitize_text($channel['highlight'] ?? '');
            $icon        = $sanitize_text($channel['icon'] ?? '');
            $style       = $sanitize_text($channel['style'] ?? 'primary');

            $cta_label = $sanitize_text($channel['cta']['label'] ?? '');
            $cta_url   = esc_url_raw(wp_unslash($channel['cta']['url'] ?? ''));
            $cta_type  = $sanitize_text($channel['cta']['type'] ?? 'anchor');

            $secondary = $sanitize_text($channel['secondary'] ?? '');

            if ($title === '') {
                continue;
            }

            $channels[] = array(
                'title'       => $title,
                'description' => $description,
                'highlight'   => $highlight,
                'icon'        => $icon,
                'style'       => $style,
                'cta'         => array(
                    'label' => $cta_label,
                    'url'   => $cta_url,
                    'type'  => $cta_type,
                ),
                'secondary'   => $secondary,
            );
        }
    }
    if (empty($channels)) {
        $channels = $defaults['channels'];
    }
    $settings['channels'] = $channels;

    $settings['form'] = array(
        'title'       => $sanitize_text($input['form']['title'] ?? '', $defaults['form']['title']),
        'description' => $sanitize_rich_text($input['form']['description'] ?? '', $defaults['form']['description']),
        'redirect'    => esc_url_raw(wp_unslash($input['form']['redirect'] ?? $defaults['form']['redirect'])),
    );

    $checklist_items = array();
    if (isset($input['checklist']['items']) && is_array($input['checklist']['items'])) {
        foreach ($input['checklist']['items'] as $item) {
            $clean = $sanitize_text($item, '');
            if ($clean !== '') {
                $checklist_items[] = $clean;
            }
        }
    }
    if (empty($checklist_items)) {
        $checklist_items = $defaults['checklist']['items'];
    }

    $settings['checklist'] = array(
        'title' => $sanitize_text($input['checklist']['title'] ?? '', $defaults['checklist']['title']),
        'items' => $checklist_items,
    );

    $hours = array();
    if (isset($input['office']['hours']) && is_array($input['office']['hours'])) {
        foreach ($input['office']['hours'] as $hour) {
            $label = $sanitize_text($hour['label'] ?? '');
            $value = $sanitize_text($hour['value'] ?? '');
            if ($label === '' && $value === '') {
                continue;
            }
            $hours[] = array('label' => $label, 'value' => $value);
        }
    }
    if (empty($hours)) {
        $hours = $defaults['office']['hours'];
    }

    $address_lines = array();
    if (isset($input['office']['address_lines']) && is_array($input['office']['address_lines'])) {
        foreach ($input['office']['address_lines'] as $line) {
            $clean = $sanitize_text($line, '');
            if ($clean !== '') {
                $address_lines[] = $clean;
            }
        }
    }
    if (empty($address_lines)) {
        $address_lines = $defaults['office']['address_lines'];
    }

    $settings['office'] = array(
        'title'         => $sanitize_text($input['office']['title'] ?? '', $defaults['office']['title']),
        'description'   => $sanitize_rich_text($input['office']['description'] ?? '', $defaults['office']['description']),
        'hours'         => $hours,
        'image'         => isset($input['office']['image']) ? esc_url_raw(wp_unslash($input['office']['image'])) : $defaults['office']['image'],
        'cta_label'     => $sanitize_text($input['office']['cta_label'] ?? '', $defaults['office']['cta_label']),
        'cta_url'       => esc_url_raw(wp_unslash($input['office']['cta_url'] ?? $defaults['office']['cta_url'])),
        'address_title' => $sanitize_text($input['office']['address_title'] ?? '', $defaults['office']['address_title']),
        'address_lines' => $address_lines,
    );

    return $settings;
}

function central_build_handle_contact_settings_submit(): void
{
    if (!isset($_POST['central_build_contact_settings_submit'])) {
        return;
    }

    check_admin_referer('central_build_contact_settings');

    $raw = isset($_POST['central_build_contact_settings']) && is_array($_POST['central_build_contact_settings'])
        ? $_POST['central_build_contact_settings']
        : array();

    $sanitized = central_build_sanitize_contact_settings($raw);

    update_option('central_build_contact_settings', $sanitized);

    add_settings_error('central_build_contact_settings', 'central_build_contact_settings_updated', __('Contact settings saved successfully.', 'central-build'), 'updated');
}

function central_build_contact_settings_page_render(): void
{
    central_build_handle_contact_settings_submit();

    $settings = central_build_get_contact_settings();
    $messages = get_settings_errors('central_build_contact_settings');

    ?>
    <div class="wrap">
        <h1><?php esc_html_e('Contact Page Settings', 'central-build'); ?></h1>

        <?php if (!empty($messages)) :
            foreach ($messages as $message) :
                printf('<div class="%1$s"><p>%2$s</p></div>', esc_attr($message['type']), esc_html($message['message']));
            endforeach;
        endif; ?>

        <form method="post" action="">
            <?php wp_nonce_field('central_build_contact_settings'); ?>

            <h2 class="title"><?php esc_html_e('Hero Section', 'central-build'); ?></h2>
            <table class="form-table" role="presentation">
                <tbody>
                    <tr>
                        <th scope="row"><label for="cb-contact-hero-title"><?php esc_html_e('Hero Title', 'central-build'); ?></label></th>
                        <td><input type="text" id="cb-contact-hero-title" name="central_build_contact_settings[hero][title]" class="large-text" value="<?php echo esc_attr($settings['hero']['title']); ?>" /></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-contact-hero-description"><?php esc_html_e('Hero Description', 'central-build'); ?></label></th>
                        <td><textarea id="cb-contact-hero-description" name="central_build_contact_settings[hero][description]" rows="3" class="large-text"><?php echo esc_textarea($settings['hero']['description']); ?></textarea></td>
                    </tr>
                </tbody>
            </table>

            <h2 class="title"><?php esc_html_e('Primary Contact Info', 'central-build'); ?></h2>
            <table class="form-table" role="presentation">
                <tbody>
                    <tr>
                        <th scope="row"><label for="cb-contact-email"><?php esc_html_e('Email Address', 'central-build'); ?></label></th>
                        <td><input type="email" id="cb-contact-email" name="central_build_contact_settings[contact_info][email]" class="regular-text" value="<?php echo esc_attr($settings['contact_info']['email']); ?>" /></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-contact-phone-link"><?php esc_html_e('Phone (tel link)', 'central-build'); ?></label></th>
                        <td><input type="text" id="cb-contact-phone-link" name="central_build_contact_settings[contact_info][phone][link]" class="regular-text" value="<?php echo esc_attr($settings['contact_info']['phone']['link']); ?>" placeholder="tel:0123456789" /></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-contact-phone-display"><?php esc_html_e('Phone (display)', 'central-build'); ?></label></th>
                        <td><input type="text" id="cb-contact-phone-display" name="central_build_contact_settings[contact_info][phone][display]" class="regular-text" value="<?php echo esc_attr($settings['contact_info']['phone']['display']); ?>" /></td>
                    </tr>
                </tbody>
            </table>

            <h2 class="title"><?php esc_html_e('Contact Channels', 'central-build'); ?></h2>
            <div class="central-build-repeatable" id="cb-contact-channels">
                <?php foreach ($settings['channels'] as $index => $channel) : ?>
                    <div class="central-build-repeatable__item">
                        <div class="central-build-repeatable__head">
                            <strong><?php printf(esc_html__('Channel %d', 'central-build'), $index + 1); ?></strong>
                            <button type="button" class="button button-link-delete central-build-repeatable__remove" data-repeatable-remove><?php esc_html_e('Remove', 'central-build'); ?></button>
                        </div>
                        <div class="central-build-repeatable__body">
                            <p>
                                <label>
                                    <?php esc_html_e('Title', 'central-build'); ?><br />
                                    <input type="text" name="central_build_contact_settings[channels][<?php echo esc_attr($index); ?>][title]" class="regular-text" value="<?php echo esc_attr($channel['title']); ?>" />
                                </label>
                            </p>
                            <p>
                                <label>
                                    <?php esc_html_e('Description', 'central-build'); ?><br />
                                    <textarea name="central_build_contact_settings[channels][<?php echo esc_attr($index); ?>][description]" rows="3" class="large-text"><?php echo esc_textarea($channel['description']); ?></textarea>
                                </label>
                            </p>
                            <p>
                                <label>
                                    <?php esc_html_e('Highlight', 'central-build'); ?><br />
                                    <input type="text" name="central_build_contact_settings[channels][<?php echo esc_attr($index); ?>][highlight]" class="regular-text" value="<?php echo esc_attr($channel['highlight']); ?>" />
                                </label>
                            </p>
                            <p>
                                <label>
                                    <?php esc_html_e('Icon Class', 'central-build'); ?><br />
                                    <input type="text" name="central_build_contact_settings[channels][<?php echo esc_attr($index); ?>][icon]" class="regular-text" value="<?php echo esc_attr($channel['icon']); ?>" placeholder="fas fa-headset" />
                                </label>
                            </p>
                            <p>
                                <label>
                                    <?php esc_html_e('Style', 'central-build'); ?><br />
                                    <select name="central_build_contact_settings[channels][<?php echo esc_attr($index); ?>][style]">
                                        <option value="primary" <?php selected($channel['style'], 'primary'); ?>><?php esc_html_e('Primary', 'central-build'); ?></option>
                                        <option value="accent" <?php selected($channel['style'], 'accent'); ?>><?php esc_html_e('Accent', 'central-build'); ?></option>
                                        <option value="emergency" <?php selected($channel['style'], 'emergency'); ?>><?php esc_html_e('Emergency', 'central-build'); ?></option>
                                    </select>
                                </label>
                            </p>
                            <p>
                                <label>
                                    <?php esc_html_e('CTA Label', 'central-build'); ?><br />
                                    <input type="text" name="central_build_contact_settings[channels][<?php echo esc_attr($index); ?>][cta][label]" class="regular-text" value="<?php echo esc_attr($channel['cta']['label']); ?>" />
                                </label>
                            </p>
                            <p>
                                <label>
                                    <?php esc_html_e('CTA URL', 'central-build'); ?><br />
                                    <input type="text" name="central_build_contact_settings[channels][<?php echo esc_attr($index); ?>][cta][url]" class="regular-text" value="<?php echo esc_url($channel['cta']['url']); ?>" />
                                </label>
                            </p>
                            <p>
                                <label>
                                    <?php esc_html_e('CTA Type', 'central-build'); ?><br />
                                    <select name="central_build_contact_settings[channels][<?php echo esc_attr($index); ?>][cta][type]">
                                        <option value="anchor" <?php selected($channel['cta']['type'], 'anchor'); ?>><?php esc_html_e('Anchor / Button', 'central-build'); ?></option>
                                        <option value="tel" <?php selected($channel['cta']['type'], 'tel'); ?>><?php esc_html_e('Phone', 'central-build'); ?></option>
                                        <option value="mail" <?php selected($channel['cta']['type'], 'mail'); ?>><?php esc_html_e('Email', 'central-build'); ?></option>
                                    </select>
                                </label>
                            </p>
                            <p>
                                <label>
                                    <?php esc_html_e('Secondary Text', 'central-build'); ?><br />
                                    <input type="text" name="central_build_contact_settings[channels][<?php echo esc_attr($index); ?>][secondary]" class="regular-text" value="<?php echo esc_attr($channel['secondary'] ?? ''); ?>" />
                                </label>
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="button" class="button" data-repeatable-add data-repeatable-target="cb-contact-channels" data-repeatable-template="cb-contact-channel-template"><?php esc_html_e('Add Channel', 'central-build'); ?></button>

            <h2 class="title"><?php esc_html_e('Contact Form', 'central-build'); ?></h2>
            <table class="form-table" role="presentation">
                <tbody>
                    <tr>
                        <th scope="row"><label for="cb-contact-form-title"><?php esc_html_e('Form Title', 'central-build'); ?></label></th>
                        <td><input type="text" id="cb-contact-form-title" name="central_build_contact_settings[form][title]" class="regular-text" value="<?php echo esc_attr($settings['form']['title']); ?>" /></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-contact-form-description"><?php esc_html_e('Form Description', 'central-build'); ?></label></th>
                        <td><textarea id="cb-contact-form-description" name="central_build_contact_settings[form][description]" rows="3" class="large-text"><?php echo esc_textarea($settings['form']['description']); ?></textarea></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-contact-form-redirect"><?php esc_html_e('Redirect URL', 'central-build'); ?></label></th>
                        <td><input type="text" id="cb-contact-form-redirect" name="central_build_contact_settings[form][redirect]" class="regular-text" value="<?php echo esc_url($settings['form']['redirect']); ?>" /></td>
                    </tr>
                </tbody>
            </table>

            <h2 class="title"><?php esc_html_e('Checklist', 'central-build'); ?></h2>
            <table class="form-table" role="presentation">
                <tbody>
                    <tr>
                        <th scope="row"><label for="cb-contact-checklist-title"><?php esc_html_e('Checklist Title', 'central-build'); ?></label></th>
                        <td><input type="text" id="cb-contact-checklist-title" name="central_build_contact_settings[checklist][title]" class="regular-text" value="<?php echo esc_attr($settings['checklist']['title']); ?>" /></td>
                    </tr>
                    <tr>
                        <th scope="row"><?php esc_html_e('Checklist Items', 'central-build'); ?></th>
                        <td>
                            <?php foreach ($settings['checklist']['items'] as $index => $item) : ?>
                                <input type="text" name="central_build_contact_settings[checklist][items][<?php echo esc_attr($index); ?>]" class="regular-text" value="<?php echo esc_attr($item); ?>" style="margin-bottom: 5px;" />
                            <?php endforeach; ?>
                            <input type="text" name="central_build_contact_settings[checklist][items][]" class="regular-text" placeholder="<?php esc_attr_e('Add checklist item…', 'central-build'); ?>" />
                        </td>
                    </tr>
                </tbody>
            </table>

            <h2 class="title"><?php esc_html_e('Office Information', 'central-build'); ?></h2>
            <table class="form-table" role="presentation">
                <tbody>
                    <tr>
                        <th scope="row"><label for="cb-contact-office-title"><?php esc_html_e('Section Title', 'central-build'); ?></label></th>
                        <td><input type="text" id="cb-contact-office-title" name="central_build_contact_settings[office][title]" class="regular-text" value="<?php echo esc_attr($settings['office']['title']); ?>" /></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-contact-office-description"><?php esc_html_e('Description', 'central-build'); ?></label></th>
                        <td><textarea id="cb-contact-office-description" name="central_build_contact_settings[office][description]" rows="3" class="large-text"><?php echo esc_textarea($settings['office']['description']); ?></textarea></td>
                    </tr>
                    <tr>
                        <th scope="row"><?php esc_html_e('Office Hours', 'central-build'); ?></th>
                        <td>
                            <?php foreach ($settings['office']['hours'] as $index => $hour) : ?>
                                <div style="display:flex; gap:10px; margin-bottom:5px;">
                                    <input type="text" name="central_build_contact_settings[office][hours][<?php echo esc_attr($index); ?>][label]" value="<?php echo esc_attr($hour['label']); ?>" placeholder="Label" />
                                    <input type="text" name="central_build_contact_settings[office][hours][<?php echo esc_attr($index); ?>][value]" value="<?php echo esc_attr($hour['value']); ?>" placeholder="Value" />
                                </div>
                            <?php endforeach; ?>
                            <div style="display:flex; gap:10px; margin-bottom:5px;">
                                <input type="text" name="central_build_contact_settings[office][hours][][label]" placeholder="Label" />
                                <input type="text" name="central_build_contact_settings[office][hours][][value]" placeholder="Value" />
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-contact-office-image"><?php esc_html_e('Office Image URL', 'central-build'); ?></label></th>
                        <td><input type="text" id="cb-contact-office-image" name="central_build_contact_settings[office][image]" class="large-text" value="<?php echo esc_url($settings['office']['image']); ?>" /></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-contact-office-cta-label"><?php esc_html_e('CTA Label', 'central-build'); ?></label></th>
                        <td><input type="text" id="cb-contact-office-cta-label" name="central_build_contact_settings[office][cta_label]" class="regular-text" value="<?php echo esc_attr($settings['office']['cta_label']); ?>" /></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-contact-office-cta-url"><?php esc_html_e('CTA URL', 'central-build'); ?></label></th>
                        <td><input type="text" id="cb-contact-office-cta-url" name="central_build_contact_settings[office][cta_url]" class="regular-text" value="<?php echo esc_url($settings['office']['cta_url']); ?>" /></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-contact-office-address-title"><?php esc_html_e('Address Title', 'central-build'); ?></label></th>
                        <td><input type="text" id="cb-contact-office-address-title" name="central_build_contact_settings[office][address_title]" class="regular-text" value="<?php echo esc_attr($settings['office']['address_title']); ?>" /></td>
                    </tr>
                    <tr>
                        <th scope="row"><?php esc_html_e('Address Lines', 'central-build'); ?></th>
                        <td>
                            <?php foreach ($settings['office']['address_lines'] as $index => $line) : ?>
                                <input type="text" name="central_build_contact_settings[office][address_lines][<?php echo esc_attr($index); ?>]" class="regular-text" value="<?php echo esc_attr($line); ?>" style="margin-bottom: 5px;" />
                            <?php endforeach; ?>
                            <input type="text" name="central_build_contact_settings[office][address_lines][]" class="regular-text" placeholder="<?php esc_attr_e('Add address line…', 'central-build'); ?>" />
                        </td>
                    </tr>
                </tbody>
            </table>

            <p class="submit">
                <button type="submit" name="central_build_contact_settings_submit" class="button button-primary"><?php esc_html_e('Save Contact Settings', 'central-build'); ?></button>
            </p>
        </form>
    </div>

    <script type="text/template" id="cb-contact-channel-template">
        <div class="central-build-repeatable__item">
            <div class="central-build-repeatable__head">
                <strong><?php esc_html_e('Channel', 'central-build'); ?></strong>
                <button type="button" class="button button-link-delete central-build-repeatable__remove" data-repeatable-remove><?php esc_html_e('Remove', 'central-build'); ?></button>
            </div>
            <div class="central-build-repeatable__body">
                <p>
                    <label>
                        <?php esc_html_e('Title', 'central-build'); ?><br />
                        <input type="text" name="central_build_contact_settings[channels][__INDEX__][title]" class="regular-text" />
                    </label>
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Description', 'central-build'); ?><br />
                        <textarea name="central_build_contact_settings[channels][__INDEX__][description]" rows="3" class="large-text"></textarea>
                    </label>
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Highlight', 'central-build'); ?><br />
                        <input type="text" name="central_build_contact_settings[channels][__INDEX__][highlight]" class="regular-text" />
                    </label>
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Icon Class', 'central-build'); ?><br />
                        <input type="text" name="central_build_contact_settings[channels][__INDEX__][icon]" class="regular-text" placeholder="fas fa-headset" />
                    </label>
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Style', 'central-build'); ?><br />
                        <select name="central_build_contact_settings[channels][__INDEX__][style]">
                            <option value="primary"><?php esc_html_e('Primary', 'central-build'); ?></option>
                            <option value="accent"><?php esc_html_e('Accent', 'central-build'); ?></option>
                            <option value="emergency"><?php esc_html_e('Emergency', 'central-build'); ?></option>
                        </select>
                    </label>
                </p>
                <p>
                    <label>
                        <?php esc_html_e('CTA Label', 'central-build'); ?><br />
                        <input type="text" name="central_build_contact_settings[channels][__INDEX__][cta][label]" class="regular-text" />
                    </label>
                </p>
                <p>
                    <label>
                        <?php esc_html_e('CTA URL', 'central-build'); ?><br />
                        <input type="text" name="central_build_contact_settings[channels][__INDEX__][cta][url]" class="regular-text" />
                    </label>
                </p>
                <p>
                    <label>
                        <?php esc_html_e('CTA Type', 'central-build'); ?><br />
                        <select name="central_build_contact_settings[channels][__INDEX__][cta][type]">
                            <option value="anchor"><?php esc_html_e('Anchor / Button', 'central-build'); ?></option>
                            <option value="tel"><?php esc_html_e('Phone', 'central-build'); ?></option>
                            <option value="mail"><?php esc_html_e('Email', 'central-build'); ?></option>
                        </select>
                    </label>
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Secondary Text', 'central-build'); ?><br />
                        <input type="text" name="central_build_contact_settings[channels][__INDEX__][secondary]" class="regular-text" />
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

function central_build_contact_settings_menu(): void
{
    add_theme_page(
        __('Contact Settings', 'central-build'),
        __('Contact Settings', 'central-build'),
        'manage_options',
        'central-build-contact-settings',
        'central_build_contact_settings_page_render'
    );
}
add_action('admin_menu', 'central_build_contact_settings_menu');
