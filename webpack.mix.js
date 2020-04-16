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

mix.js('resources/js/app.js', 'public/js');
mix.js('resources/js/login-app.js', 'public/js');

// mix.sass('resources/sass/theme.sass', 'public/css');
mix.sass('resources/sass/global.sass', 'public/css');
mix.sass('resources/sass/app.sass', 'public/css');
