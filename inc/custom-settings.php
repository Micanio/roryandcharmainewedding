<?php
// Remove unnecessary elements from wp_head
remove_action('wp_head','rsd_link');
remove_action('wp_head','wp_generator');
remove_action('wp_head','feed_links', 2);
remove_action('wp_head','index_rel_link');
remove_action('wp_head','wlwmanifest_link');
remove_action('wp_head','feed_links_extra', 3);
remove_action('wp_head','start_post_rel_link', 10, 0);
remove_action('wp_head','parent_post_rel_link', 10, 0);
remove_action('wp_head','adjacent_posts_rel_link', 10, 0);

// Remove emoji	introduced in 4.2
add_action('init','disable_wp_emojicons');
function disable_wp_emojicons() {
	// all actions related to emojis
	remove_action('admin_print_styles', 'print_emoji_styles');
	remove_action('wp_head', 'print_emoji_detection_script', 7);
	remove_action('admin_print_scripts', 'print_emoji_detection_script');
	remove_action('wp_print_styles', 'print_emoji_styles');
	remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
	remove_filter('the_content_feed', 'wp_staticize_emoji');
	remove_filter('comment_text_rss', 'wp_staticize_emoji');
	// filter to remove TinyMCE emojis
	add_filter('tiny_mce_plugins', 'disable_emojicons_tinymce');
}

function disable_emojicons_tinymce($plugins) {
	if (is_array($plugins)) {
		return array_diff($plugins, array('wpemoji'));
	} else {
		return array();
	}
}


// Prevent admin username sniffing
if(isset($_GET['author'])) { header('Location: '.get_site_url()); die(); }




// Customises meta boxes
function customize_meta_boxes() {
  /* Removes meta boxes from Posts */
  remove_meta_box('postcustom','post','normal');
  remove_meta_box('trackbacksdiv','post','normal');
  remove_meta_box('commentstatusdiv','post','normal');
  remove_meta_box('commentsdiv','post','normal');
  // remove_meta_box('tagsdiv-post_tag','post','normal');
  // remove_meta_box('postexcerpt','post','normal');
  /* Removes meta boxes from pages */
  remove_meta_box('postcustom','page','normal');
  remove_meta_box('trackbacksdiv','page','normal');
  remove_meta_box('commentstatusdiv','page','normal');
  remove_meta_box('commentsdiv','page','normal');
}

add_action('admin_init','customize_meta_boxes');


// Removing Post Columns
function custom_post_columns($defaults) {
  unset($defaults['comments']);
  return $defaults;
}

add_filter('manage_posts_columns', 'custom_post_columns');

function custom_pages_columns($defaults) {
  unset($defaults['comments']);
  return $defaults;
}

add_filter('manage_pages_columns', 'custom_pages_columns');



// Custom Logo
function custom_logo() {
  echo '<style type="text/css">
    #header-logo { background-image: url('.get_bloginfo('template_directory').'/images/admin_logo.png) !important; }
    </style>';
}

add_action('admin_head', 'custom_logo');

// Hide the upgrade notice
//add_filter( 'pre_site_transient_update_core', create_function( '$a', "return null;" ) );

if( function_exists( 'acf_add_options_page') ){

  /*acf_add_options_page(
    array(
      'page_title' => 'User Images',
      'menu_title' => 'User Images',
      'capability' => 'edit_posts',
      'parent_slug' => '',
      'menu_slug' => 'user-images',
      'position' => false,
      'icon_url' => 'dashicons-businessman',
      'redirect' => false,
    )
  );*/

}