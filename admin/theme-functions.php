<?php

/* These are functions specific to the included option settings and this theme */

/*-----------------------------------------------------------------------------------*/
/* Theme Header Output - wp_head() */
/*-----------------------------------------------------------------------------------*/

// This sets up the layouts and styles selected from the options panel

if (!function_exists('optionsframework_wp_head')) {
	function optionsframework_wp_head() { 
		$shortname =  get_option('of_shortname');
	    
		//Styles
		 if(!isset($_REQUEST['style']))
		 	$style = ''; 
		 else 
	     	$style = $_REQUEST['style'];
	     if ($style != '') {
			  $GLOBALS['stylesheet'] = $style;
	          echo '<link href="'. OF_DIRECTORY .'/styles/'. $GLOBALS['stylesheet'] . '.css" rel="stylesheet" type="text/css" />'."\n"; 
	     } else { 
	          $GLOBALS['stylesheet'] = get_option('of_alt_stylesheet');
	          if($GLOBALS['stylesheet'] != '')
	               echo '<link href="'. OF_DIRECTORY .'/styles/'. $GLOBALS['stylesheet'] .'" rel="stylesheet" type="text/css" />'."\n";         
	          else
	               echo '<link href="'. OF_DIRECTORY .'/styles/default.css" rel="stylesheet" type="text/css" />'."\n";         		  
	     }       
			
		// This prints out the custom css and specific styling options
		of_cpicked_css();
		of_head_css();
	}
}

add_action('wp_head', 'optionsframework_wp_head');


/*-----------------------------------------------------------------------------------*/
/* Output CSS from standarized options */
/*-----------------------------------------------------------------------------------*/

function of_head_css() {

		$shortname =  get_option('of_shortname'); 
		$output = '';
		
		$custom_css = get_option('of_custom_css');
		
		if ($custom_css <> '') {
			$output .= $custom_css . "\n";
		}
		
		// Output styles
		if ($output <> '') {
			$output = "<!-- Custom Styling -->\n<style type=\"text/css\">\n" . $output . "</style>\n";
			echo $output;
		}
	
}

function of_cpicked_css() {
	
?>
<style type="text/css">
	body{
		background: <?php echo get_option('of_body_background'); ?>;
		color: <?php echo get_option('of_body_text'); ?>;
	}
	
	#homepage-sidebar .widget-title, .widget-title{color: <?php echo get_option('of_body_text'); ?>;}

	#headerwrapper{
		background: <?php echo get_option('of_custom_background'); ?>;
	}

	#wrapper{
		background: <?php echo get_option('of_slider_background'); ?>;
	}
	
	#header h1 a{color:<?php echo get_option('of_logo_link'); ?>;}
	#header h1 a:hover{color:<?php echo get_option('of_logo_link_hover'); ?>;}
	
	#header h2{color:<?php echo get_option('of_logo_description'); ?>;}
	
	#access, #access ul ul.sub-menu li a {
		background: <?php echo get_option('of_menu_background'); ?>;
	}	

	#access ul li a {color:<?php echo get_option('of_menu_link'); ?>;}

	#access ul li a:hover {color:<?php echo get_option('of_menu_hover_link'); ?>;}

	a{color:<?php echo get_option('of_custom_link'); ?>; }
	
	a:hover{color:<?php echo get_option('of_custom_link_hover'); ?>; }
	
	#welcome{border-bottom:1px solid <?php echo get_option('of_border'); ?>;}
	
	#footer{border-top:1px solid <?php echo get_option('of_border'); ?>;}
	
</style>
<?php
	
}

/*-----------------------------------------------------------------------------------*/
/* Add Body Classes for Layout
/*-----------------------------------------------------------------------------------*/

// This used to be done through an additional stylesheet call, but it seemed like
// a lot of extra files for something so simple. Adds a body class to indicate sidebar position.

add_filter('body_class','of_body_class');
 
function of_body_class($classes) {
	$shortname =  get_option('of_shortname');
	$layout = get_option($shortname .'_layout');
	if ($layout == '') {
		$layout = 'two-col-left';
	}
	$classes[] = $layout;
	return $classes;
}

/*-----------------------------------------------------------------------------------*/
/* Add Favicon
/*-----------------------------------------------------------------------------------*/

function childtheme_favicon() {
		$shortname =  get_option('of_shortname'); 
		if (get_option($shortname . '_custom_favicon') != '') {
	        echo '<link rel="shortcut icon" href="'.  get_option('of_custom_favicon')  .'"/>'."\n";
	    }
		else { ?>
			<link rel="shortcut icon" href="<?php echo bloginfo('stylesheet_directory') ?>/admin/images/favicon.ico" />
<?php }
}

add_action('wp_head', 'childtheme_favicon');

/*-----------------------------------------------------------------------------------*/
/* Show analytics code in footer */
/*-----------------------------------------------------------------------------------*/

function childtheme_analytics(){
	$shortname =  get_option('of_shortname');
	$output = get_option($shortname . '_google_analytics');
	if ( $output <> "" ) 
		echo stripslashes($output) . "\n";
}
add_action('wp_footer','childtheme_analytics');

?>
