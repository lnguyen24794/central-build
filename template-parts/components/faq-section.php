<?php $cb_home_faq = central_build_get_home_content()['faq']; ?>
<section id="faq" class="py-5 py-md-5">
    <div class="container">
        <h2 class="text-center display-6 fw-normal mb-5" data-aos="fade-down"><?php echo esc_html($cb_home_faq['heading']); ?></h2>
        <div class="row justify-content-center">
            <div class="col-lg-10" data-aos="fade-up">
                <div class="accordion" id="faqAccordion">
                    <?php foreach (array_values((array) $cb_home_faq['items']) as $i => $item) :
                        $open = ($i === 0);
                        $id   = 'faq-' . ($i + 1);
                    ?>
                    <div class="accordion-item shadow-sm mb-3">
                        <h2 class="accordion-header" id="<?php echo esc_attr($id); ?>-heading">
                            <button class="accordion-button<?php echo $open ? '' : ' collapsed'; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#<?php echo esc_attr($id); ?>" aria-expanded="<?php echo $open ? 'true' : 'false'; ?>" aria-controls="<?php echo esc_attr($id); ?>">
                                 <?php echo esc_html($item['question'] ?? ''); ?>
                            </button>
                        </h2>
                        <div id="<?php echo esc_attr($id); ?>" class="accordion-collapse collapse<?php echo $open ? ' show' : ''; ?>" aria-labelledby="<?php echo esc_attr($id); ?>-heading" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                <?php echo wp_kses_post($item['answer'] ?? ''); ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>
