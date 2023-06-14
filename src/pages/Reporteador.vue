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
                    <select class="form-control" v-model="month">
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
                    <select class="form-control" v-model="entidad">
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
                      <tr><th>Id</th><th>Name</th><th>Salary</th><th>Country</th><th>City</th></tr>
                    </thead>
                    <tbody>
                      <tr><td>1</td><td>Dakota Rice</td><td>$36.738</td><td>Niger</td><td>Oud-Turnhout</td></tr>
                      <tr><td>2</td><td>Minerva Hooper</td><td>$23,789</td><td>Curaçao</td><td>Sinaai-Waas</td></tr>
                      <tr><td>3</td><td>Sage Rodriguez</td><td>$56,142</td><td>Netherlands</td><td>Baileux</td></tr>
                      <tr><td>4</td><td>Philip Chaney</td><td>$38,735</td><td>Korea, South</td><td>Overland Park</td></tr>
                      <tr><td>5</td><td>Doris Greene</td><td>$63,542</td><td>Malawi</td><td>Feldkirchen in Kärnten</td></tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <!--Opciones-->
              <div class="row" >
                <div class="col-md-12">
                  <button type="button" class="btn btn-primary btn-lg btn-block" @click="generar()">Generar Documento</button>

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

  export default {
    components: {
      LTable,
      ChartCard,
      StatsCard
    },
    data () {
      return {
        year: '2023',
        month: '5',
        entidad: '0',
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
        }
      }
    },
    methods: {
      generar(){
        Vue.showLoader();
        var self = this 


        axios.get(process.env.VUE_APP_SID_API_HOST_JS + '/ws/dbcsv.php',  'month='+ self.month + '&year=' + self.year )
        .then(async resp => {
          console.log( resp) ;
            
        })
        .catch(err => {
            console.log( 'error' + err )
        })

      }
    }

  }
</script>
<style>

</style>
