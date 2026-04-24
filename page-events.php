<?php
/**
 * Page template for the Events page.
 * Auto-used when the page slug is "events".
 *
 * @package energynet
 */

get_header();
?>

<main id="primary" class="site-main">

	<!-- ─── Page heading ─────────────────────────────────────────────────────── -->
	<section class="events-intro">
		<div class="container">
			<h1 class="section-heading">EVENTS</h1>
		</div>
		<div class="events-hero">
			<img
				src="<?php echo esc_url( get_template_directory_uri() . '/dist/images/events/events-hero.jpg' ); ?>"
				alt="<?php esc_attr_e( 'Events', 'energynet' ); ?>"
				class="events-hero__img"
			>
		</div>
	</section>

	<!-- ─── Events list ──────────────────────────────────────────────────────── -->
	<section class="events-list">
		<div class="container">

			<!-- ── Event 1: text left / image right ── -->
			<article class="event-item event-item--text-image">
				<div class="event-item__content">
					<h2 class="event-item__title">2026 METRO CENTRAL CONFERENCE</h2>
					<p class="event-item__date">APRIL 30, 2026 via ZOOM</p>
					<p class="event-item__desc">Risk Assessment Analysis of Lightning Protection System NFPA 780</p>
					<p class="event-item__speaker">ENGR. IVAN BOSCH MENDOZA, Energynet Inc., Engineering Manager</p>
				</div>
				<div class="event-item__photos">
					<a
						href="<?php echo esc_url( get_template_directory_uri() . '/dist/images/events/metro-central-conference.jpg' ); ?>"
						class="event-item__photo-link"
						data-lightbox
						aria-label="<?php esc_attr_e( 'View Metro Central Conference image full size', 'energynet' ); ?>"
					>
						<img
							src="<?php echo esc_url( get_template_directory_uri() . '/dist/images/events/metro-central-conference.jpg' ); ?>"
							alt="<?php esc_attr_e( 'Metro Central Conference flyer', 'energynet' ); ?>"
							class="event-item__photo event-item__photo--portrait"
						>
					</a>
				</div>
			</article>

			<hr class="events-divider" aria-hidden="true">

			<!-- ── Event 2: centered header / images side by side ── -->
			<article class="event-item event-item--centered">
				<div class="event-item__content">
					<h2 class="event-item__title">SOLAR &amp; STORAGE LIVE PHILIPPINES 2026</h2>
					<p class="event-item__date">MAY 19-20, 2026</p>
					<p class="event-item__venue">SMX CONVENTION CENTER MANILA</p>
				</div>
				<div class="event-item__photos">
					<a
						href="<?php echo esc_url( get_template_directory_uri() . '/dist/images/events/solar-storage-p1.jpg' ); ?>"
						class="event-item__photo-link"
						data-lightbox
						aria-label="<?php esc_attr_e( 'View Solar & Storage Live Philippines image 1 full size', 'energynet' ); ?>"
					>
						<img
							src="<?php echo esc_url( get_template_directory_uri() . '/dist/images/events/solar-storage-p1.jpg' ); ?>"
							alt="<?php esc_attr_e( 'Solar & Storage Live Philippines 2026 - Plan Your Visit', 'energynet' ); ?>"
							class="event-item__photo event-item__photo--square"
						>
					</a>
					<a
						href="<?php echo esc_url( get_template_directory_uri() . '/dist/images/events/solar-storage-p2.jpg' ); ?>"
						class="event-item__photo-link"
						data-lightbox
						aria-label="<?php esc_attr_e( 'View Solar & Storage Live Philippines image 2 full size', 'energynet' ); ?>"
					>
						<img
							src="<?php echo esc_url( get_template_directory_uri() . '/dist/images/events/solar-storage-p2.jpg' ); ?>"
							alt="<?php esc_attr_e( 'Solar & Storage Live Philippines 2026 - Exhibitor categories', 'energynet' ); ?>"
							class="event-item__photo event-item__photo--square"
						>
					</a>
				</div>
			</article>

			<hr class="events-divider" aria-hidden="true">

			<!-- ── Event 3: image left / text right ── -->
			<article class="event-item event-item--image-text">
				<div class="event-item__photos">
					<a
						href="<?php echo esc_url( get_template_directory_uri() . '/dist/images/events/iiee-convention.jpg' ); ?>"
						class="event-item__photo-link"
						data-lightbox
						aria-label="<?php esc_attr_e( 'View IIEE 51st Annual National Convention image full size', 'energynet' ); ?>"
					>
						<img
							src="<?php echo esc_url( get_template_directory_uri() . '/dist/images/events/iiee-convention.jpg' ); ?>"
							alt="<?php esc_attr_e( 'IIEE 51st Annual National Convention', 'energynet' ); ?>"
							class="event-item__photo event-item__photo--landscape"
						>
					</a>
				</div>
				<div class="event-item__content">
					<h2 class="event-item__title">51<sup>st</sup> Annual National Convention 2026</h2>
					<p class="event-item__org">Institute of Integrated Electrical Engineers of the Philippines, Inc.</p>
					<p class="event-item__date">NOVEMBER 22-28, 2026</p>
					<p class="event-item__venue">SMX CONVENTION CENTER MANILA</p>
				</div>
			</article>

		</div>
	</section>

</main>

<!-- ─── Lightbox overlay ──────────────────────────────────────────────────────── -->
<div id="events-lightbox" class="events-lightbox" aria-hidden="true" aria-modal="true" role="dialog" aria-label="<?php esc_attr_e( 'Image lightbox', 'energynet' ); ?>">
	<button class="events-lightbox__close" aria-label="<?php esc_attr_e( 'Close', 'energynet' ); ?>">
		<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
			<path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
		</svg>
	</button>
	<img class="events-lightbox__img" src="" alt="">
</div>

<?php get_footer(); ?>
