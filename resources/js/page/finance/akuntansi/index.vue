<template>
  <v-container>
    <section>
      <v-breadcrumbs :items="breadcrumbs">
        <template v-slot:item="{ item }">
          <v-breadcrumbs-item :href="item.href" :disabled="item.disabled">
            {{ item.text.toUpperCase() }}
          </v-breadcrumbs-item>
        </template>
      </v-breadcrumbs>
    </section>

    <section>
      <v-card>
        <v-tabs-items v-model="tabappbar">
          <v-tab-item value="akun">
            <tab-akun :title="title(this.tabappbar)"></tab-akun>
            <v-divider></v-divider>
            <tab-akun-transaksi :title="title(this.tabappbar)"></tab-akun-transaksi>
          </v-tab-item>
          <v-tab-item value="jurnal">
            <v-container>
              <h1 v-text="title(this.tabappbar)"></h1>
            </v-container>
          </v-tab-item>
          <v-tab-item value="neraca lajur">
            <v-container>
              <h1 v-text="title(this.tabappbar)"></h1>
            </v-container>
          </v-tab-item>
          <v-tab-item value="neraca">
            <v-container>
              <h1 v-text="title(this.tabappbar)"></h1>
            </v-container>
          </v-tab-item>
          <v-tab-item value="aktifitas">
            <v-container>
              <h1 v-text="title(this.tabappbar)"></h1>
            </v-container>
          </v-tab-item>
          <v-tab-item value="arus kas">
            <v-container>
              <h1 v-text="title(this.tabappbar)"></h1>
            </v-container>
          </v-tab-item>
          <v-tab-item value="buku besar">
            <v-container>
              <h1 v-text="title(this.tabappbar)"></h1>
            </v-container>
          </v-tab-item>
          <v-tab-item value="buku bantu">
            <v-container>
              <h1 v-text="title(this.tabappbar)"></h1>
            </v-container>
          </v-tab-item>
          <v-tab-item value="buku besar bantu">
            <v-container>
              <h1 v-text="title(this.tabappbar)"></h1>
            </v-container>
          </v-tab-item>
          <v-tab-item value="asset">
            <v-container>
              <h1 v-text="title(this.tabappbar)"></h1>
            </v-container>
          </v-tab-item>
        </v-tabs-items>
      </v-card>
    </section>
  </v-container>
</template>
<script>
import { mapState } from "vuex";
import TabAkun from "./akun/data.vue";
import TabAkunTransaksi from "./akun/dataTransaksi.vue";
export default {
  components: {
    TabAkun,
    TabAkunTransaksi,
  },
  created() {
    this.$store.commit("SET_ROOTURL", this.$route.name, { root: true });
  },
  data() {
    return {
      breadcrumbs: [
        {
          text: "Dashboard",
          disabled: false,
          href: "/",
        },
        {
          text: "Finance",
          disabled: false,
          href: "/#",
        },
        {
          text: "Akuntansi",
          disabled: true,
          href: "/akunting",
        },
      ],
    };
  },
  computed: {
    ...mapState(["tabappbar"]),
    tabappbar: {
      get: function () {
        return this.$store.state.tabappbar;
      },
      set: function (value) {
        this.$store.commit("SET_TABAPPBAR", value, { root: true });
      },
    },
  },
  methods: {
    title(e) {
      if (e != null) {
        return e.replace(/\b\w/g, (l) => l.toUpperCase());
      } else {
        return e;
      }
    },
  },
};
</script>