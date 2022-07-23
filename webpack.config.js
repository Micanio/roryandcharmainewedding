const path = require('path');
const ExtractTextPlugin = require('extract-text-webpack-plugin');
const HtmlWebpackPlugin = require('html-webpack-plugin');   
const CopyWebpackPlugin = require('copy-webpack-plugin');
const webpack = require('webpack');
const srcPath = path.join(__dirname, 'src');
const buildPath = path.join(__dirname, 'dist');

const config = {
    context: srcPath,
    devtool: 'source-map',
    entry: {
        vendor: [
            './scripts/scripts.js', 
        ], 
        app: './entry/app.js'
    },
    output: {
        filename: '[name].js',
        path: buildPath,
        sourceMapFilename: '[name].map',
        publicPath: '/wp-content/themes/theroyaloak/'
    },
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                loader: 'babel-loader',
                query: {
                    presets: ['es2015-ie'] 
                }
            }, { 
                test: /\.scss$/,
                use: ExtractTextPlugin.extract({
                    fallback: 'style-loader',
                    use: ['css-loader','autoprefixer-loader','sass-loader'],
                   // publicPath: '/'
                })

            }, {
                test: /\.svg$/,
                include: path.resolve(srcPath, 'images/svg'),
                loader: 'url-loader?limit=30000&name=images/svg/[name].[ext]',
            }, {
                test: /\.(png|gif|jpg)$/,
                include: path.resolve(srcPath, 'images'),
                loader: 'url-loader?limit=30000&name=images/[name].[ext]',
            },
            {
                test: /\.(woff|woff2|eot|ttf|otf)$/,
                include: path.resolve(srcPath, 'fonts'),
                loader: 'file-loader',
                options: {
                    name: '[path][name].[ext]'
                },
                },
        ]
    },
    watch: true,
    plugins: [
        new webpack.optimize.CommonsChunkPlugin({
            name: "vendor",
            filename: "vendor.js",
            minChunks: Infinity
        }),
        new CopyWebpackPlugin([
           //{ from: path.resolve(srcPath, 'scripts/modernizr-custom.js'), to: path.resolve(buildPath, 'scripts') },
           { from: path.resolve(srcPath, 'images'), to: path.resolve(buildPath, 'images') }
        ]),
        new ExtractTextPlugin('./styles/style.css'),
        /*
        new ExtractTextPlugin({
            filename: "style.css",
            disable: false,
            allChunks: true,
            ignoreOrder: true
        }), 
        */
        new webpack.ProvidePlugin({
           // $: "jquery",
           // jQuery: "jquery",
            slick: path.resolve(srcPath, 'scripts/slick.js')
        }),
        new webpack.optimize.UglifyJsPlugin({
            minimize: true,
            compress: false
        })
        
    ],
    
}

if(process.env.NODE_ENV === 'production') {
    config.plugins.push(
        new webpack.DefinePlugin({
            'process.env': {
                'NODE_ENV': JSON.stringify(process.env.NODE_ENV)
            }
        }),
        new webpack.optimize.UglifyJsPlugin
    )
}

module.exports = config;