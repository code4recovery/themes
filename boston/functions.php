<?php

//register the top and side menus
register_nav_menus(array(
	'top' => 'Top Menu',
	'side' => 'Side Menu',
));

//add css and js
add_action('wp_enqueue_scripts', function(){
	wp_enqueue_style('boston', get_stylesheet_directory_uri() . '/assets/compiled/theme.css', array(), filemtime(__DIR__ . '/assets/compiled/theme.css'));
	wp_enqueue_script('boston', get_stylesheet_directory_uri() . '/assets/compiled/theme.js', array('jquery'));
});

//add class to nav menu item when meetings page is active
add_filter('nav_menu_css_class', function($classes, $item, $args) {
	if (is_post_type_archive('tsml_meeting') && $item->url == '/meetings') {
		$classes[] = 'current-menu-item';
	}
	return array_unique($classes);
}, 10, 3);

//add custom meeting types
if (function_exists('tsml_custom_types')) {
	tsml_custom_types(array(
		'#' => 'Must Sign to Enter (#)',
		'B' => 'Big Book (BB)',
		'O' =>'Open (O)',
		'C' => 'Closed (C)',
		'D' => 'Discussion (D)',
		'SP' => 'Speaker (S)',
		'ST' => 'Step Meeting (12)',
		'TR' => 'Tradition Meeting (T)',
		'M' => 'Men (M)',
		'W' => 'Women (W)',
		'*' => 'Beginner\'s Meeting Beforehand (*)',
		'Y' => 'Young People (YP)',
		'LGBTQ' => 'LGBTQ (G)',
		'X' => 'Wheelchair Access (H)',
	));
}

$tsml_columns = array(
    'types' => 'Code',
    'time' => 'Time',
    'region' => 'Town',
    'distance' => 'Distance',
    'name' => 'Name',
    'location' => 'Location',
    'address' => 'Address',
);

$decode_codes = array(
	'B' => 'BB',
	'SP' => 'S',
	'ST' => '12',
	'TR' => 'T',
	'Y' => 'YP',
	'LGBTQ' => 'G',
	'X' => 'H',
);

function boston_decode($type) {
	global $decode_codes;
	if (array_key_exists($type, $decode_codes)) {
		return $decode_codes[$type];
	}
	return $type;
}

function boston_meeting_types($types) {
	return implode(array_map('boston_decode', $types));
}