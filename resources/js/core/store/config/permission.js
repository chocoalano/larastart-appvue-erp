import $axios from '../../core/api.js'
const state = () => ({
    form: {
        name: "",
        permission: []
    },
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
}

const actions = {
    index({ }, payload) {
        return new Promise((resolve) => {
            $axios.get(`/permission?page=${payload.page}&sortBy=${payload.sortBy}&sortDesc=${payload.sortDesc}&itemsPerPage=${payload.itemsPerPage}`)
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
            $axios.post(`/permission`, state.form)
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
            $axios.get(`/permission/${payload}/edit`)
                .then((response) => {
                    const dataparse = response.data.response.name.split("-");
                    const form = {
                        name: dataparse[0],
                        permission: [dataparse[1]],
                    }
                    commit("SET_FORM", form)
                    resolve(response.data.response)
                })
                .catch((error) => {
                    // resolve(error.response.data);
                    console.log(error);
                })
        })
    },
    update({ commit, state },payload) {
        return new Promise((resolve) => {
            $axios.patch(`/permission/${payload}`, state.form)
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
            $axios.delete(`/permission/${payload}`)
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
