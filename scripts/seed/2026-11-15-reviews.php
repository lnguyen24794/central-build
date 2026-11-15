<?php
/**
 * Client reviews (15 Nov 2026). Safe to run more than once.
 *
 *   wp eval-file 2026-11-15-reviews.php
 *
 * - Mama Tran Dumplings project page shows Andy K's review (Projects > Edit > Client quote).
 * - The home page reviews section comes from the theme defaults (Website Content > Home Page >
 *   Client reviews); a saved copy from an earlier run is left alone.
 */

if (!defined('ABSPATH')) {
    exit(1);
}

$ids = get_posts(array('post_type' => 'fitout_sector', 'post_status' => 'any', 'title' => 'Mama Tran Dumplings', 'numberposts' => 1, 'fields' => 'ids'));
if (!$ids) {
    WP_CLI::error('Mama Tran Dumplings project not found.');
}
$id = (int) $ids[0];
update_post_meta($id, '_fitout_quote_text', "Thank you so much to the Central Build team for the fantastic job on our renovation. We are thrilled with how everything turned out. Your attention to detail, and professionalism throughout the entire process made such a difference, and we couldn't be happier with the final result. Thanks again for all your hard work – we will gladly recommend you to anyone looking for a great builder!");
update_post_meta($id, '_fitout_quote_author', 'Andy K');
update_post_meta($id, '_fitout_quote_position', 'Mama Tran Dumplings');

$home = get_option('central_build_home_content', array());
WP_CLI::log('Home reviews: ' . (is_array($home) && isset($home['reviews']) ? 'saved copy kept' : 'theme defaults'));
WP_CLI::success("Mama Tran review set (#$id): " . get_permalink($id));
