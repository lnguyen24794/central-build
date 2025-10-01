<!-- Partners/Clients Section -->
<section class="home-three-partners-section" data-aos="fade-up" data-aos-duration="800">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-5" data-aos="fade-right" data-aos-delay="120">
                <h2 class="partners-heading">
                    <?php
                        $partners_title = get_option('central_build_partners_title', __('Trusted by Leading Brands', 'central-build'));
                        echo esc_html($partners_title);
                    ?>
                </h2>
                <div class="partners-description mt-3" data-aos="fade-up" data-aos-delay="150">
                    <?php
                        $partners_description = get_option('central_build_partners_description', __('Our integrated delivery model and proven track record make us a go-to partner for high-performing companies seeking quality fitouts.', 'central-build'));
                        echo wp_kses_post($partners_description);
                    ?>
                </div>
            </div>
            <div class="col-lg-7" data-aos="fade-left" data-aos-delay="180">
                <div class="partners-logos-grid">
                    <?php
                    $partners = central_build_get_partners();
                    if (!empty($partners)) :
                        foreach ($partners as $index => $partner) :
                            $delay = 200 + ($index * 50);
                            if (!empty($partner['logo'])) :
                    ?>
                        <div class="partner-logo-card" data-aos="zoom-in" data-aos-delay="<?php echo esc_attr($delay); ?>">
                            <img src="<?php echo esc_url($partner['logo']); ?>" alt="<?php echo esc_attr($partner['name'] ?? __('Partner Logo', 'central-build')); ?>" class="img-fluid" loading="lazy">
                        </div>
                    <?php
                            endif;
                        endforeach;
                    endif;
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>