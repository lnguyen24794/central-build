<?php
/**
 * Client feedback round 3 (11 Nov 2026, red notes in the analysis doc). Safe to run more than once.
 *
 *   wp eval-file 2026-11-11-feedback-round3.php <photo-root>
 *
 * <photo-root>/<project>/*.jpg  (upright JPGs, EXIF removed; "featured.jpg" = the project's main photo)
 *
 * 1. Projects: photos exactly as in the client's filtered Drive folders; "featured" photo as the main photo.
 *    "Fitout Projects" renamed "Completed Projects"; upcoming project "Little Summer Coffee" added as a draft.
 * 2. Services menu: "Commercial Interior Design" removed (merged into Commercial Design and Solutions).
 * 3. Service pages rewritten around the client's focus points.
 * 4. YouTube channel and LinkedIn company page.
 */

if (!defined('ABSPATH')) {
    exit(1);
}
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';
require_once ABSPATH . 'wp-admin/includes/image.php';

$root = isset($args[0]) ? rtrim($args[0], '/') : '';
$log  = static function ($m) { WP_CLI::log($m); };

$titles = array('chez-ami' => 'Chez Ami Restaurant', 'heiwa' => 'Heiwa Headspa', 'yan-rolls' => 'Yan Rolls & Coffee',
    'hoppers-crossing' => 'Hoppers Crossing Rooming House', 'mama-tran' => 'Mama Tran Dumplings');

/** Attachment for <group>/<name>, imported once (identified by _cb_seed_source). Returns [id, url]. */
$photo = static function (string $group, string $name) use ($root, $titles): array {
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
            return $cache[$key] = array(0, '');
        }
        $tmp = wp_tempnam($name);
        copy($path, $tmp);
        $label = $titles[$group] ?? $group;
        $id = media_handle_sideload(array('name' => sanitize_file_name("$group-$name.jpg"), 'tmp_name' => $tmp), 0, "$label " . strtolower($name));
        if (is_wp_error($id)) {
            WP_CLI::warning("$key: " . $id->get_error_message());
            @unlink($tmp);
            return $cache[$key] = array(0, '');
        }
        update_post_meta($id, '_cb_seed_source', $key);
        update_post_meta($id, '_wp_attachment_image_alt', $label);
    }
    return $cache[$key] = array($id, (string) wp_get_attachment_image_url($id, 'full'));
};

/* ----------------------------------------------------------- 1. projects */
// Gallery = the photos left in each Drive folder, main photo first.
$projects = array(
    'Chez Ami Restaurant'            => array('group' => 'chez-ami', 'featured' => 'IMG_1752', 'about' => 'IMG_1751',
        'gallery' => array('IMG_1752', 'IMG_1751', 'IMG_1750', 'IMG_1749', 'IMG_1674', 'IMG_1026')),
    'Heiwa Headspa'                  => array('group' => 'heiwa', 'featured' => 'IMG_7403', 'about' => 'IMG_7404',
        'gallery' => array('IMG_7403', 'IMG_7404', 'IMG_7407', 'IMG_7408')),
    'Yan Rolls & Coffee'             => array('group' => 'yan-rolls', 'featured' => 'featured', 'about' => 'IMG_0143',
        'gallery' => array('featured', 'IMG_0142', 'IMG_0143')),
    'Hoppers Crossing Rooming House' => array('group' => 'hoppers-crossing', 'featured' => 'featured', 'about' => 'IMG_1191',
        'gallery' => array('featured', 'IMG_1191', 'IMG_1192', 'IMG_1193', 'IMG_1209', 'IMG_1202', 'IMG_1189', 'IMG_1190', 'IMG_1194',
            'IMG_1196', 'IMG_1198', 'IMG_1199', 'IMG_1200', 'IMG_1201', 'IMG_1203', 'IMG_1205', 'IMG_1206')),
    'Mama Tran Dumplings'            => array('group' => 'mama-tran', 'featured' => 'featured', 'about' => 'IMG_2537-upright',
        'gallery' => array('featured', 'IMG_2537-upright')),
);
foreach ($projects as $title => $p) {
    $ids = get_posts(array('post_type' => 'fitout_sector', 'post_status' => 'any', 'title' => $title, 'numberposts' => 1, 'fields' => 'ids'));
    if (!$ids) {
        WP_CLI::warning("project not found: $title");
        continue;
    }
    $id = (int) $ids[0];
    $gallery = array();
    foreach ($p['gallery'] as $n) {
        list(, $url) = $photo($p['group'], $n);
        if ($url) {
            $gallery[] = $url;
        }
    }
    if (!$gallery) {
        WP_CLI::warning("no photos for $title, left unchanged");
        continue;
    }
    list($thumb_id, $thumb_url) = $photo($p['group'], $p['featured']);
    list(, $about_url) = $photo($p['group'], $p['about']);
    update_post_meta($id, '_fitout_gallery_images', $gallery);
    if ($thumb_id) {
        set_post_thumbnail($id, $thumb_id);
        update_post_meta($id, '_fitout_hero_image', $thumb_url);
    }
    if ($about_url) {
        update_post_meta($id, '_fitout_about_image', $about_url);
    }
    $log(sprintf('Project photos updated: %s (#%d, %d photos)', $title, $id, count($gallery)));
}

// Portfolio: completed and upcoming projects.
$tax = 'fitout_category';
$done = get_term_by('slug', 'fitout-projects', $tax);
if ($done && $done->name !== 'Completed Projects') {
    wp_update_term($done->term_id, $tax, array('name' => 'Completed Projects'));
    $log('Category renamed: Fitout Projects -> Completed Projects');
}
$upcoming = get_term_by('slug', 'upcoming-projects', $tax);
if ($done) {
    wp_update_term($done->term_id, $tax, array('description' => 'Fitouts we have delivered across Victoria: restaurants, cafés, food court shops, health and beauty spaces and building conversions.'));
}
if ($upcoming) {
    wp_update_term($upcoming->term_id, $tax, array('description' => 'Projects now in design and planning. See how our design, 3D walkthroughs and BIM coordination shape each space before construction starts.'));
}
$little = get_posts(array('post_type' => 'fitout_sector', 'post_status' => 'any', 'title' => 'Little Summer Coffee Renovation', 'numberposts' => 1, 'fields' => 'ids'));
if (!$little) {
    $lid = wp_insert_post(array(
        'post_type'    => 'fitout_sector',
        'post_status'  => 'draft', // publish once renders/photos the client may show are added
        'post_title'   => 'Little Summer Coffee Renovation',
        'post_excerpt' => 'Café renovation at The Pines Shopping Centre: new coffee bar, bakery display and back-of-house kitchen.',
        'post_content' => 'Upcoming project: renovation of Little Summer Coffee at The Pines Shopping Centre.',
    ));
    if ($lid && !is_wp_error($lid)) {
        update_post_meta($lid, '_fitout_location', 'The Pines Shopping Centre, VIC');
        update_post_meta($lid, '_fitout_about_project', "Renovation of a busy shopping centre café, now at concept design stage.\n\nThe new layout brings the order area, coffee machine and bakery display to the front, with a fully equipped back-of-house kitchen, prep benches and a separate washing area behind.");
        update_post_meta($lid, '_fitout_key_elements', "Front counter with POS and bakery display\nCoffee station with grinder and pitcher rinser\nCommercial kitchen with induction cooking and speed oven\nSeparate washing area and storage");
        if ($upcoming) {
            wp_set_object_terms($lid, array((int) $upcoming->term_id), $tax);
        }
        $log("Upcoming project added as a draft: Little Summer Coffee Renovation (#$lid)");
    }
}

/* ---------------------------------------------------- 2. services menu */
$menu = wp_get_nav_menu_object('Main');
if ($menu) {
    foreach (wp_get_nav_menu_items($menu->term_id) as $item) {
        if (strpos((string) $item->url, 'commercial-interior-design') !== false) {
            wp_delete_post($item->ID, true);
            $log('Menu item removed: ' . $item->title);
        }
        if (strpos((string) $item->url, 'fitout-sectors/fitout-projects') !== false && $item->title !== 'Completed Projects') {
            wp_update_post(array('ID' => $item->ID, 'post_title' => 'Completed Projects'));
            $log('Menu item renamed: Completed Projects');
        }
    }
}
// About page service list: drop the merged page.
$about = get_option('central_build_about_settings');
if (is_array($about)) {
    $strip = static function ($v) use (&$strip) {
        if (!is_array($v)) {
            return $v;
        }
        $out = array();
        foreach ($v as $k => $x) {
            if (is_array($x) && isset($x['url']) && strpos((string) $x['url'], 'commercial-interior-design') !== false) {
                continue;
            }
            $out[$k] = $strip($x);
        }
        return array_keys($v) === range(0, count($v) - 1) ? array_values($out) : $out;
    };
    update_option('central_build_about_settings', $strip($about));
}

/* ------------------------------------------------- 3. service pages */
$merge = static function (string $option, array $changes) use ($log) {
    $current = get_option($option);
    if (!is_array($current)) {
        WP_CLI::warning("$option not found");
        return;
    }
    update_option($option, array_replace($current, $changes));
    $log("Updated $option: " . implode(', ', array_keys($changes)));
};

// Commercial Design and Solutions: design capability, video & VR, BIM clash detection.
$cds = get_option('central_build_cds_settings');
$merge('central_build_cds_settings', array(
    'hero' => array_replace((array) ($cds['hero'] ?? array()), array(
        'badge'       => 'Commercial Design and Solutions',
        'title'       => 'SEE IT. WALK IT. <span style="color: var(--accent-color)">THEN BUILD IT.</span>',
        'description' => 'Design, 3D walkthrough videos, virtual reality and BIM coordination from the team that builds it, so every decision is made before work starts on site.',
    )),
    'intro' => array_replace((array) ($cds['intro'] ?? array()), array(
        'heading' => 'Design capability built for construction',
        'text'    => 'Central Build designs with construction in mind. Our designers work alongside partnered architects and our BIM team to turn your brief into layouts, finishes and documents that are ready to build: priced, coordinated with every trade and approved before work starts.',
    )),
    'capabilities' => array(
        'heading' => 'Our Design Capability',
        'items'   => array(
            array('icon' => 'fas fa-drafting-compass', 'title' => 'Concept & Space Planning', 'description' => 'Layouts that work for your customers, staff and equipment, tested against your budget from day one.'),
            array('icon' => 'fas fa-palette', 'title' => 'Interior Design & Finishes', 'description' => 'Materials, joinery, lighting and finishes chosen to suit your brand, your budget and daily use.'),
            array('icon' => 'fas fa-video', 'title' => '3D Walkthrough Videos', 'description' => 'Realistic walkthrough videos of your space, so you can see the result and sign off with confidence before construction.'),
            array('icon' => 'fas fa-vr-cardboard', 'title' => 'Virtual Reality (VR)', 'description' => 'Step inside your future space in VR to check layout, sightlines and finishes at true scale.'),
            array('icon' => 'fas fa-cubes', 'title' => 'BIM Modelling', 'description' => 'Every service modelled together, so clashes between trades are solved on screen instead of on site.'),
            array('icon' => 'fas fa-file-signature', 'title' => 'Documentation & Approvals', 'description' => 'Coordinated drawings for building permits, shopping centre approvals and construction.'),
        ),
    ),
    'bim' => array_replace((array) ($cds['bim'] ?? array()), array(
        'heading'     => 'BIM for Complex Projects: Solve Clashes on Screen, Not on Site',
        'subtitle'    => 'Clash monitoring between every trade and service.',
        'description' => 'On complex projects, building services compete for the same ceiling and wall space. Our BIM team models the electrical, mechanical, fire and plumbing services together with the architecture and structure, monitors clashes between trades and resolves them in the model before anyone is on site.',
        'points'      => array(
            'Clash detection between electrical, mechanical, fire and plumbing services',
            'One coordinated 3D model shared with you, your consultants and every trade',
            'Accurate quantities for cost planning and ordering',
            'Clear, coordinated drawings that reduce re-work and delays',
        ),
    )),
    'videos' => array_replace((array) ($cds['videos'] ?? array()), array(
        'heading' => '3D Walkthroughs & Virtual Tours',
        'text'    => 'Walk through our designs before they are built. More videos on the Central Build YouTube channel.',
    )),
));

// Commercial Fitouts: planning, trade coordination, in-house services, site communication.
$cfs = get_option('central_build_cfs_settings');
$merge('central_build_cfs_settings', array(
    'hero' => array_replace((array) ($cfs['hero'] ?? array()), array(
        'description' => 'Planned, tracked and coordinated fitouts delivered by one team with in-house trades, so your space opens on time and on budget.',
    )),
    'pillars' => array(
        array('title' => 'Planning & Tracking', 'heading' => 'Planned, Tracked and Ahead of Risk',
            'description' => 'Every project starts with a detailed construction program. We track progress against it every week and forecast the risks that could delay your project, such as long-lead items, approvals and site access, so they are solved before they cost you time.'),
        array('title' => 'Trade Coordination', 'heading' => 'No Gaps Between Trades',
            'description' => 'We sequence and coordinate every trade so the next one is ready as soon as the last one finishes. Coordinated drawings and daily site management mean no idle days, no clashes and no gaps in construction.'),
        array('title' => 'In-House Services', 'heading' => 'In-House Trades Speed Up the Build',
            'description' => 'Our own plumbing and electrical teams are on site from day one. Fewer handovers to outside contractors means faster decisions, a faster build and consistent quality.'),
        array('title' => 'Site Communication', 'heading' => 'Excellent Communication with Every Stakeholder',
            'description' => 'One project manager keeps clients, shopping centre management, council, building consultants and subcontractors informed, with regular updates and fast answers, so approvals and inspections never hold up the job.'),
    ),
));

// Services Coordination: complex work that needs coordinating.
$sc = get_option('central_build_sc_settings');
$merge('central_build_sc_settings', array(
    'hero' => array_replace((array) ($sc['hero'] ?? array()), array(
        'badge'       => 'Services Coordination for Complex Projects',
        'description' => 'Complex fitouts bring many trades and building services into one tight space. Central Build plans, sequences and coordinates them all, from electrical, mechanical, fire and plumbing services to specialist equipment, so everything fits together first time.',
    )),
    'problems' => array(
        array('icon' => 'fas fa-exclamation-triangle', 'title' => 'Crowded Ceilings & Walls', 'description' => 'Ducts, pipes, cables and sprinklers competing for the same space lead to costly clashes and re-work.'),
        array('icon' => 'fas fa-clock', 'title' => 'Many Trades, One Program', 'description' => 'Specialist trades working out of sequence cause bottlenecks, idle days and delays.'),
        array('icon' => 'fas fa-building', 'title' => 'Base Building Connections', 'description' => 'Connecting to shopping centre and base building services needs approvals, shutdowns and careful timing.'),
    ),
    'methodology' => array(
        array('step' => '1', 'icon' => 'fas fa-laptop-code', 'title' => 'BIM Clash Detection', 'description' => 'All services are modelled together and clashes are resolved before work starts on site.'),
        array('step' => '2', 'icon' => 'fas fa-stream', 'title' => 'Sequenced Program', 'description' => 'A detailed program sets when each trade starts and finishes, including shutdowns and inspections.'),
        array('step' => '3', 'icon' => 'fas fa-headset', 'title' => 'Daily On-Site Coordination', 'description' => 'Our project manager runs the site every day, solving issues as they arise and keeping every trade informed.'),
    ),
));

// Commercial Stripout: demolition capability.
$cs = get_option('central_build_cs_settings');
$merge('central_build_cs_settings', array(
    'hero' => array_replace((array) ($cs['hero'] ?? array()), array(
        'title'       => 'Demolition Done Right. <span style="color: var(--accent-color)">Ready to Build.</span>',
        'subtitle'    => 'Commercial demolition and stripouts you can rely on.',
        'description' => 'Central Build carries out safe, controlled demolition and stripouts of commercial tenancies, from single shops to full restaurant and office conversions, leaving a clean, compliant site ready for the fit-out.',
    )),
    'promise' => array(
        array('icon' => 'fas fa-hammer', 'title' => 'Capability', 'subtitle' => 'Full & Selective Demolition', 'description' => 'Complete stripouts back to base building, or selective removal of walls, ceilings, floors, joinery and services.'),
        array('icon' => 'fas fa-hard-hat', 'title' => 'Safety', 'subtitle' => 'Safe Work Methods', 'description' => 'Site-specific safety plans, services isolated first and certified partners for hazardous materials.'),
        array('icon' => 'fas fa-tachometer-alt', 'title' => 'Speed', 'subtitle' => 'Rapid Turnaround', 'description' => 'Experienced crews and the right equipment for occupied centres, working around trading hours when required.'),
    ),
    'technical' => array_replace((array) ($cs['technical'] ?? array()), array(
        'heading'      => 'Our Demolition Capability',
        'introduction' => 'From make-good at the end of a lease to clearing a space for a new fit-out, we handle the whole job:',
        'cards'        => array(
            array('title' => 'Internal Demolition', 'description' => 'Partitions, ceilings, floor finishes, shopfronts, kitchens and joinery removed safely and efficiently, without damaging the base building.'),
            array('title' => 'Make Safe & Waste Management', 'description' => 'Electrical and plumbing services isolated by our in-house licensed trades before work starts; materials sorted for recycling with documented disposal.'),
        ),
    )),
));

/* ------------------------------------------------- 4. social links */
$youtube  = 'https://www.youtube.com/@CENTRALBUILD';
$linkedin = 'https://www.linkedin.com/company/110246046/';
$header = get_option('central_build_header_settings');
if (is_array($header)) {
    $icons = get_template_directory_uri() . '/images/';
    $header['social_links'] = array(
        array('label' => 'Facebook', 'url' => 'https://www.facebook.com/profile.php?id=61580407266348', 'icon_url' => $icons . 'Footer-Fb.svg', 'icon_alt' => 'Facebook'),
        array('label' => 'YouTube', 'url' => $youtube, 'icon_url' => $icons . 'Footer-Youtube.svg', 'icon_alt' => 'YouTube'),
        array('label' => 'LinkedIn', 'url' => $linkedin, 'icon_url' => $icons . 'Linkedin-Icon-Big.svg', 'icon_alt' => 'LinkedIn'),
    );
    update_option('central_build_header_settings', $header);
    $log('Header social links: Facebook, YouTube channel, LinkedIn');
}
update_option('central_build_header_linkedin', $linkedin);
update_option('central_build_contact_linkedin', $linkedin);

do_action('litespeed_purge_all');
$log('Done.');
