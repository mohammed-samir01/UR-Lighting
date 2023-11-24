const mix = require('laravel-mix');
const path = require("path");
const fs = require("fs");

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

mix.js('resources/js/app.js', 'public/js').version().vue();
mix.sass('resources/sass/app.scss', 'public/css').version();
// mix.then(() => {
//     const mixManifest = require(path.resolve(__dirname, 'public/mix-manifest.json'));
//
//     const modifiedMixManifest = {};
//
//     for (const key in mixManifest) {
//         modifiedMixManifest[key] = `public${mixManifest[key]}`;
//     }
//
//     fs.writeFileSync(path.resolve(__dirname, 'public/mix-manifest.json'), JSON.stringify(modifiedMixManifest, null, 2));
// }) .options({
//     hmrOptions: {
//         host: 'ur-lighting-test.com/',
//     },
//     https: true, // Make sure this is set to true if HTTPS is required.
// });

