import $axios from '../../core/api.js'
const state = () => ({
    form: {
        name: "",
        email: "",
        roles: "",
        password: "",
        c_password: "",
    },
    rolesitem: []
})

const mutations = {
    CLEAR_FORM(state, payload) {
        state.form = {
            name: '',
            email: '',
            roles: '',
            password: '',
            c_password: ''
        }
    },
    SET_FORM(state, payload) {
        state.form = {
            name: payload.name,
            email: payload.email,
            roles: payload.roles,
            password: payload.password,
            c_password: payload.c_password
        }
    },
    SET_ROLESITEM(state, payload) {
        state.rolesitem = payload
    },
}

const actions = {
    getrolesitem({ commit }) {
        return new Promise((resolve) => {
            $axios.get(`/get-roles-item`)
                .then((response) => {
                    commit('SET_ROLESITEM', response.data.response)
                    resolve(response.data.response)
                })
                .catch((error) => {
                    resolve(error.response.data);
                })
        })
    },
    index({ }, payload) {
        return new Promise((resolve) => {
            $axios.get(`/user?page=${payload.page}&sortBy=${payload.sortBy}&sortDesc=${payload.sortDesc}&itemsPerPage=${payload.itemsPerPage}`)
                .then((response) => {
                    resolve(response.data.response)
                })
                .catch((error) => {
                    resolve(error.response.data);
                })
        })
    },
    store({ commit, state }) {
        return new Promise((resolve) => {
            $axios.post(`/user`, state.form)
                .then((response) => {
                    commit("CLEAR_FORM")
                    resolve(response.data.response)
                })
                .catch((error) => {
                    resolve(error.response.data);
                })
        })
    },
    edit({ commit }, payload) {
        return new Promise((resolve) => {
            $axios.get(`/user/${payload}/edit`)
                .then((response) => {
                    const form = {
                        name: response.data.response[0].name,
                        email: response.data.response[0].email,
                        roles: response.data.response[0].roleid,
                        password: '',
                        c_password: ''
                    }
                    commit("SET_FORM", form)
                    resolve(response.data.response)
                })
                .catch((error) => {
                    resolve(error.response.data);
                })
        })
    },
    update({ commit, state },payload) {
        return new Promise((resolve) => {
            $axios.patch(`/user/${payload}`, state.form)
                .then((response) => {
                    commit("CLEAR_FORM")
                    resolve(response.data.response)
                })
                .catch((error) => {
                    resolve(error.response.data);
                })
        })
    },
    delete({  },payload) {
        return new Promise((resolve) => {
            $axios.delete(`/user/${payload}`)
                .then((response) => {
                    resolve(response.data.response)
                })
                .catch((error) => {
                    resolve(error.response.data);
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
