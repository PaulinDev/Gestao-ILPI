require('./bootstrap');

import Vue from 'vue'

import vuetify from './vuetify';

Vue.component('app-login', require('./components/auth/app-login.vue').default);

const app = new Vue({
    el: '#app',
    vuetify
});
