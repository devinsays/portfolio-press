<?php
/**
 * @package Portfolio Press
 */

/**
 * Outputs author information
 */

if ( ! function_exists( 'portfoliopress_postby_meta' ) ):
function portfoliopress_postby_meta() {

	printf( __( '<span class="meta-prep meta-prep-author">Posted on </span><a href="%1$s" rel="bookmark"><time class="entry-date" datetime="%2$s" pubdate>%3$s</time></a> <span class="meta-sep"> by </span> <span class="author vcard"><a class="url fn n" href="%4$s" title="%5$s">%6$s</a></span>', 'portfoliopress' ),
		get_permalink(),
		get_the_date( 'c' ),
		get_the_date(),
		get_author_posts_url( get_the_author_meta( 'ID' ) ),
		sprintf( esc_attr__( 'View all posts by %s', 'portfoliopress' ), get_the_author() ),
		get_the_author()
	);

}
endif;

/**
 * Displays footer text
 */

if ( ! function_exists( 'portfoliopress_footer_meta' ) ):
function portfoliopress_footer_meta( $format ) { ?>

	<footer class="entry-meta">

		<?php if ( $format == 'quote' || $format == 'image' ) {
			portfoliopress_postby_meta();
		} ?>

		<?php if ( $format != 'quote' && $format != 'image'  ) : ?>
		<span class="cat-links"><span class="entry-utility-prep entry-utility-prep-cat-links"><?php _e( 'Posted in ', 'portfoliopress' ); ?></span><?php the_category( ', ' ); ?></span>
		<?php the_tags( '<span class="meta-sep"> | </span><span class="tag-links">' . __( 'Tagged ', 'portfoliopress' ) . '</span>', ', ', '' ); ?>
		<?php endif; ?>

		<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
		<span class="meta-sep"> | </span>
		<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'portfoliopress' ), __( '1 Comment', 'portfoliopress' ), __( '% Comments', 'portfoliopress' ) ); ?></span>
		<?php endif; ?>

		<?php edit_post_link( __( 'Edit', 'portfoliopress' ), '<span class="meta-sep">|</span> <span class="edit-link">', '</span>' ); ?>
	</footer><!-- #entry-meta -->

<?php }
endif;

/**
 * Reusable navigation code for navigation
 * Display navigation to next/previous pages when applicable
 */

if ( ! function_exists( 'portfoliopress_content_nav' ) ):
function portfoliopress_content_nav() {
	global $wp_query;
	if (  $wp_query->max_num_pages > 1 ) :
		if (function_exists('wp_pagenavi') ) {
			wp_pagenavi();
		} else { ?>
        	<nav id="nav-below">
			<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'portfoliopress' ); ?></h1>
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'portfoliopress' ) ); ?></div>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'portfoliopress' ) ); ?></div>
			</nav><!-- #nav-below -->
    	<?php }
	endif;
}
endif;

/**
 * Sets posts displayed per portfolio page to 9
 */

function wpt_portfolio_custom_posts_per_page( $query ) {
	global $wp_the_query;
	if ( $wp_the_query === $query && !is_admin() ) {
		if ( is_post_type_archive( 'portfolio' ) || is_tax( 'portfolio_tag' ) ||  is_tax( 'portfolio_category' ) ) {
			$posts_per_page = apply_filters( 'portfoliopress_posts_per_page', '9' );
			$query->set( 'posts_per_page', $posts_per_page );
		}
	}
}
add_action( 'pre_get_posts', 'wpt_portfolio_custom_posts_per_page' );

/**
 * Overrides the default behavior of portfolio taxonomies to use the archive-portfolio template
 * http://www.billerickson.net/reusing-wordpress-theme-files/
 */

function portfoliopress_template_chooser( $template ) {
	if ( is_tax( 'portfolio_tag' ) ||  is_tax( 'portfolio_category' ) )
		$template = get_query_template( 'archive-portfolio' );
	if ( is_tax( 'post_format', 'post-format-image' ) )
		$template = get_query_template( 'archive-portfolio' );
	return $template;
}
add_filter( 'template_include', 'portfoliopress_template_chooser' );

/**
 * Adds a body class to indicate sidebar position
 */

function portfolio_body_class( $classes ) {

	// Body class for full width portfolio archives
	if ( of_get_option( 'portfolio_sidebar', false ) ) {
		if ( is_post_type_archive( 'portfolio' ) || is_tax( 'post_format', 'post-format-image' ) ) {
			$classes[] = 'full-width-portfolio';
		}
	}

	// Body class for portfolio page template
	if ( is_page_template( 'templates/portfolio.php' ) )
		$classes[] = 'post-type-archive-portfolio';

	// Body class for full width portfolio page template
	if ( is_page_template( 'templates/full-width-portfolio.php' ) )
		$classes[] = 'post-type-archive-portfolio full-width-portfolio';

	// Body class for image post format archive template
	if ( is_page_template( 'templates/post-format-gallery-image.php' ) )
		$classes[] = 'post-type-archive-portfolio';

	// Body class for image post format
	if ( is_tax( 'post_format', 'post-format-image' ) )
		$classes[] = 'post-type-archive-portfolio';

	return $classes;
}
add_filter('body_class','portfolio_body_class');