<template>
    <div class="full-page login-page" data-color="" data-image="img/lights.jpg">
        <NavbarLogin />
        <!--   you can change the color of the filter page using: data-color="blue | azure | green | orange | red | purple" -->
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-6 col-lg-offset-4 col-md-offset-3 col-sm-offset-3">
                        <form @submit.prevent="recoverPssw" action="index.html">
                            <div class="card" data-background="color" data-color="">
                                <div class="card-header">
                                    <h3 class="card-title">Olvide mi Contraseña</h3>
                                </div>
                                <div class="card-content">
                                    <h4>Proporcione la siguiente información para reestablecer su Contraseña del sistema:</h4>
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
                                    <div :class="'form-group ' + ($v.correo.telefono.$invalid && submitedMail?' has-error':'') ">
                                        <label>Telefono (10 dígitos)</label>
                                        <input v-model="correo.telefono" name="telefono" type="tel" placeholder="escribe tu número telefonico" class="form-control input-no-border" >
                                    </div>
                                    <div class="form-group has-error" v-if="$v.correo.$invalid && submitedMail">
                                        <label class="control-label">
                                            Existen campos pendientes de llenar en el formulario
                                        </label>
                                    </div>
                                </div>
                                <div class="card-footer text-center">
                                    <button type="submit" class="btn btn-fill btn-wd ">Siguiente</button>
                                    <!--
                                    <div class="forgot">
                                        <a href="javascript:void(0)" @click="recoverCntr">Olvidaste tu contraseña?</a>
                                    </div>
                                    -->
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
import NavbarLogin from '@/components/NavbarLogin.vue'
import Footer from '@/components/Footer.vue'
import axios from 'axios'
import { SID_API_HOST_JS } from '@/components/constants/config'
import { validationMixin } from 'vuelidate'
import { required, minLength, minValue, sameAs, email } from 'vuelidate/lib/validators'

export default {
    name: 'recoverPw',
    data() {
        return {
            submitedMail:false,
            correo:{
                correo: '',
                correoCnfr: '',
                telefono: ''
            }
        }
    },
    mounted() {

    },
    mixins: [validationMixin],
    validations() { 
        return { 
            correo: this.rulesMail 
        } 
    },
    computed: {
        rulesMail () {
            return {
                correo: { required, email },
                correoCnfr: { required, sameAsMail: sameAs('correo') },
                telefono: { required, minLength: minLength(10) }
            }
        }
    },
    methods: {
        registro(){
            this.$router.push('/registro/'); this.$router.go(0)
        },
        recoverPssw(e, data){
            var self = this
            self.submitedMail = true
            //Validamos formulario
            if(self.$v.correo.$invalid) return

            e.preventDefault();

            axios.post(SID_API_HOST_JS + '/ws/rcvrPssw.php',  'correo='+ self.correo.correo + '&telefono=' + self.correo.telefono )
            .then(async resp => {

                if( resp.data.DatosJSON.length == 0 ){
                    Vue.alert({ 'title': 'Aviso', 'html': 'El correo electronico proporcionado NO existe en el sistema, por favor verifique la información capturada',
                        'buttons': [
                            {
                                title: 'Aceptar',
                                handler: () => { }
                            }
                        ]
                    })
                }else{
                    if( resp.data.DatosJSON[0].estatus == 'reestablecida' && resp.data.DatosJSON[0].claveTemporal == 'enviada' ){
                        Vue.alert({ 'title': 'Aviso', 'html': 'Verificación de la información del Usuario con exito, por favor ingrese a su correo electronico para reestablecer su contraseña',
                            'buttons': [
                                {
                                    title: 'Aceptar',
                                    handler: () => { this.$router.push('/login/');  }
                                }
                            ]
                        })
                    }else if( resp.data.DatosJSON[0].estatus == 'error' && resp.data.DatosJSON[0].mensaje == 'usuario inactivo' ){
                        Vue.alert({ 'title': 'Aviso', 'html': 'Usuario inactivo, por favor contacte al administrador del sistema',
                            'buttons': [
                                {
                                    title: 'Aceptar',
                                    handler: () => { this.$router.push('/login/');  }
                                }
                            ]
                        })
                    }else if( resp.data.DatosJSON[0].estatus == 'error' && resp.data.DatosJSON[0].mensaje == 'usuario no existe' ){
                        Vue.alert({ 'title': 'Aviso', 'html': 'Información del Usuario invalida (correo o teléfono), por favor verifique la información capturada',
                            'buttons': [
                                {
                                    title: 'Aceptar',
                                    handler: () => {  }
                                }
                            ]
                        })
                    }else{
                        Vue.alert({ 'title': 'Aviso', 'html': 'Ocurrio un error, por favor avise al administrador del sistema',
                            'buttons': [
                                {
                                    title: 'Aceptar',
                                    handler: () => { }
                                }
                            ]
                        })
                    }
                }
            })
            .catch(err => {
                console.log( 'error' + err )
            })

        }
    },
    components: {
		NavbarLogin, Footer
	} 
}

</script>
