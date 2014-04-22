<?php
/**
 * @package Portfolio Press
 */

/**
 * Helper function to get options set by the Options Framework plugin
 */
if ( !function_exists( 'of_get_option' ) ) :
function of_get_option( $name, $default = false ) {

	$optionsframework_settings = get_option( 'optionsframework' );

	// Gets the unique option id
	$option_name = $optionsframework_settings['id'];

	if ( get_option($option_name) ) {
		$options = get_option($option_name);
	}

	if ( isset($options[$name]) ) {
		return $options[$name];
	} else {
		return $default;
	}
}
endif;

/**
 * Adds a body class to indicate sidebar position
 */
function portfoliopress_body_class_options( $classes ) {

	// Layout options
	$classes[] = of_get_option( 'layout','layout-2cr' );

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
	if ( $favicon ) {
        echo '<link rel="shortcut icon" href="' . esc_url( $favicon ) . '"/>'."\n";
    }
}
add_action( 'wp_head', 'portfolio_favicon' );

/**
 * Menu Position Option
 */
function portfolio_head_css() {

		$output = '';

		if ( of_get_option( 'header_color' ) != "#000000") {
			$output .= "#branding {background:" . of_get_option('header_color') . "}\n";
		}

		// Output styles
		if ($output <> '') {
			$output = "<!-- Custom Styling -->\n<style type=\"text/css\">\n" . $output . "</style>\n";
			echo $output;
		}
}

add_action( 'wp_head', 'portfolio_head_css' );

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

/**
 * Front End Customizer
 *
 * WordPress 3.4 Required
 */

if ( function_exists( 'optionsframework_init' ) ) {
	add_action( 'customize_register', 'portfoliopress_customize_register' );
}

function portfoliopress_customize_register( $wp_customize ) {

	$options = optionsframework_options();

	/* Title & Tagline */

	$wp_customize->add_setting( 'portfoliopress[logo]', array(
		'type' => 'option'
	) );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'logo', array(
		'label' => $options['logo']['name'],
		'section' => 'title_tagline',
		'settings' => 'portfoliopress[logo]'
	) ) );

	/* Layout */

	$wp_customize->add_section( 'portfoliopress_layout', array(
		'title' => __( 'Layout', 'portfolio-press' ),
		'priority' => 100,
	) );

	$wp_customize->add_setting( 'portfoliopress[layout]', array(
		'default' => 'layout-2cr',
		'type' => 'option'
	) );

	$wp_customize->add_control( 'portfoliopress_layout', array(
		'label' => $options['layout']['name'],
		'section' => 'portfoliopress_layout',
		'settings' => 'portfoliopress[layout]',
		'type' => 'radio',
		'choices' => array(
			'layout-2cr' => __( 'Sidebar Right', 'portfolio-press' ),
			'layout-2cl' => __( 'Sidebar Left', 'portfolio-press' ),
			'layout-1col' => __( 'Single Column', 'portfolio-press' )
		)
	) );

	$wp_customize->add_setting( 'portfoliopress[menu_position]', array(
		'default' => 'right',
		'type' => 'option'
	) );

	$wp_customize->add_control( 'portfoliopress_menu_position', array(
		'label' => $options['menu_position']['name'],
		'section' => 'nav',
		'settings' => 'portfoliopress[menu_position]',
		'type' => 'radio',
		'choices' => $options['menu_position']['options']
	) );

	/* Header Styles */

	$wp_customize->add_section( 'portfoliopress_header_styles', array(
		'title' => __( 'Header Style', 'portfolio-press' ),
		'priority' => 105,
	) );

	$wp_customize->add_setting( 'portfoliopress[header_color]', array(
		'default' => '#000000',
		'type' => 'option'
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_color', array(
		'label' => __( 'Background Color', 'portfolio-press' ),
		'section' => 'portfoliopress_header_styles',
		'settings' => 'portfoliopress[header_color]'
	) ) );

	/* PostMessage Support */
	$wp_customize->get_setting( 'portfoliopress[header_color]' )->transport = 'postMessage';
}

/**
 * Register asynchronous customizer support for core controls.
 */
function portfoliopress_async_suport_core( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
}
add_action( 'customize_register', 'portfoliopress_async_suport_core' );

/**
 * Enqueue script enabling asynchronous customizer support.
 */
function portfoliopress_customize_preview_js() {
	wp_enqueue_script( 'portfoliopress_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20140221', true );
}
add_action( 'customize_preview_init', 'portfoliopress_customize_preview_js' );