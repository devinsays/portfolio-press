<?php
/**
 * Template Name: Image and Gallery Posts
 * Descriptions: Displays all image post formats.
 *
 * @package Portfolio Press
 */

get_header(); ?>

<?php
global $paged;
$posts_per_page = apply_filters( 'portfoliopress_posts_per_page', '9' );
$args = array(
	'tax_query' => array(
		array(
		    'taxonomy' => 'post_format',
		    'field' => 'slug',
		    'terms' => 'post-format-image',
		)
	),
	'posts_per_page' => $posts_per_page,
	'paged' => $paged
);
// Override the primary post loop
query_posts( $args );
?>

	<div id="primary">
		<div id="content" role="main">

			<?php if ( have_posts() ) : ?>

				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>


					<?php
						get_template_part( 'content', 'portfolio' );
					?>

				<?php endwhile; ?>

				<?php portfoliopress_content_nav(); ?>

			<?php else : ?>
				<?php get_template_part( 'content', 'none' ); ?>
			<?php endif; ?>

			</div><!-- #content -->
		</div><!-- #primary -->

<?php wp_reset_query(); ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>