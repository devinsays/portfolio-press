<?php
/**
 * The template for displaying portfolio post content
 *
 * @package WordPress
 * @subpackage Portfolio Press
 */

if ( post_password_required() ) {
	echo get_the_password_form();
} else {
	// Set the size of the thumbnails and content width
	$fullwidth = false;
	if ( of_get_option( 'portfolio_sidebar' ) || is_page_template('full-width-portfolio.php') )
		$fullwidth = true;
	
	$thumbnail = 'portfolio-thumbnail';
	
	if ( $fullwidth )
		$thumbnail = 'portfolio-thumbnail-fullwidth';
	
	// Query posts if this is being used as a page template
	if ( is_page_template() ) {
	
		if ( get_query_var( 'paged' ) )
			$paged = get_query_var( 'paged' );
		elseif ( get_query_var( 'page' ) )
			$paged = get_query_var( 'page' );
		else
			$paged = 1;
			
		$args = array(
			'post_type' => 'portfolio',
			'posts_per_page' => 9,
			'paged' => $paged );
		query_posts( $args );
	}
?>
<div id="portfolio"<?php if ( $fullwidth ) { echo ' class="full-width"'; }?>>

	<?php  if ( have_posts() ) : $count = 0;
		while ( have_posts() ) : the_post(); $count++; global $post; ?>
		
			<div class="portfolio-item item<?php echo $count; ?><?php if ( $count % 3 == 0 ) { echo ' last'; } ?>">
				<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e( 'Permanent Link to', 'portfoliopress' ); ?> <?php the_title_attribute(); ?>" class="thumb"><?php the_post_thumbnail( $thumbnail ); ?></a>
				<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e( 'Permanent Link to', 'portfoliopress' ); ?> <?php the_title_attribute(); ?>" class="title-overlay"><?php the_title() ?></a>
            </div>

            <?php if ( $count % 3 == 0 ) { echo '<div class="clear"></div>'; } ?>

		<?php endwhile; ?>

            <?php /* Display navigation to next/previous pages when applicable */ ?>

			<?php
			global $wp_query;
			if (  $wp_query->max_num_pages > 1 ) : ?>

			<?php if ( function_exists( 'wp_pagenavi' ) ) { ?>

				<?php wp_pagenavi(); ?>

			<?php } else { ?>

				<nav id="nav-below">
				<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'portfoliopress' ); ?></h1>
				<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'portfoliopress' ) ); ?></div>
				<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'portfoliopress' ) ); ?></div>
				</nav><!-- #nav-below -->

			<?php } ?>
		<?php endif; ?>

		<?php else: ?>

			<h2 class="title"><?php _e( 'Sorry, no posts matched your criteria.', 'portfoliopress' ) ?></h2>

	<?php endif; ?>

</div><!-- #portfolio -->
<?php } ?>      