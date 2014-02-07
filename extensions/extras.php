<?php
/**
 * @package Portfolio Press
 */

 /**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
function portfoliopress_wp_title( $title, $sep ) {
	if ( is_feed() ) {
		return $title;
	}

	global $page, $paged;

	// Add the blog name
	$title .= get_bloginfo( 'name', 'display' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title .= " $sep $site_description";
	}

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 ) {
		$title .= " $sep " . sprintf( __( 'Page %s', 'portfoliopress' ), max( $paged, $page ) );
	}

	return $title;
}
add_filter( 'wp_title', 'portfoliopress_wp_title', 10, 2 );

/**
 * Displays a notice letting the user know that portfolio post type functionality
 * will be moving into a plugin.  They can upgrade now, or wait one more
 * version before this code is removed.
 */

if ( ! class_exists( 'Portfolio_Post_Type' ) && current_user_can( 'install_plugins' ) ) {

	/* Display a notice that can be dismissed */

	add_action( 'admin_notices', 'portfoliopress_install_plugin_notice' );

	function portfoliopress_install_plugin_notice() {
		global $current_user ;
		$user_id = $current_user->ID;
		/* Check that the user hasn't already clicked to ignore the message */
		if ( ! get_user_meta( $user_id, 'portfolio_ignore_notice' ) ) {
			add_thickbox();
			echo '<div class="updated"><p>';
			printf( __( 'If you wish to use custom post types for portfolios, please install the Portfolio Post Type Plugin.  <a href="%1$s" class="thickbox onclick">Install Now</a> | <a href="%2$s">Hide Notice</a>' ), admin_url() . 'plugin-install.php?tab=plugin-information&plugin=portfolio-post-type&TB_iframe=true&width=640&height=517', '?portfolio_ignore_notice=1' );
			echo '</p></div>';
		}
	}

	add_action( 'admin_init', 'portfoliopress_post_plugin_ignore' );

	function portfoliopress_post_plugin_ignore() {
		global $current_user;
		$user_id = $current_user->ID;
		/* If user clicks to ignore the notice, add that to their user meta */
		if ( isset( $_GET['portfolio_ignore_notice'] ) && '1' == $_GET['portfolio_ignore_notice'] ) {
			add_user_meta( $user_id, 'portfolio_ignore_notice', 'true', true );
		}
	}
}