const mix = require('laravel-mix');
const WebpackNotifierPlugin = require('webpack-notifier');
const path = require('path');

mix
  .disableNotifications()
  .autoload({
    'jquery': ['$', 'window.jQuery', 'jQuery'], // auto-`require('jquery')` if these variables are used
    'popper.js': 'Popper'
  })
  // .extract([
  //   'popper.js',
  //   'bootstrap'
  // ], 'assets/vendor.js')
  .js('assets/js/app.js', 'webroot/js')
  .js('assets/js/landing.js', 'webroot/js')
  .options({
    // clearConsole: false
  })
  .sass('assets/sass/app.scss', 'webroot/css')
  .sass('assets/sass/landing.scss', 'webroot/css')
  .setPublicPath('webroot')
  // .setResourceRoot('assets')
  .webpackConfig({
    output: {
      // publicPath: '/assets/',
      // chunkFilename: 'assets/dist/[name].[chunkhash].js',
    },
    plugins: [
      new WebpackNotifierPlugin({
        title: 'OurSociety',
        alwaysNotify: true,
        contentImage: path.resolve(__dirname, 'assets/img/logo.png')
      })
    ],
    devServer: {
      // fix css files 404 issue #344
      contentBase: path.resolve(__dirname, 'webroot'),
    }
  });

if (process.env.npm_lifecycle_event === 'hot') {
  // yarn hot
  mix.browserSync({
      host: 'localhost',
      port: 3000,
      proxy: process.env.APP_DOMAIN,
      files: [
        // 'src/**/*.php',
        // 'src/Template/**/*.php',
        'webroot/js/**/*.js',
        'webroot/css/**/*.css'
      ]
    })
} else {
  // yarn dev|prod|watch
  mix.version() // version does not work in hot mode
}
