<?php
/**
 * Template for displaying a single post
 *
 * @package Portfolio Press
 */

get_header(); ?>

		<div id="primary">
			<div id="content" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<header class="entry-header">
						<h1 class="entry-title"><?php the_title(); ?></h1>

						<div class="entry-meta">
							<?php portfoliopress_postby_meta(); ?>
						</div><!-- .entry-meta -->
					</header><!-- .entry-header -->

					<div class="entry-content">

						<?php if ( wp_attachment_is_image( get_the_ID() ) ) : ?>
						<p class="attachment-image">
							<?php echo wp_get_attachment_image( get_the_ID(), 'full', false, array( 'class' => 'aligncenter' ) ); ?>
						</p><!-- .attachment-image -->
						<?php endif; ?>

						<?php if ( has_excerpt() ) : ?>
						<div class="wp-caption">
							<?php the_excerpt(); ?>
						</div>
						<?php endif; ?>

						<?php the_content(); ?>

					</div><!-- .entry-content -->

					<footer class="entry-meta">
						<span class="entry-meta-icon icon-format-<?php echo esc_attr( 'image' ); ?>"></span>
						<?php
							$metadata = wp_get_attachment_metadata();
							printf( __( '<span class="meta-prep meta-prep-entry-date">Published </span> <span class="entry-date"><time class="entry-date" datetime="%1$s">%2$s</time></span> at <a href="%3$s" title="Link to full-size image">%4$s &times; %5$s</a> in <a href="%6$s" title="Return to %7$s" rel="gallery">%8$s</a>.', 'portfolio-press' ),
								esc_attr( get_the_date( 'c' ) ),
								esc_html( get_the_date() ),
								esc_url( wp_get_attachment_url() ),
								$metadata['width'],
								$metadata['height'],
								esc_url( get_permalink( $post->post_parent ) ),
								esc_attr( strip_tags( get_the_title( $post->post_parent ) ) ),
								get_the_title( $post->post_parent )
							);
						?>
						<?php edit_post_link( __( 'Edit', 'portfolio-press' ), '<span class="edit-link">', '</span>' ); ?>
					</footer>

				</article><!-- #post-<?php the_ID(); ?> -->

				<?php if ( portfoliopress_get_option( 'portfolio_navigation', true ) ) {
					portfoliopress_post_nav();
				} ?>

				<?php if ( comments_open() ) {
					comments_template( '', true );
                } ?>

			<?php endwhile; // end of the loop. ?>

			</div><!-- #content -->
		</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>