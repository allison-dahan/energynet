<?php
/**
 * Page template for the Innovation page.
 * Auto-used when the page slug is "innovation".
 *
 * @package energynet
 */

get_header();
?>

<main id="primary" class="site-main">

	<!-- ─── Research & Development ──────────────────────────────────────────── -->
	<section class="inno-rd">
		<div class="container">

			<p class="inno-label">
				<span class="inno-label__poly" aria-hidden="true"></span>
				<?php esc_html_e( 'RESEARCH AND DEVELOPMENT', 'energynet' ); ?>
			</p>

			<h1 class="inno-heading">
				<?php esc_html_e( 'Innovation is part of Indelec DNA for more than 60 years', 'energynet' ); ?>
			</h1>

			<p class="inno-intro">
				<?php esc_html_e( 'Innovate, develop and test the safest and most reliable lightning protection solutions.', 'energynet' ); ?>
			</p>

		</div>
	</section>

	<!-- ─── Early Streamer Emission ─────────────────────────────────────────── -->
	<section class="inno-ese">
		<div class="container">

			<p class="inno-label">
				<span class="inno-label__poly" aria-hidden="true"></span>
				<?php esc_html_e( 'EARLY STREAMER EMISSION', 'energynet' ); ?>
			</p>

			<h2 class="inno-heading">
				<?php esc_html_e( 'Innovative lightning protection solutions', 'energynet' ); ?>
			</h2>

			<p class="inno-body inno-body--medium">
				<?php esc_html_e( 'Specialized since 1955 in manufacturing and installing lightning protection systems, the company introduced in the early 80\'s a revolutionary technology: the Early Streamer Emission Prevectron® air terminals.', 'energynet' ); ?>
			</p>

			<p class="inno-body">
				<?php esc_html_e( 'It became the main lightning protection technology alongside the common "Meshed Cages" design. INDELEC files several patent applications every year and it is now pioneering the integration of new communication technologies into lightning protection systems.', 'energynet' ); ?>
			</p>

			<div class="inno-img inno-img--portrait">
				<img
					src="<?php echo esc_url( get_template_directory_uri() . '/dist/images/innovation/innovation1.png' ); ?>"
					alt="<?php esc_attr_e( 'Prevectron lightning protection device', 'energynet' ); ?>"
				>
			</div>

			<a href="#" class="inno-btn">
				<?php esc_html_e( 'Prevectron3® CONNECT', 'energynet' ); ?>
			</a>

		</div>
	</section>

	<!-- ─── Test Campaigns & Certifications ──────────────────────────────────── -->
	<section class="inno-test">
		<div class="container">

			<p class="inno-label">
				<span class="inno-label__poly" aria-hidden="true"></span>
				<?php esc_html_e( 'TEST CAMPAIGNS & CERTIFICATIONS', 'energynet' ); ?>
			</p>

			<h2 class="inno-heading">
				<?php esc_html_e( 'Fully Certified Products', 'energynet' ); ?>
			</h2>

			<p class="inno-body">
				<?php esc_html_e( 'Thanks to this ongoing research process, INDELEC has developed the most reliable and safest range of lightning air terminals. Besides its unique High Voltage Laboratory, INDELEC has been heavily investing into real lightning test campaigns since 1993. Following campaigns in Florida, Japan, or Brazil, research campaigns were conducted on a new test site in Indonesia, a major lighting prone area in the world.', 'energynet' ); ?>
			</p>

			<p class="inno-body inno-body--medium">
				<?php esc_html_e( 'Each and every INDELEC product development benefits from these research equipment and in situ validation, for optimum performance.', 'energynet' ); ?>
			</p>

			<div class="inno-img inno-img--landscape">
				<img
					src="<?php echo esc_url( get_template_directory_uri() . '/dist/images/innovation/innovation2.png' ); ?>"
					alt="<?php esc_attr_e( 'Lightning protection test campaign', 'energynet' ); ?>"
				>
			</div>

			<p class="inno-body">
				<?php esc_html_e( 'The full range of products is certified either by independent third party auditor: Bureau Veritas for the Quality Certificate ISO 9001 and the lightning air terminals tests in compliance with the NF C 17 102: 2011 Annex C. These review and certification processes guarantee the quality of the manufacture and installation of INDELEC Lightning Protection Systems as well as their full compliance to standard requirements.', 'energynet' ); ?>
			</p>

		</div>
	</section>

	<!-- ─── Discover More ────────────────────────────────────────────────────── -->
	<section class="inno-discover">
		<div class="container">

			<p class="inno-label">
				<span class="inno-label__poly" aria-hidden="true"></span>
				<?php esc_html_e( 'DISCOVER MORE', 'energynet' ); ?>
			</p>

			<h2 class="inno-heading">
				<?php esc_html_e( 'Find more on Indelec innovations', 'energynet' ); ?>
			</h2>

			<div class="inno-cards">

				<a href="<?php echo esc_url( home_url( '/products' ) ); ?>" class="inno-card">
					<div class="inno-card__icon">
						<img src="<?php echo esc_url( get_template_directory_uri() . '/dist/images/innovation/discover-products.png' ); ?>" alt="">
					</div>
					<p class="inno-card__label"><?php esc_html_e( 'Our Products', 'energynet' ); ?></p>
				</a>

				<a href="#" class="inno-card">
					<div class="inno-card__icon">
						<img src="<?php echo esc_url( get_template_directory_uri() . '/dist/images/innovation/discover-liri.png' ); ?>" alt="">
					</div>
					<p class="inno-card__label"><?php esc_html_e( 'Indelec member of LiRi', 'energynet' ); ?></p>
				</a>

				<a href="#" class="inno-card">
					<div class="inno-card__icon">
						<img src="<?php echo esc_url( get_template_directory_uri() . '/dist/images/innovation/discover-news.png' ); ?>" alt="">
					</div>
					<p class="inno-card__label"><?php esc_html_e( 'News', 'energynet' ); ?></p>
				</a>

				<a href="#" class="inno-card">
					<div class="inno-card__icon">
						<img src="<?php echo esc_url( get_template_directory_uri() . '/dist/images/innovation/discover-standards.png' ); ?>" alt="">
					</div>
					<p class="inno-card__label"><?php esc_html_e( 'Lightning Standards', 'energynet' ); ?></p>
				</a>

			</div>

		</div>
	</section>

</main>

<?php get_footer(); ?>
