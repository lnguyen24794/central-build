/**
 * Central Build Pro Theme JavaScript
 * 
 * @package Central_Build_Pro
 * @since 1.0.0
 */

(function($) {
    'use strict';

    // DOM Ready
    jQuery(document).ready(function() {
        initMobileMenu();
        initSmoothScroll();
        initScrollToTop();
        initLazyLoading();
        initAnimations();
        initContactForm();
        initFAQAccordion();
    });

    // Window Scroll
    jQuery(window).on('scroll', function() {
        handleScroll();
    });

    /**
     * Initialize Mobile Menu
     */
    function initMobileMenu() {
        jQuery('.menu-toggle, .hamburgar-wrap').on('click', function(e) {
            e.preventDefault();
            
            const $this = jQuery(this);
            const $nav = jQuery('.main-navigation');
            const $menu = jQuery('.nav-menu');
            
            $this.toggleClass('active');
            $nav.toggleClass('mobile-menu-open');
            $menu.slideToggle(300);
            
            // Toggle hamburger animation
            $this.find('.hamburgar-line-one, .hamburgar-line-two, .hamburgar-line-three').toggleClass('active');
            
            // Prevent body scroll when menu is open
            jQuery('body').toggleClass('menu-open');
        });

        // Handle dropdown menus
        jQuery('.menu-item-has-children > a').on('click', function(e) {
            if (jQuery(window).width() <= 768) {
                e.preventDefault();
                jQuery(this).next('.sub-menu').slideToggle(200);
                jQuery(this).parent().toggleClass('dropdown-open');
            }
        });
    }

    /**
     * Initialize Smooth Scroll
     */
    function initSmoothScroll() {
        jQuery('a[href*="#"]:not([href="#"])').on('click', function(e) {
            const target = jQuery(this.getAttribute('href'));
            
            if (target.length) {
                e.preventDefault();
                
                jQuery('html, body').animate({
                    scrollTop: target.offset().top - 80
                }, 800, 'easeInOutQuart');
            }
        });
    }

    /**
     * Initialize Scroll to Top
     */
    function initScrollToTop() {
        // Create scroll to top button if it doesn't exist
        if (!jQuery('.scroll-to-top').length) {
            jQuery('body').append('<button class="scroll-to-top" aria-label="Scroll to top"><span>↑</span></button>');
        }

        jQuery('.scroll-to-top').on('click', function(e) {
            e.preventDefault();
            jQuery('html, body').animate({
                scrollTop: 0
            }, 800, 'easeInOutQuart');
        });
    }

    /**
     * Initialize Lazy Loading
     */
    function initLazyLoading() {
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver(function(entries, observer) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                        img.classList.add('loaded');
                        imageObserver.unobserve(img);
                    }
                });
            });

            document.querySelectorAll('img[data-src]').forEach(function(img) {
                imageObserver.observe(img);
            });
        }
    }

    /**
     * Initialize Animations
     */
    function initAnimations() {
        // Fade in animations
        if ('IntersectionObserver' in window) {
            const animationObserver = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate-in');
                    }
                });
            }, {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            });

            document.querySelectorAll('.animate-on-scroll').forEach(function(el) {
                animationObserver.observe(el);
            });
        }

        // Counter animations
        jQuery('.counter').each(function() {
            const $this = jQuery(this);
            const countTo = $this.attr('data-count');
            
            jQuery({ countNum: $this.text() }).animate({
                countNum: countTo
            }, {
                duration: 2000,
                easing: 'swing',
                step: function() {
                    $this.text(Math.floor(this.countNum));
                },
                complete: function() {
                    $this.text(this.countNum);
                }
            });
        });
    }

    /**
     * Initialize Contact Form
     */
    function initContactForm() {
        jQuery('#contact-form').on('submit', function(e) {
            e.preventDefault();
            
            const $form = jQuery(this);
            const $submitBtn = $form.find('input[type="submit"]');
            const $messages = jQuery('#form-messages');
            
            // Disable submit button
            $submitBtn.prop('disabled', true).val('Sending...');
            
            // Serialize form data
            const formData = $form.serialize();
            
            // AJAX request
            $.ajax({
                url: $form.attr('action'),
                type: 'POST',
                data: formData,
                success: function(response) {
                    $messages.removeClass('error').addClass('success')
                        .html('<p>Thank you! Your message has been sent successfully.</p>')
                        .fadeIn();
                    $form[0].reset();
                },
                error: function() {
                    $messages.removeClass('success').addClass('error')
                        .html('<p>Sorry, there was an error sending your message. Please try again.</p>')
                        .fadeIn();
                },
                complete: function() {
                    $submitBtn.prop('disabled', false).val('Enquire Now');
                    
                    // Hide message after 5 seconds
                    setTimeout(function() {
                        $messages.fadeOut();
                    }, 5000);
                }
            });
        });
    }

    /**
     * Initialize FAQ Accordion
     */
    function initFAQAccordion() {
        // Check if FAQ elements exist
        if (!jQuery('.faq-accodian-wrapper').length) {
            console.log('FAQ: No FAQ elements found');
            return;
        }

        console.log('FAQ: Initializing accordion for', jQuery('.faq-accodian-wrapper').length, 'items');

        jQuery('.faq-accodian-wrapper .w-dropdown-toggle').on('click', function(e) {
            e.preventDefault();
            
            const $toggle = jQuery(this);
            const $wrapper = $toggle.closest('.faq-accodian-wrapper');
            const $dropdown = $wrapper.find('.w-dropdown-list');
            const $content = $wrapper.find('.accordion-one-dropdown-contain');
            const $icon = $wrapper.find('.faq-open-2');            
            
            // Validate elements
            if (!$dropdown.length || !$content.length || !$icon.length) {
                console.error('FAQ: Missing required elements');
                return;
            }
            
            // Check if this FAQ is currently open
            const isOpen = $dropdown.hasClass('w--open');
            
            if (isOpen) {
                // Close this FAQ
                closeFAQItem($wrapper, $dropdown, $content, $icon, $toggle);
            } else {
                // Close all other FAQs first
                jQuery('.faq-accodian-wrapper').each(function() {
                    const $otherWrapper = jQuery(this);
                    if (!$otherWrapper.is($wrapper)) {
                        const $otherDropdown = $otherWrapper.find('.w-dropdown-list');
                        const $otherContent = $otherWrapper.find('.accordion-one-dropdown-contain');
                        const $otherIcon = $otherWrapper.find('.faq-open-2');
                        const $otherToggle = $otherWrapper.find('.w-dropdown-toggle');
                        
                        if ($otherDropdown.hasClass('w--open')) {
                            closeFAQItem($otherWrapper, $otherDropdown, $otherContent, $otherIcon, $otherToggle);
                        }
                    }
                });
                
                // Open this FAQ
                openFAQItem($wrapper, $dropdown, $content, $icon, $toggle);
            }
        });

        // Handle keyboard navigation
        jQuery('.faq-accodian-wrapper .w-dropdown-toggle').on('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                jQuery(this).trigger('click');
            }
        });
    }

    /**
     * Open FAQ Item
     */
    function openFAQItem($wrapper, $dropdown, $content, $icon, $toggle) {
        // Ensure we have jQuery objects
        if (!$dropdown.length || typeof $dropdown.css !== 'function') {
            console.error('FAQ: Invalid jQuery object for dropdown');
            return;
        }
        
        // Get content height for smooth animation
        $content.css('opacity', '0');
        $dropdown.css('height', 'auto');
        const contentHeight = $dropdown.outerHeight();
        $dropdown.css('height', '0px');
        
        // Add open classes
        $dropdown.addClass('w--open');
        $content.addClass('active');
        $icon.addClass('active');
        
        // Update ARIA attributes
        $toggle.attr('aria-expanded', 'true');
        
        // Use CSS transitions instead of jQuery animate
        setTimeout(function() {
            $dropdown.css('height', contentHeight + 'px');
            $content.css('opacity', '1');
        }, 10);
        
        // Set height to auto after animation completes
        setTimeout(function() {
            if ($dropdown.hasClass('w--open')) {
                $dropdown.css('height', 'auto');
            }
        }, 350);
        
        // Rotate icon
        $icon.css({
            'transform': 'translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg, 0deg)',
            'transform-style': 'preserve-3d'
        });
    }

    /**
     * Close FAQ Item
     */
    function closeFAQItem($wrapper, $dropdown, $content, $icon, $toggle) {
        // Ensure we have jQuery objects
        if (!$dropdown.length || typeof $dropdown.css !== 'function') {
            console.error('FAQ: Invalid jQuery object for dropdown');
            return;
        }
        
        // Get current height before closing
        const currentHeight = $dropdown.outerHeight();
        $dropdown.css('height', currentHeight + 'px');
        
        // Remove classes
        $dropdown.removeClass('w--open');
        $content.removeClass('active');
        $icon.removeClass('active');
        
        // Update ARIA attributes
        $toggle.attr('aria-expanded', 'false');
        
        // Use CSS transitions
        setTimeout(function() {
            $dropdown.css('height', '0px');
            $content.css('opacity', '0');
        }, 10);
        
        // Rotate icon back
        $icon.css({
            'transform': 'translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(-90deg) skew(0deg, 0deg)',
            'transform-style': 'preserve-3d'
        });
    }

    /**
     * Handle Window Scroll
     */
    function handleScroll() {
        const scrollTop = jQuery(window).scrollTop();
        
        // Header scroll effect
        if (scrollTop > 100) {
            jQuery('.site-header').addClass('scrolled');
        } else {
            jQuery('.site-header').removeClass('scrolled');
        }
        
        // Scroll to top button
        if (scrollTop > 300) {
            jQuery('.scroll-to-top').addClass('visible');
        } else {
            jQuery('.scroll-to-top').removeClass('visible');
        }
        
        // Parallax effect for hero sections
        jQuery('.parallax-bg').each(function() {
            const $this = jQuery(this);
            const yPos = -(scrollTop / $this.data('speed'));
            $this.css('transform', 'translateY(' + yPos + 'px)');
        });
    }

    /**
     * Testimonials Slider
     */
    function initTestimonialsSlider() {
        if (jQuery('.testimonial-slider').length) {
            jQuery('.testimonial-slider').slick({
                dots: true,
                arrows: false,
                infinite: true,
                speed: 500,
                slidesToShow: 1,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 4000,
                fade: true,
                cssEase: 'linear'
            });
        }
    }

    /**
     * Portfolio Filter
     */
    function initPortfolioFilter() {
        if (jQuery('.portfolio-filter').length) {
            jQuery('.portfolio-filter').on('click', 'button', function() {
                const filterValue = jQuery(this).attr('data-filter');
                
                jQuery(this).addClass('active').siblings().removeClass('active');
                
                jQuery('.portfolio-grid').isotope({
                    filter: filterValue
                });
            });
        }
    }

    /**
     * Initialize Google Maps
     */
    function initGoogleMaps() {
        const mapElement = document.getElementById('contact-map');
        
        if (mapElement) {
            const lat = parseFloat(mapElement.dataset.lat);
            const lng = parseFloat(mapElement.dataset.lng);
            
            const map = new google.maps.Map(mapElement, {
                zoom: 15,
                center: { lat: lat, lng: lng },
                styles: [
                    {
                        "featureType": "all",
                        "elementType": "geometry.fill",
                        "stylers": [{ "weight": "2.00" }]
                    },
                    {
                        "featureType": "all",
                        "elementType": "geometry.stroke",
                        "stylers": [{ "color": "#9c9c9c" }]
                    }
                ]
            });
            
            const marker = new google.maps.Marker({
                position: { lat: lat, lng: lng },
                map: map,
                title: 'Central Build Office'
            });
        }
    }

    // Initialize additional features
    jQuery(document).ready(function() {
        initTestimonialsSlider();
        initPortfolioFilter();
        
        // Initialize Google Maps if API is loaded
        if (typeof google !== 'undefined' && google.maps) {
            initGoogleMaps();
        }
    });

})(jQuery);
