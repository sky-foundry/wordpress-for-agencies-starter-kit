const Encore = require('@symfony/webpack-encore')

const themeName = 'default-theme'

Encore.setOutputPath(`web/app/themes/${themeName}/dist/`)
  // Public path used by the web server to access the output path
  .setPublicPath(`/app/themes/${themeName}/dist`)
  .setManifestKeyPrefix('dist/')
  /*
   * ENTRY CONFIG
   *
   * Add 1 entry for each "page" of your app
   * (including one that's included on every page - e.g. "app")
   *
   * Each entry will result in one JavaScript file (e.g. app.js)
   * and one CSS file (e.g. app.css) if your JavaScript imports CSS.
   */
  .addEntry('main', `./web/app/themes/${themeName}/javascript/main.js`)
  .addStyleEntry('app', `./web/app/themes/${themeName}/css/app.css`)

  .enableSingleRuntimeChunk()
  .cleanupOutputBeforeBuild()
  .enableSourceMaps(!Encore.isProduction())
  .enableVersioning(Encore.isProduction())
  /*
   * You can enable Sass support if you prefer to use that instead of PostCSS
   * Just make sure to comment out 'enablePostCssLoader()' below
   */
  // .enableSassLoader()
  .enablePostCssLoader()

module.exports = Encore.getWebpackConfig()
