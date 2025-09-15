<!-- Commercial Projects Section -->
<section class="home-one-construction-section-2">
    
    <!-- Section Header -->
    <div class="w-layout-blockcontainer container-one-2 w-container">
        <div class="successful-block">
            <div data-w-id="31d09677-814c-2329-e6d4-723af0afa020" class="heading-wrapper wrapper-two">
                <div class="new-tag-wrap padding-none">
                    <div class="tag-3">
                        <?php
                        $commercial_tag = get_theme_mod('central_build_commercial_tag', __('Service', 'central-build'));
                        echo esc_html($commercial_tag);
                        ?>
                    </div>
                </div>
                <div class="heading-effect position-relative overflow-hidden rotating-tag-two">
                    <h2 class="margin-none text-white home-three-project-heading">
                        <?php
                        $commercial_title = get_theme_mod('central_build_commercial_title', __('Check out <br>our latest work', 'central-build'));
                        echo wp_kses($commercial_title, array('br' => array()));
                        ?>
                    </h2>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Projects Gallery -->
    <div data-w-id="31d09677-814c-2329-e6d4-723af0afa029" class="w-layout-blockcontainer home-three-project-container w-container">
        <div class="about-one-delicious-scrolling-block">
            <div class="about-one-scrolling-block">
                <div class="about-one-scrolling-wrapper">
                    
                    <!-- First Row of Projects -->
                    <div class="item-two">
                        <?php
                        // Get first 4 projects from customizer
                        for ($i = 1; $i <= 4; $i++) {
                            $project_image = get_theme_mod("central_build_commercial_project_{$i}_image");
                            $project_title = get_theme_mod("central_build_commercial_project_{$i}_title");
                            $project_url = get_theme_mod("central_build_commercial_project_{$i}_url", '#');
                            $project_alt = get_theme_mod("central_build_commercial_project_{$i}_alt", $project_title);
                            
                            if ($project_image && $project_title) :
                        ?>
                            <a data-w-id="commercial-project-<?php echo $i; ?>" 
                               href="<?php echo esc_url($project_url); ?>" 
                               class="project-card-two w-inline-block">
                                <div class="project-card-2">
                                    <img class="home-three-project-img-2" 
                                         src="<?php echo esc_url($project_image); ?>" 
                                         width="780" 
                                         height="1120" 
                                         alt="<?php echo esc_attr($project_alt); ?>" 
                                         loading="lazy">
                                    <div class="project-overlay"></div>
                                </div>
                                <div class="home-three-project-text-box">
                                    <img width="27" height="27" 
                                         alt="<?php esc_attr_e('Arrow Icon', 'central-build'); ?>" 
                                         src="<?php echo esc_url(get_template_directory_uri() . '/images/white-arrow.svg'); ?>" 
                                         class="autofit-2">
                                    <div class="heading-four-2 text-white">
                                        <?php echo esc_html($project_title); ?>
                                    </div>
                                </div>
                            </a>
                        <?php 
                            endif;
                        }
                        ?>
                    </div>
                    
                    <!-- Second Row of Projects -->
                    <div class="item-two">
                        <?php
                        // Get next 4 projects from customizer (5-8)
                        for ($i = 5; $i <= 8; $i++) {
                            $project_image = get_theme_mod("central_build_commercial_project_{$i}_image");
                            $project_title = get_theme_mod("central_build_commercial_project_{$i}_title");
                            $project_url = get_theme_mod("central_build_commercial_project_{$i}_url", '#');
                            $project_alt = get_theme_mod("central_build_commercial_project_{$i}_alt", $project_title);
                            
                            if ($project_image && $project_title) :
                        ?>
                            <a data-w-id="commercial-project-<?php echo $i; ?>" 
                               href="<?php echo esc_url($project_url); ?>" 
                               class="project-card-two w-inline-block">
                                <div class="project-card-2">
                                    <img class="home-three-project-img-2" 
                                         src="<?php echo esc_url($project_image); ?>" 
                                         width="780" 
                                         height="1120" 
                                         alt="<?php echo esc_attr($project_alt); ?>" 
                                         loading="lazy">
                                    <div class="project-overlay"></div>
                                </div>
                                <div class="home-three-project-text-box">
                                    <img width="27" height="27" 
                                         alt="<?php esc_attr_e('Arrow Icon', 'central-build'); ?>" 
                                         src="<?php echo esc_url(get_template_directory_uri() . '/images/white-arrow.svg'); ?>" 
                                         class="autofit-2">
                                    <div class="heading-four-2 text-white">
                                        <?php echo esc_html($project_title); ?>
                                    </div>
                                </div>
                            </a>
                        <?php 
                            endif;
                        }
                        ?>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    
</section>
