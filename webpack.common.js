const { join } = require('path');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');
const { VueLoaderPlugin } = require('vue-loader');

module.exports = {
  entry: {
    'frontend': join(__dirname, 'resources/frontend.js'),
    'backend': join(__dirname, 'resources/backend.js'),
  },
  output: {
    path: join(__dirname, 'dist')
  },
  module: {
    rules: [
      {
        test: /\.tsx?$/,
        loader: 'ts-loader',
        options: {
          appendTsSuffixTo: [/\.vue$/],
        },
        exclude: /node_modules/,
      },
      {
        test: /\.vue$/, 
        loader: 'vue-loader'
      },
      {
        test: /\.(sa|sc|c)ss$/,
        use: [
          'css-loader',
          'resolve-url-loader',
          'sass-loader'
        ]
      },
      {
        test: /\.(woff|woff2|ttf|otf|svg)$/,
        loader: 'file-loader',
        include: [/fonts/],
        options: {
          name: 'fonts/[name]-[hash].[ext]',
          publicPath: '../'
        }
      }
    ]
  },
  plugins: [
    new VueLoaderPlugin(),
    new CleanWebpackPlugin()
  ]
};
