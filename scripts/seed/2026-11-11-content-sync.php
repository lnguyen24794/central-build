<?php
/**
 * Content sync (11 Nov 2026). Safe to run more than once.
 *
 *   wp eval-file 2026-11-11-content-sync.php <photo-root>
 *
 * <photo-root>/<project>/*.jpg  (upright JPGs, EXIF removed)
 *
 * 1. Projects: client photos from the Drive folders, published when they have photos.
 * 2. Old pages: real client photos instead of images hot-linked from other companies' websites,
 *    facts from the Capability Statement instead of made-up numbers / case study,
 *    one contact email, working map link; placeholder testimonials and "Member A/B/C" hidden.
 */

if (!defined('ABSPATH')) {
    exit(1);
}
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';
require_once ABSPATH . 'wp-admin/includes/image.php';

$root = isset($args[0]) ? rtrim($args[0], '/') : '';
$log  = static function ($m) { WP_CLI::log($m); };

/* ------------------------------------------------------------- photos */
function cb_sync_photo(string $root, string $group, string $name): string
{
    static $cache = array();
    $key = "$group/$name";
    if (isset($cache[$key])) {
        return $cache[$key];
    }
    $found = get_posts(array('post_type' => 'attachment', 'post_status' => 'inherit', 'numberposts' => 1, 'fields' => 'ids',
        'meta_key' => '_cb_seed_source', 'meta_value' => $key));
    $id = $found ? (int) $found[0] : 0;
    if (!$id) {
        $path = "$root/$group/$name.jpg";
        if (!is_readable($path)) {
            WP_CLI::warning("missing $path");
            return $cache[$key] = '';
        }
        $tmp = wp_tempnam($name);
        copy($path, $tmp);
        $titles = array('chez-ami' => 'Chez Ami Restaurant', 'heiwa' => 'Heiwa Headspa', 'yan-rolls' => 'Yan Rolls & Coffee',
            'hoppers-crossing' => 'Hoppers Crossing Rooming House', 'mama-tran' => 'Mama Tran Dumplings');
        $title = ($titles[$group] ?? $group) . ' ' . strtolower($name);
        $id = media_handle_sideload(array('name' => sanitize_file_name("$group-$name.jpg"), 'tmp_name' => $tmp), 0, $title);
        if (is_wp_error($id)) {
            WP_CLI::warning("$key: " . $id->get_error_message());
            @unlink($tmp);
            return $cache[$key] = '';
        }
        update_post_meta($id, '_cb_seed_source', $key);
        update_post_meta($id, '_wp_attachment_image_alt', $titles[$group] ?? $group);
    }
    $cache[$key . '#id'] = $id;
    return $cache[$key] = (string) wp_get_attachment_image_url($id, 'full');
}
$photo = static function ($group, $name) use ($root) {
    return cb_sync_photo($root, $group, $name);
};
$photo_id = static function ($group, $name) use ($root) {
    cb_sync_photo($root, $group, $name);
    $found = get_posts(array('post_type' => 'attachment', 'post_status' => 'inherit', 'numberposts' => 1, 'fields' => 'ids',
        'meta_key' => '_cb_seed_source', 'meta_value' => "$group/$name"));
    return $found ? (int) $found[0] : 0;
};

/* ----------------------------------------------------------- projects */
$projects = array(
    'Chez Ami Restaurant' => array('group' => 'chez-ami', 'featured' => 'IMG_1752', 'hero' => 'IMG_1753', 'about' => 'IMG_1744',
        'gallery' => array('IMG_1752', 'IMG_1748', 'IMG_1749', 'IMG_1751', 'IMG_1750', 'IMG_1754', 'IMG_1673', 'IMG_1674', 'IMG_1744', 'IMG_1023', 'IMG_1231', 'IMG_1118')),
    'Heiwa Headspa' => array('group' => 'heiwa', 'featured' => 'IMG_7403', 'hero' => 'IMG_7403', 'about' => 'IMG_7404',
        'gallery' => array('IMG_7403', 'IMG_7404')),
    'Yan Rolls & Coffee' => array('group' => 'yan-rolls', 'featured' => 'IMG_0142', 'hero' => 'IMG_0142', 'about' => 'IMG_0143',
        'gallery' => array('IMG_0142', 'IMG_0143')),
    'Hoppers Crossing Rooming House' => array('group' => 'hoppers-crossing', 'featured' => 'IMG_1156', 'hero' => 'IMG_1156', 'about' => 'IMG_1156',
        'gallery' => array('IMG_1156')),
    'Mama Tran Dumplings' => array('group' => 'mama-tran', 'append' => array('IMG_1225')),
);
foreach ($projects as $title => $p) {
    $ids = get_posts(array('post_type' => 'fitout_sector', 'post_status' => 'any', 'title' => $title, 'numberposts' => 1, 'fields' => 'ids'));
    if (!$ids) {
        WP_CLI::warning("project not found: $title");
        continue;
    }
    $id = (int) $ids[0];
    if (!empty($p['gallery'])) {
        $gallery = array_values(array_filter(array_map(static function ($n) use ($photo, $p) {
            return $photo($p['group'], $n);
        }, $p['gallery'])));
        update_post_meta($id, '_fitout_gallery_images', $gallery);
        update_post_meta($id, '_fitout_hero_image', $photo($p['group'], $p['hero']));
        update_post_meta($id, '_fitout_about_image', $photo($p['group'], $p['about']));
        $thumb = $photo_id($p['group'], $p['featured']);
        if ($thumb) {
            set_post_thumbnail($id, $thumb);
        }
    }
    if (!empty($p['append'])) {
        $gallery = (array) get_post_meta($id, '_fitout_gallery_images', true);
        foreach ($p['append'] as $n) {
            $u = $photo($p['group'], $n);
            if ($u && !in_array($u, $gallery, true)) {
                $gallery[] = $u;
            }
        }
        update_post_meta($id, '_fitout_gallery_images', array_values(array_filter($gallery)));
    }
    if (get_post_status($id) !== 'publish') {
        wp_update_post(array('ID' => $id, 'post_status' => 'publish'));
    }
    $log("Project ready and published: $title (#$id)");
}

/* -------------------------------------------------------------- pages */
$chez = static function ($n) use ($photo) {
    return $photo('chez-ami', $n);
};

// Home: facts instead of made-up numbers; hide testimonials copied from the old template; fix broken photo.
update_option('central_build_stats', array(
    array('number' => 'Licensed', 'label' => 'Registered builder CCB-L 100410'),
    array('number' => 'In-house', 'label' => 'Plumbing & electrical teams'),
    array('number' => '5-step', 'label' => 'Design-to-handover process'),
    array('number' => '12 weeks', 'label' => 'Chez Ami: office to 80-seat restaurant'),
));
update_option('central_build_show_testimonials_section', '0');
$about_img = (string) get_option('central_build_about_image');
if ($about_img === '' || strpos($about_img, '/themes/central-build/images/about-image.jpg') !== false) {
    update_option('central_build_about_image', $chez('IMG_1751'));
}
$log('Home: counters, testimonials hidden, photo fixed');

// About: real photo, hide placeholder team.
$a = central_build_get_about_settings();
if (strpos((string) $a['philosophy']['image'], 'unsplash.com') !== false || $a['philosophy']['image'] === '') {
    $a['philosophy']['image'] = $chez('IMG_1749');
}
$placeholder_team = true;
foreach ((array) $a['team']['members'] as $m) {
    if (!preg_match('/^Member [A-Z]$/', (string) $m['name'])) {
        $placeholder_team = false;
    }
}
if ($placeholder_team) {
    $a['team']['show'] = false;
}
update_option('central_build_about_settings', central_build_sanitize_about_settings(wp_slash($a)));
$log('About: photo, team ' . ($placeholder_team ? 'hidden (placeholders)' : 'kept'));

// Commercial Fitouts: facts, own photos, real case study.
$f = central_build_get_cfs_settings();
$f['hero']['background'] = $chez('IMG_1753');
$f['stats'] = array(
    array('icon' => 'fas fa-check-circle', 'number' => 6, 'suffix' => '', 'label' => 'Recent commercial projects'),
    array('icon' => 'fas fa-tools', 'number' => 2, 'suffix' => '', 'label' => 'In-house trades: plumbing & electrical'),
    array('icon' => 'fas fa-shield-alt', 'number' => 1, 'suffix' => ' REG. Builder', 'label' => 'Licence CCB-L 100410'),
);
$inhouse_photos = array($chez('IMG_1673'), $chez('IMG_1748'), $chez('IMG_1118'));
foreach ($f['inhouse'] as $i => $item) {
    if (isset($inhouse_photos[$i])) {
        $f['inhouse'][$i]['image'] = $inhouse_photos[$i];
    }
}
$f['case_study'] = array(
    'title'          => 'Case Study: Chez Ami Restaurant, Sale',
    'intro'          => 'The client needed an existing office in Sale, Victoria turned into a working restaurant, with design, approvals and construction handled by one team.',
    'challenge'      => 'Challenge: 306 m² office to an 80-seat restaurant in about 3 months',
    'solutions'      => array(
        'Design and construction delivered by one team, from concept to handover.',
        'Commercial kitchen, dining room and bar fitted out with our in-house plumbing and electrical trades.',
    ),
    'result_heading' => 'Result: completed on 23 July 2026',
    'result_text'    => 'Now trading as an 80-seat cafe, bistro and bar.',
    'progress_label' => '100% Completed',
    'progress_value' => 100,
    'image'          => $chez('IMG_1752'),
);
update_option('central_build_cfs_settings', central_build_sanitize_cfs_settings(wp_slash($f)));
$log('Commercial Fitouts: facts, photos, Chez Ami case study');

// Services Coordination: facts instead of made-up KPIs, own photo.
$sc = central_build_get_sc_settings();
$sc['metrics'] = array(
    array('number' => 5, 'suffix' => '', 'label' => 'Building services coordinated', 'description' => 'Gas, fire, electrical, mechanical and hydraulic systems under one plan.'),
    array('number' => 1, 'suffix' => '', 'label' => 'Point of contact', 'description' => 'One Central Build project manager for every trade on site.'),
    array('number' => 2, 'suffix' => '', 'label' => 'In-house trades', 'description' => 'Our own plumbers and electricians set the quality standard and the pace.'),
);
$sc['bim']['image'] = $chez('IMG_1231');
update_option('central_build_sc_settings', central_build_sanitize_sc_settings(wp_slash($sc)));
$log('Services Coordination: facts, photo');

// Commercial Stripout: own photos, no unverified size claim.
$cs = central_build_get_cs_settings();
$cs['hero']['background'] = $chez('IMG_1023');
$cs['scale']['images'] = array($chez('IMG_1023'), $chez('IMG_1229'), $chez('IMG_1231'));
$cs['scale']['description'] = 'We use equipment suited to occupied commercial buildings, from single shops to full restaurant conversions, and protect the base building and neighbouring tenants throughout.';
update_option('central_build_cs_settings', central_build_sanitize_cs_settings(wp_slash($cs)));
$log('Commercial Stripout: photos, wording');

// Commercial Interior Design: one contact email.
$ci = central_build_get_cid_settings();
foreach ($ci['cta_block']['items'] as $i => $item) {
    if (strpos((string) $item['text'], '@') !== false) {
        $ci['cta_block']['items'][$i]['text'] = 'admin@centralbuild.au';
    }
}
update_option('central_build_cid_settings', central_build_sanitize_cid_settings(wp_slash($ci)));
$log('Commercial Interior Design: email');

// Contact: working map link and a real photo.
$c = central_build_get_contact_settings();
if (strpos((string) $c['office']['cta_url'], 'path/to') !== false || $c['office']['cta_url'] === '') {
    $c['office']['cta_url'] = 'https://www.google.com/maps/search/?api=1&query=Melbourne+VIC+Australia';
}
if (empty($c['office']['image'])) {
    $c['office']['image'] = $chez('IMG_1752');
}
update_option('central_build_contact_settings', central_build_sanitize_contact_settings(wp_slash($c)));
$log('Contact: map link, photo');

// Stored links to theme images that never existed -> real photos bundled in the theme.
$missing = array(
    'about-image.jpg' => 'cb/cb-dining.jpg', 'cta-default.jpg' => 'cb/cb-project-hero.jpg', 'default-about-team.jpg' => 'cb/cb-team.jpg',
    'fitout-bim.jpg' => 'cb/cb-team.jpg', 'fitout-case-study.jpg' => 'cb/cb-interior.jpg', 'fitout-electrical.jpg' => 'cb/cb-construction.jpg',
    'fitout-plumbing.jpg' => 'cb/cb-kitchen.jpg', 'fitout-specialists-hero.jpg' => 'cb/cb-project-hero.jpg', 'repairs-hero.jpg' => 'cb/cb-kitchen.jpg',
    'services-coordination-bim.jpg' => 'cb/cb-construction.jpg', 'stripout-equipment-1.jpg' => 'cb/cb-demolition.jpg',
    'stripout-equipment-2.jpg' => 'cb/cb-construction.jpg', 'stripout-equipment-3.jpg' => 'cb/cb-shopfront.jpg', 'stripout-hero.jpg' => 'cb/cb-demolition.jpg',
);
$fix = static function ($v) use (&$fix, $missing) {
    if (is_array($v)) {
        foreach ($v as $k => $x) {
            $v[$k] = $fix($x);
        }
        return $v;
    }
    if (is_string($v) && strpos($v, '/themes/central-build/images/') !== false) {
        foreach ($missing as $from => $to) {
            if (substr($v, -strlen('/images/' . $from)) === '/images/' . $from) {
                return substr($v, 0, -strlen($from)) . $to;
            }
        }
    }
    return $v;
};
global $wpdb;
foreach ($wpdb->get_col("SELECT option_name FROM {$wpdb->options} WHERE option_name LIKE 'central\\_build\\_%'") as $opt) {
    $val = get_option($opt);
    $new = $fix($val);
    if ($new !== $val) {
        update_option($opt, $new);
        $log("Fixed missing theme image links in $opt");
    }
}

do_action('litespeed_purge_all');
$log('Done.');
