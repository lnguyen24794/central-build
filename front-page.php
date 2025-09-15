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
    if (get_theme_mod('central_build_show_hero_section', true)) :
        loadView(get_template_directory() . '/template-parts/home/start-section.php');
    endif;
    ?>

    <?php
    // About/Aware Section
    if (get_theme_mod('central_build_show_about_section', true)) :
        loadView(get_template_directory() . '/template-parts/home/aware-section.php');
    endif;
    ?>

    <?php
    // Trust Process Section
    if (get_theme_mod('central_build_show_trust_section', true)) :
        loadView(get_template_directory() . '/template-parts/home/trust-section.php');
    endif;
    ?>

    <?php
    // Partners Section
    if (get_theme_mod('central_build_show_partners_section', true)) :
        loadView(get_template_directory() . '/template-parts/home/partners-section.php');
    endif;
    ?>

    <?php
    // Testimonials Section
    if (get_theme_mod('central_build_show_testimonials_section', true)) :
        loadView(get_template_directory() . '/template-parts/home/testimonials-section.php');
    endif;
    ?>

    <?php
    // Featured Projects Section
    if (get_theme_mod('central_build_show_projects_section', true)) :
        loadView(get_template_directory() . '/template-parts/home/featured-projects-section.php');
    endif;
    ?>

    <?php
    // Commercial Fitout Sectors Section
    if (get_theme_mod('central_build_show_commercial_section', true)) :
        loadView(get_template_directory() . '/template-parts/home/commercial-section.php');
    endif;
    ?>

    <?php
    // CTA/Checkout Section
    if (get_theme_mod('central_build_show_cta_section', true)) :
        loadView(get_template_directory() . '/template-parts/home/checkout-section.php');
    endif;
    ?>

    <?php
    // FAQ Section
    if (get_theme_mod('central_build_show_faq_section', true)) :
        loadView(get_template_directory() . '/template-parts/home/faq-section.php');
    endif;
    ?>

    <?php
    // FAQ Transform Section
    if (get_theme_mod('central_build_show_faq_transform_section', true)) :
        loadView(get_template_directory() . '/template-parts/home/faq-transform-section.php');
    endif;
    ?>

</main>

<?php
get_footer();
