<template>
	<div>
		
		<vs-row	vs-align="center" vs-type="flex" vs-justify="space-around" vs-w="12">
			<div class="vx-col md:w-1/2 w-full mt-5">
				<vx-card noShadow class="center" title="INGRESAR DATOS DEL NIÑO APADRINADO"	title-color="primary">
				</vx-card>
			</div>
		</vs-row>
		<div class="vx-row">
			<div class="vx-col md:w-1/2 w-full mt-5">
				<vs-upload @on-success="successUpload" limit='1' text="Imagen de Perfil" />
			</div>
		
			<div class="vx-col md:w-1/2 w-full mt-5">
				<div class="vx-col w-full">

					<vs-input class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="Codigo" v-model="codigo"/>
					<span class="text-danger">el codigo es requerido</span>

					<vs-input class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="Nombres" v-model="nombres"/>
					<span class="text-danger">los nombres son requeridos</span>

					<vs-input class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="Apellidos" v-model="apellidos"/>
					<span class="text-danger">los apellidos son requeridos</span>
					<br>

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
				<div class="my-4">
					<small class="date-label">Fecha Nacimiento</small>
					<datepicker :language="$vs.rtl ? langEn : langEn" name="end-date" v-model="fecha_nacimiento"></datepicker>
				</div>
			</div>
			
			<div class="vx-col md:w-1/2 w-full mt-8">
				<small class="date-label">Escuela</small>
				<v-select label="nombre" :options="escuelas" class="mt-1" v-model="escuela_id" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
			</div>

			<div class="vx-col md:w-1/2 w-full mt-5">
				<div class="my-4">
					<small class="date-label">Fecha de apadrinamiento</small>
					<datepicker :language="$vs.rtl ? langEn : langEn" name="end-date" v-model="fecha_ingreso"></datepicker>
				</div>
			</div>

			<div class="vx-col md:w-1/2 w-full mt-8">
				<small class="date-label">Padrino</small>
				<v-select label="nombres" :options="padrinos" class="mt-1"  v-model="padrino_id" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
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
Validator.localize('es', dict);
import { es } from 'vuejs-datepicker/src/locale'

export default {
	data() {
		return {
		nombres: "",
		nombre_fotografia:"",
		apellidos: "",
		direccion: "",
		fecha_nacimiento: "",
		fecha_ingreso: "",
		genero:"",
		padrino_id:0,
		escuela_id:0,
		padrinos:[],
		escuelas:[],
		langEn: es,
		codigo:'',
		}
	},
	methods: {
		traerNombre(tabla){
			tabla.forEach(function(valor, indice, array){
				valor.nombres=valor.datos.nombres
			}); 
			return tabla
		},
		async importarPadrinos(){ //async para que se llame cada vez que se necesite
			let me = this;
			const response = await axios.get(
			`/api/padrino/get?&completo=true`)
			.then(function (response) {
				var respuesta= response.data;
				me.padrinos = respuesta.padrinos.data;
				me.padrinos = me.traerNombre(me.padrinos)
				me.pagination= respuesta.pagination;
			})
			.catch(function (error) {
				console.log(error);
			});
		},
		async importarEscuelas(){ //async para que se llame cada vez que se necesite
			let me = this;
			const response = await axios.get(`/api/escuela/get?&completo=select`)
			.then(function (response) {
				var respuesta= response.data;
				me.escuelas = respuesta.escuelas.data;
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
		},
		ingresarNino(){
			axios.post("/api/nino/post/",{
				nombres:this.nombresT,
				apellidos:this.apellidosT,
				genero:this.generoT,
				fecha_nacimiento:this.getDate(this.fecha_nacimientoT),
				sector_id:this.sector_idT.id,
				direccion:this.direccionT,
				codigo:this.codigoT,
				fecha_ingreso:this.getDate(this.fecha_ingresoT),
				ruta_imagen:this.ruta_imagenT,
				escuela_id:this.escuela_idT.id
			}).then(function(response) {
				console.log(response)
			})
			.catch(function(error) {
				console.log(error)
			});
			/*
				this.$emit('cerrado','Se cerró el formulario');
				this.$vs.notify({
				color:'success',
				title:`${this.titulo}`,
				text:'La acción se realizo exitósamente'
				});
				this.$router.push('/apadrinamiento/nino');
			*/
		},
	},
	components: {
		FormWizard,
		TabContent,
		Datepicker,
		vSelect,
	},
	mounted(){
		this.importarPadrinos();
		this.importarEscuelas();
	},
	computed:{

	}
}
</script>