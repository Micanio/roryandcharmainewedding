<!DOCTYPE html>
<html lang="en" id="html" class="no-js mb">
<head>
    <script>document.getElementById('html').className = document.getElementById('html').className.replace( /(?:^|\s)no-js(?!\S)/g , 'js' )</script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php global $page, $paged; wp_title( '|', true, 'right'); bloginfo( 'name' ); ?></title>
    <link rel="shortcut icon" type="image/jpg" href="<?php the_field('favicon', 'option'); ?>" />
    <?php wp_head(); ?>
    <?php the_field('header_code', 'options') ?>
</head>
<body <?php body_class( 'page-'.strtolower(str_replace(' ','-',get_the_title())) ); ?>>
