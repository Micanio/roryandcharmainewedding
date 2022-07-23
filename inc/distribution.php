<?php 
/**
***  Distribution functions
**/


// Check if we are using distribution files
function owr_is_dist(){
	
	$dev_ips = array('192.168.50.1');

	if(!in_array($_SERVER['REMOTE_ADDR'], $dev_ips)){
		return true;
	} 
	return false;
}

// Enqueue styles and scripts
if (!is_admin()) add_action('wp_enqueue_scripts', 'owr_enqueue_scripts');

function owr_enqueue_scripts() {
	
	if(owr_is_dist()) { // Distribution
	
		// CSS
		//wp_enqueue_style('owr-css-styles', get_template_directory_uri() . '/dist/styles/style.min.css');
		wp_enqueue_style('owr-css-styles', get_template_directory_uri() . '/dist/styles/style.css');
		// Scripts
		if (is_page('contact')) {
			wp_enqueue_script( 'google-map', '', array(), '3', true );
		};
		wp_enqueue_script('owr-js-scripts', get_template_directory_uri() . '/dist/vendor.js', array('jquery'), '1.0.0', true);
		wp_enqueue_script('owr-js-app', get_template_directory_uri() . '/dist/app.js', array('jquery'), '1.0.0', true);
		//wp_enqueue_script('owr-js-scripts', get_template_directory_uri() . '/dist/scripts/scripts.min.js', array('jquery'), '1.0.0', true);
	} else { // Development

		// CSS
		wp_enqueue_style('owr-css-styles', get_template_directory_uri() . '/src/styles/style.css');

		// Scripts
		wp_enqueue_script('owr-js-plugins', get_template_directory_uri() . '/src/scripts/plugins.js#asyncload', array('jquery'), '1.0.0', true);
		wp_enqueue_script('owr-tweenmax', get_template_directory_uri() . '/src/scripts/TweenMax.min.js#asyncload', array('jquery'),'1.0.0',true);
		wp_enqueue_script('owr-slick', get_template_directory_uri() . '/src/scripts/slick.js#asyncload', array('jquery'),'1.0.0',true);
		wp_enqueue_script('owr-js-scripts', get_template_directory_uri() . '/src/scripts/scripts.js#asyncload', array('jquery','owr-tweenmax'), '1.0.0', true);
	
	}
}

// Faviconvagra
add_action('wp_head', 'owr_favicons');

function owr_favicons() {
	$icons = '';
	if(owr_is_dist()) { // Distribution
		$icons .= '<link href="'.get_template_directory_uri() . '/dist/images/favicon.png" rel="icon" type="image/x-icon" />';
		$icons .= '<link href="'.get_template_directory_uri() . '/dist/images/apple-touch-icon.png" rel="apple-touch-icon" type="image/x-icon" />';
	} else {
		$icons .= '<link href="'.get_template_directory_uri() . '/src/images/favicon.png" rel="icon" type="image/x-icon" />';
		$icons .= '<link href="'.get_template_directory_uri() . '/src/images/apple-touch-icon.png" rel="apple-touch-icon" type="image/x-icon" />';
	}
	echo $icons;
}