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

mix.babel([
    'node_modules/vue/dist/vue.js',
    'node_modules/vuetify/dist/vuetify.js',
    'node_modules/vee-validate/dist/vee-validate.js',
    'node_modules/vee-validate/dist/locale/es.js',
    'node_modules/moment/moment.js',
    'node_modules/moment/locale/es.js',
    'node_modules/lodash/lodash.js',
    'node_modules/axios/dist/axios.js',
    'node_modules/highcharts/highcharts.js',
    'node_modules/highcharts-vue/dist/script-tag/highcharts-vue.js',
    'node_modules/numeral/numeral.js',
    'node_modules/vue-numeral-filter/dist/vue-numeral-filter.min.js',
], 'public/assets/js/agence.js');

mix.styles([
    'node_modules/vuetify/dist/vuetify.css',
    'node_modules/@mdi/font/css/materialdesignicons.css',
    'node_modules/material-design-icons-iconfont/dist/material-design-icons.css',

], 'public/assets/css/agence.css');

mix.copyDirectory('node_modules/material-design-icons-iconfont/dist/fonts', 'public/assets/css/fonts');
mix.copyDirectory('node_modules/@mdi/font/fonts', 'public/assets/fonts');
mix.copyDirectory('resources/assets/images', 'public/assets/images');
