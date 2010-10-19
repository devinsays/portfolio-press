<?php
/**
 Plugin Name: Simple Custom Post Type Archives
 Plugin URI: http://www.cmurrayconsulting.com/software/wordpress-custom-post-type-archives/
 Description: Adds friendly permalink support, template files, and a conditional for public, non-hierarchical custom post types. A natural extension to the built in custom post types feature in 3.0.
 Version: 0.9.3
 Author: Jacob M Goldman (C. Murray Consulting)
 Author URI: http://www.cmurrayconsulting.com

    Plugin: Copyright 2009 C. Murray Consulting  (email : jake@cmurrayconsulting.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/**
 * is it a post type that this plugin deals with?
 * 
 * @param string|array $post_type should be a custom post type archive
 * @return true if its a post type we deal with, false if not
 */
function is_scpta_post_type( $post_type ) 
{
	if ( is_array($post_type) )		// multiple post types 
	{
		if ( count($post_type) > 1 )	// not a custom post type archive
			return false;
			
		$post_type = $post_type[0];		
	}
	
	if ( !is_string($post_type) )
		return;
	
	$post_type = get_post_type_object( $post_type );
	
	if ( !is_null( $post_type ) && $post_type->_builtin == false && $post_type->public == true && isset($post_type->rewrite['slug']) && !empty($post_type->rewrite['slug']) && $post_type->hierarchical == false ) 
		return $post_type;	
	
	return false;
}

/**
 * generate rewrite rules for custom post type archives
 */

add_action( 'generate_rewrite_rules', 'scpta_rewrite_rules' );

function scpta_rewrite_rules( $wp_rewrite )
{
	$post_types = get_post_types();
	
	foreach ( $post_types as $type ) :
		
		if ( !$type_info = is_scpta_post_type($type) )	// skip native, non-public, no slug types - hierarchical too? 
			continue;
		
		$type_slug = $type_info->rewrite['slug'];
		
		$new_rules = array( 
			$type_slug.'/?$' => 'index.php?post_type='.$type,
		 	$type_slug.'/page/?([0-9]{1,})/?$' => 'index.php?post_type='.$type.'&paged='.$wp_rewrite->preg_index(1),
		 	$type_slug.'/feed/(feed|rdf|rss|rss2|atom)/?$' => 'index.php?post_type='.$type.'&feed='.$wp_rewrite->preg_index(1),
		 	$type_slug.'/(feed|rdf|rss|rss2|atom)/?$' => 'index.php?post_type='.$type.'&feed='.$wp_rewrite->preg_index(1)
		);
		
  		$wp_rewrite->rules = array_merge($new_rules, $wp_rewrite->rules);

	endforeach;
}

/**
 * after querying posts, set some new wp_query properties
 */
 
add_action( 'parse_query', 'scpta_parse_query', 100 );

function scpta_parse_query( $wp_query )
{
	if ( !isset($wp_query->query_vars['post_type']) )
		return;
	
	$post_type = $wp_query->query_vars['post_type'];
	
	if ( get_query_var('name') || !is_scpta_post_type($post_type) || is_robots() || is_feed() || is_trackback() )
		return;
		
	add_filter( 'body_class', 'scpta_body_classes' ); 										// add special body classes
	add_filter( 'wp_title', 'scpta_wp_title', 10, 3 );										// correct wp_title 
	$wp_query->is_home = false;																// correct is_home variable
	$wp_query->is_custom_post_type_archive = true;											// define new query variable
} 

/**
 * custom template files for custom post type archives
 */

add_action( 'template_redirect', 'scpta_template_redirect' );

function scpta_template_redirect()
{	
	if ( is_custom_post_type_archive() ) :
	
		$post_type = is_scpta_post_type( get_query_var('post_type') );
	
		$template = array( "type-".$post_type->name.".php" );
		if ( isset( $post_type->rewrite['slug'] ) ) $template[] = "type-".$post_type->rewrite['slug'].".php";
		array_push( $template, 'type.php', 'index.php' );
	
		locate_template( $template, true );
		
		die();
		
	endif;
}

/**
 * custom wp_title for custom post type archives
 */
function scpta_wp_title($title, $sep, $seplocation)
{
	$post_type = is_scpta_post_type( get_query_var('post_type') );
	
	$title = $post_type->label;
	$t_sep = '%WP_TITILE_SEP%'; // Temporary separator, for accurate flipping, if necessary
	
	$prefix = '';
	if ( !empty($title) )
		$prefix = " $sep ";

 	// Determines position of the separator and direction of the breadcrumb
	if ( 'right' == $seplocation ) { // sep on right, so reverse the order
		$title_array = explode( $t_sep, $title );
		$title_array = array_reverse( $title_array );
		$title = implode( " $sep ", $title_array ) . $prefix;
	} else {
		$title_array = explode( $t_sep, $title );
		$title = $prefix . implode( " $sep ", $title_array );
	}
	
	return $title;
}

/**
 * Add body classes for custom post types.
 */
function scpta_body_classes($classes) 
{
	array_push( $classes, 'custom-post-type-archive', 'custom-post-type-' . get_query_var('post_type') . '-archive' );
	return $classes;
}

/**
 * Determines whether the current view is a custom post type archive.
 * 
 * @param string $post_type Optional. The registered name of the post type to check against. 
 * @return true or false
 */
function is_custom_post_type_archive( $post_type = '' ) 
{
	global $wp_query;
	
	if ( !isset($wp_query->is_custom_post_type_archive) || !$wp_query->is_custom_post_type_archive ) 
		return false;
	
	if ( empty($post_type) || $post_type == get_query_var('post_type') )
		return true;
			
	// not sure whether to add checks against label, singular label or slug... adds more overhead and could be problematic with default labels (post)
		
	return false;
}

/**
 * Display a link to the current post type feed. Automatically called on custom post
 * type archives and single custom post types if automatic feed links is enabled. 
 * Priority of 2 based on feed_links priority in default-filters.php
 */
 
add_action( 'wp_head', 'scpta_feed_links', 2 ); 
 
function scpta_feed_links()
{
	if ( !current_theme_supports('automatic-feed-links') )
		return;
	
	if ( !$post_type = is_scpta_post_type( get_query_var('post_type') ) )
		return;	
	
	echo '<link rel="alternate" type="' . feed_content_type() . '" title="' . esc_attr( get_bloginfo('name') . ' &raquo; '. $post_type->label . ' Feed' ) . '" href="' . get_scpta_feed_link($post_type->name) . "\" />\n";
}

/**
 * Get a feed link for a custom post type archive
 * 
 * @param object $post_type Custom post type name.
 * @param string $feed Optional. Feed type.
 * @return string Link to the feed for the post type specified by $post_type.
 */
function get_scpta_feed_link( $post_type, $feed = '' )
{
	if ( !$post_type = is_scpta_post_type( $post_type ) )
		return false;
		
	if ( empty($feed) )
		$feed = get_default_feed();
		
	$permalink_structure = get_option('permalink_structure');
	
	if ( '' == $permalink_structure ) {
		$link = home_url("?feed=$feed&amp;post_type=" . $post_type->name);
	} else {
		$link = home_url( $post_type->rewrite['slug'] );
		$feed_link = ( $feed == get_default_feed() ) ? 'feed' : "feed/$feed";
		$link = trailingslashit($link) . user_trailingslashit($feed_link, 'feed');
	}
	
	$link = apply_filters('scpta_feed_link', $link, $feed);
	
	return $link;
}

/**
 * on activation and deactivation flush rewrite rules
 */

register_activation_hook( __FILE__, 'scpta_flush_rewrite' );
register_deactivation_hook( __FILE__, 'scpta_flush_rewrite' );

function scpta_flush_rewrite() {
	global $wp_rewrite;
	$wp_rewrite->flush_rules();
}
?>