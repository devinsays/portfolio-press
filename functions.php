<?php
/**
 * Portfolio Press functions and definitions
 *
 * @package Portfolio Press
 * @author Devin Price <devin@wptheming.com>
 * @license http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 980;
}

if ( ! function_exists( 'portfoliopress_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function portfoliopress_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on _s, use a find and replace
	 * to change '_s' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'portfoliopress', get_template_directory() . '/languages' );

	// This theme styles the visual editor with editor-style.css to match the theme style
	add_editor_style();

	// This theme uses wp_nav_menu() in one location
	register_nav_menus( array(
			'primary' => __( 'Primary Menu', 'portfoliopress' ),
		) );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// Add support for a variety of post formats ( will be added in next version )
	add_theme_support( 'post-formats', array( 'gallery', 'image', 'video', 'quote', 'link' ) );

	// Add support for featured images
	add_theme_support( 'post-thumbnails' );

	// Enable support for HTML5 markup
	add_theme_support( 'html5', array(
		'comment-list',
		'comment-form',
		'gallery',
	) );

	// Add images sizes for the various thumbnails
	add_image_size( 'portfolio-thumbnail', 280, 225, true );
	add_image_size( 'portfolio-thumbnail-fullwidth', 314, 224, true );
	add_image_size( 'portfolio-large', 690, 9999, false );
	add_image_size( 'portfolio-fullwidth', 980, 9999, false );

}
endif; // portfoliopress_setup
add_action( 'after_setup_theme', 'portfoliopress_setup' );

/**
 * Loads required javascript for the theme
 */
function portfoliopress_scripts() {
	wp_enqueue_script( 'themejs', get_template_directory_uri() . '/js/theme.js', array( 'jquery' ), false, true );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
    	wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'portfoliopress_scripts' );

/**
 * Loads webfonts from Google
 */
function portfoliopress_fonts() {
	wp_register_style( 'portfoliopress_open_sans', '//fonts.googleapis.com/css?family=Open+Sans:400italic,400,600', '', null, 'screen' );
	wp_register_style( 'portfoliopress_rokkitt', '//fonts.googleapis.com/css?family=Rokkitt:400,700', '', null, 'screen' );
	wp_enqueue_style( 'portfoliopress_open_sans' );
	wp_enqueue_style( 'portfoliopress_rokkitt' );
	wp_enqueue_style( 'portfoliopress_icon_font', get_template_directory_uri() . '/fonts/custom/portfolio-custom.css', array(), '1.0.0' );
}

add_action( 'wp_enqueue_scripts', 'portfoliopress_fonts', 10 );

/**
 * Registers widget areas
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

	register_sidebar( array(
		'name' => __( 'Footer 1', 'portfoliopress' ),
		'id' => 'footer-1',
		'description' => __( "Widetized footer", 'portfoliopress' ),
		'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>'
	) );

	register_sidebar( array(
		'name' => __( 'Footer 2', 'portfoliopress' ),
		'id' => 'footer-2',
		'description' => __( "Widetized footer", 'portfoliopress' ),
		'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>'
	) );

	register_sidebar( array(
		'name' => __( 'Footer 3', 'portfoliopress' ),
		'id' => 'footer-3',
		'description' => __( "Widetized footer", 'portfoliopress' ),
		'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>'
	) );

	register_sidebar( array(
		'name' => __( 'Footer 4', 'portfoliopress' ),
		'id' => 'footer-4',
		'description' => __( "Widetized footer", 'portfoliopress' ),
		'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>'
	) );
}
add_action( 'init', 'portfoliopress_widgets_init' );

/**
 * Sets up the options panel and default functions
 */
require_once( get_template_directory() . '/extensions/options-functions.php' );

/**
 * Adds general template functions
 */
require_once( get_template_directory() . '/extensions/template-helpers.php' );

/**
 * Adds general portfolio functions
 */
require_once( get_template_directory() . '/extensions/portfolio-helpers.php' );

/**
 * Custom functions that act independently of the theme templates.
 */
require_once( get_template_directory() . '/extensions/extras.php' );

/**
 * Displays notices for recommended plugins
 */
require_once( get_template_directory() . '/extensions/recommended-plugins.php' );