<?php
/**
 * @package WordPress
 * @subpackage Portfolio Press
 */
?>

<?php get_header(); ?>

			<div id="content">

				<?php get_template_part( 'loop', 'index' ); ?>

			</div><!-- #content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>