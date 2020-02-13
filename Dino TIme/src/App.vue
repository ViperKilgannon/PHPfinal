<template>
  <v-app>
    <v-content>
      <!-- new stuff here -->
      <Home v-if="!$root.CurrentUser" />
      <Admin v-if="$root.CurrentUser && $root.isAdmin" />
      <User v-if="$root.CurrentUser && !$root.isAdmin" />
    </v-content>
  </v-app>
</template>

<script>
import Home from "./components/Home.vue";
import Admin from "./components/Admin.vue";
import User from "./components/User.vue";

export default {
  name: "App",

  components: {
    Home,
    Admin,
    User
  },

  data: () => ({
    //
  })
};
</script>
