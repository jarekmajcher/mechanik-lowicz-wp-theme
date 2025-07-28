const Encore = require('@symfony/webpack-encore');
const path = require('path');
const fg = require('fast-glob');

Encore
    .setOutputPath('./public/admin')
    .setPublicPath('/wp-content/themes/mechanik-lowicz/public/admin/')
    .enableSassLoader()
    .enablePostCssLoader((options) => {
      options.postcssOptions = {
        config: path.resolve(__dirname, '', 'postcss.config.js'),
      };
    })
    .disableSingleRuntimeChunk()
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
;

// Auto add entry
const entries = fg.sync('./assets/admin/entrypoints/*.js');
entries.forEach(file => {
  const name = path.basename(file, path.extname(file));
  Encore.addEntry(name, file);
});

const config = Encore.getWebpackConfig();
config.name = 'admin';

Encore.reset();

module.exports = config;
