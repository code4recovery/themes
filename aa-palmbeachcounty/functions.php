<?php
//register navigation menu
register_nav_menu('main', 'Main Site Navigation');

//enqueue assets
add_action('wp_enqueue_scripts', function(){
	wp_enqueue_style('SpryMenuBar', get_stylesheet_directory_uri() . '/SpryAssets/SpryMenuBarHorizontal.css', array(), filemtime(get_stylesheet_directory() . '/SpryAssets/SpryMenuBarHorizontal.css'));
	wp_enqueue_script('SpryMenuBar', get_stylesheet_directory_uri() . '/SpryAssets/SpryMenuBar.js', array(), filemtime(get_stylesheet_directory() . '/SpryAssets/SpryMenuBar.js'), true);
	wp_enqueue_style('pbc', get_stylesheet_uri(), array('SpryMenuBar'), filemtime(get_stylesheet_directory() . '/style.css'));
	wp_enqueue_script('pbc', get_stylesheet_directory_uri() . '/script.js', array('SpryMenuBar'), filemtime(get_stylesheet_directory() . '/script.js'), true);
	wp_localize_script('pbc', 'spry', array(
		'directory' => get_stylesheet_directory_uri(),
	));
});
