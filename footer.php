<?php
/**
 * The footer for our theme
 *
 * @package Energynet
 */
?>

	<footer id="colophon" class="site-footer">

		<div class="container footer__inner">

			<!-- Col 1a: Brand (name + tagline) — mobile order 1 -->
			<div class="footer__brand">
				<p class="footer__logo"><?php bloginfo( 'name' ); ?>, Inc.</p>
				<!-- <p class="footer__tagline"><?php esc_html_e( 'Body text here.', 'Energynet' ); ?></p> -->
			</div>

			<!-- Col 2: Contact — mobile order 2 -->
			<div class="footer__contact">
				<h2 class="footer__contact-heading"><?php esc_html_e( 'CONTACT US', 'Energynet' ); ?></h2>

				<div class="footer__contact-block footer__contact-block--address">
					<span class="footer__contact-label"><?php esc_html_e( 'OFFICE', 'Energynet' ); ?></span>
					<p>112 San Miguel Street corner San Rafael Street, Plainview, Mandaluyong City, Metro Manila, Philippines 1550</p>
				</div>

				<div class="footer__contact-block footer__contact-block--address">
					<span class="footer__contact-label"><?php esc_html_e( 'WAREHOUSE', 'Energynet' ); ?></span>
					<p>112 San Miguel St., Brgy Plainview, Mandaluyong City</p>
				</div>

				<div class="footer__contact-block footer__contact-block--tel">
					<iconify-icon icon="mingcute:phone-fill" width="20" height="20" aria-hidden="true"></iconify-icon>
					<span class="footer__contact-label"><?php esc_html_e( 'Tel.', 'Energynet' ); ?></span>
					<p>+632 8640 9997<br>+632 7358 3740<br>+632 8398 2887</p>
				</div>

				<div class="footer__contact-block footer__contact-block--email">
					<iconify-icon icon="ic:round-email" width="20" height="20" aria-hidden="true"></iconify-icon>
					<a href="mailto:info@energynet.com.ph">info@energynet.com.ph</a>
				</div>
			</div>

			<!-- Col 1b: Legal links — mobile order 3, desktop back in col 1 via grid-area -->
			<nav class="footer__legal" aria-label="<?php esc_attr_e( 'Legal links', 'Energynet' ); ?>">
				<a href="#"><?php esc_html_e( 'FAQs', 'Energynet' ); ?></a>
				<a href="#"><?php esc_html_e( 'Privacy Policy', 'Energynet' ); ?></a>
				<a href="#"><?php esc_html_e( 'Terms and Conditions', 'Energynet' ); ?></a>
			</nav>

			<!-- Col 3: CTA (desktop only) -->
			<div class="footer__cta">
				<p class="footer__cta-heading"><?php esc_html_e( 'FOR MORE INFORMATION', 'Energynet' ); ?></p>
				<a href="#" class="footer__btn">
					<iconify-icon icon="mingcute:phone-fill" width="20" height="20" aria-hidden="true"></iconify-icon>
					<?php esc_html_e( 'REQUEST A QUOTE', 'Energynet' ); ?>
				</a>
				<a href="mailto:info@energynet.com.ph" class="footer__btn">
					<iconify-icon icon="ic:round-email" width="20" height="20" aria-hidden="true"></iconify-icon>
					<?php esc_html_e( 'SEND US AN EMAIL', 'Energynet' ); ?>
				</a>
				<div class="footer__follow">
					<p class="footer__follow-label"><?php esc_html_e( 'Follow us', 'Energynet' ); ?></p>
					<div class="footer__social">
						<a href="#" class="footer__social-link" aria-label="Instagram" target="_blank" rel="noopener noreferrer">
							<iconify-icon icon="ri:instagram-fill" width="28" height="28" aria-hidden="true"></iconify-icon>
						</a>
						<a href="#" class="footer__social-link" aria-label="Facebook" target="_blank" rel="noopener noreferrer">
							<iconify-icon icon="uil:facebook" width="28" height="28" aria-hidden="true"></iconify-icon>
						</a>
						<a href="#" class="footer__social-link" aria-label="YouTube" target="_blank" rel="noopener noreferrer">
							<iconify-icon icon="ri:youtube-fill" width="28" height="28" aria-hidden="true"></iconify-icon>
						</a>
						<a href="#" class="footer__social-link" aria-label="LinkedIn" target="_blank" rel="noopener noreferrer">
							<iconify-icon icon="ri:linkedin-fill" width="28" height="28" aria-hidden="true"></iconify-icon>
						</a>
					</div>
				</div>
			</div>

		</div><!-- .footer__inner -->

		<!-- Mobile: social icons + copyright (hidden on desktop) -->
		<div class="footer__bottom">
			<div class="container">
				<div class="footer__mobile-social">
					<a href="#" class="footer__social-link footer__social-link--accent" aria-label="Instagram" target="_blank" rel="noopener noreferrer">
						<iconify-icon icon="ri:instagram-fill" width="22" height="22" aria-hidden="true"></iconify-icon>
					</a>
					<a href="#" class="footer__social-link footer__social-link--accent" aria-label="Facebook" target="_blank" rel="noopener noreferrer">
						<iconify-icon icon="uil:facebook" width="22" height="22" aria-hidden="true"></iconify-icon>
					</a>
					<a href="#" class="footer__social-link footer__social-link--accent" aria-label="YouTube" target="_blank" rel="noopener noreferrer">
						<iconify-icon icon="ri:youtube-fill" width="22" height="22" aria-hidden="true"></iconify-icon>
					</a>
					<a href="#" class="footer__social-link footer__social-link--accent" aria-label="LinkedIn" target="_blank" rel="noopener noreferrer">
						<iconify-icon icon="ri:linkedin-fill" width="22" height="22" aria-hidden="true"></iconify-icon>
					</a>
				</div>
				<p class="footer__copyright">&copy; <?php bloginfo( 'name' ); ?>, Inc. <?php esc_html_e( 'All rights reserved.', 'Energynet' ); ?></p>
			</div>
		</div><!-- .footer__bottom -->

	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
