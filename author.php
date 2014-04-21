<?php
/**
 * The template for displaying author pages
 *
 * @package Portfolio Press
 */

get_header(); ?>

	<div id="primary">
		<div id="content" role="main">

			<?php the_post(); ?>

			<h2 class="page-title"><?php printf( __( 'Author Archives: <span class="vcard">%s</span>', 'portfolio-press' ), get_the_author() ); ?></h2>

			<?php rewind_posts(); ?>

			<?php
			// If a user has filled out their description, show a bio on their entries.
			if ( get_the_author_meta( 'description' ) ) : ?>
			<div class="author-info clearfix">
				<div class="author-avatar">
					<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'portfoliopress_author_bio_avatar_size', 60 ) ); ?>
				</div><!-- .author-avatar -->
				<div class="author-description">
					<h3><?php printf( __( 'About %s', 'portfolio-press' ), get_the_author() ); ?></h3>
					<p><?php the_author_meta( 'description' ); ?></p>
				</div><!-- .author-description	-->
			</div><!-- .author-info -->
			<?php endif; ?>

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', get_post_format() ); ?>
			<?php endwhile; ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>