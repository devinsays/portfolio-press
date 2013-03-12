<?php
/*
 * Template Name: Full-width Portfolio
 * Description: A full-width portfolio template with no sidebar.
 *
 * @package Portfolio Press
 */

global $content_width;

if ( of_get_option('layout') == 'layout-1col' ) {
	$content_width = 780;
} else {
	$content_width = 980;
}
	
get_header();

get_template_part( 'content-portfolio' );

get_footer();
?>