<template>
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">

          <div class="card strpied-tabled-with-hover"><!---->
            <div class="card-header">
              <h4 class="card-title">Usuarios - Registrados en el sistema</h4>
              <p class="card-category">En esta sección podra administrar los usuarios que se encuentran registrados en el sistema</p>
            </div>
            <div class="card-body table-full-width table-responsive">
              <table class="table table-hover table-striped">
                <thead>
                  <tr><th>Id</th><th>Nombre</th><th>Mail</th><th>Telefono</th><th class="text-center">Habilitado</th><th class="text-center">Administrador</th><th>Opciones</th></tr>
                </thead>
                <tbody>
                  <tr v-for="(usuario, index) in usuarios" :key="index">
                    <td>{{ usuario.id }}</td>
                    
                    <td>{{ usuario.nombre + ' ' + usuario.aPaterno + ' ' + usuario.aMaterno }}</td>
                    <td>{{ usuario.correo }}</td>
                    <td>{{ usuario.telefono }}</td>
                    <td @change="habilitado(usuario,index)" class="text-center"> <input type="checkbox" v-model="usuarios[index].habilitado" v-bind:true-value="'1'" v-bind:false-value="'0'" :readonly="idTipo=='1'" />  </td>
                    <td @change="administrador(usuario,index,$event)" class="text-center"><input type="checkbox" v-model="usuarios[index].administrador" v-bind:true-value="'1'" v-bind:false-value="'0'" :readonly="idTipo=='1'" /> </td>
                    <td>

                    </td>
                  </tr>
                </tbody>
              </table>
            </div><!---->
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
  import Vue from "vue";
  export default {
    data () {
      return {
        usuarios: [],
        idTipo: '0'
      }
    },
    methods: {
      habilitado(usuario, index){
        var self = this
        var valorNuevo = self.usuarios[index].habilitado
        if( valorNuevo == '1'){
          self.usuarios[index].habilitado = '0'
        }else{
          self.usuarios[index].habilitado = '1'
        }

        var dataForm = {
          "_cnsl": "actualizaHabilitado",
          "habilitado": valorNuevo,
          "idUsusrio": usuario.id
        }

        Vue.actualiza( dataForm, 
        //{mensajeSuccesShow:false} 
        ).then(resp => {
          if( resp.DatosJSON[0].estatus == 'actualizado' ){
            //Regresamos al valor anterior ya que no se actualizo
            self.usuarios[index].habilitado = valorNuevo
          }
        });
        
      },
      administrador(usuario, index, e){
        var self = this
        var valorNuevo = self.usuarios[index].administrador
        if( valorNuevo == '1'){
          self.usuarios[index].administrador = '0'
        }else{
          self.usuarios[index].administrador = '1'
        }

        var dataForm = {
          "_cnsl": "actualizaAdministrador",
          "administrador": valorNuevo,
          "idUsuario": usuario.id
        }

        Vue.actualiza( dataForm ).then(resp => {
          if( resp.DatosJSON[0].estatus == 'actualizado' ){
            //Regresamos al valor anterior ya que no se actualizo
            self.usuarios[index].administrador = valorNuevo
          }
        });

      },
      getData(){
        var self = this
        Vue.requestJSON( { '_cnsl': 'usuarios' } ).then(resp => {
          //console.log( resp )
          self.usuarios = resp
        })
        .catch(function(error) {
          //error en la consulta regresamos
          /// store.dispatch(AUTH_LOGOUT).then(() => next("/login/"));
        });
      }
    },
    mounted() {
      this.getData()
    },
    components: { },
  }
</script>
<style>
</style>
