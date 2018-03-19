<?php
/**
 * Customizer Utility Functions
 *
 * @package 	Customizer_Library
 * @author		Devin Price, The Theme Foundry
 */

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function customizer_library_customize_preview_js() {

	$path = str_replace( WP_CONTENT_DIR, WP_CONTENT_URL, dirname( dirname( __FILE__ ) ) );

	wp_enqueue_script(
		'customizer_library_customizer',
		$path . '/js/customizer.js',
		array( 'customize-preview' ),
		'1.0.0',
		true
	);

}
add_action( 'customize_preview_init', 'customizer_library_customize_preview_js' );

/**
 * Display upgrade notice on customizer page
 */
function portfoliopress_upgrade_notice() {

	$path = str_replace( WP_CONTENT_DIR, WP_CONTENT_URL, dirname( dirname( __FILE__ ) ) );

	wp_enqueue_script(
		'portfoliopress_upgrade',
		$path . '/js/upgrade.js',
		array(),
		'1.0.0',
		true
	);

	// Localize the script
	wp_localize_script(
		'portfoliopress_upgrade',
		'portfoliopressL10n',
		array(
			'plusURL'	=> esc_url( 'https://wptheming.com/portfolio-plus' ),
			'plusLabel'	=> __( 'Upgrade to Portfolio+', 'portfolio-press' ),
		)
	);

}
add_action( 'customize_controls_enqueue_scripts', 'portfoliopress_upgrade_notice' );

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function customizer_library_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
}
add_action( 'customize_register', 'customizer_library_customize_register' );
