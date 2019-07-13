<?php

//gutenberg customizations
add_action('enqueue_block_editor_assets', function() {
	wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css?family=Roboto|Roboto+Slab:700');
	wp_enqueue_style('mytheme-block-editor-styles', get_theme_file_uri('/assets/editor.css'), false, '1.0', 'all');
});

//include js / css on public pages
add_action('admin_enqueue_scripts', function() {
	wp_enqueue_style('aaws-admin', get_stylesheet_directory_uri() . '/assets/admin.css', array(), filemtime(get_stylesheet_directory() . '/assets/admin.css'));
});

//include js / css on public pages
add_action('wp_enqueue_scripts', function() {
	wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css?family=Roboto|Roboto+Slab:700');
	wp_enqueue_style('aaws', get_stylesheet_directory_uri() . '/assets/compiled/theme.css', array(), filemtime(get_stylesheet_directory() . '/assets/compiled/theme.css'));
	//wp_enqueue_script('aaws', get_stylesheet_directory_uri() . '/assets/compiled/theme.js', array(), filemtime(get_stylesheet_directory() . '/assets/compiled/theme.js'), true);
});