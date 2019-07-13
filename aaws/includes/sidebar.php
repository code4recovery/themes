<?php

//register sidebar
register_sidebar(array(
	'name' => 'Sidebar',
	'before_widget' => '<div class="widget pb-4">',
	'after_widget' => '</div>',
	'before_title' => '<h4 class="pb-1">',
	'after_title' => '</h4>',
));

//custom search widget HTML 
add_filter('get_search_form', function($form) {
	return '<form role="search" method="get" action="' . home_url('/') . '">
		<div class="input-group mb-3">
			<input type="search" class="form-control" value="' . get_search_query() . '" name="s">
			<div class="input-group-append">
				<input class="btn btn-outline-secondary" type="submit" value="' . __('Search') . '">
			</div>
		</div>
	</form>';
}, 100);

//custom categories widget
add_filter('wp_list_categories', function($variable) {
	$variable = str_replace('(', '<span class="badge badge-dark float-right"> ', $variable);
	$variable = str_replace(')', ' </span>', $variable);
	return $variable;
});
