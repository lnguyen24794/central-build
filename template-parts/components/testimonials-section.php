<!-- Testimonials Section -->
<section class="home-three-testimonial-section-2" data-aos="fade-up" data-aos-duration="800">
    <div class="my-container container">
        <div class="row">
            
            <!-- Left Content -->
            <div class="col-md-6 mt-5" data-aos="fade-right" data-aos-delay="120">
                
                <!-- Section Header -->
                <div class="row gap-3 m-3">
                    <div class="p-0 relative" style="width: 30px">
                        <div class="tag-wrap w-100 absolute" style="top: 70px; left: -20px;" data-aos="fade-down" data-aos-delay="150">
                            <div class="tag-2-different dark-tab">
                                <?php
                                $testimonials_tag = get_option('central_build_testimonials_tag', __('Testimonial', 'central-build'));
                                echo esc_html($testimonials_tag);
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <h2 class="home-three-testimonial-heading margin-none" data-aos="fade-down" data-aos-delay="180">
                            <?php
                            $testimonials_title = get_option('central_build_testimonials_title', __('Words from Those Who\'ve Trusted Us', 'central-build'));
                            echo esc_html($testimonials_title);
                            ?>
                        </h2>
                    </div>
                </div>
                
                <p class="home-three-slider-paragraph-2" data-aos="fade-up" data-aos-delay="220">
                    <?php
                    $testimonials_description = get_option(
                        'central_build_testimonials_description',
                        __('Discover why clients trust us for their Fitouts. Our commitment to quality and on-time delivery is reflected in their positive feedback.', 'central-build')
                    );
                    echo esc_html($testimonials_description);
                    ?>
                </p>
                
                <?php
                $testimonials_button_text = get_option('central_build_testimonials_button_text', __('Testimonials', 'central-build'));
                $testimonials_button_subtext = get_option('central_build_testimonials_button_subtext', __('Learn more', 'central-build'));
                $testimonials_button_url = get_option('central_build_testimonials_button_url', home_url('/testimonials'));
                ?>
                <!-- Swiper -->
                <div class="swiper mySwiper mt-3" style="width: 100%;" data-aos="fade-up" data-aos-delay="260">
                    <?php
                        $testimonials = central_build_get_testimonials();
                    ?>
                    <div class="swiper-wrapper">
                        <?php  if (!empty($testimonials)) :
                            foreach ($testimonials as $index => $testimonial) :
                                if (!empty($testimonial['content'])) :
                                    $delay = 280 + ($index * 60);
                        ?>
                        
                        <div class="swiper-slide h-100 home-three-testimonial-box" data-aos="zoom-in" data-aos-delay="<?php echo esc_attr($delay); ?>">
                            <div class="testimonial-content-block" style="min-height: 112px;">
                                <div class="counter-paragraph-2 body-font">
                                    "<?php echo esc_html($testimonial['content']); ?>"
                                </div>
                            </div>
                            <div class="testimonial-author-block" style="min-height: 123px;">
                                <?php if (!empty($testimonial['image'])) : ?>
                                    <div class="testimonial-author-img">
                                        <img width="70" height="70" 
                                                alt="<?php echo esc_attr($testimonial['name'] ?? ''); ?>" 
                                                src="<?php echo esc_url($testimonial['image']); ?>" 
                                                class="autofit-3">
                                    </div>
                                <?php endif; ?>
                                <div class="testimonial-author-text">
                                    <div class="heading-six-2 margin-top-none">
                                        <?php echo esc_html($testimonial['name'] ?? ''); ?>
                                    </div>
                                    <p class="margin-bottom-zero-2 margin-top-four">
                                        <?php echo esc_html($testimonial['position'] ?? ''); ?>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <?php 
                                endif;
                            endforeach;
                        endif;
                        ?>
                    </div>

                    <div class="swiper-pagination"></div>
                </div>
            </div>
            
            <!-- Right Image -->
            <div class="col-md-6" data-aos="fade-left" data-aos-delay="200">
                <?php
                $testimonials_image = get_option('central_build_testimonials_image');
                if ($testimonials_image) : ?>
                    <img
                         alt="<?php esc_attr_e('Testimonials Image', 'central-build'); ?>" 
                         src="<?php echo esc_url($testimonials_image); ?>" 
                         loading="lazy" 
                         class="autofit-3 responsive-full-width" data-aos="zoom-in" data-aos-delay="260">
                <?php endif; ?>
            </div>
            
        </div>
    </div>
</section>

<!-- Initialize Swiper -->
<script>
    new Swiper(".mySwiper", {
        loop: true,
        autoplay: {
            delay: 3000, // Chuyển động liên tục (0ms để mượt mà)
        },
        speed: 3500, // Tốc độ chuyển động (5 giây cho 1 slide)
        pagination: {
            el: ".swiper-pagination",
        },
        spaceBetween: 30,
    });
  </script>
