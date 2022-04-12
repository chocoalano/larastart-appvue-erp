import $axios from '../../../core/api'
const state = () => ({
    form: {
        nama: "",
        inisial: ""
    },
    formattribute:[]
})

const mutations = {
    CLEAR_FORM(state, payload) {
        state.form = {
            akun_id: "",
            pos_saldo: "",
            group_akun: "",
            saldo_awal_debet: "",
            saldo_awal_kredit: "",
            group_arus_kas: "",
            group_laporan: "",
            ket_transaksi: "",
            akun_lawan: "",
            ket_akun: "",
            kode_bantu: "",
            ket_bantu: "",
        }
    },
    SET_FORM(state, payload) {
        state.form = {
            akun_id: payload.akun_id,
            pos_saldo: payload.pos_saldo,
            group_akun: payload.group_akun,
            saldo_awal_debet: payload.saldo_awal_debet,
            saldo_awal_kredit: payload.saldo_awal_kredit,
            group_arus_kas: payload.group_arus_kas,
            group_laporan: payload.group_laporan,
            ket_transaksi: payload.ket_transaksi,
            akun_lawan: payload.akun_lawan,
            ket_akun: payload.ket_akun,
            kode_bantu: payload.kode_bantu,
            ket_bantu: payload.ket_bantu,
        }
    },
    SET_ATTRIBUTE_FORM(state, payload) {
        state.formattribute = payload
    },
}

const actions = {
    index({ }, payload) {
        return new Promise((resolve) => {
            $axios.get(`/akuntansi-data?page=${payload.page}&sortBy=${payload.sortBy}&sortDesc=${payload.sortDesc}&itemsPerPage=${payload.itemsPerPage}`)
                .then((response) => {
                    resolve(response.data.response)
                })
                .catch((error) => {
                    resolve(error.response.data);
                })
        })
    },
    create({ commit }) {
        return new Promise((resolve) => {
            $axios.get(`/akuntansi-data/create`)
                .then((response) => {
                    commit("SET_ATTRIBUTE_FORM",response.data.response)
                    resolve(response.data.response)
                })
                .catch((error) => {
                    resolve(error.response.data);
                })
        })
    },
    store({ commit, state }) {
        return new Promise((resolve) => {
            $axios.post(`/akuntansi-data`, state.form)
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
            $axios.get(`/akuntansi-data/${payload}/edit`)
                .then((response) => {
                    var res = response.data.response[0];
                    const form ={
                        akun_id: res.akun_id,
                        pos_saldo: res.pos_saldo,
                        group_akun: res.group_akun,
                        saldo_awal_debet: res.saldo_awal_debet,
                        saldo_awal_kredit: res.saldo_awal_kredit,
                        group_arus_kas: res.group_arus_kas,
                        group_laporan: res.group_laporan,
                        ket_transaksi: res.ket_transaksi,
                        akun_lawan: res.akun_lawan,
                        ket_akun: res.ket_akun,
                        kode_bantu: res.kode_bantu,
                        ket_bantu: res.ket_bantu,
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
            $axios.patch(`/akuntansi-data/${payload}`, state.form)
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
            $axios.delete(`/akuntansi-data/${payload}`)
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
