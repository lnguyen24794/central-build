<?php
/**
 * New photos for two sections (13 Nov 2026). Safe to run more than once.
 *
 *   wp eval-file 2026-11-13-design-bim-photos.php <bundle-root>
 *
 * - Commercial Design and Solutions > "Walk through your project before it is built": restaurant render.
 * - Services Coordination > "Precision in Pixels: The Power of BIM": two BIM model renders, stacked.
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

$import = static function (string $file, string $title) use ($root): string {
    $key   = 'r6/' . $file;
    $found = get_posts(array('post_type' => 'attachment', 'post_status' => 'inherit', 'numberposts' => 1, 'fields' => 'ids',
        'meta_key' => '_cb_seed_source', 'meta_value' => $key));
    if ($found) {
        $id = (int) $found[0];
    } else {
        $tmp = wp_tempnam($file);
        copy("$root/$file", $tmp);
        $id = media_handle_sideload(array('name' => $file, 'tmp_name' => $tmp), 0, $title);
        if (is_wp_error($id)) {
            WP_CLI::error("$file: " . $id->get_error_message());
        }
        update_post_meta($id, '_cb_seed_source', $key);
        update_post_meta($id, '_wp_attachment_image_alt', $title);
        WP_CLI::log("Imported $file (#$id)");
    }
    return set_url_scheme(wp_get_attachment_url($id), wp_parse_url(home_url(), PHP_URL_SCHEME));
};

$render   = $import('cds-design-render-restaurant.jpg', 'Restaurant design render');
$overview = $import('sc-bim-model-overview.jpg', 'BIM model with building services');
$interior = $import('sc-bim-model-interior.jpg', 'BIM model of a coordinated interior');

$cds = get_option('central_build_cds_settings', array());
$cds = is_array($cds) ? $cds : array();
$cds['intro'] = isset($cds['intro']) && is_array($cds['intro']) ? $cds['intro'] : array();
$cds['intro']['image'] = $render;
update_option('central_build_cds_settings', $cds);
WP_CLI::log("Design intro photo: $render");

$sc = get_option('central_build_sc_settings', array());
$sc = is_array($sc) ? $sc : array();
$sc['bim'] = isset($sc['bim']) && is_array($sc['bim']) ? $sc['bim'] : array();
$sc['bim']['image'] = $overview;
$sc['bim']['second_image'] = $interior;
update_option('central_build_sc_settings', $sc);
WP_CLI::log("BIM photos: $overview, $interior");

WP_CLI::success('Photos updated.');
