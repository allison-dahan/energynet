<?php
/**
 * Page template for the Products page.
 * Auto-used when the page slug is "products".
 *
 * @package energynet
 */

get_header();

$products_query = new WP_Query( [
	'post_type'      => 'product',
	'posts_per_page' => -1,
	'orderby'        => 'menu_order title',
	'order'          => 'ASC',
] );

// Collect all brand and category terms for filter buttons.
$brand_terms = get_terms( [ 'taxonomy' => 'product_brand',    'hide_empty' => true ] );
$cat_terms   = get_terms( [ 'taxonomy' => 'product_category', 'hide_empty' => true, 'parent' => 0 ] );
?>

<main id="primary" class="site-main">

	<section class="products-intro">
		<div class="container">
			<h1 class="section-heading section-heading--ruled">
				<?php esc_html_e( 'PRODUCTS', 'energynet' ); ?>
			</h1>
		</div>
	</section>

	<?php if ( ( $brand_terms && ! is_wp_error( $brand_terms ) ) || ( $cat_terms && ! is_wp_error( $cat_terms ) ) ) : ?>
	<div class="products-filter" data-products-filter>
		<div class="container">

			<?php if ( $brand_terms && ! is_wp_error( $brand_terms ) ) : ?>
			<div class="products-filter__group">
				<span class="products-filter__label"><?php esc_html_e( 'Brand', 'energynet' ); ?></span>
				<div class="products-filter__buttons">
					<button class="filter-btn is-active" data-filter="brand" data-value="all">
						<?php esc_html_e( 'All', 'energynet' ); ?>
					</button>
					<?php foreach ( $brand_terms as $term ) : ?>
						<button
							class="filter-btn"
							data-filter="brand"
							data-value="<?php echo esc_attr( $term->slug ); ?>"
						>
							<?php echo esc_html( $term->name ); ?>
						</button>
					<?php endforeach; ?>
				</div>
			</div>
			<?php endif; ?>

			<?php if ( $cat_terms && ! is_wp_error( $cat_terms ) ) : ?>
			<div class="products-filter__group">
				<span class="products-filter__label"><?php esc_html_e( 'Category', 'energynet' ); ?></span>
				<div class="products-filter__buttons">
					<button class="filter-btn is-active" data-filter="category" data-value="all">
						<?php esc_html_e( 'All', 'energynet' ); ?>
					</button>
					<?php foreach ( $cat_terms as $term ) : ?>
						<button
							class="filter-btn"
							data-filter="category"
							data-value="<?php echo esc_attr( $term->slug ); ?>"
						>
							<?php echo esc_html( $term->name ); ?>
						</button>
					<?php endforeach; ?>
				</div>
			</div>
			<?php endif; ?>

		</div>
	</div>
	<?php endif; ?>

	<section class="products-grid">
		<div class="container">
			<div class="products-grid__list">
				<?php if ( $products_query->have_posts() ) : ?>
					<?php while ( $products_query->have_posts() ) : $products_query->the_post(); ?>
						<?php get_template_part( 'template-parts/product-card' ); ?>
					<?php endwhile; ?>
					<?php wp_reset_postdata(); ?>
				<?php else : ?>
					<p><?php esc_html_e( 'No products found.', 'energynet' ); ?></p>
				<?php endif; ?>
			</div>
		</div>
	</section>

</main>

<?php get_footer(); ?>
