<?php
if (!defined('ABSPATH')) {
    exit;
}

function central_build_about_settings_defaults(): array
{
    return array(
        'hero' => array(
            'title'       => 'We Are Central Build',
            'description' => 'A specialized commercial contractor delivering outstanding results in interior fit-outs. Precision, efficiency, and excellence are at the heart of everything we do.',
        ),
        'mission' => array(
            'title' => 'Our Mission',
            'text'  => 'To deliver exceptional commercial construction services with precision, safety, and quality while building trust and long-term relationships with our clients.',
        ),
        'vision' => array(
            'title' => 'Our Vision',
            'text'  => 'To become a leading commercial contractor recognized for innovation, sustainability, and creating inspiring spaces that add lasting value.',
        ),
        'philosophy' => array(
            'image'    => 'https://images.unsplash.com/photo-1556761175-4b46a572b786',
            'heading'  => 'Who We Are',
            'paragraphs' => array(
                'Central Build is formed by a dedicated team of professionals, bringing together passion and expertise to deliver commercial projects with the highest standards of design, safety, and quality control.',
                'Our commitment to fulfilling promises and nurturing trust forms the cornerstone of our philosophy. True reputation is built not by chance, but through unwavering attention to detail, where every element contributes to lasting value.',
            ),
        ),
        'services' => array(
            array('title' => 'Interior Design & Construction', 'url' => '/interior-design-construction'),
            array('title' => 'Commercial Fitouts', 'url' => '/commercial-fitouts'),
            array('title' => 'Services Coordination', 'url' => '/services-coordination'),
            array('title' => 'Commercial Stripout', 'url' => '/commercial-stripout'),
            array('title' => 'Repairs & Maintenance', 'url' => '/repairs-and-maintenance'),
        ),
        'cta' => array(
            'text' => 'Contact Us Today!',
            'url'  => '/contact',
        ),
        'right_column' => array(
            'heading'   => 'Fitout Experts with Proven Results',
            'paragraph' => 'Leverage our expertise to transform your space. With a track record of quality fitouts, we deliver tailored solutions on time, every time.',
        ),
        'team' => array(
            'show' => true,
            'members' => array(),
        ),
    );
}

function central_build_get_about_settings(): array
{
    $defaults = central_build_about_settings_defaults();
    $saved    = get_option('central_build_about_settings', array());

    $settings = wp_parse_args(is_array($saved) ? $saved : array(), $defaults);

    $settings['hero']         = wp_parse_args($settings['hero'] ?? array(), $defaults['hero']);
    $settings['mission']      = wp_parse_args($settings['mission'] ?? array(), $defaults['mission']);
    $settings['vision']       = wp_parse_args($settings['vision'] ?? array(), $defaults['vision']);
    $settings['philosophy']   = wp_parse_args($settings['philosophy'] ?? array(), $defaults['philosophy']);
    $settings['philosophy']['paragraphs'] = is_array($settings['philosophy']['paragraphs'] ?? null)
        ? $settings['philosophy']['paragraphs']
        : $defaults['philosophy']['paragraphs'];
    $settings['services']     = is_array($settings['services'] ?? null) ? $settings['services'] : $defaults['services'];
    $settings['cta']          = wp_parse_args($settings['cta'] ?? array(), $defaults['cta']);
    $settings['right_column'] = wp_parse_args($settings['right_column'] ?? array(), $defaults['right_column']);
    $settings['team']         = wp_parse_args($settings['team'] ?? array(), $defaults['team']);
    $settings['team']['members'] = array_values(array_filter($settings['team']['members'] ?? array(), 'is_array'));

    return $settings;
}

function central_build_sanitize_about_settings(array $input): array
{
    $defaults = central_build_about_settings_defaults();

    $sanitize_text = static function ($value, $fallback) {
        $value = is_string($value) ? wp_unslash($value) : '';
        return $value !== '' ? sanitize_text_field($value) : $fallback;
    };

    $sanitize_rich_text = static function ($value, $fallback) {
        $value = is_string($value) ? wp_unslash($value) : '';
        return $value !== '' ? wp_kses_post($value) : $fallback;
    };

    $settings = array();

    $settings['hero'] = array(
        'title'       => $sanitize_text($input['hero']['title'] ?? '', $defaults['hero']['title']),
        'description' => $sanitize_rich_text($input['hero']['description'] ?? '', $defaults['hero']['description']),
    );

    $settings['mission'] = array(
        'title' => $sanitize_text($input['mission']['title'] ?? '', $defaults['mission']['title']),
        'text'  => $sanitize_rich_text($input['mission']['text'] ?? '', $defaults['mission']['text']),
    );

    $settings['vision'] = array(
        'title' => $sanitize_text($input['vision']['title'] ?? '', $defaults['vision']['title']),
        'text'  => $sanitize_rich_text($input['vision']['text'] ?? '', $defaults['vision']['text']),
    );

    $paragraphs = $defaults['philosophy']['paragraphs'];
    if (isset($input['philosophy']['paragraphs']) && is_array($input['philosophy']['paragraphs'])) {
        $paragraphs = array();
        foreach ($input['philosophy']['paragraphs'] as $paragraph) {
            $paragraphs[] = $sanitize_rich_text($paragraph, '');
        }
        $paragraphs = array_values(array_filter($paragraphs, static function ($value) {
            return $value !== '';
        }));
        if (empty($paragraphs)) {
            $paragraphs = $defaults['philosophy']['paragraphs'];
        }
    }

    $settings['philosophy'] = array(
        'image'     => isset($input['philosophy']['image']) ? esc_url_raw(wp_unslash($input['philosophy']['image'])) : $defaults['philosophy']['image'],
        'heading'   => $sanitize_text($input['philosophy']['heading'] ?? '', $defaults['philosophy']['heading']),
        'paragraphs' => $paragraphs,
    );

    $services = array();
    if (isset($input['services']) && is_array($input['services'])) {
        foreach ($input['services'] as $service) {
            $title = $sanitize_text($service['title'] ?? '', '');
            $url   = isset($service['url']) ? esc_url_raw(wp_unslash($service['url'])) : '';
            if ($title === '') {
                continue;
            }
            $services[] = array('title' => $title, 'url' => $url);
        }
    }
    if (empty($services)) {
        $services = $defaults['services'];
    }
    $settings['services'] = $services;

    $settings['cta'] = array(
        'text' => $sanitize_text($input['cta']['text'] ?? '', $defaults['cta']['text']),
        'url'  => isset($input['cta']['url']) ? esc_url_raw(wp_unslash($input['cta']['url'])) : $defaults['cta']['url'],
    );

    $settings['right_column'] = array(
        'heading'   => $sanitize_text($input['right_column']['heading'] ?? '', $defaults['right_column']['heading']),
        'paragraph' => $sanitize_rich_text($input['right_column']['paragraph'] ?? '', $defaults['right_column']['paragraph']),
    );

    $members = array();
    if (isset($input['team']['members']) && is_array($input['team']['members'])) {
        foreach ($input['team']['members'] as $member) {
            $name  = $sanitize_text($member['name'] ?? '', '');
            $role  = $sanitize_text($member['role'] ?? '', '');
            $image = isset($member['image']) ? esc_url_raw(wp_unslash($member['image'])) : '';

            if ($name === '' && $role === '' && $image === '') {
                continue;
            }

            $members[] = array(
                'name'  => $name,
                'role'  => $role,
                'image' => $image,
            );
        }
    }

    $settings['team'] = array(
        'show'    => !empty($input['team']['show']),
        'members' => $members,
    );

    return $settings;
}

function central_build_handle_about_settings_submit(): void
{
    if (!isset($_POST['central_build_about_settings_submit'])) {
        return;
    }

    check_admin_referer('central_build_about_settings');

    $raw = isset($_POST['central_build_about_settings']) && is_array($_POST['central_build_about_settings'])
        ? $_POST['central_build_about_settings']
        : array();

    $sanitized = central_build_sanitize_about_settings($raw);

    update_option('central_build_about_settings', $sanitized);

    add_settings_error('central_build_about_settings', 'central_build_about_settings_updated', __('About settings saved successfully.', 'central-build'), 'updated');
}

function central_build_about_settings_page_render(): void
{
    central_build_handle_about_settings_submit();

    $settings = central_build_get_about_settings();
    $messages = get_settings_errors('central_build_about_settings');

    ?>
    <div class="wrap">
        <h1><?php esc_html_e('About Us Settings', 'central-build'); ?></h1>

        <?php if (!empty($messages)) :
            foreach ($messages as $message) :
                printf('<div class="%1$s"><p>%2$s</p></div>', esc_attr($message['type']), esc_html($message['message']));
            endforeach;
        endif; ?>

        <form method="post" action="">
            <?php wp_nonce_field('central_build_about_settings'); ?>

            <h2 class="title"><?php esc_html_e('Hero', 'central-build'); ?></h2>
            <table class="form-table" role="presentation">
                <tbody>
                    <tr>
                        <th scope="row"><label for="cb-about-hero-title"><?php esc_html_e('Hero Title', 'central-build'); ?></label></th>
                        <td><input type="text" id="cb-about-hero-title" name="central_build_about_settings[hero][title]" class="large-text" value="<?php echo esc_attr($settings['hero']['title']); ?>" /></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-about-hero-description"><?php esc_html_e('Hero Description', 'central-build'); ?></label></th>
                        <td><textarea id="cb-about-hero-description" name="central_build_about_settings[hero][description]" rows="3" class="large-text"><?php echo esc_textarea($settings['hero']['description']); ?></textarea></td>
                    </tr>
                </tbody>
            </table>

            <h2 class="title"><?php esc_html_e('Mission & Vision', 'central-build'); ?></h2>
            <table class="form-table" role="presentation">
                <tbody>
                    <tr>
                        <th scope="row"><label for="cb-about-mission-title"><?php esc_html_e('Mission Title', 'central-build'); ?></label></th>
                        <td><input type="text" id="cb-about-mission-title" name="central_build_about_settings[mission][title]" class="regular-text" value="<?php echo esc_attr($settings['mission']['title']); ?>" /></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-about-mission-text"><?php esc_html_e('Mission Text', 'central-build'); ?></label></th>
                        <td><textarea id="cb-about-mission-text" name="central_build_about_settings[mission][text]" rows="3" class="large-text"><?php echo esc_textarea($settings['mission']['text']); ?></textarea></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-about-vision-title"><?php esc_html_e('Vision Title', 'central-build'); ?></label></th>
                        <td><input type="text" id="cb-about-vision-title" name="central_build_about_settings[vision][title]" class="regular-text" value="<?php echo esc_attr($settings['vision']['title']); ?>" /></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-about-vision-text"><?php esc_html_e('Vision Text', 'central-build'); ?></label></th>
                        <td><textarea id="cb-about-vision-text" name="central_build_about_settings[vision][text]" rows="3" class="large-text"><?php echo esc_textarea($settings['vision']['text']); ?></textarea></td>
                    </tr>
                </tbody>
            </table>

            <h2 class="title"><?php esc_html_e('Philosophy', 'central-build'); ?></h2>
            <table class="form-table" role="presentation">
                <tbody>
                    <tr>
                        <th scope="row"><label for="cb-about-philosophy-image"><?php esc_html_e('Image URL', 'central-build'); ?></label></th>
                        <td><input type="text" id="cb-about-philosophy-image" name="central_build_about_settings[philosophy][image]" class="large-text" value="<?php echo esc_url($settings['philosophy']['image']); ?>" /></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-about-philosophy-heading"><?php esc_html_e('Heading', 'central-build'); ?></label></th>
                        <td><input type="text" id="cb-about-philosophy-heading" name="central_build_about_settings[philosophy][heading]" class="regular-text" value="<?php echo esc_attr($settings['philosophy']['heading']); ?>" /></td>
                    </tr>
                    <tr>
                        <th scope="row"><?php esc_html_e('Paragraphs', 'central-build'); ?></th>
                        <td>
                            <?php foreach ($settings['philosophy']['paragraphs'] as $index => $paragraph) : ?>
                                <textarea name="central_build_about_settings[philosophy][paragraphs][<?php echo esc_attr($index); ?>]" rows="3" class="large-text" style="margin-bottom: 10px;"><?php echo esc_textarea($paragraph); ?></textarea>
                            <?php endforeach; ?>
                            <textarea name="central_build_about_settings[philosophy][paragraphs][]" rows="3" class="large-text" placeholder="<?php esc_attr_e('Add another paragraph…', 'central-build'); ?>"></textarea>
                        </td>
                    </tr>
                </tbody>
            </table>

            <h2 class="title"><?php esc_html_e('Services', 'central-build'); ?></h2>
            <div class="central-build-repeatable" id="cb-about-services">
                <?php foreach ($settings['services'] as $index => $service) : ?>
                    <div class="central-build-repeatable__item">
                        <div class="central-build-repeatable__head">
                            <strong><?php printf(esc_html__('Service %d', 'central-build'), $index + 1); ?></strong>
                            <button type="button" class="button button-link-delete central-build-repeatable__remove" data-repeatable-remove><?php esc_html_e('Remove', 'central-build'); ?></button>
                        </div>
                        <div class="central-build-repeatable__body">
                            <p>
                                <label>
                                    <?php esc_html_e('Title', 'central-build'); ?><br />
                                    <input type="text" name="central_build_about_settings[services][<?php echo esc_attr($index); ?>][title]" class="regular-text" value="<?php echo esc_attr($service['title']); ?>" />
                                </label>
                            </p>
                            <p>
                                <label>
                                    <?php esc_html_e('URL', 'central-build'); ?><br />
                                    <input type="text" name="central_build_about_settings[services][<?php echo esc_attr($index); ?>][url]" class="regular-text" value="<?php echo esc_url($service['url']); ?>" />
                                </label>
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="button" class="button" data-repeatable-add data-repeatable-target="cb-about-services" data-repeatable-template="cb-about-service-template"><?php esc_html_e('Add Service', 'central-build'); ?></button>

            <h2 class="title"><?php esc_html_e('Call to Action', 'central-build'); ?></h2>
            <table class="form-table" role="presentation">
                <tbody>
                    <tr>
                        <th scope="row"><label for="cb-about-cta-text"><?php esc_html_e('CTA Text', 'central-build'); ?></label></th>
                        <td><input type="text" id="cb-about-cta-text" name="central_build_about_settings[cta][text]" class="regular-text" value="<?php echo esc_attr($settings['cta']['text']); ?>" /></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-about-cta-url"><?php esc_html_e('CTA URL', 'central-build'); ?></label></th>
                        <td><input type="text" id="cb-about-cta-url" name="central_build_about_settings[cta][url]" class="regular-text" value="<?php echo esc_url($settings['cta']['url']); ?>" /></td>
                    </tr>
                </tbody>
            </table>

            <h2 class="title"><?php esc_html_e('Right Column', 'central-build'); ?></h2>
            <table class="form-table" role="presentation">
                <tbody>
                    <tr>
                        <th scope="row"><label for="cb-about-right-heading"><?php esc_html_e('Heading', 'central-build'); ?></label></th>
                        <td><input type="text" id="cb-about-right-heading" name="central_build_about_settings[right_column][heading]" class="regular-text" value="<?php echo esc_attr($settings['right_column']['heading']); ?>" /></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cb-about-right-paragraph"><?php esc_html_e('Paragraph', 'central-build'); ?></label></th>
                        <td><textarea id="cb-about-right-paragraph" name="central_build_about_settings[right_column][paragraph]" rows="3" class="large-text"><?php echo esc_textarea($settings['right_column']['paragraph']); ?></textarea></td>
                    </tr>
                </tbody>
            </table>

            <h2 class="title"><?php esc_html_e('Team', 'central-build'); ?></h2>
            <table class="form-table" role="presentation">
                <tbody>
                    <tr>
                        <th scope="row"><?php esc_html_e('Display Team Section', 'central-build'); ?></th>
                        <td>
                            <label>
                                <input type="checkbox" name="central_build_about_settings[team][show]" value="1" <?php checked($settings['team']['show']); ?> />
                                <?php esc_html_e('Enable "Our Team" section on the About page', 'central-build'); ?>
                            </label>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="central-build-repeatable" id="cb-about-team">
                <?php if (!empty($settings['team']['members'])) :
                    foreach ($settings['team']['members'] as $index => $member) : ?>
                        <div class="central-build-repeatable__item">
                            <div class="central-build-repeatable__head">
                                <strong><?php printf(esc_html__('Member %d', 'central-build'), $index + 1); ?></strong>
                                <button type="button" class="button button-link-delete central-build-repeatable__remove" data-repeatable-remove><?php esc_html_e('Remove', 'central-build'); ?></button>
                            </div>
                            <div class="central-build-repeatable__body">
                                <p>
                                    <label>
                                        <?php esc_html_e('Name', 'central-build'); ?><br />
                                        <input type="text" name="central_build_about_settings[team][members][<?php echo esc_attr($index); ?>][name]" class="regular-text" value="<?php echo esc_attr($member['name']); ?>" />
                                    </label>
                                </p>
                                <p>
                                    <label>
                                        <?php esc_html_e('Role', 'central-build'); ?><br />
                                        <input type="text" name="central_build_about_settings[team][members][<?php echo esc_attr($index); ?>][role]" class="regular-text" value="<?php echo esc_attr($member['role']); ?>" />
                                    </label>
                                </p>
                                <p>
                                    <label>
                                        <?php esc_html_e('Image URL', 'central-build'); ?><br />
                                        <input type="text" name="central_build_about_settings[team][members][<?php echo esc_attr($index); ?>][image]" class="regular-text" value="<?php echo esc_url($member['image']); ?>" />
                                    </label>
                                </p>
                            </div>
                        </div>
                    <?php endforeach;
                endif; ?>
            </div>
            <button type="button" class="button" data-repeatable-add data-repeatable-target="cb-about-team" data-repeatable-template="cb-about-team-template"><?php esc_html_e('Add Team Member', 'central-build'); ?></button>

            <p class="submit">
                <button type="submit" name="central_build_about_settings_submit" class="button button-primary"><?php esc_html_e('Save About Us Settings', 'central-build'); ?></button>
            </p>
        </form>
    </div>

    <script type="text/template" id="cb-about-service-template">
        <div class="central-build-repeatable__item">
            <div class="central-build-repeatable__head">
                <strong><?php esc_html_e('Service', 'central-build'); ?></strong>
                <button type="button" class="button button-link-delete central-build-repeatable__remove" data-repeatable-remove><?php esc_html_e('Remove', 'central-build'); ?></button>
            </div>
            <div class="central-build-repeatable__body">
                <p>
                    <label>
                        <?php esc_html_e('Title', 'central-build'); ?><br />
                        <input type="text" name="central_build_about_settings[services][__INDEX__][title]" class="regular-text" />
                    </label>
                </p>
                <p>
                    <label>
                        <?php esc_html_e('URL', 'central-build'); ?><br />
                        <input type="text" name="central_build_about_settings[services][__INDEX__][url]" class="regular-text" />
                    </label>
                </p>
            </div>
        </div>
    </script>

    <script type="text/template" id="cb-about-team-template">
        <div class="central-build-repeatable__item">
            <div class="central-build-repeatable__head">
                <strong><?php esc_html_e('Team Member', 'central-build'); ?></strong>
                <button type="button" class="button button-link-delete central-build-repeatable__remove" data-repeatable-remove><?php esc_html_e('Remove', 'central-build'); ?></button>
            </div>
            <div class="central-build-repeatable__body">
                <p>
                    <label>
                        <?php esc_html_e('Name', 'central-build'); ?><br />
                        <input type="text" name="central_build_about_settings[team][members][__INDEX__][name]" class="regular-text" />
                    </label>
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Role', 'central-build'); ?><br />
                        <input type="text" name="central_build_about_settings[team][members][__INDEX__][role]" class="regular-text" />
                    </label>
                </p>
                <p>
                    <label>
                        <?php esc_html_e('Image URL', 'central-build'); ?><br />
                        <input type="text" name="central_build_about_settings[team][members][__INDEX__][image]" class="regular-text" />
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

function central_build_about_settings_menu(): void
{
    add_theme_page(
        __('About Us Settings', 'central-build'),
        __('About Us Settings', 'central-build'),
        'manage_options',
        'central-build-about-settings',
        'central_build_about_settings_page_render'
    );
}
add_action('admin_menu', 'central_build_about_settings_menu');
