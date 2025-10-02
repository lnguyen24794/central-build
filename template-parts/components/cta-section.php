<!-- CTA Section -->
<section class="cta-section">
    <div class="w-layout-blockcontainer container-one cta-container w-container">
        
        <!-- CTA Content -->
        <div class="cta" data-aos="zoom-in" data-aos-duration="1200">
            <h3 class="color-white margin-bottom-twenty">
                <?php
                $cta_title = get_option('central_build_cta_title', __('Fitouts Shouldn\'t Be This Hard', 'central-build'));
                echo esc_html($cta_title);
                ?>
            </h3>
            <p class="cta-text">
                <?php
                $cta_description = get_option(
                    'central_build_cta_description',
                    __('Overwhelmed trying to manage every part of your fitout? From designs to trades, certifications, and approvals, it adds up fast.<br>We take care of it all. You\'ll have one experienced team, one point of contact, and a clear, structured plan to follow.<br>Have a space that\'s done right, ready to use, and built to support your business from day one.', 'central-build')
                );
                echo wp_kses($cta_description, array('br' => array()));
                ?>
            </p>
            
            <?php
            $cta_button_text = get_option('central_build_cta_button_text', __('Start Today!', 'central-build'));
                $cta_button_subtext = get_option('central_build_cta_button_subtext', __('Learn more', 'central-build'));
                $cta_button_url = get_option('central_build_cta_button_url', home_url('/contact'));
                ?>
            <a href="<?php echo esc_url($cta_button_url); ?>" role="button" class="cta-hero-button w-inline-block">
                <div class="button-mask">
                    <div class="link-text-wrp">
                        <div><?php echo esc_html($cta_button_text); ?></div>
                        <div class="secondt-btn-text"><?php echo esc_html($cta_button_subtext); ?></div>
                    </div>
                </div>
            </a>
        </div>
        
        <!-- Background Image -->
        <?php
        $cta_background_image = get_option('central_build_cta_background_image');
                if ($cta_background_image) : ?>
            <img src="<?php echo esc_url($cta_background_image); ?>" 
                 loading="lazy" 
                 alt="<?php esc_attr_e('CTA Background', 'central-build'); ?>" 
                 class="image-5">
        <?php else : ?>
            <img src="<?php echo esc_url(get_template_directory_uri() . '/images/cta-default.jpg'); ?>" 
                 loading="lazy" 
                 alt="<?php esc_attr_e('CTA Background', 'central-build'); ?>" 
                 class="image-5">
        <?php endif; ?>
        
    </div>
    <div class="cta-overlay"></div>
</section>
