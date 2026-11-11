<?php
if (!defined('ABSPATH')) {
    exit;
}

$footer_settings = get_option('central_build_footer_settings', array());
$defaults        = central_build_footer_settings_defaults();
$footer_settings = wp_parse_args(is_array($footer_settings) ? $footer_settings : array(), $defaults);
$footer_settings['company'] = wp_parse_args($footer_settings['company'] ?? array(), $defaults['company']);
$footer_settings['company']['phone'] = wp_parse_args($footer_settings['company']['phone'] ?? array(), $defaults['company']['phone']);
$footer_settings['company']['mobile'] = wp_parse_args($footer_settings['company']['mobile'] ?? array(), $defaults['company']['mobile']);

$sanitize_links = function ($links, $fallback) {
    $collection = array();
    if (is_array($links)) {
        foreach ($links as $link) {
            $collection[] = wp_parse_args($link, array('label' => '', 'url' => ''));
        }
    }
    if (empty($collection)) {
        $collection = $fallback;
    }
    return $collection;
};

$footer_settings['quick_links']   = $sanitize_links($footer_settings['quick_links'] ?? array(), $defaults['quick_links']);
$footer_settings['support_links'] = $sanitize_links($footer_settings['support_links'] ?? array(), $defaults['support_links']);

$company      = $footer_settings['company'];
$quick_links  = $footer_settings['quick_links'];
$support_links = $footer_settings['support_links'];

$footer_logo        = $company['logo_url'];
$footer_description = $company['description'];
$footer_email       = $company['email'];
$footer_phone       = $company['phone']['display'];
$footer_phone_link  = $company['phone']['link'];
$footer_phone_clean = preg_replace('/[^0-9+]/', '', $footer_phone_link);
$footer_mobile      = wp_parse_args($company['mobile'] ?? array(), array('display' => '', 'link' => ''));
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
                    <?php if (!empty($company['licence'])) : ?>
                        <p class="footer-two-paragraph text-light-grey" style="margin-top: -6px;"><?php echo esc_html($company['licence']); ?></p>
                    <?php endif; ?>
                    <a href="mailto:<?php echo esc_attr($footer_email); ?>" class="footer-link with-underline w-inline-block">
                        <div class="footer-link-text color-white"><?php echo esc_html($footer_email); ?></div>
                    </a>
                    <?php $footer_social = central_build_get_footer_settings()['social_links']; ?>
                    <?php if ($footer_social) : ?>
                        <nav class="cb-footer-social" aria-label="<?php esc_attr_e('Central Build on social media', 'central-build'); ?>">
                            <span class="cb-footer-social__title"><?php esc_html_e('Follow us', 'central-build'); ?></span>
                            <ul>
                                <?php foreach ($footer_social as $social) : ?>
                                    <li><a href="<?php echo esc_url($social['url']); ?>" target="_blank" rel="noopener" aria-label="<?php echo esc_attr(sprintf(__('%s (opens in a new tab)', 'central-build'), $social['label'] ?: $social['url'])); ?>" title="<?php echo esc_attr($social['label']); ?>"><i class="<?php echo esc_attr(central_build_social_icon($social['url'], $social['label'])); ?>" aria-hidden="true"></i></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </nav>
                    <?php endif; ?>
                </div>
                <div class="home-two-footer-two">
                    <div class="quick-links-text">Quick Links</div>
                    <div class="w-layout-vflex footer-menu-block">
                        <?php foreach ($quick_links as $link) :
                            $label = trim($link['label']);
                            $url   = trim($link['url']);
                            if ($label === '') {
                                continue;
                            }
                            ?>
                            <a href="<?php echo $url ? esc_url($url) : '#'; ?>" class="footer-link w-inline-block" <?php echo $url ? '' : 'aria-disabled="true"'; ?>>
                                <div class="footer-link-text"><?php echo esc_html($label); ?></div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="w-layout-hflex home-two-footer-box">
                <div class="home-two-footer-three">
                    <div class="quick-links-text">Support</div>
                    <div class="w-layout-vflex footer-menu-block">
                        <?php foreach ($support_links as $link) :
                            $label = trim($link['label']);
                            $url   = trim($link['url']);
                            if ($label === '') {
                                continue;
                            }
                            ?>
                            <a href="<?php echo $url ? esc_url($url) : '#'; ?>" class="footer-link w-inline-block" <?php echo $url ? '' : 'aria-disabled="true"'; ?>>
                                <div class="footer-link-text"><?php echo esc_html($label); ?></div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="home-two-footer-three gap-none">
                    <div class="quick-links-text">Get In Touch</div>
                    <div class="home-two-footer-call-block">
                        <a href="<?php echo esc_attr($footer_phone_link); ?>" class="footer-link w-inline-block">
                            <div class="footer-link-text text-light-grey"><?php echo esc_html($footer_phone); ?></div>
                        </a>
                        <?php if (!empty($footer_mobile['display'])) : ?>
                            <a href="<?php echo esc_attr($footer_mobile['link'] ?: 'tel:' . preg_replace('/[^0-9+]/', '', $footer_mobile['display'])); ?>" class="footer-link w-inline-block">
                                <div class="footer-link-text text-light-grey"><?php echo esc_html($footer_mobile['display']); ?></div>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 1000, // Duration of animation in ms
        once: true,    // Whether animation should only happen once - on load
    });
</script>
<?php wp_footer(); ?>

</body>
</html>

