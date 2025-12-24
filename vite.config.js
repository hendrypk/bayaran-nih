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
            input: ['resources/css/app.css', 'resources/js/app.js'],

            refresh: true,
        }),
    ],
});
