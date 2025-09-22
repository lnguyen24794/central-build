<?php
/**
 * Template Name: Commercial Shop Fitting
 * 
 * @package Central_Build_Pro
 * @since 1.0.0
 */

get_header(); ?>

<section class="service-three-hero-section">
    <div class="w-layout-blockcontainer container-one w-container">
        <div class="service-three-hero-block">
            <div data-w-id="0e6a7f6d-b00b-4b93-40ad-6dcdae4d3d25" class="w-layout-hflex home-one-hero-heading-flex">
                <div class="tag-wrap padding-none">
                    <div class="tag transparent home-one-hero-tag">Construction</div>
                </div>
                <h1 class="text-white margin-none service-three-banner-heading">
                    <?php 
                    if (have_posts()) : 
                        while (have_posts()) : the_post();
                            if (get_the_title()) {
                                the_title();
                            } else {
                                echo 'Commercial Shopfitting';
                            }
                        endwhile;
                    else :
                        echo 'Commercial Shopfitting';
                    endif;
                    ?>
                </h1>
            </div>
            <p data-w-id="5fd7aa5e-e5be-52c3-3085-db0cd07a97f2" class="color-white margin-bottom-zero service-three-paragraph">
                <?php 
                if (have_posts()) : 
                    while (have_posts()) : the_post();
                        if (get_the_content()) {
                            echo wp_trim_words(get_the_content(), 30);
                        } else {
                            echo 'Explore our expertise in commercial shopfitting, specialising in office, retail, hospitality, and mezzanine fitouts, tailored to meet every need.';
                        }
                    endwhile;
                else :
                    echo 'Explore our expertise in commercial shopfitting, specialising in office, retail, hospitality, and mezzanine fitouts, tailored to meet every need.';
                endif;
                ?>
            </p>
            <div data-w-id="5fd7aa5e-e5be-52c3-3085-db0cd07a97f4" class="w-layout-vflex service-three-hero-flex-url">
                <a href="<?php echo esc_url(home_url('/about-us/our-values')); ?>" class="service-three-hero-link-block w-inline-block">
                    <div class="heading-six margin-none text-white">Project Management and Construction Services</div>
                    <img src="<?php echo get_template_directory_uri(); ?>/images/66f1ffecdef9310969f57b20_Service-Three-Arrow.svg" alt="" width="19" height="19" class="autofit miiddle-align">
                </a>
                <a href="<?php echo esc_url(home_url('/service/custom-joinery')); ?>" class="service-three-hero-link-block w-inline-block">
                    <div class="heading-six margin-none text-white">In-house Joinery</div>
                    <img src="<?php echo get_template_directory_uri(); ?>/images/66f1ffecdef9310969f57b20_Service-Three-Arrow.svg" alt="" width="19" height="19" class="autofit miiddle-align">
                </a>
                <a href="<?php echo esc_url(home_url('/service/concreet')); ?>" class="service-three-hero-link-block w-inline-block">
                    <div class="heading-six margin-none text-white">Concreet</div>
                    <img src="<?php echo get_template_directory_uri(); ?>/images/66f1ffecdef9310969f57b20_Service-Three-Arrow.svg" alt="" width="19" height="19" class="autofit miiddle-align">
                </a>
            </div>
        </div>
    </div>
</section>

<section class="service-three-logo-section">
    <div class="w-layout-blockcontainer container-one w-container">
        <div class="w-layout-hflex service-three-logo-flex">
            <div class="service-three-logo-left">
                <img src="<?php echo get_template_directory_uri(); ?>/images/67563d1b3fc98bbd5298e096_DSC00857%20%28Large%29.jpg" 
                     data-w-id="5fd7aa5e-e5be-52c3-3085-db0cd07a9805" width="600" height="783" 
                     alt="Cabinetry team member installing marble benchtop during custom joinery fitout" 
                     srcset="<?php echo get_template_directory_uri(); ?>/images/67563d1b3fc98bbd5298e096_DSC00857%20%28Large%29-p-500.jpg 500w, <?php echo get_template_directory_uri(); ?>/images/67563d1b3fc98bbd5298e096_DSC00857%20%28Large%29.jpg 720w" 
                     sizes="(max-width: 767px) 100vw, 600px" class="service-three-hero-img">
            </div>
            <div class="service-three-logo-right">
                <div class="partners-name-wrapper service-three-logo-wrapper">
                    <div data-w-id="5fd7aa5e-e5be-52c3-3085-db0cd07a9808" class="partners-slide-wrapper">
                        <!-- Partner logos grid -->
                        <div class="w-layout-grid partners-wrapper-3">
                            <img width="148" height="80" alt="" src="<?php echo get_template_directory_uri(); ?>/images/674e4d0f8cab55fa62011a8d_0e0390_f6cf18ca135943be975fb7f5ca58dd4d~mv2.webp" loading="lazy" class="logo-image">
                            <img width="148" height="80" alt="" src="<?php echo get_template_directory_uri(); ?>/images/674e4d0f8cab55fa62011a89_14.svg" loading="lazy" class="logo-image">
                            <img width="180" height="80" alt="" src="<?php echo get_template_directory_uri(); ?>/images/674e4d0f8cab55fa62011a99_CFW%20-%20LOGO%20-%20GREY%20-%20MAIN.webp" loading="lazy" class="logo-image">
                        </div>
                        <div class="w-layout-grid partners-wrapper-3">
                            <img width="127" height="80" alt="" src="<?php echo get_template_directory_uri(); ?>/images/674e4d0f8cab55fa62011a85_3.svg" loading="lazy" class="logo-image">
                            <img width="135" height="80" alt="" src="<?php echo get_template_directory_uri(); ?>/images/674e4d0f8cab55fa62011a87_13.svg" loading="lazy" class="logo-image">
                            <img width="147" height="80" alt="" src="<?php echo get_template_directory_uri(); ?>/images/674e4d0f8cab55fa62011a84_11.svg" loading="lazy" class="logo-image">
                        </div>
                        <div class="w-layout-grid partners-wrapper-3">
                            <img width="148" height="80" alt="" src="<?php echo get_template_directory_uri(); ?>/images/674e4d0f8cab55fa62011a82_7.svg" loading="lazy" class="logo-image">
                            <img width="148" height="80" alt="" src="<?php echo get_template_directory_uri(); ?>/images/674e4d0f8cab55fa62011a81_4.svg" loading="lazy" class="logo-image">
                            <img width="160" height="80" alt="" src="<?php echo get_template_directory_uri(); ?>/images/674e4d0f8cab55fa62011a80_6.svg" loading="lazy" class="logo-image">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="service-three-section-three">
    <div class="w-layout-blockcontainer showcase-container w-container">
        <div data-w-id="5fd7aa5e-e5be-52c3-3085-db0cd07a9817" class="w-layout-vflex helping-flex margin-bottom-thirty-two center">
            <img src="<?php echo get_template_directory_uri(); ?>/images/66f1ffecdef9310969f57b01_Service-Three-Construction.webp" loading="lazy" width="134" height="134" alt="" class="margin-bottom-thirty-two">
            <h2 class="margin-top-zero margin-bottom-twenty service-three-construction-heading">Showcasing the Core of Our Fitout Expertise</h2>
            <p class="grey-text margin-bottom-zero">Explore our Fitout expertise with our sectors</p>
        </div>
        
        <div class="w-layout-hflex service-three-construction-flex">
            <div data-w-id="5fd7aa5e-e5be-52c3-3085-db0cd07a981e" class="service-three-construction-left">
                <!-- Office Fitout -->
                <div class="w-layout-vflex service-three-service-box-outer">
                    <div data-w-id="5fd7aa5e-e5be-52c3-3085-db0cd07a9820" class="service-three-service-image-box">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/674fb0ac8b2be968fa78a53b_MAIN_OFFICE_3.3.1%20%28Large%29.png" 
                             data-w-id="5fd7aa5e-e5be-52c3-3085-db0cd07a9821" width="410" height="250" 
                             alt="Raw White Rochedale Office Fitout" 
                             class="service-three-hover-img">
                    </div>
                    <div class="service-three-service-text-box">
                        <div class="w-layout-hflex site-preparation-flex">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/674e4af6a81ec22fb406f984_1.svg" alt="" width="41" height="45" class="autofit miiddle-align">
                            <div class="heading-five">Office Fitout</div>
                        </div>
                        <p class="margin-bottom-fifteen">Transform your workspace into a productive and stylish environment with our tailored Office Fitouts.</p>
                        <div data-w-id="5fd7aa5e-e5be-52c3-3085-db0cd07a9829" class="learn-more-block">
                            <a href="<?php echo esc_url(home_url('/fitout-sectors/office-fitout')); ?>" class="learn-link-block w-inline-block">
                                <div class="_3d-button-text color-dark">Learn More</div>
                                <img src="<?php echo get_template_directory_uri(); ?>/images/66f1ffecdef9310969f57d1c_Red%20Arrow.svg" alt="Arrow" width="18" height="8" class="btn-arrow">
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Retail Fitout -->
                <div class="w-layout-vflex service-three-service-box-outer second-box">
                    <div data-w-id="5fd7aa5e-e5be-52c3-3085-db0cd07a9833" class="service-three-service-image-box">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/674fb59ca04815b79062e722_1%20%28Large%29.jpg" 
                             data-w-id="5fd7aa5e-e5be-52c3-3085-db0cd07a9834" height="250" 
                             alt="MOOII Retail Fitout" width="410" 
                             class="service-three-hover-img">
                    </div>
                    <div class="service-three-service-text-box">
                        <div class="w-layout-hflex site-preparation-flex">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/674e4af6a81ec22fb406f985_4.svg" alt="" width="37" height="45" class="autofit miiddle-align">
                            <div class="heading-five">Retail Fitout</div>
                        </div>
                        <p class="margin-bottom-fifteen">Revamp your retail space with designs that attract customers and drive sales.</p>
                        <div class="learn-more-block">
                            <a href="<?php echo esc_url(home_url('/fitout-sectors/retail-fitout')); ?>" class="learn-link-block w-inline-block">
                                <div class="_3d-button-text color-dark">Learn More</div>
                                <img src="<?php echo get_template_directory_uri(); ?>/images/66f1ffecdef9310969f57d1c_Red%20Arrow.svg" alt="Arrow" width="18" height="8" class="btn-arrow">
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Beauty & Wellness Fitout -->
                <div class="w-layout-vflex service-three-service-box-outer second-box">
                    <div class="service-three-service-image-box">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/6758b52edb5c369d0ad329f7_Gloss%20Final-68%20%28Large%29.jpg" 
                             height="250" alt="Gloss Saloon Fitout" width="410" 
                             class="service-three-hover-img">
                    </div>
                    <div class="service-three-service-text-box">
                        <div class="w-layout-hflex site-preparation-flex">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/674e4af6a81ec22fb406f985_4.svg" alt="" width="37" height="45" class="autofit miiddle-align">
                            <div class="heading-five">Beauty & Wellness Fitout</div>
                        </div>
                        <p class="margin-bottom-fifteen">Specialized Salon Fitouts that combine elegance and functionality, creating inviting spaces designed to enhance client experiences and brand identity.</p>
                        <div class="learn-more-block">
                            <a href="<?php echo esc_url(home_url('/fitout-sectors/beauty-wellness-fitout')); ?>" class="learn-link-block w-inline-block">
                                <div class="_3d-button-text color-dark">Learn More</div>
                                <img src="<?php echo get_template_directory_uri(); ?>/images/66f1ffecdef9310969f57d1c_Red%20Arrow.svg" alt="Arrow" width="18" height="8" class="btn-arrow">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div data-w-id="5fd7aa5e-e5be-52c3-3085-db0cd07a9845" class="service-three-construction-right">
                <!-- Hospitality Fitout -->
                <div class="w-layout-vflex service-three-service-box-outer">
                    <div class="service-three-service-image-box">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/674e4af6a81ec22fb406f98c_DSC04862-HDR%20%28Small%29.webp" 
                             width="410" height="250" alt="Ippin Dining Hospitality Fitout" 
                             class="service-three-hover-img">
                    </div>
                    <div class="service-three-service-text-box">
                        <div class="w-layout-hflex site-preparation-flex">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/674e4af6a81ec22fb406f986_2.svg" alt="" width="41" height="38" class="autofit miiddle-align">
                            <div class="heading-five">Hospitality Fitout</div>
                        </div>
                        <p class="margin-bottom-fifteen">Create an inviting ambiance that impresses guests with our custom Hospitality Fitouts.</p>
                        <div class="learn-more-block">
                            <a href="<?php echo esc_url(home_url('/fitout-sectors/hospitality-fitout')); ?>" class="learn-link-block w-inline-block">
                                <div class="_3d-button-text color-dark">Learn More</div>
                                <img src="<?php echo get_template_directory_uri(); ?>/images/66f1ffecdef9310969f57d1c_Red%20Arrow.svg" alt="Arrow" width="18" height="8" class="btn-arrow">
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Mezzanine Fitout -->
                <div class="w-layout-vflex service-three-service-box-outer second-box">
                    <div class="service-three-service-image-box">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/674e4af6a81ec22fb406f992_DSC01452-2%20%28Small%29.webp" 
                             width="410" height="250" alt="Mezzanine Fitout" 
                             class="service-three-hover-img">
                    </div>
                    <div class="service-three-service-text-box">
                        <div class="w-layout-hflex site-preparation-flex">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/674e4af6a81ec22fb406f983_3.svg" alt="" width="40" height="36" class="autofit miiddle-align">
                            <div class="heading-five">mezzanine fitout</div>
                        </div>
                        <p class="margin-bottom-fifteen">Maximize space efficiently with our functional and innovative mezzanine Fitouts.</p>
                        <div class="learn-more-block">
                            <a href="<?php echo esc_url(home_url('/fitout-sectors/mezzanine-fitout')); ?>" class="learn-link-block w-inline-block">
                                <div class="_3d-button-text color-dark">Learn More</div>
                                <img src="<?php echo get_template_directory_uri(); ?>/images/66f1ffecdef9310969f57d1c_Red%20Arrow.svg" alt="Arrow" width="18" height="8" class="btn-arrow">
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Medical Fitout -->
                <div class="w-layout-vflex service-three-service-box-outer second-box">
                    <div class="service-three-service-image-box">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/674fb9db3d96c35876d4b314_0Y7A4128%20%28Large%29.jpg" 
                             width="410" height="250" alt="Richlands Dental Medical Fitout" 
                             class="service-three-hover-img">
                    </div>
                    <div class="service-three-service-text-box">
                        <div class="w-layout-hflex site-preparation-flex">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/66f1ffecdef9310969f57d82_Rotate%20Icon.svg" alt="" width="40" height="36" class="autofit miiddle-align">
                            <div class="heading-five">Medical Fitout</div>
                        </div>
                        <p class="margin-bottom-fifteen">Transform healthcare spaces with Central Build Pro. We specialize in functional, patient-focused medical fitouts tailored to your practice's needs.</p>
                        <div class="learn-more-block">
                            <a href="<?php echo esc_url(home_url('/fitout-sectors/medical-fitout')); ?>" class="learn-link-block w-inline-block">
                                <div class="_3d-button-text color-dark">Learn More</div>
                                <img src="<?php echo get_template_directory_uri(); ?>/images/66f1ffecdef9310969f57d1c_Red%20Arrow.svg" alt="Arrow" width="18" height="8" class="btn-arrow">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Services Marquee Section -->
<section class="service-three-section-four">
    <div class="w-layout-blockcontainer container-full-width w-container">
        <div class="about-two-journey-marque-block about-three-journey-marquee-block service-three-journey-marquee">
            <div class="w-layout-hflex service-two-marquee-main-wrap">
                <div class="w-layout-hflex service-two-marquee-box">
                    <div class="construction-marquee-train">
                        <div class="w-layout-hflex about-two-marquee-flex-block">
                            <img width="28" height="28" alt="" src="<?php echo get_template_directory_uri(); ?>/images/66f1ffecdef9310969f57cfb_.svg" class="autofit-3 middle-align">
                            <div class="about-one-marque-right-text about-two-marque-right-text">
                                <div class="heading-six-5 text-white margin-none">Project Management</div>
                            </div>
                        </div>
                    </div>
                    <div class="construction-marquee-train">
                        <div class="w-layout-hflex about-two-marquee-flex-block">
                            <img width="28" height="28" alt="" src="<?php echo get_template_directory_uri(); ?>/images/66f1ffecdef9310969f57cfb_.svg" class="autofit-3 middle-align">
                            <div class="about-one-marque-right-text about-two-marque-right-text">
                                <div class="heading-six-5 text-white margin-none">Project Planning</div>
                            </div>
                        </div>
                    </div>
                    <div class="construction-marquee-train">
                        <div class="w-layout-hflex about-two-marquee-flex-block">
                            <img width="28" height="28" alt="" src="<?php echo get_template_directory_uri(); ?>/images/66f1ffecdef9310969f57cfb_.svg" class="autofit-3 middle-align">
                            <div class="about-one-marque-right-text about-two-marque-right-text">
                                <div class="heading-six-5 text-white margin-none">Custom Joinery</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Comprehensive Construction Services -->
<section class="service-three-section-three">
    <div class="w-layout-blockcontainer comprehensive-container w-container">
        <div class="w-layout-vflex helping-flex margin-bottom-thirty-two center">
            <h2 class="margin-top-zero margin-bottom-twenty service-three-construction-heading">Comprehensive Construction Services</h2>
            <p class="grey-text margin-bottom-zero">In addition to shop fitting, we offer comprehensive construction services designed to cover every aspect of your project.</p>
        </div>
        
        <div class="w-layout-hflex service-three-construction-flex">
            <div class="service-three-construction-left">
                <!-- Project Management -->
                <div class="w-layout-vflex service-three-service-box-outer">
                    <div class="service-three-service-image-box">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/674f92c4a5ffc95f001fafc8_ENP09768%20%28Large%29.jpg" 
                             width="410" height="250" 
                             alt="Project manager coordinating site progress and subcontractors during commercial fitout" 
                             class="service-three-hover-img">
                    </div>
                    <div class="service-three-service-text-box">
                        <div class="w-layout-hflex site-preparation-flex">
                            <div class="heading-five">Project Management & Planning</div>
                        </div>
                        <p class="margin-bottom-fifteen">Comprehensive project management ensuring seamless planning, coordination, and execution of your fitout, delivered on time and within budget.</p>
                    </div>
                </div>
                
                <!-- Partitions & Ceilings -->
                <div class="w-layout-vflex service-three-service-box-outer second-box">
                    <div class="service-three-service-image-box">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/674e4af6a81ec22fb406f996_DSC02949-HDR%20%28Small%29.webp" 
                             height="250" alt="Centre For Women & Co. Office Fitout Wellington" width="410" 
                             class="service-three-hover-img">
                    </div>
                    <div class="service-three-service-text-box">
                        <div class="w-layout-hflex site-preparation-flex">
                            <div class="heading-five">Partitions & Ceilings</div>
                        </div>
                        <p class="margin-bottom-fifteen">High-quality partitions and ceiling installations, designed to optimize space, acoustics, and aesthetics for your commercial environment.</p>
                    </div>
                </div>
                
                <!-- Flooring & Finishes -->
                <div class="w-layout-vflex service-three-service-box-outer second-box">
                    <div class="service-three-service-image-box">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/674fb9db3d96c35876d4b314_0Y7A4128%20%28Large%29.jpg" 
                             height="250" alt="" width="410" 
                             class="service-three-hover-img">
                    </div>
                    <div class="service-three-service-text-box">
                        <div class="w-layout-hflex site-preparation-flex">
                            <div class="heading-five">Flooring & Finishes</div>
                        </div>
                        <p class="margin-bottom-fifteen">Durable and stylish flooring options paired with premium finishes to enhance the aesthetics and practicality of your space.</p>
                    </div>
                </div>
            </div>
            
            <div class="service-three-construction-right">
                <!-- Mechanical & Electrical -->
                <div class="w-layout-vflex service-three-service-box-outer">
                    <div class="service-three-service-image-box">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/67563c5cdf4c47e4270f0535_ENP04085%20%28Large%29.jpg" 
                             width="410" height="250" 
                             alt="Central Build Pro team members completing mechanical works" 
                             class="service-three-hover-img">
                    </div>
                    <div class="service-three-service-text-box">
                        <div class="w-layout-hflex site-preparation-flex">
                            <div class="heading-five">Mechanical & Electrical Services</div>
                        </div>
                        <p class="margin-bottom-fifteen">Expert installation of mechanical and electrical systems, including HVAC, lighting, and data cabling, tailored to your space's functionality and safety.</p>
                    </div>
                </div>
                
                <!-- Custom Joinery -->
                <div class="w-layout-vflex service-three-service-box-outer second-box">
                    <div class="service-three-service-image-box">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/674e4000a7cc35ad9ae56831_14%20%28Large%29.webp" 
                             width="410" height="250" alt="TWX Lawyers Office Fitout Kitchen" 
                             class="service-three-hover-img">
                    </div>
                    <div class="service-three-service-text-box">
                        <div class="w-layout-hflex site-preparation-flex">
                            <div class="heading-five">Custom Joinery & Furniture</div>
                        </div>
                        <p class="margin-bottom-fifteen">Beautifully crafted custom joinery and furniture tailored to your unique vision, blending functionality with exceptional design.</p>
                    </div>
                </div>
                
                <!-- Finishing Touches -->
                <div class="w-layout-vflex service-three-service-box-outer second-box">
                    <div class="service-three-service-image-box">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/674fb59ca04815b79062e722_1%20%28Large%29.jpg" 
                             width="410" height="250" alt="" 
                             class="service-three-hover-img">
                    </div>
                    <div class="service-three-service-text-box">
                        <div class="w-layout-hflex site-preparation-flex">
                            <div class="heading-five">Finishing Touches & Signage</div>
                        </div>
                        <p class="margin-bottom-fifteen">Attention to the final details, including bespoke signage and decor, to create a polished and cohesive space that represents your brand.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Partners Marquee -->
<div class="w-layout-hflex home-two-partners-marquee-main-wrap">
    <div class="w-layout-hflex home-two-partners-marquee-box-2">
        <div class="home-two-partners-block-2">
            <img width="148" height="40" alt="" src="<?php echo get_template_directory_uri(); ?>/images/674e4d0f8cab55fa62011a81_4.svg" loading="lazy" class="logo-image">
        </div>
        <div class="home-two-partners-block-2">
            <img width="160" height="80" alt="" src="<?php echo get_template_directory_uri(); ?>/images/674e4d0f8cab55fa62011a89_14.svg" loading="lazy" class="logo-image">
        </div>
        <div class="home-two-partners-block-2">
            <img width="160" height="80" alt="" src="<?php echo get_template_directory_uri(); ?>/images/674e4d0f8cab55fa62011a87_13.svg" loading="lazy" class="logo-image">
        </div>
    </div>
</div>

<!-- Testimonials Section -->
<section class="home-three-testimonial-section-2">
    <div class="my-container container">
        <div class="w-layout-hflex home-three-testimonial-flex-2 space-between">
            <div class="home-three-testimonial-left left">
                <div class="w-layout-hflex home-one-hero-heading-flex-2 home-three-testemonial-heading-wrap">
                    <div class="tag-wrap tag-type-one">
                        <div class="tag-2-different dark-tab">Testimonial</div>
                    </div>
                    <h2 class="home-three-testimonial-heading margin-none">Words from Those Who've Trusted Us</h2>
                </div>
                <p class="home-three-slider-paragraph-2">Discover why clients trust us for their Fitouts. Our commitment to quality and on-time delivery is reflected in their positive feedback.</p>
                
                <!-- Testimonial Slider -->
                <div data-delay="4000" data-animation="slide" class="testimonial-slider w-slider" data-autoplay="true">
                    <div class="w-slider-mask">
                        <div class="w-slide">
                            <div class="home-three-testimonial-box">
                                <div class="testimonial-content-block">
                                    <div class="counter-paragraph-2 body-font">"The level of communication we've received throughout this fitout was unbelievable, I knew exactly what was happening, at any point of the process"</div>
                                </div>
                                <div class="testimonial-author-block">
                                    <div class="testimonial-author-img">
                                        <img width="70" height="70" alt="" src="<?php echo get_template_directory_uri(); ?>/images/674e51387cf2d3270f527a4f_Untitled%20design.webp" class="autofit-3">
                                    </div>
                                    <div class="testimonial-author-text">
                                        <div class="heading-six-2 margin-top-none">Shayley cherry</div>
                                        <p class="margin-bottom-zero-2 maargin-top-four">Raywhite Rochedale</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="home-three-testimonial-right right">
                <img width="630" height="550" alt="" src="<?php echo get_template_directory_uri(); ?>/images/674e51387cf2d3270f527a62_ENP03761%20%28Large%29.webp" 
                     loading="lazy" class="autofit-3 responsive-full-width">
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="home-one-faq-section-copy">
    <div class="my-container container">
        <div class="w-layout-hflex freely-ask-flex-2">
            <div class="freely-ask-left">
                <div class="home-one-faq-block">
                    <div class="faq-accodian-wrapper w-dropdown">
                        <div class="accordion-one pink-border w-dropdown-toggle">
                            <div class="accodian-heading-2">What Are The Charges of Shop Fitout?</div>
                        </div>
                        <nav class="accordion-one-dropdown-main-box w-dropdown-list">
                            <div class="accordion-one-dropdown-contain active">
                                <p class="paragraph-9">As an experienced fitout company, we provide precise cost estimates, considering factors such as floor area, material selection, and design complexity. We are committed to transparency, ensuring no hidden costs in our services.</p>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
            
            <div class="freely-ask-right-2">
                <div class="w-layout-hflex heading-box-3">
                    <div class="tag-wrap tag-type-five right-side-tag">
                        <div class="tag-4 dark-tab">Support</div>
                    </div>
                    <h2 class="heading-wrap margin-none">Ready to Transform Your space?</h2>
                </div>
                
                <div class="w-layout-hflex freely-text-flex freely-text-flex-margin">
                    <img width="30" height="30" alt="Freely Icon" src="<?php echo get_template_directory_uri(); ?>/images/66f1ffecdef9310969f579e3_Freely-Icon.svg" class="autofit-3">
                    <p class="margin-bottom-zero-3"><strong class="bold-text">Free Consultation:</strong> Schedule a no-obligation Consultation</p>
                </div>
                
                <div class="w-layout-hflex freely-text-flex freely-text-flex-margin">
                    <img width="30" height="30" alt="Freely Icon" src="<?php echo get_template_directory_uri(); ?>/images/66f1ffecdef9310969f579e3_Freely-Icon.svg" class="autofit-3">
                    <p class="margin-bottom-zero-3"><strong>Custom Design: </strong>Tailored solutions to fit your vision.</p>
                </div>
                
                <div class="w-layout-hflex freely-text-flex margin-bottom-none">
                    <img width="30" height="30" alt="Freely Icon" src="<?php echo get_template_directory_uri(); ?>/images/66f1ffecdef9310969f579e3_Freely-Icon.svg" class="autofit-3">
                    <p class="margin-bottom-zero-3"><strong>Quick Start:</strong> Projects commence as soon as designs are finalized.</p>
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