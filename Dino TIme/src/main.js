import Vue from 'vue';
import App from './App.vue';
import vuetify from './plugins/vuetify';

Vue.config.productionTip = false;

new Vue({
  data: {
    CurrentUser: false,
    isAdmin: false,
    CurrentUserName: "TEMP",
    currentSignedIn: []
  },
  vuetify,
  render: (h) => h(App),
}).$mount('#app');
