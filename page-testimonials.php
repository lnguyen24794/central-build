<?php
/**
 * Template Name: Testimonials Page
 * 
 * @package Central_Build_Pro
 * @since 1.0.0
 */

get_header(); ?>

<!-- Hero Video Section -->
<div class="service-two-hero-section-2 w-background-video w-background-video-atom">
    <div class="service-two-hero-overlay"></div>
    <div class="w-layout-blockcontainer container-one-2 about-two-hero-container w-container">
        <div class="w-layout-vflex home-two-hero-block service-two-block">
            <div class="service-tag transparent-bg">testimonials</div>
            <h1 class="color-white text-center service-two-hero-heading">
                <?php 
                if (have_posts()) : 
                    while (have_posts()) : the_post();
                        if (get_the_title()) {
                            the_title();
                        } else {
                            echo 'What our Clients say about us';
                        }
                    endwhile;
                else :
                    echo 'What our Clients say about us';
                endif;
                ?>
            </h1>
            <p class="white-color margin-top-fifteen text-center">We love it when you love it!</p>
        </div>
    </div>
</div>

<!-- Testimonials Grid Section -->
<section class="service-two-section-four">
    <div class="my-container container">
        <div class="w-layout-vflex helping-flex service-two-building-heading">
            <h2 class="margin-top-zero margin-bottom-twenty service-two-assigned-heading">Check out our testimonials</h2>
        </div>
        
        <div class="w-layout-hflex construction-vertical-flex service-two-card-wrap">
            <!-- Club Bunker Testimonial -->
            <div class="w-layout-hflex construction-flex bottom-border-on">
                <div class="service-two-card-main-wrap-2">
                    <div class="w-layout-hflex construction-project-flex">
                        <img width="120" height="55" alt="Club Bunker Logo" src="<?php echo get_template_directory_uri(); ?>/images/674e4d0f8cab55fa62011a84_11.svg" class="autofit-4 middle-align">
                        <div class="service-three-crafting-block service-two-text-box">
                            <div class="heading-six-5 service-two-card-heading-wrap">Club Bunker: Gym Fitout</div>
                            <p class="margin-bottom-zero-3 service-two-card-text">Dale appreciates how Central Build Pro overcame the challenges of an older building, delivering a fitout that captures Club Bunker's community ethos.</p>
                        </div>
                    </div>
                    <div style="height:140px" class="service-two-card-image-wrap">
                        <img width="450" height="240" alt="Club Bunker testimonial" 
                             src="<?php echo get_template_directory_uri(); ?>/images/675912ddc2aa3b2ee4cac7e2_Club%20bunker%20testi%20%28Large%29.webp" 
                             class="contruction-hover-img-2">
                    </div>
                </div>
            </div>
            
            <!-- Centre for Women & Co Testimonial -->
            <div class="w-layout-hflex construction-flex">
                <div class="service-two-card-main-wrap-2">
                    <div class="w-layout-hflex construction-project-flex">
                        <img width="120" height="55" alt="Centre For Women Logo" 
                             src="<?php echo get_template_directory_uri(); ?>/images/674e4d0f8cab55fa62011a99_CFW%20-%20LOGO%20-%20GREY%20-%20MAIN.webp" 
                             class="autofit-4 middle-align">
                        <div class="service-three-crafting-block service-two-text-box">
                            <div class="heading-six-5 service-two-card-heading-wrap">Centre for Women & Co: Office Fitout</div>
                            <p class="margin-bottom-zero-3 service-two-card-text">Ella praises Central Build Pro for creating a modern and functional office space.</p>
                        </div>
                    </div>
                    <div style="height:140px" class="service-two-card-image-wrap">
                        <img width="450" height="240" alt="Centre for Women testimonial" 
                             src="<?php echo get_template_directory_uri(); ?>/images/675912ddc2aa3b2ee4cac7b2_THUMBNAIL.webp" 
                             class="contruction-hover-img-2">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="cta-section">
    <div class="w-layout-blockcontainer container-one cta-container w-container">
        <div class="cta">
            <h3 class="color-white margin-bottom-twenty">Ready to Transform Your Space?</h3>
            <p class="cta-text">Contact us today to discuss your project and see how we can help bring your vision to life.</p>
            <a href="<?php echo esc_url(home_url('/contact')); ?>" role="button" class="cta-hero-button w-inline-block">
                <div class="button-mask">
                    <div class="link-text-wrp">
                        <div>Start Today!</div>
                        <div class="secondt-btn-text">Learn more</div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="cta-overlay"></div>
</section>

<?php get_footer(); ?>