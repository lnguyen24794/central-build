/**
 * Central Build Pro Theme JavaScript
 * 
 * @package Central_Build_Pro
 * @since 1.0.0
 */

(function($) {
    'use strict';

    // DOM Ready
    $(document).ready(function() {
        initWebFonts();
        initMobileMenu();
        initSmoothScroll();
        initScrollToTop();
        initLazyLoading();
        initAnimations();
        initContactForm();
    });

    // Window Load
    $(window).on('load', function() {
        initPreloader();
    });

    // Window Resize
    $(window).on('resize', function() {
        handleResize();
    });

    // Window Scroll
    $(window).on('scroll', function() {
        handleScroll();
    });

    /**
     * Initialize Web Fonts
     */
    function initWebFonts() {
        if (typeof WebFont !== 'undefined') {
            WebFont.load({
                google: {
                    families: ["Roboto:300,regular,500"]
                },
                custom: {
                    families: ['Oswald:n2,n3,n4,n5,n6,n7'],
                    urls: [central_build_theme.template_url + '/css/main.min.css']
                }
            });
        }
    }

    /**
     * Initialize Mobile Menu
     */
    function initMobileMenu() {
        $('.menu-toggle, .hamburgar-wrap').on('click', function(e) {
            e.preventDefault();
            
            const $this = $(this);
            const $nav = $('.main-navigation');
            const $menu = $('.nav-menu');
            
            $this.toggleClass('active');
            $nav.toggleClass('mobile-menu-open');
            $menu.slideToggle(300);
            
            // Toggle hamburger animation
            $this.find('.hamburgar-line-one, .hamburgar-line-two, .hamburgar-line-three').toggleClass('active');
            
            // Prevent body scroll when menu is open
            $('body').toggleClass('menu-open');
        });

        // Close mobile menu when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.main-navigation, .menu-toggle, .hamburgar-wrap').length) {
                closeMobileMenu();
            }
        });

        // Handle dropdown menus
        $('.menu-item-has-children > a').on('click', function(e) {
            if ($(window).width() <= 768) {
                e.preventDefault();
                $(this).next('.sub-menu').slideToggle(200);
                $(this).parent().toggleClass('dropdown-open');
            }
        });
    }

    /**
     * Close Mobile Menu
     */
    function closeMobileMenu() {
        $('.menu-toggle, .hamburgar-wrap').removeClass('active');
        $('.main-navigation').removeClass('mobile-menu-open');
        $('.nav-menu').slideUp(300);
        $('body').removeClass('menu-open');
        $('.hamburgar-line-one, .hamburgar-line-two, .hamburgar-line-three').removeClass('active');
    }

    /**
     * Initialize Smooth Scroll
     */
    function initSmoothScroll() {
        $('a[href*="#"]:not([href="#"])').on('click', function(e) {
            const target = $(this.getAttribute('href'));
            
            if (target.length) {
                e.preventDefault();
                
                $('html, body').animate({
                    scrollTop: target.offset().top - 80
                }, 800, 'easeInOutQuart');
                
                // Close mobile menu if open
                closeMobileMenu();
            }
        });
    }

    /**
     * Initialize Scroll to Top
     */
    function initScrollToTop() {
        // Create scroll to top button if it doesn't exist
        if (!$('.scroll-to-top').length) {
            $('body').append('<button class="scroll-to-top" aria-label="Scroll to top"><span>↑</span></button>');
        }

        $('.scroll-to-top').on('click', function(e) {
            e.preventDefault();
            $('html, body').animate({
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
        $('.counter').each(function() {
            const $this = $(this);
            const countTo = $this.attr('data-count');
            
            $({ countNum: $this.text() }).animate({
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
        $('#contact-form').on('submit', function(e) {
            e.preventDefault();
            
            const $form = $(this);
            const $submitBtn = $form.find('input[type="submit"]');
            const $messages = $('#form-messages');
            
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
     * Initialize Preloader
     */
    function initPreloader() {
        $('.preloader').fadeOut(500, function() {
            $(this).remove();
        });
    }

    /**
     * Handle Window Resize
     */
    function handleResize() {
        // Close mobile menu on resize to desktop
        if ($(window).width() > 768) {
            closeMobileMenu();
        }
    }

    /**
     * Handle Window Scroll
     */
    function handleScroll() {
        const scrollTop = $(window).scrollTop();
        
        // Header scroll effect
        if (scrollTop > 100) {
            $('.site-header').addClass('scrolled');
        } else {
            $('.site-header').removeClass('scrolled');
        }
        
        // Scroll to top button
        if (scrollTop > 300) {
            $('.scroll-to-top').addClass('visible');
        } else {
            $('.scroll-to-top').removeClass('visible');
        }
        
        // Parallax effect for hero sections
        $('.parallax-bg').each(function() {
            const $this = $(this);
            const yPos = -(scrollTop / $this.data('speed'));
            $this.css('transform', 'translateY(' + yPos + 'px)');
        });
    }

    /**
     * Testimonials Slider
     */
    function initTestimonialsSlider() {
        if ($('.testimonial-slider').length) {
            $('.testimonial-slider').slick({
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
        if ($('.portfolio-filter').length) {
            $('.portfolio-filter').on('click', 'button', function() {
                const filterValue = $(this).attr('data-filter');
                
                $(this).addClass('active').siblings().removeClass('active');
                
                $('.portfolio-grid').isotope({
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
    $(document).ready(function() {
        initTestimonialsSlider();
        initPortfolioFilter();
        
        // Initialize Google Maps if API is loaded
        if (typeof google !== 'undefined' && google.maps) {
            initGoogleMaps();
        }
    });

    // Expose functions globally if needed
    window.CentralBuild = {
        closeMobileMenu: closeMobileMenu,
        initGoogleMaps: initGoogleMaps
    };

})(jQuery);

// Vanilla JS for performance-critical features
document.addEventListener('DOMContentLoaded', function() {
    
    // Add loading class to images
    const images = document.querySelectorAll('img');
    images.forEach(function(img) {
        img.addEventListener('load', function() {
            this.classList.add('loaded');
        });
        
        if (img.complete) {
            img.classList.add('loaded');
        }
    });
    
    // Service worker registration (if available)
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('/sw.js').catch(function(error) {
            console.log('ServiceWorker registration failed: ', error);
        });
    }
});
