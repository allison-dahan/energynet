<?php
/**
 * Page template for the Projects page.
 * Auto-used when the page slug is "projects".
 *
 * @package energynet
 */

get_header();

// ─── Query projects from CPT ───────────────────────────────────────────────────

function energynet_get_projects_by_status( string $status ): array {
	$query = new WP_Query( [
		'post_type'      => 'project',
		'posts_per_page' => -1,
		'post_status'    => 'publish',
		'meta_key'       => '_project_status',
		'meta_value'     => $status,
		'orderby'        => 'title',
		'order'          => 'ASC',
	] );

	$projects = [];

	foreach ( $query->posts as $post ) {
		$thumbnail_url = get_the_post_thumbnail_url( $post->ID, 'large' ) ?: '';

		$gallery_ids  = get_post_meta( $post->ID, '_project_gallery', true );
		$gallery_urls = [];
		if ( $gallery_ids ) {
			foreach ( array_filter( array_map( 'trim', explode( ',', $gallery_ids ) ) ) as $id ) {
				$id   = (int) $id;
				$url  = wp_get_attachment_url( $id );
				$mime = get_post_mime_type( $id );
				if ( $url ) {
					$gallery_urls[] = [
						'url'  => $url,
						'type' => strpos( $mime, 'video' ) === 0 ? 'video' : 'image',
					];
				}
			}
		}

		$projects[] = [
			'title'    => get_the_title( $post->ID ),
			'client'   => get_post_meta( $post->ID, '_project_client',   true ),
			'date'     => get_post_meta( $post->ID, '_project_date',      true ),
			'scope'    => get_post_meta( $post->ID, '_project_scope',     true ),
			'location' => get_post_meta( $post->ID, '_project_location',  true ),
			'image'    => $thumbnail_url,
			'gallery'  => $gallery_urls,
			'video'    => get_post_meta( $post->ID, '_project_video',     true ),
			'lat'      => (float) get_post_meta( $post->ID, '_project_lat',   true ),
			'lng'      => (float) get_post_meta( $post->ID, '_project_lng',   true ),
			'lat2'     => (float) get_post_meta( $post->ID, '_project_lat_2', true ),
			'lng2'     => (float) get_post_meta( $post->ID, '_project_lng_2', true ),
		];
	}

	return $projects;
}

$completed_projects = energynet_get_projects_by_status( 'completed' );
$ongoing_projects   = energynet_get_projects_by_status( 'ongoing' );
$all_projects       = array_merge( $completed_projects, $ongoing_projects );
?>

<main id="primary" class="site-main">

	<div class="projects-page">
		<div class="container">

			<!-- ─── Title ────────────────────────────────────────────────────────── -->
			<div class="projects-intro">
				<h1 class="projects-intro__title"><?php esc_html_e( 'PROJECTS', 'energynet' ); ?></h1>
			</div>

			<!-- ─── Body: two-column on desktop ──────────────────────────────────── -->
			<div class="projects-body">

				<div class="projects-left">
					<div class="projects-stat">
						<div class="projects-stat__divider" aria-hidden="true"></div>
						<p class="projects-stat__before"><?php esc_html_e( 'We bring proven expertise with', 'energynet' ); ?></p>
						<p class="projects-stat__after"><?php esc_html_e( 'SUCCESSFUL PROJECTS', 'energynet' ); ?></p>
						<p class="projects-stat__after"><?php esc_html_e( 'across the country', 'energynet' ); ?></p>
						<div class="projects-stat__divider" aria-hidden="true"></div>
					</div>

					<div class="projects-cta">
						<button
							class="projects-cta__btn projects-cta__btn--filled"
							data-drawer-open="completed"
							aria-haspopup="dialog"
						>
							<?php esc_html_e( 'SEE OUR PROJECTS', 'energynet' ); ?>
						</button>
					</div>
				</div>

				<!-- ─── Map ──────────────────────────────────────────────────────── -->
				<div class="projects-map" aria-label="<?php esc_attr_e( 'Project locations map', 'energynet' ); ?>">
					<div id="projects-map-canvas"></div>
				</div>

			</div><!-- .projects-body -->

		</div><!-- .container -->
	</div><!-- .projects-page -->

	<!-- ─── Completed projects drawer ───────────────────────────────────────────── -->
	<div
		class="projects-drawer"
		id="drawer-completed"
		role="dialog"
		aria-modal="true"
		aria-label="<?php esc_attr_e( 'Completed Projects', 'energynet' ); ?>"
		aria-hidden="true"
	>
		<div class="projects-drawer__backdrop" data-drawer-close></div>
		<div class="projects-drawer__panel">

			<div class="projects-drawer__header">
				<p class="projects-drawer__title"><?php esc_html_e( 'PROJECTS', 'energynet' ); ?></p>
				<button class="projects-drawer__close" data-drawer-close aria-label="<?php esc_attr_e( 'Close', 'energynet' ); ?>">
					<iconify-icon icon="material-symbols:close-rounded" width="36" height="36"></iconify-icon>
				</button>
			</div>

			<!-- ── List view ── -->
			<div class="projects-drawer__list">
				<div class="projects-drawer__cards">
					<?php foreach ( $all_projects as $project ) : ?>
						<div class="project-card" role="button" tabindex="0" aria-label="<?php echo esc_attr( $project['title'] ); ?>">
							<div class="project-card__placeholder"></div>
							<?php if ( ! empty( $project['image'] ) ) : ?>
								<img class="project-card__img" src="<?php echo esc_url( $project['image'] ); ?>" alt="<?php echo esc_attr( $project['title'] ); ?>" loading="lazy">
							<?php endif; ?>
							<div class="project-card__gradient"></div>
							<div class="project-card__info">
								<p class="project-card__client"><?php echo esc_html( $project['client'] ); ?></p>
								<p class="project-card__title"><?php echo esc_html( $project['title'] ); ?></p>
							</div>
						</div>
					<?php endforeach; ?>
				</div>

				<div class="projects-drawer__pagination"></div>
			</div>

			<!-- ── Detail view ── -->
			<div class="projects-detail" hidden>

				<p class="projects-detail__title" data-detail-title></p>

				<div class="projects-detail__media">
					<div class="projects-detail__main-img">
						<div class="projects-detail__play" data-detail-play aria-hidden="true">
							<iconify-icon icon="ph:play-fill" width="20" height="20"></iconify-icon>
						</div>
					</div>
					<div class="projects-detail__thumbs">
						<button class="projects-detail__arrow" data-thumb-prev aria-label="<?php esc_attr_e( 'Previous image', 'energynet' ); ?>">
							<iconify-icon icon="ph:caret-left" width="8" height="16"></iconify-icon>
						</button>
						<div class="projects-detail__thumb-list">
							<div class="projects-detail__thumb is-active"></div>
							<div class="projects-detail__thumb"></div>
							<div class="projects-detail__thumb"></div>
						</div>
						<button class="projects-detail__arrow" data-thumb-next aria-label="<?php esc_attr_e( 'Next image', 'energynet' ); ?>">
							<iconify-icon icon="ph:caret-right" width="8" height="16"></iconify-icon>
						</button>
					</div>
				</div>

				<div class="projects-detail__divider" aria-hidden="true"></div>

				<div class="projects-detail__info-card">
					<p class="projects-detail__info-heading"><?php esc_html_e( 'PROJECT INFORMATION', 'energynet' ); ?></p>

					<div class="projects-detail__project-row">
						<p class="projects-detail__label"><?php esc_html_e( 'PROJECT:', 'energynet' ); ?></p>
						<p class="projects-detail__value" data-detail-title></p>
						<div class="projects-detail__info-divider" aria-hidden="true"></div>
					</div>

					<p class="projects-detail__label"><?php esc_html_e( 'CLIENT:', 'energynet' ); ?></p>
					<p class="projects-detail__value" data-detail-client></p>

					<div class="projects-detail__info-divider" aria-hidden="true"></div>

					<p class="projects-detail__label"><?php esc_html_e( 'DATE COMPLETED:', 'energynet' ); ?></p>
					<p class="projects-detail__value" data-detail-date></p>

					<div class="projects-detail__info-divider" aria-hidden="true"></div>

					<p class="projects-detail__label"><?php esc_html_e( 'SCOPE:', 'energynet' ); ?></p>
					<p class="projects-detail__value" data-detail-scope></p>
				</div>

				<div class="projects-detail__nav">
					<button class="projects-detail__nav-btn" data-detail-prev><?php esc_html_e( 'PREV', 'energynet' ); ?></button>
					<span class="projects-detail__counter" data-detail-counter></span>
					<button class="projects-detail__nav-btn" data-detail-next><?php esc_html_e( 'NEXT', 'energynet' ); ?></button>
				</div>

			</div><!-- .projects-detail -->

		</div><!-- .projects-drawer__panel -->
	</div>

	<!-- ─── Inline project data ──────────────────────────────────────────────────── -->
	<script>
		window.projectsCompleted = <?php echo wp_json_encode( $completed_projects ); ?>;
		window.projectsOngoing   = <?php echo wp_json_encode( $ongoing_projects ); ?>;
		window.projectsAll       = <?php echo wp_json_encode( $all_projects ); ?>;
	</script>

</main>

<?php get_footer(); ?>
