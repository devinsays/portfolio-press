<?php
/**
 * @package Portfolio Press
 */

/**
 * Overrides the default behavior of portfolio taxonomies to use the archive-portfolio template
 * http://www.billerickson.net/reusing-wordpress-theme-files/
 */
function portfoliopress_template_chooser( $template ) {
	if ( is_tax( 'portfolio_tag' ) ||  is_tax( 'portfolio_category' ) )
		$template = get_query_template( 'archive-portfolio' );
	if ( is_tax( 'post_format', 'post-format-image' ) || is_tax( 'post_format', 'post-format-gallery' ) )
		$template = get_query_template( 'archive-portfolio' );
	return $template;
}
add_filter( 'template_include', 'portfoliopress_template_chooser' );

/**
 * Adds a body class to archives that display as a portfolio view
 */
function portfoliopress_body_class( $classes ) {

	if (
		is_post_type_archive( 'portfolio' ) ||
		is_page_template( 'templates/portfolio.php' ) ||
		is_page_template( 'templates/full-width-portfolio.php' ) ||
		is_page_template( 'templates/post-format-gallery-image.php' ) ||
		is_tax( 'post_format', 'post-format-image' ) ||
		is_tax( 'post_format', 'post-format-gallery' ) ||
		is_tax( 'portfolio_category' ) ||
		is_tax( 'portfolio_tag' )
	) {
		$classes[] = 'portfolio-view';
		if ( of_get_option( 'portfolio_sidebar', false ) ) {
			$classes[] = 'full-width-portfolio';
		}
	}

	if ( !of_get_option( 'portfolio_sidebar', false ) ) {
		if ( is_page_template( 'templates/full-width-portfolio.php' ) ) {
			$classes[] = 'full-width-portfolio';
		}
	}

	return $classes;
}
add_filter( 'body_class','portfoliopress_body_class' );