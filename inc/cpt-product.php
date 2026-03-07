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
// Uses free ACF only — 3 separate label+file pairs instead of a repeater.

function energynet_register_product_acf_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group( [
		'key'      => 'group_product_details',
		'title'    => 'Product Details',
		'fields'   => [

			// Technical File 1
			[
				'key'   => 'field_tech_file_1_label',
				'label' => 'Technical File 1 — Label',
				'name'  => 'tech_file_1_label',
				'type'  => 'text',
			],
			[
				'key'           => 'field_tech_file_1_upload',
				'label'         => 'Technical File 1 — File',
				'name'          => 'tech_file_1_upload',
				'type'          => 'file',
				'return_format' => 'url',
			],

			// Technical File 2
			[
				'key'   => 'field_tech_file_2_label',
				'label' => 'Technical File 2 — Label',
				'name'  => 'tech_file_2_label',
				'type'  => 'text',
			],
			[
				'key'           => 'field_tech_file_2_upload',
				'label'         => 'Technical File 2 — File',
				'name'          => 'tech_file_2_upload',
				'type'          => 'file',
				'return_format' => 'url',
			],

			// Technical File 3
			[
				'key'   => 'field_tech_file_3_label',
				'label' => 'Technical File 3 — Label',
				'name'  => 'tech_file_3_label',
				'type'  => 'text',
			],
			[
				'key'           => 'field_tech_file_3_upload',
				'label'         => 'Technical File 3 — File',
				'name'          => 'tech_file_3_upload',
				'type'          => 'file',
				'return_format' => 'url',
			],

			// Video
			[
				'key'   => 'field_product_video',
				'label' => 'Video URL or Filename',
				'name'  => 'product_video',
				'type'  => 'text',
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
