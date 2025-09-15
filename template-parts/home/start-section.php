<!-- Hero/Start Section -->
<section class="about-two-hero-section">
    <div class="w-layout-blockcontainer container-one about-two-hero-container w-container">
        <div data-w-id="63eda76c-1eca-a647-61b0-147677936d70" class="w-layout-hflex left-container">
            <div class="tag-wrap"></div>
            
            <h1 class="text-white margin-none about-two-hero-heading">
                <?php
                $hero_title = get_theme_mod('central_build_hero_title', __('Your Commercial Fitout, Made Simple', 'central-build'));
                echo esc_html($hero_title);
                ?>
            </h1>
            
            <p data-w-id="63eda76c-1eca-a647-61b0-147677936d76" class="margin-top-twenty paragraph-box-container">
                <?php
                $hero_description = get_theme_mod(
                    'central_build_hero_description',
                    __('A commercial fitout can feel like a lot especially if it\'s your first one. We\'re here to make it simple. From the start, you\'ll have a clear plan, fixed costs, and one team guiding you through the process. No variations. No confusion. Just a space that\'s built properly, so you can focus on your business.', 'central-build')
                );
                echo esc_html($hero_description);
                ?>
            </p>
            
            <?php
            $hero_button_text = get_theme_mod('central_build_hero_button_text', __('Start Your Fitout Journey', 'central-build'));
            $hero_button_subtext = get_theme_mod('central_build_hero_button_subtext', __('Learn more', 'central-build'));
            $hero_button_url = get_theme_mod('central_build_hero_button_url', home_url('/commercial-shop-fitting'));
            ?>
            <a href="<?php echo esc_url($hero_button_url); ?>" role="button" class="hero-button-2 hero-button-here w-inline-block">
                <div class="button-mask">
                    <div class="link-text-wrp">
                        <div class="text-block"><?php echo esc_html($hero_button_text); ?></div>
                        <div class="secondt-btn-text"><?php echo esc_html($hero_button_subtext); ?></div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="about-two-hero-overlay"></div>
</section>