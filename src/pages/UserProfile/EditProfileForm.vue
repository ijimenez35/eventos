<template>
  <card>
    <h4 slot="header" class="card-title">Edit Profile</h4>
    <form v-if="request">
      <div class="row">
        <div class="col-md-6">
          <base-input type="text"
                    label="Company"
                    :disabled="true"
                    placeholder="Light dashboard"
                    v-model="user.company">
          </base-input>
        </div>
        <div class="col-md-6">
          <base-input type="text"
                    label="ID Usuario"
                    :disabled="true"
                    placeholder="ID Usuario"
                    v-model="user.id">
          </base-input>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <base-input type="email"
                    label="Email"
                    :disabled="true"
                    placeholder="Email"
                    v-model="user.email">
          </base-input>
        </div>
        <div class="col-md-6">
          <base-input type="number"
                    label="Telefono"
                    :disabled="true"
                    placeholder="Telefono"
                    v-model="user.telefono">
          </base-input>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <base-input type="text"
                    label="First Name"
                    placeholder="First Name"
                    v-model="user.firstName">
          </base-input>
        </div>
        <div class="col-md-6">
          <base-input type="text"
                    label="Last Name"
                    placeholder="Last Name"
                    v-model="user.lastName">
          </base-input>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <base-input type="text"
                    label="Address"
                    placeholder="Home Address"
                    v-model="user.address">
          </base-input>
        </div>
      </div>

      <div class="row">
        <div class="col-md-4">
          <base-input type="text"
                    label="City"
                    placeholder="City"
                    v-model="user.city">
          </base-input>
        </div>
        <div class="col-md-4">
          <base-input type="text"
                    label="Country"
                    placeholder="Country"
                    v-model="user.country">
          </base-input>
        </div>
        <div class="col-md-4">
          <base-input type="number"
                    label="Postal Code"
                    placeholder="ZIP Code"
                    v-model="user.postalCode">
          </base-input>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label>About Me</label>
            <textarea rows="5" class="form-control border-input"
                      placeholder="Here can be your description"
                      v-model="user.aboutMe">
              </textarea>
          </div>
        </div>
      </div>
      <div class="text-center">
        <button type="submit" class="btn btn-info btn-fill float-right" @click.prevent="updateProfile">
          Update Profile
        </button>
      </div>
      <div class="clearfix"></div>
    </form>
  </card>
</template>
<script>
  import Vue from "vue";
  import Card from 'src/components/Cards/Card.vue'

  export default {
    components: {
      Card
    },
    data () {
      return {
        user: {
          company: 'Solución Afore',
          username: 'michael23',
          email: '',
          telefono: '',
          firstName: 'Mike',
          lastName: 'Andrew',
          address: 'Melbourne, Australia',
          city: 'melbourne',
          country: 'Australia',
          postalCode: '',
          aboutMe: `Lamborghini Mercy, Your chick she so thirsty, I'm in that two seat Lambo.`
        },
        request: false
      }
    },
    methods: {
      getData(){
        var self = this
        Vue.requestJSON( { '_cnsl': 'datosUsuario' } ).then(resp => {
          //console.log( resp )
          if( resp ){
            if( resp.length > 0 ){
              self.user.id = resp[0].id
              self.user.email = resp[0].correo
              self.user.firstName = resp[0].nombre
              self.user.lastName = resp[0].aPaterno
              //self.user.lastName = resp[0].aMaterno
              self.user.telefono = resp[0].telefono 
              self.request = true
            }
          }
        })
        .catch(function(error) {
          //error en la consulta regresamos
          /// store.dispatch(AUTH_LOGOUT).then(() => next("/login/"));
        });
        
      },
      updateProfile () {
        alert('Your data: ' + JSON.stringify(this.user))
      }
    },
    mounted() {
      this.getData()
    },
  }

</script>
<style>

</style>
