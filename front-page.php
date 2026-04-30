<?php
/**
 * The front page template
 *
 * @package Energynet
 */

get_header();
?>

<main id="primary" class="site-main">

	<section class="hero">

		<div class="hero__slides" data-hero-carousel>
			<div class="hero__slide is-active" style="background-image:url('<?php echo esc_url( get_template_directory_uri() ); ?>/public/images/home/image_1.png')"></div>
			<div class="hero__slide" style="background-image:url('<?php echo esc_url( get_template_directory_uri() ); ?>/public/images/home/image_2.png')"></div>
			<div class="hero__slide hero__slide--video">
				<video class="hero__video" src="<?php echo esc_url( get_template_directory_uri() ); ?>/dist/images/home/Home page video.mp4" muted loop playsinline></video>
			</div>

			<div class="hero__dots" role="tablist" aria-label="<?php esc_attr_e( 'Hero slides', 'energynet' ); ?>">
				<button class="hero__dot is-active" role="tab" aria-selected="true"  aria-label="<?php esc_attr_e( 'Slide 1', 'energynet' ); ?>"></button>
				<button class="hero__dot"           role="tab" aria-selected="false" aria-label="<?php esc_attr_e( 'Slide 2', 'energynet' ); ?>"></button>
				<button class="hero__dot"           role="tab" aria-selected="false" aria-label="<?php esc_attr_e( 'Slide 3', 'energynet' ); ?>"></button>
			</div>
		</div>

		<div class="hero__content">
			<h1 class="hero__heading"><?php esc_html_e( 'EPITOME OF RESILIENCE', 'Energynet' ); ?></h1>
			<a href="<?php echo esc_url( home_url( '/projects' ) ); ?>" class="hero__btn">
				<?php esc_html_e( 'PROJECTS', 'Energynet' ); ?>
			</a>
		</div>

	</section>

</main>

<?php
get_footer();
