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

import Modal from '@/components/reusable/modals/modal.vue'
import ModalsCntn from '@/components/reusable/modals/modalCntn.vue'
import ModalAlert from '@/components/reusable/modals/modalAlert.vue'

const defaultComponentName = 'Modal'
const unmountedRootErrorMessage = '[vue-js-modal] In order to render dynamic modals, a <modals-container> ' + 'component must be present on the page'

const VueModal = {
  // The install method is all that needs to exist on the plugin object.
  // It takes the global Vue object as well as user-defined options.
  install(Vue, options = {}) {
    //Makes sure that plugin can be installed only once
    if (this.installed) { return }

    var getModalsContainer = function (Vue, options, root) {
      if (!root._dynamicContainer && options.injectModalsContainer) {
        const modalsContainer = document.createElement('div')
        document.body.appendChild(modalsContainer)

        new Vue({
          parent: root,
          render: h => h(ModalsCntn)
        }).$mount(modalsContainer)
      }
      return root._dynamicContainer
    }

    this.installed = true
    this.event = new Vue()
    this.rootInstance = null
    this.componentName = options.componentName || defaultComponentName

    Vue.prototype.$vueModal = {
      showModal(modal, paramsOrProps, params, events = {}) {

        const root = params && params.root
          ? params.root
          : VueModal.rootInstance

        const container = getModalsContainer(Vue, options, root)

        if (container) {
          //console.log(modal)
          container.add(modal, paramsOrProps, params, events)
          return
        }
        console.warn(unmountedRootErrorMessage)
      },

      hide(name, params) {
        //console.log('funcion hide')
        //VueModal.event.$emit('toggle', name, false, params)
      },

      toggle(name, params) {
        // toggle (nextState, params) {
        //VueModal.event.$emit('toggle', name, undefined, params)
      }
    }
    /**
     * Sets custom component name (if provided)
     */
    //console.log(Modal);
    Vue.component(this.componentName, Modal)
    /**
     * Registration of <ModalsCntn/> component
     */
    //if (options.dynamic) {
    Vue.component('ModalsCntn', ModalsCntn)
    Vue.mixin({
      beforeMount() {
        if (VueModal.rootInstance === null) {
          VueModal.rootInstance = this.$root
        }
      }
    })
    //}

  }
};

Vue.use(VueModal, { dynamic: true, injectModalsContainer: true })

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
      var typeModal = 'modal-sm';
      if (typeof params.typeModal != 'undefined') {
        typeModal = params.typeModal;
      }
      var btnCerrar = true
      if (typeof params.btnCerrar != 'undefined') {
        btnCerrar = params.btnCerrar;
      }
      var title = 'Aviso';
      if (typeof params.title != 'undefined') {
        title = params.title;
      }

      var beforeClose = function () { }
      if (typeof params.beforeClose == 'function') {
        beforeClose = params.beforeClose;
      }

      var afterClose = function () { }
      if (typeof params.afterClose == 'function') {
        afterClose = params.afterClose;
      }

      Vue.prototype.$vueModal.showModal(ModalAlert,
        { 'html': params.html }, { typeModal: typeModal, btnCerrar: btnCerrar },
        {
          title: title,
          buttons: params.buttons,
          'beforeClose': beforeClose,
          'afterClose': afterClose
        }
      )
    }

    Vue.showLoader = (texto) => {
      if(texto){
        $('#loaderText').html(texto);
      }else{
        $('#loaderText').html('Procesando Información');
      }
      
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
