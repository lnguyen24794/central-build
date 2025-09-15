<?php
/**
 * Central Build Pro Theme Functions
 *
 * @package Central_Build_Pro
 * @since 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Load view template with arguments
 *
 * @param string $template_path Path to template file
 * @param array $args Arguments to pass to template
 */
function loadView($template_path, $args = array()) {
    if (file_exists($template_path)) {
        // Make args available as variables in template
        extract($args);
        include $template_path;
    }
}

/**
 * Theme setup
 */
function central_build_setup() {
    // Add theme support for various features
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 300,
        'flex-height' => true,
        'flex-width'  => true,
    ));
    add_theme_support('custom-background');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    add_theme_support('post-formats', array(
        'image',
        'gallery',
        'video',
        'quote',
    ));
    add_theme_support('automatic-feed-links');
    add_theme_support('responsive-embeds');
    add_theme_support('wp-block-styles');
    add_theme_support('align-wide');

    // Set content width
    $GLOBALS['content_width'] = 1200;

    // Load text domain for translations
    load_theme_textdomain('central-build', get_template_directory() . '/languages');

    // Register navigation menus
    register_nav_menus(array(
        'primary' => esc_html__('Primary Menu', 'central-build'),
        'footer'  => esc_html__('Footer Menu', 'central-build'),
    ));

    // Add editor styles
    add_theme_support('editor-styles');
    add_editor_style('css/editor-style.css');
}
add_action('after_setup_theme', 'central_build_setup');

/**
 * Enqueue scripts and styles
 */
function central_build_scripts() {
    // Enqueue main JavaScript (our custom scripts)
    wp_enqueue_script('central-build-main', 'https://code.jquery.com/jquery-3.7.1.slim.min.js"', array('jquery'), '1.0.0', true);

    wp_enqueue_script('central-build-main', get_template_directory_uri() . '/js/bootstraps.min.js', array('jquery'), '1.0.0', true);
    // Enqueue Webflow CSS (main template styles)
    wp_enqueue_style('central-build-webflow', get_template_directory_uri() . '/css/main.min.css', array(), '1.0.0');
    
    // Enqueue main stylesheet (our custom styles)
    wp_enqueue_style('central-build-style', get_stylesheet_uri(), array('central-build-webflow'), '1.0.0');
    
    // Enqueue components CSS
    wp_enqueue_style('central-build-components', get_template_directory_uri() . '/css/components.css', array('central-build-style'), '1.0.0');
    
    // Enqueue Webflow overrides CSS
    wp_enqueue_style('central-build-webflow-overrides', get_template_directory_uri() . '/css/webflow-overrides.css', array('central-build-components'), '1.0.0');

    // Enqueue Google Fonts (Roboto) and Oswald from template
    wp_enqueue_style('central-build-fonts', 'https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap', array(), null);
    
    // Enqueue WebFont loader
    wp_enqueue_script('central-build-webfont', get_template_directory_uri() . '/js/webfont.js', array(), '1.0.0', false);



    // Enqueue comment reply script
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
    
    wp_localize_script('central-build-main', 'central_build_theme', array(
        'template_url' => get_template_directory_uri(),
        'home_url'     => home_url('/'),
    ));
}
add_action('wp_enqueue_scripts', 'central_build_scripts');

/**
 * Register widget areas
 */
function central_build_widgets_init() {
    register_sidebar(array(
        'name'          => esc_html__('Main Sidebar', 'central-build'),
        'id'            => 'sidebar-1',
        'description'   => esc_html__('Add widgets here to appear in your sidebar.', 'central-build'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    register_sidebar(array(
        'name'          => esc_html__('Footer Widget Area 1', 'central-build'),
        'id'            => 'footer-1',
        'description'   => esc_html__('Add widgets here to appear in the first footer column.', 'central-build'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    register_sidebar(array(
        'name'          => esc_html__('Footer Widget Area 2', 'central-build'),
        'id'            => 'footer-2',
        'description'   => esc_html__('Add widgets here to appear in the second footer column.', 'central-build'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    register_sidebar(array(
        'name'          => esc_html__('Footer Widget Area 3', 'central-build'),
        'id'            => 'footer-3',
        'description'   => esc_html__('Add widgets here to appear in the third footer column.', 'central-build'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'central_build_widgets_init');

/**
 * Custom excerpt length
 */
function central_build_excerpt_length($length) {
    return 30;
}
add_filter('excerpt_length', 'central_build_excerpt_length');

/**
 * Custom excerpt more
 */
function central_build_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'central_build_excerpt_more');

/**
 * Add custom image sizes
 */
function central_build_image_sizes() {
    add_image_size('central-build-featured', 800, 450, true);
    add_image_size('central-build-thumbnail', 300, 200, true);
    add_image_size('central-build-gallery', 600, 400, true);
}
add_action('after_setup_theme', 'central_build_image_sizes');

/**
 * Enqueue page-specific assets
 */
function central_build_page_assets() {
    // Home page assets
    if (is_front_page()) {
        wp_enqueue_style('central-build-home-min', get_template_directory_uri() . '/css/home.min.css', array('central-build-webflow'), '1.0.0');
        wp_enqueue_script('central-build-home-js', get_template_directory_uri() . '/js/home.js', array('jquery'), '1.0.0', true);
    }

    // Contact page assets
    if (is_page_template('page-contact.php')) {
        wp_enqueue_style('central-build-contact', get_template_directory_uri() . '/css/contact.css', array('central-build-style'), '1.0.0');
        wp_enqueue_script('central-build-contact-js', get_template_directory_uri() . '/js/contact.js', array('jquery'), '1.0.0', true);
    }

    // Service pages assets
    if (is_page_template('page-commercial-shop-fitting.php') || 
        is_page_template('page-concreet.php') || 
        is_page_template('page-custom-joinery.php')) {
        wp_enqueue_style('central-build-services', get_template_directory_uri() . '/css/services.css', array('central-build-style'), '1.0.0');
        wp_enqueue_script('central-build-services-js', get_template_directory_uri() . '/js/services.js', array('jquery'), '1.0.0', true);
    }

    // About pages assets
    if (is_page_template('page-our-values.php') || is_page_template('page-testimonials.php')) {
        wp_enqueue_style('central-build-about', get_template_directory_uri() . '/css/about.css', array('central-build-style'), '1.0.0');
    }

    // Portfolio/Fitout sectors assets
    if (is_page_template('page-fitout-sectors.php')) {
        wp_enqueue_style('central-build-portfolio', get_template_directory_uri() . '/css/portfolio.css', array('central-build-style'), '1.0.0');
        wp_enqueue_script('central-build-portfolio-js', get_template_directory_uri() . '/js/portfolio.js', array('jquery'), '1.0.0', true);
    }

    // Blog/Archive pages assets
    if (is_home() || is_archive() || is_search() || is_category() || is_tag() || is_author() || is_date()) {
        wp_enqueue_style('central-build-home-min', get_template_directory_uri() . '/css/home.min.css', array('central-build-webflow'), '1.0.0');
        wp_enqueue_style('central-build-blog', get_template_directory_uri() . '/css/blog-styles.css', array('central-build-home-min'), '1.0.0');
    }
}
add_action('wp_enqueue_scripts', 'central_build_page_assets');

/**
 * Customizer additions
 */
function central_build_customize_register($wp_customize) {
    // Site Identity Section
    $wp_customize->add_setting('central_build_phone', array(
        'default'           => '+61 431 465 090',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('central_build_phone', array(
        'label'    => esc_html__('Phone Number', 'central-build'),
        'section'  => 'title_tagline',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('central_build_email', array(
        'default'           => 'info@centralbuild.com',
        'sanitize_callback' => 'sanitize_email',
    ));

    $wp_customize->add_control('central_build_email', array(
        'label'    => esc_html__('Email Address', 'central-build'),
        'section'  => 'title_tagline',
        'type'     => 'email',
    ));

    // Front Page Sections Panel
    $wp_customize->add_panel('central_build_front_page', array(
        'title'       => esc_html__('Front Page Sections', 'central-build'),
        'description' => esc_html__('Customize the sections displayed on your front page.', 'central-build'),
        'priority'    => 130,
    ));

    // Section Visibility Settings
    $wp_customize->add_section('central_build_section_visibility', array(
        'title'    => esc_html__('Section Visibility', 'central-build'),
        'panel'    => 'central_build_front_page',
        'priority' => 10,
    ));

    // Hero Section
    $wp_customize->add_setting('central_build_show_hero_section', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('central_build_show_hero_section', array(
        'label'   => esc_html__('Show Hero Section', 'central-build'),
        'section' => 'central_build_section_visibility',
        'type'    => 'checkbox',
    ));

    // About Section
    $wp_customize->add_setting('central_build_show_about_section', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('central_build_show_about_section', array(
        'label'   => esc_html__('Show About Section', 'central-build'),
        'section' => 'central_build_section_visibility',
        'type'    => 'checkbox',
    ));

    // Trust Section
    $wp_customize->add_setting('central_build_show_trust_section', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('central_build_show_trust_section', array(
        'label'   => esc_html__('Show Trust Process Section', 'central-build'),
        'section' => 'central_build_section_visibility',
        'type'    => 'checkbox',
    ));

    // Partners Section
    $wp_customize->add_setting('central_build_show_partners_section', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('central_build_show_partners_section', array(
        'label'   => esc_html__('Show Partners Section', 'central-build'),
        'section' => 'central_build_section_visibility',
        'type'    => 'checkbox',
    ));

    // Testimonials Section
    $wp_customize->add_setting('central_build_show_testimonials_section', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('central_build_show_testimonials_section', array(
        'label'   => esc_html__('Show Testimonials Section', 'central-build'),
        'section' => 'central_build_section_visibility',
        'type'    => 'checkbox',
    ));

    // Featured Projects Section
    $wp_customize->add_setting('central_build_show_projects_section', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('central_build_show_projects_section', array(
        'label'   => esc_html__('Show Featured Projects Section', 'central-build'),
        'section' => 'central_build_section_visibility',
        'type'    => 'checkbox',
    ));

    // Commercial Section
    $wp_customize->add_setting('central_build_show_commercial_section', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('central_build_show_commercial_section', array(
        'label'   => esc_html__('Show Commercial Fitout Sectors Section', 'central-build'),
        'section' => 'central_build_section_visibility',
        'type'    => 'checkbox',
    ));

    // CTA Section
    $wp_customize->add_setting('central_build_show_cta_section', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('central_build_show_cta_section', array(
        'label'   => esc_html__('Show Call-to-Action Section', 'central-build'),
        'section' => 'central_build_section_visibility',
        'type'    => 'checkbox',
    ));

    // FAQ Section
    $wp_customize->add_setting('central_build_show_faq_section', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('central_build_show_faq_section', array(
        'label'   => esc_html__('Show FAQ Section', 'central-build'),
        'section' => 'central_build_section_visibility',
        'type'    => 'checkbox',
    ));

    // FAQ Transform Section
    $wp_customize->add_setting('central_build_show_faq_transform_section', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('central_build_show_faq_transform_section', array(
        'label'   => esc_html__('Show FAQ Transform Section', 'central-build'),
        'section' => 'central_build_section_visibility',
        'type'    => 'checkbox',
    ));

    // Hero Section Content
    $wp_customize->add_section('central_build_hero_content', array(
        'title'    => esc_html__('Hero Section Content', 'central-build'),
        'panel'    => 'central_build_front_page',
        'priority' => 20,
    ));

    // Hero Title
    $wp_customize->add_setting('central_build_hero_title', array(
        'default'           => __('Your Commercial Fitout, Made Simple', 'central-build'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('central_build_hero_title', array(
        'label'   => esc_html__('Hero Title', 'central-build'),
        'section' => 'central_build_hero_content',
        'type'    => 'text',
    ));

    // Hero Description
    $wp_customize->add_setting('central_build_hero_description', array(
        'default'           => __('A commercial fitout can feel like a lot especially if it\'s your first one. We\'re here to make it simple. From the start, you\'ll have a clear plan, fixed costs, and one team guiding you through the process. No variations. No confusion. Just a space that\'s built properly, so you can focus on your business.', 'central-build'),
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control('central_build_hero_description', array(
        'label'   => esc_html__('Hero Description', 'central-build'),
        'section' => 'central_build_hero_content',
        'type'    => 'textarea',
    ));

    // Hero Button Text
    $wp_customize->add_setting('central_build_hero_button_text', array(
        'default'           => __('Start Your Fitout Journey', 'central-build'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('central_build_hero_button_text', array(
        'label'   => esc_html__('Hero Button Text', 'central-build'),
        'section' => 'central_build_hero_content',
        'type'    => 'text',
    ));

    // Hero Button Subtext
    $wp_customize->add_setting('central_build_hero_button_subtext', array(
        'default'           => __('Learn more', 'central-build'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('central_build_hero_button_subtext', array(
        'label'   => esc_html__('Hero Button Subtext', 'central-build'),
        'section' => 'central_build_hero_content',
        'type'    => 'text',
    ));

    // Hero Button URL
    $wp_customize->add_setting('central_build_hero_button_url', array(
        'default'           => home_url('/commercial-shop-fitting'),
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('central_build_hero_button_url', array(
        'label'   => esc_html__('Hero Button URL', 'central-build'),
        'section' => 'central_build_hero_content',
        'type'    => 'url',
    ));

    // Trust Section Content
    $wp_customize->add_section('central_build_trust_content', array(
        'title'    => esc_html__('Trust Process Section', 'central-build'),
        'panel'    => 'central_build_front_page',
        'priority' => 30,
    ));

    // Trust Section Title
    $wp_customize->add_setting('central_build_trust_title', array(
        'default'           => __('Trust in<br>ENP Fitouts Process', 'central-build'),
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control('central_build_trust_title', array(
        'label'   => esc_html__('Trust Section Title', 'central-build'),
        'section' => 'central_build_trust_content',
        'type'    => 'text',
    ));

    // Feature 1 Settings
    $wp_customize->add_setting('central_build_trust_feature1_icon', array(
        'default'           => get_template_directory_uri() . '/images/66f1ffecdef9310969f579e0_Engg-Icon.svg',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'central_build_trust_feature1_icon', array(
        'label'   => esc_html__('Feature 1 Icon', 'central-build'),
        'section' => 'central_build_trust_content',
    )));

    $wp_customize->add_setting('central_build_trust_feature1_title', array(
        'default'           => __('A Structured Fitout Process', 'central-build'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('central_build_trust_feature1_title', array(
        'label'   => esc_html__('Feature 1 Title', 'central-build'),
        'section' => 'central_build_trust_content',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('central_build_trust_feature1_description', array(
        'default'           => __('Most delays happen because of poor planning. We solve that with a clear, step-by-step process built around your business needs. From the start, you\'ll know what\'s happening, when it\'s happening, and what to expect next. With built-in approvals and check-ins along the way, there\'s no confusion or chaos — just structure you can rely on.', 'central-build'),
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control('central_build_trust_feature1_description', array(
        'label'   => esc_html__('Feature 1 Description', 'central-build'),
        'section' => 'central_build_trust_content',
        'type'    => 'textarea',
    ));

    // Feature 2 Settings
    $wp_customize->add_setting('central_build_trust_feature2_icon', array(
        'default'           => get_template_directory_uri() . '/images/66f1ffecdef9310969f57a0a_Project-Icon.svg',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'central_build_trust_feature2_icon', array(
        'label'   => esc_html__('Feature 2 Icon', 'central-build'),
        'section' => 'central_build_trust_content',
    )));

    $wp_customize->add_setting('central_build_trust_feature2_title', array(
        'default'           => __('Hands-On Project Support', 'central-build'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('central_build_trust_feature2_title', array(
        'label'   => esc_html__('Feature 2 Title', 'central-build'),
        'section' => 'central_build_trust_content',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('central_build_trust_feature2_description', array(
        'default'           => __('You won\'t be chasing trades or wondering what\'s going on onsite. You\'ll have a dedicated project manager who coordinates everything from permits and council approvals to joinery installation. We deal with the issues before they affect your timeline, and keep you informed without overwhelming you.', 'central-build'),
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control('central_build_trust_feature2_description', array(
        'label'   => esc_html__('Feature 2 Description', 'central-build'),
        'section' => 'central_build_trust_content',
        'type'    => 'textarea',
    ));

    // Feature 3 Settings
    $wp_customize->add_setting('central_build_trust_feature3_icon', array(
        'default'           => get_template_directory_uri() . '/images/66f1ffecdef9310969f579df_Financial-Icon.svg',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'central_build_trust_feature3_icon', array(
        'label'   => esc_html__('Feature 3 Icon', 'central-build'),
        'section' => 'central_build_trust_content',
    )));

    $wp_customize->add_setting('central_build_trust_feature3_title', array(
        'default'           => __('Transparent Cost Management', 'central-build'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('central_build_trust_feature3_title', array(
        'label'   => esc_html__('Feature 3 Title', 'central-build'),
        'section' => 'central_build_trust_content',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('central_build_trust_feature3_description', array(
        'default'           => __('We don\'t do vague quotes or "TBC" allowances. Every quote is detailed, costed properly, and confirmed with our trades. That means you know where every dollar is going before the build starts. If anything changes, we talk it through with you — no surprise charges or last-minute add-ons.', 'central-build'),
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control('central_build_trust_feature3_description', array(
        'label'   => esc_html__('Feature 3 Description', 'central-build'),
        'section' => 'central_build_trust_content',
        'type'    => 'textarea',
    ));

    // Partners Section Content
    $wp_customize->add_section('central_build_partners_content', array(
        'title'    => esc_html__('Partners/Clients Section', 'central-build'),
        'panel'    => 'central_build_front_page',
        'priority' => 40,
    ));

    // Add partner logo settings (12 partners total)
    for ($i = 1; $i <= 12; $i++) {
        // Partner Logo
        $wp_customize->add_setting("central_build_partner_{$i}_logo", array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, "central_build_partner_{$i}_logo", array(
            'label'   => sprintf(esc_html__('Partner %d Logo', 'central-build'), $i),
            'section' => 'central_build_partners_content',
        )));

        // Partner Name
        $wp_customize->add_setting("central_build_partner_{$i}_name", array(
            'default'           => sprintf(__('Partner %d', 'central-build'), $i),
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control("central_build_partner_{$i}_name", array(
            'label'   => sprintf(esc_html__('Partner %d Name', 'central-build'), $i),
            'section' => 'central_build_partners_content',
            'type'    => 'text',
        ));

        // Partner URL
        $wp_customize->add_setting("central_build_partner_{$i}_url", array(
            'default'           => '#',
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control("central_build_partner_{$i}_url", array(
            'label'   => sprintf(esc_html__('Partner %d URL', 'central-build'), $i),
            'section' => 'central_build_partners_content',
            'type'    => 'url',
        ));
    }

    // Testimonials Section Content
    $wp_customize->add_section('central_build_testimonials_content', array(
        'title'    => esc_html__('Testimonials Section', 'central-build'),
        'panel'    => 'central_build_front_page',
        'priority' => 50,
    ));

    // Testimonials Section Settings
    $wp_customize->add_setting('central_build_testimonials_tag', array(
        'default'           => __('Testimonial', 'central-build'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('central_build_testimonials_tag', array(
        'label'   => esc_html__('Section Tag', 'central-build'),
        'section' => 'central_build_testimonials_content',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('central_build_testimonials_title', array(
        'default'           => __('Words from Those Who\'ve Trusted Us', 'central-build'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('central_build_testimonials_title', array(
        'label'   => esc_html__('Section Title', 'central-build'),
        'section' => 'central_build_testimonials_content',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('central_build_testimonials_description', array(
        'default'           => __('Discover why clients trust us for their Fitouts. Our commitment to quality and on-time delivery is reflected in their positive feedback.', 'central-build'),
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control('central_build_testimonials_description', array(
        'label'   => esc_html__('Section Description', 'central-build'),
        'section' => 'central_build_testimonials_content',
        'type'    => 'textarea',
    ));

    // Button Settings
    $wp_customize->add_setting('central_build_testimonials_button_text', array(
        'default'           => __('Testimonials', 'central-build'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('central_build_testimonials_button_text', array(
        'label'   => esc_html__('Button Text', 'central-build'),
        'section' => 'central_build_testimonials_content',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('central_build_testimonials_button_subtext', array(
        'default'           => __('Learn more', 'central-build'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('central_build_testimonials_button_subtext', array(
        'label'   => esc_html__('Button Subtext', 'central-build'),
        'section' => 'central_build_testimonials_content',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('central_build_testimonials_button_url', array(
        'default'           => home_url('/testimonials'),
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('central_build_testimonials_button_url', array(
        'label'   => esc_html__('Button URL', 'central-build'),
        'section' => 'central_build_testimonials_content',
        'type'    => 'url',
    ));

    // Testimonials Image
    $wp_customize->add_setting('central_build_testimonials_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'central_build_testimonials_image', array(
        'label'   => esc_html__('Section Image', 'central-build'),
        'section' => 'central_build_testimonials_content',
    )));

    // Individual Testimonials (3 testimonials)
    for ($i = 1; $i <= 3; $i++) {
        // Testimonial Content
        $wp_customize->add_setting("central_build_testimonial_{$i}_content", array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_textarea_field',
        ));
        $wp_customize->add_control("central_build_testimonial_{$i}_content", array(
            'label'   => sprintf(esc_html__('Testimonial %d Content', 'central-build'), $i),
            'section' => 'central_build_testimonials_content',
            'type'    => 'textarea',
        ));

        // Testimonial Name
        $wp_customize->add_setting("central_build_testimonial_{$i}_name", array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control("central_build_testimonial_{$i}_name", array(
            'label'   => sprintf(esc_html__('Testimonial %d Name', 'central-build'), $i),
            'section' => 'central_build_testimonials_content',
            'type'    => 'text',
        ));

        // Testimonial Position
        $wp_customize->add_setting("central_build_testimonial_{$i}_position", array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control("central_build_testimonial_{$i}_position", array(
            'label'   => sprintf(esc_html__('Testimonial %d Position', 'central-build'), $i),
            'section' => 'central_build_testimonials_content',
            'type'    => 'text',
        ));

        // Testimonial Image
        $wp_customize->add_setting("central_build_testimonial_{$i}_image", array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, "central_build_testimonial_{$i}_image", array(
            'label'   => sprintf(esc_html__('Testimonial %d Image', 'central-build'), $i),
            'section' => 'central_build_testimonials_content',
        )));
    }

    // Featured Projects Section Content
    $wp_customize->add_section('central_build_projects_content', array(
        'title'    => esc_html__('Featured Projects Section', 'central-build'),
        'panel'    => 'central_build_front_page',
        'priority' => 60,
    ));

    // Projects Section Header
    $wp_customize->add_setting('central_build_projects_title', array(
        'default'           => __('Start Your Fitout Journey Today', 'central-build'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('central_build_projects_title', array(
        'label'   => esc_html__('Section Title', 'central-build'),
        'section' => 'central_build_projects_content',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('central_build_projects_subtitle', array(
        'default'           => __('Don\'t Fit in with your Average Fitout.', 'central-build'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('central_build_projects_subtitle', array(
        'label'   => esc_html__('Section Subtitle', 'central-build'),
        'section' => 'central_build_projects_content',
        'type'    => 'text',
    ));

    // Process Steps (3 steps)
    for ($i = 1; $i <= 3; $i++) {
        // Step Icon
        $wp_customize->add_setting("central_build_process_step_{$i}_icon", array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, "central_build_process_step_{$i}_icon", array(
            'label'   => sprintf(esc_html__('Step %d Icon', 'central-build'), $i),
            'section' => 'central_build_projects_content',
        )));

        // Step Title
        $wp_customize->add_setting("central_build_process_step_{$i}_title", array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control("central_build_process_step_{$i}_title", array(
            'label'   => sprintf(esc_html__('Step %d Title', 'central-build'), $i),
            'section' => 'central_build_projects_content',
            'type'    => 'text',
        ));

        // Step Description
        $wp_customize->add_setting("central_build_process_step_{$i}_description", array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_textarea_field',
        ));
        $wp_customize->add_control("central_build_process_step_{$i}_description", array(
            'label'   => sprintf(esc_html__('Step %d Description', 'central-build'), $i),
            'section' => 'central_build_projects_content',
            'type'    => 'textarea',
        ));
    }

    // Project Images (3 images)
    for ($i = 1; $i <= 3; $i++) {
        // Project Image
        $wp_customize->add_setting("central_build_project_image_{$i}", array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, "central_build_project_image_{$i}", array(
            'label'   => sprintf(esc_html__('Project Image %d', 'central-build'), $i),
            'section' => 'central_build_projects_content',
        )));

        // Project Image Alt Text
        $wp_customize->add_setting("central_build_project_image_{$i}_alt", array(
            'default'           => __('ENP Fitouts project team on site at commercial fitout', 'central-build'),
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control("central_build_project_image_{$i}_alt", array(
            'label'   => sprintf(esc_html__('Project Image %d Alt Text', 'central-build'), $i),
            'section' => 'central_build_projects_content',
            'type'    => 'text',
        ));
    }

    // Projects Button Settings
    $wp_customize->add_setting('central_build_projects_button_text', array(
        'default'           => __('Start Today!', 'central-build'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('central_build_projects_button_text', array(
        'label'   => esc_html__('Button Text', 'central-build'),
        'section' => 'central_build_projects_content',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('central_build_projects_button_subtext', array(
        'default'           => __('Learn more', 'central-build'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('central_build_projects_button_subtext', array(
        'label'   => esc_html__('Button Subtext', 'central-build'),
        'section' => 'central_build_projects_content',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('central_build_projects_button_url', array(
        'default'           => home_url('/contact'),
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('central_build_projects_button_url', array(
        'label'   => esc_html__('Button URL', 'central-build'),
        'section' => 'central_build_projects_content',
        'type'    => 'url',
    ));

    // Statistics (4 stats)
    for ($i = 1; $i <= 4; $i++) {
        // Stat Number
        $wp_customize->add_setting("central_build_stat_{$i}_number", array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control("central_build_stat_{$i}_number", array(
            'label'   => sprintf(esc_html__('Statistic %d Number', 'central-build'), $i),
            'section' => 'central_build_projects_content',
            'type'    => 'text',
        ));

        // Stat Label
        $wp_customize->add_setting("central_build_stat_{$i}_label", array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control("central_build_stat_{$i}_label", array(
            'label'   => sprintf(esc_html__('Statistic %d Label', 'central-build'), $i),
            'section' => 'central_build_projects_content',
            'type'    => 'text',
        ));
    }

    // CTA Section Settings
    $wp_customize->add_setting('central_build_cta_title', array(
        'default'           => __('Fitouts Shouldn\'t Be This Hard', 'central-build'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('central_build_cta_title', array(
        'label'   => esc_html__('CTA Title', 'central-build'),
        'section' => 'central_build_projects_content',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('central_build_cta_description', array(
        'default'           => __('Overwhelmed trying to manage every part of your fitout? From designs to trades, certifications, and approvals, it adds up fast.<br>We take care of it all. You\'ll have one experienced team, one point of contact, and a clear, structured plan to follow.<br>Have a space that\'s done right, ready to use, and built to support your business from day one.', 'central-build'),
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control('central_build_cta_description', array(
        'label'   => esc_html__('CTA Description', 'central-build'),
        'section' => 'central_build_projects_content',
        'type'    => 'textarea',
    ));

    $wp_customize->add_setting('central_build_cta_button_text', array(
        'default'           => __('Start Today!', 'central-build'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('central_build_cta_button_text', array(
        'label'   => esc_html__('CTA Button Text', 'central-build'),
        'section' => 'central_build_projects_content',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('central_build_cta_button_subtext', array(
        'default'           => __('Learn more', 'central-build'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('central_build_cta_button_subtext', array(
        'label'   => esc_html__('CTA Button Subtext', 'central-build'),
        'section' => 'central_build_projects_content',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('central_build_cta_button_url', array(
        'default'           => home_url('/contact'),
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('central_build_cta_button_url', array(
        'label'   => esc_html__('CTA Button URL', 'central-build'),
        'section' => 'central_build_projects_content',
        'type'    => 'url',
    ));

    $wp_customize->add_setting('central_build_cta_background_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'central_build_cta_background_image', array(
        'label'   => esc_html__('CTA Background Image', 'central-build'),
        'section' => 'central_build_projects_content',
    )));

    // Commercial Projects Section Content
    $wp_customize->add_section('central_build_commercial_content', array(
        'title'    => esc_html__('Commercial Projects Section', 'central-build'),
        'panel'    => 'central_build_front_page',
        'priority' => 70,
    ));

    // Commercial Section Header
    $wp_customize->add_setting('central_build_commercial_tag', array(
        'default'           => __('Service', 'central-build'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('central_build_commercial_tag', array(
        'label'   => esc_html__('Section Tag', 'central-build'),
        'section' => 'central_build_commercial_content',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('central_build_commercial_title', array(
        'default'           => __('Check out <br>our latest work', 'central-build'),
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control('central_build_commercial_title', array(
        'label'   => esc_html__('Section Title', 'central-build'),
        'section' => 'central_build_commercial_content',
        'type'    => 'textarea',
        'description' => esc_html__('Use <br> for line breaks', 'central-build'),
    ));

    // Commercial Projects (8 projects total)
    for ($i = 1; $i <= 8; $i++) {
        // Project Image
        $wp_customize->add_setting("central_build_commercial_project_{$i}_image", array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, "central_build_commercial_project_{$i}_image", array(
            'label'   => sprintf(esc_html__('Project %d Image', 'central-build'), $i),
            'section' => 'central_build_commercial_content',
        )));

        // Project Title
        $wp_customize->add_setting("central_build_commercial_project_{$i}_title", array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control("central_build_commercial_project_{$i}_title", array(
            'label'   => sprintf(esc_html__('Project %d Title', 'central-build'), $i),
            'section' => 'central_build_commercial_content',
            'type'    => 'text',
        ));

        // Project URL
        $wp_customize->add_setting("central_build_commercial_project_{$i}_url", array(
            'default'           => '#',
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control("central_build_commercial_project_{$i}_url", array(
            'label'   => sprintf(esc_html__('Project %d URL', 'central-build'), $i),
            'section' => 'central_build_commercial_content',
            'type'    => 'url',
        ));

        // Project Alt Text
        $wp_customize->add_setting("central_build_commercial_project_{$i}_alt", array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control("central_build_commercial_project_{$i}_alt", array(
            'label'   => sprintf(esc_html__('Project %d Alt Text', 'central-build'), $i),
            'section' => 'central_build_commercial_content',
            'type'    => 'text',
        ));
    }

    // Checkout/Sectors Section Content
    $wp_customize->add_section('central_build_checkout_content', array(
        'title'    => esc_html__('Fitout Sectors Section', 'central-build'),
        'panel'    => 'central_build_front_page',
        'priority' => 80,
    ));

    // Checkout Section Header
    $wp_customize->add_setting('central_build_checkout_icon', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'central_build_checkout_icon', array(
        'label'   => esc_html__('Section Icon', 'central-build'),
        'section' => 'central_build_checkout_content',
    )));

    $wp_customize->add_setting('central_build_checkout_title', array(
        'default'           => __('Commercial Fitout Sectors', 'central-build'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('central_build_checkout_title', array(
        'label'   => esc_html__('Section Title', 'central-build'),
        'section' => 'central_build_checkout_content',
        'type'    => 'text',
    ));

    // Fitout Sectors (5 sectors)
    for ($i = 1; $i <= 5; $i++) {
        // Sector Icon
        $wp_customize->add_setting("central_build_sector_{$i}_icon", array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, "central_build_sector_{$i}_icon", array(
            'label'   => sprintf(esc_html__('Sector %d Icon', 'central-build'), $i),
            'section' => 'central_build_checkout_content',
        )));

        // Sector Tag
        $wp_customize->add_setting("central_build_sector_{$i}_tag", array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control("central_build_sector_{$i}_tag", array(
            'label'   => sprintf(esc_html__('Sector %d Tag', 'central-build'), $i),
            'section' => 'central_build_checkout_content',
            'type'    => 'text',
        ));

        // Sector Title
        $wp_customize->add_setting("central_build_sector_{$i}_title", array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control("central_build_sector_{$i}_title", array(
            'label'   => sprintf(esc_html__('Sector %d Title', 'central-build'), $i),
            'section' => 'central_build_checkout_content',
            'type'    => 'text',
        ));

        // Sector Description
        $wp_customize->add_setting("central_build_sector_{$i}_description", array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_textarea_field',
        ));
        $wp_customize->add_control("central_build_sector_{$i}_description", array(
            'label'   => sprintf(esc_html__('Sector %d Description', 'central-build'), $i),
            'section' => 'central_build_checkout_content',
            'type'    => 'textarea',
        ));

        // Sector Image
        $wp_customize->add_setting("central_build_sector_{$i}_image", array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, "central_build_sector_{$i}_image", array(
            'label'   => sprintf(esc_html__('Sector %d Image', 'central-build'), $i),
            'section' => 'central_build_checkout_content',
        )));

        // Sector Image Alt Text
        $wp_customize->add_setting("central_build_sector_{$i}_image_alt", array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control("central_build_sector_{$i}_image_alt", array(
            'label'   => sprintf(esc_html__('Sector %d Image Alt Text', 'central-build'), $i),
            'section' => 'central_build_checkout_content',
            'type'    => 'text',
        ));

        // Sector URL
        $wp_customize->add_setting("central_build_sector_{$i}_url", array(
            'default'           => '#',
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control("central_build_sector_{$i}_url", array(
            'label'   => sprintf(esc_html__('Sector %d URL', 'central-build'), $i),
            'section' => 'central_build_checkout_content',
            'type'    => 'url',
        ));
    }

    // Checkout Button Settings
    $wp_customize->add_setting('central_build_checkout_button_text', array(
        'default'           => __('Check out our Portfolio', 'central-build'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('central_build_checkout_button_text', array(
        'label'   => esc_html__('Button Text', 'central-build'),
        'section' => 'central_build_checkout_content',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('central_build_checkout_button_subtext', array(
        'default'           => __('Learn more', 'central-build'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('central_build_checkout_button_subtext', array(
        'label'   => esc_html__('Button Subtext', 'central-build'),
        'section' => 'central_build_checkout_content',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('central_build_checkout_button_url', array(
        'default'           => home_url('/contact'),
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('central_build_checkout_button_url', array(
        'label'   => esc_html__('Button URL', 'central-build'),
        'section' => 'central_build_checkout_content',
        'type'    => 'url',
    ));

    // FAQ Sections Content
    $wp_customize->add_section('central_build_faq_content', array(
        'title'    => esc_html__('FAQ Sections', 'central-build'),
        'panel'    => 'central_build_front_page',
        'priority' => 90,
    ));

    // FAQ Section Title
    $wp_customize->add_setting('central_build_faq_title', array(
        'default'           => __('Frequently Asked Question', 'central-build'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('central_build_faq_title', array(
        'label'   => esc_html__('FAQ Section Title', 'central-build'),
        'section' => 'central_build_faq_content',
        'type'    => 'text',
    ));

    // FAQ Items (5 FAQs)
    for ($i = 1; $i <= 5; $i++) {
        // FAQ Question
        $wp_customize->add_setting("central_build_faq_{$i}_question", array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control("central_build_faq_{$i}_question", array(
            'label'   => sprintf(esc_html__('FAQ %d Question', 'central-build'), $i),
            'section' => 'central_build_faq_content',
            'type'    => 'text',
        ));

        // FAQ Answer
        $wp_customize->add_setting("central_build_faq_{$i}_answer", array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_textarea_field',
        ));
        $wp_customize->add_control("central_build_faq_{$i}_answer", array(
            'label'   => sprintf(esc_html__('FAQ %d Answer', 'central-build'), $i),
            'section' => 'central_build_faq_content',
            'type'    => 'textarea',
        ));
    }

    // Transform Section Title
    $wp_customize->add_setting('central_build_transform_title', array(
        'default'           => __('Ready to Transform Your space?', 'central-build'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('central_build_transform_title', array(
        'label'   => esc_html__('Transform Section Title', 'central-build'),
        'section' => 'central_build_faq_content',
        'type'    => 'text',
    ));

    // Transform Features (3 features)
    for ($i = 1; $i <= 3; $i++) {
        // Feature Icon
        $wp_customize->add_setting("central_build_transform_feature_{$i}_icon", array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, "central_build_transform_feature_{$i}_icon", array(
            'label'   => sprintf(esc_html__('Transform Feature %d Icon', 'central-build'), $i),
            'section' => 'central_build_faq_content',
        )));

        // Feature Title
        $wp_customize->add_setting("central_build_transform_feature_{$i}_title", array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control("central_build_transform_feature_{$i}_title", array(
            'label'   => sprintf(esc_html__('Transform Feature %d Title', 'central-build'), $i),
            'section' => 'central_build_faq_content',
            'type'    => 'text',
        ));

        // Feature Description
        $wp_customize->add_setting("central_build_transform_feature_{$i}_description", array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_textarea_field',
        ));
        $wp_customize->add_control("central_build_transform_feature_{$i}_description", array(
            'label'   => sprintf(esc_html__('Transform Feature %d Description', 'central-build'), $i),
            'section' => 'central_build_faq_content',
            'type'    => 'textarea',
        ));
    }

    // Transform Button Settings
    $wp_customize->add_setting('central_build_transform_button_text', array(
        'default'           => __('Check out our Portfolio', 'central-build'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('central_build_transform_button_text', array(
        'label'   => esc_html__('Transform Button Text', 'central-build'),
        'section' => 'central_build_faq_content',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('central_build_transform_button_subtext', array(
        'default'           => __('Learn more', 'central-build'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('central_build_transform_button_subtext', array(
        'label'   => esc_html__('Transform Button Subtext', 'central-build'),
        'section' => 'central_build_faq_content',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('central_build_transform_button_url', array(
        'default'           => home_url('/contact'),
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('central_build_transform_button_url', array(
        'label'   => esc_html__('Transform Button URL', 'central-build'),
        'section' => 'central_build_faq_content',
        'type'    => 'url',
    ));

    // Colors Section
    $wp_customize->add_setting('central_build_primary_color', array(
        'default'           => '#007BFF',
        'sanitize_callback' => 'sanitize_hex_color',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'central_build_primary_color', array(
        'label'    => esc_html__('Primary Color', 'central-build'),
        'section'  => 'colors',
    )));

    $wp_customize->add_setting('central_build_accent_color', array(
        'default'           => '#333333',
        'sanitize_callback' => 'sanitize_hex_color',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'central_build_accent_color', array(
        'label'    => esc_html__('Accent Color', 'central-build'),
        'section'  => 'colors',
    )));

    // Social Media Section
    $wp_customize->add_section('central_build_social', array(
        'title'    => esc_html__('Social Media', 'central-build'),
        'priority' => 130,
    ));

    $social_networks = array(
        'facebook'  => 'Facebook',
        'twitter'   => 'Twitter',
        'instagram' => 'Instagram',
        'linkedin'  => 'LinkedIn',
        'youtube'   => 'YouTube',
    );

    foreach ($social_networks as $network => $label) {
        $wp_customize->add_setting("central_build_social_{$network}", array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));

        $wp_customize->add_control("central_build_social_{$network}", array(
            'label'   => $label . ' ' . esc_html__('URL', 'central-build'),
            'section' => 'central_build_social',
            'type'    => 'url',
        ));
    }
}
add_action('customize_register', 'central_build_customize_register');

/**
 * Custom post types
 */
function central_build_custom_post_types() {
    // Portfolio Post Type
    register_post_type('portfolio', array(
        'labels' => array(
            'name'               => esc_html__('Portfolio', 'central-build'),
            'singular_name'      => esc_html__('Portfolio Item', 'central-build'),
            'menu_name'          => esc_html__('Portfolio', 'central-build'),
            'add_new'            => esc_html__('Add New', 'central-build'),
            'add_new_item'       => esc_html__('Add New Portfolio Item', 'central-build'),
            'edit_item'          => esc_html__('Edit Portfolio Item', 'central-build'),
            'new_item'           => esc_html__('New Portfolio Item', 'central-build'),
            'view_item'          => esc_html__('View Portfolio Item', 'central-build'),
            'search_items'       => esc_html__('Search Portfolio', 'central-build'),
            'not_found'          => esc_html__('No portfolio items found', 'central-build'),
            'not_found_in_trash' => esc_html__('No portfolio items found in trash', 'central-build'),
        ),
        'public'        => true,
        'has_archive'   => true,
        'menu_icon'     => 'dashicons-portfolio',
        'supports'      => array('title', 'editor', 'thumbnail', 'excerpt'),
        'rewrite'       => array('slug' => 'portfolio'),
        'show_in_rest'  => true,
    ));

    // Testimonials Post Type
    register_post_type('testimonials', array(
        'labels' => array(
            'name'               => esc_html__('Testimonials', 'central-build'),
            'singular_name'      => esc_html__('Testimonial', 'central-build'),
            'menu_name'          => esc_html__('Testimonials', 'central-build'),
            'add_new'            => esc_html__('Add New', 'central-build'),
            'add_new_item'       => esc_html__('Add New Testimonial', 'central-build'),
            'edit_item'          => esc_html__('Edit Testimonial', 'central-build'),
            'new_item'           => esc_html__('New Testimonial', 'central-build'),
            'view_item'          => esc_html__('View Testimonial', 'central-build'),
            'search_items'       => esc_html__('Search Testimonials', 'central-build'),
            'not_found'          => esc_html__('No testimonials found', 'central-build'),
            'not_found_in_trash' => esc_html__('No testimonials found in trash', 'central-build'),
        ),
        'public'        => true,
        'has_archive'   => true,
        'menu_icon'     => 'dashicons-format-quote',
        'supports'      => array('title', 'editor', 'thumbnail'),
        'rewrite'       => array('slug' => 'testimonials'),
        'show_in_rest'  => true,
    ));
}
add_action('init', 'central_build_custom_post_types');

/**
 * Custom taxonomies
 */
function central_build_custom_taxonomies() {
    // Portfolio Categories
    register_taxonomy('portfolio_category', 'portfolio', array(
        'labels' => array(
            'name'              => esc_html__('Portfolio Categories', 'central-build'),
            'singular_name'     => esc_html__('Portfolio Category', 'central-build'),
            'search_items'      => esc_html__('Search Categories', 'central-build'),
            'all_items'         => esc_html__('All Categories', 'central-build'),
            'parent_item'       => esc_html__('Parent Category', 'central-build'),
            'parent_item_colon' => esc_html__('Parent Category:', 'central-build'),
            'edit_item'         => esc_html__('Edit Category', 'central-build'),
            'update_item'       => esc_html__('Update Category', 'central-build'),
            'add_new_item'      => esc_html__('Add New Category', 'central-build'),
            'new_item_name'     => esc_html__('New Category Name', 'central-build'),
            'menu_name'         => esc_html__('Categories', 'central-build'),
        ),
        'hierarchical'      => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'portfolio-category'),
        'show_in_rest'      => true,
    ));
}
add_action('init', 'central_build_custom_taxonomies');

/**
 * Add custom meta boxes
 */
function central_build_add_meta_boxes() {
    add_meta_box(
        'portfolio_details',
        esc_html__('Portfolio Details', 'central-build'),
        'central_build_portfolio_meta_box',
        'portfolio',
        'normal',
        'high'
    );

    add_meta_box(
        'testimonial_details',
        esc_html__('Testimonial Details', 'central-build'),
        'central_build_testimonial_meta_box',
        'testimonials',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'central_build_add_meta_boxes');

/**
 * Portfolio meta box callback
 */
function central_build_portfolio_meta_box($post) {
    wp_nonce_field('central_build_portfolio_meta', 'central_build_portfolio_nonce');
    
    $client = get_post_meta($post->ID, '_portfolio_client', true);
    $project_date = get_post_meta($post->ID, '_portfolio_date', true);
    $project_url = get_post_meta($post->ID, '_portfolio_url', true);
    $gallery = get_post_meta($post->ID, '_portfolio_gallery', true);
    
    ?>
    <table class="form-table">
        <tr>
            <th><label for="portfolio_client"><?php esc_html_e('Client Name', 'central-build'); ?></label></th>
            <td><input type="text" id="portfolio_client" name="portfolio_client" value="<?php echo esc_attr($client); ?>" class="regular-text" /></td>
        </tr>
        <tr>
            <th><label for="portfolio_date"><?php esc_html_e('Project Date', 'central-build'); ?></label></th>
            <td><input type="date" id="portfolio_date" name="portfolio_date" value="<?php echo esc_attr($project_date); ?>" class="regular-text" /></td>
        </tr>
        <tr>
            <th><label for="portfolio_url"><?php esc_html_e('Project URL', 'central-build'); ?></label></th>
            <td><input type="url" id="portfolio_url" name="portfolio_url" value="<?php echo esc_url($project_url); ?>" class="regular-text" /></td>
        </tr>
        <tr>
            <th><label for="portfolio_gallery"><?php esc_html_e('Gallery Images (comma-separated IDs)', 'central-build'); ?></label></th>
            <td><input type="text" id="portfolio_gallery" name="portfolio_gallery" value="<?php echo esc_attr($gallery); ?>" class="regular-text" /></td>
        </tr>
    </table>
    <?php
}

/**
 * Testimonial meta box callback
 */
function central_build_testimonial_meta_box($post) {
    wp_nonce_field('central_build_testimonial_meta', 'central_build_testimonial_nonce');
    
    $author_name = get_post_meta($post->ID, '_testimonial_author', true);
    $author_position = get_post_meta($post->ID, '_testimonial_position', true);
    $author_company = get_post_meta($post->ID, '_testimonial_company', true);
    $rating = get_post_meta($post->ID, '_testimonial_rating', true);
    
    ?>
    <table class="form-table">
        <tr>
            <th><label for="testimonial_author"><?php esc_html_e('Author Name', 'central-build'); ?></label></th>
            <td><input type="text" id="testimonial_author" name="testimonial_author" value="<?php echo esc_attr($author_name); ?>" class="regular-text" /></td>
        </tr>
        <tr>
            <th><label for="testimonial_position"><?php esc_html_e('Position', 'central-build'); ?></label></th>
            <td><input type="text" id="testimonial_position" name="testimonial_position" value="<?php echo esc_attr($author_position); ?>" class="regular-text" /></td>
        </tr>
        <tr>
            <th><label for="testimonial_company"><?php esc_html_e('Company', 'central-build'); ?></label></th>
            <td><input type="text" id="testimonial_company" name="testimonial_company" value="<?php echo esc_attr($author_company); ?>" class="regular-text" /></td>
        </tr>
        <tr>
            <th><label for="testimonial_rating"><?php esc_html_e('Rating (1-5)', 'central-build'); ?></label></th>
            <td>
                <select id="testimonial_rating" name="testimonial_rating">
                    <option value=""><?php esc_html_e('Select Rating', 'central-build'); ?></option>
                    <?php for ($i = 1; $i <= 5; $i++) : ?>
                        <option value="<?php echo $i; ?>" <?php selected($rating, $i); ?>><?php echo $i; ?> <?php esc_html_e('Star(s)', 'central-build'); ?></option>
                    <?php endfor; ?>
                </select>
            </td>
        </tr>
    </table>
    <?php
}

/**
 * Save meta box data
 */
function central_build_save_meta_boxes($post_id) {
    // Portfolio meta
    if (isset($_POST['central_build_portfolio_nonce']) && wp_verify_nonce($_POST['central_build_portfolio_nonce'], 'central_build_portfolio_meta')) {
        if (isset($_POST['portfolio_client'])) {
            update_post_meta($post_id, '_portfolio_client', sanitize_text_field($_POST['portfolio_client']));
        }
        if (isset($_POST['portfolio_date'])) {
            update_post_meta($post_id, '_portfolio_date', sanitize_text_field($_POST['portfolio_date']));
        }
        if (isset($_POST['portfolio_url'])) {
            update_post_meta($post_id, '_portfolio_url', esc_url_raw($_POST['portfolio_url']));
        }
        if (isset($_POST['portfolio_gallery'])) {
            update_post_meta($post_id, '_portfolio_gallery', sanitize_text_field($_POST['portfolio_gallery']));
        }
    }

    // Testimonial meta
    if (isset($_POST['central_build_testimonial_nonce']) && wp_verify_nonce($_POST['central_build_testimonial_nonce'], 'central_build_testimonial_meta')) {
        if (isset($_POST['testimonial_author'])) {
            update_post_meta($post_id, '_testimonial_author', sanitize_text_field($_POST['testimonial_author']));
        }
        if (isset($_POST['testimonial_position'])) {
            update_post_meta($post_id, '_testimonial_position', sanitize_text_field($_POST['testimonial_position']));
        }
        if (isset($_POST['testimonial_company'])) {
            update_post_meta($post_id, '_testimonial_company', sanitize_text_field($_POST['testimonial_company']));
        }
        if (isset($_POST['testimonial_rating'])) {
            update_post_meta($post_id, '_testimonial_rating', absint($_POST['testimonial_rating']));
        }
    }
}
add_action('save_post', 'central_build_save_meta_boxes');

/**
 * Custom shortcodes
 */
function central_build_button_shortcode($atts, $content = null) {
    $atts = shortcode_atts(array(
        'url'    => '#',
        'style'  => 'primary',
        'size'   => 'medium',
        'target' => '_self',
    ), $atts, 'button');

    $classes = array('btn', 'btn-' . $atts['style'], 'btn-' . $atts['size']);
    
    return sprintf(
        '<a href="%s" class="%s" target="%s">%s</a>',
        esc_url($atts['url']),
        esc_attr(implode(' ', $classes)),
        esc_attr($atts['target']),
        do_shortcode($content)
    );
}
add_shortcode('button', 'central_build_button_shortcode');

/**
 * Gallery shortcode
 */
function central_build_gallery_shortcode($atts) {
    $atts = shortcode_atts(array(
        'ids'     => '',
        'columns' => 3,
        'size'    => 'central-build-gallery',
    ), $atts, 'gallery');

    if (empty($atts['ids'])) {
        return '';
    }

    $ids = explode(',', $atts['ids']);
    $output = '<div class="central-build-gallery columns-' . absint($atts['columns']) . '">';
    
    foreach ($ids as $id) {
        $image = wp_get_attachment_image(trim($id), $atts['size'], false, array('class' => 'gallery-image'));
        if ($image) {
            $output .= '<div class="gallery-item">' . $image . '</div>';
        }
    }
    
    $output .= '</div>';
    
    return $output;
}
add_shortcode('gallery', 'central_build_gallery_shortcode');

/**
 * Security enhancements
 */
function central_build_security() {
    // Remove WordPress version from head
    remove_action('wp_head', 'wp_generator');
    
    // Remove RSD link
    remove_action('wp_head', 'rsd_link');
    
    // Remove wlwmanifest link
    remove_action('wp_head', 'wlwmanifest_link');
    
    // Remove shortlink
    remove_action('wp_head', 'wp_shortlink_wp_head');
}
add_action('init', 'central_build_security');

/**
 * Performance optimizations
 */
function central_build_performance() {
    // Remove emoji scripts
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('admin_print_styles', 'print_emoji_styles');
    
    // Remove jQuery migrate
    function central_build_remove_jquery_migrate($scripts) {
        if (!is_admin() && isset($scripts->registered['jquery'])) {
            $script = $scripts->registered['jquery'];
            if ($script->deps) {
                $script->deps = array_diff($script->deps, array('jquery-migrate'));
            }
        }
    }
    add_action('wp_default_scripts', 'central_build_remove_jquery_migrate');
}
add_action('init', 'central_build_performance');

/**
 * Admin customizations
 */
function central_build_admin_init() {
    // Add custom admin styles
    add_action('admin_enqueue_scripts', function() {
        wp_enqueue_style('central-build-admin', get_template_directory_uri() . '/css/admin.css', array(), '1.0.0');
    });
}
add_action('admin_init', 'central_build_admin_init');
