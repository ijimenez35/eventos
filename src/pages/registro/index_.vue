<template>
    <div class="full-page login-page" data-color="" data-image="img/lights.jpg">
        <NavbarLogin />
        <!--   you can change the color of the filter page using: data-color="blue | azure | green | orange | red | purple" -->
        <div class="content" style="padding-top: 9vh;">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-8 col-lg-offset-3 col-md-offset-3 col-sm-offset-2">
                        <form @submit.prevent="verificaMail($event, $data)" v-show="mailVerificado == false">
                            <div class="card" data-background="color" data-color="">
                                <div class="card-header">
                                    <h3 class="card-title">Registro de Usuario</h3>
                                </div>
                                <div class="card-content">
                                    <h4>Proporcione la siguiente información para realizar su registro al sistema de Ligas:</h4>
                                    <br>
                                    <div :class="'form-group ' + ($v.correo.correo.$invalid && submitedMail?' has-error':'') ">
                                        <label>Correo Electrónico</label>
                                        <input v-model="correo.correo" name="correo" type="email" placeholder="escribe tu correo electrónico" class="form-control input-no-border" >
                                    </div>
                                    <div :class="'form-group ' + (($v.correo.correoCnfr.$invalid || $v.correo.correoCnfr.sameAsMail == false) && submitedMail?' has-error':'') ">
                                        <label>Confirma tu Correo Electrónico </label> 
                                        <input v-model="correo.correoCnfr"  name="correoCnfr" type="email" placeholder="escribe tu correo electr´ónico" class="form-control input-no-border" >
                                    </div>
                                    <div class="form-group has-error" v-if="!$v.correo.correoCnfr.required && submitedMail && correo.correo != ''">
                                        <label class="control-label">
                                            Es necesario confirmar el correo electrónico
                                        </label>
                                    </div>
                                    <div class="form-group has-error" v-if="!$v.correo.correoCnfr.sameAsMail && correo.correo != '' && correo.correoCnfr != ''">
                                        <label class="control-label">
                                            No coincide tu correo electronico
                                        </label>
                                    </div>
                                    <div class="form-group has-error" v-if="$v.correo.$invalid && submitedMail">
                                        <label class="control-label">
                                            Existen campos pendientes de llenar en el formulario
                                        </label>
                                    </div>
                                    <div class="form-group has-error" v-if="mailVerificado == false && submitedRequestMail == true">
                                        <label class="control-label">
                                            El correo electronico proporcionado ya existe en el sistema, por favor verifique la información capturada
                                        </label>
                                    </div>
                                </div>
                                <br>
                                <div class="card-footer text-center">
                                    <button type="submit" class="btn btn-fill btn-wd ">Verificar Correo</button>
                                </div>
                            </div>
                        </form>
                        <form @submit.prevent="registroUsuario($event, $data)" v-show="mailVerificado == true" >
                            <div class="card" data-background="color" data-color="blue">
                                <div class="card-header">
                                    <h3 class="card-title">Registro de Usuario</h3>
                                </div>
                                <div class="card-content">
                                    <h4>Proporcione la siguiente información para finalizar su registro:</h4>
                                    <br>
                                    <div class="form-group">
                                        <label>Correo Electrónico</label>
                                        <input v-model="correo.correo" name="correo" type="email" class="form-control input-no-border" readonly="readonly" >
                                    </div>
                                    <div :class="'form-group ' + ($v.registro.nombre.$invalid && submited?' has-error':'') ">
                                        <label>Nombre</label>
                                        <input v-model="registro.nombre" name="nombre" type="text" placeholder="escribe tu nombre" class="form-control input-no-border" >
                                    </div>
                                    <div :class="'form-group ' + ($v.registro.aPaterno.$invalid && submited?' has-error':'') ">
                                        <label>Apellido Paterno</label>
                                        <input v-model="registro.aPaterno" name="aPaterno" type="text" placeholder="escribe tu apellido paterno" class="form-control input-no-border" >
                                    </div>
                                    <div class="form-group">
                                        <label>Apellido Materno</label>
                                        <input v-model="registro.aMaterno" name="aMaterno" type="text" placeholder="escribe tu apellido materno" class="form-control input-no-border" >
                                    </div>
                                    <div :class="'form-group ' + ($v.registro.telefono.$invalid && submited?' has-error':'') ">
                                        <label>Telefono (10 dígitos)</label>
                                        <input v-model="registro.telefono" name="telefono" type="tel" placeholder="escribe tu número telefonico" class="form-control input-no-border" >
                                    </div>

                                    <div :class="'form-group ' + ($v.registro.clave.$invalid && submited?' has-error':'') ">
                                        <label>Contraseña (mínimo 6 caracteres, mayusculas, minusculas y números)</label>
                                        <input v-model="registro.clave" name="clave" type="password" placeholder="escribe tu constraseña" class="form-control input-no-border" >
                                    </div>
                                    <div class="form-group has-error" v-if="!$v.registro.clave.goodPassword && registro.clave != ''">
                                        <label class="control-label">La contraseña NO cumple con los requerimientos mínimos de seguridad (mínimo 6 caracteres, mayusculas, minusculas y números)</label>
                                    </div>

                                    <div :class="'form-group ' + ($v.registro.claveCnfr.$invalid && submited?' has-error':'') ">
                                        <label>Confirma tu Contraseña</label>
                                        <input v-model="registro.claveCnfr" name="claveCnfr" type="password" placeholder="confirma tu constraseña" class="form-control input-no-border" >
                                    </div>
                                    <div class="form-group has-error" v-if="!$v.registro.claveCnfr.required && submited && registro.clave">
                                        <label class="control-label">Es necesario confirmar la contraseña</label>
                                    </div>
                                    <div class="form-group has-error" v-if="!$v.registro.claveCnfr.sameAsPassword  && submited && registro.claveCnfr != ''">
                                        <label class="control-label">No coincide las contraseñas</label>
                                    </div>

                                    <div class="form-group has-error" v-if="$v.registro.$invalid && submited">
                                        <label class="control-label">
                                            Existen campos pendientes de llenar en el formulario
                                        </label>
                                    </div>
                                </div>
                                <br>
                                <div class="card-footer text-center">
                                    <button type="submit" class="btn btn-fill btn-wd ">Registrarse</button> 
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <Footer />

        <div class="full-page-background" style="background-image: url(img/lights.jpg) "></div>
    </div>
</template>
<script>

import Vue from 'vue'
import store from '@/store'
import axios from 'axios'
import Footer from '@/components/Footer.vue'
import NavbarLogin from '@/components/NavbarLogin.vue'
import { AUTH_REQUEST } from '@/store/actions/auth'
import { AUTH_LOGOUT } from '@/store/actions/auth'
import { SID_API_HOST_JS } from '@/components/constants/config'
import { validationMixin } from 'vuelidate'
import { required, minLength, minValue, sameAs, email } from 'vuelidate/lib/validators'

export default {
    name: 'Registro',
    data() {
        return {
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
    mounted() {

        /*
         (function ($) {
            var $inputsMail = $('input[name=correo],input[name=correoCnfr]');
            $inputsMail.on('input', function () {
                if( $('input[name=correo]').val().length > 0 &&  $('input[name=correoCnfr]').val().length > 0 ){
                    if( $('input[name=correo]').val() !=  $('input[name=correoCnfr]').val() ){
                        $('input[name=correo], input[name=correoCnfr]').attr('oninvalid', 'this.setCustomValidity(\'Los correos no son iguales\')' )
                        $inputsMail.not(this).prop('required', false);
                    }
                }
            });
            var $inputsClave = $('input[name=clave],input[name=claveCnfr]');
            $inputsClave.on('input', function () {
                if( $('input[name=clave]').val().length > 0 &&  $('input[name=claveCnfr]').val().length > 0 ){
                    if( $('input[name=clave]').val() !=  $('input[name=claveCnfr]').val() ){
                        $('input[name=clave], input[name=claveCnfr]').attr('oninvalid', 'this.setCustomValidity(\'Las claves no son iguales\')' )
                        $inputsClave.not(this).prop('required', false);
                    }
                }
            });

        })(JQuery);

        */

    },
    methods: {
        verificaMail(e, data){
            var self = this
            self.submitedMail = true
            //Validamos formulario
            if(self.$v.correo.$invalid) return

            self.submitedRequestMail = false;
            e.preventDefault();

            axios.post(SID_API_HOST_JS + '/ws/vrfcMail.php',  'mail='+ self.correo.correo )
            .then(async resp => {
                self.submitedRequestMail = true;
                if( resp.data.DatosJSON.length == 0 ){
                    self.mailVerificado = true;
                }else{
                    if( resp.data.DatosJSON[0].estatus == '0' ){
                        Vue.alert({ 'title': 'Aviso', 'html': 'El usuario ya existe y este se encuentra inactivo, por favor contacte a su administrador',
                            'buttons': [
                                {
                                    title: 'Aceptar',
                                    handler: () => { }
                                }
                            ]
                        })
                    }else{
                        Vue.alert({ 'title': 'Aviso', 'html': 'El correo electronico proporcionado ya existe, por favor verifique la información capturada',
                            'buttons': [
                                {
                                    title: 'Aceptar',
                                    handler: () => { }
                                }
                            ]
                        })
                    }
                    self.mailVerificado = false;
                }
            })
            .catch(err => {
                console.log( 'error' + err )
            })

        },
        resetVariables(){
            this.submite=false
            this.submitedMail=false
            this.submitedRequestMail=false
            this.mailVerificado=false
            this.registro= {
                nombre: '',
                aPaterno: '',
                aMaterno: '',
                telefono: '',
                clave: '',
                claveCnfr: ''
            }
            this.correo={
                correo: '',
                correoCnfr: ''
            }
        },
        registroUsuario(e, data){
            var self = this
            this.submited = true
            if(self.$v.correo.$invalid) return
            if(self.$v.registro.$invalid) return
            e.preventDefault();
            
            axios.post(SID_API_HOST_JS + '/ws/altaUsuario.php',  'correo='+ self.correo.correo + '' + '&nombre='+ self.registro.nombre  + '&aPaterno='+ self.registro.aPaterno + '' + '&aMaterno='+ self.registro.aMaterno + '' + '&telefono='+ self.registro.telefono + '' + '&clave='+ self.registro.clave + ''  )
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
        },
        salir(){
            this.$store.dispatch(AUTH_LOGOUT).then( 
                () => { this.$router.push('/login/'); this.$router.go(0) } 
            )
        },
    },
    components: {
		NavbarLogin, Footer
	} 
}

</script>
