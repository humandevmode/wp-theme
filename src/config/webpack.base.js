const path = require('path')

module.exports = {
	context: path.resolve(__dirname, '../'),
	entry: [
		'./main.js'
	],
	output: {
		path: path.resolve(__dirname, '../../assets'),
		filename: 'scripts/[name].min.js',
		publicPath: '/wp-content/themes/theme/assets/'
	},
	resolve: {
		extensions: ['.js', '.json', '.vue'],
		alias: {
			styles: path.resolve(__dirname, '../styles'),
			blocks: path.resolve(__dirname, '../blocks'),
		}
	},
	externals: {
		jquery: 'jQuery'
	}
}
