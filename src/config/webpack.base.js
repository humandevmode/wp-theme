'use strict'

const path = require('path')

module.exports = {
	entry: [
		'./main.js'
	],
	context: path.resolve(__dirname, '../src'),
	output: {
		path: path.resolve(__dirname, '../assets'),
		filename: 'scripts/[name].min.js',
		publicPath: '/wp-content/themes/wp-theme/assets/'
	},
	resolve: {
		extensions: ['.js', '.json', '.vue'],
	},
	externals: {
		jquery: 'jQuery'
	}
}
