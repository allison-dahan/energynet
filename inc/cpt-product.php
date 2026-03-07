<?php
/**
 * Product Custom Post Type, taxonomies, and ACF field registration.
 *
 * @package energynet
 */

// ─── Custom Post Type ─────────────────────────────────────────────────────────

function energynet_register_product_cpt() {
	register_post_type( 'product', [
		'labels' => [
			'name'               => __( 'Products',             'energynet' ),
			'singular_name'      => __( 'Product',              'energynet' ),
			'add_new'            => __( 'Add New',              'energynet' ),
			'add_new_item'       => __( 'Add New Product',      'energynet' ),
			'edit_item'          => __( 'Edit Product',         'energynet' ),
			'new_item'           => __( 'New Product',          'energynet' ),
			'view_item'          => __( 'View Product',         'energynet' ),
			'search_items'       => __( 'Search Products',      'energynet' ),
			'not_found'          => __( 'No products found',    'energynet' ),
			'not_found_in_trash' => __( 'No products in Trash', 'energynet' ),
		],
		'public'       => true,
		'has_archive'  => false,
		'show_in_rest' => true,
		'menu_icon'    => 'dashicons-products',
		'supports'     => [ 'title', 'thumbnail', 'excerpt' ],
		'rewrite'      => [ 'slug' => 'product' ],
	] );
}
add_action( 'init', 'energynet_register_product_cpt' );

// ─── Taxonomy ─────────────────────────────────────────────────────────────────
// Hierarchical: parent term = Category, child term = Sub-category.

function energynet_register_product_taxonomy() {
	register_taxonomy( 'product_category', 'product', [
		'labels' => [
			'name'              => __( 'Product Categories',   'energynet' ),
			'singular_name'     => __( 'Product Category',    'energynet' ),
			'search_items'      => __( 'Search Categories',   'energynet' ),
			'all_items'         => __( 'All Categories',      'energynet' ),
			'parent_item'       => __( 'Parent Category',     'energynet' ),
			'parent_item_colon' => __( 'Parent Category:',    'energynet' ),
			'edit_item'         => __( 'Edit Category',       'energynet' ),
			'update_item'       => __( 'Update Category',     'energynet' ),
			'add_new_item'      => __( 'Add New Category',    'energynet' ),
			'new_item_name'     => __( 'New Category Name',   'energynet' ),
			'menu_name'         => __( 'Categories',          'energynet' ),
		],
		'hierarchical' => true,
		'show_in_rest' => true,
		'rewrite'      => [ 'slug' => 'product-category' ],
	] );
}
add_action( 'init', 'energynet_register_product_taxonomy' );

// ─── Brand Taxonomy ───────────────────────────────────────────────────────────
// Non-hierarchical (like tags) — one level only.

function energynet_register_product_brand_taxonomy() {
	register_taxonomy( 'product_brand', 'product', [
		'labels' => [
			'name'          => __( 'Brands',        'energynet' ),
			'singular_name' => __( 'Brand',         'energynet' ),
			'search_items'  => __( 'Search Brands', 'energynet' ),
			'all_items'     => __( 'All Brands',    'energynet' ),
			'edit_item'     => __( 'Edit Brand',    'energynet' ),
			'update_item'   => __( 'Update Brand',  'energynet' ),
			'add_new_item'  => __( 'Add New Brand', 'energynet' ),
			'new_item_name' => __( 'New Brand Name','energynet' ),
			'menu_name'     => __( 'Brands',        'energynet' ),
		],
		'hierarchical' => false,
		'show_in_rest' => true,
		'rewrite'      => [ 'slug' => 'product-brand' ],
	] );
}
add_action( 'init', 'energynet_register_product_brand_taxonomy' );

// ─── ACF Fields ───────────────────────────────────────────────────────────────
// Uses free ACF — individual file fields with fixed labels.

function energynet_register_product_acf_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group( [
		'key'    => 'group_product_details',
		'title'  => 'Technical Information',
		'fields' => [

			[
				'key'          => 'field_tech_brochure',
				'label'        => 'Brochure',
				'name'         => 'tech_brochure',
				'type'         => 'url',
				'instructions' => 'Paste a URL or upload a file to the Media Library and paste its URL.',
			],
			[
				'key'          => 'field_tech_certificate',
				'label'        => 'Certificate',
				'name'         => 'tech_certificate',
				'type'         => 'url',
				'instructions' => 'Paste a URL or upload a file to the Media Library and paste its URL.',
			],
			[
				'key'          => 'field_tech_data_sheet',
				'label'        => 'Data Sheet',
				'name'         => 'tech_data_sheet',
				'type'         => 'url',
				'instructions' => 'Paste a URL or upload a file to the Media Library and paste its URL.',
			],
			[
				'key'          => 'field_tech_video',
				'label'        => 'Video',
				'name'         => 'tech_video',
				'type'         => 'url',
				'instructions' => 'Paste a video URL or link.',
			],

		],
		'location' => [
			[
				[
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'product',
				],
			],
		],
	] );
}
add_action( 'acf/init', 'energynet_register_product_acf_fields' );
