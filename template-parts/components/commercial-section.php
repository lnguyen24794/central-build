<!-- Fitout Projects Section -->
<section class="home-one-construction-section-2 ">
    <div class="container">
        <!-- Section Header -->
        <div class="row gap-3" data-aos="fade-down" data-aos-duration="1000">
            <div class="p-0 p relative" style="width: 30px">
                <div class="tag-wrap w-100 absolute" style="top: 70px; left: -20px;">
                    <div class="tag-2-different dark-tab">
                        <?php
                        $commercial_tag = get_option('central_build_commercial_tag', __('Service', 'central-build'));
                        echo esc_html($commercial_tag);
                        ?>
                    </div>
                </div>
            </div>
            <div class="col">
                <h2 class="home-three-testimonial-heading text-white margin-none">
                    <?php
                    $commercial_title = get_option('central_build_commercial_title', __('Check out <br>our latest work', 'central-build'));
                        echo wp_kses($commercial_title, array('br' => array()));
                        ?>
                </h2>
            </div>
        </div>
        
        <!-- Fitout Projects Carousel -->
        <div class="w-layout-blockcontainer home-three-project-container w-container" data-aos="fade-up" data-aos-duration="1200" data-aos-delay="200">
            <div class="fitout-carousel-container">
                <div class="fitout-carousel-track">
                    <?php
                        $fitout_projects = central_build_get_fitout_projects(12);
                        if (!empty($fitout_projects)) :
                            // Duplicate projects for seamless loop
                            $all_projects = array_merge($fitout_projects, $fitout_projects);
                            foreach ($all_projects as $project) :
                                if (!empty($project['image']) && !empty($project['title'])) :
                                    ?>
                        <div class="fitout-project-card">
                            <a href="<?php echo esc_url($project['url']); ?>" class="project-card-two w-inline-block">
                                <div class="project-card-2">
                                    <img class="home-three-project-img-2" 
                                        src="<?php echo esc_url($project['image']); ?>" 
                                        width="780" 
                                        height="1120" 
                                        alt="<?php echo esc_attr($project['alt']); ?>" 
                                        loading="lazy">
                                    <div class="project-overlay"></div>
                                </div>
                                <div class="home-three-project-text-box">
                                    <div class="heading-four-2 text-white">
                                        <?php echo esc_html($project['title']); ?>
                                    </div>
                                    <?php if (!empty($project['category'])) : ?>
                                    <div class="project-category text-white" style="font-size: 14px; opacity: 0.8; margin-top: 5px;">
                                        <?php echo esc_html($project['category']); ?>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </a>
                        </div>
                    <?php
                                endif;
                            endforeach;
                        else :
                            ?>
                        <!-- Fallback content if no fitout projects exist -->
                        <div class="fitout-project-card">
                            <div class="project-card-two">
                                <div class="project-card-2">
                                    <img class="home-three-project-img-2" 
                                        src="https://cdn.prod.website-files.com/66f1ffebdef9310969f57940/66f1ffecdef9310969f579c4_Image-Bg-Section.webp" 
                                        width="780" 
                                        height="1120" 
                                        alt="Sample Fitout Project" 
                                        loading="lazy">
                                    <div class="project-overlay"></div>
                                </div>
                                <div class="home-three-project-text-box">
                                    <div class="heading-four-2 text-white">
                                        Sample Fitout Project
                                    </div>
                                    <div class="project-category text-white" style="font-size: 14px; opacity: 0.8; margin-top: 5px;">
                                        Hospitality Fitout
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <!-- View All Projects Button -->
        <div class="text-center mt-4">
            <a href="<?php echo esc_url(get_post_type_archive_link('fitout_sector')); ?>" 
            class="hero-button w-inline-block" 
            style="display: inline-block; margin-top: 30px;">
                <div class="button-mask">
                    <div class="link-text-wrp">
                        <div><?php _e('View All Projects', 'central-build'); ?></div>
                        <div class="secondt-btn-text"><?php _e('View All Projects', 'central-build'); ?></div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    
</section>
