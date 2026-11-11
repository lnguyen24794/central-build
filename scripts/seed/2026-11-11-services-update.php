<?php
/**
 * One-off content update (11 Nov 2026) – client feedback round 2.
 * Safe to run more than once.
 *
 *   wp eval-file 2026-11-11-services-update.php <photo-dir>
 *
 * - Creates the "Commercial Design and Solutions" page
 * - Renames "Commercial Interior Design & Construction" -> "Commercial Interior Design"
 * - Services menu: removes Steel Structure items, lists the 6 service pages
 * - Header: real Facebook link, YouTube link, hides placeholder LinkedIn/Instagram
 * - Footer: real links (no ENP Fitouts leftovers), phone 1300 31 8888, builder licence
 * - About Us: list of services
 * - Imports the client's photos, uses them on the new page
 * - Adds 6 draft projects (5 from the Capability Statement + Mama Tran Dumplings)
 */

if (!defined('ABSPATH')) {
    exit(1);
}

$photo_dir = isset($args[0]) ? rtrim($args[0], '/') : '';
$log = static function ($msg) {
    WP_CLI::log($msg);
};

$facebook = 'https://www.facebook.com/profile.php?id=61580407266348';
$youtube  = 'https://www.youtube.com/watch?v=JM2BOY4dB_0&t=67s';
$phone    = array('display' => '1300 31 8888', 'link' => 'tel:1300318888');
$theme    = get_template_directory_uri();

/* ------------------------------------------------------------------ pages */
function cb_seed_page_by_template(string $template): int
{
    $ids = get_posts(array('post_type' => 'page', 'post_status' => 'any', 'numberposts' => 1, 'fields' => 'ids',
        'meta_key' => '_wp_page_template', 'meta_value' => $template));
    return $ids ? (int) $ids[0] : 0;
}

$cds_id = cb_seed_page_by_template('page-commercial-design-solutions.php');
if (!$cds_id) {
    $cds_id = wp_insert_post(array('post_type' => 'page', 'post_status' => 'publish', 'post_title' => 'Commercial Design and Solutions',
        'post_name' => 'commercial-design-and-solutions', 'page_template' => 'page-commercial-design-solutions.php'));
    $log("Created page Commercial Design and Solutions (#$cds_id)");
} else {
    $log("Page Commercial Design and Solutions exists (#$cds_id)");
}

$cid_id = cb_seed_page_by_template('page-commercial-interior-design.php');
if ($cid_id && get_the_title($cid_id) !== 'Commercial Interior Design') {
    wp_update_post(array('ID' => $cid_id, 'post_title' => 'Commercial Interior Design'));
    $log("Renamed page #$cid_id to Commercial Interior Design");
}
$cid = get_option('central_build_cid_settings');
if (is_array($cid) && isset($cid['hero']['title']) && stripos($cid['hero']['title'], 'DESIGN & CONSTRUCTION') !== false) {
    $cid['hero']['title'] = str_ireplace('INTERIOR DESIGN & CONSTRUCTION', 'INTERIOR DESIGN', $cid['hero']['title']);
    update_option('central_build_cid_settings', $cid);
    $log('Interior Design page heading updated');
}

/* ------------------------------------------------------------------- menu */
$services_order = array(
    '/commercial-design-and-solutions'          => 'Commercial Design and Solutions',
    '/commercial-interior-design-construction'  => 'Commercial Interior Design',
    '/commercial-fitouts'                       => 'Commercial Fitouts',
    '/services-coordination'                    => 'Services Coordination',
    '/commercial-stripout'                      => 'Commercial Stripout',
    '/repairs-and-maintenance'                  => 'Repairs & Maintenance',
);
$rows = cb_ce_menu_get()['items'];
$services_id = 0;
foreach ($rows as $row) {
    if (!$row['parent'] && strcasecmp(trim($row['title']), 'Services') === 0) {
        $services_id = (int) $row['id'];
    }
}
if ($services_id) {
    $existing_children = array();
    $new_rows = array();
    foreach ($rows as $row) {
        if (stripos($row['title'], 'steel structure') !== false) {
            $log('Menu: removing "' . $row['title'] . '"');
            continue; // drops Steel Structure links anywhere in the menu
        }
        if ((int) $row['parent'] === $services_id) {
            $existing_children[cb_ce_url_path($row['url'])] = $row;
            continue;
        }
        $new_rows[] = $row;
        if ((int) $row['id'] === $services_id) {
            foreach ($services_order as $path => $title) {
                // filled after the loop (needs all existing children first)
                $new_rows[] = array('__service' => $path);
            }
        }
    }
    foreach ($new_rows as $i => $row) {
        if (isset($row['__service'])) {
            $path = $row['__service'];
            $child = $existing_children[$path] ?? array('id' => 0, 'url' => $path . '/');
            $new_rows[$i] = array('id' => (int) $child['id'], 'title' => $services_order[$path], 'url' => $child['url'], 'parent' => $services_id);
            unset($existing_children[$path]);
        }
    }
    // Any other existing Services links that are not Steel Structure stay at the end of the drop-down.
    foreach ($existing_children as $child) {
        $new_rows[] = $child;
    }
    cb_ce_menu_save(array('items' => $new_rows));
    $log('Menu: Services drop-down updated');
}

/* ----------------------------------------------------------------- header */
$header = central_build_get_header_settings();
$social = array();
foreach ((array) $header['social_links'] as $link) {
    $host = (string) wp_parse_url((string) $link['url'], PHP_URL_HOST);
    $path = trim((string) wp_parse_url((string) $link['url'], PHP_URL_PATH), '/');
    $is_placeholder = $path === '' && !wp_parse_url((string) $link['url'], PHP_URL_QUERY);
    $label = strtolower((string) $link['label']);
    if ($label === 'facebook') {
        $link['url'] = $facebook;
        $social[] = $link;
    } elseif ($label === 'youtube') {
        continue; // re-added below
    } elseif (!$is_placeholder) {
        $social[] = $link; // keep real LinkedIn / Instagram links
    } else {
        $log('Header: hiding placeholder ' . $link['label'] . " ($host)");
    }
}
$social[] = array('label' => 'YouTube', 'url' => $youtube, 'icon_url' => $theme . '/images/Footer-Youtube.svg', 'icon_alt' => 'YouTube');
$header['social_links'] = $social;
update_option('central_build_header_settings', central_build_sanitize_header_settings(wp_slash($header)));
$log('Header: social links = ' . implode(', ', wp_list_pluck($social, 'label')));

/* ----------------------------------------------------------------- footer */
$footer = central_build_get_footer_settings();
$footer['company']['phone']   = $phone;
$footer['company']['licence'] = 'Builder Licence No. CCB-L 100410';
$footer['company']['description'] = trim(str_replace('Discover the ENP difference.', '', (string) $footer['company']['description']));
$footer['quick_links'] = array(
    array('label' => 'Home', 'url' => home_url('/')),
    array('label' => 'About Us', 'url' => home_url('/about-us/')),
    array('label' => 'Projects', 'url' => home_url('/projects/')),
    array('label' => 'Contact', 'url' => home_url('/contact/')),
);
$footer['support_links'] = array(
    array('label' => 'Repairs & Maintenance', 'url' => home_url('/repairs-and-maintenance/')),
    array('label' => 'Get a Quote', 'url' => home_url('/contact/')),
);
update_option('central_build_footer_settings', central_build_sanitize_footer_settings(wp_slash($footer)));
$log('Footer: links, phone and licence updated');

/* ------------------------------------------------------------------ about */
$about = central_build_get_about_settings();
$about['services'] = central_build_about_settings_defaults()['services'];
update_option('central_build_about_settings', central_build_sanitize_about_settings(wp_slash($about)));
$log('About Us: services list updated');

/* ----------------------------------------------------------------- photos */
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';
require_once ABSPATH . 'wp-admin/includes/image.php';

function cb_seed_import(string $path, string $title): int
{
    $source = basename($path);
    $found = get_posts(array('post_type' => 'attachment', 'post_status' => 'inherit', 'numberposts' => 1, 'fields' => 'ids',
        'meta_key' => '_cb_seed_source', 'meta_value' => $source));
    if ($found) {
        return (int) $found[0];
    }
    if (!is_readable($path)) {
        return 0;
    }
    $tmp = wp_tempnam($source);
    copy($path, $tmp);
    $id = media_handle_sideload(array('name' => sanitize_file_name(strtolower($title)) . '.jpg', 'tmp_name' => $tmp), 0, $title);
    if (is_wp_error($id)) {
        WP_CLI::warning($source . ': ' . $id->get_error_message());
        @unlink($tmp);
        return 0;
    }
    update_post_meta($id, '_cb_seed_source', $source);
    update_post_meta($id, '_wp_attachment_image_alt', $title);
    return (int) $id;
}

$photos = array();
if ($photo_dir && is_dir($photo_dir)) {
    foreach (array('IMG_2530', 'IMG_2531', 'IMG_2532', 'IMG_2533', 'IMG_2535', 'IMG_2536', 'IMG_2537') as $i => $name) {
        $id = cb_seed_import($photo_dir . '/' . $name . '.jpg', 'Mama Tran Dumplings fitout ' . ($i + 1));
        if ($id) {
            $photos[$name] = $id;
        }
    }
    $log('Photos imported: ' . count($photos));
} else {
    $log('No photo folder given; skipping photos');
}
$url = static function ($name) use ($photos) {
    return isset($photos[$name]) ? (string) wp_get_attachment_image_url($photos[$name], 'full') : '';
};

$cds = get_option('central_build_cds_settings');
$cds = is_array($cds) ? $cds : array();
$cds_now = central_build_get_cds_settings();
if (empty($cds_now['hero']['background']) && $url('IMG_2531')) {
    $cds['hero'] = array_merge($cds_now['hero'], array('background' => $url('IMG_2531')));
}
if (empty($cds_now['intro']['image']) && $url('IMG_2535')) {
    $cds['intro'] = array_merge($cds_now['intro'], array('image' => $url('IMG_2535')));
}
if ($cds) {
    update_option('central_build_cds_settings', central_build_sanitize_cds_settings(wp_slash(array_merge($cds_now, $cds))));
    $log('Design page photos set');
}

/* --------------------------------------------------------------- projects */
$fitout_cat = get_term_by('name', 'Fitout Projects', 'fitout_category');
$projects = array(
    array(
        'title' => 'Chez Ami Restaurant',
        'content' => 'Conversion of an existing office into an 80-seat restaurant in Sale, Victoria. Central Build delivered the project from design through construction in about three months.',
        'client' => 'Chez Ami', 'location' => '233-239 Raymond Street, Sale VIC 3850', 'sqm' => '306 m²', 'date' => '2026-07-23',
        'elements' => "Scope: design and construction\nProject value: \$650,000\nDuration: about 3 months (1 May to 23 July 2026)\nConversion of an existing office to an 80-seat restaurant",
    ),
    array(
        'title' => 'Heiwa Headspa',
        'content' => 'Conversion of an existing office into a head spa in Geelong, completed in about two months.',
        'client' => 'Heiwa Headspa', 'location' => '100 Ryrie St, Geelong', 'sqm' => '50 m²', 'date' => '',
        'elements' => "Scope: construction\nProject value: \$100,000\nDuration: about 2 months\nConversion of an existing office to a head spa",
    ),
    array(
        'title' => 'Laksa King',
        'content' => 'Restaurant upgrade at Westfield Southland, completed in two weeks.',
        'client' => 'Laksa King', 'location' => 'Westfield Southland, 1239 Nepean Hwy, Cheltenham', 'sqm' => '100 m²', 'date' => '',
        'elements' => "Scope: construction\nProject value: \$50,000\nDuration: 2 weeks\nRestaurant upgrade",
    ),
    array(
        'title' => 'Yan Rolls & Coffee',
        'content' => 'Renovation of a coffee shop in Kilsyth, completed in four weeks.',
        'client' => 'Yan Rolls & Coffee', 'location' => 'Shop 14, 518 Dandenong Rd, Kilsyth', 'sqm' => '60 m²', 'date' => '',
        'elements' => "Scope: construction\nProject value: \$50,000\nDuration: 4 weeks\nRenovation of a coffee shop",
    ),
    array(
        'title' => 'Hoppers Crossing Rooming House',
        'content' => 'Conversion of a Class 1a house into a Class 1b rooming house, completed in six weeks.',
        'client' => '', 'location' => '1 Regent St, Hoppers Crossing', 'sqm' => '150 m²', 'date' => '',
        'elements' => "Scope: construction\nProject value: \$150,000\nDuration: 6 weeks\nConversion of a Class 1a house to a Class 1b rooming house",
    ),
    array(
        'title' => 'Mama Tran Dumplings',
        'content' => 'Food court shopfront fitout for Mama Tran Dumplings: signage, servery counter, display fridges and kitchen fit-out.',
        'client' => 'Mama Tran Dumplings', 'location' => '', 'sqm' => '', 'date' => '',
        'elements' => '', 'photos' => array('IMG_2531', 'IMG_2530', 'IMG_2532', 'IMG_2533', 'IMG_2535', 'IMG_2536', 'IMG_2537'),
    ),
);
foreach ($projects as $p) {
    $exists = get_posts(array('post_type' => 'fitout_sector', 'post_status' => 'any', 'title' => $p['title'], 'numberposts' => 1, 'fields' => 'ids'));
    if ($exists) {
        $log('Project exists: ' . $p['title']);
        continue;
    }
    $id = wp_insert_post(array('post_type' => 'fitout_sector', 'post_status' => 'draft', 'post_title' => $p['title'], 'post_content' => $p['content']));
    if (!$id || is_wp_error($id)) {
        continue;
    }
    foreach (array('client' => '_fitout_client', 'location' => '_fitout_location', 'sqm' => '_fitout_sqm', 'date' => '_fitout_created_date', 'elements' => '_fitout_key_elements') as $k => $meta) {
        if ($p[$k] !== '') {
            update_post_meta($id, $meta, $p[$k]);
        }
    }
    update_post_meta($id, '_fitout_about_project', $p['content']);
    if ($fitout_cat) {
        wp_set_object_terms($id, (int) $fitout_cat->term_id, 'fitout_category');
    }
    if (!empty($p['photos'])) {
        $gallery = array_values(array_filter(array_map($url, $p['photos'])));
        if ($gallery) {
            update_post_meta($id, '_fitout_gallery_images', $gallery);
            update_post_meta($id, '_fitout_hero_image', $gallery[0]);
            update_post_meta($id, '_fitout_about_image', $gallery[min(4, count($gallery) - 1)]);
            set_post_thumbnail($id, $photos[$p['photos'][0]]);
        }
    }
    $log('Draft project added: ' . $p['title'] . " (#$id)");
}

do_action('litespeed_purge_all');
$log('Done.');
