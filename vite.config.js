import { defineConfig, loadEnv } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig(({ mode }) => {
    // Carrega as variáveis de ambiente do ficheiro .env
    const env = loadEnv(mode, process.cwd(), '');

    return {
        plugins: [
            laravel({
                input: 'resources/js/app.js',
                refresh: true,
            }),
            vue({
                template: {
                    transformAssetUrls: {
                        base: null,
                        includeAbsolute: false,
                    },
                },
            }),
        ],
        server: {
            // Ouve em todas as interfaces de rede (0.0.0.0)
            host: '0.0.0.0',
            hmr: {
                // Força o cliente (o navegador do telemóvel) a conectar-se ao IP correto
                host: env.VITE_SERVER_IP || 'localhost',
            },
            watch: {
                usePolling: true,
            },
        },
    };
});
