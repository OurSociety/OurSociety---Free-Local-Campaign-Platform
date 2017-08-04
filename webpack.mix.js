const mix = require('laravel-mix');
const path = require('path');
const SpriteLoaderPlugin = require('svg-sprite-loader/plugin');
const WebpackNotifierPlugin = require('webpack-notifier');

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
  .js('assets/embed/main.js', 'webroot/js/embed.js')
  .options({
    // clearConsole: false
  })
  .sass('assets/sass/app.scss', 'webroot/css')
  .sass('assets/sass/landing.scss', 'webroot/css')
  .sass('assets/embed/main.scss', 'webroot/css/embed.css')
  .setPublicPath('webroot')
  // .setResourceRoot('assets')
  .webpackConfig({
    module: {
      rules: [
        {
          test: /\.svg((\?.*)?|$)/,
          include: path.resolve(__dirname, 'assets/img/icon/topic'),
          use: [
            {
              loader: 'svg-sprite-loader',
              options: { extract: true, spriteFilename: 'img/icons-topics.svg' }
            },
            'svgo-loader'
          ]
        },
      ]
    },
    output: {
      // publicPath: '/assets/',
      // chunkFilename: 'assets/dist/[name].[chunkhash].js',
    },
    plugins: [
      new SpriteLoaderPlugin(),
      new WebpackNotifierPlugin({
        title: 'OurSociety',
        alwaysNotify: true,
        contentImage: path.resolve(__dirname, 'webroot/img/logo.png')
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
