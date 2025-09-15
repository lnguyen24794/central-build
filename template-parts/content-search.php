<?php
/**
 * Template part for displaying results in search pages
 *
 * @package Central_Build_Pro
 * @since 1.0.0
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('search-result-item'); ?>>
    <?php if (has_post_thumbnail()) : ?>
        <div class="search-result-thumbnail">
            <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail('central-build-thumbnail', array('alt' => get_the_title())); ?>
            </a>
        </div>
    <?php endif; ?>

    <div class="search-result-content">
        <header class="search-result-header">
            <div class="search-result-meta">
                <span class="post-type">
                    <?php
                    $post_type_obj = get_post_type_object(get_post_type());
echo esc_html($post_type_obj->labels->singular_name);
?>
                </span>
                
                <span class="posted-on">
                    <time class="entry-date published" datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                        <?php echo esc_html(get_the_date()); ?>
                    </time>
                </span>

                <?php
                $categories_list = get_the_category_list(esc_html__(', ', 'central-build'));
if ($categories_list) : ?>
                    <span class="cat-links">
                        <?php echo $categories_list; ?>
                    </span>
                <?php endif; ?>
            </div>

            <?php the_title('<h2 class="search-result-title entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>'); ?>
        </header>

        <div class="search-result-excerpt entry-summary">
            <?php
            // Custom excerpt for search results
            $excerpt = get_the_excerpt();
$search_query = get_search_query();

if ($search_query && $excerpt) {
    // Highlight search terms in excerpt
    $highlighted_excerpt = preg_replace(
        '/(' . preg_quote($search_query, '/') . ')/i',
        '<mark>$1</mark>',
        $excerpt
    );
    echo wp_kses_post($highlighted_excerpt);
} else {
    the_excerpt();
}
?>
        </div>

        <footer class="search-result-footer">
            <a href="<?php the_permalink(); ?>" class="read-more-link">
                <?php esc_html_e('Read More', 'central-build'); ?>
                <span class="screen-reader-text"><?php echo esc_html(get_the_title()); ?></span>
            </a>

            <?php if (comments_open() || get_comments_number()) : ?>
                <span class="comments-link">
                    <?php comments_popup_link(
                        esc_html__('No Comments', 'central-build'),
                        esc_html__('1 Comment', 'central-build'),
                        esc_html__('% Comments', 'central-build')
                    ); ?>
                </span>
            <?php endif; ?>
        </footer>
    </div>
</article>
