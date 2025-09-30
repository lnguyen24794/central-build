<?php
if (!defined('ABSPATH')) {
    exit;
}

$header_settings = get_option('central_build_header_settings', array());
$defaults        = central_build_header_settings_defaults();
$header_settings = wp_parse_args(is_array($header_settings) ? $header_settings : array(), $defaults);
$header_settings['phone'] = wp_parse_args($header_settings['phone'] ?? array(), $defaults['phone']);
$header_settings['cta']   = wp_parse_args($header_settings['cta'] ?? array(), $defaults['cta']);
$header_settings['logo']  = wp_parse_args($header_settings['logo'] ?? array(), $defaults['logo']);

$header_phone        = $header_settings['phone']['link'];
$header_phone_display = $header_settings['phone']['display'];
$header_email        = $header_settings['email'];
$header_social_links = $header_settings['social_links'];
$header_cta_text     = $header_settings['cta']['text'];
$header_cta_url      = $header_settings['cta']['url'];
$header_logo_width   = (int) $header_settings['logo']['width'];
$header_logo_height  = (int) $header_settings['logo']['height'];
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="w-mod-js">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <title><?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); ?></title>
    <meta name="description" content="<?php bloginfo('description'); ?>">
    <meta property="og:title" content="<?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); ?>">
    <meta property="og:description" content="<?php bloginfo('description'); ?>">
    <meta property="twitter:title" content="<?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); ?>">
    <meta property="twitter:description" content="<?php bloginfo('description'); ?>">
    <meta property="og:type" content="website">
    <meta content="summary_large_image" name="twitter:card">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta content="WordPress" name="generator">
    
    <?php wp_head(); ?>
    
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin="anonymous">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/js/swiper-bundle.min.js"></script>
</head>
<body <?php body_class(); ?>>

<div class="header-style-one">
    <!-- Top Bar Section -->
    <section class="home-one-header-top-bar">
        <div class="w-layout-blockcontainer container-one w-container">
            <div class="w-layout-hflex home-one-flex-block">
                <div class="w-layout-hflex header-phone-block">
                    <div class="phone-icon-block">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/Group.svg" loading="lazy" width="19" height="19" alt="">
                        <a href="<?php echo esc_attr($header_phone); ?>" class="phone-text"><?php echo esc_html($header_phone_display); ?></a>
                    </div>
                    <div class="phone-icon-block">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/messege%20icon.svg" loading="lazy" width="21" height="14" alt="">
                        <a href="mailto:<?php echo esc_attr($header_email); ?>" class="phone-text mail-text"><?php echo esc_html($header_email); ?></a>
                    </div>
                </div>
                <div class="header-social-block">
                    <div class="phone-text">Follow Us :</div>
                    <?php foreach ($header_social_links as $social) :
                        $label    = esc_html($social['label']);
                        $url      = esc_url($social['url']);
                        $icon_url = esc_url($social['icon_url']);
                        $icon_alt = esc_attr($social['icon_alt']);

                        if ($url === '' && $icon_url === '') {
                            continue;
                        }
                        ?>
                        <a href="<?php echo $url ?: '#'; ?>" target="_blank" class="header-social-link w-inline-block" <?php echo $url ? '' : 'aria-disabled="true"'; ?>>
                            <?php if ($icon_url) : ?>
                                <img src="<?php echo $icon_url; ?>" alt="<?php echo $icon_alt ?: $label; ?>" width="18" height="18">
                            <?php else : ?>
                                <span class="phone-text" style="font-size: 12px; text-transform: uppercase;">
                                    <?php echo $label ?: esc_html__('Social', 'central-build'); ?>
                                </span>
                            <?php endif; ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Main Header Section -->
    <header class="style-three-header shadow">
        <div class="w-layout-blockcontainer container-one container-gap w-container">
            <div class="navbar-wrapper">
                <a href="<?php echo home_url(); ?>" role="link" aria-current="page" class="home-three-nav-menu-brand w-nav-brand w--current">
                    <?php if (has_custom_logo()) :
                        $custom_logo_id = get_theme_mod('custom_logo');
                        $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
                        ?>
                    <img width="<?php echo esc_attr($header_logo_width); ?>" height="<?php echo esc_attr($header_logo_height); ?>" src="<?php echo esc_url($logo[0]); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" class="image-height-auto">
                    <?php else : ?>
                    <img width="<?php echo esc_attr($header_logo_width); ?>" height="<?php echo esc_attr($header_logo_height); ?>" alt="<?php bloginfo('name'); ?>" src="<?php echo get_template_directory_uri(); ?>/images/674e51fad943a77607127b0b_ENP%20transparent%20white%20cropped.webp" sizes="<?php echo esc_attr($header_logo_width); ?>px" srcset="<?php echo get_template_directory_uri(); ?>/images/674e51fad943a77607127b0b_ENP%20transparent%20white%20cropped.webp 500w, <?php echo get_template_directory_uri(); ?>/images/674e51fad943a77607127b0b_ENP%20transparent%20white%20cropped.webp 800w, <?php echo get_template_directory_uri(); ?>/images/674e51fad943a77607127b0b_ENP%20transparent%20white%20cropped.webp 1080w, <?php echo get_template_directory_uri(); ?>/images/674e51fad943a77607127b0b_ENP%20transparent%20white%20cropped.webp 1529w" class="image-height-auto">
                    <?php endif; ?>
                </a>
                
                 <!-- Navigation -->
                 <nav class="nav">
                    <?php
                        // Check if primary menu is set
                        if (has_nav_menu('primary')) {
                            wp_nav_menu(array(
                                'theme_location' => 'primary',
                                'menu_class'     => 'nav-links',
                                'container'      => false,
                                'walker'         => new Central_Build_Walker_Nav_Menu(),
                                'fallback_cb'    => false,
                            ));
                        } else {
                            // Fallback menu if no menu is assigned
                            echo '<ul class="nav-links">';
                            echo '<li><a href="' . home_url() . '">Home</a></li>';
                            echo '<li><a href="' . home_url('/contact') . '">Contact</a></li>';
                            echo '</ul>';
                        }
?>
                    <div class="burger">
                        <div class="line1"></div>
                        <div class="line2"></div>
                        <div class="line3"></div>
                    </div>
                </nav>
                
                <a href="<?php echo esc_url($header_cta_url); ?>" class="cta-button-emergency mb-0 above-all-else nav-bar-button w-inline-block">
                    Contact Now
                </a>
            </div>
        </div>
    </header>
</div>

<script>
    const navSlide = () => {
        const burger = document.querySelector(".burger");
        const nav = document.querySelector(".nav-links");
        const navLinks = document.querySelectorAll(".nav-links a");
        const dropdowns = document.querySelectorAll(".dropdown");

        // Mobile menu toggle
        burger.addEventListener("click", () => {
            nav.classList.toggle("nav-active");

            navLinks.forEach((link, index) => {
                if (link.style.animation) {
                    link.style.animation = "";
                } else {
                    link.style.animation = `navLinkFade 0.3s ease forwards 0.3s `;
                }
            });
            burger.classList.toggle("toggle");
        });

        // Mobile dropdown functionality
        dropdowns.forEach(dropdown => {
            const dropbtn = dropdown.querySelector(".dropbtn");
            
            dropbtn.addEventListener("click", (e) => {
                // Only handle on mobile
                if (window.innerWidth <= 991) {
                    e.preventDefault();
                    
                    // Close other dropdowns
                    dropdowns.forEach(otherDropdown => {
                        if (otherDropdown !== dropdown) {
                            otherDropdown.classList.remove("mobile-open");
                        }
                    });
                    
                    // Toggle current dropdown
                    dropdown.classList.toggle("mobile-open");
                }
            });
        });

        // Close dropdowns when clicking outside
        document.addEventListener("click", (e) => {
            if (!e.target.closest(".dropdown")) {
                dropdowns.forEach(dropdown => {
                    dropdown.classList.remove("mobile-open");
                });
            }
        });

        // Handle window resize
        window.addEventListener("resize", () => {
            if (window.innerWidth > 991) {
                // Close mobile dropdowns on desktop
                dropdowns.forEach(dropdown => {
                    dropdown.classList.remove("mobile-open");
                });
            }
        });
    };

    // Initialize navigation when DOM is ready
    document.addEventListener("DOMContentLoaded", navSlide);
</script>