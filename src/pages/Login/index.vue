<template>
  <div class="content">
    
    <section class="h-100 gradient-form" style="background-color: #eee;">
      <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
          <div class="col-xl-10">
            <div class="card rounded-3 text-black">
              <div class="row g-0">
                <div class="col-lg-6" style="background-color:#FFFFFF">
                  <div class="card-body p-md-5 mx-md-4">

                    <div class="text-center">
                      <img src="/img/logo-atrabajar.png"
                        style="width: 185px;" alt="logo">
                      <h4 class="mt-1 mb-5 pb-1">We are The Solucion Afore Team</h4>
                    </div>

                    <form>
                      <p>Ingresa la información de tu cuenta</p>

                      <div :class="'form-outline mb-4' + ($v.user.email.$invalid && submited?' has-error':'') ">
                        <input type="email" id="form2Example11" class="form-control" v-model="user.email" placeholder="Correo Electrónico" />
                        <label :class="'form-label' + ($v.user.email.$invalid && submited?' text-danger':'') " for="form2Example11">Correo Electrónico</label>
                      </div>

                      <div :class="'form-outline mb-4' + (($v.user.cntr.$invalid) && submited?' has-error':'') ">
                        <input type="password" id="form2Example22" class="form-control" v-model="user.cntr" placeholder="Contraseña"/>
                        <label :class="'form-label' + ($v.user.cntr.$invalid && submited?' text-danger':'') " for="form2Example22">Contraseña</label>
                      </div>

                      <p class="alert alert-danger control-label" v-if="$v.user.$invalid && submited">Existen campos pendientes de llenar en el formulario</p>

                      <p class="alert alert-danger control-label" v-if="mensajeUsuario != ''" v-html="mensajeUsuario"></p>

                      <div class="text-center pt-1 mb-5 pb-1">
                        <button @click="login" class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3" type="button">Ingresar</button>
                        <a class="text-muted" href="#" @click="olvidaste()">Olvidaste tu Contraseña?</a>
                      </div>

                      <div class="d-flex align-items-center justify-content-between pb-4">
                        <p class="mb-0 me-2">Tienes cuenta de acceso?</p>
                        <button type="button" class="btn btn-outline-danger" @click="crear()">Crear</button>
                      </div>

                    </form>

                  </div>
                </div>
                <div class="col-lg-6 d-flex align-items-center gradient-custom-2" style="background-color:#0090CC">
                  <div class="text-white px-3 py-4 p-md-5 mx-md-4" >
                    <h4 class="mb-4">We are more than just a company</h4>
                    <p class="small mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                      tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                      exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>


  </div>
</template>
<script>
  import Vue from 'vue'
  import axios from 'axios'
  import { validationMixin } from 'vuelidate'
  import { required, email } from 'vuelidate/lib/validators'

  export default {
    props: {
      backgroundColor: {
        type: String,
        default: 'black',
        validator: (value) => {
          let acceptedValues = ['', 'blue', 'azure', 'green', 'orange', 'red', 'purple', 'black']
          return acceptedValues.indexOf(value) !== -1
        }
      },
    },
    data () {
      return {
        user: {
          email: '',
          cntr: '' 
        },
        submited: false,
        mensajeUsuario: '' 
      }
    },
    mixins: [validationMixin],
    validations() { 
        return { 
          user: this.rules
        } 
    },
    computed: { 
        rules () {
            return {
              email: { required, email },
              cntr: { required }
            }
        }
    },
    methods: {
      login(){
        var self = this
        self.submited = true
        this.mensajeUsuario = '';
        if(self.$v.user.$invalid) return
        //e.preventDefault();

        Vue.showLoader();
        axios.post(process.env.VUE_APP_API_HOST_JS + '/login.php',  'email='+ self.user.email + ''  + '&cntr='+ self.user.cntr  )
        .then( respLogin => {
          Vue.hideLoader();
          //console.log( respLogin )
          //console.log( respLogin.data.estatus )

          if( respLogin ){
            if( respLogin.data ){
              if( respLogin.data.estatusUsuario ){
                if( respLogin.data.estatusUsuario == 'exito' ){
                  if( respLogin.data.habilitado == '0' ){
                    Vue.alert({ 'title': 'Aviso', 'html': 'Es necesario que se comunique con el adminsitrador del sistema para que confirme su acceso al sistema.',
                        'buttons': [ { title: 'Aceptar', handler: () => { } } ]
                    })
                  }else{
                    //Ir al administrador 
                    this.$router.push("/")
                  }
                }else{
                  self.errorLogin()
                }
              }else{ self.errorComunicacion() }
            }else{ self.errorComunicacion() }
          }else{ self.errorComunicacion() }
        })
        .catch(err => {
          self.errorComunicacion()
          Vue.hideLoader();
          console.log( 'error' )
        })
      },
      errorLogin(){
        this.mensajeUsuario = 'Usuario o Contraseña incorrectas';
        Vue.alert({ 'title': 'Aviso', 'html': 'Verifica tus credenciales, las cuales son incorrectas.',
            'buttons': [ { title: 'Aceptar', handler: () => { } } ]
        })
      },
      errorComunicacion(){
        this.mensajeUsuario = 'No se pudo estableces una conexion al servidor';
      },
      olvidaste(){
        Vue.showLoader();
        Vue.hideLoader();
        this.$router.push("/recoverPw/")
      },
      crear(){
        Vue.showLoader();
        Vue.hideLoader();
        this.$router.push("/registro/")
      }
    },
  }

</script>
<style>

</style>
