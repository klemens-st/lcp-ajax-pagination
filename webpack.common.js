const path = require( 'path' );
const ESLintPlugin = require( 'eslint-webpack-plugin' );
const MiniCssExtractPlugin = require( 'mini-css-extract-plugin' );

module.exports = {
	entry: {
		'public/dist/main': './public/js/main.js',
	},

	output: {
		filename: '[name].min.js',
		path: path.resolve( __dirname, './' ),
	},

	plugins: [
		new ESLintPlugin(),
		new MiniCssExtractPlugin( {
			filename: 'public/dist/main.min.css',
		} ),
	],

	module: {
		rules: [
			{
				test: /\.m?js$/,
				exclude: /(node_modules|bower_components)/,
				use: {
					loader: 'babel-loader',
					options: {
						presets: [ '@babel/preset-env' ],
					},
				},
			},
			{
				test: /\.scss$/,
				use: [
					MiniCssExtractPlugin.loader,
					{
						loader: 'css-loader',
						options: {
							sourceMap: true,
						},
					},
					{
						loader: 'postcss-loader',
						options: {
							sourceMap: true,
							postcssOptions: {
								plugins: [
									[ 'autoprefixer' ],
								],
							},
						},
					},
					{
						loader: 'sass-loader',
						options: {
							sourceMap: true,
						},
					},
				],
				exclude: /node_modules/,
			},
		],
	},
};
