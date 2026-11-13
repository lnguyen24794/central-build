<?php
/**
 * Template Name: Services Coordination Page
 *
 * Services Coordination – shared service layout. Content: Website Content > Services Coordination.
 *
 * @package Central_Build_Pro
 */

if (!function_exists('central_build_get_sc_settings')) {
    require_once get_template_directory() . '/inc/services-coordination-settings.php';
}

$s       = central_build_get_sc_settings();
$hero    = (array) $s['hero'];
$bim     = (array) $s['bim'];
$contact = (array) $s['contact'];

get_header();
?>
<main id="primary" class="site-main cb-page">
    <?php
    cb_ui_hero(array(
        'eyebrow' => $hero['badge'] ?? 'Services Coordination',
        'title'   => $hero['title'] ?? '',
        'text'    => $hero['description'] ?? '',
        'fact'    => 'Gas, fire, electrical, mechanical and hydraulic services under one plan',
        'image'   => cb_ui_plain($hero['background'] ?? '') !== '' ? $hero['background'] : cb_ui_default_hero_image(),
        'size'    => 'home',
        'buttons' => array(
            array('label' => $hero['cta']['label'] ?? 'Request a risk assessment', 'url' => $hero['cta']['url'] ?? '#contact'),
            array('label' => 'View projects', 'url' => home_url('/projects/')),
        ),
    ));

    cb_ui_section_open('challenges', 'white');
    cb_ui_head('The challenge', 'Where complex projects go wrong', 'Tight ceilings, many trades and live shopping centres leave no room for guesswork.');
    cb_ui_cards(array_map(static function ($p) {
        return array('icon' => $p['icon'] ?? '', 'title' => $p['title'] ?? '', 'text' => $p['description'] ?? '');
    }, (array) $s['problems']), 3);
    cb_ui_section_close();

    cb_ui_section_open('method', 'mist');
    cb_ui_head('Our method', 'How we coordinate every trade', 'One plan, one program and one project manager on site.');
    cb_ui_steps(array_map(static function ($m) {
        return array('title' => $m['title'] ?? '', 'text' => $m['description'] ?? '');
    }, (array) $s['methodology']));
    cb_ui_section_close();

    cb_ui_section_open('bim', 'navy');
    $accordion = array_map(static function ($a) {
        return array('title' => $a['heading'] ?? '', 'text' => $a['body'] ?? '');
    }, (array) ($bim['accordion'] ?? array()));
    cb_ui_split(array(
        'image'   => $bim['image'] ?? '',
        'image_2' => $bim['second_image'] ?? '',
        'eyebrow' => $bim['subtitle'] ?? 'BIM',
        'title'   => $bim['title'] ?? 'The power of BIM',
        'text'    => $bim['description'] ?? '',
        'list'    => $accordion,
        'buttons' => array(array('label' => 'See our design and BIM service', 'url' => home_url('/commercial-design-and-solutions/'), 'style' => 'outline')),
    ));
    $metrics = array();
    foreach ((array) $s['metrics'] as $m) {
        $metrics[] = array(cb_ui_plain(($m['number'] ?? '') . ($m['suffix'] ?? '')) . ' ' . cb_ui_plain($m['label'] ?? ''), $m['description'] ?? '');
    }
    echo '<div style="margin-top:64px">';
    cb_ui_facts($metrics);
    echo '</div>';
    cb_ui_section_close();

    cb_ui_projects_section('Projects we coordinated');

    cb_ui_contact(array(
        'form_id'    => 'services_coordination',
        'eyebrow'    => 'Talk to a project manager',
        'title'      => $contact['heading'] ?? 'Unify your trades',
        'text'       => $contact['description'] ?? '',
        'form_title' => $contact['form_title'] ?? 'Tell us about your project',
        'button'     => $contact['button_label'] ?? 'Request a consultation',
        'ground'     => 'white',
    ));
    ?>
</main>
<?php
get_footer();
