<?php
/*
 * Template Name: Portfolio Categories
 * Description: Displays all the portfolio categories
 *
 * @package WordPress
 * @subpackage Portfolio Press
 */

get_header(); ?>
		
		<?php
		/* http://codex.wordpress.org/Function_Reference/get_categories */
		$args = array(
			'type' => 'portfolio',
			'orderby' => 'name',
			'order' => 'ASC',
			'taxonomy' => 'portfolio_category');
	
		$categories = get_categories( $args );
		
		$portoliopress_custom_query = array();
		
		//var_dump($categories);
	
		foreach( $categories as $category ) {
		
			$args = array(
				'posts_per_page' => 1,
				'post_type' => 'portfolio',
				'portfolio_category' => $category->slug,
				'no_found_rows' => true,
				'update_post_meta_cache' => false,
				'update_post_term_cache' => false
			);
			$the_query = new WP_Query( $args );
			
			// The Loop
			while ( $the_query->have_posts() ) : $the_query->the_post();
			
				$portfolio_thumbnail = null;
				$portfolio_thumbnail_fullwidth = null;
				$portfolio_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id(), 'portfolio-thumbnail');
				$portfolio_thumbnail_fullwidth = wp_get_attachment_image_src( get_post_thumbnail_id(), 'portfolio-thumbnail-fullwidth');
			
				$portoliopress_custom_query[$category->slug] = array(
					'name' => $category->name,
					'term_link' =>  esc_attr( get_term_link( $category->name, 'portfolio_category' ) ),
					'portfolio-thumbnail' => $portfolio_thumbnail[0],
					'portfolio-thumbnail-fullwidth' => $portfolio_thumbnail_fullwidth[0]
				);
			
			endwhile;
			
			// Reset Post Data
			wp_reset_postdata();

	   } // $categories loop
	   
	   //var_dump($portoliopress_custom_query);
	   
	   ?>
	   
	   <?php	   
	   $fullwidth = of_get_option( 'portfolio_sidebar', false );
	   $thumbnail = 'portfolio-thumbnail';
	   if ( $fullwidth )
	   		$thumbnail = 'portfolio-thumbnail-fullwidth'; ?>
	   		
	   <div id="portfolio"<?php if ( $fullwidth ) { echo ' class="full-width"'; }?>>
	   	
	   <?php  $count = 0;
	   foreach ( $portoliopress_custom_query as $portfolio_cat ) {
		   //echo $portfolio_cat['name'];
		   //echo $portfolio_cat['term_link'];
		   //echo $portfolio_cat['portfolio-thumbnail'];
		   //echo $portfolio_cat['portfolio-thumbnail-fullwidth'];
		   
		   // Fun begins
		   
		   $count++;
		   $classes = 'portfolio-item item-' . $count;
		   if ( $count % 3 == 0 )
		   		$classes .= ' ie-col3';
		   		
		   if ( !($portfolio_cat[$thumbnail]) )
				$classes .= ' no-thumb'; ?>
				
			<div class="<?php echo $classes; ?>">
			<?php if ( $portfolio_cat[$thumbnail] ) { ?>
			<a href="<?php echo $portfolio_cat['term_link']; ?>" class="thumb"><img src="<?php echo $portfolio_cat[$thumbnail]; ?>"></a>
			<?php } ?>
			<a href="<?php echo $portfolio_cat['term_link']; ?>" class="title-overlay"><?php echo $portfolio_cat['name']; ?></a>
		</div>
	   <?php } ?>

		</div><!-- #portfolio -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>