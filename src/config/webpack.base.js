const path = require('path');

const config = require('./base');


module.exports = {
	context: config.theme_src,
	entry: [
		'./main.js'
	],
	output: {
		path: path.resolve(config.theme_path, './assets'),
		filename: 'scripts/[name].min.js',
		publicPath: `/wp-content/themes/${config.theme_name}/assets/`
	},
	resolve: {
		extensions: ['.js', '.json', '.vue'],
		alias: {
			styles: path.resolve(config.theme_path, './src/styles'),
			blocks: path.resolve(config.theme_path, './src/blocks'),
		}
	},
	externals: {
		jquery: 'jQuery'
	}
}
