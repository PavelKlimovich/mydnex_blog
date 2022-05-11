const mix = require('laravel-mix');

mix.setPublicPath('public/');
mix.setResourceRoot('../');

mix.js('resources/js/app.js', 'public/js')
    .sass("resources/scss/app.scss", "public/css");
