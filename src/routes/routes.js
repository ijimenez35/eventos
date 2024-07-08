import DashboardLayout from '../layout/DashboardLayout.vue'
// GeneralViews
import NotFound from '../pages/NotFoundPage.vue'

import Login from '../pages/Login/index.vue'

import store from 'src/store'
import Vue from 'vue'

// Admin pages
import Overview from 'src/pages/Overview.vue'

import UserProfile from 'src/pages/UserProfile.vue'
import TableList from 'src/pages/TableList.vue'
import Typography from 'src/pages/Typography.vue'
import Icons from 'src/pages/Icons.vue'
import Maps from 'src/pages/Maps.vue'
import Notifications from 'src/pages/Notifications.vue'
import Upgrade from 'src/pages/Upgrade.vue'

import Reporteador from 'src/pages/Reporteador.vue'
import Usuarios from 'src/pages/Usuarios.vue'
import Imagenes from 'src/pages/Imagenes.vue'
import Correos from 'src/pages/Correos.vue'
import Htmls from 'src/pages/Htmls.vue'
import BaseDatos from 'src/pages/BaseDatos.vue'

// User pages
import ConfirmaCorreo from 'src/pages/ConfirmaCorreo/index.vue'
import ContraseniaTemporal from 'src/pages/ContraseniaTemporal/index.vue'
import Registro from 'src/pages/Registro/index.vue'
import RecoverPw from 'src/pages/RecoverPw/index.vue'

import Ticket from 'src/pages/Ticket.vue'
import Eventos from 'src/pages/Eventos.vue'
import Boletos from 'src/pages/Boletos.vue'
import Reportes from 'src/pages/Reportes.vue'

import RegistroEvento from 'src/pages/RegistroEvento/index.vue'

// Default pages

let entryUrl = null;

const ifLogin = (to, from, next) => {
  if( store.getters.isAuthenticated ){
    next({ path: '/' })
  }else{
    next( ) 
  }
}

const ifNotAuthenticated = (to, from, next) => {
  if (!store.getters.isAuthenticated) {
      next();
      return;
  }
  next("/");
};

const ifAuthenticated = (to, from, next) => {
  //console.log( from )
  //next( ) return
  //console.log( store.getters.isAuthenticated )
  //console.log( store.getters.token )

  /*
  if( store.getters.isAuthenticated && store.getters.correoConfirmado == '0' && to.name != 'ConfirmaCorreo' ){
      if(entryUrl){
          next({
              path: '/confirmaCorreo/',
              query: {
                 redirect: entryUrl 
              }
          })
      }else{
          next('/confirmaCorreo/');
      }
  }else if( store.getters.isAuthenticated && store.getters.cntrTmpr == '1' && to.name != 'ContraseniaTemporal' ){
      if(entryUrl){
          next({
              path: '/contraseniaTemporal/',
              query: {
                 redirect: entryUrl 
              }
          })
      }else{
          next('/contraseniaTemporal/');
      }
  }else if (store.getters.isAuthenticated && store.getters.idRol != '') {
      //Esta logueado y tiene entidad seleccionada
      if (entryUrl) {
          const url = entryUrl;
          entryUrl = null;
          window.location.href = url
      }
      
      if (to.hash.includes("#!/") ){
          next(to.hash.replace('#!/', ''));
      }else{
          next( )
      }
      
      return true
  //Esta logueado, no tiene entidad, pero no se requiere entidad
  }else if(store.getters.isAuthenticated && ( to.query.roles == false || to.query.roles == 'false') ){
      if (entryUrl) {
          const url = entryUrl;
          entryUrl = null;
          window.location.href =  url
      }
      
      if (to.hash.includes("#!/") ){
          next(to.hash.replace('#!/', ''));
      }else{
          next( )
      }
      
      return true
  }
  */
  if( store.getters.isAuthenticated ){ //Esta logueado en el sistema

    if( to.meta.requiresAdmin ){
      Vue.showLoader('Verificando sesión del usuario')
      Vue.vrfcSesion()
      .then(() => {
        Vue.hideLoader();
        //console.log('Usuario Activo y el modulo requiere que sea administrador');
        //console.log( store.getters.administrador )
        //let meta = getFields(this.$route.meta);
        if( store.getters.administrador == '1' ){
          console.log('Usuario Activo el usuario es administrador');
          if (entryUrl) {
              const url = entryUrl;
              entryUrl = null;
              window.location.href = url
          }
          
          if (to.hash.includes("#!/") ){
              next(to.hash.replace('#!/', ''));
          }else{
              next( )
          }
          
          return true
        }else{
          Vue.notificacion('Se requiere ser administrador para acceder a este menú')

          //console.log('Usuario Activo el usuario no es administrador');
          if( from.path ){
            next( from.path )
          }else{
            next( "/" )
          }
          return false
        }
      })
      .catch(function(error) {
        Vue.hideLoader();
      })

    }else{
      //Consulta asincrono el estatus del usuario
      Vue.vrfcSesion();
      //router.replaceView
      
      if (entryUrl) {
          const url = entryUrl;
          entryUrl = null;
          window.location.href = url
      }
      
      if (to.hash.includes("#!/") ){
          next(to.hash.replace('#!/', ''));
      }else{
          next( )
      }
      
      return true
    }

    
  } else { //Usuario no esta logueado en el sistema
      if (to.hash.includes("#!/") ){
          next(to.hash.replace('#!/', ''));
      }else{

        var objectToQuerystring = function(obj) {
            return Object.keys(obj).reduce(function(str, key, i) {
                var delimiter, val;
                delimiter = i === 0 ? "?" : "&";
                key = encodeURIComponent(key);
                val = encodeURIComponent(obj[key]);
                return [str, delimiter, key, "=", val].join("");
            }, "");
        };

        entryUrl = to.path + objectToQuerystring( to.query );
        if( entryUrl == '' || entryUrl == '/' ){
            entryUrl = null;
            next('/login/')
        }else{
            if( to.query.roles ){
                next({
                    path: '/login/',
                    query: {
                        roles: to.query.roles,
                        redirect: entryUrl.replace('&roles=false','').replace('&roles=true','').replace('?roles=false&','?').replace('?roles=true&','?').replace('?roles=false','').replace('?roles=true','')
                    }
                })
            }else{
                next({
                    path: '/login/',
                    query: {
                        redirect: entryUrl 
                    }
                })
            }
        }
      }
      return false
  }
}

const routes = [
  {
    path: '/login',
    alias: "Login",
    component: Login,
    beforeEnter: ifNotAuthenticated
  },
  {
    path: '/registroEvento',
    alias: "RegistroEvento",
    component: RegistroEvento,
    beforeEnter: ifNotAuthenticated
  },
  {
    path: '/registro',
    alias: "Registro",
    component: Registro,
    beforeEnter: ifNotAuthenticated
  },
  {
    path: '/recoverPw',
    alias: "RecoverPw",
    component: RecoverPw
  },
  {
    path: '/confirmaCorreo',
    alias: "ConfirmaCorreo",
    component: ConfirmaCorreo
  },
  {
    path: '/contraseniaTemporal',
    alias: "ContraseniaTemporal",
    component: ContraseniaTemporal
  },
  {
    path: '/',
    component: DashboardLayout,
    redirect: '/admin/overview',
    beforeEnter: ifAuthenticated
  },
  {
    path: '/admin',
    component: DashboardLayout,
    redirect: '/admin/overview',
    children: [
      {
        path: 'ticket',
        name: 'Ticket',
        beforeEnter: ifAuthenticated,
        component: Ticket
      },
      {
        path: 'eventos',
        name: 'Eventos',
        beforeEnter: ifAuthenticated,
        component: Eventos
      },
      {
        path: 'boletos',
        name: 'Boletos',
        beforeEnter: ifAuthenticated,
        component: Boletos
      },
      {
        path: 'reportes',
        name: 'Reportes',
        beforeEnter: ifAuthenticated,
        component: Reportes
      },
      {
        path: 'overview',
        name: 'Overview',
        beforeEnter: ifAuthenticated,
        component: Overview
      },
      {
        path: 'reporteador',
        name: 'Reporteador',
        beforeEnter: ifAuthenticated,
        component: Reporteador
      },
      {
        path: 'user',
        name: 'User',
        beforeEnter: ifAuthenticated,
        component: UserProfile
      },
      {
        path: 'table-list',
        name: 'Table List',
        beforeEnter: ifAuthenticated,
        component: TableList
      },
      {
        path: 'typography',
        name: 'Typography',
        beforeEnter: ifAuthenticated,
        component: Typography
      },
      {
        path: 'icons',
        name: 'Icons',
        beforeEnter: ifAuthenticated,
        component: Icons
      },
      {
        path: 'maps',
        name: 'Maps',
        beforeEnter: ifAuthenticated,
        component: Maps
      },
      {
        path: 'notifications',
        name: 'Notifications',
        beforeEnter: ifAuthenticated,
        component: Notifications
      },
      {
        path: 'upgrade',
        name: 'Upgrade to PRO',
        beforeEnter: ifAuthenticated,
        component: Upgrade
      },
      {
        path: 'usuarios',
        name: 'Usuarios',
        beforeEnter: ifAuthenticated,
        component: Usuarios,
        meta: { requiresAdmin: true }
      },
      {
        path: 'imagenes',
        name: 'Imagenes',
        beforeEnter: ifAuthenticated,
        component: Imagenes,
        meta: { requiresAdmin: true }
      },
      {
        path: 'correos',
        name: 'Correos',
        beforeEnter: ifAuthenticated,
        component: Correos,
        meta: { requiresAdmin: true }
      },
      {
        path: 'htmls',
        name: 'Htmls',
        beforeEnter: ifAuthenticated,
        component: Htmls,
        meta: { requiresAdmin: true }
      },
      {
        path: 'db',
        name: 'BaseDatos',
        beforeEnter: ifAuthenticated,
        component: BaseDatos,
        meta: { requiresAdmin: true }
      },
    ]
  },
  { path: '*', component: NotFound }
]

/**
 * Asynchronously load view (Webpack Lazy loading compatible)
 * The specified component must be inside the Views folder
 * @param  {string} name  the filename (basename) of the view to load.
function view(name) {
   var res= require('../components/Dashboard/Views/' + name + '.vue');
   return res;
};**/

export default routes
