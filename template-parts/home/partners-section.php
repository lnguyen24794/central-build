<!-- Partners/Clients Section -->
<section data-w-id="241bd2c4-e4bd-eb52-2c53-638698a938c5" class="home-two-partners-marquee overflow-none home-two-bottom-marquee">
    <div class="w-layout-hflex home-two-partners-marquee-main-wrap">
        
        <!-- First Row of Partners -->
        <div class="w-layout-hflex home-two-partners-marquee-box-2">
            <?php
            // Get partner logos from customizer
            for ($i = 1; $i <= 6; $i++) {
                $partner_logo = get_theme_mod("central_build_partner_{$i}_logo");
                $partner_name = get_theme_mod("central_build_partner_{$i}_name", "Partner {$i}");
                $partner_url = get_theme_mod("central_build_partner_{$i}_url", '#');
                
                if ($partner_logo) :
            ?>
                <div class="home-two-partners-block-2">
                    <?php if ($partner_url && $partner_url !== '#') : ?>
                        <a href="<?php echo esc_url($partner_url); ?>" target="_blank" rel="noopener noreferrer">
                    <?php endif; ?>
                    
                    <img src="<?php echo esc_url($partner_logo); ?>" 
                         alt="<?php echo esc_attr($partner_name); ?>" 
                         loading="lazy" 
                         class="logo-image">
                    
                    <?php if ($partner_url && $partner_url !== '#') : ?>
                        </a>
                    <?php endif; ?>
                </div>
            <?php 
                endif;
            }
            ?>
        </div>
        
        <!-- Second Row of Partners -->
        <div class="w-layout-hflex home-two-partners-marquee-box-2">
            <?php
            // Get second row partner logos from customizer
            for ($i = 7; $i <= 12; $i++) {
                $partner_logo = get_theme_mod("central_build_partner_{$i}_logo");
                $partner_name = get_theme_mod("central_build_partner_{$i}_name", "Partner {$i}");
                $partner_url = get_theme_mod("central_build_partner_{$i}_url", '#');
                
                if ($partner_logo) :
            ?>
                <div class="home-two-partners-block-2">
                    <?php if ($partner_url && $partner_url !== '#') : ?>
                        <a href="<?php echo esc_url($partner_url); ?>" target="_blank" rel="noopener noreferrer">
                    <?php endif; ?>
                    
                    <img src="<?php echo esc_url($partner_logo); ?>" 
                         alt="<?php echo esc_attr($partner_name); ?>" 
                         loading="lazy" 
                         class="logo-image">
                    
                    <?php if ($partner_url && $partner_url !== '#') : ?>
                        </a>
                    <?php endif; ?>
                </div>
            <?php 
                endif;
            }
            ?>
        </div>
        
        <!-- Third Row of Partners (Duplicate for marquee effect) -->
        <div class="w-layout-hflex home-two-partners-marquee-box-2">
            <?php
            // Repeat first row for seamless marquee
            for ($i = 1; $i <= 6; $i++) {
                $partner_logo = get_theme_mod("central_build_partner_{$i}_logo");
                $partner_name = get_theme_mod("central_build_partner_{$i}_name", "Partner {$i}");
                $partner_url = get_theme_mod("central_build_partner_{$i}_url", '#');
                
                if ($partner_logo) :
            ?>
                <div class="home-two-partners-block-2">
                    <?php if ($partner_url && $partner_url !== '#') : ?>
                        <a href="<?php echo esc_url($partner_url); ?>" target="_blank" rel="noopener noreferrer">
                    <?php endif; ?>
                    
                    <img src="<?php echo esc_url($partner_logo); ?>" 
                         alt="<?php echo esc_attr($partner_name); ?>" 
                         loading="lazy" 
                         class="logo-image">
                    
                    <?php if ($partner_url && $partner_url !== '#') : ?>
                        </a>
                    <?php endif; ?>
                </div>
            <?php 
                endif;
            }
            ?>
        </div>
        
    </div>
</section>