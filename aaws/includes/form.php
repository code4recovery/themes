<?php

//custom contact form
add_shortcode('contact-form', function(){
	if (!empty($_GET['status']) && $_GET['status'] == 'ok') {
		return '
			<div class="alert alert-success">
				' . __('Thank you. We will be in touch soon.') . '
			</div>
		';
	}

	$type_radios = '';
	$types = get_terms(array(
		'taxonomy' => 'aaws-contact-type',
		'hide_empty' => false,
	));
	foreach ($types as $type) {
		$type_radios .= '
			<div class="form-check">
				<input class="form-check-input" type="radio" name="type" id="type-' . $type->slug . '" value="' . $type->term_id . '" required>
				<label class="form-check-label" for="type-' . $type->slug . '">
					' . $type->name . '
				</label>
			</div>
		';
	}

	return '
<form method="post" action="' . admin_url('admin-ajax.php') . '?' . build_query(array('action' => 'aaws-contact')) . '" class="needs-validation">
	' . wp_nonce_field('aaws-contact', 'aaws-nonce', true, false) . '
	<div class="form-group row">
		<label for="name" class="col-sm-3 col-form-label">' . pll__('Your Name') . '</label>
		<div class="col-sm-9">
			<input type="text" class="form-control" name="name" id="name" placeholder="Jane Q." required>
		</div>
	</div>
	<div class="form-group row">
		<label for="email" class="col-sm-3 col-form-label">' . pll__('Email') . '</label>
		<div class="col-sm-9">
			<input type="email" class="form-control" name="email" id="email" placeholder="jane@example.org" required>
		</div>
	</div>
	<div class="form-group row">
		<label for="phone" class="col-sm-3 col-form-label">' . pll__('Phone') . '</label>
		<div class="col-sm-9">
			<input type="tel" class="form-control" name="phone" id="phone" placeholder="+1 (555) 555-5555">
		</div>
	</div>
	<div class="form-group row">
		<label for="organization" class="col-sm-3 col-form-label">' . pll__('Organization') . '</label>
		<div class="col-sm-9">
			<input type="text" class="form-control" name="organization" id="organization" placeholder="Intergroup Central Office of Example" required>
		</div>
	</div>
	<div class="form-group row">
		<label for="website" class="col-sm-3 col-form-label">' . pll__('Website') . '</label>
		<div class="col-sm-9">
			<input type="url" class="form-control" name="website" id="website" placeholder="https://example.org">
		</div>
	</div>
	<fieldset class="form-group">
		<div class="row">
			<legend class="col-form-label col-sm-3 pt-0">' . pll__('Type') . '</legend>
			<div class="col-sm-9">
				' . $type_radios . '
			</div>
		</div>
	</fieldset>
	<div class="form-group row">
		<div class="col-sm-3">' . pll__('Notes') . '</div>
		<div class="col-sm-9">
			<textarea class="form-control" name="notes" id="notes" rows="8"></textarea>
			<small class="form-text text-muted">' . pll__('Optional') . '</small>
		</div>
	</div>
	<div class="form-group text-center border-top mt-4 pt-4">
		<button type="submit" class="btn btn-primary px-4">' . pll__('Submit') . '</button>
	</div>
</form>
	';
});
