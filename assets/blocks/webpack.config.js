const Encore = require('@symfony/webpack-encore');
const path = require('path');
const fg = require('fast-glob');

Encore
  .setOutputPath('public/blocks/')
  .setPublicPath('/wp-content/themes/mechanik-lowicz/public/blocks')
  .disableSingleRuntimeChunk()
  .cleanupOutputBeforeBuild()
  .enableBuildNotifications()
  .enableSourceMaps(!Encore.isProduction())
  .enableVersioning(Encore.isProduction())
  .autoProvideVariables({})
  .enableSassLoader()
  .configureBabel((config) => {
    config.presets.push('@wordpress/babel-preset-default');
  })
  .enableReactPreset()
  .addExternals({
    'react': 'React',
    'react-dom': 'ReactDOM',
    '@wordpress/blocks': ['wp', 'blocks'],
    '@wordpress/block-editor': ['wp', 'blockEditor'],
    '@wordpress/components': ['wp', 'components'],
    '@wordpress/element': ['wp', 'element']
  });

// Auto add entry
const entries = fg.sync('./assets/blocks/entrypoints/**/*.js');
entries.forEach(file => {
  // wyciągam ścieżkę względną względem ./assets/blocks/entrypoints
  const relative = path.relative('./assets/blocks/entrypoints', file);
  // usuwam rozszerzenie
  const name = relative.replace(path.extname(relative), '');
  // ustawiam entry – nazwa zachowuje strukturę katalogów
  Encore.addEntry(name, file);
});

const config = Encore.getWebpackConfig();
config.name = 'blocks';

Encore.reset();

module.exports = config;
