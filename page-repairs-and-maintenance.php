<?php
/**
 * Template Name: Repairs and Maintenance Page
 *
 * Repairs & Maintenance – shared service layout. Content: Website Content > Repairs & Maintenance.
 *
 * @package Central_Build_Pro
 */

if (!function_exists('central_build_get_rm_settings')) {
    require_once get_template_directory() . '/inc/repairs-maintenance-settings.php';
}

$s       = central_build_get_rm_settings();
$hero    = (array) $s['hero'];
$partner = (array) $s['partnership'];
$contact = (array) $s['contact'];

get_header();
?>
<main id="primary" class="site-main cb-page">
    <?php
    cb_ui_hero(array(
        'eyebrow' => $hero['subtitle'] ?? 'Repairs & Maintenance',
        'title'   => $hero['title'] ?? '',
        'text'    => $hero['description'] ?? '',
        'fact'    => 'Urgent repairs line, 24 hours a day, 7 days a week',
        'image'   => cb_ui_plain($hero['background'] ?? '') !== '' ? $hero['background'] : cb_ui_default_hero_image(),
        'size'    => 'home',
        'buttons' => array(
            array('label' => $hero['primary_cta']['label'] ?? 'Call for urgent repairs', 'url' => $hero['primary_cta']['url'] ?? 'tel:+61413058861'),
            array('label' => $hero['secondary_cta']['label'] ?? 'Book maintenance', 'url' => $hero['secondary_cta']['url'] ?? '#contact'),
        ),
    ));

    cb_ui_section_open('guarantee', 'white');
    cb_ui_head('Our guarantee', 'Fast response, lasting repairs', 'Licensed in-house trades fix the cause, not just the symptom.');
    cb_ui_cards(array_map(static function ($g) {
        return array('icon' => $g['icon'] ?? '', 'title' => $g['title'] ?? '', 'text' => trim(cb_ui_plain($g['tagline'] ?? '') . ' ' . cb_ui_plain($g['description'] ?? '')));
    }, (array) $s['guarantee']), 3);
    cb_ui_section_close();

    cb_ui_section_open('expertise', 'mist');
    cb_ui_split(array(
        'image'   => $hero['background'] ?? 'cb/cb-kitchen.jpg',
        'eyebrow' => 'What we fix',
        'title'   => 'Repairs for shops, restaurants and offices',
        'text'    => 'Our electricians, plumbers and builders keep commercial kitchens, shops and offices running, from emergency call-outs to scheduled maintenance.',
        'list'    => array_map(static function ($e) {
            return array('title' => $e['title'] ?? '', 'text' => $e['description'] ?? '');
        }, (array) $s['expertise']),
    ));
    cb_ui_section_close();

    cb_ui_section_open('how-it-works', 'white');
    cb_ui_head('How it works', 'From your call to a fixed fault', 'Four steps, with a report at the end of every job.');
    cb_ui_steps(array_map(static function ($m) {
        return array('title' => $m['title'] ?? '', 'text' => $m['description'] ?? '');
    }, (array) $s['model']));
    cb_ui_section_close();

    cb_ui_section_open('maintenance-contract', 'navy');
    cb_ui_head('Maintenance contracts', $partner['heading'] ?? 'Beyond the fix', $partner['description'] ?? '');
    cb_ui_cards(array_map(static function ($i) {
        return array('icon' => $i['icon'] ?? '', 'title' => $i['title'] ?? '', 'text' => $i['description'] ?? '');
    }, (array) ($partner['items'] ?? array())), 3);
    echo '<div style="margin-top:40px">';
    cb_ui_buttons(array(array('label' => $partner['cta_label'] ?? 'Ask about a maintenance contract', 'url' => $partner['cta_url'] ?? '#contact')));
    echo '</div>';
    cb_ui_section_close();

    cb_ui_contact(array(
        'form_id'    => 'repairs_maintenance',
        'eyebrow'    => 'Book a repair',
        'title'      => $contact['heading'] ?? 'Failures happen. Downtime is optional.',
        'text'       => $contact['description'] ?? '',
        'form_title' => $contact['form_title'] ?? 'Request a repair or maintenance quote',
        'button'     => $contact['button_label'] ?? 'Send request',
        'options'    => array('Emergency repair', 'Electrical', 'Plumbing', 'General building repair', 'Maintenance contract'),
        'ground'     => 'mist',
    ));
    ?>
</main>
<?php
get_footer();
