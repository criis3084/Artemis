<template>
   <vx-card>
			<vs-button @click="goBack" class="mr-4 mt-3" type="border" radius icon-pack="feather" color="primary" icon="icon-corner-up-left"> </vs-button>

	   <form>
		<div>
			<vs-row	vs-align="center" vs-type="flex" vs-justify="space-around" vs-w="12">
				<div class="vx-col md:w-1/2 w-full mt-5">
					<vx-card noShadow class="center" title="INGRESAR DATOS DEL NIÑO" title-color="primary">
					</vx-card>
				</div>
			</vs-row>
			<div class="vx-row">
				<div class="vx-col md:w-1/2 w-full mt-5">
					<vs-upload automatic action="/api/nino/imagen" limit='1' text="Imagen de perfil" :headers="head" fileName='photos' @on-success="respuesta" @on-delete="vaciar"/>
				</div>
			
				<div class="vx-col md:w-1/2 w-full mt-5">
					<div class="vx-col w-full">

						<vs-input v-model="codigo" name='codigo' v-validate="'required|max:30|alpha_num'" class="w-full mt-10" icon-pack="feather" icon="icon-hash" icon-no-border label-placeholder="Código"  />
						<span class="text-danger">{{ errors.first('codigo') }}</span>

						<vs-input v-model="nombres" name='nombres' v-validate="'required|alpha_spaces|max:30'" class="w-full mt-8" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="Nombres" />
						<span class="text-danger">{{ errors.first('nombres') }}</span>

						<vs-input v-model="apellidos" name="apellidos" v-validate="'required|alpha_spaces|max:30'" class="w-full mt-8" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="Apellidos" />
						<span class="text-danger">{{ errors.first('apellidos') }}</span>
						<br>

						<small class="date-label mt-2">Género</small>
							<ul class="demo-alignment">
								<li>
									<vs-radio v-validate="'required|included:1,0'" color="rgb(0, 170, 228)" v-model="genero" name='radio' vs-value="1">Masculino</vs-radio>
								</li>
								<li>
									<vs-radio color="rgb(255, 0, 128)" v-model="genero" name='radio' vs-value="0">Femenino</vs-radio>
								</li>
							</ul>
					<span class="text-danger">{{ errors.first('radio') }}</span>
					</div>
				</div>

				<div class="vx-col md:w-1/2 w-full mt-1">
					<div class="my-4">
						<small class="date-label">Fecha Nacimiento</small>
						<datepicker :language="$vs.rtl ? langEn : langEn" name="fecha_nacimiento" v-validate="'required'" v-model="fecha_nacimiento"></datepicker>
					<span class="text-danger">{{ errors.first('fecha_nacimiento') }}</span>
					
					</div>
				</div>

				<div class="vx-col md:w-1/2 w-full mt-6">
					<div class="vx-col w-full">
						<vs-input v-model="ocupacion" name="ocupacion" class="w-full" icon-pack="feather" v-validate="'max:150'" icon="icon-briefcase" icon-no-border label-placeholder="Ocupación" />
					<span class="text-danger">{{ errors.first('ocupacion') }}</span>

					</div>
				</div>

				
				<div class="vx-col w-full mt-6">
					<div class="vx-col w-full">
						<small class="date-label">Actividades que realiza</small>
						<vs-textarea class="w-full" icon-pack="feather" icon="icon-coffee" icon-no-border name='actividades' v-validate="'max:150'" v-model="actividades"/>
					<span class="text-danger">{{ errors.first('actividades') }}</span>
					</div>
				</div>

				<div class="vx-col md:w-1/2 w-full">
					<div class="my-4">
						<small class="date-label">Estudia</small>
							<ul class="demo-alignment">
								<li>
									<vs-radio color="danger" v-model="estudia" :vs-value="false">No</vs-radio>
								</li>
								<li>
									<vs-radio color="success" v-model="estudia" :vs-value="true">Si</vs-radio>
								</li>
							</ul>
					</div>
				</div>					

				<div v-if="estudia" class="vx-col w-full">
					<div class="vx-col md:w-1/2 w-full mt-3">
						<div class="vx-col w-full">
							<small class="date-label">Escuela</small>
							<v-select label="nombre" :options="escuelas" class="mt-1" name="escuela"  v-validate="'required'" v-model="escuela_id" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
					<span class="text-danger">{{ errors.first('escuela') }}</span>
						</div>
					</div>

					<div class="vx-col md:w-1/2 w-full mt-6">
						<div class="vx-col w-full">
							<vs-input v-model="grado" name="grado" class="w-full" icon-pack="feather" v-validate="'max:150'" icon="icon-file-text" icon-no-border label-placeholder="Grado" />
					<span class="text-danger">{{ errors.first('grado') }}</span>

						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="flex flex-wrap items-center justify-between mt-8">
			<div class="flex items-center">
				<vs-button class="mb-base mr-3" type="gradient" icon-pack="feather" icon="icon-save" color="success"  @click="registrar">Registrar</vs-button>
			</div>
		</div>
		</form>
				<vs-button @click="goBack" class="mb-base mr-3" type="gradient" icon-pack="feather" color="primary" icon="icon-corner-up-left"> Regresar</vs-button>			

   </vx-card>
   
</template>


<script>
import { ValidationProvider } from 'vee-validate';
import { FormWizard, TabContent } from 'vue-form-wizard'
import 'vue-form-wizard/dist/vue-form-wizard.min.css'
import vSelect from 'vue-select'
import Datepicker from 'vuejs-datepicker'
import axios from 'axios'
import { es } from 'vuejs-datepicker/src/locale'
import { Validator } from 'vee-validate';

const dict = {
  custom: {
	codigo:{
	  alpha_num: 'El campo solo debe de contener letras y números',
		required: 'El campo código es requerido',
	  max: 'Este campo solo acepta hasta 30 caracteres',
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
	radio: {
	  required: 'Seleccione una opción',
	  included: 'Seleccione una opción',
	},
	fecha_nacimiento:{
		 required: 'El campo fecha de nacimiento es requerido',
	},
	ocupacion:{
		max: 'Este campo solo acepta hasta 150 caracteres',
	},
	actividades:{
		max: 'Este campo solo acepta hasta 150 caracteres',
	},
	escuela:{
      required: 'El campo escuela es requerido',
	},
	grado:{
		max: 'Este campo solo acepta hasta 150 caracteres',
	},
  }
}

Validator.localize('es', dict)

export default {
	data() {
		return {
			nombres: null,
			apellidos:null,
			genero:null,
			fecha_nacimiento: null,
			codigo:null,
			fecha_ingreso: null,
			grado:null,
			ocupacion:null,
			actividades:null,
			escuela_id:null,
			todoRequerido:null,

			escuelas:[],
			langEn: es,
			validate_codigo:false,
			errores: null,
			estudia:true,
			ruta_imagen:"",
			head:{
					"imagenanterior":""	
				},
			listadoFamilia:[],
			listadoNinos:[],

			sectorT:0,
			direccionT:0,
			codigoT:'',
		}
	},
	components: {
		FormWizard,
		TabContent,
		Datepicker,
		vSelect,
	},
	methods: {
		getDate(datetime) {
        	let date = new Date(datetime);
        	let dateString = `${date.getFullYear()}/${date.getMonth() + 1}/${date.getDate()}`;
    	    return dateString;
		},
		getNow () {
			const today = new Date()
			const date = `${today.getFullYear()}-${today.getMonth() + 1}-${today.getDate()}`
			const time = `${today.getHours()  }:${  today.getMinutes()  }:${  today.getSeconds()}`
			this.fecha = date
		},
		async buscarFamilia(){
			let consulta=[]
			let me = this
			me.codigoT = this.$route.params.id;
			const response = await axios.get(`/api/relacion/get?criterio=codigo&buscar=${me.codigoT}&completo=informacion`)
			.then(function (response) {
				var respuesta= response.data;
				consulta = respuesta.relaciones.data;
				let hash = {};
				let hash2 = {};
				me.listadoFamilia = consulta.filter(o => hash[o.encargado_id] ? false : hash[o.encargado_id] = true);
				me.listadoNinos	  = consulta.filter(o => hash[o.nino_id] ? false : hash[o.nino_id] = true);
				me.direccionT=me.listadoFamilia[0].direccion
				me.sectorT=me.listadoFamilia[0].sector_id

				me.listadoNinos.forEach(function(elemento, indice, array) {
					let nombreT=elemento.datos_nino[0].apellidos
					nombreT=nombreT.split(' ',2)
					elemento.datos_nino[0].apellido1=nombreT[0]
					if (nombreT.length>1){
						elemento.datos_nino[0].apellido2=nombreT[1]
					}
					else
					{
						elemento.datos_nino[0].apellido2=''
					}
					const resultado = me.escuelas.find( escuela => escuela.id === elemento.nino.escuela_id );
				})
			})
			.catch(function (error) {
				console.log(error);
			});
		},
		registrar(){
	this.$validator.validateAll().then(result => {
if(result) {
			if (this.ruta_imagen === ''){
				this.ruta_imagen= "default.png"
			}
			let me = this;
			axios.post("/api/nino/post/",{
				nombres:me.nombres,
				apellidos:me.apellidos,
				genero:me.genero,
				fecha_nacimiento:me.getDate(me.fecha_nacimiento),
				sector_id: me.sectorT,
				direccion: me.direccionT,
				codigo:me.codigo,
				ruta_imagen: '/storage/public/usuarios/' + me.ruta_imagen,
				grado:me.grado,
				ocupacion:me.ocupacion,
				actividades:me.actividades,
				escuela_id:me.escuela_id.id
			}).then(function(response) {
				me.registrarRelacion(response.data.id)
			})
			.catch(function(error) {
				console.log(error)
			});
}
else{
		this.$vs.notify({
		color:'danger',
		title:'Error en validación!',
		text:'Ingrese todos los campos correctamente'
		});
	}
	})
		},
		goBack(){
			this.$router.go(-1)
		},
		registrarRelacion(idNino){
			let me = this
			var i =0
			var elemento ={}
			let bandera =true
			for (i=0; i < me.listadoFamilia.length; i++){
				elemento = me.listadoFamilia[i]
				axios.post ("/api/relacion/post/", {
					direccion : me.direccionT,
					codigo:me.codigoT,
					sector_id:me.sectorT,
					relacion:elemento.relacion,
					nino_id:idNino,
					estado:1,
					encargado_id:elemento.encargado_id,
				}).then(function(response) {
					console.log(response)
					if (bandera == true && i == me.listadoFamilia.length)
					{
						me.$vs.notify({
							color:'success',
							title:`Niño registrado`,
							text:'La acción se realizo exitósamente'
						});
						me.$router.push('/editar/familia/' + codigo);
					}
				})
				.catch(function(error) {
					bandera = false
					me.$vs.notify({
						color:'danger',
						title:`Error`,
						text:'Hubo un error en el registro'
					});
				});
			};
			this.goBack();
		},
		async importarEscuelas(){
			let me = this;
			const response = await axios.get(`/api/escuela/get?&completo=false`)
			.then(function (response) {
				var respuesta= response.data;
				me.escuelas = respuesta.escuelas.data;
			})
			.catch(function (error) {
				console.log(error);
			});
		},
		vaciar(){
			this.ruta_imagen='';
		},
		respuesta(e){
			this.ruta_imagen=e.currentTarget.response.replace(/['"]+/g, '')
			this.head.imagenanterior=this.ruta_imagen
	    },
	},
	mounted(){
		this.importarEscuelas();
		this.buscarFamilia();
	},
}

</script>

<style>

</style>