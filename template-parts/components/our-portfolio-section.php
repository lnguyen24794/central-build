<!-- Our Portfolio/Fitout Sectors Section -->
<section class="home-three-section-two-2">
    
   <div class="container">
        <!-- Section Header -->
        <div class="my-container">
            <div class="home-two-mid-icon-block-2">
                <?php
                $checkout_icon = get_option('central_build_checkout_icon');
                if ($checkout_icon) : ?>
                    <img width="66" height="83" 
                        alt="<?php esc_attr_e('Section Icon', 'central-build'); ?>" 
                        src="<?php echo esc_url($checkout_icon); ?>">
                <?php else : ?>
                    <img width="66" height="83" 
                        alt="<?php esc_attr_e('Innovation Icon', 'central-build'); ?>" 
                        src="<?php echo esc_url(get_template_directory_uri() . '/images/innovation-icon.svg'); ?>">
                <?php endif; ?>
                
                <div class="large-visible-desktop-hidden home-three-construction-heading">
                    <h2 class="heading">
                        <?php
                        $checkout_title = get_option('central_build_checkout_title', __('Commercial Fitout Sectors', 'central-build'));
                        echo esc_html($checkout_title);
                        ?>
                    </h2>
                </div>
            </div>
        </div>
        
        <!-- Portfolio/Sectors Grid -->
        <div class="project-grid-item">
            <div class="w-layout-vflex project-card-main-wrap">
                
                <?php
                $sectors = central_build_get_sectors();
                if (!empty($sectors)) :
                    foreach ($sectors as $i => $sector) :
                        if (!empty($sector['title'])) :
                            $active_class = ($i == 0) ? 'active' : '';
                            $opacity_style = ($i == 0) ? 'opacity: 1;' : 'opacity: 0;';
                            $line_opacity = ($i == 0) ? 'opacity: 0;' : 'opacity: 1;';
                            $line_class = ($i <= 0) ? 'one' : (($i <= 2) ? 'two' : 'three');
                            $data_w_id = ($i > 0) ? 'data-w-id="' . uniqid('portfolio-item-') . '"' : '';
                ?>
                    <div <?php echo $data_w_id; ?> class="project-accodian-item <?php echo $active_class; ?>">
                        <div class="w-layout-hflex project-card-wrap">
                            
                            <!-- Sector Content -->
                            <a href="<?php echo esc_url($sector['url'] ?? '#'); ?>" class="home-three-costruction-flex w-inline-block">
                                <div class="construction-heading-block">
                                    <?php if (!empty($sector['icon'])) : ?>
                                        <img src="<?php echo esc_url($sector['icon']); ?>" 
                                            loading="lazy" 
                                            width="47" 
                                            height="46" 
                                            alt="<?php echo esc_attr($sector['title']); ?> Icon" 
                                            class="home-three-card-icon">
                                    <?php endif; ?>
                                    
                                    <div class="w-layout-vflex">
                                        <?php if (!empty($sector['tag'])) : ?>
                                            <div class="contruction-tag">
                                                <?php echo esc_html($sector['tag']); ?>
                                            </div>
                                        <?php endif; ?>
                                        <h3 class="margin-bottom-zero heading-five margin-none">
                                            <?php echo esc_html($sector['title']); ?>
                                        </h3>
                                    </div>
                                </div>
                                
                                <?php if (!empty($sector['description'])) : ?>
                                    <div class="construction-text-block">
                                        <p class="margin-bottom-zero">
                                            <?php echo wp_kses($sector['description'], array('br' => array())); ?>
                                        </p>
                                    </div>
                                <?php endif; ?>
                            </a>
                            
                            <!-- Sector Image -->
                            <?php if (!empty($sector['image'])) : ?>
                                <div class="w-layout-hflex project-accodian-image">
                                    <a href="<?php echo esc_url($sector['url'] ?? '#'); ?>" class="<?php echo ($i == 0) ? 'link-block-2 ' : ''; ?>w-inline-block">
                                        <img class="autofit project-card-image <?php echo $active_class; ?>" 
                                            src="<?php echo esc_url($sector['image']); ?>" 
                                            width="440" 
                                            height="200" 
                                            alt="<?php echo esc_attr($sector['image_alt'] ?? $sector['title']); ?>" 
                                            loading="lazy"
                                            <?php if ($i == 0) : ?>
                                            style="transform: translate3d(0px, 0px, 0px) scale3d(1.09, 1.09, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg, 0deg); transform-style: preserve-3d;"
                                            <?php else : ?>
                                            style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg, 0deg); transform-style: preserve-3d;"
                                            <?php endif; ?>
                                            sizes="(max-width: 479px) 100vw, 440px">
                                    </a>
                                </div>
                            <?php endif; ?>
                            
                        </div>
                        
                        <!-- Background and Lines -->
                        <div style="<?php echo $opacity_style; ?>" class="project-card-background <?php echo $active_class; ?>"></div>
                        <div style="<?php echo $line_opacity; ?>" class="line-<?php echo $line_class; ?>"></div>
                    </div>
                <?php 
                        endif;
                    endforeach;
                endif;
                ?>
                
            </div>
            
            <!-- CTA Button -->
            <?php
            $checkout_button_text = get_option('central_build_checkout_button_text', __('Check out our Portfolio', 'central-build'));
            $checkout_button_subtext = get_option('central_build_checkout_button_subtext', __('Learn more', 'central-build'));
            $checkout_button_url = get_option('central_build_checkout_button_url', home_url('/contact'));
            ?>
            <a href="<?php echo esc_url($checkout_button_url); ?>" 
            role="button" 
            data-w-id="2e6f549c-b1ce-c583-ccf2-c3472985986c" 
            class="hero-button w-inline-block">
                <div class="button-mask">
                    <div style="transform: translate3d(0px, 0%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg, 0deg); transform-style: preserve-3d;" 
                        class="link-text-wrp">
                        <div><?php echo esc_html($checkout_button_text); ?></div>
                        <div class="secondt-btn-text"><?php echo esc_html($checkout_button_subtext); ?></div>
                    </div>
                </div>
            </a>
            
        </div>
   </div>
    
</section>
