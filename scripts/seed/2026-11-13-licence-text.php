<?php
/**
 * About > Builder Licence & Insurances: shorter card texts (13 Nov 2026). Safe to run more than once.
 *
 *   wp eval-file 2026-11-13-licence-text.php
 *
 * Ends the licence card at the registration number and drops the insurer and the $500,000 limit.
 * Only touches a saved copy; without one the page uses the theme defaults, which already match.
 */

if (!defined('ABSPATH')) {
    exit(1);
}

$cuts = array(
    ', limited to non-structural fit-out work.'                                  => '.',
    ' Underwritten by AIG Australia through MECON Insurance.'                    => '',
    ' on projects up to $500,000 in Victoria.'                                   => '.',
);
$fix = static function ($v) use (&$fix, $cuts) {
    if (is_array($v)) {
        return array_map($fix, $v);
    }
    return is_string($v) ? str_replace(array_keys($cuts), array_values($cuts), $v) : $v;
};

global $wpdb;
$names = $wpdb->get_col("SELECT option_name FROM {$wpdb->options} WHERE (option_name LIKE 'central_build_%' OR option_name LIKE 'cb_ce_%')
    AND (option_value LIKE '%limited to non-structural%' OR option_value LIKE '%Underwritten by AIG%' OR option_value LIKE '%projects up to $500,000%')");
foreach ($names as $name) {
    update_option($name, $fix(get_option($name)));
    WP_CLI::log("Updated $name");
}
WP_CLI::success(count($names) . ' saved setting(s) updated.');
