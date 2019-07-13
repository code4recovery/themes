var gulp 		= require('gulp');
var gutil 		= require('gulp-util');
var notify 		= require('gulp-notify');
var less 		= require('gulp-less');
var autoprefix 	= require('gulp-autoprefixer');
var minifyCSS 	= require('gulp-minify-css');
var rename		= require('gulp-rename');
var include		= require('gulp-include');
var uglify		= require('gulp-uglify');

gulp.task('editor-less', function(){
	return gulp.src('assets/editor.less')
		.pipe(less({
			compress: true,
	        onError: function(err) {
	            return notify(err);
	        }
		}))
		.pipe(autoprefix('last 3 version'))
        .pipe(rename({suffix: '.min'}))
		.pipe(gulp.dest('assets/css/'))
		.pipe(notify('css compiled'));
});

gulp.task('theme-less', function(){
	return gulp.src('assets/theme.less')
		.pipe(less({
			compress: true,
	        onError: function(err) {
	            return notify(err);
	        }
		}))
		.pipe(autoprefix('last 3 version'))
        .pipe(rename({suffix: '.min'}))
		.pipe(gulp.dest('assets/css/'))
		.pipe(notify('css compiled'));
});

gulp.task('theme-js', function(){
	return gulp.src('assets/theme.js')
		.pipe(include())
		.pipe(uglify({mangle:false}))
        .pipe(rename({suffix: '.min'}))
		.pipe(gulp.dest('assets/js/'));
});

gulp.task('watch', function(){
	gulp.watch('assets/editor.less', ['editor-less']);
	gulp.watch('assets/theme.less', ['theme-less']);
	gulp.watch('assets/theme.js', ['theme-js']);
});

gulp.task('default', ['editor-less', 'theme-less', 'theme-js', 'watch']);