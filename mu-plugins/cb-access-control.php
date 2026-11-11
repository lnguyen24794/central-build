<?php
/**
 * Plugin Name: Central Build – Access control
 * Description: Only the site owner has full control. Every other account (even an Administrator) can only update website content.
 * Version:     1.0.0
 *
 * Must-use plugin: lives in wp-content/mu-plugins, always runs, cannot be turned off from the dashboard
 * and keeps working if the theme is changed. Source: repo /mu-plugins/cb-access-control.php,
 * deployed with ./scripts/deploy.sh --mu
 */

if (!defined('ABSPATH')) {
    exit;
}

/** Accounts with full control (matched by email address, case-insensitive). */
const CB_AC_OWNER_EMAILS = array('lnguyen24794@gmail.com');

/** Capabilities blocked for everyone except the owner. */
const CB_AC_BLOCKED_CAPS = array(
    // Plugins
    'activate_plugins', 'install_plugins', 'update_plugins', 'delete_plugins', 'edit_plugins', 'resume_plugins', 'deactivate_plugins',
    // Themes & appearance
    'switch_themes', 'install_themes', 'update_themes', 'delete_themes', 'edit_themes', 'resume_themes', 'edit_theme_options', 'customize', 'edit_css',
    // WordPress core, languages, PHP
    'update_core', 'install_languages', 'update_languages', 'update_php', 'update_https',
    // Files & raw code
    'edit_files', 'unfiltered_upload', 'unfiltered_html',
    // Settings, tools, import/export, privacy, site health
    'manage_options', 'import', 'export', 'manage_privacy_options', 'erase_others_personal_data', 'export_others_personal_data',
    'view_site_health_checks', 'setup_network', 'manage_network', 'manage_network_options', 'manage_sites', 'delete_site',
    // Users (accounts other than their own)
    'list_users', 'create_users', 'add_users', 'delete_users', 'remove_users', 'promote_users',
);

/** Meta capabilities that are fine on one's own account but blocked on anybody else's. */
const CB_AC_OTHER_USER_CAPS = array('edit_user', 'delete_user', 'remove_user', 'promote_user', 'edit_user_meta', 'delete_user_meta', 'add_user_meta');

function cb_ac_is_owner(int $user_id): bool
{
    static $cache = array();
    if ($user_id <= 0) {
        return false;
    }
    if (!isset($cache[$user_id])) {
        $user = get_userdata($user_id);
        $cache[$user_id] = $user && in_array(strtolower($user->user_email), CB_AC_OWNER_EMAILS, true);
    }
    return $cache[$user_id];
}

/** Is this a logged-in account that must be restricted? (Cron / WP-CLI with no user are left alone.) */
function cb_ac_is_restricted(int $user_id): bool
{
    return $user_id > 0 && !cb_ac_is_owner($user_id);
}

function cb_ac_map_meta_cap(array $caps, string $cap, int $user_id, array $args): array
{
    if (!cb_ac_is_restricted($user_id)) {
        return $caps;
    }
    if (in_array($cap, CB_AC_OTHER_USER_CAPS, true)) {
        $target = isset($args[0]) ? (int) $args[0] : 0;
        if ($target !== $user_id) {
            return array('do_not_allow');
        }
        return $caps;
    }
    if (in_array($cap, CB_AC_BLOCKED_CAPS, true) || array_intersect($caps, CB_AC_BLOCKED_CAPS)) {
        return array('do_not_allow');
    }
    return $caps;
}
add_filter('map_meta_cap', 'cb_ac_map_meta_cap', 999, 4);

/** Also strip the blocked capabilities from the account itself (covers plugins that read allcaps directly). */
function cb_ac_user_has_cap(array $allcaps, array $caps, array $args, $user): array
{
    if ($user instanceof WP_User && cb_ac_is_restricted((int) $user->ID)) {
        foreach (CB_AC_BLOCKED_CAPS as $blocked) {
            unset($allcaps[$blocked]);
        }
    }
    return $allcaps;
}
add_filter('user_has_cap', 'cb_ac_user_has_cap', 999, 4);

/** Nobody but the owner can give anyone the Administrator role. */
function cb_ac_editable_roles(array $roles): array
{
    if (cb_ac_is_restricted(get_current_user_id())) {
        unset($roles['administrator']);
    }
    return $roles;
}
add_filter('editable_roles', 'cb_ac_editable_roles');

/** Hide menus that plugins show with low permissions (e.g. Hostinger, LiteSpeed). */
function cb_ac_clean_menu(): void
{
    if (!cb_ac_is_restricted(get_current_user_id())) {
        return;
    }
    global $menu;
    $keep = array(
        'index.php', 'cb-content', 'edit.php', 'upload.php', 'edit.php?post_type=page', 'edit-comments.php', 'profile.php',
        'edit.php?post_type=fitout_sector', 'edit.php?post_type=cb_form_submission',
    );
    foreach ((array) $menu as $item) {
        $slug = $item[2] ?? '';
        if ($slug === '' || strpos($slug, 'separator') === 0) {
            continue;
        }
        if (!in_array($slug, $keep, true)) {
            remove_menu_page($slug);
        }
    }
}
add_action('admin_menu', 'cb_ac_clean_menu', 99999);

function cb_ac_clean_admin_bar(WP_Admin_Bar $bar): void
{
    if (!cb_ac_is_restricted(get_current_user_id())) {
        return;
    }
    foreach ($bar->get_nodes() as $node) {
        $id = $node->id;
        if (stripos($id, 'hostinger') !== false || stripos($id, 'litespeed') !== false || $id === 'updates' || $id === 'customize') {
            $bar->remove_node($id);
        }
    }
}
add_action('admin_bar_menu', 'cb_ac_clean_admin_bar', 99999);

/** Keep plugin banners (Hostinger AI, LiteSpeed…) out of the way of content editors. */
function cb_ac_quiet_notices(): void
{
    if (cb_ac_is_restricted(get_current_user_id())) {
        remove_all_actions('admin_notices');
        remove_all_actions('all_admin_notices');
        remove_all_actions('network_admin_notices');
    }
}
add_action('in_admin_header', 'cb_ac_quiet_notices', 999);

/** Send restricted accounts away from screens they should not use (even if a plugin forgot to check). */
function cb_ac_block_screens(): void
{
    if (!cb_ac_is_restricted(get_current_user_id()) || wp_doing_ajax()) {
        return;
    }
    global $pagenow;
    $blocked_files = array(
        'plugins.php', 'plugin-install.php', 'plugin-editor.php', 'themes.php', 'theme-install.php', 'theme-editor.php',
        'customize.php', 'widgets.php', 'nav-menus.php', 'update-core.php', 'update.php', 'tools.php', 'import.php', 'export.php',
        'site-health.php', 'users.php', 'user-new.php', 'options-general.php', 'options-writing.php', 'options-reading.php',
        'options-discussion.php', 'options-media.php', 'options-permalink.php', 'options-privacy.php', 'options.php', 'privacy.php',
        'erase-personal-data.php', 'export-personal-data.php',
    );
    $page = isset($_GET['page']) ? sanitize_key(wp_unslash($_GET['page'])) : '';
    $allowed_pages = array('cb-content');
    if (in_array($pagenow, $blocked_files, true) || ($page !== '' && !in_array($page, $allowed_pages, true) && $pagenow === 'admin.php')) {
        wp_safe_redirect(admin_url('admin.php?page=cb-content'));
        exit;
    }
}
add_action('admin_menu', 'cb_ac_block_screens', 0); // before WordPress's own "not allowed" check
