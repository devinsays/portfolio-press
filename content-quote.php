<?php
/**
 * Quote post format template
 *
 * @package Portfolio Press
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="entry-content">
		<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'portfoliopress' ) ); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'portfoliopress' ), 'after' => '</div>' ) ); ?>
	</div><!-- .entry-content -->

	<?php portfoliopress_footer_meta( get_post_format() ); ?>
	
</article><!-- #post-<?php the_ID(); ?> -->
