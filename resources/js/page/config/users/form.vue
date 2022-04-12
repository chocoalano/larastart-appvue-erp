<template>
  <v-container>
    <v-text-field
      v-model="form.name"
      label="Name"
      prepend-inner-icon="mdi-account"
    ></v-text-field>
    <v-text-field
      v-model="form.email"
      label="Email"
      prepend-inner-icon="mdi-at"
    ></v-text-field>
    <v-select
      :items="rolesitem"
      v-model="form.roles"
      item-text="name"
      item-value="id"
      label="Roles"
      prepend-inner-icon="mdi-account-group"
    ></v-select>
    <v-text-field
      v-model="form.password"
      label="Password"
      type="password"
      prepend-inner-icon="mdi-shield-key"
    ></v-text-field>
    <v-text-field
      v-model="form.c_password"
      label="Confirm Password"
      type="password"
      prepend-inner-icon="mdi-shield-key-outline"
    ></v-text-field>
  </v-container>
</template>
<script>
import { mapState, mapActions  } from "vuex";
export default {
  computed: {
    ...mapState("users", {
      form: (state) => state.form,
      rolesitem: (state) => state.rolesitem,
    }),
    form: {
      get: function () {
        return this.$store.state.users.form;
      },
      set: function (value) {
        this.$store.commit("users/SET_FORM", value);
      },
    },
    rolesitem: {
      get: function () {
        return this.$store.state.users.rolesitem;
      },
      set: function (value) {
        this.$store.commit("users/SET_ROLESITEM", value);
      },
    },
  },
  created(){
      this.getrolesitem()
  },
  methods: {
    ...mapActions("users", ["getrolesitem"]),
  },
};
</script>