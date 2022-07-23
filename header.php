<?php get_template_part('head'); ?>

<header>
    <div class="nav-holder">
        <?php $classes = get_body_class(); ?>
        <div class="logo-holder">
            <h1 id="main-logo"><a href="/"><img src="<?php the_field('logo', 'option'); ?>"></a></h1>
        </div>
        <div class="mobile-menu">
            <span class="line line-one"></span>
            <span class="line line-two"></span>
            <span class="line line-three"></span>
        </div>

        <nav role="navigation" class="top-menu">
            <?php
            $args = array('theme_location' => 'main_menu', 'container' => '');
            wp_nav_menu( $args );
            ?>
        </nav>
    </div>
</header>