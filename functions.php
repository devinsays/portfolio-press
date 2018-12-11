<?php
/**
 * Portfolio Press functions and definitions
 *
 * @package Portfolio Press
 * @author Devin Price <devin@wptheming.com>
 * @license http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

/**
 * Set constant for version
 */
define( 'PORTFOLIO_VERSION', '2.8.0' );

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

	// Use the generated .pot file in languages to make translations
	load_theme_textdomain( 'portfolio-press', get_template_directory() . '/languages' );

	// This theme styles the visual editor with editor-style.css to match the theme style
	add_editor_style( 'editor.css' );

	// This theme uses wp_nav_menu() in one location
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'portfolio-press' ),
	) );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// Add support for a variety of post formats
	add_theme_support( 'post-formats', array( 'gallery', 'image', 'video', 'quote', 'link' ) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	// Add support for featured images
	add_theme_support( 'post-thumbnails' );

	// Add images sizes for the various thumbnails
	add_image_size( 'portfolio-thumbnail', 360, 260, true );
	add_image_size( 'portfolio-large', 690, 9999, false );
	add_image_size( 'portfolio-fullwidth', 980, 9999, false );
	
	// Support for wide images introduced in WordPress 5.0
	add_theme_support( 'align-wide' );

}
endif; // portfoliopress_setup
add_action( 'after_setup_theme', 'portfoliopress_setup' );

/**
 * Enqueue scripts and styles.
 */
function portfoliopress_scripts() {

	wp_enqueue_style(
		'portfoliopress-style',
		get_stylesheet_uri(),
		array(),
		PORTFOLIO_VERSION
	);

	// Use style-rtl.css for RTL layouts
	wp_style_add_data(
		'portfoliopress-style',
		'rtl',
		'replace'
	);

	if ( SCRIPT_DEBUG || WP_DEBUG ) :

		wp_enqueue_script(
			'portfoliopress-navigation',
			get_template_directory_uri() . '/js/navigation.js',
			array( 'jquery' ),
			PORTFOLIO_VERSION,
			true
		);

		wp_enqueue_script(
			'portfoliopress-fit-vids',
			get_template_directory_uri() . '/js/jquery.fitvids.js',
			array( 'jquery' ),
			PORTFOLIO_VERSION,
			true
		);

	else :

		wp_enqueue_script(
			'portfoliopress-combined',
			get_template_directory_uri() . '/js/combined-min.js',
			array( 'jquery' ),
			PORTFOLIO_VERSION,
			true
		);

	endif;

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'portfoliopress_scripts' );

/**
 * Loads webfonts from Google
 */
function portfoliopress_fonts() {

	wp_enqueue_style(
		'portfoliopress_fonts',
		'//fonts.googleapis.com/css?family=Open+Sans:400italic,400,600|Rokkitt:400,700',
		'',
		null,
		'screen'
	);

	wp_enqueue_style(
		'portfoliopress_icon_font',
		get_template_directory_uri() . '/fonts/custom/portfolio-custom.css',
		array(), PORTFOLIO_VERSION
	);

}
add_action( 'wp_enqueue_scripts', 'portfoliopress_fonts', 10 );

/**
 * Registers widget areas
 */
function portfoliopress_widgets_init() {

	register_sidebar( array (
		'name' => __( 'Sidebar', 'portfolio-press' ),
		'id' => 'sidebar',
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => "</li>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Footer 1', 'portfolio-press' ),
		'id' => 'footer-1',
		'description' => __( "Widgetized footer", 'portfolio-press' ),
		'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>'
	) );

	register_sidebar( array(
		'name' => __( 'Footer 2', 'portfolio-press' ),
		'id' => 'footer-2',
		'description' => __( "Widgetized footer", 'portfolio-press' ),
		'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>'
	) );

	register_sidebar( array(
		'name' => __( 'Footer 3', 'portfolio-press' ),
		'id' => 'footer-3',
		'description' => __( "Widgetized footer", 'portfolio-press' ),
		'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>'
	) );

	register_sidebar( array(
		'name' => __( 'Footer 4', 'portfolio-press' ),
		'id' => 'footer-4',
		'description' => __( "Widgetized footer", 'portfolio-press' ),
		'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>'
	) );
}
add_action( 'widgets_init', 'portfoliopress_widgets_init' );

/**
 * Helper library for the theme customizer.
 */
require get_template_directory() . '/extensions/customizer-library/customizer-library.php';

/**
 * Define options for the theme customizer.
 */
require get_template_directory() . '/extensions/customizer-options.php';

/**
 * Sets up the options panel and default functions
 */
require_once( get_template_directory() . '/extensions/mods.php' );

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
