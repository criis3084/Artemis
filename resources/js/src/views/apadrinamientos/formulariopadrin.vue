<template>
  <vx-card title="Ingreso de padrinos" code-toggler>

    <div class="mt-5">
      <form-wizard color="rgba(var(--vs-primary), 1)" errorColor="rgba(var(--vs-danger), 1)" :title="null" :subtitle="null" finishButtonText="Enviar" back-button-text="Atrás" next-button-text="Siguiente" @on-complete="formSubmitted">
        <tab-content title="Step 1" class="mb-5" icon="feather icon-home" :before-change="validateStep1">

          <!-- tab 1 content -->
          <form data-vv-scope="step-1">
          <div class="vx-row">
            <div class="vx-col md:w-1/2 w-full mt-5">
              <vs-input label="Nombres" v-model="nombres" class="w-full" name="first_name" v-validate="'required|alpha'" />
              <span class="text-danger">{{ errors.first('step-1.first_name') }}</span>
            </div>

            <div class="vx-col md:w-1/2 w-full mt-5">
              <vs-input label="Apellidos"  v-model="apellidos" class="w-full" name="last_name" v-validate="'required|alpha'" />
              <span class="text-danger">{{ errors.first('step-1.last_name') }}</span>
            </div>

			<div class="vx-col md:w-1/2 w-full mt-5">
              <vs-input label="CUI"  v-model="CUI" class="w-full" name="cui" v-validate="'required'" />
              <span class="text-danger">{{ errors.first('step-1.campo') }}</span>
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
			  <small class="date-label">Fecha de nacimiento</small>
			  <datepicker :language="$vs.rtl ? langEn : langEn"  v-model="fecha_nacimiento"></datepicker>
			</div>
	        
			<div class="vx-col md:w-1/2 w-full mt-5">
              <vs-input label="Dirección"  v-model="direccion" class="w-full" name="campo" v-validate="'required'" />
              <span class="text-danger">{{ errors.first('step-1.campo') }}</span>
            </div>

			<div class="vx-col md:w-1/2 w-full mt-5">
              <vs-input label="Numero de telefono"  v-model="numero_telefono" class="w-full" name="campo" v-validate="'required'" />
              <span class="text-danger">{{ errors.first('step-1.campo') }}</span>
            </div>

            <div class="vx-col md:w-1/2 w-full mt-5">
              <vs-select v-model="city" class="w-full select-large" label="City">
                <vs-select-item :key="index" :value="item.value" :text="item.text" v-for="(item,index) in cityOptions" class="w-full" />
              </vs-select>
            </div>

          </div>
          </form>
        </tab-content>

        <!-- tab 2 content -->
        <tab-content title="Step 2" class="mb-5" icon="feather icon-briefcase" :before-change="validateStep2">
          <form data-vv-scope="step-2">
          <div class="vx-row">

            <div class="vx-col md:w-1/2 w-full">
                <template>
					<vs-upload action="https://jsonplaceholder.typicode.com/posts/" limit="1" text="Subir fotografia" @on-success="successUpload" />
				</template>
            </div>

			<div class="vx-col md:w-1/2 w-full mt-5">
              <vs-input type="email" label="Correo"  v-model="correo" class="w-full" name="correo" v-validate="'required|email'" />
              <span class="text-danger">{{ errors.first('step-2.correo') }}</span>
            </div>

          </div>
          </form>
        </tab-content>

      </form-wizard>
    </div>
  </vx-card>
</template>

<script>
import { FormWizard, TabContent } from 'vue-form-wizard'
import 'vue-form-wizard/dist/vue-form-wizard.min.css'
import Datepicker from 'vuejs-datepicker'
import { es } from 'vuejs-datepicker/src/locale'
// For custom error message
import { Validator } from 'vee-validate'
const dict = {
  custom: {
    first_name: {
      required: 'Los nombres son requeridos',
      alpha: 'Solo se permiten letras'
    },
    last_name: {
      required: 'Los apellidos son requeridos',
      alpha: 'Solo se permiten letras'
    },
    correo: {
      required: 'El correo es requerido',
      email: 'Por favo ingrese un correo valido'
    },
    campo: {
      required: 'Información requerida'
    }
  }
}

// register custom messages
Validator.localize('en', dict)

export default {
  data () {
    return {
      nombres: '',
      apellidos: '',
	  correo: '',
	  CUI:'',
	  genero:'',
	  fecha_nacimiento:'',
      city: 'new-york',
	  langEn: es,
	  direccion:'',
	  numero_telefono:'',
	  ruta_imagen:'',
	  correo:'',
      
      cityOptions: [
        { text: 'New York', value: 'new-york' },
        { text: 'Chicago', value: 'chicago' },
        { text: 'San Francisco', value: 'san-francisco' },
        { text: 'Boston', value: 'boston' }
      ],
      statusOptions: [
        { text: 'Plannning', value: 'plannning' },
        { text: 'In Progress', value: 'in progress' },
        { text: 'Finished', value: 'finished' }
      ],
      LocationOptions: [
        { text: 'New York', value: 'new-york' },
        { text: 'Chicago', value: 'chicago' },
        { text: 'San Francisco', value: 'san-francisco' },
        { text: 'Boston', value: 'boston' }
      ]
    }
  },
  methods: {
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

    formSubmitted () {
      axios.post('/api/escuela/post', {
		nombres: this.nombres,
		apellidos: this.apellidos,
		CUI: this.CUI,
		genero: this.genero,
		fecha_nacimiento: this.fecha_nacimiento,
		direccion: this.direccion,
		numero_telefono: this.numero_telefono,

	})
	.then(function(response) {
		toastr.success(response.data.message, "Listo");
		l.stop();
		me.closeModal();
	})
	.catch(function(error) {
		l.stop();
		toastr.error(error.response.data.message, "Error");
	});
       this.$vs.notify({color:'success', title:'Registro', text:'Registro con exito'})
    },
    successUpload () {
      this.$vs.notify({color:'success', title:'Upload Success', text:'Lorem ipsum dolor sit amet, consectetur'})
    },
  },
  components: {
    FormWizard,
    TabContent,
    Datepicker
  }
}
</script>
