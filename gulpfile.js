process.env.DISABLE_NOTIFIER = true;
var elixir = require('laravel-elixir');
elixir.config.sourcemaps = false;
elixir.config.css.autoprefix = {
    enabled: true,
    options: {
        cascade: true,
        remove: true,
        browsers: ['last 7 versions', '> 10%']
    }
};

var gulp = require('gulp');
var newer = require('gulp-newer');
var rename = require('gulp-rename');
var minifyCss = require('gulp-minify-css');

cssSrc = 'public/css/common/css-custom.css';//Your css source directory
cssDest = 'public/css/';//Your css destination directory

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix
        //common library
        /*
        .styles([
            'bootstrap.css',
            'animate.css',
            'owl.carousel.min.css',
            'owl.theme.default.min.css',
            'gallery.css',
            'jquery.range.css',
            'bootstrap-slider.min.css',
        ], 'public/css/css-lib.css', 'public/css/common/')

        .scripts([
            'bootstrap.min.js',
            'jquery.easing.min.js',
            'jquery.wow.min.js',
            'wow.min.js',
            'owl.carousel.js',
            'gallery.js',
            'asidebar.jquery.js',
            'jquery.range.js',
            'modernizr.custom.js'
        ], 'public/js/jquery-plugin.js', 'public/js/common/')
        */
        //custom js
        .scripts([
            'three-grid.js',
            'main.js',
            'scripts.js'
        ], 'public/js/js-custom.js', 'public/js/custom/')

        //custom ccs
        .styles([
            'style.css',
            'responsive.css'
        ], 'public/css/common/css-custom.css', 'public/css/custom/')

    ;

    //minifycss
    mix.task('cssTask','public/css/common/css-custom.css');

    //build hash for custom
    mix.version(['css/css-custom.min.css','js/js-custom.js']);

});

gulp.task('cssTask', function() {
    return gulp.src(cssSrc)
        .pipe(newer(cssDest))//compares the css source and css destination(css files)
        .pipe(rename('css-custom.min.css'))
        .pipe(minifyCss())//minify css
        .pipe(gulp.dest(cssDest));//save minified css in destination directory
});

// gulp.task('custom', function() {
//     gulp.watch(cssSrc, ['cssTask']);//watch your css source and call css task
// });

