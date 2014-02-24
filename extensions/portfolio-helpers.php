<?php
/**
 * @package Portfolio Press
 */

/**
 * Overrides the default behavior of portfolio taxonomies to use the archive-portfolio template
 * http://www.billerickson.net/reusing-wordpress-theme-files/
 */
function portfoliopress_template_chooser( $template ) {
	if ( is_tax( 'portfolio_tag' ) ||  is_tax( 'portfolio_category' ) )
		$template = get_query_template( 'archive-portfolio' );
	if ( is_tax( 'post_format', 'post-format-image' ) || is_tax( 'post_format', 'post-format-gallery' ) )
		$template = get_query_template( 'archive-portfolio' );
	return $template;
}
add_filter( 'template_include', 'portfoliopress_template_chooser' );

/**
 * Sets posts displayed per portfolio to 9
 */
function portfoliopress_portfolio_posts( $query ) {

	if ( !$query->is_main_query() )
        return;



	if (
		is_post_type_archive( 'portfolio' ) ||
		is_tax( 'post_format', 'post-format-image' ) ||
		is_tax( 'post_format', 'post-format-gallery' ) ||
		is_tax( 'portfolio_category' ) ||
		is_tax( 'portfolio_tag' ) ||
		// Check for $post to avoid notices on 404 page
		( isset( $post) ) && (
			is_page_template( 'templates/portfolio.php' ) ||
			is_page_template( 'templates/full-width-portfolio.php' ) ||
			is_page_template( 'templates/post-format-gallery-image.php' )
		)
	) {
		$posts_per_page = apply_filters( 'portfoliopress_posts_per_page', of_get_option('portfolio_num','9') );
		$query->set( 'posts_per_page', $posts_per_page );
	}

}
add_action( 'pre_get_posts', 'portfoliopress_portfolio_posts' );

/**
 * Adds a body class to archives that display as a portfolio view
 */
function portfoliopress_body_class( $classes ) {

	if (
		is_post_type_archive( 'portfolio' ) ||
		is_page_template( 'templates/portfolio.php' ) ||
		is_page_template( 'templates/full-width-portfolio.php' ) ||
		is_page_template( 'templates/post-format-gallery-image.php' ) ||
		is_tax( 'post_format', 'post-format-image' ) ||
		is_tax( 'post_format', 'post-format-gallery' ) ||
		is_tax( 'portfolio_category' ) ||
		is_tax( 'portfolio_tag' )
	) {
		$classes[] = 'portfolio-view';
		if ( of_get_option( 'portfolio_sidebar', false ) ) {
			$classes[] = 'full-width-portfolio';
		}
	}

	if ( !of_get_option( 'portfolio_sidebar', false ) ) {
		if ( is_page_template( 'templates/full-width-portfolio.php' ) ) {
			$classes[] = 'full-width-portfolio';
		}
	}

	return $classes;
}
add_filter( 'body_class','portfoliopress_body_class' );

/**
 * Helper function for displaying image
 */
function portfoliopress_display_image() {

	if (
		!post_password_required() &&
		has_post_thumbnail() &&
		of_get_option( 'portfolio_images', '1' )
	) :
	if ( ( 'image' == get_post_format() ) || 'portfolio' == get_post_type() ) { ?>
	<div class="portfolio-image">
		<?php if ( is_search() || is_archive() ) { ?>
			<a href="<?php the_permalink() ?>" rel="bookmark" class="thumb">
		<?php } ?>
		<?php if ( of_get_option( 'layout') == 'layout-1col' ) {
			the_post_thumbnail( 'portfolio-fullwidth' );
		} else {
			the_post_thumbnail( 'portfolio-large' );
		} ?>
		<?php if ( is_search() || is_archive() ) { ?>
			</a>
		<?php } ?>
	</div>
	<?php  }
	endif;
}