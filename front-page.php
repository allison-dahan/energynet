<?php
/**
 * The front page template
 *
 * @package Energynet
 */

get_header();
?>

<main id="primary" class="site-main">

	<section class="hero" data-hero>

		<div class="hero__bg-wrap">
			<div class="hero__bg is-active" style="background-image: url(<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/hero-1.jpg)"></div>
			<div class="hero__bg" style="background-image: url(<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/hero-2.jpg)"></div>
			<div class="hero__bg" style="background-image: url(<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/hero-3.jpg)"></div>
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
