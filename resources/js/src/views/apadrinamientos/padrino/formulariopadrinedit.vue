<template>
  <vx-card>
<div class="vx-col md:w-1/2 w-full mt-5">
  <router-link to="/apadrinamiento/padrino"><vs-button class="w-full" icon-pack="feather" type="border" radius icon="icon-corner-up-left" icon-no-border></vs-button></router-link>
    </div>
    <div class="mt-5">
      <form-wizard color="rgba(var(--vs-primary), 1)" errorColor="rgba(var(--vs-danger), 1)" title="ACTUALIZACIÓN DE PADRINO" :subtitle="null" finishButtonText="Enviar" back-button-text="Atrás" next-button-text="Siguiente" @on-complete="formSubmitted">
				<vs-divider position="right">PID&#174;</vs-divider>
      
	   <tab-content title="Paso 1" class="mb-5" icon="feather icon-user" :before-change="validateStep1">

          <!-- tab 1 content -->
          <form data-vv-scope="step-1">
          <div class="vx-row">
            <div class="vx-col md:w-1/2 w-full mt-5">
              <vs-input label="Nombres" v-model="nombresT" class="w-full" name="nombres" v-validate="'required|alpha_spaces|max:30'" />
              <span class="text-danger">{{ errors.first('step-1.nombres') }}</span>
            </div>

            <div class="vx-col md:w-1/2 w-full mt-5">
              <vs-input label="Apellidos"  v-model="apellidosT" class="w-full" name="apellidos" v-validate="'required|alpha_spaces|max:30'" />
              <span class="text-danger">{{ errors.first('step-1.apellidos') }}</span>
            </div>

			<div class="vx-col md:w-1/2 w-full mt-5">
              <vs-input label="ID"  v-model="CUIT" class="w-full" name="cui" v-validate="'alpha_num|max:15'" />
              <span class="text-danger">{{ errors.first('step-1.cui') }}</span>
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
			  <small class="date-label">Fecha de nacimiento</small>
			  <datepicker :language="$vs.rtl ? langEn : langEn"  v-model="fecha_nacimientoT"></datepicker>
			</div>
	        
			<div class="vx-col md:w-1/2 w-full mt-5">
              <vs-input label="Dirección"  v-model="direccionT" class="w-full" name="direccion" v-validate="'required|max:254'" />
              <span class="text-danger">{{ errors.first('step-1.direccion') }}</span>
            </div>

			<div class="vx-col md:w-1/2 w-full mt-5">
              <vs-input label="Número de teléfono"  v-model="numero_telefonoT" class="w-full" name="telefono" v-validate="'max:15|numeric'" />
              <span class="text-danger">{{ errors.first('step-1.telefono') }}</span>
            </div>
          </div>
          </form>
        </tab-content>

        <!-- tab 2 content -->
        <tab-content title="Paso 2" class="mb-5" icon="feather icon-briefcase" :before-change="validateStep2">
          <form data-vv-scope="step-2">
          <div class="vx-row">

            <div class="vx-col md:w-1/2 w-full">
			<template>
				<div class="vx-col md:w-1/2 w-full mt-5">
						<img :src="imagen_perfil_antigua" :alt="imagen_perfil_antigua"  width="100" height="100" class="responsive">
						<vx-tooltip text="Editar Imagen"> <vs-button class="mr-4" type="border" icon-pack="feather" color="#1551b1" icon="icon-edit" radius  @click="editarImagen"></vs-button> </vx-tooltip>
						<vs-upload v-if="mostrarEditar" automatic action="/api/padrino/imagen" limit='1' :headers="head" fileName='photos' @on-success="respuesta" @on-delete="vaciar" text="Imagen de perfil" />
				</div>
			</template> 
            </div>
				<div class="vx-col md:w-1/2 w-full mt-5">
				<vs-input type="email" label="Correo"  v-model="correoT" class="w-full" name="correo" v-validate="'required|email|max:100'" />
				<span class="text-danger">{{ errors.first('step-2.correo') }}</span>
            </div>

          </div>
          </form>
        </tab-content>
      </form-wizard>
    </div>
    <div class="vx-col md:w-1/3 w-full mt-5">
  <router-link to="/apadrinamiento/padrino"><vs-button class="w-full" type="gradient" icon-pack="feather" icon="icon-corner-up-left" icon-no-border>Regresar</vs-button></router-link>
    </div>

  </vx-card>
</template>

<script>
import { FormWizard, TabContent } from 'vue-form-wizard'
import 'vue-form-wizard/dist/vue-form-wizard.min.css'
import vSelect from 'vue-select'
// import VueSelect from 'vue-select'
import Datepicker from 'vuejs-datepicker'
import axios from 'axios'
import { es } from 'vuejs-datepicker/src/locale'
import VueRouter from 'vue-router'

// For custom error message
import { Validator } from 'vee-validate'
const dict = {
  custom: {
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
    correo: {
      required: 'El campo correo es requerido',
	  email: 'Ingrese un correo válido',
	  max: 'Este campo solo acepta hasta 100 caracteres',
    },
    cui: {
	  alpha_num: 'El campo solo debe de contener letras y números',
	  max: 'Este campo solo acepta hasta 15 caracteres',
	},
	fecha: {
      required: 'El campo fecha es requerido',
	},
	direccion: {
	  required: 'El campo dirección es requerido',
	  max: 'Este campo solo acepta hasta 254 caracteres',
	},
	telefono: {
	  numeric: 'El campo solo debe de contener números',
	  max: 'Este campo solo acepta hasta 15 caracteres',
	},
	radio: {
	  required: 'Seleccione una opción',
	  included: 'Seleccione una opción',
	},
  }
}

// register custom messages
Validator.localize('en', dict)

export default {
	data () {
		return {
			nombresT: "",
			apellidosT: "",
			direccionT: "",
			idT:'',
			generoT:'',
			fecha_nacimientoT:this.getDate(this.fecha_nacimiento),
			CUIT:'',
			numero_telefonoT:'',
			correoT:'',
			sectoresT: [],
			arrayData: [],
			sector_idT:'',
			persona_sin_acceso_idT:'',
			langEn: es,
			id_recibido:'',
			mostrarEditar:false,
			imagen_perfil_antigua:'',
			titulo:'Actualización registrada!',
			head:{
				"imagenanterior":""	
			},
		}
	},
	methods: {
		async index(){ //async para que se llame cada vez que se necesite
			let me = this;
			this.id_recibido = this.$route.params.id;
			const response = await axios.get(
				`/api/padrino/get?&criterio=id&buscar=${this.id_recibido}&completo=true`)
			.then(function (response) {
				var respuesta= response.data;
				me.arrayData = respuesta.padrinos.data[0];
				me.nombresT = me.arrayData.datos.nombres;
				me.apellidosT = me.arrayData.datos.apellidos;
				me.direccionT = me.arrayData.datos.direccion;
				me.idT = me.arrayData.datos.id;
				me.generoT = me.arrayData.datos.genero;
				me.fecha_nacimientoT = me.arrayData.datos.fecha_nacimiento;
				me.CUIT = me.arrayData.datos.CUI;
				me.numero_telefonoT = me.arrayData.datos.numero_telefono;
				me.correoT = me.arrayData.correo;
				me.imagen_perfil_antigua = me.arrayData.ruta_imagen;
				me.persona_sin_acceso_idT = me.arrayData.datos.persona_sin_acceso_id;
			})
			.catch(function (error) {
				console.log(error);
			});
		},
		getDate(datetime) {
			let date = new Date(datetime);
			let dateString = `${date.getFullYear()}/${date.getMonth() + 1}/${date.getDate()}`;
			return dateString;
			},

		validateStep1 () {
			return new Promise((resolve, reject) => {
			this.$validator.validateAll('step-1').then(result => {
				if (result) {
				resolve(true)
				} else {
				reject('correct all values')
				this.$vs.notify({
					color:'danger',
					title:'Error en validación!',
					text:'Ingrese todos los campos correctamente'
					});
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
			if (this.ruta_imagen === '' || this.ruta_imagen === undefined){
				this.ruta_imagen= this.imagen_perfil_antigua;
			}
			else{
				this.ruta_imagen= '/storage/public/padrinos/' + this.ruta_imagen;
			}
			axios.put("/api/padrino/update/",{
			id:this.id_recibido,
				nombres:this.nombresT,
				apellidos:this.apellidosT,
				CUI:this.CUIT,
				numero_telefono:this.numero_telefonoT,
				correo:this.correoT,
				ruta_imagen:this.ruta_imagen,
				genero:this.generoT,
				fecha_nacimiento:this.getDate(this.fecha_nacimientoT),
				direccion:this.direccionT,
			sector_id:this.sector_idT.id

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
			this.$router.push('/apadrinamiento/padrino');
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
		vSelect,
	},
	mounted(){
		this.index();
	},
}
</script>
