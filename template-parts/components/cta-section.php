<!-- CTA Section -->
<section class="home-three-cta-section" data-aos="fade-up" data-aos-duration="800">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-7" data-aos="fade-right" data-aos-delay="120">
                <h2 class="cta-heading">
                    <?php
                    $cta_heading = get_option('central_build_cta_heading', __('Ready to Start Your Project with Central Build?', 'central-build'));
                    echo esc_html($cta_heading);
                    ?>
                </h2>
                <p class="cta-description" data-aos="fade-up" data-aos-delay="160">
                    <?php
                    $cta_description = get_option('central_build_cta_description', __('Our integrated delivery model gives you unmatched control, transparency, and reliability from day one.', 'central-build'));
                    echo esc_html($cta_description);
                    ?>
                </p>
            </div>
            <div class="col-md-5 text-md-end" data-aos="fade-left" data-aos-delay="150">
                <?php
                $cta_button_text = get_option('central_build_cta_button_text', __('Request a Consultation', 'central-build'));
                $cta_button_url = get_option('central_build_cta_button_url', home_url('/contact'));
                ?>
                <a href="<?php echo esc_url($cta_button_url); ?>" class="btn cta-button" data-aos="zoom-in" data-aos-delay="200">
                    <?php echo esc_html($cta_button_text); ?>
                </a>
            </div>
        </div>
    </div>
</section>
