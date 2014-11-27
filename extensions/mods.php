<?php
/**
 * @package Portfolio Press
 */

/**
 * Helper function to get saved options
 */
if ( !function_exists( 'of_get_option' ) ) :
function of_get_option( $name, $default = false ) {

	$options = get_option( 'portfoliopress' );

	if ( isset( $options[$name] ) ) {
		return $options[$name];
	}

	return $default;
}
endif;

/**
 * Adds a body class to indicate sidebar position
 */
function portfoliopress_body_class_options( $classes ) {

	// Layout options
	$classes[] = of_get_option( 'layout', 'layout-2cr' );

	// Clear the menu if selected
	if ( of_get_option( 'menu_position', false ) == 'clear' ) {
		$classes[] = 'clear-menu';
	}

	return $classes;
}
add_filter( 'body_class', 'portfoliopress_body_class_options' );

/**
 * Favicon Option
 */
function portfolio_favicon() {

	$favicon = of_get_option( 'custom_favicon', false );
	if ( $favicon ) : ?>
        <link rel="shortcut icon" href="<?php echo esc_url( $favicon ); ?>" />
    <?php endif;

    $logo_apple_touch = of_get_option( 'logo_apple_touch', false );
	if ( $logo_apple_touch ) : ?>
		<link rel="apple-touch-icon" href="<?php echo esc_url( $logo_apple_touch ); ?>" />
	<?php endif;

}
add_action( 'wp_head', 'portfolio_favicon' );

/**
 * Menu Position Option
 */
function portfoliopress_head_css() {

		$output = '';

		if ( of_get_option( 'header_color' ) != "#000000" ) {
			$output .= "#branding {background:" . of_get_option('header_color') . "}\n";
		}

		// Output styles
		if ($output <> '') {
			$output = "<!-- Portfolio Press Styling -->\n<style type=\"text/css\">\n" . $output . "</style>\n";
			echo $output;
		}
}
add_action( 'wp_head', 'portfoliopress_head_css' );

/**
 * Removes image and gallery post formats from is_home if option is set
 */
function portfoliopress_exclude_post_formats( $query ) {
	if (
		! of_get_option( 'display_image_gallery_post_formats', true ) &&
		$query->is_main_query() &&
		$query->is_home()
	) {
		$tax_query = array(
			array(
				'taxonomy' => 'post_format',
				'field' => 'slug',
				'terms' => array(
					'post-format-image',
					'post-format-gallery'
				),
				'operator' => 'NOT IN',
			)
		);
		$query->set( 'tax_query', $tax_query );
	}
}
add_action( 'pre_get_posts', 'portfoliopress_exclude_post_formats' );