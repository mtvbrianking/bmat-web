const mix = require('laravel-mix');

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

mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css');

mix.js('node_modules/perfect-scrollbar/dist/perfect-scrollbar.min.js', 'public/plugins/js/perfect-scrollbar.min.js')
	.styles('node_modules/perfect-scrollbar/css/perfect-scrollbar.min.css', 'public/plugins/css/perfect-scrollbar.css');

// mix.sass('resources/sass/landing-screens/_auth.scss', 'public/css');
