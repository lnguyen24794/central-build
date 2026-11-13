<?php
/**
 * Top banner photo on the service pages = central-build_background-scaled.jpg (13 Nov 2026).
 * Safe to run more than once.
 *
 *   wp eval-file 2026-11-13-hero-backgrounds.php
 *
 * The service pages keep the photo in Website Content (Top banner > Background photo), so it can
 * still be changed there. About, Contact and Projects use the same photo from the theme.
 */

if (!defined('ABSPATH')) {
    exit(1);
}

// WP-CLI has no HTTPS request, so take the scheme from the site address.
$url = set_url_scheme(content_url('uploads/2025/09/central-build_background-scaled.jpg'), wp_parse_url(home_url(), PHP_URL_SCHEME));

foreach (array('central_build_cfs_settings', 'central_build_cds_settings', 'central_build_cs_settings', 'central_build_sc_settings', 'central_build_rm_settings') as $name) {
    $s = get_option($name, array());
    $s = is_array($s) ? $s : array();
    $was = $s['hero']['background'] ?? '';
    $s['hero'] = isset($s['hero']) && is_array($s['hero']) ? $s['hero'] : array();
    $s['hero']['background'] = $url;
    update_option($name, $s);
    WP_CLI::log("$name: $was -> $url");
}

WP_CLI::success('Hero backgrounds updated.');
