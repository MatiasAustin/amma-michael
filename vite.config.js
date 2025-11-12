// import { defineConfig } from 'vite';
// import laravel from 'laravel-vite-plugin';
// import tailwindcss from '@tailwindcss/vite';

// export default defineConfig({
//     plugins: [
//         laravel({
//             input: ['resources/css/app.css', 'resources/js/app.js'],
//             refresh: true,
//         }),
//         tailwindcss(),
//     ],
// });

import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'

const inGitpod = !!process.env.GITPOD_WORKSPACE_URL
// Contoh: https://psychic-train-abc123.ws-eu89.gitpod.io
const workspaceHost = inGitpod
  ? process.env.GITPOD_WORKSPACE_URL.replace('https://', '').split('/')[0]
  : 'localhost'

const port = Number(process.env.VITE_PORT ?? 5173)

export default defineConfig({
  server: {
    host: true,          // 0.0.0.0
    port,
    strictPort: true,
    hmr: inGitpod
      ? {
          host: `${port}-${workspaceHost}`, // 5173-<workspace>.gitpod.io
          protocol: 'wss',
          clientPort: 443,
        }
      : true,
  },
  plugins: [
    laravel({
      input: ['resources/css/app.css', 'resources/js/app.js'],
      refresh: true,
    }),
  ],
})
