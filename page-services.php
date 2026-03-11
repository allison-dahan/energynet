<?php
/**
 * Page template for the Services page.
 * Auto-used when the page slug is "services".
 *
 * @package energynet
 */

get_header();

$services_query = new WP_Query( [
	'post_type'      => 'service',
	'posts_per_page' => -1,
	'orderby'        => 'menu_order title',
	'order'          => 'ASC',
] );
?>

<main id="primary" class="site-main">

	<section class="services-intro">
		<div class="container">
			<h1 class="services-intro__title"><?php esc_html_e( 'SERVICES', 'energynet' ); ?></h1>
			<p class="services-intro__subtitle"><?php esc_html_e( 'We offer a variety of services, all completed with consistent quality from start to finish.', 'energynet' ); ?></p>
		</div>
	</section>

	<section class="services-section">
		<div class="container">
			<div class="services-grid">
				<?php if ( $services_query->have_posts() ) : ?>
					<?php while ( $services_query->have_posts() ) : $services_query->the_post(); ?>
						<div class="service-card">
							<div class="service-card__image-wrap">
								<?php if ( has_post_thumbnail() ) : ?>
									<?php the_post_thumbnail( 'large', [
										'class' => 'service-card__image',
										'alt'   => get_the_title(),
									] ); ?>
								<?php else : ?>
									<div class="service-card__image service-card__image--placeholder"></div>
								<?php endif; ?>
							</div>
							<span class="service-card__label"><?php the_title(); ?></span>
						</div>
					<?php endwhile; ?>
					<?php wp_reset_postdata(); ?>
				<?php else : ?>
					<p><?php esc_html_e( 'No services found.', 'energynet' ); ?></p>
				<?php endif; ?>
			</div>
		</div>
	</section>

</main>

<?php get_footer(); ?>
