<template>
  <form-wizard color="rgba(var(--vs-primary), 1)" :title="null" :subtitle="null" finishButtonText="Submit" @on-complete="formSubmitted">
      <tab-content title="Paso 1" class="mb-5" icon="feather icon-home">
          <!-- tab 1 content -->
          <div class="vx-row">
			<formIngresar></formIngresar>
				<div v-if="cantidad_ingresos.length">
					<div v-for="(numero,index) in cantidad_ingresos" :key="index">
						<formIngresar></formIngresar>
					</div>
				</div>
			<vs-button @click="sumar">Agregar nuevo niño apadrinado</vs-button>

          </div>
      </tab-content>

      <!-- tab 2 content -->
      <tab-content title="Paso 2" class="mb-5" icon="feather icon-briefcase">
          <div class="vx-row">

          </div>
      </tab-content>

      <!-- tab 3 content -->
      <tab-content title="Paso 3" class="mb-5" icon="feather icon-image">
          <div class="vx-row">

          </div>
      </tab-content>
  </form-wizard>
</template>

<script>
import formIngresar from './form-ingresar.vue'
import {FormWizard, TabContent} from 'vue-form-wizard'
import 'vue-form-wizard/dist/vue-form-wizard.min.css'

import axios from 'axios'


export default {
  data() {
    return {
	  firstName: "",
	  cantidad_ingresos:[],
      /// other data....
    }
  },
  methods: {
    formSubmitted() {
      alert("Form submitted!");
	},
	sumar(){
		  this.cantidad_ingresos.push(1);
	},
  },
  components: {
    FormWizard,
	TabContent,
	formIngresar
  }
}
</script>
        