<?php
/**
 * General post content template
 *
 * @package Portfolio Press
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">
		<h1 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
		<?php if ( 'page' != $post->post_type ) : ?>
		<div class="entry-meta">
			<?php portfoliopress_postby_meta(); ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php if ( portfoliopress_get_option( 'portfolio_images', true ) ) {
			portfoliopress_display_image();
		} ?>
		<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'portfolio-press' ) ); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'portfolio-press' ), 'after' => '</div>' ) ); ?>
	</div><!-- .entry-content -->

	<?php portfoliopress_footer_meta( $post ); ?>

</article><!-- #post-<?php the_ID(); ?> -->
