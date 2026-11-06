import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [laravel({
        input: ['resources/css/rialchi/app.css', 'resources/js/rialchi/app.js'],
        buildDirectory: 'build/rialchi',
        hotFile: 'storage/framework/rialchi.hot',
        refresh: ['resources/views/rialchi/**'],
    })],
});
