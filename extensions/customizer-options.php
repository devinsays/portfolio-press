<?php
/**
 * Customizer options.
 *
 * @package Portfolio Press
 */

function portfoliopress_options() {

	// Stores all the controls that will be added
	$options = array();

	// Stores all the sections to be added
	$sections = array();

	// Logo section
	$section = 'title_tagline';

	$options['portfoliopress[logo]'] = array(
		'id' => 'portfoliopress[logo]',
		'option_type' => 'option',
		'label'   => __( 'Logo', 'portfolio-press' ),
		'section' => $section,
		'type'    => 'image',
		'default' => '',
		'priority' => 20
	);

	// Layout
	$section = 'portfolio_press';

	$sections[] = array(
		'id' => $section,
		'title' => __( 'Theme Options', 'portfolio-press' ),
		'priority' => '70'
	);

	$choices = array(
		'layout-2cr' => __( 'Sidebar Right', 'portfolio-press' ),
		'layout-2cl' => __( 'Sidebar Left', 'portfolio-press' ),
		'layout-1col' => __( 'Single Column', 'portfolio-press' )
	);

	$options['portfoliopress[layout]'] = array(
		'id' => 'portfoliopress[layout]',
		'option_type' => 'option',
		'label'   => __( 'Standard Layout', 'portfolio-press' ),
		'section' => $section,
		'type'    => 'select',
		'choices' => $choices,
		'default' => 'layout-2cr'
	);

	$options['portfoliopress[header_color]'] = array(
		'id' => 'portfoliopress[header_color]',
		'option_type' => 'option',
		'label'   => __( 'Header Color', 'portfolio-press' ),
		'section' => $section,
		'type'    => 'color',
		'default' => '#000000',
	);

	$choices = array(
		'right' => __( 'Right of Logo', 'portfolio-press' ),
		'clear' => __( 'Underneath Logo', 'portfolio-press' )
	);

	$options['portfoliopress[menu_position]'] = array(
		'id' => 'portfoliopress[menu_position]',
		'option_type' => 'option',
		'label'   => __( 'Menu Position', 'portfolio-press' ),
		'section' => $section,
		'type'    => 'select',
		'choices' => $choices,
		'default' => 'right',
	);

	// Portfolio Post Type Plugin
	if ( class_exists( 'Portfolio_Post_Type' ) ) :

		$options['portfoliopress[portfolio_featured_images]'] = array(
			'id' => 'portfoliopress[portfolio_images]',
			'option_type' => 'option',
			'label' => __( 'Display Featured Images', 'portfolio-press' ),
			'description' => __( 'Display featured images on portfolio posts.', 'portfolio-press' ),
			'section' => $section,
			'type'    => 'checkbox',
			'default' => '1',
		);

	else :

		$options['portfoliopress[post_featured_images]'] = array(
			'id' => 'portfoliopress[portfolio_images]',
			'option_type' => 'option',
			'label' => __( 'Display Featured Images', 'portfolio-press' ),
			'description' => __( 'Display featured images on posts.', 'portfolio-press' ),
			'section' => $section,
			'type'    => 'checkbox',
			'default' => '1',
		);

	endif;

	$options['portfoliopress[postnav]'] = array(
		'id' => 'portfoliopress[postnav]',
		'option_type' => 'option',
		'label' => __( 'Display post navigation', 'portfolio-press' ),
		'description' => __( 'Previous/next links on posts.', 'portfolio-press' ),
		'section' => $section,
		'type'    => 'checkbox',
		'default' => '0',
	);

		// Portfolio Post Type Plugin
	if ( class_exists( 'Portfolio_Post_Type' ) ) :

		$options['portfoliopress[portfolio_archives_fullwidth]'] = array(
			'id' => 'portfoliopress[portfolio_sidebar]',
			'option_type' => 'option',
			'label' => __( 'Full Width Archives', 'portfolio-press' ),
			'description' => __( 'Display portfolio archives full width.', 'portfolio-press' ),
			'section' => $section,
			'type'    => 'checkbox',
			'default' => '1',
		);

	else :

		$options['portfoliopress[post_archives_fullwidth]'] = array(
			'id' => 'portfoliopress[portfolio_sidebar]',
			'option_type' => 'option',
			'label' => __( 'Full Width Archives', 'portfolio-press' ),
			'description' => __( 'Display image/gallery archives full width.', 'portfolio-press' ),
			'section' => $section,
			'type'    => 'checkbox',
			'default' => '1',
		);

	endif;

	$options['portfoliopress[display_image_gallery_post_formats]'] = array(
		'id' => 'portfoliopress[display_image_gallery_post_formats]',
		'option_type' => 'option',
		'label' => __( 'Display Image and Gallery Formats on Posts Page', 'portfolio-press' ),
		'section' => $section,
		'type'    => 'checkbox',
		'default' => '1',
	);

	$options['portfoliopress[archive_titles]'] = array(
		'id' => 'portfoliopress[archive_titles]',
		'option_type' => 'option',
		'label' => __( 'Archive Titles', 'portfolio-press' ),
		'description' => __( 'Display archive titles and descriptions.', 'portfolio-press' ),
		'section' => $section,
		'type'    => 'checkbox',
		'default' => '1',
	);

	$options['portfoliopress[footer_text]'] = array(
		'id' => 'portfoliopress[footer_text]',
		'option_type' => 'option',
		'label' => __( 'Footer Text', 'portfolio-press' ),
		'section' => $section,
		'type' => 'textarea',
		'default' => ''
	);

	// Adds the sections to the $options array
	$options['sections'] = $sections;

	$customizer_library = Customizer_Library::Instance();
	$customizer_library->add_options( $options );

}
add_action( 'init', 'portfoliopress_options', 100 );