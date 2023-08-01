<template>
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card" >
            <div class="card-header">
              <h4 class="card-title">Base de Datos</h4>
            </div>
            <div class="card-body">
              <p class="card-category">Selecciona Año y Mes</p>
              <div class="row m-t-30" style="margin-top:30px;">
                <div class="col-md-6">
                  <div class="form-outline mb-4">
                    <select class="form-control" v-model="year" @change="getData()">
                      <option value="0">Seleciona un Año</option>
                      <option value="2023">2023</option>
                    </select>
                    <label class="form-label" for="form2Example11">Año</label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-outline mb-4">
                    <select class="form-control" v-model="month" @change="getData()">
                      <option value="0">Seleciona un Mes</option>
                      <option value="01">Enero</option>
                      <option value="02">Febrero</option>
                      <option value="03">Marzo</option>
                      <option value="04">Abril</option>
                      <option value="05">Mayo</option>
                      <option value="06">Junio</option>
                      <option value="07">Julio</option>
                      <option value="08">Agosto</option>
                      <option value="09">Septiembre</option>
                      <option value="10">Octubre</option>
                      <option value="11">Noviembre</option>
                      <option value="12">Diciembre</option>
                    </select>
                    <label class="form-label" for="form2Example11">Mes</label>
                  </div>
                </div>
              </div>
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
                          <svg style="color: white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Free 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) Copyright 2022 Fonticons, Inc. --><path d="M224 0V128C224 145.7 238.3 160 256 160H384V448C384 483.3 355.3 512 320 512H64C28.65 512 0 483.3 0 448V64C0 28.65 28.65 0 64 0H224zM80 224C57.91 224 40 241.9 40 264V344C40 366.1 57.91 384 80 384H96C118.1 384 136 366.1 136 344V336C136 327.2 128.8 320 120 320C111.2 320 104 327.2 104 336V344C104 348.4 100.4 352 96 352H80C75.58 352 72 348.4 72 344V264C72 259.6 75.58 256 80 256H96C100.4 256 104 259.6 104 264V272C104 280.8 111.2 288 120 288C128.8 288 136 280.8 136 272V264C136 241.9 118.1 224 96 224H80zM175.4 310.6L200.8 325.1C205.2 327.7 208 332.5 208 337.6C208 345.6 201.6 352 193.6 352H168C159.2 352 152 359.2 152 368C152 376.8 159.2 384 168 384H193.6C219.2 384 240 363.2 240 337.6C240 320.1 231.1 305.6 216.6 297.4L191.2 282.9C186.8 280.3 184 275.5 184 270.4C184 262.4 190.4 256 198.4 256H216C224.8 256 232 248.8 232 240C232 231.2 224.8 224 216 224H198.4C172.8 224 152 244.8 152 270.4C152 287 160.9 302.4 175.4 310.6zM280 240C280 231.2 272.8 224 264 224C255.2 224 248 231.2 248 240V271.6C248 306.3 258.3 340.3 277.6 369.2L282.7 376.9C285.7 381.3 290.6 384 296 384C301.4 384 306.3 381.3 309.3 376.9L314.4 369.2C333.7 340.3 344 306.3 344 271.6V240C344 231.2 336.8 224 328 224C319.2 224 312 231.2 312 240V271.6C312 294.6 306.5 317.2 296 337.5C285.5 317.2 280 294.6 280 271.6V240zM256 0L384 128H256V0z" fill="green"></path></svg>
                        </th>
                        <td>{{ registro.basename }}</td>
                        <td>{{ registro.fechaCreacion }}</td>
                        <td>
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
                  <button v-show="month != '0' && year != '0'" type="button" class="btn btn-success btn-lg btn-block" @click="subirArchivo()">
                    Subir Base de datos en CSV
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
  import LTable from 'src/components/Table.vue'
  import Card from 'src/components/Cards/Card.vue'
  const tableColumns = ['Id', 'Name', 'Salary', 'Country', 'City']
  const tableData = [{
    id: 1,
    name: 'Dakota Rice',
    salary: '$36.738',
    country: 'Niger',
    city: 'Oud-Turnhout'
  },
  {
    id: 2,
    name: 'Minerva Hooper',
    salary: '$23,789',
    country: 'Curaçao',
    city: 'Sinaai-Waas'
  },
  {
    id: 3,
    name: 'Sage Rodriguez',
    salary: '$56,142',
    country: 'Netherlands',
    city: 'Baileux'
  },
  {
    id: 4,
    name: 'Philip Chaney',
    salary: '$38,735',
    country: 'Korea, South',
    city: 'Overland Park'
  },
  {
    id: 5,
    name: 'Doris Greene',
    salary: '$63,542',
    country: 'Malawi',
    city: 'Feldkirchen in Kärnten'
  }]
  export default {
    components: {
      LTable,
      Card
    },
    data () {
      return {
        registros: [],
        year: '2023',
        month: '04',
        procesando: false, 
        ruta: '/dbcsv/',
        table1: {
          columns: [...tableColumns],
          data: [...tableData]
        },
        table2: {
          columns: [...tableColumns],
          data: [...tableData]
        }
      }
    },
    methods: {
      subirArchivo(){
        var self = this
        if( self.month != '0' && self.year != '0' ){
          Vue.subirArchivos( {archivo:self.year + '_' + self.month,ext:'csv', ruta: self.ruta} );
        }else{
          return
        }
      },
      getData(){
        var self = this 
        self.registros = [];
        var psPtrn = ''

        if( self.month == '0' || self.year == '0' ){
          //return
        }

        self.procesando = true;
        Vue.showLoader();

        var params = { 'ruta': '/dbcsv/' }

        if( self.month != '0' && self.year != '0' ){
          psPtrn = self.year + '_' + self.month + '.csv'
        }else if( self.month != '0' ){
          psPtrn = '*_' + self.month + '.csv'
        }else if( self.year != '0' ){
          psPtrn = self.year + '_*.csv'
        }

        if( psPtrn != '' ){
          Vue.set( params, 'psPtrn' , psPtrn )
        }

        Vue.archivos( params ).then(resp => {
          self.procesando = false;
          Vue.hideLoader();

          console.log( resp )
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
    },
  }
</script>
<style>
</style>
