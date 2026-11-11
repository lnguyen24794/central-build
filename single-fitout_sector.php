<?php
/**
 * Single project – reads like a case study: facts, story, videos, photos, next projects.
 * Content: Projects > edit project (details, photos, videos).
 *
 * @package Central_Build_Pro
 */

get_header();

while (have_posts()) :
    the_post();
    $id       = get_the_ID();
    $meta     = static function ($k) use ($id) { return (string) get_post_meta($id, $k, true); };
    $hero_img = $meta('_fitout_hero_image') ?: cb_ui_project_image($id, 'full');
    $about    = $meta('_fitout_about_image') ?: $hero_img;
    $location = cb_ui_plain($meta('_fitout_location'));
    $suburb   = cb_ui_short_location($location);
    $status   = cb_ui_project_status($id);
    $gallery  = array_values(array_filter((array) get_post_meta($id, '_fitout_gallery_images', true)));
    $videos   = array_values(array_filter((array) get_post_meta($id, '_fitout_videos', true)));

    // "Label: value" lines in Key Elements become facts; the rest stay as a list.
    $facts = array();
    $list  = array();
    foreach (preg_split('/\r?\n/', $meta('_fitout_key_elements')) as $line) {
        $line = cb_ui_plain($line);
        if ($line === '') {
            continue;
        }
        if (preg_match('/^(scope|scopes|project value|value|duration|type)\s*:\s*(.+)$/i', $line, $m)) {
            $label = ucfirst(strtolower(rtrim($m[1], 's')));
            $label = $label === 'Project value' ? 'Value' : $label;
            $facts[$label] = preg_replace('/\s*\(.*\)$/', '', $m[2]);
        } else {
            $list[] = $line;
        }
    }
    $fact_rows = array();
    if ($suburb !== '') {
        $fact_rows[] = array($suburb, 'Location');
    }
    if ($meta('_fitout_sqm') !== '') {
        $fact_rows[] = array($meta('_fitout_sqm'), 'Area');
    }
    foreach (array('Value', 'Duration', 'Scope') as $k) {
        if (!empty($facts[$k])) {
            $fact_rows[] = array($facts[$k], $k);
        }
    }
    if ($meta('_fitout_created_date') !== '') {
        $fact_rows[] = array(date_i18n('M Y', strtotime($meta('_fitout_created_date'))), 'Completed');
    } else {
        $fact_rows[] = array($status, 'Status');
    }
    if (!empty($facts['Type'])) {
        array_unshift($list, $facts['Type']);
    }
    $story = $meta('_fitout_about_project') ?: get_the_excerpt();
    ?>
    <main id="primary" class="site-main cb-page">
        <?php
        cb_ui_hero(array(
            'eyebrow' => $status . ($suburb !== '' ? ' · ' . $suburb : ''),
            'title'   => get_the_title(),
            'text'    => get_the_excerpt(),
            'image'   => $hero_img,
        ));

        echo '<section class="cb-section is-white is-tight"><div class="cb-wrap">';
        cb_ui_facts($fact_rows);
        echo '</div></section>';

        cb_ui_section_open('story', 'white', 'is-tight');
        echo '<div class="cb-split is-whole">';
        echo '<div class="cb-split__media"><img src="' . esc_url($about) . '" alt="' . esc_attr(get_the_title()) . '" decoding="async"></div>';
        echo '<div class="cb-split__body"><div><span class="cb-eyebrow">' . esc_html__('About the project', 'central-build') . '</span>';
        echo '<h2>' . esc_html(get_the_title()) . '</h2></div>';
        $paras = array_values(array_filter(array_map('cb_ui_plain', preg_split('/\n\s*\n/', (string) $story))));
        if ($paras) {
            echo '<div class="cb-text"><p>' . implode('</p><p>', array_map('esc_html', $paras)) . '</p></div>';
        }
        cb_ui_list($list);
        if ($meta('_fitout_final_result') !== '') {
            echo '<p class="cb-lead" style="color:var(--cb-navy)">' . esc_html(cb_ui_plain($meta('_fitout_final_result'))) . '</p>';
        }
        echo '</div></div>';
        cb_ui_section_close();

        if ($videos) {
            cb_ui_section_open('project-videos', 'navy');
            cb_ui_head(__('Project videos', 'central-build'), $meta('_fitout_videos_heading') ?: __('See the project in motion', 'central-build'), $meta('_fitout_videos_intro'));
            central_build_render_video_wall($videos);
            cb_ui_section_close();
        }

        if ($gallery) {
            cb_ui_section_open('photos', $videos ? 'white' : 'mist');
            cb_ui_head(__('Photos', 'central-build'), __('Project gallery', 'central-build'), '', 'single');
            echo '<div class="cb-gallery">';
            foreach ($gallery as $n => $url) {
                echo '<a href="' . esc_url($url) . '" target="_blank" rel="noopener"><img src="' . esc_url($url) . '" alt="' . esc_attr(sprintf(__('%1$s – photo %2$d', 'central-build'), get_the_title(), $n + 1)) . '" loading="lazy" decoding="async"></a>';
            }
            echo '</div>';
            cb_ui_section_close();
        }

        $quote = cb_ui_plain($meta('_fitout_quote_text'));
        if ($quote !== '' && $meta('_fitout_quote_author') !== '') {
            cb_ui_section_open('quote', 'white', 'is-tight');
            echo '<blockquote style="margin:0;max-width:820px"><p class="cb-lead" style="font-size:1.5rem;color:var(--cb-navy)">&ldquo;' . esc_html($quote) . '&rdquo;</p>';
            echo '<footer class="cb-tile__meta" style="margin-top:14px">' . esc_html(cb_ui_plain($meta('_fitout_quote_author'))) . ($meta('_fitout_quote_position') !== '' ? ', ' . esc_html(cb_ui_plain($meta('_fitout_quote_position'))) : '') . '</footer></blockquote>';
            cb_ui_section_close();
        }

        cb_ui_section_open('more-projects', 'mist');
        echo '<div class="cb-head"><div><span class="cb-eyebrow">' . esc_html__('More work', 'central-build') . '</span><h2>' . esc_html__('Other projects', 'central-build') . '</h2></div>';
        echo '<div class="cb-btns" style="justify-self:end"><a class="cb-btn is-outline" href="' . esc_url(home_url('/projects/')) . '">' . esc_html__('View all projects', 'central-build') . '</a></div></div>';
        cb_ui_projects(array('count' => 3, 'exclude' => array($id), 'category' => 'fitout-projects'));
        cb_ui_section_close();

        cb_ui_cta(array(
            'eyebrow' => __('Your project next', 'central-build'),
            'title'   => cb_ui_plain($meta('_fitout_cta_text')) ?: __('Planning a similar space?', 'central-build'),
            'text'    => __('Tell us about your site and we will come back with a realistic budget and program.', 'central-build'),
            'buttons' => array(
                array('label' => __('Request a quote', 'central-build'), 'url' => home_url('/contact/')),
                array('label' => __('Call 1300 31 8888', 'central-build'), 'url' => 'tel:1300318888'),
            ),
        ));
        ?>
    </main>
    <?php
endwhile;

get_footer();
