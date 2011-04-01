<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses 'portfoliopress'.  If the identifier changes, it'll appear as if the options have been reset.
 * 
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
 */

function optionsframework_options() {
		
	// If using image radio buttons, define a directory path
	$imagepath =  get_bloginfo('template_url') . '/images/';
	
	// Options array	
	$options = array();
		
	$options[] = array( "name" => __('General Settings','portfoliopress'),
                    	"type" => "heading");
						
	$options[] = array( "name" => __('Display Images on Portfolio Posts','portfoliopress'),
						"desc" => __('Uncheck this if you wish to manually display portfolio images on single posts.','portfoliopress'),
						"id" => "portfolio_images",
						"std" => "true",
						"type" => "checkbox");
						
	$options[] = array( "name" => __('Custom Logo','portfoliopress'),
						"desc" => __('Upload a logo for your theme if you would like to use one.','portfoliopress'),
						"id" => "logo",
						"type" => "upload");
						
	$options[] = array( "name" => __('Custom Favicon','portfoliopress'),
						"desc" => __('Upload a 16px x 16px Png/Gif image to represent your website.','portfoliopress'),
						"id" => "custom_favicon",
						"type" => "upload"); 
						
	$options[] = array( "name" => __('Disable Portfolio','portfoliopress'),
						"desc" => __('Check this if you are not planning to use the portfolio post type.  You can always re-enable it.','portfoliopress'),
						"id" => "disable_portfolio",
						"std" => "false",
						"type" => "checkbox");                                                 
    
	$options[] = array( "name" => __('Style and Layout','portfoliopress'),
						"type" => "heading");
					
	$options[] = array( "name" => __('Main Layout','portfoliopress'),
						"desc" => __('Select main content and sidebar alignment.','portfoliopress'),
						"id" => "layout",
						"std" => "layout-2cr",
						"type" => "images",
						"options" => array(
						'layout-2cr' => $imagepath . '2cr.png',
						'layout-2cl' => $imagepath . '2cl.png')
						);
					
	$options[] = array( "name" => __('Menu Position','portfoliopress'),
						"desc" => __('Select where the main menu should go in the header.  Long menus should go underneath.','portfoliopress'),
						"id" => "menu_position",
						"std" => "right",
						"type" => "radio",
						"options" => array("right" => "Right of logo.","clear" => "Underneath logo."));
					
					
	$options[] = array( "name" => __('Footer Settings','portfoliopress'),
						"type" => "heading");  
	
	$options[] = array( "name" => __('Custom Footer Text','portfoliopress'),
						"desc" => __('Custom HTML/Text that will appear in the footer of your theme.','portfoliopress'),
						"id" => "footer_text",
						"type" => "textarea");
									
	return $options;
}