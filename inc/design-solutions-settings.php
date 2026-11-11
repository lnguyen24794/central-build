<?php
/**
 * Commercial Design and Solutions page: content defaults, getter and sanitizer.
 * Stored in option central_build_cds_settings; edited in Website Content.
 */

if (!defined('ABSPATH')) {
    exit;
}

function central_build_cds_settings_defaults(): array
{
    return array(
        'hero' => array(
            'badge'       => 'Commercial Design and Solutions',
            'title'       => 'DESIGNED TO BUILD. <span style="color: var(--accent-color);">BUILT TO LAST.</span>',
            'description' => 'From the first sketch to the final permit, Central Build brings design, documentation and BIM coordination together with construction, so what is drawn is what gets built.',
            'cta'         => array('label' => 'Talk to Our Design Team', 'url' => '#contact'),
            'background'  => '',
        ),
        'intro' => array(
            'heading' => 'Design and construction under one roof',
            'text'    => 'Central Build is a registered commercial builder working alongside partnered architects and an overseas BIM team. Bringing design and delivery together means fewer surprises on site: budgets are tested early, trades are coordinated before work starts, and the space you approve is the space you receive.',
            'image'   => '',
        ),
        'capabilities' => array(
            'heading' => 'What We Deliver',
            'items'   => array(
                array('icon' => 'fas fa-drafting-compass', 'title' => 'Concept & Space Planning', 'description' => 'Layouts that work for your customers, staff and equipment, tested against your budget from day one.'),
                array('icon' => 'fas fa-cube', 'title' => '3D Visualisation & Walkthroughs', 'description' => 'See and walk through your space before construction starts, so decisions are made with confidence.'),
                array('icon' => 'fas fa-file-signature', 'title' => 'Documentation & Permits', 'description' => 'Complete drawings and documentation for building permits, through to the occupancy permit.'),
                array('icon' => 'fas fa-sitemap', 'title' => 'Engineering Coordination', 'description' => 'Architecture, structural and engineering design coordinated into one set of documents.'),
                array('icon' => 'fas fa-laptop-code', 'title' => 'BIM Modelling', 'description' => 'Every trade modelled together, so clashes are solved on screen instead of on site.'),
                array('icon' => 'fas fa-chart-line', 'title' => 'Feasibility & Cost Planning', 'description' => 'Early engagement to set a realistic budget and cash flow before you commit.'),
            ),
        ),
        'bim' => array(
            'heading'     => 'BIM: Solve It on Screen, Not on Site',
            'subtitle'    => 'Coordinated models for every trade.',
            'description' => 'Our BIM team models architecture, structure and services together. Clashes between gas, fire, electrical, mechanical and hydraulic systems are found and fixed in the model, before anyone is on site.',
            'image'       => '',
            'points'      => array(
                '3D models shared with you and your consultants',
                'Clash detection across all building services',
                'Accurate quantities for cost planning',
                'Clear, coordinated drawings for every trade',
            ),
        ),
        'videos' => array(
            'heading' => 'See Our Work',
            'text'    => 'Walkthroughs and project videos from Central Build.',
            'items'   => array(
                array('title' => 'Chez Ami Restaurant: 3D design walkthrough', 'url' => 'https://www.youtube.com/watch?v=JM2BOY4dB_0&t=67s'),
            ),
        ),
        'process' => array(
            'heading' => 'Our Design Process',
            'steps'   => array(
                array('icon' => 'fas fa-search-dollar', 'title' => '1. Feasibility & Cost Planning', 'description' => 'Early-stage engagement to establish a realistic budget and cash flow.'),
                array('icon' => 'fas fa-drafting-compass', 'title' => '2. Design & Documentation', 'description' => 'Coordination of architectural, structural and engineering design and documentation.'),
                array('icon' => 'fas fa-hard-hat', 'title' => '3. Construction Delivery', 'description' => 'Fast-tracked scheduling with a focus on minimising disruption to your operations.'),
                array('icon' => 'fas fa-tools', 'title' => '4. Fit-Out & Equipment', 'description' => 'Installation of commercial fittings, equipment, services and finishes.'),
                array('icon' => 'fas fa-key', 'title' => '5. Handover & Support', 'description' => 'Commissioning, testing, certificates of compliance and long-term maintenance advice.'),
            ),
        ),
        'contact' => array(
            'heading'      => 'Have a space in mind? Let\'s design it together.',
            'description'  => 'Tell us about your site and your goals. We will come back with ideas, a realistic budget and a clear plan.',
            'contact_line' => '1300 31 8888',
            'form_title'   => 'Book a Design Consultation',
            'button_label' => 'Request Consultation',
        ),
    );
}

function central_build_get_cds_settings(): array
{
    $defaults = central_build_cds_settings_defaults();
    $saved    = get_option('central_build_cds_settings', array());
    $saved    = is_array($saved) ? $saved : array();
    $settings = array();
    foreach ($defaults as $key => $section) {
        $settings[$key] = wp_parse_args(is_array($saved[$key] ?? null) ? $saved[$key] : array(), $section);
    }
    $settings['hero']['cta'] = wp_parse_args((array) $settings['hero']['cta'], $defaults['hero']['cta']);
    return $settings;
}

/** Keeps safe inline HTML (<br>, <span>); links and images are cleaned as addresses. */
function central_build_sanitize_cds_settings(array $input): array
{
    $clean = static function ($value, $key = '') use (&$clean) {
        if (is_array($value)) {
            $out = array();
            foreach ($value as $k => $v) {
                $out[is_int($k) ? $k : sanitize_key($k)] = $clean($v, is_int($k) ? $key : $k);
            }
            return $out;
        }
        if (is_bool($value)) {
            return $value;
        }
        $value = wp_unslash((string) $value);
        if (in_array($key, array('url', 'image', 'background'), true)) {
            return $value === '' ? '' : esc_url_raw($value);
        }
        return wp_kses_post($value);
    };
    $data = $clean($input);

    $rules = array(
        array('capabilities', 'items', 'title'),
        array('process', 'steps', 'title'),
        array('videos', 'items', 'url'),
    );
    foreach ($rules as $rule) {
        list($section, $list, $required) = $rule;
        if (isset($data[$section][$list]) && is_array($data[$section][$list])) {
            $data[$section][$list] = array_values(array_filter($data[$section][$list], static function ($row) use ($required) {
                return is_array($row) && trim(wp_strip_all_tags((string) ($row[$required] ?? ''))) !== '';
            }));
        }
    }
    if (isset($data['bim']['points'])) {
        $data['bim']['points'] = array_values(array_filter(array_map('trim', (array) $data['bim']['points'])));
    }
    return $data;
}

/** YouTube link -> embed address (keeps a start time such as &t=67s). */
function central_build_youtube_embed(string $url): string
{
    if (!preg_match('~(?:youtube\.com/(?:watch\?(?:.*&)?v=|embed/|shorts/)|youtu\.be/)([A-Za-z0-9_-]{11})~', $url, $m)) {
        return '';
    }
    $embed = 'https://www.youtube-nocookie.com/embed/' . $m[1];
    if (preg_match('~[?&#](?:t|start)=(\d+)~', $url, $t)) {
        $embed .= '?start=' . (int) $t[1];
    }
    return $embed;
}
