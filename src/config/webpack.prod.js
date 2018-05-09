const path = require('path');
const webpack = require('webpack')
const baseConfig = require('./webpack.base');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');


module.exports = Object.assign({}, baseConfig, {
	mode: 'production',
	plugins: [
		new webpack.ProvidePlugin({
			$: 'jquery',
			jQuery: 'jquery',
			Vue: ['vue/dist/vue.esm.js', 'default']
		}),
		new MiniCssExtractPlugin({
			filename: 'styles/main.min.css'
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
							presets: ['env']
						}
					}
				]
			},
			{
				test: /\.vue$/,
				use: [
					'vue-loader'
				]
			},
			{
				test: /\.css$/,
				use: [
					MiniCssExtractPlugin.loader,
					'css-loader?minimize',
					'postcss-loader',
				]
			},
			{
				test: /\.scss$/,
				use: [
					MiniCssExtractPlugin.loader,
					'css-loader?minimize',
					'postcss-loader',
					'resolve-url-loader',
					{
						loader: "sass-loader", options: {
							sourceMap: true,
							data: '@import "styles/global";',
							includePaths: [
								path.join(__dirname, '../')
							]
						}
					}
				]
			},
			{
				test: /\.(ttf|eot|woff2?|png|jpe?g|gif|svg|ico)$/,
				loader: 'url-loader',
				options: {
					limit: 4096,
					outputPath: 'bundle/',
					name: '[name].[hash:6].[ext]',
				}
			},
		],
	}
})

