<!-- Testimonials Section -->
<section class="home-three-testimonial-section-2">
    <div class="w-layout-blockcontainer container-one-2 w-container">
        <div class="w-layout-hflex home-three-testimonial-flex-2 space-between">
            
            <!-- Left Content -->
            <div class="home-three-testimonial-left left">
                
                <!-- Section Header -->
                <div data-w-id="489dfaf7-b299-4a69-34e9-2bcb4ca4e019" class="w-layout-hflex home-one-hero-heading-flex-2 home-three-testemonial-heading-wrap">
                    <div class="tag-wrap tag-type-one">
                        <div class="tag-2-different dark-tab">
                            <?php
                            $testimonials_tag = get_theme_mod('central_build_testimonials_tag', __('Testimonial', 'central-build'));
                            echo esc_html($testimonials_tag);
                            ?>
                        </div>
                    </div>
                    <h2 class="home-three-testimonial-heading margin-none">
                        <?php
                        $testimonials_title = get_theme_mod('central_build_testimonials_title', __('Words from Those Who\'ve Trusted Us', 'central-build'));
                        echo esc_html($testimonials_title);
                        ?>
                    </h2>
                </div>
                
                <p class="home-three-slider-paragraph-2">
                    <?php
                    $testimonials_description = get_theme_mod(
                        'central_build_testimonials_description',
                        __('Discover why clients trust us for their Fitouts. Our commitment to quality and on-time delivery is reflected in their positive feedback.', 'central-build')
                    );
                    echo esc_html($testimonials_description);
                    ?>
                </p>
                
                <?php
                $testimonials_button_text = get_theme_mod('central_build_testimonials_button_text', __('Testimonials', 'central-build'));
                $testimonials_button_subtext = get_theme_mod('central_build_testimonials_button_subtext', __('Learn more', 'central-build'));
                $testimonials_button_url = get_theme_mod('central_build_testimonials_button_url', home_url('/testimonials'));
                ?>
                <a href="<?php echo esc_url($testimonials_button_url); ?>" role="button" class="hero-button-2 w-inline-block">
                    <div class="button-mask">
                        <div class="link-text-wrp">
                            <div><?php echo esc_html($testimonials_button_text); ?></div>
                            <div class="secondt-btn-text"><?php echo esc_html($testimonials_button_subtext); ?></div>
                        </div>
                    </div>
                </a>
                
                <!-- Testimonials Slider -->
                <div data-delay="4000" data-animation="slide" class="testimonial-slider w-slider" data-autoplay="true" data-easing="ease" data-hide-arrows="false" data-disable-swipe="false" data-autoplay-limit="0" data-nav-spacing="3" data-duration="500" data-infinite="true">
                    <div class="w-slider-mask">
                        
                        <?php
                        // Get testimonials from customizer
                        for ($i = 1; $i <= 3; $i++) {
                            $testimonial_content = get_theme_mod("central_build_testimonial_{$i}_content");
                            $testimonial_name = get_theme_mod("central_build_testimonial_{$i}_name");
                            $testimonial_position = get_theme_mod("central_build_testimonial_{$i}_position");
                            $testimonial_image = get_theme_mod("central_build_testimonial_{$i}_image");
                            
                            if ($testimonial_content) :
                        ?>
                            <div class="w-slide">
                                <div class="home-three-testimonial-box">
                                    <div class="testimonial-content-block">
                                        <div class="counter-paragraph-2 body-font">
                                            "<?php echo esc_html($testimonial_content); ?>"
                                        </div>
                                    </div>
                                    <div class="testimonial-author-block">
                                        <?php if ($testimonial_image) : ?>
                                            <div class="testimonial-author-img">
                                                <img width="70" height="70" 
                                                     alt="<?php echo esc_attr($testimonial_name); ?>" 
                                                     src="<?php echo esc_url($testimonial_image); ?>" 
                                                     class="autofit-3">
                                            </div>
                                        <?php endif; ?>
                                        <div class="testimonial-author-text">
                                            <div class="heading-six-2 margin-top-none">
                                                <?php echo esc_html($testimonial_name); ?>
                                            </div>
                                            <p class="margin-bottom-zero-2 margin-top-four">
                                                <?php echo esc_html($testimonial_position); ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php 
                            endif;
                        }
                        ?>
                        
                    </div>
                    
                    <!-- Slider Navigation -->
                    <div class="display-none w-slider-arrow-left">
                        <div class="w-icon-slider-left"></div>
                    </div>
                    <div class="display-none w-slider-arrow-right">
                        <div class="w-icon-slider-right"></div>
                    </div>
                    <div class="slide-nav-two home-threee-slider-dot w-slider-nav w-slider-nav-invert w-round"></div>
                </div>
            </div>
            
            <!-- Right Image -->
            <div class="home-three-testimonial-right right">
                <?php
                $testimonials_image = get_theme_mod('central_build_testimonials_image');
                if ($testimonials_image) : ?>
                    <img width="630" height="550" 
                         alt="<?php esc_attr_e('Testimonials Image', 'central-build'); ?>" 
                         src="<?php echo esc_url($testimonials_image); ?>" 
                         loading="lazy" 
                         class="autofit-3 responsive-full-width">
                <?php else : ?>
                    <img width="630" height="550" 
                         alt="<?php esc_attr_e('Que Dining Hospitality Fitout', 'central-build'); ?>" 
                         src="<?php echo esc_url(get_template_directory_uri() . '/images/testimonials-default.jpg'); ?>" 
                         loading="lazy" 
                         class="autofit-3 responsive-full-width">
                <?php endif; ?>
            </div>
            
        </div>
    </div>
</section>
