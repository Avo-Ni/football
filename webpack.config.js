const Encore = require('@symfony/webpack-encore');

Encore
  .enableVueLoader()
  .setOutputPath('public/build/')
  .setPublicPath('/build')
  .addEntry('app', './assets/app.js')
  .splitEntryChunks()
  .enableSingleRuntimeChunk()
  .cleanupOutputBeforeBuild()
  .enableBuildNotifications()
  .enableSourceMaps(!Encore.isProduction())
  .enableVersioning(Encore.isProduction())
  .enableVueLoader()
  .configureBabel(null, {
    useBuiltIns: 'usage',
    corejs: 3,
   });

module.exports = Encore.getWebpackConfig();
