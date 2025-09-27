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
    define('CENTRAL_BUILD_VERSION', '1.0.0');
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

    wp_enqueue_script('central-build-bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array('central-build-main'), false, true);

    wp_enqueue_script('central-build-custom', get_template_directory_uri() . '/js/main.js', array('central-build-main', 'jquery-ui'), false, true);

    // Enqueue Swiper bundle JavaScript
    wp_enqueue_script('swiper-bundle', get_template_directory_uri() . '/js/swiper-bundle.min.js', array('central-build-main'), false, true);

    // Enqueue Bootstrap JavaScript
    wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js', array('central-build-main'), '5.3.2', true);
    // Enqueue Webflow CSS (main template styles)
    wp_enqueue_style('central-build-webflow', get_template_directory_uri() . '/css/main.min.css', array(), false);

    // Enqueue main stylesheet (our custom styles)
    wp_enqueue_style('central-build-style', get_stylesheet_uri(), array('central-build-webflow'), false);

    // Enqueue components CSS
    wp_enqueue_style('central-build-components', get_template_directory_uri() . '/css/components.css', array('central-build-style'), false);

    // Enqueue animation CSS
    wp_enqueue_style('animation', get_template_directory_uri() . '/css/animate.min.css', array('central-build-style'), false);

    // Enqueue Bootstrap CSS (before webflow-overrides so it can be overridden)
    wp_enqueue_style('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css', array('central-build-components', 'animation'), '5.3.2');
    wp_enqueue_style('bootstrap-icons', 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css', array('bootstrap'), '1.11.3');
    wp_enqueue_style('jquery-ui', 'https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css', array('bootstrap'), '1.14.1');

    // Enqueue Bootstrap custom utilities (safe Bootstrap utilities)
    wp_enqueue_style('bootstrap-custom', get_template_directory_uri() . '/css/bootstrap-custom.min.css', array('bootstrap'), false);

    // Enqueue Swiper bundle CSS
    wp_enqueue_style('swiper-bundle', get_template_directory_uri() . '/css/swiper-bundle.min.css', array('bootstrap-custom'), false);

    // Enqueue Webflow overrides CSS (this will override Bootstrap when needed)
    wp_enqueue_style('central-build-webflow-overrides', get_template_directory_uri() . '/css/webflow-overrides.css', array('bootstrap-custom', 'swiper-bundle', 'animation'), false);

    // Enqueue Google Fonts (Roboto) and Oswald from template
    wp_enqueue_style('central-build-fonts', 'https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap', array(), null);

    // Enqueue WebFont loader
    wp_enqueue_script('central-build-webfont', get_template_directory_uri() . '/js/webfont.js', array(), false, false);



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
        wp_enqueue_style('central-build-home-min', get_template_directory_uri() . '/css/home.min.css', array('central-build-webflow'), false);
        wp_enqueue_script('central-build-home-js', get_template_directory_uri() . '/js/home.js', array('jquery'), false, true);
    }

    // Contact page assets
    if (is_page_template('page-contact.php')) {
        wp_enqueue_style('central-build-contact', get_template_directory_uri() . '/css/contact.css', array('central-build-style'), false);
        wp_enqueue_script('central-build-contact-js', get_template_directory_uri() . '/js/contact.js', array('jquery'), false, true);
    }

    // Service pages assets
    if (is_page_template('page-commercial-shop-fitting.php') ||
        is_page_template('page-concreet.php') ||
        is_page_template('page-custom-joinery.php')) {
        wp_enqueue_style('central-build-services', get_template_directory_uri() . '/css/services.css', array('central-build-style'), false);
        wp_enqueue_script('central-build-services-js', get_template_directory_uri() . '/js/services.js', array('jquery'), false, true);
    }

    // About pages assets
    if (is_page_template('page-our-values.php') || is_page_template('page-testimonials.php')) {
        wp_enqueue_style('central-build-about', get_template_directory_uri() . '/css/about.css', array('central-build-style'), false);
    }

    // Portfolio/Fitout sectors assets
    if (is_page_template('page-fitout-sectors.php')) {
        wp_enqueue_style('central-build-portfolio', get_template_directory_uri() . '/css/portfolio.css', array('central-build-style'), false);
        wp_enqueue_script('central-build-portfolio-js', get_template_directory_uri() . '/js/portfolio.js', array('jquery'), false, true);
    }

    // Blog/Archive pages assets
    if (is_home() || is_archive() || is_search() || is_category() || is_tag() || is_author() || is_date()) {
        wp_enqueue_style('central-build-home-min', get_template_directory_uri() . '/css/home.min.css', array('central-build-webflow'), false);
        wp_enqueue_style('central-build-blog', get_template_directory_uri() . '/css/blog-styles.css', array('central-build-home-min'), false);
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

/**
 * Add body class for fitout category archives
 */
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
 * Footer Options Page
 */
function central_build_add_footer_options_page()
{
    add_theme_page(
        'Footer Settings',
        'Footer Settings',
        'manage_options',
        'footer-settings',
        'central_build_footer_settings_page'
    );
}
add_action('admin_menu', 'central_build_add_footer_options_page');

/**
 * Contact Options Page
 */
function central_build_add_contact_options_page()
{
    add_theme_page(
        'Contact Settings',
        'Contact Settings',
        'manage_options',
        'contact-settings',
        'central_build_contact_settings_page'
    );
}
add_action('admin_menu', 'central_build_add_contact_options_page');

/**
 * Header Options Page
 */
function central_build_add_header_options_page()
{
    add_theme_page(
        'Header Settings',
        'Header Settings',
        'manage_options',
        'header-settings',
        'central_build_header_settings_page'
    );
}
add_action('admin_menu', 'central_build_add_header_options_page');

/**
 * Footer Settings Page Callback
 */
function central_build_footer_settings_page()
{
    if (isset($_POST['submit']) && wp_verify_nonce($_POST['footer_settings_nonce'], 'footer_settings')) {
        // Save all footer settings
        update_option('central_build_footer_logo', wp_kses_post($_POST['footer_logo']));
        update_option('central_build_footer_description', sanitize_textarea_field($_POST['footer_description']));
        update_option('central_build_footer_email', sanitize_email($_POST['footer_email']));
        update_option('central_build_footer_phone', wp_kses_post($_POST['footer_phone']));

        // Quick Links
        update_option('central_build_footer_home_text', wp_kses_post($_POST['footer_home_text']));
        update_option('central_build_footer_home_url', esc_url_raw($_POST['footer_home_url']));
        update_option('central_build_footer_about_text', wp_kses_post($_POST['footer_about_text']));
        update_option('central_build_footer_about_url', esc_url_raw($_POST['footer_about_url']));
        update_option('central_build_footer_policy_text', wp_kses_post($_POST['footer_policy_text']));
        update_option('central_build_footer_policy_url', esc_url_raw($_POST['footer_policy_url']));
        update_option('central_build_footer_services_text', wp_kses_post($_POST['footer_services_text']));
        update_option('central_build_footer_services_url', esc_url_raw($_POST['footer_services_url']));
        update_option('central_build_footer_portfolio_text', wp_kses_post($_POST['footer_portfolio_text']));
        update_option('central_build_footer_portfolio_url', esc_url_raw($_POST['footer_portfolio_url']));

        // Support Links
        update_option('central_build_footer_csr_text', wp_kses_post($_POST['footer_csr_text']));
        update_option('central_build_footer_csr_url', esc_url_raw($_POST['footer_csr_url']));
        update_option('central_build_footer_values_text', wp_kses_post($_POST['footer_values_text']));
        update_option('central_build_footer_values_url', esc_url_raw($_POST['footer_values_url']));
        update_option('central_build_footer_blog_text', wp_kses_post($_POST['footer_blog_text']));
        update_option('central_build_footer_blog_url', esc_url_raw($_POST['footer_blog_url']));

        echo '<div class="notice notice-success"><p>Footer settings saved successfully!</p></div>';
    }

    // Get current values
    $footer_logo = get_option('central_build_footer_logo', get_template_directory_uri() . '/images/674e51fad943a77607127b0b_ENP%20transparent%20white%20cropped.webp');
    $footer_description = get_option('central_build_footer_description', 'Central Build, established in 2018, crafts lasting fitout solutions with value, efficiency, and transparency. Discover the ENP difference.');
    $footer_email = get_option('central_build_footer_email', 'info@centralbuild.au');
    $footer_phone = get_option('central_build_footer_phone', '0123 456 789');

    // Quick Links
    $footer_home_text = get_option('central_build_footer_home_text', 'Home');
    $footer_home_url = get_option('central_build_footer_home_url', home_url());
    $footer_about_text = get_option('central_build_footer_about_text', 'About Us');
    $footer_about_url = get_option('central_build_footer_about_url', home_url('/our-values'));
    $footer_policy_text = get_option('central_build_footer_policy_text', 'Policy');
    $footer_policy_url = get_option('central_build_footer_policy_url', 'https://cdn.prod.website-files.com/66f1ffebdef9310969f57940/676248fadfdb334304c54e6e_ENP%20Fitouts%20Privacy%20Policy.pdf');
    $footer_services_text = get_option('central_build_footer_services_text', 'Services');
    $footer_services_url = get_option('central_build_footer_services_url', home_url('/commercial-shop-fitting'));
    $footer_portfolio_text = get_option('central_build_footer_portfolio_text', 'Portfolio');
    $footer_portfolio_url = get_option('central_build_footer_portfolio_url', '#');

    // Support Links
    $footer_csr_text = get_option('central_build_footer_csr_text', 'CSR Commitment');
    $footer_csr_url = get_option('central_build_footer_csr_url', home_url('/enp-fitouts-csr-commitments'));
    $footer_values_text = get_option('central_build_footer_values_text', 'Our Values');
    $footer_values_url = get_option('central_build_footer_values_url', home_url('/our-values'));
    $footer_blog_text = get_option('central_build_footer_blog_text', 'Our Blog');
    $footer_blog_url = get_option('central_build_footer_blog_url', '#');

    ?>
    <div class="wrap">
        <h1>Footer Settings</h1>
        <form method="post" action="">
            <?php wp_nonce_field('footer_settings', 'footer_settings_nonce'); ?>
            
            <table class="form-table">
                <tr>
                    <th colspan="2"><h2>Company Information</h2></th>
                </tr>
                <tr>
                    <th scope="row">Footer Logo URL</th>
                    <td>
                        <input type="url" name="footer_logo" value="<?php echo esc_url($footer_logo); ?>" class="regular-text" />
                        <p class="description">Enter the URL for the footer logo image</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Company Description</th>
                    <td>
                        <textarea name="footer_description" rows="3" cols="50" class="large-text"><?php echo esc_textarea($footer_description); ?></textarea>
                        <p class="description">Brief description about the company</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Email Address</th>
                    <td>
                        <input type="email" name="footer_email" value="<?php echo esc_attr($footer_email); ?>" class="regular-text" />
                        <p class="description">Contact email address</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Phone Number</th>
                    <td>
                        <input type="text" name="footer_phone" value="<?php echo esc_attr($footer_phone); ?>" class="regular-text" />
                        <p class="description">Contact phone number</p>
                    </td>
                </tr>
                
                <tr>
                    <th colspan="2"><h2>Quick Links</h2></th>
                </tr>
                <tr>
                    <th scope="row">Home Link</th>
                    <td>
                        <input type="text" name="footer_home_text" value="<?php echo esc_attr($footer_home_text); ?>" placeholder="Link Text" class="regular-text" />
                        <input type="url" name="footer_home_url" value="<?php echo esc_url($footer_home_url); ?>" placeholder="Link URL" class="regular-text" />
                    </td>
                </tr>
                <tr>
                    <th scope="row">About Link</th>
                    <td>
                        <input type="text" name="footer_about_text" value="<?php echo esc_attr($footer_about_text); ?>" placeholder="Link Text" class="regular-text" />
                        <input type="url" name="footer_about_url" value="<?php echo esc_url($footer_about_url); ?>" placeholder="Link URL" class="regular-text" />
                    </td>
                </tr>
                <tr>
                    <th scope="row">Policy Link</th>
                    <td>
                        <input type="text" name="footer_policy_text" value="<?php echo esc_attr($footer_policy_text); ?>" placeholder="Link Text" class="regular-text" />
                        <input type="url" name="footer_policy_url" value="<?php echo esc_url($footer_policy_url); ?>" placeholder="Link URL" class="regular-text" />
                    </td>
                </tr>
                <tr>
                    <th scope="row">Services Link</th>
                    <td>
                        <input type="text" name="footer_services_text" value="<?php echo esc_attr($footer_services_text); ?>" placeholder="Link Text" class="regular-text" />
                        <input type="url" name="footer_services_url" value="<?php echo esc_url($footer_services_url); ?>" placeholder="Link URL" class="regular-text" />
                    </td>
                </tr>
                <tr>
                    <th scope="row">Portfolio Link</th>
                    <td>
                        <input type="text" name="footer_portfolio_text" value="<?php echo esc_attr($footer_portfolio_text); ?>" placeholder="Link Text" class="regular-text" />
                        <input type="url" name="footer_portfolio_url" value="<?php echo esc_url($footer_portfolio_url); ?>" placeholder="Link URL" class="regular-text" />
                    </td>
                </tr>
                
                <tr>
                    <th colspan="2"><h2>Support Links</h2></th>
                </tr>
                <tr>
                    <th scope="row">CSR Commitment Link</th>
                    <td>
                        <input type="text" name="footer_csr_text" value="<?php echo esc_attr($footer_csr_text); ?>" placeholder="Link Text" class="regular-text" />
                        <input type="url" name="footer_csr_url" value="<?php echo esc_url($footer_csr_url); ?>" placeholder="Link URL" class="regular-text" />
                    </td>
                </tr>
                <tr>
                    <th scope="row">Our Values Link</th>
                    <td>
                        <input type="text" name="footer_values_text" value="<?php echo esc_attr($footer_values_text); ?>" placeholder="Link Text" class="regular-text" />
                        <input type="url" name="footer_values_url" value="<?php echo esc_url($footer_values_url); ?>" placeholder="Link URL" class="regular-text" />
                    </td>
                </tr>
                <tr>
                    <th scope="row">Blog Link</th>
                    <td>
                        <input type="text" name="footer_blog_text" value="<?php echo esc_attr($footer_blog_text); ?>" placeholder="Link Text" class="regular-text" />
                        <input type="url" name="footer_blog_url" value="<?php echo esc_url($footer_blog_url); ?>" placeholder="Link URL" class="regular-text" />
                    </td>
                </tr>
            </table>
            
            <?php submit_button('Save Footer Settings'); ?>
        </form>
    </div>
    
    <style>
    .form-table th h2 {
        margin: 0;
        padding: 10px 0;
        border-bottom: 1px solid #ddd;
        color: #23282d;
    }
    .form-table input[type="text"], 
    .form-table input[type="url"], 
    .form-table input[type="email"] {
        margin-right: 10px;
        margin-bottom: 5px;
    }
    </style>
    <?php
}

/**
 * Contact Settings Page Callback
 */
function central_build_contact_settings_page()
{
    if (isset($_POST['submit']) && wp_verify_nonce($_POST['contact_settings_nonce'], 'contact_settings')) {
        // Save hero section settings
        update_option('central_build_contact_hero_title', wp_kses_post(wp_unslash($_POST['contact_hero_title'])));
        update_option('central_build_contact_hero_description', sanitize_textarea_field($_POST['contact_hero_description']));

        // Save contact information
        update_option('central_build_contact_email', sanitize_email($_POST['contact_email']));
        update_option('central_build_contact_phone', wp_kses_post($_POST['contact_phone']));
        update_option('central_build_contact_phone_display', wp_kses_post($_POST['contact_phone_display']));

        // Save social media links
        update_option('central_build_contact_facebook', esc_url_raw($_POST['contact_facebook']));
        update_option('central_build_contact_instagram', esc_url_raw($_POST['contact_instagram']));
        update_option('central_build_contact_linkedin', esc_url_raw($_POST['contact_linkedin']));

        // Save form settings
        update_option('central_build_contact_form_title', wp_kses_post($_POST['contact_form_title']));
        update_option('central_build_contact_form_description', sanitize_textarea_field($_POST['contact_form_description']));
        update_option('central_build_contact_form_redirect', esc_url_raw($_POST['contact_form_redirect']));

        // Save office information
        update_option('central_build_contact_office_image', esc_url_raw($_POST['contact_office_image']));
        update_option('central_build_contact_office_title', wp_kses_post($_POST['contact_office_title']));
        update_option('central_build_contact_office_description', sanitize_textarea_field($_POST['contact_office_description']));
        update_option('central_build_contact_office_location', wp_kses_post($_POST['contact_office_location']));
        update_option('central_build_contact_office_country', wp_kses_post($_POST['contact_office_country']));

        echo '<div class="notice notice-success"><p>Contact settings saved successfully!</p></div>';
    }

    // Get current values with defaults
    $contact_hero_title = get_option('central_build_contact_hero_title', 'let\'s work <span>together</span>');
    $contact_hero_description = get_option('central_build_contact_hero_description', 'Reach out to Central Build to start your journey. Whether you\'re looking for a bespoke design, a seamless build, or expert advice, we\'re here to help make your vision a reality. Let\'s create something exceptional together.');

    $contact_email = get_option('central_build_contact_email', 'info@centralbuild.au');
    $contact_phone = get_option('central_build_contact_phone', 'tel:0123456789');
    $contact_phone_display = get_option('central_build_contact_phone_display', '0123 456 789');

    $contact_facebook = get_option('central_build_contact_facebook', 'https://www.facebook.com/p/ENP-Fitouts-100079118888496/');
    $contact_instagram = get_option('central_build_contact_instagram', 'https://www.instagram.com/enpfitouts');
    $contact_linkedin = get_option('central_build_contact_linkedin', 'https://in.linkedin.com/');

    $contact_form_title = get_option('central_build_contact_form_title', 'We\'re here to help');
    $contact_form_description = get_option('central_build_contact_form_description', 'Tell us about your project & goals!');
    $contact_form_redirect = get_option('central_build_contact_form_redirect', '/thank-you');

    $contact_office_image = get_option('central_build_contact_office_image', 'https://static1.squarespace.com/static/6176ce05013c5128c1ff5aa8/6194da83ea54f441cdb5a7de/64d3736437d050544f081ff3/1707218367383/Construction-recruitment+-+dayin+the+life.jpg?format=1500w');
    $contact_office_title = get_option('central_build_contact_office_title', 'Visit Our Offices');
    $contact_office_description = get_option('central_build_contact_office_description', 'Central Build is your trusted partner for exceptional commercial fitouts. Visit us to discuss your project and explore our tailored solutions.');
    $contact_office_location = get_option('central_build_contact_office_location', 'Office in Brisbane');
    $contact_office_country = get_option('central_build_contact_office_country', 'Australia');

    ?>
    <div class="wrap">
        <h1>Contact Page Settings</h1>
        <form method="post" action="">
            <?php wp_nonce_field('contact_settings', 'contact_settings_nonce'); ?>
            
            <table class="form-table">
                <tr>
                    <th colspan="2"><h2>Hero Section</h2></th>
                </tr>
                <tr>
                    <th scope="row">Hero Title</th>
                    <td>
                        <input type="text" name="contact_hero_title" value="<?php echo esc_attr(wp_unslash($contact_hero_title)); ?>" class="large-text" />
                        <p class="description">Main heading in hero section (HTML allowed for span tags)</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Hero Description</th>
                    <td>
                        <textarea name="contact_hero_description" rows="4" cols="50" class="large-text"><?php echo esc_textarea($contact_hero_description); ?></textarea>
                        <p class="description">Description text below the hero title</p>
                    </td>
                </tr>
                
                <tr>
                    <th colspan="2"><h2>Contact Information</h2></th>
                </tr>
                <tr>
                    <th scope="row">Email Address</th>
                    <td>
                        <input type="email" name="contact_email" value="<?php echo esc_attr($contact_email); ?>" class="regular-text" />
                        <p class="description">Contact email address</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Phone Number (tel: link)</th>
                    <td>
                        <input type="text" name="contact_phone" value="<?php echo esc_attr($contact_phone); ?>" class="regular-text" placeholder="tel:0123456789" />
                        <p class="description">Phone number for tel: link (format: tel:0123456789)</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Phone Number (display)</th>
                    <td>
                        <input type="text" name="contact_phone_display" value="<?php echo esc_attr($contact_phone_display); ?>" class="regular-text" />
                        <p class="description">Phone number as displayed to users</p>
                    </td>
                </tr>
                
                <tr>
                    <th colspan="2"><h2>Social Media Links</h2></th>
                </tr>
                <tr>
                    <th scope="row">Facebook URL</th>
                    <td>
                        <input type="url" name="contact_facebook" value="<?php echo esc_url($contact_facebook); ?>" class="large-text" />
                        <p class="description">Facebook page URL</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Instagram URL</th>
                    <td>
                        <input type="url" name="contact_instagram" value="<?php echo esc_url($contact_instagram); ?>" class="large-text" />
                        <p class="description">Instagram profile URL</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">LinkedIn URL</th>
                    <td>
                        <input type="url" name="contact_linkedin" value="<?php echo esc_url($contact_linkedin); ?>" class="large-text" />
                        <p class="description">LinkedIn profile URL</p>
                    </td>
                </tr>
                
                <tr>
                    <th colspan="2"><h2>Contact Form</h2></th>
                </tr>
                <tr>
                    <th scope="row">Form Title</th>
                    <td>
                        <input type="text" name="contact_form_title" value="<?php echo esc_attr($contact_form_title); ?>" class="regular-text" />
                        <p class="description">Title above the contact form</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Form Description</th>
                    <td>
                        <textarea name="contact_form_description" rows="2" cols="50" class="large-text"><?php echo esc_textarea($contact_form_description); ?></textarea>
                        <p class="description">Description below the form title</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Form Redirect URL</th>
                    <td>
                        <input type="text" name="contact_form_redirect" value="<?php echo esc_attr($contact_form_redirect); ?>" class="regular-text" />
                        <p class="description">Page to redirect after form submission (e.g., /thank-you)</p>
                    </td>
                </tr>
                
                <tr>
                    <th colspan="2"><h2>Office Information</h2></th>
                </tr>
                <tr>
                    <th scope="row">Office Image URL</th>
                    <td>
                        <input type="url" name="contact_office_image" value="<?php echo esc_url($contact_office_image); ?>" class="large-text" />
                        <p class="description">Image for the office section</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Office Section Title</th>
                    <td>
                        <input type="text" name="contact_office_title" value="<?php echo esc_attr($contact_office_title); ?>" class="regular-text" />
                        <p class="description">Title for the office section</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Office Description</th>
                    <td>
                        <textarea name="contact_office_description" rows="3" cols="50" class="large-text"><?php echo esc_textarea($contact_office_description); ?></textarea>
                        <p class="description">Description for the office section</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Office Location</th>
                    <td>
                        <input type="text" name="contact_office_location" value="<?php echo esc_attr($contact_office_location); ?>" class="regular-text" />
                        <p class="description">Office location (e.g., "Office in Brisbane")</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Country</th>
                    <td>
                        <input type="text" name="contact_office_country" value="<?php echo esc_attr($contact_office_country); ?>" class="regular-text" />
                        <p class="description">Country name</p>
                    </td>
                </tr>
            </table>
            
            <?php submit_button('Save Contact Settings'); ?>
        </form>
    </div>
    
    <style>
    .form-table th h2 {
        margin: 0;
        padding: 10px 0;
        border-bottom: 1px solid #ddd;
        color: #23282d;
    }
    .form-table input[type="text"], 
    .form-table input[type="url"], 
    .form-table input[type="email"],
    .form-table textarea {
        margin-bottom: 5px;
    }
    </style>
    <?php
}

/**
 * Header Settings Page Callback
 */
function central_build_header_settings_page()
{
    if (isset($_POST['submit']) && wp_verify_nonce($_POST['header_settings_nonce'], 'header_settings')) {
        // Save top bar settings
        update_option('central_build_header_phone', wp_kses_post($_POST['header_phone']));
        update_option('central_build_header_phone_display', wp_kses_post($_POST['header_phone_display']));
        update_option('central_build_header_email', sanitize_email($_POST['header_email']));

        // Save social media links
        update_option('central_build_header_facebook', esc_url_raw($_POST['header_facebook']));
        update_option('central_build_header_linkedin', esc_url_raw($_POST['header_linkedin']));
        update_option('central_build_header_instagram', esc_url_raw($_POST['header_instagram']));

        // Save navigation settings
        update_option('central_build_header_cta_text', wp_kses_post($_POST['header_cta_text']));
        update_option('central_build_header_cta_url', esc_url_raw($_POST['header_cta_url']));

        // Save logo settings
        update_option('central_build_header_logo_width', absint($_POST['header_logo_width']));
        update_option('central_build_header_logo_height', absint($_POST['header_logo_height']));

        echo '<div class="notice notice-success"><p>Header settings saved successfully!</p></div>';
    }

    // Get current values with defaults
    $header_phone = get_option('central_build_header_phone', 'tel:+61431465090');
    $header_phone_display = get_option('central_build_header_phone_display', '+61 431 465 090');
    $header_email = get_option('central_build_header_email', 'info@centralbuild.au');

    $header_facebook = get_option('central_build_header_facebook', 'https://www.facebook.com/p/ENP-Fitouts-100079118888496/');
    $header_linkedin = get_option('central_build_header_linkedin', 'https://www.linkedin.com/company/enp-fitouts/?originalSubdomain=au');
    $header_instagram = get_option('central_build_header_instagram', 'https://www.instagram.com/enpfitouts');

    $header_cta_text = get_option('central_build_header_cta_text', 'Get A quote');
    $header_cta_url = get_option('central_build_header_cta_url', home_url('/contact'));

    $header_logo_width = get_option('central_build_header_logo_width', 121);
    $header_logo_height = get_option('central_build_header_logo_height', 38);

    ?>
    <div class="wrap">
        <h1>Header Settings</h1>
        <form method="post" action="">
            <?php wp_nonce_field('header_settings', 'header_settings_nonce'); ?>
            
            <table class="form-table">
                <tr>
                    <th colspan="2"><h2>Top Bar Contact Information</h2></th>
                </tr>
                <tr>
                    <th scope="row">Phone Number (tel: link)</th>
                    <td>
                        <input type="text" name="header_phone" value="<?php echo esc_attr($header_phone); ?>" class="regular-text" placeholder="tel:+61431465090" />
                        <p class="description">Phone number for tel: link (format: tel:+61431465090)</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Phone Number (display)</th>
                    <td>
                        <input type="text" name="header_phone_display" value="<?php echo esc_attr($header_phone_display); ?>" class="regular-text" />
                        <p class="description">Phone number as displayed to users</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Email Address</th>
                    <td>
                        <input type="email" name="header_email" value="<?php echo esc_attr($header_email); ?>" class="regular-text" />
                        <p class="description">Contact email address</p>
                    </td>
                </tr>
                
                <tr>
                    <th colspan="2"><h2>Social Media Links</h2></th>
                </tr>
                <tr>
                    <th scope="row">Facebook URL</th>
                    <td>
                        <input type="url" name="header_facebook" value="<?php echo esc_url($header_facebook); ?>" class="large-text" />
                        <p class="description">Facebook page URL</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">LinkedIn URL</th>
                    <td>
                        <input type="url" name="header_linkedin" value="<?php echo esc_url($header_linkedin); ?>" class="large-text" />
                        <p class="description">LinkedIn profile URL</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Instagram URL</th>
                    <td>
                        <input type="url" name="header_instagram" value="<?php echo esc_url($header_instagram); ?>" class="large-text" />
                        <p class="description">Instagram profile URL</p>
                    </td>
                </tr>
                
                <tr>
                    <th colspan="2"><h2>Navigation Settings</h2></th>
                </tr>
                <tr>
                    <th scope="row">CTA Button Text</th>
                    <td>
                        <input type="text" name="header_cta_text" value="<?php echo esc_attr($header_cta_text); ?>" class="regular-text" />
                        <p class="description">Text for the call-to-action button</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">CTA Button URL</th>
                    <td>
                        <input type="url" name="header_cta_url" value="<?php echo esc_url($header_cta_url); ?>" class="large-text" />
                        <p class="description">URL for the call-to-action button</p>
                    </td>
                </tr>
                
                <tr>
                    <th colspan="2"><h2>Logo Settings</h2></th>
                </tr>
                <tr>
                    <th scope="row">Logo Width</th>
                    <td>
                        <input type="number" name="header_logo_width" value="<?php echo esc_attr($header_logo_width); ?>" class="small-text" min="50" max="500" />
                        <p class="description">Logo width in pixels</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Logo Height</th>
                    <td>
                        <input type="number" name="header_logo_height" value="<?php echo esc_attr($header_logo_height); ?>" class="small-text" min="20" max="200" />
                        <p class="description">Logo height in pixels</p>
                    </td>
                </tr>
            </table>
            
            <?php submit_button('Save Header Settings'); ?>
        </form>
    </div>
    
    <style>
    .form-table th h2 {
        margin: 0;
        padding: 10px 0;
        border-bottom: 1px solid #ddd;
        color: #23282d;
    }
    .form-table input[type="text"], 
    .form-table input[type="url"], 
    .form-table input[type="email"],
    .form-table input[type="number"] {
        margin-bottom: 5px;
    }
    </style>
    <?php
}

/**
 * Customizer additions (Basic settings only)
 */
function central_build_customize_register($wp_customize)
{
    // Site Identity Section
    $wp_customize->add_setting('central_build_phone', array(
        'default'           => '+61 123 456 789',
        'sanitize_callback' => 'wp_kses_post',
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
        'sanitize_callback' => 'wp_kses_post',
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
function central_build_save_meta_boxes($post_id)
{
    // Portfolio meta
    if (isset($_POST['central_build_portfolio_nonce']) && wp_verify_nonce($_POST['central_build_portfolio_nonce'], 'central_build_portfolio_meta')) {
        if (isset($_POST['portfolio_client'])) {
            update_post_meta($post_id, '_portfolio_client', wp_kses_post($_POST['portfolio_client']));
        }
        if (isset($_POST['portfolio_date'])) {
            update_post_meta($post_id, '_portfolio_date', wp_kses_post($_POST['portfolio_date']));
        }
        if (isset($_POST['portfolio_url'])) {
            update_post_meta($post_id, '_portfolio_url', esc_url_raw($_POST['portfolio_url']));
        }
        if (isset($_POST['portfolio_gallery'])) {
            update_post_meta($post_id, '_portfolio_gallery', wp_kses_post($_POST['portfolio_gallery']));
        }
    }

    // Testimonial meta
    if (isset($_POST['central_build_testimonial_nonce']) && wp_verify_nonce($_POST['central_build_testimonial_nonce'], 'central_build_testimonial_meta')) {
        if (isset($_POST['testimonial_author'])) {
            update_post_meta($post_id, '_testimonial_author', wp_kses_post($_POST['testimonial_author']));
        }
        if (isset($_POST['testimonial_position'])) {
            update_post_meta($post_id, '_testimonial_position', wp_kses_post($_POST['testimonial_position']));
        }
        if (isset($_POST['testimonial_company'])) {
            update_post_meta($post_id, '_testimonial_company', wp_kses_post($_POST['testimonial_company']));
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
        wp_enqueue_style('central-build-admin', get_template_directory_uri() . '/css/admin.css', array(), false);
    });
}
add_action('admin_init', 'central_build_admin_init');
