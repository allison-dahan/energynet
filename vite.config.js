import { defineConfig } from "vite";
import { resolve } from "path";

export default defineConfig({
  base: "./",
  build: {
    outDir: "dist",
    emptyOutDir: true,
    rollupOptions: {
      input: {
        main: resolve(__dirname, "src/js/main.js"),
        styles: resolve(__dirname, "src/scss/main.scss"),
      },
      output: {
        entryFileNames: "assets/[name].js",
        assetFileNames: (assetInfo) => {
          if (assetInfo.name && assetInfo.name.endsWith(".css")) return "assets/style.css";
          return "assets/[name].[ext]";
        },
      },
    },
  },
});