<?php
/**
 * @package WordPress
 * @subpackage Blankfolio
 * @since Blankfolio 1.0
 */

get_header(); ?>

		<div id="content-container">
			<div id="content" role="content-box">

				<h1 class="page-title"><?php
					printf( __( 'Tag Archives: %s', 'blankfolio' ), '<span>' . single_tag_title( '', false ) . '</span>' );
				?></h1>

				<?php get_template_part( 'loop', 'tag' ); ?>
			</div><!-- #content -->
		</div><!-- #content-container -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>