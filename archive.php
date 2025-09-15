<?php
/**
 * The template for displaying archive pages
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

                <header class="page-header archive-header">
                    <?php
                    the_archive_title('<h1 class="page-title">', '</h1>');
                the_archive_description('<div class="archive-description">', '</div>');
                ?>
                </header>

                <div class="posts-container archive-posts">
                    <?php
                // Start the Loop
                while (have_posts()) :
                    the_post();

                    /*
                     * Include the Post-Type-specific template for the content.
                     * If you want to override this in a child theme, then include a file
                     * called content-___.php (where ___ is the Post Type name) and that will be used instead.
                     */
                    get_template_part('template-parts/content', get_post_type());

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
                        <h1 class="page-title"><?php esc_html_e('Nothing here', 'central-build'); ?></h1>
                    </header>

                    <div class="page-content">
                        <p><?php esc_html_e('It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'central-build'); ?></p>
                        <?php get_search_form(); ?>
                    </div>
                </section>

            <?php endif; ?>
        </div>

        <?php get_sidebar(); ?>
    </div>
</main>

<?php
get_footer();
