<?php
/**
 * The template for displaying all single posts
 *
 * @package Central_Build_Pro
 * @since 1.0.0
 */

get_header();
?>

<?php
// Get custom field data
$hero_image = get_post_meta(get_the_ID(), '_fitout_hero_image', true);
$client = get_post_meta(get_the_ID(), '_fitout_client', true);
$location = get_post_meta(get_the_ID(), '_fitout_location', true);
$sqm = get_post_meta(get_the_ID(), '_fitout_sqm', true);
$created_date = get_post_meta(get_the_ID(), '_fitout_created_date', true);
$about_image = get_post_meta(get_the_ID(), '_fitout_about_image', true);
$about_project = get_post_meta(get_the_ID(), '_fitout_about_project', true);
$key_elements = get_post_meta(get_the_ID(), '_fitout_key_elements', true);
$cta_text = get_post_meta(get_the_ID(), '_fitout_cta_text', true);
$final_result = get_post_meta(get_the_ID(), '_fitout_final_result', true);
$quote_text = get_post_meta(get_the_ID(), '_fitout_quote_text', true);
$quote_author = get_post_meta(get_the_ID(), '_fitout_quote_author', true);
$quote_position = get_post_meta(get_the_ID(), '_fitout_quote_position', true);
$gallery_images = get_post_meta(get_the_ID(), '_fitout_gallery_images', true);

// Fallback for hero image
if (!$hero_image && has_post_thumbnail()) {
    $hero_image = get_the_post_thumbnail_url(get_the_ID(), 'large');
}
if (!$hero_image) {
    $hero_image = 'https://cdn.prod.website-files.com/66f1ffecdef9310969f57993/68ba19ba9b593f2cdc33a4ba_2.jpg';
}

// Fallback for about image
if (!$about_image) {
    $about_image = 'https://cdn.prod.website-files.com/66f1ffecdef9310969f57993/68ba1b0c5a10af62de490dcb_5.jpg';
}

// Format created date
$formatted_date = $created_date ? date('F j, Y', strtotime($created_date)) : 'September 4, 2025';
?>

<main id="primary" class="site-main">
    <section style="background-image: url('<?php echo esc_url($hero_image); ?>');" class="project-details-hero-section">
        <div class="w-layout-blockcontainer container-one w-container">
            <div class="w-layout-vflex helping-flex landing-innerpage-block project-details-heading-block">
                <h1 class="color-white margin-bottom-twenty margin-top-zero"><?php echo esc_html(get_the_title()); ?></h1>
                <p class="project-details-hero-txt"><?php echo esc_html(get_the_excerpt() ?: 'A professional fitout project designed to meet specific business requirements.'); ?></p>
            </div>
        </div>
    </section>
    <section class="project-details-section-two">
        <div class="w-layout-blockcontainer container-one w-container">
            <div
                data-w-id="0a152d40-d08e-591a-6fa1-7f07e47e895c"
                class="w-layout-hflex project-heading-wrap padding-off"
                style="opacity: 1; transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg, 0deg); transform-style: preserve-3d;"
            >
                <h2 class="margin-none project-details-heading"><?php echo esc_html(get_the_title()); ?></h2>
            </div>
            <div class="paragraph">
                <?php echo wp_kses_post(get_the_content()); ?>
            </div>
            <div class="w-layout-hflex project-details-flex-one">
                <div style="background-image: url('<?php echo esc_url($hero_image); ?>');" class="project-details-left"></div>
                <div class="project-details-right">
                    <div class="project-details-description-block">
                        <p class="create-heading">created:</p>
                        <p class="margin-bottom-zero"><?php echo esc_html($formatted_date); ?></p>
                    </div>
                    <div class="project-details-description-block">
                        <p class="create-heading">client:</p>
                        <p class="margin-bottom-zero"><?php echo esc_html($client ?: 'Client Name'); ?></p>
                    </div>
                    <div class="project-details-description-block">
                        <p class="create-heading">SQM:</p>
                        <p class="margin-bottom-zero"><?php echo esc_html($sqm ?: ''); ?></p>
                    </div>
                    <div class="project-details-description-block">
                        <p class="create-heading">Location:</p>
                        <p class="margin-bottom-zero"><?php echo esc_html($location ?: 'Location'); ?></p>
                    </div>
                </div>
            </div>
            <div class="w-layout-hflex project-details-flex-two">
                <div class="about-project-text-block">
                    <h3 class="margin-top-zero margin-bottom-twenty">About the project</h3>
                    <div class="rich-text-block w-richtext">
                        <?php if ($about_project) : ?>
                            <?php echo wp_kses_post(nl2br($about_project)); ?>
                        <?php else : ?>
                            <p>This professional fitout project was designed and delivered by Central Build to create a functional and aesthetically pleasing space that meets the client's specific requirements.</p>
                        <?php endif; ?>
                        
                        <?php if ($key_elements) : ?>
                            <h3>Key Elements</h3>
                            <ul role="list">
                                <?php 
                                $elements = explode("\n", $key_elements);
                                foreach ($elements as $element) {
                                    $element = trim($element);
                                    if (!empty($element)) {
                                        echo '<li>' . esc_html($element) . '</li>';
                                    }
                                }
                                ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                    
                    <?php if ($quote_text && $quote_author) : ?>
                    <div class="project-details-box">
                        <p class="quote-style">
                            "<?php echo esc_html($quote_text); ?>" <?php echo esc_html($quote_author); ?><?php echo $quote_position ? ', ' . esc_html($quote_position) : ''; ?>, Central Build
                        </p>
                    </div>
                    <?php endif; ?>
                </div>
                <div style="background-image: url('<?php echo esc_url($about_image); ?>');" class="about-project-image-block"></div>
            </div>
        </div>
        <div class="my-container container">
            <div class="blog-details-block-one">
                <div class="w-layout-hflex blog-details-cta-block">
                    <div class="blog-details-cta-left"><div class="blog-cta-text-2 margin-bottom-zero"><?php echo esc_html($cta_text ?: 'Planning a fitout project? Let\'s bring your vision to life with precision and creativity'); ?></div></div>
                    <div class="blog-details-cta-right">
                        <div><img width="45" height="45" alt="Blog Details Arrow" src="https://cdn.prod.website-files.com/66f1ffebdef9310969f57940/66f1ffecdef9310969f57c4d_Blog-Details-Arrow.svg" loading="lazy" /></div>
                    </div>
                </div>
                <div class="rich-text-block-2 w-richtext">
                    <p>
                        <?php echo esc_html($final_result ?: 'The final result is a professional space that meets all functional requirements while maintaining aesthetic appeal and supporting the client\'s business objectives.'); ?>
                    </p>
                </div>
            </div>
            <div class="w-layout-blockcontainer w-container">
                <div class="w-layout-hflex blog-details-author-block-3">
                    <div class="blog-details-author-left"><img width="150" height="150" alt="" src="" loading="lazy" class="blog-details-profile-img-2 w-dyn-bind-empty" /></div>
                    <div class="blog-details-author-right w-dyn-bind-empty"></div>
                </div>
                <div class="collection-list-wrapper-2 w-dyn-list">
                    <div role="list" class="collection-list masonry-grid-wrapper w-dyn-items">
                        <?php 
                        if ($gallery_images && is_array($gallery_images) && !empty($gallery_images)) {
                            foreach ($gallery_images as $image_url) {
                                if (!empty($image_url)) {
                                    echo '<div role="listitem" class="collection-item w-dyn-item w-dyn-repeater-item">';
                                    echo '<img loading="lazy" src="' . esc_url($image_url) . '" alt="' . esc_attr(get_the_title()) . ' Gallery Image" class="collection-item-photo-blog" />';
                                    echo '</div>';
                                }
                            }
                        } else {
                            // Default gallery images if none are set
                            $default_images = array(
                                'https://cdn.prod.website-files.com/66f1ffecdef9310969f57993/68ba1b0c3006f900a6367a7c_1.jpg',
                                'https://cdn.prod.website-files.com/66f1ffecdef9310969f57993/68ba19ba9b593f2cdc33a4ba_2.jpg',
                                'https://cdn.prod.website-files.com/66f1ffecdef9310969f57993/68ba1b0cb4f04a08c47ad260_3.jpg',
                                'https://cdn.prod.website-files.com/66f1ffecdef9310969f57993/68ba1b0cdc78af2a20cd71a0_4.jpg',
                                'https://cdn.prod.website-files.com/66f1ffecdef9310969f57993/68ba1b0c5a10af62de490dcb_5.jpg',
                                'https://cdn.prod.website-files.com/66f1ffecdef9310969f57993/68ba1b0c9c10da277c254db6_DSC02146-HDR%20(Large).jpg'
                            );
                            foreach ($default_images as $image_url) {
                                echo '<div role="listitem" class="collection-item w-dyn-item w-dyn-repeater-item">';
                                echo '<img loading="lazy" src="' . esc_url($image_url) . '" alt="' . esc_attr(get_the_title()) . ' Gallery Image" class="collection-item-photo-blog" />';
                                echo '</div>';
                            }
                        }
                        ?>
                    </div>
                    <?php if (!$gallery_images || empty($gallery_images)) : ?>
                    <div class="empty-state w-dyn-hide w-dyn-empty"></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    <section class="more-project-section">
        <div class="w-layout-blockcontainer container-one w-container">
            <div class="margin-bottom-thirty-two"><h2 class="margin-bottom-twenty margin-top-zero">More Projects</h2></div>
            <?php
            // Get related fitout sector posts
            $current_categories = get_the_terms(get_the_ID(), 'fitout_category');
            $category_ids = array();
            if ($current_categories && !is_wp_error($current_categories)) {
                foreach ($current_categories as $category) {
                    $category_ids[] = $category->term_id;
                }
            }

            $related_query = new WP_Query(array(
                'post_type' => 'fitout_sector',
                'posts_per_page' => 3,
                'post_status' => 'publish',
                'post__not_in' => array(get_the_ID()),
                'tax_query' => array(
                    array(
                        'taxonomy' => 'fitout_category',
                        'field'    => 'term_id',
                        'terms'    => $category_ids,
                    ),
                ),
            ));

            if ($related_query->have_posts()) : ?>
            <div class="w-dyn-list">
                <div role="list" class="projects-flex w-dyn-items">
                    <?php while ($related_query->have_posts()) : $related_query->the_post(); 
                        $related_hero_image = get_post_meta(get_the_ID(), '_fitout_hero_image', true);
                        $related_categories = get_the_terms(get_the_ID(), 'fitout_category');
                        $related_category_name = $related_categories && !is_wp_error($related_categories) ? $related_categories[0]->name : 'Fitout';
                        
                        // Fallback image
                        if (!$related_hero_image && has_post_thumbnail()) {
                            $related_hero_image = get_the_post_thumbnail_url(get_the_ID(), 'large');
                        }
                        if (!$related_hero_image) {
                            $related_hero_image = 'https://cdn.prod.website-files.com/66f1ffebdef9310969f57940/66f1ffecdef9310969f579c4_Image-Bg-Section.webp';
                        }
                    ?>
                    <div role="listitem" class="w-dyn-item">
                        <a href="<?php echo esc_url(get_permalink()); ?>" class="link-block w-inline-block">
                            <div style="background-image: url('<?php echo esc_url($related_hero_image); ?>');" class="project-block-outer project-bg-one padding-off">
                                <div class="listing-two-content">
                                    <div class="w-layout-hflex project-building-flex">
                                        <img src="https://cdn.prod.website-files.com/66f1ffecdef9310969f57993/675917b68734562de6556a81_Hospitality.svg" alt="" width="46.5" height="46" class="project-icon" />
                                        <div class="project-block">
                                            <div class="heading-five text-white margin-none"><?php echo esc_html(get_the_title()); ?></div>
                                            <div class="heading-five text-white margin-none"><?php echo esc_html($related_category_name); ?></div>
                                        </div>
                                    </div>
                                    <div class="project-text-flex"><p><?php echo esc_html(get_the_excerpt() ?: 'Professional fitout project designed to meet specific requirements.'); ?></p></div>
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
            </div>
            <?php endif; ?>
        </div>
    </section>

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
