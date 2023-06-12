/*!

 =========================================================
 * Vue Light Bootstrap Dashboard - v2.1.0 (Bootstrap 4)
 =========================================================

 * Product Page: http://www.creative-tim.com/product/light-bootstrap-dashboard
 * Copyright 2023 Creative Tim (http://www.creative-tim.com)
 * Licensed under MIT (https://github.com/creativetimofficial/light-bootstrap-dashboard/blob/master/LICENSE.md)

 =========================================================

 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

 */
import Vue from "vue";
import VueRouter from "vue-router";
import App from "./App.vue";

// LightBootstrap plugin
import LightBootstrap from "./light-bootstrap-main";

// router setup
import routes from "./routes/routes";

import store from '@/store'

const VueAjax = {
  install(Vue, options) {
    Vue.mixin({
      data: function() {

      },
      mounted() {

      },
      methods: {

      }
    })

    Vue.IN = function() {
      var rspt = false;
      var v1;
      var argv = arguments;
      var argc = argv.length;
      if (argc < 2) {
          return true;
      } else {
          for (var i = 0; i < argc; i++) {
              if (i == 0) {
                  v1 = argv[i];
              } else {
                  if (v1 == argv[i]) { rspt = true; }
              }
          }
      }
      return rspt;
    }
    Vue.alert = function(params) {
      alert( params.html )
    }

    Vue.showLoader = () => {
      console.log('entra')
      $(".box-loader").fadeIn();
      $("#svgContainer").fadeIn();
    };
    // Funcion global que esconde el loader
    Vue.hideLoader = () => {
        $(".box-loader").fadeOut();
        $("#svgContainer").fadeOut();
    };

  }
}

Vue.use(VueAjax);


import "./registerServiceWorker";
// plugin setup
Vue.use(VueRouter);
Vue.use(LightBootstrap);

// configure router
const router = new VueRouter({

  routes, // short for routes: routes
  mode: 'history',
  linkActiveClass: "nav-item active",

  scrollBehavior: (to) => {
    if (to.hash) {
      return { selector: to.hash };
    } else {
      return { x: 0, y: 0 };
    }
  },
});

/* eslint-disable no-new */
new Vue({
  el: "#app",
  render: (h) => h(App),
  router,
  store 
});
