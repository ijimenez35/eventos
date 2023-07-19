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
import axios from 'axios'

// LightBootstrap plugin
import LightBootstrap from "./light-bootstrap-main";

// router setup
import routes from "./routes/routes";

import store from '@/store'
//import route from "@/router";

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
      setTimeout(() => {
        $('#loaderText').html('Procesando Información');
      }, 400);
    };

    Vue.notificacion = ( text, params ) => {
      var html = `<span>Welcome to <b>Light Bootstrap Dashboard</b> - a beautiful freebie for every web developer.</span>`;
      var icon = 'nc-icon nc-simple-remove'
      var type = 'danger'
      if(params){
        if (typeof params.icon != "undefined") {
          icon = params.icon;
        }
        if (typeof params.type != "undefined") {
          type = params.type;
        }
      }
      
      if(text && text != ''){
        html = text
      }
      Vue.prototype.$notifications.notify(
        {
          message: html,
          //icon: 'nc-icon nc-app',
          icon: icon,
          horizontalAlign: 'right',
          verticalAlign: 'top',
          type: type
        })
    }

    Vue.emrgPstnNeva = function(params) {

      if (params.method == 'post') {
          var form = document.createElement("form");
          form.setAttribute("method", params.method);
          form.setAttribute("action", params.url);
          form.setAttribute("target", '_blank');

          if (params.params) {
              for (var i in params.params) {
                  if (params.params.hasOwnProperty(i)) {
                      var input = document.createElement('input');
                      input.type = 'hidden';
                      input.name = i;
                      input.value = params.params[i];
                      form.appendChild(input);
                  }
              }
          }

          document.body.appendChild(form);

          form.submit();
          document.body.removeChild(form);
      } else {
          var ruta = params.url
          var parametrosGET = ''

          if (params.params) {
              for (var i in params.params) {
                  if (parametrosGET == '') {
                      parametrosGET += '?'
                  } else {
                      parametrosGET += '&'
                  }
                  if (params.params.hasOwnProperty(i)) {
                      parametrosGET += i + '=' + params.params[i]
                  }
              }
          }
          window.open(ruta + parametrosGET);
      }
    };

    Vue.vrfcSesion = function (){
      return Vue.requestJSON( { '_cnsl': 'usuario', 'id' : store.getters.idUsuario } ).then(resp => {
        if (resp && resp.length > 0) {
            if (resp[0].estatus == "1" && resp[0].habilitado == "1" ) {
              //Gardamos los valores de la sesion como promesa
              return store.dispatch('SET_USER', resp[0] )
              .then(() => {
                //console.log('Usuario Activo al verificar la sesion');

              })
              .catch(error => { })
            } else {
              //Terminar la sesion
              //console.log('Usuario Inactivo terminar sesion');
              store.dispatch('AUTH_LOGOUT').then(() => next("/login/"));
            }
        } else {
          //console.log('No se pudo verificar la sesion')
          //error en la consulta regresamos
          /// store.dispatch(AUTH_LOGOUT).then(() => next("/login/"));
        }
      })
      .catch(function(error) {
        //error en la consulta regresamos
        /// store.dispatch(AUTH_LOGOUT).then(() => next("/login/"));
      });
    }

    Vue.requestJSON = function (params) {
      //Verificar si la ruta actual requiere sesion de administrador
      
      //let meta = Vue.prototype.$router.currentRoute.meta;
      //console.log(meta);
      //Vue.prototype.$router.push('/roles/')
      
      // some logic ...
      let data = { '_': Math.random() }

      //Agregamos la variable del usuario
      if( store ){
        if( store.getters.isAuthenticated ){
          Vue.set( data, 'idUsuario' , store.getters.idUsuario )
        }
      }
      //Agregamos la variable si el usuario esta en un modulo que requiere ser administrador
      if(router){
        if(router.currentRoute){
          if( router.currentRoute.meta ){
            if( router.currentRoute.meta.requiresAdmin ){
              Vue.set( data, 'admin' , '1' )
            }
          }
        }
      }
      
      $.extend(data, params)

      //delete axios.defaults.headers.common['Authorization-Backdoor']
      axios.defaults.headers.common['Authorization'] = store.getters.token  
      return axios.get(process.env.VUE_APP_API_HOST_JS + '/rqstGet.php', {
        params: data
      }).then(async resp => resp.data.DatosJSON)
        .catch(err => {
          //Vue.hideLoader()
          console.log('error en mySQL')
        })

    };

    Vue.archivos = function (params){

      let data = { '_': Math.random(), 'tipo': '2' }

      $.extend(data, params)

      var objectToQuerystring = function (obj) {
        return Object.keys(obj).reduce(function (str, key, i) {
            var delimiter, val;
            delimiter = (i === 0) ? '?' : '&';
            key = encodeURIComponent(key);
            val = encodeURIComponent(obj[key]);
            return [str, delimiter, key, '=', val].join('');
        }, '');
    }

    var delFirstCharacter = function(cadena){
        cadena = cadena.substring(1, cadena.length);
        return cadena;
    }

      axios.defaults.headers.common['Authorization'] = store.getters.token  
      return axios.post(process.env.VUE_APP_API_HOST_JS + '/fileMngr.php', delFirstCharacter( objectToQuerystring( data ) )  )
        .then(async resp => resp.data.DatosJSON)
        .catch(err => {
          console.log('error en archivos')
        })
    }

    Vue.actualiza = function (formData, config) {

      let data = { '_': Math.random() }

      var mensajeSucces = 'La información se guardó con exito.'
      //var mensajeError = 'Ocurrio un error en el guardado de la información.'
      var mensajeError = 'Ocurrio un error en el guardado, NO responde el servicio'
      //var mensajeHideAfter = 4000
      var mensajeSuccesShow = true
      var mensajeErrorShow = true

      if (config) {
        if (typeof config.mensajeSucces != 'undefined') {
          mensajeSucces = config.mensajeSucces
        }
        if (typeof config.mensajeError != 'undefined') {
          mensajeError = config.mensajeError
        }
        if (typeof config.mensajeHideAfter != 'undefined') {
          mensajeHideAfter = config.mensajeHideAfter
        }
        if (typeof config.mensajeSuccesShow != 'undefined') {
          mensajeSuccesShow = config.mensajeSuccesShow
        }
        if (typeof config.mensajeErrorShow != 'undefined') {
          mensajeErrorShow = config.mensajeErrorShow
        }
      }

      $.extend(data, formData)

      var objectToQuerystring = function (obj) {
          return Object.keys(obj).reduce(function (str, key, i) {
              var delimiter, val;
              delimiter = (i === 0) ? '?' : '&';
              key = encodeURIComponent(key);
              val = encodeURIComponent(obj[key]);
              return [str, delimiter, key, '=', val].join('');
          }, '');
      }

      var delFirstCharacter = function(cadena){
          cadena = cadena.substring(1, cadena.length);
          return cadena;
      }

      Vue.showLoader()

      var enviaDatos = () => {
        axios.defaults.headers.common['Authorization'] = store.getters.token  
        return axios.post(process.env.VUE_APP_API_HOST_JS + '/rqstSend.php', delFirstCharacter( objectToQuerystring( data ) ))
          .then(resp => {
            Vue.hideLoader()
            if (mensajeSuccesShow == true) {
              //Swal.fire( 'OK...', mensajeSucces, 'success' )
              Vue.notificacion(mensajeSucces, {type: 'success'})
            }
            return resp.data
          })
          .catch(err => {
            Vue.hideLoader()
            if (mensajeErrorShow == true) {
              Vue.notificacion(mensajeError)
            }
          })
      }
      return enviaDatos()
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
