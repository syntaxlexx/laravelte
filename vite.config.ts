import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { svelte } from '@sveltejs/vite-plugin-svelte'
import path from 'path'

export default defineConfig({
    plugins: [
        laravel.default({
            input: 'resources/ts/app.ts',
            refresh: true,
        }),
        svelte()
    ],
    resolve: {
        alias: {
            '@': path.resolve(__dirname, './resources/ts')
        },
    },
});
