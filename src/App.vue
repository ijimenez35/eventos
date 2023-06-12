<template>
  <div :class="{'nav-open': $sidebar.showSidebar}">
    <notifications></notifications>
    <router-view></router-view>
    
    <div class="box-loader">
      <div class="bgloader text-center" id="svgContainer" @dblclick="cerrarAnimacion()">
        <img src="/img/loading-bubbles.svg" alt="Loading icon" />
        <h4 class="text-white " style="margin-top:5px;">Procesando Información</h4>
      </div>
    </div>

  </div>
</template>

<script>
  export default {
    methods: {
      cerrarAnimacion(){
        $(".box-loader").fadeOut();
        $("#svgContainer").fadeOut();
      },
    }
  }
</script>
<style lang="scss">
  .box-loader{ position: fixed;display: none;width: 100%;height: 100%;top: 0;left: 0;right: 0;bottom: 0;background-color: rgba(0,0,0,0.5);z-index: 9999999999;}

  .bgloader{ margin: 40% 37% !important; width: 25%;  }

  .bgloader_{ background: white; border: ridge #339bca 10px; border-radius: 316px; margin: auto; margin: 10% 38%;transform: translate3d(0px, 0px, 0px); width: 25%;  }

  .vue-notifyjs.notifications{
    .list-move {
      transition: transform 0.3s, opacity 0.4s;
    }
    .list-item {
      display: inline-block;
      margin-right: 10px;

    }
    .list-enter-active {
      transition: transform 0.2s ease-in, opacity 0.4s ease-in;
    }
    .list-leave-active {
      transition: transform 1s ease-out, opacity 0.4s ease-out;
    }

    .list-enter {
      opacity: 0;
      transform: scale(1.1);

    }
    .list-leave-to {
      opacity: 0;
      transform: scale(1.2, 0.7);
    }
  }
</style>
