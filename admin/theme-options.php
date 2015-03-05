<?php

add_action('init','of_options');

if (!function_exists('of_options')) {
function of_options(){
	
// VARIABLES
$themename = get_theme_data(STYLESHEETPATH . '/style.css');
$themename = $themename['Name'];
$shortname = "of";

// Populate OptionsFramework option in array for use in theme
global $of_options;
$of_options = get_option('of_options');

$GLOBALS['template_path'] = OF_DIRECTORY;

//Access the WordPress Categories via an Array
$of_categories = array();  
$of_categories_obj = get_categories('hide_empty=0');
foreach ($of_categories_obj as $of_cat) {
    $of_categories[$of_cat->cat_ID] = $of_cat->cat_name;}
$categories_tmp = array_unshift($of_categories, "Select a category:");    
       
//Access the WordPress Pages via an Array
$of_pages = array();
$of_pages_obj = get_pages('sort_column=post_parent,menu_order');    
foreach ($of_pages_obj as $of_page) {
    $of_pages[$of_page->ID] = $of_page->post_name; }
$of_pages_tmp = array_unshift($of_pages, "");       

// Number of featured posts to display
$featured_options_select = array("1","2","3","4","5","6","7","8","9","10");

// Image Alignment radio box
$options_thumb_align = array("alignleft" => "Left","alignright" => "Right","aligncenter" => "Center"); 

// Image Links to Options
$options_image_link_to = array("image" => "The Image","post" => "The Post"); 

//Testing 
$options_select = array("one","two","three","four","five"); 
$options_radio = array("one" => "One","two" => "Two","three" => "Three","four" => "Four","five" => "Five"); 

//Stylesheets Reader
$alt_stylesheet_path = OF_FILEPATH . '/styles/';
$alt_stylesheets = array();

if ( is_dir($alt_stylesheet_path) ) {
    if ($alt_stylesheet_dir = opendir($alt_stylesheet_path) ) { 
        while ( ($alt_stylesheet_file = readdir($alt_stylesheet_dir)) !== false ) {
            if(stristr($alt_stylesheet_file, ".css") !== false) {
                $alt_stylesheets[] = $alt_stylesheet_file;
            }
        }    
    }
}

//More Options
$uploads_arr = wp_upload_dir();
$all_uploads_path = $uploads_arr['path'];
$all_uploads = get_option('of_uploads');
$other_entries = array("Select a number:","1","2","3","4","5","6","7","8","9","10");
$body_repeat = array("no-repeat","repeat-x","repeat-y","repeat");
$body_pos = array("top left","top center","top right","center left","center center","center right","bottom left","bottom center","bottom right");

// Set the Options Array
$options = array();

$options[] = array( "name" => "General Settings",
                    "type" => "heading");
					

$options[] = array( "name" => "Custom Logo",
					"desc" => "Upload a logo for your theme, or specify the image address of your online logo. (http://example.com/logo.png)",
					"id" => $shortname."_logo",
					"std" => "",
					"type" => "upload");
					
$url =  OF_DIRECTORY . '/admin/images/';
$options[] = array( "name" => "Left or Right Sidebar?",
					"desc" => "Select main content and sidebar alignment.",
					"id" => $shortname."_layout",
					"std" => "two-col-left",
					"type" => "images",
					"options" => array(
						'two-col-left' => $url . '2cl.png',
						'two-col-right' => $url . '2cr.png')
					);
					
$options[] = array( "name" => "Custom Favicon",
					"desc" => "Upload a 16px x 16px Png/Gif image that will represent your website's favicon.",
					"id" => $shortname."_custom_favicon",
					"std" => "",
					"type" => "upload"); 

					              
$options[] = array( "name" => "Website Analytics",
					"desc" => "Paste your Google Analytics (or other) tracking code here. This will be added into the footer template of your theme.",
					"id" => $shortname."_google_analytics",
					"std" => "",
					"type" => "textarea");                                                    

    
$options[] = array( "name" => "Homepage Settings",
					"type" => "heading");

$options[] = array( "name" => "Call to Action Text",
					"desc" => "Get your clients attention with a call to action section",
					"id" => $shortname."_action",
					"std" => "",
					"type" => "text");  
					
$options[] = array( "name" => "Custom View My Work Button",
					"desc" => "Upload a custom view my work button. (http://example.com/logo.png). For best results, keep dimensions at 131x38px.",
					"id" => $shortname."_viewmyworkbutton",
					"std" => "",
					"type" => "upload"); 
					
$options[] = array( "name" => "View My Work Text",
					"desc" => "View My Work Button Text.",
					"id" => $shortname."_viewmyworktext",
					"std" => "View My Work",
					"type" => "text");  
					
$options[] = array( "name" => "View My Work Button Link",
					"desc" => "Select a page.",
					"id" => $shortname."_viewmyworklink",
					"std" => "",
					"type" => "select",
					"class" => "",
					"options" => $of_pages);
					
$options[] = array( "name" => "Custom More About Me Button",
					"desc" => "Upload a custom more about me button. (http://example.com/logo.png). For best results, keep dimensions at 131x38px.",
					"id" => $shortname."_moreaboutmebutton",
					"std" => "",
					"type" => "upload"); 

$options[] = array( "name" => "More About Me Text",
					"desc" => "More About Me Button Text.",
					"id" => $shortname."_moreaboutmetext",
					"std" => "More About Me",
					"type" => "text");  
					
$options[] = array( "name" => "More About Me Button Link",
					"desc" => "Select a page.",
					"id" => $shortname."_moreaboutmelink",
					"std" => "",
					"type" => "select",
					"class" => "",
					"options" => $of_pages);
					              
					
$options[] = array( "name" => "Featured Category For Homepage Slider",
					"desc" => "Select a category to highlight using the featured content slider. Assign a post thumbnail to featured posts - 940 x 400 px images work best.",
					"id" => $shortname."_featured_category",
					"std" => "Select a category:",
					"type" => "select",
					"options" => $of_categories);
					
$options[] = array( "name" => "From the Blog Title",
					"desc" => "Change title to your own",
					"id" => $shortname."_fromtheblogtitle",
					"std" => "From the Blog",
					"type" => "text"); 
					
$options[] = array( "name" => "Category For Blog Section",
					"desc" => "Select a category to highlight blog section",
					"id" => $shortname."_blog_category",
					"std" => "Select a category:",
					"type" => "select",
					"options" => $of_categories);
					
$options[] = array( "name" => "Styling Options",
					"type" => "heading");
					
$options[] = array( "name" => "Header Background Color",
					"desc" => "Color setting applied to Header and Footer background colors.",
					"id" => $shortname."_custom_background",
					"std" => "#fafafa",
					"type" => "color");
					
$options[] = array( "name" => "Slider Background Color",
					"desc" => "Color setting applied to header and footer border colors.",
					"id" => $shortname."_slider_background",
					"std" => "#dddddd",
					"type" => "color");
					
$options[] = array( "name" => "Body Background Color",
					"desc" => "Color setting applied to header and footer border colors.",
					"id" => $shortname."_body_background",
					"std" => "#ffffff",
					"type" => "color");
					
$options[] = array( "name" => "Site Title Link Color",
					"desc" => "Color setting applied to link colors.",
					"id" => $shortname."_logo_link",
					"std" => "#004B91",
					"type" => "color");
					
$options[] = array( "name" => "Site Title Link Hover Color",
					"desc" => "Color setting applied to link colors.",
					"id" => $shortname."_logo_link_hover",
					"std" => "#FF4B33",
					"type" => "color");
					
$options[] = array( "name" => "Site Title Description Color",
					"desc" => "Color setting applied to link colors.",
					"id" => $shortname."_logo_description",
					"std" => "#666666",
					"type" => "color");
					
$options[] = array( "name" => "Body Text Color",
					"desc" => "Color setting applied to text colors.",
					"id" => $shortname."_body_text",
					"std" => "#000000",
					"type" => "color");
					
$options[] = array( "name" => "Content Link Color",
					"desc" => "Color setting applied to link colors.",
					"id" => $shortname."_custom_link",
					"std" => "#004B91",
					"type" => "color");
					
$options[] = array( "name" => "Content Link Hover Color",
					"desc" => "Color setting applied to link colors.",
					"id" => $shortname."_custom_link_hover",
					"std" => "#FF4B33",
					"type" => "color");
					
$options[] = array( "name" => "Menu Background Color",
					"desc" => "Color setting applied to link colors.",
					"id" => $shortname."_menu_background",
					"std" => "#eeeeee",
					"type" => "color");
					
$options[] = array( "name" => "Menu Link Color",
					"desc" => "Color setting applied to link colors.",
					"id" => $shortname."_menu_link",
					"std" => "#004B91",
					"type" => "color");
					
$options[] = array( "name" => "Menu Link Hover Color",
					"desc" => "Color setting applied to link colors.",
					"id" => $shortname."_menu_hover_link",
					"std" => "#FF4B33",
					"type" => "color");
					
$options[] = array( "name" => "Border Background Colors",
					"desc" => "Color setting applied to text colors.",
					"id" => $shortname."_border",
					"std" => "#dcdcdc",
					"type" => "color");
					
$options[] = array( "name" => "Custom CSS",
                    "desc" => "Quickly add some CSS to your theme by adding it to this block.",
                    "id" => $shortname."_custom_css",
                    "std" => "",
                    "type" => "textarea");
                    
                    
                    
$options[] = array( "name" => "Footer Customization",
					"type" => "heading");      

$options[] = array( "name" => "Custom Text (Left)",
					"desc" => "Custom HTML and Text that will appear in the footer of your theme.",
					"id" => $shortname."_footer_left",
					"std" => "",
					"type" => "textarea");

$options[] = array( "name" => "Custom Text (Right)",
					"desc" => "Custom HTML and Text that will appear in the footer of your theme.",
					"id" => $shortname."_footer_right",
					"std" => "",
					"type" => "textarea");
					


update_option('of_template',$options); 					  
update_option('of_themename',$themename);   
update_option('of_shortname',$shortname);

}
}
?>
