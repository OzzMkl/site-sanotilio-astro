// @ts-check
import { defineConfig } from "astro/config";

import tailwindcss from "@tailwindcss/vite";

import dotenv from "dotenv";
dotenv.config();

const port = process.env.PORT || 3000;
const host = process.env.HOST || "http://localhost";


// https://astro.build/config
export default defineConfig({
  site: `${host}:${port}`, //Solo funciona en build
  trailingSlash: "always", // agrega barra al final de las URLs
  vite: {
    plugins: [tailwindcss()],
  },
});
