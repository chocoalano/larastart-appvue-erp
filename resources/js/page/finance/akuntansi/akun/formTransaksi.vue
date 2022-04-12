<template>
  <v-container>
    <v-row>
      <v-col cols="12" sm="6" md="2">
        <v-select
          v-model="form.akun_id"
          :items="formattribute.akun"
          item-text="nama"
          item-value="id"
          label="Pilih Akun"
        ></v-select>
      </v-col>
      <v-col cols="12" sm="6" md="2">
        <v-select
          v-model="form.pos_saldo"
          :items="formattribute.pos_saldo"
          label="POS Saldo"
        ></v-select>
      </v-col>
      <v-col cols="12" sm="6" md="2">
        <v-select
          v-model="form.group_akun"
          :items="formattribute.group_akun"
          label="Group Akun"
        ></v-select>
      </v-col>
      <v-col cols="12" sm="6" md="2">
        <v-text-field
          label="Saldo Awal Debet"
          v-model="form.saldo_awal_debet"
        ></v-text-field>
      </v-col>
      <v-col cols="12" sm="6" md="2">
        <v-text-field
          label="Saldo Awal Kredit"
          v-model="form.saldo_awal_kredit"
        ></v-text-field>
      </v-col>
      <v-col cols="12" sm="6" md="2">
        <v-select
          v-model="form.group_arus_kas"
          :items="formattribute.group_arus_kas"
          label="Group Arus KAS"
        ></v-select>
      </v-col>
      <v-col cols="12" sm="6" md="2">
        <v-select
          v-model="form.group_laporan"
          :items="formattribute.group_laporan"
          label="Group Laporan"
        ></v-select>
      </v-col>
      <v-col cols="12" sm="6" md="3">
        <v-select
          v-model="form.akun_lawan"
          :items="formattribute.akun"
          item-text="nama"
          item-value="id"
          label="Pilih Akun Lawan"
          @change="getKetAkunLawan(form.akun_lawan)"
        ></v-select>
      </v-col>
      <v-col cols="12" sm="6" md="2">
        <v-text-field
          label="Ket. Akun"
          disabled
          v-model="form.ket_akun"
        ></v-text-field>
      </v-col>
      <v-col cols="12" sm="6" md="3">
        <v-select
          v-model="form.kode_bantu"
          :items="formattribute.buku_bantu"
          item-text="piutang_usaha"
          item-value="id"
          label="Pilih Kode Bantu"
          @change="getKetbantu(form.kode_bantu)"
        ></v-select>
      </v-col>
      <v-col cols="12" sm="6" md="2">
        <v-text-field
          label="Ket. Bantu"
          disabled
          v-model="form.ket_bantu"
        ></v-text-field>
      </v-col>
      <v-col cols="12" sm="6" md="12">
        <v-textarea
          name="ket_transaksi"
          v-model="form.ket_transaksi"
          label="Ket. Transaksi"
        ></v-textarea>
      </v-col>
    </v-row>
  </v-container>
</template>
<script>
import { mapState, mapActions } from "vuex";
export default {
  computed: {
    ...mapState("akuntansiakuntransaksi", {
      form: (state) => state.form,
      formattribute: (state) => state.formattribute,
    }),
    form: {
      get: function () {
        return this.$store.state.akuntansiakuntransaksi.form;
      },
      set: function (value) {
        this.$store.commit("akuntansiakuntransaksi/SET_FORM", value);
      },
    },
    formattribute: {
      get: function () {
        return this.$store.state.akuntansiakuntransaksi.formattribute;
      },
      set: function (value) {
        this.$store.commit("akuntansiakuntransaksi/SET_ATTRIBUTE_FORM", value);
      },
    },
  },
  created() {
    this.create();
  },
  methods: {
    ...mapActions("akuntansiakuntransaksi", ["create"]),
    getKetAkunLawan(e) {
      var users = this.formattribute.akun;
      var filter = {
        id: e
      };
      users= users.filter(function(item) {
        for (var key in filter) {
          if (item[key] === undefined || item[key] != filter[key])
            return false;
        }
        return true;
      });
      this.form.ket_akun=users[0].nama
    },
    getKetbantu(e) {
      var users = this.formattribute.buku_bantu;
      var filter = {
        id: e
      };
      users= users.filter(function(item) {
        for (var key in filter) {
          if (item[key] === undefined || item[key] != filter[key])
            return false;
        }
        return true;
      });
      this.form.ket_bantu=users[0].piutang_usaha
    },
  },
};
</script>