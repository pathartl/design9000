<?php
/*
Template Name: Blog Template
*/

get_header();

?>






<?php
$limit = get_option('posts_per_page');
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
query_posts('showposts=' . $limit . '&paged=' . $paged);
$wp_query->is_archive = true; $wp_query->is_home = false;

global $more;
$more = 0;
?>		
	
<?php while (have_posts()) : the_post(); ?>

		<div class="post" id="post-<?php the_ID(); ?>">

			<h1 class="entry-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h1>

			<h2 class="time"><?php the_time('F jS, Y') ?></h2>

			<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_post_thumbnail('single'); ?></a>	

			<div class="entry">

				<?php the_content('Continue Reading &rarr;'); ?>

			</div>

		

			<p class="postmetadata">Filed under: <?php the_category(', ') ?> <?php if (function_exists('the_tags')) { the_tags('<br/>Tags: ', ', ', ''); } ?></p>

			</div>

		<?php endwhile; ?>

				<div id="nav-below" class="navigation">
					<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'blankfolio' ) ); ?></div>
					<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'blankfolio' ) ); ?></div>
				</div><!-- #nav-below -->


	
<?php get_sidebar(); ?>
<?php get_footer(); ?>