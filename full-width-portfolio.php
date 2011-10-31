<?php
/*
 * Template Name: Full-width Portfolio
 * Description: A full-width portfolio template with no sidebar.
 *
 * @package WordPress
 * @subpackage Portfolio Press
 */

global $content_width;
$content_width = 980;
	
get_header();

if ( post_password_required() ) {
	echo get_the_password_form();
} else {
	// WP 3.0 PAGED BUG FIX
	if ( get_query_var( 'paged' ) )
		$paged = get_query_var( 'paged' );
	elseif ( get_query_var( 'page' ) )
		$paged = get_query_var( 'page' );
	else
		$paged = 1;
	
	$args = array( 'post_type' => 'portfolio',
		'posts_per_page' => 9,
		'paged' => $paged );
	query_posts( $args );
	
	get_template_part( 'content-portfolio' );
}

if ( !of_get_option('portfolio_sidebar') )
	get_sidebar();

get_footer();
?>