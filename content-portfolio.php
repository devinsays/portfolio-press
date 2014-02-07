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
		<h3><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title() ?></a></h3>
		<?php if ( has_post_format() ) :
			$format = get_post_format();
		?>
		<div class="portfolio-format-meta icon-format-<?php echo $format; ?>"></div>
		<?php endif; ?>
		<a href="<?php the_permalink() ?>" rel="bookmark" class="thumb">
			<?php if ( post_password_required() ) { ?>
				<img src="<?php echo get_template_directory_uri() . '/images/protected-' . $thumbnail . '.gif'; ?>">
			<?php }
			elseif ( has_post_thumbnail() ) {
				the_post_thumbnail( 'portfolio-' . $thumbnail );
			} else { ?>
				<img src="<?php echo get_template_directory_uri() . '/images/placeholder-' . $thumbnail . '.gif'; ?>">
			<?php } ?>
		</a>
	</div><!-- .entry-content -->
</article><!-- #post-<?php the_ID(); ?> -->