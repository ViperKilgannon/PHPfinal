<template>
  <v-app id="keep">
    <v-app-bar app clipped-left color="blue">
      <span class="title ml-3 mr-5">
        Dino&nbsp;
        <span class="font-weight-light">Admin</span>
      </span>
      <v-text-field
        v-model="searchArg"
        solo-inverted
        flat
        hide-details
        label="Search"
        @keydown.enter="searchForUser(searchArg)"
        prepend-inner-icon="mdi-magnify"
        class="mr-5"
      />
      <v-btn @click="registerBox = true" class="mr-5">Register User</v-btn>
      <v-btn @click="logout()">Logout</v-btn>
    </v-app-bar>

    <v-content class="grey darken-3 fill-height">
      <v-data-table
        :headers="headers"
        :items="$root.currentSignedIn"
        :single-expand=true
        show-expand
        disable-filtering
        disable-sort
        disable-pagination
        class="elevation-1 mx-12 grey lighten-1"
      >
        <template v-slot:item.timeIn="{ item }">
          <span>{{getTimeIn(item.timeIn)}}</span>
        </template>
        <template v-slot:item.timeOut="{ item }">
          <span>{{(getTimeIn(item.timeOut)=="00:00:00" ? "Currently Active" : getTimeIn(item.timeOut))}}</span>
        </template>
        <template v-slot:item.owedAmount="{ item }">
          <span>{{(getTimeIn(item.timeOut)=="00:00:00" ? getOwed(Date.now()-item.timeIn, item.id)  : getOwed(item.timeOut-item.timeIn, item.id))}}</span>
        </template>
        <template v-slot:expanded-item="{ item }">
        <td colspan="100%" ><v-btn color="error" @click="deleteRecord(item.id)" class="float-right mr-5">Delete Record</v-btn></td>
      </template>
      </v-data-table>

      <v-btn class="ml-12" @click="checkWhoSignIn()">Refresh</v-btn>
        <v-btn class="mr-12 float-right" @click="endOfDay()">Close Day Sheet</v-btn>
    <!-- search results -->
    <v-dialog
      v-model="searchUser"
      scrollable fullscreen
      persistent
      max-width="600px"
      transition="dialog-transition"
    >
        <v-content class="grey darken-3 fill-height">
      <v-data-table
        :headers="searchHeader"
        :items="searchedUsers"
        disable-filtering
        disable-pagination
        class="elevation-1 mx-12 grey lighten-1"
      >
        <template v-slot:item.Admin="{ item }">
          <span>{{item.Admin=="1" ? "Yes"  : "No"}}</span>
        </template>
        <template v-slot:item.Action="{ item }">
          <span><v-btn @click="editThisUserPrime(item.UserName, item.Name)">Edit</v-btn></span>
        </template>
      </v-data-table>
      <v-btn color="warning" class="mr-12 float-right" text @click="searchUser = false">Close</v-btn>
        </v-content>
    </v-dialog>
    <!-- edit user -->
    <v-dialog v-model="editUser" persistent max-width="600px" transition="dialog-transition">
      <v-card>
        <v-app-bar color="blue">
          <v-card-title>
            <span class="headline">Edit User</span>
          </v-card-title>
        </v-app-bar>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12">
                <v-text-field
                  v-model="usernameEdit"
                  prepend-icon="mdi-account-circle"
                  label="Username"
                  type="text"
                  required
                ></v-text-field>
              </v-col>
                <v-col cols="12">
                <v-text-field
                  v-model="nameEdit"
                  prepend-icon="mdi-account-circle"
                  label="Name"
                  type="text"
                  required
                ></v-text-field>
              </v-col>
            </v-row>
              <v-col cols="12">
                <v-switch
                  v-model="admin"
                  label="Admin?"
                  prepend-icon="mdi-account-circle"
                  color="success"
                ></v-switch>
              </v-col>
          </v-container>
        </v-card-text>
        <v-card-subtitle class="error--text ml-5">{{ error }}</v-card-subtitle>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue" text @click="editUser = false">Close</v-btn>
          <v-btn color="blue" text @click="editThisUser();">Confirm</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <!-- register box -->
    <v-dialog v-model="registerBox" persistent max-width="600px" transition="dialog-transition">
      <v-card>
        <v-app-bar color="blue">
          <v-card-title>
            <span class="headline">Register</span>
          </v-card-title>
        </v-app-bar>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12">
                <v-text-field
                  v-model="username"
                  prepend-icon="mdi-account-circle"
                  label="Username"
                  type="text"
                  required
                ></v-text-field>
              </v-col>
                <v-col cols="12">
                <v-text-field
                  v-model="name"
                  prepend-icon="mdi-account-circle"
                  label="Name"
                  type="text"
                  required
                ></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-text-field
                  v-model="password"
                  prepend-icon="mdi-lock"
                  label="Password"
                  type="password"
                  required
                ></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-text-field
                  v-model="confirmpassword"
                  bounce
                  prepend-icon="mdi-lock-alert"
                  label="Confirm Password"
                  type="password"
                  required
                ></v-text-field>
              </v-col>
            </v-row>
              <v-col cols="12">
                <v-switch
                  v-model="admin"
                  label="Admin?"
                  prepend-icon="mdi-account-circle"
                  color="success"
                ></v-switch>
              </v-col>
          </v-container>
        </v-card-text>
        <v-card-subtitle class="error--text ml-5">{{ error }}</v-card-subtitle>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue" text @click="registerBox = false">Close</v-btn>
          <v-btn color="blue" text @click="register();">Confirm</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    </v-content>
  </v-app>
</template>

<script>
const server = "http://127.0.0.1/server/ajaxfile.php";
const Axios = require('axios');

var axios = Axios.create({
  withCredentials: true
})


export default {
  props: {
    source: String
  },
  data: () => ({
    registerBox: false,
    editUser: false,
    searchUser: false,
    searchedUsers: [],
    searchArg: "",
    username: "",
    name: "",
    password: "",
    usernameEdit: "",
    nameEdit: "",
    editUserPrime: "",
    admin: false,
    res: "",
    confirmpassword: "",
    error: "",
    searchHeader: [
      {
        text: "Users",
        align: "left",
        sortable: false,
        value: "UserName"
      },
      { text: "Name", value: "Name" },
      { text: "Admin?", value: "Admin" },
      { text: ' ', value: 'Action', sortable: false }
      ],
    headers: [
      {
        text: "Current Users Logged In",
        align: "left",
        sortable: false,
        value: "user"
      },
      { text: "Time In", value: "timeIn" },
      { text: "Time Out", value: "timeOut" },
      { text: "Ammount Owed", value: "owedAmount" }
    ],
  }),

  methods: {
    //need to test
    editThisUser() {
      let bodyFormData = new FormData();
      if (this.admin = "false"){
          newadmin = 0;
      } else {
        newadmin = 1;
      }
      bodyFormData.set('action', 'updateUser');
      bodyFormData.set('oldUser', editUserPrime);
      bodyFormData.set('newUser', usernameEdit);
      bodyFormData.set('name', nameEdit);
      bodyFormData.set('admin', newadmin);

      axios.post(server, bodyFormData)
      .then((res) => {
        console.log(res);
      })
    },
    editThisUserPrime(user, name) {
      this.usernameEdit = user;
      this.editUserPrime = user;
      this.nameEdit = name;
      this.editUser = true;
    },
    searchForUser(arg) {
      let bodyFormData = new FormData();
      bodyFormData.set('action', "search");
      bodyFormData.set('arg', arg)

      axios.post(server, bodyFormData)
      .then((res) => {
        this.searchedUsers = res.data.searched;
        console.log(res);
        this.searchUser = true;
      })
    },
    deleteRecord(id) {
      let bodyFormData = new FormData();
      bodyFormData.set('action', "deleteRecord");
      bodyFormData.set('id', id)

      axios.post(server, bodyFormData)
      .then((res) => {
        console.log(res);
        this.checkWhoSignIn();
      })
    },
    getOwed(time, id) {
      let timeUsed = time / 3600000;
      let total = timeUsed * 5;
      let price = "$" + total.toFixed(2);
      let bodyFormData = new FormData();
      bodyFormData.set('action', "owed");
      bodyFormData.set('id', id);
      bodyFormData.set('amount', total);
      axios.post(server, bodyFormData)
      .then((res) => {
        console.log(res)
      })
      return price;
    },
    checkWhoSignIn() {
      let bodyFormData = new FormData();
      bodyFormData.set('action', "checkSignIn");

      axios.post(server, bodyFormData)
      .then((res) => {
        console.log(res);
        this.$root.currentSignedIn = res.data.currentUsers;
      })
    },
    endOfDay() {
      let bodyFormData = new FormData();
      bodyFormData.set('action', "clear");
      bodyFormData.set('admin', this.$root.isAdmin);

      axios.post(server, bodyFormData)
      .then((res) => {
        console.log(res);
      })
    },
    register() {
      if (this.password === this.confirmpassword) {
        let bodyFormData = new FormData();
        bodyFormData.set('action', "register");
        bodyFormData.set('UserName', this.username);
        bodyFormData.set('Name', this.name);
        bodyFormData.set('password', this.password);
        bodyFormData.set('Admin', this.admin);

        axios.post(server, bodyFormData)
        .then((res) => {
          console.log(res);
          if (res.data.success === true) {
          this.registerBox = false
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
    logout() {
        let bodyFormData = new FormData();
        bodyFormData.set('action', "logout");
    axios.post(server, bodyFormData)
    .then((res) => {
      console.log(res);
        this.$root.CurrentUser = false;
    })
    .catch((res) => {
          console.log(res);
          alert("Server Error Still Logged In");
        })
    },
    getTimeIn(time) {
      function addZero(i) {
        if (i < 10) {
          i = "0" + i;
        }
        return i;
      }
      function formatDateTime() {
        let d = new Date(parseInt(time, 10));
        let h = addZero(d.getHours());
        let m = addZero(d.getMinutes());
        let s = addZero(d.getSeconds());
        time = h + ":" + m + ":" + s;
      }

      if (time) {
        formatDateTime(time);
      } else {
        time = "00:00:00";
      }
      return time;
    }
  }
}
</script>

<style>
#keep .v-navigation-drawer__border {
  display: none;
}
</style>