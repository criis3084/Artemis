<template>
	<div>
		<vx-card>
			<form-wizard  color="rgba(var(--vs-primary), 1)" errorColor="rgba(var(--vs-danger), 1)" title="ACTUALIZAR DATOS DE TUTOR" subtitle="" finishButtonText="Enviar" back-button-text="Atrás" next-button-text="Siguiente" @on-complete="formSubmitted">
				<tab-content title="Paso 1" class="mb-5" icon="feather icon-user" :before-change="validateStep1">
					<!-- tab 1 content -->
					<form data-vv-scope="step-1" >
						<div class="vx-row">

							<div class="vx-col md:w-1/2 w-full mt-5">
								<div class="vx-col w-full">
									<vs-input class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="Nombres" name="nombres" v-model="nombresTutor" v-validate="'required|alpha'"/>
									<span class="text-danger">{{ errors.first('step-1.nombres') }}</span>
								</div>
							</div>

							<div class="vx-col md:w-1/2 w-full mt-5">
								<div class="vx-col w-full">
									<vs-input class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="Apellidos" name="apellidos" v-model="apellidosTutor" v-validate="'required|alpha'"/>
									<span class="text-danger">{{ errors.first('step-1.apellidos') }}</span>
								</div>
							</div>

							<div class="vx-col md:w-1/2 w-full mt-5">
								<div class="vx-col w-full">
									<vs-input class="w-full" icon-pack="feather" icon="icon-file-text" icon-no-border label-placeholder="Especialidad" v-model="especialidadTutor"/>
								</div>
							</div>

							<div class="vx-col md:w-1/2 w-full mt-5">
								<div class="vx-col w-full">
									<vs-input class="w-full" icon-pack="feather" icon="icon-hash" icon-no-border label-placeholder="CUI" name="cui" v-model="CUI" v-validate="'required'"/>
									<span class="text-danger">{{ errors.first('step-1.cui') }}</span>
								</div>
							</div>

							<div class="vx-col md:w-1/2 w-full mt-5">
								<div class="my-4">
									<small class="date-label">Fecha de nacimiento</small>
									<datepicker :format="dateFormat" :language="$vs.rtl ? langEn : langEn" name="end-date" v-model="fecha_nacimiento"></datepicker>
								</div>
							</div>

							<div class="vx-col md:w-1/2 w-full mt-5">
								<small class="date-label">Género</small>
								<ul class="demo-alignment">
									<li>
										<vs-radio color="rgb(0, 170, 228)" v-model="genero" vs-value="1" selected>Masculino</vs-radio>
									</li>
									<li>
										<vs-radio color="rgb(255, 0, 128)" v-model="genero" vs-value="0">Femenino</vs-radio>
									</li>
								</ul>
							</div>

							<div class="vx-col md:w-1/2 w-full mt-5">
								<div class="vx-col w-full">
									<vs-input class="w-full" icon-pack="feather" icon="icon-phone" icon-no-border label-placeholder="Número de teléfono" v-model="numero_telefono"/>
								</div>
							</div>

							<div class="vx-col md:w-1/2 w-full mt-5">
								<div class="vx-col w-full">
									<vs-input class="w-full" icon-pack="feather" icon="icon-home" icon-no-border label-placeholder="Dirección" name="direccion" v-model="direccionTutor" v-validate="'required'"/>
									<span class="text-danger">{{errors.first('step-1.direccion') }}</span>
								</div>
							</div>

						</div>
					</form>
				</tab-content>
				<!-- tab 2 content -->
					<tab-content title="Paso 2" class="mb-5" icon="feather icon-file-plus" :before-change="validateStep2">
						<form data-vv-scope="step-2">
							<div class="vx-row">
								<div class="vx-col md:w-1/2 w-full mt-5">
										<img :src="imagen_perfil_antigua"  width="100" height="100" class="responsive">
										<vx-tooltip text="Editar Imagen"> <vs-button class="mr-4" type="border" icon-pack="feather" color="#1551b1" icon="icon-edit" radius  @click="editarImagen"></vs-button> </vx-tooltip>
										<vs-upload v-if="mostrarEditar" automatic action="/api/tutor/imagen" limit='1' :headers="head" fileName='photos' @on-success="respuesta" @on-delete="vaciar"/>
								</div>
							</div>

							<div class="vx-col md:w-1/2 w-full mt-5">
								<div class="vx-col w-full">
									<vs-input class="w-full" icon-pack="feather" icon="icon-mail" icon-no-border label-placeholder="Correo" v-model="correo" name="correo" v-validate="'email'"/>
									<span class="text-danger">{{ errors.first('step-2.correo') }}</span>
								</div>
							</div>

							<div class="vx-col md:w-1/2 w-full mt-5">
								<div class="vx-col w-full">
									<vs-input class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="Descripción" v-model="descripcion"/>
								</div>
							</div>

						</form>
					</tab-content>

						<!-- tab 3 content -->
					<tab-content title="Paso 3" class="mb-5" icon="feather icon-lock" :before-change="validateStep3">
						<form data-vv-scope="step-3">
							<div class="vx-col md:w-1/2 w-full mt-5">
								<div class="vx-col w-full">
									<vs-input class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="Usuario" v-model="usuario" v-validate="'required'" name="campo"/>
									<span class="text-danger">{{ errors.first('step-3.campo') }}</span>
								</div>
							</div>
							<div class="vx-col md:w-1/2 w-full mt-5">
								<div class="vx-col w-full">
									<vs-input class="w-full" icon-pack="feather" icon="icon-lock" icon-no-border label-placeholder="Contraseña" name="campo" v-model="password" v-validate="'required'"/>
									<span class="text-danger">{{ errors.first('step-3.campo') }}</span>
								</div>
							</div>
							<div class="vx-col md:w-1/2 w-full mt-5">
								<small class="date-label">Rol</small>
								<v-select label="nombre" :options="roles"  v-model="rol_id"  :dir="$vs.rtl ? 'rtl' : 'ltr'" />
							</div>
						</form>
					</tab-content>
			</form-wizard>
			<div class="vx-col md:w-1/2 w-full mt-5">
				<router-link to="/tutoria/tutor"><vs-button class="w-full" icon-pack="feather" icon="icon-corner-up-left" icon-no-border >Regresar</vs-button></router-link>
			</div>
		</vx-card>
	</div>
</template>

<script>
import { FormWizard, TabContent } from 'vue-form-wizard'
import 'vue-form-wizard/dist/vue-form-wizard.min.css'
import vSelect from 'vue-select'
import Datepicker from 'vuejs-datepicker'
import axios from 'axios'
// For custom error message
import { Validator } from 'vee-validate'
const dict = {
  custom: {
    nombres: {
      required: 'Los Nombres son requeridos',
      alpha: 'El nombre solo debe incluir letras'
    },
    apellidos: {
	  required: 'Los apellidos son requeridos',
      alpha: 'El nombre solo debe incluir letras'
    },
    direccion: {
      required: 'La direccion es requerida',
    },
    fecha_nacimiento: {
      required: 'La fecha de nacimiento es requerida',
      alpha: 'Job title may only contain alphabetic characters'
    },
    cui: {
      required: 'El cui es requerido'
    },
    correo:{
      email:'Ingrese un correo valido '
    },
    campo: {
      required:'Dato requerido'
    }
    
  }
}

// register custom messages
Validator.localize('en', dict)
import { es } from 'vuejs-datepicker/src/locale'
export default {
	data () {
		return {
			arrayData: [],
			idTutor:'',
			id:'',
			nombresTutor: '',
			apellidosTutor: '',
			direccionTutor: '',
			especialidadTutor:'',
			genero:'',
			CUI:'',
			numero_telefono:'',
			correo:'',
			imagen_perfil_antigua:'',
			imagen_perfil:'',
			fecha_nacimiento:this.getDate(this.fecha_nacimiento),
			descripcion:'',
			usuario:'',
			password:'',
			roles: [],
			selected: '1',
			rol_id:'',
			langEn: es,
			head:{
				"imagenanterior":""	
			},
			mostrarEditar:false,
			id_recibido:'',
			titulo:'Registrado exitosamente!',
			waterMark : 'Select a date',
			dateVal : new Date(),
			dateFormat : 'yyyy-MM-dd'
		}
	},
	methods: {
		editarImagen(){
			this.mostrarEditar=true;
		},
		vaciar(){
			console.log('imagen vaciada!')
			this.imagen_perfil='';
		},
		respuesta(e){
			this.imagen_perfil=e.currentTarget.response.replace(/['"]+/g, '')
			this.head.imagenanterior=this.imagen_perfil
		},
		getDate (datetime) {
			const date = new Date(datetime)
			const dateString = `${date.getFullYear()}/${date.getMonth() + 1}/${date.getDate()}`
			return dateString
		},
		formSubmitted () {
			if (this.imagen_perfil === ''){
				this.imagen_perfil= this.imagen_perfil_antigua;
			}
			else{
				this.imagen_perfil= '/storage/public/tutores/' + this.imagen_perfil;
			}
			axios.put('/api/tutor/update/', {
			id:this.id_recibido,
			nombres:this.nombresTutor,
			apellidos:this.apellidosTutor,
			especialidad:this.especialidadTutor,
			CUI:this.CUI,
			genero:this.genero,
			numero_telefono:this.numero_telefono,
			correo:this.correo,
			imagen_perfil:this.imagen_perfil,
			usuario:this.usuario,
			password:this.password,
			descripcion:this.descripcion,
			fecha_nacimiento:this.getDate(this.fecha_nacimiento),
			direccion:this.direccionTutor,
			rol_id:this.rol_id.id
			}).then(function (response) {
				console.log(response)	
			})
			.catch(function (error) {
				console.log(error)
			})
			this.$emit('cerrado', 'Se cerró el formulario')
			this.$router.push('/tutoria/tutor')
		},
		async index (page, search) { //async para que se llame cada vez que se necesite
			const me = this
			this.id_recibido = this.$route.params.id
			const response = await axios.get(`/api/tutor/get?&criterio=id&buscar=${this.id_recibido}&completo=true`)
			.then(function (response) {
				console.log(page)
				var respuesta =  response.data
				me.arrayData = respuesta.tutors.data[0]
				me.nombresTutor = me.arrayData.datos.nombres
				me.apellidosTutor = me.arrayData.datos.apellidos
				me.direccionTutor = me.arrayData.datos.direccion
				me.especialidadTutor = me.arrayData.especialidad
				me.idTutor = me.arrayData.datos.id
				me.genero = me.arrayData.datos.genero
				me.fecha_nacimiento = me.arrayData.datos.fecha_nacimiento
				me.CUI = me.arrayData.datos.CUI
				me.numero_telefono = me.arrayData.datos.numero_telefono
				me.correo = me.arrayData.datos.correo
				me.imagen_perfil_antigua = me.arrayData.datos.imagen_perfil
				me.descripcion = me.arrayData.datos.descripcion
				me.rol_id = me.arrayData.datos.rol_id
				me.usuario = me.arrayData.datos.usuario
				me.password = me.arrayData.datos.password
				me.pagination = respuesta.pagination
			})
			.catch(function (error) {
				console.log(error)
			})
		},
		async importarRoles(){ //async para que se llame cada vez que se necesite
		let me = this;
		let encontrado=false;
		let elementoE={}
		const response = await axios.get(
			`/api/rol/get?completo=select`)
		.then(function (response) {
			var respuesta= response.data;
			me.roles = respuesta.roles.data;
			me.roles.forEach(function(elemento, indice, array) {
				if (elemento.id==me.rol_id)
				{
					elementoE=elemento
					encontrado=true
				}
			})
			me.rol_id = encontrado == true ? elementoE : {id:me.rol_id,nombre:'Rol desactivado'} 
			me.pagination= respuesta.pagination;
		})
		.catch(function (error) {
			console.log(error);
		});
	},
		successUpload () {
			this.$vs.notify({color:'success', title:'Fotografía', text:'Fotografía importada'})
		},
		validateStep1 () {
			return new Promise((resolve, reject) => {
			this.$validator.validateAll('step-1').then(result => {
				if (result) {
				resolve(true)
				} else {
				reject('correct all values')
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
				}
			})
			})
		},
		validateStep3 () {
			return new Promise((resolve, reject) => {
			this.$validator.validateAll('step-3').then(result => {
				if (result) {
				console.log(this.getDate(this.fecha_nacimiento))
				resolve(true)
				} else {
				reject('correct all values')
				}
			})
			})

		}
	},
	components: {
		FormWizard,
		TabContent,
		Datepicker,
		vSelect
	},
	mounted () {
		
		this.index(1, this.search)
		this.importarRoles()
	}
}
</script>