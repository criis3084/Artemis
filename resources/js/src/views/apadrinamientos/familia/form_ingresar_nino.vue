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

							<vs-input v-model="codigo" name='codigo' class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="Codigo"  />

							<vs-input v-model="nombres" name='nombres' class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="Nombres" />

							<vs-input v-model="apellidos" name="apellidos" class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="Apellidos" />

							<span class="text-danger">los apellidos son requeridos</span>
							<br>

							<small class="date-label mt-10">Genero</small>
								<ul class="demo-alignment">
									<li>
										<vs-radio color="rgb(0, 170, 228)" v-model="genero" name='genero' vs-value="1" selected>Masculino</vs-radio>
									</li>
									<li>
										<vs-radio color="rgb(255, 0, 128)" v-model="genero" name='genero' vs-value="0">Femenino</vs-radio>
									</li>
								</ul>
						</div>
					</div>

					<div class="vx-col md:w-1/2 w-full mt-5">
						<div class="my-4">
							<small class="date-label">Fecha Nacimiento</small>
							<datepicker :language="$vs.rtl ? langEn : langEn" name="fecha_nacimiento" v-model="fecha_nacimiento"></datepicker>
						</div>
					</div>
					
					<div class="vx-col md:w-1/2 w-full mt-8">
						<small class="date-label">Escuela</small>
						<v-select label="nombre" :options="escuelas" class="mt-1" name="escuela_id"  v-model="escuela_id" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
					</div>

					<div class="vx-col md:w-1/2 w-full mt-5">
						<div class="my-4">
							<small class="date-label">Fecha de apadrinamiento</small>
							<datepicker :language="$vs.rtl ? langEn : langEn" name="fecha_ingreso" v-model="fecha_ingreso"></datepicker>
						</div>
					</div>

					<div class="vx-col md:w-1/2 w-full mt-8">
						<small class="date-label">Padrino</small>
						<v-select label="nombres" :options="padrinos" class="mt-1" name="padrino_id"  v-model="padrino_id" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
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
	},
	validator: null,
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
			validate_codigo:false,
			errores: null,
		}
	},
	watch: {
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
		escuela_id(value){	
			this.validator.validate('escuela_id', value);
			this.validateForm();
		},
		fecha_ingreso(value){	
			this.validator.validate('fecha_ingreso', value);
			this.validateForm();
		},
		padrino_id(value){	
			this.validator.validate('padrino_id', value);
			this.validateForm();
		},
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
		validateForm() {
			this.validator.validateAll({
				codigo: this.codigo,
				nombres: this.nombres,
				apellidos: this.apellidos,
				genero: this.genero,
				fecha_nacimiento :this.fecha_nacimiento,
				fecha_ingreso :this.fecha_ingreso,
			}).then((result) => {
				if (result && this.escuela_id.id!==undefined && this.padrino_id.id!==undefined) {
					console.log(result);
					this.$emit('validado',{validado:result,id_form:this.$props.id_formulario});
				return;
				}
					this.$emit('validado',{validado:false,id_form:this.$props.id_formulario});
					console.log('Oops!');
			});
		},
		ingresarNino(){
			axios.post("/api/nino/post/",{
				codigo:this.codigoT,
				nombres:this.nombresT,
				apellidos:this.apellidosT,
				genero:this.generoT,
				fecha_nacimiento:this.getDate(this.fecha_nacimiento),
				escuela_id:this.escuela_id.id,
				fecha_ingreso:this.getDate(this.fecha_ingreso),
				ruta_imagen:this.ruta_imagen,
				/*
				padrino_id:this.padrino_id,
				direccion:this.direccionT,
				*/
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
	created() {
		this.validator = new Validator({
			codigo: 'required',
			nombres: 'required|alpha_spaces',
			apellidos: 'required|alpha_spaces',
			genero: 'required',
			fecha_nacimiento :'required',
			escuela_id:'required',
			fecha_ingreso:'required',
			padrino_id:'required',
		});
		//this.$set(this, 'errores', this.validator.errors);

	}
}
</script>