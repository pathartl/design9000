<?php
/**
 * @package WordPress
 * @subpackage Blankfolio
 * @since Blankfolio 1.0
 */
?>
	</div><!-- #content-box -->

</div><!-- #container -->

<div id="footer" role="contentinfo">
		<div id="colophon">


			<div id="site-info">
				
				
<p>
<?php if( get_option('of_footer_left') != '') { ?>
<?php echo get_option('of_footer_left'); ?>

<?php } else { ?>

&copy; <?php echo date("Y"); ?> <a href="<?php echo home_url( '/' ) ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>. All Rights Reserved.
<?php } ?>
</p>
			</div><!-- #site-info -->
				
                <div id="site-generator">

<p>
<?php if( get_option('of_footer_right') != '') { ?>
<?php echo get_option('of_footer_right'); ?>

<?php } else { ?>

Powered by <a href="http://wordpress.org/">Wordpress</a> and <a href="http://pathartl.me">Pat Hartl</a>.
					
<?php } ?>
</p>
                </div><!-- #site-generator -->

		</div><!-- #colophon -->
	</div><!-- #footer -->


<?php wp_footer(); ?>
</body>
</html>