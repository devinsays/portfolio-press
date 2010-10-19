<?php
/**
 * @package WordPress
 * @subpackage Portfolio Press
 */

get_header(); ?>

		<div id="primary">
			<div id="content">

				<h2 class="page-title"><?php
					printf( __( 'Category Archives: %s', 'portfoliopress' ), '<span>' . single_cat_title( '', false ) . '</span>' );
				?></h2>

				<?php $categorydesc = category_description(); if ( ! empty( $categorydesc ) ) echo apply_filters( 'archive_meta', '<div class="archive-meta">' . $categorydesc . '</div>' ); ?>

				<?php get_template_part( 'loop', 'category' ); ?>

			</div><!-- #content -->
		</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>