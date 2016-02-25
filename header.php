<?php
/**
 * Header template
 *
 * @package Portfolio Press
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<!--[if lt IE 9]>
<script src="<?php echo esc_url( get_template_directory_uri() . '/js/html5.js' ); ?>"></script>
<![endif]-->
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page">

	<header id="branding">
    	<div class="col-width">
        <?php $heading_tag = ( is_home() || is_front_page() ) ? 'h1' : 'div'; ?>
			<hgroup id="logo">
				<<?php echo $heading_tag; ?> id="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                <?php if ( portfoliopress_get_option( 'logo', false ) ) { ?>
					<img src="<?php echo esc_url( portfoliopress_get_option( 'logo' ) ); ?>" alt="<?php echo bloginfo( 'name' ) ?>">
				<?php } else {
					bloginfo( 'name' );
				}?>
                </a>
                </<?php echo $heading_tag; ?>>
				<?php if ( ! portfoliopress_get_option( 'logo', false ) ) { ?>
                	<h2 id="site-description"><?php bloginfo( 'description' ); ?></h2>
                <?php } ?>
			</hgroup>

			<nav id="navigation" class="site-navigation primary-navigation" role="navigation">
				<h1 class="menu-toggle"><?php _e( 'Menu', 'portfolio-press' ); ?></h1>
				<a class="screen-reader-text skip-link" href="#content"><?php _e( 'Skip to content', 'portfolio-press' ); ?></a>
				<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu' ) ); ?>
			</nav>
		</div>
	</header><!-- #branding -->

	<div id="main">
    	<div class="col-width">