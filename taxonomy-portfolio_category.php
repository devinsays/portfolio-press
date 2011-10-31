<?php
/**
 * This template displays the portfolio tags.
 *
 * @package WordPress
 * @subpackage Portfolio Press
 */

get_header();

if ( post_password_required() ) {
	echo get_the_password_form();
} else {
	get_template_part( 'content-portfolio' );
}

if ( !of_get_option( 'portfolio_sidebar' ) )
	get_sidebar();

get_footer();
?>