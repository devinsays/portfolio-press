<?php
/**
 * @package Portfolio Press
 */

// Include the TGM_Plugin_Activation class.
require_once dirname( __FILE__ ) . '/class-tgm-plugin-activation.php';

function portfoliopress_recommended_plugins() {

	// Recommended Plugins
	$plugins = array(

		// Options Framework
		array(
			'name' 		=> 'Options Framework',
			'slug' 		=> 'options-framework',
			'required' 	=> false,
		),

		// Regenerate thumbnails
		array(
			'name' 		=> 'Regenerate Thumbnails',
			'slug' 		=> 'regenerate-thumbnails',
			'required' 	=> false,
		),

	);

    // Strings for translations
    $config = array();

    tgmpa( $plugins, $config );

}
add_action( 'tgmpa_register', 'portfoliopress_recommended_plugins' );