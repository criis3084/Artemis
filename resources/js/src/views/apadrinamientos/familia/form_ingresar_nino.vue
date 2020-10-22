<template>
	<div>
				<vs-row	vs-align="center" vs-type="flex" vs-justify="space-around" vs-w="12">
					<div class="vx-col md:w-1/2 w-full mt-5">
						<vx-card noShadow class="center" title="INGRESAR DATOS DEL NIÑO"	title-color="primary">
						</vx-card>
					</div>
				</vs-row>
				<div class="vx-row">
					<div class="vx-col md:w-1/2 w-full mt-5">
						<vs-upload automatic action="/api/nino/imagen" limit='1' text="Imagen de perfil" :headers="head" fileName='photos' @on-success="respuesta" @on-delete="vaciar"/>
					</div>
				
					<div class="vx-col md:w-1/2 w-full mt-5">
						<div class="vx-col w-full">

							<vs-input v-model="codigo" name='codigo' class="w-full" icon-pack="feather" icon="icon-hash" icon-no-border label-placeholder="Código"  />

							<vs-input v-model="nombres" name='nombres' class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="Nombres" />

							<vs-input v-model="apellidos" name="apellidos" class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="Apellidos" />

							<br>

							<small class="date-label mt-10">Género</small>
								<ul class="demo-alignment">
									<li>
										<vs-radio color="rgb(0, 170, 228)" v-model="genero" name='genero' vs-value="1">Masculino</vs-radio>
									</li>
									<li>
										<vs-radio color="rgb(255, 0, 128)" v-model="genero" name='genero' vs-value="0">Femenino</vs-radio>
									</li>
								</ul>
						</div>
					</div>

					<div class="vx-col md:w-1/2 w-full mt-1">
						<div class="my-4">
							<small class="date-label">Fecha Nacimiento</small>
							<datepicker :language="$vs.rtl ? langEn : langEn" name="fecha_nacimiento" v-model="fecha_nacimiento"></datepicker>
						</div>
					</div>

					<div class="vx-col md:w-1/2 w-full mt-6">
						<div class="vx-col w-full">
							<vs-input v-model="ocupacion" name="ocupacion" class="w-full" icon-pack="feather" icon="icon-briefcase" icon-no-border label-placeholder="Ocupación" />
						</div>
					</div>

					
					<div class="vx-col w-full mt-6">
						<div class="vx-col w-full">
							<small class="date-label">Actividades que realiza</small>
							<vs-textarea class="w-full" icon-pack="feather" icon="icon-coffee" icon-no-border name='actividades' v-model="actividades"/>
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
								<v-select label="nombre" :options="escuelas" class="mt-1" name="escuela_id"  v-model="escuela_id" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
							</div>
						</div>

						<div class="vx-col md:w-1/2 w-full mt-6">
							<div class="vx-col w-full">
								<vs-input v-model="grado" name="grado" class="w-full" icon-pack="feather" icon="icon-file-text" icon-no-border label-placeholder="Grado" />
							</div>
						</div>
					</div>


				</div>
	</div>
</template>

<script>
import { FormWizard, TabContent } from 'vue-form-wizard'
import 'vue-form-wizard/dist/vue-form-wizard.min.css'
import vSelect from 'vue-select'
import Datepicker from 'vuejs-datepicker'
import axios from 'axios'
import { es } from 'vuejs-datepicker/src/locale'
import { Validator } from 'vee-validate';
/*
Validator.localize('es', dict);
const dict = {
  custom: {
    codigo: {
      required: 'El codigo es un campo obligatorio',
      alpha: "El nombre solo debe incluir letras"
    },
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
*/
export default {
	props:{
		id_formulario:{
			default:0
		},
		direccion:{
			default:''
		},
		sector_id:{
			default:0
		},
		ingresar:{
			default:false
		},
	},
	validator: null,
	data() {
		return {
			nombres: "",
			apellidos: "",
			genero:'',
			fecha_nacimiento: "",

			codigo:'',
			fecha_ingreso: "",
			grado:"",
			ocupacion:"",
			actividades:"",
			escuela_id:null,

			padrinos:[],
			escuelas:[],
			langEn: es,
			validate_codigo:false,
			errores: null,
			estudia:true,
			ninoIngresado:0,

			ruta_imagen:"",
			head:{
					"imagenanterior":""	
				},
		}
	},
	watch: {
		ingresar: function(newVal, oldVal) {
			if (newVal == true){
				this.ingresarNino()
			}
		},
    	codigo(value) {
			this.validator.validate('codigo', value);
			this.validateForm();
		},
		nombres(value){	
			this.validator.validate('nombres', value);
			this.validateForm();
		},
		apellidos(value){	
			this.validator.validate('apellidos', value);
			this.validateForm();
		},
		genero(value){	
			this.validator.validate('genero', value);
			this.validateForm();
		},
		fecha_nacimiento(value){	
			this.validator.validate('fecha_nacimiento', value);
			this.validateForm();
		},
		ocupacion(value){	
			this.validator.validate('ocupacion', value);
			this.validateForm();
		},
		grado(value){	
			this.validator.validate('grado', value);
			this.validateForm();
		},
		estudia(value){
			if(value==false){
				this.grado='No estudia'
				this.escuela_id={id:1}
			}
			if(value==true){
				this.grado=''
				this.escuela_id=null
			}
		},
		escuela_id(value){
			this.validator.validate('escuela_id', value);
			this.validateForm();
		},
		actividades(value){
			this.validator.validate('actividades', value);
			this.validateForm();
		},
	},
	methods: {
		getDate(datetime) {
			let date = new Date(datetime);
			let dateString = `${date.getFullYear()}/${date.getMonth() + 1}/${date.getDate()}`;
			return dateString;
		},
		traerNombre(tabla){
			tabla.forEach(function(valor, indice, array){
				valor.nombres=valor.datos.nombres
			}); 
			return tabla
		},
		async importarPadrinos(){ //async para que se llame cada vez que se necesite
			let me = this;
			const response = await axios.get(
			`/api/padrino/get?&completo=false`)
			.then(function (response) {
				var respuesta= response.data;
				me.padrinos = respuesta.padrinos.data;
				me.padrinos = me.traerNombre(me.padrinos)
			})
			.catch(function (error) {
				console.log(error);
			});
		},
		async importarEscuelas(){ //async para que se llame cada vez que se necesite
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
		validateForm() {
			this.validator.validateAll({
				codigo: this.codigo,
				nombres: this.nombres,
				apellidos: this.apellidos,
				genero: this.genero,
				grado: this.grado,
				ocupacion: this.ocupacion,
				fecha_nacimiento :this.fecha_nacimiento,
				escuela_id :this.escuela_id,
				actividades :this.actividades,
			}).then((result) => {
				if (result){
					this.$emit('validado',{validado:result,id_form:this.$props.id_formulario});
					return;
				}
				this.$emit('validado',{validado:false,id_form:this.$props.id_formulario});
			});
		},
		enviando(id){
			this.$emit('recibirNinos',{id_nino:id});
		},
		ingresarNino(){
			if (this.ruta_imagen === ''){
				this.ruta_imagen= "default.png"
			}
			let me = this;
			axios.post("/api/nino/post/",{
				nombres:me.nombres,
				apellidos:me.apellidos,
				genero:me.genero,
				fecha_nacimiento:me.getDate(me.fecha_nacimiento),
				sector_id: me.$props.sector_id.id,
				direccion: me.$props.direccion,
				
				codigo:me.codigo,
				ruta_imagen: '/storage/public/ninos/' + me.ruta_imagen,
				grado:me.grado,
				ocupacion:me.ocupacion,
				actividades:me.actividades,
				escuela_id:me.escuela_id.id
			}).then(function(response) {
				me.enviando(response.data.id)
			})
			.catch(function(error) {
				console.log(error)
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
	created() {
		this.validator = new Validator({
			codigo: 'required',
			nombres: 'required|alpha_spaces',
			apellidos: 'required|alpha_spaces',
			genero: 'required',
			grado: 'required',
			ocupacion: 'required',
			fecha_nacimiento :'required',
			escuela_id :'required',
			actividades :'required',
		});
		//this.$set(this, 'errores', this.validator.errors);

	}
}
</script>