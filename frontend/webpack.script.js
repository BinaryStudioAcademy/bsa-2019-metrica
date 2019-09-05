const path = require('path');
const UglifyJsPlugin = require('uglifyjs-webpack-plugin');
const Dotenv = require('dotenv-webpack');

module.exports = {
	entry: './scripts/metrica.js',
	output: {
		path: path.resolve(__dirname, 'dist'),
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
	plugins: [
		new Dotenv()
	],
	mode: 'production'
};
