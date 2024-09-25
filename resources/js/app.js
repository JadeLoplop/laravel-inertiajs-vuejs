import './bootstrap'; // This is for Laravel Echo and Axios setup
import 'bootstrap/dist/css/bootstrap.min.css'; // This is for Bootstrap styles
import 'bootstrap'; // This is for Bootstrap's JavaScript functionality
import { ZiggyVue } from '../../vendor/tightenco/ziggy';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';

createInertiaApp({
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .mount(el)
    },
});
