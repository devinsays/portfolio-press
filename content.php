<?php
/**
 * General post content template
 *
 * @package Portfolio Press
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">
		<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'portfoliopress' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
		<div class="entry-meta">
			<?php portfoliopress_postby_meta(); ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<?php // Display excerpts for archives and search ?>
	<?php if ( is_archive() || is_search() ) :?>
	<div class="entry-summary">
		<?php if ( has_post_thumbnail() && !post_password_required() ) { ?>
			<div class="portfolio-image">
				<a href="<?php the_permalink() ?>" rel="bookmark"><?php the_post_thumbnail( 'portfolio-large' ); ?></a>
			</div>
			<?php } ?>
		<?php the_excerpt( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'portfoliopress' ) ); ?>
	</div><!-- .entry-summary -->
	<?php else : ?>

	<?php // Otherwise show full content ?>
	<div class="entry-content">
		<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'portfoliopress' ) ); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'portfoliopress' ), 'after' => '</div>' ) ); ?>
	</div><!-- .entry-content -->
	<?php endif; ?>

	<?php portfoliopress_footer_meta( $post ); ?>

</article><!-- #post-<?php the_ID(); ?> -->
