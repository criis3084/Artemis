<template>
	<div>	
		<vs-prompt :active.sync="ingresar" :is-valid="copia"></vs-prompt>	
		<vs-row	vs-align="center" vs-type="flex" vs-justify="space-around" vs-w="12">
			<div class="vx-col md:w-1/2 w-full mt-5">
				<vx-card noShadow class="center" title="INGRESAR FAMILIARES DEL NIÑO" title-color="primary">
				</vx-card>
			</div>
		</vs-row>
		<div class="vx-row">
			<div class="vx-col md:w-1/2 w-full mt-5">
				<vs-upload @on-success="successUpload" limit='1' text="Imagen de Perfil" />
			</div>
		
			<div class="vx-col md:w-1/2 w-full mt-5">
				<div class="vx-col w-full">

					<vs-input class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="Nombres" v-model="nombres" name='nombres'/>
					<span class="text-danger">los nombres son requeridos</span>

					<vs-input class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="Apellidos" v-model="apellidos" name='apellidos' />
					<span class="text-danger">los apellidos son requeridos</span>
					<br>

					<vs-input class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="DPI" v-model="CUI" name='CUI' />
					<span class="text-danger">El DPI es requerido</span>

					<small class="date-label mt-10">Genero</small>
						<ul class="demo-alignment">
							<li>
								<vs-radio color="rgb(0, 170, 228)" v-model="genero" vs-value="1" name='genero'>Masculino</vs-radio>
							</li>
							<li>
								<vs-radio color="rgb(255, 0, 128)" v-model="genero" vs-value="0" name='genero'>Femenino</vs-radio>
							</li>
						</ul>
				</div>
			</div>

			<div class="vx-col md:w-1/2 w-full mt-6">
				<div class="vx-col w-full">
					<vs-input class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="Numero de telefono" name='telefono' v-model="telefono"/>
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
					<vs-input class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="Parentesco con el niño/niña apadrinado" name='relacion' v-model="relacion"/>
				</div>
			</div>

			<div class="vx-col md:w-1/2 w-full mt-6">
				<div class="vx-col w-full">
					<vs-input class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="Escolaridad" name='escolaridad' v-model="escolaridad"/>
				</div>
			</div>

			<div class="vx-col md:w-1/2 w-full mt-6">
				<div class="vx-col w-full">
					<vs-input class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="Ocupacion" name='ocupacion' v-model="ocupacion"/>
				</div>
			</div>

			<div class="vx-col md:w-1/2 w-full mt-6">
				<div class="vx-col w-full">
					<vs-input class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="Ingresos Mensuales" name='ingresos' v-model="ingresos"/>
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
import { Validator } from 'vee-validate';
import { es } from 'vuejs-datepicker/src/locale'
// register custom messages

// For custom error message
/*
Validator.localize('en', dict);
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
	data() {
		return {
			nombres: "",
			apellidos: "",
			CUI:"",
			genero:'',
			telefono: "",
			fecha_nacimiento: "",
			relacion: "",
			escolaridad: "",
			ocupacion: "",
			ingresos: "",
			langEn: es,
			/*
			sector_id:"",
			direccion: "",
			nombre_fotografia:"",
			*/
		}
	},
	watch: {
		nombres(value) {
			this.validator.validate('nombres', value);
			this.validateForm();
		},
		apellidos(value){	
			this.validator.validate('apellidos', value);
			this.validateForm();
		},
		CUI(value){	
			this.validator.validate('CUI', value);
			this.validateForm();
		},
		genero(value){	
			this.validator.validate('genero', value);
			this.validateForm();
		},
		telefono(value){
			this.validator.validate('telefono', value);
			this.validateForm();
		},
		fecha_nacimiento(value){	
			this.validator.validate('fecha_nacimiento', value);
			this.validateForm();
		},
		relacion(value){	
			this.validator.validate('relacion', value);
			this.validateForm();
		},
		escolaridad(value){	
			this.validator.validate('escolaridad', value);
			this.validateForm();
		},
		ocupacion(value){	
			this.validator.validate('ocupacion', value);
			this.validateForm();
		},
		ingresos(value){	
			this.validator.validate('ingresos', value);
			this.validateForm();
		},
	},
	computed:{
		copia(){
			console.log('ingresando...')
			if(this.$props.ingresar==true)
			{
				console.log('y verdadero')
				this.ingresarFamilia()
			}
		}
	},
	methods: {
		getDate(datetime) {
			let date = new Date(datetime);
			let dateString = `${date.getFullYear()}/${date.getMonth() + 1}/${date.getDate()}`;
			return dateString;
		},
		successUpload(){
			this.$vs.notify({color:'success',title:'Fotografia',text:'Fotografia importada'})
		},
		validateForm() {
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
				ingresos: this.ingresos,
			}).then((result) => {
				if (result ){
					this.$emit('validado',{validado:result,id_form:this.$props.id_formulario});
					return;
				}
				this.$emit('validado',{validado:false,id_form:this.$props.id_formulario});
			});
		},
		ingresarFamilia(){
			axios.post("/api/encargado/post/",{
				nombres:this.nombres,
				apellidos:this.apellidos,
				CUI:this.CUI,
				numero_telefono:this.telefono,
				genero:this.genero,
				fecha_nacimiento:this.getDate(this.fecha_nacimiento),
				sector_id: this.$props.sector_id.id,
				direccion: this.$props.direccion,

				ruta_imagen:this.ruta_imagen,
				ocupacion:this.ocupacion,
				escolaridad:this.escolaridad,
				ingresos:this.ingresos,
			}).then(function(response) {
				console.log(response)
			})
			.catch(function(error) {
				console.log(error)
			});
			/*
			axios.post("/api/relacion/post/",{
				relacion:this.relacion,
				direccion:this.direccion,
				codigo:this.codigo,
				nino_id:this.nino_id,
				sector_id:this.sector_id,
				encargado_id:this.encargado_id,
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
	created() {
		this.validator = new Validator({
			nombres: 'required|alpha_spaces',
			apellidos: 'required|alpha_spaces',
			CUI: 'required',
			genero: 'required',
			telefono: 'required',
			fecha_nacimiento :'required',
			relacion: 'required',
			escolaridad:'required',
			ocupacion:'required',
			ingresos:'required|decimal:2',
		});
	}
}
</script>