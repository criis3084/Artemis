<template>
	<div>
		<vx-card>
			<form-wizard @click="acceptAlert()" color="rgba(var(--vs-primary), 1)" errorColor="rgba(var(--vs-danger), 1)" title="INGRESO DE TUTOR" subtitle="" finishButtonText="Enviar" back-button-text="Atrás" next-button-text="Siguiente" enctype="multipart/form-data">
				<tab-content title="Paso 1" class="mb-5" icon="feather icon-user-plus" :before-change="validateStep1">

				<!-- tab 1 content -->
					<form data-vv-scope="step-1" >
						<div class="vx-row">

							<div class="vx-col md:w-1/2 w-full mt-5">
								<div class="vx-col w-full">
									<vs-input class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="Nombres" name="nombres" v-model="nombres" v-validate="'required|alpha'"/>
									<span class="text-danger">{{ errors.first('step-1.nombres') }}</span>
								</div>
							</div>

							<div class="vx-col md:w-1/2 w-full mt-5">
								<div class="vx-col w-full">
									<vs-input class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="Apellidos" v-model="apellidos" name="apellidos" v-validate="'required|alpha'"/>
									<span class="text-danger">{{ errors.first('step-1.apellidos') }}</span>
								</div>
							</div>

                            <div class="vx-col md:w-1/2 w-full mt-5">
								<div class="vx-col w-full">
									<vs-input class="w-full" icon-pack="feather" icon="icon-file-text" icon-no-border label-placeholder="Especialidad" v-model="especialidad"/>
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
									<vs-input class="w-full" icon-pack="feather" icon="icon-phone" icon-no-border label-placeholder="Número de teléfono" v-model="numero_telefono"/>
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
						<vs-upload automatic action="/api/tutor/imagen" @change="datos(this)" @on-success="successUpload" />
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
					<vs-input class="w-full" icon-pack="feather" icon="icon-image" icon-no-border label-placeholder="Ruta de imagen" v-model="imagen_perfil"/>
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
  <router-link to="/tutoria/tutor"><vs-button class="w-full" icon-pack="feather" icon="icon-corner-up-left" icon-no-border>Regresar</vs-button></router-link>
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
import { Validator } from 'vee-validate';
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
Validator.localize('en', dict);
import { es } from 'vuejs-datepicker/src/locale'
export default {
  data() {
    return {
      nombres: "",
      apellidos: "",
      direccion: "",
      especialidad:'',
      genero:'',
      CUI:'',
      numero_telefono:'',
      correo:'',
      imagen_perfil:'',
      fecha_nacimiento: "",
      descripcion:'',
      usuario:'',
      password:'',
      roles: [],
	  rol_id:'',
	  langEn: es,
	  codigo:'',
	  titulo:'Registrado exitosamente!',
	  waterMark : 'Select a date',
      dateVal : new Date(),
	  dateFormat : 'yyyy-MM-dd',
    }
  },
  methods: {
	datos(e){
		console.log(e)
	},
	getDate(datetime) {
	let date = new Date(datetime);
	let dateString = `${date.getFullYear()}/${date.getMonth() + 1}/${date.getDate()}`;
	return dateString;
	},
	async importarRoles(){ //async para que se llame cada vez que se necesite
		let me = this;
		const response = await axios.get(
			`/api/rol/get?completo=select`)
		.then(function (response) {
			var respuesta= response.data;
            me.roles = respuesta.roles.data;
            console.log(me.roles);
			me.pagination= respuesta.pagination;
		})
		.catch(function (error) {
			console.log(error);
		});
	},
	acceptAlert(){
	axios.post("/api/tutor/post/",{
		nombres:this.nombres,
        apellidos:this.apellidos,
        especialidad:this.especialidad,
        CUI:this.CUI,
        numero_telefono:this.numero_telefono,
        correo:this.correo,
        imagen_perfil:this.imagen_perfil,
        usuario:this.usuario,
        password:this.password,
        descripcion:this.descripcion,
		genero:this.genero,
		fecha_nacimiento:this.getDate(this.fecha_nacimiento),
		direccion:this.direccion,
		
		rol_id:this.rol_id.id
	}).then(function(response) {
			console.log(response)
		})
		.catch(function(error) {
		console.log(error)
        });
		this.$emit('cerrado','Se cerró el formulario');
		this.$router.push('/tutoria/tutor');
	},
	successUpload(){
      this.$vs.notify({color:'success',title:'Fotografía',text:'Fotografía importada'})
    },
    validateStep1() {
      return new Promise((resolve, reject) => {
        this.$validator.validateAll('step-1').then(result => {
          if (result) {
            resolve(true)
          } else {
            reject("correct all values");
          }
        })
      })
    },
    validateStep2() {
      return new Promise((resolve, reject) => {
        this.$validator.validateAll("step-2").then(result => {
          if (result) {
            resolve(true)
          } else {
            reject("correct all values");
          }
        })
      })
    },
    validateStep3() {
      return new Promise((resolve, reject) => {
        this.$validator.validateAll('step-3').then(result => {
          if (result) {
			console.log(this.getDate(this.fecha_nacimiento));
			this.acceptAlert();
			// alert('Form submitted!');
			this.$router.push('/tutoria/tutor');
            resolve(true)
          } else {
            reject('correct all values');
          }
        })
	  })
	//   this.$vs.notify({
    //       color:'success',
    //       title:`${titulo}`,
    //       text:'La acción se realizo exitósamente'
    //     });
    }
  },
  components: {
    FormWizard,
	TabContent,
	Datepicker,
	vSelect,
  },	
	mounted(){
    this.importarRoles();
  },
}
</script>