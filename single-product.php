<?php
/**
 * Single product page template.
 * Auto-used for individual product posts (post type: product).
 *
 * @package energynet
 */

get_header();

$post_id   = get_the_ID();
$title     = get_the_title();
$image_url = get_the_post_thumbnail_url( $post_id, 'large' );
$page_url  = get_permalink();

// Breadcrumb — brand term
$brand_terms = get_the_terms( $post_id, 'product_brand' );
$brand       = ( $brand_terms && ! is_wp_error( $brand_terms ) ) ? $brand_terms[0] : null;

// Tech files
$tech_fields = array_filter( [
	'Brochure'    => get_post_meta( $post_id, '_tech_brochure_url', true ),
	'Certificate' => get_post_meta( $post_id, '_tech_certificate',  true ),
	'Data Sheet'  => get_post_meta( $post_id, '_tech_data_sheet',   true ),
] );

$video_url = get_post_meta( $post_id, '_tech_video', true );

// Convert YouTube watch/short URLs to embed URLs for iframe use.
if ( $video_url ) {
	if ( preg_match( '#youtu\.be/([a-zA-Z0-9_-]+)#', $video_url, $m ) ) {
		$video_url = 'https://www.youtube.com/embed/' . $m[1];
	} elseif ( preg_match( '#[?&]v=([a-zA-Z0-9_-]+)#', $video_url, $m ) ) {
		$video_url = 'https://www.youtube.com/embed/' . $m[1];
	}
}

$tech_icons = [
	'Brochure'    => 'ph:file-text-thin',
	'Certificate' => 'ph:certificate-thin',
	'Data Sheet'  => 'ph:table-thin',
];
?>

<main id="primary" class="site-main">
<div class="single-product">

	<?php // ─── Breadcrumb ──────────────────────────────────────────────────── ?>
	<nav class="product-breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'energynet' ); ?>">
		<a class="product-breadcrumb__link" href="<?php echo esc_url( home_url( '/products' ) ); ?>">
			<?php esc_html_e( 'Our Products', 'energynet' ); ?>
		</a>
		<?php if ( $brand ) : ?>
			<span class="product-breadcrumb__sep">&gt;</span>
			<a class="product-breadcrumb__link" href="<?php echo esc_url( home_url( '/products' ) ); ?>">
				<?php echo esc_html( $brand->name ); ?>
			</a>
		<?php endif; ?>
		<span class="product-breadcrumb__sep">&gt;</span>
		<span class="product-breadcrumb__current"><?php echo esc_html( $title ); ?></span>
	</nav>

	<?php // ─── Product main grid (image + info) ─────────────────────────── ?>
	<div class="product-main-grid">

	<?php // ─── Product image ───────────────────────────────────────────────── ?>
	<?php if ( $image_url ) : ?>
	<div class="product-image-card">
		<img
			class="product-image-card__img"
			src="<?php echo esc_url( $image_url ); ?>"
			alt="<?php echo esc_attr( $title ); ?>"
		>
		<button class="product-image-card__zoom" aria-label="<?php esc_attr_e( 'Zoom image', 'energynet' ); ?>" data-product-zoom>
			<iconify-icon icon="mdi:magnify" width="18" height="18"></iconify-icon>
		</button>
	</div>
	<?php endif; ?>

	<?php // ─── Product info card ───────────────────────────────────────────── ?>
	<div class="product-info-card">
		<h1 class="product-info-card__title"><?php echo esc_html( $title ); ?></h1>
		<div class="product-info-card__description">
			<?php
			if ( get_the_content() ) {
				the_content();
			} else {
				echo wp_kses_post( wpautop( get_the_excerpt() ) );
			}
			?>
		</div>
		<a
			href="<?php echo esc_url( home_url( '/contact' ) ); ?>"
			class="product-info-card__cta"
		>
			<?php esc_html_e( 'NEED MORE INFORMATION? CONTACT US', 'energynet' ); ?>
		</a>
	</div>

	</div><!-- .product-main-grid -->

	<?php // ─── Share bar ───────────────────────────────────────────────────── ?>
	<div class="product-share">
		<span class="product-share__label"><?php esc_html_e( 'SHARE', 'energynet' ); ?></span>
		<div class="product-share__buttons">
			<a
				class="product-share__btn"
				href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode( $page_url ); ?>"
				target="_blank" rel="noopener noreferrer"
				aria-label="<?php esc_attr_e( 'Share on Facebook', 'energynet' ); ?>"
			>
				<iconify-icon icon="uil:facebook"></iconify-icon>
			</a>
			<a
				class="product-share__btn"
				href="https://www.instagram.com/"
				target="_blank" rel="noopener noreferrer"
				aria-label="<?php esc_attr_e( 'Share on Instagram', 'energynet' ); ?>"
			>
				<iconify-icon icon="ri:instagram-fill"></iconify-icon>
			</a>
			<a
				class="product-share__btn"
				href="https://api.whatsapp.com/send?text=<?php echo urlencode( $title . ' ' . $page_url ); ?>"
				target="_blank" rel="noopener noreferrer"
				aria-label="<?php esc_attr_e( 'Share on WhatsApp', 'energynet' ); ?>"
			>
				<iconify-icon icon="mdi:whatsapp"></iconify-icon>
			</a>
			<button
				class="product-share__btn"
				data-copy-url="<?php echo esc_attr( $page_url ); ?>"
				aria-label="<?php esc_attr_e( 'Copy link', 'energynet' ); ?>"
			>
				<iconify-icon icon="mdi:link-variant"></iconify-icon>
			</button>
		</div>
	</div>

	<?php // ─── Technical information ────────────────────────────────────────── ?>
	<?php if ( $tech_fields ) : ?>
	<div class="product-section">
		<div class="product-section__header">
			<span class="product-section__diamond" aria-hidden="true"></span>
			<span class="product-section__eyebrow"><?php esc_html_e( 'ADDITIONAL INFORMATION', 'energynet' ); ?></span>
			<span class="product-section__line" aria-hidden="true"></span>
		</div>
		<h2 class="product-section__heading"><?php esc_html_e( 'Technical Information', 'energynet' ); ?></h2>
		<div class="product-tech-grid">
			<?php foreach ( $tech_fields as $label => $url ) : ?>
				<a
					class="product-tech-card"
					href="<?php echo esc_url( $url ); ?>"
					target="_blank"
					rel="noopener noreferrer"
				>
					<div class="product-tech-card__icon-wrap">
						<iconify-icon icon="<?php echo esc_attr( $tech_icons[ $label ] ?? 'mdi:file-outline' ); ?>" width="100" height="100"></iconify-icon>
						<span class="product-tech-card__label"><?php echo esc_html( $label ); ?></span>
					</div>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
	<?php endif; ?>

	<?php // ─── Video ───────────────────────────────────────────────────────── ?>
	<?php if ( $video_url ) : ?>
	<div class="product-section product-section--video">
		<div class="product-section__header">
			<span class="product-section__diamond" aria-hidden="true"></span>
			<span class="product-section__eyebrow"><?php esc_html_e( 'VIDEO', 'energynet' ); ?></span>
			<span class="product-section__line" aria-hidden="true"></span>
		</div>
		<h2 class="product-section__heading"><?php esc_html_e( 'See how our product works', 'energynet' ); ?></h2>
		<div class="product-video">
			<iframe
				class="product-video__iframe"
				src="<?php echo esc_url( $video_url ); ?>"
				allowfullscreen
				loading="lazy"
				title="<?php echo esc_attr( $title ); ?>"
			></iframe>
		</div>
	</div>
	<?php endif; ?>

</div>

<?php // ─── Back to top ─────────────────────────────────────────────────────── ?>
<button class="back-to-top" aria-label="<?php esc_attr_e( 'Back to top', 'energynet' ); ?>" data-back-to-top>
	<span class="back-to-top__circle">
		<iconify-icon icon="mdi:chevron-up" width="20" height="20"></iconify-icon>
	</span>
	<span class="back-to-top__label"><?php esc_html_e( 'BACK TO TOP', 'energynet' ); ?></span>
</button>

</main>

<?php get_footer(); ?>
