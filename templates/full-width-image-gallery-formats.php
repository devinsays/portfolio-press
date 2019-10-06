<?php
/**
 * Template Name: Full Width Image and Gallery Posts
 * Descriptions: Displays all image and gallery post formats.
 *
 * @package Portfolio Press
 */

get_header(); ?>

<?php
if ( get_query_var( 'paged' ) ) {
	$paged = get_query_var( 'paged' );
} elseif ( get_query_var( 'page' ) ) {
	$paged = get_query_var( 'page' );
} else {
	$paged = 1;
}
$args = array(
	'tax_query' => array(
		array(
			'taxonomy' => 'post_format',
			'field' => 'slug',
			'terms' => array( 'post-format-image', 'post-format-gallery' ),
		)
	),
	'paged' => $paged
);
$portfolio = new WP_Query( $args );
?>

<div id="primary">
	<div id="content" role="main">

		<?php if ( $portfolio->have_posts() ) : ?>

			<?php /* Start the Loop */ ?>
			<?php while ( $portfolio->have_posts() ) : $portfolio->the_post(); ?>
				<?php get_template_part( 'content', 'portfolio' ); ?>
			<?php endwhile; ?>

			<?php portfoliopress_paging_nav( $portfolio ); ?>

		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>

	</div><!-- #content -->
</div><!-- #primary -->

<?php wp_reset_query(); ?>
<?php get_footer(); ?>
