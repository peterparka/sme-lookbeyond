<?php

@ini_set( 'upload_max_size' , '64M' );
@ini_set( 'post_max_size', '64M');
@ini_set( 'max_execution_time', '300' );

require __DIR__.'/inc/custom-fields.php';
require __DIR__.'/inc/filters.php';
require __DIR__.'/inc/styles-scripts.php';
require __DIR__.'/inc/setup.php';
require __DIR__.'/inc/twitter.php';


/**
 * Architect Base Theme functions and definitions
 *
 * @package Arc_starter
 * @since Arc_starter 1.1
 */

if ( ! function_exists( 'arc_setup' ) ):

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which runs
	 * before the init hook. The init hook is too late for some features, such as indicating
	 * support post thumbnails.
	 */
	function arc_setup() {

		/**
		 * Theme supports: Feed links in head, post formats (aside/image/gallery), post thumbnails...
		 */
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'post-thumbnails' );

		/**
		 * This theme uses wp_nav_menu() in one location.
		 */
		register_nav_menus( array(
			'primary' => __( 'Main Navigation', 'architect' ),
		) );

		/**
		 * Remove the crap from the wp_head() function
		 */
		remove_action('wp_head', 'rsd_link');
		remove_action('wp_head', 'wp_generator');
		remove_action('wp_head', 'feed_links', 2);
		remove_action('wp_head', 'index_rel_link');
		remove_action('wp_head', 'wlwmanifest_link');
		remove_action('wp_head', 'feed_links_extra', 3);
		remove_action('wp_head', 'start_post_rel_link', 10, 0);
		remove_action('wp_head', 'parent_post_rel_link', 10, 0);
		remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);

		/** WP in the back-end **/

		/**
		 * Disable the Admin bar (courtesy of Paul Davis - Slim Starkers)
		 */
	    add_filter('show_admin_bar', '__return_false');

		/**
		 * Hide the upgrade notices in Wordpress (especially handy for people like Career Innovation etc etc
		 */
		if (!current_user_can('edit_users')) {
			add_action('init', create_function('$a', "remove_action('init', 'wp_version_check');"), 2);
			add_filter('pre_option_update_core', create_function('$a', "return null;"));
		}

		/**
		 * Prevent users from being able to use the full content editor in WP, allow only the code view
		 * - handy when you need to add in custom html to the post (which actually shouldn't be done)
		 **/
		// add_filter ( 'user_can_richedit' , create_function ( '$a' , 'return false;' ) , 50 );
	}

endif; // arc_setup
/**
 * Tell WordPress to run toolbox_setup() when the 'after_setup_theme' hook is run.
 */
add_action( 'after_setup_theme', 'arc_setup' );

/**
 * Remove any unwanted wordpress dashboard boxes
 */
function disable_default_dashboard_widgets() {
	remove_meta_box('dashboard_recent_comments', 'dashboard', 'core');
	remove_meta_box('dashboard_incoming_links', 'dashboard', 'core');
	remove_meta_box('dashboard_plugins', 'dashboard', 'core');
}
add_action('admin_menu', 'disable_default_dashboard_widgets');

if( function_exists('acf_add_options_page') ) {

    acf_add_options_page();
}

function my_format_TinyMCE( $in ) {
    // $in['remove_linebreaks'] = false;
    // $in['gecko_spellcheck'] = false;
    // $in['keep_styles'] = true;
    // $in['accessibility_focus'] = true;
    // $in['tabfocus_elements'] = 'major-publishing-actions';
    // $in['media_strict'] = false;
    // $in['paste_remove_styles'] = false;
    // $in['paste_remove_spans'] = false;
    // $in['paste_strip_class_attributes'] = 'none';
    // $in['paste_text_use_dialog'] = true;
    // $in['wpeditimage_disable_captions'] = true;
    // $in['plugins'] = 'tabfocus,paste,media,fullscreen,wordpress,wpeditimage,wpgallery,wplink,wpdialogs,wpfullscreen';
    // $in['content_css'] = get_template_directory_uri() . "/editor-style.css";
    // $in['wpautop'] = true;
    $in['apply_source_formatting'] = true;
        $in['block_formats'] = "Paragraph=p; Heading 4=h4"; //Heading 2=h2; Heading 3=h3;
    $in['toolbar1'] = 'bold,italic,strikethrough,bullist,numlist,blockquote,hr,alignleft,aligncenter,alignright,link,unlink,wp_more,spellchecker,wp_fullscreen,wp_adv ';
    $in['toolbar2'] = 'formatselect,underline,alignjustify,forecolor,pastetext,removeformat,charmap,outdent,indent,undo,redo,wp_help ';
    // $in['toolbar3'] = '';
    // $in['toolbar4'] = '';
    return $in;
}
add_filter( 'tiny_mce_before_init', 'my_format_TinyMCE' );

/**
 * Stops the post thumbnail from outputting height and width attributes
 */
// function remove_img_attr ($html) {
//     return preg_replace('/(width|height)="\d+"\s/', "", $html);
// }

// add_filter( 'post_thumbnail_html', 'remove_img_attr' );

add_filter( 'post_thumbnail_html', 'remove_width_attribute', 10 );
add_filter( 'image_send_to_editor', 'remove_width_attribute', 10 );

function remove_width_attribute( $html ) {
   // $html = preg_replace( '/(width|height)="\d*"\s/', "", $html );
   // return $html;
   return preg_replace('/(width|height)="\d+"\s/', "", $html);
}

// Override the calculated image sizes -- for 4.4+
add_filter( 'wp_calculate_image_sizes', '__return_false',  PHP_INT_MAX );
// Override the calculated image sources
add_filter( 'wp_calculate_image_srcset', '__return_false', PHP_INT_MAX );

if ( ! isset( $content_width ) ) {
	$content_width = 630;
}

function breezer_addDivToImage( $content ) {

   // A regular expression of what to look for.
   $pattern = '/(<img([^>]*)>)/i';
   // What to replace it with. $1 refers to the content in the first 'capture group', in parentheses above
   $replacement = '<div class="image-container">$1</div>';

   // run preg_replace() on the $content
   $content = preg_replace( $pattern, $replacement, $content );

   // return the processed content
   return $content;
}

add_filter( 'the_content', 'breezer_addDivToImage' );

?>
