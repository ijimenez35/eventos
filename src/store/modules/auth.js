import Vue from 'vue'
import axios from 'axios'

const state = {
  status: '',
  token: '',
  idUsuario: '',
  nombre: '',
  aPaterno: '',
  aMaterno: '',
  correo: '',
  lang: '', 
  ladaPais: '', 
  telefono: '',
  idRol: '',
  idFolioRol: '',
  rolNombre: '',
  folioNombre: '',
  roles: [],
  correoConfirmado: '0',
  habilitado: '0',
  cntrTmpr: '0' 
}

const getters = {
  isAuthenticated: state => !!state.token,
  token: state => state.token,
  idUsuario: state => state.idUsuario,
  nombre: state => state.nombre,
  aPaterno: state => state.aPaterno,
  aMaterno: state => state.aMaterno,
  fullName: state => state.nombre + ' ' + state.aPaterno,
  correo: state => state.correo,
  lang: state => state.lang,
  ladaPais: state => state.ladaPais,
  telefono: state => state.telefono,
  idRol: state => state.idRol,
  idFolioRol: state => state.idFolioRol,
  rolNombre: state => state.rolNombre,
  folioNombre: state => state.folioNombre,
  roles: state => state.roles,
  correoConfirmado: state => state.correoConfirmado,  
  habilitado: state => state.habilitado,
  cntrTmpr: state => state.cntrTmpr
}

const actions = {
  ['AUTH_REQUEST']: ({commit}, user) => {
    return new Promise((resolve, reject) => {
        //delete axios.defaults.headers.common['Authorization']
        axios.post(process.env.VUE_APP_API_HOST_JS + '/login.php', 'email='+ user.email + ''  + '&cntr='+ user.cntr )
        .then(async respLogin => {

          if( respLogin.data.estatusUsuario == 'exito' ){
            if( respLogin.data.habilitado == '0' ){
              commit('AUTH_ERROR')
              let vsError = 'Usuario inhabilitado'
              reject(vsError)
            }else{
              //Traer los roles del usuario
              let data = {
                '_cnsl': 'roles',
                'idUsuario' : respLogin.data.id
              }
  
              Vue.requestJSON( data ).then(respRoles => {
                if( respRoles ){
                  if( respRoles.length == 0 ){
                    Vue.set(respLogin.data, 'idRol', '0' )
                    Vue.set(respLogin.data, 'idFolioRol', '0' )
                    Vue.set(respLogin.data, 'rolNombre', '')
                    Vue.set(respLogin.data, 'folioNombre', '')
                    Vue.set(respLogin.data, 'roles', [])
                  }else if( respRoles.length == 1 ){
                    Vue.set(respLogin.data, 'idRol', respRoles[0].idRol )
                    Vue.set(respLogin.data, 'idFolioRol', respRoles[0].idFolioRol )
                    Vue.set(respLogin.data, 'rolNombre', respRoles[0].rolNombre)
                    Vue.set(respLogin.data, 'folioNombre', respRoles[0].folioNombre)
                    Vue.set(respLogin.data, 'roles', respRoles)
                  }else{
                    Vue.set(respLogin.data, 'idRol', '0' )
                    Vue.set(respLogin.data, 'idFolioRol', '0' )
                    Vue.set(respLogin.data, 'rolNombre', '')
                    Vue.set(respLogin.data, 'folioNombre', '')
                    Vue.set(respLogin.data, 'roles', respRoles)
                  }
    
                  commit('AUTH_SUCCESS', respLogin)
                  //dispatch(USER_REQUEST) 
                  resolve(respLogin)
                }
              })
            }
          }else{
            commit('AUTH_ERROR')
            let vsError = 'Usuario invalido'
            reject(vsError)
          }
        })
        .catch(err => {
          commit('AUTH_ERROR', err)
          reject(err)
        })
    })
  },
  ['AUTH_LOGOUT']: ({commit}) => {
    return new Promise((resolve) => {
      commit('AUTH_LOGOUT')
      resolve()
    })
  },
  ['AUTH_SUCCESS']: ({ commit }) => {
    return new Promise((resolve) => {
      commit('AUTH_SUCCESS')
      resolve()
    })
  },
  ['SET_ROL']: ({commit}, rol) => {
    return new Promise((resolve) => {
      commit('SET_ROL', rol)
      resolve()
    })
  },
  ['SET_CNTRTMPR']: ({commit}, value) => {
    return new Promise((resolve) => {
      commit('SET_CNTRTMPR', value)
      resolve()
    })
  },
  ['SET_CORREOCONFIRMADO']: ({commit}, value) => {
    return new Promise((resolve) => {
      commit('SET_CORREOCONFIRMADO', value)
      resolve()
    })
  }
}

const mutations = {
  ['AUTH_REQUEST']: (state) => {
    state.status = 'loading'
  },
  ['AUTH_SUCCESS']: (state, resp) => {
    state.status = 'success'
    state.token = resp.data.token
    state.idUsuario = resp.data.id
    state.nombre = resp.data.nombre
    state.aPaterno = resp.data.aPaterno
    state.aMaterno = resp.data.aMaterno
    state.correo = resp.data.correo
    state.lang = resp.data.lang
    state.ladaPais = resp.data.ladaPais
    state.telefono = resp.data.telefono
    state.idRol = resp.data.idRol
    state.idFolioRol = resp.data.idFolioRol
    state.rolNombre = resp.data.rolNombre
    state.folioNombre = resp.data.folioNombre
    state.roles = resp.data.roles
    state.correoConfirmado = resp.data.correoConfirmado
    state.habilitado = resp.data.habilitado
    state.cntrTmpr = resp.data.cntrTmpr 
  },
  ['AUTH_ERROR']: (state) => {
    state.status = 'error'
    state.token = null
  },
  ['AUTH_LOGOUT']: (state) => {
    state.status = null
    state.token = null
    state.idUsuario = null
    state.nombre = null
    state.aPaterno = null
    state.aMaterno = null
    state.correo = null
    state.lang = null
    state.ladaPais = null
    state.telefono = null
    state.idRol = null
    state.idFolioRol = null
    state.rolNombre = null
    state.folioNombre = null
    state.roles = null
    state.correoConfirmado = null
    state.habilitado = null
    state.cntrTmpr = null 
  },
  ['SET_ROL']: (state, rol) => {
    state.idRol = rol.idRol
    state.idFolioRol = rol.idFolioRol
    state.rolNombre = rol.rolNombre
    state.folioNombre = rol.folioNombre
  },
  ['SET_CNTRTMPR']: (state, value) => {
    state.cntrTmpr = value
  },
  ['SET_CORREOCONFIRMADO']: (state, value) => {
    state.correoConfirmado = value
  }
}

export default {
  state,
  getters,
  actions,
  mutations,
}