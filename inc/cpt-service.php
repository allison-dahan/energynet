<?php
/**
 * Service Custom Post Type registration.
 *
 * @package energynet
 */

function energynet_register_service_cpt() {
	register_post_type( 'service', [
		'labels' => [
			'name'               => __( 'Services',             'energynet' ),
			'singular_name'      => __( 'Service',              'energynet' ),
			'add_new'            => __( 'Add New',              'energynet' ),
			'add_new_item'       => __( 'Add New Service',      'energynet' ),
			'edit_item'          => __( 'Edit Service',         'energynet' ),
			'new_item'           => __( 'New Service',          'energynet' ),
			'view_item'          => __( 'View Service',         'energynet' ),
			'search_items'       => __( 'Search Services',      'energynet' ),
			'not_found'          => __( 'No services found',    'energynet' ),
			'not_found_in_trash' => __( 'No services in Trash', 'energynet' ),
		],
		'public'       => false,
		'show_ui'      => true,
		'show_in_rest' => true,
		'menu_icon'    => 'dashicons-hammer',
		'supports'     => [ 'title', 'thumbnail', 'page-attributes' ],
		'rewrite'      => false,
	] );
}
add_action( 'init', 'energynet_register_service_cpt' );
