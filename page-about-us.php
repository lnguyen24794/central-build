<?php
/**
 * Template Name: About Us Page
 *
 * About – content: Website Content > About Us; "Why Central Build" from the Capability Statement 2026.
 *
 * @package Central_Build_Pro
 */

if (!function_exists('central_build_get_about_settings')) {
    require_once get_template_directory() . '/inc/about-settings.php';
}

$s     = central_build_get_about_settings();
$hero  = (array) $s['hero'];
$phil  = (array) $s['philosophy'];
$right = (array) ($s['right_column'] ?? array());

$why      = cb_ui_why_points();
$services = cb_ui_service_cards();

get_header();
?>
<main id="primary" class="site-main cb-page">
    <?php
    cb_ui_hero(array(
        'eyebrow' => 'About Central Build',
        'title'   => $hero['title'] ?? 'We are Central Build',
        'text'    => $hero['description'] ?? '',
        'fact'    => 'Registered commercial builder · Licence CCB-L 100410',
        'image'   => 'cb/cb-team.jpg',
    ));

    cb_ui_section_open('who-we-are', 'white');
    cb_ui_split(array(
        'image'   => $phil['image'] ?? '',
        'eyebrow' => 'Where trust builds',
        'title'   => $phil['heading'] ?? 'Who we are',
        'text'    => (array) ($phil['paragraphs'] ?? array()),
        'list'    => array(
            array('title' => $s['mission']['title'] ?? 'Our mission', 'text' => $s['mission']['text'] ?? ''),
            array('title' => $s['vision']['title'] ?? 'Our vision', 'text' => $s['vision']['text'] ?? ''),
        ),
    ));
    cb_ui_section_close();

    cb_ui_section_open('why', 'mist');
    cb_ui_head('Why Central Build', $right['heading'] ?? 'Fitout experts with proven results', $right['paragraph'] ?? '');
    cb_ui_cards($why, 3);
    cb_ui_section_close();

    cb_ui_section_open('services', 'white');
    cb_ui_head('Services', 'Five services, one team', 'Design, build, coordinate, strip out and maintain, all with the same people.');
    cb_ui_cards($services, 3);
    cb_ui_section_close();

    cb_ui_section_open('projects', 'mist');
    cb_ui_head('Our work', 'Recent projects', '');
    cb_ui_projects(array('count' => 3, 'category' => 'fitout-projects'));
    cb_ui_section_close();

    cb_ui_cta(array(
        'eyebrow' => 'Let\'s work together',
        'title'   => 'Tell us about your next space',
        'text'    => 'A short call is all it takes to get a realistic budget and program.',
        'buttons' => array(
            array('label' => $s['cta']['text'] ?? 'Contact us', 'url' => $s['cta']['url'] ?? home_url('/contact/')),
            array('label' => 'View projects', 'url' => home_url('/projects/')),
        ),
    ));
    ?>
</main>
<?php
get_footer();
