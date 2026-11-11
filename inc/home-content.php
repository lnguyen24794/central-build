<?php
/**
 * Home page content that used to be hard-coded in templates
 * (hero banner, "About Us" intro, FAQ list, bottom contact block).
 *
 * Stored in one option: central_build_home_content.
 * Edited from: Website Content → Home Page.
 */

if (!defined('ABSPATH')) {
    exit;
}

function central_build_home_content_defaults(): array
{
    return array(
        'hero' => array(
            'title'       => 'Simple, Smart <br> <span style="color: var(--accent-color);">Commercial Spaces Built for You</span>',
            'tagline'     => 'CENTRAL BUILD makes fitouts straightforward, with no surprises along the way.',
            'description' => 'We bring our experience and passion into every project, tailoring spaces built with safety, quality, and within budget.',
            'button'      => array('label' => 'START YOUR PROJECT CONSULTATION', 'url' => '#contact'),
        ),
        'intro' => array(
            'heading' => 'About Us',
            'text'    => 'Central Build is a specialized commercial contractor, formed by dedicated team of professionals, bringing together passion and expertise to deliver outstanding results in commercial interior fit-outs.',
            'cards'   => array(
                array(
                    'icon'        => 'bi bi-gear-fill',
                    'title'       => 'Precision & Excellence',
                    'description' => 'With a meticulous approach, we prioritize precision, efficiency, and excellence, ensuring each project is executed to the highest standards of design, safety, and quality control.',
                ),
                array(
                    'icon'        => 'bi bi-shield-check',
                    'title'       => 'Commitment & Trust',
                    'description' => 'Our commitment to fulfilling promises and nurturing trust forms the cornerstone of our philosophy, creating lasting value and successful completion of each project.',
                ),
            ),
        ),
        'faq' => array(
            'heading' => 'Common Questions About Our Integrated Approach',
            'items'   => array(
                array(
                    'question' => 'What does "Vertically Integrated" mean for my project?',
                    'answer'   => 'It means Central Build employs most core trades (plumbers, electricians, builders) directly, instead of relying on external sub-contractors. This gives us total control over quality, scheduling, and accountability, drastically reducing delays and communication errors.',
                ),
                array(
                    'question' => 'How does your integrated model impact overall project cost?',
                    'answer'   => 'While our upfront quote is competitive, the integrated model often results in lower total costs due to reduced project management fees, fewer variations caused by site conflicts, and shorter completion timelines. Efficiency equals savings.',
                ),
                array(
                    'question' => 'Do you handle ongoing Repairs & Maintenance after handover?',
                    'answer'   => 'Yes. We provide comprehensive, 24/7 commercial Repairs and Maintenance as a trusted "Readiness Partner," ensuring your operations continue smoothly long after the fit-out is complete.',
                ),
            ),
        ),
        'contact' => array(
            'heading'       => 'READY TO EXPERIENCE THE <span style="color: var(--accent-color);">INTEGRATED ADVANTAGE?</span>',
            'description'   => 'Stop settling for fragmented service. Partner with Central Build for guaranteed control and transparent results on your next commercial project.',
            'form_title'    => 'Project Kick-off Form (Fast Response)',
            'button_label'  => 'REQUEST A CONSULTATION',
            'project_types' => array('Commercial Fitout', 'Commercial Stripout', 'Services Coordination', 'Maintenance Contract'),
        ),
    );
}

function central_build_get_home_content(): array
{
    $defaults = central_build_home_content_defaults();
    $saved    = get_option('central_build_home_content', array());
    $saved    = is_array($saved) ? $saved : array();

    $content = array();
    foreach ($defaults as $key => $section) {
        $content[$key] = wp_parse_args(is_array($saved[$key] ?? null) ? $saved[$key] : array(), $section);
    }
    $content['hero']['button'] = wp_parse_args((array) $content['hero']['button'], $defaults['hero']['button']);

    return $content;
}

/**
 * Sanitize the whole home content array (keeps safe inline HTML such as <br> and <span>).
 */
function central_build_sanitize_home_content(array $input): array
{
    $clean = static function ($value) use (&$clean) {
        if (is_array($value)) {
            $out = array();
            foreach ($value as $k => $v) {
                $out[is_int($k) ? $k : sanitize_key($k)] = $clean($v);
            }
            return $out;
        }
        return wp_kses_post(wp_unslash((string) $value));
    };

    $data = $clean($input);

    // Drop empty repeater rows.
    foreach (array(array('intro', 'cards', 'title'), array('faq', 'items', 'question')) as $rule) {
        list($section, $list, $required) = $rule;
        if (isset($data[$section][$list]) && is_array($data[$section][$list])) {
            $data[$section][$list] = array_values(array_filter($data[$section][$list], static function ($row) use ($required) {
                return is_array($row) && trim(wp_strip_all_tags($row[$required] ?? '')) !== '';
            }));
        }
    }
    if (isset($data['contact']['project_types'])) {
        $data['contact']['project_types'] = array_values(array_filter(array_map('trim', (array) $data['contact']['project_types'])));
    }
    if (isset($data['hero']['button']['url'])) {
        $data['hero']['button']['url'] = esc_url_raw($data['hero']['button']['url']) ?: '#contact';
    }

    return $data;
}
