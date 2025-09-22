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
    
    <link href="<?php echo get_template_directory_uri(); ?>/images/67624b469230f78408d127c9_66f5ef0f300ba05756664c1f_Untitled%20design%20%282%29%20%28Custom%29.png" rel="shortcut icon" type="image/x-icon">
    <link href="<?php echo get_template_directory_uri(); ?>/images/67624b50f5ed113a6d144492_66f5eee1b9d1bc07e2c176ba_Untitled%20design%20%282%29.png" rel="apple-touch-icon">

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
                        <img src="<?php echo get_template_directory_uri(); ?>/images/66f1ffecdef9310969f57d56_Group.svg" loading="lazy" width="19" height="19" alt="">
                        <a href="tel:+61431465090" class="phone-text">+61 431 465 090</a>
                    </div>
                    <div class="phone-icon-block">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/66f1ffecdef9310969f57d90_messege%20icon.svg" loading="lazy" width="21" height="14" alt="">
                        <a href="mailto:info@enpfitouts.com" class="phone-text mail-text">info@enpfitouts.com</a>
                    </div>
                </div>
                <div class="header-social-block">
                    <div class="phone-text">Follow Us :</div>
                    <a href="https://www.facebook.com/p/ENP-Fitouts-100079118888496/" target="_blank" class="header-social-link w-inline-block">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/66f1ffecdef9310969f579dc_Footer-Fb.svg" alt="Fb Icon" width="7" height="13">
                    </a>
                    <a href="https://www.linkedin.com/company/enp-fitouts/?originalSubdomain=au" target="_blank" class="header-social-link w-inline-block">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/66f1ffecdef9310969f57a73_Linkedin-Icon-Big.svg" width="14" height="13" alt="Linkedin Icon Big">
                    </a>
                    <a href="https://www.instagram.com/enpfitouts" target="_blank" class="header-social-link w-inline-block">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/66f1ffecdef9310969f579dd_Footer-Instra.svg" width="14" height="13" alt="Instra Icon">
                    </a>
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
                    <img width="121" height="38" src="<?php echo esc_url($logo[0]); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" class="image-height-auto">
                    <?php else : ?>
                    <img width="121" height="38" alt="<?php bloginfo('name'); ?>" src="<?php echo get_template_directory_uri(); ?>/images/674e51fad943a77607127b0b_ENP%20transparent%20white%20cropped.webp" sizes="121px" srcset="<?php echo get_template_directory_uri(); ?>/images/674e51fad943a77607127b0b_ENP%20transparent%20white%20cropped.webp 500w, <?php echo get_template_directory_uri(); ?>/images/674e51fad943a77607127b0b_ENP%20transparent%20white%20cropped.webp 800w, <?php echo get_template_directory_uri(); ?>/images/674e51fad943a77607127b0b_ENP%20transparent%20white%20cropped.webp 1080w, <?php echo get_template_directory_uri(); ?>/images/674e51fad943a77607127b0b_ENP%20transparent%20white%20cropped.webp 1529w" class="image-height-auto">
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
                
                <a href="<?php echo home_url('/contact'); ?>" class="hero-button mb-0 above-all-else nav-bar-button w-inline-block">
                    <div class="button-mask">
                        <div class="link-text-wrp">
                            <div class="text-block-2">Get A quote</div>
                        </div>
                    </div>
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