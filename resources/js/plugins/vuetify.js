// src/plugins/vuetify.js
import '@mdi/font/css/materialdesignicons.css'
import Vue from 'vue'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'

Vue.use(Vuetify);

export default new Vuetify({
    icons: {
        iconfont: 'mdi',
    },
    theme: {
        themes: {
            light: {
                primary: '#0199c0',
                secondary: '#000f46',
                accent: '#8c9eff',
                error: '#b71c1c',
            },
        },
    },
});