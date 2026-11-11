<?php
/**
 * Home page – what we do, for whom, proof, how we work, contact.
 * Content: Website Content > Home Page (hero, "Why Central Build" intro, FAQ, contact form).
 *
 * @package Central_Build_Pro
 */

$home    = central_build_get_home_content();
$hero    = (array) $home['hero'];
$intro   = (array) $home['intro'];
$faq     = (array) $home['faq'];
$contact = (array) $home['contact'];

$chez       = get_posts(array('post_type' => 'fitout_sector', 'post_status' => 'publish', 'title' => 'Chez Ami Restaurant', 'numberposts' => 1, 'fields' => 'ids'));
$chez_id    = $chez ? (int) $chez[0] : 0;
$chez_video = $chez_id ? array_slice((array) get_post_meta($chez_id, '_fitout_videos', true), 0, 2) : array();
$hero_image = $chez_id ? cb_ui_project_image($chez_id, 'full') : 'cb/cb-project-hero.jpg';
$about_img  = function_exists('central_build_get_about_settings') ? (string) (central_build_get_about_settings()['philosophy']['image'] ?? '') : '';
$steps      = function_exists('central_build_get_cds_settings') ? (array) (central_build_get_cds_settings()['process']['steps'] ?? array()) : array();

get_header();
?>
<main id="primary" class="site-main cb-page">
    <?php
    cb_ui_hero(array(
        'eyebrow' => 'Registered commercial builder · Victoria',
        'title'   => $hero['title'] ?? 'Commercial spaces built for you',
        'text'    => trim(cb_ui_plain($hero['tagline'] ?? '') . ' ' . cb_ui_plain($hero['description'] ?? '')),
        'fact'    => 'Chez Ami, Sale: office to 80-seat restaurant in 12 weeks',
        'image'   => $hero_image,
        'size'    => 'home',
        'buttons' => array(
            array('label' => $hero['button']['label'] ?? 'Start your project', 'url' => $hero['button']['url'] ?? '#contact'),
            array('label' => 'View our projects', 'url' => home_url('/projects/')),
        ),
    ));

    cb_ui_section_open('services', 'white');
    cb_ui_head('Services', 'Five services, one team', 'Design, build, coordinate, strip out and maintain, all with the same people and one point of contact.');
    cb_ui_cards(cb_ui_service_cards(), 3);
    cb_ui_section_close();

    cb_ui_section_open('projects', 'mist');
    echo '<div class="cb-head"><div><span class="cb-eyebrow">' . esc_html__('Our work', 'central-build') . '</span><h2>' . esc_html__('Recent projects', 'central-build') . '</h2></div>';
    echo '<p class="cb-lead">' . esc_html__('Restaurants, cafés, food court shops, a head spa and a rooming house, all delivered by Central Build.', 'central-build') . '</p></div>';
    cb_ui_projects(array('count' => 6, 'category' => 'fitout-projects'));
    echo '<div style="margin-top:40px">';
    cb_ui_buttons(array(array('label' => 'View all projects', 'url' => home_url('/projects/'), 'style' => 'outline')));
    echo '</div>';
    cb_ui_section_close();

    if ($chez_video) {
        cb_ui_section_open('see-it-first', 'navy');
        cb_ui_head('From 3D design to opening night', 'See your space before it is built', 'We walked the Chez Ami owners through their restaurant in 3D and VR. Twelve weeks later, it opened.');
        central_build_render_video_wall($chez_video);
        echo '<div style="margin-top:40px">';
        cb_ui_buttons(array(
            array('label' => 'Read the Chez Ami story', 'url' => get_permalink($chez_id)),
            array('label' => 'Our design service', 'url' => home_url('/commercial-design-and-solutions/'), 'style' => 'outline'),
        ));
        echo '</div>';
        cb_ui_section_close();
    }

    cb_ui_section_open('why', 'white');
    cb_ui_split(array(
        'image'   => $about_img,
        'eyebrow' => 'Why Central Build',
        'title'   => cb_ui_plain($intro['heading'] ?? '') !== '' && stripos((string) $intro['heading'], 'about us') === false ? $intro['heading'] : 'Where trust builds',
        'text'    => $intro['text'] ?? '',
        'list'    => array_map(static function ($w) {
            return array('title' => $w['title'], 'text' => $w['text']);
        }, array_slice(cb_ui_why_points(), 0, 4)),
        'buttons' => array(array('label' => 'About Central Build', 'url' => home_url('/about-us/'), 'style' => 'outline')),
    ));
    cb_ui_section_close();

    if ($steps) {
        cb_ui_section_open('process', 'mist');
        cb_ui_head('How we work', 'Five steps from budget to handover', 'The same approach on every project, from a café refresh to a full restaurant conversion.');
        cb_ui_steps(array_map(static function ($p) {
            return array('title' => $p['title'] ?? '', 'text' => $p['description'] ?? '');
        }, $steps));
        cb_ui_section_close();
    }

    if (!empty($faq['items'])) {
        cb_ui_section_open('faq', 'white');
        echo '<div class="cb-split" style="align-items:start"><div>';
        echo '<span class="cb-eyebrow">' . esc_html__('FAQ', 'central-build') . '</span><h2>' . esc_html(cb_ui_plain($faq['heading'] ?? 'Common questions')) . '</h2></div><div>';
        cb_ui_faq((array) $faq['items']);
        echo '</div></div>';
        cb_ui_section_close();
    }

    cb_ui_contact(array(
        'form_id'    => 'front_page',
        'eyebrow'    => 'Start your project',
        'title'      => $contact['heading'] ?? 'Tell us about your project',
        'text'       => $contact['description'] ?? '',
        'form_title' => $contact['form_title'] ?? 'Project kick-off form',
        'button'     => $contact['button_label'] ?? 'Request a consultation',
        'options'    => (array) ($contact['project_types'] ?? array()),
        'ground'     => 'mist',
    ));
    ?>
</main>
<?php
get_footer();
