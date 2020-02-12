<template>
  <v-app>
    <v-content>
      <!-- new stuff here -->
      <Home />
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
    Home
  },

  data: () => ({
    //
  })
};
</script>
