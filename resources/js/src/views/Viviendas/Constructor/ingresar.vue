<template>
  <vx-card>
<div class="vx-col md:w-1/3 w-full mt-5">
  <router-link to="/vivienda/constructor"><vs-button type="border" radius class="w-full" icon-pack="feather" icon="icon-corner-up-left" icon-no-border></vs-button></router-link>
    </div>
    <div class="mt-5">
      <form-wizard color="rgba(var(--vs-primary), 1)" errorColor="rgba(var(--vs-danger), 1)" title="INGRESO DE CONSTRUCTOR" :subtitle="null" finishButtonText="Enviar" back-button-text="Atrás" next-button-text="Siguiente" @on-complete="formSubmitted">
				<vs-divider position="right">PID&#174;</vs-divider>
        
        <tab-content title="Registro" class="mb-5" icon="feather icon-user-plus" :before-change="validateStep1">

          <!-- tab 1 content -->
          <form data-vv-scope="step-1">
          <div class="vx-row">
            <div class="vx-col md:w-1/2 w-full mt-5">
              <vs-input label="Nombres" v-model="nombres" class="w-full" icon-pack="feather" icon="icon-user" name="nombres" v-validate="'required|alpha_spaces|max:30'" />
              <span class="text-danger">{{ errors.first('step-1.nombres') }}</span>
            </div>

            <div class="vx-col md:w-1/2 w-full mt-5">
              <vs-input label="Apellidos"  v-model="apellidos" class="w-full" icon-pack="feather" icon="icon-user"  name="apellidos" v-validate="'required|alpha_spaces|max:30'"/>
              <span class="text-danger">{{ errors.first('step-1.apellidos') }}</span>
            </div>

			<div class="vx-col md:w-1/2 w-full mt-5">
              <vs-input label="CUI"  v-model="CUI" class="w-full" icon-pack="feather" icon="icon-hash" name="cui" v-validate="'max:15|numeric'" />
              <span class="text-danger">{{ errors.first('step-1.cui') }}</span>
            </div>

            <div class="vx-col md:w-1/2 w-full mt-5">
				<small class="date-label">Género</small>
				<ul class="demo-alignment">
					<li>
					    <vs-radio name="radio" v-validate="'required|included:1,0'" color="rgb(0, 170, 228)" v-model="genero" vs-value="1" selected>Masculino</vs-radio>
					</li>
					<li>
						<vs-radio name="radio" color="rgb(255, 0, 128)" v-model="genero" vs-value="0">Femenino</vs-radio>
					</li>
				</ul>
					<span class="text-danger">{{ errors.first('step-1.radio') }}</span>

            </div>

			<div class="vx-col md:w-1/2 w-full mt-5">
			  <small class="date-label">Fecha de nacimiento</small>
			  <datepicker name="fecha" v-validate="'required'" :language="$vs.rtl ? langEn : langEn"  v-model="fecha_nacimiento"></datepicker>
					<span class="text-danger">{{ errors.first('step-1.fecha') }}</span>

    	</div>
	        
			<div class="vx-col md:w-1/2 w-full mt-5">
              <vs-input label="Dirección"  v-model="direccion" class="w-full" icon-pack="feather" icon="icon-map-pin" name="direccion" v-validate="'required|max:254'" />
              <span class="text-danger">{{ errors.first('step-1.direccion') }}</span>
            </div>

			<div class="vx-col md:w-1/2 w-full mt-5">
              <vs-input label="Número de teléfono"  v-model="numero_telefono" class="w-full" icon-pack="feather" icon="icon-phone" name="telefono" v-validate="'max:15|numeric'" />
              <span class="text-danger">{{ errors.first('step-1.telefono') }}</span>
            </div>

      <div class="vx-col md:w-1/2 w-full mt-5">
				<small class="date-label">Sector</small>
				<v-select name="sector" v-validate="'required'" label="nombre" :options="sectores" v-model="sector_id" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
					<span class="text-danger">{{ errors.first('step-1.sector') }}</span>

			</div>

          </div>
          </form>
        </tab-content>
      </form-wizard>
    </div>
    <div class="vx-col md:w-1/3 w-full mt-5">
  <router-link to="/vivienda/constructor"><vs-button type="gradient" class="w-full" icon-pack="feather" icon="icon-corner-up-left" icon-no-border>Regresar</vs-button></router-link>
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
	  max: 'Este campo solo acepta hasta 50 caracteres',
    },
    cui: {
	  numeric: 'El campo solo debe de contener números',
	  max: 'Este campo solo acepta hasta 15 caracteres',
	},
	fecha: {
      required: 'El campo fecha de nacimiento es requerido',
	},
	direccion: {
	  required: 'El campo dirección es requerido',
	  max: 'Este campo solo acepta hasta 254 caracteres',
	},
	telefono: {
	  max: 'Este campo solo acepta hasta 15 caracteres',
	  numeric: 'El campo solo debe de contener números',
	},
	radio: {
	  required: 'Seleccione una opción',
	  included: 'Seleccione una opción',
    },
	sector:{
	  required: 'El campo sector es requerido',
	},
  }
}

// register custom messages
Validator.localize('en', dict)

export default {
  data () {
    return {
      nombres: "",
      apellidos: "",
      direccion: "",
      genero:'',
      fecha_nacimiento:"",
      CUI:'',
      numero_telefono:'',
      sectores: [],
	    sector_id:'',
	  langEn: es,
    }
  },
  methods: {
    getDate(datetime) {
        let date = new Date(datetime);
        let dateString = `${date.getFullYear()}/${date.getMonth() + 1}/${date.getDate()}`;
        return dateString;
      },
	async importarSectores(){ //async para que se llame cada vez que se necesite
		let me = this;
		const response = await axios.get(
			`/api/sector/get?completo=select`)
		.then(function (response) {
			var respuesta= response.data;
            me.sectores = respuesta.sectores.data;
            console.log(me.sectores);
			me.pagination= respuesta.pagination;
		})
		.catch(function (error) {
			console.log(error);
		});
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
    formSubmitted () {
      // alert('Form submitted!');
      axios.post("/api/constructor/post/",{
		nombres:this.nombres,
        apellidos:this.apellidos,
        CUI:this.CUI,
        numero_telefono:this.numero_telefono,
		genero:this.genero,
		fecha_nacimiento:this.getDate(this.fecha_nacimiento),
		direccion:this.direccion,
		sector_id:this.sector_id.id
	}).then(function(response) {
      console.log(response)
		})
		.catch(function(error) {
		console.log(error)
        });
        this.$emit('cerrado','Se cerró el formulario');
        this.$vs.notify({
          color:'success',
          title:'Constructor registrado',
          text:'La acción se realizo exitósamente'
        });
        this.$router.push('/vivienda/constructor');
    },
  },
  components: {
    FormWizard,
	  TabContent,
  	Datepicker,
	  vSelect,
  },
	mounted(){
    this.importarSectores();
  },
}
</script>
