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

		<video
			class="hero__video"
			src="<?php echo esc_url( get_template_directory_uri() ); ?>/dist/images/home/Home page video.mp4"
			autoplay
			muted
			loop
			playsinline
		></video>

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
