<?php
/*
 * Template Name: Portfolio Categories
 * Description: Displays all the portfolio categories
 *
 * @package WordPress
 * @subpackage Portfolio Press
 */

get_header(); ?>

	<div id="primary">
		<div id="content" role="main">
		
		<?php
		/* http://codex.wordpress.org/Function_Reference/get_categories */
		$args = array(
			'type' => 'portfolio',
			'orderby'                  => 'name',
			'order'                    => 'ASC',
			'taxonomy'                 => 'portfolio_category');
	
		$categories = get_categories( $args );
		
		//var_dump($categories);
	
		foreach( $categories as $category ) {
		
			echo '<h3>' . $category->name . '</h3>';
			echo '<p>' . esc_attr( get_term_link( $category->name, 'portfolio_category' ) ) . '</p>';
		
			$args = array(
				'posts_per_page' => 1,
				'post_type' => 'portfolio',
				'portfolio_category' => $category->slug
			);
			$the_query = new WP_Query( $args );
			
			//var_dump($the_query);
			
			// The Loop
			while ( $the_query->have_posts() ) : $the_query->the_post();
				echo '<p>Most recent post: ' . get_the_title() . '</p>'; ?>
				<div>
				<?php if ( has_post_thumbnail() ) { ?>
				<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e( 'Permanent Link to', 'portfoliopress' ); ?><?php the_title_attribute(); ?>" class="thumb"><?php the_post_thumbnail( 'portfolio-thumbnail' ); ?></a>
			<?php } ?>
				</div>
			<?php endwhile;
			
			// Reset Post Data
			wp_reset_postdata();

	   } // $categories loop
	   ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>