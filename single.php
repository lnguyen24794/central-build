<?php
/**
 * The template for displaying all single posts
 *
 * @package Central_Build_Pro
 * @since 1.0.0
 */

get_header();
?>

<main id="primary" class="site-main">
    <div class="container">
        <div class="content-area">
            <?php
            while (have_posts()) :
                the_post();
                ?>
                
                <article id="post-<?php the_ID(); ?>" <?php post_class('single-post'); ?>>
                    <header class="entry-header">
                        <?php
                        if (has_post_thumbnail()) : ?>
                            <div class="post-thumbnail">
                                <?php the_post_thumbnail('central-build-featured', array('alt' => get_the_title())); ?>
                            </div>
                        <?php endif; ?>

                        <div class="entry-meta">
                            <span class="posted-on">
                                <time class="entry-date published" datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                                    <?php echo esc_html(get_the_date()); ?>
                                </time>
                            </span>
                            
                            <span class="byline">
                                <?php esc_html_e('by', 'central-build'); ?>
                                <span class="author vcard">
                                    <a class="url fn n" href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
                                        <?php echo esc_html(get_the_author()); ?>
                                    </a>
                                </span>
                            </span>

                            <?php
                            $categories_list = get_the_category_list(esc_html__(', ', 'central-build'));
                if ($categories_list) : ?>
                                <span class="cat-links">
                                    <?php esc_html_e('in', 'central-build'); ?> <?php echo $categories_list; ?>
                                </span>
                            <?php endif; ?>

                            <?php
                $tags_list = get_the_tag_list('', esc_html_x(', ', 'list item separator', 'central-build'));
                if ($tags_list) : ?>
                                <span class="tags-links">
                                    <?php esc_html_e('Tagged', 'central-build'); ?> <?php echo $tags_list; ?>
                                </span>
                            <?php endif; ?>

                            <?php if (comments_open() || get_comments_number()) : ?>
                                <span class="comments-link">
                                    <?php comments_popup_link(
                                        esc_html__('Leave a comment', 'central-build'),
                                        esc_html__('1 Comment', 'central-build'),
                                        esc_html__('% Comments', 'central-build')
                                    ); ?>
                                </span>
                            <?php endif; ?>
                        </div>

                        <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
                    </header>

                    <div class="entry-content">
                        <?php
                        the_content(sprintf(
                            wp_kses(
                                /* translators: %s: Name of current post. Only visible to screen readers */
                                __('Continue reading<span class="screen-reader-text"> "%s"</span>', 'central-build'),
                                array(
                                    'span' => array(
                                        'class' => array(),
                                    ),
                                )
                            ),
                            wp_kses_post(get_the_title())
                        ));

                wp_link_pages(array(
                    'before' => '<div class="page-links">' . esc_html__('Pages:', 'central-build'),
                    'after'  => '</div>',
                ));
                ?>
                    </div>

                    <footer class="entry-footer">
                        <?php
                // Edit post link
                edit_post_link(
                    sprintf(
                        wp_kses(
                            /* translators: %s: Name of current post. Only visible to screen readers */
                            __('Edit <span class="screen-reader-text">"%s"</span>', 'central-build'),
                            array(
                                'span' => array(
                                    'class' => array(),
                                ),
                            )
                        ),
                        wp_kses_post(get_the_title())
                    ),
                    '<span class="edit-link">',
                    '</span>'
                );
                ?>
                    </footer>
                </article>

                <?php
                // Author bio
                if (get_the_author_meta('description')) : ?>
                    <div class="author-info">
                        <div class="author-avatar">
                            <?php echo get_avatar(get_the_author_meta('user_email'), 80); ?>
                        </div>
                        <div class="author-description">
                            <h3 class="author-title">
                                <?php
                        printf(
                            /* translators: %s: Author name */
                            esc_html__('About %s', 'central-build'),
                            '<span class="author-name">' . esc_html(get_the_author()) . '</span>'
                        );
                    ?>
                            </h3>
                            <div class="author-bio">
                                <?php echo wp_kses_post(get_the_author_meta('description')); ?>
                                <a class="author-link" href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>" rel="author">
                                    <?php
                        printf(
                            /* translators: %s: Author name */
                            esc_html__('View all posts by %s', 'central-build'),
                            esc_html(get_the_author())
                        );
                    ?>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php
                // Post navigation
                the_post_navigation(array(
                    'prev_text' => '<span class="nav-subtitle">' . esc_html__('Previous:', 'central-build') . '</span> <span class="nav-title">%title</span>',
                    'next_text' => '<span class="nav-subtitle">' . esc_html__('Next:', 'central-build') . '</span> <span class="nav-title">%title</span>',
                ));

                // Related posts
                central_build_related_posts();

                // If comments are open or we have at least one comment, load up the comment template.
                if (comments_open() || get_comments_number()) :
                    comments_template();
                endif;

            endwhile; // End of the loop.
?>
        </div>

        <?php get_sidebar(); ?>
    </div>
</main>

<?php
get_footer();

/**
 * Display related posts
 */
function central_build_related_posts()
{
    $post_id = get_the_ID();
    $categories = wp_get_post_categories($post_id);

    if (empty($categories)) {
        return;
    }

    $related_posts = get_posts(array(
        'category__in'   => $categories,
        'post__not_in'   => array($post_id),
        'posts_per_page' => 3,
        'post_status'    => 'publish',
    ));

    if (empty($related_posts)) {
        return;
    }
    ?>
    
    <section class="related-posts">
        <h3 class="related-posts-title"><?php esc_html_e('Related Posts', 'central-build'); ?></h3>
        <div class="related-posts-grid">
            <?php foreach ($related_posts as $related_post) :
                setup_postdata($related_post); ?>
                <article class="related-post">
                    <?php if (has_post_thumbnail($related_post->ID)) : ?>
                        <div class="related-post-thumbnail">
                            <a href="<?php echo esc_url(get_permalink($related_post->ID)); ?>">
                                <?php echo get_the_post_thumbnail($related_post->ID, 'central-build-thumbnail', array('alt' => get_the_title($related_post->ID))); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                    
                    <div class="related-post-content">
                        <h4 class="related-post-title">
                            <a href="<?php echo esc_url(get_permalink($related_post->ID)); ?>">
                                <?php echo esc_html(get_the_title($related_post->ID)); ?>
                            </a>
                        </h4>
                        
                        <div class="related-post-meta">
                            <time class="related-post-date" datetime="<?php echo esc_attr(get_the_date('c', $related_post->ID)); ?>">
                                <?php echo esc_html(get_the_date('', $related_post->ID)); ?>
                            </time>
                        </div>
                        
                        <div class="related-post-excerpt">
                            <?php echo wp_kses_post(wp_trim_words(get_the_excerpt($related_post->ID), 15, '...')); ?>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </section>
    
    <?php
    wp_reset_postdata();
}
