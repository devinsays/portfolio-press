<?php
/**
 * @package Portfolio Press
 */

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

	if ( current_user_can( 'manage_options' ) ) { ?>
		<div class="updated notice" style="position: relative">
			<p>
			<?php printf( __(
				'Portfolio Press recommends setting <a href="%2$s">posts per page</a> to 9 or 12. <a href="%1$s">Update</a>', 'portfolio-press' ),
				'?portfolio_update_posts_per_page=1',
				admin_url( 'options-reading.php', false )
			); ?>
			</p>
			<a href="?portfolio_post_per_page_ignore=1">
				<button type="button" class="notice-dismiss">
					<span class="screen-reader-text">
						<?php _e( 'Dismiss this notice.', 'portfolio-press' ); ?>
					</span>
				</button>
			</a>
		</div>
	<?php }
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

	if ( current_user_can( 'manage_options' ) ) { ?>
		<div class="updated notice" style="position: relative;">
			<p>
			<?php printf( __(
				'Portfolio Press recommends regenerating thumbnails. <a href="%1$s" target="_blank">Read More</a>', 'portfolio-press' ),
				esc_url( 'https://wordpress.org/plugins/regenerate-thumbnails/' )
			); ?>
		</p>
		<a href="?portfolio_thumbnails_ignore=1">
			<button type="button" class="notice-dismiss">
				<span class="screen-reader-text">
					<?php _e( 'Dismiss this notice.', 'portfolio-press' ); ?>
				</span>
			</button>
		</a>
	</div>
	<?php }
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
	if ( ! class_exists( 'Portfolio_Post_Type' ) ) {
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
