<!-- FAQ Transform Section -->
<section class="home-one-faq-section-copy">
    <div class="w-layout-blockcontainer container-one-2 w-container">
        <div class="w-layout-hflex freely-ask-flex-2">
            <div class="freely-ask-right-2">
                
                <!-- Section Header -->
                <div class="w-layout-hflex heading-box-3">
                    <div class="tag-wrap tag-type-five right-side-tag"></div>
                    <h2 class="heading-wrap margin-none header-to-the-right">
                        <?php
                        $transform_title = get_theme_mod('central_build_transform_title', __('Ready to Transform Your space?', 'central-build'));
                        echo esc_html($transform_title);
                        ?>
                    </h2>
                </div>
                
                <!-- Transform Features -->
                <?php
                // Get transform features from customizer
                for ($i = 1; $i <= 3; $i++) {
                    $feature_icon = get_theme_mod("central_build_transform_feature_{$i}_icon");
                    $feature_title = get_theme_mod("central_build_transform_feature_{$i}_title");
                    $feature_description = get_theme_mod("central_build_transform_feature_{$i}_description");
                    
                    if ($feature_title && $feature_description) :
                        $margin_class = ($i == 3) ? 'margin-bottom-none' : 'freely-text-flex-margin';
                ?>
                    <div class="w-layout-hflex freely-text-flex <?php echo $margin_class; ?>">
                        <?php if ($feature_icon) : ?>
                            <img width="30" height="30" 
                                 alt="<?php echo esc_attr($feature_title); ?> Icon" 
                                 src="<?php echo esc_url($feature_icon); ?>" 
                                 class="autofit-3">
                        <?php else : ?>
                            <img width="30" height="30" 
                                 alt="<?php esc_attr_e('Feature Icon', 'central-build'); ?>" 
                                 src="<?php echo esc_url(get_template_directory_uri() . '/images/freely-icon.svg'); ?>" 
                                 class="autofit-3">
                        <?php endif; ?>
                        
                        <p class="margin-bottom-zero-3">
                            <strong class="bold-text"><?php echo esc_html($feature_title); ?>:</strong> 
                            <?php echo wp_kses($feature_description, array('br' => array())); ?>
                        </p>
                    </div>
                <?php 
                    endif;
                }
                ?>
                
                <!-- CTA Button -->
                <?php
                $transform_button_text = get_theme_mod('central_build_transform_button_text', __('Check out our Portfolio', 'central-build'));
                $transform_button_subtext = get_theme_mod('central_build_transform_button_subtext', __('Learn more', 'central-build'));
                $transform_button_url = get_theme_mod('central_build_transform_button_url', home_url('/contact'));
                ?>
                <a href="<?php echo esc_url($transform_button_url); ?>" role="button" class="faq-hero-button w-inline-block">
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
