<?php
/**
 * Template for displaying a portfolio post
 *
 * @package Portfolio Press
 */

get_header(); ?>

	<div id="primary">
		<div id="content" role="main">

		<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header class="entry-header">
					<h1 class="entry-title"><?php the_title(); ?></h1>

					<div class="entry-meta">
						<?php portfoliopress_postby_meta(); ?>
					</div><!-- .entry-meta -->
				</header><!-- .entry-header -->

				<div class="entry-content">
					<?php portfoliopress_display_image(); ?>
					<?php the_content(); ?>
					<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'portfoliopress' ), 'after' => '</div>' ) ); ?>
				</div><!-- .entry-content -->

				<?php portfoliopress_footer_meta( $post ); ?>

			</article><!-- #post-<?php the_ID(); ?> -->

			<nav id="nav-below">
				<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'portfoliopress' ); ?></h1>
				<div class="nav-previous"><?php previous_post_link( '%link', '%title <span class="meta-nav">' . _e( '&rarr;', 'Previous post link', 'portfoliopress' ) . '</span>' ); ?></div>
				<div class="nav-next"><?php next_post_link( '%link', '<span class="meta-nav">' . _e( '&larr;', 'Next post link', 'portfoliopress' ) . '</span> %title' ); ?></div>
			</nav><!-- #nav-below -->

			<?php if ( comments_open() ) {
				comments_template( '', true );
            } ?>

		<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>