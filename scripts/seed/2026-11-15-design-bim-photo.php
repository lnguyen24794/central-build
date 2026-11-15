<?php
/**
 * Commercial Design and Solutions > "BIM for Complex Projects" photo = BIM model interior (15 Nov 2026).
 * Safe to run more than once. Needs 2026-11-13-design-bim-photos.php to have imported the photo.
 *
 *   wp eval-file 2026-11-15-design-bim-photo.php
 *
 * The section had no photo of its own and borrowed the design intro photo above it.
 */

if (!defined('ABSPATH')) {
    exit(1);
}

$ids = get_posts(array('post_type' => 'attachment', 'post_status' => 'inherit', 'numberposts' => 1, 'fields' => 'ids',
    'meta_key' => '_cb_seed_source', 'meta_value' => 'r6/sc-bim-model-interior.jpg'));
if (!$ids) {
    WP_CLI::error('BIM photo not imported yet: run 2026-11-13-design-bim-photos.php first.');
}
$url = set_url_scheme(wp_get_attachment_url((int) $ids[0]), wp_parse_url(home_url(), PHP_URL_SCHEME));

$cds = get_option('central_build_cds_settings', array());
$cds = is_array($cds) ? $cds : array();
$cds['bim'] = isset($cds['bim']) && is_array($cds['bim']) ? $cds['bim'] : array();
$cds['bim']['image'] = $url;
update_option('central_build_cds_settings', $cds);

WP_CLI::success("Design page BIM photo: $url");
