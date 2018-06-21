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
        .copy('resources/assets/js/*.js', 'public/js')
        .copy('resources/assets/images/', 'public/images/')
        .browserSync({
            proxy: 'vnh.app'
        })
    ;

    mix
        .sass('app.scss')
        .sass('vendor.scss')
        // .scripts('main.js', 'public/js/main.js')
        .scripts('three-grid.js', 'public/js/three-grid.js')
        .scripts([
            'vendor/owl.carousel.min.js',
            'vendor/ion.rangeSlider.js',
            'vendor/bootstrap-select.min.js',
            'vendor/jquery.sticky.js',
            'vendor/jquery.lazyload.min.js'
        ], 'public/js/vendor.js')
    ;
    mix.version(['css/app.css','js/main.js']);

    /*mix
        .sass('admin.scss')
        .copy('resources/assets/js/vendor/ckeditor', 'public/js/ckeditor')
        .styles([
            'font-awesome.min.css', 'ionicons.min.css',
            'bootstrap.min.css', 'select2.min.css',
            'AdminLTE.min.css', '_all-skins.min.css', 'orange.css',
            'datepicker3.css', 'daterangepicker-bs3.css',
            'jquery.dataTables.min.css', 'select.dataTables.min.css', 'nestable.css',
            'bootstrap-datepicker3.standalone.min.css',
            'blue.css'
        ], 'public/css/vendor_admin.css')
        .scripts([
            'vendor/jquery-1.12.2.min.js', 'vendor/jquery-ui.min.js',
            'vendor/bootstrap.min.js', 'vendor/select2.min.js',
            'vendor/moment.min.js', 'vendor/daterangepicker.js', 'vendor/bootstrap-datepicker.js',
            'vendor/jquery.dataTables.min.js', 'vendor/dataTables.select.min.js', 'vendor/jquery.nestable.js',
            'vendor/app-admin.js',
            'vendor/icheck.min.js'
        ], 'public/js/vendor_admin.js')
    ;*/
});
