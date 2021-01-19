require('./bootstrap');

import Vue from 'vue';

import { InertiaApp } from '@inertiajs/inertia-vue';
import { InertiaForm } from 'laravel-jetstream';
import PortalVue from 'portal-vue';
import VueSignaturePad from 'vue-signature-pad';
// import { MdButton, MdIcon, MdCard, MdLayout, MdDatepicker, MdList, MdField, MdSwitch, MdRipple, MdTable, MdContent, MdDialog, MdToolbar, MdSteppers, MdMenu, MdCheckbox, MdTooltip, MdSpeedDial, MdSelect } from 'vue-material/dist/components';
import VueMaterial from 'vue-material'
import 'vue-material/dist/vue-material.min.css';
import 'vue-material/dist/theme/default.css';

Vue.mixin({ methods: { route } });
Vue.use(InertiaApp);
Vue.use(InertiaForm);
Vue.use(PortalVue);
Vue.use(VueSignaturePad);
Vue.use(VueMaterial);
// Vue.use(MdButton, MdIcon, MdCard, MdLayout, MdDatepicker, MdList, MdField, MdSwitch, MdRipple, MdTable, MdContent, MdDialog, MdToolbar, MdSteppers, MdMenu, MdCheckbox, MdTooltip, MdSpeedDial, MdSelect)


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
