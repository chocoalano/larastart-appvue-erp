<template>
  <v-app id="inspire">
    <app-bar v-if="isAuth"></app-bar>
    <v-main>
      <router-view />
    </v-main>
  </v-app>
</template>

<script>
import { mapGetters } from "vuex";
import AppBar from "./AppBar";
export default {
  components: {
    AppBar,
  },
  computed: {
    ...mapGetters(["isAuth"]),
  },
};
</script>