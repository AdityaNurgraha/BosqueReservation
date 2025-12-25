import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
   /* server: {
        host: '0.0.0.0',
        port: 8080,
        strictPort: true,
        hmr: {
            host: '192.168.1.7',
            port: 8080,
        },
    },*/
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});