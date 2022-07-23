<?php get_header(); ?>

<?php if(have_posts()) {

    while(have_posts()) {
        the_post();
        $header_type = get_field( 'header-type' );
        get_template_part('templates/header-banner');
        if(have_rows('flexible_content')){
            while(have_rows('flexible_content')){
                the_row();
                $layout = get_row_layout();
                get_template_part('templates/flex', $layout);
            }
        }
    }
} ?>

<?php get_footer(); ?>