<?php
/**
 * The template used to display tag archive pages
 *
 * @package Portfolio Press
 */

get_header(); ?>

	<div id="primary">
		<div id="content" role="main">

			<header class="archive-header">
				<h1 class="archive-title"><?php echo single_tag_title( '', false ); ?></h1>
				<?php $tagdesc = tag_description();
					if ( ! empty( $tagdesc ) ) {
						echo apply_filters( 'archive_meta', '<div class="archive-meta">' . $tagdesc . '</div>' );
				} ?>
			</header>

			<?php if ( have_posts() ) : ?>

				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', get_post_format() ); ?>

				<?php endwhile; ?>

				<?php portfoliopress_paging_nav(); ?>

			<?php else : ?>
				<?php get_template_part( 'content', 'none' ); ?>
			<?php endif; ?>

			</div><!-- #content -->
		</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>