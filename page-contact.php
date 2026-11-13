<?php
/**
 * Template Name: Contact Page
 *
 * Contact – content: Website Content > Contact.
 *
 * @package Central_Build_Pro
 */

if (!function_exists('central_build_get_contact_settings')) {
    require_once get_template_directory() . '/inc/contact-settings.php';
}

$s      = central_build_get_contact_settings();
$hero   = (array) $s['hero'];
$form   = (array) ($s['form'] ?? array());
$check  = (array) ($s['checklist'] ?? array());
$office = (array) ($s['office'] ?? array());

$channels = array();
foreach ((array) $s['channels'] as $ch) {
    $text = trim(cb_ui_plain($ch['description'] ?? '') . ' ' . cb_ui_plain($ch['highlight'] ?? ''));
    $url  = (string) ($ch['cta']['url'] ?? '');
    if ($url === '#form') {
        $url = '#contact';
    }
    $channels[] = array('icon' => $ch['icon'] ?? '', 'title' => $ch['title'] ?? '', 'text' => $text, 'url' => $url, 'link_label' => cb_ui_plain($ch['cta']['label'] ?? 'Contact us'));
}

ob_start();
if (!empty($check['items'])) {
    echo '<div><h3 style="margin-bottom:12px">' . esc_html(cb_ui_plain($check['title'] ?? 'Before you send')) . '</h3>';
    cb_ui_list((array) $check['items']);
    echo '</div>';
}
$aside = ob_get_clean();

get_header();
?>
<main id="primary" class="site-main cb-page">
    <?php
    cb_ui_hero(array(
        'eyebrow' => 'Contact',
        'title'   => $hero['title'] ?? 'Let\'s work together',
        'text'    => $hero['description'] ?? '',
        'image'   => cb_ui_default_hero_image(),
    ));

    cb_ui_section_open('channels', 'white');
    cb_ui_head('How to reach us', 'Choose the fastest way', 'New projects, urgent repairs or general questions: each has its own line.');
    cb_ui_cards($channels, 3);
    cb_ui_section_close();

    cb_ui_contact(array(
        'id'          => 'contact',
        'form_id'     => 'contact_page',
        'eyebrow'     => 'Project enquiry',
        'title'       => $form['title'] ?? 'We\'re here to help',
        'text'        => $form['description'] ?? '',
        'form_title'  => 'Tell us about your project',
        'button'      => 'Send enquiry',
        'aside_extra' => $aside,
        'ground'      => 'mist',
    ));

    cb_ui_section_open('visit', 'white');
    echo '<div class="cb-grid is-2">';
    echo '<div class="cb-card"><span class="cb-card__icon">' . cb_ui_icon('fas fa-map-marker-alt') . '</span><h3>' . esc_html(cb_ui_plain($office['address_title'] ?? 'Office & Factory')) . '</h3>';
    foreach ((array) ($office['address_lines'] ?? array()) as $line) {
        echo '<p>' . esc_html(cb_ui_plain($line)) . '</p>';
    }
    if (!empty($office['cta_url'])) {
        echo '<a class="cb-link" href="' . esc_url($office['cta_url']) . '" target="_blank" rel="noopener">' . esc_html__('Get directions to the factory', 'central-build') . '</a>';
    }
    echo '</div>';
    echo '<div class="cb-card"><span class="cb-card__icon">' . cb_ui_icon('fas fa-clock') . '</span><h3>' . esc_html(cb_ui_plain($office['title'] ?? 'Office hours')) . '</h3>';
    foreach ((array) ($office['hours'] ?? array()) as $h) {
        echo '<p><strong style="color:var(--cb-ink)">' . esc_html(cb_ui_plain($h['label'] ?? '')) . '</strong> ' . esc_html(cb_ui_plain($h['value'] ?? '')) . '</p>';
    }
    if (!empty($office['description'])) {
        echo '<p>' . esc_html(ucfirst(strtolower(cb_ui_plain($office['description'])))) . '</p>';
    }
    echo '</div></div>';
    cb_ui_section_close();
    ?>
</main>
<?php
get_footer();
