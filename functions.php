<?php
/**
 * @package WordPress
 * @subpackage Portfolio Press
 */
 
// Set the content width based on the theme's design and stylesheet
if ( ! isset( $content_width ) )
	$content_width = 640;
	
// Sets up the options panel and default functions
require_once( TEMPLATEPATH . '/extensions/options-functions.php' );

// Tell WordPress to run portfoliopress_setup() when the 'after_setup_theme' hook is run
add_action( 'after_setup_theme', 'portfoliopress_setup' );
 
if ( ! function_exists( 'portfoliopress_setup' ) ):
function portfoliopress_setup() {

	/**
	 * Make the theme available for translation.
	 * Translations can be added in the /languages/ directory.
	 */
	load_theme_textdomain( 'portfoliopress', TEMPLATEPATH . '/languages' );
	
	$locale = get_locale();
	$locale_file = TEMPLATEPATH . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );
	
	// This theme styles the visual editor with editor-style.css to match the theme style
	add_editor_style();
	
	// This theme uses wp_nav_menu() in one location
	register_nav_menus( array(
			'primary' => __( 'Primary Menu', 'portfoliopress' ),
		) );
	
	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );
	
	// Add support for a variety of post formats ( will be added in next version )
	add_theme_support( 'post-formats', array( 'gallery', 'quote', 'image' ) );
	
	add_image_size( 'portfolio-thumbnail', 215, 175, true );
	add_image_size( 'portfolio-thumbnail-fullwidth', 308, 220, true );
	add_image_size( 'portfolio-large', 630, 9999, false );

}
endif; // portfoliopress_setup

/**
 * Loads the required javascript for the drop down menus and jquery effects
 * on portfolio items and post formats.
 */
 
function portfoliopress_scripts() {
	wp_enqueue_script( 'superfish', get_template_directory_uri() .'/js/superfish.js', array( 'jquery' ), false, true );
	if ( !is_single() ) {
		wp_enqueue_script( 'themejs', get_template_directory_uri() . '/js/theme.js', array( 'jquery' ), false, true );
	}
}

add_action('wp_enqueue_scripts', 'portfoliopress_scripts');

/**
 * Displays a notice letting the user know that portfolio post type functionality
 * will be moving into a plugin.  They can upgrade now, or wait one more
 * version before this code is removed.
 */
if ( !function_exists( 'portfolioposttype' ) && current_user_can( 'install_plugins' ) ) {

	/* Display a notice that can be dismissed */

	add_action( 'admin_notices', 'portfoliopress_install_plugin_notice' );

	function portfoliopress_install_plugin_notice() {
		global $current_user ;
		$user_id = $current_user->ID;
		/* Check that the user hasn't already clicked to ignore the message */
		if ( ! get_user_meta( $user_id, 'portfoliopress_install_plugin_notice' ) ) {
			add_thickbox();
			echo '<div class="updated"><p>';
			printf( __( 'If you wish to use custom post types for portfolios, please install the Portfolio Post Type Plugin.  <a href="%1$s" class="thickbox onclick">Install Now</a> | <a href="%2$s">Hide Notice</a>' ), admin_url() . 'plugin-install.php?tab=plugin-information&plugin=portfolio-post-type&TB_iframe=true&width=640&height=517', '?example_nag_ignore=0' );
			echo '</p></div>';
		}
	}

	add_action( 'admin_init', 'portfoliopress_post_plugin_ignore' );

	function portfoliopress_post_plugin_ignore() {
		global $current_user;
		$user_id = $current_user->ID;
		/* If user clicks to ignore the notice, add that to their user meta */
		if ( isset( $_GET['example_nag_ignore'] ) && '0' == $_GET['example_nag_ignore'] ) {
			add_user_meta( $user_id, 'example_ignore_notice', 'true', true );
		}
	}
}

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 */
function portfolio_page_menu_args( $args ) {
	$args['show_home'] = true;
	$args['menu_class'] = 'menu';
	return $args;
}

add_filter( 'wp_page_menu_args', 'portfolio_page_menu_args' );

/**
 * Class name for wp_nav_menu
 */
function portfolio_wp_nav_menu_args( $args ) {
	$args['container_class'] = 'menu';
	$args['menu_class'] = '';
	return $args;
}

add_filter( 'wp_nav_menu_args', 'portfolio_wp_nav_menu_args' );

/**
 * Register widgetized area and update sidebar with default widgets
 */
function portfoliopress_widgets_init() {
	register_sidebar( array (
			'name' => __( 'Sidebar', 'portfoliopress' ),
			'id' => 'sidebar',
			'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
			'after_widget' => "</li>",
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		) );

	register_sidebar( array( 'name' => __( 'Footer 1', 'portfoliopress' ),'id' => 'footer-1', 'description' => __( "Widetized footer", 'portfoliopress' ), 'before_widget' => '<div id="%1$s" class="widget-container %2$s">','after_widget' => '</div>','before_title' => '<h3>','after_title' => '</h3>' ) );
	register_sidebar( array( 'name' => __( 'Footer 2', 'portfoliopress' ),'id' => 'footer-2', 'description' => __( "Widetized footer", 'portfoliopress' ), 'before_widget' => '<div id="%1$s" class="widget-container %2$s">','after_widget' => '</div>','before_title' => '<h3>','after_title' => '</h3>' ) );
	register_sidebar( array( 'name' => __( 'Footer 3', 'portfoliopress' ),'id' => 'footer-3', 'description' => __( "Widetized footer", 'portfoliopress' ), 'before_widget' => '<div id="%1$s" class="widget-container %2$s">','after_widget' => '</div>','before_title' => '<h3>','after_title' => '</h3>' ) );
	register_sidebar( array( 'name' => __( 'Footer 4', 'portfoliopress' ),'id' => 'footer-4', 'description' => __( "Widetized footer", 'portfoliopress' ), 'before_widget' => '<div id="%1$s" class="widget-container %2$s">','after_widget' => '</div>','before_title' => '<h3>','after_title' => '</h3>' ) );
}

add_action( 'init', 'portfoliopress_widgets_init' );

/**
 * Reusable navigation code for navigation
 * Display navigation to next/previous pages when applicable
 */
function portfoliopress_content_nav() {
	global $wp_query;
	if (  $wp_query->max_num_pages > 1 ) :
		if (function_exists('wp_pagenavi') ) {
			wp_pagenavi();
		} else { ?>
        	<nav id="nav-below">
			<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'portfoliopress' ); ?></h1>		
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'portfoliopress' ) ); ?></div>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'portfoliopress' ) ); ?></div>
			</nav><!-- #nav-below -->
    	<?php }
	endif;
}


/**
 * Set version number in options
 */
if ( of_get_option( 'version', '0.1' ) < 0.9 ) {
	global $current_user;
	$user_id = $current_user->ID;
	// Show the nag again to use the Portfolio Post Type Plugin
	delete_user_meta( $user_id, 'example_ignore_notice', 'true', true );
	// Update the theme version number
	$options = get_option( 'portfoliopress' );
	$options['version'] = '0.9';
	update_option( 'portfoliopress', $options );
}

/**
 * In previous versions of Portfolio Press, portfolio tags were registered as portfolio-tags
 * These need to be updated to the portfolio_tag taxonomy.
 */
function portfoliopress_update_portfolio_tags( $term_ids ) {
	register_taxonomy( 'portfolio-tags', 'portfolio', array( 'public'=> false ) );
	$taxonomy = 'portfolio-tags';
	$new_tax = 'portfolio_tag';
	$tt_ids = array();
	foreach ( $term_ids as $term_id ) {
		$term = get_term( $term_id, $taxonomy );
		$tt_ids[] = $term->term_taxonomy_id;
	}
	$tt_ids = implode( ',', array_map( 'absint', $tt_ids ) );
	global $wpdb;
	$wpdb->query( $wpdb->prepare( "
		UPDATE $wpdb->term_taxonomy SET taxonomy = %s WHERE term_taxonomy_id IN ($tt_ids)
	", $new_tax ) );
}

/**
 * Sets posts displayed per portfolio page to 9.
 * If you change this you should also update the query $args in
 * archive-portfolio.php if you also use the portfolio page template.
 */
function wpt_portfolio_custom_posts_per_page( $query ) {
	global $wp_the_query;
	if ( $wp_the_query === $query && !is_admin() && is_post_type_archive( 'portfolio' ) ) {
		$query->set( 'posts_per_page', '9' );
	}
}

add_action( 'pre_get_posts', 'wpt_portfolio_custom_posts_per_page' );

/**
 * Overrides the default behavior of portfolio taxonomies to use the archive-portfolio template
 * http://www.billerickson.net/reusing-wordpress-theme-files/
 */
function portfoliopress_template_chooser( $template ) {
	if ( is_tax( 'portfolio_tag' ) ||  is_tax( 'portfolio_category' ) )
		$template = get_query_template( 'archive-portfolio' );
	return $template;
}
add_filter( 'template_include', 'portfoliopress_template_chooser' );