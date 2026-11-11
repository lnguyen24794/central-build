<?php
/**
 * Videos: a "Project Videos" box on each project, and one video wall used by project pages
 * and the Commercial Design and Solutions page.
 *
 * A video is a file from the Media Library (MP4) or a YouTube link, with an optional cover photo.
 * The wall keeps every video in its own shape (16:9 walkthroughs next to 9:16 phone clips, all the
 * same height), so nothing is cropped.
 *
 * @package Central_Build_Pro
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * One stored video -> what the wall needs: type, src, poster, ratio (width / height), title.
 *
 * @param array $item  url, poster (optional), title (optional)
 */
function central_build_video_item(array $item): array
{
    $url    = trim((string) ($item['url'] ?? ''));
    $poster = trim((string) ($item['poster'] ?? ''));
    $title  = trim(wp_strip_all_tags((string) ($item['title'] ?? '')));
    if ($url === '') {
        return array();
    }
    if (function_exists('central_build_youtube_embed') && ($embed = central_build_youtube_embed($url))) {
        return array('type' => 'youtube', 'src' => $embed, 'poster' => '', 'ratio' => 16 / 9, 'title' => $title);
    }
    if (!preg_match('~\.(mp4|m4v|webm|mov)(\?.*)?$~i', $url)) {
        return array();
    }
    $ratio = 16 / 9;
    $id    = attachment_url_to_postid($url);
    if ($id) {
        $meta = wp_get_attachment_metadata($id);
        if (!empty($meta['width']) && !empty($meta['height'])) {
            $ratio = (float) $meta['width'] / (float) $meta['height'];
        }
    }
    if (!empty($item['ratio']) && (float) $item['ratio'] > 0) {
        $ratio = (float) $item['ratio'];
    }
    return array('type' => 'file', 'src' => $url, 'poster' => $poster, 'ratio' => $ratio, 'title' => $title);
}

/**
 * The video wall. Items are stored videos (url, poster, title).
 */
function central_build_render_video_wall(array $items): void
{
    $videos = array_values(array_filter(array_map(static function ($i) {
        return is_array($i) ? central_build_video_item($i) : array();
    }, $items)));
    if (!$videos) {
        return;
    }
    $portrait = count(array_filter($videos, static function ($v) { return $v['ratio'] < 1; }));
    ?>
    <div class="cb-video-wall<?php echo $portrait ? ' has-portrait' : ''; ?>" data-count="<?php echo count($videos); ?>">
        <?php foreach ($videos as $i => $v) :
            $label = $v['title'] ?: sprintf(__('Central Build video %d', 'central-build'), $i + 1);
            $shape = $v['ratio'] < 1 ? 'is-portrait' : 'is-landscape'; ?>
            <div class="cb-video <?php echo esc_attr($shape); ?>" style="--r: <?php echo esc_attr(number_format($v['ratio'], 4, '.', '')); ?>;">
                <?php if ($v['type'] === 'youtube') : ?>
                    <iframe src="<?php echo esc_url($v['src']); ?>" title="<?php echo esc_attr($label); ?>" loading="lazy" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                <?php else : ?>
                    <video controls playsinline preload="none"<?php echo $v['poster'] ? ' poster="' . esc_url($v['poster']) . '"' : ''; ?> aria-label="<?php echo esc_attr($label); ?>" title="<?php echo esc_attr($label); ?>">
                        <source src="<?php echo esc_url($v['src']); ?>" type="video/mp4" />
                    </video>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
    <?php
}

/* ------------------------------------------------------------------ project box */

add_action('add_meta_boxes', static function () {
    add_meta_box('fitout_sector_videos', __('Project Videos', 'central-build'), 'central_build_project_videos_box', 'fitout_sector', 'normal', 'high');
});

function central_build_project_videos_box($post): void
{
    $videos = get_post_meta($post->ID, '_fitout_videos', true);
    $videos = is_array($videos) ? $videos : array();
    ?>
    <p class="description" style="margin-top:0"><?php _e('Videos are shown on the project page after "About the project", in this order. Choose an MP4 from the Media Library or paste a YouTube link. Phone (portrait) videos and wide videos can be mixed. Drag a video to move it.', 'central-build'); ?></p>
    <table class="form-table" role="presentation">
        <tr>
            <th><label for="fitout_videos_heading"><?php _e('Heading', 'central-build'); ?></label></th>
            <td><input type="text" id="fitout_videos_heading" name="fitout_videos_heading" class="large-text" value="<?php echo esc_attr((string) get_post_meta($post->ID, '_fitout_videos_heading', true)); ?>" placeholder="<?php esc_attr_e('See the project in motion', 'central-build'); ?>" /></td>
        </tr>
        <tr>
            <th><label for="fitout_videos_intro"><?php _e('Short text next to the heading', 'central-build'); ?></label></th>
            <td><textarea id="fitout_videos_intro" name="fitout_videos_intro" rows="3" class="large-text"><?php echo esc_textarea((string) get_post_meta($post->ID, '_fitout_videos_intro', true)); ?></textarea></td>
        </tr>
    </table>
    <ul id="cb-project-videos" class="cb-project-videos">
        <?php foreach ($videos as $v) { central_build_project_video_row((array) $v); } ?>
    </ul>
    <script type="text/html" id="tmpl-cb-project-video-row"><?php central_build_project_video_row(array()); ?></script>
    <input type="hidden" name="fitout_videos_present" value="1" />
    <p><button type="button" class="button button-primary" id="cb-project-video-add"><?php _e('+ Add a video', 'central-build'); ?></button></p>
    <?php
}

function central_build_project_video_row(array $v): void
{
    $url    = (string) ($v['url'] ?? '');
    $poster = (string) ($v['poster'] ?? '');
    $title  = (string) ($v['title'] ?? '');
    ?>
    <li class="cb-project-video">
        <span class="cb-project-video__handle dashicons dashicons-move" title="<?php esc_attr_e('Drag to move', 'central-build'); ?>"></span>
        <div class="cb-project-video__fields">
            <label><?php _e('Video (MP4 file or YouTube link)', 'central-build'); ?>
                <span class="cb-project-video__line">
                    <input type="text" class="large-text cb-project-video__url" name="fitout_videos[url][]" value="<?php echo esc_attr($url); ?>" placeholder="https://www.youtube.com/watch?v=..." />
                    <button type="button" class="button cb-project-video__choose"><?php _e('Choose video file', 'central-build'); ?></button>
                </span>
            </label>
            <label><?php _e('Name (for your reference and screen readers)', 'central-build'); ?>
                <input type="text" class="large-text" name="fitout_videos[title][]" value="<?php echo esc_attr($title); ?>" placeholder="<?php esc_attr_e('e.g. 3D design walkthrough', 'central-build'); ?>" />
            </label>
            <div class="cb-project-video__poster">
                <span><?php _e('Cover photo (optional, shown before the video plays)', 'central-build'); ?></span>
                <?php central_build_project_image_picker('fitout_videos[poster][]', $poster); ?>
            </div>
        </div>
        <button type="button" class="button-link cb-project-video__remove"><?php _e('Remove video', 'central-build'); ?></button>
    </li>
    <?php
}

add_action('save_post_fitout_sector', static function ($post_id) {
    if (!isset($_POST['central_build_fitout_sector_nonce']) || !wp_verify_nonce($_POST['central_build_fitout_sector_nonce'], 'central_build_fitout_sector_meta')) {
        return;
    }
    if ((defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) || !current_user_can('edit_post', $post_id) || !isset($_POST['fitout_videos_present'])) {
        return;
    }
    $in     = wp_unslash((array) ($_POST['fitout_videos'] ?? array()));
    $urls   = (array) ($in['url'] ?? array());
    $out    = array();
    foreach ($urls as $i => $url) {
        $url = esc_url_raw(trim((string) $url));
        if ($url === '') {
            continue;
        }
        $out[] = array(
            'url'    => $url,
            'poster' => esc_url_raw((string) ($in['poster'][$i] ?? '')),
            'title'  => sanitize_text_field((string) ($in['title'][$i] ?? '')),
        );
    }
    update_post_meta($post_id, '_fitout_videos', $out);
    update_post_meta($post_id, '_fitout_videos_heading', sanitize_text_field(wp_unslash((string) ($_POST['fitout_videos_heading'] ?? ''))));
    update_post_meta($post_id, '_fitout_videos_intro', sanitize_textarea_field(wp_unslash((string) ($_POST['fitout_videos_intro'] ?? ''))));
});

add_action('admin_footer', static function () {
    $screen = function_exists('get_current_screen') ? get_current_screen() : null;
    if (!$screen || $screen->post_type !== 'fitout_sector' || $screen->base !== 'post') {
        return;
    }
    ?>
    <style>
        .cb-project-videos { margin: 10px 0; }
        .cb-project-video { display: flex; gap: 12px; align-items: flex-start; border: 1px solid #dcdcde; border-radius: 6px; padding: 12px; background: #fff; margin-bottom: 10px; }
        .cb-project-video__handle { cursor: move; color: #8c8f94; margin-top: 4px; }
        .cb-project-video__fields { flex: 1; display: grid; gap: 10px; }
        .cb-project-video__fields label, .cb-project-video__poster > span { display: grid; gap: 4px; font-weight: 600; }
        .cb-project-video__line { display: flex; gap: 8px; font-weight: 400; }
        .cb-project-video__remove { color: #b32d2e !important; white-space: nowrap; }
    </style>
    <script>
    jQuery(function ($) {
        var $list = $('#cb-project-videos');
        if (!$list.length) { return; }
        $list.sortable({ handle: '.cb-project-video__handle', placeholder: 'cb-project-gallery-placeholder', forcePlaceholderSize: true });
        $('#cb-project-video-add').on('click', function () {
            $list.append($($('#tmpl-cb-project-video-row').html()));
        });
        $list.on('click', '.cb-project-video__remove', function () {
            if (window.confirm('Remove this video from the project page?')) { $(this).closest('li').remove(); }
        });
        $list.on('click', '.cb-project-video__choose', function () {
            var $input = $(this).closest('li').find('.cb-project-video__url');
            var frame = wp.media({ title: 'Choose a video', button: { text: 'Use this video' }, library: { type: 'video' }, multiple: false });
            frame.on('select', function () { $input.val(frame.state().get('selection').first().toJSON().url); });
            frame.open();
        });
    });
    </script>
    <?php
}, 20);
