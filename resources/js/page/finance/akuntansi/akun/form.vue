<template>
  <v-container>
    <v-row>
      <v-col cols="12" sm="6" md="6">
        <v-text-field
          v-model="form.nama"
          label="Nama Akun"
        ></v-text-field>
      </v-col>
      <v-col cols="12" sm="6" md="6">
        <v-text-field
          v-model="form.inisial"
          label="Inisial Akun"
        ></v-text-field>
      </v-col>
    </v-row>
  </v-container>
</template>
<script>
import { mapState } from "vuex";
export default {
  computed: {
    ...mapState("akuntansiakun", {
      form: (state) => state.form,
    }),
    form: {
      get: function () {
        return this.$store.state.akuntansiakun.form;
      },
      set: function (value) {
        this.$store.commit("akuntansiakun/SET_FORM", value);
      },
    },
  },
};
</script>