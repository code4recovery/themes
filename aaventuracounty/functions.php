<?php
add_action('wp_enqueue_scripts', 'my_theme_enqueue_styles');
function my_theme_enqueue_styles() {
	wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
}

//test CSV
if (false) {
	$handle = fopen(__DIR__ . '/Meetingtest6.txt', 'r');
	$meeting = array();
	while (($data = fgetcsv($handle, 3000, ',')) !== false) {
		//skip empty rows
		if (strlen(trim(implode($data)))) {
			$meetings[] = $data;
		}
	}
	dd(tsml_import_reformat($meetings));
}

tsml_custom_types(array(
	'CHIP' => 'Chip Meeting',
	'SF' => 'Senior Friendly',
));

//make an array from a non CSV
function tsml_import_reformat($rows) {

	//convert text file to array
	$meetings = array();
	foreach ($rows as $row) {
		$row = explode("\t", str_replace('"', '', $row[0]));
		$meetings[] = $row;
	}
	$header = array_shift($meetings);
	$header = array_map('strtolower', $header);
	$header_count = count($header);
	
	//create an output array
	$output = array();
	
	foreach ($meetings as $meeting) {
		
		$meeting = array_pad($meeting, $header_count, '');
		
		$meeting = array_combine($header, $meeting);
		
		//hide 'every day' meetings
		if (!in_array($meeting['dayname'], array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'))) {
			continue;
		}
				
		//format the types	
		$types = explode(' ', str_replace(array('[', ']', '(', ')', '{', '}'), ' ', $meeting['type']));
		$types = array_values(array_diff($types, array('')));
		$types = array_map(function($value){
			if ($value == 'C') return 'Closed';
			if ($value == 'CC') return 'Babysitting Available';
			if ($value == 'G') return 'LGBTQ';
			if ($value == 'M') return 'Men';
			if ($value == 'O') return 'Open';
			if ($value == 'H') return 'Wheelchair Access';
			if ($value == 'W') return 'Women';
			if ($value == 'YP') return 'Young People';
			if ($value == 'CH') return 'Chip Meeting';
			if ($value == 'SF') return 'Senior Friendly';
			if ($value == 'B') return 'Birthday';
			return $value;
		}, $types);
		
		//append gso_id and vc_id to location_notes
		$notes = array();
		
		if (!empty($meeting['location notes'])) {
			$notes[] = $meeting['location notes'];
		}
				
		if (!empty($meeting['vc_id'])) {
			$notes[] = 'VC Meeting ID: ' . $meeting['vc_id'];
		}
		
		$district = $group = '';
		if (!empty($meeting['gso_id']) && substr_count($meeting['gso_id'], '][93][')) {
			list($gso_id, $district) = explode('][93][', substr($meeting['gso_id'], 1, -1));
			$district = 'District ' . $district;
			$group = 'Group ' . $gso_id;
			$notes[] = 'GSO Group ID: ' . $gso_id;
		}

		$output[] = array(
			'day' => $meeting['dayname'],
			'slug' => $meeting['vc_id'],
			'time' => $meeting['time'], //date('G:i:s', strtotime($input['Time'])),
			'name' => $meeting['name'],
			'location' => $meeting['location'],
			'address' => $meeting['address'],
			'city' => $meeting['cities'],
			'state' => 'CA',
			'group' => $group,
			'district' => $district,
			'country' => 'USA',
			'postal_code' => $meeting['loczip'],
			'region' => $meeting['cities'],
			'notes' => implode("\n", $notes),
			'types' => implode(', ', $types),
		);
	}

	//dd($output);
	
	//reformat back to look like a CSV
	$meetings = array(array_keys($output[0]));
	foreach ($output as $out) {
		$meetings[] = array_values($out);
	}
	
	//dd($meetings);
	
	return $meetings;
}
