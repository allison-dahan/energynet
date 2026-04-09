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
        map: resolve(__dirname, "src/js/map.js"),
      },
      output: {
        entryFileNames: "assets/[name].js",
        assetFileNames: (assetInfo) => {
          const names = assetInfo.names ?? [];
          if (names.some(n => n.endsWith(".css"))) {
            if (names.some(n => n === "maptiler-sdk.css")) return "assets/map.css";
            return "assets/style.css";
          }
          return "assets/[name].[ext]";
        },
      },
    },
  },
});