const common = require('./webpack.common.js');
const { mergeWithRules } = require('webpack-merge');

module.exports = mergeWithRules({
  module: {
    rules: {
      test: 'match',
      use: 'prepend'
    }
  }
})(common, {
  mode: 'development',
  output: {
    filename: './js/[name].bundle.js'
  },
  module: {
    rules: [
      {
        test: /\.(sa|sc|c)ss$/,
        use: [
          'style-loader'
        ]
      },
    ]
  }
});
