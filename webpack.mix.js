const mix = require('laravel-mix');
const path = require('path');
const SpriteLoaderPlugin = require('svg-sprite-loader/plugin');
const WebpackNotifierPlugin = require('webpack-notifier');

mix
  .disableNotifications()
  .autoload({
    'jquery': ['$', 'window.jQuery', 'jQuery'], // auto-`require('jquery')` if these variables are used
    'popper.js/dist/umd/popper.js': ['Popper'],
  })
  .extract(['bootstrap', 'bootstrap-sass', 'jdenticon/dist/jdenticon.js', 'jquery', 'popper.js', 'selectize', 'trumbowyg'])
  .js('assets/js/app.js', 'webroot/js')
  .js('assets/js/landing.js', 'webroot/js')
  .js('assets/admin/js/admin.js', 'webroot/js/admin.js')
  .js('assets/common/js/common.js', 'webroot/js/common.js')
  .js('assets/embed/main.js', 'webroot/js/embed.js')
  .options({
    // clearConsole: false
  })
  .sass('assets/sass/app.scss', 'webroot/css')
  .sass('assets/sass/landing.scss', 'webroot/css')
  .sass('assets/admin/scss/admin.scss', 'webroot/css/admin.css', {
    includePaths: ['node_modules']
  })
  .sass('assets/embed/scss/embed.scss', 'webroot/css')
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
        {
          test: /\.svg((\?.*)?|$)/,
          include: path.resolve(__dirname, 'assets/img/logo'),
          use: [
            {
              loader: 'svg-sprite-loader',
              options: { extract: true, spriteFilename: 'img/sprite-branding.svg' }
            },
            'svgo-loader'
          ]
        },
        {
          test: /\.svg((\?.*)?|$)/,
          include: path.resolve(__dirname, 'assets/admin/svg'),
          use: [
            {
              loader: 'svg-sprite-loader',
              options: { extract: true, spriteFilename: 'img/sprite-admin.svg' }
            },
            'svgo-loader'
          ]
        },
        {
          test: /\.svg((\?.*)?|$)/,
          include: path.resolve(__dirname, 'assets/img/brand'),
          use: [
            {
              loader: 'svg-sprite-loader',
              options: { extract: true, spriteFilename: 'img/brand-sprite.svg' }
            },
            'svgo-loader'
          ]
        }
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
