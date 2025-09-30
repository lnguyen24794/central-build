<?php
if (!defined('ABSPATH')) {
    exit;
}

function central_build_cid_settings_defaults(): array
{
    return array(
        'hero' => array(
            'title'        => 'COMMERCIAL INTERIOR DESIGN & CONSTRUCTION',
            'subtitle'     => 'ENGINEERING SPACES, DELIVERING EXCEPTIONAL VALUE.',
            'description'  => 'Central Build — dedication and expertise in every detail, ensuring quality, safety, and timeliness.',
            'primary_cta'  => array('label' => 'Get a Free Quote Today', 'url' => '#contact'),
            'secondary_cta'=> array('label' => 'View Our Projects', 'url' => '#portfolio'),
        ),
        'about' => array(
            'heading'    => 'About Central Build',
            'subheading' => 'The Specialist in Commercial Interior Fit-Outs.',
            'content'    => 'Central Build is a specialized commercial contractor, formed by a dedicated team of professionals, bringing together passion and expertise to deliver outstanding results in commercial interior fit-outs. With a meticulous approach, we prioritize precision, efficiency, and excellence, ensuring each project is executed to the highest standards of design, safety, and quality control.',
            'quote'      => array(
                'text'   => 'Our commitment to fulfilling promises and nurturing trust forms the cornerstone of our philosophy. True reputation is built through unwavering attention to detail.',
                'author' => 'Central Build Management',
            ),
            'image'      => get_template_directory_uri() . '/images/default-about-team.jpg',
        ),
        'strengths' => array(
            array(
                'icon'        => 'fas fa-shield-alt',
                'title'       => '100% Services Secured',
                'description' => 'As a registered commercial builder, we guarantee the highest standards of quality, safety, and timeliness, ensuring maximum efficiency and care.',
            ),
            array(
                'icon'        => 'fas fa-tools',
                'title'       => 'Comprehensive In-House Teams',
                'description' => 'Our in-house plumbing and electrical teams ensure seamless coordination, full control, and minimal conflicts from concept to completion.',
            ),
            array(
                'icon'        => 'fas fa-users-cog',
                'title'       => 'Skilled Management & Execution',
                'description' => 'Exceptional skills brought from a wide range of projects ensure seamless processes, delivering the best results on-time and within budget.',
            ),
            array(
                'icon'        => 'fas fa-handshake',
                'title'       => 'Client-Focused Transparency',
                'description' => 'We work closely with you from start to finish, providing transparent and upfront pricing with absolutely no hidden costs.',
            ),
        ),
        'process' => array(
            array(
                'icon'        => 'fas fa-lightbulb',
                'title'       => '1. Consult & Analyze',
                'description' => 'Thorough analysis of your requirements, budget, and commercial vision. We listen first.',
            ),
            array(
                'icon'        => 'fas fa-drafting-compass',
                'title'       => '2. Design & Quoting',
                'description' => 'Presenting innovative design concepts, detailed blueprints, and fully transparent, upfront pricing.',
            ),
            array(
                'icon'        => 'fas fa-hard-hat',
                'title'       => '3. Construction & Control',
                'description' => 'Execution by our specialized in-house teams with strict quality control, safety compliance, and efficient problem-solving.',
            ),
            array(
                'icon'        => 'fas fa-key',
                'title'       => '4. Handover & Warranty',
                'description' => 'Timely completion and project handover. Follow-up support and comprehensive warranty for lasting value.',
            ),
        ),
        'cta_block' => array(
            'heading'     => 'Ready to Transform Your Commercial Space?',
            'description' => 'Let Central Build provide the optimal solution. Get your free, non-binding consultation today.',
            'items'       => array(
                array('icon' => 'fas fa-phone-alt', 'text' => '+1 (123) 456-7890'),
                array('icon' => 'fas fa-envelope', 'text' => 'info@centralbuild.com'),
                array('icon' => 'fas fa-map-marker-alt', 'text' => '123 Commercial Drive, Suite 100 — Metropolis, Anytown 12345'),
            ),
            'form_title'   => 'Request a Free Quote',
            'button_label' => 'Submit Request',
        ),
    );
}

function central_build_get_cid_settings(): array
{
    $defaults = central_build_cid_settings_defaults();
    $saved    = get_option('central_build_cid_settings', array());

    $settings = wp_parse_args(is_array($saved) ? $saved : array(), $defaults);

    $settings['hero'] = wp_parse_args($settings['hero'] ?? array(), $defaults['hero']);
    $settings['hero']['primary_cta']   = wp_parse_args($settings['hero']['primary_cta'] ?? array(), $defaults['hero']['primary_cta']);
    $settings['hero']['secondary_cta'] = wp_parse_args($settings['hero']['secondary_cta'] ?? array(), $defaults['hero']['secondary_cta']);

    $settings['about'] = wp_parse_args($settings['about'] ?? array(), $defaults['about']);
    $settings['about']['quote'] = wp_parse_args($settings['about']['quote'] ?? array(), $defaults['about']['quote']);

    $settings['strengths'] = array_values(array_filter($settings['strengths'] ?? array(), 'is_array'));
    if (empty($settings['strengths'])) {
        $settings['strengths'] = $defaults['strengths'];
    }

    $settings['process'] = array_values(array_filter($settings['process'] ?? array(), 'is_array'));
    if (empty($settings['process'])) {
        $settings['process'] = $defaults['process'];
    }

    $settings['cta_block'] = wp_parse_args($settings['cta_block'] ?? array(), $defaults['cta_block']);
    $settings['cta_block']['items'] = array_values(array_filter($settings['cta_block']['items'] ?? array(), 'is_array'));
    if (empty($settings['cta_block']['items'])) {
        $settings['cta_block']['items'] = $defaults['cta_block']['items'];
    }

    return $settings;
}

function central_build_sanitize_cid_settings(array $input): array
{
    $defaults = central_build_cid_settings_defaults();
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
        'title'        => $sanitize_text($input['hero']['title'] ?? '', $defaults['hero']['title']),
        'subtitle'     => $sanitize_text($input['hero']['subtitle'] ?? '', $defaults['hero']['subtitle']),
        'description'  => $sanitize_rich_text($input['hero']['description'] ?? '', $defaults['hero']['description']),
        'primary_cta'  => array(
            'label' => $sanitize_text($input['hero']['primary_cta']['label'] ?? '', $defaults['hero']['primary_cta']['label']),
            'url'   => esc_url_raw(wp_unslash($input['hero']['primary_cta']['url'] ?? $defaults['hero']['primary_cta']['url'])),
        ),
        'secondary_cta'=> array(
            'label' => $sanitize_text($input['hero']['secondary_cta']['label'] ?? '', $defaults['hero']['secondary_cta']['label']),
            'url'   => esc_url_raw(wp_unslash($input['hero']['secondary_cta']['url'] ?? $defaults['hero']['secondary_cta']['url'])),
        ),
    );

    $settings['about'] = array(
        'heading'    => $sanitize_text($input['about']['heading'] ?? '', $defaults['about']['heading']),
        'subheading' => $sanitize_text($input['about']['subheading'] ?? '', $defaults['about']['subheading']),
        'content'    => $sanitize_rich_text($input['about']['content'] ?? '', $defaults['about']['content']),
        'quote'      => array(
            'text'   => $sanitize_rich_text($input['about']['quote']['text'] ?? '', $defaults['about']['quote']['text']),
            'author' => $sanitize_text($input['about']['quote']['author'] ?? '', $defaults['about']['quote']['author']),
        ),
        'image'      => esc_url_raw(wp_unslash($input['about']['image'] ?? $defaults['about']['image'])),
    );

    $settings['strengths'] = array();
    if (!empty($input['strengths']) && is_array($input['strengths'])) {
        foreach ($input['strengths'] as $card) {
            $title = $sanitize_text($card['title'] ?? '');
            $description = $sanitize_rich_text($card['description'] ?? '');
            $icon = $sanitize_text($card['icon'] ?? 'fas fa-circle');
            if ($title === '' && $description === '') {
                continue;
            }
            $settings['strengths'][] = array(
                'icon'        => $icon,
                'title'       => $title,
                'description' => $description,
            );
        }
    }
    if (empty($settings['strengths'])) {
        $settings['strengths'] = $defaults['strengths'];
    }

    $settings['process'] = array();
    if (!empty($input['process']) && is_array($input['process'])) {
        foreach ($input['process'] as $step) {
            $title = $sanitize_text($step['title'] ?? '');
            $description = $sanitize_rich_text($step['description'] ?? '');
            $icon = $sanitize_text($step['icon'] ?? 'fas fa-circle');
            if ($title === '' && $description === '') {
                continue;
            }
            $settings['process'][] = array(
                'icon'        => $icon,
                'title'       => $title,
                'description' => $description,
            );
        }
    }
    if (empty($settings['process'])) {
        $settings['process'] = $defaults['process'];
    }

    $cta_items = array();
    if (!empty($input['cta_block']['items']) && is_array($input['cta_block']['items'])) {
        foreach ($input['cta_block']['items'] as $item) {
            $text = $sanitize_text($item['text'] ?? '');
            $icon = $sanitize_text($item['icon'] ?? 'fas fa-circle');
            if ($text === '') {
                continue;
            }
            $cta_items[] = array('icon' => $icon, 'text' => $text);
        }
    }
    if (empty($cta_items)) {
        $cta_items = $defaults['cta_block']['items'];
    }

    $settings['cta_block'] = array(
        'heading'     => $sanitize_text($input['cta_block']['heading'] ?? '', $defaults['cta_block']['heading']),
        'description' => $sanitize_rich_text($input['cta_block']['description'] ?? '', $defaults['cta_block']['description']),
        'items'       => $cta_items,
        'form_title'  => $sanitize_text($input['cta_block']['form_title'] ?? '', $defaults['cta_block']['form_title']),
        'button_label'=> $sanitize_text($input['cta_block']['button_label'] ?? '', $defaults['cta_block']['button_label']),
    );

    return $settings;
}

function central_build_handle_cid_settings_submit(): void
{
    if (!isset($_POST['central_build_cid_settings_submit'])) {
        return;
    }

    check_admin_referer('central_build_cid_settings');

    $raw = isset($_POST['central_build_cid_settings']) && is_array($_POST['central_build_cid_settings'])
        ? $_POST['central_build_cid_settings']
        : array();

    $sanitized = central_build_sanitize_cid_settings($raw);

    update_option('central_build_cid_settings', $sanitized);

    add_settings_error('central_build_cid_settings', 'central_build_cid_settings_updated', __('Commercial interior design settings saved successfully.', 'central-build'), 'updated');
}

function central_build_cid_settings_page_render(): void
{
    central_build_handle_cid_settings_submit();

    $settings = central_build_get_cid_settings();
    $messages = get_settings_errors('central_build_cid_settings');
    ?>
    <div class="wrap">
        <h1><?php esc_html_e('Commercial Interior Design Page Settings', 'central-build'); ?></h1>

        <?php if (!empty($messages)) :
            foreach ($messages as $message) :
                printf('<div class="%1$s"><p>%2$s</p></div>', esc_attr($message['type']), esc_html($message['message']));
            endforeach;
        endif; ?>

        <form method="post" action="">
            <?php wp_nonce_field('central_build_cid_settings'); ?>

            <h2 class="title"><?php esc_html_e('Hero Section', 'central-build'); ?></h2>
            <table class="form-table" role="presentation">
                <tbody>
                    <tr>
                        <th scope="row"><label for="cb-cid-hero-title"><?php esc_html_e('Title', 'central-build'); ?></label></th>
                        <td><input type="text" id="cb-cid-hero-title" name="central_build_cid_settings[hero][title]" class="large-text" value="<?php echo esc_attr($settings['hero']['title']); ?>" /></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-cid-hero-subtitle"><?php esc_html_e('Subtitle', 'central-build'); ?></label></th>
                        <td><input type="text" id="cb-cid-hero-subtitle" name="central_build_cid_settings[hero][subtitle]" class="large-text" value="<?php echo esc_attr($settings['hero']['subtitle']); ?>" /></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-cid-hero-description"><?php esc_html_e('Description', 'central-build'); ?></label></th>
                        <td><textarea id="cb-cid-hero-description" name="central_build_cid_settings[hero][description]" rows="3" class="large-text"><?php echo esc_textarea($settings['hero']['description']); ?></textarea></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-cid-hero-primary-label"><?php esc_html_e('Primary CTA Label', 'central-build'); ?></label></th>
                        <td><input type="text" id="cb-cid-hero-primary-label" name="central_build_cid_settings[hero][primary_cta][label]" class="regular-text" value="<?php echo esc_attr($settings['hero']['primary_cta']['label']); ?>" /></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-cid-hero-primary-url"><?php esc_html_e('Primary CTA URL', 'central-build'); ?></label></th>
                        <td><input type="text" id="cb-cid-hero-primary-url" name="central_build_cid_settings[hero][primary_cta][url]" class="regular-text" value="<?php echo esc_url($settings['hero']['primary_cta']['url']); ?>" /></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-cid-hero-secondary-label"><?php esc_html_e('Secondary CTA Label', 'central-build'); ?></label></th>
                        <td><input type="text" id="cb-cid-hero-secondary-label" name="central_build_cid_settings[hero][secondary_cta][label]" class="regular-text" value="<?php echo esc_attr($settings['hero']['secondary_cta']['label']); ?>" /></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-cid-hero-secondary-url"><?php esc_html_e('Secondary CTA URL', 'central-build'); ?></label></th>
                        <td><input type="text" id="cb-cid-hero-secondary-url" name="central_build_cid_settings[hero][secondary_cta][url]" class="regular-text" value="<?php echo esc_url($settings['hero']['secondary_cta']['url']); ?>" /></td>
                    </tr>
                </tbody>
            </table>

            <h2 class="title"><?php esc_html_e('About Section', 'central-build'); ?></h2>
            <table class="form-table" role="presentation">
                <tbody>
                    <tr>
                        <th scope="row"><label for="cb-cid-about-heading"><?php esc_html_e('Heading', 'central-build'); ?></label></th>
                        <td><input type="text" id="cb-cid-about-heading" name="central_build_cid_settings[about][heading]" class="large-text" value="<?php echo esc_attr($settings['about']['heading']); ?>" /></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-cid-about-subheading"><?php esc_html_e('Subheading', 'central-build'); ?></label></th>
                        <td><input type="text" id="cb-cid-about-subheading" name="central_build_cid_settings[about][subheading]" class="large-text" value="<?php echo esc_attr($settings['about']['subheading']); ?>" /></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-cid-about-content"><?php esc_html_e('Content', 'central-build'); ?></label></th>
                        <td><textarea id="cb-cid-about-content" name="central_build_cid_settings[about][content]" rows="6" class="large-text"><?php echo esc_textarea($settings['about']['content']); ?></textarea></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-cid-about-quote-text"><?php esc_html_e('Quote Text', 'central-build'); ?></label></th>
                        <td><textarea id="cb-cid-about-quote-text" name="central_build_cid_settings[about][quote][text]" rows="3" class="large-text"><?php echo esc_textarea($settings['about']['quote']['text']); ?></textarea></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-cid-about-quote-author"><?php esc_html_e('Quote Author', 'central-build'); ?></label></th>
                        <td><input type="text" id="cb-cid-about-quote-author" name="central_build_cid_settings[about][quote][author]" class="regular-text" value="<?php echo esc_attr($settings['about']['quote']['author']); ?>" /></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-cid-about-image"><?php esc_html_e('Image URL', 'central-build'); ?></label></th>
                        <td><input type="text" id="cb-cid-about-image" name="central_build_cid_settings[about][image]" class="large-text" value="<?php echo esc_url($settings['about']['image']); ?>" /></td>
                    </tr>
                </tbody>
            </table>

            <h2 class="title"><?php esc_html_e('Strengths', 'central-build'); ?></h2>
            <div class="central-build-repeatable" id="cb-cid-strengths">
                <?php foreach ($settings['strengths'] as $index => $card) : ?>
                    <div class="central-build-repeatable__item">
                        <div class="central-build-repeatable__head">
                            <strong><?php printf(esc_html__('Strength %d', 'central-build'), $index + 1); ?></strong>
                            <button type="button" class="button button-link-delete central-build-repeatable__remove" data-repeatable-remove><?php esc_html_e('Remove', 'central-build'); ?></button>
                        </div>
                        <div class="central-build-repeatable__body">
                            <p>
                                <label><?php esc_html_e('Icon Class', 'central-build'); ?><br />
                                    <input type="text" name="central_build_cid_settings[strengths][<?php echo esc_attr($index); ?>][icon]" class="regular-text" value="<?php echo esc_attr($card['icon']); ?>" placeholder="fas fa-shield-alt" />
                                </label>
                            </p>
                            <p>
                                <label><?php esc_html_e('Title', 'central-build'); ?><br />
                                    <input type="text" name="central_build_cid_settings[strengths][<?php echo esc_attr($index); ?>][title]" class="regular-text" value="<?php echo esc_attr($card['title']); ?>" />
                                </label>
                            </p>
                            <p>
                                <label><?php esc_html_e('Description', 'central-build'); ?><br />
                                    <textarea name="central_build_cid_settings[strengths][<?php echo esc_attr($index); ?>][description]" rows="3" class="large-text"><?php echo esc_textarea($card['description']); ?></textarea>
                                </label>
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="button" class="button" data-repeatable-add data-repeatable-target="cb-cid-strengths" data-repeatable-template="cb-cid-strength-template"><?php esc_html_e('Add Strength', 'central-build'); ?></button>

            <h2 class="title"><?php esc_html_e('Process Steps', 'central-build'); ?></h2>
            <div class="central-build-repeatable" id="cb-cid-process">
                <?php foreach ($settings['process'] as $index => $step) : ?>
                    <div class="central-build-repeatable__item">
                        <div class="central-build-repeatable__head">
                            <strong><?php printf(esc_html__('Step %d', 'central-build'), $index + 1); ?></strong>
                            <button type="button" class="button button-link-delete central-build-repeatable__remove" data-repeatable-remove><?php esc_html_e('Remove', 'central-build'); ?></button>
                        </div>
                        <div class="central-build-repeatable__body">
                            <p>
                                <label><?php esc_html_e('Icon Class', 'central-build'); ?><br />
                                    <input type="text" name="central_build_cid_settings[process][<?php echo esc_attr($index); ?>][icon]" class="regular-text" value="<?php echo esc_attr($step['icon']); ?>" placeholder="fas fa-lightbulb" />
                                </label>
                            </p>
                            <p>
                                <label><?php esc_html_e('Title', 'central-build'); ?><br />
                                    <input type="text" name="central_build_cid_settings[process][<?php echo esc_attr($index); ?>][title]" class="regular-text" value="<?php echo esc_attr($step['title']); ?>" />
                                </label>
                            </p>
                            <p>
                                <label><?php esc_html_e('Description', 'central-build'); ?><br />
                                    <textarea name="central_build_cid_settings[process][<?php echo esc_attr($index); ?>][description]" rows="3" class="large-text"><?php echo esc_textarea($step['description']); ?></textarea>
                                </label>
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="button" class="button" data-repeatable-add data-repeatable-target="cb-cid-process" data-repeatable-template="cb-cid-process-template"><?php esc_html_e('Add Process Step', 'central-build'); ?></button>

            <h2 class="title"><?php esc_html_e('Contact CTA Block', 'central-build'); ?></h2>
            <table class="form-table" role="presentation">
                <tbody>
                    <tr>
                        <th scope="row"><label for="cb-cid-cta-heading"><?php esc_html_e('Heading', 'central-build'); ?></label></th>
                        <td><input type="text" id="cb-cid-cta-heading" name="central_build_cid_settings[cta_block][heading]" class="large-text" value="<?php echo esc_attr($settings['cta_block']['heading']); ?>" /></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-cid-cta-description"><?php esc_html_e('Description', 'central-build'); ?></label></th>
                        <td><textarea id="cb-cid-cta-description" name="central_build_cid_settings[cta_block][description]" rows="3" class="large-text"><?php echo esc_textarea($settings['cta_block']['description']); ?></textarea></td>
                    </tr>
                </tbody>
            </table>
            <div class="central-build-repeatable" id="cb-cid-cta-items">
                <?php foreach ($settings['cta_block']['items'] as $index => $item) : ?>
                    <div class="central-build-repeatable__item">
                        <div class="central-build-repeatable__head">
                            <strong><?php printf(esc_html__('Contact Item %d', 'central-build'), $index + 1); ?></strong>
                            <button type="button" class="button button-link-delete central-build-repeatable__remove" data-repeatable-remove><?php esc_html_e('Remove', 'central-build'); ?></button>
                        </div>
                        <div class="central-build-repeatable__body">
                            <p>
                                <label><?php esc_html_e('Icon Class', 'central-build'); ?><br />
                                    <input type="text" name="central_build_cid_settings[cta_block][items][<?php echo esc_attr($index); ?>][icon]" class="regular-text" value="<?php echo esc_attr($item['icon']); ?>" placeholder="fas fa-phone-alt" />
                                </label>
                            </p>
                            <p>
                                <label><?php esc_html_e('Text', 'central-build'); ?><br />
                                    <input type="text" name="central_build_cid_settings[cta_block][items][<?php echo esc_attr($index); ?>][text]" class="regular-text" value="<?php echo esc_attr($item['text']); ?>" />
                                </label>
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="button" class="button" data-repeatable-add data-repeatable-target="cb-cid-cta-items" data-repeatable-template="cb-cid-cta-item-template"><?php esc_html_e('Add Contact Item', 'central-build'); ?></button>

            <table class="form-table" role="presentation">
                <tbody>
                    <tr>
                        <th scope="row"><label for="cb-cid-cta-form-title"><?php esc_html_e('Form Title', 'central-build'); ?></label></th>
                        <td><input type="text" id="cb-cid-cta-form-title" name="central_build_cid_settings[cta_block][form_title]" class="regular-text" value="<?php echo esc_attr($settings['cta_block']['form_title']); ?>" /></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-cid-cta-button"><?php esc_html_e('Form Button Label', 'central-build'); ?></label></th>
                        <td><input type="text" id="cb-cid-cta-button" name="central_build_cid_settings[cta_block][button_label]" class="regular-text" value="<?php echo esc_attr($settings['cta_block']['button_label']); ?>" /></td>
                    </tr>
                </tbody>
            </table>

            <p class="submit">
                <button type="submit" name="central_build_cid_settings_submit" class="button button-primary"><?php esc_html_e('Save Settings', 'central-build'); ?></button>
            </p>
        </form>
    </div>

    <script type="text/template" id="cb-cid-strength-template">
        <div class="central-build-repeatable__item">
            <div class="central-build-repeatable__head">
                <strong><?php esc_html_e('Strength', 'central-build'); ?></strong>
                <button type="button" class="button button-link-delete central-build-repeatable__remove" data-repeatable-remove><?php esc_html_e('Remove', 'central-build'); ?></button>
            </div>
            <div class="central-build-repeatable__body">
                <p>
                    <label><?php esc_html_e('Icon Class', 'central-build'); ?><br />
                        <input type="text" name="central_build_cid_settings[strengths][__INDEX__][icon]" class="regular-text" placeholder="fas fa-star" />
                    </label>
                </p>
                <p>
                    <label><?php esc_html_e('Title', 'central-build'); ?><br />
                        <input type="text" name="central_build_cid_settings[strengths][__INDEX__][title]" class="regular-text" />
                    </label>
                </p>
                <p>
                    <label><?php esc_html_e('Description', 'central-build'); ?><br />
                        <textarea name="central_build_cid_settings[strengths][__INDEX__][description]" rows="3" class="large-text"></textarea>
                    </label>
                </p>
            </div>
        </div>
    </script>

    <script type="text/template" id="cb-cid-process-template">
        <div class="central-build-repeatable__item">
            <div class="central-build-repeatable__head">
                <strong><?php esc_html_e('Process Step', 'central-build'); ?></strong>
                <button type="button" class="button button-link-delete central-build-repeatable__remove" data-repeatable-remove><?php esc_html_e('Remove', 'central-build'); ?></button>
            </div>
            <div class="central-build-repeatable__body">
                <p>
                    <label><?php esc_html_e('Icon Class', 'central-build'); ?><br />
                        <input type="text" name="central_build_cid_settings[process][__INDEX__][icon]" class="regular-text" placeholder="fas fa-star" />
                    </label>
                </p>
                <p>
                    <label><?php esc_html_e('Title', 'central-build'); ?><br />
                        <input type="text" name="central_build_cid_settings[process][__INDEX__][title]" class="regular-text" />
                    </label>
                </p>
                <p>
                    <label><?php esc_html_e('Description', 'central-build'); ?><br />
                        <textarea name="central_build_cid_settings[process][__INDEX__][description]" rows="3" class="large-text"></textarea>
                    </label>
                </p>
            </div>
        </div>
    </script>

    <script type="text/template" id="cb-cid-cta-item-template">
        <div class="central-build-repeatable__item">
            <div class="central-build-repeatable__head">
                <strong><?php esc_html_e('Contact Item', 'central-build'); ?></strong>
                <button type="button" class="button button-link-delete central-build-repeatable__remove" data-repeatable-remove><?php esc_html_e('Remove', 'central-build'); ?></button>
            </div>
            <div class="central-build-repeatable__body">
                <p>
                    <label><?php esc_html_e('Icon Class', 'central-build'); ?><br />
                        <input type="text" name="central_build_cid_settings[cta_block][items][__INDEX__][icon]" class="regular-text" placeholder="fas fa-phone" />
                    </label>
                </p>
                <p>
                    <label><?php esc_html_e('Text', 'central-build'); ?><br />
                        <input type="text" name="central_build_cid_settings[cta_block][items][__INDEX__][text]" class="regular-text" />
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

function central_build_cid_settings_menu(): void
{
    add_theme_page(
        __('Commercial Interior Design', 'central-build'),
        __('Commercial Interior Design', 'central-build'),
        'manage_options',
        'central-build-cid-settings',
        'central_build_cid_settings_page_render'
    );
}
add_action('admin_menu', 'central_build_cid_settings_menu');
