const mix = require('laravel-mix');
const path = require('path');
const SpriteLoaderPlugin = require('svg-sprite-loader/plugin');
const WebpackNotifierPlugin = require('webpack-notifier');

mix

  // Current themes: (TODO: if possible, merge site/admin/common into single BS4 theme)
  // - Site: used for frontend, based on Bootstrap 4
  .sass('assets/site/scss/main.scss', 'webroot/css/site.css')
  .js('assets/site/js/main.js', 'webroot/js/site.js')
  // - Admin: used for backend, based on Bootstrap 4
  .sass('assets/admin/scss/admin.scss', 'webroot/css/admin.css', { includePaths: ['node_modules'] })
  .js('assets/admin/js/admin.js', 'webroot/js/admin.js')
  // - Common: Styles and scripts shared between frontend and backend
  .js('assets/common/js/common.js', 'webroot/js/common.js')
  // - Embed: used for widget embed, based on Bootstrap 4
  .sass('assets/embed/scss/main.scss', 'webroot/css/embed.css')
  .js('assets/embed/main.js', 'webroot/js/embed.js')

  // Deprecated themes:
  // - App: used for old frontend, based on Bootstrap 3 (deprecated, to be dropped ASAP)
  .sass('assets/sass/app.scss', 'webroot/css')
  .js('assets/js/app.js', 'webroot/js')
  // - Landing: used for static index.html (deprecated, to be dropped at time of public launch)
  .sass('assets/sass/landing.scss', 'webroot/css')
  .js('assets/js/landing.js', 'webroot/js')

  // TODO: Fix SVG stuff.
  .copy('assets/img/svg/video-placeholder.svg', 'webroot/img/svg/video-placeholder.svg')
  // Configuration:
  .disableNotifications()
  .autoload({
    'jquery': ['$', 'window.jQuery', 'jQuery'], // auto-`require('jquery')` if these variables are used
    'popper.js/dist/umd/popper.js': ['Popper'],
    'moment': ['moment'],
  })
  .extract(['bootstrap', 'bootstrap-sass', 'jdenticon/dist/jdenticon.js', 'jquery', 'popper.js', 'selectize', 'trumbowyg'])
  .options({
    // clearConsole: false
  })
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

Mix.listen('configReady', (webpackConfig) => {

  // TODO: Delete webpack.config.js and move logic to here. See https://github.com/JeffreyWay/laravel-mix/pull/1077
  // // remove original rule
  // webpackConfig.module.rules = webpackConfig.module.rules.filter(rule => String(rule.test) !== String(/\.s[ac]ss$/))
  //
  // // add modified rule
  // webpackConfig.module.rules.push({
  //   test: /\.s[ac]ss$/,
  //   loaders: [
  //     {loader: 'style-loader'},
  //     {loader: 'css-loader', options: {sourceMap: true}},
  //     {loader: 'sass-loader', options: {sourceMap: true}},
  //   ],
  // })

})
