<?php
/**
 * Project Custom Post Type and ACF field registration.
 *
 * @package energynet
 */

// ─── Custom Post Type ─────────────────────────────────────────────────────────

function energynet_register_project_cpt() {
	register_post_type( 'project', [
		'labels' => [
			'name'               => __( 'Projects',             'energynet' ),
			'singular_name'      => __( 'Project',              'energynet' ),
			'add_new'            => __( 'Add New',              'energynet' ),
			'add_new_item'       => __( 'Add New Project',      'energynet' ),
			'edit_item'          => __( 'Edit Project',         'energynet' ),
			'new_item'           => __( 'New Project',          'energynet' ),
			'view_item'          => __( 'View Project',         'energynet' ),
			'search_items'       => __( 'Search Projects',      'energynet' ),
			'not_found'          => __( 'No projects found',    'energynet' ),
			'not_found_in_trash' => __( 'No projects in Trash', 'energynet' ),
		],
		'public'       => true,
		'has_archive'  => false,
		'show_in_rest' => true,
		'menu_icon'    => 'dashicons-building',
		'supports'     => [ 'title', 'thumbnail' ],
		'rewrite'      => [ 'slug' => 'project' ],
	] );
}
add_action( 'init', 'energynet_register_project_cpt' );

// ─── ACF Fields ───────────────────────────────────────────────────────────────

function energynet_register_project_acf_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group( [
		'key'    => 'group_project_details',
		'title'  => 'Project Details',
		'fields' => [

			[
				'key'   => 'field_project_status',
				'label' => 'Status',
				'name'  => 'project_status',
				'type'  => 'select',
				'choices' => [
					'completed' => 'Completed',
					'ongoing'   => 'Ongoing',
				],
				'default_value' => 'completed',
				'return_format' => 'value',
			],
			[
				'key'   => 'field_project_client',
				'label' => 'Client',
				'name'  => 'project_client',
				'type'  => 'text',
			],
			[
				'key'          => 'field_project_location',
				'label'        => 'Location',
				'name'         => 'project_location',
				'type'         => 'text',
				'instructions' => 'City or region (e.g. Cavite, Metro Manila). Will be used for the map.',
			],
			[
				'key'   => 'field_project_date',
				'label' => 'Date Completed',
				'name'  => 'project_date',
				'type'  => 'text',
				'instructions' => 'e.g. DD/MM/YYYY',
			],
			[
				'key'   => 'field_project_scope',
				'label' => 'Scope',
				'name'  => 'project_scope',
				'type'  => 'textarea',
				'rows'  => 3,
			],
			[
				'key'           => 'field_project_gallery',
				'label'         => 'Gallery',
				'name'          => 'project_gallery',
				'type'          => 'gallery',
				'return_format' => 'array',
				'preview_size'  => 'medium',
				'library'       => 'all',
				'instructions'  => 'Upload project images. First image is used as the main photo.',
			],
			[
				'key'          => 'field_project_video',
				'label'        => 'Video URL',
				'name'         => 'project_video',
				'type'         => 'url',
				'instructions' => 'Paste a video URL (YouTube, Vimeo, etc.).',
			],

		],
		'location' => [
			[
				[
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'project',
				],
			],
		],
	] );
}
add_action( 'acf/init', 'energynet_register_project_acf_fields' );
