import DashboardLayout from '../layout/DashboardLayout.vue'
// GeneralViews
import NotFound from '../pages/NotFoundPage.vue'

import Login from '../pages/Login/index.vue'

import store from 'src/store'

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

// User pages
import ConfirmaCorreo from 'src/pages/ConfirmaCorreo/index.vue'
import ContraseniaTemporal from 'src/pages/ContraseniaTemporal/index.vue'

// Default pages

let entryUrl = null;

const ifAuthenticated = (to, from, next) => {
  next( )
  return
  console.log( store.getters.isAuthenticated )
  console.log( store.getters.token )
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
  }else {
      if (to.hash.includes("#!/") ){
          next(to.hash.replace('#!/', ''));
      }else{
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
    component: Login
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
    beforeEnter: ifAuthenticated,
    children: [
      {
        path: 'overview',
        name: 'Overview',
        component: Overview
      },
      {
        path: 'reporteador',
        name: 'Reporteador',
        component: Reporteador
      },
      {
        path: 'user',
        name: 'User',
        component: UserProfile
      },
      {
        path: 'table-list',
        name: 'Table List',
        component: TableList
      },
      {
        path: 'typography',
        name: 'Typography',
        component: Typography
      },
      {
        path: 'icons',
        name: 'Icons',
        component: Icons
      },
      {
        path: 'maps',
        name: 'Maps',
        component: Maps
      },
      {
        path: 'notifications',
        name: 'Notifications',
        component: Notifications
      },
      {
        path: 'upgrade',
        name: 'Upgrade to PRO',
        component: Upgrade
      },
      {
        path: 'usuarios',
        name: 'Usuarios',
        component: Usuarios
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
