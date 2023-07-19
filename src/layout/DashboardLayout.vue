<template>
  <div class="wrapper">
    <side-bar :title="nombreUsuario">
      <mobile-menu slot="content"></mobile-menu>
      <sidebar-link to="/admin/reporteador">
        <i class="nc-icon nc-notes"></i>
        <p>Reporteador</p>
      </sidebar-link>

      <sidebar-link to="/admin/user">
        <i class="nc-icon nc-circle-09"></i>
        <p>Mi Perfil</p>
      </sidebar-link>

      <sidebar-link to="/admin/usuarios">
        <i class="nc-icon nc-badge"></i>
        <p>Administrar Usuarios</p>
      </sidebar-link>

      <sidebar-link to="/admin/db">
        <i class="nc-icon nc-app"></i>
        <p>Bases de Datos</p>
      </sidebar-link>

      <sidebar-link to="/admin/htmls">
        <i class="nc-icon nc-tv-2"></i>
        <p>HTML's</p>
      </sidebar-link>

      <!--
      <sidebar-link to="/admin/correos">
        <i class="nc-icon nc-email-85"></i>
        <p>Correos</p>
      </sidebar-link>
      -->

      <sidebar-link to="/admin/imagenes">
        <i class="nc-icon nc-album-2"></i>
        <p>Imagenes</p>
      </sidebar-link>


      <!--
      <sidebar-link to="/admin/reporteador">
        <i class="nc-icon nc-chart-pie-35 nc-notes"></i>
        <p>Reporteador</p>
      </sidebar-link>

      <sidebar-link to="/admin/typography">
        <i class="nc-icon nc-paper-2"></i>
        <p>Typography</p>
      </sidebar-link>
      <sidebar-link to="/admin/icons">
        <i class="nc-icon nc-atom"></i>
        <p>Icons</p>
      </sidebar-link>
      <sidebar-link to="/admin/maps">
        <i class="nc-icon nc-pin-3"></i>
        <p>Maps</p>
      </sidebar-link>
      <sidebar-link to="/admin/notifications">
        <i class="nc-icon nc-bell-55"></i>
        <p>Notifications</p>
      </sidebar-link>

      <template slot="bottom-links">
        <sidebar-link class="active"
                      to="/admin/upgrade">
          <i class="nc-icon nc-alien-33"></i>
          <p>Upgrade to PRO</p>
        </sidebar-link>
      </template>
      -->
    </side-bar>
    <div class="main-panel">
      <top-navbar></top-navbar>

      <dashboard-content @click="toggleSidebar">

      </dashboard-content>

      <content-footer></content-footer>
    </div>
  </div>
</template>
<style lang="scss">

</style>
<script>
  import TopNavbar from './TopNavbar.vue'
  import ContentFooter from './ContentFooter.vue'
  import DashboardContent from './Content.vue'
  import MobileMenu from './MobileMenu.vue'
  import store from '@/store'
  export default {
    data () {
      return {
        nombreUsuario: store.getters.fullName
      }
    },
    components: {
      TopNavbar,
      ContentFooter,
      DashboardContent,
      MobileMenu
    },
    methods: {
      toggleSidebar () {
        if (this.$sidebar.showSidebar) {
          this.$sidebar.displaySidebar(false)
        }
      }
    }
  }

</script>
