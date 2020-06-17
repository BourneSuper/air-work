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
	.copy('resources/js/util.js', 'public/js')
	.copy('resources/js/home.js', 'public/js')
	.copy('resources/js/api.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .version();
