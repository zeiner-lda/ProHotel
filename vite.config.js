
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin'; // Importe usando ES Modules

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', // Seu arquivo CSS principal
                'resources/js/app.js',   // Seu arquivo JS principal
            ],
            refresh: true,
        }),
    ],
});
