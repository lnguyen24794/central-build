<?php
/**
 * Project videos and Chez Ami story (11 Nov 2026). Safe to run more than once.
 *
 *   wp eval-file 2026-11-11-project-videos.php <media-root>
 *
 * <media-root>/videos/<name>.mp4 and <name>-poster.jpg (MP4s re-muxed for streaming, unchanged picture)
 *
 * Sources: the client's videos and notes in .docs/ ("CHEZ AMI – The Wait Is Finally Over",
 * "Chez Ami Restaurant" design/VR note).
 */

if (!defined('ABSPATH')) {
    exit(1);
}
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';
require_once ABSPATH . 'wp-admin/includes/image.php';

$root = isset($args[0]) ? rtrim($args[0], '/') : '';
$log  = static function ($m) { WP_CLI::log($m); };

/** Media Library file for videos/<file>, imported once. Returns its URL. */
$media = static function (string $file, string $title) use ($root): string {
    $key = "videos/$file";
    $found = get_posts(array('post_type' => 'attachment', 'post_status' => 'inherit', 'numberposts' => 1, 'fields' => 'ids',
        'meta_key' => '_cb_seed_source', 'meta_value' => $key));
    if ($found) {
        return (string) wp_get_attachment_url((int) $found[0]);
    }
    $path = "$root/videos/$file";
    if (!is_readable($path)) {
        WP_CLI::warning("missing $path");
        return '';
    }
    $tmp = wp_tempnam($file);
    copy($path, $tmp);
    $id = media_handle_sideload(array('name' => $file, 'tmp_name' => $tmp), 0, $title);
    if (is_wp_error($id)) {
        WP_CLI::warning("$file: " . $id->get_error_message());
        @unlink($tmp);
        return '';
    }
    update_post_meta($id, '_cb_seed_source', $key);
    if (wp_attachment_is_image($id)) {
        update_post_meta($id, '_wp_attachment_image_alt', $title);
    }
    WP_CLI::log("Imported $file (#$id)");
    return (string) wp_get_attachment_url($id);
};

$walk        = $media('chez-ami-3d-walkthrough.mp4', 'Chez Ami Restaurant – 3D and VR design walkthrough');
$walk_poster = $media('chez-ami-3d-walkthrough-poster.jpg', 'Chez Ami Restaurant – 3D design of the bar');
$done        = $media('chez-ami-finished.mp4', 'Chez Ami Restaurant – the finished restaurant');
$done_poster = $media('chez-ami-finished-poster.jpg', 'Chez Ami Restaurant – bar on opening');
$hand        = $media('chez-ami-handover.mp4', 'Chez Ami Restaurant – project handover walk-through');
$hand_poster = $media('chez-ami-handover-poster.jpg', 'Chez Ami Restaurant – dining room at handover');

/* --------------------------------------------------------------- Chez Ami project */
$ids = get_posts(array('post_type' => 'fitout_sector', 'post_status' => 'any', 'title' => 'Chez Ami Restaurant', 'numberposts' => 1, 'fields' => 'ids'));
if ($ids) {
    $id = (int) $ids[0];
    $summary = 'A tired, unfinished office in Sale turned into an 80-seat fine dining restaurant in 12 weeks, from concept design to handover.';
    wp_update_post(array('ID' => $id, 'post_excerpt' => $summary, 'post_content' => $summary));
    update_post_meta($id, '_fitout_about_project', "Chez Ami is a fine dining restaurant, café and bar for more than 80 guests in Sale, Victoria, built inside an outdated office.\n\nCentral Build managed every stage: concept design, 3D and VR walkthroughs, approvals, construction, interior fit-out and handover. Our in-house plumbing and electrical trades worked alongside experienced contractors, and the venue was completed in 12 weeks, from 1 May to 23 July 2026.");
    update_post_meta($id, '_fitout_key_elements', "Scope: design and construction\nProject value: \$650,000\nDuration: 12 weeks (1 May to 23 July 2026)\nOffice converted to an 80-seat restaurant, café and bar\n3D and VR walkthrough approved before construction\nIn-house plumbing and electrical trades");
    update_post_meta($id, '_fitout_final_result', 'Now trading as an elegant fine dining venue for more than 80 guests.');
    $videos = array();
    foreach (array(
        array($walk, $walk_poster, '3D and VR design walkthrough'),
        array($done, $done_poster, 'The finished restaurant'),
        array($hand, $hand_poster, 'Handover walk-through'),
    ) as $v) {
        if ($v[0]) {
            $videos[] = array('url' => $v[0], 'poster' => $v[1], 'title' => $v[2]);
        }
    }
    update_post_meta($id, '_fitout_videos', $videos);
    update_post_meta($id, '_fitout_videos_heading', 'From 3D design to opening night');
    update_post_meta($id, '_fitout_videos_intro', 'The owners walked through their restaurant in 3D and VR before construction began. Twelve weeks later, the room on screen was ready for guests.');
    $log(sprintf('Chez Ami: story updated, %d videos', count($videos)));
}

/* ------------------------------------------- Commercial Design and Solutions page */
$cds = get_option('central_build_cds_settings');
if (is_array($cds)) {
    $cds['intro']['heading'] = 'Walk through your project before it is built';
    $cds['intro']['text'] = 'We don\'t just design. We turn ideas into real, buildable spaces. With BIM and virtual reality you can walk through your project before construction begins: see it, feel it and refine it. Design visualisation and walkthrough videos are affordable too, giving you premium insight without the premium price.';
    $cds['videos']['heading'] = '3D Walkthroughs & Virtual Tours';
    $cds['videos']['text'] = 'Chez Ami Restaurant in Sale: designed and walked through in 3D and VR, then built by Central Build in 12 weeks.';
    $items = array();
    if ($walk) {
        $items[] = array('title' => 'Chez Ami Restaurant: 3D and VR design walkthrough', 'url' => $walk, 'poster_image' => $walk_poster);
    }
    foreach ((array) ($cds['videos']['items'] ?? array()) as $item) {
        if (is_array($item) && strpos((string) ($item['url'] ?? ''), 'youtube.com') !== false) {
            $item['title'] = 'Chez Ami Restaurant: 3D walkthrough (YouTube)';
            $item['poster_image'] = '';
            $items[] = $item;
        }
    }
    $cds['videos']['items'] = $items;
    update_option('central_build_cds_settings', $cds);
    $log('Commercial Design and Solutions: intro and videos updated');
}

/* ------------------------------------------------------- facts that must agree */
$cfs = get_option('central_build_cfs_settings');
if (is_array($cfs) && isset($cfs['case_study'])) {
    $cfs['case_study']['challenge'] = 'Challenge: 306 m² office to an 80-seat restaurant in 12 weeks';
    update_option('central_build_cfs_settings', $cfs);
}

/* ------------------------------------------------- office and factory addresses */
$contact = get_option('central_build_contact_settings');
if (is_array($contact) && isset($contact['office'])) {
    $contact['office']['address_title'] = 'Office & Factory';
    $contact['office']['address_lines'] = array(
        'Office: PO Box 1041, Mitcham North VIC 3132',
        'Factory: 3 Hillside Street, Maddingley VIC 3340',
    );
    $contact['office']['cta_url'] = 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode('3 Hillside Street, Maddingley VIC 3340');
    update_option('central_build_contact_settings', $contact);
    $log('Contact: office and factory addresses');
}

do_action('litespeed_purge_all');
$log('Done.');
