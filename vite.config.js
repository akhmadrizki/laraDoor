import { defineConfig, loadEnv } from "vite";
import laravel from "laravel-vite-plugin";

export default ({ mode }) => {
    process.env = { ...process.env, ...loadEnv(mode, process.cwd()) };

    const https = {
        key: process.env.VITE_DEV_SERVER_KEY,
        cert: process.env.VITE_DEV_SERVER_CERT,
    };

    return defineConfig({
        plugins: [
            laravel({
                input: ["resources/sass/app.scss", "resources/js/app.js"],
                refresh: true,
            }),
        ],
        server: {
            https: process.env.VITE_DEV_SERVER_KEY ? https : false,
            host: process.env.VITE_DEV_SERVER || "localhost",
        },
    });
};
