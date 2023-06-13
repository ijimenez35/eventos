<template>
  <div id="modals-cntn">
    <modal
      v-for="modal in modals"
      :key="modal.id"
      v-bind="modal.modalAttrs"
      v-on="modal.modalListeners"
      @closed="remove(modal.id)"

      v-bind:component="{ component: modal.component, componentAttrs : modal.componentAttrs }"
      v-bind:title="modal.modalListeners.title"
      v-bind:buttons="modal.modalListeners.buttons"
      v-bind:beforeClose="modal.modalListeners.beforeClose"
      v-bind:afterClose="modal.modalListeners.afterClose"

      v-bind:attrs="modal.modalAttrs"

    >
    </modal>
  </div>
</template>
<script>

//(import { generateId } from './utils'
//import Vue from 'vue'

const PREFIX = '_dynamic_modal_'
const generateId = ((index = 0) => () => (index++).toString())()

export default {
  data () {
    return {
      modals: []
    }
  },
  created () {
    this.$root._dynamicContainer = this
  },
  methods: {
    add (component, componentAttrs = {}, modalAttrs = {}, modalListeners) {
      //console.log( modalListeners );
      const id = generateId()
      const name = modalAttrs.name || (PREFIX + id)

      this.modals.push({
        id,
        modalAttrs: { ...modalAttrs, name },
        modalListeners,
        component,
        componentAttrs
      })

    },
    remove (id) {
      //console.log('entra a remove ' + id);
      for (let i in this.modals) {
        if (this.modals[i].id === id) {
          this.modals.splice(i, 1)
          return
        }
      }
    }
  }
}
</script>

