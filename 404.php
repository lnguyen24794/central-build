<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package Central_Build_Pro
 * @since 1.0.0
 */

get_header();
?>

<main id="primary" class="site-main">
    <div class="container">
        <div class="content-area">
            <section class="error-404 not-found">
                <header class="page-header">
                    <h1 class="page-title"><?php esc_html_e('Oops! That page can&rsquo;t be found.', 'central-build'); ?></h1>
                </header>

                <div class="page-content">
                    <div class="error-404-content">
                        <div class="error-404-number">404</div>
                        <p class="error-404-message"><?php esc_html_e('It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'central-build'); ?></p>
                    </div>

                    <div class="error-404-search">
                        <?php get_search_form(); ?>
                    </div>

                    <div class="error-404-widgets">
                        <div class="widget-area-404">
                            <div class="widget">
                                <h3 class="widget-title"><?php esc_html_e('Most Used Categories', 'central-build'); ?></h3>
                                <?php
                                wp_list_categories(array(
                                    'orderby'    => 'count',
                                    'order'      => 'DESC',
                                    'show_count' => 1,
                                    'title_li'   => '',
                                    'number'     => 10,
                                ));
?>
                            </div>

                            <div class="widget">
                                <h3 class="widget-title"><?php esc_html_e('Recent Posts', 'central-build'); ?></h3>
                                <?php
$recent_posts = wp_get_recent_posts(array(
    'numberposts' => 5,
    'post_status' => 'publish',
));

if ($recent_posts) : ?>
                                    <ul>
                                        <?php foreach ($recent_posts as $recent) : ?>
                                            <li>
                                                <a href="<?php echo esc_url(get_permalink($recent['ID'])); ?>">
                                                    <?php echo esc_html($recent['post_title']); ?>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </div>

                            <div class="widget">
                                <h3 class="widget-title"><?php esc_html_e('Archives', 'central-build'); ?></h3>
                                <?php
wp_get_archives(array(
    'type'  => 'monthly',
    'limit' => 12,
));
?>
                            </div>

                            <div class="widget">
                                <h3 class="widget-title"><?php esc_html_e('Tag Cloud', 'central-build'); ?></h3>
                                <?php
wp_tag_cloud(array(
    'smallest' => 1,
    'largest'  => 22,
    'unit'     => 'pt',
    'number'   => 45,
));
?>
                            </div>
                        </div>
                    </div>

                    <div class="error-404-navigation">
                        <h3><?php esc_html_e('Quick Navigation', 'central-build'); ?></h3>
                        <div class="quick-nav-links">
                            <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary">
                                <?php esc_html_e('Go to Homepage', 'central-build'); ?>
                            </a>
                            
                            <?php if (get_permalink(get_page_by_path('contact'))) : ?>
                                <a href="<?php echo esc_url(get_permalink(get_page_by_path('contact'))); ?>" class="btn btn-secondary">
                                    <?php esc_html_e('Contact Us', 'central-build'); ?>
                                </a>
                            <?php endif; ?>
                            
                            <?php if (get_permalink(get_page_by_path('about'))) : ?>
                                <a href="<?php echo esc_url(get_permalink(get_page_by_path('about'))); ?>" class="btn btn-secondary">
                                    <?php esc_html_e('About Us', 'central-build'); ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</main>

<?php
get_footer();
