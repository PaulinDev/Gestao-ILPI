import Vue from 'vue'
import Vuetify from 'vuetify'
import '@mdi/font/css/materialdesignicons.css'
import 'vuetify/dist/vuetify.min.css'
import VueMask from 'v-mask'
import pt from 'vuetify/lib/locale/pt'
import preset from './components/layouts/preset'

Vue.use(Vuetify);
Vue.use(VueMask);

export default new Vuetify({
    preset,
    icons: {
        iconfont: 'mdi',
    },
    lang: {
        locales: { pt },
        current: 'pt',
    },
    theme: {
        options: {
          customProperties: true,
          variations: false,
        },
      },
})
