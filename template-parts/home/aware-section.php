<!-- Problem Aware Section -->
<section class="problem-aware-section">
        <div class="container">
            <div class="home-one-why-us-flex">
                <div class="home-one-why-us-left">
                    <div class="image-hover-block">
                        <?php
    $about_image = get_theme_mod('central_build_about_image');
if ($about_image) : ?>
                            <img src="<?php echo esc_url($about_image); ?>" alt="<?php esc_attr_e('Central Build team on site', 'central-build'); ?>" class="single-img hovered">
                        <?php else : ?>
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/images/about-image.jpg'); ?>" alt="<?php esc_attr_e('Central Build team on site', 'central-build'); ?>" class="single-img hovered">
                        <?php endif; ?>
                    </div>
                </div>
                <div class="home-one-why-us-right">
                    <div class="heading-box">
                        <h2 class="heading-wrap">
                            <?php
    $about_title = get_theme_mod('central_build_about_title', __('Built on Expertise and Purpose', 'central-build'));
echo esc_html($about_title);
?>
                        </h2>
                    </div>
                    <p class="way-us-paragraph margin-top-twenty">
                        <?php
                        $about_description = get_theme_mod(
                            'central_build_about_description',
                            __('With years of experience and a passion for excellence, we deliver tailored fit-out solutions designed to elevate your business. Our commitment to quality and purpose-driven results ensures your space not only meets but exceeds expectations.', 'central-build')
                        );
echo esc_html($about_description);
?>
                    </p>
                    <div class="devider-one"></div>
                    
                    <!-- Features Grid -->
                    <div class="problem-aware-block">
                        <div class="home-one-project-block">
                            <div class="heading-six"><?php esc_html_e('Cost Control', 'central-build'); ?></div>
                            <p class="home-one-way-us-paragraph"><?php esc_html_e('Clear pricing from the start. No hidden costs. No surprise variations. Just a scope you can trust.', 'central-build'); ?></p>
                        </div>
                        <div class="home-one-project-block">
                            <div class="heading-six"><?php esc_html_e('Timely Delivery', 'central-build'); ?></div>
                            <p class="home-one-way-us-paragraph"><?php esc_html_e('We understand how important your opening date is. That\'s why we give you a clear plan upfront, stick to it, and communicate early if anything changes. You\'ll always know where things stand.', 'central-build'); ?></p>
                        </div>
                    </div>
                    
                    <div class="problem-aware-block">
                        <div class="home-one-project-block">
                            <div class="heading-six"><?php esc_html_e('Practical Planning', 'central-build'); ?></div>
                            <p class="home-one-way-us-paragraph"><?php esc_html_e('We guide you through the design phase to make sure your layout works for real operations.', 'central-build'); ?></p>
                        </div>
                        <div class="home-one-project-block">
                            <div class="heading-six"><?php esc_html_e('Built-in Compliance', 'central-build'); ?></div>
                            <p class="home-one-way-us-paragraph"><?php esc_html_e('We take care of approvals, permits, and builder certifications so you avoid delays and paperwork headaches.', 'central-build'); ?></p>
                        </div>
                    </div>
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