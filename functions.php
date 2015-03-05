<?php
/** Tell WordPress to run blankfolio_setup() when the 'after_setup_theme' hook is run. */
add_action( 'after_setup_theme', 'blankfolio_setup' );

if ( ! function_exists( 'blankfolio_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * To override blankfolio_setup() in a child theme, add your own blankfolio_setup to your child theme's
 * functions.php file.
 *
 * @uses add_theme_support() To add support for post thumbnails and automatic feed links.
 * @uses register_nav_menus() To add support for navigation menus.
 * @uses add_custom_background() To add support for a custom background.
 * @uses add_editor_style() To style the visual editor.
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_custom_image_header() To add support for a custom header.
 * @uses register_default_headers() To register the default custom header images provided with the theme.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @since blankfolio 1.0
 */
function blankfolio_setup() {


if ( ! isset( $content_width ) ) $content_width = 480;

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

// Enable post thumbnails
add_theme_support( 'post-thumbnails' );
set_post_thumbnail_size( 50, 50, true );
add_image_size( 'featured', 940, 400, true );
add_image_size( 'small-thumbnail', 213, 100, true );
add_image_size( 'single', 604, 260, true );


	/**
	 * Add support for the Aside and Gallery Post Formats
	 */
	add_theme_support( 'post-formats', array( 'aside', 'gallery' ) );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'blankfolio' ),
	) );
	
/* Begin Theme Options - Based on the theme options framework by wptheming.com */

/* Set the file path based on whether the Options Framework is in a parent theme or child theme */

if ( STYLESHEETPATH == TEMPLATEPATH ) {
	define('OF_FILEPATH', TEMPLATEPATH);
	define('OF_DIRECTORY', get_bloginfo('template_directory'));
} else {
	define('OF_FILEPATH', STYLESHEETPATH);
	define('OF_DIRECTORY', get_bloginfo('stylesheet_directory'));
}

/* These files build out the options interface.  Likely won't need to edit these. */

require_once (OF_FILEPATH . '/admin/admin-functions.php');		// Custom functions and plugins
require_once (OF_FILEPATH . '/admin/admin-interface.php');		// Admin Interfaces (options,framework, seo)

/* These files build out the theme specific options and associated functions. */

require_once (OF_FILEPATH . '/admin/theme-options.php'); 		// Options panel settings and custom settings
require_once (OF_FILEPATH . '/admin/theme-functions.php'); 	// Theme actions based on options settings

/* end Theme Options */

/* Custome Twitter Widget */
require_once(TEMPLATEPATH . '/inc/twitter.php'); // this includes a custom twitter widget.

}
endif;



/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * @since blankfolio 1.0
 */
function blankfolio_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'blankfolio_page_menu_args' );

/**
 * Sets the post excerpt length to 40 characters.
 *
 * @since blankfolio 1.0
 * @return int
 */
function blankfolio_excerpt_length( $length ) {
	return 30;
}
add_filter( 'excerpt_length', 'blankfolio_excerpt_length' );

/**
 * Returns a "Continue Reading" link for excerpts
 *
 * @since blankfolio 1.0
 * @return string "Continue Reading" link
 */
function blankfolio_continue_reading_link() {
	return ' <a href="'. get_permalink() . '">' . __( 'Read More <span class="meta-nav">&rarr;</span>', 'blankfolio' ) . '</a>';
}

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and blankfolio_continue_reading_link().
 *
 * @since blankfolio 1.0
 * @return string An ellipsis
 */
function blankfolio_auto_excerpt_more( $more ) {
	return ' &hellip;' . blankfolio_continue_reading_link();
}
add_filter( 'excerpt_more', 'blankfolio_auto_excerpt_more' );

/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 *
 * @since blankfolio 1.0
 * @return string Excerpt with a pretty "Continue Reading" link
 */
function blankfolio_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= blankfolio_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'blankfolio_custom_excerpt_more' );

/**
 * Remove inline styles printed when the gallery shortcode is used.
 *
 * Galleries are styled by the theme in blankfolio's style.css.
 *
 * @since blankfolio 1.0
 * @return string The gallery style filter, with the styles themselves removed.
 */
function blankfolio_remove_gallery_css( $css ) {
	return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );
}
add_filter( 'gallery_style', 'blankfolio_remove_gallery_css' );

if ( ! function_exists( 'blankfolio_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own blankfolio_comment(), and that function will be used instead.
 *
 * @since blankfolio 1.0
 */
function blankfolio_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case '' :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>">
		<div class="comment-author vcard">
		<div class="gravreply">
			<?php echo get_avatar( $comment, 40 ); ?>
			<?php comment_reply_link(array_merge( $args, array('reply_text' => 'Reply', 'add_below' =>
 $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))); ?>
		</div><!-- end gravreply -->
			<cite class="fn"><?php comment_author_link(); ?></cite>

			<span class="comment-meta commentmetadata">
				<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
				<?php
					/* translators: 1: date, 2: time */
					printf( __( '%1$s', 'blankfolio' ),
						get_comment_date()
					); ?></a>
					<?php edit_comment_link( __( 'Edit', 'blankfolio' ), '' );
				?>
			</span><!-- .comment-meta .commentmetadata -->
		</div><!-- .comment-author .vcard -->
		<?php if ( $comment->comment_approved == '0' ) : ?>
			<em><?php _e( 'Your comment is awaiting moderation.', 'blankfolio' ); ?></em>
			<br />
		<?php endif; ?>

		<div class="comment-body"><?php comment_text(); ?></div>

	</div><!-- #comment-##  -->

	<?php
			break;
		case 'pingback'  :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'blankfolio' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'blankfolio' ), ' ' ); ?></p>
	<?php
			break;
	endswitch;
}
endif;
/**
 * Register widgetized areas, including two sidebars and four widget-ready columns in the footer.
 *
 * @since blankfolio 1.0
 * @uses register_sidebar
 */
function blankfolio_widgets_init() {
	// Area 1, Single page sidebar.
	register_sidebar( array(
		'name' => __( 'Sidebar Widget Area', 'blankfolio' ),
		'id' => 'sidebar-1',
		'description' => __( 'The primary widget area', 'blankfolio' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 2, Homepage sidebar.
	register_sidebar( array(
		'name' => __( 'Homepage Widget Area', 'blankfolio' ),
		'id' => 'homepage-widgets',
		'description' => __( 'The feature widget above the sidebars in Content-Sidebar-Sidebar and Sidebar-Sidebar-Content layouts', 'blankfolio' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}
/** Register sidebars by running blankfolio_widgets_init() on the widgets_init hook. */
add_action( 'widgets_init', 'blankfolio_widgets_init' );

/**
 * Removes the default styles that are packaged with the Recent Comments widget.
 *
 * @since blankfolio 1.0
 */
function blankfolio_remove_recent_comments_style() {
	global $wp_widget_factory;
	remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
}
add_action( 'widgets_init', 'blankfolio_remove_recent_comments_style' );

if ( ! function_exists( 'blankfolio_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post—date/time and author.
 *
 * @since blankfolio 1.0
 */
function blankfolio_posted_on() {
	// use the "byline" class to hide the author name and link. We should make this appear automatically with a multi-author conditional tag in the future
	printf( __( '<span class="%1$s">Posted on</span> %2$s <span class="%4$s"><span class="meta-sep">by</span> %3$s</span>', 'blankfolio' ),
		'meta-prep meta-prep-author',
		sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><span class="entry-date">%3$s</span></a>',
			get_permalink(),
			esc_attr( get_the_time() ),
			get_the_date()
		),
		sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
			get_author_posts_url( get_the_author_meta( 'ID' ) ),
			sprintf( esc_attr__( 'View all posts by %s', 'blankfolio' ), get_the_author() ),
			get_the_author()
		),
		'byline'
	);
}
endif;

if ( ! function_exists( 'blankfolio_posted_in' ) ) :
/**
 * Prints HTML with meta information for the current post (category, tags and permalink).
 *
 * @since blankfolio 1.0
 */
function blankfolio_posted_in() {
	// Retrieves tag list of current post, separated by commas.
	$tag_list = get_the_tag_list( '', ', ' );
	if ( $tag_list ) {
		$posted_in = __( 'This entry was posted in %1$s and tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'blankfolio' );
	} elseif ( is_object_in_taxonomy( get_post_type(), 'category' ) ) {
		$posted_in = __( 'This entry was posted in %1$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'blankfolio' );
	} else {
		$posted_in = __( 'Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'blankfolio' );
	}
	// Prints the string, replacing the placeholders.
	printf(
		$posted_in,
		get_the_category_list( ', ' ),
		$tag_list,
		get_permalink(),
		the_title_attribute( 'echo=0' )
	);
}
endif;


/**
 *  Returns the current blankfolio layout as selected in the theme options
 *
 * @since blankfolio 1.0
 */
function blankfolio_current_layout() {
	$options = get_option( 'blankfolio_theme_options' );
	$current_layout = $options['theme_layout'];

	$two_columns = array( 'content-sidebar', 'sidebar-content' );

	if ( in_array( $current_layout, $two_columns ) )
		return 'two-column ' . $current_layout;
	else
		return 'three-column ' . $current_layout;
}

/**
 *  Adds blankfolio_current_layout() to the array of body classes
 *
 * @since blankfolio 1.0
 */
function blankfolio_body_class($classes) {
	$classes[] = blankfolio_current_layout();
		
	return $classes;
}
add_filter( 'body_class', 'blankfolio_body_class' );
?>