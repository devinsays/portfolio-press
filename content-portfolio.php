<?php
/**
 * This template displays portfolio post content
 *
 * @package Portfolio Press
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
		
	// This displays the portfolio full width, but doesn't change thumbnail sizes
	if ( of_get_option('layout','layout-2cr') ==  'layout-1col' )
		$fullwidth = true;
	
	// Query posts if this is being used as a page template
	if ( is_page_template() ) {
	
		global $paged;
	
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

	<?php if ( is_tax() ): ?>
	<header class="entry-header">
		<h1 class="entry-title"><?php echo single_cat_title( '', false ); ?></h1>
		<?php $categorydesc = category_description(); if ( ! empty( $categorydesc ) ) echo apply_filters( 'archive_meta', '<div class="archive-meta">' . $categorydesc . '</div>' ); ?>
	</header>

	<?php endif; ?>

	<?php  if ( have_posts() ) : $count = 0;
		while ( have_posts() ) : the_post(); $count++;
		$classes = 'portfolio-item item-' . $count;
		if ( $count % 3 == 0 ) {
			$classes .= ' ie-col3';
		}
		if ( !has_post_thumbnail() ) {
			$classes .= ' no-thumb';
		} ?>
		<div class="<?php echo $classes; ?>">
			<?php if ( has_post_thumbnail() ) { ?>
			<a href="<?php the_permalink() ?>" rel="bookmark" class="thumb"><?php the_post_thumbnail( $thumbnail ); ?></a>
			<?php } ?>
			<a href="<?php the_permalink() ?>" rel="bookmark" class="title-overlay"><?php the_title() ?></a>
		</div>

		<?php endwhile; ?>

        <?php portfoliopress_content_nav(); ?>
			
		<?php else: ?>

			<h2 class="title"><?php _e( 'Sorry, no posts matched your criteria.', 'portfoliopress' ) ?></h2>

	<?php endif; ?>

</div><!-- #portfolio -->
<?php } ?>      