<?php
/**
 * Website Content editor — list of pages and their sections, in the order
 * they appear on the website. Field types are worked out automatically from
 * the stored data (see editor.php); only friendly names / help live here.
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Friendly labels used for every field key unless a section overrides them.
 */
function cb_ce_label_dictionary(): array
{
    return array(
        'title'          => 'Heading',
        'heading'        => 'Heading',
        'subtitle'       => 'Sub-heading',
        'subheading'     => 'Sub-heading',
        'tagline'        => 'Short line under the heading',
        'badge'          => 'Small label above the heading',
        'tag'            => 'Small label',
        'description'    => 'Text',
        'text'           => 'Text',
        'content'        => 'Text',
        'intro'          => 'Intro text',
        'introduction'   => 'Intro text',
        'paragraph'      => 'Text',
        'paragraphs'     => 'Paragraphs',
        'body'           => 'Text',
        'label'          => 'Text',
        'url'            => 'Link',
        'cta'            => 'Button',
        'button'         => 'Button',
        'primary_cta'    => 'Main button',
        'secondary_cta'  => 'Second button',
        'button_label'   => 'Button text',
        'cta_label'      => 'Button text',
        'cta_url'        => 'Button link',
        'form_title'     => 'Form heading',
        'contact_line'   => 'Phone number shown',
        'contact'        => 'Phone number shown',
        'image'          => 'Image',
        'images'         => 'Images',
        'background'     => 'Background image',
        'icon'           => 'Icon',
        'icon_url'       => 'Icon image',
        'icon_alt'       => 'Icon description (for screen readers)',
        'logo'           => 'Logo',
        'logo_url'       => 'Logo',
        'number'         => 'Number',
        'suffix'         => 'Text after the number (e.g. % )',
        'name'           => 'Name',
        'role'           => 'Role',
        'position'       => 'Company / position',
        'question'       => 'Question',
        'answer'         => 'Answer',
        'email'          => 'Email address',
        'phone'          => 'Phone',
        'display'        => 'Phone number (as shown)',
        'link'           => 'Phone link (e.g. tel:+61400000000)',
        'items'          => 'Items',
        'cards'          => 'Cards',
        'hours'          => 'Opening hours',
        'value'          => 'Value',
        'step'           => 'Step number',
        'highlight'      => 'Highlighted line',
        'secondary'      => 'Extra line',
        'alt'            => 'Image description (for Google & screen readers)',
        'image_alt'      => 'Image description (for Google & screen readers)',
        'show'           => 'Show this part',
        'show_projects'  => 'Show the "Our projects" strip on this page',
        'redirect'       => 'Page to open after the form is sent',
        'address_title'  => 'Address heading',
        'address_lines'  => 'Address lines',
        'accordion'      => 'Expandable questions',
        'solutions'      => 'Solutions (one per line)',
        'challenge'      => 'Challenge',
        'result_heading' => 'Result heading',
        'result_text'    => 'Result text',
        'progress_label' => 'Progress bar text',
        'progress_value' => 'Progress bar (0–100)',
        'recipients'     => 'Send form emails to',
        'reply_to'       => 'Reply-to address',
        'service_options'=> 'Choices in the "service" drop-down',
        'project_types'  => 'Choices in the "project type" drop-down',
        'members'        => 'Team members',
        'social_links'   => 'Social media links',
        'quick_links'    => 'Quick links',
        'support_links'  => 'Support links',
        'company'        => 'Company details',
    );
}

/**
 * All editable pages.
 *
 * store.type = group   → one option holding an array (existing *-settings.php files)
 * store.type = options → home page: each section maps fields to individual options
 */
function cb_ce_pages(): array
{
    static $pages = null;
    if ($pages === null) {
        $pages = cb_ce_prune_for_new_layout(cb_ce_apply_menu_titles(cb_ce_pages_raw()));
    }
    return $pages;
}

/**
 * Nov 2026 redesign: hide editor sections the new page layouts no longer show,
 * so every box in Website Content changes something visible.
 */
function cb_ce_prune_for_new_layout(array $pages): array
{
    $keep = array(
        'home' => array('hero', 'intro', 'faq', 'contact'),
    );
    $drop = array(
        'cfs' => array('stats'),
        'about' => array('team'),
    );
    foreach ($keep as $page => $sections) {
        if (isset($pages[$page]['sections'])) {
            $pages[$page]['sections'] = array_intersect_key($pages[$page]['sections'], array_flip($sections));
        }
    }
    foreach ($drop as $page => $sections) {
        foreach ($sections as $section) {
            unset($pages[$page]['sections'][$section]);
        }
    }
    // The new layouts always show these parts, so their on/off switches would do nothing.
    foreach ($pages as $key => $page) {
        foreach ((array) ($page['sections'] ?? array()) as $sk => $section) {
            unset($pages[$key]['sections'][$sk]['visible']);
        }
    }
    if (isset($pages['home']['sections']['intro'])) {
        $pages['home']['sections']['intro']['label'] = '"Why Central Build" introduction';
        $pages['home']['sections']['intro']['help']  = 'Heading and text next to the photo in the "Why Central Build" section.';
    }
    return $pages;
}

/**
 * Show each page under the name visitors see in the top menu
 * (e.g. the Commercial Stripout page is "Steel Structure Installation" in the menu).
 */
function cb_ce_apply_menu_titles(array $pages): array
{
    if (!function_exists('cb_ce_menu_titles_by_path')) {
        return $pages;
    }
    $titles = cb_ce_menu_titles_by_path();
    foreach ($pages as $key => $page) {
        if (empty($page['template']) || $page['template'] === 'front') {
            continue;
        }
        $path = cb_ce_url_path(cb_ce_view_url($page));
        if ($path === '/') {
            continue;
        }
        $pages[$key]['summary'] = 'Page address: ' . $path;
        if (!empty($titles[$path])) {
            $pages[$key]['title'] = $titles[$path];
        }
    }
    return $pages;
}

function cb_ce_pages_raw(): array
{
    $home_vis = static function ($key) {
        return 'central_build_show_' . $key . '_section';
    };

    return array(
        /* ------------------------------------------------------------ HOME */
        'home' => array(
            'title'    => 'Home Page',
            'icon'     => 'dashicons-admin-home',
            'template' => 'front',
            'summary'  => 'The first page visitors see.',
            'store'    => array('type' => 'options'),
            'sections' => array(
                'hero' => array(
                    'label'   => 'Top banner',
                    'help'    => 'The big headline at the very top of the home page.',
                    'visible' => $home_vis('hero'),
                    'home'    => 'hero',
                ),
                'intro' => array(
                    'label' => 'About Us introduction',
                    'help'  => 'Short introduction with two cards, right under the top banner.',
                    'home'  => 'intro',
                ),
                'trust' => array(
                    'label'   => '"Trust in Central Build" process',
                    'help'    => 'Row of reasons to trust you, each with a small icon.',
                    'visible' => $home_vis('trust'),
                    'fields'  => array(
                        'title' => array('option' => 'central_build_trust_title', 'default' => 'Trust in<br>Central Build Process'),
                        'items' => array('option' => 'central_build_trust_features', 'getter' => 'central_build_get_trust_features', 'label' => 'Reasons',
                            'item' => array('icon' => '', 'title' => '', 'description' => '')),
                    ),
                    'types'   => array('icon' => 'image'),
                ),
                'projects' => array(
                    'label'   => '"Start your fitout journey" steps & numbers',
                    'help'    => 'Process steps, photos, a button and the counters (years of experience etc.).',
                    'visible' => $home_vis('projects'),
                    'fields'  => array(
                        'title'          => array('option' => 'central_build_projects_title', 'default' => 'Start Your Fitout Journey Today'),
                        'subtitle'       => array('option' => 'central_build_projects_subtitle', 'default' => "Don't Fit in with your Average Fitout."),
                        'steps'          => array('option' => 'central_build_process_steps', 'getter' => 'central_build_get_process_steps', 'label' => 'Process steps',
                            'item' => array('icon' => '', 'title' => '', 'description' => '')),
                        'photos'         => array('option' => 'central_build_project_images', 'getter' => 'central_build_get_project_images', 'label' => 'Photos',
                            'item' => array('image' => '', 'alt' => '')),
                        'button_text'    => array('option' => 'central_build_projects_button_text', 'default' => 'Start Today!', 'label' => 'Button text'),
                        'button_subtext' => array('option' => 'central_build_projects_button_subtext', 'default' => 'Learn more', 'label' => 'Button small text'),
                        'button_url'     => array('option' => 'central_build_projects_button_url', 'default' => home_url('/contact'), 'label' => 'Button link'),
                        'stats'          => array('option' => 'central_build_stats', 'getter' => 'central_build_get_stats', 'label' => 'Counters',
                            'item' => array('number' => '', 'label' => '')),
                    ),
                    'types'   => array('icon' => 'image', 'number' => 'text'),
                    'labels'  => array('label' => 'Text under the number', 'number' => 'Number (e.g. 24+)'),
                ),
                'aware' => array(
                    'label'   => '"Built on expertise" with photo',
                    'help'    => 'Photo on one side, heading, text and short highlights on the other.',
                    'visible' => $home_vis('about'),
                    'fields'  => array(
                        'title'       => array('option' => 'central_build_about_title', 'default' => 'Built on Expertise and Purpose'),
                        'description' => array('option' => 'central_build_about_description', 'default' => ''),
                        'image'       => array('option' => 'central_build_about_image', 'default' => '', 'type' => 'image', 'label' => 'Photo'),
                        'features'    => array('option' => 'central_build_about_features', 'getter' => 'central_build_get_about_features', 'label' => 'Highlights',
                            'item' => array('title' => '', 'description' => '')),
                    ),
                ),
                'partners' => array(
                    'label'   => 'Partner / client logos',
                    'help'    => 'A scrolling strip of logos. Turn it on once you have added logos.',
                    'visible' => $home_vis('partners'),
                    'fields'  => array(
                        'partners' => array('option' => 'central_build_partners', 'getter' => 'central_build_get_partners', 'label' => 'Logos',
                            'item' => array('logo' => '', 'name' => '', 'url' => '')),
                    ),
                    'types'   => array('logo' => 'image'),
                    'labels'  => array('name' => 'Company name', 'url' => 'Website link (optional)'),
                ),
                'testimonials' => array(
                    'label'   => 'Client testimonials',
                    'help'    => 'What your clients say about you.',
                    'visible' => $home_vis('testimonials'),
                    'fields'  => array(
                        'tag'            => array('option' => 'central_build_testimonials_tag', 'default' => 'Testimonial'),
                        'title'          => array('option' => 'central_build_testimonials_title', 'default' => "Words from Those Who've Trusted Us"),
                        'description'    => array('option' => 'central_build_testimonials_description', 'default' => ''),
                        'quotes'         => array('option' => 'central_build_testimonials', 'getter' => 'central_build_get_testimonials', 'label' => 'Testimonials',
                            'item' => array('content' => '', 'name' => '', 'position' => '', 'image' => '')),
                        'image'          => array('option' => 'central_build_testimonials_image', 'default' => '', 'type' => 'image', 'label' => 'Side photo'),
                        'button_text'    => array('option' => 'central_build_testimonials_button_text', 'default' => 'Testimonials', 'label' => 'Button text'),
                        'button_subtext' => array('option' => 'central_build_testimonials_button_subtext', 'default' => 'Learn more', 'label' => 'Button small text'),
                        'button_url'     => array('option' => 'central_build_testimonials_button_url', 'default' => home_url('/testimonials'), 'label' => 'Button link'),
                    ),
                    'labels'  => array('content' => 'What they said', 'image' => 'Photo'),
                ),
                'commercial' => array(
                    'label'   => '"Check out our latest work"',
                    'help'    => 'The project cards themselves come from <strong>Projects</strong> in the left menu — add or edit a project there.',
                    'visible' => $home_vis('commercial'),
                    'fields'  => array(
                        'tag'   => array('option' => 'central_build_commercial_tag', 'default' => 'Service'),
                        'title' => array('option' => 'central_build_commercial_title', 'default' => 'Check out <br>our latest work'),
                    ),
                    'link'    => array('label' => 'Manage projects', 'url' => 'edit.php?post_type=fitout_sector'),
                ),
                'sectors' => array(
                    'label'  => 'Commercial fitout sectors',
                    'help'   => 'The list of sectors (Office, Retail, Medical…) with a photo for each.',
                    'fields' => array(
                        'title'          => array('option' => 'central_build_checkout_title', 'default' => 'Commercial Fitout Sectors'),
                        'sectors'        => array('option' => 'central_build_sectors', 'getter' => 'central_build_get_sectors', 'label' => 'Sectors',
                            'item' => array('icon' => '', 'tag' => '', 'title' => '', 'description' => '', 'image' => '', 'url' => '')),
                        'button_text'    => array('option' => 'central_build_checkout_button_text', 'default' => 'Check out our Portfolio', 'label' => 'Button text'),
                        'button_subtext' => array('option' => 'central_build_checkout_button_subtext', 'default' => 'Learn more', 'label' => 'Button small text'),
                        'button_url'     => array('option' => 'central_build_checkout_button_url', 'default' => home_url('/contact'), 'label' => 'Button link'),
                    ),
                    'types'  => array('icon' => 'image'),
                ),
                'cta' => array(
                    'label'  => '"Fitouts shouldn\'t be this hard" banner',
                    'help'   => 'Wide banner with a background photo and a button.',
                    'fields' => array(
                        'title'          => array('option' => 'central_build_cta_title', 'default' => "Fitouts Shouldn't Be This Hard"),
                        'description'    => array('option' => 'central_build_cta_description', 'default' => '', 'type' => 'textarea'),
                        'button_text'    => array('option' => 'central_build_cta_button_text', 'default' => 'Start Today!', 'label' => 'Button text'),
                        'button_subtext' => array('option' => 'central_build_cta_button_subtext', 'default' => 'Learn more', 'label' => 'Button small text'),
                        'button_url'     => array('option' => 'central_build_cta_button_url', 'default' => home_url('/contact'), 'label' => 'Button link'),
                        'image'          => array('option' => 'central_build_cta_background_image', 'default' => '', 'type' => 'image', 'label' => 'Background photo'),
                    ),
                ),
                'faq' => array(
                    'label' => 'Frequently asked questions',
                    'help'   => 'Questions that open when clicked.',
                    'home'   => 'faq',
                    'labels' => array('items' => 'Questions'),
                ),
                'contact' => array(
                    'label' => 'Contact form at the bottom',
                    'help'  => 'Messages sent from this form arrive by email — see <strong>Form emails</strong>.',
                    'home'  => 'contact',
                ),
            ),
        ),

        /* ------------------------------------------------------------ ABOUT */
        'about' => array(
            'title'    => 'About Us',
            'icon'     => 'dashicons-groups',
            'template' => 'page-about-us.php',
            'summary'  => 'Your story, mission, vision and team.',
            'store'    => array('type' => 'group', 'option' => 'central_build_about_settings', 'get' => 'central_build_get_about_settings', 'sanitize' => 'central_build_sanitize_about_settings'),
            'sections' => array(
                'hero'         => array('label' => 'Top banner'),
                'mission'      => array('label' => 'Our mission'),
                'vision'       => array('label' => 'Our vision'),
                'philosophy'   => array('label' => '"Who we are" with photo'),
                'right_column' => array('label' => '"Fitout experts" text'),
                'services'     => array('label' => 'List of services', 'labels' => array('title' => 'Service name')),
                'cta'          => array('label' => 'Contact button', 'labels' => array('text' => 'Button text', 'url' => 'Button link')),
                'team'         => array('label' => 'Team members', 'labels' => array('show' => 'Show the team on the page'), 'types' => array('image' => 'image'),
                    'items' => array('members' => array('name' => '', 'role' => '', 'image' => ''))),
                'licence'      => array('label' => 'Builder licence and insurances', 'help' => 'Shown on the About page and as a short row on the home page. Keep it in line with the current certificates of currency.',
                    'labels' => array('abn' => 'ABN line (leave empty to hide)', 'items' => 'Licence and insurance cards', 'icon' => 'Icon')),
            ),
        ),

        /* ------------------------------------------------------------ SERVICES */
        'cds' => array(
            'title'    => 'Commercial Design and Solutions',
            'icon'     => 'dashicons-admin-customizer',
            'template' => 'page-commercial-design-solutions.php',
            'summary'  => 'Service page.',
            'store'    => array('type' => 'group', 'option' => 'central_build_cds_settings', 'get' => 'central_build_get_cds_settings', 'sanitize' => 'central_build_sanitize_cds_settings'),
            'sections' => array(
                'hero'         => array('label' => 'Top banner', 'labels' => array('background' => 'Background photo')),
                'intro'        => array('label' => 'Introduction with photo', 'labels' => array('image' => 'Photo')),
                'capabilities' => array('label' => 'What we deliver (cards)', 'labels' => array('items' => 'Cards')),
                'bim'          => array('label' => 'BIM section', 'labels' => array('points' => 'Tick list (one per line)', 'image' => 'Photo')),
                'videos'       => array('label' => 'Videos', 'help' => 'For each video paste a YouTube link, or the address of an MP4 file from the Media Library (Media > Library > the video > Copy URL). Wide and phone (portrait) videos can be mixed.',
                    'labels' => array('items' => 'Videos', 'url' => 'YouTube link or MP4 address', 'title' => 'Name (for screen readers)', 'poster_image' => 'Cover photo (MP4 only, optional)')),
                'process'      => array('label' => 'Our design process (steps)', 'labels' => array('steps' => 'Steps')),
                'contact'      => array('label' => 'Contact & form at the bottom'),
            ),
        ),
        'cfs' => array(
            'title'    => 'Commercial Fitouts',
            'icon'     => 'dashicons-building',
            'template' => 'page-commercial-fitout-specialists.php',
            'summary'  => 'Service page.',
            'store'    => array('type' => 'group', 'option' => 'central_build_cfs_settings', 'get' => 'central_build_get_cfs_settings', 'sanitize' => 'central_build_sanitize_cfs_settings'),
            'sections' => array(
                'hero'       => array('label' => 'Top banner'),
                'stats'      => array('label' => 'Numbers (counters)'),
                'pillars'    => array('label' => 'Three pillars', 'labels' => array('title' => 'Small label', 'heading' => 'Heading')),
                'inhouse'    => array('label' => 'In-house teams'),
                'case_study' => array('label' => 'Case study'),
                'journey'    => array('label' => 'Your journey (steps)'),
                'final_cta'  => array('label' => 'Contact & form at the bottom'),
            ),
        ),
        'sc' => array(
            'title'    => 'Services Coordination',
            'icon'     => 'dashicons-networking',
            'template' => 'page-services-coordination.php',
            'summary'  => 'Service page.',
            'store'    => array('type' => 'group', 'option' => 'central_build_sc_settings', 'get' => 'central_build_get_sc_settings', 'sanitize' => 'central_build_sanitize_sc_settings'),
            'sections' => array(
                'hero'          => array('label' => 'Top banner'),
                'problems'      => array('label' => 'Problems we solve'),
                'methodology'   => array('label' => 'Our method (steps)'),
                'bim'           => array('label' => 'The power of BIM', 'labels' => array('image' => 'Photo', 'second_image' => 'Second photo (shown under the first, optional)')),
                'metrics'       => array('label' => 'Results (numbers)'),
                'contact'       => array('label' => 'Contact & form at the bottom'),
                'show_projects' => array('label' => 'Projects strip'),
            ),
        ),
        'cs' => array(
            'title'    => 'Commercial Stripout',
            'icon'     => 'dashicons-hammer',
            'template' => 'page-commercial-stripout.php',
            'summary'  => 'Service page.',
            'store'    => array('type' => 'group', 'option' => 'central_build_cs_settings', 'get' => 'central_build_get_cs_settings', 'sanitize' => 'central_build_sanitize_cs_settings'),
            'sections' => array(
                'hero'          => array('label' => 'Top banner'),
                'promise'       => array('label' => 'Our promise'),
                'safety'        => array('label' => 'Safety'),
                'technical'     => array('label' => 'The stripout edge'),
                'scale'         => array('label' => 'Any scale (with photos)'),
                'contact'       => array('label' => 'Contact & form at the bottom'),
                'show_projects' => array('label' => 'Projects strip'),
            ),
        ),
        'rm' => array(
            'title'    => 'Repairs & Maintenance',
            'icon'     => 'dashicons-admin-tools',
            'template' => 'page-repairs-and-maintenance.php',
            'summary'  => 'Service page.',
            'store'    => array('type' => 'group', 'option' => 'central_build_rm_settings', 'get' => 'central_build_get_rm_settings', 'sanitize' => 'central_build_sanitize_rm_settings'),
            'sections' => array(
                'hero'          => array('label' => 'Top banner'),
                'guarantee'     => array('label' => 'Our guarantee'),
                'expertise'     => array('label' => 'What we fix'),
                'model'         => array('label' => 'How it works (steps)'),
                'partnership'   => array('label' => 'Maintenance contract'),
                'contact'       => array('label' => 'Contact & form at the bottom'),
                'show_projects' => array('label' => 'Projects strip'),
            ),
        ),

        /* ------------------------------------------------------------ CONTACT */
        'contact' => array(
            'title'    => 'Contact',
            'icon'     => 'dashicons-email',
            'template' => 'page-contact.php',
            'summary'  => 'Contact details, office hours and the enquiry form.',
            'store'    => array('type' => 'group', 'option' => 'central_build_contact_settings', 'get' => 'central_build_get_contact_settings', 'sanitize' => 'central_build_sanitize_contact_settings'),
            'sections' => array(
                'hero'         => array('label' => 'Top banner'),
                'contact_info' => array('label' => 'Email & phone'),
                'channels'     => array('label' => 'Ways to contact us (3 boxes)',
                    'choices' => array(
                        'style' => array('accent' => 'Gold', 'emergency' => 'Red (urgent)', 'primary' => 'Orange'),
                        'type'  => array('anchor' => 'Jump to the form', 'tel' => 'Phone call', 'mail' => 'Send an email', 'link' => 'Open a link'),
                    ),
                    'labels'  => array('style' => 'Colour', 'type' => 'What the button does')),
                'form'         => array('label' => 'Enquiry form'),
                'checklist'    => array('label' => '"Ready to connect?" checklist'),
                'office'       => array('label' => 'Office hours & address', 'labels' => array('label' => 'Days', 'value' => 'Hours')),
            ),
        ),

        /* ------------------------------------------------------------ SITE-WIDE */
        'header' => array(
            'title'    => 'Header (top of every page)',
            'icon'     => 'dashicons-align-wide',
            'group'    => 'site',
            'summary'  => 'Phone, email, social links and the "Get a quote" button.',
            'store'    => array('type' => 'group', 'option' => 'central_build_header_settings', 'get' => 'central_build_get_header_settings', 'sanitize' => 'central_build_sanitize_header_settings'),
            'sections' => array(
                'phone'        => array('label' => 'Phone number'),
                'email'        => array('label' => 'Email address'),
                'social_links' => array('label' => 'Social media links', 'labels' => array('label' => 'Network name', 'url' => 'Link to your page')),
                'cta'          => array('label' => '"Get a quote" button', 'labels' => array('text' => 'Button text', 'url' => 'Button link')),
            ),
        ),
        'footer' => array(
            'title'    => 'Footer (bottom of every page)',
            'icon'     => 'dashicons-align-full-width',
            'group'    => 'site',
            'summary'  => 'Logo, short description, contact details and links.',
            'store'    => array('type' => 'group', 'option' => 'central_build_footer_settings', 'get' => 'central_build_get_footer_settings', 'sanitize' => 'central_build_sanitize_footer_settings'),
            'sections' => array(
                'company'       => array('label' => 'Company details', 'labels' => array('licence' => 'Builder licence line', 'description' => 'Short description', 'phone' => 'Company phone', 'mobile' => 'Mobile (second line, leave empty to hide)')),
                'quick_links'   => array('label' => 'Quick links', 'labels' => array('label' => 'Link text', 'url' => 'Link')),
                'support_links' => array('label' => 'Support links', 'labels' => array('label' => 'Link text', 'url' => 'Link')),
                'copyright'     => array('label' => 'Copyright line (very bottom)', 'help' => 'Write {year} where the current year should appear; it updates by itself every January. Leave empty to hide the line.'),
                'social_links'  => array('label' => 'Social media ("Follow us")', 'help' => 'Round icons under the email address. The icon is picked from the link (Facebook, YouTube, LinkedIn, Instagram, TikTok). Remove a row to hide that icon.', 'labels' => array('items' => 'Social links', 'label' => 'Name (e.g. Facebook)', 'url' => 'Page address')),
            ),
        ),
        'menu' => array(
            'title'    => 'Top menu (every page)',
            'icon'     => 'dashicons-menu',
            'group'    => 'site',
            'summary'  => 'The links in the menu at the top of the website, including the Services drop-down.',
            'store'    => array('type' => 'custom', 'get' => 'cb_ce_menu_get', 'save' => 'cb_ce_menu_save', 'snapshot' => 'cb_ce_menu_snapshot', 'restore' => 'cb_ce_menu_restore'),
            'sections' => array(
                'items' => array(
                    'label'   => 'Menu links',
                    'help'    => 'The links in the order they appear. "Show under" puts a link inside a drop-down, for example under Services.',
                    'labels'  => array('title' => 'Menu text', 'url' => 'Link', 'parent' => 'Show under'),
                    'types'   => array('id' => 'hidden', 'url' => 'url'),
                    'choices' => array('parent' => 'cb_ce_menu_parent_choices'),
                    'items'   => array('items' => array('id' => 0, 'title' => '', 'url' => '', 'parent' => 0)),
                ),
            ),
        ),
        'forms' => array(
            'title'    => 'Form emails',
            'icon'     => 'dashicons-email-alt',
            'group'    => 'site',
            'summary'  => 'Who receives the messages sent from each form on the website.',
            'store'    => array('type' => 'group', 'option' => 'central_build_form_notifications', 'get' => 'central_build_get_form_notifications', 'sanitize' => 'central_build_sanitize_form_notifications'),
            'sections' => array(
                'sender'                        => array('label' => 'Sender and main inbox (all forms)', 'help' => 'Every email from the website is sent with this sender name. Form messages go to the main inbox unless a form below has its own addresses.',
                    'labels' => array('name' => 'Sender name', 'recipient' => 'Main inbox for form messages'), 'types' => array('recipient' => 'text')),
                'front_page'                    => array('label' => 'Home page form'),
                'contact_page'                  => array('label' => 'Contact page form'),
                'commercial_fitout_specialists' => array('label' => 'Commercial Fitouts form'),
                'commercial_stripout'           => array('label' => 'Commercial Stripout form'),
                'repairs_maintenance'           => array('label' => 'Repairs & Maintenance form'),
                'services_coordination'         => array('label' => 'Services Coordination form'),
                'design_solutions'              => array('label' => 'Commercial Design and Solutions form'),
            ),
            'section_defaults' => array('help' => 'Add one email address per line. Leave empty to send to the main inbox (first part of this page).',
                'types' => array('recipients' => 'emails')),
        ),
    );
}
