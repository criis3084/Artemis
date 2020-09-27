<template>
	<div>
		
		<vs-row	vs-align="center" vs-type="flex" vs-justify="space-around" vs-w="12">
			<div class="vx-col md:w-1/2 w-full mt-5">
				<vx-card noShadow class="center" title="INGRESAR DATOS DEL PADRINO"	title-color="primary">
				</vx-card>
			</div>
		</vs-row>
		<div class="vx-row">
			<div class="vx-col md:w-1/2 w-full mt-5">
				<vs-upload @on-success="successUpload" limit='1' text="Imagen de Perfil" />
			</div>
		
			<div class="vx-col md:w-1/2 w-full mt-5">
				<div class="vx-col w-full">

					<vs-input class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="Nombres" v-model="nombres"/>
					<span class="text-danger">los nombres son requeridos</span>

					<vs-input class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="Apellidos" v-model="apellidos"/>
					<span class="text-danger">los apellidos son requeridos</span>
					<br>

					<vs-input class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="CUI" v-model="CUI"/>
					<span class="text-danger">El CUI es requerido</span>

					<small class="date-label mt-10">Genero</small>
						<ul class="demo-alignment">
							<li>
								<vs-radio color="rgb(0, 170, 228)" v-model="genero" vs-value="1" selected>Masculino</vs-radio>
							</li>
							<li>
								<vs-radio color="rgb(255, 0, 128)" v-model="genero" vs-value="0">Femenino</vs-radio>
							</li>
						</ul>
				</div>
			</div>

			<div class="vx-col md:w-1/2 w-full mt-5">
				<div class="vx-col w-full">
					<vs-input class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="Dirección" v-model="direccion"/>
					<span class="text-danger">La dirección es requerida</span>
				</div>
			</div>

			<div class="vx-col md:w-1/2 w-full mt-5">
				<div class="vx-col w-full">
					<vs-input class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="Numero de telefono" v-model="telefono"/>
				</div>
			</div>

			<div class="vx-col md:w-1/2 w-full mt-5">
				<div class="vx-col w-full">
					<vs-input class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="Correo electronico" v-model="correo"/>
				</div>
			</div>

			<div class="vx-col md:w-1/2 w-full ">
				<div class="my-4">
					<small class="date-label">Fecha Nacimiento</small>
					<datepicker :language="$vs.rtl ? langEn : langEn" name="end-date" v-model="fecha_nacimiento"></datepicker>
				</div>
			</div>

		</div>
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
	  nombre_fotografia:"",
      apellidos: "",
	  CUI:"",
	  genero:"",
      direccion: "",
      fecha_nacimiento: "",
      telefono: "",
      correo: "",
	  sectores:[],
	  langEn: es,
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
			me.pagination= respuesta.pagination;
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
			console.log(result)
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
  },
  computed:{
	  fotografia(){
		  console.log(nombre_fotografia);
		  return 1
	  }
  }
}
</script>