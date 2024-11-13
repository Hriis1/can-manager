const { defineConfig } = require('@vue/cli-service');
module.exports = defineConfig({
  transpileDependencies: true,
  devServer: {
    proxy: {
      '/can-data.json': {
        target: 'http://localhost/can-manager',
        changeOrigin: true
      },
      '/include': {
        target: 'http://localhost/can-manager',
        changeOrigin: true,
        pathRewrite: { '^/include': '/include' } // Rewrite if needed
      }
    }
  }
});
