<?php
/**
 * About > "Who We Are" photo = the Central Build title slide (13 Nov 2026). Safe to run more than once.
 *
 *   wp eval-file 2026-11-13-who-we-are-photo.php <bundle-root>
 *
 * The home page "Why Central Build" section used the same photo. It keeps its current photo
 * through its own field (Website Content > Home Page > "Why Central Build" introduction > Image).
 */

if (!defined('ABSPATH')) {
    exit(1);
}
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';
require_once ABSPATH . 'wp-admin/includes/image.php';

$root = isset($args[0]) ? rtrim($args[0], '/') : '';
$file = 'about-who-we-are.jpg';
if ($root === '' || !is_file("$root/$file")) {
    WP_CLI::error('Pass the bundle folder.');
}

$key   = 'r7/' . $file;
$found = get_posts(array('post_type' => 'attachment', 'post_status' => 'inherit', 'numberposts' => 1, 'fields' => 'ids',
    'meta_key' => '_cb_seed_source', 'meta_value' => $key));
if ($found) {
    $id = (int) $found[0];
} else {
    $tmp = wp_tempnam($file);
    copy("$root/$file", $tmp);
    $id = media_handle_sideload(array('name' => $file, 'tmp_name' => $tmp), 0, 'Central Build: Where Trust Builds');
    if (is_wp_error($id)) {
        WP_CLI::error($id->get_error_message());
    }
    update_post_meta($id, '_cb_seed_source', $key);
    update_post_meta($id, '_wp_attachment_image_alt', 'Central Build: Where Trust Builds');
    WP_CLI::log("Imported $file (#$id)");
}
$url = set_url_scheme(wp_get_attachment_url($id), wp_parse_url(home_url(), PHP_URL_SCHEME));

$about = get_option('central_build_about_settings', array());
$about = is_array($about) ? $about : array();
$about['philosophy'] = isset($about['philosophy']) && is_array($about['philosophy']) ? $about['philosophy'] : array();
$old = (string) ($about['philosophy']['image'] ?? '');

// Keep the home page on the photo it shows today.
$home = get_option('central_build_home_content', array());
$home = is_array($home) ? $home : array();
$home['intro'] = isset($home['intro']) && is_array($home['intro']) ? $home['intro'] : array();
if (trim((string) ($home['intro']['image'] ?? '')) === '' && $old !== '' && $old !== $url) {
    $home['intro']['image'] = $old;
    update_option('central_build_home_content', $home);
    WP_CLI::log("Home \"Why Central Build\" photo kept: $old");
}

$about['philosophy']['image'] = $url;
update_option('central_build_about_settings', $about);
WP_CLI::success("Who We Are photo: $url");
