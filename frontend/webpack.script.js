const path = require('path');
const webpack = require('webpack');
const UglifyJsPlugin = require('uglifyjs-webpack-plugin');

module.exports = {
	entry: './scripts/metrica.js',
	output: {
		path: path.resolve(__dirname, 'dist', 'script'),
		filename: 'metrica.js'
	},
	module: {
		rules: [
			{
				test: /\.js$/,
				exclude: /node_modules/,
				loader: 'babel-loader'
			}
		]
	},
	optimization: {
		minimizer: [new UglifyJsPlugin()],
	},
	stats: {
		colors: true
	},
	mode: 'production'
};
