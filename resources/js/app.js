import Vue from 'vue'
import {FingerprintsPlugin} from 'vue-fingerprints'
import { mapGetters, mapActions } from "vuex";
import App from './components/App.vue'
import Vuetify from './plugins/vuetify'
import router from './core/core/router.js'
import store from './core/core/store.js'
// component/core
console.log(`Vue version : ${Vue.version}`);

Vue.use(FingerprintsPlugin)

new Vue({
    el: '#app',
    vuetify: Vuetify,
    router,
    store,
    components: { App },
    computed: {
        ...mapGetters(["isAuth"]),
    },
    watch: {
        isAuth(val) {
            if (val) {
                this.validationAuth(val);
            }
        },
    },
    created() {
        if (this.isAuth) {
            this.validationAuth(this.isAuth);
        }
    },
    methods: {
        ...mapActions("auth", ["getUserLogin"]),
        validationAuth(auth) {
            if (auth) {
                this.getUserLogin().then((e) => {
                    if (e != 200) {
                        localStorage.setItem("token", null);
                        this.$store.commit("SET_TOKEN", null, { root: true });
                    }
                });
            } else {
                localStorage.setItem("token", null);
                this.$store.commit("SET_TOKEN", null, { root: true });
            }
        },
    },
});
