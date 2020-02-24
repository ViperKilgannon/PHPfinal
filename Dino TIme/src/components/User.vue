<template>
  <v-app id="inspire">
    <v-app-bar app color="indigo" dark>
      <v-toolbar-title class="ml-10">{{$root.CurrentUserName}}</v-toolbar-title>
       <v-spacer></v-spacer>
       <v-btn @click="logout()">Logout</v-btn>
    </v-app-bar>

    <v-content>
      <v-container class="fill-height" fluid>

      </v-container>
    </v-content>
    <v-footer color="indigo" app>
      <span class="white--text">&copy; 2020</span>
    </v-footer>
  </v-app>
</template>

<script>
const server = "http://127.0.0.1/server/ajaxfile.php";
const axios = require('axios').default;

export default {
  props: {
    //
  },
  data: () => ({
    //
  }),
  methods: {
    logout() {
      let bodyFormData = new FormData();
      bodyFormData.set('action', "logout");
      bodyFormData.set('id', this.$root.CurrentUserSessionId);
      bodyFormData.set('Admin', this.$root.isAdmin)
      bodyFormData.set('time', Date.now());
      axios.post(server, bodyFormData)
      .then((res) => {
        console.log(res);
        this.$root.CurrentUser = false;
        this.$root.CurrentUserName = "";
        this.$root.CurrentUserSessionId = "";
      })
      .catch((res) => {
          console.log(res);
          alert("Server Error Still Logged In");
        })
    }
  }
};
</script>
