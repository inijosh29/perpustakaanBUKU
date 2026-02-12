import {
    defineConfig
} from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        host: '127.0.0.1', // jangan 0.0.0.0
        port: 5173,
        https: false,       // pastikan pakai HTTP
        cors: true,
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
