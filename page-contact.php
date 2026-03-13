<?php
/**
 * Page template for the Contact page.
 * Auto-used when the page slug is "contact".
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
				<a href="#contact-form" class="contact-hero__btn contact-hero__btn--filled">
					<?php esc_html_e( 'CONTACT US', 'energynet' ); ?>
				</a>
				<a href="<?php echo esc_url( get_permalink( get_page_by_path( 'request-a-quote' ) ) ); ?>" class="contact-hero__btn contact-hero__btn--outline">
					<?php esc_html_e( 'REQUEST A QUOTE', 'energynet' ); ?>
				</a>
				<a href="<?php echo esc_url( get_permalink( get_page_by_path( 'faqs' ) ) ); ?>" class="contact-hero__btn contact-hero__btn--outline">
					<?php esc_html_e( 'FAQs', 'energynet' ); ?>
				</a>
			</div>
		</div>
	</section>

	<!-- ─── Contact form + info ───────────────────────────────────────────────────── -->
	<section class="contact-form-section" id="contact-form">
		<div class="container">

			<h1 class="contact-form__title"><?php esc_html_e( 'CONTACT US', 'energynet' ); ?></h1>
			<p class="contact-form__subtitle"><?php esc_html_e( "Got an inquiry? Get in touch with us! Fill up the form and we'll get back to you shortly.", 'energynet' ); ?></p>

			<div class="contact-content">

				<!-- Left: Form -->
				<div class="contact-content__form">
					<form class="contact-form" method="post" action="">
						<?php wp_nonce_field( 'contact_form_submit', 'contact_nonce' ); ?>

						<div class="contact-form__field">
							<label class="contact-form__label" for="cf-name"><?php esc_html_e( 'FULL NAME', 'energynet' ); ?></label>
							<input
								class="contact-form__input"
								type="text"
								id="cf-name"
								name="cf_name"
								placeholder="<?php esc_attr_e( 'first and last name*', 'energynet' ); ?>"
								required
							>
						</div>

						<div class="contact-form__field">
							<label class="contact-form__label" for="cf-phone"><?php esc_html_e( 'PHONE NUMBER', 'energynet' ); ?></label>
							<input
								class="contact-form__input"
								type="tel"
								id="cf-phone"
								name="cf_phone"
								placeholder="<?php esc_attr_e( 'number*', 'energynet' ); ?>"
							>
						</div>

						<div class="contact-form__field">
							<label class="contact-form__label" for="cf-email"><?php esc_html_e( 'EMAIL', 'energynet' ); ?></label>
							<input
								class="contact-form__input"
								type="email"
								id="cf-email"
								name="cf_email"
								placeholder="<?php esc_attr_e( 'email*', 'energynet' ); ?>"
								required
							>
						</div>

						<div class="contact-form__field">
							<label class="contact-form__label" for="cf-company"><?php esc_html_e( 'COMPANY', 'energynet' ); ?></label>
							<input
								class="contact-form__input"
								type="text"
								id="cf-company"
								name="cf_company"
								placeholder="<?php esc_attr_e( 'company*', 'energynet' ); ?>"
							>
						</div>

						<div class="contact-form__field">
							<label class="contact-form__label" for="cf-subject"><?php esc_html_e( 'SUBJECT', 'energynet' ); ?></label>
							<input
								class="contact-form__input"
								type="text"
								id="cf-subject"
								name="cf_subject"
								placeholder="<?php esc_attr_e( 'Subject*', 'energynet' ); ?>"
								required
							>
						</div>

						<div class="contact-form__field">
							<label class="contact-form__label contact-form__label--lg" for="cf-message"><?php esc_html_e( 'MESSAGE', 'energynet' ); ?></label>
							<textarea
								class="contact-form__textarea"
								id="cf-message"
								name="cf_message"
								required
							></textarea>
						</div>

						<?php /* Add your preferred captcha solution here (e.g. reCAPTCHA, CF7 captcha). */ ?>
						<div class="contact-form__captcha">
							<!-- captcha placeholder -->
						</div>

						<div class="contact-form__submit-wrap">
							<button type="submit" class="contact-form__submit">
								<?php esc_html_e( 'SUBMIT', 'energynet' ); ?>
							</button>
						</div>

					</form>

					<!-- Divider: visible on mobile only, hidden on desktop -->
					<div class="contact-divider"></div>
				</div>

				<!-- Right: Info + Map -->
				<div class="contact-content__sidebar">
					<div class="contact-info__items">

						<div class="contact-info__item">
							<div class="contact-info__icon-wrap" aria-hidden="true">
								<iconify-icon icon="mdi:map-marker" width="26" height="26"></iconify-icon>
							</div>
							<div class="contact-info__content">
								<p class="contact-info__text">
									<?php esc_html_e( 'OFFICE', 'energynet' ); ?><br>
									<?php esc_html_e( '112 San Miguel Street corner San Rafael Street, Plainview, Mandaluyong City, Metro Manila, Philippines 1550', 'energynet' ); ?>
								</p>
								<p class="contact-info__text contact-info__text--gap">
									<?php esc_html_e( 'WAREHOUSE', 'energynet' ); ?><br>
									<?php esc_html_e( '112 San Miguel St., Brgy Plainview, Mandaluyong City', 'energynet' ); ?>
								</p>
							</div>
						</div>

						<div class="contact-info__item">
							<div class="contact-info__icon-wrap" aria-hidden="true">
								<iconify-icon icon="mingcute:phone-fill" width="26" height="26"></iconify-icon>
							</div>
							<div class="contact-info__content">
								<p class="contact-info__text">
									<?php esc_html_e( 'Tel. +632 8640 9997, +632 7358 3740, +632 8398 2887', 'energynet' ); ?>
								</p>
							</div>
						</div>

						<div class="contact-info__item">
							<div class="contact-info__icon-wrap" aria-hidden="true">
								<iconify-icon icon="ic:round-email" width="26" height="26"></iconify-icon>
							</div>
							<div class="contact-info__content">
								<a class="contact-info__email" href="mailto:info@energynet.com.ph">info@energynet.com.ph</a>
							</div>
						</div>

					</div><!-- .contact-info__items -->

					<div class="contact-map">
						<?php /* Replace .contact-map__placeholder with a Google Maps iframe when ready. */ ?>
						<div class="contact-map__placeholder">
							<span><?php esc_html_e( 'MAP', 'energynet' ); ?></span>
						</div>
					</div>
				</div><!-- .contact-content__sidebar -->

			</div><!-- .contact-content -->
		</div><!-- .container -->
	</section>

</main>

<?php get_footer(); ?>
