<?php
/**
 * Website Content → "Top menu": edit the links in the main menu (primary location)
 * without needing access to Appearance → Menus.
 *
 * Also gives the page cards in Website Content the same names as the menu links,
 * so "Steel Structure Installation" in the menu is "Steel Structure Installation" here too.
 */

if (!defined('ABSPATH')) {
    exit;
}

function cb_ce_menu_id(): int
{
    $locations = get_nav_menu_locations();
    if (!empty($locations['primary'])) {
        return (int) $locations['primary'];
    }
    $menus = wp_get_nav_menus();
    return $menus ? (int) $menus[0]->term_id : 0;
}

/** Menu items sorted as they appear: each top-level link followed by its drop-down links. */
function cb_ce_menu_items_sorted(): array
{
    $menu_id = cb_ce_menu_id();
    if (!$menu_id) {
        return array();
    }
    $items = wp_get_nav_menu_items($menu_id, array('post_status' => 'any')) ?: array();
    usort($items, static function ($a, $b) {
        return (int) $a->menu_order <=> (int) $b->menu_order;
    });
    $top = array();
    $children = array();
    foreach ($items as $item) {
        $parent = (int) $item->menu_item_parent;
        if ($parent) {
            $children[$parent][] = $item;
        } else {
            $top[] = $item;
        }
    }
    $sorted = array();
    foreach ($top as $item) {
        $sorted[] = $item;
        foreach ($children[$item->ID] ?? array() as $child) {
            $sorted[] = $child;
        }
        unset($children[$item->ID]);
    }
    foreach ($children as $orphans) { // children of a missing parent
        foreach ($orphans as $child) {
            $sorted[] = $child;
        }
    }
    return $sorted;
}

/** Store API: current values ['items' => rows]. */
function cb_ce_menu_get(): array
{
    $rows = array();
    foreach (cb_ce_menu_items_sorted() as $item) {
        $rows[] = array(
            'id'     => (int) $item->ID,
            'title'  => (string) $item->title,
            'url'    => (string) $item->url,
            'parent' => (int) $item->menu_item_parent,
        );
    }
    return array('items' => $rows);
}

/** Choices for "Show under": top level, or inside one of the top-level links. */
function cb_ce_menu_parent_choices(): array
{
    $choices = array(0 => 'Main menu bar (top level)');
    foreach (cb_ce_menu_items_sorted() as $item) {
        if (!(int) $item->menu_item_parent) {
            $choices[(int) $item->ID] = 'Drop-down under "' . $item->title . '"';
        }
    }
    return $choices;
}

/** Full copy of the menu, used by "Undo last save". */
function cb_ce_menu_snapshot(): array
{
    $snap = array();
    foreach (cb_ce_menu_items_sorted() as $item) {
        $snap[] = cb_ce_menu_item_args($item) + array('id' => (int) $item->ID);
    }
    return $snap;
}

function cb_ce_menu_item_args($item): array
{
    return array(
        'menu-item-object-id'   => (int) $item->object_id,
        'menu-item-object'      => (string) $item->object,
        'menu-item-parent-id'   => (int) $item->menu_item_parent,
        'menu-item-position'    => (int) $item->menu_order,
        'menu-item-type'        => (string) $item->type,
        'menu-item-title'       => (string) $item->title,
        'menu-item-url'         => (string) $item->url,
        'menu-item-description' => (string) $item->description,
        'menu-item-attr-title'  => (string) $item->attr_title,
        'menu-item-target'      => (string) $item->target,
        'menu-item-classes'     => implode(' ', array_filter((array) $item->classes)),
        'menu-item-xfn'         => (string) $item->xfn,
        'menu-item-status'      => 'publish',
    );
}

/** Store API: save rows posted from the editor. */
function cb_ce_menu_save(array $values): void
{
    $menu_id = cb_ce_menu_id();
    if (!$menu_id) {
        return;
    }
    $existing = array();
    foreach (cb_ce_menu_items_sorted() as $item) {
        $existing[(int) $item->ID] = $item;
    }
    $rows = array_values(array_filter((array) ($values['items'] ?? array()), static function ($row) {
        return is_array($row) && trim((string) ($row['title'] ?? '')) !== '';
    }));

    $kept = array();
    foreach ($rows as $row) {
        $id = (int) ($row['id'] ?? 0);
        if ($id && isset($existing[$id])) {
            $kept[$id] = true;
        }
    }
    // Links removed in the editor.
    foreach ($existing as $id => $item) {
        if (empty($kept[$id])) {
            wp_delete_post($id, true);
        }
    }

    $top_level = array();
    foreach ($rows as $row) {
        if (!(int) ($row['parent'] ?? 0) && (int) ($row['id'] ?? 0)) {
            $top_level[(int) $row['id']] = true;
        }
    }

    $position = 0;
    foreach ($rows as $row) {
        $position++;
        $id     = (int) ($row['id'] ?? 0);
        $title  = sanitize_text_field((string) $row['title']);
        $url    = trim((string) ($row['url'] ?? ''));
        $url    = $url === '' ? '#' : esc_url_raw($url);
        $parent = (int) ($row['parent'] ?? 0);
        if ($parent === $id || empty($top_level[$parent])) {
            $parent = 0;
        }

        if ($id && isset($existing[$id])) {
            $args = cb_ce_menu_item_args($existing[$id]);
            if ($url !== $existing[$id]->url) {
                // A new address turns a page/category link into a plain link.
                $args['menu-item-type']      = 'custom';
                $args['menu-item-object']    = 'custom';
                $args['menu-item-object-id'] = 0;
                $args['menu-item-url']       = $url;
            }
            $args['menu-item-title']     = $title;
            $args['menu-item-parent-id'] = $parent;
            $args['menu-item-position']  = $position;
            wp_update_nav_menu_item($menu_id, $id, $args);
        } else {
            wp_update_nav_menu_item($menu_id, 0, array(
                'menu-item-type'      => 'custom',
                'menu-item-title'     => $title,
                'menu-item-url'       => $url,
                'menu-item-parent-id' => $parent,
                'menu-item-position'  => $position,
                'menu-item-status'    => 'publish',
            ));
        }
    }
}

/** Store API: put the menu back exactly as in a snapshot. */
function cb_ce_menu_restore(array $snapshot): void
{
    $menu_id = cb_ce_menu_id();
    if (!$menu_id) {
        return;
    }
    $current = array();
    foreach (cb_ce_menu_items_sorted() as $item) {
        $current[(int) $item->ID] = true;
    }
    $in_snapshot = array();
    foreach ($snapshot as $row) {
        $in_snapshot[(int) $row['id']] = true;
    }
    foreach (array_keys($current) as $id) {
        if (empty($in_snapshot[$id])) {
            wp_delete_post($id, true);
        }
    }
    $id_map = array();
    // Parents first so that children can point at them.
    usort($snapshot, static function ($a, $b) {
        return ((int) $a['menu-item-parent-id'] > 0) <=> ((int) $b['menu-item-parent-id'] > 0);
    });
    foreach ($snapshot as $row) {
        $old  = (int) $row['id'];
        $args = $row;
        unset($args['id']);
        $parent = (int) $args['menu-item-parent-id'];
        if ($parent && isset($id_map[$parent])) {
            $args['menu-item-parent-id'] = $id_map[$parent];
        }
        $target = !empty($current[$old]) ? $old : 0;
        $new_id = wp_update_nav_menu_item($menu_id, $target, $args);
        if (!is_wp_error($new_id)) {
            $id_map[$old] = (int) $new_id;
        }
    }
}

/* ---------------------------------------------------------------------
 * Page cards use the menu's wording
 * --------------------------------------------------------------------- */

function cb_ce_url_path(string $url): string
{
    $path = (string) wp_parse_url($url, PHP_URL_PATH);
    return '/' . trim($path, '/');
}

/** Map of page path => menu link text, e.g. "/commercial-stripout" => "Steel Structure Installation". */
function cb_ce_menu_titles_by_path(): array
{
    static $map = null;
    if ($map !== null) {
        return $map;
    }
    $map = array();
    $home_path = cb_ce_url_path(home_url('/'));
    foreach (cb_ce_menu_items_sorted() as $item) {
        $url = (string) $item->url;
        if ($url === '' || $url === '#') {
            continue;
        }
        if (strpos($url, '//') !== false && wp_parse_url($url, PHP_URL_HOST) !== wp_parse_url(home_url(), PHP_URL_HOST)) {
            continue;
        }
        $path = cb_ce_url_path($url);
        if ($home_path !== '/' && strpos($path, $home_path) === 0) {
            $path = '/' . ltrim(substr($path, strlen($home_path)), '/');
        }
        if (!isset($map[$path])) {
            $map[$path] = (string) $item->title;
        }
    }
    return $map;
}
