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
		$title .= " $sep " . sprintf( __( 'Page %s', 'portfolio-press' ), max( $paged, $page ) );
	}

	return $title;
}
add_filter( 'wp_title', 'portfoliopress_wp_title', 10, 2 );


/**
 * Upgrade routine for Portfolio Press.
 * Sets $options['upgrade-2-0'] to true if user is updating
 */
function portfoliopress_upgrade_routine() {

	$options = get_option( 'portfoliopress', false );

	// If version is set, upgrade routine has already run
	if ( !empty( $options['version'] ) ) {
		return;
	}

	// If $options exist, user is upgrading
	if ( $options ) {
		$options['upgrade-2-0'] = true;
	}

	// If 'portfolio_ignore_notice' exists, user is upgrading
	// We'll also delete that data since it's no longer used
	global $current_user;
	if ( get_user_meta( $current_user->ID, 'portfolio_ignore_notice' ) ) {
		$options['upgrade-2-0'] = true;
		delete_user_meta( $current_user->ID, 'portfolio_ignore_notice' );
	}

	// Update page templates
	portfoliopress_update_page_templates();

	// New version number
	$options['version'] = '2.2';

	update_option( 'portfoliopress', $options );
}
add_action( 'admin_init', 'portfoliopress_upgrade_routine' );

/**
 * Part of the Portfolio Press upgrade routine.
 * The page template paths have changed, so let's update the template meta for the user.
 */
function portfoliopress_update_page_templates() {

	$args = array(
		'post_type' => 'page',
		'post_status' => 'publish',
		'meta_query' => array(
		    array(
		        'key' => '_wp_page_template',
		        'value' => 'default',
		        'compare' => '!='
		    )
		)
	);

	$query = new WP_Query( $args );
	if ( $query->have_posts() ) :
		while ( $query->have_posts() ) : $query->the_post();
			$current_template = get_post_meta( get_the_ID(), '_wp_page_template', true );
			$new_template = false;
			switch ( $current_template ) {
				case 'archive-portfolio.php':
					$new_template = 'templates/portfolio.php';
					break;
				case 'full-width-page.php':
					$new_template = 'templates/full-width-page.php';
					break;
				case 'full-width-portfolio.php':
					$new_template = 'templates/full-width-portfolio.php';
					break;
			}
			if ( $new_template ) {
				update_post_meta( get_the_ID(), '_wp_page_template', $new_template );
			}
		endwhile;
	endif;
}

/**
 * Displays notice if user has upgraded theme
 */
function portfoliopress_upgrade_notice() {

	if ( current_user_can( 'edit_theme_options' ) ) {
		$options = get_option( 'portfoliopress', false );

		if ( !empty( $options['upgrade-2-0'] ) && $options['upgrade-2-0'] ) {
			echo '<div class="updated"><p>';
				printf( __(
					'Thanks for updating Portfolio Press.  Please <a href="%1$s">read about important changes</a> in this version and give your site a quick check. <a href="%2$s">Dismiss notice</a>' ),
					'http://wptheming.com/2014/03/portfolio-theme-updates/',
					'?portfolio_upgrade_notice_ignore=1' );
			echo '</p></div>';
		}
	}

}
add_action( 'admin_notices', 'portfoliopress_upgrade_notice', 100 );

/**
 * Displays notice if post_per_page is not divisible by 3
 */
function portfoliopress_posts_per_page_notice() {

	$posts_per_page = get_option( 'posts_per_page', 10 );

	if ( ( $posts_per_page % 3 ) == 0 ) {
		return;
	}

	$options = get_option( 'portfoliopress', false );

	if ( isset( $options['post_per_page_ignore'] ) ) {
		return;
	}

	if ( current_user_can( 'manage_options' ) ) {
		echo '<div class="updated"><p>';
			printf( __(
				'Portfolio Press recommends setting posts per page to 9. This can be changed under <a href="%3$s">Settings > Reading Options</a>.<br><a href="%1$s">Update It</a> | <a href="%2$s">Dismiss Notice</a>.' ),
				'?portfolio_update_posts_per_page=1',
				'?portfolio_post_per_page_ignore=1',
				admin_url( 'options-reading.php', false ), 'portfolio-press' );
		echo '</p></div>';
	}
}
add_action( 'admin_notices', 'portfoliopress_posts_per_page_notice', 120 );

/**
 * Hides notices if user chooses to dismiss it
 */
function portfoliopress_notice_ignores() {

	$options = get_option( 'portfoliopress' );

	if ( isset( $_GET['portfolio_upgrade_notice_ignore'] ) && '1' == $_GET['portfolio_upgrade_notice_ignore'] ) {
		$options['upgrade-2-0'] = false;
		update_option( 'portfoliopress', $options );
	}

	if ( isset( $_GET['portfolio_post_per_page_ignore'] ) && '1' == $_GET['portfolio_post_per_page_ignore'] ) {
		$options['post_per_page_ignore'] = false;
		update_option( 'portfoliopress', $options );
	}

	if ( isset( $_GET['portfolio_update_posts_per_page'] ) && '1' == $_GET['portfolio_update_posts_per_page'] ) {
		update_option( 'posts_per_page', 9 );
	}

}
add_action( 'admin_init', 'portfoliopress_notice_ignores' );

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
add_filter( 'theme_page_templates', 'portfoliopress_page_templates_mod' );

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

/**
 * Remove WordPress's default padding on images with captions
 *
 * @param int $width Default WP .wp-caption width (image width + 10px)
 * @return int Updated width to remove 10px padding
 */
function portfoliopress_remove_caption_padding( $width ) {
    return $width - 10;
}
add_filter( 'img_caption_shortcode_width', 'portfoliopress_remove_caption_padding' );