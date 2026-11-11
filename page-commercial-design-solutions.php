<?php
/**
 * Template Name: Commercial Design and Solutions Page
 *
 * Design, 3D/VR walkthroughs and BIM – shared service layout.
 * All content is edited in Website Content → Commercial Design and Solutions.
 *
 * @package Central_Build_Pro
 */

if (!function_exists('central_build_get_cds_settings')) {
    require_once get_template_directory() . '/inc/design-solutions-settings.php';
}

$s       = central_build_get_cds_settings();
$hero    = (array) $s['hero'];
$intro   = (array) $s['intro'];
$caps    = (array) $s['capabilities'];
$bim     = (array) $s['bim'];
$videos  = (array) $s['videos'];
$process = (array) $s['process'];
$contact = (array) $s['contact'];

$video_items = array();
foreach ((array) ($videos['items'] ?? array()) as $video) {
    $video = (array) $video;
    $video['poster'] = $video['poster_image'] ?? '';
    if (central_build_video_item($video)) {
        $video_items[] = $video;
    }
}

get_header();
?>
<main id="primary" class="site-main cb-page">
    <?php
    cb_ui_hero(array(
        'eyebrow' => $hero['badge'] ?? 'Commercial Design and Solutions',
        'title'   => $hero['title'] ?? '',
        'text'    => $hero['description'] ?? '',
        'fact'    => 'Chez Ami: walked through in 3D and VR, built in 12 weeks',
        'image'   => $hero['background'] ?? '',
        'size'    => 'home',
        'buttons' => array(
            array('label' => $hero['cta']['label'] ?? 'Talk to our design team', 'url' => $hero['cta']['url'] ?? '#contact'),
            array('label' => 'Watch the walkthrough', 'url' => '#videos'),
        ),
    ));

    cb_ui_section_open('design', 'white');
    cb_ui_split(array(
        'image'   => $intro['image'] ?? '',
        'eyebrow' => 'Design capability',
        'title'   => $intro['heading'] ?? '',
        'text'    => $intro['text'] ?? '',
    ));
    cb_ui_section_close();

    if ($video_items) {
        cb_ui_section_open('videos', 'navy');
        cb_ui_head('Video & VR', $videos['heading'] ?? '3D walkthroughs', $videos['text'] ?? '');
        central_build_render_video_wall($video_items);
        cb_ui_section_close();
    }

    cb_ui_section_open('capabilities', 'white');
    cb_ui_head('What we deliver', $caps['heading'] ?? 'Our design capability', 'From the first layout to permit drawings, coordinated with the team that builds it.');
    cb_ui_cards(array_map(static function ($i) {
        return array('icon' => $i['icon'] ?? '', 'title' => $i['title'] ?? '', 'text' => $i['description'] ?? '');
    }, (array) ($caps['items'] ?? array())), 3);
    cb_ui_section_close();

    cb_ui_section_open('bim', 'mist');
    cb_ui_split(array(
        'image'   => !empty($bim['image']) ? $bim['image'] : ($intro['image'] ?? ''),
        'reverse' => true,
        'eyebrow' => $bim['subtitle'] ?? 'BIM',
        'title'   => $bim['heading'] ?? '',
        'text'    => $bim['description'] ?? '',
        'list'    => (array) ($bim['points'] ?? array()),
    ));
    cb_ui_section_close();

    cb_ui_section_open('process', 'white');
    cb_ui_head('Process', $process['heading'] ?? 'Our design process', 'The same five steps we use on every project, from budget to handover.');
    cb_ui_steps(array_map(static function ($p) {
        return array('title' => $p['title'] ?? '', 'text' => $p['description'] ?? '');
    }, (array) ($process['steps'] ?? array())));
    cb_ui_section_close();

    cb_ui_projects_section('Designed and built by Central Build');

    cb_ui_contact(array(
        'form_id'    => 'design_solutions',
        'eyebrow'    => 'Design consultation',
        'title'      => $contact['heading'] ?? 'Have a space in mind?',
        'text'       => $contact['description'] ?? '',
        'form_title' => $contact['form_title'] ?? 'Book a design consultation',
        'button'     => $contact['button_label'] ?? 'Request a consultation',
        'ground'     => 'white',
    ));
    ?>
</main>
<?php
get_footer();
