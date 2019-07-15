<?php
	
// unregister sidebar to remove left sidebar of Twenty Fourteen

function remove_left_sidebar(){

    unregister_sidebar( 'sidebar-1' );

}

add_action( 'widgets_init', 'remove_left_sidebar', 11 );

//include parent style
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
function my_theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );

}

//die('yo');