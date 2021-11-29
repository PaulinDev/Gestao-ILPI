require('./bootstrap');

import Vue from 'vue'

import vuetify from './vuetify';

Vue.component('app-bar', require('./components/layouts/bar.vue').default);
Vue.component('app-navigation', require('./components/layouts/navigation.vue').default);
Vue.component('app-login', require('./components/auth/app-login.vue').default);


Vue.component('list-employee', require('./components/employee/list.vue').default);
Vue.component('new-employee', require('./components/employee/new.vue').default);
Vue.component('edit-employee', require('./components/employee/edit.vue').default);

const app = new Vue({
    el: '#app',
    vuetify,
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
