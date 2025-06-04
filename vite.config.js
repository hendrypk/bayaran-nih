import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    // server: {
    //     host: 'hendry.id',
    //     port: 5173,
    //     strictPort: true,
    // },
    plugins: [
        laravel({
            input: [
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
