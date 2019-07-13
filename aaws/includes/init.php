<?php

//create custom post type for contacts
add_action('init', function(){
	register_post_type('aaws-contact', array(
		'labels' => array(
			'name' => 'Contacts',
		),
		'show_ui' => true,
		'show_in_admin_bar' => false,
		'menu_icon' => 'dashicons-email',
	));

	register_taxonomy('aaws-contact-type', 'aaws-contact', array(
		'labels' => array(
			'name' => 'Types',
		),
		'public' => false,
		'show_ui' => true,
		'show_tagcloud' => false,
		'hierarchical' => true,
	));
});

