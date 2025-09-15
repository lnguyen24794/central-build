<?php
/**
 * The template for displaying search results pages
 *
 * @package Central_Build_Pro
 * @since 1.0.0
 */

get_header();
?>

<main id="primary" class="site-main">
    <div class="container">
        <div class="content-area">
            <?php if (have_posts()) : ?>

                <header class="page-header search-header">
                    <h1 class="page-title">
                        <?php
                        printf(
                            /* translators: %s: search query. */
                            esc_html__('Search Results for: %s', 'central-build'),
                            '<span class="search-query">' . get_search_query() . '</span>'
                        );
                ?>
                    </h1>
                    
                    <div class="search-form-container">
                        <p><?php esc_html_e('Try a different search term:', 'central-build'); ?></p>
                        <?php get_search_form(); ?>
                    </div>
                </header>

                <div class="posts-container search-results">
                    <?php
                    // Start the Loop
                    while (have_posts()) :
                        the_post();

                        /**
                         * Run the loop for the search to output the results.
                         * If you want to overload this in a child theme then include a file
                         * called content-search.php and that will be used instead.
                         */
                        get_template_part('template-parts/content', 'search');

                    endwhile;
                ?>
                </div>

                <?php
                // Previous/next page navigation
                the_posts_pagination(array(
                'mid_size'  => 2,
                'prev_text' => esc_html__('Previous', 'central-build'),
                'next_text' => esc_html__('Next', 'central-build'),
                'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__('Page', 'central-build') . ' </span>',
                ));
                ?>

            <?php else : ?>

                <section class="no-results not-found">
                    <header class="page-header">
                        <h1 class="page-title">
                            <?php
                            printf(
                                /* translators: %s: search query. */
                                esc_html__('Nothing found for: %s', 'central-build'),
                                '<span class="search-query">' . get_search_query() . '</span>'
                            );
                ?>
                        </h1>
                    </header>

                    <div class="page-content">
                        <p><?php esc_html_e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'central-build'); ?></p>
                        
                        <div class="search-suggestions">
                            <h3><?php esc_html_e('Search Suggestions:', 'central-build'); ?></h3>
                            <ul>
                                <li><?php esc_html_e('Make sure all words are spelled correctly.', 'central-build'); ?></li>
                                <li><?php esc_html_e('Try different keywords.', 'central-build'); ?></li>
                                <li><?php esc_html_e('Try more general keywords.', 'central-build'); ?></li>
                                <li><?php esc_html_e('Try fewer keywords.', 'central-build'); ?></li>
                            </ul>
                        </div>

                        <?php get_search_form(); ?>

                        <!-- Popular posts or categories -->
                        <div class="search-alternatives">
                            <h3><?php esc_html_e('Popular Content', 'central-build'); ?></h3>
                            
                            <?php
                // Get popular posts
                $popular_posts = get_posts(array(
                    'posts_per_page' => 5,
                    'meta_key' => 'post_views_count',
                    'orderby' => 'meta_value_num',
                    'order' => 'DESC',
                ));

                if ($popular_posts) : ?>
                                <div class="popular-posts">
                                    <h4><?php esc_html_e('Popular Posts', 'central-build'); ?></h4>
                                    <ul>
                                        <?php foreach ($popular_posts as $post) : setup_postdata($post); ?>
                                            <li>
                                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                                <?php wp_reset_postdata();
                endif;

// Get categories
$categories = get_categories(array(
    'orderby' => 'count',
    'order'   => 'DESC',
    'number'  => 5,
));

if ($categories) : ?>
                                <div class="popular-categories">
                                    <h4><?php esc_html_e('Browse by Category', 'central-build'); ?></h4>
                                    <ul>
                                        <?php foreach ($categories as $category) : ?>
                                            <li>
                                                <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>">
                                                    <?php echo esc_html($category->name); ?>
                                                    <span class="post-count">(<?php echo $category->count; ?>)</span>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </section>

            <?php endif; ?>
        </div>

        <?php get_sidebar(); ?>
    </div>
</main>

<?php
get_footer();
