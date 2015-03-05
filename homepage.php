<?php
/**
 * Template Name: Homepage Template
 * Description: If you'd rather have a specific homepage rather than your blog posts. View readme.txt file for instructions.
 *
 * @package WordPress
 * @subpackage Blankfolio
 * @since Blankfolio 1.0
 */

get_header(); ?>

<div id="homepage">
<div id="homepage-page">
				
			<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
							
					<div class="entry-content">
						<?php the_content(); ?>
						<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'blankfolio' ), 'after' => '</div>' ) ); ?>
					
					</div><!-- .entry-content -->
				
			<?php endwhile; ?>

</div><!-- #homepage -->
		
<div id="homepage-blog">
        
        <h3><?php echo get_option('of_fromtheblogtitle'); ?></h3>
       
		<?php $fromtheblog = get_option('of_blog_category'); ?>
		<?php $fromtheblogPosts = new WP_Query(); $fromtheblogPosts->query('category_name='.$fromtheblog.'&showposts=2');  ?>
       
		<?php while ($fromtheblogPosts->have_posts()) : $fromtheblogPosts->the_post(); ?>
		<div class="homepage-post">
		<h4><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h4>
			<div class="latest-entry">
				<?php the_excerpt(); ?>
			</div>
			
			<p class="meta">Written on <?php echo get_the_date(); ?></p>
		</div>
		<?php endwhile; ?>
            
</div><!-- end #blog -->

<div id="homepage-sidebar">
	<ul>
		<?php // The homepage widget area
		if ( ! dynamic_sidebar( 'homepage-widgets' ) ) : ?>

						
		<?php endif; // end homepage widget area ?>
	</ul>
</div>
</div><!-- #homepage -->
<?php get_footer(); ?>