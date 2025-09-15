<?php
/**
 * Template Name: Concreet Service
 * 
 * @package Central_Build_Pro
 * @since 1.0.0
 */

get_header(); ?>

<section class="service-three-hero-section">
    <div class="w-layout-blockcontainer container-one w-container">
        <div class="service-three-hero-block">
            <div class="w-layout-hflex home-one-hero-heading-flex">
                <div class="tag-wrap padding-none">
                    <div class="tag transparent home-one-hero-tag">Service</div>
                </div>
                <h1 class="text-white margin-none service-three-banner-heading">
                    <?php 
                    if (have_posts()) : 
                        while (have_posts()) : the_post();
                            if (get_the_title()) {
                                the_title();
                            } else {
                                echo 'Concreet Solutions';
                            }
                        endwhile;
                    else :
                        echo 'Concreet Solutions';
                    endif;
                    ?>
                </h1>
            </div>
            <p class="color-white margin-bottom-zero service-three-paragraph">
                <?php 
                if (have_posts()) : 
                    while (have_posts()) : the_post();
                        if (get_the_content()) {
                            echo wp_trim_words(get_the_content(), 30);
                        } else {
                            echo 'Innovative decorative concrete facades and furniture, adding a distinctive industrial touch to modern commercial designs.';
                        }
                    endwhile;
                else :
                    echo 'Innovative decorative concrete facades and furniture, adding a distinctive industrial touch to modern commercial designs.';
                endif;
                ?>
            </p>
        </div>
    </div>
</section>

<section class="service-three-section-three">
    <div class="w-layout-blockcontainer showcase-container w-container">
        <div class="w-layout-vflex helping-flex margin-bottom-thirty-two center">
            <img src="<?php echo get_template_directory_uri(); ?>/images/66f1ffecdef9310969f57b01_Service-Three-Construction.webp" loading="lazy" width="134" height="134" alt="" class="margin-bottom-thirty-two">
            <h2 class="margin-top-zero margin-bottom-twenty service-three-construction-heading">Concreet Design Solutions</h2>
            <p class="grey-text margin-bottom-zero">Explore our innovative concrete design applications</p>
        </div>
        
        <div class="w-layout-hflex service-three-construction-flex">
            <div class="service-three-construction-left">
                <div class="w-layout-vflex service-three-service-box-outer">
                    <div class="service-three-service-image-box">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/674fb0ac8b2be968fa78a53b_MAIN_OFFICE_3.3.1%20%28Large%29.png" 
                             width="410" height="250" alt="Concreet Facade Application" 
                             class="service-three-hover-img">
                    </div>
                    <div class="service-three-service-text-box">
                        <div class="w-layout-hflex site-preparation-flex">
                            <div class="heading-five">Decorative Facades</div>
                        </div>
                        <p class="margin-bottom-fifteen">Transform building exteriors with our innovative concreet facade solutions that combine durability with striking visual appeal.</p>
                    </div>
                </div>
                
                <div class="w-layout-vflex service-three-service-box-outer second-box">
                    <div class="service-three-service-image-box">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/674fb59ca04815b79062e722_1%20%28Large%29.jpg" 
                             height="250" alt="Custom Concrete Furniture" width="410" 
                             class="service-three-hover-img">
                    </div>
                    <div class="service-three-service-text-box">
                        <div class="w-layout-hflex site-preparation-flex">
                            <div class="heading-five">Custom Furniture</div>
                        </div>
                        <p class="margin-bottom-fifteen">Bespoke concrete furniture pieces that add industrial elegance to any commercial space.</p>
                    </div>
                </div>
            </div>
            
            <div class="service-three-construction-right">
                <div class="w-layout-vflex service-three-service-box-outer">
                    <div class="service-three-service-image-box">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/674e4af6a81ec22fb406f98c_DSC04862-HDR%20%28Small%29.webp" 
                             width="410" height="250" alt="Interior Concrete Features" 
                             class="service-three-hover-img">
                    </div>
                    <div class="service-three-service-text-box">
                        <div class="w-layout-hflex site-preparation-flex">
                            <div class="heading-five">Interior Features</div>
                        </div>
                        <p class="margin-bottom-fifteen">Create stunning interior focal points with our decorative concrete wall features and design elements.</p>
                    </div>
                </div>
                
                <div class="w-layout-vflex service-three-service-box-outer second-box">
                    <div class="service-three-service-image-box">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/674e4af6a81ec22fb406f992_DSC01452-2%20%28Small%29.webp" 
                             width="410" height="250" alt="Architectural Elements" 
                             class="service-three-hover-img">
                    </div>
                    <div class="service-three-service-text-box">
                        <div class="w-layout-hflex site-preparation-flex">
                            <div class="heading-five">Architectural Elements</div>
                        </div>
                        <p class="margin-bottom-fifteen">Enhance your space with custom architectural concrete elements that blend form and function seamlessly.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="home-one-faq-section-copy">
    <div class="w-layout-blockcontainer container-one-2 w-container">
        <div class="w-layout-hflex freely-ask-flex-2">
            <div class="freely-ask-right-2">
                <div class="w-layout-hflex heading-box-3">
                    <h2 class="heading-wrap margin-none">Ready to Transform Your Space with Concreet?</h2>
                </div>
                
                <div class="w-layout-hflex freely-text-flex freely-text-flex-margin">
                    <img width="30" height="30" alt="Freely Icon" src="<?php echo get_template_directory_uri(); ?>/images/66f1ffecdef9310969f579e3_Freely-Icon.svg" class="autofit-3">
                    <p class="margin-bottom-zero-3"><strong class="bold-text">Free Consultation:</strong> Discuss your concrete design needs</p>
                </div>
                
                <div class="w-layout-hflex freely-text-flex freely-text-flex-margin">
                    <img width="30" height="30" alt="Freely Icon" src="<?php echo get_template_directory_uri(); ?>/images/66f1ffecdef9310969f579e3_Freely-Icon.svg" class="autofit-3">
                    <p class="margin-bottom-zero-3"><strong>Custom Solutions: </strong>Tailored concrete applications for your project.</p>
                </div>
                
                <a href="<?php echo esc_url(home_url('/contact')); ?>" role="button" class="hero-button-2 w-inline-block">
                    <div class="button-mask">
                        <div class="link-text-wrp">
                            <div>Contact Us Today</div>
                            <div class="secondt-btn-text">Learn more</div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
