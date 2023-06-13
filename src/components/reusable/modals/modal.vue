<template>

  <div class="modal fade" tabindex="-1" role="dialog" :id="'modal_' + id" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <!--
      <div class="modal-backdrop fade in" style="z-index: -1;"></div>
    -->
    <div :class="'modal-dialog modal-dialog-centered ' + typeModal" role="document" style="min-height: calc(50% - 1rem);">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="myLargeModalLabel" v-html="title"></h5>
          <button v-show="btnCerrar" @click="closeModal" type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <!--componente dinamico-->
          <component
            :is="component.component"
            v-bind="component.componentAttrs" 
            @close="closeModal"
            @ocultarCancelar="ocultarCancelar"
            ref="componente"
          />
        </div>
        <div class="modal-footer">
          <!--botones-->
          <button 
              @click="eventButton(button)" 
              v-for="(button,index) in buttons" 
              :key="index" type="button"
              :class="'fcbtn btn btn-outline btn-1c ' + getClass(button.title)"
              :disabled="(button.title==='Cancelar' && ocultaBtnCancelar)"
            >
              {{button.title}}
          </button>
        </div>
      </div>
    </div>
  </div>

  
</template>
<script>

import Vue from 'vue'
import 'bootstrap'
//import Modal from '@/components/reusable/modals/Modal.vue'

export default {
  name: 'VueJsModal',
  props:['name','component', 'title', 'buttons', 'attrs', 'before-close', 'after-close'],
  data () {
    return {
      id:this.name,
      typeModal:'modal-lg',
      btnCerrar: true,
        ocultaBtnCancelar: false
    }
  },
  computed: {
    classObject: function () {
      return {
        'fcbtn btn btn-outline btn-1c' : true,
        'btn-danger': true 
      }
    }
  },
  created () {
   
  },
  beforeMount () {
    //console.log('entra beforeMount')
    //Modal.event.$on('toggle', this.handleToggleEvent)
  },
  beforeDestroy () {
    //console.log('entra beforeDestroy')
    //Modal.event.$off('toggle', this.handleToggleEvent)
  },
  mounted() {
    if( this.attrs ){
      //console.log('actualiza 1')
      if( typeof this.attrs.typeModal != 'undefined' ){
        //console.log('actualiza 2')
        this.typeModal = this.attrs.typeModal
      }
      if( typeof this.attrs.btnCerrar != 'undefined' ){
        //console.log('actualiza 2')
        this.btnCerrar = this.attrs.btnCerrar
      }
    }

    $('#modal_' + this.id).on('shown.bs.modal', function() {
        $(document).off('focusin.modal');
    });

    $('#modal_' + this.id).modal( {backdrop: 'static', keyboard: false} )
  },
  methods: {
    getClass(title){
      if( title.toLowerCase() == 'si' ){
        return 'btn-success'
      }else if( title.toLowerCase() == 'buscar persona' ){
        return 'btn-success'
      }else if( title.toLowerCase() == 'aceptar' ){
        return 'btn-success'
      }else if( title.toLowerCase() == 'guardar' ){
        return 'btn-success'
      }else if( title.toLowerCase() == 'autorizar' ){
        return 'btn-success'
      }else if( title.toLowerCase() == 'cancelar' ){
        return 'btn-danger'
      }else if( title.toLowerCase() == 'no' ){
        return 'btn-danger'
      }else if( title.toLowerCase() == 'subir' ){
        return 'btn-primary'
      }else if( title.toLowerCase() == 'continuar' ){
        return 'btn-info'
      }else{
        return 'btn-danger'
      }
    },
    ocultarCancelar(oculta){
      this.ocultaBtnCancelar = oculta;
      this.btnCerrar = !oculta;
    },
    closeModal(){
      if( typeof this['beforeClose'] == 'function' ){
        this['beforeClose']()
      }

      $('#modal_' + this.id).modal('hide');
      this.$emit('closed', false)
      
      if( typeof this.afterClose == 'function' ){
        this.afterClose()
      }
    },
    eventButton(button){
      let cerrar = true
      var self = this
      if( typeof button.handler == 'function' ){
        button.handler( self )
      }
      if( typeof button.handler_ == 'string' ){
        this.$refs.componente["" + button.handler_ + ""]()
      }
      //console.log( typeof button.close );
      if( typeof button.close == 'boolean' ){
        cerrar = button.close
      }
      //console.log(cerrar)
      if(cerrar){
        this.closeModal();
      }
    },
    handleToggleEvent (name, state, params) {
      //console.log('entra a handleToggleEvent')
    },
    toggle (nextState, params) {
      //console.log('entra a toggle')
    }
  }
}
</script>