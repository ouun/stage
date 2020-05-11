const mix = require('laravel-mix');
require('mix-tailwindcss');
require('@tinypixelco/laravel-mix-wp-blocks');
require('laravel-mix-purgecss');
require('laravel-mix-copy-watched');
require('laravel-mix-export-tailwind-config');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management – https://laravel-mix.com
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Stage application. By default, we are compiling the Sass file
 | for your application, as well as bundling up your JS files.
 |
 */

// Public Path & Development Domain
mix.setPublicPath('./dist')
  .browserSync({
    proxy: 'stage.test',
    port: '1984',
  });

// JavaScript
// Todo: .extract() is removed: https://github.com/roots/sage/issues/2204
// So there is no manifest.js file available
mix.js('resources/assets/scripts/app.js', 'scripts')
  .block('resources/assets/scripts/editor.js', 'scripts');

// Styles
mix.sass('resources/assets/styles/stage.scss', 'styles')
  .sass('resources/assets/styles/shop.scss', 'styles')
  .sass('resources/assets/styles/blocks.scss', 'styles/blocks')
  .sass('resources/assets/styles/blocks-editor.scss', 'styles/blocks')
  .sass('app/Customizer/assets/styles/customizer.scss', 'styles/customizer')
  .sass('app/Customizer/assets/styles/controls.scss', 'styles/customizer')
  .tailwind();

// Assets
mix.copyWatched('resources/assets/images', 'dist/images')
  .copyWatched('resources/assets/icons', 'dist/icons')
  .copyWatched('resources/assets/fonts', 'dist/fonts')
  .copyWatched('resources/languages', 'dist/languages');

// Customizer Scripts
mix.copyWatched('app/Customizer/assets/scripts', 'dist/scripts/customizer');

// Autoload
mix.autoload({
  jquery: ['$', 'window.jQuery'],
});

// Options
mix.options({
  processCssUrls: false,
});

// Generate source maps when not in production
mix.sourceMaps(false, 'source-map')
  .version();

// Export Tailwind config to json
mix.exportTailwindConfig('tailwind.config.js', 'tailwind.config.json');
