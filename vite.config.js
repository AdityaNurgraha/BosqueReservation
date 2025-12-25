import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
            // pastikan dev server URL tidak aktif
            devServer: {
                https: true,
            }
        }),
    ],
    base: '/build/', // relative path → otomatis HTTPS
});
