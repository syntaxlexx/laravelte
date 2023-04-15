import './bootstrap';
import './../css/app.css';

import { createInertiaApp } from '@inertiajs/svelte';

// layouts
import AppLayout from './Layouts/AppLayout.svelte'
import DashboardLayout from './Layouts/DashboardLayout.svelte'
import AdminDashboardLayout from './Layouts/AdminDashboardLayout.svelte'

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title: string | null) => `${title || ''} - ${appName}`,
    resolve: (name: string) => {
        console.log("name", name);
        // set eager loading to true to get one js file. NB: Must be Enabled if Svelte
        const pages = import.meta.glob('./Pages/**/*.svelte', { eager: true })
        let page = pages[`./Pages/${name}.svelte`]
        let layout = name.startsWith('User/')
            ? DashboardLayout
            : name.startsWith('Admin/')
                ? AdminDashboardLayout
                : AppLayout;
        // return { default: page.default, layout: page.layout }
        return { default: page.default, layout, }
    },
    // resolve: (name: string) => resolvePageComponent(`./Pages/${name}.svelte`, import.meta.glob('./Pages/**/*.svelte')),
    setup({ el, App, props }) {
        new App({ target: el, props })
    },
    progress: {
        color: '#da532c',
    },
});
