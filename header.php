<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Blankfolio
 * @since Blankfolio 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'blankfolio' ), max( $paged, $page ) );

	?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />


<!-- start bxSlider -->
<script src="http://code.jquery.com/jquery-latest.js" type="text/javascript"></script>
<script src="<?php bloginfo('template_directory'); ?>/fancybox/jquery.mousewheel-3.0.4.pack.js" type="text/javascript"></script>
<script src="<?php bloginfo('template_directory'); ?>/fancybox/jquery.fancybox-1.3.4.pack.js" type="text/javascript"></script>
<script src="<?php bloginfo('template_directory'); ?>/js/simpleCart.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" media="screen" href="<?php bloginfo( 'template_directory' ); ?>/fancybox/jquery.fancybox-1.3.4.css" />


<script type="text/javascript">


simpleCart.email = "";
simpleCart.shippingFlatRate = 3.00;
simpleCart.cartHeaders = ["Thumbnail", "Name", "increment", "Quantity_input", "decrement", "Total", "Remove", "Size"];


$(document).ready(function(){
	$("a.fancybox").fancybox();
});
</script>
<!-- end bxSlider -->

<?php
	/* We add some JavaScript to pages with the comment form
	 * to support sites with threaded comments (when in use).
	 */
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	/* Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */
	wp_head();
?>
</head>

<body <?php body_class(); ?>>

<div id="headerwrapper">	
<div id="header">
		<div id="logo">
					<?php if( get_option('of_logo') != '') { ?>
		<a class="image" href="<?php echo get_option('home'); ?>/" title="Home">
			<img src="<?php echo get_option('of_logo'); ?>"  />
		</a>
		<?php } else { ?>
			<h1 class="front-page-logo"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo('name'); ?></a></h1>	
			<h2><?php bloginfo('description'); ?></h2>
		<?php } ?>
		</div>
</div><!-- end #header -->
</div><!-- end #headerwrapper -->		
	
	
<?php if (is_front_page()) : ?>			
		
		<div id="welcome">

			<h2 class="welcome-title"><?php if( get_option('of_action') != '') { ?><?php echo get_option('of_action'); ?><?php } else { ?><?php the_title(); ?><?php } ?></h2>
			
		</div><!-- end #welcome -->
<?php endif; ?>	

<div id="container">
<div id="content-box">
