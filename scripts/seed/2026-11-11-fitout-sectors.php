<?php
/**
 * "Commercial Fitout Sectors" (home page + projects page): sectors backed by real projects.
 * Run after 2026-11-11-content-sync.php (needs the project photos). Safe to run more than once.
 *
 *   wp eval-file 2026-11-11-fitout-sectors.php
 */

if (!defined('ABSPATH')) {
    exit(1);
}

$theme = get_template_directory_uri() . '/images/';

$attachment = static function (string $source): string {
    $ids = get_posts(array('post_type' => 'attachment', 'post_status' => 'inherit', 'numberposts' => 1, 'fields' => 'ids',
        'meta_key' => '_cb_seed_source', 'meta_value' => $source));
    return $ids ? (string) wp_get_attachment_image_url((int) $ids[0], 'large') : '';
};
$project = static function (string $title): array {
    $ids = get_posts(array('post_type' => 'fitout_sector', 'post_status' => 'publish', 'title' => $title, 'numberposts' => 1, 'fields' => 'ids'));
    if (!$ids) {
        return array('url' => '', 'image' => '');
    }
    return array('url' => (string) get_permalink($ids[0]), 'image' => (string) get_the_post_thumbnail_url($ids[0], 'large'));
};

// "Southside Dental Fitout" is the theme's sample project (one render repeated as every photo): unpublish it.
$sample = get_posts(array('post_type' => 'fitout_sector', 'post_status' => 'publish', 'title' => 'Southside Dental Fitout', 'numberposts' => 1, 'fields' => 'ids'));
if ($sample) {
    $gallery = array_unique(array_filter((array) get_post_meta($sample[0], '_fitout_gallery_images', true)));
    if (count($gallery) <= 1) {
        wp_update_post(array('ID' => $sample[0], 'post_status' => 'draft'));
        WP_CLI::log('Sample project "Southside Dental Fitout" set to draft');
    }
}

$current = central_build_get_sectors();
$office_image = '';
foreach ($current as $s) {
    if (stripos((string) $s['title'], 'office') !== false) {
        $office_image = (string) $s['image'];
    }
}

$chez     = $project('Chez Ami Restaurant');
$mama     = $project('Mama Tran Dumplings');
$heiwa    = $project('Heiwa Headspa');

$sectors = array(
    array(
        'icon'        => $theme . 'Hospitality.svg',
        'tag'         => 'Hospitality',
        'title'       => 'Restaurants, Cafés & Bars',
        'description' => 'Kitchens, bars, seating and services delivered by one team, like the 80-seat Chez Ami restaurant in Sale.',
        'image'       => $attachment('chez-ami/IMG_1752') ?: $chez['image'],
        'image_alt'   => 'Chez Ami Restaurant, Sale – dining room and bar by Central Build',
        'url'         => $chez['url'],
    ),
    array(
        'icon'        => $theme . 'Retail-Icon.svg',
        'tag'         => 'Retail',
        'title'       => 'Shops & Food Courts',
        'description' => 'Shopfronts, counters, signage and display fridges for busy centres, like Mama Tran Dumplings.',
        'image'       => $mama['image'] ?: $theme . 'cb/cb-food-court.jpg',
        'image_alt'   => 'Mama Tran Dumplings food court shopfront by Central Build',
        'url'         => $mama['url'],
    ),
    array(
        'icon'        => $theme . 'Medical-Icon.svg',
        'tag'         => 'Health & Beauty',
        'title'       => 'Health, Beauty & Wellness',
        'description' => 'Calm treatment spaces built to strict hygiene standards, like the Heiwa head spa in Geelong.',
        'image'       => $heiwa['image'] ?: $attachment('heiwa/IMG_7404'),
        'image_alt'   => 'Heiwa Headspa, Geelong – fit-out under construction by Central Build',
        'url'         => $heiwa['url'],
    ),
    array(
        'icon'        => $theme . 'Home-Three-Icon.svg',
        'tag'         => 'Office',
        'title'       => 'Offices & Building Conversions',
        'description' => 'Office fit-outs and changes of use, from an office-to-restaurant conversion to a Class 1b rooming house.',
        'image'       => $office_image ?: $theme . 'cb/cb-interior.jpg',
        'image_alt'   => 'Commercial office fit-out design by Central Build',
        'url'         => home_url('/commercial-fitouts/'),
    ),
);
foreach ($sectors as $i => $s) {
    if ($s['url'] === '') {
        $sectors[$i]['url'] = home_url('/projects/');
    }
}
update_option('central_build_sectors', $sectors);
update_option('central_build_checkout_title', 'Commercial Fitout Sectors');
update_option('central_build_checkout_button_text', 'See all our projects');
update_option('central_build_checkout_button_url', home_url('/projects/'));
do_action('litespeed_purge_all');
WP_CLI::log('Sectors updated: ' . implode(', ', wp_list_pluck($sectors, 'title')));
