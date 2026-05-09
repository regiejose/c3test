import { defineConfig } from 'vite'

export default defineConfig({
  build: {
    outDir: 'dist',
    emptyOutDir: true,

    rollupOptions: {
      input: {
        main: './src/js/main.js',
        style: './src/css/style.css',
      },
      output: {
        assetFileNames: '[name].[ext]',
      },
    },
  },
})