<template>
    <div class="full-page login-page" data-color="" data-image="img/background-2.jpg">
        <NavbarLogin />
        <!--   you can change the color of the filter page using: data-color="blue | azure | green | orange | red | purple" -->
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-md-offset-4 col-sm-offset-3">
                        <form @submit.prevent="resetPssw" action="index.html">
                            <div class="card" data-background="color" data-color="blue">
                                <div class="card-header">
                                    <h3 class="card-title">Actualizar mi Contraseña</h3>
                                </div>
                                <div class="card-content">
                                    <h4>Proporcione la siguiente información para actualizar su Contraseña:</h4>
                                    <br>
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
                                <div class="card-footer text-center">
                                    <button type="submit" class="btn btn-fill btn-wd ">Guardar</button>
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

        <div class="full-page-background" style="background-image: url(img/background-2.jpg) "></div>
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
    name: 'contraseniaTemporal',
    data() {
        return {
            submited:false,
            registro: {
                clave: '',
                claveCnfr: ''
            },
        }
    },
    mounted() {

    },
    mixins: [validationMixin],
    validations() { 
        return { 
            registro: this.rules,
        } 
    },
    computed: {
        rules () {
            return {
                clave: { required, minLength: minLength(6), goodPassword:(clave) => { 
                    return clave.length >= 6 &&
                    /[a-z]/.test(clave) &&
                    /[A-Z]/.test(clave) &&
                    /[0-9]/.test(clave)
                } },
                claveCnfr: { required, sameAsPassword: sameAs('clave') }
            }
        }
    },
    methods: {
        registroUsuario(){
            this.$router.push('/registro/'); this.$router.go(0)
        },
        resetPssw(e, data){
            var self = this
            self.submited = true
            //Validamos formulario
            if(self.$v.registro.$invalid) return

            e.preventDefault();

            axios.post(SID_API_HOST_JS + '/ws/rsetPssw.php',  'correo='+ store.getters.correo + '&cntr=' + self.registro.clave )
            .then(async resp => {

                if( resp.data.DatosJSON.length == 0 ){
                    Vue.alert({ 'title': 'Aviso', 'html': 'Ocurrio un error, por favor avise al administrador del sistema',
                        'buttons': [
                            {
                                title: 'Aceptar',
                                handler: () => { }
                            }
                        ]
                    })
                }else{
                    if( resp.data.DatosJSON[0].estatus == 'exito' ){
                        Vue.alert({ 'title': 'Aviso', 'html': 'Su clave de acceso al sistema se actualizo con exito',
                            'buttons': [
                                {
                                    title: 'Aceptar',
                                    handler: () => { 
                                        this.$store.dispatch('SET_CNTRTMPR', '0' ).then(() => {
                                            Vue.nextTick(() =>{
                                                if( this.$route.query.redirect ){
                                                    this.$router.push(this.$route.query.redirect); this.$router.go(0)
                                                    //window.location.href = this.$route.query.redirect
                                                }else{
                                                    this.$router.push('/'); this.$router.go(0)
                                                    //window.location.href ='/'
                                                }
                                            });
                                        })
                                    }
                                }
                            ]
                        })
                    }else if( resp.data.DatosJSON[0].estatus == 'error' ){
                        Vue.alert({ 'title': 'Aviso', 'html': 'Ocurrio un error, por favor avise al administrador del sistema',
                            'buttons': [
                                {
                                    title: 'Aceptar',
                                    handler: () => { }
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
