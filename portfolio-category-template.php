<?php
/*
 * Template Name: Portfolio Categories
 * Description: Displays all the portfolio categories
 *
 * @package WordPress
 * @subpackage Portfolio Press
 */
 
// This template requires some additional functions to work properly
require_once( get_template_directory() . '/extensions/portfolio-category-functions.php' );

get_header();
	   
	   $portoliopress_category_query = get_transient('portoliopress_category_query');
	   if ( !$portoliopress_category_query ) {
	   		$portoliopress_category_query = portfoliopress_category_cache();
	   }
	    
	   $fullwidth = of_get_option( 'portfolio_sidebar', false );
	   $thumbnail = 'portfolio-thumbnail';
	   if ( $fullwidth )
	   		$thumbnail = 'portfolio-thumbnail-fullwidth'; ?>
	   		
	   <div id="portfolio"<?php if ( $fullwidth ) { echo ' class="full-width"'; }?>>
	   	
	   <?php  $count = 0;
	   foreach ( $portoliopress_category_query as $portfolio_cat ) {
		   
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

<?php if ( !of_get_option( 'portfolio_sidebar' ) )
	get_sidebar();

get_footer();