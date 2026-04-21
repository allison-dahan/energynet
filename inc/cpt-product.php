<?php
/**
 * Product Custom Post Type, taxonomies, and native meta box registration.
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
		'supports'     => [ 'title', 'editor', 'thumbnail', 'excerpt' ],
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

// ─── Meta box: Technical Information ─────────────────────────────────────────

function energynet_register_product_meta_box() {
	add_meta_box(
		'product_technical_information',
		__( 'Technical Information', 'energynet' ),
		'energynet_render_product_meta_box',
		'product',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'energynet_register_product_meta_box' );

function energynet_render_product_meta_box( $post ) {
	wp_nonce_field( 'energynet_save_product_meta', 'energynet_product_nonce' );

	$brochure_name = get_post_meta( $post->ID, '_tech_brochure_name', true );
	$brochure_url  = get_post_meta( $post->ID, '_tech_brochure_url',  true );
	$certificate_name = get_post_meta( $post->ID, '_tech_certificate_name', true );
	$certificate      = get_post_meta( $post->ID, '_tech_certificate',      true );
	$data_sheet    = get_post_meta( $post->ID, '_tech_data_sheet',    true );
	$video         = get_post_meta( $post->ID, '_tech_video',         true );
	?>
	<style>
		.en-product-meta-table { width: 100%; border-collapse: collapse; }
		.en-product-meta-table th { text-align: left; padding: 8px 12px 8px 0; width: 140px; font-weight: 600; vertical-align: middle; }
		.en-product-meta-table td { padding: 6px 0; vertical-align: middle; }
		.en-product-meta-table input[type="url"],
		.en-product-meta-table input[type="text"] { width: 100%; }
		.en-product-meta-table .description { color: #666; font-size: 12px; margin-top: 3px; display: block; }
	</style>
	<table class="en-product-meta-table">
		<tr>
			<th><?php esc_html_e( 'Brochure', 'energynet' ); ?></th>
			<td>
				<input type="text" id="_tech_brochure_name" name="_tech_brochure_name" value="<?php echo esc_attr( $brochure_name ); ?>" placeholder="<?php esc_attr_e( 'Display name (optional)', 'energynet' ); ?>" style="width:100%;margin-bottom:6px;">
				<input type="url"  id="_tech_brochure_url"  name="_tech_brochure_url"  value="<?php echo esc_attr( $brochure_url ); ?>"  placeholder="https://" style="width:100%;margin-bottom:6px;">
				<button type="button" id="en-brochure-btn" class="button"><?php esc_html_e( 'Upload / Select File', 'energynet' ); ?></button>
				<button type="button" id="en-brochure-remove" class="button" style="margin-left:4px;<?php echo $brochure_url ? '' : 'display:none;'; ?>"><?php esc_html_e( 'Remove', 'energynet' ); ?></button>
				<span class="description"><?php esc_html_e( 'Upload a file or paste a URL link above.', 'energynet' ); ?></span>
			</td>
		</tr>
		<tr>
			<th><?php esc_html_e( 'Certificate', 'energynet' ); ?></th>
			<td>
				<input type="text" id="_tech_certificate_name" name="_tech_certificate_name" value="<?php echo esc_attr( $certificate_name ); ?>" placeholder="<?php esc_attr_e( 'Display name (optional)', 'energynet' ); ?>" style="width:100%;margin-bottom:6px;">
				<input type="url"  id="_tech_certificate"      name="_tech_certificate"      value="<?php echo esc_attr( $certificate ); ?>"      placeholder="https://" style="width:100%;margin-bottom:6px;">
				<button type="button" id="en-certificate-btn" class="button"><?php esc_html_e( 'Upload / Select File', 'energynet' ); ?></button>
				<button type="button" id="en-certificate-remove" class="button" style="margin-left:4px;<?php echo $certificate ? '' : 'display:none;'; ?>"><?php esc_html_e( 'Remove', 'energynet' ); ?></button>
				<span class="description"><?php esc_html_e( 'Upload a file or paste a URL link above.', 'energynet' ); ?></span>
			</td>
		</tr>
		<tr>
			<th><label for="_tech_data_sheet"><?php esc_html_e( 'Data Sheet', 'energynet' ); ?></label></th>
			<td><input type="url" id="_tech_data_sheet" name="_tech_data_sheet" value="<?php echo esc_attr( $data_sheet ); ?>" placeholder="https://"></td>
		</tr>
		<tr>
			<th><label for="_tech_video"><?php esc_html_e( 'Video URL', 'energynet' ); ?></label></th>
			<td><input type="url" id="_tech_video" name="_tech_video" value="<?php echo esc_attr( $video ); ?>" placeholder="https://"></td>
		</tr>
	</table>

	<script>
	(function($){
		// ── Brochure picker ──
		var frame;
		var $url    = $('#_tech_brochure_url');
		var $name   = $('#_tech_brochure_name');
		var $btn    = $('#en-brochure-btn');
		var $remove = $('#en-brochure-remove');

		$btn.on('click', function(e){
			e.preventDefault();
			if (frame) { frame.open(); return; }
			frame = wp.media({
				title:    '<?php echo esc_js( __( 'Select Brochure File', 'energynet' ) ); ?>',
				button:   { text: '<?php echo esc_js( __( 'Use this file', 'energynet' ) ); ?>' },
				multiple: false
			});
			frame.on('select', function(){
				var attachment = frame.state().get('selection').first().toJSON();
				$url.val(attachment.url);
				if (!$name.val()) $name.val(attachment.filename || attachment.title || '');
				$remove.show();
			});
			frame.open();
		});

		$remove.on('click', function(e){
			e.preventDefault();
			$url.val('');
			$name.val('');
			$remove.hide();
		});

		// Show remove button whenever URL is manually typed
		$url.on('input', function(){
			if ($(this).val()) $remove.show(); else $remove.hide();
		});

		// ── Certificate picker ──
		var certFrame;
		var $certUrl    = $('#_tech_certificate');
		var $certName   = $('#_tech_certificate_name');
		var $certBtn    = $('#en-certificate-btn');
		var $certRemove = $('#en-certificate-remove');

		$certBtn.on('click', function(e){
			e.preventDefault();
			if (certFrame) { certFrame.open(); return; }
			certFrame = wp.media({
				title:    '<?php echo esc_js( __( 'Select Certificate File', 'energynet' ) ); ?>',
				button:   { text: '<?php echo esc_js( __( 'Use this file', 'energynet' ) ); ?>' },
				multiple: false
			});
			certFrame.on('select', function(){
				var attachment = certFrame.state().get('selection').first().toJSON();
				$certUrl.val(attachment.url);
				if (!$certName.val()) $certName.val(attachment.filename || attachment.title || '');
				$certRemove.show();
			});
			certFrame.open();
		});

		$certRemove.on('click', function(e){
			e.preventDefault();
			$certUrl.val('');
			$certName.val('');
			$certRemove.hide();
		});

		// Show remove button whenever URL is manually typed
		$certUrl.on('input', function(){
			if ($(this).val()) $certRemove.show(); else $certRemove.hide();
		});
	}(jQuery));
	</script>
	<?php
}

function energynet_save_product_meta( $post_id ) {
	if ( ! isset( $_POST['energynet_product_nonce'] ) || ! wp_verify_nonce( $_POST['energynet_product_nonce'], 'energynet_save_product_meta' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	if ( wp_is_post_revision( $post_id ) ) return;
	if ( ! current_user_can( 'edit_post', $post_id ) ) return;

	// Brochure: filename + URL
	$brochure_name = isset( $_POST['_tech_brochure_name'] ) ? sanitize_text_field( wp_unslash( $_POST['_tech_brochure_name'] ) ) : '';
	$brochure_url  = isset( $_POST['_tech_brochure_url'] )  ? esc_url_raw( wp_unslash( $_POST['_tech_brochure_url'] ) )          : '';
	update_post_meta( $post_id, '_tech_brochure_name', $brochure_name );
	update_post_meta( $post_id, '_tech_brochure_url',  $brochure_url );

	// Certificate: filename + URL
	$certificate_name = isset( $_POST['_tech_certificate_name'] ) ? sanitize_text_field( wp_unslash( $_POST['_tech_certificate_name'] ) ) : '';
	update_post_meta( $post_id, '_tech_certificate_name', $certificate_name );

	$url_fields = [ '_tech_certificate', '_tech_data_sheet', '_tech_video' ];
	foreach ( $url_fields as $field ) {
		$value = isset( $_POST[ $field ] ) ? esc_url_raw( wp_unslash( $_POST[ $field ] ) ) : '';
		update_post_meta( $post_id, $field, $value );
	}
}
add_action( 'save_post_product', 'energynet_save_product_meta', 10 );

// ─── Brand Logo: enqueue media on taxonomy edit pages ─────────────────────────

function energynet_brand_admin_enqueue( $hook ) {
	global $pagenow, $post;

	// Enqueue media on product edit screen for brochure upload
	if ( ( $hook === 'post.php' || $hook === 'post-new.php' ) && isset( $post ) && $post->post_type === 'product' ) {
		wp_enqueue_media();
	}

	if ( ( $pagenow === 'term.php' || $pagenow === 'edit-tags.php' ) && isset( $_GET['taxonomy'] ) && $_GET['taxonomy'] === 'product_brand' ) {
		wp_enqueue_media();
		wp_add_inline_script( 'jquery-core', energynet_brand_logo_inline_js() );
	}
}
add_action( 'admin_enqueue_scripts', 'energynet_brand_admin_enqueue' );

function energynet_brand_logo_inline_js() {
	return "
jQuery(function($){
	var frame;
	$(document).on('click', '#en-brand-logo-btn', function(e){
		e.preventDefault();
		if (frame) { frame.open(); return; }
		frame = wp.media({
			title:    'Select Brand Logo',
			button:   { text: 'Use this image' },
			multiple: false,
			library:  { type: 'image' }
		});
		frame.on('select', function(){
			var attachment = frame.state().get('selection').first().toJSON();
			$('#_brand_logo_id').val(attachment.id);
			var url = (attachment.sizes && attachment.sizes.thumbnail) ? attachment.sizes.thumbnail.url : attachment.url;
			$('#en-brand-logo-preview').html('<img src=\"' + url + '\" style=\"max-width:150px;max-height:100px;border:1px solid #ddd;margin-top:6px;\">');
			$('#en-brand-logo-remove').show();
		});
		frame.open();
	});
	$(document).on('click', '#en-brand-logo-remove', function(e){
		e.preventDefault();
		$('#_brand_logo_id').val('');
		$('#en-brand-logo-preview').html('');
		$(this).hide();
	});
});
";
}

// ─── Brand Logo: add form fields (edit term page) ─────────────────────────────

function energynet_brand_edit_form_fields( $term ) {
	$logo_id  = get_term_meta( $term->term_id, '_brand_logo_id', true );
	$logo_url = $logo_id ? wp_get_attachment_image_url( (int) $logo_id, 'thumbnail' ) : '';
	?>
	<tr class="form-field">
		<th scope="row"><label for="_brand_logo_id"><?php esc_html_e( 'Brand Logo', 'energynet' ); ?></label></th>
		<td>
			<input type="hidden" id="_brand_logo_id" name="_brand_logo_id" value="<?php echo esc_attr( $logo_id ); ?>">
			<button type="button" id="en-brand-logo-btn" class="button"><?php esc_html_e( 'Select / Change Logo', 'energynet' ); ?></button>
			<button type="button" id="en-brand-logo-remove" class="button" style="<?php echo $logo_id ? '' : 'display:none;'; ?>"><?php esc_html_e( 'Remove', 'energynet' ); ?></button>
			<div id="en-brand-logo-preview">
				<?php if ( $logo_url ) : ?>
					<img src="<?php echo esc_url( $logo_url ); ?>" style="max-width:150px;max-height:100px;border:1px solid #ddd;margin-top:6px;">
				<?php endif; ?>
			</div>
			<p class="description"><?php esc_html_e( 'Upload or select the brand logo image.', 'energynet' ); ?></p>
		</td>
	</tr>
	<?php
}
add_action( 'product_brand_edit_form_fields', 'energynet_brand_edit_form_fields' );

// ─── Brand Logo: add form fields (add new term page) ─────────────────────────

function energynet_brand_add_form_fields() {
	?>
	<div class="form-field">
		<label for="_brand_logo_id"><?php esc_html_e( 'Brand Logo', 'energynet' ); ?></label>
		<input type="hidden" id="_brand_logo_id" name="_brand_logo_id" value="">
		<button type="button" id="en-brand-logo-btn" class="button"><?php esc_html_e( 'Select Logo', 'energynet' ); ?></button>
		<button type="button" id="en-brand-logo-remove" class="button" style="display:none;"><?php esc_html_e( 'Remove', 'energynet' ); ?></button>
		<div id="en-brand-logo-preview"></div>
		<p><?php esc_html_e( 'Upload or select the brand logo image.', 'energynet' ); ?></p>
	</div>
	<?php
}
add_action( 'product_brand_add_form_fields', 'energynet_brand_add_form_fields' );

// ─── Brand Logo: save on edit ─────────────────────────────────────────────────

function energynet_save_brand_logo( $term_id ) {
	if ( ! isset( $_POST['_brand_logo_id'] ) ) return;
	$logo_id = absint( $_POST['_brand_logo_id'] );
	if ( $logo_id ) {
		update_term_meta( $term_id, '_brand_logo_id', $logo_id );
	} else {
		delete_term_meta( $term_id, '_brand_logo_id' );
	}
}
add_action( 'edited_product_brand',  'energynet_save_brand_logo' );
add_action( 'create_product_brand',  'energynet_save_brand_logo' );
