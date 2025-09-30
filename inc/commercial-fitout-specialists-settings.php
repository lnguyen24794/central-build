<?php
if (!defined('ABSPATH')) {
    exit;
}

function central_build_cfs_settings_defaults(): array
{
    return array(
        'hero' => array(
            'badge'        => 'Commercial Fitout Specialists',
            'title'        => "STOP DELAYS. <br> START BUILDING <span style=\"color: var(--accent-color);\">VALUE.</span>",
            'description'  => 'We eliminate the pitfalls of traditional construction – conflict, budget creep, and delays – through our 100% Secured and In-House delivery model.',
            'cta'          => array('label' => 'Calculate Your Project Time & Cost', 'url' => '#contact'),
            'background'   => get_template_directory_uri() . '/images/fitout-specialists-hero.jpg',
        ),
        'stats' => array(
            array('icon' => 'fas fa-check-circle', 'number' => 50, 'suffix' => '', 'label' => 'Successful Projects Delivered'),
            array('icon' => 'fas fa-percent', 'number' => 98, 'suffix' => '%', 'label' => 'Client Satisfaction Rate'),
            array('icon' => 'fas fa-shield-alt', 'number' => 1, 'suffix' => __(' REG. Builder', 'central-build'), 'label' => 'Certified Commercial Builder'),
        ),
        'pillars' => array(
            array(
                'title'       => 'Precision Engineering',
                'heading'     => '100% Secured Delivery',
                'description' => 'Meticulous attention to detail with full compliance across design, safety, and quality. Being a registered commercial builder means every phase is fully secured, minimizing risk and maximising lasting value.',
            ),
            array(
                'title'       => 'Vertical Integration',
                'heading'     => 'The In-House Advantage',
                'description' => 'Full control over timeline and workmanship with our in-house trades and BIM coordination. Minimal friction, superior finish quality, and faster execution.',
            ),
            array(
                'title'       => 'Client-Centric Flexibility',
                'heading'     => 'Adaptable & Transparent Management',
                'description' => 'Upfront pricing with no hidden costs. Flexible management that adapts to change, delivering faster while protecting budgets and schedules.',
            ),
        ),
        'inhouse' => array(
            array(
                'icon'        => 'fas fa-faucet',
                'title'       => 'Plumbing Experts',
                'description' => 'Specialised Central Build plumbers ensure flawless integration of critical water systems for F&B and retail fitouts.',
                'image'       => get_template_directory_uri() . '/images/fitout-plumbing.jpg',
            ),
            array(
                'icon'        => 'fas fa-bolt',
                'title'       => 'Electrical Specialists',
                'description' => 'Electrical teams coordinate with BIM plans to handle complex power layouts safely and efficiently for modern office spaces.',
                'image'       => get_template_directory_uri() . '/images/fitout-electrical.jpg',
            ),
            array(
                'icon'        => 'fas fa-sitemap',
                'title'       => 'BIM & Seamless Management',
                'description' => 'Experienced management aligned with BIM architects keeps every trade synchronised, guaranteeing efficiency and quality.',
                'image'       => get_template_directory_uri() . '/images/fitout-bim.jpg',
            ),
        ),
        'case_study' => array(
            'title'       => 'Case Study Spotlight: The Vertex HQ',
            'intro'       => 'The client required a rapid, high-quality transformation to meet an aggressive expansion deadline — demanding unprecedented speed without budget inflation.',
            'challenge'   => 'Challenge: 4,000 m² Tech Office Refit in 10 Weeks',
            'solutions'   => array(
                'Deployed in-house teams concurrently for accelerated timeline.',
                'Used flexible management to solve on-site conflicts instantly.',
            ),
            'result_heading' => 'Result: Delivered 3 Days Early',
            'result_text'    => 'Achieving maximum speed and quality control.',
            'progress_label' => '100% Completion',
            'progress_value' => 100,
            'image'          => get_template_directory_uri() . '/images/fitout-case-study.jpg',
        ),
        'journey' => array(
            array('icon' => 'fas fa-search', 'title' => '1. Discovery', 'description' => 'In-depth consultation to define needs and budget.'),
            array('icon' => 'fas fa-drafting-compass', 'title' => '2. Blueprint', 'description' => 'Transparent quoting, BIM modelling, and design finalisation.'),
            array('icon' => 'fas fa-industry', 'title' => '3. Execute', 'description' => 'Integrated build with in-house trades and strict QA/QC.'),
            array('icon' => 'fas fa-rocket', 'title' => '4. Launch', 'description' => 'Rapid handover, final commissioning, and warranty support.'),
        ),
        'final_cta' => array(
            'title'       => "DON'T JUST BUILD. <br> BUILD <span style=\"color: var(--primary-color);\">CENTRAL.</span>",
            'description' => 'We guarantee On-Time, On-Budget, and On-Spec delivery. Challenge us with your next project and experience the difference.',
            'contact'     => '+1 (123) 456-7890',
            'form_title'  => 'Schedule a Free Analysis',
            'button_label'=> 'Get Started Now',
        ),
    );
}

function central_build_get_cfs_settings(): array
{
    $defaults = central_build_cfs_settings_defaults();
    $saved    = get_option('central_build_cfs_settings', array());

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

    $settings['stats']     = $map_repeatable($settings['stats'] ?? array(), $defaults['stats']);
    $settings['pillars']   = $map_repeatable($settings['pillars'] ?? array(), $defaults['pillars']);
    $settings['inhouse']   = $map_repeatable($settings['inhouse'] ?? array(), $defaults['inhouse']);
    $settings['journey']   = $map_repeatable($settings['journey'] ?? array(), $defaults['journey']);

    $settings['case_study'] = wp_parse_args($settings['case_study'] ?? array(), $defaults['case_study']);
    $settings['case_study']['solutions'] = array_values(array_filter($settings['case_study']['solutions'] ?? array(), static function ($item) {
        return is_string($item) && trim($item) !== '';
    }));
    if (empty($settings['case_study']['solutions'])) {
        $settings['case_study']['solutions'] = $defaults['case_study']['solutions'];
    }

    $settings['final_cta'] = wp_parse_args($settings['final_cta'] ?? array(), $defaults['final_cta']);

    return $settings;
}

function central_build_sanitize_cfs_settings(array $input): array
{
    $defaults = central_build_cfs_settings_defaults();
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
        'background'  => esc_url_raw(wp_unslash($input['hero']['background'] ?? $defaults['hero']['background'])),
        'cta'         => array(
            'label' => $sanitize_text($input['hero']['cta']['label'] ?? '', $defaults['hero']['cta']['label']),
            'url'   => esc_url_raw(wp_unslash($input['hero']['cta']['url'] ?? $defaults['hero']['cta']['url'])),
        ),
    );

    $settings['stats'] = array();
    if (isset($input['stats']) && is_array($input['stats'])) {
        foreach ($input['stats'] as $card) {
            $label = $sanitize_text($card['label'] ?? '');
            if ($label === '' && ($card['number'] ?? '') === '') {
                continue;
            }
            $settings['stats'][] = array(
                'icon'   => $sanitize_text($card['icon'] ?? 'fas fa-circle'),
                'number' => isset($card['number']) ? (int) $card['number'] : 0,
                'suffix' => $sanitize_text($card['suffix'] ?? ''),
                'label'  => $label,
            );
        }
    }
    if (empty($settings['stats'])) {
        $settings['stats'] = $defaults['stats'];
    }

    $settings['pillars'] = array();
    if (isset($input['pillars']) && is_array($input['pillars'])) {
        foreach ($input['pillars'] as $pillar) {
            $title = $sanitize_text($pillar['title'] ?? '');
            if ($title === '') {
                continue;
            }
            $settings['pillars'][] = array(
                'title'       => $title,
                'heading'     => $sanitize_text($pillar['heading'] ?? '', $title),
                'description' => $sanitize_rich_text($pillar['description'] ?? ''),
            );
        }
    }
    if (empty($settings['pillars'])) {
        $settings['pillars'] = $defaults['pillars'];
    }

    $settings['inhouse'] = array();
    if (isset($input['inhouse']) && is_array($input['inhouse'])) {
        foreach ($input['inhouse'] as $card) {
            $title = $sanitize_text($card['title'] ?? '');
            if ($title === '') {
                continue;
            }
            $settings['inhouse'][] = array(
                'icon'        => $sanitize_text($card['icon'] ?? 'fas fa-circle'),
                'title'       => $title,
                'description' => $sanitize_rich_text($card['description'] ?? ''),
                'image'       => esc_url_raw(wp_unslash($card['image'] ?? '')),
            );
        }
    }
    if (empty($settings['inhouse'])) {
        $settings['inhouse'] = $defaults['inhouse'];
    }

    $solutions = array();
    if (isset($input['case_study']['solutions']) && is_array($input['case_study']['solutions'])) {
        foreach ($input['case_study']['solutions'] as $line) {
            $clean = $sanitize_rich_text($line, '');
            if ($clean !== '') {
                $solutions[] = $clean;
            }
        }
    }
    if (empty($solutions)) {
        $solutions = $defaults['case_study']['solutions'];
    }

    $settings['case_study'] = array(
        'title'          => $sanitize_text($input['case_study']['title'] ?? '', $defaults['case_study']['title']),
        'intro'          => $sanitize_rich_text($input['case_study']['intro'] ?? '', $defaults['case_study']['intro']),
        'challenge'      => $sanitize_text($input['case_study']['challenge'] ?? '', $defaults['case_study']['challenge']),
        'solutions'      => $solutions,
        'result_heading' => $sanitize_text($input['case_study']['result_heading'] ?? '', $defaults['case_study']['result_heading']),
        'result_text'    => $sanitize_rich_text($input['case_study']['result_text'] ?? '', $defaults['case_study']['result_text']),
        'progress_label' => $sanitize_text($input['case_study']['progress_label'] ?? '', $defaults['case_study']['progress_label']),
        'progress_value' => isset($input['case_study']['progress_value']) ? max(0, min(100, (int) $input['case_study']['progress_value'])) : $defaults['case_study']['progress_value'],
        'image'          => esc_url_raw(wp_unslash($input['case_study']['image'] ?? $defaults['case_study']['image'])),
    );

    $settings['journey'] = array();
    if (isset($input['journey']) && is_array($input['journey'])) {
        foreach ($input['journey'] as $step) {
            $title = $sanitize_text($step['title'] ?? '');
            if ($title === '') {
                continue;
            }
            $settings['journey'][] = array(
                'icon'        => $sanitize_text($step['icon'] ?? 'fas fa-circle'),
                'title'       => $title,
                'description' => $sanitize_rich_text($step['description'] ?? ''),
            );
        }
    }
    if (empty($settings['journey'])) {
        $settings['journey'] = $defaults['journey'];
    }

    $settings['final_cta'] = array(
        'title'        => $sanitize_rich_text($input['final_cta']['title'] ?? '', $defaults['final_cta']['title']),
        'description'  => $sanitize_rich_text($input['final_cta']['description'] ?? '', $defaults['final_cta']['description']),
        'contact'      => $sanitize_text($input['final_cta']['contact'] ?? '', $defaults['final_cta']['contact']),
        'form_title'   => $sanitize_text($input['final_cta']['form_title'] ?? '', $defaults['final_cta']['form_title']),
        'button_label' => $sanitize_text($input['final_cta']['button_label'] ?? '', $defaults['final_cta']['button_label']),
    );

    return $settings;
}

function central_build_handle_cfs_settings_submit(): void
{
    if (!isset($_POST['central_build_cfs_settings_submit'])) {
        return;
    }

    check_admin_referer('central_build_cfs_settings');

    $raw = isset($_POST['central_build_cfs_settings']) && is_array($_POST['central_build_cfs_settings'])
        ? $_POST['central_build_cfs_settings']
        : array();

    $sanitized = central_build_sanitize_cfs_settings($raw);

    update_option('central_build_cfs_settings', $sanitized);

    add_settings_error('central_build_cfs_settings', 'central_build_cfs_settings_updated', __('Commercial fitout specialists settings saved successfully.', 'central-build'), 'updated');
}

function central_build_cfs_settings_page_render(): void
{
    central_build_handle_cfs_settings_submit();

    $settings = central_build_get_cfs_settings();
    $messages = get_settings_errors('central_build_cfs_settings');
    ?>
    <div class="wrap">
        <h1><?php esc_html_e('Commercial Fitout Specialists Settings', 'central-build'); ?></h1>

        <?php if (!empty($messages)) :
            foreach ($messages as $message) :
                printf('<div class="%1$s"><p>%2$s</p></div>', esc_attr($message['type']), esc_html($message['message']));
            endforeach;
        endif; ?>

        <form method="post" action="">
            <?php wp_nonce_field('central_build_cfs_settings'); ?>
            <h2 class="title"><?php esc_html_e('Hero Section', 'central-build'); ?></h2>
            <table class="form-table" role="presentation">
                <tbody>
                    <tr>
                        <th scope="row"><label for="cb-cfs-hero-badge"><?php esc_html_e('Badge Text', 'central-build'); ?></label></th>
                        <td><input type="text" id="cb-cfs-hero-badge" name="central_build_cfs_settings[hero][badge]" class="regular-text" value="<?php echo esc_attr($settings['hero']['badge']); ?>" /></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-cfs-hero-title"><?php esc_html_e('Title', 'central-build'); ?></label></th>
                        <td><textarea id="cb-cfs-hero-title" name="central_build_cfs_settings[hero][title]" rows="3" class="large-text"><?php echo esc_textarea($settings['hero']['title']); ?></textarea></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-cfs-hero-description"><?php esc_html_e('Description', 'central-build'); ?></label></th>
                        <td><textarea id="cb-cfs-hero-description" name="central_build_cfs_settings[hero][description]" rows="3" class="large-text"><?php echo esc_textarea($settings['hero']['description']); ?></textarea></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-cfs-hero-background"><?php esc_html_e('Background Image URL', 'central-build'); ?></label></th>
                        <td><input type="text" id="cb-cfs-hero-background" name="central_build_cfs_settings[hero][background]" class="large-text" value="<?php echo esc_url($settings['hero']['background']); ?>" /></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-cfs-hero-cta-label"><?php esc_html_e('CTA Label', 'central-build'); ?></label></th>
                        <td><input type="text" id="cb-cfs-hero-cta-label" name="central_build_cfs_settings[hero][cta][label]" class="regular-text" value="<?php echo esc_attr($settings['hero']['cta']['label']); ?>" /></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-cfs-hero-cta-url"><?php esc_html_e('CTA URL', 'central-build'); ?></label></th>
                        <td><input type="text" id="cb-cfs-hero-cta-url" name="central_build_cfs_settings[hero][cta][url]" class="regular-text" value="<?php echo esc_url($settings['hero']['cta']['url']); ?>" /></td>
                    </tr>
                </tbody>
            </table>

            <h2 class="title"><?php esc_html_e('Statistics', 'central-build'); ?></h2>
            <div class="central-build-repeatable" id="cb-cfs-stats">
                <?php foreach ($settings['stats'] as $index => $stat) : ?>
                    <div class="central-build-repeatable__item">
                        <div class="central-build-repeatable__head">
                            <strong><?php printf(esc_html__('Statistic %d', 'central-build'), $index + 1); ?></strong>
                            <button type="button" class="button button-link-delete central-build-repeatable__remove" data-repeatable-remove><?php esc_html_e('Remove', 'central-build'); ?></button>
                        </div>
                        <div class="central-build-repeatable__body">
                            <p><label><?php esc_html_e('Icon Class', 'central-build'); ?><br />
                                <input type="text" name="central_build_cfs_settings[stats][<?php echo esc_attr($index); ?>][icon]" class="regular-text" value="<?php echo esc_attr($stat['icon']); ?>" placeholder="fas fa-star" /></label></p>
                            <p><label><?php esc_html_e('Number', 'central-build'); ?><br />
                                <input type="number" name="central_build_cfs_settings[stats][<?php echo esc_attr($index); ?>][number]" value="<?php echo esc_attr($stat['number']); ?>" /></label></p>
                            <p><label><?php esc_html_e('Suffix', 'central-build'); ?><br />
                                <input type="text" name="central_build_cfs_settings[stats][<?php echo esc_attr($index); ?>][suffix]" class="regular-text" value="<?php echo esc_attr($stat['suffix']); ?>" /></label></p>
                            <p><label><?php esc_html_e('Label', 'central-build'); ?><br />
                                <input type="text" name="central_build_cfs_settings[stats][<?php echo esc_attr($index); ?>][label]" class="regular-text" value="<?php echo esc_attr($stat['label']); ?>" /></label></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="button" class="button" data-repeatable-add data-repeatable-target="cb-cfs-stats" data-repeatable-template="cb-cfs-stat-template"><?php esc_html_e('Add Statistic', 'central-build'); ?></button>

            <h2 class="title"><?php esc_html_e('Pillars', 'central-build'); ?></h2>
            <div class="central-build-repeatable" id="cb-cfs-pillars">
                <?php foreach ($settings['pillars'] as $index => $pillar) : ?>
                    <div class="central-build-repeatable__item">
                        <div class="central-build-repeatable__head">
                            <strong><?php printf(esc_html__('Pillar %d', 'central-build'), $index + 1); ?></strong>
                            <button type="button" class="button button-link-delete central-build-repeatable__remove" data-repeatable-remove><?php esc_html_e('Remove', 'central-build'); ?></button>
                        </div>
                        <div class="central-build-repeatable__body">
                            <p><label><?php esc_html_e('Tab Title', 'central-build'); ?><br />
                                <input type="text" name="central_build_cfs_settings[pillars][<?php echo esc_attr($index); ?>][title]" class="regular-text" value="<?php echo esc_attr($pillar['title']); ?>" /></label></p>
                            <p><label><?php esc_html_e('Heading', 'central-build'); ?><br />
                                <input type="text" name="central_build_cfs_settings[pillars][<?php echo esc_attr($index); ?>][heading]" class="regular-text" value="<?php echo esc_attr($pillar['heading']); ?>" /></label></p>
                            <p><label><?php esc_html_e('Description', 'central-build'); ?><br />
                                <textarea name="central_build_cfs_settings[pillars][<?php echo esc_attr($index); ?>][description]" rows="3" class="large-text"><?php echo esc_textarea($pillar['description']); ?></textarea></label></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="button" class="button" data-repeatable-add data-repeatable-target="cb-cfs-pillars" data-repeatable-template="cb-cfs-pillar-template"><?php esc_html_e('Add Pillar', 'central-build'); ?></button>

            <h2 class="title"><?php esc_html_e('In-House Teams', 'central-build'); ?></h2>
            <div class="central-build-repeatable" id="cb-cfs-inhouse">
                <?php foreach ($settings['inhouse'] as $index => $block) : ?>
                    <div class="central-build-repeatable__item">
                        <div class="central-build-repeatable__head">
                            <strong><?php printf(esc_html__('Team %d', 'central-build'), $index + 1); ?></strong>
                            <button type="button" class="button button-link-delete central-build-repeatable__remove" data-repeatable-remove><?php esc_html_e('Remove', 'central-build'); ?></button>
                        </div>
                        <div class="central-build-repeatable__body">
                            <p><label><?php esc_html_e('Icon Class', 'central-build'); ?><br />
                                <input type="text" name="central_build_cfs_settings[inhouse][<?php echo esc_attr($index); ?>][icon]" class="regular-text" value="<?php echo esc_attr($block['icon']); ?>" /></label></p>
                            <p><label><?php esc_html_e('Title', 'central-build'); ?><br />
                                <input type="text" name="central_build_cfs_settings[inhouse][<?php echo esc_attr($index); ?>][title]" class="regular-text" value="<?php echo esc_attr($block['title']); ?>" /></label></p>
                            <p><label><?php esc_html_e('Description', 'central-build'); ?><br />
                                <textarea name="central_build_cfs_settings[inhouse][<?php echo esc_attr($index); ?>][description]" rows="3" class="large-text"><?php echo esc_textarea($block['description']); ?></textarea></label></p>
                            <p><label><?php esc_html_e('Image URL', 'central-build'); ?><br />
                                <input type="text" name="central_build_cfs_settings[inhouse][<?php echo esc_attr($index); ?>][image]" class="regular-text" value="<?php echo esc_url($block['image']); ?>" placeholder="https://" /></label></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="button" class="button" data-repeatable-add data-repeatable-target="cb-cfs-inhouse" data-repeatable-template="cb-cfs-inhouse-template"><?php esc_html_e('Add In-House Team', 'central-build'); ?></button>

            <h2 class="title"><?php esc_html_e('Case Study', 'central-build'); ?></h2>
            <table class="form-table" role="presentation">
                <tbody>
                    <tr>
                        <th scope="row"><label for="cb-cfs-case-title"><?php esc_html_e('Title', 'central-build'); ?></label></th>
                        <td><input type="text" id="cb-cfs-case-title" name="central_build_cfs_settings[case_study][title]" class="large-text" value="<?php echo esc_attr($settings['case_study']['title']); ?>" /></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-cfs-case-intro"><?php esc_html_e('Intro', 'central-build'); ?></label></th>
                        <td><textarea id="cb-cfs-case-intro" name="central_build_cfs_settings[case_study][intro]" rows="3" class="large-text"><?php echo esc_textarea($settings['case_study']['intro']); ?></textarea></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-cfs-case-challenge"><?php esc_html_e('Challenge Heading', 'central-build'); ?></label></th>
                        <td><input type="text" id="cb-cfs-case-challenge" name="central_build_cfs_settings[case_study][challenge]" class="large-text" value="<?php echo esc_attr($settings['case_study']['challenge']); ?>" /></td>
                    </tr>
                    <tr>
                        <th scope="row"><?php esc_html_e('Solutions', 'central-build'); ?></th>
                        <td>
                            <?php foreach ($settings['case_study']['solutions'] as $index => $item) : ?>
                                <textarea name="central_build_cfs_settings[case_study][solutions][<?php echo esc_attr($index); ?>]" rows="2" class="large-text" style="margin-bottom:6px;"><?php echo esc_textarea($item); ?></textarea>
                            <?php endforeach; ?>
                            <textarea name="central_build_cfs_settings[case_study][solutions][]" rows="2" class="large-text" placeholder="<?php esc_attr_e('Add solution highlight…', 'central-build'); ?>"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-cfs-case-result-heading"><?php esc_html_e('Result Heading', 'central-build'); ?></label></th>
                        <td><input type="text" id="cb-cfs-case-result-heading" name="central_build_cfs_settings[case_study][result_heading]" class="large-text" value="<?php echo esc_attr($settings['case_study']['result_heading']); ?>" /></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-cfs-case-result-text"><?php esc_html_e('Result Text', 'central-build'); ?></label></th>
                        <td><textarea id="cb-cfs-case-result-text" name="central_build_cfs_settings[case_study][result_text]" rows="3" class="large-text"><?php echo esc_textarea($settings['case_study']['result_text']); ?></textarea></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-cfs-case-progress-label"><?php esc_html_e('Progress Label', 'central-build'); ?></label></th>
                        <td><input type="text" id="cb-cfs-case-progress-label" name="central_build_cfs_settings[case_study][progress_label]" class="regular-text" value="<?php echo esc_attr($settings['case_study']['progress_label']); ?>" /></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-cfs-case-progress-value"><?php esc_html_e('Progress Value (0-100)', 'central-build'); ?></label></th>
                        <td><input type="number" id="cb-cfs-case-progress-value" name="central_build_cfs_settings[case_study][progress_value]" value="<?php echo esc_attr($settings['case_study']['progress_value']); ?>" min="0" max="100" /></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-cfs-case-image"><?php esc_html_e('Image URL', 'central-build'); ?></label></th>
                        <td><input type="text" id="cb-cfs-case-image" name="central_build_cfs_settings[case_study][image]" class="large-text" value="<?php echo esc_url($settings['case_study']['image']); ?>" /></td>
                    </tr>
                </tbody>
            </table>

            <h2 class="title"><?php esc_html_e('Client Journey', 'central-build'); ?></h2>
            <div class="central-build-repeatable" id="cb-cfs-journey">
                <?php foreach ($settings['journey'] as $index => $step) : ?>
                    <div class="central-build-repeatable__item">
                        <div class="central-build-repeatable__head">
                            <strong><?php printf(esc_html__('Step %d', 'central-build'), $index + 1); ?></strong>
                            <button type="button" class="button button-link-delete central-build-repeatable__remove" data-repeatable-remove><?php esc_html_e('Remove', 'central-build'); ?></button>
                        </div>
                        <div class="central-build-repeatable__body">
                            <p><label><?php esc_html_e('Icon Class', 'central-build'); ?><br />
                                <input type="text" name="central_build_cfs_settings[journey][<?php echo esc_attr($index); ?>][icon]" class="regular-text" value="<?php echo esc_attr($step['icon']); ?>" /></label></p>
                            <p><label><?php esc_html_e('Title', 'central-build'); ?><br />
                                <input type="text" name="central_build_cfs_settings[journey][<?php echo esc_attr($index); ?>][title]" class="regular-text" value="<?php echo esc_attr($step['title']); ?>" /></label></p>
                            <p><label><?php esc_html_e('Description', 'central-build'); ?><br />
                                <textarea name="central_build_cfs_settings[journey][<?php echo esc_attr($index); ?>][description]" rows="2" class="large-text"><?php echo esc_textarea($step['description']); ?></textarea></label></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="button" class="button" data-repeatable-add data-repeatable-target="cb-cfs-journey" data-repeatable-template="cb-cfs-journey-template"><?php esc_html_e('Add Journey Step', 'central-build'); ?></button>

            <h2 class="title"><?php esc_html_e('Final CTA', 'central-build'); ?></h2>
            <table class="form-table" role="presentation">
                <tbody>
                    <tr>
                        <th scope="row"><label for="cb-cfs-final-title"><?php esc_html_e('Heading', 'central-build'); ?></label></th>
                        <td><textarea id="cb-cfs-final-title" name="central_build_cfs_settings[final_cta][title]" rows="2" class="large-text"><?php echo esc_textarea($settings['final_cta']['title']); ?></textarea></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-cfs-final-description"><?php esc_html_e('Description', 'central-build'); ?></label></th>
                        <td><textarea id="cb-cfs-final-description" name="central_build_cfs_settings[final_cta][description]" rows="3" class="large-text"><?php echo esc_textarea($settings['final_cta']['description']); ?></textarea></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-cfs-final-contact"><?php esc_html_e('Contact Text', 'central-build'); ?></label></th>
                        <td><input type="text" id="cb-cfs-final-contact" name="central_build_cfs_settings[final_cta][contact]" class="regular-text" value="<?php echo esc_attr($settings['final_cta']['contact']); ?>" /></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-cfs-final-form-title"><?php esc_html_e('Form Title', 'central-build'); ?></label></th>
                        <td><input type="text" id="cb-cfs-final-form-title" name="central_build_cfs_settings[final_cta][form_title]" class="regular-text" value="<?php echo esc_attr($settings['final_cta']['form_title']); ?>" /></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-cfs-final-button"><?php esc_html_e('Button Label', 'central-build'); ?></label></th>
                        <td><input type="text" id="cb-cfs-final-button" name="central_build_cfs_settings[final_cta][button_label]" class="regular-text" value="<?php echo esc_attr($settings['final_cta']['button_label']); ?>" /></td>
                    </tr>
                </tbody>
            </table>

            <p class="submit">
                <button type="submit" name="central_build_cfs_settings_submit" class="button button-primary"><?php esc_html_e('Save Settings', 'central-build'); ?></button>
            </p>
        </form>
    </div>

    <script type="text/template" id="cb-cfs-stat-template">
        <div class="central-build-repeatable__item">
            <div class="central-build-repeatable__head">
                <strong><?php esc_html_e('Statistic', 'central-build'); ?></strong>
                <button type="button" class="button button-link-delete central-build-repeatable__remove" data-repeatable-remove><?php esc_html_e('Remove', 'central-build'); ?></button>
            </div>
            <div class="central-build-repeatable__body">
                <p><label><?php esc_html_e('Icon Class', 'central-build'); ?><br />
                    <input type="text" name="central_build_cfs_settings[stats][__INDEX__][icon]" class="regular-text" /></label></p>
                <p><label><?php esc_html_e('Number', 'central-build'); ?><br />
                    <input type="number" name="central_build_cfs_settings[stats][__INDEX__][number]" /></label></p>
                <p><label><?php esc_html_e('Suffix', 'central-build'); ?><br />
                    <input type="text" name="central_build_cfs_settings[stats][__INDEX__][suffix]" class="regular-text" /></label></p>
                <p><label><?php esc_html_e('Label', 'central-build'); ?><br />
                    <input type="text" name="central_build_cfs_settings[stats][__INDEX__][label]" class="regular-text" /></label></p>
            </div>
        </div>
    </script>

    <script type="text/template" id="cb-cfs-pillar-template">
        <div class="central-build-repeatable__item">
            <div class="central-build-repeatable__head">
                <strong><?php esc_html_e('Pillar', 'central-build'); ?></strong>
                <button type="button" class="button button-link-delete central-build-repeatable__remove" data-repeatable-remove><?php esc_html_e('Remove', 'central-build'); ?></button>
            </div>
            <div class="central-build-repeatable__body">
                <p><label><?php esc_html_e('Tab Title', 'central-build'); ?><br />
                    <input type="text" name="central_build_cfs_settings[pillars][__INDEX__][title]" class="regular-text" /></label></p>
                <p><label><?php esc_html_e('Heading', 'central-build'); ?><br />
                    <input type="text" name="central_build_cfs_settings[pillars][__INDEX__][heading]" class="regular-text" /></label></p>
                <p><label><?php esc_html_e('Description', 'central-build'); ?><br />
                    <textarea name="central_build_cfs_settings[pillars][__INDEX__][description]" rows="3" class="large-text"></textarea></label></p>
            </div>
        </div>
    </script>

    <script type="text/template" id="cb-cfs-inhouse-template">
        <div class="central-build-repeatable__item">
            <div class="central-build-repeatable__head">
                <strong><?php esc_html_e('In-House Team', 'central-build'); ?></strong>
                <button type="button" class="button button-link-delete central-build-repeatable__remove" data-repeatable-remove><?php esc_html_e('Remove', 'central-build'); ?></button>
            </div>
            <div class="central-build-repeatable__body">
                <p><label><?php esc_html_e('Icon Class', 'central-build'); ?><br />
                    <input type="text" name="central_build_cfs_settings[inhouse][__INDEX__][icon]" class="regular-text" /></label></p>
                <p><label><?php esc_html_e('Title', 'central-build'); ?><br />
                    <input type="text" name="central_build_cfs_settings[inhouse][__INDEX__][title]" class="regular-text" /></label></p>
                <p><label><?php esc_html_e('Description', 'central-build'); ?><br />
                    <textarea name="central_build_cfs_settings[inhouse][__INDEX__][description]" rows="3" class="large-text"></textarea></label></p>
                <p><label><?php esc_html_e('Image URL', 'central-build'); ?><br />
                    <input type="text" name="central_build_cfs_settings[inhouse][__INDEX__][image]" class="regular-text" placeholder="https://" /></label></p>
            </div>
        </div>
    </script>

    <script type="text/template" id="cb-cfs-journey-template">
        <div class="central-build-repeatable__item">
            <div class="central-build-repeatable__head">
                <strong><?php esc_html_e('Journey Step', 'central-build'); ?></strong>
                <button type="button" class="button button-link-delete central-build-repeatable__remove" data-repeatable-remove><?php esc_html_e('Remove', 'central-build'); ?></button>
            </div>
            <div class="central-build-repeatable__body">
                <p><label><?php esc_html_e('Icon Class', 'central-build'); ?><br />
                    <input type="text" name="central_build_cfs_settings[journey][__INDEX__][icon]" class="regular-text" /></label></p>
                <p><label><?php esc_html_e('Title', 'central-build'); ?><br />
                    <input type="text" name="central_build_cfs_settings[journey][__INDEX__][title]" class="regular-text" /></label></p>
                <p><label><?php esc_html_e('Description', 'central-build'); ?><br />
                    <textarea name="central_build_cfs_settings[journey][__INDEX__][description]" rows="2" class="large-text"></textarea></label></p>
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

function central_build_cfs_settings_menu(): void
{
    add_theme_page(
        __('Commercial Fitout Specialists', 'central-build'),
        __('Commercial Fitout Specialists', 'central-build'),
        'manage_options',
        'central-build-cfs-settings',
        'central_build_cfs_settings_page_render'
    );
}
add_action('admin_menu', 'central_build_cfs_settings_menu');
