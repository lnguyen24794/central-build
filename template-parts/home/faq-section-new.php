<!-- FAQ Section -->
<section class="home-one-faq-section-copy">
    <div class="w-layout-blockcontainer container-one-2 w-container">
        <div class="w-layout-hflex freely-ask-flex-2">
            <div class="freely-ask-left">
                <div class="home-one-faq-block">
                    
                    <!-- FAQ Title -->
                    <h2 class="heading-wrap margin-none header-to-the-right">
                        <?php
                        $faq_title = get_theme_mod('central_build_faq_title', __('Frequently Asked Question', 'central-build'));
                        echo esc_html($faq_title);
                        ?>
                    </h2>
                    
                    <!-- FAQ Items -->
                    <?php
                    // Get FAQ items from customizer
                    for ($i = 1; $i <= 5; $i++) {
                        $faq_question = get_theme_mod("central_build_faq_{$i}_question");
                        $faq_answer = get_theme_mod("central_build_faq_{$i}_answer");
                        
                        if ($faq_question && $faq_answer) :
                            $active_class = ($i == 1) ? 'active' : '';
                            $height_style = ($i == 1) ? 'height: auto;' : 'height: 0px;';
                            $rotation_style = ($i == 1) ? 'transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(-90deg) skew(0deg, 0deg); transform-style: preserve-3d;' : 'transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(-90deg) skew(0deg, 0deg); transform-style: preserve-3d;';
                    ?>
                        <div data-delay="0" data-hover="false" class="faq-accodian-wrapper w-dropdown">
                            <div class="accordion-one pink-border w-dropdown-toggle" 
                                 id="w-dropdown-toggle-<?php echo $i + 2; ?>" 
                                 aria-controls="w-dropdown-list-<?php echo $i + 2; ?>" 
                                 aria-haspopup="menu" 
                                 aria-expanded="<?php echo ($i == 1) ? 'true' : 'false'; ?>" 
                                 role="button" 
                                 tabindex="0">
                                <div class="accodian-heading-2">
                                    <?php echo esc_html($faq_question); ?>
                                </div>
                                <div class="faq-open-close">
                                    <div class="faq-close-2"></div>
                                    <div class="faq-open-2 <?php echo $active_class; ?>" 
                                         style="<?php echo $rotation_style; ?>"></div>
                                </div>
                            </div>
                            <nav style="<?php echo $height_style; ?>" 
                                 class="accordion-one-dropdown-main-box w-dropdown-list" 
                                 id="w-dropdown-list-<?php echo $i + 2; ?>" 
                                 aria-labelledby="w-dropdown-toggle-<?php echo $i + 2; ?>">
                                <div class="accordion-one-dropdown-contain <?php echo $active_class; ?>">
                                    <p class="paragraph-9">
                                        <?php echo esc_html($faq_answer); ?>
                                    </p>
                                </div>
                            </nav>
                        </div>
                    <?php 
                        endif;
                    }
                    ?>
                    
                </div>
            </div>
        </div>
    </div>
</section>
