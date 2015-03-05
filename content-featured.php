<?php
/**
 * @package WordPress
 * @subpackage Blankfolio
 * @since Blankfolio 1.0
 */
?>
<div id="post-<?php the_ID(); ?>">
	<div class="entry-header">
<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'blankfolio' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
	</div><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content('Continue Reading &rarr;'); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'duster' ), 'after' => '</div>' ) ); ?>
	</div><!-- .entry-content -->
</div><!-- #post-<?php the_ID(); ?> -->
