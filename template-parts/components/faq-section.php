<!-- FAQ Section -->
<section class="home-one-faq-section-copy">
    <div class="container">
        <div class="w-layout-hflex freely-ask-flex-2">
            <div class="freely-ask-left">
                <div class="home-one-faq-block">
                    
                    <!-- FAQ Title -->
                    <h2 class="heading-wrap margin-none header-to-the-right mb-2">
                        <?php
                        $faq_title = get_option('central_build_faq_title', __('Frequently Asked Question', 'central-build'));
                        echo esc_html($faq_title);
                        ?>
                    </h2>
                    
                    <!-- FAQ Items -->
                    <?php
                    $faqs = central_build_get_faqs();
                    if (!empty($faqs)) :
                        foreach ($faqs as $i => $faq) :
                            if (!empty($faq['question']) && !empty($faq['answer'])) :
                                $active_class = ($i == 0) ? 'active' : '';
                                $dropdown_id = $i + 3;
                    ?>
                        <div data-delay="0" data-hover="false" class="faq-accodian-wrapper w-dropdown" data-faq-index="<?php echo $i; ?>">
                            <div class="accordion-one pink-border w-dropdown-toggle" 
                                 id="w-dropdown-toggle-<?php echo $dropdown_id; ?>" 
                                 aria-controls="w-dropdown-list-<?php echo $dropdown_id; ?>" 
                                 aria-haspopup="menu" 
                                 aria-expanded="<?php echo ($i == 0) ? 'true' : 'false'; ?>" 
                                 role="button" 
                                 tabindex="0">
                                <div class="accodian-heading-2">
                                    <?php echo esc_html($faq['question']); ?>
                                </div>
                                <div class="faq-open-close">
                                    <div class="faq-close-2"></div>
                                    <div class="faq-open-2 <?php echo $active_class; ?>"></div>
                                </div>
                            </div>
                            <nav class="accordion-one-dropdown-main-box w-dropdown-list <?php echo ($i == 0) ? 'w--open' : ''; ?>" 
                                 id="w-dropdown-list-<?php echo $dropdown_id; ?>" 
                                 aria-labelledby="w-dropdown-toggle-<?php echo $dropdown_id; ?>"
                                 style="<?php echo ($i == 0) ? 'height: auto;' : 'height: 0px;'; ?>">
                                <div class="accordion-one-dropdown-contain <?php echo $active_class; ?>">
                                    <p class="paragraph-9">
                                        <?php echo esc_html($faq['answer']); ?>
                                    </p>
                                </div>
                            </nav>
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
