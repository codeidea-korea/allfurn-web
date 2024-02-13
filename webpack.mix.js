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

mix.scripts([
        'resources/js/plugin/component.js',
        'resources/js/plugin/datepicker.js',
        'resources/js/plugin/ui-plugin.js',
        'resources/js/mypage.js',
        'resources/js/community.js',
        'resources/js/ui.js',
        'resources/js/headernav.js',
        'resources/js/message.js',
    ], 'public/js/plugin.js')
    .styles([
        'resources/css/ui.css',
        'resources/css/icons.css',
    ], 'public/css/ui.css')
    .copy('resources/fonts/PretendardVariable.woff2', 'public/fonts/PretendardVariable.woff2')
