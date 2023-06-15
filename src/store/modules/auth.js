import Vue from 'vue'
import { AUTH_REQUEST, AUTH_ERROR, AUTH_SUCCESS, AUTH_LOGOUT } from '@/store/actions/auth'
import axios from 'axios'

const state = {
  status: '',
  token: '',
  idUsuario: '',
  nombre: '',
  aPaterno: '',
  aMaterno: '',
  correo: '',
  telefono: '',
  idRol: '',
  idFolioRol: '',
  rolNombre: '',
  folioNombre: '',
  roles: [],
  correoConfirmado: '0',
  cntrTmpr: '0' 
}

const getters = {
  isAuthenticated: state => !!state.token,
  idUsuario: state => state.idUsuario,
  nombre: state => state.nombre,
  aPaterno: state => state.aPaterno,
  aMaterno: state => state.aMaterno,
  correo: state => state.correo,
  telefono: state => state.telefono,
  idRol: state => state.idRol,
  idFolioRol: state => state.idFolioRol,
  rolNombre: state => state.rolNombre,
  folioNombre: state => state.folioNombre,
  roles: state => state.roles,
  token: state => state.token,
  cntrTmpr: state => state.cntrTmpr,
  correoConfirmado: state => state.correoConfirmado 
}

const actions = {
  [AUTH_REQUEST]: ({commit}, user) => {
    return new Promise((resolve, reject) => {
        delete axios.defaults.headers.common['Authorization']
        axios.post(process.env.VUE_APP_API_HOST_JS + '/ws/login.php', 
          'login='+user.username+'&cntr='+user.password
        )
        .then(async resp => {
          if( resp.data.estatusUsuario == 'exito' ){

            let data = {
              '_cnsl': 'roles',
              'idUsuario' : resp.data.id
            }

            Vue.requestJSON( data ).then(respRoles => {

              if( respRoles ){
                if( respRoles.length == 0 ){
                  Vue.set(resp.data, 'idRol', '0' )
                  Vue.set(resp.data, 'idFolioRol', '0' )
                  Vue.set(resp.data, 'rolNombre', '')
                  Vue.set(resp.data, 'folioNombre', '')
                  Vue.set(resp.data, 'roles', [])
                }else if( respRoles.length == 1 ){
                  Vue.set(resp.data, 'idRol', respRoles[0].idRol )
                  Vue.set(resp.data, 'idFolioRol', respRoles[0].idFolioRol )
                  Vue.set(resp.data, 'rolNombre', respRoles[0].rolNombre)
                  Vue.set(resp.data, 'folioNombre', respRoles[0].folioNombre)
                  Vue.set(resp.data, 'roles', respRoles)
                }else{
                  Vue.set(resp.data, 'idRol', '0' )
                  Vue.set(resp.data, 'idFolioRol', '0' )
                  Vue.set(resp.data, 'rolNombre', '')
                  Vue.set(resp.data, 'folioNombre', '')
                  Vue.set(resp.data, 'roles', respRoles)
                }
  
                commit(AUTH_SUCCESS, resp)
                //dispatch(USER_REQUEST) 
                resolve(resp)
              }
            })
/*
            axios.get(process.env.VUE_APP_API_HOST_JS + '/ws/wsMySQLJson.php', { params: data })
            .then(respRoles => {
              
              if( respRoles.data.DatosJSON.length == 0 ){
                Vue.set(resp.data, 'idRol', '0' )
                Vue.set(resp.data, 'idFolioRol', '0' )
                Vue.set(resp.data, 'rolNombre', '')
                Vue.set(resp.data, 'folioNombre', '')
                Vue.set(resp.data, 'roles', [])
              }else if( respRoles.data.DatosJSON.length == 1 ){
                Vue.set(resp.data, 'idRol', respRoles.data.DatosJSON[0].idRol )
                Vue.set(resp.data, 'idFolioRol', respRoles.data.DatosJSON[0].idFolioRol )
                Vue.set(resp.data, 'rolNombre', respRoles.data.DatosJSON[0].rolNombre)
                Vue.set(resp.data, 'folioNombre', respRoles.data.DatosJSON[0].folioNombre)
                Vue.set(resp.data, 'roles', respRoles.data.DatosJSON)
              }else{
                Vue.set(resp.data, 'idRol', '0' )
                Vue.set(resp.data, 'idFolioRol', '0' )
                Vue.set(resp.data, 'rolNombre', '')
                Vue.set(resp.data, 'folioNombre', '')
                Vue.set(resp.data, 'roles', respRoles.data.DatosJSON)
              }

              commit(AUTH_SUCCESS, resp)
              //dispatch(USER_REQUEST) 
              resolve(resp)
                
            })
            .catch(err => {
                console.log('error')
            })

            */

          }else{
            commit(AUTH_ERROR)
            let vsError = 'Usuario invalido'
            reject(vsError)
          }
          
        })
        .catch(err => {
          //console.log(err)
          commit(AUTH_ERROR, err)
          reject(err)
        })
    })
  },
  [AUTH_LOGOUT]: ({commit}) => {
    return new Promise((resolve) => {
      commit(AUTH_LOGOUT)
      resolve()
    })
  },
  [AUTH_SUCCESS]: ({ commit }) => {
    return new Promise((resolve) => {
      commit(AUTH_SUCCESS)
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
  [AUTH_REQUEST]: (state) => {
    state.status = 'loading'
  },
  [AUTH_SUCCESS]: (state, resp) => {
    state.status = 'success'
    state.token = resp.data.token
    state.idUsuario = resp.data.id
    state.nombre = resp.data.nombre
    state.aPaterno = resp.data.aPaterno
    state.aMaterno = resp.data.aMaterno
    state.correo = resp.data.correo
    state.telefono = resp.data.telefono
    state.idRol = resp.data.idRol
    state.idFolioRol = resp.data.idFolioRol
    state.rolNombre = resp.data.rolNombre
    state.folioNombre = resp.data.folioNombre
    state.roles = resp.data.roles
    state.cntrTmpr = resp.data.cntrTmpr 
    state.correoConfirmado = resp.data.correoConfirmado 
  },
  [AUTH_ERROR]: (state) => {
    state.status = 'error'
    state.token = null
  },
  [AUTH_LOGOUT]: (state) => {
    state.token = null
    state.idUsuario = null
    state.nombre = null
    state.aPaterno = null
    state.aMaterno = null
    state.correo = null
    state.telefono = null
    state.idRol = null
    state.idFolioRol = null
    state.rolNombre = null
    state.folioNombre = null
    state.roles = null
    state.cntrTmpr = null 
    state.correoConfirmado = null
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