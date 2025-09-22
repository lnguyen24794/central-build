<?php
/**
 * Fitout Sector Sample Data
 * 
 * This file contains sample data for the fitout_sector custom post type.
 * Run this once to populate your site with sample fitout projects.
 *
 * @package Central_Build_Pro
 * @since 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Create sample fitout sector data
 * This function should be called once to populate sample data
 */
function central_build_create_sample_fitout_data()
{
    // First, create the taxonomy terms
    $categories = array(
        'hospitality-fitout' => 'Hospitality Fitout',
        'office-fitout' => 'Office Fitout',
        'retail-fitout' => 'Retail Fitout',
        'medical-fitout' => 'Medical Fitout',
        'beauty-wellness-fitout' => 'Beauty & Wellness Fitout',
        'mezzanine-fitout' => 'Mezzanine Fitout'
    );

    foreach ($categories as $slug => $name) {
        if (!term_exists($name, 'fitout_category')) {
            wp_insert_term($name, 'fitout_category', array(
                'slug' => $slug
            ));
        }
    }

    // Sample fitout projects data
    $sample_projects = array(
        array(
            'title' => 'Cafe Fitout - Kingsley Cakes',
            'content' => 'This café fitout for Kingsley Cakes was delivered by Central Build to create a warm, welcoming space that elevates the customer experience. The project features a curved tiled counter with integrated lighting, custom timber seating, and softly textured walls that balance comfort with durability. From the flow of the service area to the fine detailing of the dining zone, our team managed every stage of the fitout to ensure the café feels both contemporary and timeless.',
            'excerpt' => 'A warm and inviting café fitout designed to balance functionality with a fresh, modern aesthetic.',
            'category' => 'hospitality-fitout',
            'meta' => array(
                '_fitout_client' => 'Kingsley Cakes',
                '_fitout_location' => 'Gold Coast',
                '_fitout_sqm' => '120',
                '_fitout_created_date' => '2025-09-04',
                '_fitout_hero_image' => 'https://cdn.prod.website-files.com/66f1ffecdef9310969f57993/68ba19ba9b593f2cdc33a4ba_2.jpg',
                '_fitout_about_image' => 'https://cdn.prod.website-files.com/66f1ffecdef9310969f57993/68ba1b0c5a10af62de490dcb_5.jpg',
                '_fitout_key_elements' => "Curved front counter finished with soft green tiling and integrated LED strip lighting\nCustom takeaway seating bench paired with a feature wall and decorative lighting\nNatural timber tables and bentwood chairs for a timeless café aesthetic\nWarm textured wall finishes with subtle panelling for added depth\nLayered lighting design combining pendants, wall sconces, and concealed strip lighting",
                '_fitout_cta_text' => 'Planning a hospitality fitout? Let\'s bring your vision to life with precision and creativity',
                '_fitout_final_result' => 'The final result is a café space that feels modern, calming, and refined while remaining practical for everyday service. Kingsley Cakes now welcomes guests into a setting that elevates their experience, whether they\'re stopping in for a quick coffee or enjoying a sit-down meal.',
                '_fitout_quote_text' => 'Cafés are about atmosphere as much as service. The soft curves, tiled counter, and timber finishes had to feel seamless, because even the smallest detail changes how customers experience the space. Getting that balance right was key.',
                '_fitout_quote_author' => 'Josh',
                '_fitout_quote_position' => 'Project Manager',
                '_fitout_gallery_images' => array(
                    'https://cdn.prod.website-files.com/66f1ffecdef9310969f57993/68ba1b0c3006f900a6367a7c_1.jpg',
                    'https://cdn.prod.website-files.com/66f1ffecdef9310969f57993/68ba19ba9b593f2cdc33a4ba_2.jpg',
                    'https://cdn.prod.website-files.com/66f1ffecdef9310969f57993/68ba1b0cb4f04a08c47ad260_3.jpg',
                    'https://cdn.prod.website-files.com/66f1ffecdef9310969f57993/68ba1b0cdc78af2a20cd71a0_4.jpg',
                    'https://cdn.prod.website-files.com/66f1ffecdef9310969f57993/68ba1b0c5a10af62de490dcb_5.jpg',
                    'https://cdn.prod.website-files.com/66f1ffecdef9310969f57993/68ba1b0c9c10da277c254db6_DSC02146-HDR%20(Large).jpg'
                )
            )
        ),
        array(
            'title' => 'The Sushi Berrinba',
            'content' => 'A contemporary Japanese restaurant fitout that combines traditional elements with modern functionality. This project showcases clean lines, natural materials, and efficient kitchen workflow design.',
            'excerpt' => 'Contemporary Japanese restaurant fitout combining traditional aesthetics with modern functionality.',
            'category' => 'hospitality-fitout',
            'meta' => array(
                '_fitout_client' => 'The Sushi Berrinba',
                '_fitout_location' => 'Brisbane',
                '_fitout_sqm' => '180',
                '_fitout_created_date' => '2025-08-15',
                '_fitout_hero_image' => 'https://cdn.prod.website-files.com/66f1ffecdef9310969f57993/687f152ca09f0aed27e7fd8d_ENP00952.jpg',
                '_fitout_about_image' => 'https://cdn.prod.website-files.com/66f1ffecdef9310969f57993/687f152ca09f0aed27e7fd8d_ENP00952.jpg',
                '_fitout_key_elements' => "Traditional Japanese design elements with modern touches\nOpen kitchen concept for customer engagement\nNatural timber and stone finishes\nEfficient workflow design for sushi preparation\nAmbient lighting creating intimate dining atmosphere",
                '_fitout_cta_text' => 'Ready to create your perfect restaurant space? Let\'s discuss your vision.',
                '_fitout_final_result' => 'A sophisticated dining space that honors Japanese tradition while meeting modern operational requirements.',
                '_fitout_quote_text' => 'The balance between tradition and functionality was crucial for this project.',
                '_fitout_quote_author' => 'Sarah',
                '_fitout_quote_position' => 'Design Lead'
            )
        ),
        array(
            'title' => 'Southside Dental Fitout',
            'content' => 'A comprehensive medical fitout designed to create a calming and professional environment for dental patients. The space incorporates modern equipment integration with patient comfort in mind.',
            'excerpt' => 'Professional dental fitout focusing on patient comfort and operational efficiency.',
            'category' => 'medical-fitout',
            'meta' => array(
                '_fitout_client' => 'Southside Dental',
                '_fitout_location' => 'Brisbane Southside',
                '_fitout_sqm' => '250',
                '_fitout_created_date' => '2025-07-20',
                '_fitout_hero_image' => 'https://cdn.prod.website-files.com/66f1ffecdef9310969f57993/68c3726bd7b3e5e0f74b31f2_DSC02176-HDR%20(Custom).jpg',
                '_fitout_about_image' => 'https://cdn.prod.website-files.com/66f1ffecdef9310969f57993/68c3726bd7b3e5e0f74b31f2_DSC02176-HDR%20(Custom).jpg',
                '_fitout_key_elements' => "Calming color palette to reduce patient anxiety\nState-of-the-art equipment integration\nEfficient sterilization and storage areas\nComfortable waiting areas with natural lighting\nPrivacy considerations for patient consultations",
                '_fitout_cta_text' => 'Planning a medical fitout? We understand the unique requirements of healthcare spaces.',
                '_fitout_final_result' => 'A modern dental practice that prioritizes both patient comfort and operational efficiency.',
                '_fitout_quote_text' => 'Creating a space where patients feel comfortable is just as important as the technical aspects.',
                '_fitout_quote_author' => 'Michael',
                '_fitout_quote_position' => 'Healthcare Specialist'
            )
        ),
        array(
            'title' => 'Mobility Showroom',
            'content' => 'A full showroom for Mobility Rentals & Sales, blending modern accessibility with bold retail presentation. Central Build delivered custom joinery, LED-lit display zones, textured finishes, and a high-end showroom experience across two levels.',
            'excerpt' => 'Comprehensive mobility showroom with accessibility focus and premium retail presentation.',
            'category' => 'retail-fitout',
            'meta' => array(
                '_fitout_client' => 'Mobility Rentals & Sales',
                '_fitout_location' => 'Gold Coast',
                '_fitout_sqm' => '400',
                '_fitout_created_date' => '2025-06-10',
                '_fitout_hero_image' => 'https://cdn.prod.website-files.com/66f1ffecdef9310969f57993/68a50ac14f0dc1ea85971343_DSC01140-HDR%20(Large).jpg',
                '_fitout_about_image' => 'https://cdn.prod.website-files.com/66f1ffecdef9310969f57993/68a50ac14f0dc1ea85971343_DSC01140-HDR%20(Large).jpg',
                '_fitout_key_elements' => "Full accessibility compliance throughout\nCustom display zones with LED lighting\nTwo-level showroom design\nInteractive product demonstration areas\nAccessible customer consultation spaces",
                '_fitout_cta_text' => 'Need a retail space that stands out? Let\'s create something exceptional together.',
                '_fitout_final_result' => 'A showroom that perfectly balances accessibility requirements with premium retail presentation.',
                '_fitout_quote_text' => 'This project required us to think differently about retail design and accessibility.',
                '_fitout_quote_author' => 'Emma',
                '_fitout_quote_position' => 'Retail Design Specialist'
            )
        ),
        array(
            'title' => 'Corporate Office Fitout',
            'content' => 'A modern corporate office designed to promote collaboration and productivity. The space features flexible work areas, meeting rooms, and breakout spaces that adapt to changing business needs.',
            'excerpt' => 'Modern corporate office promoting collaboration and productivity with flexible spaces.',
            'category' => 'office-fitout',
            'meta' => array(
                '_fitout_client' => 'Corporate Solutions Ltd',
                '_fitout_location' => 'Brisbane CBD',
                '_fitout_sqm' => '600',
                '_fitout_created_date' => '2025-05-15',
                '_fitout_hero_image' => 'https://cdn.prod.website-files.com/66f1ffebdef9310969f57940/674fb0ac8b2be968fa78a53b_MAIN_OFFICE_3.3.1%20(Large).png',
                '_fitout_about_image' => 'https://cdn.prod.website-files.com/66f1ffebdef9310969f57940/674fb0ac8b2be968fa78a53b_MAIN_OFFICE_3.3.1%20(Large).png',
                '_fitout_key_elements' => "Open plan workspace with flexible configurations\nModern meeting rooms with AV integration\nCollaborative breakout areas\nErgonomic workstations and furniture\nSustainable materials and energy-efficient lighting",
                '_fitout_cta_text' => 'Ready to transform your workplace? Let\'s create an office that works for your team.',
                '_fitout_final_result' => 'A dynamic workspace that supports both focused work and team collaboration.',
                '_fitout_quote_text' => 'The key was creating spaces that could adapt to different work styles and team sizes.',
                '_fitout_quote_author' => 'David',
                '_fitout_quote_position' => 'Workplace Design Consultant'
            )
        ),
        array(
            'title' => 'Gloss Beauty Salon',
            'content' => 'A luxurious beauty salon fitout that creates an elegant and relaxing environment for clients. The design incorporates premium finishes and efficient workflow for beauty treatments.',
            'excerpt' => 'Luxurious beauty salon with elegant design and efficient treatment workflows.',
            'category' => 'beauty-wellness-fitout',
            'meta' => array(
                '_fitout_client' => 'Gloss Beauty',
                '_fitout_location' => 'Surfers Paradise',
                '_fitout_sqm' => '200',
                '_fitout_created_date' => '2025-04-20',
                '_fitout_hero_image' => 'https://cdn.prod.website-files.com/66f1ffebdef9310969f57940/6758b52edb5c369d0ad329f7_Gloss%20Final-68%20(Large).jpg',
                '_fitout_about_image' => 'https://cdn.prod.website-files.com/66f1ffebdef9310969f57940/6758b52edb5c369d0ad329f7_Gloss%20Final-68%20(Large).jpg',
                '_fitout_key_elements' => "Luxurious reception and waiting area\nPrivate treatment rooms with premium finishes\nProfessional lighting for beauty treatments\nEfficient storage and product display\nRelaxing ambiance with carefully selected materials",
                '_fitout_cta_text' => 'Creating your dream beauty space? We specialize in wellness and beauty fitouts.',
                '_fitout_final_result' => 'An elegant salon that provides the perfect environment for beauty treatments and client relaxation.',
                '_fitout_quote_text' => 'Every detail matters in a beauty salon - from lighting to finishes, it all contributes to the client experience.',
                '_fitout_quote_author' => 'Lisa',
                '_fitout_quote_position' => 'Beauty Space Designer'
            )
        )
    );

    // Create the posts
    foreach ($sample_projects as $project) {
        // Check if post already exists
        $existing_post = get_page_by_title($project['title'], OBJECT, 'fitout_sector');
        if ($existing_post) {
            continue; // Skip if already exists
        }

        // Create the post
        $post_data = array(
            'post_title' => $project['title'],
            'post_content' => $project['content'],
            'post_excerpt' => $project['excerpt'],
            'post_status' => 'publish',
            'post_type' => 'fitout_sector',
            'post_author' => 1
        );

        $post_id = wp_insert_post($post_data);

        if ($post_id && !is_wp_error($post_id)) {
            // Set the category
            $term = get_term_by('slug', $project['category'], 'fitout_category');
            if ($term) {
                wp_set_post_terms($post_id, array($term->term_id), 'fitout_category');
            }

            // Add meta fields
            foreach ($project['meta'] as $meta_key => $meta_value) {
                update_post_meta($post_id, $meta_key, $meta_value);
            }

            // Set featured image if available
            if (isset($project['meta']['_fitout_hero_image'])) {
                // You could implement featured image setting from URL here if needed
            }
        }
    }

    return 'Sample fitout sector data created successfully!';
}

/**
 * Admin function to create sample data
 * Add this to your admin menu or call it via wp-admin
 */
function central_build_add_sample_data_admin_menu()
{
    add_management_page(
        'Create Sample Fitout Data',
        'Sample Fitout Data',
        'manage_options',
        'create-sample-fitout-data',
        'central_build_sample_data_admin_page'
    );
}
add_action('admin_menu', 'central_build_add_sample_data_admin_menu');

/**
 * Admin page callback
 */
function central_build_sample_data_admin_page()
{
    if (isset($_POST['create_sample_data']) && wp_verify_nonce($_POST['sample_data_nonce'], 'create_sample_data')) {
        $result = central_build_create_sample_fitout_data();
        echo '<div class="notice notice-success"><p>' . esc_html($result) . '</p></div>';
    }

    ?>
    <div class="wrap">
        <h1>Create Sample Fitout Data</h1>
        <p>This will create sample fitout sector posts and categories for testing purposes.</p>
        <form method="post">
            <?php wp_nonce_field('create_sample_data', 'sample_data_nonce'); ?>
            <p>
                <input type="submit" name="create_sample_data" class="button button-primary" value="Create Sample Data" />
            </p>
        </form>
    </div>
    <?php
}

/**
 * Update existing categories with custom fields
 */
function central_build_update_existing_categories_with_custom_fields() {
    $categories_data = array(
        'hospitality-fitout' => array(
            'hero_image' => 'https://cdn.prod.website-files.com/66f1ffebdef9310969f57940/674e4000a7cc35ad9ae56860_DSC01892%20(Large).webp',
            'icon' => 'https://cdn.prod.website-files.com/66f1ffebdef9310969f57940/674e4af6a81ec22fb406f986_2.svg',
            'description' => 'Reimagine your hospitality space with custom fitouts tailored for ambiance and function. Central Build creates inviting environments that enhance the guest experience and showcase your brand\'s unique personality.'
        ),
        'office-fitout' => array(
            'hero_image' => 'https://cdn.prod.website-files.com/66f1ffebdef9310969f57940/674fb0ac8b2be968fa78a53b_MAIN_OFFICE_3.3.1%20(Large).png',
            'icon' => 'https://cdn.prod.website-files.com/66f1ffebdef9310969f57940/674e4af6a81ec22fb406f984_1.svg',
            'description' => 'Transform your workspace into a productive and inspiring environment with our professional office fitouts. We create modern, functional spaces that boost productivity and reflect your company culture.'
        ),
        'retail-fitout' => array(
            'hero_image' => 'https://cdn.prod.website-files.com/66f1ffebdef9310969f57940/674fb59ca04815b79062e722_1%20(Large).jpg',
            'icon' => 'https://cdn.prod.website-files.com/66f1ffebdef9310969f57940/674e4af6a81ec22fb406f985_4.svg',
            'description' => 'Elevate your retail space with custom fitouts designed to attract customers and drive sales. Our retail solutions combine aesthetic appeal with practical functionality.'
        ),
        'medical-fitout' => array(
            'hero_image' => 'https://cdn.prod.website-files.com/66f1ffebdef9310969f57940/674fb9db3d96c35876d4b314_0Y7A4128%20(Large).jpg',
            'icon' => 'https://cdn.prod.website-files.com/66f1ffebdef9310969f57940/66f1ffecdef9310969f57d82_Rotate%20Icon.svg',
            'description' => 'Specialized medical fitouts that prioritize patient comfort, operational efficiency, and compliance with healthcare regulations. Creating healing environments that inspire confidence.'
        ),
        'beauty-wellness-fitout' => array(
            'hero_image' => 'https://cdn.prod.website-files.com/66f1ffebdef9310969f57940/6758b52edb5c369d0ad329f7_Gloss%20Final-68%20(Large).jpg',
            'icon' => 'https://cdn.prod.website-files.com/66f1ffebdef9310969f57940/674e4af6a81ec22fb406f985_4.svg',
            'description' => 'Luxurious beauty and wellness fitouts that create serene, professional environments. Designed to enhance client relaxation and showcase your premium services.'
        ),
        'mezzanine-fitout' => array(
            'hero_image' => 'https://cdn.prod.website-files.com/66f1ffebdef9310969f57940/674e4af6a81ec22fb406f992_DSC01452-2%20(Small).webp',
            'icon' => 'https://cdn.prod.website-files.com/66f1ffebdef9310969f57940/674e4af6a81ec22fb406f983_3.svg',
            'description' => 'Maximize your space efficiently with innovative mezzanine fitouts. Smart solutions that add functional area while maintaining design integrity.'
        )
    );

    foreach ($categories_data as $slug => $data) {
        $term = get_term_by('slug', $slug, 'fitout_category');
        if ($term) {
            update_term_meta($term->term_id, 'category_hero_image', $data['hero_image']);
            update_term_meta($term->term_id, 'category_icon', $data['icon']);
            update_term_meta($term->term_id, 'category_description_custom', $data['description']);
        }
    }

    return 'Existing categories updated with custom fields!';
}

/**
 * Admin function to update existing categories
 */
function central_build_add_update_categories_admin_menu()
{
    add_management_page(
        'Update Category Fields',
        'Update Category Fields',
        'manage_options',
        'update-category-fields',
        'central_build_update_categories_admin_page'
    );
}
add_action('admin_menu', 'central_build_add_update_categories_admin_menu');

/**
 * Admin page callback for updating categories
 */
function central_build_update_categories_admin_page()
{
    if (isset($_POST['update_categories']) && wp_verify_nonce($_POST['update_categories_nonce'], 'update_categories')) {
        $result = central_build_update_existing_categories_with_custom_fields();
        echo '<div class="notice notice-success"><p>' . esc_html($result) . '</p></div>';
    }

    ?>
    <div class="wrap">
        <h1>Update Category Fields</h1>
        <p>This will update existing fitout categories with default hero images, icons, and descriptions.</p>
        <form method="post">
            <?php wp_nonce_field('update_categories', 'update_categories_nonce'); ?>
            <p>
                <input type="submit" name="update_categories" class="button button-primary" value="Update Existing Categories" />
            </p>
        </form>
    </div>
    <?php
}

/**
 * Activation hook to create sample data
 * Uncomment the line below if you want to create sample data on theme activation
 */
// add_action('after_switch_theme', 'central_build_create_sample_fitout_data');
