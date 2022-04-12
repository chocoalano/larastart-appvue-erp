import $axios from '../../../core/api'
const state = () => ({
    form: {
        nama: "",
        inisial: ""
    },
})

const mutations = {
    CLEAR_FORM(state, payload) {
        state.form = {
            nama: "",
            inisial: ""
        }
    },
    SET_FORM(state, payload) {
        state.form = {
            nama: payload.nama,
            inisial: payload.inisial
        }
    },
}

const actions = {
    index({ }, payload) {
        return new Promise((resolve) => {
            $axios.get(`/akuntansi?page=${payload.page}&sortBy=${payload.sortBy}&sortDesc=${payload.sortDesc}&itemsPerPage=${payload.itemsPerPage}`)
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
            $axios.post(`/akuntansi`, state.form)
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
            $axios.get(`/akuntansi/${payload}/edit`)
                .then((response) => {
                    const form = {
                        nama: response.data.response.nama,
                        inisial: response.data.response.inisial,
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
            $axios.patch(`/akuntansi/${payload}`, state.form)
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
            $axios.delete(`/akuntansi/${payload}`)
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
