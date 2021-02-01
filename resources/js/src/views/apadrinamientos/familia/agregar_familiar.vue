<template>
   	<vx-card>
		<div>
			<vs-row	vs-align="center" vs-type="flex" vs-justify="space-around" vs-w="12">
				<div class="vx-col md:w-1/2 w-full mt-5">
					<vx-card noShadow class="center" title="INGRESAR FAMILIAR" title-color="primary">
					</vx-card>
				</div>
			</vs-row>
			<div class="vx-row">
				<div class="vx-col md:w-1/2 w-full mt-5">
					<vs-upload automatic action="/api/encargado/imagen" limit='1' text="Imagen de perfil" :headers="head" fileName='photos' @on-success="respuesta" @on-delete="vaciar"/>
				</div>
			
				<div class="vx-col md:w-1/2 w-full mt-5">
					<div class="vx-col w-full">

						<vs-input class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="Nombres" v-model="nombres" name="nombres"/>
								<div v-if="VALnombres"><span class="text-danger">{{ VALnombres }}</span><br></div>
								<div v-if="VALnombres2"><span class="text-danger">{{ VALnombres2 }}</span><br></div>
								<div v-if="VALnombres3"><span class="text-danger">{{ VALnombres3 }}</span></div>

						<vs-input class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="Apellidos" v-model="apellidos" name="apellidos" />
								<div v-if="VALapellidos"><span class="text-danger">{{ VALapellidos }}</span><br></div>
								<div v-if="VALapellidos2"><span class="text-danger">{{ VALapellidos2 }}</span><br></div>
								<div v-if="VALapellidos3"><span class="text-danger">{{ VALapellidos3 }}</span></div>


						<vs-input class="w-full" icon-pack="feather" icon="icon-hash" icon-no-border label-placeholder="CUI" v-model="CUI" name="CUI" />
								<div v-if="VALcui"><span class="text-danger">{{ VALcui }}</span><br></div>
								<div v-if="VALcui2"><span class="text-danger">{{ VALcui2 }}</span><br></div>

						<small class="date-label mt-10">Género</small>
							<ul class="demo-alignment">
								<li>
									<vs-radio color="rgb(0, 170, 228)" v-model="genero" vs-value="1" name="genero">Masculino</vs-radio>
								</li>
								<li>
									<vs-radio color="rgb(255, 0, 128)" v-model="genero" vs-value="0" name="genero">Femenino</vs-radio>
								</li>
							</ul>
							<div v-if="VALgenero"><span class="text-danger">{{ VALgenero }}</span><br></div>
					</div>
				</div>

				<div class="vx-col md:w-1/2 w-full mt-6">
					<div class="vx-col w-full">
						<vs-input class="w-full" icon-pack="feather" icon="icon-phone" icon-no-border label-placeholder="Número de teléfono" name="telefono" v-model="telefono"/>
							<div v-if="VALtelefono"><span class="text-danger">{{ VALtelefono }}</span><br></div>
							<div v-if="VALtelefono2"><span class="text-danger">{{ VALtelefono2 }}</span><br></div>
					</div>
				</div>

				<div class="vx-col md:w-1/2 w-full mt-1">
					<div class="my-4">
						<small class="date-label">Fecha Nacimiento</small>
						<datepicker :language="$vs.rtl ? langEn : langEn" name="fecha_nacimiento" v-model="fecha_nacimiento"></datepicker>
				<div v-if="VALfecha"><span class="text-danger">{{ VALfecha }}</span><br></div>
			</div>
				</div>

				<div class="vx-col md:w-1/2 w-full mt-2">
					<div class="vx-col w-full">
						<vs-input class="w-full" icon-pack="feather" icon="icon-users" icon-no-border label-placeholder="Parentesco con los niños" name="relacion" v-model="relacion"/>
							<div v-if="VALrelacion"><span class="text-danger">{{ VALrelacion }}</span><br></div>
							<div v-if="VALrelacion2"><span class="text-danger">{{ VALrelacion2 }}</span><br></div>
							<div v-if="VALrelacion3"><span class="text-danger">{{ VALrelacion3 }}</span></div>
					</div>
				</div>

				<div class="vx-col md:w-1/2 w-full mt-2	">
					<div class="vx-col w-full">
						<vs-input class="w-full"  icon="school" icon-no-border label-placeholder="Escolaridad" name="escolaridad" v-model="escolaridad"/>
							<div v-if="VALescolaridad"><span class="text-danger">{{ VALescolaridad }}</span><br></div>
					</div>
				</div>

				<div class="vx-col md:w-1/2 w-full mt-6">
					<div class="vx-col w-full">
						<vs-input class="w-full" icon-pack="feather" icon="icon-briefcase" icon-no-border label-placeholder="Ocupación" name="ocupacion" v-model="ocupacion"/>
							<div v-if="VALocupacion"><span class="text-danger">{{ VALocupacion }}</span><br></div>
					</div>
				</div>

				<div class="vx-col md:w-1/2 w-full mt-6">
					<div class="vx-col w-full">
						<vs-input class="w-full" icon="local_atm" icon-no-border label-placeholder="Ingresos Mensuales" name="ingresos" v-model="ingresos"/>
							<div v-if="VALingresos"><span class="text-danger">{{ VALingresos }}</span><br></div>
							<div v-if="VALingresos2"><span class="text-danger">{{ VALingresos2 }}</span><br></div>
					</div>
				</div>

			</div>
		</div>
		<div class="flex flex-wrap items-center justify-between mt-8">
			<div class="flex items-center">
				<vs-button class="mb-base mr-3" type="gradient" icon-pack="feather" icon="icon-printer" color="success"  @click="ingresarFamilia">Registrar</vs-button>
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
import { Validator } from 'vee-validate'
import { es } from 'vuejs-datepicker/src/locale'

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
    validacionD:true
  },
  data () {
    return {
		VALnombres: "",
		VALnombres2: "",
		VALnombres3: "",
		VALapellidos: "",
		VALapellidos2: "",
		VALapellidos3: "",
		VALgenero:'',
		VALfecha: "",
		VALcui:'',
		VALcui2:'',
		VALtelefono: '',
		VALtelefono2: '',
		VALrelacion: '',
		VALrelacion2: '',
		VALrelacion3: '',
		VALescolaridad: '',
		VALocupacion: '',
		VALingresos: '',
		VALingresos2: '',


		nombres: null,
		apellidos: null,
		CUI:null,
		genero:null,
		telefono: null,
		fecha_nacimiento: null,
		relacion: null,
		escolaridad:null,
		ocupacion: null,
		ingresos:null,
		langEn: es,
		msg:'',
		ruta_imagen:"",
		head:{
			"imagenanterior":""	
		},
		direccionT:'',
		sectorT:0,
		codigoT:0,
    }
  },
  watch: {
    validacionD (newVal, oldVal) {
      if (newVal == false) {
		 this.validarNombre()
      }
    },

    nombres (value) {
      this.validator.validate('nombres', value)
      this.validateForm()
      this.nombres = value;
			this.validateNombre(value);
    },
    apellidos (value) {	
      this.validator.validate('apellidos', value)
      this.validateForm()
      this.apellidos = value;
			this.validateApellido(value);
    },
    CUI (value) {	
      this.validator.validate('CUI', value)
      this.validateForm()
      this.CUI = value;
			this.validateCUI(value);
    },
    genero (value) {	
      this.validator.validate('genero', value)
      this.validateForm()
      this.genero = value;
			this.validateGenero(value);
    },
    telefono (value) {
      this.validator.validate('telefono', value)
      this.validateForm()
      this.telefono = value;
			this.validateTelefono(value);
    },
    fecha_nacimiento (value) {	
      this.validator.validate('fecha_nacimiento', value)
      this.validateForm()
      this.fecha_nacimiento = value;
			this.validateFecha(value);
    },
    relacion (value) {	
      this.validator.validate('relacion', value)
      this.validateForm()
      this.relacion = value;
			this.validateRelacion(value);
    },
    escolaridad (value) {	
      this.validator.validate('escolaridad', value)
      this.validateForm()
      this.escolaridad = value;
			this.validateEscolaridad(value);
    },
    ocupacion (value) {	
      this.validator.validate('ocupacion', value)
      this.validateForm()
      this.ocupacion = value;
			this.validateOcupacion(value);
    },
    ingresos (value) {	
      this.validator.validate('ingresos', value)
      this.validateForm()
      this.ingresos = value;
			this.validateIngresos(value);
    }
  },
  methods: {
    camposCambioEstado(){
		this.nombres="a"
		this.apellidos="a"
		this.CUI="1"
		this.genero="1"
		this.telefono="1"
		this.fecha_nacimiento="1"
		this.relacion="a"
		this.escolaridad="a"
		this.ocupacion="a"
		this.ingresos="1"
	},
	camposCambioEstado2(){
		this.nombres=""
		this.apellidos=""
		this.CUI=""
		this.genero=""
		this.telefono=""
		this.fecha_nacimiento=""
		this.relacion=""
		this.escolaridad=""
		this.ocupacion=""
		this.ingresos=""
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
	validateEscolaridad(value){
	if (value.length<151)
		{
			this.VALescolaridad = '';
		} else{
			this.VALescolaridad = 'Este campo solo acepta hasta 150 caracteres';
		} 
	},
	validateTelefono(value){
	if (/^[0-9 ]*$/.test(value))
		{
			this.VALtelefono = '';
		} else{
			this.VALtelefono = 'El campo solo debe de contener números';
		} 
	if (value.length<16)
		{
			this.VALtelefono2 = '';
		} else{
			this.VALtelefono2 = 'Este campo solo acepta hasta 15 caracteres';
		} 
	},
	validateCUI(value){
	if (/^[0-9 ]*$/.test(value))
		{
			this.VALcui = '';
		} else{
			this.VALcui = 'El campo solo debe de contener números';
		} 
	if (value.length<14)
		{
			this.VALcui2 = '';
		} else{
			this.VALcui2 = 'Este campo solo acepta hasta 13 caracteres';
		} 
	},
	validateIngresos(value){
	if (/^[0-9 ]*$/.test(value))
		{
			this.VALingresos = '';
		} else{
			this.VALingresos = 'El campo solo debe de contener números';
		} 
	if (value.length<10)
		{
			this.VALingresos2 = '';
		} else{
			this.VALingresos2 = 'Este campo solo acepta hasta 9 caracteres';
		} 
	},
	validateRelacion(value){
    if (/^[a-zA-Z ]*$/.test(value))
		{
			this.VALrelacion = '';
		} else{
			this.VALrelacion = 'El campo solo debe de contener letras y espacios';
		} 
	if (value.length<31)
		{
			this.VALrelacion2 = '';
		} else{
			this.VALrelacion2 = 'Este campo solo acepta hasta 30 caracteres';
		} 
	if (value=="")
		{
			this.VALrelacion3 = 'El campo parentesco es requerido';
		} else{
			this.VALrelacion3 = '';
		} 
	},
    getDate (datetime) {
      const date = new Date(datetime)
      const dateString = `${date.getFullYear()}/${date.getMonth() + 1}/${date.getDate()}`
      return dateString
    },
    successUpload () {
		this.$vs.notify({color:'success', title:'Fotografia', text:'Fotografia importada'})
    },
    validateForm () {
		this.validator.validateAll({
			nombres: this.nombres,
			apellidos: this.apellidos,
			CUI: this.CUI,
			genero: this.genero,
			telefono :this.telefono,
			fecha_nacimiento :this.fecha_nacimiento,
			relacion: this.relacion,
			escolaridad: this.escolaridad,
			ocupacion: this.ocupacion,
			ingresos: this.ingresos
    	}).then((result) => {
			if (result) {
				this.$emit('validado', {validado:result, id_form:this.$props.id_formulario})
				return
			}
			this.$emit('validado', {validado:false, id_form:this.$props.id_formulario})
      	})
    },
    registrarRelacion(id) {
		let me = this
		var i =0
		var elemento ={}
		let bandera =true
		for (i=0; i < me.listadoNinos.length; i++){
			elemento = me.listadoFamilia[i]
			axios.post ("/api/relacion/post/", {
				direccion : me.direccionT,
				codigo:me.codigoT,
				sector_id:me.sectorT,
				relacion:me.relacion,
				nino_id:elemento.nino_id,
				estado:1,
				encargado_id:id,
			}).then(function(response) {
				console.log(response)
				if (bandera == true && i == me.listadoFamilia.length)
				{
					me.$vs.notify({
						color:'success',
						title:`Niño registrado`,
						text:'La acción se realizo exitósamente'
					});
					me.$router.push('/editar/familia/' + me.codigoT);
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
		})
		.catch(function (error) {
			console.log(error);
		});
	},
    ingresarFamilia() {
		if (this.ruta_imagen === ''){
			this.ruta_imagen= "default.png"
		}
		const me = this
		axios.post('/api/encargado/post/', {
			nombres:me.nombres,
			apellidos:me.apellidos,
			CUI:me.CUI,
			numero_telefono:me.telefono,
			genero:me.genero,
			fecha_nacimiento:me.getDate(me.fecha_nacimiento),
			sector_id: me.sectorT,
			direccion: me.direccionT,

			ruta_imagen:'/storage/public/' + me.ruta_imagen,
			ocupacion:me.ocupacion,
			escolaridad:me.escolaridad,
			ingresos:me.ingresos
		}).then(function (response) {
			me.registrarRelacion(response.data.id)
		})
		.catch(function (error) {
			console.log(error)
		})
    },
    validarNombre () {
		  this.msg = 'El campo es requerido' 	  
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
		vSelect
  	},
	mounted(){
		this.buscarFamilia();
		this.camposCambioEstado();
		this.camposCambioEstado2();
	},
	created () {
		this.validator = new Validator({
			nombres: 'required|alpha_spaces|max:30',
			apellidos: 'required|alpha_spaces|max:30',
			CUI: 'numeric|max:13',
			genero: 'required',
			telefono: 'numeric|max:15',
			fecha_nacimiento :'required',
			relacion: 'required|alpha_spaces|max:30',
			escolaridad:'max:150',
			ocupacion:'max:150',
			ingresos:'numeric|max:15'
		})
	}
}
</script>