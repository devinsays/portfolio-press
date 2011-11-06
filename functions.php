<?php
/**
 * @package WordPress
 * @subpackage Portfolio Press
 */
 
// Set the content width based on the theme's design and stylesheet
if ( ! isset( $content_width ) )
	$content_width = 640;

// Tell WordPress to run portfoliopress_setup() when the 'after_setup_theme' hook is run
add_action( 'after_setup_theme', 'portfoliopress_setup' );
 
if ( ! function_exists( 'twentyeleven_setup' ) ):
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
		
	// Sets up the options panel and default functions
	require_once( TEMPLATEPATH . '/extensions/options-functions.php' );
	
	// This theme styles the visual editor with editor-style.css to match the theme style
	add_editor_style();
	
	// This theme uses wp_nav_menu() in one location
	register_nav_menus( array(
			'primary' => __( 'Primary Menu', 'portfoliopress' ),
		) );
	
	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );
	
	// Add support for a variety of post formats ( will be added in next version )
	// add_theme_support( 'post-formats', array( 'aside', 'link', 'gallery', 'status', 'quote', 'image' ) );
	
	// Enqueue javascript for the menu and portfolio items
	if ( !is_admin() ) {
		wp_enqueue_script( 'superfish', get_template_directory_uri() .'/js/superfish.js', array( 'jquery' ) );
		if ( !is_single() ) {
			wp_enqueue_script( 'fader', get_template_directory_uri() . '/js/jquery.fader.js', array( 'jquery' ) );
		}
	}
	
	// Enables the portfolio custom post type.
	if ( !of_get_option( 'disable_portfolio', "0" ) && !function_exists( 'portfolioposttype' ) ) {
		require_once( TEMPLATEPATH . '/extensions/portfolio-post-type.php' );
	}


}
endif; // portfoliopress_setup

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
			printf( __( 'Future versions of Portfolio Press will require the Portfolio Post Type Plugin.  <a href="%1$s" class="thickbox onclick">Install Now</a> | <a href="%2$s">Hide Notice</a>' ), admin_url() . 'plugin-install.php?tab=plugin-information&plugin=portfolio-post-type&TB_iframe=true&width=640&height=517', '?example_nag_ignore=0' );
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
function portfolio_widgets_init() {
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

add_action( 'init', 'portfolio_widgets_init' );

/**
 * Set version number in options, runs tag updater script, flushes rewrite rules
 */
if ( !of_get_option( 'version', false ) ) {
	if ( function_exists( 'portfolioposttype' ) ) {
		portfolioposttype();
	} else {
		wpt_portfolio_posttype();
	}
	flush_rewrite_rules();
	register_taxonomy( 'portfolio-tags', 'portfolio', array( 'public'=> false ) );
	$term_ids = get_terms( 'portfolio-tags', array( 'hide_empty' => false ,'fields' => 'ids' ) );
	if ( $term_ids && ( taxonomy_exists( 'portfolio_tag' ) ) ) {
		portfoliopress_update_portfolio_tags( $term_ids );
	}
	$options = get_option( 'portfoliopress' );
	$options['version'] = '0.8';
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
 * archive-portfolio.php and related taxonomy templates.
 */
function wpt_portfolio_custom_posts_per_page( &$q ) {
	if ( get_post_type() == 'portfolio' )
		$q->set( 'posts_per_page', 9 );
	return $q;
}

add_filter( 'parse_query', 'wpt_portfolio_custom_posts_per_page' );