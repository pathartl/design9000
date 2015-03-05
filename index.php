<?php
/**
 * @package WordPress
 * @subpackage Design 9000
 * @since Design 9000 1.0
 */

get_header(); 
?>

		<div id="content-container">
			<div id="content" role="content-box">

			<?php get_template_part( 'loop', 'index' ); ?>
			</div><!-- #content -->
		</div><!-- #content-container -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
