const path = require("path");

module.exports = {
  entry: {
    application: "./assets/bbb-connector.js",
  },
  output: {
    filename: "bbb-connector-app.js",
    path: path.resolve(__dirname, "assets")
  },
  module: {
    rules: [{ test: /\.js$/, exclude: /node_modules/, loader: "babel-loader" }]
  }
};
