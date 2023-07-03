<template>
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">

          <div class="card strpied-tabled-with-hover"><!---->
            <div class="card-header">
              <h4 class="card-title">Usuarios - Registrados en el sistema</h4>
              <p class="card-category">Here is a subtitle for this table</p>
            </div>
            <div class="card-body table-full-width table-responsive">
              <table class="table table-hover table-striped">
                <thead>
                  <tr><th>Id</th><th>Nombre</th><th>Mail</th><th>Telefono</th><th>Habilitado</th><th>Administrador</th><th>Opciones</th></tr>
                </thead>
                <tbody>
                  <tr v-for="(usuario, index) in usuarios" :key="index">
                    <td>{{ usuario.id }}</td>
                    
                    <td>{{ usuario.nombre + ' ' + usuario.aPaterno + ' ' + usuario.aMaterno }}</td>
                    <td>{{ usuario.correo }}</td>
                    <td>{{ usuario.telefono }}</td>
                    <td>{{ usuario.habilitado }}</td>
                    <td>{{ usuario.administrador }}</td>
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
        usuarios: []
      }
    },
    methods: {
      getData(){
        var self = this
        Vue.requestJSON( { '_cnsl': 'usuarios' } ).then(resp => {
          console.log( resp )
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
