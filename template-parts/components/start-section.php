<?php $cb_home_hero = central_build_get_home_content()['hero']; ?>
<!-- Hero/Start Section -->
<section class="about-two-hero-section">
    <div class="w-layout-blockcontainer container-one about-two-hero-container w-container">
        <div class="container position-relative" data-aos="fade-up" data-aos-duration="1200">
            <h1 class="display-3 fw-bolder mb-3"><?php echo wp_kses_post($cb_home_hero['title']); ?></h1>
            <?php if (!empty($cb_home_hero['tagline'])) : ?>
            <p class="lead mb-4 fw-bold" style="color: var(--accent-color);"><?php echo wp_kses_post($cb_home_hero['tagline']); ?></p>
            <?php endif; ?>
            <?php if (!empty($cb_home_hero['description'])) : ?>
            <p class="mb-5 fs-5 opacity-85 col-lg-8 text-white"><?php echo wp_kses_post($cb_home_hero['description']); ?></p>
            <?php endif; ?>
            <?php if (!empty($cb_home_hero['button']['label'])) : ?>
            <a href="<?php echo esc_url($cb_home_hero['button']['url'] ?: '#contact'); ?>" class="btn cta-button-gold btn-lg shadow-lg"><?php echo esc_html($cb_home_hero['button']['label']); ?></a>
            <?php endif; ?>
        </div>
    </div>
    <div class="about-two-hero-overlay"></div>
</section>
