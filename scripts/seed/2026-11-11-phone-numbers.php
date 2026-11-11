<?php
/**
 * Phone numbers (11 Nov 2026). Safe to run more than once.
 *   Company: 1300 31 8888      -> main number everywhere
 *   Mobile:  +61 413 058 861   -> urgent / 24-7 calls and a second line in the footer
 * Removes the old number +61 421 817 757.
 *
 *   wp eval-file 2026-11-11-phone-numbers.php
 */

if (!defined('ABSPATH')) {
    exit(1);
}

$company = array('display' => '1300 31 8888', 'link' => 'tel:1300318888');
$mobile  = array('display' => '+61 413 058 861', 'link' => 'tel:+61413058861');
$old     = '/\+?61\s*421\s*817\s*757|\+61421817757/';

$save = static function (string $option, string $sanitizer, array $data) {
    update_option($option, call_user_func($sanitizer, wp_slash($data)));
    WP_CLI::log("updated $option");
};

// Header + Contact: show and dial the company number.
$h = central_build_get_header_settings();
$h['phone'] = $company;
$save('central_build_header_settings', 'central_build_sanitize_header_settings', $h);

$c = central_build_get_contact_settings();
$c['contact_info']['phone'] = $company;
foreach ($c['channels'] as $i => $ch) {
    if (stripos($ch['title'], 'urgent') !== false) {
        $c['channels'][$i]['highlight']  = $mobile['display'];
        $c['channels'][$i]['cta']['url'] = $mobile['link'];
    }
    if (isset($ch['secondary']) && preg_match('/\d{3}/', (string) $ch['secondary'])) {
        $c['channels'][$i]['secondary'] = $company['display'];
    }
}
$save('central_build_contact_settings', 'central_build_sanitize_contact_settings', $c);

// Footer: company number + mobile line.
$f = central_build_get_footer_settings();
$f['company']['phone']  = $company;
$f['company']['mobile'] = array('display' => 'Mobile: ' . $mobile['display'], 'link' => $mobile['link']);
$save('central_build_footer_settings', 'central_build_sanitize_footer_settings', $f);

// Service pages: contact lines -> company number; Repairs emergency button -> mobile.
$cid = central_build_get_cid_settings();
foreach ($cid['cta_block']['items'] as $i => $item) {
    if (($item['icon'] ?? '') === 'fas fa-phone-alt' || preg_match($old, (string) $item['text'])) {
        $cid['cta_block']['items'][$i]['text'] = $company['display'];
    }
}
$save('central_build_cid_settings', 'central_build_sanitize_cid_settings', $cid);

$cfs = central_build_get_cfs_settings();
$cfs['final_cta']['contact'] = $company['display'];
$save('central_build_cfs_settings', 'central_build_sanitize_cfs_settings', $cfs);

foreach (array('sc', 'cs', 'rm') as $k) {
    $d = call_user_func("central_build_get_{$k}_settings");
    $d['contact']['contact_line'] = $company['display'];
    if ($k === 'rm') {
        $d['hero']['primary_cta']['url'] = $mobile['link'];
    }
    $save("central_build_{$k}_settings", "central_build_sanitize_{$k}_settings", $d);
}

$cds = central_build_get_cds_settings();
$cds['contact']['contact_line'] = $company['display'];
$save('central_build_cds_settings', 'central_build_sanitize_cds_settings', $cds);

// Old single-value options from the first theme version (not shown any more) – keep them consistent.
foreach (array('central_build_footer_phone', 'central_build_contact_phone_display', 'central_build_header_phone_display') as $o) {
    if (get_option($o) !== false) {
        update_option($o, $company['display']);
    }
}
foreach (array('central_build_contact_phone', 'central_build_header_phone') as $o) {
    if (get_option($o) !== false) {
        update_option($o, '1300318888');
    }
}

do_action('litespeed_purge_all');
WP_CLI::log('Done.');
