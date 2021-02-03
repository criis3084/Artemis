<template>
   	<vx-card>
			<vs-button @click="goBack" class="mr-4 mt-3" type="border" radius icon-pack="feather" color="primary" icon="icon-corner-up-left"> </vs-button>
<form>
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

						<vs-input class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="Nombres" v-model="nombres" name="nombres" v-validate="'required|max:30|alpha_num'"/>
						<span class="text-danger">{{ errors.first('nombres') }}</span>

						<vs-input class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="Apellidos" v-model="apellidos" name="apellidos"  v-validate="'required|max:30|alpha_num'"/>
						<span class="text-danger">{{ errors.first('apellidos') }}</span>


						<vs-input class="w-full" icon-pack="feather" icon="icon-hash" icon-no-border label-placeholder="CUI" v-model="CUI" name="CUI"  v-validate="'required|max:20|numeric'"/>
						<span class="text-danger">{{ errors.first('CUI') }}</span>

						<small class="date-label mt-10">Género</small>
							<ul class="demo-alignment">
								<li>
									<vs-radio v-validate="'required|included:1,0'" color="rgb(0, 170, 228)" v-model="genero" vs-value="1" name="radio">Masculino</vs-radio>
								</li>
								<li>
									<vs-radio color="rgb(255, 0, 128)" v-model="genero" vs-value="0" name="radio">Femenino</vs-radio>
								</li>
							</ul>
					<span class="text-danger">{{ errors.first('radio') }}</span>
					</div>
				</div>

				<div class="vx-col md:w-1/2 w-full mt-6">
					<div class="vx-col w-full">
						<vs-input class="w-full" icon-pack="feather" icon="icon-phone" icon-no-border label-placeholder="Número de teléfono" name="telefono" v-validate="'max:11|numeric'" v-model="telefono"/>
					<span class="text-danger">{{ errors.first('telefono') }}</span>
					</div>
				</div>

				<div class="vx-col md:w-1/2 w-full mt-1">
					<div class="my-4">
						<small class="date-label">Fecha Nacimiento</small>
						<datepicker :language="$vs.rtl ? langEn : langEn" name="fecha_nacimiento" v-model="fecha_nacimiento" v-validate="'required'"></datepicker>
					<span class="text-danger">{{ errors.first('fecha_nacimiento') }}</span>
			</div>
				</div>

				<div class="vx-col md:w-1/2 w-full mt-2">
					<div class="vx-col w-full">
						<vs-input class="w-full" icon-pack="feather" icon="icon-users" icon-no-border label-placeholder="Parentesco con los niños" name="relacion" v-validate="'required|max:150'" v-model="relacion"/>
					<span class="text-danger">{{ errors.first('relacion') }}</span>

					</div>
				</div>

				<div class="vx-col md:w-1/2 w-full mt-2	">
					<div class="vx-col w-full">
						<vs-input class="w-full"  icon="school" icon-no-border label-placeholder="Escolaridad" name="escolaridad" v-validate="'max:150'" v-model="escolaridad"/>
					<span class="text-danger">{{ errors.first('escolaridad') }}</span>
					</div>
				</div>

				<div class="vx-col md:w-1/2 w-full mt-6">
					<div class="vx-col w-full">
						<vs-input class="w-full" icon-pack="feather" icon="icon-briefcase" icon-no-border label-placeholder="Ocupación" name="ocupacion" v-validate="'max:150'" v-model="ocupacion"/>
					<span class="text-danger">{{ errors.first('ocupacion') }}</span>
					</div>
				</div>

				<div class="vx-col md:w-1/2 w-full mt-6">
					<div class="vx-col w-full">
						<vs-input class="w-full" icon="local_atm" icon-no-border label-placeholder="Ingresos Mensuales" name="ingresos" v-validate="'max:9|numeric'" v-model="ingresos"/>
					<span class="text-danger">{{ errors.first('ingresos') }}</span>

					</div>
				</div>

			</div>
		</div>
		<div class="flex flex-wrap items-center justify-between mt-8">
			<div class="flex items-center">
				<vs-button class="mb-base mr-3" type="gradient" icon-pack="feather" icon="icon-save" color="success"  @click="ingresarFamilia">Registrar</vs-button>
			</div>
		</div>
</form>
				<vs-button @click="goBack" class="mb-base mr-3" type="gradient" icon-pack="feather" color="primary" icon="icon-corner-up-left"> Regresar</vs-button>			
		
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

const dict = {
  custom: {
	CUI:{
	  numeric: 'El campo solo debe de contener números',
		required: 'El campo CUI es requerido',
	  max: 'Este campo solo acepta hasta 20 caracteres',
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
	numeric: {
	  max: 'Este campo solo acepta hasta 8 caracteres',
	  numeric: 'El campo solo debe de contener números',
	},
	fecha_nacimiento:{
		 required: 'El campo fecha de nacimiento es requerido',
	},
	relacion:{
		 required: 'El campo parentesco es requerido',
		max: 'Este campo solo acepta hasta 150 caracteres',
	},
	ocupacion:{
		max: 'Este campo solo acepta hasta 150 caracteres',
	},
	escolaridad:{
		max: 'Este campo solo acepta hasta 50 caracteres',
	},
	grado:{
		max: 'Este campo solo acepta hasta 150 caracteres',
	},
  }
}

Validator.localize('es', dict)

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
  
  methods: {
    
    getDate (datetime) {
      const date = new Date(datetime)
      const dateString = `${date.getFullYear()}/${date.getMonth() + 1}/${date.getDate()}`
      return dateString
	},
	goBack(){
			this.$router.go(-1)
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
						title:`Familiar registrado`,
						text:'La acción se realizo exitósamente'
					});
				}
			}).catch(function(error) {
				bandera = false
				console.log(error)
				me.$vs.notify({
					color:'danger',
					title:`Error`,
					text:'Hubo un error en el registro'
				});
			});
		}
		me.$router.push('/editar/familia/' + me.codigoT);
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
this.$validator.validateAll().then(result => {
if(result) {
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