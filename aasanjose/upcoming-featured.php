<?php

class Upcoming_Featured extends WP_Widget {

	public function __construct() {
		parent::__construct('upcoming_featured', 'Upcoming Featured Events', array( 
			'classname' => 'upcoming_featured',
			'description' => 'Carousel of upcoming featured events from The Events Calendar',
		));
	}

	public function widget($args, $instance) {
		
		//make sure TEC is installed
		if (!function_exists('tribe_get_events')) return;
		
		//get next 5 featured events with thumbnails or be quiet
		if (!$events = tribe_get_events(array(
			'posts_per_page' => 5,
			'featured' => true,
			'start_date' => date('Y-m-d H:i:s'),
			'include' => tribe_get_events(array(
				'meta_key' => '_thumbnail_id', 
				'fields' => 'ids',
			)),
		))) return;

		//get title parameter
		if (empty($instance['title'])) $instance['title'] = 'Upcoming Featured Events';
		
		//include CSS
		wp_enqueue_style('upcoming-featured', get_stylesheet_directory_uri() . '/upcoming-featured.css');

		//start output
		echo $args['before_widget'], $args['before_title'], apply_filters('widget_title', $instance['title']), $args['after_title'];
		
		//carousel parent
		echo '<div data-slick=\'{"slidesToShow": 1, "slidesToScroll": 1, "dots": true, "arrows":true}\'>';
		
		foreach ($events as $event) {
			
			//$event_thumbnail_id = get_post_thumbnail_id($event);
			//dd(wp_get_attachment_metadata($event_thumbnail_id));
			
			echo '<a class="upcoming-featured-event" href="' . get_permalink($event->ID) . '"><h3>',
				get_the_title($event->ID),
				'</h3><div class="image" style="background-image:url(' . get_the_post_thumbnail_url($event->ID, 'large') . ');"></div>',
				tribe_get_start_date($event->ID),
			'</a>';
		}		
		
		echo '</div>';
		
		echo $args['after_widget'];
	}

	//admin form
	public function form($instance) {
		if (empty($instance['title'])) $instance['title'] = 'Upcoming Featured Events';
		?>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title'))?>">Title</label> 
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title'))?>" name="<?php echo esc_attr($this->get_field_name('title'))?>" type="text" value="<?php echo esc_attr($instance['title'])?>">
		</p>
		<?php
	}

	//admin form save hook
	public function update($new_instance, $old_instance) {
		return array(
			'title' => (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '',
		);
	}
}

//initialize
function upcoming_featured_init() {
	register_widget('Upcoming_Featured');
}
add_action('widgets_init', 'upcoming_featured_init');

