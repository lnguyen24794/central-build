<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Central_Build
 */

get_header(); ?>

<main id="primary" class="site-main">
    
    <!-- Hero Section -->
    <section class="about-two-hero-section">
        <div class="w-layout-blockcontainer container-one about-two-hero-container w-container">
            <div data-w-id="63eda76c-1eca-a647-61b0-147677936d70" class="w-layout-hflex left-container">
                <div class="tag-wrap"></div>
                <h1 class="text-white margin-none about-two-hero-heading">
                    <?php if (is_home() && !is_front_page()) : ?>
                        <?php single_post_title(); ?>
                    <?php elseif (is_archive()) : ?>
                        <?php the_archive_title(); ?>
                    <?php elseif (is_search()) : ?>
                        <?php printf(esc_html__('Search Results for: %s', 'central-build'), '<span>' . get_search_query() . '</span>'); ?>
                    <?php else : ?>
                        <?php esc_html_e('Latest Posts & Updates', 'central-build'); ?>
                    <?php endif; ?>
                </h1>
                <p data-w-id="63eda76c-1eca-a647-61b0-147677936d76" class="margin-top-twenty paragraph-box-container">
                    <?php if (is_archive()) : ?>
                        <?php the_archive_description(); ?>
                    <?php elseif (is_search()) : ?>
                        <?php esc_html_e('Browse through our search results to find what you\'re looking for.', 'central-build'); ?>
                    <?php else : ?>
                        <?php esc_html_e('Stay updated with our latest news, insights, and project showcases. Discover the latest trends in commercial fitouts and construction.', 'central-build'); ?>
                    <?php endif; ?>
                </p>
                <?php if (!is_search()) : ?>
                    <a href="<?php echo esc_url(home_url('/contact')); ?>" role="button" class="hero-button-2 hero-button-here w-inline-block">
                        <div class="button-mask">
                            <div class="link-text-wrp">
                                <div class="text-block"><?php esc_html_e('Get In Touch', 'central-build'); ?></div>
                                <div class="secondt-btn-text"><?php esc_html_e('Contact Us', 'central-build'); ?></div>
                            </div>
                        </div>
                    </a>
                <?php endif; ?>
            </div>
        </div>
        <div class="about-two-hero-overlay"></div>
    </section>

    <!-- Posts Section -->
    <section class="problem-aware-section">
        <div class="w-layout-blockcontainer container-one w-container">
            <?php if (have_posts()) : ?>
                <div class="w-layout-hflex home-one-why-us-flex">
                    <div class="home-one-why-us-left">
                        <div class="w-layout-hflex heading-box">
                            <h2 class="heading-wrap">
                                <?php if (is_search()) : ?>
                                    <?php esc_html_e('Search Results', 'central-build'); ?>
                                <?php else : ?>
                                    <?php esc_html_e('Latest Articles', 'central-build'); ?>
                                <?php endif; ?>
                            </h2>
                        </div>
                        <div class="devider-one"></div>
                        <div class="posts-container">
                            <?php while (have_posts()) : the_post(); ?>
                                <div class="home-one-project-block">
                                    <div class="heading-six">
                                        <a href="<?php the_permalink(); ?>" class="post-title-link"><?php the_title(); ?></a>
                                    </div>
                                    <div class="post-meta">
                                        <span class="post-date"><?php echo get_the_date(); ?></span>
                                        <?php if (has_category()) : ?><span class="post-categories"> | <?php the_category(', '); ?></span><?php endif; ?>
                                    </div>
                                    <p class="home-one-way-us-paragraph">
                                        <?php if (has_excerpt()) {
                                            the_excerpt();
                                        } else {
                                            echo wp_trim_words(get_the_content(), 30, '...');
                                        } ?>
                                    </p>
                                    <a href="<?php the_permalink(); ?>" class="read-more-link"><?php esc_html_e('Read More', 'central-build'); ?> →</a>
                                </div>
                            <?php endwhile; ?>
                        </div>
                        
                        <!-- Pagination -->
                        <?php
                        the_posts_pagination(array(
                            'mid_size'  => 2,
                            'prev_text' => esc_html__('Previous', 'central-build'),
                            'next_text' => esc_html__('Next', 'central-build'),
                            'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__('Page', 'central-build') . ' </span>',
                        ));
?>
                    </div>
                    
                    <div class="home-one-why-us-right">
                        <div class="image-hover-block">
                            <?php $blog_image = get_theme_mod('central_build_blog_image'); ?>
                            <?php if ($blog_image) : ?>
                                <img src="<?php echo esc_url($blog_image); ?>" 
                                     loading="lazy" 
                                     height="603" 
                                     alt="<?php esc_attr_e('Blog Image', 'central-build'); ?>" 
                                     width="590" 
                                     class="single-img hovered">
                            <?php else : ?>
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/images/674e5040ddb06406c2a2f88a_ENP07249%20%28Large%29.jpg'); ?>" 
                                     loading="lazy" 
                                     height="603" 
                                     alt="<?php esc_attr_e('Central Build project team on site', 'central-build'); ?>" 
                                     width="590" 
                                     class="single-img hovered">
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php else : ?>
                <div class="w-layout-hflex home-one-why-us-flex">
                    <div class="home-one-why-us-left">
                        <div class="w-layout-hflex heading-box">
                            <h2 class="heading-wrap"><?php esc_html_e('No Posts Found', 'central-build'); ?></h2>
                        </div>
                        <div class="devider-one"></div>
                        <div class="home-one-project-block">
                            <div class="heading-six"><?php esc_html_e('Nothing here yet', 'central-build'); ?></div>
                            <p class="home-one-way-us-paragraph">
                                <?php if (is_home() && current_user_can('publish_posts')) : ?>
                                    <?php printf(
                                        wp_kses(
                                            __('Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'central-build'),
                                            array('a' => array('href' => array()))
                                        ),
                                        esc_url(admin_url('post-new.php'))
                                    ); ?>
                                <?php elseif (is_search()) : ?>
                                    <?php esc_html_e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'central-build'); ?>
                                    <?php get_search_form(); ?>
                                <?php else : ?>
                                    <?php esc_html_e('It seems we can\'t find what you\'re looking for. Perhaps searching can help.', 'central-build'); ?>
                                    <?php get_search_form(); ?>
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                    <div class="home-one-why-us-right">
                        <div class="image-hover-block">
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/images/674e5040ddb06406c2a2f88a_ENP07249%20%28Large%29.jpg'); ?>" 
                                 loading="lazy" 
                                 height="603" 
                                 alt="<?php esc_attr_e('Central Build project team', 'central-build'); ?>" 
                                 width="590" 
                                 class="single-img hovered">
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="w-layout-blockcontainer container-one cta-container w-container">
            <div class="cta">
                <h3 class="color-white margin-bottom-twenty"><?php esc_html_e('Ready to Start Your Project?', 'central-build'); ?></h3>
                <p class="cta-text"><?php esc_html_e('Get in touch with our team to discuss your commercial fitout needs. We\'re here to help bring your vision to life with our expertise and dedication to quality.', 'central-build'); ?></p>
                <a href="<?php echo esc_url(home_url('/contact')); ?>" role="button" data-w-id="8fb97af1-9681-6946-9a0f-451bff58b659" class="cta-hero-button w-inline-block">
                    <div class="button-mask">
                        <div class="link-text-wrp">
                            <div><?php esc_html_e('Contact Us Today!', 'central-build'); ?></div>
                            <div class="secondt-btn-text"><?php esc_html_e('Get Started', 'central-build'); ?></div>
                        </div>
                    </div>
                </a>
            </div>
            <?php $cta_bg_image = get_theme_mod('central_build_cta_bg_image'); ?>
            <?php if ($cta_bg_image) : ?>
                <img src="<?php echo esc_url($cta_bg_image); ?>" 
                     loading="lazy" 
                     alt="<?php esc_attr_e('Background', 'central-build'); ?>" 
                     class="image-5">
            <?php else : ?>
                <img src="<?php echo esc_url(get_template_directory_uri() . '/images/688c08b213c2af647f152459_5%20%28Large%29.jpg'); ?>" 
                     loading="lazy" 
                     alt="<?php esc_attr_e('Background', 'central-build'); ?>" 
                     class="image-5">
            <?php endif; ?>
        </div>
        <div class="cta-overlay"></div>
    </section>

</main>

<?php get_footer(); ?>
