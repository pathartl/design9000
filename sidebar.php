<?php
/**
 * @package WordPress
 * @subpackage Blankfolio
 * @since Blankfolio 1.0
 */
?>

<div id="sidebar" class="widget-area" role="complementary">
			<ul class="xoxo">

			<?php // The primary sidebar used in all layouts
			if ( ! dynamic_sidebar( 'sidebar-1' ) ) : ?>

				<li class="widget-container">
					<h3 class="widget-title"><?php _e( 'Recent Entries', 'blankfolio' ); ?></h3>
						<ul>
							<?php
							$recent_entries = new WP_Query();
							$recent_entries->query( 'order=DESC&posts_per_page=10' );

							while ($recent_entries->have_posts()) : $recent_entries->the_post();
								?>
								<li><a href="<?php the_permalink() ?>"><?php the_title() ?></a></li>
								<?php
							endwhile;							
							?>
						</ul>
				</li>

				<li class="widget-container">
					<h3 class="widget-title"><?php _e( 'Links', 'blankfolio' ); ?></h3>
						<ul>
							<?php wp_list_bookmarks( array( 'title_li' => '', 'categorize' => 0 ) ); ?>
						</ul>
				</li>

			<?php endif; // end primary widget area ?>
			</ul>
</div><!-- #primary .widget-area -->