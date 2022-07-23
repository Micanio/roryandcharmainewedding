<?php

//Hides the admin bar for all users on frontend
show_admin_bar( false );
add_theme_support('menus');

$site_includes = array(
    'distribution',
    'custom-settings',
    'custom-menus',
    'helpers'
);

foreach( $site_includes as $include ){
    $path = __DIR__.'/inc/'.$include.'.php';
    if( file_exists( $path ) ){
        require_once( $path );
    }
}

/** Enabled Post Thumbnails **/
add_theme_support( 'post-thumbnails' ); 
add_image_size( 'thumbnail', 300, 300, true);
add_image_size( 'blog-thumb', 465, 360, true);
add_image_size( 'link-box', 210, 210, true);
add_image_size( 'testimonial-thumb', 70, 70, true);
add_image_size( 'image-link', 200, 100, true );
//add_image_size( 'in-content-image', 460, 395, true);
add_image_size( 'in-content-image', 500, 500, false);
add_image_size( 'carousel',320,480,true);
add_image_size( 'full',9999,9999,false);

function custom_excerpt_length( $length ) {
    return 15; /* words */
}
add_filter( 'excerpt_length', 'custom_excerpt_length' );

//add svg support to media uploader
function cc_mime_types( $mimes ){
    
         $mimes['svg'] = 'image/svg+xml';
         return $mimes;
    }
    add_filter( 'upload_mimes', 'cc_mime_types' );
    
    
    //fix svg display in admin
    function fix_svg() {
       echo '<style type="text/css">
             .attachment-post-thumbnail, .acf-image-image {
                  width: 100% !important;
                  height: auto !important;
             }
             .acf-image-image{
                  width: 120px !important;
                 
             }
             </style>';
    }
    add_action('admin_head', 'fix_svg');
    add_filter("gform_confirmation_anchor", create_function("","return false;"));

// Async load
function async_scripts($url)
{
    if ( strpos( $url, '#asyncload') === false )
        return $url;
    else if ( is_admin() )
        return str_replace( '#asyncload', '', $url );
    else
    return str_replace( '#asyncload', '', $url )."' async='async"; 
    }
add_filter( 'clean_url', 'async_scripts', 11, 1 );

if ( ! function_exists( 'ld_modify_contact_methods' ) ) :

    function ld_modify_contact_methods( $contactmethods ) {
        $contactmethods['linkedin'] = __( 'Linked In' );
        $contactmethods['youtube'] = __( 'YouTube' );
        $contactmethods['instagram'] = __( 'Instagram' );

        return $contactmethods;
    }
    add_filter('user_contactmethods','ld_modify_contact_methods', 10, 1);

endif;

add_action( 'widgets_init', 'owr_register_sidebars' );
function owr_register_sidebars() {
    /* Register the 'primary' sidebar. */
    register_sidebar(
        array(
            'id'            => 'primary',
            'name'          => __( 'Primary Sidebar' ),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        )
    );
    /* Repeat register_sidebar() code for additional sidebars. */
}


// Add ACF options page in admin sidebar

if( function_exists("acf_add_options_page") ) {

    acf_add_options_page(array(
    "page_title" => "Theme Options",
    "menu_title" => "Theme Options",
    'redirect'      => false
    ));

    acf_add_options_page(array(
    "page_title" => "Site Settings",
    "menu_title" => "Site Settings",
    'redirect'      => false
    ));
}
function my_acf_google_map_api( $api ){
    $api['key'] = 'AIzaSyDILr9wRbjdSC4LGVBpRakWYwGdsnQ8RzA';
    return $api;
}
add_filter('acf/fields/google_map/api', 'my_acf_google_map_api');