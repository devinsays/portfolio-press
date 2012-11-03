<?php
/**
 * Sidebar template
 *
 * @package Portfolio Press
 */
?>
	<?php if ( of_get_option('layout') != 'layout-1col' ) : ?>
	<div id="sidebar" role="complementary">
		<ul class="xoxo">
		<?php if ( ! dynamic_sidebar( 'sidebar' ) ) : ?>

			<li id="search" class="widget-container widget_search">
				<?php get_search_form(); ?>
			</li>

			<li id="archives" class="widget-container">
				<h3 class="widget-title"><?php _e( 'Archives', 'portfoliopress' ); ?></h3>
				<ul>
					<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
				</ul>
			</li>

			<li id="meta" class="widget-container">
				<h3 class="widget-title"><?php _e( 'Meta', 'portfoliopress' ); ?></h3>
				<ul>
					<?php wp_register(); ?>
					<li><?php wp_loginout(); ?></li>
					<?php wp_meta(); ?>
				</ul>
			</li>

		<?php endif; // end sidebar widget area ?>
		</ul>
	</div><!-- #secondary .widget-area -->
	<?php endif; ?>