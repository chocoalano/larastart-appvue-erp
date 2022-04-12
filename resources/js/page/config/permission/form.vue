<template>
  <v-container>
    <v-text-field
      v-model="form.name"
      label="Name"
      prepend-inner-icon="mdi-account"
    ></v-text-field>
    <v-row>
      <v-col cols="12" md="6" v-for="i in permissionitem" :key="i">
        <v-checkbox
          v-model="form.permission"
          :label="i.toUpperCase()"
          :value="i.toLowerCase()"
          :prepend-icon="geticon(i)"
        >
        </v-checkbox>
      </v-col>
    </v-row>
  </v-container>
</template>
<script>
import { mapState } from "vuex";
export default {
  data: () => ({
    permissionitem: [
      "list",
      "create",
      "edit",
      "delete",
      "export",
      "import",
      "download",
      "print",
    ],
  }),
  computed: {
    ...mapState("permission", {
      form: (state) => state.form,
    }),
    form: {
      get: function () {
        return this.$store.state.permission.form;
      },
      set: function (value) {
        this.$store.commit("permission/SET_FORM", value);
      },
    },
  },
  methods: {
    geticon(i) {
      if (i === "list") {
        return 'mdi-playlist-check'
      } else if (i === "create") {
        return 'mdi-plus'
      } else if (i === "edit") {
        return 'mdi-pencil'
      } else if (i === "delete") {
        return 'mdi-delete'
      } else if (i === "export") {
        return 'mdi-file-export'
      } else if (i === "import") {
        return 'mdi-file-import'
      } else if (i === "download") {
        return 'mdi-cloud-download'
      } else if (i === "print") {
        return 'mdi-printer'
      }
    },
  },
};
</script>