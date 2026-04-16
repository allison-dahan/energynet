<?php
/**
 * Project Custom Post Type and native meta box registration.
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

// ─── Enqueue media uploader on project edit screen ────────────────────────────

function energynet_project_admin_enqueue( $hook ) {
	global $post;
	if ( ( $hook === 'post.php' || $hook === 'post-new.php' ) && isset( $post ) && $post->post_type === 'project' ) {
		wp_enqueue_media();
	}
}
add_action( 'admin_enqueue_scripts', 'energynet_project_admin_enqueue' );

// ─── Register meta box ────────────────────────────────────────────────────────

function energynet_register_project_meta_box() {
	add_meta_box(
		'project_details',
		__( 'Project Details', 'energynet' ),
		'energynet_render_project_meta_box',
		'project',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'energynet_register_project_meta_box' );

// ─── Render meta box ──────────────────────────────────────────────────────────

function energynet_render_project_meta_box( $post ) {
	wp_nonce_field( 'energynet_save_project_meta', 'energynet_project_nonce' );

	$status   = get_post_meta( $post->ID, '_project_status',   true ) ?: 'completed';
	$client   = get_post_meta( $post->ID, '_project_client',   true );
	$location = get_post_meta( $post->ID, '_project_location', true );
	$date     = get_post_meta( $post->ID, '_project_date',     true );
	$scope    = get_post_meta( $post->ID, '_project_scope',    true );
	$gallery  = get_post_meta( $post->ID, '_project_gallery',  true );
	$video    = get_post_meta( $post->ID, '_project_video',    true );
	$lat       = get_post_meta( $post->ID, '_project_lat',       true );
	$lng       = get_post_meta( $post->ID, '_project_lng',       true );
	$location2 = get_post_meta( $post->ID, '_project_location_2', true );
	$lat2      = get_post_meta( $post->ID, '_project_lat_2',      true );
	$lng2      = get_post_meta( $post->ID, '_project_lng_2',      true );

	// Build thumbnail previews for existing gallery IDs.
	$gallery_thumbs = '';
	if ( $gallery ) {
		foreach ( array_filter( array_map( 'trim', explode( ',', $gallery ) ) ) as $att_id ) {
			$att_id = (int) $att_id;
			$mime   = get_post_mime_type( $att_id );
			$remove = '<button type="button" class="en-gallery-remove" data-id="' . $att_id . '" style="position:absolute;top:0;right:0;background:#c00;color:#fff;border:none;cursor:pointer;font-size:12px;line-height:1;padding:2px 4px;">&times;</button>';

			if ( strpos( $mime, 'video' ) === 0 ) {
				$filename = basename( get_attached_file( $att_id ) );
				$gallery_thumbs .= '<div class="en-gallery-thumb" data-id="' . $att_id . '" style="display:inline-block;position:relative;margin:4px;">'
					. '<div style="width:80px;height:80px;background:#333;display:flex;align-items:center;justify-content:center;border:1px solid #ddd;flex-direction:column;gap:4px;">'
					. '<span style="color:#fff;font-size:22px;">&#9654;</span>'
					. '<span style="color:#aaa;font-size:10px;max-width:76px;overflow:hidden;white-space:nowrap;text-overflow:ellipsis;">' . esc_html( $filename ) . '</span>'
					. '</div>'
					. $remove . '</div>';
			} else {
				$thumb = wp_get_attachment_image_url( $att_id, 'thumbnail' );
				if ( $thumb ) {
					$gallery_thumbs .= '<div class="en-gallery-thumb" data-id="' . $att_id . '" style="display:inline-block;position:relative;margin:4px;">'
						. '<img src="' . esc_url( $thumb ) . '" style="width:80px;height:80px;object-fit:cover;border:1px solid #ddd;">'
						. $remove . '</div>';
				}
			}
		}
	}
	?>

	<style>
		.en-meta-table { width: 100%; border-collapse: collapse; }
		.en-meta-table th { text-align: left; padding: 8px 12px 8px 0; width: 160px; font-weight: 600; vertical-align: top; }
		.en-meta-table td { padding: 6px 0; vertical-align: top; }
		.en-meta-table input[type="text"],
		.en-meta-table input[type="url"],
		.en-meta-table input[type="number"],
		.en-meta-table textarea,
		.en-meta-table select { width: 100%; }
		.en-meta-table .description { color: #666; font-size: 12px; margin-top: 4px; display: block; }
		#en-gallery-thumbs { margin-top: 8px; }
	</style>

	<table class="en-meta-table">

		<tr>
			<th><label for="_project_status"><?php esc_html_e( 'Status', 'energynet' ); ?></label></th>
			<td>
				<select id="_project_status" name="_project_status">
					<option value="completed" <?php selected( $status, 'completed' ); ?>><?php esc_html_e( 'Completed', 'energynet' ); ?></option>
					<option value="ongoing"   <?php selected( $status, 'ongoing' ); ?>><?php esc_html_e( 'Ongoing',   'energynet' ); ?></option>
				</select>
			</td>
		</tr>

		<tr>
			<th><label for="_project_client"><?php esc_html_e( 'Client', 'energynet' ); ?></label></th>
			<td>
				<input type="text" id="_project_client" name="_project_client" value="<?php echo esc_attr( $client ); ?>">
			</td>
		</tr>

		<tr>
			<th><label for="_project_location"><?php esc_html_e( 'Location', 'energynet' ); ?></label></th>
			<td>
				<input type="text" id="_project_location" name="_project_location" value="<?php echo esc_attr( $location ); ?>">
				<span class="description"><?php esc_html_e( 'City or region, used for the map', 'energynet' ); ?></span>
			</td>
		</tr>

		<tr>
			<th><label for="_project_date"><?php esc_html_e( 'Date Completed', 'energynet' ); ?></label></th>
			<td>
				<input type="text" id="_project_date" name="_project_date" value="<?php echo esc_attr( $date ); ?>" placeholder="DD/MM/YYYY">
				<span class="description"><?php esc_html_e( 'e.g. DD/MM/YYYY', 'energynet' ); ?></span>
			</td>
		</tr>

		<tr>
			<th><label for="_project_scope"><?php esc_html_e( 'Scope', 'energynet' ); ?></label></th>
			<td>
				<textarea id="_project_scope" name="_project_scope" rows="3"><?php echo esc_textarea( $scope ); ?></textarea>
			</td>
		</tr>

		<tr>
			<th><?php esc_html_e( 'Gallery', 'energynet' ); ?></th>
			<td>
				<input type="hidden" id="_project_gallery" name="_project_gallery" value="<?php echo esc_attr( $gallery ); ?>">
				<button type="button" id="en-gallery-btn" class="button"><?php esc_html_e( 'Add Images / Videos', 'energynet' ); ?></button>
				<span class="description"><?php esc_html_e( 'Images and videos both supported.', 'energynet' ); ?></span>
				<div id="en-gallery-thumbs"><?php echo $gallery_thumbs; // already escaped per-thumb ?></div>
			</td>
		</tr>

		<tr>
			<th><label for="_project_lat"><?php esc_html_e( 'Latitude', 'energynet' ); ?></label></th>
			<td>
				<input type="number" id="_project_lat" name="_project_lat" value="<?php echo esc_attr( $lat ); ?>" step="any" readonly>
				<span class="description"><?php esc_html_e( 'Auto-filled from Location on save', 'energynet' ); ?></span>
			</td>
		</tr>

		<tr>
			<th><label for="_project_lng"><?php esc_html_e( 'Longitude', 'energynet' ); ?></label></th>
			<td>
				<input type="number" id="_project_lng" name="_project_lng" value="<?php echo esc_attr( $lng ); ?>" step="any" readonly>
				<span class="description"><?php esc_html_e( 'Auto-filled from Location on save', 'energynet' ); ?></span>
			</td>
		</tr>

		<tr><td colspan="2"><hr style="margin:8px 0;border:none;border-top:1px solid #ddd;"></td></tr>

		<tr>
			<th><label for="_project_location_2"><?php esc_html_e( 'Location 2 (optional)', 'energynet' ); ?></label></th>
			<td>
				<input type="text" id="_project_location_2" name="_project_location_2" value="<?php echo esc_attr( $location2 ); ?>">
				<span class="description"><?php esc_html_e( 'Second location if the project spans two sites', 'energynet' ); ?></span>
			</td>
		</tr>

		<tr>
			<th><label for="_project_lat_2"><?php esc_html_e( 'Latitude 2', 'energynet' ); ?></label></th>
			<td>
				<input type="number" id="_project_lat_2" name="_project_lat_2" value="<?php echo esc_attr( $lat2 ); ?>" step="any" readonly>
				<span class="description"><?php esc_html_e( 'Auto-filled from Location 2 on save', 'energynet' ); ?></span>
			</td>
		</tr>

		<tr>
			<th><label for="_project_lng_2"><?php esc_html_e( 'Longitude 2', 'energynet' ); ?></label></th>
			<td>
				<input type="number" id="_project_lng_2" name="_project_lng_2" value="<?php echo esc_attr( $lng2 ); ?>" step="any" readonly>
				<span class="description"><?php esc_html_e( 'Auto-filled from Location 2 on save', 'energynet' ); ?></span>
			</td>
		</tr>

	</table>

	<script>
	(function($) {
		var frame;
		var $input  = $('#_project_gallery');
		var $thumbs = $('#en-gallery-thumbs');

		// Open WP media library.
		$('#en-gallery-btn').on('click', function(e) {
			e.preventDefault();

			if (frame) {
				frame.open();
				return;
			}

			frame = wp.media({
				title:    '<?php echo esc_js( __( 'Select Images or Videos', 'energynet' ) ); ?>',
				button:   { text: '<?php echo esc_js( __( 'Add to Gallery', 'energynet' ) ); ?>' },
				multiple: true
			});

			frame.on('select', function() {
				var selection   = frame.state().get('selection');
				var existingIds = $input.val() ? $input.val().split(',').map(function(id){ return id.trim(); }).filter(Boolean) : [];

				selection.each(function(attachment) {
					var id      = attachment.get('id');
					var type    = attachment.get('type'); // 'image' or 'video'
					var remove  = '<button type="button" class="en-gallery-remove" data-id="' + id + '" style="position:absolute;top:0;right:0;background:#c00;color:#fff;border:none;cursor:pointer;font-size:12px;line-height:1;padding:2px 4px;">&times;</button>';
					var preview;

					if (type === 'video') {
						var filename = attachment.get('filename') || attachment.get('url').split('/').pop();
						preview = '<div style="width:80px;height:80px;background:#333;display:flex;align-items:center;justify-content:center;border:1px solid #ddd;flex-direction:column;gap:4px;">' +
							'<span style="color:#fff;font-size:22px;">&#9654;</span>' +
							'<span style="color:#aaa;font-size:10px;max-width:76px;overflow:hidden;white-space:nowrap;text-overflow:ellipsis;">' + filename + '</span>' +
							'</div>';
					} else {
						var thumbUrl = attachment.get('sizes') && attachment.get('sizes').thumbnail
							? attachment.get('sizes').thumbnail.url
							: attachment.get('url');
						preview = '<img src="' + thumbUrl + '" style="width:80px;height:80px;object-fit:cover;border:1px solid #ddd;">';
					}

					if (existingIds.indexOf(String(id)) === -1) {
						existingIds.push(String(id));
						$thumbs.append(
							'<div class="en-gallery-thumb" data-id="' + id + '" style="display:inline-block;position:relative;margin:4px;">' +
							preview + remove +
							'</div>'
						);
					}
				});

				$input.val(existingIds.join(','));
			});

			frame.open();
		});

		// Remove individual image.
		$thumbs.on('click', '.en-gallery-remove', function() {
			var id  = $(this).data('id');
			var ids = $input.val().split(',').map(function(v){ return v.trim(); }).filter(function(v){ return v && String(v) !== String(id); });
			$input.val(ids.join(','));
			$(this).closest('.en-gallery-thumb').remove();
		});

	}(jQuery));
	</script>
	<?php
}

// ─── Save meta box data ───────────────────────────────────────────────────────

function energynet_save_project_meta( $post_id ) {
	// Verify nonce.
	if ( ! isset( $_POST['energynet_project_nonce'] ) || ! wp_verify_nonce( $_POST['energynet_project_nonce'], 'energynet_save_project_meta' ) ) {
		return;
	}

	// Skip autosaves and revisions.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	if ( wp_is_post_revision( $post_id ) ) return;

	// Check permissions.
	if ( ! current_user_can( 'edit_post', $post_id ) ) return;

	$fields = [
		'_project_status',
		'_project_client',
		'_project_location',
		'_project_location_2',
		'_project_date',
		'_project_video',
		'_project_gallery',
	];

	foreach ( $fields as $field ) {
		$value = isset( $_POST[ $field ] ) ? sanitize_text_field( wp_unslash( $_POST[ $field ] ) ) : '';
		update_post_meta( $post_id, $field, $value );
	}

	// Scope is a textarea — preserve line breaks.
	$scope = isset( $_POST['_project_scope'] ) ? sanitize_textarea_field( wp_unslash( $_POST['_project_scope'] ) ) : '';
	update_post_meta( $post_id, '_project_scope', $scope );

	// Lat / lng — numeric, stored as-is (geocoding will overwrite).
	$lat = isset( $_POST['_project_lat'] ) ? (float) $_POST['_project_lat'] : '';
	$lng = isset( $_POST['_project_lng'] ) ? (float) $_POST['_project_lng'] : '';
	if ( $lat ) update_post_meta( $post_id, '_project_lat', $lat );
	if ( $lng ) update_post_meta( $post_id, '_project_lng', $lng );

	$lat2 = isset( $_POST['_project_lat_2'] ) ? (float) $_POST['_project_lat_2'] : '';
	$lng2 = isset( $_POST['_project_lng_2'] ) ? (float) $_POST['_project_lng_2'] : '';
	if ( $lat2 ) update_post_meta( $post_id, '_project_lat_2', $lat2 );
	if ( $lng2 ) update_post_meta( $post_id, '_project_lng_2', $lng2 );
}
add_action( 'save_post_project', 'energynet_save_project_meta', 10 );

// ─── Auto-geocode location → lat/lng on save ──────────────────────────────────

function energynet_geocode_project_location( $post_id ) {
	// Skip autosaves, revisions, and non-project posts.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	if ( wp_is_post_revision( $post_id ) ) return;
	if ( get_post_type( $post_id ) !== 'project' ) return;

	$location = get_post_meta( $post_id, '_project_location', true );
	if ( ! $location ) return;

	// Only geocode when lat/lng are empty OR location has changed since last geocode.
	$cached_location = get_post_meta( $post_id, '_geocoded_location', true );
	$lat             = get_post_meta( $post_id, '_project_lat', true );
	$lng             = get_post_meta( $post_id, '_project_lng', true );

	if ( $lat && $lng && $cached_location === $location ) return;

	// Call Nominatim — bias results to the Philippines.
	$url = add_query_arg( [
		'q'            => $location . ', Philippines',
		'format'       => 'json',
		'limit'        => 1,
		'countrycodes' => 'ph',
	], 'https://nominatim.openstreetmap.org/search' );

	$response = wp_remote_get( $url, [
		'timeout' => 8,
		'headers' => [ 'User-Agent' => 'EnergyNet-Theme/1.0' ],
	] );

	if ( is_wp_error( $response ) ) return;

	$data = json_decode( wp_remote_retrieve_body( $response ), true );
	if ( empty( $data[0]['lat'] ) ) return;

	update_post_meta( $post_id, '_project_lat', (float) $data[0]['lat'] );
	update_post_meta( $post_id, '_project_lng', (float) $data[0]['lon'] );
	update_post_meta( $post_id, '_geocoded_location', $location );

	// ── Geocode location 2 if provided and changed ──
	$location2 = get_post_meta( $post_id, '_project_location_2', true );
	if ( $location2 ) {
		$cached2 = get_post_meta( $post_id, '_geocoded_location_2', true );
		$lat2    = get_post_meta( $post_id, '_project_lat_2', true );
		$lng2    = get_post_meta( $post_id, '_project_lng_2', true );

		if ( ! $lat2 || ! $lng2 || $cached2 !== $location2 ) {
			$url2 = add_query_arg( [
				'q'            => $location2 . ', Philippines',
				'format'       => 'json',
				'limit'        => 1,
				'countrycodes' => 'ph',
			], 'https://nominatim.openstreetmap.org/search' );

			$response2 = wp_remote_get( $url2, [
				'timeout' => 8,
				'headers' => [ 'User-Agent' => 'EnergyNet-Theme/1.0' ],
			] );

			if ( ! is_wp_error( $response2 ) ) {
				$data2 = json_decode( wp_remote_retrieve_body( $response2 ), true );
				if ( ! empty( $data2[0]['lat'] ) ) {
					update_post_meta( $post_id, '_project_lat_2', (float) $data2[0]['lat'] );
					update_post_meta( $post_id, '_project_lng_2', (float) $data2[0]['lon'] );
					update_post_meta( $post_id, '_geocoded_location_2', $location2 );
				}
			}
		}
	}
}
add_action( 'save_post_project', 'energynet_geocode_project_location', 20 );
