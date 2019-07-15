<?php

add_action('admin_init', function(){
	add_editor_style();	
});

//add default twentyfourteen css
add_action('wp_enqueue_scripts', function(){
	wp_enqueue_style('parent_style', get_template_directory_uri() . '/style.css');
});

//remove extra space in admin sidebar caused by mailgun plugin
add_action('admin_menu', function(){
    remove_submenu_page('options-general.php', 'mailgun-lists');
});

//add a menu, such as on the homepage, from within a shortcode
add_shortcode('menu', function($attributes){
	extract(shortcode_atts(array('name' => null), $attributes));
	return wp_nav_menu(array( 'menu' => $name, 'echo' => false));
});

//special types
if (function_exists('tsml_custom_types')) {
	tsml_custom_types(array(
	    'H' => 'Chip Meeting',
	));
}

//change some text
$tsml_strings['loc_empty'] = 'Enter a location (city, zip code, neighborhood or landmark) in the field above.';
$tsml_strings['no_meetings'] .= ' Check out our <a href="/search-hints" class="alert-link">Search Hints</a> page for help.';
$tsml_strings['loc_error'] .= ' Check out our <a href="/search-hints" class="alert-link">Search Hints</a> page for help.';
$tsml_strings['geo_error'] .= ' Check out our <a href="/search-hints" class="alert-link">Search Hints</a> page for help.';

//change other text
function theme_override_tsml_strings($translated_text, $text, $domain) {
    if ($domain == '12-step-meeting-list') {
        switch ($translated_text) {
            case 'Request an Update':
                return 'Submit meeting info change';
        }
    }
    return $translated_text;
}
add_filter('gettext', 'theme_override_tsml_strings', 20, 3);
