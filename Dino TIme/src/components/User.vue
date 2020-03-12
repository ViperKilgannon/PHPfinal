<template>
  <v-app id="inspire">
    <v-app-bar app color="indigo" dark>
      <v-toolbar-title class="ml-10">{{$root.CurrentUserName}}</v-toolbar-title>
      <v-spacer></v-spacer>
      <v-btn class="mr-5" @click="changePass = true">Change Password</v-btn>
      <v-btn class="mr-12" @click="logout()">Logout</v-btn>
    </v-app-bar>

    <v-content>
      <v-card class="mx-12 my-5 text-center black--text" color="purple lighten-3" justify="center">
        <div justify="center">
          <v-card-subtitle class="headline font-weight-bold black--text"> Current time used: {{timerTime}}</v-card-subtitle>
        </div>
        <div justify="center">
          <v-card-subtitle class="headline font-weight-bold black--text">Current amount owed: ${{currentOwed}}</v-card-subtitle>
        </div>
      </v-card>
      <!-- changepassword -->
      <v-dialog v-model="changePass" persistent max-width="600px" transition="dialog-transition">
        <v-card>
          <v-app-bar color="indigo">
            <v-card-title>
              <span class="headline white--text">Change Password</span>
            </v-card-title>
          </v-app-bar>
          <v-card-text>
            <v-container>
              <v-row>
                <v-col cols="12">
                  <v-text-field
                    @keydown.enter="changePassword()"
                    v-model="password"
                    prepend-icon="mdi-lock"
                    label="Current Password"
                    type="password"
                    required
                  ></v-text-field>
                </v-col>
                <v-col cols="12">
                  <v-text-field
                    @keydown.enter="changePassword()"
                    v-model="newPassword"
                    prepend-icon="mdi-lock"
                    label="New Password"
                    type="password"
                    required
                  ></v-text-field>
                </v-col>
                <v-col cols="12">
                  <v-text-field
                    @keydown.enter="changePassword()"
                    v-model="confirmNewPassword"
                    bounce
                    prepend-icon="mdi-lock-alert"
                    label="Confirm New Password"
                    type="password"
                    required
                  ></v-text-field>
                </v-col>
              </v-row>
            </v-container>
          </v-card-text>
          <v-card-subtitle class="error--text ml-5">{{ error }}</v-card-subtitle>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="indigo" text @click="changePass = false">Close</v-btn>
            <v-btn color="indigo" text @click="changePassword();">Confirm</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-content>
    <v-footer color="indigo" app>
      <span class="white--text">&copy; 2020</span>
    </v-footer>
  </v-app>
</template>

<script>
const server = "http://127.0.0.1/server/ajaxfile.php";
const Axios = require("axios");

var axios = Axios.create({
  withCredentials: true
});

export default {
  props: {
    //
  },
  data: () => ({
    changePass: false,
    password: "",
    newPassword: "",
    confirmNewPassword: "",
    error: "",
    time: 0,
    currentTime: Date.now(),
    timerHandle: -1
  }),
  computed: {
    elapsedTime() {
      return this.currentTime - this.$root.timeIn;
    },
    currentOwed() {
      let timeUsed = this.elapsedTime / 3600000;
      let total = timeUsed * 5;
      return total.toFixed(2);
    },
    timerTime() {
      var diff = Math.floor((this.elapsedTime) / 1000);
      var hour = Math.floor(diff / 3600)
      var min = Math.floor(diff / 60) % 60
      var sec = diff % 60
      function addZero(i) {
        if (i < 10) {
          i = "0" + i;
        }
        return i;
      }
      return addZero(hour) + ":" + addZero(min) + ":" + addZero(sec);
    }
  },
  methods: {
    changePassword() {
      if (this.newPassword === this.confirmNewPassword) {
        let bodyFormData = new FormData();
        bodyFormData.set("action", "changePass");
        bodyFormData.set("pass", this.password);
        bodyFormData.set("newPass", this.newPassword);
        axios.post(server, bodyFormData).then((res) => {
          if (res.message === false) {
            this.error = res.data.message;
          }
        });
      } else {
        this.error = "Passwords Don't Match";
      }
    },
    logout() {
      let bodyFormData = new FormData();
      bodyFormData.set("action", "logout");
      bodyFormData.set("id", this.$root.CurrentUserSessionId);
      bodyFormData.set("time", Date.now());
      axios.post(server, bodyFormData)
        .then((res) => {
          this.$root.CurrentUser = false;
          this.$root.CurrentUserName = "";
          this.$root.CurrentUserSessionId = "";
        })
        .catch((res) => {
          alert("Server Error Still Logged In");
        });
    },
  },
  mounted() {
    if (this.timerHandle < 0) {
      this.timerHandle = setInterval(() => {
        this.currentTime = Date.now();
      }, 1000);
    }
  }
};
</script>
