<!-- Featured Projects / Process Section -->
<section class="about-one-section-four">
    <div class="w-layout-blockcontainer life-to-vision-container w-container">
        
        <!-- Section Header -->
        <div data-w-id="0e331148-2df2-4cc1-ea98-909bd35be7ea" class="w-layout-vflex helping-flex left-align">
            <h2 class="text-white mobile-text-left tab-text-left">
                <?php
                $projects_title = get_theme_mod('central_build_projects_title', __('Start Your Fitout Journey Today', 'central-build'));
                echo esc_html($projects_title);
                ?>
            </h2>
            <p class="text-light-grey margin-top-twenty paragraph-subtext">
                <?php
                $projects_subtitle = get_theme_mod('central_build_projects_subtitle', __('Don\'t Fit in with your Average Fitout.', 'central-build'));
                echo esc_html($projects_subtitle);
                ?>
            </p>
        </div>
        
        <!-- Process Steps & Images -->
        <div class="w-layout-hflex about-one-focused-block">
            
            <!-- Left - Process Steps -->
            <div class="about-one-focused-left">
                
                <?php
                // Get process steps from customizer
                for ($i = 1; $i <= 3; $i++) {
                    $step_icon = get_theme_mod("central_build_process_step_{$i}_icon");
                    $step_title = get_theme_mod("central_build_process_step_{$i}_title");
                    $step_description = get_theme_mod("central_build_process_step_{$i}_description");
                    
                    if ($step_title) :
                        $border_class = ($i == 3) ? 'focused-no-bottom-border' : '';
                ?>
                    <div data-w-id="process-step-<?php echo $i; ?>" class="focused-icon-block <?php echo $border_class; ?>">
                        <div class="focused-icon-left margin-top-ten">
                            <?php if ($step_icon) : ?>
                                <img src="<?php echo esc_url($step_icon); ?>" 
                                     alt="<?php echo esc_attr($step_title); ?> Icon" 
                                     class="autofit">
                            <?php endif; ?>
                        </div>
                        <div class="focused-text-right">
                            <div class="heading-five text-white">
                                <?php echo esc_html($step_title); ?>
                            </div>
                            <p class="margin-top-fifteen text-light-grey">
                                <?php echo esc_html($step_description); ?>
                            </p>
                        </div>
                    </div>
                <?php 
                    endif;
                }
                ?>
                
            </div>
            
            <!-- Right - Project Images -->
            <div class="about-one-focused-right">
                <?php
                // Get project images from customizer
                for ($i = 1; $i <= 3; $i++) {
                    $project_image = get_theme_mod("central_build_project_image_{$i}");
                    $project_alt = get_theme_mod("central_build_project_image_{$i}_alt", __('ENP Fitouts project team on site at commercial fitout', 'central-build'));
                    
                    if ($project_image) :
                        $opacity_style = ($i == 1) ? 'opacity: 1;' : 'opacity: 0;';
                        $image_class = "about-one-focused-image-" . ($i == 1 ? 'one' : ($i == 2 ? 'two' : 'three'));
                ?>
                    <div style="<?php echo $opacity_style; ?>" class="<?php echo $image_class; ?>">
                        <img src="<?php echo esc_url($project_image); ?>" 
                             alt="<?php echo esc_attr($project_alt); ?>" 
                             <?php echo ($i > 1) ? 'loading="lazy"' : ''; ?>
                             class="autofit responsive-full-width">
                    </div>
                <?php 
                    endif;
                }
                ?>
            </div>
            
        </div>
        
        <!-- CTA Button -->
        <?php
        $projects_button_text = get_theme_mod('central_build_projects_button_text', __('Start Today!', 'central-build'));
        $projects_button_subtext = get_theme_mod('central_build_projects_button_subtext', __('Learn more', 'central-build'));
        $projects_button_url = get_theme_mod('central_build_projects_button_url', home_url('/contact'));
        ?>
        <a href="<?php echo esc_url($projects_button_url); ?>" role="button" class="hero-button w-inline-block">
            <div class="button-mask">
                <div class="link-text-wrp">
                    <div><?php echo esc_html($projects_button_text); ?></div>
                    <div class="secondt-btn-text"><?php echo esc_html($projects_button_subtext); ?></div>
                </div>
            </div>
        </a>
        
        <!-- Statistics Counter -->
        <div class="w-layout-hflex about-one-counter-block">
            
            <!-- First Row Stats -->
            <div class="about-one-counter-block-small">
                <?php
                // Get stats from customizer
                for ($i = 1; $i <= 2; $i++) {
                    $stat_number = get_theme_mod("central_build_stat_{$i}_number");
                    $stat_label = get_theme_mod("central_build_stat_{$i}_label");
                    
                    if ($stat_number && $stat_label) :
                ?>
                    <div class="about-one-counter-box">
                        <div class="heading-three text-white margin-none">
                            <?php echo esc_html($stat_number); ?>
                        </div>
                        <div class="margin-top-fifteen text-light-grey text-captalize">
                            <?php echo esc_html($stat_label); ?>
                        </div>
                    </div>
                <?php 
                    endif;
                }
                ?>
            </div>
            
            <!-- Second Row Stats -->
            <div class="about-one-counter-block-small">
                <?php
                // Get stats 3 and 4 from customizer
                for ($i = 3; $i <= 4; $i++) {
                    $stat_number = get_theme_mod("central_build_stat_{$i}_number");
                    $stat_label = get_theme_mod("central_build_stat_{$i}_label");
                    
                    if ($stat_number && $stat_label) :
                        $border_class = ($i == 4) ? 'no-left-border' : '';
                ?>
                    <div class="about-one-counter-box <?php echo $border_class; ?>">
                        <div class="heading-three text-white margin-none">
                            <?php echo esc_html($stat_number); ?>
                        </div>
                        <div class="margin-top-fifteen text-light-grey text-captalize">
                            <?php echo esc_html($stat_label); ?>
                        </div>
                    </div>
                <?php 
                    endif;
                }
                ?>
            </div>
            
        </div>
        
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="w-layout-blockcontainer container-one cta-container w-container">
        
        <!-- CTA Content -->
        <div class="cta">
            <h3 class="color-white margin-bottom-twenty">
                <?php
                $cta_title = get_theme_mod('central_build_cta_title', __('Fitouts Shouldn\'t Be This Hard', 'central-build'));
                echo esc_html($cta_title);
                ?>
            </h3>
            <p class="cta-text">
                <?php
                $cta_description = get_theme_mod(
                    'central_build_cta_description',
                    __('Overwhelmed trying to manage every part of your fitout? From designs to trades, certifications, and approvals, it adds up fast.<br>We take care of it all. You\'ll have one experienced team, one point of contact, and a clear, structured plan to follow.<br>Have a space that\'s done right, ready to use, and built to support your business from day one.', 'central-build')
                );
                echo wp_kses($cta_description, array('br' => array()));
                ?>
            </p>
            
            <?php
            $cta_button_text = get_theme_mod('central_build_cta_button_text', __('Start Today!', 'central-build'));
            $cta_button_subtext = get_theme_mod('central_build_cta_button_subtext', __('Learn more', 'central-build'));
            $cta_button_url = get_theme_mod('central_build_cta_button_url', home_url('/contact'));
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
        $cta_background_image = get_theme_mod('central_build_cta_background_image');
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
