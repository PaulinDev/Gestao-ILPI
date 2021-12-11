require('./bootstrap');

import Vue from 'vue'

import vuetify from './vuetify';

Vue.component('app-bar', require('./components/layouts/bar.vue').default);
Vue.component('app-navigation', require('./components/layouts/navigation.vue').default);
Vue.component('app-login', require('./components/auth/app-login.vue').default);


Vue.component('list-employee', require('./components/employee/list.vue').default);
Vue.component('new-employee', require('./components/employee/new.vue').default);
Vue.component('edit-employee', require('./components/employee/edit.vue').default);

Vue.component('list-patient', require('./components/patients/list.vue').default);
Vue.component('new-patient', require('./components/patients/new.vue').default);
Vue.component('edit-patient', require('./components/patients/edit.vue').default);
Vue.component('view-patient', require('./components/patients/view-patient.vue').default);
Vue.component('patient-info', require('./components/patients/patient-info.vue').default);
Vue.component('patient-additional-info', require('./components/patients/patient-additional-info.vue').default);

Vue.component('patient-inventory-new', require('./components/patients/inventory/new.vue').default);
Vue.component('patient-inventory-edit', require('./components/patients/inventory/edit.vue').default);

const app = new Vue({
    el: '#app',
    vuetify,
    data() {
        return {
            themeDark: false
        }
    },
    methods: {
        token() {
            let token = document.cookie.split(';').find(index => {
                return index.startsWith('token=')
            });

            token = token.split('=')[1];
            token = 'Bearer ' + token;

            return token;
        }
    },
});
