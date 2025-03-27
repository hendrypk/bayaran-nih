import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // 'resources/css/app.css',
                // 'resources/js/app.js',
                // 'resources/js/sb-admin-2.js',
                'resources/js/sb-admin-2.min.js',
                'resources/vendor/chart.js/Chart.min.js',

                'resources/vendor/fontawesome-free/css/all.min.css',
                'resources/css/sb-admin-2.css',
                'resources/css/sb-admin-2.min.css',
            ],
            refresh: true,
        }),
    ],
});
