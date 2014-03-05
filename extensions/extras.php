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
	$options['version'] = '1.9';

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
				printf( __(
					'Thanks for updating Portfolio Press to version 1.9.  Please <b><a href="%1$s">read about the changes</a></b> in this version. <b><a href="%2$s">Dismiss this Notice</a></b>.' ),
					'http://wptheming.com',
					'?portfolio_upgrade_notice_ignore=1' );
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

/**
 * Removes page templates that require the Portfolio Post Type.
 *
 * This is an ugly hack until post template filters appear in core:
 * https://core.trac.wordpress.org/ticket/13265
 */
function portfoliopress_page_template_mod( $hook ) {
	global $wp_version;
	if ( class_exists( 'Portfolio_Post_Type' ) )
        return;
    if ( version_compare( $wp_version, '3.8.2', '>' ) ) {
    	return;
    }
    if ( 'post.php' != $hook )
        return;
    wp_enqueue_script( 'portfoliopress_page_template_mod', esc_url( get_template_directory_uri() . '/js/admin-page-template-mod.js' ) );
}
add_action( 'admin_enqueue_scripts', 'portfoliopress_page_template_mod' );

/**
 * Filter Page Templates if Portfolio Post Type Plugin
 * is not active.
 *
 * @param array $templates Array of templates.
 * @return array $templates Modified Array of templates.
 */

function portfoliopress_page_templates_mod( $templates ) {
	if ( !class_exists( 'Portfolio_Post_Type' ) ) {
		unset( $templates['templates/portfolio.php'] );
		unset( $templates['templates/full-width-portfolio.php'] );
	}
	return $templates;
}
add_filter( 'page_templates', 'portfoliopress_page_templates_mod' );

/**
 * WP PageNavi Support
 *
 * Removes wp-pagenavi styling since it is handled by theme.
 */

function portfoliopress_deregister_styles() {
    wp_deregister_style( 'wp-pagenavi' );
}
add_action( 'wp_print_styles', 'portfoliopress_deregister_styles', 100 );

/**
 * Replaces definition list elements with their appropriate HTML5 counterparts.
 *
 * @param array $atts The output array of shortcode attributes.
 * @return array HTML5-ified gallery attributes.
 */
function portfoliopress_gallery_atts( $atts ) {
    $atts['itemtag']    = 'figure';
    $atts['icontag']    = 'div';
    $atts['captiontag'] = 'figcaption';

    return $atts;
}
add_filter( 'shortcode_atts_gallery', 'portfoliopress_gallery_atts' );

// Removes the default gallery styling
add_filter( 'use_default_gallery_style', '__return_false' );