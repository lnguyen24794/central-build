<?php
/**
 * Reference projects from the Capability Statement 2026 (slides 9–11). Safe to run more than once.
 *
 *   wp eval-file 2026-11-11-capability-projects.php <photo-root>
 *
 * <photo-root>/<project>/*.jpg  (cropped from the Capability Statement PDF, EXIF removed)
 *
 * - Laksa King (Westfield Southland): photos added, published in Completed Projects.
 * - Heiwa Headspa: photos of the finished head spa become the main photos (construction photos kept after them).
 * - Yan Rolls & Coffee: interior and sign photos added.
 */

if (!defined('ABSPATH')) {
    exit(1);
}
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';
require_once ABSPATH . 'wp-admin/includes/image.php';

$root = isset($args[0]) ? rtrim($args[0], '/') : '';
$log  = static function ($m) { WP_CLI::log($m); };

$titles = array('laksa-king' => 'Laksa King', 'heiwa' => 'Heiwa Headspa', 'yan-rolls' => 'Yan Rolls & Coffee');

/** Attachment for <group>/<name>, imported once (identified by _cb_seed_source). Returns [id, url]. */
$photo = static function (string $group, string $name) use ($root, $titles): array {
    $key   = "$group/$name";
    $found = get_posts(array('post_type' => 'attachment', 'post_status' => 'inherit', 'numberposts' => 1, 'fields' => 'ids',
        'meta_key' => '_cb_seed_source', 'meta_value' => $key));
    $id = $found ? (int) $found[0] : 0;
    if (!$id) {
        $path = "$root/$group/$name.jpg";
        if (!is_readable($path)) {
            WP_CLI::warning("missing $path");
            return array(0, '');
        }
        $tmp = wp_tempnam($name);
        copy($path, $tmp);
        $label = $titles[$group] ?? $group;
        $id = media_handle_sideload(array('name' => sanitize_file_name("$group-$name.jpg"), 'tmp_name' => $tmp), 0, "$label " . strtolower($name));
        if (is_wp_error($id)) {
            WP_CLI::warning("$key: " . $id->get_error_message());
            @unlink($tmp);
            return array(0, '');
        }
        update_post_meta($id, '_cb_seed_source', $key);
        update_post_meta($id, '_wp_attachment_image_alt', $label);
    }
    return array($id, (string) wp_get_attachment_image_url($id, 'full'));
};

/** Existing gallery URLs whose seed source is one of $sources (keeps the client's Drive photos). */
$existing = static function (array $sources): array {
    $urls = array();
    foreach ($sources as $key) {
        $found = get_posts(array('post_type' => 'attachment', 'post_status' => 'inherit', 'numberposts' => 1, 'fields' => 'ids',
            'meta_key' => '_cb_seed_source', 'meta_value' => $key));
        if ($found) {
            $urls[] = (string) wp_get_attachment_image_url((int) $found[0], 'full');
        }
    }
    return array_values(array_filter($urls));
};

$project = static function (string $title): int {
    $ids = get_posts(array('post_type' => 'fitout_sector', 'post_status' => 'any', 'title' => $title, 'numberposts' => 1, 'fields' => 'ids'));
    return $ids ? (int) $ids[0] : 0;
};

$completed = get_term_by('slug', 'fitout-projects', 'fitout_category');

/* ------------------------------------------------------------------ Laksa King */
$id = $project('Laksa King');
if ($id) {
    list($a_id, $a_url) = $photo('laksa-king', 'IMG_slide-2');
    list(, $b_url)      = $photo('laksa-king', 'IMG_slide-1');
    if ($a_id) {
        set_post_thumbnail($id, $a_id);
        update_post_meta($id, '_fitout_hero_image', $a_url);
        update_post_meta($id, '_fitout_about_image', $b_url ?: $a_url);
        update_post_meta($id, '_fitout_gallery_images', array_values(array_filter(array($a_url, $b_url))));
    }
    update_post_meta($id, '_fitout_about_project', "A restaurant upgrade for Laksa King at Westfield Southland, Cheltenham, one of Melbourne's busiest shopping centres.\n\nCentral Build delivered the 100 m² upgrade in two weeks, working around the centre's trading hours and access rules so the restaurant could reopen quickly.");
    update_post_meta($id, '_fitout_key_elements', "Scope: construction\nProject value: \$50,000\nDuration: 2 weeks\nRestaurant upgrade inside an operating shopping centre");
    $summary = 'Restaurant upgrade at Westfield Southland, Cheltenham, delivered in two weeks.';
    wp_update_post(array('ID' => $id, 'post_status' => 'publish', 'post_excerpt' => $summary, 'post_content' => $summary));
    if ($completed) {
        wp_set_object_terms($id, array((int) $completed->term_id), 'fitout_category');
    }
    $log("Laksa King published (#$id)");
}

/* ------------------------------------------------------------------ Heiwa Headspa */
$id = $project('Heiwa Headspa');
if ($id) {
    list($f1_id, $f1) = $photo('heiwa', 'finished-1');
    list(, $f2)       = $photo('heiwa', 'finished-2');
    if ($f1_id) {
        $gallery = array_merge(array_filter(array($f1, $f2)), $existing(array('heiwa/IMG_7403', 'heiwa/IMG_7404', 'heiwa/IMG_7407', 'heiwa/IMG_7408')));
        set_post_thumbnail($id, $f1_id);
        update_post_meta($id, '_fitout_hero_image', $f1);
        update_post_meta($id, '_fitout_about_image', $f2 ?: $f1);
        update_post_meta($id, '_fitout_gallery_images', array_values(array_unique($gallery)));
        $summary = 'An office in Geelong turned into a calm, softly lit head spa in about two months.';
        wp_update_post(array('ID' => $id, 'post_excerpt' => $summary, 'post_content' => $summary));
        $log('Heiwa Headspa: finished photos added (' . count($gallery) . ' photos)');
    }
}

/* ------------------------------------------------------------------ Yan Rolls & Coffee */
$id = $project('Yan Rolls & Coffee');
if ($id) {
    list(, $in)   = $photo('yan-rolls', 'interior');
    list(, $sign) = $photo('yan-rolls', 'sign');
    if ($in) {
        $gallery = array_merge(array($in), $existing(array('yan-rolls/featured', 'yan-rolls/IMG_0142', 'yan-rolls/IMG_0143')), array_filter(array($sign)));
        update_post_meta($id, '_fitout_about_image', $in);
        update_post_meta($id, '_fitout_gallery_images', array_values(array_unique($gallery)));
        $log('Yan Rolls & Coffee: interior photos added (' . count($gallery) . ' photos)');
    }
}

do_action('litespeed_purge_all');
$log('Done.');
