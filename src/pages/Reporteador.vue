<template>
  <div class="content">
    <div class="container-fluid">

      <div class="row">
        <div class="col-md-12">
          <div class="card" >
            <div class="card-header">
              <h4 class="card-title">Reporteador</h4>
            </div>
            <div class="card-body">
              <p class="card-category">Selecciona Mes y Entidad</p>
              <div class="row m-t-30" style="margin-top:30px;">
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
                  <div class="form-outline mb-4" v-show="false">
                    <select class="form-control" v-model="year">
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
                    <select class="form-control" v-model="entidad" @change="filtroEntidad()">
                      <option value="0">Todas</option>
                      <option value="1">Aguascalientes</option>
                      <option value="2">Baja California</option>
                      <option value="3">Baja California Sur</option>
                      <option value="4">Campeche</option>
                      <option value="5">Coahuila de Zaragoza</option>
                      <option value="6">Junio</option>
                      <option value="7">Chiapas</option>
                      <option value="8">Chihuahua</option>
                      <option value="9">Ciudad de México</option>
                      <option value="10">Durango</option>
                      <option value="11">Guanajuato</option>
                      <option value="12">Guerrero</option>
                      <option value="13">Hidalgo</option>
                      <option value="14">Jalisco</option>
                      <option value="15">México</option>
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
              <!--Listado-->
              <div class="row" >
                <div class="col-md-12">
                  <table class="table table-hover table-striped">
                    <thead>
                      <tr><th><input type="checkbox" v-model="checkedAll" @change="changeCheckAll"/></th><th>Id</th><th>NUMERO DE CONTROL</th><th>CURP</th><th>NOMBRE ENTIDAD</th><th>OPCIONES</th></tr>
                    </thead>
                    <tbody>

                      <tr v-for="(registro, index) in registros" :key="index" >
                        <td>
                          <input v-model="registros[index].seleccionado" v-bind:true-value="'1'" v-bind:false-value="'0'" type="checkbox"/>
                        </td>
                        <td>{{ registro.ID }}</td>
                        <td>{{ registro['NUMERO DE CONTROL'] }}</td>
                        <td>{{ registro['CURP'] }}</td>
                        <td>{{ registro['NOMBRE ENTIDAD'] }}</td>
                        <td>
                          <button type="button" class="btn btn-primary" @click="generarDocumento( registro )">Generar Documento</button>
                        </td>
                      </tr>
                      
                    </tbody>
                  </table>
                </div>
              </div>
              <!--Opciones-->
              <div class="row" >
                <div class="col-md-12">
                  <button type="button" class="btn btn-primary btn-lg btn-block" @click="generarDocumentos()">Generar Documento</button>

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
        year: '2023',
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
        registrosData: []
      }
    },
    methods: {
      getData(){
        var self = this 
        Vue.showLoader();

        if( self.month == '0' || self.year == '0' ){
          return
        }

        self.checkedAll = false
        
        axios.get(process.env.VUE_APP_API_HOST_JS + '/dbcsv.php',  'month='+ self.month + '&year=' + self.year )
        .then(async resp => {
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
            console.log( 'error' + err )
        })
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
        console.log( registro )
        var datos = '{';
        datos += '"nmroCntr":"'+ registro['NUMERO DE CONTROL'] +'", '
        datos += '"curp":"'+ registro['CURP'] +'", '
        datos += '"mncp":"'+ registro['NOMBRE MUNICIPIO'] +'", '
        datos += '"sexo":"'+ registro['Sexo'] +'", '
        datos += '"cp":"'+ registro['CODIGO POSTAL'] +'", '
        datos += '"edad":"'+ registro['Edad'] +'", '
        datos += '"ageb":"'+ registro['ageb'] +'", '
        datos += '"estd":"'+ registro['NOMBRE ENTIDAD'] +'", '


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
        datos += '"ipm":"'+ registro['RCV'] +'", '

        datos += '"0-5":"'+ registro['0 a 5 personas'] +'", '
        datos += '"6-10":"'+ registro['6 a 10 personas'] +'", '
        datos += '"11-30":"'+ registro['11 a 30 personas'] +'", '
        datos += '"31-50":"'+ registro['31 a 50 personas'] +'", '
        datos += '"51-100":"'+ registro['51 a 100 personas'] +'", '
        datos += '"101-250":"'+ registro['101 a 250 personas'] +'"'
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
            datos += '{"nmroCntr":"'+ self.registros[i]['NUMERO DE CONTROL'] +'", "curp":"'+ self.registros[i]['CURP'] +'"}'
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
        var params = { "Datos": datos };
        Vue.emrgPstnNeva( { "method":'post', "params": params, "url": process.env.VUE_APP_API_HOST_JS + '/reporte.php' } );
      }
    }

  }
</script>
<style>

</style>
