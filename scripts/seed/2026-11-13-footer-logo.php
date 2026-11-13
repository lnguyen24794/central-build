<?php
/**
 * Footer logo = the square Central Build logo on its cream ground (13 Nov 2026). Safe to run more than once.
 * Needs 2026-11-13-logo-little-summer.php to have imported the square logo first.
 *
 *   wp eval-file 2026-11-13-footer-logo.php
 */

if (!defined('ABSPATH')) {
    exit(1);
}

$ids = get_posts(array('post_type' => 'attachment', 'post_status' => 'inherit', 'numberposts' => 1, 'fields' => 'ids',
    'meta_key' => '_cb_seed_source', 'meta_value' => 'r5/logo/central-build-site-icon.png'));
if (!$ids) {
    WP_CLI::error('Square logo not imported yet: run 2026-11-13-logo-little-summer.php first.');
}
$src = wp_get_attachment_image_src((int) $ids[0], 'medium_large') ?: wp_get_attachment_image_src((int) $ids[0], 'full');
$url = set_url_scheme($src[0], wp_parse_url(home_url(), PHP_URL_SCHEME));

$s = get_option('central_build_footer_settings', array());
$s = is_array($s) ? $s : array();
$was = $s['company']['logo_url'] ?? '';
$s['company'] = isset($s['company']) && is_array($s['company']) ? $s['company'] : array();
$s['company']['logo_url'] = $url;
update_option('central_build_footer_settings', $s);

WP_CLI::success("Footer logo: $was -> $url");
