<?php

include('upcoming-featured.php');

register_sidebar(array(
	'name'          => 'Spanish Language Content',
	'id'            => 'spanish-content',
	'description'   => 'Additional sidebar that appears on the right for Spanish-language pages.',
	'before_widget' => '<aside id="%1$s" class="widget %2$s">',
	'after_widget'  => '</aside>',
	'before_title'  => '<h1 class="widget-title">',
	'after_title'   => '</h1>',
));

//stylesheets
add_action('wp_enqueue_scripts', function() {
	wp_enqueue_style('twentyfourteen', get_template_directory_uri() . '/style.css');
});

//add google analytics manually without extra files
add_action('wp_footer', function(){
	?>
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-46709454-1"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());
		gtag('config', 'UA-46709454-1');
	</script>
	<?php
});

//favicon
add_action('wp_head', function(){
	echo '<link rel="shortcut icon" href="/wp-content/uploads/2014/04/triangle.png">';
});

//editor stylesheet
add_action('init', function(){
	add_editor_style('editor-style.css');
});

//editor tweaks
add_filter('tiny_mce_before_init', function($init) {
	$init['block_formats'] = 'Paragraph=p;Heading 2=h2;Heading 3=h3;Heading 4=h4;Heading 5=h5;Heading 6=h6;Alert=pre';
	return $init;
});

//copyright statements
add_action('twentyfourteen_credits', function(){ ?>
    <p>Header image by T. Wise via <a href="https://www.flickr.com/photos/photographingtravis/16478214690" target="_blank">Flickr</a>. Creative Commons license 2015.</p>
    <p>All other information © <?php echo current_time('Y')?> Intergroup Central Office of Santa Clara County, Inc. All rights reserved.</p>
<?php }, 10, 0 ); 

//woocommerce, remove order comments field and heading
add_filter('woocommerce_enable_order_notes_field', '__return_false');
add_filter('woocommerce_checkout_fields' , function ($fields) {
	unset($fields['order']['order_comments']);
	unset($fields['billing']['billing_company']);
	return $fields;
});
remove_theme_support( 'wc-product-gallery-zoom' );

//customize woocommerce thank you
add_filter('the_title', function($title, $id) {
	if (function_exists('is_order_received_page') && is_order_received_page() && get_the_ID() === $id) {
		$title = 'Thank You';
	}
	return $title;
}, 10, 2 );

add_filter('woocommerce_thankyou_order_received_text', function($str, $order) {
    return 'Your contribution has been received. You should receive a confirmation email shortly.';
}, 10, 2);