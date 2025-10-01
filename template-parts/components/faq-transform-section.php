<!-- FAQ Transform Section -->
<section class="home-one-faq-section-copy" data-aos="fade-up" data-aos-duration="800">
    <div class="my-container container">
        <div class="w-layout-hflex freely-ask-flex-2">
            <div class="freely-ask-right-2" data-aos="fade-left" data-aos-delay="120">
                
                <!-- Section Header -->
                <div class="w-layout-hflex heading-box-3" data-aos="fade-down" data-aos-delay="150">
                    <div class="tag-wrap tag-type-five right-side-tag"></div>
                    <h2 class="heading-wrap margin-none header-to-the-right">
                        <?php
                        $transform_title = get_option('central_build_transform_title', __('Ready to Transform Your space?', 'central-build'));
                        echo esc_html($transform_title);
                        ?>
                    </h2>
                </div>
                
                <!-- Transform Features -->
                <?php
                $transform_features = central_build_get_transform_features();
                if (!empty($transform_features)) :
                    foreach ($transform_features as $i => $feature) :
                        if (!empty($feature['title']) && !empty($feature['description'])) :
                            $margin_class = ($i == (count($transform_features) - 1)) ? 'margin-bottom-none' : 'freely-text-flex-margin';
                            $delay = 180 + ($i * 60);
                ?>
                    <div class="w-layout-hflex freely-text-flex <?php echo $margin_class; ?>" data-aos="fade-up" data-aos-delay="<?php echo esc_attr($delay); ?>">
                        <?php if (!empty($feature['icon'])) : ?>
                            <img width="30" height="30" 
                                 alt="<?php echo esc_attr($feature['title']); ?> Icon" 
                                 src="<?php echo esc_url($feature['icon']); ?>" 
                                 class="autofit-3">
                        <?php else : ?>
                            <img width="30" height="30" 
                                 alt="<?php esc_attr_e('Feature Icon', 'central-build'); ?>" 
                                 src="<?php echo esc_url(get_template_directory_uri() . '/images/freely-icon.svg'); ?>" 
                                 class="autofit-3">
                        <?php endif; ?>
                        
                        <p class="margin-bottom-zero-3">
                            <strong class="bold-text"><?php echo esc_html($feature['title']); ?>:</strong> 
                            <?php echo wp_kses($feature['description'], array('br' => array())); ?>
                        </p>
                    </div>
                <?php 
                        endif;
                    endforeach;
                endif;
                ?>
                
                <!-- CTA Button -->
                <?php
                $transform_button_text = get_option('central_build_transform_button_text', __('Check out our Portfolio', 'central-build'));
                $transform_button_subtext = get_option('central_build_transform_button_subtext', __('Learn more', 'central-build'));
                $transform_button_url = get_option('central_build_transform_button_url', home_url('/contact'));
                ?>
                <a href="<?php echo esc_url($transform_button_url); ?>" role="button" class="hero-button w-inline-block" data-aos="fade-up" data-aos-delay="300">
                    <div class="button-mask">
                        <div class="link-text-wrp">
                            <div><?php echo esc_html($transform_button_text); ?></div>
                            <div class="secondt-btn-text"><?php echo esc_html($transform_button_subtext); ?></div>
                        </div>
                    </div>
                </a>
                
            </div>
        </div>
    </div>
</section>
