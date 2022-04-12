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
          <v-tab-item value="users">
            <users-manage></users-manage>
          </v-tab-item>
          <v-tab-item value="roles">
            <roles-manage></roles-manage>
          </v-tab-item>
          <v-tab-item value="permissions">
            <permissions-manage></permissions-manage>
          </v-tab-item>
        </v-tabs-items>
      </v-card>
    </section>
  </v-container>
</template>
<script>
import { mapState } from "vuex";
import UsersManage from "./users/data.vue"
import RolesManage from "./roles/data.vue"
import PermissionsManage from "./permission/data.vue"
export default {
  created() {
    this.$store.commit("SET_ROOTURL", this.$route.name, { root: true });
  },
  components:{
    UsersManage,
    RolesManage,
    PermissionsManage,
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
          text: "Configuration",
          disabled: true,
          href: "/config",
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
    title() {
      if (this.tabappbar === "tab-piutang") {
        return "Manage Piutang";
      } else {
        return "Accounting Management";
      }
    },
  },
};
</script>