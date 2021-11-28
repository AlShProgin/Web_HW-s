const path = require('path')
var webpack = require("webpack")

module.exports = {
    entry: 'JS/NodeJS-test.js',
    module: {
        rules: [
            { test: /\.(js)$/, use: 'babel-loader' },
            { test: /\.css$/, use: ['style-loader', 'css-loader'] }
        ]
    },
    output: {
        path: path.resolve(__dirname, 'JS'),
        filename: 'bundle.js'
    }
}