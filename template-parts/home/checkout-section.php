<!-- Fitout Sectors Section -->
<section class="home-three-section-two-2">
    
    <!-- Section Header -->
    <div class="w-layout-blockcontainer container-one-2 w-container">
        <div class="home-two-mid-icon-block-2">
            <?php
            $checkout_icon = get_theme_mod('central_build_checkout_icon');
            if ($checkout_icon) : ?>
                <img width="66" height="83" 
                     alt="<?php esc_attr_e('Section Icon', 'central-build'); ?>" 
                     src="<?php echo esc_url($checkout_icon); ?>">
            <?php endif; ?>
            
            <div class="large-visible-desktop-hidden home-three-construction-heading">
                <h2 class="heading">
                    <?php
                    $checkout_title = get_theme_mod('central_build_checkout_title', __('Commercial Fitout Sectors', 'central-build'));
                    echo esc_html($checkout_title);
                    ?>
                </h2>
            </div>
        </div>
    </div>
    
    <!-- Fitout Sectors Grid -->
    <div class="project-grid-item">
        <div class="w-layout-vflex project-card-main-wrap">
            
            <?php
            // Get fitout sectors from customizer
            for ($i = 1; $i <= 5; $i++) {
                $sector_icon = get_theme_mod("central_build_sector_{$i}_icon");
                $sector_tag = get_theme_mod("central_build_sector_{$i}_tag");
                $sector_title = get_theme_mod("central_build_sector_{$i}_title");
                $sector_description = get_theme_mod("central_build_sector_{$i}_description");
                $sector_image = get_theme_mod("central_build_sector_{$i}_image");
                $sector_image_alt = get_theme_mod("central_build_sector_{$i}_image_alt");
                $sector_url = get_theme_mod("central_build_sector_{$i}_url", '#');
                
                if ($sector_title) :
                    $active_class = ($i == 1) ? 'active' : '';
                    $opacity_style = ($i == 1) ? 'opacity: 1;' : 'opacity: 0;';
                    $line_opacity = ($i == 1) ? 'opacity: 0;' : 'opacity: 1;';
            ?>
                <div class="project-accodian-item <?php echo $active_class; ?>">
                    <div class="w-layout-hflex project-card-wrap">
                        
                        <!-- Sector Content -->
                        <a href="<?php echo esc_url($sector_url); ?>" class="home-three-costruction-flex w-inline-block">
                            <div class="construction-heading-block">
                                <?php if ($sector_icon) : ?>
                                    <img src="<?php echo esc_url($sector_icon); ?>" 
                                         loading="lazy" 
                                         alt="<?php echo esc_attr($sector_title); ?> Icon" 
                                         class="home-three-card-icon">
                                <?php endif; ?>
                                
                                <div class="w-layout-vflex">
                                    <?php if ($sector_tag) : ?>
                                        <div class="contruction-tag">
                                            <?php echo esc_html($sector_tag); ?>
                                        </div>
                                    <?php endif; ?>
                                    <h3 class="margin-bottom-zero heading-five margin-none">
                                        <?php echo esc_html($sector_title); ?>
                                    </h3>
                                </div>
                            </div>
                            
                            <?php if ($sector_description) : ?>
                                <div class="construction-text-block">
                                    <p class="margin-bottom-zero">
                                        <?php echo wp_kses($sector_description, array('br' => array())); ?>
                                    </p>
                                </div>
                            <?php endif; ?>
                        </a>
                        
                        <!-- Sector Image -->
                        <?php if ($sector_image) : ?>
                            <div class="w-layout-hflex project-accodian-image">
                                <a href="<?php echo esc_url($sector_url); ?>" class="w-inline-block">
                                    <img class="autofit project-card-image <?php echo $active_class; ?>" 
                                         src="<?php echo esc_url($sector_image); ?>" 
                                         width="440" 
                                         height="200" 
                                         alt="<?php echo esc_attr($sector_image_alt ? $sector_image_alt : $sector_title); ?>" 
                                         loading="lazy">
                                </a>
                            </div>
                        <?php endif; ?>
                        
                    </div>
                    
                    <!-- Background and Lines -->
                    <div style="<?php echo $opacity_style; ?>" class="project-card-background <?php echo $active_class; ?>"></div>
                    <div style="<?php echo $line_opacity; ?>" class="line-<?php echo ($i <= 1) ? 'one' : ($i <= 3 ? 'two' : 'three'); ?>"></div>
                </div>
            <?php 
                endif;
            }
            ?>
            
        </div>
        
        <!-- CTA Button -->
        <?php
        $checkout_button_text = get_theme_mod('central_build_checkout_button_text', __('Check out our Portfolio', 'central-build'));
        $checkout_button_subtext = get_theme_mod('central_build_checkout_button_subtext', __('Learn more', 'central-build'));
        $checkout_button_url = get_theme_mod('central_build_checkout_button_url', home_url('/contact'));
        ?>
        <a href="<?php echo esc_url($checkout_button_url); ?>" role="button" class="hero-button w-inline-block">
            <div class="button-mask">
                <div class="link-text-wrp">
                    <div><?php echo esc_html($checkout_button_text); ?></div>
                    <div class="secondt-btn-text"><?php echo esc_html($checkout_button_subtext); ?></div>
                </div>
            </div>
        </a>
        
    </div>
    
</section>
