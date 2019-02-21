/** @type {import('bili').Config} */
module.exports = {
  input: 'src/index.js',
  bundleNodeModules: true,
  output: {
    dir: './',
    fileName: 'index.js',
    format: 'umd-min',
    sourceMap: false,
    minify: 'false'
  },
  plugins: {
    vue: true,
  }
}
