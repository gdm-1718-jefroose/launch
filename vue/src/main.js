// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
/* eslint-disable */
import * as VueGoogleMaps from 'vue2-google-maps';
import Vue from 'vue'
import App from './App'
import router from './router'
import auth from './auth'
import 'materialize-css'

Vue.config.productionTip = false

Vue.use(VueGoogleMaps, {
  load: {
    key: 'AIzaSyAItIXSodQBV73DQhCCmo3Xj3rFqYPtNtM',
    v: '3.31'
  }
});

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  template: '<App/>',
  components: { App }
})


auth.checkAuth();

var sidenav = document.querySelector('.sidenav');
var instance = new M.Sidenav(sidenav);
var dropdown = document.querySelector('.dropdown-trigger');
var instance2 = new M.Dropdown(dropdown);



