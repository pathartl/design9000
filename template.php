<?php
/**
 * Template Name: Page Template
 * Description: If you'd rather have a specific homepage rather than your blog posts. View readme.txt file for instructions.
 *
 * @package WordPress
 * @subpackage Blankfolio
 * @since Blankfolio 1.0
 */
get_header();

?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

<div id="store-content">
	<div id="welcome"><h2 class="welcome-title"><?php the_title(); ?></h2></div>
	<div class="page-content"><?php the_content(); ?></div>
	<div class="clear"></div>
</div>
<div id="store-sidebar">
	<h3>Pages</h3>
	<ul>
		<?php wp_list_pages( array( 'title_li' => '', 'categorize' => 0 ) ); ?>
		<?php
			if(is_user_logged_in()) {
				echo '<li><a href="' . get_bloginfo('url') . '/inventory">Inventory</a></li>';
			}
		?>
	</ul>
</div>

<?php endwhile; ?>

<?php

get_footer();

?>