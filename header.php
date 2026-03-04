<?php
/**
 * The header for our theme
 *
 * @package energynet
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'energynet' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="container header__inner">

			<a class="header__logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
				<?php bloginfo( 'name' ); ?>
			</a>

			<nav class="header__nav" aria-label="<?php esc_attr_e( 'Primary navigation', 'energynet' ); ?>">
				<?php
				wp_nav_menu( array(
					'theme_location' => 'menu-1',
					'menu_id'        => 'primary-menu',
					'container'      => false,
				) );
				?>
			</nav>

			<div class="header__social" aria-label="<?php esc_attr_e( 'Social media links', 'energynet' ); ?>">
				<a href="#" class="header__social-link" aria-label="Instagram" target="_blank" rel="noopener noreferrer">
					<iconify-icon icon="ri:instagram-fill" width="28" height="28" aria-hidden="true"></iconify-icon>
				</a>
				<a href="#" class="header__social-link" aria-label="Facebook" target="_blank" rel="noopener noreferrer">
					<iconify-icon icon="uil:facebook" width="28" height="28" aria-hidden="true"></iconify-icon>
				</a>
				<a href="#" class="header__social-link" aria-label="LinkedIn" target="_blank" rel="noopener noreferrer">
					<iconify-icon icon="ri:linkedin-fill" width="28" height="28" aria-hidden="true"></iconify-icon>
				</a>
				<a href="#" class="header__social-link" aria-label="YouTube" target="_blank" rel="noopener noreferrer">
					<iconify-icon icon="line-md:youtube-filled" width="28" height="28" aria-hidden="true"></iconify-icon>
				</a>
			</div>

			<button class="header__toggle" aria-label="<?php esc_attr_e( 'Open menu', 'energynet' ); ?>" aria-expanded="false" aria-controls="header-drawer">
				<svg width="24" height="24" viewBox="0 0 24 24" fill="none" aria-hidden="true"><line x1="3" y1="6" x2="21" y2="6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/><line x1="3" y1="12" x2="21" y2="12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/><line x1="3" y1="18" x2="21" y2="18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
			</button>

		</div><!-- .header__inner -->
	</header><!-- #masthead -->

	<!-- Mobile drawer -->
	<div class="header__drawer" id="header-drawer" aria-hidden="true">
		<div class="header__drawer-inner">

			<div class="header__drawer-top">
				<a class="header__logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<?php bloginfo( 'name' ); ?>
				</a>
				<button class="header__close" aria-label="<?php esc_attr_e( 'Close menu', 'energynet' ); ?>">
					<svg width="24" height="24" viewBox="0 0 24 24" fill="none" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/><line x1="6" y1="6" x2="18" y2="18" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/></svg>
				</button>
			</div>

			<nav class="header__drawer-nav" aria-label="<?php esc_attr_e( 'Mobile navigation', 'energynet' ); ?>">
				<?php
				wp_nav_menu( array(
					'theme_location' => 'menu-1',
					'menu_id'        => 'mobile-primary-menu',
					'container'      => false,
				) );
				?>
			</nav>

			<div class="header__drawer-social">
				<a href="#" class="header__social-link" aria-label="Instagram" target="_blank" rel="noopener noreferrer">
					<iconify-icon icon="ri:instagram-fill" width="24" height="24" aria-hidden="true"></iconify-icon>
				</a>
				<a href="#" class="header__social-link" aria-label="Facebook" target="_blank" rel="noopener noreferrer">
					<iconify-icon icon="uil:facebook" width="24" height="24" aria-hidden="true"></iconify-icon>
				</a>
				<a href="#" class="header__social-link" aria-label="LinkedIn" target="_blank" rel="noopener noreferrer">
					<iconify-icon icon="ri:linkedin-fill" width="24" height="24" aria-hidden="true"></iconify-icon>
				</a>
				<a href="#" class="header__social-link" aria-label="YouTube" target="_blank" rel="noopener noreferrer">
					<iconify-icon icon="line-md:youtube-filled" width="24" height="24" aria-hidden="true"></iconify-icon>
				</a>
			</div>

		</div><!-- .header__drawer-inner -->
	</div><!-- .header__drawer -->
