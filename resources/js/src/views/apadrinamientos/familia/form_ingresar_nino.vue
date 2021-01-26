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
					<div v-if="VALcodigo"><span class="text-danger">{{ VALcodigo }}</span><br></div>
					<div v-if="VALcodigo2"><span class="text-danger">{{ VALcodigo2 }}</span><br></div>
					<div v-if="VALcodigo3"><span class="text-danger">{{ VALcodigo3 }}</span></div>


					<vs-input v-model="nombres" name='nombres' class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="Nombres" />
					<div v-if="VALnombres"><span class="text-danger">{{ VALnombres }}</span><br></div>
					<div v-if="VALnombres2"><span class="text-danger">{{ VALnombres2 }}</span><br></div>
					<div v-if="VALnombres3"><span class="text-danger">{{ VALnombres3 }}</span></div>


					<vs-input v-model="apellidos" name="apellidos" class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="Apellidos" />
					<div v-if="VALapellidos"><span class="text-danger">{{ VALapellidos }}</span><br></div>
					<div v-if="VALapellidos2"><span class="text-danger">{{ VALapellidos2 }}</span><br></div>
					<div v-if="VALapellidos3"><span class="text-danger">{{ VALapellidos3 }}</span></div>

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
					<div v-if="VALgenero"><span class="text-danger">{{ VALgenero }}</span><br></div>

				</div>
			</div>

			<div class="vx-col md:w-1/2 w-full mt-1">
				<div class="my-4">
					<small class="date-label">Fecha Nacimiento</small>
					<datepicker :language="$vs.rtl ? langEn : langEn" name="fecha_nacimiento" v-model="fecha_nacimiento"></datepicker>
					<div v-if="VALfecha"><span class="text-danger">{{ VALfecha }}</span><br></div>
				
				</div>
			</div>

			<div class="vx-col md:w-1/2 w-full mt-6">
				<div class="vx-col w-full">
					<vs-input v-model="ocupacion" name="ocupacion" class="w-full" icon-pack="feather" icon="icon-briefcase" icon-no-border label-placeholder="Ocupación" />
					<div v-if="VALocupacion"><span class="text-danger">{{ VALocupacion }}</span><br></div>
				
				</div>
			</div>

			
			<div class="vx-col w-full mt-6">
				<div class="vx-col w-full">
					<small class="date-label">Actividades que realiza</small>
					<vs-textarea class="w-full" icon-pack="feather" icon="icon-coffee" icon-no-border name='actividades' v-model="actividades"/>
					<div v-if="VALactividades"><span class="text-danger">{{ VALactividades }}</span><br></div>

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
						<div v-if="VALescuela"><span class="text-danger">{{ VALescuela }}</span><br></div>
					</div>
				</div>

				<div class="vx-col md:w-1/2 w-full mt-6">
					<div class="vx-col w-full">
						<vs-input v-model="grado" name="grado" class="w-full" icon-pack="feather" icon="icon-file-text" icon-no-border label-placeholder="Grado" />
					<div v-if="VALgrado"><span class="text-danger">{{ VALgrado }}</span><br></div>

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
			VALcodigo: "",
			VALcodigo2: "",
			VALcodigo3: "",
			VALnombres: "",
			VALnombres2: "",
			VALnombres3: "",
			VALapellidos: "",
			VALapellidos2: "",
			VALapellidos3: "",
			VALgenero:'',
			VALfecha: "",
			VALcodigo:'',
			VALfecha_ingreso: "",
			VALgrado:"",
			VALocupacion:"",
			VALactividades:"",
			VALescuela:"",
			
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
			this.codigo = value;
			this.validateCodigo(value);
		},
		nombres(value){	
			this.validator.validate('nombres', value);
			this.validateForm();
			this.nombres = value;
			this.validateNombre(value);
		},
		apellidos(value){	
			this.validator.validate('apellidos', value);
			this.validateForm();
			this.apellidos = value;
			this.validateApellido(value);
		},
		genero(value){	
			this.validator.validate('genero', value);
			this.validateForm();
			this.genero = value;
			this.validateGenero(value);
		},
		fecha_nacimiento(value){	
			this.validator.validate('fecha_nacimiento', value);
			this.validateForm();
			this.fecha_nacimiento = value;
			this.validateFecha(value);
		},
		ocupacion(value){	
			this.validator.validate('ocupacion', value);
			this.validateForm();
			this.ocupacion = value;
			this.validateOcupacion(value);
		},
		grado(value){	
			this.validator.validate('grado', value);
			this.validateForm();
			this.grado = value;
			this.validateEscolaridad(value);
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
			this.escuela_id = value;
			this.validateEscuela(value);
		},
		actividades(value){
			this.validator.validate('actividades', value);
			this.validateForm();
			this.actividades = value;
			this.validateActividades(value);
		},
	},
	methods: {
		camposCambioEstado(){
				this.codigo="a"
				this.nombres="a"
				this.apellidos="a"
				this.genero="1"
				this.fecha_nacimiento="1"
				this.escuela_id="1"
		},
		camposCambioEstado2(){
				this.codigo=""
				this.nombres=""
				this.apellidos=""
				this.genero=""
				this.fecha_nacimiento=""
				this.escuela_id=""
		},
		validateCodigo(value){
		if (/^[a-zA-Z0-9]*$/.test(value))
			{
				this.VALcodigo = '';
			} else{
				this.VALcodigo = 'El campo solo debe de contener letras y números';
			} 
		if (value.length<21)
			{
				this.VALcodigo2 = '';
			} else{
				this.VALcodigo2 = 'Este campo solo acepta hasta 20 caracteres';
			} 
		if (value=="")
			{
				this.VALcodigo3 = 'El campo código es requerido';
			} else{
				this.VALcodigo3 = '';
			} 
		},
		validateNombre(value){
		if (/^[a-zA-ZÀ-ÿ\u00f1\u00d1 ]*$/.test(value))
			{
				this.VALnombres = '';
			} else{
				this.VALnombres = 'El campo solo debe de contener letras y espacios';
			} 
		if (value.length<31)
			{
				this.VALnombres2 = '';
			} else{
				this.VALnombres2 = 'Este campo solo acepta hasta 30 caracteres';
			} 
		if (value=="")
			{
				this.VALnombres3 = 'El campo nombres es requerido';
			} else{
				this.VALnombres3 = '';
			} 
		},
		validateApellido(value){
		if (/^[a-zA-ZÀ-ÿ\u00f1\u00d1 ]*$/.test(value))
			{
				this.VALapellidos = '';
			} else{
				this.VALapellidos = 'El campo solo debe de contener letras y espacios';
			} 
		if (value.length<31)
			{
				this.VALapellidos2 = '';
			} else{
				this.VALapellidos2 = 'Este campo solo acepta hasta 30 caracteres';
			} 
		if (value=="")
			{
				this.VALapellidos3 = 'El campo apellidos es requerido';
			} else{
				this.VALapellidos3 = '';
			} 
		},
		validateGenero(value){
		if (value=="")
			{
				this.VALgenero = 'Seleccione una opción';
			} else{
				this.VALgenero = '';
			} 
		},
		validateFecha(value){
		if (value=="")
			{
				this.VALfecha = 'El campo fecha de nacimiento es requerido';
			} else{
				this.VALfecha = '';
			} 
		},
		validateOcupacion(value){
		if (value.length<151)
			{
				this.VALocupacion = '';
			} else{
				this.VALocupacion = 'Este campo solo acepta hasta 150 caracteres';
			} 
		},
		validateActividades(value){
		if (value.length<151)
			{
				this.VALactividades = '';
			} else{
				this.VALactividades = 'Este campo solo acepta hasta 150 caracteres';
			} 
		},
		validateEscolaridad(value){
		if (value.length<151)
			{
				this.VALgrado = '';
			} else{
				this.VALgrado = 'Este campo solo acepta hasta 150 caracteres';
			} 
		},
		validateEscuela(value){
		if (value=="")
			{
				this.VALescuela = 'El campo escuela es requerido';
			} else{
				this.VALescuela = '';
			} 
		},
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
				ruta_imagen: '/storage/public/' + me.ruta_imagen,
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
		this.importarEscuelas();
		this.camposCambioEstado();
		this.camposCambioEstado2();
	},
	created() {
		this.validator = new Validator({
			codigo: 'required|alpha_num|max:20',
			nombres: 'required|alpha_spaces|max:30',
			apellidos: 'required|alpha_spaces|max:30',
			genero: 'required',
			grado: 'max:50',
			ocupacion: 'max:150',
			actividades :'max:150',
			fecha_nacimiento :'required',
			escuela_id :'required',
		});
		//this.$set(this, 'errores', this.validator.errors);

	}
}
</script>