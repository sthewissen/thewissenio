require('checkenv').check();

const package = require('./package.json');

const path = require('path');
const glob = require('glob');
const webpack = require('webpack');
const HappyPack = require('happypack');
const CopyWebpackPlugin = require('copy-webpack-plugin');
const HtmlWebpackPlugin = require('html-webpack-plugin');
const UglifyJSPlugin = require('uglifyjs-webpack-plugin');
const CleanWebpackPlugin = require('clean-webpack-plugin');
const ExtractTextPlugin = require('extract-text-webpack-plugin');
const createVariants = require('parallel-webpack').createVariants;
const ImageminPlugin = require('imagemin-webpack-plugin').default;
const { removeEmpty, propIf } = require('webpack-config-utils');

let baseOptions = {
	env: process.env.NODE_ENV
}

let variants = {
	theme: process.env.THEMES.split(',')
}

module.exports = createVariants(baseOptions, variants, (options) => ({
	target: 'web',
	name: options.theme,
	context: path.join(__dirname, 'src'),

	entry: {
		main: [
			'babel-polyfill',
			`./scripts/index.js`,
			`./sass/style.scss`
		]
	},

	output: {
		path: path.resolve(__dirname, `dist/`),
		filename: 'js/[name].js?v=[chunkhash]',
	},

	module: {
		rules: [{
			test: /\.(jsx?)$/,
			exclude: /node_modules/,
			loaders: ['happypack/loader?id=js']
		}, {
			test: /\.(tsx?)$/,
			exclude: /node_modules/,
			loaders: ['happypack/loader?id=ts']
		}, {
			test: /\.css$/,
			exclude: /node_modules/,
			loaders: ['happypack/loader?id=css']
		}, {
			test: /\.scss$/, 
			exclude: /node_modules/,
			use: ExtractTextPlugin.extract({
				use: ['happypack/loader?id=scss'],
			})
		}]
	},

	plugins: removeEmpty([
		new HappyPack({
			id: 'js',
			verbose: options.env === 'development',
			loaders: [
				'babel-loader'
			]
		}),

		new HappyPack({
			id: 'ts',
			verbose: options.env === 'development',
			loaders: [
				'ts-loader'
			]
		}),

		new HappyPack({
			id: 'css',
			verbose: options.env === 'development',
			loaders: [
				'style-loader',
				'css-loader']
		}),

		new HappyPack({
			id: 'scss',
			verbose: options.env === 'development',
			loaders: [
				{loader: 'css-loader', options: {url: false}},
				'postcss-loader',
				'sass-loader',
			]
		}),

		new CleanWebpackPlugin(['dist'], {
			verbose: options.env !== 'production'
		}),

		new webpack.optimize.CommonsChunkPlugin({
			name: 'vendor',
			minChunks: module => module.context && module.context.indexOf('node_modules') !== -1
		}),

		new webpack.optimize.CommonsChunkPlugin({
			name: 'runtime',
			minChunks: Infinity
		}),

		new ExtractTextPlugin({
			filename: 'style.css?v=[chunkhash]',
			disable: false,
			allChunks: true
		}),

		// Copy static files
		new CopyWebpackPlugin([{
			from: 'images',
			to: 'img'
		}]),

		new CopyWebpackPlugin([{
			from: 'theme_assets',
			to: ''
		}]),

		new CopyWebpackPlugin([{
			from: 'scripts/lib',
			to: 'js/lib'
		}]),

		new CopyWebpackPlugin([{
			from: 'scripts/custom',
			to: 'js'
		}]),

		new CopyWebpackPlugin([{
			from: 'lib',
			to: 'lib'
		}]),

		new CopyWebpackPlugin([{
			from: 'static',
			to: 'static'
		}]),

		new webpack.DefinePlugin({
			'process.env.NODE_ENV': JSON.stringify(options.env),
			'process.env.THEME': JSON.stringify(options.theme)
		}),

		// Add banner
		new webpack.BannerPlugin({
			banner: `
						Theme Name: Thewissen.io
						Theme URI: https://thewissen.io
						Description: The brand-new Thewissen.io theme!
						Version: 1.0.0
						Author: Yvo Linssen, Steven Thewissen
						Author URI: http://yvolinssen.nl/
						Tags: HTML5, CSS3
					`,
			exclude: /(vendor|runtime).js/
		}),

		propIf(
			options.env === 'development',
			new webpack.NamedModulesPlugin(),
			new webpack.HashedModuleIdsPlugin()
		),

		propIf(
			options.env === 'development',
			new webpack.SourceMapDevToolPlugin({
				exclude: /(vendor|runtime).js/
			})
		),

		propIf(
			options.env === 'production',
			new UglifyJSPlugin({
				parallel: true
			})
		),

		propIf(
			options.env === 'production',
			new ImageminPlugin({
				test: /\.(jpe?g|png|gif|svg)$/i
			})
		)
	].concat(glob.sync('**/*', {
		cwd: path.resolve(process.cwd(), 'src/template'),
		nodir: true
	}).map(file => (
		new HtmlWebpackPlugin({
			chunksSortMode: 'dependency',
			filename: file,
			template: `template/${file}`,
			inject: false,
			package: package,
			variations: options
		})
	))))
}));
