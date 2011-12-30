<?php
/**
 * Template Name: Portfolio
 *
 * @package WordPress
 * @subpackage Portfolio Press
 */

get_header();

get_template_part( 'content-portfolio' );
	
if ( !of_get_option( 'portfolio_sidebar' ) )
	get_sidebar();

get_footer();
?>