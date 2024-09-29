import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import envCompatible from 'vite-plugin-env-compatible';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/materialize.js',
                'resources/css/materialize.css',
                'resources/css/style.css',
                'resources/js/init.js',
                'resources/js/app.js'
            ],
            refresh: true,
        }),
        envCompatible(),
    ],
});
