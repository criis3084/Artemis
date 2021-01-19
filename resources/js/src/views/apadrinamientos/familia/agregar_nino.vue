<template>
   <vx-card>
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

						<vs-input v-model="codigo" name='codigo' class="w-full mt-10" icon-pack="feather" icon="icon-hash" icon-no-border label-placeholder="Código"  />
						<!-- <div v-if="VALcodigo"><span class="text-danger">{{ VALcodigo }}</span><br></div> -->
						<!-- <div v-if="VALcodigo2"><span class="text-danger">{{ VALcodigo2 }}</span><br></div> -->
						<!-- <div v-if="VALcodigo3"><span class="text-danger">{{ VALcodigo3 }}</span></div> -->


						<vs-input v-model="nombres" name='nombres' class="w-full mt-8" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="Nombres" />
						<!-- <div v-if="VALnombres"><span class="text-danger">{{ VALnombres }}</span><br></div> -->
						<!-- <div v-if="VALnombres2"><span class="text-danger">{{ VALnombres2 }}</span><br></div> -->
						<!-- <div v-if="VALnombres3"><span class="text-danger">{{ VALnombres3 }}</span></div> -->


						<vs-input v-model="apellidos" name="apellidos" class="w-full mt-8" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="Apellidos" />
						<!-- <div v-if="VALapellidos"><span class="text-danger">{{ VALapellidos }}</span><br></div> -->
						<!-- <div v-if="VALapellidos2"><span class="text-danger">{{ VALapellidos2 }}</span><br></div> -->
						<!-- <div v-if="VALapellidos3"><span class="text-danger">{{ VALapellidos3 }}</span></div> -->

						<br>

						<small class="date-label mt-2">Género</small>
							<ul class="demo-alignment">
								<li>
									<vs-radio color="rgb(0, 170, 228)" v-model="genero" name='genero' vs-value="1">Masculino</vs-radio>
								</li>
								<li>
									<vs-radio color="rgb(255, 0, 128)" v-model="genero" name='genero' vs-value="0">Femenino</vs-radio>
								</li>
							</ul>
						<!-- <div v-if="VALgenero"><span class="text-danger">{{ VALgenero }}</span><br></div> -->

					</div>
				</div>

				<div class="vx-col md:w-1/2 w-full mt-1">
					<div class="my-4">
						<small class="date-label">Fecha Nacimiento</small>
						<datepicker :language="$vs.rtl ? langEn : langEn" name="fecha_nacimiento" v-model="fecha_nacimiento"></datepicker>
						<!-- <div v-if="VALfecha"><span class="text-danger">{{ VALfecha }}</span><br></div> -->
					
					</div>
				</div>

				<div class="vx-col md:w-1/2 w-full mt-6">
					<div class="vx-col w-full">
						<vs-input v-model="ocupacion" name="ocupacion" class="w-full" icon-pack="feather" icon="icon-briefcase" icon-no-border label-placeholder="Ocupación" />
						<!-- <div v-if="VALocupacion"><span class="text-danger">{{ VALocupacion }}</span><br></div> -->
					</div>
				</div>

				
				<div class="vx-col w-full mt-6">
					<div class="vx-col w-full">
						<small class="date-label">Actividades que realiza</small>
						<vs-textarea class="w-full" icon-pack="feather" icon="icon-coffee" icon-no-border name='actividades' v-model="actividades"/>
						<!-- <div v-if="VALactividades"><span class="text-danger">{{ VALactividades }}</span><br></div> -->
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
							<v-select label="nombre" :options="escuelas" class="mt-1" name="escuela"  v-model="escuela_id" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
							<!-- <div v-if="VALescuela">
								<span class="text-danger">{{ VALescuela }}</span><br>
							</div> -->
						</div>
					</div>

					<div class="vx-col md:w-1/2 w-full mt-6">
						<div class="vx-col w-full">
							<vs-input v-model="grado" name="grado" class="w-full" icon-pack="feather" icon="icon-file-text" icon-no-border label-placeholder="Grado" />
							<!-- <div v-if="VALgrado">
								<span class="text-danger">{{ VALgrado }}</span><br>
							</div> -->
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="flex flex-wrap items-center justify-between mt-8">
			<div class="flex items-center">
				<vs-button class="mb-base mr-3" type="gradient" icon-pack="feather" icon="icon-printer" color="success"  @click="registrar">Registrar</vs-button>
			</div>
		</div>
   </vx-card>
</template>


<script>
import { FormWizard, TabContent } from 'vue-form-wizard'
import 'vue-form-wizard/dist/vue-form-wizard.min.css'
import vSelect from 'vue-select'
import Datepicker from 'vuejs-datepicker'
import axios from 'axios'
import { es } from 'vuejs-datepicker/src/locale'
import { Validator } from 'vee-validate';

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
			sectorFamilia:0,
			direccionFamilia:0
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
			let codigo = this.$route.params.id;
			let consulta=[]
			let me = this
			const response = await axios.get(`/api/relacion/get?criterio=codigo&buscar=${codigo}&completo=informacion`)
			.then(function (response) {
				var respuesta= response.data;
				consulta = respuesta.relaciones.data;
				let hash = {};
				let hash2 = {};
				me.listadoFamilia = consulta.filter(o => hash[o.encargado_id] ? false : hash[o.encargado_id] = true);
				me.listadoNinos	  = consulta.filter(o => hash[o.nino_id] ? false : hash[o.nino_id] = true);
				me.direccion=me.listadoFamilia[0].direccion
				me.sector=me.listadoFamilia[0].sector.nombre

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
					//elemento.nino.escuela_nombre = resultado.nombre
				})
			})
			.catch(function (error) {
				console.log(error);
			});
		},
		registrar(){
			if (this.ruta_imagen === ''){
				this.ruta_imagen= "default.png"
			}
			let me = this;
			axios.post("/api/nino/post/",{
				nombres:me.nombres,
				apellidos:me.apellidos,
				genero:me.genero,
				fecha_nacimiento:me.getDate(me.fecha_nacimiento),
				sector_id: me.sectorFamilia,
				direccion: me.direccionFamilia,

				codigo:me.codigo,
				ruta_imagen: '/storage/public/ninos/' + me.ruta_imagen,
				grado:me.grado,
				ocupacion:me.ocupacion,
				actividades:me.actividades,
				escuela_id:me.escuela_id.id
			}).then(function(response) {
				me.familia
				console.log(response.data.id)
			})
			.catch(function(error) {
				console.log(error)
			});
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