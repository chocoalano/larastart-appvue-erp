<template>
  <v-container>
    <v-text-field
      v-model="form.name"
      label="Name"
      prepend-inner-icon="mdi-account"
    ></v-text-field>
    <div v-for="i in permissionitem" :key="i.id">
      <v-switch
        v-model="form.permission"
        inset
        :label="i.name.toUpperCase()"
        :value="i.id"
      ></v-switch>
    </div>
    <v-row justify="center">
      <v-col cols="8">
        <v-container class="max-width">
          <v-pagination
            v-model="page"
            class="my-4"
            :length="totalpage"
            circle
          ></v-pagination>
        </v-container>
      </v-col>
    </v-row>
  </v-container>
</template>
<script>
import { mapState, mapActions } from "vuex";
export default {
  data: () => ({
    page: 1,
    itemsPerPage: 10,
    totalpage: 0,
  }),
  computed: {
    ...mapState("roles", {
      form: (state) => state.form,
      permissionitem: (state) => state.permissionitem,
    }),
    form: {
      get: function () {
        return this.$store.state.roles.form;
      },
      set: function (value) {
        this.$store.commit("roles/SET_FORM", value);
      },
    },
    permissionitem: {
      get: function () {
        return this.$store.state.roles.permissionitem;
      },
      set: function (value) {
        this.$store.commit("roles/SET_PERMISSIONITEM", value);
      },
    },
  },
  watch: {
    page() {
      this.getpermission();
    },
  },
  created() {
    this.getpermission();
  },
  methods: {
    ...mapActions("roles", ["getpermissionitem"]),
    getpermission() {
      const options = {
        sortBy: '',
        sortDesc: '',
        page: this.page,
        itemsPerPage: this.itemsPerPage,
        totalpage: this.totalpage,
      };
      this.getpermissionitem(options).then((res) => {
        let perpage = parseInt(res.to);
        let total = parseInt(res.total);
        this.totalpage = Math.ceil(total / perpage);
      });
    },
  },
};
</script>