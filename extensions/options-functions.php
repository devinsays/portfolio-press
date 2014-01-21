<?php
/**
 * @package Portfolio Press
 */
 
/**
 * Theme options require the "Options Framework" plugin to be installed in order to display.
 * If it's not installed, default settings will be used.
 */
 
if ( !function_exists( 'of_get_option' ) ) {
function of_get_option($name, $default = false) {
	
	$optionsframework_settings = get_option('optionsframework');
	
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
}

if ( !function_exists( 'optionsframework_add_page' ) && current_user_can('edit_theme_options') ) {
	function portfolio_options_default() {
		add_theme_page(__('Theme Options','portfoliopress'), __('Theme Options','portfoliopress'), 'edit_theme_options', 'options-framework','optionsframework_page_notice');
	}
	add_action('admin_menu', 'portfolio_options_default');
}

/**
 * Displays a notice on the theme options page if the Options Framework plugin is not installed
 */

if ( !function_exists( 'optionsframework_page_notice' ) ) {
	function optionsframework_page_notice() { ?>
	
		<div class="wrap">
		<?php screen_icon( 'themes' ); ?>
		<h2><?php _e('Theme Options','portfoliopress'); ?></h2>
        <p><b><?php printf( __( 'If you would like to use the Portfolio Press theme options, please install the %s plugin.', 'portfoliopress' ), '<a href="http://wordpress.org/extend/plugins/options-framework/">Options Framework</a>' ); ?></b></p>
        <p><?php _e('Once the plugin is activated you will have option to:','portfoliopress'); ?></p>
        <ul class="ul-disc">
        <li><?php _e('Upload a logo image','portfoliopress'); ?></li>
        <li><?php _e('Change the sidebar position','portfoliopress'); ?></li>
        <li><?php _e('Change the menu position','portfoliopress'); ?></li>
        <li><?php _e('Hide the portfolio image on the single post','portfoliopress'); ?></li>
        <li><?php _e('Update the footer text','portfoliopress'); ?></li>
        </ul>
        
        <p><?php _e('If you don\'t need these options, the plugin is not required and default settings will be used.','portfoliopress'); ?></p>
		</div>
	<?php
	}
}

/**
 * Additional content to display after the options panel
 * if it is installed
 */

function portfoliopress_panel_info() { ?>
    <p style="color: #777;">Theme <a href="http://wptheming.com/portfolio-theme">documentation</a>.  For additional options, see <a href="http://wptheming.com/portfolio-plus/">Portfolio+</a>.</p>
<?php }

add_action('optionsframework_after','portfoliopress_panel_info', 100);

/**
 * Adds a body class to indicate sidebar position
 */
 
function portfolio_body_class($classes) {
	$layout = of_get_option('layout','layout-2cr');
	$classes[] = $layout;
	return $classes;
}

add_filter('body_class','portfolio_body_class');

/**
 * Favicon Option
 */

function portfolio_favicon() {
	$favicon = of_get_option('custom_favicon', false);
	if ( $favicon ) {
        echo '<link rel="shortcut icon" href="'.  $favicon  .'"/>'."\n";
    }
}

add_action('wp_head', 'portfolio_favicon');

/**
 * Menu Position Option
 */

function portfolio_head_css() {
				
		$output = '';
		
		if ( of_get_option('menu_position') == "clear") {
			$output .= "#navigation {clear:both; float:none; margin-left:-10px;}\n";
			$output .= "#navigation ul li {margin-left:0; margin-right:10px;}\n";
		}
		
		if ( of_get_option('header_color') != "#000000") {
			$output .= "#branding {background:" . of_get_option('header_color') . "}\n";
		}
		
		// Output styles
		if ($output <> '') {
			$output = "<!-- Custom Styling -->\n<style type=\"text/css\">\n" . $output . "</style>\n";
			echo $output;
		}
}

add_action('wp_head', 'portfolio_head_css');

/**
 * Front End Customizer
 *
 * WordPress 3.4 Required
 */

if ( function_exists( 'optionsframework_init' ) ) {
	add_action( 'customize_register', 'portfoliopress_customize_register' );
}

function portfoliopress_customize_register($wp_customize) {

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
		'title' => __( 'Layout', 'portfoliopress' ),
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
			'layout-2cr' => 'Sidebar Right',
			'layout-2cl' => 'Sidebar Left',
			'layout-1col' => 'Single Column')
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
	
	$wp_customize->add_section( 'portfolioplus_header_styles', array(
		'title' => __( 'Header Style', 'portfoliopress' ),
		'priority' => 105,
	) );
	
	$wp_customize->add_setting( 'portfoliopress[header_color][color]', array(
		'default' => '#000000',
		'type' => 'option'
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_bg_color', array(
		'label' => __( 'Background Color', 'portfolioplus' ),
		'section' => 'portfoliopress_header_styles',
		'settings'   => 'portfoliopress[header_color]'
	) ) );	
}

?>