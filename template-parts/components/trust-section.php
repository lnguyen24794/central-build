<!-- Trust Process Section -->
<section id="Home-One-Section-Two" class="home-one-section-two">
    <div class="w-layout-blockcontainer trust-in-process-container custom-container">
        <div class="w-layout-vflex home-one-section-two-main-wrap">
            
            <!-- Section Heading -->
            <div class="w-layout-hflex heading-box">
                <h2 class="nz-div-6">
                    <span class="title-holder">
                    <?php
                    $trust_title = get_option('central_build_trust_title', __('Trust in<br>Central Build Process', 'central-build'));
                    echo wp_kses($trust_title, array('br' => array()));
                    ?>
                    </span>
                </h2>
            </div>
            
            <!-- Features Grid -->
            <div class="w-layout-hflex home-one-box-flex margin-top-negative">
                <?php
                // Get trust features from the new array format
                $trust_features = central_build_get_trust_features();

                    if (!empty($trust_features)) :
                        foreach ($trust_features as $index => $feature) :
                            $box_class = ($index === 0) ? 'home-one-box-one shadow' : 'home-one-box-one';
                            ?>
                
                <!-- Trust Feature <?php echo $index + 1; ?> -->
                <div class="<?php echo esc_attr($box_class); ?>">
                    <?php if (!empty($feature['icon'])) : ?>
                        <img src="<?php echo esc_url($feature['icon']); ?>" 
                             alt="<?php echo esc_attr($feature['title'] ?? ''); ?>" 
                             width="66" height="66" 
                             class="autofit financial-icon">
                    <?php endif; ?>
                    
                    <?php if (!empty($feature['title'])) : ?>
                        <div class="heading-six">
                            <?php echo esc_html($feature['title']); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($feature['description'])) : ?>
                        <p class="margin-top-twenty">
                            <?php echo esc_html($feature['description']); ?>
                        </p>
                    <?php endif; ?>
                </div>
                
                <?php
                        endforeach;
                    endif;
                    ?>
            </div>
        </div>
    </div>
</section>