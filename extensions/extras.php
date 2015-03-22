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
 * Displays notice if post_per_page is not divisible by 3
 */
function portfoliopress_posts_per_page_notice() {

	$posts_per_page = get_option( 'posts_per_page', 10 );

	if ( ( $posts_per_page % 3 ) == 0 ) {
		return;
	}

	$options = get_option( 'portfoliopress', false );

	if ( isset( $options['post_per_page_ignore'] ) && $options['post_per_page_ignore'] == 1 ) {
		return;
	}

	if ( current_user_can( 'manage_options' ) ) {
		echo '<div class="updated"><p>';
			printf( __(
				'Portfolio Press recommends setting <a href="%3$s">posts per page</a> to 9 or 12. <a href="%1$s">Update</a> | <a href="%2$s">Hide Notice</a>', 'portfolio-press' ),
				'?portfolio_update_posts_per_page=1',
				'?portfolio_post_per_page_ignore=1',
				admin_url( 'options-reading.php', false )
			);
		echo '</p></div>';
	}
}
add_action( 'admin_notices', 'portfoliopress_posts_per_page_notice', 120 );

/**
 * Display notice to regenerate thumbnails
 */
function portfoliopress_thumbnail_notice() {

	$options = get_option( 'portfoliopress', false );

	if ( isset( $options['regnerate_thumbnails'] ) && $options['regnerate_thumbnails'] == 1 ) {
		return;
	}

	if ( current_user_can( 'manage_options' ) ) {
		echo '<div class="updated"><p>';
			printf( __(
				'Portfolio Press recommends regenerating thumbnails. <a href="%1$s" target="_blank">Read More</a> | <a href="%2$s">Hide Notice</a>', 'portfolio-press' ),
				esc_url( 'https://wordpress.org/plugins/regenerate-thumbnails/' ),
				'?portfolio_thumbnails_ignore=1'
				);
		echo '</p></div>';
	}
}
add_action( 'admin_notices', 'portfoliopress_thumbnail_notice', 200 );

/**
 * Hides notices if user chooses to dismiss it
 */
function portfoliopress_notice_ignores() {

	$options = get_option( 'portfoliopress' );

	if ( isset( $_GET['portfolio_post_per_page_ignore'] ) && '1' == $_GET['portfolio_post_per_page_ignore'] ) {
		$options['post_per_page_ignore'] = 1;
		update_option( 'portfoliopress', $options );
	}

	if ( isset( $_GET['portfolio_update_posts_per_page'] ) && '1' == $_GET['portfolio_update_posts_per_page'] ) {
		update_option( 'posts_per_page', 9 );
	}

	if ( isset( $_GET['portfolio_thumbnails_ignore'] ) && '1' == $_GET['portfolio_thumbnails_ignore'] ) {
		$options['regnerate_thumbnails'] = 1;
		update_option( 'portfoliopress', $options );
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


/**
 * Notice that Options Framework plugin is no longer needed.
 */
function portfoliopress_optionsframework_notice() {

	// Only show notice if Options Framework is installed
	if ( ! function_exists( 'optionsframework_init' ) ) {
		return;
	}

	global $pagenow;
    if ( !is_multisite() && ( $pagenow == 'plugins.php' || $pagenow == 'themes.php' ) ) {
		echo '<div class="updated portfolio-press-options"><p>';
		printf(
            __( 'Portfolio Press options are now in the <a href="%s">customizer</a>. You can safely remove the Options Framework plugin from your site.', 'portfolio-press' ),
            admin_url( 'customize.php' )
        );
		echo "</p></div>";
    }
}
add_action( 'admin_notices', 'portfoliopress_optionsframework_notice' );