<?php
/**
 * The front page template file
 *
 * This is the template that displays the front page.
 *
 * @package Central_Build_Pro
 * @since 1.0.0
 */

get_header(); ?>

<main id="primary" class="site-main">
    
    <?php
        // Hero/Start Section
        if (get_option('central_build_show_hero_section', true)) :
            loadView(get_template_directory() . '/template-parts/components/start-section.php');
        endif;
    ?>

    <?php
        loadView(get_template_directory() . '/template-parts/components/about-us-section.php');
    ?>

    <?php
        // Trust Process Section
        if (get_option('central_build_show_trust_section', true)) :
            loadView(get_template_directory() . '/template-parts/components/trust-section.php');
        endif;
    ?>

    <?php
    // Featured Projects Section
    if (get_option('central_build_show_projects_section', true)) :
        loadView(get_template_directory() . '/template-parts/components/featured-projects-section.php');
    endif;
    ?>

    
    <?php
    // About/Aware Section
    if (get_option('central_build_show_about_section', true)) :
        loadView(get_template_directory() . '/template-parts/components/aware-section.php');
    endif;
    ?>



    <?php
    // Partners Section
    if (get_option('central_build_show_partners_section', true)) :
        loadView(get_template_directory() . '/template-parts/components/partners-section.php');
    endif;
    ?>

    <?php
    // Testimonials Section
    if (get_option('central_build_show_testimonials_section', true)) :
        loadView(get_template_directory() . '/template-parts/components/testimonials-section.php');
    endif;
    ?>

    <?php
    // Commercial Fitout Sectors Section
    if (get_option('central_build_show_commercial_section', true)) :
        loadView(get_template_directory() . '/template-parts/components/commercial-section.php');
    endif;
    ?>

    <?php
    // CTA/Checkout Section
    loadView(get_template_directory() . '/template-parts/components/fitout-sector-section.php');
    ?>

    <?php
    // Cta Section
    loadView(get_template_directory() . '/template-parts/components/cta-section.php');
    ?>

    <?php
    // FAQ Section
    loadView(get_template_directory() . '/template-parts/components/faq-section.php');
    ?>


    <?php
    // FAQ Transform Section
    if (get_option('central_build_show_faq_transform_section', true)) :
        loadView(get_template_directory() . '/template-parts/components/faq-transform-section.php');
    endif;
    ?>

    </main>
<?php
get_footer();
?>