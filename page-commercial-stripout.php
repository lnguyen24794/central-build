<?php
/**
 * Template Name: commercial-stripout Page
 *
 * Commercial Stripout – shared service layout. Content: Website Content > Commercial Stripout.
 *
 * @package Central_Build_Pro
 */

if (!function_exists('central_build_get_cs_settings')) {
    require_once get_template_directory() . '/inc/commercial-stripout-settings.php';
}

$s       = central_build_get_cs_settings();
$hero    = (array) $s['hero'];
$tech    = (array) $s['technical'];
$scale   = (array) $s['scale'];
$contact = (array) $s['contact'];
$images  = array_values(array_filter((array) ($scale['images'] ?? array())));

get_header();
?>
<main id="primary" class="site-main cb-page">
    <?php
    cb_ui_hero(array(
        'eyebrow' => $hero['subtitle'] ?? 'Commercial Stripout',
        'title'   => $hero['title'] ?? '',
        'text'    => $hero['description'] ?? '',
        'fact'    => 'Services made safe by our own licensed plumbers and electricians',
        'image'   => $hero['background'] ?? 'cb/cb-demolition.jpg',
        'size'    => 'home',
        'buttons' => array(
            array('label' => $hero['cta']['label'] ?? 'Get a stripout quote', 'url' => $hero['cta']['url'] ?? '#contact'),
            array('label' => 'View projects', 'url' => home_url('/projects/')),
        ),
    ));

    // Promise and safety merged into one set of cards.
    $cards = array();
    foreach ((array) $s['promise'] as $p) {
        $cards[] = array('icon' => $p['icon'] ?? '', 'label' => $p['title'] ?? '', 'title' => $p['subtitle'] ?? '', 'text' => $p['description'] ?? '');
    }
    foreach ((array) $s['safety'] as $p) {
        $cards[] = array('icon' => $p['icon'] ?? '', 'label' => 'Safety', 'title' => $p['title'] ?? '', 'text' => $p['description'] ?? '');
    }
    cb_ui_section_open('promise', 'white');
    cb_ui_head('Our promise', 'Safe, clean and ready for the next trade', 'Every stripout follows the same protocol, from site protection to the final compliance check.');
    cb_ui_cards($cards, 3);
    cb_ui_section_close();

    cb_ui_section_open('capability', 'mist');
    cb_ui_split(array(
        'image'   => $images[0] ?? ($hero['background'] ?? ''),
        'eyebrow' => 'Capability',
        'title'   => $tech['heading'] ?? 'Our demolition capability',
        'text'    => $tech['introduction'] ?? '',
        'list'    => array_map(static function ($c) {
            return array('title' => $c['title'] ?? '', 'text' => $c['description'] ?? '');
        }, (array) ($tech['cards'] ?? array())),
    ));
    cb_ui_section_close();

    cb_ui_section_open('scale', 'navy');
    cb_ui_head($scale['subtitle'] ?? 'Any scale', $scale['heading'] ?? 'Ready for any scale', $scale['description'] ?? '');
    if (count($images) > 1) {
        echo '<div class="cb-photos" style="--n:' . min(3, count($images)) . '">';
        foreach (array_slice($images, 0, 3) as $img) {
            echo '<img src="' . esc_url($img) . '" alt="' . esc_attr__('Commercial stripout by Central Build', 'central-build') . '" loading="lazy">';
        }
        echo '</div>';
    }
    cb_ui_section_close();

    cb_ui_projects_section('Recent projects');

    cb_ui_contact(array(
        'form_id'    => 'commercial_stripout',
        'eyebrow'    => 'Get a quote',
        'title'      => $contact['title'] ?? 'Your fit-out begins with a clean, safe stripout',
        'text'       => $contact['description'] ?? '',
        'form_title' => $contact['form_title'] ?? 'Request a stripout quote',
        'button'     => $contact['button_label'] ?? 'Request a quote',
        'ground'     => 'white',
    ));
    ?>
</main>
<?php
get_footer();
