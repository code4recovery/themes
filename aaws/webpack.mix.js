const mix = require('laravel-mix');

mix.scripts([
		'./assets/theme.js', 
	], './assets/compiled/theme.js')
   .sass('./assets/theme.scss', './assets/compiled/theme.css')
   .options({
      processCssUrls: false
   });
