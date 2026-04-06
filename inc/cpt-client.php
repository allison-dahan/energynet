<?php
/**
 * Client Custom Post Type registration.
 *
 * @package energynet
 */

function energynet_register_client_cpt() {
	register_post_type( 'client', [
		'labels' => [
			'name'               => __( 'Clients',             'energynet' ),
			'singular_name'      => __( 'Client',              'energynet' ),
			'add_new'            => __( 'Add New',             'energynet' ),
			'add_new_item'       => __( 'Add New Client',      'energynet' ),
			'edit_item'          => __( 'Edit Client',         'energynet' ),
			'new_item'           => __( 'New Client',          'energynet' ),
			'view_item'          => __( 'View Client',         'energynet' ),
			'search_items'       => __( 'Search Clients',      'energynet' ),
			'not_found'          => __( 'No clients found',    'energynet' ),
			'not_found_in_trash' => __( 'No clients in Trash', 'energynet' ),
		],
		'public'       => false,
		'show_ui'      => true,
		'show_in_rest' => true,
		'menu_icon'    => 'dashicons-groups',
		'supports'     => [ 'title', 'thumbnail' ],
		'rewrite'      => false,
	] );
}
add_action( 'init', 'energynet_register_client_cpt' );
