<template>
  <div class="content">
    <div class="container-fluid">

      <div class="row">
        <div class="col-md-12">
          <div class="card" >
            <div class="row ">
              <div class="col-md-6">
                <div class="card-header">
                  <h4 class="card-title">Reportes</h4>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-outline mt-4 mr-3">
                  <select class="form-control" v-model="PDFVersion">
                    <option value="reporte">Version 1</option>
                    <option value="reporte_2">Version 2</option>
                    <option value="reporte_3">Version 3</option>
                    <option value="reporte_4">Version 4</option>
                  </select>
                  <label class="form-label" for="form2Example11">Version PDF</label>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-outline mt-4 mr-3">
                  <select class="form-control" v-model="vistaPDF">
                    <option value="I">En linea</option>
                    <option value="D">Descarga</option>
                  </select>
                  <label class="form-label" for="form2Example11">Vista del PDF</label>
                </div>
              </div>
            </div>
            
            <div class="card-body">
              <p class="card-category">Selecciona Mes y Entidad</p>
              <div class="row m-t-30" style="margin-top:30px;">
                <div class="col-md-6">
                  <div class="form-outline mb-4" v-show="true">
                    <select class="form-control" v-model="year">
                      <option value="0">Seleciona un Año</option>
                      <option value="2024">2024</option>
                      <option value="2023">2023</option>
                      <option value="2022">2022</option>
                      <option value="2021">2021</option>
                      <option value="2020">2020</option>
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
                <div class="col-md-6" v-show=" year != '0' && month != '0'">
                  <div class="form-outline mb-4">
                    <select class="form-control" v-model="entidad" @change="filtroEntidad()">
                      <option value="0">Todas</option>
                      <option value="1">Aguascalientes</option>
                      <option value="2">Baja California</option>
                      <option value="3">Baja California Sur</option>
                      <option value="4">Campeche</option>
                      <option value="5">Coahuila de Zaragoza</option>
                      <option value="6">Colima</option>
                      <option value="7">Chiapas</option>
                      <option value="8">Chihuahua</option>
                      <option value="9">Ciudad de México</option>
                      <option value="10">Durango</option>
                      <option value="11">Guanajuato</option>
                      <option value="12">Guerrero</option>
                      <option value="13">Hidalgo</option>
                      <option value="14">Jalisco</option>
                      <option value="15">Estado de México</option>
                      <option value="16">Michoacán de Ocampo</option>
                      <option value="17">Morelos</option>
                      <option value="18">Nayarit</option>
                      <option value="19">Nuevo León</option>
                      <option value="20">Oaxaca</option>
                      <option value="21">Puebla</option>
                      <option value="22">Querétaro</option>
                      <option value="23">Quintana Roo</option>
                      <option value="24">San Luis Potosí</option>
                      <option value="25">Sinaloa</option>
                      <option value="26">Sonora</option>
                      <option value="27">Tabasco</option>
                      <option value="28">Tamaulipas</option>
                      <option value="29">Tlaxcala</option>
                      <option value="30">Veracruz</option>
                      <option value="31">Yucatán</option>
                      <option value="32">Zacatecas</option>
                    </select>
                    <label class="form-label" for="form2Example11">Entidad</label>
                  </div>
                </div>
              </div>

              <div class="row" v-show="baseDatos.length > 0">
                <div class="col-md-12">
                  <h5 class="card-title">Listado de Bases de Datos</h5>
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
                      <tr v-for="(registro, index) in baseDatos" :key="index" >
                        <th>
                          <svg style="color: white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Free 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) Copyright 2022 Fonticons, Inc. --><path d="M224 0V128C224 145.7 238.3 160 256 160H384V448C384 483.3 355.3 512 320 512H64C28.65 512 0 483.3 0 448V64C0 28.65 28.65 0 64 0H224zM80 224C57.91 224 40 241.9 40 264V344C40 366.1 57.91 384 80 384H96C118.1 384 136 366.1 136 344V336C136 327.2 128.8 320 120 320C111.2 320 104 327.2 104 336V344C104 348.4 100.4 352 96 352H80C75.58 352 72 348.4 72 344V264C72 259.6 75.58 256 80 256H96C100.4 256 104 259.6 104 264V272C104 280.8 111.2 288 120 288C128.8 288 136 280.8 136 272V264C136 241.9 118.1 224 96 224H80zM175.4 310.6L200.8 325.1C205.2 327.7 208 332.5 208 337.6C208 345.6 201.6 352 193.6 352H168C159.2 352 152 359.2 152 368C152 376.8 159.2 384 168 384H193.6C219.2 384 240 363.2 240 337.6C240 320.1 231.1 305.6 216.6 297.4L191.2 282.9C186.8 280.3 184 275.5 184 270.4C184 262.4 190.4 256 198.4 256H216C224.8 256 232 248.8 232 240C232 231.2 224.8 224 216 224H198.4C172.8 224 152 244.8 152 270.4C152 287 160.9 302.4 175.4 310.6zM280 240C280 231.2 272.8 224 264 224C255.2 224 248 231.2 248 240V271.6C248 306.3 258.3 340.3 277.6 369.2L282.7 376.9C285.7 381.3 290.6 384 296 384C301.4 384 306.3 381.3 309.3 376.9L314.4 369.2C333.7 340.3 344 306.3 344 271.6V240C344 231.2 336.8 224 328 224C319.2 224 312 231.2 312 240V271.6C312 294.6 306.5 317.2 296 337.5C285.5 317.2 280 294.6 280 271.6V240zM256 0L384 128H256V0z" fill="green"></path></svg>
                        </th>
                        <td>{{ registro.basename }}</td>
                        <td>{{ registro.fechaCreacion }}</td>
                        <td class="text-center">
                         <button type="button" class="btn btn-info " @click="verBaseDatos( registro )">
                            Ver Base de Datos
                          </button>
                        </td>
                      </tr>
                    </tbody> 
                  </table>

                  <!--

                  <span v-show="procesando == false && registros.length == 0">Sin Información </span> 
                  <span v-show="procesando == true">Procesando Información</span> 

                  -->

                </div>
              </div>

              <!--Listado-->
              <div class="row" >
                <div class="col-md-12">
                  <h5 class="card-title">Listado de Registros en la Bases de Datos <b> {{ nombreBaseDatos == '' ? '' : '( ' + nombreBaseDatos + ' - ' + registros.length + ' registros )' }}  </b></h5>
                  <table class="table table-hover table-striped">
                    <thead>
                      <tr><th><input type="checkbox" v-model="checkedAll" @change="changeCheckAll"/></th><th>Id</th><th>NUMERO DE CONTROL</th><th>CURP</th><th>NOMBRE ENTIDAD</th><th>OPCIONES</th></tr>
                    </thead>
                    <tbody >

                      <tr v-for="(registro, index) in registros" :key="index" >
                        <td>
                          <input v-model="registros[index].seleccionado" v-bind:true-value="'1'" v-bind:false-value="'0'" type="checkbox"/>
                        </td>
                        <td>{{ registro.ID }}</td>
                        <td>{{ registro['NUMERO DE CONTROL'] }}</td>
                        <td>{{ registro['CURP'] }}</td>
                        <td>{{ getNombreEstado( registro) }}</td>
                        <td>
                          <button type="button" class="btn btn-danger" @click="generarDocumento( registro )">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-pdf" viewBox="0 0 16 16">
                              <path d="M4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4zm0 1h8a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z"/>
                              <path d="M4.603 12.087a.81.81 0 0 1-.438-.42c-.195-.388-.13-.776.08-1.102.198-.307.526-.568.897-.787a7.68 7.68 0 0 1 1.482-.645 19.701 19.701 0 0 0 1.062-2.227 7.269 7.269 0 0 1-.43-1.295c-.086-.4-.119-.796-.046-1.136.075-.354.274-.672.65-.823.192-.077.4-.12.602-.077a.7.7 0 0 1 .477.365c.088.164.12.356.127.538.007.187-.012.395-.047.614-.084.51-.27 1.134-.52 1.794a10.954 10.954 0 0 0 .98 1.686 5.753 5.753 0 0 1 1.334.05c.364.065.734.195.96.465.12.144.193.32.2.518.007.192-.047.382-.138.563a1.04 1.04 0 0 1-.354.416.856.856 0 0 1-.51.138c-.331-.014-.654-.196-.933-.417a5.716 5.716 0 0 1-.911-.95 11.642 11.642 0 0 0-1.997.406 11.311 11.311 0 0 1-1.021 1.51c-.29.35-.608.655-.926.787a.793.793 0 0 1-.58.029zm1.379-1.901c-.166.076-.32.156-.459.238-.328.194-.541.383-.647.547-.094.145-.096.25-.04.361.01.022.02.036.026.044a.27.27 0 0 0 .035-.012c.137-.056.355-.235.635-.572a8.18 8.18 0 0 0 .45-.606zm1.64-1.33a12.647 12.647 0 0 1 1.01-.193 11.666 11.666 0 0 1-.51-.858 20.741 20.741 0 0 1-.5 1.05zm2.446.45c.15.162.296.3.435.41.24.19.407.253.498.256a.107.107 0 0 0 .07-.015.307.307 0 0 0 .094-.125.436.436 0 0 0 .059-.2.095.095 0 0 0-.026-.063c-.052-.062-.2-.152-.518-.209a3.881 3.881 0 0 0-.612-.053zM8.078 5.8a6.7 6.7 0 0 0 .2-.828c.031-.188.043-.343.038-.465a.613.613 0 0 0-.032-.198.517.517 0 0 0-.145.04c-.087.035-.158.106-.196.283-.04.192-.03.469.046.822.024.111.054.227.09.346z"/>
                            </svg>
                            Documento</button>
                        </td>
                      </tr>
                    </tbody> 
                  </table>

                  <span v-show="procesando == false && registros.length == 0">Sin Información </span> 
                  <span v-show="procesando == true">Procesando Información</span> 

                </div>
              </div>
              <div class="row" v-show="registros.length>0">
                <div class="col-md-12">
                  <h5>Total Registros : {{ registros.length }}</h5>
                </div>
              </div>
              <!--Opciones-->
              <div class="row" >
                <div class="col-md-12">
                  <button v-show="registros.length>0" type="button" class="btn btn-danger btn-lg btn-block" @click="generarDocumentos()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-pdf" viewBox="0 0 16 16">
                      <path d="M4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4zm0 1h8a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z"/>
                      <path d="M4.603 12.087a.81.81 0 0 1-.438-.42c-.195-.388-.13-.776.08-1.102.198-.307.526-.568.897-.787a7.68 7.68 0 0 1 1.482-.645 19.701 19.701 0 0 0 1.062-2.227 7.269 7.269 0 0 1-.43-1.295c-.086-.4-.119-.796-.046-1.136.075-.354.274-.672.65-.823.192-.077.4-.12.602-.077a.7.7 0 0 1 .477.365c.088.164.12.356.127.538.007.187-.012.395-.047.614-.084.51-.27 1.134-.52 1.794a10.954 10.954 0 0 0 .98 1.686 5.753 5.753 0 0 1 1.334.05c.364.065.734.195.96.465.12.144.193.32.2.518.007.192-.047.382-.138.563a1.04 1.04 0 0 1-.354.416.856.856 0 0 1-.51.138c-.331-.014-.654-.196-.933-.417a5.716 5.716 0 0 1-.911-.95 11.642 11.642 0 0 0-1.997.406 11.311 11.311 0 0 1-1.021 1.51c-.29.35-.608.655-.926.787a.793.793 0 0 1-.58.029zm1.379-1.901c-.166.076-.32.156-.459.238-.328.194-.541.383-.647.547-.094.145-.096.25-.04.361.01.022.02.036.026.044a.27.27 0 0 0 .035-.012c.137-.056.355-.235.635-.572a8.18 8.18 0 0 0 .45-.606zm1.64-1.33a12.647 12.647 0 0 1 1.01-.193 11.666 11.666 0 0 1-.51-.858 20.741 20.741 0 0 1-.5 1.05zm2.446.45c.15.162.296.3.435.41.24.19.407.253.498.256a.107.107 0 0 0 .07-.015.307.307 0 0 0 .094-.125.436.436 0 0 0 .059-.2.095.095 0 0 0-.026-.063c-.052-.062-.2-.152-.518-.209a3.881 3.881 0 0 0-.612-.053zM8.078 5.8a6.7 6.7 0 0 0 .2-.828c.031-.188.043-.343.038-.465a.613.613 0 0 0-.032-.198.517.517 0 0 0-.145.04c-.087.035-.158.106-.196.283-.04.192-.03.469.046.822.024.111.054.227.09.346z"/>
                    </svg>
                    Generar Documento
                  </button>

                  <button class="btn btn-primary btn-lg btn-block" disabled_ v-show="false">
                    <span class="spinner-grow spinner-grow-sm"></span>
                    Loading..
                  </button>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row" v-show="false">
        <div class="col-md-12">
          <chart-card :chart-data="lineChart.data"
                      :chart-options="lineChart.options"
                      :responsive-options="lineChart.responsiveOptions">
            <template slot="header">
              <h4 class="card-title">Reporteador</h4>
              <p class="card-category">Selecciona Mes y Año</p>

              <div class="row m-t-30" style="margin-top:30px;">
                <div class="col-md-6">
                  <div class="form-outline mb-4">
                    <select id="form2Example11" class="form-control">
                      <option value="0">Seleciona un Año</option>
                      <option value="2023">2023</option>
                      <option value="2022">2022</option>
                      <option value="2021">2021</option>
                      <option value="2020">2020</option>
                    </select>
                    <label class="form-label" for="form2Example11">Año</label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-outline mb-4">
                    <select id="form2Example11" class="form-control">
                      <option value="0">Seleciona un Mes</option>
                      <option value="1">Enero</option>
                      <option value="2">Febrero</option>
                      <option value="3">Marzo</option>
                      <option value="4">Abril</option>
                      <option value="5">Mayo</option>
                      <option value="6">Junio</option>
                      <option value="7">Julio</option>
                      <option value="8">Agosto</option>
                      <option value="9">Septiembre</option>
                      <option value="10">Octubre</option>
                      <option value="11">Noviembre</option>
                      <option value="12">Diciembre</option>
                    </select>
                    <label class="form-label" for="form2Example11">Mes</label>
                  </div>
                </div>
              </div>

            </template>

            <template slot="footer">
              <div class="legend">
                <i class="fa fa-circle text-info"></i> Open
                <i class="fa fa-circle text-danger"></i> Click
                <i class="fa fa-circle text-warning"></i> Click Second Time
              </div>
              <hr>
              <div class="stats">
                <i class="fa fa-history"></i> Updated 3 minutes ago
              </div>
            </template>
          </chart-card>
        </div>

        <div class="col-md-12">
          <chart-card
            :chart-data="barChart.data"
            :chart-options="barChart.options"
            :chart-responsive-options="barChart.responsiveOptions"
            chart-type="Bar">
            <template slot="header">
              <h4 class="card-title">Reporteador</h4>
              <p class="card-category">Selecciona Año y Mes</p>


              <div class="row m-t-30" style="margin-top:30px;">
                <div class="col-md-6">
                  <div class="form-outline mb-4">
                    <select id="form2Example11" class="form-control">
                      <option value="0">Seleciona un Año</option>
                      <option value="2023">2023</option>
                      <option value="2022">2022</option>
                      <option value="2021">2021</option>
                      <option value="2020">2020</option>
                    </select>
                    <label class="form-label" for="form2Example11">Año</label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-outline mb-4">
                    <select id="form2Example11" class="form-control">
                      <option value="0">Seleciona un Mes</option>
                      <option value="1">Enero</option>
                      <option value="2">Febrero</option>
                      <option value="3">Marzo</option>
                      <option value="4">Abril</option>
                      <option value="5">Mayo</option>
                      <option value="6">Junio</option>
                      <option value="7">Julio</option>
                      <option value="8">Agosto</option>
                      <option value="9">Septiembre</option>
                      <option value="10">Octubre</option>
                      <option value="11">Noviembre</option>
                      <option value="12">Diciembre</option>
                    </select>
                    <label class="form-label" for="form2Example11">Mes</label>
                  </div>
                </div>
              </div>

            </template>
            <template slot="footer">
              <div class="legend">
                <i class="fa fa-circle text-info"></i> Tesla Model S
                <i class="fa fa-circle text-danger"></i> BMW 5 Series
              </div>
              <hr>
              <div class="stats">
                <i class="fa fa-check"></i> Data information certified
              </div>
            </template>
          </chart-card>

        </div>

        
      </div>

    </div>
  </div>
</template>
<script>
  import ChartCard from 'src/components/Cards/ChartCard.vue'
  import StatsCard from 'src/components/Cards/StatsCard.vue'
  import LTable from 'src/components/Table.vue'
  import Vue from 'vue'
  import axios from 'axios'

  export default {
    components: {
      LTable,
      ChartCard,
      StatsCard
    },
    data () {
      return {
        nombreBaseDatos: '',
        baseDatos: [], 
        PDFVersion: 'reporte_4',
        vistaPDF: 'I',
        PDFVersiones: [ 'reporte', 'reporte_2' ],
        year: '2024',
        month: '0',
        entidad: '0',
        checkedAll: false,
        editTooltip: 'Edit Task',
        deleteTooltip: 'Remove',
        pieChart: {
          data: {
            labels: ['40%', '20%', '40%'],
            series: [40, 20, 40]
          }
        },
        lineChart: {
          data: {
            labels: ['9:00AM', '12:00AM', '3:00PM', '6:00PM', '9:00PM', '12:00PM', '3:00AM', '6:00AM'],
            series: [
              [287, 385, 490, 492, 554, 586, 698, 695],
              [67, 152, 143, 240, 287, 335, 435, 437],
              [23, 113, 67, 108, 190, 239, 307, 308]
            ]
          },
          options: {
            low: 0,
            high: 800,
            showArea: false,
            height: '245px',
            axisX: {
              showGrid: false
            },
            lineSmooth: true,
            showLine: true,
            showPoint: true,
            fullWidth: true,
            chartPadding: {
              right: 50
            }
          },
          responsiveOptions: [
            ['screen and (max-width: 640px)', {
              axisX: {
                labelInterpolationFnc (value) {
                  return value[0]
                }
              }
            }]
          ]
        },
        barChart: {
          data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mai', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            series: [
              [542, 443, 320, 780, 553, 453, 326, 434, 568, 610, 756, 895],
              [412, 243, 280, 580, 453, 353, 300, 364, 368, 410, 636, 695]
            ]
          },
          options: {
            seriesBarDistance: 10,
            axisX: {
              showGrid: false
            },
            height: '245px'
          },
          responsiveOptions: [
            ['screen and (max-width: 640px)', {
              seriesBarDistance: 5,
              axisX: {
                labelInterpolationFnc (value) {
                  return value[0]
                }
              }
            }]
          ]
        },
        tableData: {
          data: [
            {title: 'Sign contract for "What are conference organizers afraid of?"', checked: false},
            {title: 'Lines From Great Russian Literature? Or E-mails From My Boss?', checked: true},
            {
              title: 'Flooded: One year later, assessing what was lost and what was found when a ravaging rain swept through metro Detroit',
              checked: true
            },
            {title: 'Create 4 Invisible User Experiences you Never Knew About', checked: false},
            {title: 'Read "Following makes Medium better"', checked: false},
            {title: 'Unfollow 5 enemies from twitter', checked: false}
          ]
        },
        registros: [],
        registrosData: [],
        procesando: false 
      }
    },
    methods: {
      verBaseDatos(baseDatos){
        var self = this;
        console.log(baseDatos)
        self.procesando = true;
        self.registros = [];
        self.registrosData = [];
        self.checkedAll = false

        self.nombreBaseDatos = baseDatos.basename;

        Vue.showLoader();
        axios.get(process.env.VUE_APP_API_HOST_JS + '/dbcsv.php?db='+ baseDatos.filename )
        .then(async resp => {
          self.procesando = false;
          Vue.hideLoader();
          //console.log( resp) ;
          //filtrar por entidad
          if( resp.status == 200 ){
            if( resp.data.DatosJSON ){
              if( resp.data.DatosJSON.length > 0 ){
                self.registrosData = resp.data.DatosJSON
                self.filtroEntidad()
              }
            }
          }
        })
        .catch(err => {
          self.procesando = false;
          Vue.hideLoader();
          console.log( 'error' + err )
        })

      },
      getNombreEstado(registro){
        if( registro['NOM_ENT'] ){
          return registro['NOM_ENT']
        }else if( registro['NOMBRE ENTIDAD'] ){
          return registro['NOMBRE ENTIDAD']
        }
      },
      getData(){
        var self = this 
        self.registros = [];
        self.registrosData = [];
        self.procesando = true;
        self.nombreBaseDatos = '';
        Vue.showLoader();

        if( self.month == '0' || self.year == '0' ){
          return
        }

        self.checkedAll = false

        //Verificar las bases de datos
        var params = { 'ruta': '/dbcsv/', 'psPtrn': self.year + '_' + self.month + '*.csv' }
        self.baseDatos = [];
        Vue.archivos( params ).then(resp => {
          self.procesando = false;
          Vue.hideLoader();

          console.log( resp )
          self.baseDatos = resp

          if( self.baseDatos.length > 0 ){
            self.verBaseDatos(self.baseDatos[0])
          }
        })
        .catch(function(error) {
          //error en la consulta regresamos
          
        });

        /*
        axios.get(process.env.VUE_APP_API_HOST_JS + '/dbcsv.php?month='+ self.month + '&year=' + self.year )
        .then(async resp => {
          self.procesando = false;
          Vue.hideLoader();
          //console.log( resp) ;
          //filtrar por entidad
          if( resp.status == 200 ){
            if( resp.data.DatosJSON ){
              if( resp.data.DatosJSON.length > 0 ){
                self.registrosData = resp.data.DatosJSON
                self.filtroEntidad()
              }
            }
          }
        })
        .catch(err => {
          self.procesando = false;
          Vue.hideLoader();
          console.log( 'error' + err )
        })

        */
      },
      changeCheckAll(ev){
        this.registros.forEach(rgst=>{rgst.seleccionado = ev.target.checked ? '1': '0'})
      },
      filtroEntidad(){
        var self = this
        var registros = [];
        if( self.entidad == '0' ){
          for( var i = 0; i<self.registrosData.length; i++ ){
            Vue.set( self.registrosData[i], 'seleccionado' , '0' )
          }
          self.registros = self.registrosData
        }else{
          for( var i = 0 ; i<self.registrosData.length ; i++ ){
            if( self.entidad == self.registrosData[i]['ENTIDAD_y']){
              registros.push( self.registrosData[i] )
            }else if( self.entidad == self.registrosData[i]['ENTIDAD'] ){
              registros.push( self.registrosData[i] )
            }
          }
          for( var i = 0; i<self.registros.length; i++ ){
            Vue.set( self.registros[i], 'seleccionado' , '0' )
          }
          self.registros = registros
        }
        console.log( self.registros )
      },
      generarDocumento( registro ){
        var  self = this
        //console.log( registro )
        var datos = '{';
        datos += '"ID":"'+ registro['ID'] +'", '

        if(registro['Numero de Control']){
          datos += '"nmroCntr":"'+ registro['Numero de Control'] +'", '
        }else if(registro['NUMERO DE CONTROL']){
          datos += '"nmroCntr":"'+ registro['NUMERO DE CONTROL'] +'", '
        }

        datos += '"curp":"'+ registro['CURP'] +'", '
        datos += '"mncp":"'+ registro['NOMBRE MUNICIPIO'] +'", '
        datos += '"sexo":"'+ registro['Sexo'] +'", '
        datos += '"cp":"'+ registro['p_code_ok'] +'", '
        datos += '"edad":"'+ registro['Edad'] +'", '
        datos += '"ageb":"'+ registro['ageb'] +'", '

        if(registro['NOM_ENT']){
          datos += '"estd":"'+ registro['NOM_ENT'] +'", '
        }else if(registro['NOMBRE ENTIDAD']){
          datos += '"estd":"'+ registro['NOMBRE ENTIDAD'] +'", '
        }
        
        datos += '"cve_unica":"'+ registro['cve_unica'] +'", '
        datos += '"total_ue":"'+ registro['total_ue'] +'", '

        datos += '"v":"'+ registro['VIVIENDAS'] +'", '
        datos += '"pt":"'+ registro['POBTOT'] +'", '
        datos += '"ptf":"'+ registro['POBFEM'] +'", '
        datos += '"ptm":"'+ registro['POBMAS'] +'", '

        datos += '"p18plus":"'+ registro['P_18YMAS'] +'", '
        datos += '"p18plusf":"'+ registro['P_18YMAS_F'] +'", '
        datos += '"p18plusm":"'+ registro['P_18YMAS_M'] +'", '

        datos += '"p60":"'+ registro['P_60YMAS'] +'", '
        datos += '"p60f":"'+ registro['P_60YMAS_F'] +'", '
        datos += '"p60m":"'+ registro['P_60YMAS_M'] +'", '

        datos += '"gpe":"'+ registro['GRAPROES'] +'", '
        datos += '"pea":"'+ registro['PEA'] +'", '
        datos += '"peaf":"'+ registro['PEA_F'] +'", '
        datos += '"peam":"'+ registro['PEA_M'] +'", '

        datos += '"po":"'+ registro['POCUPADA'] +'", '
        datos += '"pof":"'+ registro['POCUPADA_F'] +'", '
        datos += '"pom":"'+ registro['POCUPADA_M'] +'", '

        datos += '"pass":"'+ registro['PDER_SS'] +'", '
        datos += '"paIMSS":"'+ registro['PDER_IMSS'] +'", '
        datos += '"paISSSTE":"'+ registro['PDER_ISTE'] +'", '
        datos += '"paISSSTEe":"'+ registro['PDER_ISTEE'] +'", '

        datos += '"ncs":"'+ registro['NIVEL PREDOMINANTE'] +'", '
        datos += '"ipm":"---", '

        datos += '"0-5":"'+ registro['0 a 5 personas'] +'", '
        datos += '"6-10":"'+ registro['6 a 10 personas'] +'", '
        datos += '"11-30":"'+ registro['11 a 30 personas'] +'", '
        datos += '"31-50":"'+ registro['31 a 50 personas'] +'", '
        datos += '"51-100":"'+ registro['51 a 100 personas'] +'", '
        datos += '"101-250":"'+ registro['101 a 250 personas'] +'", '
        datos += '"251":"'+ registro['251 y más personas'] +'"'
        datos += '}'
        
        var datosSend = '{ "DatosJSON": ['+datos+'] }';
        self.vistaDocumento( datosSend )
      },
      generarDocumentos(){
        var self = this
        //Generar documentos seleccionados
        var datos = '';

        for( var i = 0 ; i<self.registros.length ; i++ ){
          if( self.registros[i].seleccionado == '1' ){
            if( datos != ''){
              datos += ',';
            }
            //datos += '{"nmroCntr":"'+ self.registros[i]['NUMERO DE CONTROL'] +'", "curp":"'+ self.registros[i]['CURP'] +'"}'

            datos += '{'
            datos += '"ID":"'+ self.registros[i]['ID'] +'", '
            
            //datos += '"nmroCntr":"'+ self.registros[i]['NUMERO DE CONTROL'] +'", '

            if(self.registros[i]['Numero de Control']){
              datos += '"nmroCntr":"'+ self.registros[i]['Numero de Control'] +'", '
            }else if(self.registros[i]['NUMERO DE CONTROL']){
              datos += '"nmroCntr":"'+ self.registros[i]['NUMERO DE CONTROL'] +'", '
            }


            datos += '"curp":"'+ self.registros[i]['CURP'] +'", '
            datos += '"mncp":"'+ self.registros[i]['NOMBRE MUNICIPIO'] +'", '
            datos += '"sexo":"'+ self.registros[i]['Sexo'] +'", '
            datos += '"cp":"'+ self.registros[i]['p_code_ok'] +'", '
            datos += '"edad":"'+ self.registros[i]['Edad'] +'", '
            datos += '"ageb":"'+ self.registros[i]['ageb'] +'", '
            
            if(self.registros[i]['NOM_ENT']){
              datos += '"estd":"'+ self.registros[i]['NOM_ENT'] +'", '
            }else if(self.registros[i]['NOMBRE ENTIDAD']){
              datos += '"estd":"'+ self.registros[i]['NOMBRE ENTIDAD'] +'", '
            }

            datos += '"cve_unica":"'+ self.registros[i]['cve_unica'] +'", '
            datos += '"total_ue":"'+ self.registros[i]['total_ue'] +'", '

            datos += '"v":"'+ self.registros[i]['VIVIENDAS'] +'", '
            datos += '"pt":"'+ self.registros[i]['POBTOT'] +'", '
            datos += '"ptf":"'+ self.registros[i]['POBFEM'] +'", '
            datos += '"ptm":"'+ self.registros[i]['POBMAS'] +'", '

            datos += '"p18plus":"'+ self.registros[i]['P_18YMAS'] +'", '
            datos += '"p18plusf":"'+ self.registros[i]['P_18YMAS_F'] +'", '
            datos += '"p18plusm":"'+ self.registros[i]['P_18YMAS_M'] +'", '

            datos += '"p60":"'+ self.registros[i]['P_60YMAS'] +'", '
            datos += '"p60f":"'+ self.registros[i]['P_60YMAS_F'] +'", '
            datos += '"p60m":"'+ self.registros[i]['P_60YMAS_M'] +'", '

            datos += '"gpe":"'+ self.registros[i]['GRAPROES'] +'", '
            datos += '"pea":"'+ self.registros[i]['PEA'] +'", '
            datos += '"peaf":"'+ self.registros[i]['PEA_F'] +'", '
            datos += '"peam":"'+ self.registros[i]['PEA_M'] +'", '

            datos += '"po":"'+ self.registros[i]['POCUPADA'] +'", '
            datos += '"pof":"'+ self.registros[i]['POCUPADA_F'] +'", '
            datos += '"pom":"'+ self.registros[i]['POCUPADA_M'] +'", '

            datos += '"pass":"'+ self.registros[i]['PDER_SS'] +'", '
            datos += '"paIMSS":"'+ self.registros[i]['PDER_IMSS'] +'", '
            datos += '"paISSSTE":"'+ self.registros[i]['PDER_ISTE'] +'", '
            datos += '"paISSSTEe":"'+ self.registros[i]['PDER_ISTEE'] +'", '

            datos += '"ncs":"'+ self.registros[i]['NIVEL PREDOMINANTE'] +'", '
            datos += '"ipm":"---", '

            datos += '"0-5":"'+ self.registros[i]['0 a 5 personas'] +'", '
            datos += '"6-10":"'+ self.registros[i]['6 a 10 personas'] +'", '
            datos += '"11-30":"'+ self.registros[i]['11 a 30 personas'] +'", '
            datos += '"31-50":"'+ self.registros[i]['31 a 50 personas'] +'", '
            datos += '"51-100":"'+ self.registros[i]['51 a 100 personas'] +'", '
            datos += '"101-250":"'+ self.registros[i]['101 a 250 personas'] +'", '
            datos += '"251":"'+ self.registros[i]['251 y más personas'] +'"'
            datos += '}'

          }
        }

        if( datos == ''){
          Vue.alert({"title":'Aviso','html':'Seleccione por lo menos un registro', 'buttons': [ { title: 'Aceptar', handler: () => { } } ]})
          return 
        }

        var datosSend = '{ "DatosJSON": ['+datos+'] }';
        self.vistaDocumento( datosSend )

      },
      vistaDocumento( datos ){
        var self = this
        var mes = '';
        if(self.month == '01' ){ mes = 'Enero'; }
        if(self.month == '02' ){ mes = 'Febrero'; }
        if(self.month == '03' ){ mes = 'Marzo'; }
        if(self.month == '04' ){ mes = 'Abril'; }
        if(self.month == '05' ){ mes = 'Mayo'; }
        //if(self.month == '06' ){ mes = 'Junio'; mes = 'Julio'; }
        if(self.month == '06' ){ mes = 'Junio'; }
        if(self.month == '07' ){ mes = 'Julio'; }
        if(self.month == '08' ){ mes = 'Agosto'; }
        if(self.month == '09' ){ mes = 'Septiembre'; }
        if(self.month == '10' ){ mes = 'Octubre'; }
        if(self.month == '11' ){ mes = 'Noviembre'; }
        if(self.month == '12' ){ mes = 'Diciembre'; }
        var params = { "Datos": datos, "month": mes, "year": self.year, vista: self.vistaPDF };
        Vue.emrgPstnNeva( { "method":'post', "params": params, "url": process.env.VUE_APP_API_HOST_JS + '/'+ self.PDFVersion + '.php' } );
      }
    }

  }
</script>
<style>

</style>
