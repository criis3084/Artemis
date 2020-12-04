<template>
	<div>
		<vx-card>
			<form-wizard color="rgba(var(--vs-primary), 1)" errorColor="rgba(var(--vs-danger), 1)" title="INGRESO DE NIÑO" subtitle="" finishButtonText="Enviar" back-button-text="Atras" next-button-text="Siguiente">
				<tab-content title="Paso 1" class="mb-5" icon="feather icon-user-plus" :before-change="validateStep1">

				<!-- tab 1 content -->
					<form data-vv-scope="step-1">
						<div class="vx-row">

							<div class="vx-col md:w-1/2 w-full mt-5">
								<div class="vx-col w-full">
									<vs-input class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="Nombres" v-model="nombres"/>
									<span class="text-danger">los nombres son requeridos</span>
								</div>
							</div>

							<div class="vx-col md:w-1/2 w-full mt-5">
								<div class="vx-col w-full">
									<vs-input class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="Apellidos" v-model="apellidos"/>
									<span class="text-danger">los apellidos son requeridos</span>
								</div>
							</div>

							<div class="vx-col md:w-1/2 w-full mt-5">
								<div class="my-4">
									<small class="date-label">Fecha Nacimiento</small>
									<datepicker :language="$vs.rtl ? langEn : langEn" name="end-date" v-model="fecha_nacimiento"></datepicker>
								</div>
							</div>

							<div class="vx-col md:w-1/2 w-full mt-5">
								<small class="date-label">Género</small>
								<ul class="demo-alignment">
										<li>
											<vs-radio color="rgb(0, 170, 228)" v-model="genero" vs-value="1" selected>Masculino</vs-radio>
										</li>
										<li>
											<vs-radio color="rgb(255, 0, 128)" v-model="genero" vs-value="0">Femenino</vs-radio>
										</li>
								</ul>
							</div>
							
							<div class="vx-col md:w-1/2 w-full mt-5">
								<div class="vx-col w-full">
									<vs-input class="w-full" icon-pack="feather" icon="icon-map-pin" icon-no-border label-placeholder="Dirección" v-model="direccion"/>
									<span class="text-danger">La dirección es requerida</span>
								</div>
							</div>

							<div class="vx-col md:w-1/2 w-full mt-5">
								<small class="date-label">Sector</small>
								<v-select label="nombre" :options="sectores" v-model="sector_id" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
							</div>

							<div class="vx-col md:w-1/2 w-full mt-5">
								<small class="date-label">Escuela</small>
								<v-select label="nombre" :options="escuelas" v-model="escuela_id" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
							</div>

							<div class="vx-col md:w-1/2 w-full mt-5">
								<small class="date-label"></small>
								<vs-button>Registrar niño no apadrinado</vs-button>
							</div>
						</div>
					</form>
				</tab-content>

    <!-- tab 2 content -->
    <tab-content title="Paso 2" class="mb-5" icon="feather icon-file-plus" :before-change="validateStep2">
		<form data-vv-scope="step-2">
			<div class="vx-row">
				<div class="vx-col md:w-1/2 w-full mt-5">
					<template>
						<vs-upload action="https://jsonplaceholder.typicode.com/posts/" @on-success="successUpload" limit="1" text="Subir fotografía" />
					</template>
				</div>
			</div>
			<div class="vx-row">
				<div class="vx-col md:w-1/2 w-full mt-5">
					<div class="vx-col w-full">
						<vs-input class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="Código" v-model="codigo"/>
						<span class="text-danger">El código es requerido</span>
					</div>
				</div>
			</div>
			<div class="vx-col md:w-1/2 w-full mt-5">
				<div class="my-4">
					<small class="date-label">Fecha de apadrinamiento</small>
					<datepicker :language="$vs.rtl ? langEn : langEn" name="end-date" v-model="fecha_ingreso"></datepicker>
				</div>
			</div>
		</form>
    </tab-content>

 
  </form-wizard>
  <div class="vx-col md:w-1/2 w-full mt-5">
  <router-link to="/apadrinamiento/nino"><vs-button class="w-full" icon-pack="feather" icon="icon-corner-up-left" icon-no-border>Regresar</vs-button></router-link>
    </div>
</vx-card>
</div>
</template>

<script>
import { FormWizard, TabContent } from 'vue-form-wizard'
import 'vue-form-wizard/dist/vue-form-wizard.min.css'
import vSelect from 'vue-select'

// For custom error message
import { Validator } from 'vee-validate';
const dict = {
  custom: {
    nombres: {
      required: 'Los Nombres son requeridos',
      alpha: "El nombre solo debe incluir letras"
    },
    apellidos: {
	  required: 'Los apellidos son requeridos',
      alpha: "El nombre solo debe incluir letras"
    },
    direccion: {
      required: 'La direccion es requerida',
      email: "Please enter valid email"
    },
    fecha_nacimiento: {
      required: 'La fecha de nacimiento es requerida',
      alpha: "Job title may only contain alphabetic characters"
    },
    sector: {
      required: 'el sector es requerido',
      alpha: "Event name may only contain alphabetic characters"
    },
  }
};

import Datepicker from 'vuejs-datepicker'
import axios from 'axios'
// register custom messages
Validator.localize('en', dict);
import { es } from 'vuejs-datepicker/src/locale'

export default {
  data() {
    return {
      nombres: "",
      apellidos: "",
      direccion: "",
      fecha_nacimiento: "",
      fecha_ingreso: "",
	  genero:"",
	  sector_id:0,
	  escuela_id:0,
	  sectores:[],
	  escuelas:[],
	  langEn: es,
	  codigo:'',
    }
  },
  methods: {
	async importarSectores(){ //async para que se llame cada vez que se necesite
		let me = this;
		const response = await axios.get(


			`/api/sector/get?&completo=select`)
		.then(function (response) {
			var respuesta= response.data;
			me.sectores = respuesta.sectores.data;
		})
		.catch(function (error) {
			console.log(error);
		});
	},async importarEscuelas(){ //async para que se llame cada vez que se necesite
		let me = this;
		const response = await axios.get(
			`/api/escuela/get?&completo=select`)
		.then(function (response) {
			var respuesta= response.data;
			me.escuelas = respuesta.escuelas.data;
		})
		.catch(function (error) {
			console.log(error);
		});
	},
	successUpload(){
      this.$vs.notify({color:'success',title:'Fotografia',text:'Fotografia importada'})
    },
    validateStep1() {
      return new Promise((resolve, reject) => {
        this.$validator.validateAll('step-1').then(result => {
          if (result) {
            resolve(true)
          } else {
            reject("correct all values");
          }
        })
      })
    },
    validateStep2() {
      return new Promise((resolve, reject) => {
        this.$validator.validateAll("step-2").then(result => {
          if (result) {
            resolve(true)
          } else {
            reject("correct all values");
          }
        })
      })
    }
  },
  components: {
    FormWizard,
	TabContent,
	Datepicker,
	vSelect,
  },
	mounted(){
    this.importarSectores();
    this.importarEscuelas();
  },
}
</script>