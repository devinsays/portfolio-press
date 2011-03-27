<?php
/**
 * Enable Custom Post Types for Portfolio Items
 * http://codex.wordpress.org/Function_Reference/register_post_type
 */
 
// Registers the new post type and taxonomy

function wpt_portfolio_posttype() {

	$labels = array(
		'name' => __( 'Portfolio', 'portfoliopress' ),
		'singular_name' => __( 'Portfolio Item', 'portfoliopress' ),
		'add_new' => __( 'Add New Item', 'portfoliopress' ),
		'add_new_item' => __( 'Add New Portfolio Item', 'portfoliopress' ),
		'edit_item' => __( 'Edit Portfolio Item', 'portfoliopress' ),
		'new_item' => __( 'Add New Portfolio Item', 'portfoliopress' ),
		'view_item' => __( 'View Item', 'portfoliopress' ),
		'search_items' => __( 'Search Portfolio', 'portfoliopress' ),
		'not_found' => __( 'No portfolio items found', 'portfoliopress' ),
		'not_found_in_trash' => __( 'No portfolio items found in trash', 'portfoliopress' )
	);

	$args = array(
    	'labels' => $labels,
    	'public' => true,
		'supports' => array( 'title', 'editor', 'thumbnail', 'comments' ),
		'capability_type' => 'post',
		'rewrite' => array("slug" => "portfolio"), // Permalinks format
		'menu_position' => 5,
		'has_archive' => true
	); 

	register_post_type( 'portfolio', $args);
	
	$taxonomy_args = array(
		'hierarchical' => false,
		'label' => __( 'Portfolio Tags', 'portfoliopress' ), 
		'labels' => array(
			'name' => __( 'Portfolio Tags', 'portfoliopress' ),
			'singular_name' => __( 'Portfolio Tag', 'portfoliopress' )
		)
	);
	
	register_taxonomy( 'portfolio-tags', 'portfolio', $taxonomy_args);
}

add_action( 'init', 'wpt_portfolio_posttype' );

// Allow thumbnails to be used on portfolio post type

add_theme_support( 'post-thumbnails', array( 'portfolio' ) );

add_image_size( 'portfolio-thumbnail', 215, 175, true );
add_image_size( 'portfolio-thumbnail-fullwidth', 308, 220, true );
add_image_size( 'portfolio-large', 630, 9999, false );

//  Add Columns to Portfolio Edit Screen
//  http://wptheming.com/2010/07/column-edit-pages/

add_filter("manage_edit-portfolio_columns", "portfolio_edit_columns");

add_action("manage_posts_custom_column",  "portfolio_columns_display", 10, 2);

 
function portfolio_edit_columns($portfolio_columns){
	$portfolio_columns = array(
		"cb" => "<input type=\"checkbox\" />",
		"title" => _x('Title', 'column name'),
		"thumbnail" => __('Thumbnail', 'portfoliopress'),
		"portfolio-tags" => __('Tags', 'portfoliopress'),
		"author" => __('Author', 'portfoliopress'),
		"comments" => __('Comments', 'portfoliopress'),
		"date" => __('Date', 'portfoliopress'),
	);
	$portfolio_columns['comments'] = '<div class="vers"><img alt="Comments" src="' . esc_url( admin_url( 'images/comment-grey-bubble.png' ) ) . '" /></div>';
	return $portfolio_columns;
}
 
function portfolio_columns_display($portfolio_columns, $post_id){

	switch ($portfolio_columns)
	
	{
		// Code from: http://wpengineer.com/display-post-thumbnail-post-page-overview
		
		case "thumbnail":
			$width = (int) 35;
			$height = (int) 35;
			$thumbnail_id = get_post_meta( $post_id, '_thumbnail_id', true );
			
			// Display the featured image in the column view if possible
			if ($thumbnail_id) {
				$thumb = wp_get_attachment_image( $thumbnail_id, array($width, $height), true );
			}
			if ( isset($thumb) ) {
				echo $thumb;
			} else {
				echo __('None', 'portfoliopress');
			}
			break;	
			
			// Display the portfolio tags in the column view
			case "portfolio-tags":
			
			if ( $tag_list = get_the_term_list( $post_id, 'portfolio-tags', '', ', ', '' ) ) {
				echo $tag_list;
			} else {
				echo __('None', 'portfoliopress');
			}
			break;			
	}
}
	
// Sets posts displayed per portfolio page to 9 -- Feel free to change
	
function wpt_portfolio_custom_posts_per_page( &$q ) {
	if ( get_post_type() == 'portfolio' )
		$q->set( 'posts_per_page', 9 );
	return $q;
}

add_filter('parse_query', 'wpt_portfolio_custom_posts_per_page');

// Styling for the custom post type icon

add_action( 'admin_head', 'wpt_portfolio_icons' );

function wpt_portfolio_icons() {
    ?>
    <style type="text/css" media="screen">
        #menu-posts-portfolio .wp-menu-image {
            background: url(<?php echo get_template_directory_uri(); ?>/images/portfolio-icon.png) no-repeat 6px 6px !important;
        }
		#menu-posts-portfolio:hover .wp-menu-image, #menu-posts-portfolio.wp-has-current-submenu .wp-menu-image {
            background-position:6px -16px !important;
        }
		#icon-edit.icon32-posts-portfolio {background: url(<?php echo get_template_directory_uri(); ?> /images/portfolio-32x32.png) no-repeat;}
    </style>
<?php }

?>