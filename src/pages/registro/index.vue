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
                    
                    <form @submit.prevent="verificaMail($event, $data)" v-show="mailVerificado == false">
                      <p>Verificar Correo</p>

                      <div :class="'form-outline mb-4' + ($v.correo.correo.$invalid && submitedMail?' has-error':'') ">
                        <input id="form2Example1" type="email" v-model="correo.correo" class="form-control" placeholder="Correo Electrónico" required />
                        <label :class="'form-label' + ($v.correo.correo.$invalid && submitedMail?' text-danger':'') ">Correo Electrónico</label>
                        <label class="form-label text-danger" v-if="!$v.correo.correo.email">&nbsp;&nbsp;( correo invalido )</label>
                      </div>

                      <div :class="'form-outline mb-4' + (($v.correo.correoCnfr.$invalid || $v.correo.correoCnfr.sameAsMail == false) && submitedMail?' has-error':'') " >
                        <input id="form2Example2" type="email" v-model="correo.correoCnfr" class="form-control" placeholder="Confirma tu Correo Electrónico" required/>
                        <label :class="'form-label' + ($v.correo.correoCnfr.$invalid && submitedMail?' text-danger':'') ">Confirma tu Correo Electrónico</label>
                        <label class="form-label text-danger" v-if="!$v.correo.correoCnfr.sameAsMail && correo.correo != '' && correo.correoCnfr != ''">&nbsp;&nbsp;( No coincide tu correo electronico )</label>
                        <label class="form-label text-danger" v-if="!$v.correo.correoCnfr.required && submitedMail && correo.correo != '' && correo.correoCnfr == ''">&nbsp;&nbsp;( Es necesario confirmar el correo electrónico )</label>
                      </div>

                      <p class="alert alert-danger control-label" v-if="$v.correo.$invalid && submitedMail">Existen campos pendientes de llenar en el formulario</p>

                      <p class="alert alert-warning control-label" v-if="mailVerificado == false && submitedRequestMail == true">El correo electronico proporcionado ya existe en el sistema, por favor verifique la información capturada</p>
                      
                      <div class="text-center pt-1 mb-5 pb-1">
                        <button class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3" type="submit">Verificar Correo</button>
                      </div>

                    </form>

                    <form @submit.prevent="registroUsuario($event, $data)" v-show="mailVerificado == true" >
                      <p>Registro de Usuario</p>

                      <div class="form-outline mb-4">
                        <input type="email" class="form-control" placeholder="Correo Electrónico" readonly="readonly" />
                        <label class="form-label">Correo Electrónico</label>
                      </div>

                      <div class="form-outline mb-4">
                        <input type="email" class="form-control" placeholder="Codigo enviado a tu Correo Electrónico" />
                        <label class="form-label">Codigo enviado a tu Correo Electrónico</label>
                      </div>

                      <div class="form-outline mb-4">
                        <input type="text" class="form-control" placeholder="Nombre" />
                        <label class="form-label">Nombre</label>
                      </div>

                      <div class="form-outline mb-4">
                        <input type="text" class="form-control" placeholder="Nombre" />
                        <label class="form-label">Apellido Paterno</label>
                      </div>

                      <div class="form-outline mb-4">
                        <input type="text" class="form-control" placeholder="Nombre" />
                        <label class="form-label">Apellido Materno</label>
                      </div>

                      <div class="form-outline mb-4">
                        <input type="text" class="form-control" placeholder="Nombre" />
                        <label class="form-label">Telefono (10 dígitos)</label>
                      </div>

                      <div class="form-outline mb-4">
                        <input type="password" class="form-control" placeholder="Contraseña" />
                        <label class="form-label">Contraseña (mínimo 6 caracteres, mayusculas, minusculas y números)</label>
                      </div>

                      <div class="form-outline mb-4">
                        <input type="password" class="form-control" placeholder="Confirma Contraseña" />
                        <label class="form-label">Confirma tu Contraseña</label>
                      </div>

                      <div class="text-center pt-1 mb-5 pb-1">
                        <button @click="registrarse" class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3" type="button">Registrarse</button>
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
  import axios from 'axios'
  import { validationMixin } from 'vuelidate'
  import { required, minLength, minValue, sameAs, email } from 'vuelidate/lib/validators'

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
          email: 'correo@dominio.com'
          
        },
        correoConfirmado: false, 

        submited:false,
        submitedMail:false,
        submitedRequestMail:false,
        mailVerificado:false,
        registro: {
            nombre: '',
            aPaterno: '',
            aMaterno: '',
            telefono: '',
            clave: '',
            claveCnfr: ''
        },
        correo:{
            correo: '',
            correoCnfr: ''
        }
      }
    },
    mixins: [validationMixin],
    validations() { 
        return { 
            registro: this.rules,
            correo: this.rulesMail 
        } 
    },
    computed: { 
        rules () {
            return {
                nombre: { required, minLength: minLength(3) },
                aPaterno: { required, minLength: minLength(5) },
                telefono: { required, minValue: minLength(10) },
                clave: { required, minLength: minLength(6), goodPassword:(clave) => { 
                    return clave.length >= 6 &&
                    /[a-z]/.test(clave) &&
                    /[A-Z]/.test(clave) &&
                    /[0-9]/.test(clave)
                } },
                claveCnfr: { required, sameAsPassword: sameAs('clave') }
            }
        },
        rulesMail () {
            return {
                correo: { required, email },
                correoCnfr: { required, sameAsMail: sameAs('correo') }
            }
        }
    },
    methods: {
      login(){
        this.$router.push("/admin/")
      },
      olvidaste(){
        this.$router.push("/recoverPw/")
      },
      crear(){
        this.$router.push("/registro/")
      },
      verificarCorreo(){
        this.correoConfirmado = true;
      },
      registrarse(){
        //this.$router.push("/admin/")
      },

      verificaMail(e, data){
        var self = this
        self.submitedMail = true

        //console.log( process.env.VUE_APP_API_HOST_JS )
        //return
        //Validamos formulario
        if(self.$v.correo.$invalid) return

        self.submitedRequestMail = false;
        e.preventDefault();

        axios.post(process.env.VUE_APP_API_HOST_JS + '/ws/vrfcMail.php',  'mail='+ self.correo.correo )
        .then(async resp => {
            self.submitedRequestMail = true;
            if( resp.data.DatosJSON.length == 0 ){
                self.mailVerificado = true;
            }else{
                if( resp.data.DatosJSON[0].estatus == 'inactivo' ){
                    Vue.alert({ 'title': 'Aviso', 'html': 'El usuario ya existe y este se encuentra inactivo, por favor contacte a su administrador',
                        'buttons': [
                            {
                                title: 'Aceptar',
                                handler: () => { }
                            }
                        ]
                    })
                }else if( resp.data.DatosJSON[0].estatus == 'existe' ){ //Existe correo en el sistema
                  Vue.alert({ 'title': 'Aviso', 'html': 'El correo electronico proporcionado ya existe, por favor verifique la información capturada',
                      'buttons': [
                          {
                              title: 'Aceptar',
                              handler: () => { }
                          }
                      ]
                  })
                }else if( resp.data.DatosJSON[0].estatus == 'insertado' ){ //No existe y procedemos al registro del usuario
                  self.mailVerificado = true;
                }  
            }
        })
        .catch(err => {
            console.log( 'error' + err )
        })
      },
      registroUsuario(e, data){
        var self = this
        this.submited = true
        if(self.$v.correo.$invalid) return
        if(self.$v.registro.$invalid) return
        e.preventDefault();
        
        axios.post(process.env.VUE_APP_API_HOST_JS + '/ws/altaUsuario.php',  'correo='+ self.correo.correo + '' + '&nombre='+ self.registro.nombre  + '&aPaterno='+ self.registro.aPaterno + '' + '&aMaterno='+ self.registro.aMaterno + '' + '&telefono='+ self.registro.telefono + '' + '&clave='+ self.registro.clave + ''  )
        .then(async resp => {
            if( resp.data.DatosJSON[0].estatus == 'insertado' ){
                let correo = self.correo.correo;
                self.resetVariables()
                Vue.alert({ 'title': 'Aviso', 'html': 'Usuario dado de alta con exito, por favor ingrese a su correo electronico ('+correo+') para concluir con su registro.',
                    'buttons': [
                        {
                            title: 'Aceptar',
                            handler: () => { this.$router.push('/login/'); this.$router.go(0) }
                        }
                    ]
                })
            }else if( resp.data.DatosJSON[0].estatus == 'error' ){
                if(  resp.data.DatosJSON[0].mensaje == 'correo existente' ){
                    self.resetVariables()
                    Vue.alert({ 'title': 'Aviso', 'html': 'Este correo electronico ya existe en el sistema, por favor verifique la información capturada',
                        'buttons': [
                            {
                                title: 'Aceptar',
                                handler: () => { }
                            }
                        ]
                    })
                }else{
                    Vue.alert({ 'title': 'Aviso', 'html': 'Ocurrio un error al dar de alta el usuario - ' + resp.data.DatosJSON[0].mensaje,
                        'buttons': [
                            {
                                title: 'Aceptar',
                                handler: () => { }
                            }
                        ]
                    })
                }
                
            }else{
                Vue.alert({ 'title': 'Aviso', 'html': 'Ocurrio un error al dar de alta el usuario',
                    'buttons': [
                        {
                            title: 'Aceptar',
                            handler: () => { }
                        }
                    ]
                })
            }
        })
        .catch(err => {
            console.log( 'error' )
        })
      }
    },
    mounted() {
      //this.correoConfirmado = false;
    }
  }

</script>
<style>

</style>
