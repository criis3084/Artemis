<template>
	<vx-card>
		<vs-row	vs-align="center" vs-type="flex" vs-justify="space-around" vs-w="12">
				<div class="vx-col md:w-1/4 w-full mt-5">
					<vx-card noShadow class="center" title="INGRESAR FAMILIA" title-color="primary">
					</vx-card>
				</div>
		</vs-row>
		<form-wizard color="rgba(var(--vs-primary), 1)" :title="null" :subtitle="null" finishButtonText="Submit" @on-complete="formSubmitted">
			<!-- tab 1 content -->
			<tab-content title="Step 1" class="mb-5" icon="feather icon-home">
				<div class="vx-row">
					<formIngresarNino></formIngresarNino>
						<div v-if="cantidad_ingresos_nino.length">
							<div v-for="(numero,index) in cantidad_ingresos_nino" :key="index">
								<vs-divider class="mt-10" ></vs-divider>
								<formIngresarNino></formIngresarNino>
							</div>
						</div>
				</div>

					<vs-row	vs-align="center" vs-type="flex"  class="m-10" vs-justify="space-around" vs-w="12">
						<div class="vx-col md:w-1/4 w-full mt-5">
								<vs-button @click="sumar_nino">Agregar nuevo niño apadrinado</vs-button>
						</div>
					</vs-row>
			</tab-content>

			<!-- tab 2 content -->
			<tab-content title="Step 2" class="mb-5" icon="feather icon-briefcase">
				<div class="vx-row">
					<formIngresarPadrino></formIngresarPadrino>
						<div v-if="cantidad_ingresos_padrino.length">
							<div v-for="(numero,index) in cantidad_ingresos_padrino" :key="index">
								<vs-divider class="mt-10" ></vs-divider>
								<formIngresarPadrino></formIngresarPadrino>
							</div>
						</div>

					<vs-row	vs-align="center" vs-type="flex"  class="m-10" vs-justify="space-around" vs-w="12">
						<div class="vx-col md:w-1/4 w-full mt-5">
								<vs-button @click="sumar_padrino">Agregar nuevo niño apadrinado</vs-button>
						</div>
					</vs-row>

				</div>
			</tab-content>

			<!-- tab 3 content -->
			<tab-content title="Step 3" class="mb-5" icon="feather icon-image">
				<div class="vx-row">

				</div>
			</tab-content>
		</form-wizard>
	</vx-card>
</template>

<script>
import formIngresarNino from './form_ingresar_nino.vue'
import formIngresarPadrino from './form_ingresar_padrino.vue'
import {FormWizard, TabContent} from 'vue-form-wizard'
import 'vue-form-wizard/dist/vue-form-wizard.min.css'

import axios from 'axios'


export default {
  data() {
    return {
	  firstName: "",
	  cantidad_ingresos_nino:[],
	  cantidad_ingresos_padrino:[],
      /// other data....
    }
  },
  methods: {
    formSubmitted() {
      alert("Form submitted!");
	},
	sumar_nino(){
		  this.cantidad_ingresos_nino.push(1);
	},
	sumar_padrino(){
		  this.cantidad_ingresos_padrino.push(1);
	},
  },
  components: {
    FormWizard,
	TabContent,
	formIngresarNino,
	formIngresarPadrino
  }
}
</script>
        