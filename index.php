<?php
/**
 * @package WordPress
 * @subpackage Portfolio Press
 */
?>

<?php

/* Loads the portfolio on the home if that option is selected : */

if (is_home() && (of_get_option('portfolio_home') == 'true') ) {
	get_template_part('full-width-portfolio');
} else { ?>

<?php get_header(); ?>

			<div id="content">

				<?php get_template_part( 'loop', 'index' ); ?>

			</div><!-- #content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>

<?php } ?>