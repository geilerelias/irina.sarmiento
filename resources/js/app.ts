import '../css/app.css';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createPinia } from 'pinia';
import type { DefineComponent } from 'vue';
import { createApp, h } from 'vue';
import { initializeTheme } from './composables/useAppearance';

import { library } from '@fortawesome/fontawesome-svg-core';

import {
    faFacebookF,
    faGithub,
    faInstagram,
    faLinkedinIn,
} from '@fortawesome/free-brands-svg-icons';

import {
    faAngleRight,
    faArrowRight,
    faBars,
    faBolt,
    faBullseye,
    faCheck,
    faEnvelope,
    faEye,
    faGlobeAmericas,
    faHandshake,
    faLeaf,
    faLightbulb,
    faMapMarkerAlt,
    faNetworkWired,
    faPhone,
    faSolarPanel,
    faUser,
    faUsers,
    faUserShield,
} from '@fortawesome/free-solid-svg-icons';

import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

library.add(
    faUser,
    faPhone,
    faBars,
    faBolt,
    faUserShield,
    faNetworkWired,
    faAngleRight,
    faMapMarkerAlt,
    faEnvelope,
    faFacebookF,
    faLinkedinIn,
    faInstagram,
    faArrowRight,
    faGithub,
    faSolarPanel,
    faGlobeAmericas,
    faUsers,
    faBullseye,
    faEye,
    faLeaf,
    faLightbulb,
    faHandshake,
    faCheck,
);

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => (title ? `${title} - ${appName}` : appName),
    resolve: (name) =>
        resolvePageComponent(
            `./pages/${name}.vue`,
            import.meta.glob<DefineComponent>('./pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(createPinia())
            .component('font-awesome-icon', FontAwesomeIcon)
            .mount(el);
    },
    progress: {
        color: '#8b6f47',
        showSpinner: true,
    },
});

// This will set light / dark mode on page load...
initializeTheme();
