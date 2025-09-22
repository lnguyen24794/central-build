<?php
/**
 * The template for displaying archive pages
 *
 * @package Central_Build_Pro
 * @since 1.0.0
 */

get_header();

// Get current category information
$current_term = get_queried_object();
$is_category_archive = is_tax('fitout_category');

// Set default values
$category_name = 'Fitout Sectors';
$category_description = 'Explore our comprehensive fitout services across various sectors.';
$category_slug = '';
$hero_image = 'https://cdn.prod.website-files.com/66f1ffebdef9310969f57940/674e4000a7cc35ad9ae56860_DSC01892%20(Large).webp';

// Category-specific settings
if ($is_category_archive && $current_term) {
    $category_name = $current_term->name;
    $category_slug = $current_term->slug;
    
    // Get custom description from term meta, fallback to default description, then term description
    $custom_description = get_term_meta($current_term->term_id, 'category_description_custom', true);
    if ($custom_description) {
        $category_description = $custom_description;
    } elseif ($current_term->description) {
        $category_description = $current_term->description;
    } else {
        $category_description = get_category_description_by_slug($current_term->slug);
    }
    
    // Get custom hero image from term meta, fallback to default
    $custom_hero_image = get_term_meta($current_term->term_id, 'category_hero_image', true);
    if ($custom_hero_image) {
        $hero_image = $custom_hero_image;
    } else {
        $hero_image = get_category_hero_image($current_term->slug);
    }
}

/**
 * Get category description by slug
 */
function get_category_description_by_slug($slug) {
    $descriptions = array(
        'hospitality-fitout' => 'Reimagine your hospitality space with custom fitouts tailored for ambiance and function. Central Build creates inviting environments that enhance the guest experience and showcase your brand\'s unique personality.',
        'office-fitout' => 'Transform your workspace into a productive and inspiring environment with our professional office fitouts. We create modern, functional spaces that boost productivity and reflect your company culture.',
        'retail-fitout' => 'Elevate your retail space with custom fitouts designed to attract customers and drive sales. Our retail solutions combine aesthetic appeal with practical functionality.',
        'medical-fitout' => 'Specialized medical fitouts that prioritize patient comfort, operational efficiency, and compliance with healthcare regulations. Creating healing environments that inspire confidence.',
        'beauty-wellness-fitout' => 'Luxurious beauty and wellness fitouts that create serene, professional environments. Designed to enhance client relaxation and showcase your premium services.',
        'mezzanine-fitout' => 'Maximize your space efficiently with innovative mezzanine fitouts. Smart solutions that add functional area while maintaining design integrity.'
    );
    
    return isset($descriptions[$slug]) ? $descriptions[$slug] : 'Professional fitout solutions tailored to your specific industry needs.';
}

/**
 * Get category hero image by slug
 */
function get_category_hero_image($slug) {
    $images = array(
        'hospitality-fitout' => 'https://cdn.prod.website-files.com/66f1ffebdef9310969f57940/674e4000a7cc35ad9ae56860_DSC01892%20(Large).webp',
        'office-fitout' => 'https://cdn.prod.website-files.com/66f1ffebdef9310969f57940/674fb0ac8b2be968fa78a53b_MAIN_OFFICE_3.3.1%20(Large).png',
        'retail-fitout' => 'https://cdn.prod.website-files.com/66f1ffebdef9310969f57940/674fb59ca04815b79062e722_1%20(Large).jpg',
        'medical-fitout' => 'https://cdn.prod.website-files.com/66f1ffebdef9310969f57940/674fb9db3d96c35876d4b314_0Y7A4128%20(Large).jpg',
        'beauty-wellness-fitout' => 'https://cdn.prod.website-files.com/66f1ffebdef9310969f57940/6758b52edb5c369d0ad329f7_Gloss%20Final-68%20(Large).jpg',
        'mezzanine-fitout' => 'https://cdn.prod.website-files.com/66f1ffebdef9310969f57940/674e4af6a81ec22fb406f992_DSC01452-2%20(Small).webp'
    );
    
    return isset($images[$slug]) ? $images[$slug] : 'https://cdn.prod.website-files.com/66f1ffebdef9310969f57940/674e4000a7cc35ad9ae56860_DSC01892%20(Large).webp';
}

/**
 * Get category icon by slug
 */
function get_category_icon($slug) {
    $icons = array(
        'hospitality-fitout' => 'https://cdn.prod.website-files.com/66f1ffebdef9310969f57940/674e4af6a81ec22fb406f986_2.svg',
        'office-fitout' => 'https://cdn.prod.website-files.com/66f1ffebdef9310969f57940/674e4af6a81ec22fb406f984_1.svg',
        'retail-fitout' => 'https://cdn.prod.website-files.com/66f1ffebdef9310969f57940/674e4af6a81ec22fb406f985_4.svg',
        'medical-fitout' => 'https://cdn.prod.website-files.com/66f1ffebdef9310969f57940/66f1ffecdef9310969f57d82_Rotate%20Icon.svg',
        'beauty-wellness-fitout' => 'https://cdn.prod.website-files.com/66f1ffebdef9310969f57940/674e4af6a81ec22fb406f985_4.svg',
        'mezzanine-fitout' => 'https://cdn.prod.website-files.com/66f1ffebdef9310969f57940/674e4af6a81ec22fb406f983_3.svg'
    );
    
    return isset($icons[$slug]) ? $icons[$slug] : 'https://cdn.prod.website-files.com/66f1ffebdef9310969f57940/674e4af6a81ec22fb406f986_2.svg';
}
?>

<main id="primary" class="site-main">
    <section class="home-three-hero-section">
        <div class="w-layout-blockcontainer container-one home-three-hero-container w-container">
            <div class="home-three-hero-block">
                <div class="w-layout-hflex home-one-hero-heading-flex">
                    <div class="tag-wrap padding-none"><div class="tag dark-tab">fitout sectors</div></div>
                    <h1 class="home-three-heading text-white margin-none"><?php echo esc_html($category_name); ?></h1>
                </div>
                <p class="text-white">
                    <?php echo esc_html($category_description); ?>
                </p>
                <div class="w-layout-hflex home-three-btn-flex">
                    <a href="/about-us/our-values" role="button" data-w-id="a30961f4-0944-26f8-6286-299f045dfe63" class="hero-button white-button w-inline-block">
                        <div class="button-mask">
                            <div style="transform: translate3d(0px, 0%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg, 0deg); transform-style: preserve-3d;" class="link-text-wrp">
                                <div class="text-block-4">Learn More About us</div>
                                <div class="secondt-btn-text">Learn more<br /></div>
                            </div>
                        </div>
                    </a>
                    <a href="/contact" role="button" data-w-id="146142f8-1a88-63c3-ca79-9e09d5fc51ed" class="hero-button border-button w-inline-block">
                        <div class="button-mask">
                            <div style="transform: translate3d(0px, 0%, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg, 0deg); transform-style: preserve-3d;" class="link-text-wrp">
                                <div>Free Consultation</div>
                                <div class="secondt-btn-text">Free Consultation</div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="home-three-banner-img">
            <div class="home-three-banner-image-block">
                <img
                    src="https://cdn.prod.website-files.com/66f1ffebdef9310969f57940/66f1ffecdef9310969f579c4_Image-Bg-Section.webp"
                    sizes="(max-width: 905px) 100vw, 905px"
                    height="849"
                    alt="Home Three Hero Image"
                    width="905"
                    srcset="
                        https://cdn.prod.website-files.com/66f1ffebdef9310969f57940/66f1ffecdef9310969f579c4_Image-Bg-Section-p-500.webp 500w,
                        https://cdn.prod.website-files.com/66f1ffebdef9310969f57940/66f1ffecdef9310969f579c4_Image-Bg-Section-p-800.webp 800w,
                        https://cdn.prod.website-files.com/66f1ffebdef9310969f57940/66f1ffecdef9310969f579c4_Image-Bg-Section.webp       905w
                    "
                    class="autofit image-abs-one"
                />
                <img
                    src="<?php echo esc_url($hero_image); ?>"
                    loading="lazy"
                    width="905"
                    height="849"
                    alt="<?php echo esc_attr($category_name . ' Projects'); ?>"
                    class="home-three-banner-transparent-image"
                />
            </div>
        </div>
    </section>
    <section class="home-three-section-two">
        <div class="w-layout-blockcontainer container-one w-container">
            <div class="home-two-mid-icon-block">
                <?php
                // Get custom icon from term meta, fallback to default
                $category_icon = '';
                if ($is_category_archive && $current_term) {
                    $custom_icon = get_term_meta($current_term->term_id, 'category_icon', true);
                    if ($custom_icon) {
                        $category_icon = $custom_icon;
                    } else {
                        $category_icon = get_category_icon($category_slug);
                    }
                } else {
                    $category_icon = get_category_icon($category_slug);
                }
                ?>
                <div class="large-visible-desktop-hidden home-three-construction-heading"><h2 class="heading-3"><?php echo esc_html($category_name . ' Projects'); ?></h2></div>
            </div>
        </div>
        <?php
        // Query fitout sector posts for current category
        $query_args = array(
            'post_type' => 'fitout_sector',
            'posts_per_page' => -1,
            'post_status' => 'publish',
        );
        
        // If viewing a specific category, filter by that category
        if ($is_category_archive && $current_term) {
            $query_args['tax_query'] = array(
                array(
                    'taxonomy' => 'fitout_category',
                    'field'    => 'term_id',
                    'terms'    => $current_term->term_id,
                ),
            );
        }
        
        $fitout_query = new WP_Query($query_args);
        
        if ($fitout_query->have_posts()) : ?>
        <div class="w-dyn-list">
            <div role="list" class="projects-flex w-dyn-items">
                <?php while ($fitout_query->have_posts()) : $fitout_query->the_post(); 
                    $hero_image = get_post_meta(get_the_ID(), '_fitout_hero_image', true);
                    $categories = get_the_terms(get_the_ID(), 'fitout_category');
                    $category_name = $categories && !is_wp_error($categories) ? $categories[0]->name : 'Fitout';
                    
                    // Fallback image if no hero image is set
                    if (!$hero_image && has_post_thumbnail()) {
                        $hero_image = get_the_post_thumbnail_url(get_the_ID(), 'large');
                    }
                    if (!$hero_image) {
                        $hero_image = 'https://cdn.prod.website-files.com/66f1ffebdef9310969f57940/66f1ffecdef9310969f579c4_Image-Bg-Section.webp';
                    }
                ?>
                <div role="listitem" class="w-dyn-item">
                    <a href="<?php echo esc_url(get_permalink()); ?>" class="link-block w-inline-block">
                        <div style="background-image: url('<?php echo esc_url($hero_image); ?>');" class="project-block-outer">
                            <div class="listing-two-content">
                                <div class="w-layout-hflex project-building-flex">
                                    <img src="/wp-content/themes/central-build/images/Hospitality.svg" alt="" width="50" height="40" class="project-icon" />
                                    <div class="project-block">
                                        <div class="heading-five text-white margin-none"><?php echo esc_html(get_the_title()); ?></div>
                                        <div class="heading-five text-white margin-top-none"><?php echo esc_html($category_name); ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="listing-bg"></div>
                        </div>
                    </a>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
        <?php 
        wp_reset_postdata();
        else : ?>
        <div class="w-dyn-list">
            <div role="list" class="projects-flex w-dyn-items">
                <div class="w-dyn-empty">
                    <div>No fitout projects found in this category.</div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </section>
    <section class="service-three-section-four">
        <div class="w-layout-blockcontainer container-full-width w-container">
            <div class="about-two-journey-marque-block about-three-journey-marquee-block service-three-journey-marquee">
                <div class="w-layout-hflex service-two-marquee-main-wrap">
                    <div class="w-layout-hflex service-two-marquee-box">
                        <div class="construction-marquee-train">
                            <div class="w-layout-hflex about-two-marquee-flex-block">
                                <img width="28" height="28" alt="Icon" src="https://cdn.prod.website-files.com/66f1ffebdef9310969f57940/66f1ffecdef9310969f57cfb_.svg" class="autofit-3 middle-align" />
                                <div class="about-one-marque-right-text about-two-marque-right-text"><div class="heading-six-5 text-white margin-none">Project Management</div></div>
                            </div>
                        </div>
                        <div class="construction-marquee-train">
                            <div class="w-layout-hflex about-two-marquee-flex-block">
                                <img width="28" height="28" alt="Icon" src="https://cdn.prod.website-files.com/66f1ffebdef9310969f57940/66f1ffecdef9310969f57cfb_.svg" class="autofit-3 middle-align" />
                                <div class="about-one-marque-right-text about-two-marque-right-text"><div class="heading-six-5 text-white margin-none">Project Planning</div></div>
                            </div>
                        </div>
                        <div class="construction-marquee-train">
                            <div class="w-layout-hflex about-two-marquee-flex-block">
                                <img width="28" height="28" alt="Icon" src="https://cdn.prod.website-files.com/66f1ffebdef9310969f57940/66f1ffecdef9310969f57cfb_.svg" class="autofit-3 middle-align" />
                                <div class="about-one-marque-right-text about-two-marque-right-text"><div class="heading-six-5 text-white margin-none">Partition</div></div>
                            </div>
                        </div>
                        <div class="construction-marquee-train">
                            <div class="w-layout-hflex about-two-marquee-flex-block">
                                <img width="28" height="28" alt="Icon" src="https://cdn.prod.website-files.com/66f1ffebdef9310969f57940/66f1ffecdef9310969f57cfb_.svg" class="autofit-3 middle-align" />
                                <div class="about-one-marque-right-text about-two-marque-right-text"><div class="heading-six-5 text-white margin-none">Ceiling</div></div>
                            </div>
                        </div>
                        <div class="construction-marquee-train">
                            <div class="w-layout-hflex about-two-marquee-flex-block">
                                <img width="28" height="28" alt="Icon" src="https://cdn.prod.website-files.com/66f1ffebdef9310969f57940/66f1ffecdef9310969f57cfb_.svg" class="autofit-3 middle-align" />
                                <div class="about-one-marque-right-text about-two-marque-right-text"><div class="heading-six-5 text-white margin-none">Glazing</div></div>
                            </div>
                        </div>
                        <div class="construction-marquee-train">
                            <div class="w-layout-hflex about-two-marquee-flex-block">
                                <img width="28" height="28" alt="Icon" src="https://cdn.prod.website-files.com/66f1ffebdef9310969f57940/66f1ffecdef9310969f57cfb_.svg" class="autofit-3 middle-align" />
                                <div class="about-one-marque-right-text about-two-marque-right-text"><div class="heading-six-5 text-white margin-none">Shop Fronts</div></div>
                            </div>
                        </div>
                    </div>
                    <div class="w-layout-hflex service-two-marquee-box">
                        <div class="construction-marquee-train">
                            <div class="w-layout-hflex about-two-marquee-flex-block">
                                <img width="28" height="28" alt="Icon" src="https://cdn.prod.website-files.com/66f1ffebdef9310969f57940/66f1ffecdef9310969f57cfb_.svg" class="autofit-3 middle-align" />
                                <div class="about-one-marque-right-text about-two-marque-right-text"><div class="heading-six-5 text-white margin-none">Flooring</div></div>
                            </div>
                        </div>
                        <div class="construction-marquee-train">
                            <div class="w-layout-hflex about-two-marquee-flex-block">
                                <img width="28" height="28" alt="Icon" src="https://cdn.prod.website-files.com/66f1ffebdef9310969f57940/66f1ffecdef9310969f57cfb_.svg" class="autofit-3 middle-align" />
                                <div class="about-one-marque-right-text about-two-marque-right-text"><div class="heading-six-5 text-white margin-none">Finishes</div></div>
                            </div>
                        </div>
                        <div class="construction-marquee-train">
                            <div class="w-layout-hflex about-two-marquee-flex-block">
                                <img width="28" height="28" alt="Icon" src="https://cdn.prod.website-files.com/66f1ffebdef9310969f57940/66f1ffecdef9310969f57cfb_.svg" class="autofit-3 middle-align" />
                                <div class="about-one-marque-right-text about-two-marque-right-text"><div class="heading-six-5 text-white margin-none">Mechanical Services</div></div>
                            </div>
                        </div>
                        <div class="construction-marquee-train">
                            <div class="w-layout-hflex about-two-marquee-flex-block">
                                <img width="28" height="28" alt="Icon" src="https://cdn.prod.website-files.com/66f1ffebdef9310969f57940/66f1ffecdef9310969f57cfb_.svg" class="autofit-3 middle-align" />
                                <div class="about-one-marque-right-text about-two-marque-right-text"><div class="heading-six-5 text-white margin-none">Electrical Services</div></div>
                            </div>
                        </div>
                        <div class="construction-marquee-train">
                            <div class="w-layout-hflex about-two-marquee-flex-block">
                                <img width="28" height="28" alt="Icon" src="https://cdn.prod.website-files.com/66f1ffebdef9310969f57940/66f1ffecdef9310969f57cfb_.svg" class="autofit-3 middle-align" />
                                <div class="about-one-marque-right-text about-two-marque-right-text"><div class="heading-six-5 text-white margin-none">Data &amp; Security</div></div>
                            </div>
                        </div>
                        <div class="construction-marquee-train">
                            <div class="w-layout-hflex about-two-marquee-flex-block">
                                <img width="28" height="28" alt="Icon" src="https://cdn.prod.website-files.com/66f1ffebdef9310969f57940/66f1ffecdef9310969f57cfb_.svg" class="autofit-3 middle-align" />
                                <div class="about-one-marque-right-text about-two-marque-right-text"><div class="heading-six-5 text-white margin-none">Custom Joinery</div></div>
                            </div>
                        </div>
                    </div>
                    <div class="w-layout-hflex service-two-marquee-box">
                        <div class="construction-marquee-train">
                            <div class="w-layout-hflex about-two-marquee-flex-block">
                                <img width="28" height="28" alt="Icon" src="https://cdn.prod.website-files.com/66f1ffebdef9310969f57940/66f1ffecdef9310969f57cfb_.svg" class="autofit-3 middle-align" />
                                <div class="about-one-marque-right-text about-two-marque-right-text"><div class="heading-six-5 text-white margin-none">Custom Furniture</div></div>
                            </div>
                        </div>
                        <div class="construction-marquee-train">
                            <div class="w-layout-hflex about-two-marquee-flex-block">
                                <img width="28" height="28" alt="Icon" src="https://cdn.prod.website-files.com/66f1ffebdef9310969f57940/66f1ffecdef9310969f57cfb_.svg" class="autofit-3 middle-align" />
                                <div class="about-one-marque-right-text about-two-marque-right-text"><div class="heading-six-5 text-white margin-none">Finishing Touches</div></div>
                            </div>
                        </div>
                        <div class="construction-marquee-train">
                            <div class="w-layout-hflex about-two-marquee-flex-block">
                                <img width="28" height="28" alt="Icon" src="https://cdn.prod.website-files.com/66f1ffebdef9310969f57940/66f1ffecdef9310969f57cfb_.svg" class="autofit-3 middle-align" />
                                <div class="about-one-marque-right-text about-two-marque-right-text"><div class="heading-six-5 text-white margin-none">Signage</div></div>
                            </div>
                        </div>
                        <div class="construction-marquee-train">
                            <div class="w-layout-hflex about-two-marquee-flex-block">
                                <img width="28" height="28" alt="Icon" src="https://cdn.prod.website-files.com/66f1ffebdef9310969f57940/66f1ffecdef9310969f57cfb_.svg" class="autofit-3 middle-align" />
                                <div class="about-one-marque-right-text about-two-marque-right-text"><div class="heading-six-5 text-white margin-none">Design Concept</div></div>
                            </div>
                        </div>
                        <div class="construction-marquee-train">
                            <div class="w-layout-hflex about-two-marquee-flex-block">
                                <img width="28" height="28" alt="Icon" src="https://cdn.prod.website-files.com/66f1ffebdef9310969f57940/66f1ffecdef9310969f57cfb_.svg" class="autofit-3 middle-align" />
                                <div class="about-one-marque-right-text about-two-marque-right-text"><div class="heading-six-5 text-white margin-none">Certification</div></div>
                            </div>
                        </div>
                        <div class="construction-marquee-train">
                            <div class="w-layout-hflex about-two-marquee-flex-block">
                                <img width="28" height="28" alt="Icon" src="https://cdn.prod.website-files.com/66f1ffebdef9310969f57940/66f1ffecdef9310969f57cfb_.svg" class="autofit-3 middle-align" />
                                <div class="about-one-marque-right-text about-two-marque-right-text"><div class="heading-six-5 text-white margin-none">Floor Plan</div></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php
    // CTA/Checkout Section
    loadView(get_template_directory() . '/template-parts/components/fitout-sector-section.php');
    ?>

    <?php
    // Cta Section
    loadView(get_template_directory() . '/template-parts/components/cta-section.php');
    ?>

    <?php
    // FAQ Section
    loadView(get_template_directory() . '/template-parts/components/faq-section.php');
    ?>
</main>

<?php
get_footer();
