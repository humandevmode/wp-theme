const webpack = require('webpack');
const baseConfig = require('./webpack.base');

const config = require('./base');

module.exports = Object.assign({}, baseConfig, {
  mode: 'development',
  devtool: 'eval',
  entry: {
    main: [
      'webpack-hot-middleware/client?reload=true&noInfo=true',
      'webpack/hot/dev-server',
      './main.js',
    ],
  },
  plugins: [
    new webpack.ProvidePlugin({
      $: 'jquery',
      jQuery: 'jquery',
      Vue: ['vue/dist/vue.esm.js', 'default'],
    }),
    new webpack.HotModuleReplacementPlugin(),
  ],
  module: {
    rules: [
      {
        test: /\.js$/,
        exclude: [/node_modules(?![/|\\](bootstrap|foundation-sites))/],
        use: [
          'babel-loader?presets=env',
        ],
      },
      {
        test: /\.vue$/,
        use: [
          'vue-loader',
        ],
      },
      {
        test: /\.css$/,
        use: [
          'style-loader?sourceMap',
          'css-loader?sourceMap',
          'postcss-loader?sourceMap',
        ],
      },
      {
        test: /\.scss$/,
        use: [
          'style-loader?sourceMap',
          'css-loader?sourceMap',
          'postcss-loader?sourceMap',
          'resolve-url-loader?sourceMap',
          {
            loader: 'sass-loader', options: {
              sourceMap: true,
              data: '@import "styles/global";',
              includePaths: [
                config.theme_src,
              ],
            },
          },
        ],
      },
      {
        test: /\.(ttf|eot|woff2?|png|jpe?g|gif|svg|ico)$/,
        loader: 'url-loader',
        options: {
          limit: 4096,
          outputPath: 'bundle/',
          name: '[name].[hash:6].[ext]',
        },
      },
    ],
  },
});
