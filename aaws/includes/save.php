<?php

//process contact form
add_action('wp_ajax_aaws-contact', 'aaws_contact');
add_action('wp_ajax_nopriv_aaws-contact', 'aaws_contact');
function aaws_contact() {

	//security
	if (empty($_POST['aaws-nonce']) || !wp_verify_nonce($_POST['aaws-nonce'], 'aaws-contact')) {
		wp_send_json_error(array(
			'message' => 'Sorry, your nonce did not verify.',
		));
	}

	//input filtering
	$_POST['email'] = sanitize_email($_POST['email']);
	$_POST['name'] = sanitize_text_field($_POST['name']);
	$_POST['notes'] = sanitize_textarea_field($_POST['notes']);
	$_POST['organization'] = sanitize_text_field($_POST['organization']);
	$_POST['phone'] = sanitize_text_field($_POST['phone']);
	$_POST['type'] = intval($_POST['type']);
	$_POST['website'] = sanitize_text_field($_POST['website']);

	//create entry in 'contacts' custom post type
	$post_id = wp_insert_post(array(
		'post_title' => $_POST['organization'],
		'post_content' => $_POST['notes'],
		'post_type' => 'aaws-contact',
		'post_status' => 'publish',
		'tax_input' => array(
			'aaws-contact-type' => array($_POST['type']),
		),
	));

	//save custom fields
	update_post_meta($post_id, 'name', $_POST['name']);
	update_post_meta($post_id, 'email', $_POST['email']);
	update_post_meta($post_id, 'phone', $_POST['phone']);
	update_post_meta($post_id, 'website', $_POST['website']);

	//build email message
	$message = '<h1>New Contact from AAWS + Meeting Guide Site</h1>';
	
	if (!empty($_POST['name'])) {
		$message .= '<p style="margin: 1em 0;">Name: ' . $_POST['name'] . '</p>';
	}
	if (!empty($_POST['email'])) {
		$message .= '<p style="margin: 1em 0;">Email: <a href="mailto:' . $_POST['email'] . '">' . $_POST['email'] . '</a></p>';
	}
	if (!empty($_POST['phone'])) {
		$message .= '<p style="margin: 1em 0;">Phone: <a href="tel:' . $_POST['phone'] . '">' . $_POST['phone'] . '</a></p>';
	}
	if (!empty($_POST['organization'])) {
		$message .= '<p style="margin: 1em 0;">Organization: ' . $_POST['organization'] . '</p>';
	}
	if (!empty($_POST['website'])) {
		$message .= '<p style="margin: 1em 0;">Website: <a href="' . $_POST['website'] . '">' . $_POST['website'] . '</a></p>';
	}
	if (!empty($_POST['type'])) {
		$term = get_term($_POST['type'], 'aaws-contact-type');
		$message .= '<p style="margin: 1em 0;">Type: ' . $term->name . '</p>';
	}
	if (!empty($_POST['notes'])) {
		$message .= '<p style="margin: 1em 0;">Notes: ' . nl2br($_POST['notes']) . '</p>';
	}

	//send email message
	wp_mail('meetingguide@aa.org', '[' . get_bloginfo('name') . '] ' . $_POST['organization'], '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		</head>
		<body style="width:100% !important; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; margin:0; padding:0; background-color:#eeeeee;">
			<table cellpadding="0" cellspacing="0" border="0" style="background-color:#eeeeee; width:100%; height:100%;">
				<tr>
					<td valign="top" style="text-align:center;padding-top:15px;">
						<table cellpadding="0" cellspacing="0" border="0" align="center">
							<tr>
								<td width="630" valign="top" style="background-color:#ffffff; text-align:left; padding:15px; font-size:15px; font-family:Arial, sans-serif;">
									' . $message . '
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</body>
	</html>', array(
		'Content-Type: text/html; charset=UTF-8',
		'Reply-To: ' . $_POST['email'],
	));

	//success
	wp_redirect('/contact?status=ok');
}