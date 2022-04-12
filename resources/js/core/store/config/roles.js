import $axios from '../../core/api.js'
const state = () => ({
    form: {
        name: "",
        permission: []
    },
    permissionitem: []
})

const mutations = {
    CLEAR_FORM(state, payload) {
        state.form = {
            name: "",
        permission: []
        }
    },
    SET_FORM(state, payload) {
        state.form = {
            name: payload.name,
            permission: payload.permission,
        }
    },
    SET_PERMISSIONITEM(state, payload) {
        state.permissionitem = payload
    },
}

const actions = {
    getpermissionitem({ commit },payload) {
        return new Promise((resolve) => {
            $axios.get(`/get-permission-item?page=${payload.page}&sortBy=${payload.sortBy}&sortDesc=${payload.sortDesc}&itemsPerPage=${payload.itemsPerPage}`)
                .then((response) => {
                    commit('SET_PERMISSIONITEM', response.data.response.data)
                    resolve(response.data.response)
                })
                .catch((error) => {
                    resolve(error.response.data);
                })
        })
    },
    index({ }, payload) {
        return new Promise((resolve) => {
            $axios.get(`/role?page=${payload.page}&sortBy=${payload.sortBy}&sortDesc=${payload.sortDesc}&itemsPerPage=${payload.itemsPerPage}`)
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
            $axios.post(`/role`, state.form)
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
            $axios.get(`/role/${payload}/edit`)
                .then((response) => {
                    const form = {
                        name: response.data.response[0].name,
                        permission: response.data.response[1],
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
            $axios.patch(`/role/${payload}`, state.form)
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
            $axios.delete(`/role/${payload}`)
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
