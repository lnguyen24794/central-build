<?php
/**
 * WP-CLI bootstrap: create Heat Pump hub/brand/model pages + menu updates.
 *
 * Usage: wp eval-file /scripts/setup-content.php
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit( 1 );
}

require_once get_stylesheet_directory() . '/inc/brand-content.php';

function evo_upsert_page( $title, $slug, $parent_id = 0, $meta = array() ) {
	$existing = get_page_by_path(
		$parent_id
			? get_page_uri( $parent_id ) . '/' . $slug
			: $slug,
		OBJECT,
		'page'
	);

	// Fallback search by slug + parent.
	if ( ! $existing ) {
		$q = new WP_Query(
			array(
				'post_type'      => 'page',
				'name'           => $slug,
				'post_parent'    => $parent_id,
				'posts_per_page' => 1,
				'post_status'    => 'any',
			)
		);
		if ( $q->have_posts() ) {
			$existing = $q->posts[0];
		}
		wp_reset_postdata();
	}

	$data = array(
		'post_title'   => $title,
		'post_name'    => $slug,
		'post_status'  => 'publish',
		'post_type'    => 'page',
		'post_parent'  => $parent_id,
		'post_content' => '',
	);

	if ( $existing ) {
		$data['ID'] = $existing->ID;
		$id = wp_update_post( $data, true );
	} else {
		$id = wp_insert_post( $data, true );
	}

	if ( is_wp_error( $id ) ) {
		WP_CLI::warning( $id->get_error_message() );
		return 0;
	}

	update_post_meta( $id, '_wp_page_template', 'page-templates/heat-pump-brand.php' );
	foreach ( $meta as $key => $value ) {
		update_post_meta( $id, $key, $value );
	}

	// Prefer our PHP template over Elementor for these pages.
	delete_post_meta( $id, '_elementor_edit_mode' );
	delete_post_meta( $id, '_elementor_data' );
	delete_post_meta( $id, '_elementor_template_type' );

	return (int) $id;
}

WP_CLI::log( 'Creating Heat Pump Hot Water pages...' );

$hub_id = evo_upsert_page(
	'Heat Pump Hot Water',
	'heat-pump-hot-water',
	0,
	array()
);

$brands = evo_get_brands();
$created = array( 'hub' => $hub_id );

foreach ( $brands as $slug => $brand ) {
	$brand_id = evo_upsert_page(
		$brand['title'],
		$slug,
		$hub_id,
		array( '_evo_brand' => $slug )
	);
	$created[ $slug ] = $brand_id;

	foreach ( $brand['models'] as $model ) {
		$model_id = evo_upsert_page(
			$brand['name'] . ' ' . $model['label'],
			$model['slug'],
			$brand_id,
			array(
				'_evo_brand' => $slug,
				'_evo_model' => $model['slug'],
			)
		);
		$created[ $slug . '/' . $model['slug'] ] = $model_id;
	}
}

// Redirect old Emerald menu target: keep /emerald-heat-pump/ but point content via redirect option.
$old = get_page_by_path( 'emerald-heat-pump' );
if ( $old && ! empty( $created['emerald'] ) ) {
	update_post_meta( $old->ID, '_evo_redirect_to', home_url( '/heat-pump-hot-water/emerald/' ) );
}

// Update primary menu: rename Emerald Heat Pump -> Heat Pump Hot Water linking to hub.
$menus = wp_get_nav_menus();
foreach ( $menus as $menu ) {
	$items = wp_get_nav_menu_items( $menu->term_id );
	if ( ! $items ) {
		continue;
	}
	foreach ( $items as $item ) {
		$title = trim( wp_strip_all_tags( $item->title ) );
		if ( preg_match( '/emerald\s*heat\s*pump/i', $title ) || preg_match( '/heat\s*pump/i', $title ) && ! preg_match( '/hot\s*water/i', $title ) ) {
			wp_update_nav_menu_item(
				$menu->term_id,
				$item->ID,
				array(
					'menu-item-title'  => 'Heat Pump Hot Water',
					'menu-item-url'    => home_url( '/heat-pump-hot-water/' ),
					'menu-item-status' => 'publish',
					'menu-item-type'   => 'custom',
				)
			);
			WP_CLI::log( "Updated menu item in {$menu->name}: {$title}" );
		}
	}
}

// Ensure front page still uses our template override (page id 45 historically).
$front_id = (int) get_option( 'page_on_front' );
if ( $front_id ) {
	delete_post_meta( $front_id, '_elementor_edit_mode' );
	WP_CLI::log( "Front page ID {$front_id}: Elementor builder mode cleared for PHP front-page.php" );
}

flush_rewrite_rules();

WP_CLI::success( 'Content setup complete. Pages: ' . wp_json_encode( $created ) );
