<?php
if (!defined('ABSPATH')) {
    exit;
}

function central_build_cs_settings_defaults(): array
{
    return array(
        'hero' => array(
            'title'       => 'Zero Debris. Zero Delays. <span style="color: var(--accent-color);">Zero Risk.</span>',
            'subtitle'    => 'Commercial Stripouts: preparing your perfect foundation.',
            'description' => 'Central Build specialises in controlled, compliant, and efficient commercial stripouts, ensuring your space is ready for Phase II fit-out without compromises on safety or timeline.',
            'cta'         => array('label' => 'Get a Fast & Compliant Quote', 'url' => '#contact'),
            'background'  => get_template_directory_uri() . '/images/stripout-hero.jpg',
        ),
        'promise' => array(
            array(
                'icon'        => 'fas fa-route',
                'title'       => 'Process',
                'subtitle'    => 'Strict Protocol',
                'description' => 'Documented steps for site protection, waste segregation, and crucial structural integrity checks.',
            ),
            array(
                'icon'        => 'fas fa-bullseye',
                'title'       => 'Precision',
                'subtitle'    => 'Selective Demolition',
                'description' => 'Surgical removal that preserves non-target elements and base building services.',
            ),
            array(
                'icon'        => 'fas fa-tachometer-alt',
                'title'       => 'Performance',
                'subtitle'    => 'Rapid Turnaround',
                'description' => 'Specialised teams minimise disruption to surrounding tenants for high-speed delivery.',
            ),
        ),
        'safety' => array(
            array(
                'icon'        => 'fas fa-first-aid',
                'title'       => 'Hazard Mitigation',
                'description' => 'Comprehensive assessment and removal of hazardous materials by certified partners.',
            ),
            array(
                'icon'        => 'fas fa-warehouse',
                'title'       => 'Site Protection',
                'description' => 'Dust control, noise dampening, and shoring to protect base building and adjacent tenants.',
            ),
            array(
                'icon'        => 'fas fa-clipboard-check',
                'title'       => 'Compliance Audit',
                'description' => 'Post-stripout certification confirming readiness for the next phase.',
            ),
        ),
        'technical' => array(
            'heading'      => 'The Stripout Edge: Precision & Sustainability',
            'introduction' => 'Our services go beyond simple demolition. We focus on two key areas that set up your project for success:',
            'cards'        => array(
                array(
                    'title'       => 'Selective Demolition Expertise',
                    'description' => 'We strip the tenant space back to the condition you require without compromising base services or core structures.',
                ),
                array(
                    'title'       => 'Advanced Waste Management',
                    'description' => 'All stripout materials are segregated for high-rate recycling with documented disposal trails.',
                ),
            ),
        ),
        'scale' => array(
            'heading'     => 'Ready for Any Scale. Any Complexity.',
            'subtitle'    => 'Scalable solutions, guaranteed.',
            'description' => 'We leverage specialised equipment suited for internal commercial environments. From 50 m² to 5,000 m², we deliver with precision and efficiency.',
            'images'      => array(
                get_template_directory_uri() . '/images/stripout-equipment-1.jpg',
                get_template_directory_uri() . '/images/stripout-equipment-2.jpg',
                get_template_directory_uri() . '/images/stripout-equipment-3.jpg',
            ),
            'cta_label'   => 'See Our Capabilities',
            'cta_url'     => '#contact',
        ),
        'contact' => array(
            'title'        => 'Your fit-out begins with a perfect stripout.',
            'description'  => 'Secure a safe, clean, and certified space for your next construction phase. We guarantee compliance and readiness.',
            'contact_line' => '+1 (123) 456-7890',
            'form_title'   => 'Request a Clean Slate Quote',
            'button_label' => 'Get Started Now',
        ),
        'show_projects' => true,
    );
}

function central_build_get_cs_settings(): array
{
    $defaults = central_build_cs_settings_defaults();
    $saved    = get_option('central_build_cs_settings', array());

    $settings = wp_parse_args(is_array($saved) ? $saved : array(), $defaults);

    $settings['hero'] = wp_parse_args($settings['hero'] ?? array(), $defaults['hero']);
    $settings['hero']['cta'] = wp_parse_args($settings['hero']['cta'] ?? array(), $defaults['hero']['cta']);

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

    $settings['promise']  = $map_repeatable($settings['promise'] ?? array(), $defaults['promise']);
    $settings['safety']   = $map_repeatable($settings['safety'] ?? array(), $defaults['safety']);
    $settings['technical'] = wp_parse_args($settings['technical'] ?? array(), $defaults['technical']);
    $settings['technical']['cards'] = $map_repeatable($settings['technical']['cards'] ?? array(), $defaults['technical']['cards']);
    $settings['scale']    = wp_parse_args($settings['scale'] ?? array(), $defaults['scale']);
    $settings['scale']['images'] = array_values(array_filter($settings['scale']['images'] ?? array(), 'strlen')) ?: $defaults['scale']['images'];
    $settings['contact']  = wp_parse_args($settings['contact'] ?? array(), $defaults['contact']);
    $settings['show_projects'] = !empty($settings['show_projects']);

    return $settings;
}

function central_build_sanitize_cs_settings(array $input): array
{
    $defaults = central_build_cs_settings_defaults();
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
        'subtitle'    => $sanitize_text($input['hero']['subtitle'] ?? '', $defaults['hero']['subtitle']),
        'description' => $sanitize_rich_text($input['hero']['description'] ?? '', $defaults['hero']['description']),
        'background'  => esc_url_raw(wp_unslash($input['hero']['background'] ?? $defaults['hero']['background'])),
        'cta'         => array(
            'label' => $sanitize_text($input['hero']['cta']['label'] ?? '', $defaults['hero']['cta']['label']),
            'url'   => esc_url_raw(wp_unslash($input['hero']['cta']['url'] ?? $defaults['hero']['cta']['url'])),
        ),
    );

    $settings['promise'] = array();
    if (!empty($input['promise']) && is_array($input['promise'])) {
        foreach ($input['promise'] as $item) {
            $title = $sanitize_text($item['title'] ?? '');
            $description = $sanitize_rich_text($item['description'] ?? '');
            if ($title === '' && $description === '') {
                continue;
            }
            $settings['promise'][] = array(
                'icon'        => $sanitize_text($item['icon'] ?? 'fas fa-circle'),
                'title'       => $title,
                'subtitle'    => $sanitize_text($item['subtitle'] ?? ''),
                'description' => $description,
            );
        }
    }
    if (empty($settings['promise'])) {
        $settings['promise'] = $defaults['promise'];
    }

    $settings['safety'] = array();
    if (!empty($input['safety']) && is_array($input['safety'])) {
        foreach ($input['safety'] as $step) {
            $title = $sanitize_text($step['title'] ?? '');
            $description = $sanitize_rich_text($step['description'] ?? '');
            if ($title === '' && $description === '') {
                continue;
            }
            $settings['safety'][] = array(
                'icon'        => $sanitize_text($step['icon'] ?? 'fas fa-circle'),
                'title'       => $title,
                'description' => $description,
            );
        }
    }
    if (empty($settings['safety'])) {
        $settings['safety'] = $defaults['safety'];
    }

    $cards = array();
    if (!empty($input['technical']['cards']) && is_array($input['technical']['cards'])) {
        foreach ($input['technical']['cards'] as $card) {
            $title = $sanitize_text($card['title'] ?? '');
            $description = $sanitize_rich_text($card['description'] ?? '');
            if ($title === '' && $description === '') {
                continue;
            }
            $cards[] = array('title' => $title, 'description' => $description);
        }
    }
    if (empty($cards)) {
        $cards = $defaults['technical']['cards'];
    }

    $settings['technical'] = array(
        'heading'      => $sanitize_text($input['technical']['heading'] ?? '', $defaults['technical']['heading']),
        'introduction' => $sanitize_rich_text($input['technical']['introduction'] ?? '', $defaults['technical']['introduction']),
        'cards'        => $cards,
    );

    $images = array();
    if (!empty($input['scale']['images']) && is_array($input['scale']['images'])) {
        foreach ($input['scale']['images'] as $image) {
            $image_url = esc_url_raw(wp_unslash($image));
            if ($image_url !== '') {
                $images[] = $image_url;
            }
        }
    }
    if (empty($images)) {
        $images = $defaults['scale']['images'];
    }

    $settings['scale'] = array(
        'heading'     => $sanitize_text($input['scale']['heading'] ?? '', $defaults['scale']['heading']),
        'subtitle'    => $sanitize_text($input['scale']['subtitle'] ?? '', $defaults['scale']['subtitle']),
        'description' => $sanitize_rich_text($input['scale']['description'] ?? '', $defaults['scale']['description']),
        'images'      => $images,
        'cta_label'   => $sanitize_text($input['scale']['cta_label'] ?? '', $defaults['scale']['cta_label']),
        'cta_url'     => esc_url_raw(wp_unslash($input['scale']['cta_url'] ?? $defaults['scale']['cta_url'])),
    );

    $settings['contact'] = array(
        'title'        => $sanitize_rich_text($input['contact']['title'] ?? '', $defaults['contact']['title']),
        'description'  => $sanitize_rich_text($input['contact']['description'] ?? '', $defaults['contact']['description']),
        'contact_line' => $sanitize_text($input['contact']['contact_line'] ?? '', $defaults['contact']['contact_line']),
        'form_title'   => $sanitize_text($input['contact']['form_title'] ?? '', $defaults['contact']['form_title']),
        'button_label' => $sanitize_text($input['contact']['button_label'] ?? '', $defaults['contact']['button_label']),
    );

    $settings['show_projects'] = !empty($input['show_projects']);

    return $settings;
}

function central_build_handle_cs_settings_submit(): void
{
    if (!isset($_POST['central_build_cs_settings_submit'])) {
        return;
    }

    check_admin_referer('central_build_cs_settings');

    $raw = isset($_POST['central_build_cs_settings']) && is_array($_POST['central_build_cs_settings'])
        ? $_POST['central_build_cs_settings']
        : array();

    $sanitized = central_build_sanitize_cs_settings($raw);

    update_option('central_build_cs_settings', $sanitized);

    add_settings_error('central_build_cs_settings', 'central_build_cs_settings_updated', __('Commercial stripout settings saved successfully.', 'central-build'), 'updated');
}

function central_build_cs_settings_page_render(): void
{
    central_build_handle_cs_settings_submit();

    $settings = central_build_get_cs_settings();
    $messages = get_settings_errors('central_build_cs_settings');
    ?>
    <div class="wrap">
        <h1><?php esc_html_e('Commercial Stripout Settings', 'central-build'); ?></h1>

        <?php if (!empty($messages)) :
            foreach ($messages as $message) :
                printf('<div class="%1$s"><p>%2$s</p></div>', esc_attr($message['type']), esc_html($message['message']));
            endforeach;
        endif; ?>

        <form method="post" action="">
            <?php wp_nonce_field('central_build_cs_settings'); ?>

            <h2 class="title"><?php esc_html_e('Hero Section', 'central-build'); ?></h2>
            <table class="form-table" role="presentation">
                <tbody>
                    <tr>
                        <th scope="row"><label for="cb-cs-hero-title"><?php esc_html_e('Title', 'central-build'); ?></label></th>
                        <td><textarea id="cb-cs-hero-title" name="central_build_cs_settings[hero][title]" rows="2" class="large-text"><?php echo esc_textarea($settings['hero']['title']); ?></textarea></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-cs-hero-subtitle"><?php esc_html_e('Subtitle', 'central-build'); ?></label></th>
                        <td><input type="text" id="cb-cs-hero-subtitle" name="central_build_cs_settings[hero][subtitle]" class="large-text" value="<?php echo esc_attr($settings['hero']['subtitle']); ?>" /></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-cs-hero-description"><?php esc_html_e('Description', 'central-build'); ?></label></th>
                        <td><textarea id="cb-cs-hero-description" name="central_build_cs_settings[hero][description]" rows="3" class="large-text"><?php echo esc_textarea($settings['hero']['description']); ?></textarea></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-cs-hero-background"><?php esc_html_e('Background Image URL', 'central-build'); ?></label></th>
                        <td><input type="text" id="cb-cs-hero-background" name="central_build_cs_settings[hero][background]" class="large-text" value="<?php echo esc_url($settings['hero']['background']); ?>" /></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-cs-hero-cta-label"><?php esc_html_e('CTA Label', 'central-build'); ?></label></th>
                        <td><input type="text" id="cb-cs-hero-cta-label" name="central_build_cs_settings[hero][cta][label]" class="regular-text" value="<?php echo esc_attr($settings['hero']['cta']['label']); ?>" /></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-cs-hero-cta-url"><?php esc_html_e('CTA URL', 'central-build'); ?></label></th>
                        <td><input type="text" id="cb-cs-hero-cta-url" name="central_build_cs_settings[hero][cta][url]" class="regular-text" value="<?php echo esc_url($settings['hero']['cta']['url']); ?>" /></td>
                    </tr>
                </tbody>
            </table>

            <h2 class="title"><?php esc_html_e('Core Promise Boxes', 'central-build'); ?></h2>
            <div class="central-build-repeatable" id="cb-cs-promise">
                <?php foreach ($settings['promise'] as $index => $item) : ?>
                    <div class="central-build-repeatable__item">
                        <div class="central-build-repeatable__head">
                            <strong><?php printf(esc_html__('Promise %d', 'central-build'), $index + 1); ?></strong>
                            <button type="button" class="button button-link-delete central-build-repeatable__remove" data-repeatable-remove><?php esc_html_e('Remove', 'central-build'); ?></button>
                        </div>
                        <div class="central-build-repeatable__body">
                            <p><label><?php esc_html_e('Icon Class', 'central-build'); ?><br />
                                <input type="text" name="central_build_cs_settings[promise][<?php echo esc_attr($index); ?>][icon]" class="regular-text" value="<?php echo esc_attr($item['icon']); ?>" /></label></p>
                            <p><label><?php esc_html_e('Title', 'central-build'); ?><br />
                                <input type="text" name="central_build_cs_settings[promise][<?php echo esc_attr($index); ?>][title]" class="regular-text" value="<?php echo esc_attr($item['title']); ?>" /></label></p>
                            <p><label><?php esc_html_e('Subtitle', 'central-build'); ?><br />
                                <input type="text" name="central_build_cs_settings[promise][<?php echo esc_attr($index); ?>][subtitle]" class="regular-text" value="<?php echo esc_attr($item['subtitle']); ?>" /></label></p>
                            <p><label><?php esc_html_e('Description', 'central-build'); ?><br />
                                <textarea name="central_build_cs_settings[promise][<?php echo esc_attr($index); ?>][description]" rows="3" class="large-text"><?php echo esc_textarea($item['description']); ?></textarea></label></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="button" class="button" data-repeatable-add data-repeatable-target="cb-cs-promise" data-repeatable-template="cb-cs-promise-template"><?php esc_html_e('Add Promise Box', 'central-build'); ?></button>

            <h2 class="title"><?php esc_html_e('Safety Steps', 'central-build'); ?></h2>
            <div class="central-build-repeatable" id="cb-cs-safety">
                <?php foreach ($settings['safety'] as $index => $step) : ?>
                    <div class="central-build-repeatable__item">
                        <div class="central-build-repeatable__head">
                            <strong><?php printf(esc_html__('Safety Step %d', 'central-build'), $index + 1); ?></strong>
                            <button type="button" class="button button-link-delete central-build-repeatable__remove" data-repeatable-remove><?php esc_html_e('Remove', 'central-build'); ?></button>
                        </div>
                        <div class="central-build-repeatable__body">
                            <p><label><?php esc_html_e('Icon Class', 'central-build'); ?><br />
                                <input type="text" name="central_build_cs_settings[safety][<?php echo esc_attr($index); ?>][icon]" class="regular-text" value="<?php echo esc_attr($step['icon']); ?>" /></label></p>
                            <p><label><?php esc_html_e('Title', 'central-build'); ?><br />
                                <input type="text" name="central_build_cs_settings[safety][<?php echo esc_attr($index); ?>][title]" class="regular-text" value="<?php echo esc_attr($step['title']); ?>" /></label></p>
                            <p><label><?php esc_html_e('Description', 'central-build'); ?><br />
                                <textarea name="central_build_cs_settings[safety][<?php echo esc_attr($index); ?>][description]" rows="3" class="large-text"><?php echo esc_textarea($step['description']); ?></textarea></label></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="button" class="button" data-repeatable-add data-repeatable-target="cb-cs-safety" data-repeatable-template="cb-cs-safety-template"><?php esc_html_e('Add Safety Step', 'central-build'); ?></button>

            <h2 class="title"><?php esc_html_e('Technical Differentiators', 'central-build'); ?></h2>
            <table class="form-table" role="presentation">
                <tbody>
                    <tr>
                        <th scope="row"><label for="cb-cs-technical-heading"><?php esc_html_e('Heading', 'central-build'); ?></label></th>
                        <td><input type="text" id="cb-cs-technical-heading" name="central_build_cs_settings[technical][heading]" class="large-text" value="<?php echo esc_attr($settings['technical']['heading']); ?>" /></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-cs-technical-intro"><?php esc_html_e('Introduction', 'central-build'); ?></label></th>
                        <td><textarea id="cb-cs-technical-intro" name="central_build_cs_settings[technical][introduction]" rows="3" class="large-text"><?php echo esc_textarea($settings['technical']['introduction']); ?></textarea></td>
                    </tr>
                </tbody>
            </table>
            <div class="central-build-repeatable" id="cb-cs-technical-cards">
                <?php foreach ($settings['technical']['cards'] as $index => $card) : ?>
                    <div class="central-build-repeatable__item">
                        <div class="central-build-repeatable__head">
                            <strong><?php printf(esc_html__('Card %d', 'central-build'), $index + 1); ?></strong>
                            <button type="button" class="button button-link-delete central-build-repeatable__remove" data-repeatable-remove><?php esc_html_e('Remove', 'central-build'); ?></button>
                        </div>
                        <div class="central-build-repeatable__body">
                            <p><label><?php esc_html_e('Title', 'central-build'); ?><br />
                                <input type="text" name="central_build_cs_settings[technical][cards][<?php echo esc_attr($index); ?>][title]" class="regular-text" value="<?php echo esc_attr($card['title']); ?>" /></label></p>
                            <p><label><?php esc_html_e('Description', 'central-build'); ?><br />
                                <textarea name="central_build_cs_settings[technical][cards][<?php echo esc_attr($index); ?>][description]" rows="3" class="large-text"><?php echo esc_textarea($card['description']); ?></textarea></label></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="button" class="button" data-repeatable-add data-repeatable-target="cb-cs-technical-cards" data-repeatable-template="cb-cs-technical-template"><?php esc_html_e('Add Technical Card', 'central-build'); ?></button>

            <h2 class="title"><?php esc_html_e('Scale & Capability', 'central-build'); ?></h2>
            <table class="form-table" role="presentation">
                <tbody>
                    <tr>
                        <th scope="row"><label for="cb-cs-scale-heading"><?php esc_html_e('Heading', 'central-build'); ?></label></th>
                        <td><input type="text" id="cb-cs-scale-heading" name="central_build_cs_settings[scale][heading]" class="large-text" value="<?php echo esc_attr($settings['scale']['heading']); ?>" /></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-cs-scale-subtitle"><?php esc_html_e('Subtitle', 'central-build'); ?></label></th>
                        <td><input type="text" id="cb-cs-scale-subtitle" name="central_build_cs_settings[scale][subtitle]" class="large-text" value="<?php echo esc_attr($settings['scale']['subtitle']); ?>" /></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-cs-scale-description"><?php esc_html_e('Description', 'central-build'); ?></label></th>
                        <td><textarea id="cb-cs-scale-description" name="central_build_cs_settings[scale][description]" rows="3" class="large-text"><?php echo esc_textarea($settings['scale']['description']); ?></textarea></td>
                    </tr>
                    <tr>
                        <th scope="row"><?php esc_html_e('Image URLs', 'central-build'); ?></th>
                        <td>
                            <?php foreach ($settings['scale']['images'] as $index => $image) : ?>
                                <input type="text" name="central_build_cs_settings[scale][images][<?php echo esc_attr($index); ?>]" class="large-text" value="<?php echo esc_url($image); ?>" style="margin-bottom:6px;" />
                            <?php endforeach; ?>
                            <input type="text" name="central_build_cs_settings[scale][images][]" class="large-text" placeholder="<?php esc_attr_e('Add image URL…', 'central-build'); ?>" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-cs-scale-cta-label"><?php esc_html_e('CTA Label', 'central-build'); ?></label></th>
                        <td><input type="text" id="cb-cs-scale-cta-label" name="central_build_cs_settings[scale][cta_label]" class="regular-text" value="<?php echo esc_attr($settings['scale']['cta_label']); ?>" /></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-cs-scale-cta-url"><?php esc_html_e('CTA URL', 'central-build'); ?></label></th>
                        <td><input type="text" id="cb-cs-scale-cta-url" name="central_build_cs_settings[scale][cta_url]" class="regular-text" value="<?php echo esc_url($settings['scale']['cta_url']); ?>" /></td>
                    </tr>
                </tbody>
            </table>

            <h2 class="title"><?php esc_html_e('Contact Section', 'central-build'); ?></h2>
            <table class="form-table" role="presentation">
                <tbody>
                    <tr>
                        <th scope="row"><label for="cb-cs-contact-title"><?php esc_html_e('Heading', 'central-build'); ?></label></th>
                        <td><textarea id="cb-cs-contact-title" name="central_build_cs_settings[contact][title]" rows="2" class="large-text"><?php echo esc_textarea($settings['contact']['title']); ?></textarea></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-cs-contact-description"><?php esc_html_e('Description', 'central-build'); ?></label></th>
                        <td><textarea id="cb-cs-contact-description" name="central_build_cs_settings[contact][description]" rows="3" class="large-text"><?php echo esc_textarea($settings['contact']['description']); ?></textarea></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-cs-contact-line"><?php esc_html_e('Contact Line', 'central-build'); ?></label></th>
                        <td><input type="text" id="cb-cs-contact-line" name="central_build_cs_settings[contact][contact_line]" class="regular-text" value="<?php echo esc_attr($settings['contact']['contact_line']); ?>" /></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-cs-contact-form-title"><?php esc_html_e('Form Title', 'central-build'); ?></label></th>
                        <td><input type="text" id="cb-cs-contact-form-title" name="central_build_cs_settings[contact][form_title]" class="regular-text" value="<?php echo esc_attr($settings['contact']['form_title']); ?>" /></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-cs-contact-button"><?php esc_html_e('Button Label', 'central-build'); ?></label></th>
                        <td><input type="text" id="cb-cs-contact-button" name="central_build_cs_settings[contact][button_label]" class="regular-text" value="<?php echo esc_attr($settings['contact']['button_label']); ?>" /></td>
                    </tr>
                </tbody>
            </table>

            <h2 class="title"><?php esc_html_e('Projects Section', 'central-build'); ?></h2>
            <p>
                <label>
                    <input type="checkbox" name="central_build_cs_settings[show_projects]" value="1" <?php checked($settings['show_projects']); ?> />
                    <?php esc_html_e('Display fitout projects grid below the content.', 'central-build'); ?>
                </label>
            </p>

            <p class="submit">
                <button type="submit" name="central_build_cs_settings_submit" class="button button-primary"><?php esc_html_e('Save Settings', 'central-build'); ?></button>
            </p>
        </form>
    </div>

    <script type="text/template" id="cb-cs-promise-template">
        <div class="central-build-repeatable__item">
            <div class="central-build-repeatable__head">
                <strong><?php esc_html_e('Promise', 'central-build'); ?></strong>
                <button type="button" class="button button-link-delete central-build-repeatable__remove" data-repeatable-remove><?php esc_html_e('Remove', 'central-build'); ?></button>
            </div>
            <div class="central-build-repeatable__body">
                <p><label><?php esc_html_e('Icon Class', 'central-build'); ?><br />
                    <input type="text" name="central_build_cs_settings[promise][__INDEX__][icon]" class="regular-text" /></label></p>
                <p><label><?php esc_html_e('Title', 'central-build'); ?><br />
                    <input type="text" name="central_build_cs_settings[promise][__INDEX__][title]" class="regular-text" /></label></p>
                <p><label><?php esc_html_e('Subtitle', 'central-build'); ?><br />
                    <input type="text" name="central_build_cs_settings[promise][__INDEX__][subtitle]" class="regular-text" /></label></p>
                <p><label><?php esc_html_e('Description', 'central-build'); ?><br />
                    <textarea name="central_build_cs_settings[promise][__INDEX__][description]" rows="3" class="large-text"></textarea></label></p>
            </div>
        </div>
    </script>

    <script type="text/template" id="cb-cs-safety-template">
        <div class="central-build-repeatable__item">
            <div class="central-build-repeatable__head">
                <strong><?php esc_html_e('Safety Step', 'central-build'); ?></strong>
                <button type="button" class="button button-link-delete central-build-repeatable__remove" data-repeatable-remove><?php esc_html_e('Remove', 'central-build'); ?></button>
            </div>
            <div class="central-build-repeatable__body">
                <p><label><?php esc_html_e('Icon Class', 'central-build'); ?><br />
                    <input type="text" name="central_build_cs_settings[safety][__INDEX__][icon]" class="regular-text" /></label></p>
                <p><label><?php esc_html_e('Title', 'central-build'); ?><br />
                    <input type="text" name="central_build_cs_settings[safety][__INDEX__][title]" class="regular-text" /></label></p>
                <p><label><?php esc_html_e('Description', 'central-build'); ?><br />
                    <textarea name="central_build_cs_settings[safety][__INDEX__][description]" rows="3" class="large-text"></textarea></label></p>
            </div>
        </div>
    </script>

    <script type="text/template" id="cb-cs-technical-template">
        <div class="central-build-repeatable__item">
            <div class="central-build-repeatable__head">
                <strong><?php esc_html_e('Technical Card', 'central-build'); ?></strong>
                <button type="button" class="button button-link-delete central-build-repeatable__remove" data-repeatable-remove><?php esc_html_e('Remove', 'central-build'); ?></button>
            </div>
            <div class="central-build-repeatable__body">
                <p><label><?php esc_html_e('Title', 'central-build'); ?><br />
                    <input type="text" name="central_build_cs_settings[technical][cards][__INDEX__][title]" class="regular-text" /></label></p>
                <p><label><?php esc_html_e('Description', 'central-build'); ?><br />
                    <textarea name="central_build_cs_settings[technical][cards][__INDEX__][description]" rows="3" class="large-text"></textarea></label></p>
            </div>
        </div>
    </script>

    <style>
        .central-build-repeatable { margin: 0 0 1.5rem; }
        .central-build-repeatable__item { border: 1px solid #dcdcde; border-radius: 4px; padding: 1rem; margin-bottom: 1rem; background: #fff; }
        .central-build-repeatable__head { display: flex; align-items: center; justify-content: space_between; margin-bottom: .75rem; }
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

function central_build_cs_settings_menu(): void
{
    add_theme_page(
        __('Commercial Stripout', 'central-build'),
        __('Commercial Stripout', 'central-build'),
        'manage_options',
        'central-build-cs-settings',
        'central_build_cs_settings_page_render'
    );
}
add_action('admin_menu', 'central_build_cs_settings_menu');
