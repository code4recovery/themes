<?php

/* Redirect old podcast link
if ($_SERVER['REQUEST_URI'] == '/speakers?type=podcast') {
	header('Location: /wp-admin/admin-ajax.php?action=podcast');
	exit;
}
*/

# Street address
$club_info = array(
	'name' => 'Saturday Nite Live',
	'address_1' => '1954 Camden Ave',
	'address_2' => 'San Jose, CA 95124',
	'latitude' => 37.261450,
	'longitude' => -121.928030,
);

# Public site assets
add_action('wp_enqueue_scripts', function(){
	global $club_info;
	wp_enqueue_script('typekit-js', '//use.typekit.net/jhu3vuq.js');
	wp_enqueue_script('theme-js', get_stylesheet_directory_uri() . '/assets/js/theme.min.js');
	wp_enqueue_style('theme-css', get_stylesheet_directory_uri() . '/assets/css/theme.min.css');
	wp_localize_script('theme-js', 'club_info', $club_info);
});

# Editor Style
add_action('admin_init', function(){
	add_editor_style(get_stylesheet_directory_uri() . '/assets/css/editor.min.css');
});

# Featured Images
add_theme_support('post-thumbnails', ['page']); 

# Upcoming events shortcode
add_shortcode('events', function(){
	$posts = get_posts(['post_status' => 'future', 'numberposts' => -1]);
	$events = [];

	foreach ($posts as $post) {
		$events[strtotime($post->post_date)] = $post;
	}

	$business = strtotime('second sat of this month 3:30pm');
	if ($business < current_time('timestamp')) $business = strtotime('second sat of next month 3:30pm');
	$events[$business] = (object) [
		'post_title' => 'Business Meeting',
		'post_content' => 'SNL\'s monthly business meeting, where new meeting secretaries and steering committee positions are elected.',
	];

	$secretary = strtotime('first sat of this month 3:30pm');
	if ($secretary < current_time('timestamp')) $secretary = strtotime('first sat of next month 3:30pm');
	$events[$secretary] = (object) [
		'post_title' => 'Secretary\'s Workshop',
		'post_content' => 'New meeting secretaries must first attend this workshop to be eligible for election.',
	];
	
	ksort($events);
	
	foreach ($events as $date => $event) {?>
		<div class="event">
			<div class="meta">
				<div class="day"><?php echo date('l', $date)?></div>
				<div class="date"><?php echo date('M j', $date)?></div>
				<div class="time"><?php echo date('g:i a', $date)?></div>
			</div>
			<h4>
				<?php echo $event->post_title?>
				<?php if (!empty($event->ID)) echo edit_post_link('<i class="glyphicon glyphicon-edit"></i>', null, null, $event->ID)?>
			</h4>
			<?php echo nl2br($event->post_content)?>
		</div>
	<?php }
});

function snl_get_recordings($limit = -1) {
	$audio_posts = [];
	$recordings = get_posts(['numberposts' => $limit, 'post_type' => 'attachment', 'post_mime_type' => 'audio']);
	foreach ($recordings as $recording) {
		$audio_posts[$recording->post_parent] = wp_get_attachment_url($recording->ID);
	}
	$posts = get_posts(['include' => array_keys($audio_posts)]);
	foreach ($posts as &$post) {
		$filename = ABSPATH . substr($audio_posts[$post->ID], strlen(get_site_url()) + 1);
		$post = [
			'name' => $post->post_title,
			'date' => strtotime($post->post_date),
			'url' => $audio_posts[$post->ID],
			'size' => filesize($filename),
		];
	}
	return $posts;
}

# Podcast shortcode
add_shortcode('podcast', function(){
	$recordings = snl_get_recordings();
	foreach ($recordings as &$recording) {
		$recording = '<li><a href="' . $recording['url'] . '">' . $recording['name'] . '</a>, ' . date('l, M d, Y', $recording['date']) . '</li>';
	}
	list($scheme, $link) = explode('://', admin_url('admin-ajax.php?action=podcast'), 2);
	return '<div class="alert alert-warning podcast">
			<a href="pcast://' . $link . '" class="alert-link">Subscribe to the podcast!</a> 
			If it doesn\'t work for you, please <a href="#contact" class="scroll alert-link">let us know</a> what kind of setup you have and we will try to help.
		</div>
		<ul>' . implode($recordings) . '</ul>';
});

# Podcast AJAX
add_action('wp_ajax_podcast', 'snl_podcast');
add_action('wp_ajax_nopriv_podcast', 'snl_podcast');

function snl_podcast() {
	
	$recordings = snl_get_recordings(20);
	
	foreach ($recordings as &$recording) {
		$recording = '
			<item>
				<title>' . $recording['name'] . '</title>
				<link>http://' . $_SERVER['HTTP_HOST'] . '/recordings</link>
				<description>This is a speaker recording from the Saturday Nite Live group of AA in San Jose, CA.</description>
				<pubDate>' . date('D, j M Y 20:00:00', $recording['date']) . '</pubDate>
				<guid>' . $recording['url'] . '</guid>
				<enclosure url="' . $recording['url'] . '" length="' . $recording['size'] . '" type="audio/mpeg"/>
				<itunes:author>' . $recording['name'] . '</itunes:author>
				<itunes:explicit>Yes</itunes:explicit>
			</item>';
	}

	die('<?xml version="1.0" encoding="UTF-8"?>
<rss xmlns:itunes="http://www.itunes.com/dtds/podcast-1.0.dtd" version="2.0">
	<channel>
		<title>' . get_option('blogname') . '</title>
		<link>http://' . $_SERVER['HTTP_HOST'] . '/recordings</link>
		<description>Speakers</description>
		<language>en-us</language>
		<pubDate>' . date(DATE_RSS, key($recordings)) . '</pubDate>
		<lastBuildDate>' . date('D, j M Y 20:00:00') . '</lastBuildDate>
		<docs>http://blogs.law.harvard.edu/tech/rss</docs>
		<generator>Custom</generator>
		<managingEditor>' . get_option('admin_email') . '</managingEditor>
		<webMaster>' . get_option('admin_email') . '</webMaster>
		<itunes:explicit>Yes</itunes:explicit>
		<itunes:image href="' . get_stylesheet_directory_uri() . '/img/circle-triangle.jpg"/>
		' . implode($recordings) . '
	</channel>
</rss>');
}

# Contact form
add_action('wp_ajax_contact', 'deliver_mail');
add_action('wp_ajax_nopriv_contact', 'deliver_mail');
function deliver_mail() {

	if (!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['message'])) {

		// sanitize form values
		$name		= sanitize_text_field($_POST['name']);
		$email		= sanitize_email($_POST['email']);
		$message	= stripslashes($_POST['message']);
		$to			= get_option('admin_email');
		$headers	= 'From: ' . $name . ' <' . $email . '>' . "\r\n";

		if (wp_mail($to, 'SNL Contact Form', $message, $headers)) {
			echo '<div class="alert alert-warning">Thanks for contacting us, you can expect a response soon.</div>';
		} else {
			echo '<div class="alert alert-danger">An unexpected error occurred!</div>';
		}
		
	} else {
		echo '<div class="alert alert-danger">An unexpected input error occurred!</div>';
	}

	exit;
}

# Remove style tag from wp-caption
add_shortcode('wp_caption', 'fixed_img_caption_shortcode');
add_shortcode('caption', 'fixed_img_caption_shortcode');
function fixed_img_caption_shortcode($attr, $content=null) {
	if (!isset($attr['caption'])) {
		if (preg_match('#((?:<a [^>]+>\s*)?<img [^>]+>(?:\s*</a>)?)(.*)#is', $content, $matches)) {
			$content = $matches[1];
			$attr['caption'] = trim( $matches[2] );
		}
	}
	$output = apply_filters('img_caption_shortcode', '', $attr, $content);
	if ($output != '') return $output;
	extract(shortcode_atts([
		'id'	=> '',
		'align'	=> 'alignnone',
		'width'	=> '',
		'caption' => ''
	], $attr));
	if (1 > (int) $width || empty($caption)) return $content;
	if ($id) $id = 'id="' . esc_attr($id) . '" ';
	return '<div ' . $id . 'class="wp-caption ' . esc_attr($align) . '">'
	. do_shortcode($content) . '<p class="wp-caption-text">' . $caption . '</p></div>';
}

# Custom password form
add_filter('the_password_form', function() {
	global $post;
	return '
	<form class="protected-post-form" action="' . get_option('siteurl') . '/wp-login.php?action=postpass" method="post">
		<input type="hidden" name="_wp_http_referer" value="/recordings">
		<p>This section requires a password to protect our speakers\' anonymity. You may <a href="#contact" class="scroll">contact the webmaster</a> for the password.</p>
		<div class="input-group">
			<input name="post_password" class="form-control" placeholder="Password" type="password"><span class="input-group-btn"><input type="submit" class="btn btn-primary" name="Submit" value="Submit"></span>
		</div>
	</form>
	';
});
