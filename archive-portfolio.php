<?php
/**
 * Template Name: Portfolio
 *
 * This is for the default archive view of portfolio archives.
 * It can also be used as a page template.
 *
 * @package Portfolio Press
 */

get_header();

get_template_part( 'content-portfolio' );
	
if ( !of_get_option( 'portfolio_sidebar' ) )
	get_sidebar();

get_footer();
?>