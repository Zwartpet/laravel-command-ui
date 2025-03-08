import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            buildDirectory: 'vendor/command-ui',
            input: ['resources/css/command-ui.css'],
            refresh: true,
        }),
        tailwindcss(),
    ],
});