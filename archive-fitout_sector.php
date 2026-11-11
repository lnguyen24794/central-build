<?php
/**
 * Projects (all) and project categories (Completed / Upcoming): one grid with a filter.
 *
 * @package Central_Build_Pro
 */

$term     = is_tax('fitout_category') ? get_queried_object() : null;
$current  = $term ? $term->slug : '';
$terms    = get_terms(array('taxonomy' => 'fitout_category', 'hide_empty' => false, 'slug' => array('fitout-projects', 'upcoming-projects')));
$all_ids  = get_posts(array('post_type' => 'fitout_sector', 'post_status' => 'publish', 'numberposts' => 1, 'fields' => 'ids', 'orderby' => 'date'));
$hero_img = $all_ids ? cb_ui_project_image((int) $all_ids[0], 'full') : 'cb/cb-project-hero.jpg';
$title    = $term ? $term->name : __('Our Projects', 'central-build');
$text     = $term && cb_ui_plain($term->description) !== ''
    ? $term->description
    : __('Restaurants, cafés, food court shops, health and beauty spaces and building conversions across Victoria, designed and built by Central Build.', 'central-build');

get_header();
?>
<main id="primary" class="site-main cb-page">
    <?php
    cb_ui_hero(array(
        'eyebrow' => __('Projects', 'central-build'),
        'title'   => $title,
        'text'    => $text,
        'image'   => $hero_img,
    ));

    cb_ui_section_open('project-list', 'white');
    echo '<nav class="cb-filter" aria-label="' . esc_attr__('Filter projects', 'central-build') . '">';
    echo '<a href="' . esc_url(home_url('/projects/')) . '"' . ($current === '' ? ' class="is-active" aria-current="page"' : '') . '>' . esc_html__('All projects', 'central-build') . '</a>';
    if (!is_wp_error($terms)) {
        foreach ($terms as $t) {
            $active = $current === $t->slug;
            echo '<a href="' . esc_url(get_term_link($t)) . '"' . ($active ? ' class="is-active" aria-current="page"' : '') . '>' . esc_html($t->name) . '</a>';
        }
    }
    echo '</nav>';
    $shown = cb_ui_projects(array(
        'count'       => -1,
        'category'    => $current,
        'show_status' => $current === '',
        'empty'       => $current === 'upcoming-projects'
            ? __('New projects are in design now. Check back soon, or ask us about what we are building next.', 'central-build')
            : __('No projects here yet.', 'central-build'),
    ));
    cb_ui_section_close();

    cb_ui_cta(array(
        'eyebrow' => __('Your project next', 'central-build'),
        'title'   => __('Planning a fitout, a stripout or a refresh?', 'central-build'),
        'text'    => __('Tell us about your space and we will come back with a realistic budget and program.', 'central-build'),
        'buttons' => array(
            array('label' => __('Request a quote', 'central-build'), 'url' => home_url('/contact/')),
            array('label' => __('Call 1300 31 8888', 'central-build'), 'url' => 'tel:1300318888'),
        ),
    ));
    ?>
</main>
<?php
get_footer();
