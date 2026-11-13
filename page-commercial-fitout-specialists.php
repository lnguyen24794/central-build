<?php
/**
 * Template Name: commercial-fitout-specialists Page
 *
 * Commercial Fitouts – shared service layout (hero, promise, in-house, process, case study, projects, contact).
 * Content: Website Content > Commercial Fitouts.
 *
 * @package Central_Build_Pro
 */

if (!function_exists('central_build_get_cfs_settings')) {
    require_once get_template_directory() . '/inc/commercial-fitout-specialists-settings.php';
}

$s       = central_build_get_cfs_settings();
$hero    = (array) $s['hero'];
$inhouse = array_values((array) $s['inhouse']);
$case    = (array) $s['case_study'];
$cta     = (array) $s['final_cta'];
$chez    = get_posts(array('post_type' => 'fitout_sector', 'post_status' => 'publish', 'title' => 'Chez Ami Restaurant', 'numberposts' => 1, 'fields' => 'ids'));

get_header();
?>
<main id="primary" class="site-main cb-page">
    <?php
    cb_ui_hero(array(
        'eyebrow' => $hero['badge'] ?? 'Commercial Fitouts',
        'title'   => $hero['title'] ?? '',
        'text'    => $hero['description'] ?? '',
        'image'   => cb_ui_plain($hero['background'] ?? '') !== '' ? $hero['background'] : cb_ui_default_hero_image(),
        'size'    => 'home',
        'buttons' => array(
            array('label' => $hero['cta']['label'] ?? 'Get a fitout quote', 'url' => $hero['cta']['url'] ?? '#contact'),
            array('label' => 'View fitout projects', 'url' => home_url('/projects/')),
        ),
    ));

    cb_ui_section_open('how-we-deliver', 'white');
    cb_ui_head('How we deliver', 'How we deliver every fitout', 'Four things we do on every job, so your space opens on time and on budget.');
    cb_ui_cards(array_map(static function ($p) {
        return array('label' => $p['title'] ?? '', 'title' => $p['heading'] ?? '', 'text' => $p['description'] ?? '');
    }, (array) $s['pillars']), 4);
    cb_ui_section_close();

    if ($inhouse) {
        cb_ui_section_open('in-house', 'mist');
        cb_ui_split(array(
            'image'   => $inhouse[0]['image'] ?? '',
            'eyebrow' => 'In-house trades',
            'title'   => 'We own the process with our in-house teams',
            'text'    => 'Our own plumbers and electricians work on site from day one, alongside our project managers and BIM team. Fewer handovers mean faster decisions and consistent quality.',
            'list'    => array_map(static function ($u) {
                return array('title' => $u['title'] ?? '', 'text' => $u['description'] ?? '');
            }, $inhouse),
        ));
        cb_ui_section_close();
    }

    cb_ui_section_open('process', 'white');
    cb_ui_head('Process', 'From brief to handover', 'One team and one program from the first consultation to the keys.');
    cb_ui_steps(array_map(static function ($j) {
        return array('title' => $j['title'] ?? '', 'text' => $j['description'] ?? '');
    }, (array) $s['journey']));
    cb_ui_section_close();

    if (!empty($case['title'])) {
        cb_ui_section_open('case-study', 'navy');
        cb_ui_split(array(
            'image'   => $case['image'] ?? '',
            'reverse' => true,
            'eyebrow' => 'Case study',
            'title'   => preg_replace('/^Case Study:\s*/i', '', (string) $case['title']),
            'text'    => array($case['intro'] ?? '', preg_replace('/^Challenge:\s*/i', 'The brief: ', (string) ($case['challenge'] ?? ''))),
            'list'    => array_merge((array) ($case['solutions'] ?? array()), array(trim(preg_replace('/^Result:\s*/i', '', (string) ($case['result_heading'] ?? '')) . '. ' . cb_ui_plain($case['result_text'] ?? ''), '. '))),
            'buttons' => $chez ? array(array('label' => 'Read the Chez Ami story', 'url' => get_permalink($chez[0]))) : array(),
        ));
        cb_ui_section_close();
    }

    cb_ui_projects_section('Recent fitout projects');

    cb_ui_contact(array(
        'form_id'    => 'commercial_fitout_specialists',
        'eyebrow'    => 'Start your fitout',
        'title'      => $cta['title'] ?? 'Planning a fitout?',
        'text'       => $cta['description'] ?? '',
        'form_title' => $cta['form_title'] ?? 'Request a fitout quote',
        'button'     => $cta['button_label'] ?? 'Request a quote',
        'ground'     => 'white',
    ));
    ?>
</main>
<?php
get_footer();
