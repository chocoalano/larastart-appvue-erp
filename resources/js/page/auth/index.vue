<template>
  <v-app id="inspire" class="primary">
    <v-container fluid fill-height>
      <v-layout align-center justify-center>
        <v-flex xs12 sm8 md4>
          <v-card class="elevation-12">
            <v-card-title> Sign-in </v-card-title>
            <v-card-text>
              <v-form>
                <v-text-field
                  v-model="formlogin.email"
                  :error-messages="error.data.email"
                  prepend-inner-icon="mdi-account"
                  name="login"
                  label="Login"
                  type="text"
                  outlined
                  clearable
                  rounded
                ></v-text-field>
                <v-text-field
                  v-model="formlogin.password"
                  :error-messages="error.data.password"
                  prepend-inner-icon="mdi-key"
                  :append-icon="showpass ? 'mdi-eye' : 'mdi-eye-off'"
                  :type="showpass ? 'text' : 'password'"
                  name="password"
                  label="Password"
                  hint="At least 8 characters"
                  @click:append="showpass = !showpass"
                  outlined
                  clearable
                  rounded
                ></v-text-field>
              </v-form>
            </v-card-text>
            <v-card-text
              class="d-flex justify-center"
              v-if="error.status != null"
            >
              <v-alert
                dense
                outlined
                :type="error.status === 200 ? 'success' : 'error'"
              >
                <p v-if="error.status != 422" v-text="error.data"></p>
                <div v-else>
                  <p v-text="error.data.email"></p>
                  <p v-text="error.data.password"></p>
                </div>
              </v-alert>
            </v-card-text>
            <v-card-actions class="d-flex justify-center">
              <v-btn color="primary" class="mb-5" large @click="submitLogin">
                <v-icon>mdi-login</v-icon>
                Masuk
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-flex>
      </v-layout>
    </v-container>
  </v-app>
</template>

<script>
import { mapState, mapActions } from "vuex";
export default {
  data() {
    return {
      showpass: false,
      error: {
        data: [],
        status: null,
      },
    };
  },
  computed: {
    ...mapState("auth", {
      formlogin: (state) => state.formlogin,
    }),
  },
  methods: {
    ...mapActions("auth", ["submit"]),
    submitLogin() {
      this.submit().then((res) => {
        if (res.status != 200) {
          this.error.data = res.data.response;
          this.error.status = res.status;
        } else {
          this.error = { data: "seccess authenticated" };
          setTimeout(() => {
            this.error = [];
            this.$router.push({ name: "index" });
          }, 1000);
        }
      });
    },
  },
};
</script>

<style></style>