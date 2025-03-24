import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/app.js',
                'resources/js/post.js',
                'resources/js/home.js',
                'resources/css/app.css',
                'resources/css/filament/dashboard/theme.css',
            ],
            refresh: true,
        }),
    ],
});
