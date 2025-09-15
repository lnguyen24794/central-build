<?php
/**
 * Template part for displaying posts
 *
 * @package Central_Build_Pro
 * @since 1.0.0
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('post-item'); ?>>
    <?php if (has_post_thumbnail()) : ?>
        <div class="post-thumbnail">
            <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail('central-build-featured', array('alt' => get_the_title())); ?>
            </a>
        </div>
    <?php endif; ?>

    <div class="post-content-wrapper">
        <header class="post-header">
            <div class="post-meta">
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
            </div>

            <?php
            if (is_singular()) :
                the_title('<h1 class="post-title entry-title">', '</h1>');
            else :
                the_title('<h2 class="post-title entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
            endif;
?>
        </header>

        <div class="post-content entry-content">
            <?php
if (is_singular() || is_home()) {
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
} else {
    the_excerpt();
}
?>
        </div>

        <footer class="post-footer entry-footer">
            <?php if (!is_singular()) : ?>
                <a href="<?php the_permalink(); ?>" class="read-more-link btn btn-primary">
                    <?php esc_html_e('Read More', 'central-build'); ?>
                </a>
            <?php endif; ?>

            <?php
$tags_list = get_the_tag_list('', esc_html_x(', ', 'list item separator', 'central-build'));
if ($tags_list) : ?>
                <div class="tags-links">
                    <span class="tags-label"><?php esc_html_e('Tags:', 'central-build'); ?></span>
                    <?php echo $tags_list; ?>
                </div>
            <?php endif; ?>

            <?php if (comments_open() || get_comments_number()) : ?>
                <div class="comments-link">
                    <?php comments_popup_link(
                        esc_html__('Leave a comment', 'central-build'),
                        esc_html__('1 Comment', 'central-build'),
                        esc_html__('% Comments', 'central-build')
                    ); ?>
                </div>
            <?php endif; ?>

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
    </div>
</article>
