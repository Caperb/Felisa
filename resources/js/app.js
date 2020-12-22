require('./bootstrap');

require('moment');

import Vue from 'vue';

// import { createMollieClient } from '@mollie/api-client';
import { InertiaApp } from '@inertiajs/inertia-vue';
import { InertiaForm } from 'laravel-jetstream';
import PortalVue from 'portal-vue';
import { MdField } from 'vue-material/dist/components';
import { MdContent } from 'vue-material/dist/components';
import { MdButton } from 'vue-material/dist/components';
import { MdLayout } from 'vue-material/dist/components';
import { MdToolbar } from 'vue-material/dist/components';
import 'vue-material/dist/vue-material.min.css';
import 'vue-material/dist/theme/default.css';


Vue.use(MdField);
Vue.use(MdContent);
Vue.use(MdLayout);
Vue.use(MdToolbar);
Vue.use(MdButton);
Vue.mixin({ methods: { route } });
Vue.use(InertiaApp);
Vue.use(InertiaForm);
Vue.use(PortalVue);

// const mollieClient = createMollieClient({ apiKey: 'test_zrAuBra5kqptednuRjc3zHHUuvdPH6' });
const app = document.getElementById('app');

new Vue({
    render: (h) =>
        h(InertiaApp, {
            props: {
                initialPage: JSON.parse(app.dataset.page),
                resolveComponent: (name) => require(`./Pages/${name}`).default,
            },
        }),
}).$mount(app);
