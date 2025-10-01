<!-- Trust Process Section -->
<section class="home-two-our-promise-section" data-aos="fade-up" data-aos-duration="800">
    <div class="w-layout-blockcontainer container w-container">
        <div class="home-two-promise-top">
            <div class="promise-left" data-aos="fade-right" data-aos-delay="120">
                <div class="section-title" data-aos="fade-down" data-aos-delay="150">
                    <div class="section-tag">
                        <?php echo esc_html(get_option('central_build_trust_tag', __('Trusted Delivery', 'central-build'))); ?>
                    </div>
                    <h2 class="section-heading">
                        <?php echo esc_html(get_option('central_build_trust_title', __('What Sets Central Build Apart', 'central-build'))); ?>
                    </h2>
                </div>
                <p class="promise-description" data-aos="fade-up" data-aos-delay="180">
                    <?php echo esc_html(get_option('central_build_trust_description', __('From concept to completion, our vertically integrated team ensures quality, speed, and accountability at every step.', 'central-build'))); ?>
                </p>
            </div>
            <div class="promise-right" data-aos="fade-left" data-aos-delay="200">
                <div class="promise-video">
                    <div class="video-overlay">
                        <i class="fas fa-play"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="promise-points">
            <?php
            $trust_points = central_build_get_trust_points();
            if (!empty($trust_points)) :
                foreach ($trust_points as $index => $point) :
                    $delay = 220 + ($index * 70);
            ?>
            <div class="promise-item" data-aos="zoom-in" data-aos-delay="<?php echo esc_attr($delay); ?>">
                <div class="promise-icon">
                    <i class="<?php echo esc_attr($point['icon'] ?? 'fas fa-check-circle'); ?>"></i>
                </div>
                <div class="promise-content">
                    <h4 class="promise-heading"><?php echo esc_html($point['title'] ?? ''); ?></h4>
                    <p class="promise-text"><?php echo esc_html($point['description'] ?? ''); ?></p>
                </div>
            </div>
            <?php
                endforeach;
            endif;
            ?>
        </div>
    </div>
</section>