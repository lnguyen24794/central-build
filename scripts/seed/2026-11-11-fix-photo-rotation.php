<?php
/**
 * Fix the client photos imported by 2026-11-11-services-update.php:
 * WordPress auto-rotated them a second time (leftover EXIF orientation).
 * Rotates each file back to upright in place (same URLs) and rebuilds the smaller sizes.
 * Only touches attachments marked _cb_seed_source and only while they are landscape.
 *
 *   wp eval-file 2026-11-11-fix-photo-rotation.php
 */

if (!defined('ABSPATH')) {
    exit(1);
}
require_once ABSPATH . 'wp-admin/includes/image.php';

$ids = get_posts(array('post_type' => 'attachment', 'post_status' => 'inherit', 'numberposts' => -1, 'fields' => 'ids', 'meta_key' => '_cb_seed_source'));
foreach ($ids as $id) {
    $file = get_attached_file($id);
    $size = $file ? @getimagesize($file) : false;
    if (!$size) {
        WP_CLI::warning("#$id: file not found");
        continue;
    }
    if ($size[0] <= $size[1]) {
        WP_CLI::log("#$id already upright ({$size[0]}x{$size[1]})");
        continue;
    }
    $editor = wp_get_image_editor($file);
    if (is_wp_error($editor)) {
        WP_CLI::warning("#$id: " . $editor->get_error_message());
        continue;
    }
    $editor->rotate(90); // counter-clockwise
    $saved = $editor->save($file);
    if (is_wp_error($saved)) {
        WP_CLI::warning("#$id: " . $saved->get_error_message());
        continue;
    }
    $meta = wp_generate_attachment_metadata($id, $file);
    wp_update_attachment_metadata($id, $meta);
    $now = getimagesize($file);
    WP_CLI::log("#$id rotated -> {$now[0]}x{$now[1]}");
}
do_action('litespeed_purge_all');
WP_CLI::log('Done.');
