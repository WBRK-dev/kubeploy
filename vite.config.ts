import inertia from '@inertiajs/vite';
import { wayfinder } from '@laravel/vite-plugin-wayfinder';
import { svelte } from '@sveltejs/vite-plugin-svelte';
import tailwindcss from '@tailwindcss/vite';
import laravel from 'laravel-vite-plugin';
import { defineConfig } from 'vite';

console.log(process.env.TRAEFIK_DOMAIN)

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.ts'],
            refresh: true,
        }),
        inertia(),
        tailwindcss(),
        svelte(),
        wayfinder({
            formVariants: true,
        }),
    ],
    server: {
        host: true,
        port: 5137,
        strictPort: true,
        origin: `https://vite.${process.env.TRAEFIK_DOMAIN}`,
        allowedHosts: [process.env.TRAEFIK_DOMAIN!],
        cors: {
            origin: /https?:\/\/([A-Za-z0-9\-\.]+)?(.+\.test)(?::\d+)?$/,
        }
    },
});
