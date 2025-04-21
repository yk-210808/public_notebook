import { defineConfig } from "vite";
import autoprefixer from "autoprefixer";
import viteImagemin from 'vite-plugin-imagemin'; 
import { fileURLToPath } from 'node:url';
import { globSync } from 'glob';
import path, { resolve } from 'path';
import ViteSvgSpriteWrapper from 'vite-svg-sprite-wrapper';
import SVGSpriter from 'svg-sprite';

import liveReload from 'vite-plugin-live-reload';
import devManifest from "vite-plugin-dev-manifest";
const themeDistPath = path.resolve(__dirname, 'wp/wp-content/themes/my-theme/');


const htmlFiles = Object.fromEntries(
  globSync('src/**/*.html').map(file => [
    path.relative(
      'src',
      file.slice(0, file.length - path.extname(file).length)
    ),
    fileURLToPath(new URL(file, import.meta.url)),
  ])
);

const exclusionFiles = (assetInfo) => {
  if (assetInfo.name === 'sprite.svg') {
    return 'img/svg/sprite.svg';
  }else {
    // 通常は ext ごとにフォルダ分け
    const ext = assetInfo.name?.split('.').pop();
    return `${ext}/[name].[ext]`;
  }
}


export default defineConfig({
  root: 'src/',
  publicDir: '../static/',
  base: './',

  server: {
    port: 8888,
    watch: {
      usePolling: true,
    },
    hmr: {
      protocol: "ws",
      host: "localhost",
    },
  },
  build: {
    outDir: themeDistPath, // ビルド出力先をWordPressテーマへ
    emptyOutDir: false,
    sourcemap: false,
    manifest: true,
    rollupOptions: {
      input: {
        main: resolve(__dirname, "src/js/main.js"),
        style: resolve(__dirname, "src/scss/style.scss"),
      },
      output: {
        entryFileNames: `js/[name].js`,
        chunkFileNames: `js/[name].js`,
        assetFileNames: exclusionFiles,
      },
    },
  },
  css: {
    postcss: {
      plugins: [autoprefixer],
    },
  },
  plugins: [
    viteImagemin({
      gifsicle: {
        optimizationLevel: 7,
        interlaced: false,
      },
      optipng: {
        optimizationLevel: 7,
      },
      mozjpeg: {
        quality: 20,
      },
      pngquant: {
        quality: [0.8, 0.9],
        speed: 4,
      },
      svgo: {
        plugins: [
          {
            name: 'removeViewBox',
          },
          {
            name: 'removeEmptyAttrs',
            active: false,
          },
        ],
      },
    }),
    ViteSvgSpriteWrapper({
      icons: 'static/img/svg/*.svg',
      outputDir: themeDistPath +'/img/svg/',
      sprite: SVGSpriter.Config,
    }),
    liveReload([
      '../wp/wp-content/themes/my-theme/**/*.php', // パスはプロジェクトに合わせて
    ]),
    devManifest(),
  ],
})
