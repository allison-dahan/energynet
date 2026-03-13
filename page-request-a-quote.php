<?php
/**
 * Page template for the Request a Quote page.
 * Auto-used when the page slug is "request-a-quote".
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
				<a href="#quote-form" class="contact-hero__btn contact-hero__btn--filled">
					<?php esc_html_e( 'REQUEST A QUOTE', 'energynet' ); ?>
				</a>
				<a href="<?php echo esc_url( get_permalink( get_page_by_path( 'faqs' ) ) ); ?>" class="contact-hero__btn contact-hero__btn--outline">
					<?php esc_html_e( 'FAQs', 'energynet' ); ?>
				</a>
			</div>
		</div>
	</section>

	<!-- ─── Quote form ────────────────────────────────────────────────────────────── -->
	<section class="contact-form-section" id="quote-form">
		<div class="container">

			<h1 class="contact-form__title"><?php esc_html_e( 'REQUEST A QUOTATION', 'energynet' ); ?></h1>
			<p class="contact-form__subtitle"><?php esc_html_e( "Thank you for considering us for your project! Kindly fill up the form and we'll email you a quotation.", 'energynet' ); ?></p>

			<form class="contact-form" method="post" action="">
				<?php wp_nonce_field( 'quote_form_submit', 'quote_nonce' ); ?>

				<!-- Section 1: Personal info — two columns on desktop -->
				<!-- Source order: FULL NAME | COMPANY, PHONE NUMBER | CITY, EMAIL | POSITION -->
				<div class="contact-form__grid">

					<div class="contact-form__field">
						<label class="contact-form__label" for="qf-name"><?php esc_html_e( 'FULL NAME', 'energynet' ); ?></label>
						<input
							class="contact-form__input"
							type="text"
							id="qf-name"
							name="qf_name"
							placeholder="<?php esc_attr_e( 'first and last name*', 'energynet' ); ?>"
							required
						>
					</div>

					<div class="contact-form__field">
						<label class="contact-form__label" for="qf-company"><?php esc_html_e( 'COMPANY', 'energynet' ); ?></label>
						<input
							class="contact-form__input"
							type="text"
							id="qf-company"
							name="qf_company"
							placeholder="<?php esc_attr_e( 'company*', 'energynet' ); ?>"
						>
					</div>

					<div class="contact-form__field">
						<label class="contact-form__label" for="qf-phone"><?php esc_html_e( 'PHONE NUMBER', 'energynet' ); ?></label>
						<input
							class="contact-form__input"
							type="tel"
							id="qf-phone"
							name="qf_phone"
							placeholder="<?php esc_attr_e( 'number*', 'energynet' ); ?>"
						>
					</div>

					<div class="contact-form__field">
						<label class="contact-form__label" for="qf-city"><?php esc_html_e( 'CITY', 'energynet' ); ?></label>
						<input
							class="contact-form__input"
							type="text"
							id="qf-city"
							name="qf_city"
							placeholder="<?php esc_attr_e( 'city*', 'energynet' ); ?>"
						>
					</div>

					<div class="contact-form__field">
						<label class="contact-form__label" for="qf-email"><?php esc_html_e( 'EMAIL', 'energynet' ); ?></label>
						<input
							class="contact-form__input"
							type="email"
							id="qf-email"
							name="qf_email"
							placeholder="<?php esc_attr_e( 'email*', 'energynet' ); ?>"
							required
						>
					</div>

					<div class="contact-form__field">
						<label class="contact-form__label" for="qf-position"><?php esc_html_e( 'POSITION', 'energynet' ); ?></label>
						<input
							class="contact-form__input"
							type="text"
							id="qf-position"
							name="qf_position"
							placeholder="<?php esc_attr_e( 'position*', 'energynet' ); ?>"
						>
					</div>

				</div><!-- .contact-form__grid -->

				<h2 class="contact-form__section-title"><?php esc_html_e( 'YOUR PROJECT', 'energynet' ); ?></h2>

				<!-- Section 2: Project info — two columns on desktop -->
				<!-- Source order: CITY | PROJECT STAGE, YOUR REQUEST | PROJECT TYPE -->
				<div class="contact-form__grid">

					<div class="contact-form__field">
						<label class="contact-form__label" for="qf-project-city"><?php esc_html_e( 'CITY', 'energynet' ); ?></label>
						<input
							class="contact-form__input"
							type="text"
							id="qf-project-city"
							name="qf_project_city"
							placeholder="<?php esc_attr_e( 'project city*', 'energynet' ); ?>"
						>
					</div>

					<div class="contact-form__field">
						<label class="contact-form__label" for="qf-stage"><?php esc_html_e( 'PROJECT STAGE', 'energynet' ); ?></label>
						<select class="contact-form__select" id="qf-stage" name="qf_stage">
							<option value="" disabled selected><?php esc_html_e( 'project stage', 'energynet' ); ?></option>
							<option value="planning"><?php esc_html_e( 'Planning', 'energynet' ); ?></option>
							<option value="design"><?php esc_html_e( 'Design', 'energynet' ); ?></option>
							<option value="construction"><?php esc_html_e( 'Construction', 'energynet' ); ?></option>
							<option value="operation"><?php esc_html_e( 'Operation', 'energynet' ); ?></option>
						</select>
					</div>

					<div class="contact-form__field">
						<label class="contact-form__label" for="qf-request"><?php esc_html_e( 'YOUR REQUEST', 'energynet' ); ?></label>
						<select class="contact-form__select" id="qf-request" name="qf_request">
							<option value="" disabled selected><?php esc_html_e( 'request type', 'energynet' ); ?></option>
							<option value="products"><?php esc_html_e( 'Products', 'energynet' ); ?></option>
							<option value="services"><?php esc_html_e( 'Services', 'energynet' ); ?></option>
							<option value="other"><?php esc_html_e( 'Other', 'energynet' ); ?></option>
						</select>
					</div>

					<div class="contact-form__field">
						<label class="contact-form__label" for="qf-type"><?php esc_html_e( 'PROJECT TYPE', 'energynet' ); ?></label>
						<select class="contact-form__select" id="qf-type" name="qf_type">
							<option value="" disabled selected><?php esc_html_e( 'project type', 'energynet' ); ?></option>
							<option value="renewable"><?php esc_html_e( 'Renewable Energy', 'energynet' ); ?></option>
							<option value="non-renewable"><?php esc_html_e( 'Non-Renewable Energy', 'energynet' ); ?></option>
							<option value="infrastructure"><?php esc_html_e( 'Infrastructure', 'energynet' ); ?></option>
							<option value="data-center"><?php esc_html_e( 'Data Center', 'energynet' ); ?></option>
							<option value="industrial"><?php esc_html_e( 'Industrial', 'energynet' ); ?></option>
							<option value="commercial"><?php esc_html_e( 'Commercial', 'energynet' ); ?></option>
						</select>
					</div>

				</div><!-- .contact-form__grid -->

				<!-- Full-width: PROJECT/PRODUCT DETAILS -->
				<div class="contact-form__field">
					<label class="contact-form__label contact-form__label--lg" for="qf-details"><?php esc_html_e( 'PROJECT/PRODUCT DETAILS', 'energynet' ); ?></label>
					<textarea
						class="contact-form__textarea contact-form__textarea--tall"
						id="qf-details"
						name="qf_details"
					></textarea>
				</div>

				<label class="contact-form__checkbox-wrap">
					<input
						class="contact-form__checkbox"
						type="checkbox"
						name="qf_agree"
						required
					>
					<span class="contact-form__checkbox-label">
						<?php esc_html_e( 'I understand and agree that this site collects the information I filled out. Energynet, Inc. do not share the information connected for business purposes. Refer to Energynet, Inc. Privacy Policy terms and conditions.', 'energynet' ); ?>
					</span>
				</label>

				<div class="contact-form__submit-wrap contact-form__submit-wrap--centered">
					<button type="submit" class="contact-form__submit">
						<?php esc_html_e( 'SUBMIT', 'energynet' ); ?>
					</button>
				</div>

			</form>
		</div>
	</section>

</main>

<?php get_footer(); ?>
