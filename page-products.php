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

// Collect all brand and category terms for sidebar and filter overlay.
$brand_terms = get_terms( [ 'taxonomy' => 'product_brand',    'hide_empty' => true ] );
$cat_terms   = get_terms( [ 'taxonomy' => 'product_category', 'hide_empty' => true, 'parent' => 0 ] );

$has_filters = ( $brand_terms && ! is_wp_error( $brand_terms ) ) || ( $cat_terms && ! is_wp_error( $cat_terms ) );
?>

<main id="primary" class="site-main">

	<section class="products-intro">
		<div class="container">
			<h1 class="products-title"><?php esc_html_e( 'Our Products', 'energynet' ); ?></h1>

			<?php if ( $has_filters ) : ?>
			<button
				class="products-filter-toggle"
				data-filter-open
				aria-label="<?php esc_attr_e( 'Filter products', 'energynet' ); ?>"
			>
				<iconify-icon icon="ph:squares-four" width="16" height="16"></iconify-icon>
			</button>
			<?php endif; ?>
		</div>
	</section>

	<div class="products-layout">
		<div class="container products-layout__inner">

			<?php // ─── Desktop sidebar ────────────────────────────────────────── ?>
			<?php if ( $has_filters ) : ?>
			<aside class="products-sidebar">

				<div class="products-sidebar__search-wrap">
					<input
						class="products-sidebar__search"
						type="text"
						placeholder="<?php esc_attr_e( 'Search products...', 'energynet' ); ?>"
						data-sidebar-search
					>
					<iconify-icon class="products-sidebar__search-icon" icon="mdi:magnify" width="20" height="20"></iconify-icon>
				</div>

				<?php if ( $cat_terms && ! is_wp_error( $cat_terms ) ) : ?>
				<div class="products-sidebar__panel">
					<h3 class="products-sidebar__heading"><?php esc_html_e( 'Product Categories', 'energynet' ); ?></h3>
					<ul class="products-sidebar__list">
						<li>
							<button class="products-sidebar__item is-active" data-filter="category" data-value="all">
								<?php esc_html_e( 'All Categories', 'energynet' ); ?>
							</button>
						</li>
						<?php foreach ( $cat_terms as $term ) : ?>
						<li>
							<button class="products-sidebar__item" data-filter="category" data-value="<?php echo esc_attr( $term->slug ); ?>">
								<?php echo esc_html( $term->name ); ?>
							</button>
						</li>
						<?php endforeach; ?>
					</ul>
				</div>
				<?php endif; ?>

				<?php if ( $brand_terms && ! is_wp_error( $brand_terms ) ) : ?>
				<h3 class="products-sidebar__brand-heading"><?php esc_html_e( 'Search product by Brand', 'energynet' ); ?></h3>
				<div class="products-sidebar__brands">
					<?php foreach ( $brand_terms as $term ) :
						$logo_url = '';
						if ( function_exists( 'get_field' ) ) {
							$logo = get_field( 'brand_logo', 'product_brand_' . $term->term_id );
							if ( $logo ) {
								$logo_url = is_array( $logo ) ? ( $logo['url'] ?? '' ) : $logo;
							}
						}
					?>
					<button
						class="products-sidebar__brand"
						data-filter="brand"
						data-value="<?php echo esc_attr( $term->slug ); ?>"
					>
						<?php if ( $logo_url ) : ?>
							<img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php echo esc_attr( $term->name ); ?>">
						<?php else : ?>
							<?php echo esc_html( $term->name ); ?>
						<?php endif; ?>
					</button>
					<?php endforeach; ?>
				</div>
				<?php endif; ?>

			</aside>
			<?php endif; ?>

			<?php // ─── Product grid ────────────────────────────────────────────── ?>
			<div class="products-grid">
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

		</div>
	</div>

	<?php // ─── Filter overlay (mobile only) ────────────────────────────────────── ?>
	<?php if ( $has_filters ) : ?>
	<div class="filter-overlay" data-filter-overlay aria-hidden="true">

		<div class="filter-overlay__top">
			<button
				class="filter-overlay__close"
				data-filter-close
				aria-label="<?php esc_attr_e( 'Close filters', 'energynet' ); ?>"
			>
				<iconify-icon icon="mdi:close" width="24" height="24"></iconify-icon>
			</button>
		</div>

		<div class="filter-overlay__content">

			<div class="filter-overlay__search-wrap">
				<input
					class="filter-overlay__search"
					type="text"
					placeholder="<?php esc_attr_e( 'Search products...', 'energynet' ); ?>"
					data-filter-search
				>
				<iconify-icon class="filter-overlay__search-icon" icon="mdi:magnify" width="20" height="20"></iconify-icon>
			</div>

			<div class="filter-overlay__card">

				<?php if ( $cat_terms && ! is_wp_error( $cat_terms ) ) : ?>
				<div class="filter-overlay__section">
					<h3 class="filter-overlay__heading"><?php esc_html_e( 'Product Categories', 'energynet' ); ?></h3>
					<ul class="filter-overlay__list">
						<li>
							<button class="filter-overlay__item is-active" data-filter="category" data-value="all">
								<?php esc_html_e( 'All Categories', 'energynet' ); ?>
							</button>
						</li>
						<?php foreach ( $cat_terms as $term ) : ?>
						<li>
							<button class="filter-overlay__item" data-filter="category" data-value="<?php echo esc_attr( $term->slug ); ?>">
								<?php echo esc_html( $term->name ); ?>
							</button>
						</li>
						<?php endforeach; ?>
					</ul>
				</div>
				<?php endif; ?>

				<?php if ( $brand_terms && ! is_wp_error( $brand_terms ) ) : ?>
				<div class="filter-overlay__section">
					<h3 class="filter-overlay__heading"><?php esc_html_e( 'Search product by brand', 'energynet' ); ?></h3>
					<div class="filter-overlay__brands">
						<?php foreach ( $brand_terms as $term ) :
							$logo_url = '';
							if ( function_exists( 'get_field' ) ) {
								$logo = get_field( 'brand_logo', 'product_brand_' . $term->term_id );
								if ( $logo ) {
									$logo_url = is_array( $logo ) ? ( $logo['url'] ?? '' ) : $logo;
								}
							}
						?>
						<button
							class="filter-overlay__brand"
							data-filter="brand"
							data-value="<?php echo esc_attr( $term->slug ); ?>"
						>
							<?php if ( $logo_url ) : ?>
								<img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php echo esc_attr( $term->name ); ?>">
							<?php else : ?>
								<?php echo esc_html( $term->name ); ?>
							<?php endif; ?>
						</button>
						<?php endforeach; ?>
					</div>
				</div>
				<?php endif; ?>

			</div><!-- .filter-overlay__card -->

		</div><!-- .filter-overlay__content -->

	</div><!-- .filter-overlay -->
	<?php endif; ?>

</main>

<?php get_footer(); ?>
