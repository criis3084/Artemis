<template>
	<div>
			<formIngresar></formIngresar>
				<div v-if="cantidad_ingresos.length">
					<div v-for="(numero,index) in cantidad_ingresos" :key="index">
						<formIngresar></formIngresar>
					</div>
				</div>
			<vs-button @click="sumar">Agregar nuevo niño apadrinado</vs-button>
	</div>
</template>

<script>

import formIngresar from './form-ingresar.vue'

import axios from 'axios'

export default {
  data() {
    return {
	  cantidad_ingresos:[],
    }
  },
  methods: {
	  sumar(){
		  this.cantidad_ingresos.push(1);
		  console.log(this.cantidad_ingresos.length);
	  },
  },
  components: {
	  formIngresar
	},
	mounted(){

  },
}
</script>