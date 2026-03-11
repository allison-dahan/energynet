<?php
/**
 * Page template for the FAQs page.
 * Auto-used when the page slug is "faqs".
 *
 * @package energynet
 */

get_header();

// Hero image: use the page's featured image if set.
$hero_img = get_the_post_thumbnail_url( get_the_ID(), 'full' );
?>

<main id="primary" class="site-main">

	<!-- ─── Hero ────────────────────────────────────────────────────────────────── -->
	<section class="contact-hero">
		<div
			class="contact-hero__image"
			<?php if ( $hero_img ) : ?>
				style="background-image: url(<?php echo esc_url( $hero_img ); ?>)"
			<?php endif; ?>
		>
			<div class="contact-hero__buttons">
				<a href="<?php echo esc_url( get_permalink( get_page_by_path( 'contact' ) ) ); ?>" class="contact-hero__btn contact-hero__btn--outline">
					<?php esc_html_e( 'CONTACT US', 'energynet' ); ?>
				</a>
				<a href="<?php echo esc_url( get_permalink( get_page_by_path( 'request-a-quote' ) ) ); ?>" class="contact-hero__btn contact-hero__btn--outline">
					<?php esc_html_e( 'REQUEST A QUOTE', 'energynet' ); ?>
				</a>
				<a href="#faq-content" class="contact-hero__btn contact-hero__btn--filled">
					<?php esc_html_e( 'FAQs', 'energynet' ); ?>
				</a>
			</div>
		</div>
	</section>

	<!-- ─── FAQ content ───────────────────────────────────────────────────────────── -->
	<section class="faq-section" id="faq-content">
		<div class="container">

			<div class="faq-intro">
				<h1 class="faq-intro__title"><?php esc_html_e( 'FREQUENTLY ASKED QUESTIONS', 'energynet' ); ?></h1>
				<p class="faq-intro__subtitle"><?php esc_html_e( "Need more information? Contact us and we'll get back to you shortly.", 'energynet' ); ?></p>
			</div>

			<div class="faq-list">

				<div class="faq-item">
					<h2 class="faq-item__question"><?php esc_html_e( 'Why should I invest in a lightning protection system now?', 'energynet' ); ?></h2>
					<div class="faq-item__answer">
						<p><?php esc_html_e( "Lightning damage isn't just rare accidents — it can mean downtime, costly repairs, data loss, and safety risks. A professionally engineered lightning protection system safeguards your building, equipment, and people by safely directing high-energy strikes into the ground. Don't wait for damage to happen. Prevention is always more affordable than recovery.", 'energynet' ); ?></p>
					</div>
				</div>

				<div class="faq-item">
					<h2 class="faq-item__question"><?php esc_html_e( 'What components are included in a complete lightning protection system?', 'energynet' ); ?></h2>
					<div class="faq-item__answer">
						<p><?php esc_html_e( 'A standard system typically includes:', 'energynet' ); ?></p>
						<ul>
							<li><?php esc_html_e( 'Air terminals (lightning rods)', 'energynet' ); ?></li>
							<li><?php esc_html_e( 'Down conductors', 'energynet' ); ?></li>
							<li><?php esc_html_e( 'Grounding/earthing system', 'energynet' ); ?></li>
							<li><?php esc_html_e( 'Surge protection devices (SPDs)', 'energynet' ); ?></li>
							<li><?php esc_html_e( 'Bonding system', 'energynet' ); ?></li>
						</ul>
						<p><?php esc_html_e( 'Each component works together to safely capture, conduct, and dissipate lightning energy into the earth.', 'energynet' ); ?></p>
					</div>
				</div>

				<div class="faq-item">
					<h2 class="faq-item__question"><?php esc_html_e( 'What exactly do you provide?', 'energynet' ); ?></h2>
					<div class="faq-item__answer">
						<p><?php esc_html_e( 'We deliver complete, end-to-end protection solutions, including:', 'energynet' ); ?></p>
						<ul>
							<li><?php esc_html_e( 'Risk assessment & engineering design', 'energynet' ); ?></li>
							<li><?php esc_html_e( 'Supply of certified lightning protection materials', 'energynet' ); ?></li>
							<li><?php esc_html_e( 'Professional installation', 'energynet' ); ?></li>
							<li><?php esc_html_e( 'Grounding and earthing systems', 'energynet' ); ?></li>
							<li><?php esc_html_e( 'Surge protection integration', 'energynet' ); ?></li>
							<li><?php esc_html_e( 'Testing, certification, and maintenance', 'energynet' ); ?></li>
						</ul>
						<p><?php esc_html_e( "From design to installation — we handle everything so you don't have to.", 'energynet' ); ?></p>
					</div>
				</div>

				<div class="faq-item">
					<h2 class="faq-item__question"><?php esc_html_e( 'Is my building at risk?', 'energynet' ); ?></h2>
					<div class="faq-item__answer">
						<p><?php esc_html_e( 'If your facility has any of these, protection is highly recommended:', 'energynet' ); ?></p>
						<ul>
							<li><?php esc_html_e( 'High-rise or exposed structures', 'energynet' ); ?></li>
							<li><?php esc_html_e( 'Warehouses & industrial facilities', 'energynet' ); ?></li>
							<li><?php esc_html_e( 'Hospitals, schools, offices', 'energynet' ); ?></li>
							<li><?php esc_html_e( 'Telecom towers or data centers', 'energynet' ); ?></li>
							<li><?php esc_html_e( 'Sensitive electrical equipment', 'energynet' ); ?></li>
						</ul>
						<p><?php esc_html_e( 'Not sure? We can perform a quick risk evaluation to determine your level of exposure. Book your FREE site consultation today.', 'energynet' ); ?></p>
					</div>
				</div>

				<div class="faq-item">
					<h2 class="faq-item__question"><?php esc_html_e( 'How do I know if my grounding system is failing?', 'energynet' ); ?></h2>
					<div class="faq-item__answer">
						<p><?php esc_html_e( 'Warning signs include:', 'energynet' ); ?></p>
						<ul>
							<li><?php esc_html_e( 'Frequent equipment damage', 'energynet' ); ?></li>
							<li><?php esc_html_e( 'Electrical noise or unstable power', 'energynet' ); ?></li>
							<li><?php esc_html_e( 'Static shocks', 'energynet' ); ?></li>
							<li><?php esc_html_e( 'Failed inspections', 'energynet' ); ?></li>
						</ul>
						<p><?php esc_html_e( 'If you notice these, your grounding system may already be compromised. Schedule a professional testing service today.', 'energynet' ); ?></p>
					</div>
				</div>

				<div class="faq-item">
					<h2 class="faq-item__question"><?php esc_html_e( 'Can you upgrade or retrofit an existing building?', 'energynet' ); ?></h2>
					<div class="faq-item__answer">
						<p><?php esc_html_e( 'Yes. Whether your facility is new or decades old, we create custom retrofit solutions that enhance safety without major structural changes. Your current building can still achieve modern lightning protection standards.', 'energynet' ); ?></p>
					</div>
				</div>

				<div class="faq-item">
					<h2 class="faq-item__question"><?php esc_html_e( 'Do you conduct soil resistivity testing before installation?', 'energynet' ); ?></h2>
					<div class="faq-item__answer">
						<p><?php esc_html_e( 'Yes. Soil resistivity testing is critical for accurate grounding design. We use the Wenner 4-point method to determine:', 'energynet' ); ?></p>
						<ul>
							<li><?php esc_html_e( 'Soil resistivity profile (Ω·m)', 'energynet' ); ?></li>
							<li><?php esc_html_e( 'Layered soil conditions', 'energynet' ); ?></li>
							<li><?php esc_html_e( 'Required electrode depth and configuration', 'energynet' ); ?></li>
							<li><?php esc_html_e( 'Feasibility of chemical or deep-driven electrodes', 'energynet' ); ?></li>
						</ul>
						<p><?php esc_html_e( 'This ensures cost-efficient and technically sound grounding solutions.', 'energynet' ); ?></p>
					</div>
				</div>

				<div class="faq-item">
					<h2 class="faq-item__question"><?php esc_html_e( 'Can you support large-scale industrial or infrastructure projects?', 'energynet' ); ?></h2>
					<div class="faq-item__answer">
						<p><?php esc_html_e( 'Absolutely. We support:', 'energynet' ); ?></p>
						<ul>
							<li><?php esc_html_e( 'Industrial plants', 'energynet' ); ?></li>
							<li><?php esc_html_e( 'Oil & gas facilities', 'energynet' ); ?></li>
							<li><?php esc_html_e( 'Power substations', 'energynet' ); ?></li>
							<li><?php esc_html_e( 'Manufacturing facilities', 'energynet' ); ?></li>
							<li><?php esc_html_e( 'Warehouses & logistics hubs', 'energynet' ); ?></li>
							<li><?php esc_html_e( 'Data centers', 'energynet' ); ?></li>
							<li><?php esc_html_e( 'Commercial high-rise buildings', 'energynet' ); ?></li>
						</ul>
						<p><?php esc_html_e( 'We work directly with EPC contractors, MEP consultants, and project management teams.', 'energynet' ); ?></p>
					</div>
				</div>

				<div class="faq-item">
					<h2 class="faq-item__question"><?php esc_html_e( 'Do you provide grounding system testing and certification?', 'energynet' ); ?></h2>
					<div class="faq-item__answer">
						<p><?php esc_html_e( 'Yes. We perform:', 'energynet' ); ?></p>
						<ul>
							<li><?php esc_html_e( 'Fall-of-potential testing', 'energynet' ); ?></li>
							<li><?php esc_html_e( 'Clamp-on ground resistance testing', 'energynet' ); ?></li>
							<li><?php esc_html_e( 'Continuity testing', 'energynet' ); ?></li>
							<li><?php esc_html_e( 'Bonding verification', 'energynet' ); ?></li>
							<li><?php esc_html_e( 'Visual inspection & documentation', 'energynet' ); ?></li>
						</ul>
						<p><?php esc_html_e( 'We issue formal test reports with measured values and compliance references.', 'energynet' ); ?></p>
					</div>
				</div>

				<div class="faq-item">
					<h2 class="faq-item__question"><?php esc_html_e( 'Why choose us as your lightning and grounding protection partner?', 'energynet' ); ?></h2>
					<div class="faq-item__answer">
						<p><?php esc_html_e( "Because protection isn't just about hardware — it's about expertise.", 'energynet' ); ?></p>
						<ul>
							<li><?php esc_html_e( 'Certified engineering team', 'energynet' ); ?></li>
							<li><?php esc_html_e( 'Proven installation experience', 'energynet' ); ?></li>
							<li><?php esc_html_e( 'Risk-based design approach', 'energynet' ); ?></li>
							<li><?php esc_html_e( 'Long-term maintenance support', 'energynet' ); ?></li>
							<li><?php esc_html_e( 'Reliable after-sales service', 'energynet' ); ?></li>
						</ul>
						<p><?php esc_html_e( "We don't sell products — we deliver confidence and protection.", 'energynet' ); ?></p>
					</div>
				</div>

			</div><!-- .faq-list -->
		</div><!-- .container -->
	</section>

</main>

<?php get_footer(); ?>
