<template>
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card" >
            <div class="card-header">
              <h4 class="card-title">Imagenes de Zonas</h4>
            </div>
            <div class="card-body">
              <p class="card-category">Listado de Imagenes asignados a cada ZONA</p>
              <!--Listado-->
              <div class="row" >
                <div class="col-md-12">
                  <table class="table table-hover table-striped">
                    <thead>
                      <tr>
                        <th></th>
                        <th>Nombre</th>
                        <th>Fecha Creación</th>
                        <th>OPCIONES</th>
                      </tr>
                    </thead>
                    <tbody >
                      <tr v-for="(registro, index) in registros" :key="index" >
                        <th>
                          <svg style="color: rgb(244, 135, 11);" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-file-image" viewBox="0 0 16 16"> <path d="M8.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z" fill="#f4870b"></path> <path d="M12 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zM3 2a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v8l-2.083-2.083a.5.5 0 0 0-.76.063L8 11 5.835 9.7a.5.5 0 0 0-.611.076L3 12V2z" fill="#f4870b"></path> </svg>
                        </th>
                        <td>{{ registro.basename }}</td>
                        <td>{{ registro.fechaCreacion }}</td>
                        <td>
                          <button type="button" class="btn btn-primary " @click="ver( registro )">
                            Ver 
                          </button>
                          &nbsp;
                          <a class="btn btn-warning " :href="'http://solucionafore.com/'+ruta+'/' + registro.basename " :download="registro.basename">
                              Descargar
                          </a>
                          &nbsp;
                          <button type="button" class="btn btn-danger " @click="eliminar( registro )">
                            Eliminar 
                          </button>
                        </td>
                      </tr>
                    </tbody> 
                  </table>

                  <span v-show="procesando == false && registros.length == 0">Sin Información </span> 
                  <span v-show="procesando == true">Procesando Información</span> 

                </div>
              </div>

              <!--Opciones-->
              <div class="row" >
                <div class="col-md-12">
                  <button type="button" class="btn btn-success btn-lg btn-block" @click="subirArchivo()">
                    Subir HTML
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
  import Vue from 'vue'
  import archivoTemplate from 'src/components/reusable/archivos/archivoTemplate.vue'
  export default {
    data () {
      return {
        registros: [],
        procesando: false,
        ruta: '/img_claveunica/'
      }
    },
    methods: {
      subirArchivo(){

      },
      getData(){
        var self = this 
        self.registros = [];
        var psPtrn = ''

        self.procesando = true;
        Vue.showLoader();

        var params = { 'ruta': self.ruta }

        if( psPtrn != '' ){
          Vue.set( params, 'psPtrn' , psPtrn )
        }

        Vue.archivos( params ).then(resp => {
          self.procesando = false;
          Vue.hideLoader();

          self.registros = resp
        })
        .catch(function(error) {
          //error en la consulta regresamos
          /// store.dispatch(AUTH_LOGOUT).then(() => next("/login/"));
        });
      },
      descargar( archivo ){
        var self = this
        var link = document.createElement("a");
        // If you don't know the name or want to use
        // the webserver default set name = ''
        link.setAttribute('download', 'descarga');
        link.href = 'http://solucionafore.com' + self.ruta + archivo.basename;
        document.body.appendChild(link);
        link.click();
        link.remove();
      },
      ver( archivo ){
        var self = this
        this.$vueModal.showModal(
          archivoTemplate,
          { 
              //'resource': '/img_claveunica/' + archivo.basename
              'resource': 'http://solucionafore.com' + self.ruta + archivo.basename
          }, { },
          {
              title: 'Archivo: ' + archivo.basename,
              buttons: [
                  {
                      title: 'Cerrar'
                  }
              ]
          }
        )
        
      },
      eliminar( archivo ){
        Vue.alert({ 'title': 'Aviso', 'html': 'Esta seguro de eliminar este archivo?<br><br>' + archivo.basename,
            'buttons': [
                {
                    title: 'Aceptar',
                    handler: () => { 
                        
                    }
                },
                {
                    title: 'Cancelar',
                    handler: () => { 
                        
                    }
                }
            ]
        })
      },
    },
    mounted() {
      this.getData()
      // console.log( process.env.NODE_ENV )
      // ruta SVG
      // https://fontawesomeicons.com/svg/icons/file-image
    },
    components: {
      archivoTemplate 
    }
  }
</script>
<style>
</style>