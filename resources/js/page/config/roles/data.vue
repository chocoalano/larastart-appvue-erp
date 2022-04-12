<template>
  <v-data-table
    :headers="headers"
    :items="desserts"
    :options.sync="options"
    :server-items-length="totalDesserts"
    :loading="loading"
    class="elevation-1"
  >
    <template v-slot:top>
      <v-toolbar flat>
        <v-toolbar-title>Roles Managements</v-toolbar-title>
        <v-divider class="mx-4" inset vertical></v-divider>
        <v-spacer></v-spacer>
        <v-dialog v-model="dialog" max-width="500px">
          <template v-slot:activator="{ on, attrs }">
            <v-btn color="primary" dark class="mb-2" v-bind="attrs" v-on="on">
              New Item
            </v-btn>
          </template>
          <v-card>
            <v-card-title>
              <span class="text-h5">{{ formTitle }}</span>
            </v-card-title>

            <v-card-text>
              <form-data></form-data>
            </v-card-text>

            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="close"> Cancel </v-btn>
              <v-btn color="blue darken-1" text @click="save"> Save </v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
        <v-dialog v-model="dialogDelete" max-width="500px">
          <v-card>
            <v-card-title class="text-h5"
              >Are you sure you want to delete this item?</v-card-title
            >
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="closeDelete"
                >Cancel</v-btn
              >
              <v-btn color="blue darken-1" text @click="deleteItemConfirm"
                >OK</v-btn
              >
              <v-spacer></v-spacer>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-toolbar>
    </template>
    <template v-slot:[`item.actions`]="{ item }">
      <v-icon small class="mr-2" @click="editItem(item.id)"> mdi-pencil </v-icon>
      <v-icon small @click="deleteItem(item.id)"> mdi-delete </v-icon>
    </template>
  </v-data-table>
</template>
<script>
import { mapActions  } from "vuex";
import FormData from "./form";
export default {
  components:{
    FormData
  },
  data: () => ({
    dialog: false,
    dialogDelete: false,
    totalDesserts: 0,
    desserts: [],
    loading: true,
    options: {},
    headers: [
      { text: "Name", value: "name"},
      { text: "Guard Name", value: "guard_name" },
      { text: 'Actions', value: 'actions', sortable: false },
    ],
    editedIndex: 0,
  }),

  computed: {
    formTitle() {
      return this.editedIndex === 0 ? "New Data" : "Edit Data";
    },
  },

  watch: {
    dialog(val) {
      val || this.close();
    },
    dialogDelete(val) {
      val || this.closeDelete();
    },
    options: {
      handler() {
        this.getDataFromApi();
      },
      deep: true,
    },
  },

  methods: {
    ...mapActions("roles", ["index", "store", "edit", "update","delete"]),
    getDataFromApi() {
      this.loading = true;
      const { sortBy, sortDesc, page, itemsPerPage } = this.options
      this.index(this.options).then((data) => {
        this.desserts = data.data;
        this.totalDesserts = data.total;
        this.loading = false;
      });
    },

    editItem(item) {
      this.editedIndex = item;
      this.edit(item)
      this.dialog = true;
    },

    deleteItem(item) {
      this.editedIndex = item;
      this.dialogDelete = true;
    },

    deleteItemConfirm() {
      this.delete(this.editedIndex).then((res)=>{
        this.getDataFromApi();
      })
      this.closeDelete();
    },

    close() {
      this.dialog = false;
      this.$nextTick(() => {
        this.$store.commit("roles/CLEAR_FORM");
        this.editedIndex = 0;
      });
    },

    closeDelete() {
      this.dialogDelete = false;
      this.$nextTick(() => {
        this.editedIndex = 0;
      });
    },

    save() {
      console.log(this.editedIndex);
      if (this.editedIndex > 0) {
        this.update(this.editedIndex).then((res)=>{
          this.getDataFromApi();
        })
      } else {
        this.store().then((res)=>{
          this.getDataFromApi();
        })
      }
      this.close();
    },
  },
};
</script>