//= include ../bower_components/jquery/dist/jquery.js
//= include ../bower_components/bootstrap/dist/js/bootstrap.js
//= include ../bower_components/skrollr/dist/skrollr.min.js
//= include ../bower_components/jquery-validate/dist/jquery.validate.js

try{Typekit.load();}catch(e){}

function initialize() {

	club_info.latitude = parseFloat(club_info.latitude);
	club_info.longitude = parseFloat(club_info.longitude);
	//console.log(club_info);

	var map = new google.maps.Map(document.getElementById('map-canvas'), {
		zoom: 15,
		scrollwheel: false,
		disableDefaultUI: true,
		center: new google.maps.LatLng(club_info.latitude + .004, club_info.longitude),
		mapTypeId: google.maps.MapTypeId.ROADMAP
	});

	var infowindow = new google.maps.InfoWindow({
		content: '<div id="content">' +
			'<h3>' + club_info.name + '</h3>' +
			'<p>' + club_info.address_1 + '<br>' + club_info.address_2 + '</p>' +
			'<p><a class="btn btn-primary btn-xs" href="http://maps.apple.com/maps?daddr=' + encodeURI(club_info.address_1) + '+' + encodeURI(club_info.address_2) + '" target="_blank">Directions</a></p>' +
		'</div>',
		maxWidth: 270
	});

	var marker = new google.maps.Marker({
		position: new google.maps.LatLng(club_info.latitude, club_info.longitude),
		map: map,
		title: 'Saturday Nite Live'
	});

	infowindow.open(map,marker);

	google.maps.event.addListener(marker, 'click', function() {
		infowindow.open(map,marker);
	});
}

function loadScript() {
	var script = document.createElement('script');
	script.type = 'text/javascript';
	script.src = 'https://maps.googleapis.com/maps/api/js?key=AIzaSyBlWPsOFjpzK10n1iRsmkr4FnVW42GNDmM&callback=initialize';
	document.body.appendChild(script);
}

window.onload = loadScript;

$(function(){

	//smooth scrolling
	$("a.scroll").click(function(e) {
        e.preventDefault();
        var href = $(this).attr('href');
		$(".navbar-collapse").collapse('hide');
        $('html, body').stop().animate({
            scrollTop: $(href).offset().top
        }, 500, function(){
	        location.hash = href;        
        });
    });
	
	//parallax big screens
	if (!(/Android|iPhone|iPad|iPod|BlackBerry|Windows Phone/i).test(navigator.userAgent || navigator.vendor || window.opera)) {
		skrollr.init({forceHeight: false});
	}
	
	$('section.contact form').validate({
		errorElement:"span",
		errorClass:"help-inline",
		onfocusout:false,
    	onkeyup: function(element) { },
		errorPlacement: function(error, element) {},
		highlight: function(element, errorClass, validClass) {
			$(element).parent().addClass("has-error");
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parent().removeClass("has-error");
		},
		invalidHandler: function(event, validator) {
			//
		},
		submitHandler: function(form){
			var $form = $(form);
			$.post('/wp-admin/admin-ajax.php', $form.serialize(), function(data) {
				$form.css({ height: $form.height() }).html(data);
			});
			return false;
		}
	});
	
});

