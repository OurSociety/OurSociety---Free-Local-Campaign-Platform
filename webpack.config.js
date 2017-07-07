const webpack = require('webpack');
const path = require('path');
const ExtractTextPlugin = require('extract-text-webpack-plugin');
const inProduction = (process.env.NODE_ENV === 'production');

//noinspection JSUnresolvedFunction
module.exports = {
  entry: {
    app: './assets/main.js'
  },
  output: {
    path: path.resolve(__dirname, './webroot/assets'),
    filename: '[name].js'
  },
  module: {
    rules: [
      {
        test: /\.s[ac]ss$/,
        use: ExtractTextPlugin.extract({
          use: ['css-loader', 'sass-loader'],
          fallback: 'style-loader'
        })
      },
      {
        test: /\.js/,
        exclude: /node_modules/,
        use: 'babel-loader'
      }
    ]
  },
  plugins: [
    new ExtractTextPlugin('[name].css'),
    new webpack.LoaderOptionsPlugin({
      minimize: inProduction
    })
  ]
};

if (inProduction) {
  //noinspection JSUnresolvedFunction
  module.exports.plugins.push(
    new webpack.optimize.UglifyJsPlugin()
  );
}
