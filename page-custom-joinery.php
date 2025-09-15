<?php
/**
 * Template Name: Custom Joinery Service
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
                                echo 'Custom Joinery';
                            }
                        endwhile;
                    else :
                        echo 'Custom Joinery';
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
                            echo 'Expert in-house joinery services delivering high-quality, bespoke craftsmanship for commercial fitouts, custom furniture, and architectural woodwork.';
                        }
                    endwhile;
                else :
                    echo 'Expert in-house joinery services delivering high-quality, bespoke craftsmanship for commercial fitouts, custom furniture, and architectural woodwork.';
                endif;
                ?>
            </p>
        </div>
    </div>
</section>

<section class="service-three-logo-section">
    <div class="w-layout-blockcontainer container-one w-container">
        <div class="w-layout-hflex service-three-logo-flex">
            <div class="service-three-logo-left">
                <img src="<?php echo get_template_directory_uri(); ?>/images/67563d1b3fc98bbd5298e096_DSC00857%20%28Large%29.jpg" 
                     width="600" height="783" 
                     alt="Cabinetry team member installing marble benchtop during custom joinery fitout" 
                     class="service-three-hero-img">
            </div>
            <div class="service-three-logo-right">
                <div class="partners-name-wrapper service-three-logo-wrapper">
                    <h3 class="margin-top-zero margin-bottom-twenty">Our Joinery Expertise</h3>
                    <p class="margin-bottom-twenty">Our skilled craftsmen combine traditional techniques with modern precision to deliver exceptional custom joinery solutions.</p>
                    
                    <div class="w-layout-vflex">
                        <div class="heading-six margin-bottom-ten">✓ Custom Cabinetry</div>
                        <div class="heading-six margin-bottom-ten">✓ Built-in Storage Solutions</div>
                        <div class="heading-six margin-bottom-ten">✓ Reception Desks & Counters</div>
                        <div class="heading-six margin-bottom-ten">✓ Architectural Millwork</div>
                        <div class="heading-six margin-bottom-ten">✓ Bespoke Furniture</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="service-three-section-three">
    <div class="w-layout-blockcontainer showcase-container w-container">
        <div class="w-layout-vflex helping-flex margin-bottom-thirty-two center">
            <img src="<?php echo get_template_directory_uri(); ?>/images/66f1ffecdef9310969f57b01_Service-Three-Construction.webp" loading="lazy" width="134" height="134" alt="" class="margin-bottom-thirty-two">
            <h2 class="margin-top-zero margin-bottom-twenty service-three-construction-heading">Custom Joinery Solutions</h2>
            <p class="grey-text margin-bottom-zero">Explore our comprehensive joinery services</p>
        </div>
        
        <div class="w-layout-hflex service-three-construction-flex">
            <div class="service-three-construction-left">
                <!-- Commercial Cabinetry -->
                <div class="w-layout-vflex service-three-service-box-outer">
                    <div class="service-three-service-image-box">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/674e4000a7cc35ad9ae56831_14%20%28Large%29.webp" 
                             width="410" height="250" alt="Commercial Kitchen Cabinetry" 
                             class="service-three-hover-img">
                    </div>
                    <div class="service-three-service-text-box">
                        <div class="w-layout-hflex site-preparation-flex">
                            <div class="heading-five">Commercial Cabinetry</div>
                        </div>
                        <p class="margin-bottom-fifteen">Custom-built cabinets and storage solutions designed for commercial kitchens, offices, and retail spaces.</p>
                    </div>
                </div>
                
                <!-- Reception & Counter Solutions -->
                <div class="w-layout-vflex service-three-service-box-outer second-box">
                    <div class="service-three-service-image-box">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/674fb0ac8b2be968fa78a53b_MAIN_OFFICE_3.3.1%20%28Large%29.png" 
                             height="250" alt="Custom Reception Desk" width="410" 
                             class="service-three-hover-img">
                    </div>
                    <div class="service-three-service-text-box">
                        <div class="w-layout-hflex site-preparation-flex">
                            <div class="heading-five">Reception & Counters</div>
                        </div>
                        <p class="margin-bottom-fifteen">Bespoke reception desks and service counters that make a lasting first impression on your clients.</p>
                    </div>
                </div>
                
                <!-- Built-in Storage -->
                <div class="w-layout-vflex service-three-service-box-outer second-box">
                    <div class="service-three-service-image-box">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/674fb59ca04815b79062e722_1%20%28Large%29.jpg" 
                             height="250" alt="Built-in Storage Solutions" width="410" 
                             class="service-three-hover-img">
                    </div>
                    <div class="service-three-service-text-box">
                        <div class="w-layout-hflex site-preparation-flex">
                            <div class="heading-five">Built-in Storage</div>
                        </div>
                        <p class="margin-bottom-fifteen">Maximize space efficiency with custom built-in storage solutions tailored to your specific needs.</p>
                    </div>
                </div>
            </div>
            
            <div class="service-three-construction-right">
                <!-- Architectural Millwork -->
                <div class="w-layout-vflex service-three-service-box-outer">
                    <div class="service-three-service-image-box">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/674e4af6a81ec22fb406f98c_DSC04862-HDR%20%28Small%29.webp" 
                             width="410" height="250" alt="Architectural Millwork" 
                             class="service-three-hover-img">
                    </div>
                    <div class="service-three-service-text-box">
                        <div class="w-layout-hflex site-preparation-flex">
                            <div class="heading-five">Architectural Millwork</div>
                        </div>
                        <p class="margin-bottom-fifteen">Custom architectural woodwork including trim, moldings, and decorative elements that enhance your space.</p>
                    </div>
                </div>
                
                <!-- Bespoke Furniture -->
                <div class="w-layout-vflex service-three-service-box-outer second-box">
                    <div class="service-three-service-image-box">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/674e4af6a81ec22fb406f992_DSC01452-2%20%28Small%29.webp" 
                             width="410" height="250" alt="Custom Furniture" 
                             class="service-three-hover-img">
                    </div>
                    <div class="service-three-service-text-box">
                        <div class="w-layout-hflex site-preparation-flex">
                            <div class="heading-five">Bespoke Furniture</div>
                        </div>
                        <p class="margin-bottom-fifteen">One-of-a-kind furniture pieces designed and crafted to perfectly complement your commercial space.</p>
                    </div>
                </div>
                
                <!-- Retail Displays -->
                <div class="w-layout-vflex service-three-service-box-outer second-box">
                    <div class="service-three-service-image-box">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/674fb9db3d96c35876d4b314_0Y7A4128%20%28Large%29.jpg" 
                             width="410" height="250" alt="Custom Retail Displays" 
                             class="service-three-hover-img">
                    </div>
                    <div class="service-three-service-text-box">
                        <div class="w-layout-hflex site-preparation-flex">
                            <div class="heading-five">Retail Displays</div>
                        </div>
                        <p class="margin-bottom-fifteen">Custom display units and shelving systems designed to showcase your products effectively.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Process Section -->
<section class="service-three-section-three">
    <div class="w-layout-blockcontainer comprehensive-container w-container">
        <div class="w-layout-vflex helping-flex margin-bottom-thirty-two center">
            <h2 class="margin-top-zero margin-bottom-twenty service-three-construction-heading">Our Joinery Process</h2>
            <p class="grey-text margin-bottom-zero">From concept to completion, we ensure every detail meets your expectations</p>
        </div>
        
        <div class="w-layout-hflex service-three-construction-flex">
            <div class="service-three-construction-left">
                <!-- Design Consultation -->
                <div class="w-layout-vflex service-three-service-box-outer">
                    <div class="service-three-service-text-box">
                        <div class="w-layout-hflex site-preparation-flex">
                            <div class="heading-five">1. Design Consultation</div>
                        </div>
                        <p class="margin-bottom-fifteen">We work closely with you to understand your vision, requirements, and space constraints to create the perfect design solution.</p>
                    </div>
                </div>
                
                <!-- Precision Manufacturing -->
                <div class="w-layout-vflex service-three-service-box-outer second-box">
                    <div class="service-three-service-text-box">
                        <div class="w-layout-hflex site-preparation-flex">
                            <div class="heading-five">2. Precision Manufacturing</div>
                        </div>
                        <p class="margin-bottom-fifteen">Our skilled craftsmen use premium materials and advanced techniques to manufacture your custom joinery to exact specifications.</p>
                    </div>
                </div>
            </div>
            
            <div class="service-three-construction-right">
                <!-- Professional Installation -->
                <div class="w-layout-vflex service-three-service-box-outer">
                    <div class="service-three-service-text-box">
                        <div class="w-layout-hflex site-preparation-flex">
                            <div class="heading-five">3. Professional Installation</div>
                        </div>
                        <p class="margin-bottom-fifteen">Expert installation ensures perfect fit and finish, with minimal disruption to your business operations.</p>
                    </div>
                </div>
                
                <!-- Quality Assurance -->
                <div class="w-layout-vflex service-three-service-box-outer second-box">
                    <div class="service-three-service-text-box">
                        <div class="w-layout-hflex site-preparation-flex">
                            <div class="heading-five">4. Quality Assurance</div>
                        </div>
                        <p class="margin-bottom-fifteen">Final inspection and quality checks ensure every piece meets our high standards and your complete satisfaction.</p>
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
                    <h2 class="heading-wrap margin-none">Ready for Custom Joinery?</h2>
                </div>
                
                <div class="w-layout-hflex freely-text-flex freely-text-flex-margin">
                    <img width="30" height="30" alt="Freely Icon" src="<?php echo get_template_directory_uri(); ?>/images/66f1ffecdef9310969f579e3_Freely-Icon.svg" class="autofit-3">
                    <p class="margin-bottom-zero-3"><strong class="bold-text">Free Design Consultation:</strong> Discuss your joinery needs with our experts</p>
                </div>
                
                <div class="w-layout-hflex freely-text-flex freely-text-flex-margin">
                    <img width="30" height="30" alt="Freely Icon" src="<?php echo get_template_directory_uri(); ?>/images/66f1ffecdef9310969f579e3_Freely-Icon.svg" class="autofit-3">
                    <p class="margin-bottom-zero-3"><strong>Premium Materials: </strong>We use only the finest timber and hardware.</p>
                </div>
                
                <div class="w-layout-hflex freely-text-flex margin-bottom-none">
                    <img width="30" height="30" alt="Freely Icon" src="<?php echo get_template_directory_uri(); ?>/images/66f1ffecdef9310969f579e3_Freely-Icon.svg" class="autofit-3">
                    <p class="margin-bottom-zero-3"><strong>Expert Craftsmanship:</strong> Skilled artisans with years of experience.</p>
                </div>
                
                <a href="<?php echo esc_url(home_url('/contact')); ?>" role="button" class="hero-button-2 w-inline-block">
                    <div class="button-mask">
                        <div class="link-text-wrp">
                            <div>Get Your Quote Today</div>
                            <div class="secondt-btn-text">Learn more</div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
