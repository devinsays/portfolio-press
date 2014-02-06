<?php
/**
 * Template Name: Portfolio
 * Description: Basic Portfolio template.
 *
 * @package Portfolio Press
 */

get_header(); ?>

<?php
global $paged;
$posts_per_page = apply_filters( 'portfoliopress_posts_per_page', '9' );
$args = array(
	'post_type' => 'portfolio',
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
						/* Include the Post-Format-specific template for the content.
						 * If you want to overload this in a child theme then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
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

<?php if ( !of_get_option( 'portfolio_sidebar', false ) ) { get_sidebar(); } ?>
<?php get_footer(); ?>