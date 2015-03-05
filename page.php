<?php
/**
 * @package WordPress
 * @subpackage Blankfolio
 * @since Blankfolio 1.0
 */

get_header(); ?>

		<div id="content-container">
			<div id="content" role="content-box">

			<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<?php if ( is_front_page() ) { ?>
						<h2 class="entry-title"><?php the_title(); ?></h2>
					<?php } else { ?>
						<h1 class="entry-title"><?php the_title(); ?></h1>
					<?php } ?>

					<div class="entry-content">
						<?php the_content(); ?>
						<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'blankfoliopress' ), 'after' => '</div>' ) ); ?>
						<?php edit_post_link( __( 'Edit', 'blankfoliopress' ), '<p class="edit-link">', '</p>' ); ?>
					</div><!-- .entry-content -->
				</div><!-- #post-## -->
				
				
				<?php /* Enable/disable comments in pages */
			if( get_option('of_pages_comments') == 'true') { ?>
				<?php comments_template( '', true ); ?>
				<?php } ?>

			<?php endwhile; ?>

			</div><!-- #content -->
		</div><!-- #content-container -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>