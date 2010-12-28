<?php

add_action('init','of_options');

if (!function_exists('of_options')) {
function of_options(){
	
// VARIABLES
$themename = get_theme_data(STYLESHEETPATH . '/style.css');
$themename = $themename['Name'];
$shortname = "ppo";  // Unique shortname, Portfolio Press Options

// Populate options in array for use in theme
global $of_options;
$of_options = get_option('of_options');

$GLOBALS['template_path'] = OF_DIRECTORY;

//Stylesheets Reader
$alt_stylesheet_path = OF_FILEPATH . '/styles/';
$alt_stylesheets = array();

if ( is_dir($alt_stylesheet_path) ) {
    if ($alt_stylesheet_dir = opendir($alt_stylesheet_path) ) { 
        while ( ($alt_stylesheet_file = readdir($alt_stylesheet_dir)) !== false ) {
            if(stristr($alt_stylesheet_file, ".css") !== false) {
                $alt_stylesheets[] = $alt_stylesheet_file;
            }
        }    
    }
}

//More Options
$uploads_arr = wp_upload_dir();
$all_uploads_path = $uploads_arr['path'];
$all_uploads = get_option('of_uploads');
$url =  OF_DIRECTORY . '/admin/images/';

// Set the Options Array
$options = array();

$options[] = array( "name" => __('General Settings','portfoliopress'),
                    "type" => "heading");
					
$options[] = array( "name" => __('Use Portfolio as Home Page','portfoliopress'),
					"desc" => __('General Settings','portfoliopress'),
					"id" => $shortname."_portfolio_home",
					"std" => "false",
					"type" => "checkbox");
					
$options[] = array( "name" => __('Display Portfolio Images Automatically','portfoliopress'),
					"desc" => __('Uncheck this if you wish to manually display portfolio images on single posts.','portfoliopress'),
					"id" => $shortname."_portfolio_images",
					"std" => "true",
					"type" => "checkbox");

$options[] = array( "name" => __('Custom Logo','portfoliopress'),
					"desc" => __('Upload a logo for your theme, or specify the image address of your online logo. (http://yoursite.com/logo.png)','portfoliopress'),
					"id" => $shortname."_logo",
					"std" => "",
					"type" => "upload");
					
$options[] = array( "name" => __('Custom Favicon','portfoliopress'),
					"desc" => __('Upload a 16px x 16px Png/Gif image to represent your website.','portfoliopress'),
					"id" => $shortname."_custom_favicon",
					"std" => "",
					"type" => "upload"); 
					
					
$options[] = array( "name" => __('Disable Portfolio Menu','portfoliopress'),
					"desc" => __('Check this if you are not planning to use the portfolio post type. Refresh browser after selecting.','portfoliopress'),
					"id" => $shortname."_disable_portfolio",
					"std" => "false",
					"type" => "checkbox");                                                 
    
$options[] = array( "name" => __('Style and Layout','portfoliopress'),
					"type" => "heading");
					
$options[] = array( "name" => __('Main Layout','portfoliopress'),
					"desc" => __('Select main content and sidebar alignment.','portfoliopress'),
					"id" => $shortname."_layout",
					"std" => "layout-2cr",
					"type" => "images",
					"options" => array(
						'layout-2cr' => $url . '2cr.png',
						'layout-2cl' => $url . '2cl.png')
					);
					
$options[] = array( "name" => __('Menu Position','portfoliopress'),
					"desc" => __('Select where the main menu should go in the header.','portfoliopress'),
					"id" => $shortname."_menu_pos",
					"std" => "right",
					"type" => "radio",
					"options" => array("right" => "Right of logo.","clear" => "Underneath logo."));
					
$options[] = array( "name" => __('Theme Stylesheet','portfoliopress'),
					"desc" => __('There are no additional stylesheets right now.  Let\'s go with the default.','portfoliopress'),
					"id" => $shortname."_alt_stylesheet",
					"std" => "default.css",
					"type" => "select",
					"options" => $alt_stylesheets);
					
$options[] = array( "name" => __('Custom CSS','portfoliopress'),
					"desc" => __('Quickly add some CSS to your theme by adding it to this block.','portfoliopress'),
                    "id" => $shortname."_custom_css",
                    "std" => "",
                    "type" => "textarea");
					
$options[] = array( "name" => __('Footer Settings','portfoliopress'),
					"type" => "heading");  

$options[] = array( "name" => __('Custom Footer Text','portfoliopress'),
					"desc" => __('Custom HTML/Text that will appear in the footer of your theme.','portfoliopress'),
					"id" => $shortname."_footer_text",
					"std" => "",
					"type" => "text");    
					
$options[] = array( "name" => __('Tracking Code','portfoliopress'),
					"desc" => __('Paste your Google Analytics (or other) tracking code here. This will be added into the footer template of your theme.','portfoliopress'),
					"id" => $shortname."_google_analytics",
					"std" => "",
					"type" => "textarea");

update_option('of_template',$options); 					  
update_option('of_themename',$themename);   
update_option('of_shortname',$shortname);

}
}
?>
