<?php
if (!defined('ABSPATH')) {
    exit;
}

function central_build_rm_settings_defaults(): array
{
    return array(
        'hero' => array(
            'title'       => 'YOUR BUSINESS CONTINUITY. <span style="color: var(--accent-color);">OUR PRIORITY.</span>',
            'subtitle'    => 'Commercial Repairs &amp; Maintenance: rapid response, lasting solutions.',
            'description' => 'When critical faults occur or preventative maintenance is due, Central Build provides the reliable, professional service you need to keep your operations running smoothly.',
            'background'  => get_template_directory_uri() . '/images/repairs-hero.jpg',
            'primary_cta' => array('label' => 'Call Emergency Service (24/7)', 'url' => 'tel:+11234567890'),
            'secondary_cta' => array('label' => 'Request Scheduled Maintenance', 'url' => '#contact'),
        ),
        'guarantee' => array(
            array(
                'icon'        => 'fas fa-headset',
                'title'       => 'Rapid Response (24/7)',
                'tagline'     => 'Guaranteed contact within 60 minutes.',
                'description' => 'We minimise operational downtime with our dedicated, round-the-clock emergency support line.',
            ),
            array(
                'icon'        => 'fas fa-tools',
                'title'       => 'Lasting Solutions',
                'tagline'     => 'Licensed, in-house expertise.',
                'description' => 'Repairs performed by our skilled, licensed trades for permanent fixes, not just temporary patches.',
            ),
            array(
                'icon'        => 'fas fa-calendar-check',
                'title'       => 'Warranty & Follow-Up',
                'tagline'     => 'Strong service guarantee.',
                'description' => 'Repairs are backed by warranty, transparent reporting, and preventative advice to stop repeat issues.',
            ),
        ),
        'expertise' => array(
            array('icon' => 'fas fa-bolt',          'title' => 'Electrical Faults',          'description' => 'Wiring, switchboards, lighting failure, and power outage resolution.'),
            array('icon' => 'fas fa-faucet',        'title' => 'Plumbing Emergencies',       'description' => 'Leaks, burst pipes, drainage issues, and commercial hot water systems.'),
            array('icon' => 'fas fa-paint-roller',  'title' => 'General Building Repairs',   'description' => 'Walls, flooring, ceilings, locks, and general wear-and-tear remediation.'),
            array('icon' => 'fas fa-calendar-alt',  'title' => 'Preventative Maintenance',   'description' => 'Scheduled compliance checks and asset lifespan maintenance (HVAC, fire systems).'),
        ),
        'model' => array(
            array('icon' => 'fas fa-phone-volume', 'title' => '1. Call & Report',      'description' => 'Client reports fault via dedicated 24/7 line and receives immediate prioritisation.'),
            array('icon' => 'fas fa-route',        'title' => '2. Dispatch & ETA',     'description' => 'Nearest specialised team dispatched with ETA provided within 60 minutes.'),
            array('icon' => 'fas fa-toolbox',      'title' => '3. Diagnose & Repair',  'description' => 'On-site diagnosis and immediate implementation of a permanent, compliant fix.'),
            array('icon' => 'fas fa-file-invoice', 'title' => '4. Close & Report',     'description' => 'Digital reporting on resolution, cost breakdown, and preventative next steps.'),
        ),
        'partnership' => array(
            'heading'     => 'Beyond the Fix: Proactive Maintenance.',
            'description' => 'Transition from reactive repairs to a strategic, proactive maintenance partnership for long-term stability and cost predictability.',
            'cta_label'   => 'Switch to a Maintenance Contract',
            'cta_url'     => '#contact',
            'items'       => array(
                array('icon' => 'fas fa-dollar-sign',    'title' => 'Cost Predictability',     'description' => 'Fixed annual fee structure for budget certainty and planned expenditure.'),
                array('icon' => 'fas fa-certificate',    'title' => 'Compliance Assurance',    'description' => 'Scheduled checks to automatically meet strict regulatory and insurance requirements.'),
                array('icon' => 'fas fa-chart-line',     'title' => 'Asset Lifespan Extension','description' => 'Proactively extending the life of critical plant and equipment (HVAC, fire systems).'),
            ),
        ),
        'contact' => array(
            'heading'       => 'Failures happen. Downtime is optional.',
            'description'   => 'Partner with Central Build today for guaranteed responsiveness and peace of mind.',
            'contact_line'  => '+1 (123) 456-7890',
            'form_title'    => 'Get a Maintenance Quote',
            'button_label'  => 'Submit Request',
            'service_options' => array('Emergency Service', 'Scheduled Maintenance Contract', 'General Repair Quote'),
        ),
        'show_projects' => true,
    );
}

function central_build_get_rm_settings(): array
{
    $defaults = central_build_rm_settings_defaults();
    $saved    = get_option('central_build_rm_settings', array());

    $settings = wp_parse_args(is_array($saved) ? $saved : array(), $defaults);

    $settings['hero'] = wp_parse_args($settings['hero'] ?? array(), $defaults['hero']);
    $settings['hero']['primary_cta']   = wp_parse_args($settings['hero']['primary_cta'] ?? array(), $defaults['hero']['primary_cta']);
    $settings['hero']['secondary_cta'] = wp_parse_args($settings['hero']['secondary_cta'] ?? array(), $defaults['hero']['secondary_cta']);

    $map_repeatable = static function ($items, $fallback) {
        $result = array();
        if (is_array($items)) {
            foreach ($items as $item) {
                if (is_array($item)) {
                    $result[] = $item;
                }
            }
        }
        if (empty($result)) {
            $result = $fallback;
        }
        return $result;
    };

    $settings['guarantee']  = $map_repeatable($settings['guarantee'] ?? array(), $defaults['guarantee']);
    $settings['expertise']  = $map_repeatable($settings['expertise'] ?? array(), $defaults['expertise']);
    $settings['model']      = $map_repeatable($settings['model'] ?? array(), $defaults['model']);

    $settings['partnership'] = wp_parse_args($settings['partnership'] ?? array(), $defaults['partnership']);
    $settings['partnership']['items'] = $map_repeatable($settings['partnership']['items'] ?? array(), $defaults['partnership']['items']);

    $settings['contact'] = wp_parse_args($settings['contact'] ?? array(), $defaults['contact']);
    $options = array();
    if (!empty($settings['contact']['service_options']) && is_array($settings['contact']['service_options'])) {
        foreach ($settings['contact']['service_options'] as $option) {
            $option = is_string($option) ? trim(wp_unslash($option)) : '';
            if ($option !== '') {
                $options[] = $option;
            }
        }
    }
    if (empty($options)) {
        $options = $defaults['contact']['service_options'];
    }
    $settings['contact']['service_options'] = $options;

    $settings['show_projects'] = !empty($settings['show_projects']);

    return $settings;
}

function central_build_sanitize_rm_settings(array $input): array
{
    $defaults = central_build_rm_settings_defaults();
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
        'title'        => $sanitize_rich_text($input['hero']['title'] ?? '', $defaults['hero']['title']),
        'subtitle'     => $sanitize_text($input['hero']['subtitle'] ?? '', $defaults['hero']['subtitle']),
        'description'  => $sanitize_rich_text($input['hero']['description'] ?? '', $defaults['hero']['description']),
        'background'   => esc_url_raw(wp_unslash($input['hero']['background'] ?? $defaults['hero']['background'])),
        'primary_cta'  => array(
            'label' => $sanitize_text($input['hero']['primary_cta']['label'] ?? '', $defaults['hero']['primary_cta']['label']),
            'url'   => esc_url_raw(wp_unslash($input['hero']['primary_cta']['url'] ?? $defaults['hero']['primary_cta']['url'])),
        ),
        'secondary_cta' => array(
            'label' => $sanitize_text($input['hero']['secondary_cta']['label'] ?? '', $defaults['hero']['secondary_cta']['label']),
            'url'   => esc_url_raw(wp_unslash($input['hero']['secondary_cta']['url'] ?? $defaults['hero']['secondary_cta']['url'])),
        ),
    );

    $settings['guarantee'] = array();
    if (!empty($input['guarantee']) && is_array($input['guarantee'])) {
        foreach ($input['guarantee'] as $item) {
            $title = $sanitize_text($item['title'] ?? '');
            $description = $sanitize_rich_text($item['description'] ?? '');
            if ($title === '' && $description === '') {
                continue;
            }
            $settings['guarantee'][] = array(
                'icon'        => $sanitize_text($item['icon'] ?? 'fas fa-circle'),
                'title'       => $title,
                'tagline'     => $sanitize_text($item['tagline'] ?? ''),
                'description' => $description,
            );
        }
    }
    if (empty($settings['guarantee'])) {
        $settings['guarantee'] = $defaults['guarantee'];
    }

    $settings['expertise'] = array();
    if (!empty($input['expertise']) && is_array($input['expertise'])) {
        foreach ($input['expertise'] as $tile) {
            $title = $sanitize_text($tile['title'] ?? '');
            $description = $sanitize_rich_text($tile['description'] ?? '');
            if ($title === '' && $description === '') {
                continue;
            }
            $settings['expertise'][] = array(
                'icon'        => $sanitize_text($tile['icon'] ?? 'fas fa-circle'),
                'title'       => $title,
                'description' => $description,
            );
        }
    }
    if (empty($settings['expertise'])) {
        $settings['expertise'] = $defaults['expertise'];
    }

    $settings['model'] = array();
    if (!empty($input['model']) && is_array($input['model'])) {
        foreach ($input['model'] as $step) {
            $title = $sanitize_text($step['title'] ?? '');
            $description = $sanitize_rich_text($step['description'] ?? '');
            if ($title === '' && $description === '') {
                continue;
            }
            $settings['model'][] = array(
                'icon'        => $sanitize_text($step['icon'] ?? 'fas fa-circle'),
                'title'       => $title,
                'description' => $description,
            );
        }
    }
    if (empty($settings['model'])) {
        $settings['model'] = $defaults['model'];
    }

    $items = array();
    if (!empty($input['partnership']['items']) && is_array($input['partnership']['items'])) {
        foreach ($input['partnership']['items'] as $item) {
            $title = $sanitize_text($item['title'] ?? '');
            $description = $sanitize_rich_text($item['description'] ?? '');
            if ($title === '' && $description === '') {
                continue;
            }
            $items[] = array(
                'icon'        => $sanitize_text($item['icon'] ?? 'fas fa-circle'),
                'title'       => $title,
                'description' => $description,
            );
        }
    }
    if (empty($items)) {
        $items = $defaults['partnership']['items'];
    }

    $settings['partnership'] = array(
        'heading'     => $sanitize_text($input['partnership']['heading'] ?? '', $defaults['partnership']['heading']),
        'description' => $sanitize_rich_text($input['partnership']['description'] ?? '', $defaults['partnership']['description']),
        'cta_label'   => $sanitize_text($input['partnership']['cta_label'] ?? '', $defaults['partnership']['cta_label']),
        'cta_url'     => esc_url_raw(wp_unslash($input['partnership']['cta_url'] ?? $defaults['partnership']['cta_url'])),
        'items'       => $items,
    );

    $service_options = array();
    if (!empty($input['contact']['service_options']) && is_array($input['contact']['service_options'])) {
        foreach ($input['contact']['service_options'] as $option) {
            $option = $sanitize_text($option, '');
            if ($option !== '') {
                $service_options[] = $option;
            }
        }
    }
    if (empty($service_options)) {
        $service_options = $defaults['contact']['service_options'];
    }

    $settings['contact'] = array(
        'heading'       => $sanitize_rich_text($input['contact']['heading'] ?? '', $defaults['contact']['heading']),
        'description'   => $sanitize_rich_text($input['contact']['description'] ?? '', $defaults['contact']['description']),
        'contact_line'  => $sanitize_text($input['contact']['contact_line'] ?? '', $defaults['contact']['contact_line']),
        'form_title'    => $sanitize_text($input['contact']['form_title'] ?? '', $defaults['contact']['form_title']),
        'button_label'  => $sanitize_text($input['contact']['button_label'] ?? '', $defaults['contact']['button_label']),
        'service_options' => $service_options,
    );

    $settings['show_projects'] = !empty($input['show_projects']);

    return $settings;
}

function central_build_handle_rm_settings_submit(): void
{
    if (!isset($_POST['central_build_rm_settings_submit'])) {
        return;
    }

    check_admin_referer('central_build_rm_settings');

    $raw = isset($_POST['central_build_rm_settings']) && is_array($_POST['central_build_rm_settings'])
        ? $_POST['central_build_rm_settings']
        : array();

    $sanitized = central_build_sanitize_rm_settings($raw);

    update_option('central_build_rm_settings', $sanitized);

    add_settings_error('central_build_rm_settings', 'central_build_rm_settings_updated', __('Repairs & maintenance settings saved successfully.', 'central-build'), 'updated');
}

function central_build_rm_settings_page_render(): void
{
    central_build_handle_rm_settings_submit();

    $settings = central_build_get_rm_settings();
    $messages = get_settings_errors('central_build_rm_settings');
    ?>
    <div class="wrap">
        <h1><?php esc_html_e('Repairs & Maintenance Settings', 'central-build'); ?></h1>

        <?php if (!empty($messages)) :
            foreach ($messages as $message) :
                printf('<div class="%1$s"><p>%2$s</p></div>', esc_attr($message['type']), esc_html($message['message']));
            endforeach;
        endif; ?>

        <form method="post" action="">
            <?php wp_nonce_field('central_build_rm_settings'); ?>

            <h2 class="title"><?php esc_html_e('Hero Section', 'central-build'); ?></h2>
            <table class="form-table" role="presentation">
                <tbody>
                    <tr>
                        <th scope="row"><label for="cb-rm-hero-title"><?php esc_html_e('Title', 'central-build'); ?></label></th>
                        <td><textarea id="cb-rm-hero-title" name="central_build_rm_settings[hero][title]" rows="2" class="large-text"><?php echo esc_textarea($settings['hero']['title']); ?></textarea></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-rm-hero-subtitle"><?php esc_html_e('Subtitle', 'central-build'); ?></label></th>
                        <td><input type="text" id="cb-rm-hero-subtitle" name="central_build_rm_settings[hero][subtitle]" class="large-text" value="<?php echo esc_attr($settings['hero']['subtitle']); ?>" /></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-rm-hero-description"><?php esc_html_e('Description', 'central-build'); ?></label></th>
                        <td><textarea id="cb-rm-hero-description" name="central_build_rm_settings[hero][description]" rows="3" class="large-text"><?php echo esc_textarea($settings['hero']['description']); ?></textarea></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-rm-hero-background"><?php esc_html_e('Background Image URL', 'central-build'); ?></label></th>
                        <td><input type="text" id="cb-rm-hero-background" name="central_build_rm_settings[hero][background]" class="large-text" value="<?php echo esc_url($settings['hero']['background']); ?>" /></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-rm-hero-primary-label"><?php esc_html_e('Primary CTA Label', 'central-build'); ?></label></th>
                        <td><input type="text" id="cb-rm-hero-primary-label" name="central_build_rm_settings[hero][primary_cta][label]" class="regular-text" value="<?php echo esc_attr($settings['hero']['primary_cta']['label']); ?>" /></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-rm-hero-primary-url"><?php esc_html_e('Primary CTA URL', 'central-build'); ?></label></th>
                        <td><input type="text" id="cb-rm-hero-primary-url" name="central_build_rm_settings[hero][primary_cta][url]" class="regular-text" value="<?php echo esc_url($settings['hero']['primary_cta']['url']); ?>" /></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-rm-hero-secondary-label"><?php esc_html_e('Secondary CTA Label', 'central-build'); ?></label></th>
                        <td><input type="text" id="cb-rm-hero-secondary-label" name="central_build_rm_settings[hero][secondary_cta][label]" class="regular-text" value="<?php echo esc_attr($settings['hero']['secondary_cta']['label']); ?>" /></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-rm-hero-secondary-url"><?php esc_html_e('Secondary CTA URL', 'central-build'); ?></label></th>
                        <td><input type="text" id="cb-rm-hero-secondary-url" name="central_build_rm_settings[hero][secondary_cta][url]" class="regular-text" value="<?php echo esc_url($settings['hero']['secondary_cta']['url']); ?>" /></td>
                    </tr>
                </tbody>
            </table>

            <h2 class="title"><?php esc_html_e('Guarantee Boxes', 'central-build'); ?></h2>
            <div class="central-build-repeatable" id="cb-rm-guarantee">
                <?php foreach ($settings['guarantee'] as $index => $item) : ?>
                    <div class="central-build-repeatable__item">
                        <div class="central-build-repeatable__head">
                            <strong><?php printf(esc_html__('Guarantee %d', 'central-build'), $index + 1); ?></strong>
                            <button type="button" class="button button-link-delete central-build-repeatable__remove" data-repeatable-remove><?php esc_html_e('Remove', 'central-build'); ?></button>
                        </div>
                        <div class="central-build-repeatable__body">
                            <p><label><?php esc_html_e('Icon Class', 'central-build'); ?><br />
                                <input type="text" name="central_build_rm_settings[guarantee][<?php echo esc_attr($index); ?>][icon]" class="regular-text" value="<?php echo esc_attr($item['icon']); ?>" /></label></p>
                            <p><label><?php esc_html_e('Title', 'central-build'); ?><br />
                                <input type="text" name="central_build_rm_settings[guarantee][<?php echo esc_attr($index); ?>][title]" class="regular-text" value="<?php echo esc_attr($item['title']); ?>" /></label></p>
                            <p><label><?php esc_html_e('Tagline', 'central-build'); ?><br />
                                <input type="text" name="central_build_rm_settings[guarantee][<?php echo esc_attr($index); ?>][tagline]" class="regular-text" value="<?php echo esc_attr($item['tagline']); ?>" /></label></p>
                            <p><label><?php esc_html_e('Description', 'central-build'); ?><br />
                                <textarea name="central_build_rm_settings[guarantee][<?php echo esc_attr($index); ?>][description]" rows="3" class="large-text"><?php echo esc_textarea($item['description']); ?></textarea></label></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="button" class="button" data-repeatable-add data-repeatable-target="cb-rm-guarantee" data-repeatable-template="cb-rm-guarantee-template"><?php esc_html_e('Add Guarantee Box', 'central-build'); ?></button>

            <h2 class="title"><?php esc_html_e('Expertise Tiles', 'central-build'); ?></h2>
            <div class="central-build-repeatable" id="cb-rm-expertise">
                <?php foreach ($settings['expertise'] as $index => $tile) : ?>
                    <div class="central-build-repeatable__item">
                        <div class="central-build-repeatable__head">
                            <strong><?php printf(esc_html__('Tile %d', 'central-build'), $index + 1); ?></strong>
                            <button type="button" class="button button-link-delete central-build-repeatable__remove" data-repeatable-remove><?php esc_html_e('Remove', 'central-build'); ?></button>
                        </div>
                        <div class="central-build-repeatable__body">
                            <p><label><?php esc_html_e('Icon Class', 'central-build'); ?><br />
                                <input type="text" name="central_build_rm_settings[expertise][<?php echo esc_attr($index); ?>][icon]" class="regular-text" value="<?php echo esc_attr($tile['icon']); ?>" /></label></p>
                            <p><label><?php esc_html_e('Title', 'central-build'); ?><br />
                                <input type="text" name="central_build_rm_settings[expertise][<?php echo esc_attr($index); ?>][title]" class="regular-text" value="<?php echo esc_attr($tile['title']); ?>" /></label></p>
                            <p><label><?php esc_html_e('Description', 'central-build'); ?><br />
                                <textarea name="central_build_rm_settings[expertise][<?php echo esc_attr($index); ?>][description]" rows="3" class="large-text"><?php echo esc_textarea($tile['description']); ?></textarea></label></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="button" class="button" data-repeatable-add data-repeatable-target="cb-rm-expertise" data-repeatable-template="cb-rm-expertise-template"><?php esc_html_e('Add Expertise Tile', 'central-build'); ?></button>

            <h2 class="title"><?php esc_html_e('Rapid Response Model', 'central-build'); ?></h2>
            <div class="central-build-repeatable" id="cb-rm-model">
                <?php foreach ($settings['model'] as $index => $step) : ?>
                    <div class="central-build-repeatable__item">
                        <div class="central-build-repeatable__head">
                            <strong><?php printf(esc_html__('Step %d', 'central-build'), $index + 1); ?></strong>
                            <button type="button" class="button button-link-delete central-build-repeatable__remove" data-repeatable-remove><?php esc_html_e('Remove', 'central-build'); ?></button>
                        </div>
                        <div class="central-build-repeatable__body">
                            <p><label><?php esc_html_e('Icon Class', 'central-build'); ?><br />
                                <input type="text" name="central_build_rm_settings[model][<?php echo esc_attr($index); ?>][icon]" class="regular-text" value="<?php echo esc_attr($step['icon']); ?>" /></label></p>
                            <p><label><?php esc_html_e('Title', 'central-build'); ?><br />
                                <input type="text" name="central_build_rm_settings[model][<?php echo esc_attr($index); ?>][title]" class="regular-text" value="<?php echo esc_attr($step['title']); ?>" /></label></p>
                            <p><label><?php esc_html_e('Description', 'central-build'); ?><br />
                                <textarea name="central_build_rm_settings[model][<?php echo esc_attr($index); ?>][description]" rows="3" class="large-text"><?php echo esc_textarea($step['description']); ?></textarea></label></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="button" class="button" data-repeatable-add data-repeatable-target="cb-rm-model" data-repeatable-template="cb-rm-model-template"><?php esc_html_e('Add Model Step', 'central-build'); ?></button>

            <h2 class="title"><?php esc_html_e('Proactive Maintenance Partnership', 'central-build'); ?></h2>
            <table class="form-table" role="presentation">
                <tbody>
                    <tr>
                        <th scope="row"><label for="cb-rm-partnership-heading"><?php esc_html_e('Heading', 'central-build'); ?></label></th>
                        <td><input type="text" id="cb-rm-partnership-heading" name="central_build_rm_settings[partnership][heading]" class="large-text" value="<?php echo esc_attr($settings['partnership']['heading']); ?>" /></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-rm-partnership-description"><?php esc_html_e('Description', 'central-build'); ?></label></th>
                        <td><textarea id="cb-rm-partnership-description" name="central_build_rm_settings[partnership][description]" rows="3" class="large-text"><?php echo esc_textarea($settings['partnership']['description']); ?></textarea></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-rm-partnership-cta-label"><?php esc_html_e('CTA Label', 'central-build'); ?></label></th>
                        <td><input type="text" id="cb-rm-partnership-cta-label" name="central_build_rm_settings[partnership][cta_label]" class="regular-text" value="<?php echo esc_attr($settings['partnership']['cta_label']); ?>" /></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-rm-partnership-cta-url"><?php esc_html_e('CTA URL', 'central-build'); ?></label></th>
                        <td><input type="text" id="cb-rm-partnership-cta-url" name="central_build_rm_settings[partnership][cta_url]" class="regular-text" value="<?php echo esc_url($settings['partnership']['cta_url']); ?>" /></td>
                    </tr>
                </tbody>
            </table>
            <div class="central-build-repeatable" id="cb-rm-partnership-items">
                <?php foreach ($settings['partnership']['items'] as $index => $item) : ?>
                    <div class="central-build-repeatable__item">
                        <div class="central-build-repeatable__head">
                            <strong><?php printf(esc_html__('Benefit %d', 'central-build'), $index + 1); ?></strong>
                            <button type="button" class="button button-link-delete central-build-repeatable__remove" data-repeatable-remove><?php esc_html_e('Remove', 'central-build'); ?></button>
                        </div>
                        <div class="central-build-repeatable__body">
                            <p><label><?php esc_html_e('Icon Class', 'central-build'); ?><br />
                                <input type="text" name="central_build_rm_settings[partnership][items][<?php echo esc_attr($index); ?>][icon]" class="regular-text" value="<?php echo esc_attr($item['icon']); ?>" /></label></p>
                            <p><label><?php esc_html_e('Title', 'central-build'); ?><br />
                                <input type="text" name="central_build_rm_settings[partnership][items][<?php echo esc_attr($index); ?>][title]" class="regular-text" value="<?php echo esc_attr($item['title']); ?>" /></label></p>
                            <p><label><?php esc_html_e('Description', 'central-build'); ?><br />
                                <textarea name="central_build_rm_settings[partnership][items][<?php echo esc_attr($index); ?>][description]" rows="3" class="large-text"><?php echo esc_textarea($item['description']); ?></textarea></label></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="button" class="button" data-repeatable-add data-repeatable-target="cb-rm-partnership-items" data-repeatable-template="cb-rm-partnership-template"><?php esc_html_e('Add Partnership Item', 'central-build'); ?></button>

            <h2 class="title"><?php esc_html_e('Contact Section', 'central-build'); ?></h2>
            <table class="form-table" role="presentation">
                <tbody>
                    <tr>
                        <th scope="row"><label for="cb-rm-contact-heading"><?php esc_html_e('Heading', 'central-build'); ?></label></th>
                        <td><textarea id="cb-rm-contact-heading" name="central_build_rm_settings[contact][heading]" rows="2" class="large-text"><?php echo esc_textarea($settings['contact']['heading']); ?></textarea></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-rm-contact-description"><?php esc_html_e('Description', 'central-build'); ?></label></th>
                        <td><textarea id="cb-rm-contact-description" name="central_build_rm_settings[contact][description]" rows="3" class="large-text"><?php echo esc_textarea($settings['contact']['description']); ?></textarea></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-rm-contact-line"><?php esc_html_e('Contact Line', 'central-build'); ?></label></th>
                        <td><input type="text" id="cb-rm-contact-line" name="central_build_rm_settings[contact][contact_line]" class="regular-text" value="<?php echo esc_attr($settings['contact']['contact_line']); ?>" /></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-rm-contact-form-title"><?php esc_html_e('Form Title', 'central-build'); ?></label></th>
                        <td><input type="text" id="cb-rm-contact-form-title" name="central_build_rm_settings[contact][form_title]" class="regular-text" value="<?php echo esc_attr($settings['contact']['form_title']); ?>" /></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-rm-contact-button"><?php esc_html_e('Button Label', 'central-build'); ?></label></th>
                        <td><input type="text" id="cb-rm-contact-button" name="central_build_rm_settings[contact][button_label]" class="regular-text" value="<?php echo esc_attr($settings['contact']['button_label']); ?>" /></td>
                    </tr>
                    <tr>
                        <th scope="row"><?php esc_html_e('Service Options', 'central-build'); ?></th>
                        <td>
                            <?php foreach ($settings['contact']['service_options'] as $index => $option) : ?>
                                <input type="text" name="central_build_rm_settings[contact][service_options][<?php echo esc_attr($index); ?>]" class="regular-text" value="<?php echo esc_attr($option); ?>" style="margin-bottom:6px;" />
                            <?php endforeach; ?>
                            <input type="text" name="central_build_rm_settings[contact][service_options][]" class="regular-text" placeholder="<?php esc_attr_e('Add option…', 'central-build'); ?>" />
                        </td>
                    </tr>
                </tbody>
            </table>

            <h2 class="title"><?php esc_html_e('Projects Section', 'central-build'); ?></h2>
            <p>
                <label>
                    <input type="checkbox" name="central_build_rm_settings[show_projects]" value="1" <?php checked($settings['show_projects']); ?> />
                    <?php esc_html_e('Display fitout projects grid below the content.', 'central-build'); ?>
                </label>
            </p>

            <p class="submit">
                <button type="submit" name="central_build_rm_settings_submit" class="button button-primary"><?php esc_html_e('Save Settings', 'central-build'); ?></button>
            </p>
        </form>
    </div>

    <script type="text/template" id="cb-rm-guarantee-template">
        <div class="central-build-repeatable__item">
            <div class="central-build-repeatable__head">
                <strong><?php esc_html_e('Guarantee', 'central-build'); ?></strong>
                <button type="button" class="button button-link-delete central-build-repeatable__remove" data-repeatable-remove><?php esc_html_e('Remove', 'central-build'); ?></button>
            </div>
            <div class="central-build-repeatable__body">
                <p><label><?php esc_html_e('Icon Class', 'central-build'); ?><br />
                    <input type="text" name="central_build_rm_settings[guarantee][__INDEX__][icon]" class="regular-text" /></label></p>
                <p><label><?php esc_html_e('Title', 'central-build'); ?><br />
                    <input type="text" name="central_build_rm_settings[guarantee][__INDEX__][title]" class="regular-text" /></label></p>
                <p><label><?php esc_html_e('Tagline', 'central-build'); ?><br />
                    <input type="text" name="central_build_rm_settings[guarantee][__INDEX__][tagline]" class="regular-text" /></label></p>
                <p><label><?php esc_html_e('Description', 'central-build'); ?><br />
                    <textarea name="central_build_rm_settings[guarantee][__INDEX__][description]" rows="3" class="large-text"></textarea></label></p>
            </div>
        </div>
    </script>

    <script type="text/template" id="cb-rm-expertise-template">
        <div class="central-build-repeatable__item">
            <div class="central-build-repeatable__head">
                <strong><?php esc_html_e('Expertise Tile', 'central-build'); ?></strong>
                <button type="button" class="button button-link-delete central-build-repeatable__remove" data-repeatable-remove><?php esc_html_e('Remove', 'central-build'); ?></button>
            </div>
            <div class="central-build-repeatable__body">
                <p><label><?php esc_html_e('Icon Class', 'central-build'); ?><br />
                    <input type="text" name="central_build_rm_settings[expertise][__INDEX__][icon]" class="regular-text" /></label></p>
                <p><label><?php esc_html_e('Title', 'central-build'); ?><br />
                    <input type="text" name="central_build_rm_settings[expertise][__INDEX__][title]" class="regular-text" /></label></p>
                <p><label><?php esc_html_e('Description', 'central-build'); ?><br />
                    <textarea name="central_build_rm_settings[expertise][__INDEX__][description]" rows="3" class="large-text"></textarea></label></p>
            </div>
        </div>
    </script>

    <script type="text/template" id="cb-rm-model-template">
        <div class="central-build-repeatable__item">
            <div class="central-build-repeatable__head">
                <strong><?php esc_html_e('Model Step', 'central-build'); ?></strong>
                <button type="button" class="button button-link-delete central-build-repeatable__remove" data-repeatable-remove><?php esc_html_e('Remove', 'central-build'); ?></button>
            </div>
            <div class="central-build-repeatable__body">
                <p><label><?php esc_html_e('Icon Class', 'central-build'); ?><br />
                    <input type="text" name="central_build_rm_settings[model][__INDEX__][icon]" class="regular-text" /></label></p>
                <p><label><?php esc_html_e('Title', 'central-build'); ?><br />
                    <input type="text" name="central_build_rm_settings[model][__INDEX__][title]" class="regular-text" /></label></p>
                <p><label><?php esc_html_e('Description', 'central-build'); ?><br />
                    <textarea name="central_build_rm_settings[model][__INDEX__][description]" rows="3" class="large-text"></textarea></label></p>
            </div>
        </div>
    </script>

    <script type="text/template" id="cb-rm-partnership-template">
        <div class="central-build-repeatable__item">
            <div class="central-build-repeatable__head">
                <strong><?php esc_html_e('Partnership Item', 'central-build'); ?></strong>
                <button type="button" class="button button-link-delete central-build-repeatable__remove" data-repeatable-remove><?php esc_html_e('Remove', 'central-build'); ?></button>
            </div>
            <div class="central-build-repeatable__body">
                <p><label><?php esc_html_e('Icon Class', 'central-build'); ?><br />
                    <input type="text" name="central_build_rm_settings[partnership][items][__INDEX__][icon]" class="regular-text" /></label></p>
                <p><label><?php esc_html_e('Title', 'central-build'); ?><br />
                    <input type="text" name="central_build_rm_settings[partnership][items][__INDEX__][title]" class="regular-text" /></label></p>
                <p><label><?php esc_html_e('Description', 'central-build'); ?><br />
                    <textarea name="central_build_rm_settings[partnership][items][__INDEX__][description]" rows="3" class="large-text"></textarea></label></p>
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

function central_build_rm_settings_menu(): void
{
    add_theme_page(
        __('Repairs & Maintenance', 'central-build'),
        __('Repairs & Maintenance', 'central-build'),
        'manage_options',
        'central-build-rm-settings',
        'central_build_rm_settings_page_render'
    );
}
add_action('admin_menu', 'central_build_rm_settings_menu');
