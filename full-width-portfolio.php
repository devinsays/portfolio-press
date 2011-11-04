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

get_footer();
?>