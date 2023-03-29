import './bootstrap';
import '../css/app.postcss';

import { createInertiaApp } from '@inertiajs/svelte';

// layouts
import AppLayout from './Layouts/AppLayout.svelte'
import DashboardLayout from './Layouts/DashboardLayout.svelte'

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title: string | null) => `${title || ''} - ${appName}`,
    resolve: (name: string) => {
        const pages = import.meta.glob('./Pages/**/*.svelte', { eager: true })
        let page = pages[`./Pages/${name}.svelte`]
        return { default: page.default, layout: name.startsWith('Dashboard/') ? DashboardLayout : AppLayout }
    },
    // resolve: (name: string) => resolvePageComponent(`./Pages/${name}.svelte`, import.meta.glob('./Pages/**/*.svelte')),
    setup({ el, App, props }) {
        new App({ target: el, props })
    },
    progress: {
        color: '#da532c',
    },
});
