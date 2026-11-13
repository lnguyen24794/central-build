<?php
/**
 * Client feedback round 4 (13 Nov 2026). Safe to run more than once.
 *
 *   wp eval-file 2026-11-13-feedback-round4.php
 *
 * - Project order everywhere: Mama Tran, Chez Ami, Hoppers Crossing, Heiwa, Yan Rolls, Laksa King
 *   (Projects > Edit > Order). Drafts follow after them.
 * - Mama Tran Dumplings location: South Melbourne Market.
 * - The Chez Ami 3D walkthrough is shown once, from YouTube (the MP4 copy was the same video).
 */

if (!defined('ABSPATH')) {
    exit(1);
}

$youtube = 'https://www.youtube.com/watch?v=JM2BOY4dB_0&t=67s';
$order   = array(
    'Mama Tran Dumplings',
    'Chez Ami Restaurant',
    'Hoppers Crossing Rooming House',
    'Heiwa Headspa',
    'Yan Rolls & Coffee',
    'Laksa King',
    'Little Summer Coffee Renovation',
    'Southside Dental Fitout',
);

$find = static function (string $title): int {
    $ids = get_posts(array('post_type' => 'fitout_sector', 'post_status' => 'any', 'title' => $title, 'numberposts' => 1, 'fields' => 'ids'));
    return $ids ? (int) $ids[0] : 0;
};

foreach ($order as $n => $title) {
    $id = $find($title);
    if (!$id) {
        WP_CLI::warning("Not found: $title");
        continue;
    }
    wp_update_post(array('ID' => $id, 'menu_order' => $n + 1));
    WP_CLI::log(sprintf('%d. %s (#%d)', $n + 1, $title, $id));
}

$mama = $find('Mama Tran Dumplings');
if ($mama) {
    WP_CLI::log('Mama Tran location was: ' . get_post_meta($mama, '_fitout_location', true));
    update_post_meta($mama, '_fitout_location', 'South Melbourne Market');
}

// Chez Ami project: the 3D walkthrough MP4 becomes the YouTube video.
$chez = $find('Chez Ami Restaurant');
if ($chez) {
    $videos = (array) get_post_meta($chez, '_fitout_videos', true);
    foreach ($videos as $i => $v) {
        if (is_array($v) && strpos((string) ($v['url'] ?? ''), 'chez-ami-3d-walkthrough.mp4') !== false) {
            $videos[$i] = array('url' => $youtube, 'poster' => '', 'title' => $v['title'] ?? '3D and VR design walkthrough');
        }
    }
    update_post_meta($chez, '_fitout_videos', array_values($videos));
    WP_CLI::log('Chez Ami videos: ' . implode(', ', wp_list_pluck($videos, 'url')));
}

// Design page: keep only the YouTube walkthrough.
$cds = get_option('central_build_cds_settings');
if (is_array($cds) && !empty($cds['videos']['items'])) {
    $items = array_values(array_filter((array) $cds['videos']['items'], static function ($v) {
        $url = (string) ($v['url'] ?? '');
        return strpos($url, 'youtube.com') !== false || strpos($url, 'youtu.be') !== false;
    }));
    if (!$items) {
        $items = array(array('title' => 'Chez Ami Restaurant: 3D and VR design walkthrough', 'url' => $youtube, 'poster_image' => ''));
    }
    $cds['videos']['items'] = $items;
    update_option('central_build_cds_settings', $cds);
    WP_CLI::log('Design page videos: ' . count($items));
}

WP_CLI::success('Round 4 content updated.');
