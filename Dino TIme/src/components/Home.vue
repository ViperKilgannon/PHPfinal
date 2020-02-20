<template>
  <v-app id="inspire">
    <v-content>
      <v-container class="fill-height" fluid>
        <v-row align="center" justify="center">
          <v-col cols="12" sm="8" md="4">
            <v-card class="elevation-12">
              <v-toolbar color="primary" dark flat>
                <v-toolbar-title>Login</v-toolbar-title>
                <v-spacer />
              </v-toolbar>
              <v-card-text>
                <v-form>
                  <v-text-field v-model="username" label="Username" name="login" prepend-icon="mdi-account" type="text" required />

                  <v-text-field
                    v-model="password"
                    id="password"
                    label="Password"
                    name="password"
                    prepend-icon="mdi-lock"
                    type="password"
                    required
                  />
                </v-form>
              </v-card-text>
              <v-card-subtitle class="error--text ml-5">{{ error }}</v-card-subtitle>
              <v-card-actions>
                <v-spacer />
                <v-btn color="primary" @click="login()">Login</v-btn>
              </v-card-actions>
            </v-card>
          </v-col>
        </v-row>
      </v-container>
    </v-content>
  </v-app>
</template>

<script>
const server = "http://127.0.0.1/server/ajaxfile.php";
const axios = require('axios').default;

export default {
  props: {
    source: String
  },
   data: () => ({
    error: "",
    username: "",
    password: ""
   }),
 methods: {
   // todo add admin responce
    login() {
        let bodyFormData = new FormData();
        bodyFormData.set('action', "login");
        bodyFormData.set('UserName', this.username);
        bodyFormData.set('password', this.password);

        axios.post(server, bodyFormData)
        .then((res) => {
          console.log(res);
          if (res.data.success === true) {
          this.$root.CurrentUser = true
          } else {
            this.error = res.data.message;
          }
        })
        .catch((res) => {
          console.log(res);
          this.error = "Server Error";
        })
      }
    },
  }
</script>
