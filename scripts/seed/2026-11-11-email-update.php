<?php
/**
 * Company email admin@centralbuild.au -> thangt@centralbuild.au (11 Nov 2026). Safe to run more than once.
 *
 *   wp eval-file 2026-11-11-email-update.php
 *
 * Replaces the address in every Central Build setting (header, footer, contact page, form emails,
 * Website Content undo copies) and in posts. The WordPress admin email is not touched.
 */

if (!defined('ABSPATH')) {
    exit(1);
}

$old = 'admin@centralbuild.au';
$new = 'thangt@centralbuild.au';

$swap = static function ($value) use (&$swap, $old, $new) {
    if (is_array($value)) {
        foreach ($value as $k => $v) {
            $value[$k] = $swap($v);
        }
        return $value;
    }
    return is_string($value) ? str_ireplace($old, $new, $value) : $value;
};

global $wpdb;
$names = $wpdb->get_col($wpdb->prepare(
    "SELECT option_name FROM {$wpdb->options} WHERE (option_name LIKE %s OR option_name LIKE %s) AND option_value LIKE %s",
    'central_build_%', 'cb_ce_%', '%' . $wpdb->esc_like($old) . '%'
));
foreach ($names as $name) {
    update_option($name, $swap(get_option($name)));
    WP_CLI::log("Option updated: $name");
}
// Legacy single email options (not shown on the new layout) follow the new address too.
foreach (array('central_build_contact_email', 'central_build_header_email', 'central_build_footer_email') as $name) {
    if (get_option($name, null) !== null) {
        update_option($name, $new);
    }
}

$posts = $wpdb->get_col($wpdb->prepare("SELECT ID FROM {$wpdb->posts} WHERE post_content LIKE %s", '%' . $wpdb->esc_like($old) . '%'));
foreach ($posts as $id) {
    $p = get_post((int) $id);
    wp_update_post(array('ID' => $p->ID, 'post_content' => str_ireplace($old, $new, $p->post_content)));
    WP_CLI::log("Post updated: #{$p->ID}");
}
$metas = $wpdb->get_results($wpdb->prepare("SELECT post_id, meta_key FROM {$wpdb->postmeta} WHERE meta_value LIKE %s", '%' . $wpdb->esc_like($old) . '%'));
foreach ($metas as $m) {
    update_post_meta((int) $m->post_id, $m->meta_key, $swap(get_post_meta((int) $m->post_id, $m->meta_key, true)));
    WP_CLI::log("Post meta updated: #{$m->post_id} {$m->meta_key}");
}

do_action('litespeed_purge_all');
WP_CLI::log('Done.');
