<?php
/**
 * Central Build Pro Admin Options
 *
 * @package Central_Build_Pro
 * @since 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add admin menu
 */
function central_build_admin_menu()
{
    add_menu_page(
        __('Central Build Options', 'central-build'),
        __('Central Build', 'central-build'),
        'manage_options',
        'central-build-options',
        'central_build_options_page',
        'dashicons-admin-home',
        30
    );
}
add_action('admin_menu', 'central_build_admin_menu');

/**
 * Register settings
 */
function central_build_register_settings()
{
    // Hero Section Settings
    register_setting('central_build_hero_settings', 'central_build_hero_title');
    register_setting('central_build_hero_settings', 'central_build_hero_description');
    register_setting('central_build_hero_settings', 'central_build_hero_button_text');
    register_setting('central_build_hero_settings', 'central_build_hero_button_subtext');
    register_setting('central_build_hero_settings', 'central_build_hero_button_url');

    // About Section Settings
    register_setting('central_build_about_settings', 'central_build_about_title');
    register_setting('central_build_about_settings', 'central_build_about_description');
    register_setting('central_build_about_settings', 'central_build_about_image');
    register_setting('central_build_about_settings', 'central_build_about_features');

    // Trust Section Settings
    register_setting('central_build_trust_settings', 'central_build_trust_title');
    register_setting('central_build_trust_settings', 'central_build_trust_features');

    // Partners Section Settings
    register_setting('central_build_partners_settings', 'central_build_partners');

    // Testimonials Section Settings
    register_setting('central_build_testimonials_settings', 'central_build_testimonials_tag');
    register_setting('central_build_testimonials_settings', 'central_build_testimonials_title');
    register_setting('central_build_testimonials_settings', 'central_build_testimonials_description');
    register_setting('central_build_testimonials_settings', 'central_build_testimonials_button_text');
    register_setting('central_build_testimonials_settings', 'central_build_testimonials_button_subtext');
    register_setting('central_build_testimonials_settings', 'central_build_testimonials_button_url');
    register_setting('central_build_testimonials_settings', 'central_build_testimonials_image');
    register_setting('central_build_testimonials_settings', 'central_build_testimonials');

    // Projects Section Settings
    register_setting('central_build_projects_settings', 'central_build_projects_title');
    register_setting('central_build_projects_settings', 'central_build_projects_subtitle');
    register_setting('central_build_projects_settings', 'central_build_process_steps');
    register_setting('central_build_projects_settings', 'central_build_project_images');
    register_setting('central_build_projects_settings', 'central_build_projects_button_text');
    register_setting('central_build_projects_settings', 'central_build_projects_button_subtext');
    register_setting('central_build_projects_settings', 'central_build_projects_button_url');
    register_setting('central_build_projects_settings', 'central_build_stats');
    register_setting('central_build_projects_settings', 'central_build_cta_title');
    register_setting('central_build_projects_settings', 'central_build_cta_description');
    register_setting('central_build_projects_settings', 'central_build_cta_button_text');
    register_setting('central_build_projects_settings', 'central_build_cta_button_subtext');
    register_setting('central_build_projects_settings', 'central_build_cta_button_url');
    register_setting('central_build_projects_settings', 'central_build_cta_background_image');

    // Commercial Section Settings
    register_setting('central_build_commercial_settings', 'central_build_commercial_tag');
    register_setting('central_build_commercial_settings', 'central_build_commercial_title');
    register_setting('central_build_commercial_settings', 'central_build_commercial_projects');

    // Sectors Section Settings
    register_setting('central_build_sectors_settings', 'central_build_checkout_icon');
    register_setting('central_build_sectors_settings', 'central_build_checkout_title');
    register_setting('central_build_sectors_settings', 'central_build_checkout_button_text');
    register_setting('central_build_sectors_settings', 'central_build_checkout_button_subtext');
    register_setting('central_build_sectors_settings', 'central_build_checkout_button_url');
    register_setting('central_build_sectors_settings', 'central_build_sectors');

    // FAQ Section Settings
    register_setting('central_build_faq_settings', 'central_build_faq_title');
    register_setting('central_build_faq_settings', 'central_build_transform_title');
    register_setting('central_build_faq_settings', 'central_build_transform_button_text');
    register_setting('central_build_faq_settings', 'central_build_transform_button_subtext');
    register_setting('central_build_faq_settings', 'central_build_transform_button_url');
    register_setting('central_build_faq_settings', 'central_build_faqs');
    register_setting('central_build_faq_settings', 'central_build_transform_features');

    // Section Visibility Settings
    register_setting('central_build_visibility_settings', 'central_build_show_hero_section');
    register_setting('central_build_visibility_settings', 'central_build_show_about_section');
    register_setting('central_build_visibility_settings', 'central_build_show_trust_section');
    register_setting('central_build_visibility_settings', 'central_build_show_partners_section');
    register_setting('central_build_visibility_settings', 'central_build_show_testimonials_section');
    register_setting('central_build_visibility_settings', 'central_build_show_projects_section');
    register_setting('central_build_visibility_settings', 'central_build_show_commercial_section');
    register_setting('central_build_visibility_settings', 'central_build_show_cta_section');
    register_setting('central_build_visibility_settings', 'central_build_show_faq_section');
    register_setting('central_build_visibility_settings', 'central_build_show_faq_transform_section');
}
add_action('admin_init', 'central_build_register_settings');

/**
 * Set default values for options
 */
function central_build_set_default_options()
{
    // Hero Section Defaults
    if (!get_option('central_build_hero_title')) {
        update_option('central_build_hero_title', __('Your Commercial Fitout, Made Simple', 'central-build'));
    }
    if (!get_option('central_build_hero_description')) {
        update_option('central_build_hero_description', __('A commercial fitout can feel like a lot especially if it\'s your first one. We\'re here to make it simple. From the start, you\'ll have a clear plan, fixed costs, and one team guiding you through the process. No variations. No confusion. Just a space that\'s built properly, so you can focus on your business.', 'central-build'));
    }
    if (!get_option('central_build_hero_button_text')) {
        update_option('central_build_hero_button_text', __('Start Your Fitout Journey', 'central-build'));
    }
    if (!get_option('central_build_hero_button_subtext')) {
        update_option('central_build_hero_button_subtext', __('Learn more', 'central-build'));
    }
    if (!get_option('central_build_hero_button_url')) {
        update_option('central_build_hero_button_url', home_url('/commercial-shop-fitting'));
    }

    // About Section Defaults
    if (!get_option('central_build_about_title')) {
        update_option('central_build_about_title', 'Built on Expertise and Purpose');
    }
    if (!get_option('central_build_about_description')) {
        update_option('central_build_about_description', 'We know commercial fitouts inside and out. With years of experience and a commitment to quality, we deliver spaces that work for your business. Our approach is straightforward: understand your needs, create a plan, and execute it flawlessly.');
    }
    if (!get_option('central_build_about_image')) {
        update_option('central_build_about_image', get_template_directory_uri() . '/images/about-image.jpg');
    }
    if (!get_option('central_build_about_feature_1_title')) {
        update_option('central_build_about_feature_1_title', 'Expert Team');
    }
    if (!get_option('central_build_about_feature_1_description')) {
        update_option('central_build_about_feature_1_description', 'Skilled professionals with years of commercial fitout experience.');
    }
    if (!get_option('central_build_about_feature_2_title')) {
        update_option('central_build_about_feature_2_title', 'Quality Materials');
    }
    if (!get_option('central_build_about_feature_2_description')) {
        update_option('central_build_about_feature_2_description', 'We use only the finest materials to ensure lasting results.');
    }
    if (!get_option('central_build_about_feature_3_title')) {
        update_option('central_build_about_feature_3_title', 'On-Time Delivery');
    }
    if (!get_option('central_build_about_feature_3_description')) {
        update_option('central_build_about_feature_3_description', 'Your project will be completed on schedule, every time.');
    }
    if (!get_option('central_build_about_feature_4_title')) {
        update_option('central_build_about_feature_4_title', 'Built-in Compliance');
    }
    if (!get_option('central_build_about_feature_4_description')) {
        update_option('central_build_about_feature_4_description', 'We take care of approvals, permits, and builder certifications so you avoid delays and paperwork headaches.');
    }

    // Trust Section Defaults
    if (!get_option('central_build_trust_title')) {
        update_option('central_build_trust_title', __('Trust in<br>Central Build Process', 'central-build'));
    }

    // Set default about features
    if (!get_option('central_build_about_features')) {
        $about_features = array(
            array(
                'title' => __('Expert Team', 'central-build'),
                'description' => __('Skilled professionals with years of commercial fitout experience.', 'central-build')
            ),
            array(
                'title' => __('Quality Materials', 'central-build'),
                'description' => __('We use only the finest materials to ensure lasting results.', 'central-build')
            ),
            array(
                'title' => __('On-Time Delivery', 'central-build'),
                'description' => __('Your project will be completed on schedule, every time.', 'central-build')
            ),
            array(
                'title' => __('Built-in Compliance', 'central-build'),
                'description' => __('We take care of approvals, permits, and builder certifications so you avoid delays and paperwork headaches.', 'central-build')
            )
        );
        update_option('central_build_about_features', $about_features);
    }

    // Set default trust features
    if (!get_option('central_build_trust_features')) {
        $trust_features = array(
            array(
                'icon' => get_template_directory_uri() . '/images/66f1ffecdef9310969f579e0_Engg-Icon.svg',
                'title' => __('A Structured Fitout Process', 'central-build'),
                'description' => __('Most delays happen because of poor planning. We solve that with a clear, step-by-step process built around your business needs. From the start, you\'ll know what\'s happening, when it\'s happening, and what to expect next. With built-in approvals and check-ins along the way, there\'s no confusion or chaos — just structure you can rely on.', 'central-build')
            ),
            array(
                'icon' => get_template_directory_uri() . '/images/66f1ffecdef9310969f57a0a_Project-Icon.svg',
                'title' => __('Hands-On Project Support', 'central-build'),
                'description' => __('You won\'t be chasing trades or wondering what\'s going on onsite. You\'ll have a dedicated project manager who coordinates everything from permits and council approvals to joinery installation. We deal with the issues before they affect your timeline, and keep you informed without overwhelming you.', 'central-build')
            ),
            array(
                'icon' => get_template_directory_uri() . '/images/66f1ffecdef9310969f579df_Financial-Icon.svg',
                'title' => __('Transparent Cost Management', 'central-build'),
                'description' => __('We don\'t do vague quotes or "TBC" allowances. Every quote is detailed, costed properly, and confirmed with our trades. That means you know where every dollar is going before the build starts. If anything changes, we talk it through with you — no surprise charges or last-minute add-ons.', 'central-build')
            )
        );
        update_option('central_build_trust_features', $trust_features);
    }

    // Set default partners
    if (!get_option('central_build_partners')) {
        $partners = array();
        update_option('central_build_partners', $partners);
    }

    // Testimonials Section Defaults
    if (!get_option('central_build_testimonials_tag')) {
        update_option('central_build_testimonials_tag', __('Testimonial', 'central-build'));
    }
    if (!get_option('central_build_testimonials_title')) {
        update_option('central_build_testimonials_title', __('Words from Those Who\'ve Trusted Us', 'central-build'));
    }
    if (!get_option('central_build_testimonials_description')) {
        update_option('central_build_testimonials_description', __('Discover why clients trust us for their Fitouts. Our commitment to quality and on-time delivery is reflected in their positive feedback.', 'central-build'));
    }
    if (!get_option('central_build_testimonials_button_text')) {
        update_option('central_build_testimonials_button_text', __('Testimonials', 'central-build'));
    }
    if (!get_option('central_build_testimonials_button_subtext')) {
        update_option('central_build_testimonials_button_subtext', __('Learn more', 'central-build'));
    }
    if (!get_option('central_build_testimonials_button_url')) {
        update_option('central_build_testimonials_button_url', home_url('/testimonials'));
    }
    if (!get_option('central_build_testimonials_image')) {
        update_option('central_build_testimonials_image', get_template_directory_uri() . '/images/674e51387cf2d3270f527a62_ENP03761%20(Large).webp');
    }

    // Projects Section Defaults
    if (!get_option('central_build_projects_title')) {
        update_option('central_build_projects_title', __('Start Your Fitout Journey Today', 'central-build'));
    }
    if (!get_option('central_build_projects_subtitle')) {
        update_option('central_build_projects_subtitle', __('Don\'t Fit in with your Average Fitout.', 'central-build'));
    }

    // Set default testimonials
    if (!get_option('central_build_testimonials')) {
        $testimonials = array();
        update_option('central_build_testimonials', $testimonials);
    }

    // Set default process steps
    if (!get_option('central_build_process_steps')) {
        $process_steps = array();
        update_option('central_build_process_steps', $process_steps);
    }

    // Set default project images
    if (!get_option('central_build_project_images')) {
        $project_images = array(
            array(
                'image' => get_template_directory_uri() . '/images/674f9b92faa922f1c9d341e8_ENP01158%20(Large).jpg',
                'alt' => __('Central Build project team on site at commercial fitout', 'central-build')
            ),
            array(
                'image' => get_template_directory_uri() . '/images/674f9b802ae4a2d428b5a641_ENP05602-2%20(Large).jpg',
                'alt' => __('Central Build project team on site at commercial fitout', 'central-build')
            ),
            array(
                'image' => get_template_directory_uri() . '/images/674f9b5ff94e758f82264b97_ENP09869-2%20(Large).jpg',
                'alt' => __('Central Build project team on site at commercial fitout', 'central-build')
            )
        );
        update_option('central_build_project_images', $project_images);
    }

    // Set default statistics
    if (!get_option('central_build_stats')) {
        $stats = array(
            array('number' => '24+', 'label' => 'years of experience'),
            array('number' => '4.8/5', 'label' => 'Client Satisfaction'),
            array('number' => '168', 'label' => 'projects done'),
            array('number' => '98%', 'label' => 'project on time')
        );
        update_option('central_build_stats', $stats);
    }

    // Set default commercial projects
    if (!get_option('central_build_commercial_projects')) {
        $commercial_projects = array();
        update_option('central_build_commercial_projects', $commercial_projects);
    }

    // Set default sectors
    if (!get_option('central_build_sectors')) {
        $sectors = array(
            array(
                'icon' => get_template_directory_uri() . '/images/66f1ffecdef9310969f57ce4_Home%20Three%20Icon%20(2).svg',
                'tag' => __('Office', 'central-build'),
                'title' => __('Office Fitout', 'central-build'),
                'description' => __('Transform your workspace into a productive and stylish environment with our tailored Office Fitouts.', 'central-build'),
                'image' => get_template_directory_uri() . '/images/674fb0ac8b2be968fa78a53b_MAIN_OFFICE_3.3.1%20(Large).png',
                'image_alt' => __('Ray White Rochedale Office Fitout', 'central-build'),
                'url' => '/fitout-sectors/office-fitout'
            ),
            array(
                'icon' => get_template_directory_uri() . '/images/674e4af6a81ec22fb406f986_2.svg',
                'tag' => __('Hospitality', 'central-build'),
                'title' => __('Hospitality Fitout', 'central-build'),
                'description' => __('Create an inviting ambiance that impresses guests with our custom Hospitality Fitouts.', 'central-build'),
                'image' => get_template_directory_uri() . '/images/674e3fad63d734034c3a7b42_DSC04865-HDR%20(Large).webp',
                'image_alt' => __('Ippin Dining Hospitality Fitout', 'central-build'),
                'url' => '/fitout-sectors/hospitality-fitout'
            ),
            array(
                'icon' => get_template_directory_uri() . '/images/66f1ffecdef9310969f57ce3_Home%20Three%20Icon%20(3).svg',
                'tag' => __('Retail', 'central-build'),
                'title' => __('Retail Fitout', 'central-build'),
                'description' => __('Revamp your retail space with designs that attract customers and drive sales.', 'central-build'),
                'image' => get_template_directory_uri() . '/images/674fb59ca04815b79062e722_1%20(Large).jpg',
                'image_alt' => __('MOOII Brisbane CBD Retail Fitout', 'central-build'),
                'url' => '/fitout-sectors/retail-fitout'
            ),
            array(
                'icon' => get_template_directory_uri() . '/images/674e4af6a81ec22fb406f983_3.svg',
                'tag' => __('Mezzanine', 'central-build'),
                'title' => __('Mezzanine Fitout', 'central-build'),
                'description' => __('Maximize space efficiently with our functional and innovative Mezzanine Fitouts.', 'central-build'),
                'image' => get_template_directory_uri() . '/images/674e4af6a81ec22fb406f992_DSC01452-2%20(Small).webp',
                'image_alt' => __('Mezzanine Fitout In Parkridge', 'central-build'),
                'url' => '/fitout-sectors/mezzanine-fitout'
            ),
            array(
                'icon' => get_template_directory_uri() . '/images/674e4af6a81ec22fb406f984_1.svg',
                'tag' => __('Medical', 'central-build'),
                'title' => __('Medical Fitout', 'central-build'),
                'description' => __('Transform healthcare spaces with Central Build. We specialize in functional, patient-focused medical fitouts tailored to your practice\'s needs.', 'central-build'),
                'image' => get_template_directory_uri() . '/images/674fb9db3d96c35876d4b314_0Y7A4128%20(Large).jpg',
                'image_alt' => __('Richlands Dental Medical Fitout', 'central-build'),
                'url' => '/fitout-sectors/medical-fitout'
            )
        );
        update_option('central_build_sectors', $sectors);
    }
    
    // Set default checkout section settings
    if (!get_option('central_build_checkout_icon')) {
        update_option('central_build_checkout_icon', get_template_directory_uri() . '/images/66e8b10d2841cb4cd4932dbe_Innovation-Icon.svg');
    }
    if (!get_option('central_build_checkout_title')) {
        update_option('central_build_checkout_title', __('Commercial Fitout Sectors', 'central-build'));
    }
    if (!get_option('central_build_checkout_button_text')) {
        update_option('central_build_checkout_button_text', __('Check out our Portfolio', 'central-build'));
    }
    if (!get_option('central_build_checkout_button_subtext')) {
        update_option('central_build_checkout_button_subtext', __('Learn more', 'central-build'));
    }
    if (!get_option('central_build_checkout_button_url')) {
        update_option('central_build_checkout_button_url', home_url('/contact'));
    }

    // Commercial Section Defaults
    if (!get_option('central_build_commercial_tag')) {
        update_option('central_build_commercial_tag', __('Service', 'central-build'));
    }
    if (!get_option('central_build_commercial_title')) {
        update_option('central_build_commercial_title', __('Check out <br>our latest work', 'central-build'));
    }

    // FAQ Section Defaults
    if (!get_option('central_build_faq_title')) {
        update_option('central_build_faq_title', __('Frequently Asked Question', 'central-build'));
    }
    if (!get_option('central_build_transform_title')) {
        update_option('central_build_transform_title', __('Ready to Transform Your space?', 'central-build'));
    }

    // Set default FAQ items
    if (!get_option('central_build_faqs')) {
        $faqs = array(
            array(
                'question' => __('What Are The Charges of Shop Fitout?', 'central-build'),
                'answer' => __('As an experienced fitout company, we provide precise cost estimates, considering factors such as floor area, material selection, and design complexity. We are committed to transparency, ensuring no hidden costs in our services.', 'central-build')
            ),
            array(
                'question' => __('What is Project Timing in A Fitout Project?', 'central-build'),
                'answer' => __('Project timing varies with complexity, but our commercial Fitout projects typically take between 4 to 12 weeks from start to completion.', 'central-build')
            ),
            array(
                'question' => __('Do I need a design ready before starting the fitout process?', 'central-build'),
                'answer' => __('No, having a design is not mandatory. We offer comprehensive design services and work closely with our partners to guide you through the entire commercial Fitout design process.', 'central-build')
            ),
            array(
                'question' => __('When can the fitout process begin?', 'central-build'),
                'answer' => __('We can commence the fitout as soon as the design is finalized and all necessary materials and certifications are in place.', 'central-build')
            )
        );
        update_option('central_build_faqs', $faqs);
    }

    // Set default transform features
    if (!get_option('central_build_transform_features')) {
        $transform_features = array(
            array(
                'icon' => get_template_directory_uri() . '/images/66f1ffecdef9310969f579e3_Freely-Icon.svg',
                'title' => __('Free Consultation', 'central-build'),
                'description' => __('Schedule a no-obligation Consultation', 'central-build')
            ),
            array(
                'icon' => get_template_directory_uri() . '/images/66f1ffecdef9310969f579e3_Freely-Icon.svg',
                'title' => __('Custom Design', 'central-build'),
                'description' => __('Tailored solutions to fit your vision.', 'central-build')
            ),
            array(
                'icon' => get_template_directory_uri() . '/images/66f1ffecdef9310969f579e3_Freely-Icon.svg',
                'title' => __('Quick Start', 'central-build'),
                'description' => __('Projects commence as soon as designs are finalized.', 'central-build')
            )
        );
        update_option('central_build_transform_features', $transform_features);
    }

    // Set default section visibility
    $sections = array(
        'central_build_show_hero_section',
        'central_build_show_about_section',
        'central_build_show_trust_section',
        'central_build_show_partners_section',
        'central_build_show_testimonials_section',
        'central_build_show_projects_section',
        'central_build_show_commercial_section',
        'central_build_show_cta_section',
        'central_build_show_faq_section',
        'central_build_show_faq_transform_section'
    );

    foreach ($sections as $section) {
        if (get_option($section) === false) {
            update_option($section, 1);
        }
    }
}
add_action('after_switch_theme', 'central_build_set_default_options');

/**
 * Migrate old data format to new dynamic format
 */
function central_build_migrate_old_data() {
    // Check if migration has already been done
    if (get_option('central_build_migration_done')) {
        return;
    }
    
    // Migrate about features
    $about_features = array();
    for ($i = 1; $i <= 4; $i++) {
        $title = get_option("central_build_about_feature_{$i}_title");
        $description = get_option("central_build_about_feature_{$i}_description");
        
        if ($title || $description) {
            $about_features[] = array(
                'title' => $title,
                'description' => $description
            );
        }
    }
    if (!empty($about_features)) {
        update_option('central_build_about_features', $about_features);
    }
    
    // Migrate trust features
    $trust_features = array();
    for ($i = 1; $i <= 3; $i++) {
        $icon = get_option("central_build_trust_feature{$i}_icon");
        $title = get_option("central_build_trust_feature{$i}_title");
        $description = get_option("central_build_trust_feature{$i}_description");
        
        if ($title || $description || $icon) {
            $trust_features[] = array(
                'icon' => $icon,
                'title' => $title,
                'description' => $description
            );
        }
    }
    if (!empty($trust_features)) {
        update_option('central_build_trust_features', $trust_features);
    }
    
    // Migrate partners
    $partners = array();
    for ($i = 1; $i <= 12; $i++) {
        $logo = get_option("central_build_partner_{$i}_logo");
        $name = get_option("central_build_partner_{$i}_name");
        $url = get_option("central_build_partner_{$i}_url");
        
        if ($logo || $name || $url) {
            $partners[] = array(
                'logo' => $logo,
                'name' => $name,
                'url' => $url
            );
        }
    }
    if (!empty($partners)) {
        update_option('central_build_partners', $partners);
    }
    
    // Migrate testimonials
    $testimonials = array();
    for ($i = 1; $i <= 3; $i++) {
        $content = get_option("central_build_testimonial_{$i}_content");
        $name = get_option("central_build_testimonial_{$i}_name");
        $position = get_option("central_build_testimonial_{$i}_position");
        $image = get_option("central_build_testimonial_{$i}_image");
        
        if ($content || $name) {
            $testimonials[] = array(
                'content' => $content,
                'name' => $name,
                'position' => $position,
                'image' => $image
            );
        }
    }
    if (!empty($testimonials)) {
        update_option('central_build_testimonials', $testimonials);
    }
    
    // Migrate commercial projects
    $projects = array();
    for ($i = 1; $i <= 8; $i++) {
        $image = get_option("central_build_commercial_project_{$i}_image");
        $title = get_option("central_build_commercial_project_{$i}_title");
        $url = get_option("central_build_commercial_project_{$i}_url");
        $alt = get_option("central_build_commercial_project_{$i}_alt");
        
        if ($image || $title) {
            $projects[] = array(
                'image' => $image,
                'title' => $title,
                'url' => $url,
                'alt' => $alt
            );
        }
    }
    if (!empty($projects)) {
        update_option('central_build_commercial_projects', $projects);
    }
    
    // Migrate sectors
    $sectors = array();
    for ($i = 1; $i <= 5; $i++) {
        $icon = get_option("central_build_sector_{$i}_icon");
        $tag = get_option("central_build_sector_{$i}_tag");
        $title = get_option("central_build_sector_{$i}_title");
        $description = get_option("central_build_sector_{$i}_description");
        $image = get_option("central_build_sector_{$i}_image");
        $image_alt = get_option("central_build_sector_{$i}_image_alt");
        $url = get_option("central_build_sector_{$i}_url");
        
        if ($title || $description) {
            $sectors[] = array(
                'icon' => $icon,
                'tag' => $tag,
                'title' => $title,
                'description' => $description,
                'image' => $image,
                'image_alt' => $image_alt,
                'url' => $url
            );
        }
    }
    if (!empty($sectors)) {
        update_option('central_build_sectors', $sectors);
    }
    
    // Migrate FAQs
    $faqs = array();
    for ($i = 1; $i <= 5; $i++) {
        $question = get_option("central_build_faq_{$i}_question");
        $answer = get_option("central_build_faq_{$i}_answer");
        
        if ($question || $answer) {
            $faqs[] = array(
                'question' => $question,
                'answer' => $answer
            );
        }
    }
    if (!empty($faqs)) {
        update_option('central_build_faqs', $faqs);
    }
    
    // Migrate transform features
    $transform_features = array();
    for ($i = 1; $i <= 3; $i++) {
        $icon = get_option("central_build_transform_feature_{$i}_icon");
        $title = get_option("central_build_transform_feature_{$i}_title");
        $description = get_option("central_build_transform_feature_{$i}_description");
        
        if ($title || $description) {
            $transform_features[] = array(
                'icon' => $icon,
                'title' => $title,
                'description' => $description
            );
        }
    }
    if (!empty($transform_features)) {
        update_option('central_build_transform_features', $transform_features);
    }
    
    // Migrate stats
    $stats = array();
    for ($i = 1; $i <= 4; $i++) {
        $number = get_option("central_build_stat_{$i}_number");
        $label = get_option("central_build_stat_{$i}_label");
        
        if ($number || $label) {
            $stats[] = array(
                'number' => $number,
                'label' => $label
            );
        }
    }
    if (!empty($stats)) {
        update_option('central_build_stats', $stats);
    }
    
    // Migrate process steps
    $process_steps = array();
    for ($i = 1; $i <= 3; $i++) {
        $icon = get_option("central_build_process_step_{$i}_icon");
        $title = get_option("central_build_process_step_{$i}_title");
        $description = get_option("central_build_process_step_{$i}_description");
        
        if ($title || $description) {
            $process_steps[] = array(
                'icon' => $icon,
                'title' => $title,
                'description' => $description
            );
        }
    }
    if (!empty($process_steps)) {
        update_option('central_build_process_steps', $process_steps);
    }
    
    // Migrate project images
    $project_images = array();
    for ($i = 1; $i <= 3; $i++) {
        $image = get_option("central_build_project_image_{$i}");
        $alt = get_option("central_build_project_image_{$i}_alt");
        
        if ($image) {
            $project_images[] = array(
                'image' => $image,
                'alt' => $alt
            );
        }
    }
    if (!empty($project_images)) {
        update_option('central_build_project_images', $project_images);
    }
    
    // Mark migration as done
    update_option('central_build_migration_done', true);
}
add_action('admin_init', 'central_build_migrate_old_data');

/**
 * Options page HTML
 */
function central_build_options_page()
{
    ?>
    <div class="wrap">
        <h1><?php esc_html_e('Central Build Pro Options', 'central-build'); ?></h1>
        
        <?php
        // Handle form submission
        if (isset($_POST['submit'])) {
            $active_tab = isset($_POST['active_tab']) ? sanitize_text_field($_POST['active_tab']) : 'hero';
            echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__('Settings saved successfully!', 'central-build') . '</p></div>';
        }

    $active_tab = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : 'hero';
    ?>
        
        <h2 class="nav-tab-wrapper">
            <a href="?page=central-build-options&tab=visibility" class="nav-tab <?php echo $active_tab == 'visibility' ? 'nav-tab-active' : ''; ?>">
                <?php esc_html_e('Section Visibility', 'central-build'); ?>
            </a>
            <a href="?page=central-build-options&tab=hero" class="nav-tab <?php echo $active_tab == 'hero' ? 'nav-tab-active' : ''; ?>">
                <?php esc_html_e('Hero Section', 'central-build'); ?>
            </a>
            <a href="?page=central-build-options&tab=about" class="nav-tab <?php echo $active_tab == 'about' ? 'nav-tab-active' : ''; ?>">
                <?php esc_html_e('About Section', 'central-build'); ?>
            </a>
            <a href="?page=central-build-options&tab=trust" class="nav-tab <?php echo $active_tab == 'trust' ? 'nav-tab-active' : ''; ?>">
                <?php esc_html_e('Trust Process', 'central-build'); ?>
            </a>
            <a href="?page=central-build-options&tab=partners" class="nav-tab <?php echo $active_tab == 'partners' ? 'nav-tab-active' : ''; ?>">
                <?php esc_html_e('Partners', 'central-build'); ?>
            </a>
            <a href="?page=central-build-options&tab=testimonials" class="nav-tab <?php echo $active_tab == 'testimonials' ? 'nav-tab-active' : ''; ?>">
                <?php esc_html_e('Testimonials', 'central-build'); ?>
            </a>
            <a href="?page=central-build-options&tab=projects" class="nav-tab <?php echo $active_tab == 'projects' ? 'nav-tab-active' : ''; ?>">
                <?php esc_html_e('Projects', 'central-build'); ?>
            </a>
            <a href="?page=central-build-options&tab=commercial" class="nav-tab <?php echo $active_tab == 'commercial' ? 'nav-tab-active' : ''; ?>">
                <?php esc_html_e('Commercial', 'central-build'); ?>
            </a>
            <a href="?page=central-build-options&tab=sectors" class="nav-tab <?php echo $active_tab == 'sectors' ? 'nav-tab-active' : ''; ?>">
                <?php esc_html_e('Sectors', 'central-build'); ?>
            </a>
            <a href="?page=central-build-options&tab=faq" class="nav-tab <?php echo $active_tab == 'faq' ? 'nav-tab-active' : ''; ?>">
                <?php esc_html_e('FAQ', 'central-build'); ?>
            </a>
        </h2>

        <form method="post" action="options.php" enctype="multipart/form-data">
            <input type="hidden" name="active_tab" value="<?php echo esc_attr($active_tab); ?>" />
            
            <?php
        switch ($active_tab) {
            case 'visibility':
                settings_fields('central_build_visibility_settings');
                central_build_visibility_tab();
                break;
            case 'hero':
                settings_fields('central_build_hero_settings');
                central_build_hero_tab();
                break;
            case 'about':
                settings_fields('central_build_about_settings');
                central_build_about_tab();
                break;
            case 'trust':
                settings_fields('central_build_trust_settings');
                central_build_trust_tab();
                break;
            case 'partners':
                settings_fields('central_build_partners_settings');
                central_build_partners_tab();
                break;
            case 'testimonials':
                settings_fields('central_build_testimonials_settings');
                central_build_testimonials_tab();
                break;
            case 'projects':
                settings_fields('central_build_projects_settings');
                central_build_projects_tab();
                break;
            case 'commercial':
                settings_fields('central_build_commercial_settings');
                central_build_commercial_tab();
                break;
            case 'sectors':
                settings_fields('central_build_sectors_settings');
                central_build_sectors_tab();
                break;
            case 'faq':
                settings_fields('central_build_faq_settings');
                central_build_faq_tab();
                break;
            default:
                settings_fields('central_build_hero_settings');
                central_build_hero_tab();
                break;
        }

    submit_button();
    ?>
        </form>
    </div>

    <style>
        .central-build-admin-section {
            background: #fff;
            padding: 20px;
            margin: 20px 0;
            border: 1px solid #ccd0d4;
            box-shadow: 0 1px 1px rgba(0,0,0,.04);
        }
        .central-build-admin-section h3 {
            margin-top: 0;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        .central-build-field-group {
            margin-bottom: 20px;
            padding: 15px;
            background: #f9f9f9;
            border-left: 4px solid #0073aa;
        }
        .central-build-field-group h4 {
            margin-top: 0;
            color: #0073aa;
        }
        .central-build-image-preview {
            max-width: 150px;
            height: auto;
            margin: 10px 0;
            border: 1px solid #ddd;
            padding: 5px;
        }
        .central-build-checkbox-group {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
            margin: 20px 0;
        }
        .central-build-checkbox-item {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            border-left: 4px solid #0073aa;
        }
        .central-build-repeatable-section {
            margin: 20px 0;
        }
        .repeatable-item {
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            overflow: hidden;
        }
        .field-header {
            background: #f1f1f1;
            padding: 10px 15px;
            border-bottom: 1px solid #ddd;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: move;
        }
        .field-header h4 {
            margin: 0;
            font-size: 14px;
        }
        .repeatable-item .form-table {
            margin: 0;
        }
        .repeatable-item .form-table th,
        .repeatable-item .form-table td {
            padding: 10px 15px;
        }
        .sort-placeholder {
            background: #f0f0f0;
            border: 2px dashed #ccc;
            height: 50px;
            margin: 10px 0;
        }
        .add-field {
            margin-top: 10px;
        }
        .remove-field {
            background: #dc3232;
            border-color: #dc3232;
            color: white;
            font-size: 12px;
            padding: 4px 8px;
            height: auto;
        }
        .remove-field:hover {
            background: #a00;
            border-color: #a00;
        }
        .error {
            border-color: #dc3232 !important;
            box-shadow: 0 0 2px rgba(220, 50, 50, 0.8);
        }
    </style>
    
    <script>
    jQuery(document).ready(function($) {
        // Initialize sortable for existing repeatable sections
        if ($.fn.sortable) {
            $('.repeatable-fields').sortable({
                handle: '.field-header',
                placeholder: 'sort-placeholder',
                update: function(event, ui) {
                    var container = $(this);
                    updateFieldNumbers(container);
                    updateFieldIndices(container);
                }
            });
        }
        
        function updateFieldNumbers(container) {
            container.children('.repeatable-item').each(function(index) {
                var fieldGroup = $(this);
                var header = fieldGroup.find('.field-header h4');
                var currentText = header.text();
                var baseText = currentText.replace(/\d+/, '').trim();
                header.text(baseText + ' ' + (index + 1));
            });
        }
        
        function updateFieldIndices(container) {
            container.children('.repeatable-item').each(function(index) {
                var fieldGroup = $(this);
                fieldGroup.attr('data-index', index);
                
                fieldGroup.find('input, textarea, select').each(function() {
                    var field = $(this);
                    var name = field.attr('name');
                    if (name) {
                        var newName = name.replace(/\[\d+\]/, '[' + index + ']');
                        field.attr('name', newName);
                    }
                });
            });
        }
    });
    </script>
    <?php
}

/**
 * Section Visibility Tab
 */
function central_build_visibility_tab()
{
    ?>
    <div class="central-build-admin-section">
        <h3><?php esc_html_e('Section Visibility Settings', 'central-build'); ?></h3>
        <p><?php esc_html_e('Control which sections are displayed on your front page.', 'central-build'); ?></p>
        
        <div class="central-build-checkbox-group">
            <?php
            $sections = array(
                'central_build_show_hero_section' => __('Hero Section', 'central-build'),
                'central_build_show_about_section' => __('About Section', 'central-build'),
                'central_build_show_trust_section' => __('Trust Process Section', 'central-build'),
                'central_build_show_partners_section' => __('Partners Section', 'central-build'),
                'central_build_show_testimonials_section' => __('Testimonials Section', 'central-build'),
                'central_build_show_projects_section' => __('Projects Section', 'central-build'),
                'central_build_show_commercial_section' => __('Commercial Section', 'central-build'),
                'central_build_show_cta_section' => __('CTA Section', 'central-build'),
                'central_build_show_faq_section' => __('FAQ Section', 'central-build'),
                'central_build_show_faq_transform_section' => __('FAQ Transform Section', 'central-build')
            );

    foreach ($sections as $option => $label) {
        $checked = get_option($option, 1) ? 'checked' : '';
        ?>
                <div class="central-build-checkbox-item">
                    <label>
                        <input type="checkbox" name="<?php echo esc_attr($option); ?>" value="1" <?php echo $checked; ?> />
                        <strong><?php echo esc_html($label); ?></strong>
                    </label>
                </div>
                <?php
    }
    ?>
        </div>
    </div>
    <?php
}

/**
 * Hero Section Tab
 */
function central_build_hero_tab()
{
    ?>
    <div class="central-build-admin-section">
        <h3><?php esc_html_e('Hero Section Settings', 'central-build'); ?></h3>
        
        <table class="form-table">
            <tr>
                <th scope="row"><?php esc_html_e('Hero Title', 'central-build'); ?></th>
                <td>
                    <input type="text" name="central_build_hero_title" value="<?php echo esc_attr(get_option('central_build_hero_title')); ?>" class="large-text" />
                </td>
            </tr>
            <tr>
                <th scope="row"><?php esc_html_e('Hero Description', 'central-build'); ?></th>
                <td>
                    <textarea name="central_build_hero_description" rows="5" class="large-text"><?php echo esc_textarea(get_option('central_build_hero_description')); ?></textarea>
                </td>
            </tr>
            <tr>
                <th scope="row"><?php esc_html_e('Button Text', 'central-build'); ?></th>
                <td>
                    <input type="text" name="central_build_hero_button_text" value="<?php echo esc_attr(get_option('central_build_hero_button_text')); ?>" class="regular-text" />
                </td>
            </tr>
            <tr>
                <th scope="row"><?php esc_html_e('Button Subtext', 'central-build'); ?></th>
                <td>
                    <input type="text" name="central_build_hero_button_subtext" value="<?php echo esc_attr(get_option('central_build_hero_button_subtext')); ?>" class="regular-text" />
                </td>
            </tr>
            <tr>
                <th scope="row"><?php esc_html_e('Button URL', 'central-build'); ?></th>
                <td>
                    <input type="url" name="central_build_hero_button_url" value="<?php echo esc_url(get_option('central_build_hero_button_url')); ?>" class="regular-text" />
                </td>
            </tr>
        </table>
    </div>
    <?php
}

/**
 * About Section Tab
 */
function central_build_about_tab()
{
    ?>
    <div class="central-build-admin-section">
        <h3><?php esc_html_e('About Section Settings', 'central-build'); ?></h3>
        
        <table class="form-table">
            <tr>
                <th scope="row"><?php esc_html_e('About Title', 'central-build'); ?></th>
                <td>
                    <input type="text" name="central_build_about_title" value="<?php echo esc_attr(get_option('central_build_about_title')); ?>" class="large-text" />
                </td>
            </tr>
            <tr>
                <th scope="row"><?php esc_html_e('About Description', 'central-build'); ?></th>
                <td>
                    <textarea name="central_build_about_description" rows="5" class="large-text"><?php echo esc_textarea(get_option('central_build_about_description')); ?></textarea>
                </td>
            </tr>
            <tr>
                <th scope="row"><?php esc_html_e('About Image', 'central-build'); ?></th>
                <td>
                    <input type="text" name="central_build_about_image" value="<?php echo esc_url(get_option('central_build_about_image')); ?>" class="large-text image-upload-field" />
                    <button type="button" class="button upload-image-button"><?php esc_html_e('Upload Image', 'central-build'); ?></button>
                </td>
            </tr>
            
        </table>
        
        <h4><?php esc_html_e('Features', 'central-build'); ?></h4>
        <div class="central-build-repeatable-section" data-section="about_features">
            <div class="repeatable-fields" id="about-features-container">
                <?php
                $about_features = get_option('central_build_about_features', array());
                if (!empty($about_features)) :
                    foreach ($about_features as $index => $feature) :
                ?>
                    <div class="central-build-field-group repeatable-item" data-index="<?php echo $index; ?>">
                        <div class="field-header">
                            <h4><?php printf(esc_html__('Feature %d', 'central-build'), $index + 1); ?></h4>
                            <button type="button" class="button remove-field"><?php esc_html_e('Remove', 'central-build'); ?></button>
                        </div>
                        <table class="form-table">
                            <tr>
                                <th scope="row"><?php esc_html_e('Title', 'central-build'); ?></th>
                                <td>
                                    <input type="text" name="central_build_about_features[<?php echo $index; ?>][title]" value="<?php echo esc_attr($feature['title'] ?? ''); ?>" class="large-text" />
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><?php esc_html_e('Description', 'central-build'); ?></th>
                                <td>
                                    <textarea name="central_build_about_features[<?php echo $index; ?>][description]" rows="3" class="large-text"><?php echo esc_textarea($feature['description'] ?? ''); ?></textarea>
                                </td>
                            </tr>
                        </table>
                    </div>
                <?php
                    endforeach;
                endif;
                ?>
            </div>
            <button type="button" class="button add-field" data-target="about-features-container" data-template="about-feature-template"><?php esc_html_e('Add Feature', 'central-build'); ?></button>
        </div>
        
        <!-- Template for new features -->
        <script type="text/template" id="about-feature-template">
            <div class="central-build-field-group repeatable-item" data-index="{INDEX}">
                <div class="field-header">
                    <h4><?php esc_html_e('New Feature', 'central-build'); ?></h4>
                    <button type="button" class="button remove-field"><?php esc_html_e('Remove', 'central-build'); ?></button>
                </div>
                <table class="form-table">
                    <tr>
                        <th scope="row"><?php esc_html_e('Title', 'central-build'); ?></th>
                        <td>
                            <input type="text" name="central_build_about_features[{INDEX}][title]" value="" class="large-text" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php esc_html_e('Description', 'central-build'); ?></th>
                        <td>
                            <textarea name="central_build_about_features[{INDEX}][description]" rows="3" class="large-text"></textarea>
                        </td>
                    </tr>
                </table>
            </div>
        </script>
        
        <table class="form-table">
        </table>
    </div>
    <?php
}

/**
 * Trust Section Tab
 */
function central_build_trust_tab()
{
    ?>
    <div class="central-build-admin-section">
        <h3><?php esc_html_e('Trust Process Section Settings', 'central-build'); ?></h3>
        
        <table class="form-table">
            <tr>
                <th scope="row"><?php esc_html_e('Section Title', 'central-build'); ?></th>
                <td>
                    <input type="text" name="central_build_trust_title" value="<?php echo esc_attr(get_option('central_build_trust_title')); ?>" class="large-text" />
                    <p class="description"><?php esc_html_e('You can use &lt;br&gt; for line breaks', 'central-build'); ?></p>
                </td>
            </tr>
        </table>

        <div class="central-build-repeatable-section" data-section="trust_features">
            <div class="repeatable-fields" id="trust-features-container">
                <?php
                $trust_features = get_option('central_build_trust_features', array());
                if (!empty($trust_features)) :
                    foreach ($trust_features as $index => $feature) :
                ?>
                    <div class="central-build-field-group repeatable-item" data-index="<?php echo $index; ?>">
                        <div class="field-header">
                            <h4><?php printf(esc_html__('Feature %d', 'central-build'), $index + 1); ?></h4>
                            <button type="button" class="button remove-field"><?php esc_html_e('Remove', 'central-build'); ?></button>
                        </div>
                        <table class="form-table">
                            <tr>
                                <th scope="row"><?php esc_html_e('Icon URL', 'central-build'); ?></th>
                                <td>
                                    <input type="url" name="central_build_trust_features[<?php echo $index; ?>][icon]" value="<?php echo esc_url($feature['icon'] ?? ''); ?>" class="large-text image-upload-field" />
                                    <button type="button" class="button upload-image-button"><?php esc_html_e('Upload Image', 'central-build'); ?></button>
                                    <?php if (!empty($feature['icon'])) : ?>
                                        <br><img src="<?php echo esc_url($feature['icon']); ?>" class="central-build-image-preview" alt="Feature Icon" />
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><?php esc_html_e('Title', 'central-build'); ?></th>
                                <td>
                                    <input type="text" name="central_build_trust_features[<?php echo $index; ?>][title]" value="<?php echo esc_attr($feature['title'] ?? ''); ?>" class="large-text" />
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><?php esc_html_e('Description', 'central-build'); ?></th>
                                <td>
                                    <textarea name="central_build_trust_features[<?php echo $index; ?>][description]" rows="4" class="large-text"><?php echo esc_textarea($feature['description'] ?? ''); ?></textarea>
                                </td>
                            </tr>
                        </table>
                    </div>
                <?php
                    endforeach;
                endif;
                ?>
            </div>
            <button type="button" class="button add-field" data-target="trust-features-container" data-template="trust-feature-template"><?php esc_html_e('Add Feature', 'central-build'); ?></button>
        </div>
        
        <!-- Template for new trust features -->
        <script type="text/template" id="trust-feature-template">
            <div class="central-build-field-group repeatable-item" data-index="{INDEX}">
                <div class="field-header">
                    <h4><?php esc_html_e('New Feature', 'central-build'); ?></h4>
                    <button type="button" class="button remove-field"><?php esc_html_e('Remove', 'central-build'); ?></button>
                </div>
                <table class="form-table">
                    <tr>
                        <th scope="row"><?php esc_html_e('Icon URL', 'central-build'); ?></th>
                        <td>
                            <input type="url" name="central_build_trust_features[{INDEX}][icon]" value="" class="large-text image-upload-field" />
                            <button type="button" class="button upload-image-button"><?php esc_html_e('Upload Image', 'central-build'); ?></button>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php esc_html_e('Title', 'central-build'); ?></th>
                        <td>
                            <input type="text" name="central_build_trust_features[{INDEX}][title]" value="" class="large-text" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php esc_html_e('Description', 'central-build'); ?></th>
                        <td>
                            <textarea name="central_build_trust_features[{INDEX}][description]" rows="4" class="large-text"></textarea>
                        </td>
                    </tr>
                </table>
            </div>
        </script>
    </div>
    <?php
}

/**
 * Partners Section Tab
 */
function central_build_partners_tab()
{
    ?>
    <div class="central-build-admin-section">
        <h3><?php esc_html_e('Partners/Clients Section Settings', 'central-build'); ?></h3>
        <p><?php esc_html_e('Add up to 12 partner/client logos for the marquee section.', 'central-build'); ?></p>
        
        <div class="central-build-repeatable-section" data-section="partners">
            <div class="repeatable-fields" id="partners-container">
                <?php
                $partners = get_option('central_build_partners', array());
                if (!empty($partners)) :
                    foreach ($partners as $index => $partner) :
                ?>
                    <div class="central-build-field-group repeatable-item" data-index="<?php echo $index; ?>">
                        <div class="field-header">
                            <h4><?php printf(esc_html__('Partner %d', 'central-build'), $index + 1); ?></h4>
                            <button type="button" class="button remove-field"><?php esc_html_e('Remove', 'central-build'); ?></button>
                        </div>
                        <table class="form-table">
                            <tr>
                                <th scope="row"><?php esc_html_e('Logo URL', 'central-build'); ?></th>
                                <td>
                                    <input type="url" name="central_build_partners[<?php echo $index; ?>][logo]" value="<?php echo esc_url($partner['logo'] ?? ''); ?>" class="large-text image-upload-field" />
                                    <button type="button" class="button upload-image-button"><?php esc_html_e('Upload Image', 'central-build'); ?></button>
                                    <?php if (!empty($partner['logo'])) : ?>
                                        <br><img src="<?php echo esc_url($partner['logo']); ?>" class="central-build-image-preview" alt="Partner Logo" />
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><?php esc_html_e('Name', 'central-build'); ?></th>
                                <td>
                                    <input type="text" name="central_build_partners[<?php echo $index; ?>][name]" value="<?php echo esc_attr($partner['name'] ?? ''); ?>" class="regular-text" />
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><?php esc_html_e('Website URL', 'central-build'); ?></th>
                                <td>
                                    <input type="url" name="central_build_partners[<?php echo $index; ?>][url]" value="<?php echo esc_url($partner['url'] ?? ''); ?>" class="regular-text" />
                                </td>
                            </tr>
                        </table>
                    </div>
                <?php
                    endforeach;
                endif;
                ?>
            </div>
            <button type="button" class="button add-field" data-target="partners-container" data-template="partner-template"><?php esc_html_e('Add Partner', 'central-build'); ?></button>
        </div>
        
        <!-- Template for new partners -->
        <script type="text/template" id="partner-template">
            <div class="central-build-field-group repeatable-item" data-index="{INDEX}">
                <div class="field-header">
                    <h4><?php esc_html_e('New Partner', 'central-build'); ?></h4>
                    <button type="button" class="button remove-field"><?php esc_html_e('Remove', 'central-build'); ?></button>
                </div>
                <table class="form-table">
                    <tr>
                        <th scope="row"><?php esc_html_e('Logo URL', 'central-build'); ?></th>
                        <td>
                            <input type="url" name="central_build_partners[{INDEX}][logo]" value="" class="large-text image-upload-field" />
                            <button type="button" class="button upload-image-button"><?php esc_html_e('Upload Image', 'central-build'); ?></button>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php esc_html_e('Name', 'central-build'); ?></th>
                        <td>
                            <input type="text" name="central_build_partners[{INDEX}][name]" value="" class="regular-text" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php esc_html_e('Website URL', 'central-build'); ?></th>
                        <td>
                            <input type="url" name="central_build_partners[{INDEX}][url]" value="" class="regular-text" />
                        </td>
                    </tr>
                </table>
            </div>
        </script>
    </div>
    <?php
}

/**
 * Include other tab functions (testimonials, projects, commercial, sectors, faq)
 * These would be similar in structure to the above functions
 */

// Add more tab functions here...
function central_build_testimonials_tab()
{
    ?>
    <div class="central-build-admin-section">
        <h3><?php esc_html_e('Testimonials Section Settings', 'central-build'); ?></h3>
        
        <table class="form-table">
            <tr>
                <th scope="row"><?php esc_html_e('Section Tag', 'central-build'); ?></th>
                <td>
                    <input type="text" name="central_build_testimonials_tag" value="<?php echo esc_attr(get_option('central_build_testimonials_tag')); ?>" class="regular-text" />
                </td>
            </tr>
            <tr>
                <th scope="row"><?php esc_html_e('Section Title', 'central-build'); ?></th>
                <td>
                    <input type="text" name="central_build_testimonials_title" value="<?php echo esc_attr(get_option('central_build_testimonials_title')); ?>" class="large-text" />
                </td>
            </tr>
            <tr>
                <th scope="row"><?php esc_html_e('Section Description', 'central-build'); ?></th>
                <td>
                    <textarea name="central_build_testimonials_description" rows="3" class="large-text"><?php echo esc_textarea(get_option('central_build_testimonials_description')); ?></textarea>
                </td>
            </tr>
            <tr>
                <th scope="row"><?php esc_html_e('Button Text', 'central-build'); ?></th>
                <td>
                    <input type="text" name="central_build_testimonials_button_text" value="<?php echo esc_attr(get_option('central_build_testimonials_button_text')); ?>" class="regular-text" />
                </td>
            </tr>
            <tr>
                <th scope="row"><?php esc_html_e('Button Subtext', 'central-build'); ?></th>
                <td>
                    <input type="text" name="central_build_testimonials_button_subtext" value="<?php echo esc_attr(get_option('central_build_testimonials_button_subtext')); ?>" class="regular-text" />
                </td>
            </tr>
            <tr>
                <th scope="row"><?php esc_html_e('Button URL', 'central-build'); ?></th>
                <td>
                    <input type="url" name="central_build_testimonials_button_url" value="<?php echo esc_url(get_option('central_build_testimonials_button_url')); ?>" class="regular-text" />
                </td>
            </tr>
            <tr>
                <th scope="row"><?php esc_html_e('Section Image', 'central-build'); ?></th>
                <td>
                    <input type="url" name="central_build_testimonials_image" value="<?php echo esc_url(get_option('central_build_testimonials_image')); ?>" class="large-text" />
                    <?php 
                    $testimonials_image = get_option('central_build_testimonials_image');
                    if ($testimonials_image) : ?>
                        <br><img src="<?php echo esc_url($testimonials_image); ?>" class="central-build-image-preview" alt="Testimonials Section Image" />
                    <?php endif; ?>
                </td>
            </tr>
        </table>

        <div class="central-build-repeatable-section" data-section="testimonials">
            <div class="repeatable-fields" id="testimonials-container">
                <?php
                $testimonials = get_option('central_build_testimonials', array());
                if (!empty($testimonials)) :
                    foreach ($testimonials as $index => $testimonial) :
                ?>
                    <div class="central-build-field-group repeatable-item" data-index="<?php echo $index; ?>">
                        <div class="field-header">
                            <h4><?php printf(esc_html__('Testimonial %d', 'central-build'), $index + 1); ?></h4>
                            <button type="button" class="button remove-field"><?php esc_html_e('Remove', 'central-build'); ?></button>
                        </div>
                        <table class="form-table">
                            <tr>
                                <th scope="row"><?php esc_html_e('Content', 'central-build'); ?></th>
                                <td>
                                    <textarea name="central_build_testimonials[<?php echo $index; ?>][content]" rows="4" class="large-text"><?php echo esc_textarea($testimonial['content'] ?? ''); ?></textarea>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><?php esc_html_e('Author Name', 'central-build'); ?></th>
                                <td>
                                    <input type="text" name="central_build_testimonials[<?php echo $index; ?>][name]" value="<?php echo esc_attr($testimonial['name'] ?? ''); ?>" class="regular-text" />
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><?php esc_html_e('Author Position', 'central-build'); ?></th>
                                <td>
                                    <input type="text" name="central_build_testimonials[<?php echo $index; ?>][position]" value="<?php echo esc_attr($testimonial['position'] ?? ''); ?>" class="regular-text" />
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><?php esc_html_e('Author Image', 'central-build'); ?></th>
                                <td>
                                    <input type="url" name="central_build_testimonials[<?php echo $index; ?>][image]" value="<?php echo esc_url($testimonial['image'] ?? ''); ?>" class="large-text image-upload-field" />
                                    <button type="button" class="button upload-image-button"><?php esc_html_e('Upload Image', 'central-build'); ?></button>
                                    <?php if (!empty($testimonial['image'])) : ?>
                                        <br><img src="<?php echo esc_url($testimonial['image']); ?>" class="central-build-image-preview" alt="Testimonial Image" />
                                    <?php endif; ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                <?php
                    endforeach;
                endif;
                ?>
            </div>
            <button type="button" class="button add-field" data-target="testimonials-container" data-template="testimonial-template"><?php esc_html_e('Add Testimonial', 'central-build'); ?></button>
        </div>
        
        <!-- Template for new testimonials -->
        <script type="text/template" id="testimonial-template">
            <div class="central-build-field-group repeatable-item" data-index="{INDEX}">
                <div class="field-header">
                    <h4><?php esc_html_e('New Testimonial', 'central-build'); ?></h4>
                    <button type="button" class="button remove-field"><?php esc_html_e('Remove', 'central-build'); ?></button>
                </div>
                <table class="form-table">
                    <tr>
                        <th scope="row"><?php esc_html_e('Content', 'central-build'); ?></th>
                        <td>
                            <textarea name="central_build_testimonials[{INDEX}][content]" rows="4" class="large-text"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php esc_html_e('Author Name', 'central-build'); ?></th>
                        <td>
                            <input type="text" name="central_build_testimonials[{INDEX}][name]" value="" class="regular-text" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php esc_html_e('Author Position', 'central-build'); ?></th>
                        <td>
                            <input type="text" name="central_build_testimonials[{INDEX}][position]" value="" class="regular-text" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php esc_html_e('Author Image', 'central-build'); ?></th>
                        <td>
                            <input type="url" name="central_build_testimonials[{INDEX}][image]" value="" class="large-text image-upload-field" />
                            <button type="button" class="button upload-image-button"><?php esc_html_e('Upload Image', 'central-build'); ?></button>
                        </td>
                    </tr>
                </table>
            </div>
        </script>
    </div>
    <?php
}

function central_build_projects_tab()
{
    ?>
    <div class="central-build-admin-section">
        <h3><?php esc_html_e('Featured Projects Section Settings', 'central-build'); ?></h3>
        
        <table class="form-table">
            <tr>
                <th scope="row"><?php esc_html_e('Section Title', 'central-build'); ?></th>
                <td>
                    <input type="text" name="central_build_projects_title" value="<?php echo esc_attr(get_option('central_build_projects_title')); ?>" class="large-text" />
                </td>
            </tr>
            <tr>
                <th scope="row"><?php esc_html_e('Section Subtitle', 'central-build'); ?></th>
                <td>
                    <input type="text" name="central_build_projects_subtitle" value="<?php echo esc_attr(get_option('central_build_projects_subtitle')); ?>" class="large-text" />
                </td>
            </tr>
        </table>

        <h4><?php esc_html_e('Process Steps', 'central-build'); ?></h4>
        <div class="central-build-repeatable-section" data-section="process_steps">
            <div class="repeatable-fields" id="process-steps-container">
                <?php
                $process_steps = get_option('central_build_process_steps', array());
                if (!empty($process_steps)) :
                    foreach ($process_steps as $index => $step) :
                ?>
                    <div class="central-build-field-group repeatable-item" data-index="<?php echo $index; ?>">
                        <div class="field-header">
                            <h4><?php printf(esc_html__('Step %d', 'central-build'), $index + 1); ?></h4>
                            <button type="button" class="button remove-field"><?php esc_html_e('Remove', 'central-build'); ?></button>
                        </div>
                        <table class="form-table">
                            <tr>
                                <th scope="row"><?php esc_html_e('Icon URL', 'central-build'); ?></th>
                                <td>
                                    <input type="url" name="central_build_process_steps[<?php echo $index; ?>][icon]" value="<?php echo esc_url($step['icon'] ?? ''); ?>" class="large-text image-upload-field" />
                                    <button type="button" class="button upload-image-button"><?php esc_html_e('Upload Image', 'central-build'); ?></button>
                                    <?php if (!empty($step['icon'])) : ?>
                                        <br><img src="<?php echo esc_url($step['icon']); ?>" class="central-build-image-preview" alt="Step Icon" />
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><?php esc_html_e('Title', 'central-build'); ?></th>
                                <td>
                                    <input type="text" name="central_build_process_steps[<?php echo $index; ?>][title]" value="<?php echo esc_attr($step['title'] ?? ''); ?>" class="large-text" />
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><?php esc_html_e('Description', 'central-build'); ?></th>
                                <td>
                                    <textarea name="central_build_process_steps[<?php echo $index; ?>][description]" rows="3" class="large-text"><?php echo esc_textarea($step['description'] ?? ''); ?></textarea>
                                </td>
                            </tr>
                        </table>
                    </div>
                <?php
                    endforeach;
                endif;
                ?>
            </div>
            <button type="button" class="button add-field" data-target="process-steps-container" data-template="process-step-template"><?php esc_html_e('Add Process Step', 'central-build'); ?></button>
        </div>
        
        <!-- Template for new process steps -->
        <script type="text/template" id="process-step-template">
            <div class="central-build-field-group repeatable-item" data-index="{INDEX}">
                <div class="field-header">
                    <h4><?php esc_html_e('New Step', 'central-build'); ?></h4>
                    <button type="button" class="button remove-field"><?php esc_html_e('Remove', 'central-build'); ?></button>
                </div>
                <table class="form-table">
                    <tr>
                        <th scope="row"><?php esc_html_e('Icon URL', 'central-build'); ?></th>
                        <td>
                            <input type="url" name="central_build_process_steps[{INDEX}][icon]" value="" class="large-text image-upload-field" />
                            <button type="button" class="button upload-image-button"><?php esc_html_e('Upload Image', 'central-build'); ?></button>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php esc_html_e('Title', 'central-build'); ?></th>
                        <td>
                            <input type="text" name="central_build_process_steps[{INDEX}][title]" value="" class="large-text" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php esc_html_e('Description', 'central-build'); ?></th>
                        <td>
                            <textarea name="central_build_process_steps[{INDEX}][description]" rows="3" class="large-text"></textarea>
                        </td>
                    </tr>
                </table>
            </div>
        </script>

        <h4><?php esc_html_e('Project Images', 'central-build'); ?></h4>
        <div class="central-build-repeatable-section" data-section="project_images">
            <div class="repeatable-fields" id="project-images-container">
                <?php
                $project_images = get_option('central_build_project_images', array());
                if (!empty($project_images)) :
                    foreach ($project_images as $index => $image) :
                ?>
                    <div class="central-build-field-group repeatable-item" data-index="<?php echo $index; ?>">
                        <div class="field-header">
                            <h4><?php printf(esc_html__('Project Image %d', 'central-build'), $index + 1); ?></h4>
                            <button type="button" class="button remove-field"><?php esc_html_e('Remove', 'central-build'); ?></button>
                        </div>
                        <table class="form-table">
                            <tr>
                                <th scope="row"><?php esc_html_e('Image URL', 'central-build'); ?></th>
                                <td>
                                    <input type="url" name="central_build_project_images[<?php echo $index; ?>][image]" value="<?php echo esc_url($image['image'] ?? ''); ?>" class="large-text image-upload-field" />
                                    <button type="button" class="button upload-image-button"><?php esc_html_e('Upload Image', 'central-build'); ?></button>
                                    <?php if (!empty($image['image'])) : ?>
                                        <br><img src="<?php echo esc_url($image['image']); ?>" class="central-build-image-preview" alt="Project Image" />
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><?php esc_html_e('Alt Text', 'central-build'); ?></th>
                                <td>
                                    <input type="text" name="central_build_project_images[<?php echo $index; ?>][alt]" value="<?php echo esc_attr($image['alt'] ?? ''); ?>" class="large-text" />
                                </td>
                            </tr>
                        </table>
                    </div>
                <?php
                    endforeach;
                endif;
                ?>
            </div>
            <button type="button" class="button add-field" data-target="project-images-container" data-template="project-image-template"><?php esc_html_e('Add Project Image', 'central-build'); ?></button>
        </div>
        
        <!-- Template for new project images -->
        <script type="text/template" id="project-image-template">
            <div class="central-build-field-group repeatable-item" data-index="{INDEX}">
                <div class="field-header">
                    <h4><?php esc_html_e('New Project Image', 'central-build'); ?></h4>
                    <button type="button" class="button remove-field"><?php esc_html_e('Remove', 'central-build'); ?></button>
                </div>
                <table class="form-table">
                    <tr>
                        <th scope="row"><?php esc_html_e('Image URL', 'central-build'); ?></th>
                        <td>
                            <input type="url" name="central_build_project_images[{INDEX}][image]" value="" class="large-text image-upload-field" />
                            <button type="button" class="button upload-image-button"><?php esc_html_e('Upload Image', 'central-build'); ?></button>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php esc_html_e('Alt Text', 'central-build'); ?></th>
                        <td>
                            <input type="text" name="central_build_project_images[{INDEX}][alt]" value="" class="large-text" />
                        </td>
                    </tr>
                </table>
            </div>
        </script>

        <h4><?php esc_html_e('Button Settings', 'central-build'); ?></h4>
        <table class="form-table">
            <tr>
                <th scope="row"><?php esc_html_e('Button Text', 'central-build'); ?></th>
                <td>
                    <input type="text" name="central_build_projects_button_text" value="<?php echo esc_attr(get_option('central_build_projects_button_text')); ?>" class="regular-text" />
                </td>
            </tr>
            <tr>
                <th scope="row"><?php esc_html_e('Button Subtext', 'central-build'); ?></th>
                <td>
                    <input type="text" name="central_build_projects_button_subtext" value="<?php echo esc_attr(get_option('central_build_projects_button_subtext')); ?>" class="regular-text" />
                </td>
            </tr>
            <tr>
                <th scope="row"><?php esc_html_e('Button URL', 'central-build'); ?></th>
                <td>
                    <input type="url" name="central_build_projects_button_url" value="<?php echo esc_url(get_option('central_build_projects_button_url')); ?>" class="regular-text" />
                </td>
            </tr>
        </table>

        <h4><?php esc_html_e('Statistics', 'central-build'); ?></h4>
        <div class="central-build-repeatable-section" data-section="stats">
            <div class="repeatable-fields" id="stats-container">
                <?php
                $stats = get_option('central_build_stats', array());
                if (!empty($stats)) :
                    foreach ($stats as $index => $stat) :
                ?>
                    <div class="central-build-field-group repeatable-item" data-index="<?php echo $index; ?>">
                        <div class="field-header">
                            <h4><?php printf(esc_html__('Statistic %d', 'central-build'), $index + 1); ?></h4>
                            <button type="button" class="button remove-field"><?php esc_html_e('Remove', 'central-build'); ?></button>
                        </div>
                        <table class="form-table">
                            <tr>
                                <th scope="row"><?php esc_html_e('Number', 'central-build'); ?></th>
                                <td>
                                    <input type="text" name="central_build_stats[<?php echo $index; ?>][number]" value="<?php echo esc_attr($stat['number'] ?? ''); ?>" class="regular-text" />
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><?php esc_html_e('Label', 'central-build'); ?></th>
                                <td>
                                    <input type="text" name="central_build_stats[<?php echo $index; ?>][label]" value="<?php echo esc_attr($stat['label'] ?? ''); ?>" class="regular-text" />
                                </td>
                            </tr>
                        </table>
                    </div>
                <?php
                    endforeach;
                endif;
                ?>
            </div>
            <button type="button" class="button add-field" data-target="stats-container" data-template="stat-template"><?php esc_html_e('Add Statistic', 'central-build'); ?></button>
        </div>
        
        <!-- Template for new statistics -->
        <script type="text/template" id="stat-template">
            <div class="central-build-field-group repeatable-item" data-index="{INDEX}">
                <div class="field-header">
                    <h4><?php esc_html_e('New Statistic', 'central-build'); ?></h4>
                    <button type="button" class="button remove-field"><?php esc_html_e('Remove', 'central-build'); ?></button>
                </div>
                <table class="form-table">
                    <tr>
                        <th scope="row"><?php esc_html_e('Number', 'central-build'); ?></th>
                        <td>
                            <input type="text" name="central_build_stats[{INDEX}][number]" value="" class="regular-text" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php esc_html_e('Label', 'central-build'); ?></th>
                        <td>
                            <input type="text" name="central_build_stats[{INDEX}][label]" value="" class="regular-text" />
                        </td>
                    </tr>
                </table>
            </div>
        </script>

        <h4><?php esc_html_e('CTA Section', 'central-build'); ?></h4>
        <table class="form-table">
            <tr>
                <th scope="row"><?php esc_html_e('CTA Title', 'central-build'); ?></th>
                <td>
                    <input type="text" name="central_build_cta_title" value="<?php echo esc_attr(get_option('central_build_cta_title')); ?>" class="large-text" />
                </td>
            </tr>
            <tr>
                <th scope="row"><?php esc_html_e('CTA Description', 'central-build'); ?></th>
                <td>
                    <textarea name="central_build_cta_description" rows="4" class="large-text"><?php echo esc_textarea(get_option('central_build_cta_description')); ?></textarea>
                </td>
            </tr>
            <tr>
                <th scope="row"><?php esc_html_e('CTA Button Text', 'central-build'); ?></th>
                <td>
                    <input type="text" name="central_build_cta_button_text" value="<?php echo esc_attr(get_option('central_build_cta_button_text')); ?>" class="regular-text" />
                </td>
            </tr>
            <tr>
                <th scope="row"><?php esc_html_e('CTA Button Subtext', 'central-build'); ?></th>
                <td>
                    <input type="text" name="central_build_cta_button_subtext" value="<?php echo esc_attr(get_option('central_build_cta_button_subtext')); ?>" class="regular-text" />
                </td>
            </tr>
            <tr>
                <th scope="row"><?php esc_html_e('CTA Button URL', 'central-build'); ?></th>
                <td>
                    <input type="url" name="central_build_cta_button_url" value="<?php echo esc_url(get_option('central_build_cta_button_url')); ?>" class="regular-text" />
                </td>
            </tr>
            <tr>
                <th scope="row"><?php esc_html_e('CTA Background Image', 'central-build'); ?></th>
                <td>
                    <input type="url" name="central_build_cta_background_image" value="<?php echo esc_url(get_option('central_build_cta_background_image')); ?>" class="large-text" />
                    <?php 
                    $cta_bg_image = get_option('central_build_cta_background_image');
                    if ($cta_bg_image) : ?>
                        <br><img src="<?php echo esc_url($cta_bg_image); ?>" class="central-build-image-preview" alt="CTA Background Image" />
                    <?php endif; ?>
                </td>
            </tr>
        </table>
    </div>
    <?php
}

function central_build_commercial_tab()
{
    ?>
    <div class="central-build-admin-section">
        <h3><?php esc_html_e('Commercial Projects Section Settings', 'central-build'); ?></h3>
        
        <table class="form-table">
            <tr>
                <th scope="row"><?php esc_html_e('Section Tag', 'central-build'); ?></th>
                <td>
                    <input type="text" name="central_build_commercial_tag" value="<?php echo esc_attr(get_option('central_build_commercial_tag')); ?>" class="regular-text" />
                </td>
            </tr>
            <tr>
                <th scope="row"><?php esc_html_e('Section Title', 'central-build'); ?></th>
                <td>
                    <textarea name="central_build_commercial_title" rows="2" class="large-text"><?php echo esc_textarea(get_option('central_build_commercial_title')); ?></textarea>
                    <p class="description"><?php esc_html_e('You can use &lt;br&gt; for line breaks', 'central-build'); ?></p>
                </td>
            </tr>
        </table>

        <h4><?php esc_html_e('Commercial Projects', 'central-build'); ?></h4>
        <div class="central-build-repeatable-section" data-section="commercial_projects">
            <div class="repeatable-fields" id="commercial-projects-container">
                <?php
                $commercial_projects = get_option('central_build_commercial_projects', array());
                if (!empty($commercial_projects)) :
                    foreach ($commercial_projects as $index => $project) :
                ?>
                    <div class="central-build-field-group repeatable-item" data-index="<?php echo $index; ?>">
                        <div class="field-header">
                            <h4><?php printf(esc_html__('Project %d', 'central-build'), $index + 1); ?></h4>
                            <button type="button" class="button remove-field"><?php esc_html_e('Remove', 'central-build'); ?></button>
                        </div>
                        <table class="form-table">
                            <tr>
                                <th scope="row"><?php esc_html_e('Project Image', 'central-build'); ?></th>
                                <td>
                                    <input type="url" name="central_build_commercial_projects[<?php echo $index; ?>][image]" value="<?php echo esc_url($project['image'] ?? ''); ?>" class="large-text image-upload-field" />
                                    <button type="button" class="button upload-image-button"><?php esc_html_e('Upload Image', 'central-build'); ?></button>
                                    <?php if (!empty($project['image'])) : ?>
                                        <br><img src="<?php echo esc_url($project['image']); ?>" class="central-build-image-preview" alt="Commercial Project" />
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><?php esc_html_e('Project Title', 'central-build'); ?></th>
                                <td>
                                    <input type="text" name="central_build_commercial_projects[<?php echo $index; ?>][title]" value="<?php echo esc_attr($project['title'] ?? ''); ?>" class="large-text" />
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><?php esc_html_e('Project URL', 'central-build'); ?></th>
                                <td>
                                    <input type="url" name="central_build_commercial_projects[<?php echo $index; ?>][url]" value="<?php echo esc_url($project['url'] ?? ''); ?>" class="regular-text" />
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><?php esc_html_e('Alt Text', 'central-build'); ?></th>
                                <td>
                                    <input type="text" name="central_build_commercial_projects[<?php echo $index; ?>][alt]" value="<?php echo esc_attr($project['alt'] ?? ''); ?>" class="large-text" />
                                </td>
                            </tr>
                        </table>
                    </div>
                <?php
                    endforeach;
                endif;
                ?>
            </div>
            <button type="button" class="button add-field" data-target="commercial-projects-container" data-template="commercial-project-template"><?php esc_html_e('Add Project', 'central-build'); ?></button>
        </div>
        
        <!-- Template for new commercial projects -->
        <script type="text/template" id="commercial-project-template">
            <div class="central-build-field-group repeatable-item" data-index="{INDEX}">
                <div class="field-header">
                    <h4><?php esc_html_e('New Project', 'central-build'); ?></h4>
                    <button type="button" class="button remove-field"><?php esc_html_e('Remove', 'central-build'); ?></button>
                </div>
                <table class="form-table">
                    <tr>
                        <th scope="row"><?php esc_html_e('Project Image', 'central-build'); ?></th>
                        <td>
                            <input type="url" name="central_build_commercial_projects[{INDEX}][image]" value="" class="large-text image-upload-field" />
                            <button type="button" class="button upload-image-button"><?php esc_html_e('Upload Image', 'central-build'); ?></button>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php esc_html_e('Project Title', 'central-build'); ?></th>
                        <td>
                            <input type="text" name="central_build_commercial_projects[{INDEX}][title]" value="" class="large-text" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php esc_html_e('Project URL', 'central-build'); ?></th>
                        <td>
                            <input type="url" name="central_build_commercial_projects[{INDEX}][url]" value="" class="regular-text" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php esc_html_e('Alt Text', 'central-build'); ?></th>
                        <td>
                            <input type="text" name="central_build_commercial_projects[{INDEX}][alt]" value="" class="large-text" />
                        </td>
                    </tr>
                </table>
            </div>
        </script>
    </div>
    <?php
}

function central_build_sectors_tab()
{
    ?>
    <div class="central-build-admin-section">
        <h3><?php esc_html_e('Fitout Sectors Section Settings', 'central-build'); ?></h3>
        
        <table class="form-table">
            <tr>
                <th scope="row"><?php esc_html_e('Section Icon', 'central-build'); ?></th>
                <td>
                    <input type="url" name="central_build_checkout_icon" value="<?php echo esc_url(get_option('central_build_checkout_icon')); ?>" class="large-text" />
                    <?php 
                    $checkout_icon = get_option('central_build_checkout_icon');
                    if ($checkout_icon) : ?>
                        <br><img src="<?php echo esc_url($checkout_icon); ?>" class="central-build-image-preview" alt="Section Icon" />
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <th scope="row"><?php esc_html_e('Section Title', 'central-build'); ?></th>
                <td>
                    <input type="text" name="central_build_checkout_title" value="<?php echo esc_attr(get_option('central_build_checkout_title')); ?>" class="large-text" />
                </td>
            </tr>
            <tr>
                <th scope="row"><?php esc_html_e('Button Text', 'central-build'); ?></th>
                <td>
                    <input type="text" name="central_build_checkout_button_text" value="<?php echo esc_attr(get_option('central_build_checkout_button_text')); ?>" class="regular-text" />
                </td>
            </tr>
            <tr>
                <th scope="row"><?php esc_html_e('Button Subtext', 'central-build'); ?></th>
                <td>
                    <input type="text" name="central_build_checkout_button_subtext" value="<?php echo esc_attr(get_option('central_build_checkout_button_subtext')); ?>" class="regular-text" />
                </td>
            </tr>
            <tr>
                <th scope="row"><?php esc_html_e('Button URL', 'central-build'); ?></th>
                <td>
                    <input type="url" name="central_build_checkout_button_url" value="<?php echo esc_url(get_option('central_build_checkout_button_url')); ?>" class="regular-text" />
                </td>
            </tr>
        </table>

        <h4><?php esc_html_e('Fitout Sectors', 'central-build'); ?></h4>
        <div class="central-build-repeatable-section" data-section="sectors">
            <div class="repeatable-fields" id="sectors-container">
                <?php
                $sectors = get_option('central_build_sectors', array());
                if (!empty($sectors)) :
                    foreach ($sectors as $index => $sector) :
                ?>
                    <div class="central-build-field-group repeatable-item" data-index="<?php echo $index; ?>">
                        <div class="field-header">
                            <h4><?php printf(esc_html__('Sector %d', 'central-build'), $index + 1); ?></h4>
                            <button type="button" class="button remove-field"><?php esc_html_e('Remove', 'central-build'); ?></button>
                        </div>
                        <table class="form-table">
                            <tr>
                                <th scope="row"><?php esc_html_e('Sector Icon', 'central-build'); ?></th>
                                <td>
                                    <input type="url" name="central_build_sectors[<?php echo $index; ?>][icon]" value="<?php echo esc_url($sector['icon'] ?? ''); ?>" class="large-text image-upload-field" />
                                    <button type="button" class="button upload-image-button"><?php esc_html_e('Upload Image', 'central-build'); ?></button>
                                    <?php if (!empty($sector['icon'])) : ?>
                                        <br><img src="<?php echo esc_url($sector['icon']); ?>" class="central-build-image-preview" alt="Sector Icon" />
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><?php esc_html_e('Sector Tag', 'central-build'); ?></th>
                                <td>
                                    <input type="text" name="central_build_sectors[<?php echo $index; ?>][tag]" value="<?php echo esc_attr($sector['tag'] ?? ''); ?>" class="regular-text" />
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><?php esc_html_e('Sector Title', 'central-build'); ?></th>
                                <td>
                                    <input type="text" name="central_build_sectors[<?php echo $index; ?>][title]" value="<?php echo esc_attr($sector['title'] ?? ''); ?>" class="large-text" />
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><?php esc_html_e('Sector Description', 'central-build'); ?></th>
                                <td>
                                    <textarea name="central_build_sectors[<?php echo $index; ?>][description]" rows="3" class="large-text"><?php echo esc_textarea($sector['description'] ?? ''); ?></textarea>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><?php esc_html_e('Sector Image', 'central-build'); ?></th>
                                <td>
                                    <input type="url" name="central_build_sectors[<?php echo $index; ?>][image]" value="<?php echo esc_url($sector['image'] ?? ''); ?>" class="large-text image-upload-field" />
                                    <button type="button" class="button upload-image-button"><?php esc_html_e('Upload Image', 'central-build'); ?></button>
                                    <?php if (!empty($sector['image'])) : ?>
                                        <br><img src="<?php echo esc_url($sector['image']); ?>" class="central-build-image-preview" alt="Sector Image" />
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><?php esc_html_e('Image Alt Text', 'central-build'); ?></th>
                                <td>
                                    <input type="text" name="central_build_sectors[<?php echo $index; ?>][image_alt]" value="<?php echo esc_attr($sector['image_alt'] ?? ''); ?>" class="large-text" />
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><?php esc_html_e('Sector URL', 'central-build'); ?></th>
                                <td>
                                    <input type="url" name="central_build_sectors[<?php echo $index; ?>][url]" value="<?php echo esc_url($sector['url'] ?? ''); ?>" class="regular-text" />
                                </td>
                            </tr>
                        </table>
                    </div>
                <?php
                    endforeach;
                endif;
                ?>
            </div>
            <button type="button" class="button add-field" data-target="sectors-container" data-template="sector-template"><?php esc_html_e('Add Sector', 'central-build'); ?></button>
        </div>
        
        <!-- Template for new sectors -->
        <script type="text/template" id="sector-template">
            <div class="central-build-field-group repeatable-item" data-index="{INDEX}">
                <div class="field-header">
                    <h4><?php esc_html_e('New Sector', 'central-build'); ?></h4>
                    <button type="button" class="button remove-field"><?php esc_html_e('Remove', 'central-build'); ?></button>
                </div>
                <table class="form-table">
                    <tr>
                        <th scope="row"><?php esc_html_e('Sector Icon', 'central-build'); ?></th>
                        <td>
                            <input type="url" name="central_build_sectors[{INDEX}][icon]" value="" class="large-text image-upload-field" />
                            <button type="button" class="button upload-image-button"><?php esc_html_e('Upload Image', 'central-build'); ?></button>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php esc_html_e('Sector Tag', 'central-build'); ?></th>
                        <td>
                            <input type="text" name="central_build_sectors[{INDEX}][tag]" value="" class="regular-text" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php esc_html_e('Sector Title', 'central-build'); ?></th>
                        <td>
                            <input type="text" name="central_build_sectors[{INDEX}][title]" value="" class="large-text" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php esc_html_e('Sector Description', 'central-build'); ?></th>
                        <td>
                            <textarea name="central_build_sectors[{INDEX}][description]" rows="3" class="large-text"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php esc_html_e('Sector Image', 'central-build'); ?></th>
                        <td>
                            <input type="url" name="central_build_sectors[{INDEX}][image]" value="" class="large-text image-upload-field" />
                            <button type="button" class="button upload-image-button"><?php esc_html_e('Upload Image', 'central-build'); ?></button>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php esc_html_e('Image Alt Text', 'central-build'); ?></th>
                        <td>
                            <input type="text" name="central_build_sectors[{INDEX}][image_alt]" value="" class="large-text" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php esc_html_e('Sector URL', 'central-build'); ?></th>
                        <td>
                            <input type="url" name="central_build_sectors[{INDEX}][url]" value="" class="regular-text" />
                        </td>
                    </tr>
                </table>
            </div>
        </script>
    </div>
    <?php
}

function central_build_faq_tab()
{
    ?>
    <div class="central-build-admin-section">
        <h3><?php esc_html_e('FAQ Section Settings', 'central-build'); ?></h3>
        
        <table class="form-table">
            <tr>
                <th scope="row"><?php esc_html_e('FAQ Section Title', 'central-build'); ?></th>
                <td>
                    <input type="text" name="central_build_faq_title" value="<?php echo esc_attr(get_option('central_build_faq_title')); ?>" class="large-text" />
                </td>
            </tr>
        </table>

        <h4><?php esc_html_e('FAQ Items', 'central-build'); ?></h4>
        <div class="central-build-repeatable-section" data-section="faqs">
            <div class="repeatable-fields" id="faqs-container">
                <?php
                $faqs = get_option('central_build_faqs', array());
                if (!empty($faqs)) :
                    foreach ($faqs as $index => $faq) :
                ?>
                    <div class="central-build-field-group repeatable-item" data-index="<?php echo $index; ?>">
                        <div class="field-header">
                            <h4><?php printf(esc_html__('FAQ %d', 'central-build'), $index + 1); ?></h4>
                            <button type="button" class="button remove-field"><?php esc_html_e('Remove', 'central-build'); ?></button>
                        </div>
                        <table class="form-table">
                            <tr>
                                <th scope="row"><?php esc_html_e('Question', 'central-build'); ?></th>
                                <td>
                                    <input type="text" name="central_build_faqs[<?php echo $index; ?>][question]" value="<?php echo esc_attr($faq['question'] ?? ''); ?>" class="large-text" />
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><?php esc_html_e('Answer', 'central-build'); ?></th>
                                <td>
                                    <textarea name="central_build_faqs[<?php echo $index; ?>][answer]" rows="4" class="large-text"><?php echo esc_textarea($faq['answer'] ?? ''); ?></textarea>
                                </td>
                            </tr>
                        </table>
                    </div>
                <?php
                    endforeach;
                endif;
                ?>
            </div>
            <button type="button" class="button add-field" data-target="faqs-container" data-template="faq-template"><?php esc_html_e('Add FAQ', 'central-build'); ?></button>
        </div>
        
        <!-- Template for new FAQs -->
        <script type="text/template" id="faq-template">
            <div class="central-build-field-group repeatable-item" data-index="{INDEX}">
                <div class="field-header">
                    <h4><?php esc_html_e('New FAQ', 'central-build'); ?></h4>
                    <button type="button" class="button remove-field"><?php esc_html_e('Remove', 'central-build'); ?></button>
                </div>
                <table class="form-table">
                    <tr>
                        <th scope="row"><?php esc_html_e('Question', 'central-build'); ?></th>
                        <td>
                            <input type="text" name="central_build_faqs[{INDEX}][question]" value="" class="large-text" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php esc_html_e('Answer', 'central-build'); ?></th>
                        <td>
                            <textarea name="central_build_faqs[{INDEX}][answer]" rows="4" class="large-text"></textarea>
                        </td>
                    </tr>
                </table>
            </div>
        </script>

        <h4><?php esc_html_e('Transform Section', 'central-build'); ?></h4>
        <table class="form-table">
            <tr>
                <th scope="row"><?php esc_html_e('Transform Section Title', 'central-build'); ?></th>
                <td>
                    <input type="text" name="central_build_transform_title" value="<?php echo esc_attr(get_option('central_build_transform_title')); ?>" class="large-text" />
                </td>
            </tr>
            <tr>
                <th scope="row"><?php esc_html_e('Transform Button Text', 'central-build'); ?></th>
                <td>
                    <input type="text" name="central_build_transform_button_text" value="<?php echo esc_attr(get_option('central_build_transform_button_text')); ?>" class="regular-text" />
                </td>
            </tr>
            <tr>
                <th scope="row"><?php esc_html_e('Transform Button Subtext', 'central-build'); ?></th>
                <td>
                    <input type="text" name="central_build_transform_button_subtext" value="<?php echo esc_attr(get_option('central_build_transform_button_subtext')); ?>" class="regular-text" />
                </td>
            </tr>
            <tr>
                <th scope="row"><?php esc_html_e('Transform Button URL', 'central-build'); ?></th>
                <td>
                    <input type="url" name="central_build_transform_button_url" value="<?php echo esc_url(get_option('central_build_transform_button_url')); ?>" class="regular-text" />
                </td>
            </tr>
        </table>

        <h4><?php esc_html_e('Transform Features', 'central-build'); ?></h4>
        <div class="central-build-repeatable-section" data-section="transform_features">
            <div class="repeatable-fields" id="transform-features-container">
                <?php
                $transform_features = get_option('central_build_transform_features', array());
                if (!empty($transform_features)) :
                    foreach ($transform_features as $index => $feature) :
                ?>
                    <div class="central-build-field-group repeatable-item" data-index="<?php echo $index; ?>">
                        <div class="field-header">
                            <h4><?php printf(esc_html__('Transform Feature %d', 'central-build'), $index + 1); ?></h4>
                            <button type="button" class="button remove-field"><?php esc_html_e('Remove', 'central-build'); ?></button>
                        </div>
                        <table class="form-table">
                            <tr>
                                <th scope="row"><?php esc_html_e('Feature Icon', 'central-build'); ?></th>
                                <td>
                                    <input type="url" name="central_build_transform_features[<?php echo $index; ?>][icon]" value="<?php echo esc_url($feature['icon'] ?? ''); ?>" class="large-text image-upload-field" />
                                    <button type="button" class="button upload-image-button"><?php esc_html_e('Upload Image', 'central-build'); ?></button>
                                    <?php if (!empty($feature['icon'])) : ?>
                                        <br><img src="<?php echo esc_url($feature['icon']); ?>" class="central-build-image-preview" alt="Transform Feature Icon" />
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><?php esc_html_e('Feature Title', 'central-build'); ?></th>
                                <td>
                                    <input type="text" name="central_build_transform_features[<?php echo $index; ?>][title]" value="<?php echo esc_attr($feature['title'] ?? ''); ?>" class="large-text" />
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><?php esc_html_e('Feature Description', 'central-build'); ?></th>
                                <td>
                                    <textarea name="central_build_transform_features[<?php echo $index; ?>][description]" rows="2" class="large-text"><?php echo esc_textarea($feature['description'] ?? ''); ?></textarea>
                                </td>
                            </tr>
                        </table>
                    </div>
                <?php
                    endforeach;
                endif;
                ?>
            </div>
            <button type="button" class="button add-field" data-target="transform-features-container" data-template="transform-feature-template"><?php esc_html_e('Add Transform Feature', 'central-build'); ?></button>
        </div>
        
        <!-- Template for new transform features -->
        <script type="text/template" id="transform-feature-template">
            <div class="central-build-field-group repeatable-item" data-index="{INDEX}">
                <div class="field-header">
                    <h4><?php esc_html_e('New Transform Feature', 'central-build'); ?></h4>
                    <button type="button" class="button remove-field"><?php esc_html_e('Remove', 'central-build'); ?></button>
                </div>
                <table class="form-table">
                    <tr>
                        <th scope="row"><?php esc_html_e('Feature Icon', 'central-build'); ?></th>
                        <td>
                            <input type="url" name="central_build_transform_features[{INDEX}][icon]" value="" class="large-text image-upload-field" />
                            <button type="button" class="button upload-image-button"><?php esc_html_e('Upload Image', 'central-build'); ?></button>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php esc_html_e('Feature Title', 'central-build'); ?></th>
                        <td>
                            <input type="text" name="central_build_transform_features[{INDEX}][title]" value="" class="large-text" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php esc_html_e('Feature Description', 'central-build'); ?></th>
                        <td>
                            <textarea name="central_build_transform_features[{INDEX}][description]" rows="2" class="large-text"></textarea>
                        </td>
                    </tr>
                </table>
            </div>
        </script>
    </div>
    <?php
}

/**
 * Enqueue admin styles and scripts
 */
function central_build_admin_enqueue_scripts($hook)
{
    if ($hook != 'toplevel_page_central-build-options') {
        return;
    }

    wp_enqueue_media();
    wp_enqueue_script('central-build-admin', get_template_directory_uri() . '/js/admin.js', array('jquery'), '1.0.0', true);
}
add_action('admin_enqueue_scripts', 'central_build_admin_enqueue_scripts');

/**
 * Helper functions for backward compatibility and data access
 */

/**
 * Get about features with backward compatibility
 */
function central_build_get_about_features() {
    $features = get_option('central_build_about_features', array());
    
    // If new format is empty, try to get from old format
    if (empty($features)) {
        $features = array();
        for ($i = 1; $i <= 4; $i++) {
            $title = get_option("central_build_about_feature_{$i}_title");
            $description = get_option("central_build_about_feature_{$i}_description");
            
            if ($title || $description) {
                $features[] = array(
                    'title' => $title,
                    'description' => $description
                );
            }
        }
    }
    
    return $features;
}

/**
 * Get trust features with backward compatibility
 */
function central_build_get_trust_features() {
    $features = get_option('central_build_trust_features', array());
    
    // If new format is empty, try to get from old format
    if (empty($features)) {
        $features = array();
        for ($i = 1; $i <= 3; $i++) {
            $icon = get_option("central_build_trust_feature{$i}_icon");
            $title = get_option("central_build_trust_feature{$i}_title");
            $description = get_option("central_build_trust_feature{$i}_description");
            
            if ($title || $description || $icon) {
                $features[] = array(
                    'icon' => $icon,
                    'title' => $title,
                    'description' => $description
                );
            }
        }
    }
    
    return $features;
}

/**
 * Get partners with backward compatibility
 */
function central_build_get_partners() {
    $partners = get_option('central_build_partners', array());
    
    // If new format is empty, try to get from old format
    if (empty($partners)) {
        $partners = array();
        for ($i = 1; $i <= 12; $i++) {
            $logo = get_option("central_build_partner_{$i}_logo");
            $name = get_option("central_build_partner_{$i}_name");
            $url = get_option("central_build_partner_{$i}_url");
            
            if ($logo || $name || $url) {
                $partners[] = array(
                    'logo' => $logo,
                    'name' => $name,
                    'url' => $url
                );
            }
        }
    }
    
    return $partners;
}

/**
 * Get testimonials with backward compatibility
 */
function central_build_get_testimonials() {
    $testimonials = get_option('central_build_testimonials', array());
    
    // If new format is empty, try to get from old format
    if (empty($testimonials)) {
        $testimonials = array();
        for ($i = 1; $i <= 3; $i++) {
            $content = get_option("central_build_testimonial_{$i}_content");
            $name = get_option("central_build_testimonial_{$i}_name");
            $position = get_option("central_build_testimonial_{$i}_position");
            $image = get_option("central_build_testimonial_{$i}_image");
            
            if ($content || $name) {
                $testimonials[] = array(
                    'content' => $content,
                    'name' => $name,
                    'position' => $position,
                    'image' => $image
                );
            }
        }
    }
    
    return $testimonials;
}

/**
 * Get commercial projects with backward compatibility
 */
function central_build_get_commercial_projects() {
    $projects = get_option('central_build_commercial_projects', array());
    
    // If new format is empty, try to get from old format
    if (empty($projects)) {
        $projects = array();
        for ($i = 1; $i <= 8; $i++) {
            $image = get_option("central_build_commercial_project_{$i}_image");
            $title = get_option("central_build_commercial_project_{$i}_title");
            $url = get_option("central_build_commercial_project_{$i}_url");
            $alt = get_option("central_build_commercial_project_{$i}_alt");
            
            if ($image || $title) {
                $projects[] = array(
                    'image' => $image,
                    'title' => $title,
                    'url' => $url,
                    'alt' => $alt
                );
            }
        }
    }
    
    return $projects;
}

/**
 * Get sectors with backward compatibility
 */
function central_build_get_sectors() {
    $sectors = get_option('central_build_sectors', array());
    
    // If new format is empty, try to get from old format
    if (empty($sectors)) {
        $sectors = array();
        for ($i = 1; $i <= 5; $i++) {
            $icon = get_option("central_build_sector_{$i}_icon");
            $tag = get_option("central_build_sector_{$i}_tag");
            $title = get_option("central_build_sector_{$i}_title");
            $description = get_option("central_build_sector_{$i}_description");
            $image = get_option("central_build_sector_{$i}_image");
            $image_alt = get_option("central_build_sector_{$i}_image_alt");
            $url = get_option("central_build_sector_{$i}_url");
            
            if ($title || $description) {
                $sectors[] = array(
                    'icon' => $icon,
                    'tag' => $tag,
                    'title' => $title,
                    'description' => $description,
                    'image' => $image,
                    'image_alt' => $image_alt,
                    'url' => $url
                );
            }
        }
    }
    
    return $sectors;
}

/**
 * Get FAQs with backward compatibility
 */
function central_build_get_faqs() {
    $faqs = get_option('central_build_faqs', array());
    
    // If new format is empty, try to get from old format
    if (empty($faqs)) {
        $faqs = array();
        for ($i = 1; $i <= 5; $i++) {
            $question = get_option("central_build_faq_{$i}_question");
            $answer = get_option("central_build_faq_{$i}_answer");
            
            if ($question || $answer) {
                $faqs[] = array(
                    'question' => $question,
                    'answer' => $answer
                );
            }
        }
    }
    
    return $faqs;
}

/**
 * Get transform features with backward compatibility
 */
function central_build_get_transform_features() {
    $features = get_option('central_build_transform_features', array());
    
    // If new format is empty, try to get from old format
    if (empty($features)) {
        $features = array();
        for ($i = 1; $i <= 3; $i++) {
            $icon = get_option("central_build_transform_feature_{$i}_icon");
            $title = get_option("central_build_transform_feature_{$i}_title");
            $description = get_option("central_build_transform_feature_{$i}_description");
            
            if ($title || $description) {
                $features[] = array(
                    'icon' => $icon,
                    'title' => $title,
                    'description' => $description
                );
            }
        }
    }
    
    return $features;
}

/**
 * Get stats with backward compatibility
 */
function central_build_get_stats() {
    $stats = get_option('central_build_stats', array());
    
    // If new format is empty, try to get from old format
    if (empty($stats)) {
        $stats = array();
        for ($i = 1; $i <= 4; $i++) {
            $number = get_option("central_build_stat_{$i}_number");
            $label = get_option("central_build_stat_{$i}_label");
            
            if ($number || $label) {
                $stats[] = array(
                    'number' => $number,
                    'label' => $label
                );
            }
        }
    }
    
    return $stats;
}

/**
 * Get process steps with backward compatibility
 */
function central_build_get_process_steps() {
    $steps = get_option('central_build_process_steps', array());
    
    // If new format is empty, try to get from old format
    if (empty($steps)) {
        $steps = array();
        for ($i = 1; $i <= 3; $i++) {
            $icon = get_option("central_build_process_step_{$i}_icon");
            $title = get_option("central_build_process_step_{$i}_title");
            $description = get_option("central_build_process_step_{$i}_description");
            
            if ($title || $description) {
                $steps[] = array(
                    'icon' => $icon,
                    'title' => $title,
                    'description' => $description
                );
            }
        }
    }
    
    return $steps;
}

/**
 * Get project images with backward compatibility
 */
function central_build_get_project_images() {
    $images = get_option('central_build_project_images', array());
    
    // If new format is empty, try to get from old format
    if (empty($images)) {
        $images = array();
        for ($i = 1; $i <= 3; $i++) {
            $image = get_option("central_build_project_image_{$i}");
            $alt = get_option("central_build_project_image_{$i}_alt");
            
            if ($image) {
                $images[] = array(
                    'image' => $image,
                    'alt' => $alt
                );
            }
        }
    }
    
    return $images;
}
