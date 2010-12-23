<?php

add_action('init','of_options');

if (!function_exists('of_options')) {
function of_options(){
	
// VARIABLES
$themename = get_theme_data(STYLESHEETPATH . '/style.css');
$themename = $themename['Name'];
$shortname = "of";

// Populate OptionsFramework option in array for use in theme
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

// Set the Options Array
$options = array();

$options[] = array( "name" => "General Settings",
                    "type" => "heading");
					

$options[] = array( "name" => "Custom Logo",
					"desc" => "Upload a logo for your theme, or specify the image address of your online logo. (http://yoursite.com/logo.png)",
					"id" => $shortname."_logo",
					"std" => "",
					"type" => "upload");
					
$url =  OF_DIRECTORY . '/admin/images/';
$options[] = array( "name" => "Main Layout",
					"desc" => "Select main content and sidebar alignment.",
					"id" => $shortname."_layout",
					"std" => "2c-r-fixed",
					"type" => "images",
					"options" => array(
						'2c-r-fixed' => $url . '2cr.png',
						'2c-l-fixed' => $url . '2cl.png')
					);
					
$options[] = array( "name" => "Menu Position",
					"desc" => "Select where the main menu should go in the header.",
					"id" => $shortname."_example_radio",
					"std" => "one",
					"type" => "radio",
					"options" => array("right" => "To the right of logo or header text","clear" => "Underneath logo or header text"));
					
$options[] = array( "name" => "Use Portfolio as Home Page",
					"desc" => "If checked, your portfolio will show up on the home page.",
					"id" => $shortname."_portfolio_home",
					"std" => "false",
					"type" => "checkbox");
					
$options[] = array( "name" => "Custom Favicon",
					"desc" => "Upload a 16px x 16px Png/Gif image that will represent your website's favicon.",
					"id" => $shortname."_custom_favicon",
					"std" => "",
					"type" => "upload");                                                  
    
$options[] = array( "name" => "Styling Options",
					"type" => "heading");
					
$options[] = array( "name" => "Theme Stylesheet",
					"desc" => "Select your themes alternative color scheme.",
					"id" => $shortname."_alt_stylesheet",
					"std" => "default.css",
					"type" => "select",
					"options" => $alt_stylesheets);
					
$options[] = array( "name" => "Custom CSS",
                    "desc" => "Quickly add some CSS to your theme by adding it to this block.",
                    "id" => $shortname."_custom_css",
                    "std" => "",
                    "type" => "textarea");
					
$options[] = array( "name" => "Footer Settings",
					"type" => "heading");  

$options[] = array( "name" => "Custom Footer Text (Left)",
					"desc" => "Custom HTML/Text that will appear in the footer of your theme.",
					"id" => $shortname."_footer_left_text",
					"std" => "",
					"type" => "text");    

$options[] = array( "name" => "Custom Footer Text (Right)",
					"desc" => "Custom HTML/Text that will appear in the footer of your theme.",
					"id" => $shortname."_footer_right_text",
					"std" => "",
					"type" => "text");
					
$options[] = array( "name" => "Tracking Code",
					"desc" => "Paste your Google Analytics (or other) tracking code here. This will be added into the footer template of your theme.",
					"id" => $shortname."_google_analytics",
					"std" => "",
					"type" => "textarea");

update_option('of_template',$options); 					  
update_option('of_themename',$themename);   
update_option('of_shortname',$shortname);

}
}
?>
