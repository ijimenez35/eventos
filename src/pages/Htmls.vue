<template>
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card" >
            <div class="card-header">
              <h4 class="card-title">HTML de Zonas</h4>
            </div>
            <div class="card-body">
              <p class="card-category">Listado de HTML asignados a cada ZONA</p>
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
                          <svg style="color: blue" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Free 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) Copyright 2022 Fonticons, Inc. --><path d="M0 32l34.9 395.8L191.5 480l157.6-52.2L384 32H0zm308.2 127.9H124.4l4.1 49.4h175.6l-13.6 148.4-97.9 27v.3h-1.1l-98.7-27.3-6-75.8h47.7L138 320l53.5 14.5 53.7-14.5 6-62.2H84.3L71.5 112.2h241.1l-4.4 47.7z" fill="blue"></path></svg>
                        </th>
                        <td>{{ registro.basename }}</td>
                        <td>{{ registro.fechaCreacion }}</td>
                        <td>
                          <!--
                          <button type="button" class="btn btn-warning " @click="ver( registro )">
                            Ver 
                          </button>
                          <button type="button" class="btn btn-danger " @click="eliminar( registro )">
                            Eliminar 
                          </button>
                          -->
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
  export default {
    data () {
      return {
        registros: [],
        procesando: false
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

        var params = { 'ruta': '/html_claveunica/' }

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
      descargar(){

      },
      ver(){

      },
      eliminar(){

      }
    },
    mounted() {
      this.getData()
    },
    components: {
      
    }
  }
</script>
<style>
</style>
