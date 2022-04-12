import $axios from '../core/api.js'

const state = () => ({
    formlogin: {
        email: '',
        password: ''
    },
    authenticated: [],
})

const mutations = {
    ASSIGN_USER_AUTH(state, payload) {
        state.authenticated = payload
    },
    ASSIGN_FORM(state, payload) {
        state.formlogin = {
            email: payload.email,
            password: payload.password
        }
    },
    CLEAR_FORM(state) {
        state.formlogin = {
            email: '',
            password: ''
        }
    },
    SET_ALERT(state, payload) {
        state.alert = payload
    },
}

const actions = {
    submit({ commit, state }) {
        localStorage.setItem('token', null)
        commit('SET_TOKEN', null, { root: true })
        return new Promise((resolve) => {
            $axios.post('/login', state.formlogin)
                .then((response) => {
                    localStorage.setItem('token', response.data.response)
                    commit('SET_TOKEN', response.data, { root: true })
                    resolve(response)
                    commit('CLEAR_FORM')
                })
                .catch((error) => {
                    resolve(error.response);
                })
        })
    },
    getUserLogin({ commit }) {
        return new Promise((resolve, reject) => {
            $axios.get(`auth`)
                .then((response) => {
                    const data={
                        name:response.data.response.user.name,
                        email:response.data.response.user.email,
                        rolename:response.data.response.user.roles[0].name,
                        permission:response.data.response.permission,
                    }
                    commit('ASSIGN_USER_AUTH', data)
                    resolve(response.status)
                })
                .catch((error) => {
                    resolve(error.response)
                })
        })
    },
    logout({ commit }) {
        return new Promise((resolve, reject) => {
            $axios.post(`logout`)
                .then((response) => {
                    localStorage.setItem('token', null)
                    commit('SET_TOKEN', null, { root: true })
                    resolve(response.status)
                })
                .catch((error) => {
                    console.log(error.response)
                })
        })
    },
}

export default {
    namespaced: true,
    state,
    actions,
    mutations
}
