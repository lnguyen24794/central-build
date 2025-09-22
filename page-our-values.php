<?php
/**
 * Template Name: Our Values Page
 * 
 * @package Central_Build_Pro
 * @since 1.0.0
 */

get_header(); ?>

<!-- Hero Section -->
<section class="about-one-hero-section">
    <div class="w-layout-blockcontainer container-one about-two-hero-container w-container">
        <div class="about-one-hero-block">
            <div class="w-layout-hflex about-one-heading">
                <div class="tag-wrap">
                    <div class="tag dark-tab">About Us</div>
                </div>
                <h1 class="about-one-hero-heading text-white margin-none">
                    <?php 
                    if (have_posts()) : 
                        while (have_posts()) : the_post();
                            if (get_the_title()) {
                                the_title();
                            } else {
                                echo 'Creating a <span>legacy</span> of quality construction';
                            }
                        endwhile;
                    else :
                        echo 'Creating a <span>legacy</span> of quality construction';
                    endif;
                    ?>
                </h1>
            </div>
            <p class="color-white margin-bottom-zero about-one-hero-paragraph margin-top-twenty-five">
                <?php 
                if (have_posts()) : 
                    while (have_posts()) : the_post();
                        if (get_the_content()) {
                            echo wp_trim_words(get_the_content(), 50);
                        } else {
                            echo 'Central Build Pro delivers high-quality Brisbane commercial shop Fitouts with a focus on trust, sustainability, and supporting the local community. We are committed to creating lasting spaces that reflect our clients\' vision and contribute to local business success.';
                        }
                    endwhile;
                else :
                    echo 'Central Build Pro delivers high-quality Brisbane commercial shop Fitouts with a focus on trust, sustainability, and supporting the local community. We are committed to creating lasting spaces that reflect our clients\' vision and contribute to local business success.';
                endif;
                ?>
            </p>
        </div>
    </div>
    <div class="about-one-hero-overlay about-one-hero-overlay-two"></div>
    <div class="about-one-hero-overlay"></div>
</section>

<!-- Values Section -->
<section class="about-one-section-two">
    <div class="w-layout-blockcontainer container-one w-container">
        <div class="w-layout-hflex about-one-bottom-banner-block">
            <div class="about-one-bottom-banner-left">
                <img src="<?php echo get_template_directory_uri(); ?>/images/66f1ffecdef9310969f57cf8_About%20Icon%20%281%29.svg" alt="Icon" width="43" height="44" class="autofit">
                <div class="heading-six margin-top-thirty">CSR Commitments</div>
                <p class="margin-bottom-zero">Alongside our commitment to creating lasting spaces, we proudly support local initiatives through our CSR efforts, including partnerships with Centre for Women & Co. and other community-focused organizations.</p>
            </div>
            <div class="about-one-bottom-banner-left">
                <img src="<?php echo get_template_directory_uri(); ?>/images/66f1ffecdef9310969f57cf9_About%20Icon%20%282%29.svg" alt="Icon" width="40" height="44" class="autofit">
                <div class="heading-six margin-top-thirty">100% <span>secure</span> services</div>
                <p class="margin-bottom-zero">We ensure 100% secure services through strict compliance with industry standards, sourcing trusted materials, and utilising the expertise of our certified team.</p>
            </div>
            <div class="about-one-bottom-banner-right">
                <div class="about-one-hero-button-wrap">
                    <div class="position-relative about-one-hero-button-block">
                        <div class="about-one-hero-button-background"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Mission Section -->
<section class="about-one-section-three">
    <div class="w-layout-blockcontainer container-one w-container">
        <div class="w-layout-hflex about-one-mission-block">
            <div class="about-one-mission-left">
                <img src="<?php echo get_template_directory_uri(); ?>/images/66f1ffecdef9310969f57af1_About-One-Color-Bg.webp" 
                     class="desktop-visible-responsive-hidden">
                <img class="autofit responsive-full-width about-one-mission-img" 
                     src="<?php echo get_template_directory_uri(); ?>/images/674f93236bf6f3bf70603016_ENP05610%20%28Large%29.jpg" 
                     width="520" height="640" 
                     alt="Central Build Pro project team on site at commercial fitout" 
                     loading="lazy">
            </div>
            <div class="about-one-mission-right">
                <div class="w-layout-hflex home-one-hero-heading-flex">
                    <div class="tag-wrap padding-none">
                        <div class="tag dark-tab">Mission</div>
                    </div>
                    <h2 class="margin-none mission-headaing">Our mission is to build quality future</h2>
                </div>
                <p class="mission-paragraph-margin">At Central Build Pro, our mission is to create a legacy of quality shop Fitouts, with a focus on craftsmanship, sustainability, and supporting the local community.</p>
                
                <div style="background-color:rgb(255,255,255)" class="box-two-block box-two-active">
                    <div class="w-layout-hflex box-two-flex">
                        <div class="mission-icon-block">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/66f1ffecdef9310969f57a49_Performance-Arrow.svg" alt="Performance Arrow" width="25" height="25" class="autofit">
                        </div>
                        <div class="mission-text-block">
                            <div class="heading-six margin-top-none">Creating Sustainable Structures</div>
                            <p class="margin-bottom-zero performance-padding-one">Our sustainable practices and quality workmanship create long-lasting spaces that enhance local businesses and contribute to a stronger community.</p>
                        </div>
                    </div>
                </div>
                
                <div class="box-two-block box-two-active-responsive">
                    <div class="w-layout-hflex box-two-flex">
                        <div class="mission-icon-block">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/66f1ffecdef9310969f57a49_Performance-Arrow.svg" alt="Performance Arrow" width="25" height="25" class="autofit">
                        </div>
                        <div class="mission-text-block">
                            <div class="heading-six margin-top-none">Client-Focused Approach</div>
                            <p class="margin-bottom-zero performance-padding-one">We collaborate with clients throughout the entire project, offering transparent, upfront pricing with no hidden costs. We tailor our Fitouts to maximise your business potential while respecting your budget.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Process Section -->
<section class="about-one-section-four">
    <div class="w-layout-blockcontainer container-one w-container">
        <div class="w-layout-vflex helping-flex left-align">
            <h2 class="text-white mobile-text-left tab-text-left">Bringing Your Vision to Life <br>with Central Build Pro</h2>
            <p class="text-light-grey margin-top-twenty paragraph-subtext">Don't Fit in with your Average Fitout.</p>
        </div>
        
        <div class="w-layout-hflex about-one-focused-block">
            <div class="about-one-focused-left">
                <div class="focused-icon-block">
                    <div class="focused-icon-left margin-top-ten">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/66f1ffecdef9310969f57a8c_Quality-Icon.svg" alt="Quality Icon" width="42" height="52" class="autofit">
                    </div>
                    <div class="focused-text-right">
                        <div class="heading-five text-white">One-Stop Solution from Design to Build</div>
                        <p class="margin-top-fifteen text-light-grey">We manage everything from design to build and post-project support, offering a seamless, stress-free experience.</p>
                    </div>
                </div>
                
                <div class="focused-icon-block">
                    <div class="focused-icon-left margin-top-ten">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/66f1ffecdef9310969f57a8a_Superior-Icon.svg" alt="Superior Icon" width="49" height="48" class="autofit">
                    </div>
                    <div class="focused-text-right">
                        <div class="heading-five text-white">Superior Project Management</div>
                        <p class="margin-top-fifteen text-light-grey">Our expert project managers ensure top quality, so clients never have to worry about the process.</p>
                    </div>
                </div>
                
                <div class="focused-icon-block focused-no-bottom-border">
                    <div class="focused-icon-left margin-top-ten">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/66f1ffecdef9310969f57d0d_Clock%20Icon.svg" alt="Clock Icon" width="37" height="51" class="autofit">
                    </div>
                    <div class="focused-text-right">
                        <div class="heading-five text-white">Delivering Project On Time</div>
                        <p class="margin-top-fifteen text-light-grey">We guarantee timely project completion, allowing clients to meet key deadlines and focus on business operations.</p>
                    </div>
                </div>
            </div>
            
            <div class="about-one-focused-right">
                <div style="opacity:1" class="about-one-focused-image-one">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/674f9b92faa922f1c9d341e8_ENP01158%20%28Large%29.jpg" 
                         width="645" height="481" 
                         alt="Central Build Pro project team on site at commercial fitout" 
                         class="autofit responsive-full-width">
                </div>
            </div>
        </div>
        
        <!-- Statistics -->
        <div class="w-layout-hflex about-one-counter-block">
            <div class="about-one-counter-block-small">
                <div class="about-one-counter-box">
                    <div class="heading-three text-white margin-none">24+</div>
                    <div class="margin-top-fifteen text-light-grey text-captalize">years of experience</div>
                </div>
                <div class="about-one-counter-box">
                    <div class="heading-three text-white margin-none">4.8/5</div>
                    <div class="margin-top-fifteen text-light-grey text-captalize">Client Satisfaction</div>
                </div>
            </div>
            <div class="about-one-counter-block-small">
                <div class="about-one-counter-box">
                    <div class="heading-three text-white margin-none">168</div>
                    <div class="margin-top-fifteen text-light-grey text-captalize">projects done</div>
                </div>
                <div class="about-one-counter-box no-left-border">
                    <div class="heading-three text-white margin-none">98 %</div>
                    <div class="margin-top-fifteen text-light-grey text-captalize">project on time</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Us Section -->
<div class="why-choose-us-2">
    <section class="why-choose-hero-section-2">
        <div class="about-two-cta-block-3">
            <div class="cta-box">
                <div class="about-two-cta-left">
                    <img width="177" height="140" alt="Central Build Pro project team on site" 
                         src="<?php echo get_template_directory_uri(); ?>/images/674f8951b0a7b472cd1e9c7a_ENP08765%20%28Large%29.webp" 
                         class="autofit-3 border-radious-ten">
                    <div class="about-two-cta-text-block">
                        <div class="cta-text-wrap">
                            <h3 class="color-white margin-bottom-twenty margin-top-zero responsive-text-center cta-heading">Want To Discuss About Your Next Project?</h3>
                            <div class="cta-line-3"></div>
                            <p class="color-white margin-bottom-zero responsive-text-center cta-paragraph">Give us a call today and<br>let us know how we can help!</p>
                        </div>
                        <div class="about-two-cta-right">
                            <a href="<?php echo esc_url(home_url('/contact')); ?>" role="button" class="hero-button-2 black-button w-inline-block">
                                <div class="button-mask">
                                    <div class="link-text-wrp">
                                        <div>enquire now</div>
                                        <div class="secondt-btn-text">enquire now</div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="my-container container">
            <div class="service-two-mission-tag-2 why-chosse-hero-tag">
                <div class="w-layout-hflex home-one-hero-heading-flex-2 why-choose-us-hero-heading">
                    <div class="why-choose-us-tag-wrap padding-none">
                        <div class="tag-5 transparent home-one-hero-tag">Why Choose Us</div>
                    </div>
                    <h2 class="color-white margin-none why-choose-us-banner-heading">Innovative Spaces, Stronger Communities</h2>
                </div>
                <p class="color-white margin-bottom-zero why-choose-hero-paragraph">Central Build Pro offers a complete, hassle-free experience from design to completion, with expert project management and in-house craftsmanship to ensure every detail is perfect.</p>
            </div>
        </div>
    </section>
    
    <!-- Services Section -->
    <section class="why-choose-section-two">
        <div class="my-container container">
            <div class="w-layout-hflex why-choose-hero-flex">
                <div class="why-choose-hero-left">
                    <div class="why-choose-image-block image-block-one"></div>
                    <div class="heading-six-3 margin-top-twenty">In-house Joinery</div>
                    <p class="margin-bottom-zero-3">Experienced in-house joinery team delivering high-quality, bespoke craftsmanship for every project.</p>
                </div>
                <div class="why-choose-hero-left hero-left-two">
                    <div class="why-choose-image-block image-block-two img-block-active"></div>
                    <div class="heading-six-3 margin-top-twenty">Commercial Shop Fitting</div>
                    <p class="margin-bottom-zero-3">Provide tailored Shop fitting solutions that seamlessly integrate functionality and style for commercial spaces.</p>
                </div>
                <div class="why-choose-hero-left hero-left-three">
                    <div class="why-choose-image-block img-block-three"></div>
                    <div class="heading-six-3 margin-top-twenty">Concreet</div>
                    <p class="margin-bottom-zero-3">Innovative decorative concrete facades and furniture, adding a distinctive industrial touch to modern designs.</p>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Featured Projects -->
<section class="home-three-section-two">
    <div class="w-layout-blockcontainer container-one w-container">
        <div class="home-two-mid-icon-block">
            <div class="large-visible-desktop-hidden home-three-construction-heading">
                <h2 class="heading-3">Featured Projects</h2>
            </div>
        </div>
    </div>
    
    <div class="projects-flex">
        <!-- Sample project items -->
        <div class="w-dyn-item">
            <a href="#" class="link-block w-inline-block">
                <div class="project-block-outer" style="background-image:url('<?php echo get_template_directory_uri(); ?>/images/687ef5fb6cbe67daa2094be0_enp00981.jpg')">
                    <div class="listing-two-content">
                        <div class="w-layout-hflex project-building-flex">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/66f1ffecdef9310969f57c28_Project-Building-Icon.webp" alt="" width="50" height="40" class="project-icon">
                            <div class="project-block">
                                <div class="heading-five text-white margin-none">Sample Project</div>
                                <div class="heading-five text-white margin-top-none">Commercial Fitout</div>
                            </div>
                        </div>
                    </div>
                    <div class="listing-bg"></div>
                </div>
            </a>
        </div>
    </div>
</section>

<?php get_footer(); ?>