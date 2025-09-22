<?php
// Get footer settings with fallbacks
$footer_logo = get_option('central_build_footer_logo', get_template_directory_uri() . '/images/674e51fad943a77607127b0b_ENP%20transparent%20white%20cropped.webp');
$footer_description = get_option('central_build_footer_description', 'Central Build, established in 2018, crafts lasting fitout solutions with value, efficiency, and transparency. Discover the ENP difference.');
$footer_email = get_option('central_build_footer_email', 'info@centralbuild.au');
$footer_phone = get_option('central_build_footer_phone', '0123 456 789');

// Quick Links
$footer_home_text = get_option('central_build_footer_home_text', 'Home');
$footer_home_url = get_option('central_build_footer_home_url', home_url());
$footer_about_text = get_option('central_build_footer_about_text', 'About Us');
$footer_about_url = get_option('central_build_footer_about_url', home_url('/our-values'));
$footer_policy_text = get_option('central_build_footer_policy_text', 'Policy');
$footer_policy_url = get_option('central_build_footer_policy_url', 'https://cdn.prod.website-files.com/66f1ffebdef9310969f57940/676248fadfdb334304c54e6e_ENP%20Fitouts%20Privacy%20Policy.pdf');
$footer_services_text = get_option('central_build_footer_services_text', 'Services');
$footer_services_url = get_option('central_build_footer_services_url', home_url('/commercial-shop-fitting'));
$footer_portfolio_text = get_option('central_build_footer_portfolio_text', 'Portfolio');
$footer_portfolio_url = get_option('central_build_footer_portfolio_url', '#');

// Support Links
$footer_csr_text = get_option('central_build_footer_csr_text', 'CSR Commitment');
$footer_csr_url = get_option('central_build_footer_csr_url', home_url('/enp-fitouts-csr-commitments'));
$footer_values_text = get_option('central_build_footer_values_text', 'Our Values');
$footer_values_url = get_option('central_build_footer_values_url', home_url('/our-values'));
$footer_blog_text = get_option('central_build_footer_blog_text', 'Our Blog');
$footer_blog_url = get_option('central_build_footer_blog_url', '#');

// Clean phone number for tel: link
$footer_phone_clean = preg_replace('/[^0-9]/', '', $footer_phone);
?>

<footer class="home-two-footer-section">
    <div class="w-layout-blockcontainer container-one w-container">
        <div class="w-layout-hflex home-two-footer-flex-one">
            <div class="w-layout-hflex home-two-footer-box footer-box-first">
                <div class="home-two-footer-one">
                    <a href="<?php echo esc_url(home_url()); ?>" class="buildex w-inline-block">
                        <img src="<?php echo esc_url($footer_logo); ?>" sizes="220px" width="220" height="70" alt="<?php bloginfo('name'); ?>" srcset="<?php echo esc_url($footer_logo); ?> 500w, <?php echo esc_url($footer_logo); ?> 800w, <?php echo esc_url($footer_logo); ?> 1080w, <?php echo esc_url($footer_logo); ?> 1529w" class="autofit">
                    </a>
                    <p class="footer-two-paragraph text-light-grey"><?php echo esc_html($footer_description); ?></p>
                    <a href="mailto:<?php echo esc_attr($footer_email); ?>" class="footer-link with-underline w-inline-block">
                        <div class="footer-link-text color-white"><?php echo esc_html($footer_email); ?></div>
                    </a>
                </div>
                <div class="home-two-footer-two">
                    <div class="quick-links-text">Quick Links</div>
                    <div class="w-layout-vflex footer-menu-block">
                        <?php if ($footer_home_text && $footer_home_url) : ?>
                        <a href="<?php echo esc_url($footer_home_url); ?>" class="footer-link w-inline-block">
                            <div class="footer-link-text"><?php echo esc_html($footer_home_text); ?></div>
                        </a>
                        <?php endif; ?>
                        
                        <?php if ($footer_about_text && $footer_about_url) : ?>
                        <a href="<?php echo esc_url($footer_about_url); ?>" class="footer-link w-inline-block">
                            <div class="footer-link-text"><?php echo esc_html($footer_about_text); ?></div>
                        </a>
                        <?php endif; ?>
                        
                        <?php if ($footer_policy_text && $footer_policy_url) : ?>
                        <a href="<?php echo esc_url($footer_policy_url); ?>" class="footer-link w-inline-block">
                            <div class="footer-link-text"><?php echo esc_html($footer_policy_text); ?></div>
                        </a>
                        <?php endif; ?>
                        
                        <?php if ($footer_services_text && $footer_services_url) : ?>
                        <a href="<?php echo esc_url($footer_services_url); ?>" class="footer-link w-inline-block">
                            <div class="footer-link-text"><?php echo esc_html($footer_services_text); ?></div>
                        </a>
                        <?php endif; ?>
                        
                        <?php if ($footer_portfolio_text && $footer_portfolio_url && $footer_portfolio_url !== '#') : ?>
                        <a href="<?php echo esc_url($footer_portfolio_url); ?>" class="footer-link w-inline-block">
                            <div class="footer-link-text"><?php echo esc_html($footer_portfolio_text); ?></div>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="w-layout-hflex home-two-footer-box">
                <div class="home-two-footer-three">
                    <div class="quick-links-text">Support</div>
                    <div class="w-layout-vflex footer-menu-block">
                        <?php if ($footer_csr_text && $footer_csr_url) : ?>
                        <a href="<?php echo esc_url($footer_csr_url); ?>" class="footer-link w-inline-block">
                            <div class="footer-link-text"><?php echo esc_html($footer_csr_text); ?></div>
                        </a>
                        <?php endif; ?>
                        
                        <?php if ($footer_values_text && $footer_values_url) : ?>
                        <a href="<?php echo esc_url($footer_values_url); ?>" class="footer-link w-inline-block">
                            <div class="footer-link-text"><?php echo esc_html($footer_values_text); ?></div>
                        </a>
                        <?php endif; ?>
                        
                        <?php if ($footer_blog_text && $footer_blog_url && $footer_blog_url !== '#') : ?>
                        <a href="<?php echo esc_url($footer_blog_url); ?>" class="footer-link w-inline-block">
                            <div class="footer-link-text"><?php echo esc_html($footer_blog_text); ?></div>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="home-two-footer-three gap-none">
                    <div class="quick-links-text">Get In Touch</div>
                    <div class="home-two-footer-call-block">
                        <a href="tel:<?php echo esc_attr($footer_phone_clean); ?>" class="footer-link w-inline-block">
                            <div class="footer-link-text text-light-grey"><?php echo esc_html($footer_phone); ?></div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>

</body>
</html>

