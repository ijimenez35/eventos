<template>
    <div v-html="html" class="text-center"></div>
</template>

<script>
  export default {
    name: 'modalAlert',
    props: {
        html: { type: String, default: '' }
    }
  }
</script>
