<?php
if (!defined('ABSPATH')) {
    exit;
}

function central_build_sc_settings_defaults(): array
{
    return array(
        'hero' => array(
            'badge'       => 'Expert Services Coordination',
            'title'       => 'PROJECT CHAOS <span style="color: var(--accent-color);">ENDS HERE.</span>',
            'description' => 'Central Build acts as the single point of control, synchronising all trades—from MEP to specialised fit-outs—to eliminate conflicts, wastage, and delays.',
            'cta'         => array('label' => 'Request a Project Risk Assessment', 'url' => '#contact'),
        ),
        'problems' => array(
            array(
                'icon'        => 'fas fa-exclamation-triangle',
                'title'       => 'Risk of Conflict',
                'description' => 'Unmanaged subcontractors lead to costly clashes between crucial trades on site.',
            ),
            array(
                'icon'        => 'fas fa-clock',
                'title'       => 'Time Wastage',
                'description' => 'Poor sequencing and communication result in re-work, bottlenecks, and critical delays.',
            ),
            array(
                'icon'        => 'fas fa-hand-holding-dollar',
                'title'       => 'Unforeseen Costs',
                'description' => 'Lack of upfront coordination forces expensive variation orders post-construction.',
            ),
        ),
        'methodology' => array(
            array(
                'step'        => '1',
                'icon'        => 'fas fa-laptop-code',
                'title'       => 'BIM-Verified Planning',
                'description' => 'Comprehensive clash detection solves conflicts virtually before any on-site work begins.',
            ),
            array(
                'step'        => '2',
                'icon'        => 'fas fa-tools',
                'title'       => 'In-House Anchor Execution',
                'description' => 'Our internal trades set the quality standard and sequencing pace for every contractor.',
            ),
            array(
                'step'        => '3',
                'icon'        => 'fas fa-headset',
                'title'       => 'Flexible On-Site Monitoring',
                'description' => 'Daily coordination and adaptive management ensure immediate conflict resolution.',
            ),
        ),
        'bim' => array(
            'title'       => 'Precision in Pixels: The Power of BIM',
            'subtitle'    => 'Virtual Conflict Resolution, Real-World Savings.',
            'description' => 'Building Information Modelling (BIM) is our primary risk mitigation tool. We use advanced clash detection to identify and resolve every potential conflict between MEP services, structures, and architectural elements.',
            'image'       => get_template_directory_uri() . '/images/services-coordination-bim.jpg',
            'accordion'   => array(
                array(
                    'heading' => 'How Clash Detection Works',
                    'body'    => 'Before ground breaks, we overlay 3D models of all trades. Where models intersect, we engineer a solution with our BIM team, avoiding destructive re-work on site.',
                ),
            ),
        ),
        'metrics' => array(
            array(
                'number'      => 25,
                'suffix'      => '%',
                'label'       => 'Cost Reduction',
                'description' => 'Average saving on variation orders through proactive coordination.',
            ),
            array(
                'number'      => 95,
                'suffix'      => '%',
                'label'       => 'RFI Volume Reduction',
                'description' => 'Clear direction means fewer requests for information and smoother delivery.',
            ),
            array(
                'number'      => 8,
                'suffix'      => __(' Weeks Saved', 'central-build'),
                'label'       => 'Critical Path Time',
                'description' => 'Optimised sequencing and conflict-free execution accelerate completion.',
            ),
        ),
        'contact' => array(
            'heading'       => 'Unify Your Trades. Secure Your Success.',
            'description'   => 'Stop wasting time and budget on site conflicts. Let Central Build manage the complexity and guarantee a smooth delivery.',
            'contact_line'  => '+1 (123) 456-7890',
            'form_title'    => 'Claim Your Project Control',
            'button_label'  => 'Request Consultation',
        ),
        'show_projects' => true,
    );
}

function central_build_get_sc_settings(): array
{
    $defaults = central_build_sc_settings_defaults();
    $saved    = get_option('central_build_sc_settings', array());

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

    $settings['problems']    = $map_repeatable($settings['problems'] ?? array(), $defaults['problems']);
    $settings['methodology'] = $map_repeatable($settings['methodology'] ?? array(), $defaults['methodology']);
    $settings['metrics']     = $map_repeatable($settings['metrics'] ?? array(), $defaults['metrics']);

    $settings['bim'] = wp_parse_args($settings['bim'] ?? array(), $defaults['bim']);
    $settings['bim']['accordion'] = $map_repeatable($settings['bim']['accordion'] ?? array(), $defaults['bim']['accordion']);

    $settings['contact'] = wp_parse_args($settings['contact'] ?? array(), $defaults['contact']);

    $settings['show_projects'] = !empty($settings['show_projects']);

    return $settings;
}

function central_build_sanitize_sc_settings(array $input): array
{
    $defaults = central_build_sc_settings_defaults();
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
        'badge'       => $sanitize_text($input['hero']['badge'] ?? '', $defaults['hero']['badge']),
        'title'       => $sanitize_rich_text($input['hero']['title'] ?? '', $defaults['hero']['title']),
        'description' => $sanitize_rich_text($input['hero']['description'] ?? '', $defaults['hero']['description']),
        'cta'         => array(
            'label' => $sanitize_text($input['hero']['cta']['label'] ?? '', $defaults['hero']['cta']['label']),
            'url'   => esc_url_raw(wp_unslash($input['hero']['cta']['url'] ?? $defaults['hero']['cta']['url'])),
        ),
    );

    $settings['problems'] = array();
    if (!empty($input['problems']) && is_array($input['problems'])) {
        foreach ($input['problems'] as $problem) {
            $title = $sanitize_text($problem['title'] ?? '');
            $description = $sanitize_rich_text($problem['description'] ?? '');
            if ($title === '' && $description === '') {
                continue;
            }
            $settings['problems'][] = array(
                'icon'        => $sanitize_text($problem['icon'] ?? 'fas fa-circle'),
                'title'       => $title,
                'description' => $description,
            );
        }
    }
    if (empty($settings['problems'])) {
        $settings['problems'] = $defaults['problems'];
    }

    $settings['methodology'] = array();
    if (!empty($input['methodology']) && is_array($input['methodology'])) {
        foreach ($input['methodology'] as $step) {
            $title = $sanitize_text($step['title'] ?? '');
            $description = $sanitize_rich_text($step['description'] ?? '');
            if ($title === '' && $description === '') {
                continue;
            }
            $settings['methodology'][] = array(
                'step'        => $sanitize_text($step['step'] ?? ''),
                'icon'        => $sanitize_text($step['icon'] ?? 'fas fa-circle'),
                'title'       => $title,
                'description' => $description,
            );
        }
    }
    if (empty($settings['methodology'])) {
        $settings['methodology'] = $defaults['methodology'];
    }

    $accordion_items = array();
    if (!empty($input['bim']['accordion']) && is_array($input['bim']['accordion'])) {
        foreach ($input['bim']['accordion'] as $item) {
            $heading = $sanitize_text($item['heading'] ?? '');
            $body    = $sanitize_rich_text($item['body'] ?? '');
            if ($heading === '' && $body === '') {
                continue;
            }
            $accordion_items[] = array(
                'heading' => $heading,
                'body'    => $body,
            );
        }
    }
    if (empty($accordion_items)) {
        $accordion_items = $defaults['bim']['accordion'];
    }

    $settings['bim'] = array(
        'title'       => $sanitize_text($input['bim']['title'] ?? '', $defaults['bim']['title']),
        'subtitle'    => $sanitize_text($input['bim']['subtitle'] ?? '', $defaults['bim']['subtitle']),
        'description' => $sanitize_rich_text($input['bim']['description'] ?? '', $defaults['bim']['description']),
        'image'       => esc_url_raw(wp_unslash($input['bim']['image'] ?? $defaults['bim']['image'])),
        'accordion'   => $accordion_items,
    );

    $settings['metrics'] = array();
    if (!empty($input['metrics']) && is_array($input['metrics'])) {
        foreach ($input['metrics'] as $metric) {
            $label = $sanitize_text($metric['label'] ?? '');
            $description = $sanitize_rich_text($metric['description'] ?? '');
            if ($label === '' && $description === '') {
                continue;
            }
            $settings['metrics'][] = array(
                'number'      => isset($metric['number']) ? (int) $metric['number'] : 0,
                'suffix'      => $sanitize_text($metric['suffix'] ?? ''),
                'label'       => $label,
                'description' => $description,
            );
        }
    }
    if (empty($settings['metrics'])) {
        $settings['metrics'] = $defaults['metrics'];
    }

    $settings['contact'] = array(
        'heading'      => $sanitize_text($input['contact']['heading'] ?? '', $defaults['contact']['heading']),
        'description'  => $sanitize_rich_text($input['contact']['description'] ?? '', $defaults['contact']['description']),
        'contact_line' => $sanitize_text($input['contact']['contact_line'] ?? '', $defaults['contact']['contact_line']),
        'form_title'   => $sanitize_text($input['contact']['form_title'] ?? '', $defaults['contact']['form_title']),
        'button_label' => $sanitize_text($input['contact']['button_label'] ?? '', $defaults['contact']['button_label']),
    );

    $settings['show_projects'] = !empty($input['show_projects']);

    return $settings;
}

function central_build_handle_sc_settings_submit(): void
{
    if (!isset($_POST['central_build_sc_settings_submit'])) {
        return;
    }

    check_admin_referer('central_build_sc_settings');

    $raw = isset($_POST['central_build_sc_settings']) && is_array($_POST['central_build_sc_settings'])
        ? $_POST['central_build_sc_settings']
        : array();

    $sanitized = central_build_sanitize_sc_settings($raw);

    update_option('central_build_sc_settings', $sanitized);

    add_settings_error('central_build_sc_settings', 'central_build_sc_settings_updated', __('Services coordination settings saved successfully.', 'central-build'), 'updated');
}

function central_build_sc_settings_page_render(): void
{
    central_build_handle_sc_settings_submit();

    $settings = central_build_get_sc_settings();
    $messages = get_settings_errors('central_build_sc_settings');
    ?>
    <div class="wrap">
        <h1><?php esc_html_e('Services Coordination Settings', 'central-build'); ?></h1>

        <?php if (!empty($messages)) :
            foreach ($messages as $message) :
                printf('<div class="%1$s"><p>%2$s</p></div>', esc_attr($message['type']), esc_html($message['message']));
            endforeach;
        endif; ?>

        <form method="post" action="">
            <?php wp_nonce_field('central_build_sc_settings'); ?>

            <h2 class="title"><?php esc_html_e('Hero Section', 'central-build'); ?></h2>
            <table class="form-table" role="presentation">
                <tbody>
                    <tr>
                        <th scope="row"><label for="cb-sc-hero-badge"><?php esc_html_e('Badge Text', 'central-build'); ?></label></th>
                        <td><input type="text" id="cb-sc-hero-badge" name="central_build_sc_settings[hero][badge]" class="regular-text" value="<?php echo esc_attr($settings['hero']['badge']); ?>" /></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-sc-hero-title"><?php esc_html_e('Title', 'central-build'); ?></label></th>
                        <td><textarea id="cb-sc-hero-title" name="central_build_sc_settings[hero][title]" rows="3" class="large-text"><?php echo esc_textarea($settings['hero']['title']); ?></textarea></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-sc-hero-description"><?php esc_html_e('Description', 'central-build'); ?></label></th>
                        <td><textarea id="cb-sc-hero-description" name="central_build_sc_settings[hero][description]" rows="3" class="large-text"><?php echo esc_textarea($settings['hero']['description']); ?></textarea></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-sc-hero-cta-label"><?php esc_html_e('CTA Label', 'central-build'); ?></label></th>
                        <td><input type="text" id="cb-sc-hero-cta-label" name="central_build_sc_settings[hero][cta][label]" class="regular-text" value="<?php echo esc_attr($settings['hero']['cta']['label']); ?>" /></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-sc-hero-cta-url"><?php esc_html_e('CTA URL', 'central-build'); ?></label></th>
                        <td><input type="text" id="cb-sc-hero-cta-url" name="central_build_sc_settings[hero][cta][url]" class="regular-text" value="<?php echo esc_url($settings['hero']['cta']['url']); ?>" /></td>
                    </tr>
                </tbody>
            </table>

            <h2 class="title"><?php esc_html_e('Problem Statements', 'central-build'); ?></h2>
            <div class="central-build-repeatable" id="cb-sc-problems">
                <?php foreach ($settings['problems'] as $index => $problem) : ?>
                    <div class="central-build-repeatable__item">
                        <div class="central-build-repeatable__head">
                            <strong><?php printf(esc_html__('Problem %d', 'central-build'), $index + 1); ?></strong>
                            <button type="button" class="button button-link-delete central-build-repeatable__remove" data-repeatable-remove><?php esc_html_e('Remove', 'central-build'); ?></button>
                        </div>
                        <div class="central-build-repeatable__body">
                            <p><label><?php esc_html_e('Icon Class', 'central-build'); ?><br />
                                <input type="text" name="central_build_sc_settings[problems][<?php echo esc_attr($index); ?>][icon]" class="regular-text" value="<?php echo esc_attr($problem['icon']); ?>" placeholder="fas fa-star" /></label></p>
                            <p><label><?php esc_html_e('Title', 'central-build'); ?><br />
                                <input type="text" name="central_build_sc_settings[problems][<?php echo esc_attr($index); ?>][title]" class="regular-text" value="<?php echo esc_attr($problem['title']); ?>" /></label></p>
                            <p><label><?php esc_html_e('Description', 'central-build'); ?><br />
                                <textarea name="central_build_sc_settings[problems][<?php echo esc_attr($index); ?>][description]" rows="3" class="large-text"><?php echo esc_textarea($problem['description']); ?></textarea></label></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="button" class="button" data-repeatable-add data-repeatable-target="cb-sc-problems" data-repeatable-template="cb-sc-problem-template"><?php esc_html_e('Add Problem', 'central-build'); ?></button>

            <h2 class="title"><?php esc_html_e('Methodology Steps', 'central-build'); ?></h2>
            <div class="central-build-repeatable" id="cb-sc-methodology">
                <?php foreach ($settings['methodology'] as $index => $step) : ?>
                    <div class="central-build-repeatable__item">
                        <div class="central-build-repeatable__head">
                            <strong><?php printf(esc_html__('Step %d', 'central-build'), $index + 1); ?></strong>
                            <button type="button" class="button button-link-delete central-build-repeatable__remove" data-repeatable-remove><?php esc_html_e('Remove', 'central-build'); ?></button>
                        </div>
                        <div class="central-build-repeatable__body">
                            <p><label><?php esc_html_e('Step Badge', 'central-build'); ?><br />
                                <input type="text" name="central_build_sc_settings[methodology][<?php echo esc_attr($index); ?>][step]" class="regular-text" value="<?php echo esc_attr($step['step']); ?>" /></label></p>
                            <p><label><?php esc_html_e('Icon Class', 'central-build'); ?><br />
                                <input type="text" name="central_build_sc_settings[methodology][<?php echo esc_attr($index); ?>][icon]" class="regular-text" value="<?php echo esc_attr($step['icon']); ?>" /></label></p>
                            <p><label><?php esc_html_e('Title', 'central-build'); ?><br />
                                <input type="text" name="central_build_sc_settings[methodology][<?php echo esc_attr($index); ?>][title]" class="regular-text" value="<?php echo esc_attr($step['title']); ?>" /></label></p>
                            <p><label><?php esc_html_e('Description', 'central-build'); ?><br />
                                <textarea name="central_build_sc_settings[methodology][<?php echo esc_attr($index); ?>][description]" rows="3" class="large-text"><?php echo esc_textarea($step['description']); ?></textarea></label></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="button" class="button" data-repeatable-add data-repeatable-target="cb-sc-methodology" data-repeatable-template="cb-sc-methodology-template"><?php esc_html_e('Add Step', 'central-build'); ?></button>

            <h2 class="title"><?php esc_html_e('BIM Section', 'central-build'); ?></h2>
            <table class="form-table" role="presentation">
                <tbody>
                    <tr>
                        <th scope="row"><label for="cb-sc-bim-title"><?php esc_html_e('Title', 'central-build'); ?></label></th>
                        <td><input type="text" id="cb-sc-bim-title" name="central_build_sc_settings[bim][title]" class="large-text" value="<?php echo esc_attr($settings['bim']['title']); ?>" /></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-sc-bim-subtitle"><?php esc_html_e('Subtitle', 'central-build'); ?></label></th>
                        <td><input type="text" id="cb-sc-bim-subtitle" name="central_build_sc_settings[bim][subtitle]" class="large-text" value="<?php echo esc_attr($settings['bim']['subtitle']); ?>" /></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-sc-bim-description"><?php esc_html_e('Description', 'central-build'); ?></label></th>
                        <td><textarea id="cb-sc-bim-description" name="central_build_sc_settings[bim][description]" rows="4" class="large-text"><?php echo esc_textarea($settings['bim']['description']); ?></textarea></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-sc-bim-image"><?php esc_html_e('Image URL', 'central-build'); ?></label></th>
                        <td><input type="text" id="cb-sc-bim-image" name="central_build_sc_settings[bim][image]" class="large-text" value="<?php echo esc_url($settings['bim']['image']); ?>" /></td>
                    </tr>
                </tbody>
            </table>
            <div class="central-build-repeatable" id="cb-sc-bim-accordion">
                <?php foreach ($settings['bim']['accordion'] as $index => $item) : ?>
                    <div class="central-build-repeatable__item">
                        <div class="central-build-repeatable__head">
                            <strong><?php printf(esc_html__('Accordion Item %d', 'central-build'), $index + 1); ?></strong>
                            <button type="button" class="button button-link-delete central-build-repeatable__remove" data-repeatable-remove><?php esc_html_e('Remove', 'central-build'); ?></button>
                        </div>
                        <div class="central-build-repeatable__body">
                            <p><label><?php esc_html_e('Heading', 'central-build'); ?><br />
                                <input type="text" name="central_build_sc_settings[bim][accordion][<?php echo esc_attr($index); ?>][heading]" class="regular-text" value="<?php echo esc_attr($item['heading']); ?>" /></label></p>
                            <p><label><?php esc_html_e('Body', 'central-build'); ?><br />
                                <textarea name="central_build_sc_settings[bim][accordion][<?php echo esc_attr($index); ?>][body]" rows="3" class="large-text"><?php echo esc_textarea($item['body']); ?></textarea></label></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="button" class="button" data-repeatable-add data-repeatable-target="cb-sc-bim-accordion" data-repeatable-template="cb-sc-bim-accordion-template"><?php esc_html_e('Add Accordion Item', 'central-build'); ?></button>

            <h2 class="title"><?php esc_html_e('Metrics', 'central-build'); ?></h2>
            <div class="central-build-repeatable" id="cb-sc-metrics">
                <?php foreach ($settings['metrics'] as $index => $metric) : ?>
                    <div class="central-build-repeatable__item">
                        <div class="central-build-repeatable__head">
                            <strong><?php printf(esc_html__('Metric %d', 'central-build'), $index + 1); ?></strong>
                            <button type="button" class="button button-link-delete central-build-repeatable__remove" data-repeatable-remove><?php esc_html_e('Remove', 'central-build'); ?></button>
                        </div>
                        <div class="central-build-repeatable__body">
                            <p><label><?php esc_html_e('Number', 'central-build'); ?><br />
                                <input type="number" name="central_build_sc_settings[metrics][<?php echo esc_attr($index); ?>][number]" value="<?php echo esc_attr($metric['number']); ?>" /></label></p>
                            <p><label><?php esc_html_e('Suffix', 'central-build'); ?><br />
                                <input type="text" name="central_build_sc_settings[metrics][<?php echo esc_attr($index); ?>][suffix]" class="regular-text" value="<?php echo esc_attr($metric['suffix']); ?>" /></label></p>
                            <p><label><?php esc_html_e('Label', 'central-build'); ?><br />
                                <input type="text" name="central_build_sc_settings[metrics][<?php echo esc_attr($index); ?>][label]" class="regular-text" value="<?php echo esc_attr($metric['label']); ?>" /></label></p>
                            <p><label><?php esc_html_e('Description', 'central-build'); ?><br />
                                <textarea name="central_build_sc_settings[metrics][<?php echo esc_attr($index); ?>][description]" rows="3" class="large-text"><?php echo esc_textarea($metric['description']); ?></textarea></label></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="button" class="button" data-repeatable-add data-repeatable-target="cb-sc-metrics" data-repeatable-template="cb-sc-metric-template"><?php esc_html_e('Add Metric', 'central-build'); ?></button>

            <h2 class="title"><?php esc_html_e('Contact Block', 'central-build'); ?></h2>
            <table class="form-table" role="presentation">
                <tbody>
                    <tr>
                        <th scope="row"><label for="cb-sc-contact-heading"><?php esc_html_e('Heading', 'central-build'); ?></label></th>
                        <td><input type="text" id="cb-sc-contact-heading" name="central_build_sc_settings[contact][heading]" class="large-text" value="<?php echo esc_attr($settings['contact']['heading']); ?>" /></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-sc-contact-description"><?php esc_html_e('Description', 'central-build'); ?></label></th>
                        <td><textarea id="cb-sc-contact-description" name="central_build_sc_settings[contact][description]" rows="3" class="large-text"><?php echo esc_textarea($settings['contact']['description']); ?></textarea></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-sc-contact-line"><?php esc_html_e('Contact Line', 'central-build'); ?></label></th>
                        <td><input type="text" id="cb-sc-contact-line" name="central_build_sc_settings[contact][contact_line]" class="regular-text" value="<?php echo esc_attr($settings['contact']['contact_line']); ?>" /></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-sc-contact-form-title"><?php esc_html_e('Form Title', 'central-build'); ?></label></th>
                        <td><input type="text" id="cb-sc-contact-form-title" name="central_build_sc_settings[contact][form_title]" class="regular-text" value="<?php echo esc_attr($settings['contact']['form_title']); ?>" /></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-sc-contact-button"><?php esc_html_e('Button Label', 'central-build'); ?></label></th>
                        <td><input type="text" id="cb-sc-contact-button" name="central_build_sc_settings[contact][button_label]" class="regular-text" value="<?php echo esc_attr($settings['contact']['button_label']); ?>" /></td>
                    </tr>
                </tbody>
            </table>

            <h2 class="title"><?php esc_html_e('Projects Section', 'central-build'); ?></h2>
            <p>
                <label>
                    <input type="checkbox" name="central_build_sc_settings[show_projects]" value="1" <?php checked($settings['show_projects']); ?> />
                    <?php esc_html_e('Display fitout projects grid below the content.', 'central-build'); ?>
                </label>
            </p>

            <p class="submit">
                <button type="submit" name="central_build_sc_settings_submit" class="button button-primary"><?php esc_html_e('Save Settings', 'central-build'); ?></button>
            </p>
        </form>
    </div>

    <script type="text/template" id="cb-sc-problem-template">
        <div class="central-build-repeatable__item">
            <div class="central-build-repeatable__head">
                <strong><?php esc_html_e('Problem', 'central-build'); ?></strong>
                <button type="button" class="button button-link-delete central-build-repeatable__remove" data-repeatable-remove><?php esc_html_e('Remove', 'central-build'); ?></button>
            </div>
            <div class="central-build-repeatable__body">
                <p><label><?php esc_html_e('Icon Class', 'central-build'); ?><br />
                    <input type="text" name="central_build_sc_settings[problems][__INDEX__][icon]" class="regular-text" /></label></p>
                <p><label><?php esc_html_e('Title', 'central-build'); ?><br />
                    <input type="text" name="central_build_sc_settings[problems][__INDEX__][title]" class="regular-text" /></label></p>
                <p><label><?php esc_html_e('Description', 'central-build'); ?><br />
                    <textarea name="central_build_sc_settings[problems][__INDEX__][description]" rows="3" class="large-text"></textarea></label></p>
            </div>
        </div>
    </script>

    <script type="text/template" id="cb-sc-methodology-template">
        <div class="central-build-repeatable__item">
            <div class="central-build-repeatable__head">
                <strong><?php esc_html_e('Step', 'central-build'); ?></strong>
                <button type="button" class="button button-link-delete central-build-repeatable__remove" data-repeatable-remove><?php esc_html_e('Remove', 'central-build'); ?></button>
            </div>
            <div class="central-build-repeatable__body">
                <p><label><?php esc_html_e('Step Badge', 'central-build'); ?><br />
                    <input type="text" name="central_build_sc_settings[methodology][__INDEX__][step]" class="regular-text" /></label></p>
                <p><label><?php esc_html_e('Icon Class', 'central-build'); ?><br />
                    <input type="text" name="central_build_sc_settings[methodology][__INDEX__][icon]" class="regular-text" /></label></p>
                <p><label><?php esc_html_e('Title', 'central-build'); ?><br />
                    <input type="text" name="central_build_sc_settings[methodology][__INDEX__][title]" class="regular-text" /></label></p>
                <p><label><?php esc_html_e('Description', 'central-build'); ?><br />
                    <textarea name="central_build_sc_settings[methodology][__INDEX__][description]" rows="3" class="large-text"></textarea></label></p>
            </div>
        </div>
    </script>

    <script type="text/template" id="cb-sc-bim-accordion-template">
        <div class="central-build-repeatable__item">
            <div class="central-build-repeatable__head">
                <strong><?php esc_html_e('Accordion Item', 'central-build'); ?></strong>
                <button type="button" class="button button-link-delete central-build-repeatable__remove" data-repeatable-remove><?php esc_html_e('Remove', 'central-build'); ?></button>
            </div>
            <div class="central-build-repeatable__body">
                <p><label><?php esc_html_e('Heading', 'central-build'); ?><br />
                    <input type="text" name="central_build_sc_settings[bim][accordion][__INDEX__][heading]" class="regular-text" /></label></p>
                <p><label><?php esc_html_e('Body', 'central-build'); ?><br />
                    <textarea name="central_build_sc_settings[bim][accordion][__INDEX__][body]" rows="3" class="large-text"></textarea></label></p>
            </div>
        </div>
    </script>

    <script type="text/template" id="cb-sc-metric-template">
        <div class="central-build-repeatable__item">
            <div class="central-build-repeatable__head">
                <strong><?php esc_html_e('Metric', 'central-build'); ?></strong>
                <button type="button" class="button button-link-delete central-build-repeatable__remove" data-repeatable-remove><?php esc_html_e('Remove', 'central-build'); ?></button>
            </div>
            <div class="central-build-repeatable__body">
                <p><label><?php esc_html_e('Number', 'central-build'); ?><br />
                    <input type="number" name="central_build_sc_settings[metrics][__INDEX__][number]" /></label></p>
                <p><label><?php esc_html_e('Suffix', 'central-build'); ?><br />
                    <input type="text" name="central_build_sc_settings[metrics][__INDEX__][suffix]" class="regular-text" /></label></p>
                <p><label><?php esc_html_e('Label', 'central-build'); ?><br />
                    <input type="text" name="central_build_sc_settings[metrics][__INDEX__][label]" class="regular-text" /></label></p>
                <p><label><?php esc_html_e('Description', 'central-build'); ?><br />
                    <textarea name="central_build_sc_settings[metrics][__INDEX__][description]" rows="3" class="large-text"></textarea></label></p>
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

function central_build_sc_settings_menu(): void
{
    add_theme_page(
        __('Services Coordination', 'central-build'),
        __('Services Coordination', 'central-build'),
        'manage_options',
        'central-build-sc-settings',
        'central_build_sc_settings_page_render'
    );
}
add_action('admin_menu', 'central_build_sc_settings_menu');
