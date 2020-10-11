<template>
<vx-card title="Nuevo Grupo">
  <div class="vx-row">
    <div class="vx-col sm:w-1/2 w-full mb-2">
      <vs-input class="w-full" label-placeholder="Nombre de grupo" v-model="nombre" />
    </div>
    <div class="vx-col sm:w-1/2 w-full mb-2">
      <vs-input class="w-full" label-placeholder="Descripción" v-model="descripcion" />
    </div>
  </div>
  <div class="vx-row">
    <div class="vx-col sm:w-1/2 w-full mb-2">
      <vs-input class="w-full" label-placeholder="Cantidad prestamo actual" v-model=" cantidad_prestamo_actual" />
    </div>
    <div class="vx-col sm:w-1/2 w-full mb-2">
      <vs-input class="w-full" label-placeholder="Cantidad ultimo prestamo" v-model=" cantidad_ultimo_prestamo" />
    </div>
  </div>
  <div class="vx-row">
    <div class="vx-col w-full">
      <vs-button class="mr-3 mb-2" @click="guardar">Guardar</vs-button>
      <vs-button color="warning" type="border" class="mb-2" @click=" nombre = descripcion = cantidad_prestamo_actual = cantidad_ultimo_prestamo = '';">Limpiar</vs-button>
    </div>
  </div>
  </vx-card>
</template>
<script>
import axios from 'axios'


export default {
  data () {
    return {
      nombre:'',
      descripcion:'',
      cantidad_ultimo_prestamo:'',
      cantidad_prestamo_actual:''
    }
  },
  methods:{
    guardar () {
      axios.post('/api/grupoPrestamo/post/', {
        nombre:this.nombre,
        descripcion:this.descripcion,
        cantidad_ultimo_prestamo:this.cantidad_ultimo_prestamo,
        cantidad_prestamo_actual:this.cantidad_prestamo_actual
      }).then(function (response) {
        console.log(response)
      })
        .catch(function (error) {
          console.log(error)
        })
		
      this.$vs.notify({
        color:'success',
        title:'Exito',
        text:'Registro Creado!'
	  })
    }
  },
  computed:{

  }
}
</script>