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
 * Upgrade routine for Portfolio Press.
 * Sets $options['upgrade'] to true if user is updating
 */
function portfoliopress_upgrade_routine() {

	$options = get_option( 'portfoliopress', false );

	// If version is set, upgrade routine has already run
	if ( !empty( $options['version'] ) ) {
		return;
	}

	// If $options exist, user is upgrading
	if ( $options ) {
		$options['upgrade'] = true;
	}

	// If 'portfolio_ignore_notice' exists, user is upgrading
	// We'll also delete that data since it's no longer used
	global $current_user;
	if ( get_user_meta( $current_user->ID, 'portfolio_ignore_notice' ) ) {
		$options['upgrade'] = true;
		delete_user_meta( $current_user->ID, 'portfolio_ignore_notice' );
	}

	// New version number
	$options['version'] = '2.0';

	update_option( 'portfoliopress', $options );
}


add_action( 'admin_init', 'portfoliopress_upgrade_routine' );

/**
 * Displays notice if user has upgraded theme
 */
function portfoliopress_upgrade_notice() {

	if ( current_user_can( 'edit_theme_options' ) ) {

		$options = get_option( 'portfoliopress', false );

		if ( !empty( $options['upgrade'] ) ) {
			echo '<div class="updated"><p>';
				printf( __( 'Thanks for updating Portfolio Press.  Please read <b><a href="%1$s">about the significant changes</a></b> in this version. <b><a href="%2$s">Dismiss this Notice</a></b>.' ), 'http://wptheming.com', '?portfolio_upgrade_notice_ignore=1' );
			echo '</p></div>';
		}

	}
}

add_action( 'admin_notices', 'portfoliopress_upgrade_notice', 100 );

/**
 * Hides update notice if user chooses to dismiss it
 */
function portfoliopress_upgrade_notice_ignore() {
	if ( isset( $_GET['portfolio_upgrade_notice_ignore'] ) && '1' == $_GET['portfolio_upgrade_notice_ignore'] ) {
		$options = get_option( 'portfoliopress' );
		$options['upgrade'] = false;
		update_option( 'portfoliopress', $options );
	}
}

add_action( 'admin_init', 'portfoliopress_upgrade_notice_ignore' );