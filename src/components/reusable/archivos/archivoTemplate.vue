<template>
    <div style="height;100%:">
        <div v-if="isImage">
            <img :src="src" alt="Imagen" class="" :height_='window.height - 150' width="100%" />
        </div>
        <div v-if="isPDF">
            <embed :src="src" :height='window.height - 150' width="100%" />
        </div>
        <div v-if="isHTML">
            <iframe :src="src" :height='window.height - 450' width="100%" title="Archivo"></iframe>
        </div>
        <div v-if="isImage == false && isPDF == false && isHTML == false">
            Archivo no cuenta con vista disponible
        </div>
    </div>
</template>
<script>

export default {
    name: 'archivoTemplate',
    props: ['resource'],
    data() {
        return {
            window: {
                width: 0,
                height: 0
            },
            src: '',
            isImage: false,
            isPDF: false,
            isHTML: false
        }
    },
    methods: {
        handleResize() {
            this.window.width = window.innerWidth;
            this.window.height = window.innerHeight;
        }
    },
    created(){
        window.addEventListener('resize', this.handleResize)
        this.handleResize();
    },
    destroyed() {
        window.removeEventListener('resize', this.handleResize)
    },
    mounted(){
        var self = this

        self.window.height = window.innerHeight;

        self.src = self.resource

        var archivo = self.resource.toLowerCase()

        if( archivo.includes('.jpg') || archivo.includes('.png') || archivo.includes('.gif') || archivo.includes('.jpeg') ){
            self.isImage = true;
        }
        if( archivo.includes('.pdf') ){
            self.isPDF = true;
        }
        if( archivo.includes('.html') ){
            self.isHTML = true;
        }

    }
}
</script>