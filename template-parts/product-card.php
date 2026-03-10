<?php
/**
 * Reusable product card component.
 * Must be called inside a WP_Query loop (uses global $post).
 *
 * @package energynet
 */

$post_id     = get_the_ID();
$name        = get_the_title();
$image_url   = get_the_post_thumbnail_url( $post_id, 'large' );
$link_url    = get_permalink();

// Brand slugs — used for JS filter data attribute only.
$brand_slugs = [];
$brand_terms = get_the_terms( $post_id, 'product_brand' );
if ( $brand_terms && ! is_wp_error( $brand_terms ) ) {
	$brand_slugs = wp_list_pluck( $brand_terms, 'slug' );
}

// Category slug — used for JS filter data attribute only.
$category_slug = '';
$cat_terms     = get_the_terms( $post_id, 'product_category' );
if ( $cat_terms && ! is_wp_error( $cat_terms ) ) {
	foreach ( $cat_terms as $term ) {
		if ( $term->parent === 0 ) {
			$category_slug = $term->slug;
		}
	}
}
?>

<article
	class="product-card"
	data-brands="<?php echo esc_attr( implode( ',', $brand_slugs ) ); ?>"
	data-categories="<?php echo esc_attr( $category_slug ); ?>"
>

	<a class="product-card__link" href="<?php echo esc_url( $link_url ); ?>">

		<div class="product-card__image-wrap">
			<?php if ( $image_url ) : ?>
				<img
					class="product-card__image"
					src="<?php echo esc_url( $image_url ); ?>"
					alt="<?php echo esc_attr( $name ); ?>"
					loading="lazy"
				>
			<?php endif; ?>
		</div>

		<span class="product-card__divider" aria-hidden="true"></span>

		<h3 class="product-card__title"><?php echo esc_html( $name ); ?></h3>

	</a>

</article>
