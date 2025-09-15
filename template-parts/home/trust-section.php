<!-- Trust Process Section -->
<section id="Home-One-Section-Two" class="home-one-section-two">
    <div class="w-layout-blockcontainer trust-in-process-container w-container">
        <div class="w-layout-vflex home-one-section-two-main-wrap">
            
            <!-- Section Heading -->
            <div class="w-layout-hflex heading-box">
                <h2 class="heading-wrap">
                    <?php
                    $trust_title = get_theme_mod('central_build_trust_title', __('Trust in<br>ENP Fitouts Process', 'central-build'));
                    echo wp_kses($trust_title, array('br' => array()));
                    ?>
                </h2>
            </div>
            
            <!-- Features Grid -->
            <div data-w-id="3de9e9fa-b38d-5f0a-de5d-ec28d085a4de" class="w-layout-hflex home-one-box-flex margin-top-negative">
                
                <!-- Feature 1: Structured Process -->
                <div data-w-id="3de9e9fa-b38d-5f0a-de5d-ec28d085a4df" class="home-one-box-one">
                    <?php
                    $feature1_icon = get_theme_mod('central_build_trust_feature1_icon', get_template_directory_uri() . '/images/66f1ffecdef9310969f579e0_Engg-Icon.svg');
                    ?>
                    <img src="<?php echo esc_url($feature1_icon); ?>" alt="<?php esc_attr_e('Structured Process Icon', 'central-build'); ?>" width="66" height="66" class="autofit financial-icon">
                    
                    <div class="heading-six">
                        <?php
                        $feature1_title = get_theme_mod('central_build_trust_feature1_title', __('A Structured Fitout Process', 'central-build'));
                        echo esc_html($feature1_title);
                        ?>
                    </div>
                    
                    <p class="margin-top-twenty">
                        <?php
                        $feature1_description = get_theme_mod(
                            'central_build_trust_feature1_description',
                            __('Most delays happen because of poor planning. We solve that with a clear, step-by-step process built around your business needs. From the start, you\'ll know what\'s happening, when it\'s happening, and what to expect next. With built-in approvals and check-ins along the way, there\'s no confusion or chaos — just structure you can rely on.', 'central-build')
                        );
                        echo esc_html($feature1_description);
                        ?>
                    </p>
                </div>
                
                <!-- Feature 2: Project Support -->
                <div data-w-id="3de9e9fa-b38d-5f0a-de5d-ec28d085a4f0" class="home-one-box-one">
                    <?php
                    $feature2_icon = get_theme_mod('central_build_trust_feature2_icon', get_template_directory_uri() . '/images/66f1ffecdef9310969f57a0a_Project-Icon.svg');
                    ?>
                    <img src="<?php echo esc_url($feature2_icon); ?>" alt="<?php esc_attr_e('Project Support Icon', 'central-build'); ?>" width="66" height="66" class="autofit financial-icon">
                    
                    <div class="heading-six">
                        <?php
                        $feature2_title = get_theme_mod('central_build_trust_feature2_title', __('Hands-On Project Support', 'central-build'));
                        echo esc_html($feature2_title);
                        ?>
                    </div>
                    
                    <p class="margin-top-twenty">
                        <?php
                        $feature2_description = get_theme_mod(
                            'central_build_trust_feature2_description',
                            __('You won\'t be chasing trades or wondering what\'s going on onsite. You\'ll have a dedicated project manager who coordinates everything from permits and council approvals to joinery installation. We deal with the issues before they affect your timeline, and keep you informed without overwhelming you.', 'central-build')
                        );
                        echo esc_html($feature2_description);
                        ?>
                    </p>
                </div>
                
                <!-- Feature 3: Cost Management -->
                <div class="home-one-box-one">
                    <?php
                    $feature3_icon = get_theme_mod('central_build_trust_feature3_icon', get_template_directory_uri() . '/images/66f1ffecdef9310969f579df_Financial-Icon.svg');
                    ?>
                    <img src="<?php echo esc_url($feature3_icon); ?>" alt="<?php esc_attr_e('Cost Management Icon', 'central-build'); ?>" width="64" height="66" class="autofit financial-icon">
                    
                    <div class="heading-six">
                        <?php
                        $feature3_title = get_theme_mod('central_build_trust_feature3_title', __('Transparent Cost Management', 'central-build'));
                        echo esc_html($feature3_title);
                        ?>
                    </div>
                    
                    <p class="margin-top-twenty">
                        <?php
                        $feature3_description = get_theme_mod(
                            'central_build_trust_feature3_description',
                            __('We don\'t do vague quotes or "TBC" allowances. Every quote is detailed, costed properly, and confirmed with our trades. That means you know where every dollar is going before the build starts. If anything changes, we talk it through with you — no surprise charges or last-minute add-ons.', 'central-build')
                        );
                        echo esc_html($feature3_description);
                        ?>
                    </p>
                </div>
                
            </div>
        </div>
    </div>
</section>