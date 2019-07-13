const mix = require('laravel-mix');

mix.sass('./assets/theme.scss', './assets/compiled/theme.css')
	.scripts([
		'./node_modules/bootstrap/dist/js/bootstrap.bundle.min.js', 
		'./assets/theme.js', 
	], './assets/compiled/theme.js')
	.options({
		processCssUrls: false
	});
