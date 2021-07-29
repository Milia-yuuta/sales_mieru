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
mix.webpackConfig({
  mode: 'production'
})

mix.js('resources/js/select2_start.js', 'public/js')
    .js('resources/js/analysis/exactionReport/index.js', 'public/js/analysis/exactionReport')
    .js('resources/js/analysis/todayStock/index.js', 'public/js/analysis/todayStock')
    .js('resources/js/analysis/stageTrend/index.js', 'public/js/analysis/stageTrend')
    .js('resources/js/dailyReport/index/index.js', 'public/js/dailyReport/index')
    .js('resources/js/dailyReport/show/index.js', 'public/js/dailyReport/show')
    .js('resources/js/analysis/pursuit/index.js', 'public/js/analysis/pursuit')
    .js('resources/js/analysis/yield/index.js', 'public/js/analysis/yield')
    .js('resources/js/element/button/all_check_button.js', 'public/js')
    .js('resources/js/prospect/show/index.js', 'public/js/prospect/show')
    .js('resources/js/analysis/monthResult/index.js', 'public/js/analysis/monthResult')
    .js('resources/js/analysis/webResponse/index.js', 'public/js/analysis/webResponse')
    .js('resources/js/prospect/index/index.js', 'public/js/prospect/index')
    .js('resources/js/property/index.js', 'public/js/property')
    .js('resources/js/home/index.js', 'public/js/home')
    .sass('resources/sass/app.scss', 'public/css')
    .version();