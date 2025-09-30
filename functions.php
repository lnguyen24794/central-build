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

if (!defined('CENTRAL_BUILD_VERSION')) {
    define('CENTRAL_BUILD_VERSION', '1.0.1');
}

/**
 * Load view template with arguments
 *
 * @param string $template_path Path to template file
 * @param array $args Arguments to pass to template
 */
function loadView($template_path, $args = array())
{
    if (file_exists($template_path)) {
        // Make args available as variables in template
        extract($args);
        include $template_path;
    }
}

/**
 * Theme setup
 */
function central_build_setup()
{
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
 * Custom Walker Class for Navigation Menu with Dropdown Support
 */
class Central_Build_Walker_Nav_Menu extends Walker_Nav_Menu
{
    // Start Level
    public function start_lvl(&$output, $depth = 0, $args = null)
    {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<div class=\"dropdown-content\">\n";
    }

    // End Level
    public function end_lvl(&$output, $depth = 0, $args = null)
    {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</div>\n";
    }

    // Start Element
    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
    {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';

        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        // Check if item has children
        $has_children = in_array('menu-item-has-children', $classes);

        if ($depth == 0) {
            if ($has_children) {
                $output .= $indent . '<li class="dropdown">';
            } else {
                $output .= $indent . '<li>';
            }
        }

        $attributes = ! empty($item->attr_title) ? ' title="'  . esc_attr($item->attr_title) .'"' : '';
        $attributes .= ! empty($item->target) ? ' target="' . esc_attr($item->target) .'"' : '';
        $attributes .= ! empty($item->xfn) ? ' rel="'    . esc_attr($item->xfn) .'"' : '';
        $attributes .= ! empty($item->url) ? ' href="'   . esc_attr($item->url) .'"' : '';

        $item_output = isset($args->before) ? $args->before : '';

        if ($depth == 0 && $has_children) {
            $item_output .= '<a class="dropbtn"' . $attributes . '>';
        } else {
            $item_output .= '<a' . $attributes . '>';
        }

        $item_output .= (isset($args->link_before) ? $args->link_before : '') . apply_filters('the_title', $item->title, $item->ID) . (isset($args->link_after) ? $args->link_after : '');

        if ($depth == 0 && $has_children) {
            $item_output .= ' <i class="arrow-down"></i>';
        }

        $item_output .= '</a>';
        $item_output .= isset($args->after) ? $args->after : '';

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }

    // End Element
    public function end_el(&$output, $item, $depth = 0, $args = null)
    {
        if ($depth == 0) {
            $output .= "</li>\n";
        }
    }
}

/**
 * Enqueue scripts and styles
 */
function central_build_scripts()
{
    // Enqueue main JavaScript (our custom scripts) - Use full jQuery instead of slim
    wp_enqueue_script('central-build-main', 'https://code.jquery.com/jquery-3.7.1.min.js', array(), '3.7.1', true);
    wp_enqueue_script('jquery-ui', 'https://code.jquery.com/ui/1.14.1/jquery-ui.min.js', array('central-build-main'), '1.14.1', true);

    wp_enqueue_script('central-build-custom', get_template_directory_uri() . '/js/main.js', array('central-build-main', 'jquery-ui'), true, true);

    // Enqueue Swiper bundle JavaScript
    wp_enqueue_script('swiper-bundle', get_template_directory_uri() . '/js/swiper-bundle.min.js', array('central-build-main'), true, true);

    // Enqueue Webflow CSS (main template styles)
    wp_enqueue_style('central-build-webflow', get_template_directory_uri() . '/css/main.min.css', array(), true);

    // Enqueue main stylesheet (our custom styles)
    wp_enqueue_style('central-build-style', get_stylesheet_uri(), array('central-build-webflow'), true);

    // Enqueue components CSS
    wp_enqueue_style('central-build-components', get_template_directory_uri() . '/css/components.css', array('central-build-style'), true);

    // Enqueue animation CSS
    wp_enqueue_style('animation', get_template_directory_uri() . '/css/animate.min.css', array('central-build-style'), true);

    // Enqueue Bootstrap CSS (before webflow-overrides so it can be overridden)
    wp_enqueue_style('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css', array('central-build-components', 'animation'), '5.3.2');
    wp_enqueue_style('bootstrap-icons', 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css', array('bootstrap'), '1.11.3');
    wp_enqueue_style('jquery-ui', 'https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css', array('bootstrap'), '1.14.1');

    // Enqueue Bootstrap custom utilities (safe Bootstrap utilities)
    wp_enqueue_style('bootstrap-custom', get_template_directory_uri() . '/css/bootstrap-custom.min.css', array('bootstrap'), true);

    // Enqueue Swiper bundle CSS
    wp_enqueue_style('swiper-bundle', get_template_directory_uri() . '/css/swiper-bundle.min.css', array('bootstrap-custom'), true);

    // Enqueue Webflow overrides CSS (this will override Bootstrap when needed)
    wp_enqueue_style('central-build-webflow-overrides', get_template_directory_uri() . '/css/webflow-overrides.css', array('bootstrap-custom', 'swiper-bundle', 'animation'), true);

    // Enqueue Google Fonts (Roboto) and Oswald from template
    wp_enqueue_style('central-build-fonts', 'https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap', array(), null);

    // Enqueue WebFont loader
    wp_enqueue_script('central-build-webfont', get_template_directory_uri() . '/js/webfont.js', array(), true, true);



    // Enqueue comment reply script
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }

    wp_localize_script('central-build-custom', 'central_build_theme', array(
        'template_url' => get_template_directory_uri(),
        'home_url'     => home_url('/'),
    ));
}
add_action('wp_enqueue_scripts', 'central_build_scripts');

/**
 * Register widget areas
 */
function central_build_widgets_init()
{
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
function central_build_excerpt_length($length)
{
    return 30;
}
add_filter('excerpt_length', 'central_build_excerpt_length');

/**
 * Custom excerpt more
 */
function central_build_excerpt_more($more)
{
    return '...';
}
add_filter('excerpt_more', 'central_build_excerpt_more');

/**
 * Add custom image sizes
 */
function central_build_image_sizes()
{
    add_image_size('central-build-featured', 800, 450, true);
    add_image_size('central-build-thumbnail', 300, 200, true);
    add_image_size('central-build-gallery', 600, 400, true);
}
add_action('after_setup_theme', 'central_build_image_sizes');

/**
 * Enqueue page-specific assets
 */
function central_build_page_assets()
{
    // Home page assets
    if (is_front_page()) {
        wp_enqueue_style('central-build-home-min', get_template_directory_uri() . '/css/home.min.css', array('central-build-webflow'), true);
        wp_enqueue_script('central-build-home-js', get_template_directory_uri() . '/js/home.js', array('jquery'), true, true);
    }

    // Contact page assets
    if (is_page_template('page-contact.php')) {
        wp_enqueue_style('central-build-contact', get_template_directory_uri() . '/css/contact.css', array('central-build-style'), true);
        wp_enqueue_script('central-build-contact-js', get_template_directory_uri() . '/js/contact.js', array('jquery'), true, true);
    }

    // Service pages assets
    if (is_page_template('page-commercial-shop-fitting.php') ||
        is_page_template('page-concreet.php') ||
        is_page_template('page-custom-joinery.php')) {
        wp_enqueue_style('central-build-services', get_template_directory_uri() . '/css/services.css', array('central-build-style'), true);
        wp_enqueue_script('central-build-services-js', get_template_directory_uri() . '/js/services.js', array('jquery'), true, true);
    }

    // About pages assets
    if (is_page_template('page-our-values.php') || is_page_template('page-testimonials.php')) {
        wp_enqueue_style('central-build-about', get_template_directory_uri() . '/css/about.css', array('central-build-style'), true);
    }

    // Portfolio/Fitout sectors assets
    if (is_page_template('page-fitout-sectors.php')) {
        wp_enqueue_style('central-build-portfolio', get_template_directory_uri() . '/css/portfolio.css', array('central-build-style'), true);
        wp_enqueue_script('central-build-portfolio-js', get_template_directory_uri() . '/js/portfolio.js', array('jquery'), true, true);
    }

    // Blog/Archive pages assets
    if (is_home() || is_archive() || is_search() || is_category() || is_tag() || is_author() || is_date()) {
        wp_enqueue_style('central-build-home-min', get_template_directory_uri() . '/css/home.min.css', array('central-build-webflow'), true);
        wp_enqueue_style('central-build-blog', get_template_directory_uri() . '/css/blog-styles.css', array('central-build-home-min'), true);
    }
}
add_action('wp_enqueue_scripts', 'central_build_page_assets');

/**
 * Include admin options
 */
require_once get_template_directory() . '/inc/admin-options.php';

/**
 * Include fitout sector custom post type
 */
require_once get_template_directory() . '/inc/fitout-sector-post-type.php';

/**
 * Include fitout sector sample data (for development/testing)
 */
require_once get_template_directory() . '/inc/fitout-sector-sample-data.php';

/**
 * Get fitout sector projects for commercial section
 */
function central_build_get_fitout_projects($limit = 8)
{
    $fitout_query = new WP_Query(array(
        'post_type' => 'fitout_sector',
        'posts_per_page' => $limit,
        'post_status' => 'publish',
        'orderby' => 'date',
        'order' => 'DESC'
    ));

    $projects = array();

    if ($fitout_query->have_posts()) {
        while ($fitout_query->have_posts()) {
            $fitout_query->the_post();

            $hero_image = get_post_meta(get_the_ID(), '_fitout_hero_image', true);
            $client = get_post_meta(get_the_ID(), '_fitout_client', true);
            $categories = get_the_terms(get_the_ID(), 'fitout_category');
            $category_name = $categories && !is_wp_error($categories) ? $categories[0]->name : '';

            // Fallback image if no hero image is set
            if (!$hero_image && has_post_thumbnail()) {
                $hero_image = get_the_post_thumbnail_url(get_the_ID(), 'large');
            }
            if (!$hero_image) {
                $hero_image = 'https://cdn.prod.website-files.com/66f1ffebdef9310969f57940/66f1ffecdef9310969f579c4_Image-Bg-Section.webp';
            }

            $projects[] = array(
                'title' => get_the_title(),
                'image' => $hero_image,
                'url' => get_permalink(),
                'alt' => get_the_title() . ' - ' . $category_name,
                'client' => $client,
                'category' => $category_name,
                'excerpt' => get_the_excerpt()
            );
        }
        wp_reset_postdata();
    }

    return $projects;
}

/**
 * Flush rewrite rules when theme is activated
 */
function central_build_flush_rewrite_rules()
{
    central_build_register_fitout_sector_post_type();
    central_build_register_fitout_category_taxonomy();
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'central_build_flush_rewrite_rules');

/**
 * Custom template for fitout category taxonomy
 */
function central_build_fitout_category_template($template)
{
    if (is_tax('fitout_category')) {
        $new_template = locate_template(array('archive-fitout_sector.php'));
        if (!empty($new_template)) {
            return $new_template;
        }
    }
    return $template;
}
add_filter('template_include', 'central_build_fitout_category_template');

function central_build_fitout_category_body_class($classes)
{
    if (is_tax('fitout_category')) {
        $classes[] = 'fitout-category-archive';
        $term = get_queried_object();
        if ($term) {
            $classes[] = 'fitout-category-' . $term->slug;
        }
    }
    return $classes;
}
add_filter('body_class', 'central_build_fitout_category_body_class');

/**
 * Customizer additions (Basic settings only)
 */
function central_build_customize_register($wp_customize)
{
    // Site Identity Section
    $wp_customize->add_setting('central_build_phone', array(
        'default'           => '+61 123 456 789',
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

    // Fitout Projects Section
    $wp_customize->add_section('central_build_fitout', array(
        'title'    => esc_html__('Fitout Projects Section', 'central-build'),
        'priority' => 140,
    ));

    $wp_customize->add_setting('central_build_fitout_tag', array(
        'default'           => 'Fitout Projects',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('central_build_fitout_tag', array(
        'label'   => esc_html__('Section Tag', 'central-build'),
        'section' => 'central_build_fitout',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('central_build_fitout_title', array(
        'default'           => 'Our Latest <br>Fitout Projects',
        'sanitize_callback' => 'wp_kses_post',
    ));

    $wp_customize->add_control('central_build_fitout_title', array(
        'label'       => esc_html__('Section Title', 'central-build'),
        'section'     => 'central_build_fitout',
        'type'        => 'textarea',
        'description' => esc_html__('Use <br> for line breaks', 'central-build'),
    ));
}
add_action('customize_register', 'central_build_customize_register');

/**
 * Custom post types
 */
function central_build_custom_post_types()
{
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
function central_build_custom_taxonomies()
{
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
function central_build_add_meta_boxes()
{
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
function central_build_portfolio_meta_box($post)
{
    wp_nonce_field('central_build_portfolio_meta', 'central_build_portfolio_nonce');

    $client = get_post_meta($post->ID, '_portfolio_client', true);
    $project_date = get_post_meta($post->ID, '_portfolio_date', true);
    $project_url = get_post_meta($post->ID, '_portfolio_url', true);
    $gallery = get_post_meta($post->ID, '_portfolio_gallery', true);

    ?>
    <table class="form-table">
        <tr>
            <th><label for="portfolio_client"><?php esc_html_e('Client Name', 'central-build'); ?></label></th>
            <td><input type="text" id="portfolio_client" name="portfolio_client" value="<?php echo esc_attr(wp_unslash($client)); ?>" class="regular-text" /></td>
        </tr>
        <tr>
            <th><label for="portfolio_date"><?php esc_html_e('Project Date', 'central-build'); ?></label></th>
            <td><input type="date" id="portfolio_date" name="portfolio_date" value="<?php echo esc_attr(wp_unslash($project_date)); ?>" class="regular-text" /></td>
        </tr>
        <tr>
            <th><label for="portfolio_url"><?php esc_html_e('Project URL', 'central-build'); ?></label></th>
            <td><input type="text" id="portfolio_url" name="portfolio_url" value="<?php echo esc_url($project_url); ?>" class="regular-text" /></td>
        </tr>
        <tr>
            <th><label for="portfolio_gallery"><?php esc_html_e('Gallery Images (comma-separated IDs)', 'central-build'); ?></label></th>
            <td><input type="text" id="portfolio_gallery" name="portfolio_gallery" value="<?php echo esc_attr(wp_unslash($gallery)); ?>" class="regular-text" /></td>
        </tr>
    </table>
    <?php
}

/**
 * Testimonial meta box callback
 */
function central_build_testimonial_meta_box($post)
{
    wp_nonce_field('central_build_testimonial_meta', 'central_build_testimonial_nonce');

    $author_name = get_post_meta($post->ID, '_testimonial_author', true);
    $author_position = get_post_meta($post->ID, '_testimonial_position', true);
    $author_company = get_post_meta($post->ID, '_testimonial_company', true);
    $rating = get_post_meta($post->ID, '_testimonial_rating', true);

    ?>
    <table class="form-table">
        <tr>
            <th><label for="testimonial_author"><?php esc_html_e('Author Name', 'central-build'); ?></label></th>
            <td><input type="text" id="testimonial_author" name="testimonial_author" value="<?php echo esc_attr(wp_unslash($author_name)); ?>" class="regular-text" /></td>
        </tr>
        <tr>
            <th><label for="testimonial_position"><?php esc_html_e('Position', 'central-build'); ?></label></th>
            <td><input type="text" id="testimonial_position" name="testimonial_position" value="<?php echo esc_attr(wp_unslash($author_position)); ?>" class="regular-text" /></td>
        </tr>
        <tr>
            <th><label for="testimonial_company"><?php esc_html_e('Company', 'central-build'); ?></label></th>
            <td><input type="text" id="testimonial_company" name="testimonial_company" value="<?php echo esc_attr(wp_unslash($author_company)); ?>" class="regular-text" /></td>
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
function central_build_save_meta_boxes($post_id)
{
    // Portfolio meta
    if (isset($_POST['central_build_portfolio_nonce']) && wp_verify_nonce($_POST['central_build_portfolio_nonce'], 'central_build_portfolio_meta')) {
        if (isset($_POST['portfolio_client'])) {
            update_post_meta($post_id, '_portfolio_client', sanitize_text_field(wp_unslash($_POST['portfolio_client'])));
        }
        if (isset($_POST['portfolio_date'])) {
            update_post_meta($post_id, '_portfolio_date', sanitize_text_field(wp_unslash($_POST['portfolio_date'])));
        }
        if (isset($_POST['portfolio_url'])) {
            update_post_meta($post_id, '_portfolio_url', esc_url_raw($_POST['portfolio_url']));
        }
        if (isset($_POST['portfolio_gallery'])) {
            update_post_meta($post_id, '_portfolio_gallery', sanitize_text_field(wp_unslash($_POST['portfolio_gallery'])));
        }
    }

    // Testimonial meta
    if (isset($_POST['central_build_testimonial_nonce']) && wp_verify_nonce($_POST['central_build_testimonial_nonce'], 'central_build_testimonial_meta')) {
        if (isset($_POST['testimonial_author'])) {
            update_post_meta($post_id, '_testimonial_author', sanitize_text_field(wp_unslash($_POST['testimonial_author'])));
        }
        if (isset($_POST['testimonial_position'])) {
            update_post_meta($post_id, '_testimonial_position', sanitize_text_field(wp_unslash($_POST['testimonial_position'])));
        }
        if (isset($_POST['testimonial_company'])) {
            update_post_meta($post_id, '_testimonial_company', sanitize_text_field(wp_unslash($_POST['testimonial_company'])));
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
function central_build_button_shortcode($atts, $content = null)
{
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
function central_build_gallery_shortcode($atts)
{
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
function central_build_security()
{
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
function central_build_performance()
{
    // Remove emoji scripts
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('admin_print_styles', 'print_emoji_styles');

    // Remove jQuery migrate
    function central_build_remove_jquery_migrate($scripts)
    {
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
function central_build_admin_init()
{
    // Add custom admin styles
    add_action('admin_enqueue_scripts', function () {
        wp_enqueue_style('central-build-admin', get_template_directory_uri() . '/css/admin.css', array(), true);
    });
}
add_action('admin_init', 'central_build_admin_init');

require_once get_template_directory() . '/inc/header-settings.php';
require_once get_template_directory() . '/inc/footer-settings.php';
require_once get_template_directory() . '/inc/about-settings.php';
require_once get_template_directory() . '/inc/contact-settings.php';
require_once get_template_directory() . '/inc/commercial-interior-design-settings.php';
require_once get_template_directory() . '/inc/commercial-fitout-specialists-settings.php';
require_once get_template_directory() . '/inc/services-coordination-settings.php';
require_once get_template_directory() . '/inc/commercial-stripout-settings.php';
require_once get_template_directory() . '/inc/repairs-maintenance-settings.php';
require_once get_template_directory() . '/inc/form-notifications-settings.php';
require_once get_template_directory() . '/inc/form-handler.php';
