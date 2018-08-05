const webpack = require('webpack');
const baseConfig = require('./webpack.base');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');

const config = require('./base');

module.exports = Object.assign({}, baseConfig, {
  mode: 'production',
  plugins: [
    new webpack.ProvidePlugin({
      $: 'jquery',
      jQuery: 'jquery',
      Vue: ['vue/dist/vue.esm.js', 'default'],
    }),
    new MiniCssExtractPlugin({
      filename: 'styles/main.min.css',
    }),
  ],
  module: {
    rules: [
      {
        test: /\.js$/,
        exclude: /node_modules/,
        use: [
          {
            loader: 'babel-loader',
            options: {
              presets: ['env'],
            },
          },
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
          MiniCssExtractPlugin.loader,
          'css-loader?minimize',
          'postcss-loader',
        ],
      },
      {
        test: /\.scss$/,
        use: [
          MiniCssExtractPlugin.loader,
          'css-loader?minimize',
          'postcss-loader',
          'resolve-url-loader',
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
        test: /\.(ttf|eot|woff2?)$/,
        loader: 'url-loader',
        options: {
          limit: 4096,
          outputPath: 'bundle/',
          name: '[name].[hash:6].[ext]',
        },
      },
      {
        test: /\.(png|jpe?g|gif|svg|ico)$/,
        use: [
          {
            loader: 'url-loader',
            options: {
              limit: 4096,
              outputPath: 'bundle/',
              name: '[name].[hash:6].[ext]',
            },
          },
          {
            loader: 'image-webpack-loader',
          },
        ]
      },
    ],
  },
});

