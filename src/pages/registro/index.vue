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
                        <label class="form-label text-danger" v-if="!$v.correo.correoCnfr.sameAsMail && correo.correo != '' && correo.correoCnfr != ''">&nbsp;&nbsp;( No coincide tu correo electrónico )</label>
                        <label class="form-label text-danger" v-if="!$v.correo.correoCnfr.required && submitedMail && correo.correo != '' && correo.correoCnfr == ''">&nbsp;&nbsp;( Es necesario confirmar el correo electrónico )</label>
                      </div>

                      <p class="alert alert-danger control-label" v-if="$v.correo.$invalid && submitedMail">Existen campos pendientes de llenar en el formulario</p>
                      <p class="alert alert-danger control-label" v-if="mailVerificado == false && submitedRequestMail == true && mailExiste == true">El correo electrónico proporcionado ya existe en el sistema, por favor verifique la información capturada</p>
                      <p class="alert alert-warning control-label" v-if="codigoEnviado == true && submitedRequestMail == true">Ya ha sido enviado un mensaje a su correo con el código de verificación.</p>
                      
                      <div class="text-center pt-1 mb-5 pb-1">
                        <button class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3" type="submit" >Verificar Correo</button>
                        <button class="btn btn-success btn-block fa-lg gradient-custom-2 mb-3" type="button" @click="registrarse" v-if="codigoEnviado == true && submitedRequestMail == true">Ya tengo mi Código !</button>
                        <button class="btn btn-warning btn-block fa-lg gradient-custom-2 mb-3" type="button" @click="reenviarCodigo(correo.correo)" v-if="codigoEnviado == true && submitedRequestMail == true">Enviar otro Código !</button>
                      </div>


                    </form>

                    <form @submit.prevent="registroUsuario($event, $data)" v-show="mailVerificado == true" >
                      <p>Registro de Usuario</p>

                      <div :class="'form-outline mb-4' + ($v.registro.correo.$invalid && submited?' has-error':'') ">
                        <input type="email"  class="form-control" v-model="registro.correo" placeholder="Correo Electrónico" readonly="readonly" />
                        <label :class="'form-label' + ($v.registro.correo.$invalid && submited?' text-danger':'') ">Correo Electrónico</label>
                      </div>

                      <!---
                      <div :class="'form-outline mb-4' + ($v.registro.codigo.$invalid && submited?' has-error':'') ">
                        <input type="text" class="form-control" v-model="registro.codigo" placeholder="Codigo enviado a tu Correo Electrónico" />
                        <label :class="'form-label' + ($v.registro.codigo.$invalid && submited?' text-danger':'') ">Código enviado a tu Correo Electrónico</label>
                      </div>
                      -->
                      

                      <div :class="'input-group mb-4' + ($v.registro.codigo.$invalid && submited?' has-error':'') ">
                        <input type="text" class="form-control" v-model="registro.codigo" placeholder="Código de Verificación" minlength="3" maxlength="5">
                        <div class="input-group-append">
                          <button class="btn btn-outline-secondary" type="button" style="padding: 6px 16px;" @click="reenviarCodigo(registro.correo)">Enviar Otro</button>
                        </div>
                        <label style="margin-top:5px;" :class="'form-label' + ($v.registro.codigo.$invalid && submited?' text-danger':'') ">Código enviado a tu Correo Electrónico</label>
                      </div>

                      <div :class="'form-outline mb-4' + ($v.registro.nombre.$invalid && submited?' has-error':'') ">
                        <input type="text" class="form-control" v-model="registro.nombre" placeholder="Nombre" />
                        <label :class="'form-label' + ($v.registro.nombre.$invalid && submited?' text-danger':'') ">Nombre</label>
                      </div>

                      <div :class="'form-outline mb-4' + ($v.registro.aPaterno.$invalid && submited?' has-error':'') ">
                        <input type="text" class="form-control" v-model="registro.aPaterno" placeholder="Apellido Paterno" />
                        <label :class="'form-label' + ($v.registro.aPaterno.$invalid && submited?' text-danger':'') ">Apellido Paterno</label>
                      </div>

                      <div :class="'form-outline mb-4' + ($v.registro.aMaterno.$invalid && submited?' has-error':'') ">
                        <input type="text" class="form-control" v-model="registro.aMaterno" placeholder="Apellido Materno" />
                        <label :class="'form-label' + ($v.registro.aMaterno.$invalid && submited?' text-danger':'') ">Apellido Materno</label>
                      </div>

                      <div :class="'form-outline mb-4' + ($v.registro.telefono.$invalid && submited?' has-error':'') ">
                        <input type="text" class="form-control" v-model="registro.telefono" placeholder="Telefono (10 dígitos)" minlength="10" maxlength="10" />
                        <label :class="'form-label' + ($v.registro.telefono.$invalid && submited?' text-danger':'') ">Telefono (10 dígitos)</label>
                      </div>

                      <div :class="'form-outline mb-4' + ($v.registro.clave.$invalid && submited?' has-error':'') ">
                        <input type="password" class="form-control" v-model="registro.clave" placeholder="Contraseña (mínimo 6 caracteres, mayusculas, minusculas y números)" />
                        <label :class="'form-label' + ($v.registro.clave.$invalid && submited?' text-danger':'') ">Contraseña (mínimo 6 caracteres, mayusculas, minusculas y números)</label>
                      </div>

                      <div :class="'form-outline mb-4' + (($v.registro.claveCnfr.$invalid || $v.registro.claveCnfr.sameAsPassword == false) && submited?' has-error':'') ">
                        <input type="password" class="form-control" v-model="registro.claveCnfr" placeholder="Confirma tu Contraseña" />
                        <label :class="'form-label' + ($v.registro.claveCnfr.$invalid && submited?' text-danger':'') ">Confirma tu Contraseña</label>
                        <label class="form-label text-danger" v-if="!$v.registro.claveCnfr.sameAsPassword && registro.clave != '' && registro.claveCnfr != ''">&nbsp;&nbsp;( No coincide tu contraseña )</label>
                      </div>

                      <div class="text-center pt-1 mb-5 pb-1">
                        <button class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3" type="submit">Registrarse</button>
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
  import { required, minLength, minValue, sameAs, email, numeric } from 'vuelidate/lib/validators'

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
        codigoEnviado:false,
        registro: {
            correo: '',
            codigo: '',
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
                correo: { required, email },
                codigo: { required, minLength: minLength(3), numeric },
                nombre: { required, minLength: minLength(3) },
                aPaterno: { required, minLength: minLength(5) },
                aMaterno: { minLength: minLength(5) },
                telefono: { required, minLength: minLength(10), numeric },
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
      resetVariables(){
        var self = this;
        self.correoConfirmado = false
        self.submited = false
        self.submitedMail = false
        self.submitedRequestMail = false
        self.mailVerificado = false
        self.codigoEnviado = false
        self.registro = {
            correo: '',
            codigo: '',
            nombre: '',
            aPaterno: '',
            aMaterno: '',
            telefono: '',
            clave: '',
            claveCnfr: ''
        },
        self.correo = {
            correo: '',
            correoCnfr: ''
        }
      },
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
        var self = this
        self.mailVerificado = true;
        self.registro.correo = self.correo.correo;
      },
      reenviarCodigo(correo){
        var self = this
        axios.post(process.env.VUE_APP_API_HOST_JS + '/vrfcMail.php', 'mail='+ correo+'&accion=1' )
        .then(async respReenviarCodigo => {
          if( respReenviarCodigo.data.DatosJSON.length > 0){
            if( respReenviarCodigo.data.DatosJSON[0].estatus == 'insertado' || respReenviarCodigo.data.DatosJSON[0].estatus == 'actualizado' ){
              Vue.alert({ 'title': 'Aviso', 'html': 'Código enviado al correo porporcionado:<br> <b>'+correo+'</b> <br>Por favor verifique su bandeja de entrada.', 'typeModal': 'modal-md',
                  'buttons': [ { title: 'Aceptar' } ]
              })
            }
          }
        })
        .catch(err => {
          console.log( 'error, no se pudo reenviar el codigo' + err )
        })
      },
      verificaMail(e, data){
        var self = this
        self.submitedMail = true
        self.mailVerificado = false
        self.mailExiste = false
        self.codigoEnviado = false
        if(self.$v.correo.$invalid) return

        self.submitedRequestMail = false;
        e.preventDefault();

        axios.post(process.env.VUE_APP_API_HOST_JS + '/vrfcMail.php', 'mail='+ self.correo.correo )
        .then(async resp => {
            //{"DatosJSON":[{"ID":"2","estatus":"actualizado","mensaje":"codigo actualizado","correo":"ijimenez35@gmail.com","confirmacionCorreo":"enviada"}]}
            self.submitedRequestMail = true;
            if( resp.data.DatosJSON.length > 0){
              if( resp.data.DatosJSON[0].estatus == 'enviado' ){
                self.codigoEnviado = true
                Vue.alert({ 'title': 'Aviso', 'html': 'Ya ha sido enviado un mensaje al correo electrónico:<br> <b>'+self.correo.correo+'</b> <br> Por favor verifica la bandeja para obtener el código de verificación y asi continuar.', 'typeModal': 'modal-md', 
                    'buttons': [
                        {
                          class: 'btn-success', 
                          title: 'Ya tengo mi Código !',
                          handler: () => { 
                            self.registrarse()
                            //self.mailVerificado = true;
                            //self.registro.correo = self.correo.correo;
                          }
                        },
                        {
                          cerrar: false, title: 'Enviar otro Código',
                          handler: () => {
                            axios.post(process.env.VUE_APP_API_HOST_JS + '/vrfcMail.php', 'mail='+ self.correo.correo+'&accion=1' )
                            .then(async respRnvr => {
                              if( respRnvr.data.DatosJSON.length > 0){
                                if( resp.data.DatosJSON[0].estatus == 'insertado' || resp.data.DatosJSON[0].estatus == 'actualizado' ){
                                  self.codigoEnviado = true
                                  self.mailVerificado = true;
                                  self.registro.correo = self.correo.correo;
                                  Vue.alert({ 'title': 'Aviso', 'html': 'Código enviado al correo porporcionado:<br> <b>'+self.registro.correo+'</b> <br>Por favor verifique su bandeja de entrada.', 'typeModal': 'modal-md',
                                    'buttons': [ { title: 'Aceptar' } ]
                                  })
                                }else{
                                  self.mailExiste = true
                                  Vue.alert({ 'title': 'Aviso', 'html': 'El correo electrónico proporcionado se encuentra registrado en el sistema, por favor verifique la información capturada',
                                      'buttons': [ { title: 'Aceptar', handler: () => { } } ]
                                  })
                                }
                              }else{
                                console.log( 'error en vrfcMail' )
                              }
                            })
                            .catch(err => {
                              console.log( 'error, no se pudo reenviar el codigo' + err )
                            })
                          }
                        }
                    ]
                })
                
              }else if( resp.data.DatosJSON[0].estatus == 'insertado' || resp.data.DatosJSON[0].estatus == 'actualizado' ){ //No existe y procedemos al registro del usuario
                self.codigoEnviado = true;
                self.mailVerificado = true;
                self.registro.correo = self.correo.correo;
                Vue.alert({ 'title': 'Aviso', 'html': 'Código enviado al correo porporcionado:<br> <b>'+self.registro.correo+'</b> <br>Por favor verifique su bandeja de entrada.', 'typeModal': 'modal-md',
                  'buttons': [ { title: 'Aceptar' } ]
                })
              }else{
                self.mailExiste = true
                //self.correo.correo = '';
                //self.correo.correoCnfr = '';
                //self.submitedMail = false;
                Vue.alert({ 'title': 'Aviso', 'html': 'El correo electrónico proporcionado se encuentra registrado en el sistema, por favor verifique la información capturada',
                    'buttons': [ { title: 'Aceptar', handler: () => { } } ]
                })
              }
            }else{
              console.log( 'error JSON vacio' )
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
        
        axios.post(process.env.VUE_APP_API_HOST_JS + '/registro.php',  'correo='+ self.registro.correo + ''  + '&codigo='+ self.registro.codigo + '&nombre='+ self.registro.nombre  + '&aPaterno='+ self.registro.aPaterno + '' + '&aMaterno='+ self.registro.aMaterno + '' + '&telefono='+ self.registro.telefono + '' + '&clave='+ self.registro.clave + ''  )
        .then(async resp => {
            if( resp.data.DatosJSON[0].estatus == 'insertado' ){
                self.resetVariables()
                Vue.alert({ 'title': 'Aviso', 'html': 'Usuario registrado con exito, por favor inicie sesion en el sistema.',
                    'buttons': [
                        {
                            title: 'Iniciar Sesión',
                            handler: () => { this.$router.push('/login/'); this.$router.go(0) }
                        }
                    ]
                })
            }else if( resp.data.DatosJSON[0].estatus == 'error' ){
                if( resp.data.DatosJSON[0].mensaje == 'correo no confirmado' ){
                  Vue.alert({ 'title': 'Aviso', 'html': 'Codigo de verificación incorrecto, por favor verifique la información capturada',
                      'buttons': [
                          {
                              title: 'Aceptar',
                              handler: () => { }
                          }
                      ]
                  })
                }else if( resp.data.DatosJSON[0].mensaje == 'correo existe' ){
                    self.resetVariables()
                    Vue.alert({ 'title': 'Aviso', 'html': 'Este correo electroníco ya existe en el sistema, por favor verifique la información capturada',
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
