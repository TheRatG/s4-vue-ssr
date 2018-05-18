const Encore = require('@symfony/webpack-encore');
const path = require('path');

Encore
// the project directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // the public path used by the web server to access the previous directory
    .setPublicPath('/build')
    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())
    // uncomment to create hashed filenames (e.g. app.abc123.css)
    .enableVersioning()
    .enableVueLoader()
    // uncomment to define the assets of the project
    .addEntry('js/client', './assets/js/client.js')
    .addEntry('js/server', './assets/js/server.js')
// .addStyleEntry('css/app', './assets/css/app.scss')

// uncomment if you use Sass/SCSS files
// .enableSassLoader()

// uncomment for legacy applications that require $/jQuery as a global variable
// .autoProvidejQuery()

// .configureBabel(function(babelConfig) {
//     // babelConfig.plugins.push('syntax-dynamic-import');
//     // babelConfig.plugins.push('transform-object-rest-spread');
//     // babelConfig.plugins.push('transform-class-properties');
//     // babelConfig.presets.push('babel-polyfill');
//     babelConfig.presets.push('babel-preset-stage-3');
// })
;

config = Encore.getWebpackConfig();
config.watchOptions = {poll: true, ignored: '/node_modules/'};
config.resolve.alias.project_root = path.resolve(__dirname);
module.exports = config;
