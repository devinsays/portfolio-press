<?php
/**
 * @package Portfolio Press
 */
 
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