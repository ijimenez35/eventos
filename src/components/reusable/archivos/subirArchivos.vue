<template>
    <div class="white-box">
        <div v-show="(showInst)">
            <h3>Subir Archivo</h3>
            <p class="messageBlue">
                <b>Instrucciones:</b> 
                <br>
                <span v-if="(ancho!='0' && alto!='0') && ( ancho.length>0 && alto.length>0 ) " >
                    Las especificaciones permitidas de la/s imagen/es a subir es: {{ancho}}px Ancho por {{alto}}px Alto.
                    <br>
                </span>
                <span v-if="ext.length>0 || exts.length>0">
                    Extensiones de archivos permitidas: *.{{fileExtensions.replace(/ /g, ', *.')}}
                </span>
                <br>
                Para finalizar, haga click sobre el botón Subir.
            </p>
            <hr>
        </div>
        <input type="file" id="input-file-now" class="dropify" ref="file"
            v-on:change="onChangeFileUpload()" 
            :disabled="cargando"
            :data-allowed-file-extensions="((exts && exts.length>0)? exts.toString().replace(/,/g,' '): (ext.length>0?ext:'*'))"
            :data-min-width="(parseInt(ancho)-1)" :data-max-width="(parseInt(ancho)+1)"
            :data-min-height="(parseInt(alto)-1)" :data-max-height="(parseInt(alto)+1)"
            :data-max-file-size="((ext && ext.indexOf('jpg')>=0)?'2M':'100M')" 
        />

        <button @click="submitForm" v-show="false"> Subir </button>
        <br>
        <div v-show="cargando">
            <div class="progress progress-lg">
                <label class="control-label" v-if="uploadPercentage===0" >
                    Preparando archivo ...
                </label>
                <div class="progress-bar progress-bar-success" :style="'width: '+uploadPercentage+'%;'" role="progressbar" v-else>
                    {{ uploadPercentage }}%
                </div>
            </div>
        </div>
        <div class="has-error" v-show="labelErrorDocumento.length>0" >
            <label class="control-label">
                {{labelErrorDocumento}}
            </label>
        </div>
    </div>

</template>

<script>
    import Vue from 'vue'
    import axios from 'axios'
    
    export default {
        name: 'subirDocumentos',
        props: {
            ruta: {type: String, default: ''},
            archivo: {type: String, default: ''},
            ext: { type: String, required: true },
            exts: {type: Array, default: null},
            ancho: {type: String, default: '0'},
            alto: {type: String, default: '0'},
            afterUpload: { type: Function, default: function () { } }
        },
        data() {
            return {
                file: '',
                fileError: '',
                uploadPercentage: 0,
                cargando: false,
                labelErrorDocumento: '',
                fileExtensions: '',
                showInst: false,
                inputAttr: {}
            }
        },
        methods: {
            submit() {
                var self = this
            },
            cargoArchivo( response ){
                Vue.hideLoader();
                var self = this
                //Cerrar el cargando
                setTimeout(() => {
                    self.cargando = false;
                    //console.log(response)
                    self.afterUpload( response );
                    //Cerrar
                    self.$emit('close', '')
                }, 100);
            },
            verificaDisponibleArchivo( archivo, response){
                var self = this
                Vue.archivos( { 'psRuta': archivo } )
                .then( respArch => { 
                    if( respArch ){
                        if(respArch.length > 0){
                            console.log('existe')
                            self.cargoArchivo( response )
                        }else{
                            console.log('no disponible')
                            setTimeout(()=>{
                                self.verificaDisponibleArchivo( archivo, response )
                            }, 1000);
                        }
                    }
                })
            },
            submitForm() {
                var self = this

                if(self.file===''){
                    self.labelErrorDocumento = 'Primero selecciona un archivo.'
                    return
                }
                if( self.cargando){
                    return 
                }

                if(self.file!=='error'){
                    self.$emit('ocultarCancelar', true)
                    self.cargando = true;
                    self.labelErrorDocumento = ''
                    let formData = new FormData();
                    formData.append('objFile', self.file);
                    //formData.append('psRuta', '/docs/archdgtl/AfldDrvd/cntrt/temp3/1372/1646904785/');
                    if (self.archivo != '') {
                        formData.append('nombre', self.archivo);
                    }
                    formData.append('ruta', self.ruta);
                    
                    let config = {
                        onDownloadProgress: function (progressEvent) {
                            self.uploadPercentage = parseInt(Math.round(( progressEvent.loaded * 100 ) / progressEvent.total));
                        }
                    }
                    axios.post(
                        process.env.VUE_APP_API_HOST_JS + '/uploadFile.php',
                        formData,
                        config
                    )
                    .then(response => {
                        Vue.showLoader();
                        if( response.data.DatosJSON[0].nombre != '' && response.data.DatosJSON[0].path != '' ){
                            self.verificaDisponibleArchivo( response.data.DatosJSON[0].path + response.data.DatosJSON[0].nombre, response )
                        }else{
                            self.verificaDisponibleArchivo( response.data.DatosJSON[0].path, response )
                        }                        
                    })
                    .catch((error) => {
                        self.cargando = false;
                        self.$emit('ocultarCancelar', false)
                        console.log('ERROR   ', error)
                    })

                } else {
                    self.labelErrorDocumento = 'Revisa las especificaciones, al parecer hay un error con el archivo: ' + self.fileError.name
                }
            },
            onChangeFileUpload() {
                this.file = this.$refs.file.files[0];
                this.fileError = this.$refs.file.files[0];
            }
        },
        mounted() {
            var self = this;
            $(function () {

                self.fileExtensions = (self.ext.length>0?self.ext:'*.*');
                if(self.exts && self.exts.length>0){
                    self.fileExtensions = self.exts.toString().replace(/,/g," ")
                }

                if(self.ext.length>0 && self.ancho!=='0' && self.alto!=='0'){
                    self.showInst=true;
                }

                var drEvent = $('.dropify').dropify({
                    messages: {
                        default: 'Arrastre y suelte sus archivos o haga clic para seleccionarlo desde su equipo',
                        replace: 'Arrastre y suelte sus archivos o haga clic para seleccionarlo desde su equipo',
                        remove: 'Quitar Archivo',
                        error: 'Ocurrió un error al subir el archivo'
                    },
                    error: {
                        'fileSize': 'El tamaño del archivo es demasiado grande ({{ value }} máx).',
                        'minWidth': 'El ancho de la imagen es demasiado pequeño ('+self.ancho+'px mín).',
                        'maxWidth': 'El ancho de la imagen es demasiado grande ('+self.ancho+'px máx).',
                        'minHeight': 'La altura de la imagen es demasiado pequeña ('+self.alto+'px mín).',
                        'maxHeight': 'La altura de la imagen es demasiado grande ('+self.alto+'px máx).',
                        'imageFormat': 'El formato de imagen no está permitido ({{ value }} solamente).',
                        'fileExtension': 'El archivo no esta permitido ( archivo con extension '+self.fileExtensions+' solamente).'
                    }
                });

                drEvent.on('dropify.errors', function(event, element){
                    self.file = 'error';
                });

            });
        }
    }
</script>
