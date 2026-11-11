<?php $cb_home_intro = central_build_get_home_content()['intro']; ?>
<section class="py-5 bg-light">
  <div class="container">
    <div class="w-layout-hflex heading-box" data-aos="fade-down" data-aos-duration="1000">
        <h2 class="nz-div-6">
            <span class="title-holder"> <?php echo esc_html($cb_home_intro['heading']); ?> </span>
        </h2>
    </div>
    <?php if (!empty($cb_home_intro['text'])) : ?>
    <div class="mt-3 text-center" data-aos="fade-up" data-aos-duration="1200" data-aos-delay="200">
        <p class="text-muted w-75 mx-auto">
            <?php echo wp_kses_post($cb_home_intro['text']); ?>
        </p>
    </div>
    <?php endif; ?>
    <div class="row g-4" data-aos="fade-up" data-aos-duration="1200" data-aos-delay="400">
      <?php foreach ((array) $cb_home_intro['cards'] as $card) : ?>
      <div class="col-md-6">
        <div class="card h-100 shadow-sm border-0">
          <div class="card-body text-center p-4">
            <?php if (!empty($card['icon'])) : ?>
            <div class="mb-3">
              <i class="<?php echo esc_attr($card['icon']); ?> text-primary fs-1"></i>
            </div>
            <?php endif; ?>
            <h5 class="fw-bold"><?php echo esc_html($card['title'] ?? ''); ?></h5>
            <p class="text-muted">
              <?php echo wp_kses_post($card['description'] ?? ''); ?>
            </p>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
