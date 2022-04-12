<template>
  <v-app id="inspire">
    <v-container fluid fill-height>
      <v-layout align-center justify-center>
        <v-flex xs12 sm8 md4>
          <v-card>
            <v-card-title class="d-flex justify-center">
              PAGE NOT FOUND
            </v-card-title>
            <v-card-text class="d-flex justify-center">
              <h1>404</h1>
            </v-card-text>
            <v-card-actions class="d-flex justify-center">
              <v-btn color="primary" class="mb-5" large to="/">
                <v-icon>mdi-login</v-icon>
                Back to home
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-flex>
      </v-layout>
    </v-container>
  </v-app>
</template>

<script>
export default {
  created() {
    this.$store.commit("SET_ROOTURL", this.$route.name, { root: true });
  },
};
</script>

<style></style>