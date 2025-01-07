import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/app.js',
                'resources/scss/filament/dashboard/theme.scss'
            ],
            refresh: true,
        }),
    ],
});
