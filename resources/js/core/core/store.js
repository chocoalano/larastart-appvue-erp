import Vue from 'vue'
import Vuex from 'vuex'

// store module
import auth from '../store/auth'
import config from '../store/config/index'
import users from '../store/config/users'
import roles from '../store/config/roles'
import permission from '../store/config/permission'
import akuntansi from '../store/finance/akuntansi/index'
import akuntansiakun from '../store/finance/akuntansi/akun'
import akuntansiakuntransaksi from '../store/finance/akuntansi/akunTransaksi'
// store module
Vue.use(Vuex)
const store = new Vuex.Store({
    modules: {
        auth,
        config,
        users,
        roles,
        permission,
        akuntansi,
        akuntansiakun,
        akuntansiakuntransaksi,
    },
    state: {
        token: localStorage.getItem('token'),
        baseUrl: process.env.NODE_ENV ==
            'production' ?
            window.location.protocol + '//' + window.location.hostname :
            window.location.protocol + '//' + window.location.hostname + ':8000/',
        errors: [],
        itemsmenu: [
            { text: "Dashboard", icon: "mdi-apps", to: "/", child:false, childitems:[] },
            { text: "Configuration", icon: "mdi-cogs", to: "/config", child:false, childitems:[] },
            { text: "Finance", icon: "mdi-finance", to: "#", child:true, childitems:[
                { text: "Akuntansi", icon: "mdi-calculator", to: "/akunting"},
                { text: "Faktur", icon: "mdi-receipt", to: "/faktur"},
                { text: "Pengeluaran", icon: "mdi-hand-coin-outline", to: "/pengeluaran"},
                { text: "Spreadsheet (BI)", icon: "mdi-google-spreadsheet ", to: "/spreadsheet"},
                { text: "Dokumen", icon: "mdi-file-sign", to: "/dokumen"},
                { text: "Pemasukan", icon: "mdi-clipboard-arrow-down", to: "/pemasukan"},
            ] },
            { text: "Sales", icon: "mdi-salesforce", to: "#", child:true, childitems:[
                { text: "CRM", icon: "mdi-account-group", to: "/crm"},
                { text: "Sales", icon: "mdi-salesforce", to: "/sales"},
                { text: "Point Of sale", icon: "mdi-point-of-sale", to: "/pos"},
                { text: "Berlangganan", icon: "mdi-playlist-check", to: "/berlangganan"},
                { text: "Sewa", icon: "mdi-key-chain", to: "/sewa"},
                { text: "Penghubung platform", icon: "mdi-connection", to: "/siteconnector"},
            ] },
            { text: "Website", icon: "mdi-web", to: "#", child:true, childitems:[
                { text: "eCommerce", icon: "mdi-cart", to: "/ecommerce"},
                { text: "Blogs", icon: "mdi-post", to: "/blogs"},
                { text: "Forum", icon: "mdi-forum", to: "/forum"},
                { text: "Live Chat", icon: "mdi-chat-processing", to: "/chat"},
                { text: "eLearning", icon: "mdi-chair-school", to: "/elearning"},
            ] },
            { text: "Inventory & MRP", icon: "mdi-office-building-cog", to: "#", child:true, childitems:[
                { text: "Inventori", icon: "mdi-abacus", to: "/inventori"},
                { text: "Manufaktur", icon: "mdi-toolbox", to: "/manufaktur"},
                { text: "Pembelian", icon: "mdi-cash-register", to: "/pembelian"},
                { text: "Pemeliharaan", icon: "mdi-wrench-clock", to: "/pemeliharaan"},
                { text: "Quality", icon: "mdi-quality-high", to: "/quality"},
            ] },
            { text: "Human Resource", icon: "mdi-human-capacity-decrease", to: "#", child:true, childitems:[
                { text: "Pekerja", icon: "mdi-account-box-multiple", to: "/pekerja"},
                { text: "Lowongan Pekerja", icon: "mdi-account-tie", to: "/lowongan"},
                { text: "Waktu istirahat", icon: "mdi-clipboard-text-clock", to: "/timing"},
                { text: "Penilaian", icon: "mdi-clipboard-check-multiple", to: "/penilaian"},
                { text: "Rujukan", icon: "mdi-human-queue", to: "/rujukan"},
                { text: "Armada", icon: "mdi-car", to: "/armada"},
            ] },
            { text: "Pemasaran", icon: "mdi-shopping", to: "#", child:true, childitems:[
                { text: "Pemasaran sosial", icon: "mdi-semantic-web", to: "/pemasaran-sosial"},
                { text: "Email Pemasaran", icon: "mdi-email-fast", to: "/pemasaran-email"},
                { text: "SMS Pemasaran", icon: "mdi-android-messages", to: "/pemasaran-sms"},
                { text: "Acara", icon: "mdi-calendar-clock", to: "/pemasaran-acara"},
                { text: "Otomasi Pemasaran", icon: "mdi-arrow-decision-auto", to: "/pemasaran-otomasi"},
                { text: "Survei", icon: "mdi-walk", to: "/pemasaran-survei"},
            ] },
            { text: "Pelayanan", icon: "mdi-face-agent", to: "#", child:true, childitems:[
                { text: "Proyek", icon: "mdi-checkbox-marked-circle-plus-outline ", to: "/pelayanan-proyek"},
                { text: "Lembar waktu", icon: "mdi-timeline-clock-outline ", to: "/pelayanan-timesheet"},
                { text: "Servis lapangan", icon: "mdi-map-clock-outline", to: "/pelayanan-lapangan"},
                { text: "Meja bantuan", icon: "mdi-timeline-help-outline", to: "/pelayanan-bantuan"},
                { text: "Perencanaan", icon: "mdi-lightbulb-on", to: "/pelayanan-perencanaan"},
                { text: "Janji temu", icon: "mdi-hand-clap", to: "/pelayanan-pertemuan"},
            ] },
            { text: "Produktifitas", icon: "mdi-human-greeting-proximity", to: "#", child:true, childitems:[
                { text: "Diskusi", icon: "mdi-account-voice", to: "/produktifitas-diskusi"},
                { text: "Persetujuan", icon: "mdi-draw", to: "/produktifitas-persetujuan"},
                { text: "IoT", icon: "mdi-radio-tower", to: "/produktifitas-iot"},
                { text: "VoIP", icon: "mdi-access-point", to: "/produktifitas-voip"},
            ] },
        ],
        rooturl:'',
        tabappbar:null,
    },
    getters: {
        isAuth: state => {
            return state.token != "null" && state.token != null
        }
    },
    mutations: {
        SET_ISAUTH(state, payload) {
            state.isAuth = payload
        },
        SET_ERRORS(state, payload) {
            state.errors = payload
        },
        CLEAR_ERRORS(state) {
            state.errors = []
        },
        SET_TOKEN(state, payload) {
            state.token = payload
        },
        SET_ROOTURL(state, payload) {
            state.rooturl = payload
        },
        SET_TABAPPBAR(state, payload) {
            state.tabappbar = payload
        },
    }
})
export default store