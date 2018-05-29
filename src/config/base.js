const path = require('path');

const theme_src = path.resolve(__dirname, '../');
const theme_path = path.resolve(__dirname, '../..');
const theme_name = path.basename(theme_path);

module.exports = {
	theme_src,
	theme_path,
	theme_name,
}
