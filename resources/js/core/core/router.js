import Vue from 'vue'
import Router from 'vue-router'
import IndexPage from '../../page/index.vue'
import LoinPage from '../../page/auth/index.vue'
import PageNotFound from '../../page/404.vue'
import config from '../../page/config/index.vue'
import akuntansi from '../../page/finance/akuntansi/index.vue'


import store from './store.js'
Vue.use(Router)
const router = new Router({
    mode: 'history',
    routes: [
        {
            path: '/auth',
            name: 'login',
            component: LoinPage
        },
        {
            path: '/',
            name: 'index',
            component: IndexPage,
            meta: {
                requiresAuth: true,
                title: 'Home'
            }
        },
        {
            path: '/config',
            name: 'config',
            component: config,
            meta: {
                requiresAuth: true,
                title: 'Configuration Management'
            }
        },
        {
            path: '/akunting',
            name: 'akuntansi',
            component: akuntansi,
            meta: {
                requiresAuth: true,
                title: 'Management Akuntansi'
            }
        },
        { path: "*", component: PageNotFound }
    ]
});
router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        store.commit('CLEAR_ERRORS')
        let auth = store.getters.isAuth
        if (!auth) {
            next({ name: 'login' })
        } else {
            next()
        }
    } else {
        next()
    }
})
export default router
