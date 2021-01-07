let mix = require('laravel-mix');

mix.setPublicPath('public');

//MIX SCSS FILES
mix.sass('resources/assets/sass/app.scss', 'public/css/all.css');

//MIX JS FILES
mix.js('resources/assets/js/app.js', 'public/js/all.js');
