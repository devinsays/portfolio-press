<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package Portfolio Press
 */

get_header(); ?>

	<div id="primary">
		<div id="content" role="main">

			<article id="post-0" class="post error404 not-found">
				<header class="entry-header">
					<h1 class="entry-title"><?php _e( 'This is somewhat embarrassing, isn&rsquo;t it?', 'portfoliopress' ); ?></h1>
				</header>
				
				<div class="entry-content">
					<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching, or one of the links below, can help.', 'portfoliopress' ); ?></p>
	
					<?php get_search_form(); ?>
	
					<?php the_widget( 'WP_Widget_Recent_Posts' ); ?>
	
					<div class="widget">
						<h2 class="widgettitle"><?php _e( 'Most Used Categories', 'portfoliopress' ); ?></h2>
						<ul>
						<?php wp_list_categories( array( 'orderby' => 'count', 'order' => 'DESC', 'show_count' => 'TRUE', 'title_li' => '', 'number' => '10' ) ); ?>
						</ul>
					</div>
	
					<?php the_widget( 'WP_Widget_Tag_Cloud' ); ?>
	
				</div><!-- .entry-content -->
			</article><!-- #post-0 -->

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>