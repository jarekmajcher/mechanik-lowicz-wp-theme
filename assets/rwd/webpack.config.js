const Encore = require('@symfony/webpack-encore');
const path = require('path');
const fg = require('fast-glob');
const SVGSpritemapPlugin = require('svg-spritemap-webpack-plugin');

Encore
  .setOutputPath('./public/rwd')
  .setPublicPath('/wp-content/themes/mechanik-lowicz/public/rwd/')
  .enableSingleRuntimeChunk()
  .cleanupOutputBeforeBuild()
  .enableBuildNotifications()
  .enableSourceMaps(!Encore.isProduction())
  .enableVersioning(Encore.isProduction())
  .enableSassLoader()
  .enablePostCssLoader((options) => {
    options.postcssOptions = {
      config: path.resolve(__dirname, '', 'postcss.config.js'),
    };
  })
  .copyFiles({
    from: './assets/rwd/favicons',
    to: 'favicons/[path][name].[ext]',
  })
  .copyFiles({
    from: './assets/rwd/images',
    to: 'images/[path][name].[hash:8].[ext]',
  })
  .addPlugin(new SVGSpritemapPlugin(
    ['./assets/rwd/icons/*.svg'],
    {
      output: {
        filename: 'icons/sprite.svg',
      },
      sprite: {
        prefix: false,
      },
      styles: false,
    },
  ))
;

// Auto add entry
const entries = fg.sync('./assets/rwd/entrypoints/*.js');
entries.forEach(file => {
  const name = path.basename(file, path.extname(file));
  Encore.addEntry(name, file);
});

const config = Encore.getWebpackConfig();
config.name = 'rwd';

Encore.reset();

module.exports = config;
