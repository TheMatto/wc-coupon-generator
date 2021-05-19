const common = require('./webpack.common.js');
const { mergeWithRules } = require('webpack-merge');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');

module.exports = mergeWithRules({
  module: {
    rules: {
      test: 'match',
      use: 'prepend'
    }
  }
})(common, {
  mode: 'production',
  output: {
    filename: './js/[name].bundle.[chunkhash].js'
  },
  module: {
    rules: [
      {
        test: /\.(sa|sc|c)ss$/,
        use: [
          MiniCssExtractPlugin.loader
        ]
      },
    ]
  },
  plugins: [
    new MiniCssExtractPlugin({
      filename: './css/[name].bundle.[chunkhash].css'
    })
  ]
});
