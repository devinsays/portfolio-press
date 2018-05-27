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

				<?php
				// If no image is set, we'll use a fallback image
				if ( has_post_thumbnail() ) {
					$image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'portfolio-thumbnail', true );
					$image = $image[0];
					$class = "image-thumbnail";
				} else {
					$format = get_post_format();
					$image = get_template_directory_uri() . '/images/image.svg';
					$formats = array( 'gallery', 'image', 'video' );
					if ( in_array( $format, $formats ) ) {
						$image = get_template_directory_uri() . '/images/' . $format . '.svg';
					}
					$class = 'fallback-thumbnail';
				}

				// If password is required, always show lock image
				if ( post_password_required() ) {
					$image = get_template_directory_uri() . '/images/lock.svg';
					$class = 'fallback-thumbnail';
				}
				?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<div class="entry-content">
						<a href="<?php the_permalink() ?>" rel="bookmark" class="thumb" aria-labelledby="post-<?php the_ID(); ?>-title">
							<h3 id="post-<?php the_ID(); ?>-title"><?php the_title() ?></h3>
							<img class="<?php echo $class; ?>" src="<?php echo esc_url( $image ); ?>" width="360" height="260" alt="">
						</a>
					</div><!-- .entry-content -->
				</article><!-- #post-<?php the_ID(); ?> -->

			<?php endwhile; ?>

			<?php portfoliopress_paging_nav( $portfolio ); ?>

		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>

	</div><!-- #content -->
</div><!-- #primary -->

<?php wp_reset_query(); ?>
<?php get_footer(); ?>
