<?php
/**
 * Square logo + Little Summer Coffee upcoming project (13 Nov 2026). Safe to run more than once.
 *
 *   wp eval-file 2026-11-13-logo-little-summer.php <bundle-root>
 *
 * <bundle-root>/logo/central-build-logo-square.png   header logo (transparent, 1:1)
 * <bundle-root>/logo/central-build-site-icon.png     browser tab / app icon
 * <bundle-root>/little-summer/render-01..05.jpg      concept renders (AC Atelier, Rev C, 30/10/2026)
 *
 * - Header logo becomes the square logo, shown at 100 x 100.
 * - Little Summer Coffee Renovation is published under Upcoming Projects with render 01 as its main photo.
 */

if (!defined('ABSPATH')) {
    exit(1);
}
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';
require_once ABSPATH . 'wp-admin/includes/image.php';

$root = isset($args[0]) ? rtrim($args[0], '/') : '';
if ($root === '' || !is_dir($root)) {
    WP_CLI::error('Pass the bundle folder.');
}

/** Attachment for a bundle file, imported once (identified by _cb_seed_source). */
$import = static function (string $rel, string $title) use ($root): int {
    $key   = 'r5/' . $rel;
    $found = get_posts(array('post_type' => 'attachment', 'post_status' => 'inherit', 'numberposts' => 1, 'fields' => 'ids',
        'meta_key' => '_cb_seed_source', 'meta_value' => $key));
    if ($found) {
        return (int) $found[0];
    }
    $tmp = wp_tempnam($rel);
    copy("$root/$rel", $tmp);
    $id = media_handle_sideload(array('name' => basename($rel), 'tmp_name' => $tmp), 0, $title);
    if (is_wp_error($id)) {
        WP_CLI::error("$rel: " . $id->get_error_message());
    }
    update_post_meta($id, '_cb_seed_source', $key);
    update_post_meta($id, '_wp_attachment_image_alt', $title);
    WP_CLI::log("Imported $rel (#$id)");
    return (int) $id;
};

/* ---------------------------------------------------------------- logo */
$logo = $import('logo/central-build-logo-square.png', 'Central Build');
$icon = $import('logo/central-build-site-icon.png', 'Central Build icon');
set_theme_mod('custom_logo', $logo);
update_option('site_icon', $icon);
$header = get_option('central_build_header_settings', array());
$header = is_array($header) ? $header : array();
$header['logo'] = array('width' => 100, 'height' => 100);
update_option('central_build_header_settings', $header);
WP_CLI::log("Header logo #$logo, site icon #$icon");

/* ---------------------------------------------------------------- Little Summer Coffee */
$ids = get_posts(array('post_type' => 'fitout_sector', 'post_status' => 'any', 'title' => 'Little Summer Coffee Renovation', 'numberposts' => 1, 'fields' => 'ids'));
$post_id = $ids ? (int) $ids[0] : 0;
if (!$post_id) {
    $post_id = (int) wp_insert_post(array('post_type' => 'fitout_sector', 'post_title' => 'Little Summer Coffee Renovation', 'post_status' => 'draft'));
}

$captions = array(
    1 => 'Little Summer Coffee: café counter under the skylight',
    2 => 'Little Summer Coffee: front counter and bakery display',
    3 => 'Little Summer Coffee: order point and seating',
    4 => 'Little Summer Coffee: dining area entry',
    5 => 'Little Summer Coffee: coffee bar from the mall',
);
$urls = array();
$first = 0;
foreach ($captions as $n => $caption) {
    $id = $import(sprintf('little-summer/render-%02d.jpg', $n), $caption);
    $first = $first ?: $id;
    $urls[] = wp_get_attachment_url($id);
}

wp_update_post(array(
    'ID'           => $post_id,
    'post_status'  => 'publish',
    'post_excerpt' => 'Café renovation at The Pines Shopping Centre: new coffee bar, bakery display and back-of-house kitchen.',
    'post_content' => 'Upcoming project: renovation of Little Summer Coffee at The Pines Shopping Centre.',
    'menu_order'   => 7,
));
set_post_thumbnail($post_id, $first);
update_post_meta($post_id, '_fitout_hero_image', $urls[0]);
update_post_meta($post_id, '_fitout_about_image', $urls[1]);
update_post_meta($post_id, '_fitout_gallery_images', $urls);
update_post_meta($post_id, '_fitout_location', 'The Pines Shopping Centre, VIC');
update_post_meta($post_id, '_fitout_client', 'Little Summer Coffee');
if (!get_post_meta($post_id, '_fitout_about_project', true)) {
    update_post_meta($post_id, '_fitout_about_project', "Renovation of a busy shopping centre café, now at concept design stage.\n\nThe new layout brings the order area, coffee machine and bakery display to the front, with a fully equipped back-of-house kitchen, prep benches and a separate washing area behind.");
}
if (!get_post_meta($post_id, '_fitout_key_elements', true)) {
    update_post_meta($post_id, '_fitout_key_elements', "Front counter with POS and bakery display\nCoffee station with grinder and pitcher rinser\nCommercial kitchen with induction cooking and speed oven\nSeparate washing area and storage");
}
wp_set_object_terms($post_id, array('upcoming-projects'), 'fitout_category');

WP_CLI::success("Little Summer Coffee published (#$post_id): " . get_permalink($post_id));
