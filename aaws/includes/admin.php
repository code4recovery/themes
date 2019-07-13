<?php

//contact edit page
add_action('do_meta_boxes', function(){
	remove_meta_box('slugdiv', 'aaws-contact', 'normal');
	add_meta_box('info', 'Additional Info', function(){
		global $post;
		$meta = get_post_meta($post->ID);
		?>
		<div class="meta_form_row">
			<label for="name">Name</label>
			<input type="text" name="name" id="name" value="<?php echo $meta['name'][0]?>" class="large-text">
		</div>
		<div class="meta_form_row">
			<label for="email">Email</label>
			<input type="email" name="email" id="email" value="<?php echo $meta['email'][0]?>" class="large-text">
		</div>
		<div class="meta_form_row">
			<label for="phone">Phone</label>
			<input type="tel" name="phone" id="phone" value="<?php echo $meta['phone'][0]?>" class="large-text">
		</div>
		<div class="meta_form_row">
			<label for="website">Website</label>
			<input type="url" name="website" id="website" value="<?php echo $meta['website'][0]?>" class="large-text">
		</div>
		<?php
	}, 'aaws-contact', 'normal', 'low');
});

//add contacts link to admin bar
add_action('admin_bar_menu', function($wp_admin_bar) {
	if (is_admin()) return;
	$wp_admin_bar->add_node(array(
		'id' => 'aaws-contact',
		'title' => 'Contacts',
		'href' => '/wp-admin/edit.php?post_type=aaws-contact',
	));
}, 999);

//save changes to metadata
add_action('save_post', function($post_id, $post, $update) {
	global $tsml_nonce, $wpdb, $tsml_notification_addresses, $tsml_days;
	
	//security
	if (empty($_POST['post_type']) || ($_POST['post_type'] != 'aaws-contact')) return;
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
	if (!current_user_can('edit_post', $post_id)) return;
	if (wp_is_post_revision($post_id)) return;
	//if (!isset($_POST['tsml_nonce']) || !wp_verify_nonce($_POST['tsml_nonce'], $tsml_nonce)) return;
	
	//save custom fields
	update_post_meta($post_id, 'name', sanitize_text_field($_POST['name']));
	update_post_meta($post_id, 'email', sanitize_text_field($_POST['email']));
	update_post_meta($post_id, 'phone', sanitize_text_field($_POST['phone']));
	update_post_meta($post_id, 'website', sanitize_text_field($_POST['website']));	

}, 10, 3);

//admin list page
add_filter('manage_edit-aaws-contact_columns', function($defaults) {
	return array(
		'cb'		=> '<input type="checkbox" />',
		'title'		=> 'Organization',
		'name'		=> 'Name',
		'type'		=> 'Type',
		'date'		=> 'Date',
	);	
});

add_action('manage_aaws-contact_posts_custom_column', function($column_name, $post_id) {
	global $wpdb;
	if ($column_name == 'name') {
		echo get_post_meta($post_id, 'name', true);
	} elseif ($column_name == 'type') {
		echo implode(', ', wp_get_post_terms($post_id, 'aaws-contact-type', array('fields' => 'names')));
	}
}, 10, 2);
