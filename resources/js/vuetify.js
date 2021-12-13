import Vue from 'vue'
import Vuetify from 'vuetify'
import '@mdi/font/css/materialdesignicons.css'
import 'vuetify/dist/vuetify.min.css'
import VueMask from 'v-mask'
import pt from 'vuetify/lib/locale/pt'

Vue.use(Vuetify);
Vue.use(VueMask);

export default new Vuetify({
    theme: {
        themes: {
            light: {
                primary: '#7367F0',
                secondary: '#696969',
                accent: '#8c9eff',
                error: '#b71c1c',
                success: '#28a745'
            },
        },
        dark: true
    },
    icons: {
        iconfont: 'mdi',
    },
    lang: {
        locales: { pt },
        current: 'pt',
    },
})
