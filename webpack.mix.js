const { mix } = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix
    .scripts([
        'node_modules/jquery/dist/jquery.js',
        'node_modules/bootstrap-sass/assets/javascripts/bootstrap.js',
        'node_modules/sweetalert2/dist/sweetalert2.js',
        'node_modules/toastr/build/toastr.min.js',
        'resources/assets/js/loader.js',
        'resources/assets/js/app.js'
    ], 'public/js/app.js')
    .sass('resources/assets/sass/app.scss', 'public/css/app.css')
    .version();
