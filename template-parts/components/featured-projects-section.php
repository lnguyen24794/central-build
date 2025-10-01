<!-- Featured Projects / Process Section -->
<section class="about-one-section-four">
    <div class="w-layout-blockcontainer life-to-vision-container w-container">
        
        <!-- Section Header -->
        <div data-w-id="0e331148-2df2-4cc1-ea98-909bd35be7ea" class="w-layout-vflex helping-flex left-align">
            <h2 class="text-white mobile-text-left tab-text-left">
                <?php
                $projects_title = get_option('central_build_projects_title', __('Start Your Fitout Journey Today', 'central-build'));
                echo esc_html($projects_title);
                ?>
            </h2>
            <p class="text-light-grey margin-top-twenty paragraph-subtext">
                <?php
                $projects_subtitle = get_option('central_build_projects_subtitle', __('Don\'t Fit in with your Average Fitout.', 'central-build'));
                echo esc_html($projects_subtitle);
                ?>
            </p>
        </div>
        
        <!-- Process Steps & Images -->
        <div class="w-layout-hflex about-one-focused-block">
            
            <!-- Left - Process Steps -->
            <div class="about-one-focused-left">
                
                <?php
                $process_steps = central_build_get_process_steps();
                if (!empty($process_steps)) :
                    foreach ($process_steps as $i => $step) :
                        if (!empty($step['title'])) :
                            $border_class = ($i == (count($process_steps) - 1)) ? 'focused-no-bottom-border' : '';
                ?>
                    <div data-w-id="process-step-<?php echo $i + 1; ?>" class="focused-icon-block <?php echo $border_class; ?>">
                        <div class="focused-icon-left margin-top-ten">
                            <?php if (!empty($step['icon'])) : ?>
                                <img src="<?php echo esc_url($step['icon']); ?>" 
                                     alt="<?php echo esc_attr($step['title']); ?> Icon" 
                                     class="autofit">
                            <?php endif; ?>
                        </div>
                        <div class="focused-text-right">
                            <div class="heading-five text-white">
                                <?php echo esc_html($step['title']); ?>
                            </div>
                            <p class="margin-top-fifteen text-light-grey">
                                <?php echo esc_html($step['description']); ?>
                            </p>
                        </div>
                    </div>
                <?php 
                        endif;
                    endforeach;
                endif;
                ?>
                
            </div>
            
            <!-- Right - Project Images -->
            <div class="about-one-focused-right">
                <?php
                $project_images = central_build_get_project_images();
                if (!empty($project_images)) :
                    foreach ($project_images as $i => $image) :
                        if (!empty($image['image'])) :
                            $opacity_style = ($i == 0) ? 'opacity: 1;' : 'opacity: 0;';
                            $image_class = "about-one-focused-image-" . ($i == 0 ? 'one' : ($i == 1 ? 'two' : 'three'));
                            $alt_text = $image['alt'] ?? __('Central Build project team on site at commercial fitout', 'central-build');
                ?>
                    <div style="<?php echo $opacity_style; ?>" class="<?php echo $image_class; ?>">
                        <img src="<?php echo esc_url($image['image']); ?>" 
                             alt="<?php echo esc_attr($alt_text); ?>" 
                             <?php echo ($i > 0) ? 'loading="lazy"' : ''; ?>
                             class="autofit responsive-full-width">
                    </div>
                <?php 
                        endif;
                    endforeach;
                endif;
                ?>
            </div>
            
        </div>
        
        <!-- CTA Button -->
        <?php
        $projects_button_text = get_option('central_build_projects_button_text', __('Start Today!', 'central-build'));
        $projects_button_subtext = get_option('central_build_projects_button_subtext', __('Learn more', 'central-build'));
        $projects_button_url = get_option('central_build_projects_button_url', home_url('/contact'));
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
                $stats = central_build_get_stats();
                if (!empty($stats)) :
                    $first_row_stats = array_slice($stats, 0, 2);
                    foreach ($first_row_stats as $stat) :
                        if (!empty($stat['number']) && !empty($stat['label'])) :
                ?>
                    <div class="about-one-counter-box">
                        <div class="heading-three text-white margin-none">
                            <?php echo esc_html($stat['number']); ?>
                        </div>
                        <div class="margin-top-fifteen text-light-grey text-captalize">
                            <?php echo esc_html($stat['label']); ?>
                        </div>
                    </div>
                <?php 
                        endif;
                    endforeach;
                endif;
                ?>
            </div>
            
            <!-- Second Row Stats -->
            <div class="about-one-counter-block-small">
                <?php
                $stats = central_build_get_stats();
                if (!empty($stats)) :
                    $second_row_stats = array_slice($stats, 2, 2);
                    foreach ($second_row_stats as $index => $stat) :
                        if (!empty($stat['number']) && !empty($stat['label'])) :
                            $border_class = ($index == 1) ? 'no-left-border' : '';
                ?>
                    <div class="about-one-counter-box <?php echo $border_class; ?>">
                        <div class="heading-three text-white margin-none">
                            <?php echo esc_html($stat['number']); ?>
                        </div>
                        <div class="margin-top-fifteen text-light-grey text-captalize">
                            <?php echo esc_html($stat['label']); ?>
                        </div>
                    </div>
                <?php 
                        endif;
                    endforeach;
                endif;
                ?>
            </div>
            
        </div>
        
    </div>
</section>