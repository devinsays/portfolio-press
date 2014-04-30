<?php
/**
 * This file only gets loaded if the Options Framework plugin is installed
 *
 * A unique identifier is defined to store the options in the database
 * and reference them from the theme.  By default it uses 'portfolio-press'.
 * If the identifier changes, it'll appear as if the options have been reset.
 *
 * @package Portfolio Press
 */

function optionsframework_option_name() {

	$optionsframework_settings = get_option('optionsframework');
	$optionsframework_settings['id'] = 'portfoliopress';
	update_option('optionsframework', $optionsframework_settings);

}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the "id" fields, make sure to use all lowercase and no spaces.
 *
 * @returns array $options
 */

function optionsframework_options() {

	// If using image radio buttons, define a directory path
	$imagepath =  esc_url( get_template_directory_uri() . '/images/' );

	// Options array
	$options = array();

	/* General Settings */

	$options[] = array(
		"name" => __( 'General Settings', 'portfolio-press' ),
		"type" => "heading"
	);

	$options['logo'] = array(
		"name" => __( 'Custom Logo', 'portfolio-press' ),
		"desc" => __( 'Upload a logo for your theme if you would like to use one.','portfolio-press' ),
		"id" => "logo",
		"type" => "upload");

	$options[] = array(
		"name" => __( 'Custom Favicon', 'portfolio-press' ),
		"desc" => __( 'Upload a 16px x 16px png/gif image to represent your website.' , 'portfolio-press' ),
		"id" => "custom_favicon",
		"type" => "upload"
	);

	if ( class_exists( 'Portfolio_Post_Type' ) ) {

		$options[] = array(
			"name" => __( 'Display Images on Portfolio / Image Posts', 'portfolio-press' ),
			"desc" => __( 'Display featured images automatically on posts.', 'portfolio-press' ),
			"id" => "portfolio_images",
			"std" => "1",
			"type" => "checkbox"
		);

	} else {

		$options[] = array(
			"name" => __( 'Display Images Automatically on Image Post Formats', 'portfolio-press' ),
			"desc" => __( 'Display featured images automatically on posts.', 'portfolio-press' ),
			"id" => "portfolio_images",
			"std" => "1",
			"type" => "checkbox"
		);

	}

	if ( class_exists( 'Portfolio_Post_Type' ) ) {

		$options[] = array(
			"name" => __( 'Display Portfolio / Image / Galleries Full Width', 'portfolio-press' ),
			"desc" => __( 'Display all image based archives full width.', 'portfolio-press' ),
			"id" => "portfolio_sidebar",
			"std" => "0",
			"type" => "checkbox"
		);

	} else {

		$options[] = array(
			"name" => __( 'Display Image and Gallery Post Format Archives Full Width', 'portfolio-press' ),
			"desc" => __( 'Display all image/gallery archives full width.', 'portfolio-press' ),
			"id" => "portfolio_sidebar",
			"std" => "0",
			"type" => "checkbox"
		);

	}

	$options[] = array(
		"name" => __( 'Display Image and Gallery Formats on Posts Page', 'portfolio-press' ),
		"desc" => __( 'Display all post formats on posts page.', 'portfolio-press' ),
		"id" => "display_image_gallery_post_formats",
		"std" => "1",
		"type" => "checkbox"
	);

	$options['archive_titles'] = array(
		'name' => __( 'Archive Titles', 'portfolio-press' ),
		'desc' => __( 'Display archive titles and descriptions.', 'portfolio-press' ),
		'id' => 'archive_titles',
		'std' => '1',
		'type' => 'checkbox'
	);

	$options[] = array(
		'name' => __( 'Posts Per Page', 'portfolio-press' ),
		'desc' => sprintf( '<p>%s</p>',
			sprintf(
				__( 'Posts per page can be set in the <a href="%s">reading options</a>.', 'portfolio-press' ),
				admin_url( 'options-reading.php', false )
				)
			),
		'type' => 'info'
	);

	/* Style and Layout */

	$options[] = array(
		"name" => __( 'Style and Layout','portfolio-press' ),
		"type" => "heading");

	$options['layout'] = array(
		'name' => __( 'Main Layout','portfolio-press' ),
		'desc' => __( 'Select main content and sidebar alignment.','portfolio-press' ),
		'id' => 'layout',
		'std' => 'layout-2cr',
		'type' => 'images',
		'options' => array(
			'layout-2cr' => $imagepath . '2cr.png',
			'layout-2cl' => $imagepath . '2cl.png',
			'layout-1col' => $imagepath . '1cl.png')
		);

	$options[] = array(
		"name" => __( 'Header Color','portfolio-press' ),
		"id" => "header_color",
		"std" => "#000000",
		"type" => "color"
	);

	$options['menu_position'] = array(
		"name" => __( 'Menu Position', 'portfolio-press' ),
		"desc" => __( 'Select where the main menu should go in the header.  Long menus should go underneath.','portfolio-press' ),
		"id" => "menu_position",
		"std" => "right",
		"type" => "radio",
		"options" => array(
			"right" => __( 'Right of logo.', 'portfolio-press' ),
			"clear" => __( 'Underneath logo', 'portfolio-press' )
		)
	);

	/* Footer Settings */

	$options[] = array(
		"name" => __( 'Footer Settings', 'portfolio-press' ),
		"type" => "heading"
	);

	$options[] = array(
		"name" => __( 'Custom Footer Text', 'portfolio-press' ),
		"desc" => __( 'Custom text that will appear in the footer of your theme.','portfolio-press' ),
		"id" => "footer_text",
		"type" => "textarea"
	);

	/* More Information */

	$options[] = array(
		"name" => __( 'More', 'portfolio-press' ),
		"type" => "heading"
	);

	$options[] = array(
		'name' => __( 'Theme Support', 'portfolio-press' ),
		'desc' => sprintf(
				'<p>%s</p>',
				sprintf(
					__( 'If you need help with Portfolio Press, check if your question has been answered in the <a href="%s">theme FAQ</a>.', 'portfolio-press' ),
					esc_url( 'http://wptheming.com/portfolio-press' )
				)
			),
		'type' => 'info'
	);

	$options[] = array(
		'name' => __( 'Additional Options in Portfolio+', 'portfolio-press' ),
		'desc' => sprintf(
				'<p>%s</p><p>%s</p><ul><li>%s</li><li>%s</li><li>%s</li><li>%s</li><li>%s</li><li>%s</li></ul><p>%s</p>',
				sprintf(
					__( 'If you like this theme and would like to support further development, consider purchasing <a href="%s">Portfolio+</a>.', 'portfolio-press' ),
					esc_url( 'http://wptheming.com/portfolio-plus' )
				),
				__( 'You will also get these additional features:', 'portfolio-press' ),
				__( 'Text Color Options', 'portfolio-press' ),
				__( 'Background Stye Options', 'portfolio-press' ),
				__( 'Additional Page Templates', 'portfolio-press' ),
				__( 'Option to Hide Post Dates', 'portfolio-press' ),
				__( 'Infinite Scroll', 'portfolio-press' ),
				__( 'Priority Support', 'portfolio-press' ),
				sprintf(
					__( '<a href="%s">Read More</a>', 'portfolio-press' ),
					esc_url( 'http://wptheming.com/portfolio-plus' )
				)
			),
		'type' => 'info'
	);

	/* Utility Options (Not Displayed) */

	$options[] = array(
		"name" => __( 'Upgrade', 'portfolio-press' ),
		"id" => "upgrade",
		"std" => '0',
		"class" => "hidden",
		"type" => "text" );

	$options[] = array(
		"name" => __( 'Version', 'portfolio-press' ),
		"id" => "version",
		"std" => '1.9',
		"class" => "hidden",
		"type" => "text"
	);

	return $options;
}

/**
 * Additional content to display after the options panel
 */
function portfoliopress_panel_info() { ?>
    <p style="color: #777;">
    <?php printf(
    	__( 'Theme <a href="%s">documentation</a>.  For additional options, see <a href="%s">Portfolio+</a>.', 'portfolio-press' ),
    	esc_url( 'http://wptheming.com/portfolio-press' ),
    	esc_url( 'http://wptheming.com/portfolio-plus' )
    );
    ?>
    </p>
<?php }

add_action( 'optionsframework_after', 'portfoliopress_panel_info', 100 );