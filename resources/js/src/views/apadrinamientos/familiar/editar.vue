<template>
	<div>
		<vx-card>
			<div class="vx-col md:w-1/2 w-full mt-5">
				<router-link to="/apadrinamiento/encargado"><vs-button type="border" radius class="w-full" icon-pack="feather" icon="icon-corner-up-left" icon-no-border></vs-button></router-link>
			</div>
			<form-wizard color="rgba(var(--vs-primary), 1)" errorColor="rgba(var(--vs-danger), 1)" title="ACTUALIZACIÓN DE ENCARGADO" subtitle="" finishButtonText="Enviar" back-button-text="Atrás" next-button-text="Siguiente" @on-complete="formSubmitted">
				<vs-divider position="right">PID&#174;</vs-divider>
				
				<tab-content title="Paso 1" class="mb-5" icon="feather icon-user-plus" :before-change="validateStep1">

				<!-- tab 1 content -->
					<form data-vv-scope="step-1">
						<div class="vx-row">
							<div class="vx-col md:w-1/2 w-full mt-5">
								<div class="vx-col w-full">
									<vs-input class="w-full" icon-pack="feather" icon="icon-hash" icon-no-border label-placeholder="CUI" v-model="cuiT" name="cui" v-validate="'numeric|max:13'"/>
									<span class="text-danger">{{ errors.first('step-1.cui') }}</span>
								</div>
							</div>

							<div class="vx-col md:w-1/2 w-full mt-5">
								<div class="vx-col w-full">
									<vs-input class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="Nombres" v-model="nombresT" name="nombres" v-validate="'required|alpha_spaces|max:30'"/>
									<span class="text-danger">{{ errors.first('step-1.nombres') }}</span>
								</div>
							</div>

							<div class="vx-col md:w-1/2 w-full mt-5">
								<div class="vx-col w-full">
									<vs-input class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="Apellidos" v-model="apellidosT" name="apellidos" v-validate="'required|alpha_spaces|max:30'"/>
									<span class="text-danger">{{ errors.first('step-1.apellidos') }}</span>
								</div>
							</div>

							<div class="vx-col md:w-1/2 w-full mt-5">
								<div class="my-4">
									<small class="date-label">Fecha de nacimiento</small>
									<datepicker :language="$vs.rtl ? langEn : langEn" name="fecha" v-model="fecha_nacimientoT" v-validate="'required'"></datepicker>
									<span class="text-danger">{{ errors.first('step-1.fecha') }}</span>
								</div>
							</div>

							
							<div class="vx-col md:w-1/2 w-full mt-5">
								<small class="date-label">Género</small>
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
									<vs-input class="w-full" icon-pack="feather" icon="icon-map-pin" icon-no-border label-placeholder="Dirección" v-model="direccionT" name="direccion" v-validate="'required|max:254'"/>
									<span class="text-danger">{{errors.first('step-1.direccion') }}</span>
								</div>
							</div>

							<div class="vx-col md:w-1/2 w-full mt-5">
								<div class="vx-col w-full">
									<vs-input class="w-full" icon-pack="feather" icon="icon-phone" icon-no-border label-placeholder="Teléfono" v-model="numero_telefonoT" name="numero_telefono" v-validate="'numeric|max:15'"/>
									<span class="text-danger">{{errors.first('step-1.numero_telefono') }}</span>
								</div>
							</div>


							<div class="vx-col md:w-1/2 w-full mt-5">
								<div class="vx-col w-full">
									<vs-input class="w-full" icon-pack="feather" icon="icon-briefcase" icon-no-border label-placeholder="Ocupación" v-model="ocupacionT" name="ocupacion" v-validate="'max:150'"/>
									<span class="text-danger">{{errors.first('step-1.ocupacion') }}</span>
								</div>
							</div>

							<div class="vx-col md:w-1/2 w-full mt-5">
								<div class="vx-col w-full">
									<vs-input class="w-full" icon="school" icon-no-border label-placeholder="Escolaridad" v-model="escolaridadT" name="escolaridad" v-validate="'max:150'"/>
									<span class="text-danger">{{errors.first('step-1.escolaridad') }}</span>
								</div>
							</div>

                            <div class="vx-col md:w-1/2 w-full mt-5">
								<small class="date-label">Ingresos</small>
								<vx-input-group class="mb-base">
								<template slot="prepend">	
								<div class="prepend-text bg-primary" >
									<span>Q</span>	
								</div>
								<div class="vx-col w-full">
									<vs-input class="w-full" icon-no-border v-model="ingresosT" name="ingresos" v-validate="'numeric|max:9'"/>
									<span class="text-danger">{{errors.first('step-1.ingresos') }}</span>
								</div>
								</template>
								</vx-input-group>
							</div>

							<div class="vx-col md:w-1/2 w-full mt-5">
								<small class="date-label">Sector</small>
								<v-select label="nombre" :options="sectoresT" v-model="sector_idT" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
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
								<vs-upload v-if="mostrarEditar" automatic action="/api/encargado/imagen" limit='1' :headers="head" fileName='photos' @on-success="respuesta" @on-delete="vaciar" text="Imagen de perfil" />
						</div>
					</template>
				</div>
			</div>
		</form>
    </tab-content>

 
  </form-wizard>
  <div class="vx-col md:w-1/3 w-full mt-5">
  <router-link to="/apadrinamiento/encargado"><vs-button class="w-full" type="gradient" icon-pack="feather" icon="icon-corner-up-left" icon-no-border>Regresar</vs-button></router-link>
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
	cui: {
	  numeric: 'El campo solo debe de contener números',
	  max: 'Este campo solo acepta hasta 13 dígitos',
    },
    nombres: {
	  required: 'El campo nombres es requerido',
	  alpha_spaces: 'El campo solo debe de contener letras y espacios',
	  max: 'Este campo solo acepta hasta 30 caracteres',
    },
    apellidos: {
	  required: 'El campo apellidos es requerido',
	  alpha_spaces: 'El campo solo debe de contener letras y espacios',
	  max: 'Este campo solo acepta hasta 30 caracteres',
    },
    direccion: {
	  required: 'El campo dirección es requerido',
	  max: 'Este campo solo acepta hasta 254 caracteres',
    },
    fecha: {
      required: 'El campo fecha de nacimiento es requerido',
	},
	ocupacion: {
	  max: 'Este campo solo acepta hasta 150 caracteres',
	},
    escolaridad: {
	  max: 'Este campo solo acepta hasta 150 caracteres',
	},
	ingresos: {
	  numeric: 'El campo solo debe de contener números',
	  max: 'Este campo solo acepta hasta 9 caracteres',
	},
	numero_telefono: {
	  numeric: 'El campo solo debe de contener números',
	  max: 'Este campo solo acepta hasta 15 caracteres',
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
		nombresT: "",
		apellidosT: "",
		direccionT: "",
		fecha_nacimientoT: "",
		fecha_ingresoT: "",
		generoT:"",
		codigoT:"",
		ocupacionT:"",
		cuiT:"",
		numero_telefonoT:"",
        escolaridadT:"",
        ingresosT:"",
		sector_idT:0,
		escuela_idT:0,
		numero_telefono:'',
	//   id_recibido:0,
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
		getDate(datetime) {
        	let date = new Date(datetime);
        	let dateString = `${date.getFullYear()}/${date.getMonth() + 1}/${date.getDate()}`;
			return dateString;
		},
		async index(){ //async para que se llame cada vez que se necesite
			let me = this;
			this.id_recibido = this.$route.params.id;
			const response = await axios.get(
				`/api/encargado/get?&criterio=id&buscar=${this.id_recibido}&completo=true`)
			.then(function (response) {
				var respuesta= response.data;
				me.arrayData = respuesta.encargados.data[0];
				me.nombresT = me.arrayData.datos.nombres;
				me.apellidosT = me.arrayData.datos.apellidos;
				me.direccionT = me.arrayData.datos.direccion;
				me.numero_telefonoT = me.arrayData.datos.numero_telefono;
				me.idT = me.arrayData.datos.id;
				me.cuiT = me.arrayData.datos.CUI;
				me.generoT = me.arrayData.datos.genero;
				me.imagen_perfil_antigua = me.arrayData.ruta_imagen;
				me.fecha_nacimientoT = me.arrayData.datos.fecha_nacimiento;
				
				me.ocupacionT = me.arrayData.ocupacion;
                me.escolaridadT = me.arrayData.escolaridad;
                me.ingresosT = me.arrayData.ingresos;
				me.sector_idT = me.arrayData.datos.sector_id;
			
				me.persona_sin_acceso_idT = me.arrayData.datos.persona_sin_acceso_id;
				me.pagination= respuesta.pagination;
			})
			.catch(function (error) {
				console.log(error);
			});
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

		validateStep1() {
		return new Promise((resolve, reject) => {
			this.$validator.validateAll('step-1').then(result => {
			if (result) {
				resolve(true)
			} else {
				reject("correct all values");
				this.$vs.notify({
			color:'danger',
			title:'Error en validación!',
			text:'Ingrese todos los campos correctamente'
			});
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
				this.$vs.notify({
			color:'danger',
			title:'Error en validación!',
			text:'Ingrese todos los campos correctamente'
			});
			}
			})
		})
		},
		formSubmitted () {
			console.log("ruta");
			console.log(this.ruta_imagen);
			console.log("ruta antigua");
			console.log(this.imagen_perfil_antigua);
			if (this.ruta_imagen === '' || this.ruta_imagen == undefined ){
				this.ruta_imagen= this.imagen_perfil_antigua;
			}
			else{
				this.ruta_imagen= '/storage/public/familiares/' + this.ruta_imagen;
			}
			// alert('Form submitted!');
			axios.put("/api/encargado/update/",{
				id:this.id_recibido,
				CUI:this.cuiT,
				nombres:this.nombresT,
				apellidos:this.apellidosT,
				numero_telefono:this.numero_telefonoT,
				genero:this.generoT,
				ruta_imagen:this.ruta_imagen,
				ocupacion:this.ocupacionT,
                escolaridad:this.escolaridadT,
                ingresos:this.ingresosT,
				fecha_nacimiento:this.getDate(this.fecha_nacimientoT),
				direccion:this.direccionT,
                sector_id:this.sector_idT.id,
			
		}).then(function(response) {
		console.log(response)
			})
			.catch(function(error) {
			console.log(error)
			});
			this.$emit('cerrado','Se cerró el formulario');
			this.$vs.notify({
			color:'success',
			title:`${this.titulo}`,
			text:'La acción se realizo exitósamente'
			});
			this.$router.push('/apadrinamiento/encargado');
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
			this.$vs.notify({
					color:'success',
					title:'Imagen subida',
					text:'Acción realizada exitósamente!'
				});
		},
  },
  components: {
    FormWizard,
	TabContent,
	Datepicker,
	vSelect,
  },
	mounted(){
	this.index();
	this.importarSectores();
	
  },
}
</script>