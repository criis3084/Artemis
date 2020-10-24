<template>
	<div>
		<vx-card>
			<form-wizard color="rgba(var(--vs-primary), 1)" errorColor="rgba(var(--vs-danger), 1)" title="Nuevo personal médico" subtitle="" finishButtonText="Enviar" back-button-text="Atrás" next-button-text="Siguiente" enctype="multipart/form-data">
				<tab-content title="Paso 1" class="mb-5" icon="feather icon-user-plus" :before-change="validateStep1">

				<!-- tab 1 content -->
					<form data-vv-scope="step-1" >
						<div class="vx-row">

							<div class="vx-col md:w-1/2 w-full mt-5">
								<div class="vx-col w-full">
									<vs-input class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="Nombres" name="nombres" v-model="nombres" v-validate="'required|alpha_spaces'"/>
									<span class="text-danger">{{ errors.first('step-1.nombres') }}</span>
								</div>
							</div>

							<div class="vx-col md:w-1/2 w-full mt-5">
								<div class="vx-col w-full">
									<vs-input class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="Apellidos" v-model="apellidos" name="apellidos" v-validate="'required|alpha_spaces'"/>
									<span class="text-danger">{{ errors.first('step-1.apellidos') }}</span>
								</div>
							</div>

                            <div class="vx-col md:w-1/2 w-full mt-5">
								<div class="vx-col w-full">
                                    <small class="date-label">Profesión</small>
									<v-select label="nombre" :options="Profesiones"  v-model="profesion" :dir="$vs.rtl ? 'rtl' : 'ltr'" name="profesion" v-validate="'required'" />
                                    <span class="text-danger">{{ errors.first('step-1.profesion') }}</span>
								</div>
							</div>

                            <div class="vx-col md:w-1/2 w-full mt-5">
								<div class="vx-col w-full">
									<vs-input class="w-full" icon-pack="feather" icon="icon-hash" icon-no-border label-placeholder="CUI" v-model="CUI" name="cui" v-validate="'required'"/>
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
									<vs-input class="w-full" icon-pack="feather" icon="icon-phone" icon-no-border label-placeholder="Número de teléfono" v-model="numero_telefono" name="telefono" v-validate="'required|numeric'"/>
                                    <span class="text-danger">{{errors.first('step-1.telefono') }}</span>
								</div>
							</div>
							
							<div class="vx-col md:w-1/2 w-full mt-5">
								<div class="vx-col w-full">
									<vs-input class="w-full" icon-pack="feather" icon="icon-map-pin" icon-no-border label-placeholder="Dirección" name="direccion" v-model="direccion" v-validate="'required'"/>
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
					<template>
						<vs-upload automatic action="/api/clinico/imagen" limit="1" :headers="head" fileName="photos" @on-success="respuesta" @on-delete="vaciar" text="Imagen de perfil"/>
					</template>
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
                    <small>Descripción</small>
					<textarea class="w-full" icon-no-border label-placeholder="Descripción" v-model="descripcion"/>
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
				</div>
			</div>

            <div class="vx-col md:w-1/2 w-full mt-5">
				<div class="vx-col w-full">
					<vs-input class="w-full" icon-pack="feather" icon="icon-lock" icon-no-border label-placeholder="Contraseña" v-model="password" name="campo" v-validate="'required'"/>
					<span class="text-danger">{{ errors.first('step-3.campo') }}</span>
				</div>
			</div>

            <div class="vx-col md:w-1/2 w-full mt-5">
				<small class="date-label">Rol</small>
				<v-select label="nombre" :options="roles" v-model="rol_id" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
			</div>

        </form>
    </tab-content>
  </form-wizard>

    <div class="vx-col md:w-1/2 w-full mt-5">
	<router-link to="/clinica/PersonalMedico"><vs-button class="w-full" icon-pack="feather" icon="icon-corner-up-left" icon-no-border>Regresar</vs-button></router-link>
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
      required: 'Los nombres son requeridos',
      alpha_spaces: 'El nombre solo debe incluir letras'
    },
    apellidos: {
	  required: 'Los apellidos son requeridos',
      alpha_spaces: 'El nombre solo debe incluir letras'
    },
    direccion: {
      required: 'La direccion es requerida'
    },
    fecha_nacimiento: {
      required: 'La fecha de nacimiento es requerida',
      alpha_spaces: 'Job title may only contain alphabetic characters'
    },
    cui: {
      required: 'El cui es requerido'
    },
    correo:{
      email:'Ingrese un correo valido '
    },
    campo: {
      required:'Dato requerido'
    },
    profesion :{
      required:'Seleccione una profesión'
    },
    telefono:{
      required:'El numero de teléfono es necesario',
      numeric:'Solo se aceptan números'
    }
  }
}

Validator.localize('en', dict)
import { es } from 'vuejs-datepicker/src/locale'
export default {
  data () {
    return {
      nombres: '',
      apellidos: '',
      direccion: '',
      especialidad:'',
      genero:'',
      CUI:'',
      numero_telefono:'',
      correo:'',
      imagen_perfil:'',
      fecha_nacimiento: '',
      descripcion:'',
      usuario:'',
      password:'',
      roles: [],
      rol_id:'',
      Profesiones:[],
      profesion:'',
      langEn: es,
      codigo:'',
      titulo:'Registrado exitosamente!',
      waterMark : 'Select a date',
      dateVal : new Date(),
      dateFormat : 'yyyy-MM-dd',
      head:{
        'imagenanterior':''	
      }
    }
  },
  methods: {
    getDate (datetime) {
      const date = new Date(datetime)
      const dateString = `${date.getFullYear()}/${date.getMonth() + 1}/${date.getDate()}`
      return dateString
    },
    async importarRoles () { 
      const me = this
      const response = await axios.get(
        '/api/rol/get?completo=true')
        .then(function (response) {
          const respuesta = response.data
          me.roles = respuesta.roles.data
          me.pagination = respuesta.pagination
        })
        .catch(function (error) {
          console.log(error)
        })
    },
    async importarProfesiones () { 
      const me = this
      const response = await axios.get(
        '/api/profesion/get?completo=true')
        .then(function (response) {
          const respuesta = response.data
          me.Profesiones = respuesta.profesiones.data
        })
        .catch(function (error) {
          console.log(error)
        })
    },
    acceptAlert () {
		
      if (this.imagen_perfil === '') {
        this.imagen_perfil = 'default.png'
      }
		
      axios.post('/api/clinico/post/', {
        nombres:this.nombres,
        apellidos:this.apellidos,
        profesion_id:this.profesion.id,
        CUI:this.CUI,
        numero_telefono:this.numero_telefono,
        correo:this.correo,
        imagen_perfil: `/storage/public/personalClinico/${  this.imagen_perfil}`,
        usuario:this.usuario,
        password:this.password,
        descripcion:this.descripcion,
        genero:this.genero,
        fecha_nacimiento:this.getDate(this.fecha_nacimiento),
        direccion:this.direccion,
			
        rol_id:this.rol_id.id
      }).then(function (response) {
        console.log(response)
        alert('Guardado correctamente')
      })
        .catch(function (error) {
          console.log(error)
          alert('Error al gurdar')
        })
      this.$router.push('/clinica/PersonalMedico')
      this.$emit('cerrado', 'Se cerró el formulario')
    },
    vaciar () {
      this.imagen_perfil = ''
    },
    respuesta (e) {
      this.imagen_perfil = e.currentTarget.response.replace(/['"]+/g, '')
      this.head.imagenanterior = this.imagen_perfil
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
            this.acceptAlert()
            // alert('Form submitted!');
            this.$router.push('/clinica/PersonalMedico')
            resolve(true)
          } else {
            this.$vs.notify({
              color:'success',
              title:'Información',
              text:'Ingrese correctamente los datos'
            })
          }
        })
	  })
      //   
    }
  },
  components: {
    FormWizard,
    TabContent,
    Datepicker,
    vSelect
  },	
  mounted () {
    this.importarRoles()
    this.importarProfesiones()
  }
}
</script>