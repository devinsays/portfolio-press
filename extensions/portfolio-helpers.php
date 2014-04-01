<?php
/**
 * @package Portfolio Press
 */

/**
 * Overrides the default behavior of portfolio taxonomies to use the archive-portfolio template
 * http://www.billerickson.net/reusing-wordpress-theme-files/
 *
 * @param string template path
 */
function portfoliopress_template_chooser( $template ) {

	global $wp_query;
	$portfolio = false;

	// Check if the taxonomy query contains only image or gallery post formats
	if ( is_category() || is_tag() || is_home() ) {
		$portfolio = true;
		if ( $wp_query->have_posts() ) :
			while ( $wp_query->have_posts() ) : $wp_query->the_post();
				$format = get_post_format();
				if ( ( $format !=='image' ) && ( $format != 'gallery' ) ) {
					$portfolio = false;
				}
			endwhile;
		endif;
	}

	// Check if template should be displayed as archive-portfolio.php
	if (
		is_post_type_archive( 'portfolio' ) ||
		is_tax( 'post_format', 'post-format-image' ) ||
		is_tax( 'post_format', 'post-format-gallery' ) ||
		is_tax( 'portfolio_category' ) ||
		is_tax( 'portfolio_tag' )
	) {
		$portfolio = true;
	}

	// Use the archive-portfolio.php template
	if ( $portfolio ) {
		$wp_query->set( 'portfolio_view', true );
		$template = get_query_template( 'archive-portfolio' );
	}

	return $template;
}
add_filter( 'template_include', 'portfoliopress_template_chooser' );

/**
 * Adds a body class to archives that display as a portfolio view
 *
 * @param array classes applied to post
 * @return array modified classes
 */
function portfoliopress_body_class( $classes ) {

	global $post;

	if (
		is_page_template( 'templates/portfolio.php' ) ||
		is_page_template( 'templates/full-width-portfolio.php' ) ||
		is_page_template( 'templates/image-gallery-formats.php' ) ||
		is_page_template( 'templates/full-width-image-gallery-formats.php' ) ||
		get_query_var( 'portfolio_view' )
	) {
		$classes[] = 'portfolio-view';
		if ( of_get_option( 'portfolio_sidebar', false ) ) {
			$classes[] = 'full-width-portfolio';
		}
	}

	// Remove the term "templates" from the page template body class
	// Primarily for backwards compatibility
	if ( isset( $post) && (
			is_page_template( 'templates/full-width-page.php' ) ||
			is_page_template( 'templates/portfolio.php' ) ||
			is_page_template( 'templates/full-width-portfolio.php' ) ||
			is_page_template( 'templates/image-gallery-formats.php' ) ||
			is_page_template( 'templates/full-width-image-gallery-formats.php' )
		)
	) {
		foreach( $classes as $key => $value) {
			if ( $value == 'page-template-templatesfull-width-page-php') {
				$classes[$key] = 'page-template-full-width-page-php';
			}
			if ( $value == 'page-template-templatesportfolio-php') {
				$classes[$key] = 'page-template-portfolio-php';
			}
			if ( $value == 'page-template-templatesfull-width-portfolio-php') {
				$classes[$key] = 'page-template-full-width-portfolio-php';
			}
			if ( $value == 'page-template-templatesimage-gallery-formats-php') {
				$classes[$key] = 'page-template-image-gallery-formats-php';
			}
			if ( $value == 'page-template-templatesfull-width-image-gallery-formats-php') {
				$classes[$key] = 'page-template-full-width-image-gallery-formats-php';
			}
		}
	}

	if ( !of_get_option( 'portfolio_sidebar', false ) ) {
		if (
			is_page_template( 'templates/full-width-portfolio.php' ) ||
			is_page_template( 'templates/full-width-image-gallery-formats.php' )
		) {
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

	// Don't display images on single post if the option is turned off
	if ( is_single() && !of_get_option( 'portfolio_images', true ) ) {
		return;
	}

	if ( !post_password_required() && has_post_thumbnail() ) :

	if ( ( 'image' == get_post_format() ) || 'portfolio' == get_post_type() ) { ?>
	<div class="portfolio-image">
		<?php if ( !is_single() ) { ?>
			<a href="<?php the_permalink() ?>" rel="bookmark" class="thumb">
		<?php } ?>
		<?php if ( of_get_option( 'layout' ) == 'layout-1col' ) {
			the_post_thumbnail( 'portfolio-fullwidth' );
		} else {
			the_post_thumbnail( 'portfolio-large' );
		} ?>
		<?php if ( !is_single() ) { ?>
			</a>
		<?php } ?>
	</div>
	<?php  }
	endif;
}

/**
 * Helper function to display a gallery.
 *
 * @param object $post
 */
function portfoliopress_display_gallery( $post ) {
	$pattern = get_shortcode_regex();
	preg_match('/'.$pattern.'/s', $post->post_content, $matches);
	if ( is_array( $matches ) && $matches[2] == 'gallery' ) {
		$shortcode = $matches[0];
		echo do_shortcode( $shortcode );
	}
}