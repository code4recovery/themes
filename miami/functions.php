<?php

//load parent style
add_action('wp_enqueue_scripts', 'my_theme_enqueue_styles');
function my_theme_enqueue_styles() {
	wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
}

//type overrides per jennifer
$tsml_types['aa'] = array(
	'ABSI'	=> 'As Bill Sees It',
	'A'		=> 'Atheist / Agnostic',
	//'BA'		=> 'Babysitting Available',
	'BE'		=> 'Beginner',
	'B'		=> 'Big Book',
	//'CF'		=> 'Child-Friendly',
	//'H'		=> 'Chips',
	'C'		=> 'Closed',
	'CAN'	=> 'Candlelight',
	//'AL-AN'	=> 'Concurrent with Al-Anon',
	//'AL'		=> 'Concurrent with Alateen',
	//'XT'		=> 'Cross Talk Permitted',
	//'DLY'	=> 'Daily',
	'REFL'	=> 'Daily Reflections',
	'D'		=> 'Discussion', //edited per Jennifer
	//'DD'		=> 'Dual Diagnosis',
	'EMOT'	=> 'Emotional Sobriety', //added per Jennifer
	'FF'		=> 'Fragrance Free',
	'FR'		=> 'French',
	'G'		=> 'Gay',
	'GR'		=> 'Grapevine',
	//'ITA'	=> 'Italian',
	//'L'		=> 'Lesbian',
	'LIT'	=> 'Literature',
	'LIV'	=> 'Living Sober',
	'LGBTQ'	=> 'LGBTQ',
	'MED'	=> 'Meditation',
	'M'		=> 'Men',
	'NEW'	=> 'Newcomers',
	'O'		=> 'Open',
	//'POL'	=> 'Polish',
	//'POR'	=> 'Portuguese',
	//'PUN'	=> 'Punjabi',
	//'RUS'	=> 'Russian',
	'RAP'	=> 'Rap',
	'ASL'	=> 'Sign Language',
	'SLIP'	=> 'Slippers',
	//'SM'		=> 'Smoking Permitted',
	'S'		=> 'Spanish',
	'SP'		=> 'Speaker',
	'ST'		=> 'Step Meeting',
	'SUR'	=> 'Surrender', //added per Jennifer
	'TR'		=> 'Tradition',
	//'T'		=> 'Transgender',
	'X'		=> 'Wheelchair Accessible',
	'W'		=> 'Women',
	'Y'		=> 'Young People',
);