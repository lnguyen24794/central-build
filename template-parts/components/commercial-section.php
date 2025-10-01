<!-- Commercial Fitout Sectors Section -->
<section class="home-three-section-two" data-aos="fade-up" data-aos-duration="800">
    <div class="container">
        <div class="w-layout-hflex heading-box" data-aos="fade-down" data-aos-delay="100">
            <h2 class="nz-div-6">
                <span class="title-holder">
                <?php
                    $commercial_title = get_option('central_build_commercial_title', __('Commercial Fitout Sectors', 'central-build'));
                    echo esc_html($commercial_title);
                ?>
                </span>
            </h2>
        </div>
        <div class="project-grid-item" data-aos="fade-up" data-aos-delay="150">
            <div class="project-accodian">
                <?php
                $sectors = central_build_get_sectors();
                if (!empty($sectors)) :
                    foreach ($sectors as $i => $sector) :
                        if (!empty($sector['title'])) :
                            $delay = 200 + ($i * 80);
                ?>
                <div class="project-accodian-item" data-aos="fade-up" data-aos-delay="<?php echo esc_attr($delay); ?>">
                    <div class="w-layout-hflex project-card-wrap">
                        <div class="home-three-costruction-flex">
                            <div class="construction-heading-block">
                                <?php if (!empty($sector['icon'])) : ?>
                                    <img src="<?php echo esc_url($sector['icon']); ?>" alt="<?php echo esc_attr($sector['title']); ?> Icon" class="home-three-card-icon">
                                <?php endif; ?>
                                <div class="w-layout-vflex">
                                    <div class="contruction-tag">
                                        <?php echo esc_html($sector['tag'] ?? __('Sector', 'central-build')); ?>
                                    </div>
                                    <h3 class="margin-bottom-zero heading-five margin-none">
                                        <?php echo esc_html($sector['title']); ?>
                                    </h3>
                                </div>
                            </div>
                            <div class="construction-text-block">
                                <p class="margin-bottom-zero">
                                    <?php echo esc_html($sector['description'] ?? ''); ?>
                                </p>
                            </div>
                        </div>
                        <?php if (!empty($sector['image'])) : ?>
                        <div class="w-layout-hflex project-accodian-image" data-aos="zoom-in" data-aos-delay="<?php echo esc_attr($delay + 50); ?>">
                            <img src="<?php echo esc_url($sector['image']); ?>" alt="<?php echo esc_attr($sector['image_alt'] ?? $sector['title']); ?>" class="autofit project-card-image" loading="lazy">
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="project-card-background"></div>
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
