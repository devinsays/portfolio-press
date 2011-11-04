<?php
/**
 * @package WordPress
 * @subpackage Portfolio Press
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name ="viewport" content="width = 1020">
<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'portfoliopress' ), max( $paged, $page ) );

	?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<?php if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' ); ?>
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/html5.js"></script>
<![endif]-->
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="wrapper">
	<header id="branding">
    	<div class="col-width">
        <?php $heading_tag = ( is_home() || is_front_page() ) ? 'h1' : 'div'; ?>
			<hgroup id="logo">
				<<?php echo $heading_tag; ?> id="site-title"><a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
                <?php if ( of_get_option('logo', false) ) { ?>
					<img src="<?php echo of_get_option('logo'); ?>" alt="<?php echo bloginfo( 'name' ) ?>" />
				<?php } else {
					bloginfo( 'name' );
				}?>
                </a>
                </<?php echo $heading_tag; ?>>
				<?php if ( !of_get_option('logo', false) ) { ?>
                	<h2 id="site-description"><?php bloginfo( 'description' ); ?></h2>
                <?php } ?>
			</hgroup>
      
		<nav id="navigation">
			<h3 class="screen-reader-text"><?php _e( 'Main menu', 'portfoliopress' ); ?></h3>
			<div class="skip-link screen-reader-text"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'portfoliopress' ); ?>"><?php _e( 'Skip to content', 'portfoliopress' ); ?></a></div>
	
			<?php wp_nav_menu( array( 'theme_location' => 'primary') ); ?>
		</nav><!-- #access -->
    
    </div>
    
	</header><!-- #branding -->

	<div id="main">
    	<div class="col-width">