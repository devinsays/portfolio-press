<?php
/**
 * This template displays portfolio post content
 *
 * @package Portfolio Press
 */

// Set the size of the thumbnails and content width
$fullwidth = false;

// If portfolio is displayed full width
if ( of_get_option( 'portfolio_sidebar' ) || is_page_template( 'full-width-portfolio.php' ) )
	$fullwidth = true;

// If portfolio is a 1-column layout
if ( of_get_option('layout','layout-2cr') ==  'layout-1col' )
	$fullwidth = true;

$thumbnail = 'thumbnail';

if ( $fullwidth )
	$thumbnail = 'thumbnail-fullwidth';
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-content">
		<a href="<?php the_permalink() ?>" rel="bookmark" class="thumb">
			<h3><?php the_title() ?></h3>
			<?php
			if ( has_post_format( array( 'gallery', 'image' ) ) ) :
				$format = get_post_format();
			?>
			<div class="portfolio-format-meta icon-format-<?php echo $format; ?>"></div>
			<?php endif; ?>
			<?php if ( post_password_required() ) { ?>
				<img src="<?php echo  esc_url( get_template_directory_uri() . '/images/protected-' . $thumbnail . '.gif' ); ?>">
			<?php }
			elseif ( has_post_thumbnail() ) {
				the_post_thumbnail( 'portfolio-' . $thumbnail );
			} else { ?>
				<img src="<?php echo esc_url( get_template_directory_uri() . '/images/placeholder-' . $thumbnail . '.gif' ); ?>">
			<?php } ?>
		</a>
	</div><!-- .entry-content -->
</article><!-- #post-<?php the_ID(); ?> -->