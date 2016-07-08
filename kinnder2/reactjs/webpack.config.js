var webpack = require('webpack');
var path = require('path');

var BUILD_DIR = path.resolve(__dirname, '../web/js');
var APP_DIR = path.resolve(__dirname, 'src/app/js');
console.log(BUILD_DIR);
var config = {
  entry: { 
      newsletter: [APP_DIR + '/newsletter.jsx']
  },
  output: {
    path: BUILD_DIR,
    filename: '[name].js'
  },
  plugins: [
    new webpack.IgnorePlugin(/^(buffertools)$/) // unwanted "deeper" dependency
  ],
  module : {
    loaders : [
      {
        test : /\.jsx?/,
        include : APP_DIR,
        loader : 'babel',
        query: {
          presets: ['es2015','react']
        }
      }
    ]
  },
  //devtool: 'eval'

};

module.exports = config;

