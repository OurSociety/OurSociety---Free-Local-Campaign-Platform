require('laravel-mix/src/index');
require(Mix.paths.mix());

Mix.dispatch('init', Mix);

const WebpackConfig = require('laravel-mix/src/builder/WebpackConfig');
const webpackConfig = new WebpackConfig().build();

webpackConfig.module.rules.forEach(rule => {
  // Modify rule for images:
  if (rule.test.toString() === /\.(png|jpe?g|gif)$/.toString()) {
    // Rename paths to "img" instead of "images":
    rule.loaders[0].options.name = path => {
      if (!/node_modules/.test(path)) {
        return 'img/[name].[ext]?[hash]';
      }

      return 'img/vendor/' + path.replace(/.*(node_modules|images|image|img|assets)\//g, '') + '?[hash]';
    };
  }

  // Modify rule for fonts:
  if (rule.test.toString() === /\.(woff2?|ttf|eot|svg|otf)$/.toString()) {
    // Tweak test to only match SVGs with "font" in their path:
    // TODO: s/node_modules/font and fix missing loader for trumbowyg icons
    rule.test = /(\.(woff2?|ttf|eot|otf)$|node_modules.*\.svg$)/;
    //rule.test = /(\.(woff2?|ttf|eot|otf)$|font.*\.svg$)/;
  }
});

module.exports = webpackConfig;
