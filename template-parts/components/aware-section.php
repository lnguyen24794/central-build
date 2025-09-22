<!-- Problem Aware Section -->
<section class="problem-aware-section">
        <div class="container">
            <div class="home-one-why-us-flex">
                <div class="home-one-why-us-left">
                    <div class="image-hover-block">
                        <?php
                        $about_image = get_option('central_build_about_image');
                        if ($about_image) : ?>
                            <img src="<?php echo esc_url($about_image); ?>" alt="<?php esc_attr_e('Central Build team on site', 'central-build'); ?>" class="single-img hovered">
                        <?php else : ?>
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/images/about-image.jpg'); ?>" alt="<?php esc_attr_e('Central Build team on site', 'central-build'); ?>" class="single-img hovered">
                        <?php endif; ?>
                    </div>
                </div>
                <div class="home-one-why-us-right">
                    <div class="w-layout-hflex heading-box">
                        <h2 class="nz-div-6">
                            <span class="title-holder">
                            <?php
                                $about_title = get_option('central_build_about_title', __('Built on Expertise and Purpose', 'central-build'));
                                echo esc_html($about_title);
                            ?>
                            </span>
                        ?>
                        </h2>
                    </div>
                    <p class="way-us-paragraph margin-top-twenty">
                        <?php
                            $about_description = get_option(
                                'central_build_about_description',
                                __('With years of experience and a passion for excellence, we deliver tailored fit-out solutions designed to elevate your business. Our commitment to quality and purpose-driven results ensures your space not only meets but exceeds expectations.', 'central-build')
                            );
                        echo esc_html($about_description);
                        ?>
                    </p>
                    <div class="devider-one"></div>
                    
                    <!-- Features Grid -->
                    <?php
                    $about_features = central_build_get_about_features();
                        if (!empty($about_features)) :
                            $feature_chunks = array_chunk($about_features, 2);
                            foreach ($feature_chunks as $chunk) :
                                ?>
                        <div class="problem-aware-block">
                            <?php foreach ($chunk as $feature) : ?>
                                <div class="home-one-project-block">
                                    <div class="heading-six">
                                        <?php echo esc_html($feature['title'] ?? ''); ?>
                                    </div>
                                    <p class="home-one-way-us-paragraph">
                                        <?php echo esc_html($feature['description'] ?? ''); ?>
                                    </p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php
                            endforeach;
                        endif;
                        ?>
                </div>
            </div>
        </div>
        <div class="devider-one"></div>
        <a href="<?php echo esc_url(get_permalink(get_page_by_path('about'))); ?>" class="hero-button">
            <div class="button-mask">
                <div class="link-text-wrp">
                    <div><?php esc_html_e('Learn More About Us', 'central-build'); ?></div>
                    <div class="secondt-btn-text"><?php esc_html_e('Learn more', 'central-build'); ?></div>
                </div>
            </div>
        </a>
    </section>