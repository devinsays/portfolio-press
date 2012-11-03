<?php
/**
 * The template used for displaying comments
 *
 * @package Portfolio Press
 */
 ?>

	<div id="comments">
	<?php if ( post_password_required() ) : ?>
		<div class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'portfoliopress' ); ?></div>
	</div><!-- .comments -->
	<?php return;
		endif;
	?>

	<?php // You can start editing here -- including this comment! ?>

	<?php if ( have_comments() ) : ?>
		<h3 id="comments-title">
			<?php
			    printf( _n( 'One Response to %2$s', '%1$s Responses to %2$s', get_comments_number(), 'portfoliopress' ),
			        number_format_i18n( get_comments_number() ), '<em>' . get_the_title() . '</em>' );
			?>
		</h3>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-above">
			<h1 class="screen-reader-text"><?php _e( 'Comment navigation', 'portfoliopress' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'portfoliopress' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'portfoliopress' ) ); ?></div>
		</nav>
		<?php endif; // check for comment navigation ?>

		<ol class="commentlist">
			<?php wp_list_comments(array('avatar_size'=>50)); ?>
		</ol>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-below">
			<h1 class="screen-reader-text"><?php _e( 'Comment navigation', 'portfoliopress' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'portfoliopress' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'portfoliopress' ) ); ?></div>
		</nav>
		<?php endif; // check for comment navigation ?>

	<?php endif; ?>

	<?php comment_form(); ?>

</div><!-- #comments -->