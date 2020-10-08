<template>
	<div>
		<vx-card>
			<form-wizard color="rgba(var(--vs-primary), 1)" errorColor="rgba(var(--vs-danger), 1)" title="ACTUALIZACIÓN DE NIÑO" subtitle="" finishButtonText="Enviar" back-button-text="Atras" next-button-text="Siguiente" @on-complete="formSubmitted">
				<tab-content title="Paso 1" class="mb-5" icon="feather icon-user-plus" :before-change="validateStep1">

				<!-- tab 1 content -->
					<form data-vv-scope="step-1">
						<div class="vx-row">
							
							<div class="vx-col md:w-1/2 w-full mt-5">
								<div class="vx-col w-full">
									<vs-input class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="Código" v-model="codigoT" v-validate="'required'"/>
										<span class="text-danger">{{ errors.first('step-1.campo') }}</span>
								</div>
							</div>


							<div class="vx-col md:w-1/2 w-full mt-5">
								<div class="vx-col w-full">
									<vs-input class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="Nombres" name="nombres" v-model="nombresT" v-validate="'required'"/>
										<span class="text-danger">{{ errors.first('step-1.nombres') }}</span>
								</div>
							</div>

							<div class="vx-col md:w-1/2 w-full mt-5">
								<div class="vx-col w-full">
									<vs-input class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="Apellidos" name="apellidos" v-model="apellidosT" v-validate="'required'"/>
									<span class="text-danger">{{ errors.first('step-1.apellidos') }}</span>
								</div>
							</div>

							<div class="vx-col md:w-1/2 w-full mt-5">
								<div class="my-4">
									<small class="date-label">Fecha Nacimiento</small>
									<datepicker :language="$vs.rtl ? langEn : langEn" name="fecha" v-model="fecha_nacimientoT" v-validate="'required'"></datepicker>
									<span class="text-danger">{{ errors.first('step-1.fecha') }}</span>
								</div>
							</div>

							<div class="vx-col md:w-1/2 w-full mt-5">
								<div class="my-4">
									<small class="date-label">Fecha Ingreso</small>
									<datepicker :language="$vs.rtl ? langEn : langEn" name="fecha" v-model="fecha_ingresoT" v-validate="'required'"></datepicker>
									<span class="text-danger">{{ errors.first('step-1.fecha') }}</span>
								</div>
							</div>

							<div class="vx-col md:w-1/2 w-full mt-5">
								<small class="date-label">Genero</small>
								<ul class="demo-alignment">
										<li>
											<vs-radio color="rgb(0, 170, 228)" v-model="generoT" vs-value="1" selected>Masculino</vs-radio>
										</li>
										<li>
											<vs-radio color="rgb(255, 0, 128)" v-model="generoT" vs-value="0">Femenino</vs-radio>
										</li>
								</ul>
							</div>
							
							<div class="vx-col md:w-1/2 w-full mt-5">
								<div class="vx-col w-full">
									<vs-input class="w-full" icon-pack="feather" icon="icon-home" icon-no-border label-placeholder="Dirección" v-model="direccionT" name="direccion" v-validate="'required'"/>
									<span class="text-danger">{{errors.first('step-1.direccion') }}</span>
								</div>
							</div>

							<div class="vx-col md:w-1/2 w-full mt-5">
								<div class="vx-col w-full">
									<vs-input class="w-full" icon-pack="feather" icon="icon-phone" icon-no-border label-placeholder="Télefono" v-model="numero_telefono" name="telefono" v-validate="'required'"/>
									<span class="text-danger">{{errors.first('step-1.telefono') }}</span>
								</div>
							</div>

							<div class="vx-col md:w-1/2 w-full mt-5">
								<small class="date-label">Sector</small>
								<v-select label="nombre" :options="sectoresT" v-model="sector_idT" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
							</div>

							<div class="vx-col md:w-1/2 w-full mt-5">
								<small class="date-label">Escuela</small>
								<v-select label="nombre" :options="escuelasT" v-model="escuela_idT" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
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
						<div class="vx-col md:w-1/2 w-full mt-5">
								<img :src="imagen_perfil_antigua"  width="100" height="100" class="responsive">
								<vx-tooltip text="Editar Imagen"> <vs-button class="mr-4" type="border" icon-pack="feather" color="#1551b1" icon="icon-edit" radius  @click="editarImagen"></vs-button> </vx-tooltip>
								<vs-upload v-if="mostrarEditar" automatic action="/api/nino/imagen" limit='1' :headers="head" fileName='photos' @on-success="respuesta" @on-delete="vaciar" text="Imagen de perfil" />
						</div>
					</template>
				</div>
			</div>
		</form>
    </tab-content>

 
  </form-wizard>
  <div class="vx-col md:w-1/2 w-full mt-5">
  <router-link to="/apadrinamiento/ninono"><vs-button class="w-full" icon-pack="feather" icon="icon-corner-up-left" icon-no-border>Regresar</vs-button></router-link>
    </div>
</vx-card>
</div>
</template>

<script>
import { FormWizard, TabContent } from 'vue-form-wizard'
import 'vue-form-wizard/dist/vue-form-wizard.min.css'
import vSelect from 'vue-select'

// For custom error message
import { Validator } from 'vee-validate'
const dict = {
  custom: {
    nombres: {
      required: 'Los Nombres son requeridos'
      
    },
    apellidos: {
	  required: 'Los apellidos son requeridos'
      
    },
    direccion: {
      required: 'La direccion es requerida'
    },
    fecha: {
      required: 'La fecha es requerida'
    },
    sector: {
      required: 'El sector es requerido',
    },
    campo:{
      required:'El campo es requerido '
    }
  }
}

import Datepicker from 'vuejs-datepicker'
import axios from 'axios'
// register custom messages
Validator.localize('en', dict)
import { es } from 'vuejs-datepicker/src/locale'

export default {
  data () {
		return {
			nombresT: '',
			apellidosT: '',
			direccionT: '',
			fecha_nacimientoT: '',
			fecha_ingresoT: '',
			generoT:'',
			codigoT:'',
			sector_idT:0,
			escuela_idT:0,
			numero_telefono:'',
			ruta_imagen:'',

			sectoresT:[],
			escuelasT:[],
			titulo:'Actualización registrada!',
			langEn: es,
			codigo:'',
			mostrarEditar:false,
			imagen_perfil_antigua:'',
			head:{
				"imagenanterior":""	
			},
		}
	},
	methods: {
		getDate (datetime) {
			const date = new Date(datetime)
			const dateString = `${date.getFullYear()}/${date.getMonth() + 1}/${date.getDate()}`
			return dateString
		},
		async index () { //async para que se llame cada vez que se necesite
		const me = this
		this.id_recibido = this.$route.params.id
		const response = await axios.get(
		`/api/nino/get?&criterio=id&buscar=${this.id_recibido}&completo=true`)
			.then(function (response) {
				const respuesta = response.data
				me.arrayData = respuesta.ninos.data[0]
				me.nombresT = me.arrayData.datos.nombres
				me.apellidosT = me.arrayData.datos.apellidos
				me.direccionT = me.arrayData.datos.direccion
				me.numero_telefono = me.arrayData.datos.numero_telefono
				me.idT = me.arrayData.datos.id
				me.codigoT = me.arrayData.codigo
				me.generoT = me.arrayData.datos.genero
				me.imagen_perfil_antigua = me.arrayData.ruta_imagen
				me.fecha_nacimientoT = me.arrayData.datos.fecha_nacimiento
				me.fecha_ingresoT = me.arrayData.fecha_ingreso
				me.sector_idT = me.arrayData.datos.sector_id
				me.escuela_idT = me.arrayData.escuela_id
				me.persona_sin_acceso_idT = me.arrayData.datos.persona_sin_acceso_id
			})
			.catch(function (error) {
				console.log(error)
			})
		},
		async importarSectores(){ //async para que se llame cada vez que se necesite
			let me = this;
			let encontrado=false;
			let elementoE={}
			const response = await axios.get(
				`/api/sector/get?completo=select`)
			.then(function (response) {
				var respuesta= response.data;
				me.sectoresT = respuesta.sectores.data;
				me.sectoresT.forEach(function(elemento, indice, array) {
					if (elemento.id==me.sector_idT)
					{
						elementoE=elemento
						encontrado=true
					}
				})
				me.sector_idT = encontrado == true ? elementoE : {id:me.sector_idT,nombre:'Sector desactivado'} 
				me.pagination= respuesta.pagination;
			})
			.catch(function (error) {
				console.log(error);
			});
		},
		async importarEscuelas(){ //async para que se llame cada vez que se necesite
			let me = this;
			let encontrado=false;
			let elementoE={}
			const response = await axios.get(
				`/api/escuela/get?&completo=select`)
			.then(function (response) {
				var respuesta= response.data;
				me.escuelasT = respuesta.escuelas.data;

				me.escuelasT.forEach(function(elemento, indice, array) {
					if (elemento.id==me.escuela_idT)
					{
						elementoE=elemento
						encontrado=true
					}
				})
				me.escuela_idT = encontrado == true ? elementoE : {id:me.escuela_idT,nombre:'Escuela desactivada'} 
			})
			.catch(function (error) {
				console.log(error);
			});
		},
		validateStep1 () {
			return new Promise((resolve, reject) => {
				this.$validator.validateAll('step-1').then(result => {
				if (result) {
					resolve(true)
				} else {
					reject('correct all values')
				}
				})
			})
		},
		validateStep2 () {
			return new Promise((resolve, reject) => {
				this.$validator.validateAll('step-2').then(result => {
				if (result) {
					resolve(true)
				} else {
					reject('correct all values')
				}
				})
			})
		},
		formSubmitted () {
			// alert('Form submitted!');
			if (this.ruta_imagen === ''){
				this.ruta_imagen= this.imagen_perfil_antigua;
			}
			else{
				this.ruta_imagen= '/storage/public/ninos/' + this.ruta_imagen;
			}
			axios.put('/api/nino/update/', {
				id:this.id_recibido,
				codigo:this.codigoT,
				nombres:this.nombresT,
				apellidos:this.apellidosT,
				genero:this.generoT,
				ruta_imagen:this.ruta_imagen,
				fecha_nacimiento:this.getDate(this.fecha_nacimientoT),
				fecha_ingreso:this.getDate(this.fecha_ingresoT),
				direccion:this.direccionT,
				sector_id:this.sector_idT.id,
				escuela_id:this.escuela_idT.id
			}).then(function (response) {
				console.log(response)
			})
			.catch(function (error) {
				console.log(error)
			})
			this.$emit('cerrado', 'Se cerró el formulario')
			this.$vs.notify({
				color:'success',
				title:`${this.titulo}`,
				text:'La acción se realizo exitósamente'
			})
			this.$router.push('/apadrinamiento/ninono')
		},
		vaciar(){
			this.ruta_imagen='';
		},
		editarImagen(){
			this.mostrarEditar=true;
		},
		respuesta(e){
			this.ruta_imagen=e.currentTarget.response.replace(/['"]+/g, '')
			this.head.imagenanterior=this.ruta_imagen
		},
	},
	components: {
		FormWizard,
		TabContent,
		Datepicker,
		vSelect
	},
	mounted () {
		this.index()
		this.importarSectores()
		this.importarEscuelas()
	}
}
</script>