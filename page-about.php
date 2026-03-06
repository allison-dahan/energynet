<?php
/**
 * Page template for the About page.
 * Auto-used when the page slug is "about".
 *
 * @package energynet
 */

get_header();
?>

<main id="primary" class="site-main">

	<!-- ─── About Us ──────────────────────────────────────────────────────────── -->
	<section class="about-intro">
		<div class="container">
			<h1 class="section-heading">ABOUT US</h1>
		</div>

		<!-- Full-bleed image carousel -->
		<div class="about-carousel" data-about-carousel>
			<div class="about-carousel__track">
				<div class="about-carousel__slide is-active" style="background-image: url(<?php echo esc_url( get_template_directory_uri() . '/dist/images/about/andreas-gucklhorn-Ilpf2eUPpUE-unsplash.jpg' ); ?>)"></div>
				<div class="about-carousel__slide" style="background-image: url(<?php echo esc_url( get_template_directory_uri() . '/dist/images/about/rifki-kurniawan-pO3lCoKJncM-unsplash.jpg' ); ?>)"></div>
				<div class="about-carousel__slide" style="background-image: url(<?php echo esc_url( get_template_directory_uri() . '/dist/images/about/scott-blake-x-ghf9LjrVg-unsplash.jpg' ); ?>)"></div>
				<div class="about-carousel__slide" style="background-image: url(<?php echo esc_url( get_template_directory_uri() . '/dist/images/about/thomas-richter-B09tL5bSQJk-unsplash.jpg' ); ?>)"></div>
			</div>
			<div class="about-carousel__dots" role="tablist" aria-label="<?php esc_attr_e( 'Image slides', 'energynet' ); ?>">
				<button class="about-carousel__dot is-active" role="tab" aria-selected="true"  aria-label="<?php esc_attr_e( 'Slide 1', 'energynet' ); ?>"></button>
				<button class="about-carousel__dot"            role="tab" aria-selected="false" aria-label="<?php esc_attr_e( 'Slide 2', 'energynet' ); ?>"></button>
				<button class="about-carousel__dot"            role="tab" aria-selected="false" aria-label="<?php esc_attr_e( 'Slide 3', 'energynet' ); ?>"></button>
				<button class="about-carousel__dot"            role="tab" aria-selected="false" aria-label="<?php esc_attr_e( 'Slide 4', 'energynet' ); ?>"></button>
			</div>
		</div>

		<div class="container">
			<p class="about-intro__text">Energynet, Inc. has evolved into a dynamic Engineering, Procurement, and Construction (EPC) partner delivering integrated solutions that power modern infrastructure and sustainable development. Built on years of industry expertise, the company now leads projects from concept to completion — combining engineering precision, strategic sourcing, and disciplined construction execution to provide reliable, future-ready results. Beyond EPC execution, Energynet continues to elevate infrastructure through premium lightning protection and grounding solutions, precision-engineered mechanical and electrical supports, advanced wire mesh cable management, and aircraft obstruction lighting systems trusted worldwide. With a multidisciplinary team of engineers, project managers, and technical specialists, Energynet delivers end-to-end solutions across grounding and earthing systems, lightning protection technologies, electrical and mechanical supports, structured cable management, and critical infrastructure applications. The company's EPC approach ensures seamless coordination, technical excellence, and operational efficiency at every stage of the project lifecycle — from design development and procurement strategy to on-site implementation and commissioning — while maintaining strong partnerships with globally recognized brands and advanced engineering solutions.</p>
		</div>
	</section>

	<!-- ─── Services ─────────────────────────────────────────────────────────── -->
	<section class="services">
		<div class="container">
			<h2 class="section-heading section-heading--ruled">SERVICES</h2>
			<div class="services__list">

				<article class="service-card">
					<img src="<?php echo esc_url( get_template_directory_uri() . '/dist/images/about/services/SERVICES ICONS 1.png' ); ?>" alt="" class="service-card__icon" aria-hidden="true">
					<h3 class="service-card__title">LIGHTNING PROTECTION DESIGN &amp; INSTALLATION</h3>
					<p class="service-card__text">Energynet, Inc. offers an in-house design service producing customized direct strike lightning protection using ESE Design Methodology, latest design method for Controlled Streamer Emission system such as Rolling Sphere Method and Collection Volume Method, and full risk assessment in accordance with the relevant standard.</p>
				</article>

				<article class="service-card">
					<img src="<?php echo esc_url( get_template_directory_uri() . '/dist/images/about/services/SERVICES ICONS 2.png' ); ?>" alt="" class="service-card__icon" aria-hidden="true">
					<h3 class="service-card__title">GROUND RESISTANCE TESTING</h3>
					<p class="service-card__text">Once installed, grounding systems must be tested to verify their resistance to earth, using a variety of means including "Fall-of-Potential" or "Clamp-On" testing. EnergyNet, Inc. provides these critical evaluation of services, giving you the peace of mind of knowing that you are truly protected.</p>
				</article>

				<article class="service-card">
					<img src="<?php echo esc_url( get_template_directory_uri() . '/dist/images/about/services/SERVICES ICONS 3.png' ); ?>" alt="" class="service-card__icon" aria-hidden="true">
					<h3 class="service-card__title">GROUNDING SYSTEMS DESIGN AND PREVENTIVE MAINTENANCE</h3>
					<p class="service-card__text">Energynet, Inc. offers an in-house design service producing customized direct strike lightning protection using ESE Design Methodology, latest design method for Controlled Streamer Emission system such as Rolling Sphere Method and Collection Volume Method, and full risk assessment in accordance with the relevant standard.</p>
				</article>

				<article class="service-card">
					<img src="<?php echo esc_url( get_template_directory_uri() . '/dist/images/about/services/SERVICES ICONS 4.png' ); ?>" alt="" class="service-card__icon" aria-hidden="true">
					<h3 class="service-card__title">LIGHTNING PROTECTION AND GROUNDING SYSTEMS PREVENTIVE MAINTENANCE</h3>
					<p class="service-card__text">Once installed, grounding systems must be tested to verify their resistance to earth, using a variety of means including "Fall-of-Potential" or "Clamp-On" testing. EnergyNet, Inc. provides these critical evaluation of services, giving you the peace of mind of knowing that you are truly protected.</p>
				</article>

			</div>
		</div>
	</section>

	<!-- ─── Experience ───────────────────────────────────────────────────────── -->
	<section class="experience">
		<div class="container">
			<div class="experience__stat">
				<span class="experience__number">20</span>
				<span class="experience__label">YEARS OF SERVICE</span>
			</div>
			<p class="experience__text">With over 20 years of proven field experience, we support large-scale construction and industrial developments with dependable engineering solutions built on technical rigor and practical execution. From design coordination to on-site implementation, our team delivers grounded, high-performance systems that enhance safety, operational reliability, and project efficiency. Trusted by contractors, developers, and industrial partners, we bring strength, precision, and consistency to every phase of the build.</p>
		</div>
	</section>

	<!-- ─── Partners ─────────────────────────────────────────────────────────── -->
	<section class="partners">
		<div class="container">
			<h2 class="section-heading section-heading--left">PARTNERS</h2>
			<div class="partners__grid">
				<div class="partner-logo">
					<img src="<?php echo esc_url( get_template_directory_uri() . '/dist/images/about/partners/enistrut logo.png' ); ?>" alt="Enistrut">
				</div>
				<div class="partner-logo">
					<img src="<?php echo esc_url( get_template_directory_uri() . '/dist/images/about/partners/indelec-logo.png' ); ?>" alt="Indelec">
				</div>
				<div class="partner-logo">
					<img src="<?php echo esc_url( get_template_directory_uri() . '/dist/images/about/partners/delta box logo.png' ); ?>" alt="Delta Box">
				</div>
				<div class="partner-logo">
					<img src="<?php echo esc_url( get_template_directory_uri() . '/dist/images/about/partners/Cablofil-logo.JPG' ); ?>" alt="Cablofil">
				</div>
			</div>
			<div class="partners__cta">
				<a href="#" class="btn btn--primary">KNOW MORE ABOUT OUR PARTNERS</a>
			</div>
		</div>
	</section>

	<!-- ─── Clients ──────────────────────────────────────────────────────────── -->
	<section class="clients">
		<div class="container">
			<h2 class="section-heading section-heading--ruled section-heading--sm">CLIENTS</h2>
			<div class="clients__logos">
				<img src="<?php echo esc_url( get_template_directory_uri() . '/dist/images/about/clients/Meralco.jpg' ); ?>" alt="Meralco">
				<img src="<?php echo esc_url( get_template_directory_uri() . '/dist/images/about/clients/Aboitiz.png' ); ?>" alt="Aboitiz">
				<img src="<?php echo esc_url( get_template_directory_uri() . '/dist/images/about/clients/Rockwell Land.png' ); ?>" alt="Rockwell Land">
				<img src="<?php echo esc_url( get_template_directory_uri() . '/dist/images/about/clients/SMDC.png' ); ?>" alt="SMDC">
			</div>
			<div class="section-divider"></div>
		</div>
	</section>

	<!-- ─── Certifications ───────────────────────────────────────────────────── -->
	<section class="certifications">
		<div class="container">
			<h2 class="section-heading section-heading--sm">CERTIFICATIONS</h2>
			<div class="certifications__grid">
				<div class="cert-item">
					<img src="<?php echo esc_url( get_template_directory_uri() . '/dist/images/about/certifications/duns_registered_logo.png' ); ?>" alt="DUNS Registered">
				</div>
				<div class="cert-item">
					<img src="<?php echo esc_url( get_template_directory_uri() . '/dist/images/about/certifications/pcab_category_d_license.png' ); ?>" alt="PCAB Category D License">
				</div>
			</div>
		</div>
	</section>

	<!-- ─── Partner modal (mobile only) ─────────────────────────────────────── -->
	<div class="partner-modal" id="partner-modal" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'Partner details', 'energynet' ); ?>" aria-hidden="true">
		<div class="partner-modal__panel">
			<div class="partner-modal__header">
				<span class="partner-modal__label">PARTNERS</span>
				<button class="partner-modal__close" aria-label="<?php esc_attr_e( 'Close', 'energynet' ); ?>">
					<svg width="20" height="20" viewBox="0 0 24 24" fill="none" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/><line x1="6" y1="6" x2="18" y2="18" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/></svg>
				</button>
			</div>
			<div class="partner-modal__body">
				<div class="partner-modal__logo-row">
					<button class="partner-modal__arrow partner-modal__arrow--prev" aria-label="<?php esc_attr_e( 'Previous partner', 'energynet' ); ?>">
						<svg width="12" height="22" viewBox="0 0 12 22" fill="none" aria-hidden="true"><path d="M10 2L2 11L10 20" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
					</button>
					<div class="partner-modal__frame">
						<img class="partner-modal__logo" src="" alt="">
					</div>
					<button class="partner-modal__arrow partner-modal__arrow--next" aria-label="<?php esc_attr_e( 'Next partner', 'energynet' ); ?>">
						<svg width="12" height="22" viewBox="0 0 12 22" fill="none" aria-hidden="true"><path d="M2 2L10 11L2 20" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
					</button>
				</div>
				<div class="partner-modal__divider"></div>
				<p class="partner-modal__text"></p>
			</div>
		</div>
	</div>

</main>

<?php get_footer(); ?>
