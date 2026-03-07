<?php
/**
 * Reusable product card component.
 * Must be called inside a WP_Query loop (uses global $post).
 *
 * Fields:
 *   - Title:           post title
 *   - Image:           featured image
 *   - Description:     post excerpt
 *   - Brand:           "product_brand" taxonomy terms
 *   - Category:        parent term in "product_category" taxonomy
 *   - Sub-category:    child term in "product_category" taxonomy
 *   - Tech files:      ACF fields tech_file_1–3 (label + file upload)
 *   - Video:           ACF field "product_video"
 *
 * @package energynet
 */

$post_id     = get_the_ID();
$name        = get_the_title();
$description = get_the_excerpt();
$image_url   = get_the_post_thumbnail_url( $post_id, 'large' );
$link_url    = get_permalink();

// Brand from taxonomy.
$brand_name  = '';
$brand_slugs = [];
$brand_terms = get_the_terms( $post_id, 'product_brand' );
if ( $brand_terms && ! is_wp_error( $brand_terms ) ) {
	$brand_name  = $brand_terms[0]->name;
	$brand_slugs = wp_list_pluck( $brand_terms, 'slug' );
}

// Technical information files.
$tech_rows = [];
if ( function_exists( 'get_field' ) ) {
	foreach ( [
		'Brochure'    => 'tech_brochure',
		'Certificate' => 'tech_certificate',
		'Data Sheet'  => 'tech_data_sheet',
	] as $label => $field_name ) {
		$url = get_field( $field_name );
		if ( $url ) {
			$tech_rows[] = [ 'tech_file_label' => $label, 'tech_file_upload' => $url ];
		}
	}
}

// Separate parent (category) and child (sub-category) terms.
$category      = '';
$category_slug = '';
$sub_category  = '';
$cat_terms     = get_the_terms( $post_id, 'product_category' );
if ( $cat_terms && ! is_wp_error( $cat_terms ) ) {
	foreach ( $cat_terms as $term ) {
		if ( $term->parent === 0 ) {
			$category      = $term->name;
			$category_slug = $term->slug;
		} else {
			$sub_category = $term->name;
		}
	}
}

// Data attributes for JS filtering.
$data_brands     = esc_attr( implode( ',', $brand_slugs ) );
$data_categories = esc_attr( $category_slug );
?>

<article
	class="product-card"
	data-brands="<?php echo $data_brands; ?>"
	data-categories="<?php echo $data_categories; ?>"
>

	<?php if ( $image_url ) : ?>
		<div class="product-card__image-wrap">
			<img
				class="product-card__image"
				src="<?php echo esc_url( $image_url ); ?>"
				alt="<?php echo esc_attr( $name ); ?>"
				loading="lazy"
			>
		</div>
	<?php endif; ?>

	<div class="product-card__body">

		<?php if ( $brand_name ) : ?>
			<span class="product-card__brand"><?php echo esc_html( $brand_name ); ?></span>
		<?php endif; ?>

		<?php if ( $name ) : ?>
			<h3 class="product-card__title"><?php echo esc_html( $name ); ?></h3>
		<?php endif; ?>

		<?php if ( $category || $sub_category ) : ?>
			<div class="product-card__tags">
				<?php if ( $category ) : ?>
					<span class="product-card__tag"><?php echo esc_html( $category ); ?></span>
				<?php endif; ?>
				<?php if ( $sub_category ) : ?>
					<span class="product-card__tag product-card__tag--sub"><?php echo esc_html( $sub_category ); ?></span>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<?php if ( $description ) : ?>
			<p class="product-card__text"><?php echo esc_html( $description ); ?></p>
		<?php endif; ?>

		<?php if ( $tech_rows ) : ?>
			<ul class="product-card__tech-files">
				<?php foreach ( $tech_rows as $row ) : ?>
					<?php
					$label = $row['tech_file_label']  ?? '';
					$url   = $row['tech_file_upload']  ?? '';
					if ( ! $url ) continue;
					?>
					<li>
						<a
							class="product-card__tech-link"
							href="<?php echo esc_url( $url ); ?>"
							target="_blank"
							rel="noopener noreferrer"
						>
							<?php echo esc_html( $label ?: basename( $url ) ); ?>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>

		<a href="<?php echo esc_url( $link_url ); ?>" class="btn btn--primary product-card__cta">
			<?php esc_html_e( 'VIEW MORE', 'energynet' ); ?>
		</a>

	</div>

</article>
