<template>
  <vx-card title="Actualización de padrino" code-toggler>

    <div class="mt-5">
      <form-wizard color="rgba(var(--vs-primary), 1)" errorColor="rgba(var(--vs-danger), 1)" :title="null" :subtitle="null" finishButtonText="Enviar" back-button-text="Atrás" next-button-text="Siguiente" @on-complete="formSubmitted">
       <tab-content title="Step 1" class="mb-5" icon="feather icon-home" :before-change="validateStep1">

          <!-- tab 1 content -->
          <form data-vv-scope="step-1">
          <div class="vx-row">
            <div class="vx-col md:w-1/2 w-full mt-5">
              <vs-input label="Nombres" v-model="nombresT" class="w-full" name="first_name" v-validate="'required|alpha'" />
              <span class="text-danger">{{ errors.first('step-1.first_name') }}</span>
            </div>

            <div class="vx-col md:w-1/2 w-full mt-5">
              <vs-input label="Apellidos"  v-model="apellidosT" class="w-full" name="last_name" v-validate="'required|alpha'" />
              <span class="text-danger">{{ errors.first('step-1.last_name') }}</span>
            </div>

			<div class="vx-col md:w-1/2 w-full mt-5">
              <vs-input label="CUI"  v-model="CUIT" class="w-full" name="cui" v-validate="'required'" />
              <span class="text-danger">{{ errors.first('step-1.campo') }}</span>
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
              <vs-input label="Dirección"  v-model="direccionT" class="w-full" name="campo" v-validate="'required'" />
              <span class="text-danger">{{ errors.first('step-1.campo') }}</span>
            </div>

			<div class="vx-col md:w-1/2 w-full mt-5">
              <vs-input label="Numero de telefono"  v-model="numero_telefonoT" class="w-full" name="campo" v-validate="'required'" />
              <span class="text-danger">{{ errors.first('step-1.campo') }}</span>
            </div>

            <div class="vx-col md:w-1/2 w-full mt-5">
				<small class="date-label">Sector</small>
				<v-select label="nombre" :options="sectoresT" v-model="sector_idT" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
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
              <vs-input type="email" label="Ruta de imagen"  v-model="ruta_imagenT" class="w-full" name="ruta_imagen" />
              <span class="text-danger">{{ errors.first('step-2.ruta_imagen') }}</span>
            </div>
		      	<div class="vx-col md:w-1/2 w-full mt-5">
              <vs-input type="email" label="Correo"  v-model="correoT" class="w-full" name="correo" v-validate="'required|email'" />
              <span class="text-danger">{{ errors.first('step-2.correo') }}</span>
            </div>

          </div>
          </form>
        </tab-content>
      </form-wizard>
    </div>
    <div class="vx-col md:w-1/2 w-full mt-5">
  <router-link to="/apadrinamiento/padrino"><vs-button class="w-full" icon-pack="feather" icon="icon-corner-up-left" icon-no-border>Regresar</vs-button></router-link>
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
    // props:{
	// 	identificador:{
	// 		default:false
	// 	},
	//     id:{default: 0},
    //     nombres:String,
    //     apellidos:String,
    //     direccion:String,
    //     genero:Boolean,
    //     fecha_nacimiento:Date,
    //     CUI:String,
    //     numero_telefono:String,
    //     correo:String,
    //     ruta_imagen:String,
	//     sector_id:{default: 0},
	// },
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
      ruta_imagenT:'',
      sectoresT: [],
      arrayData: [],
	  sector_idT:'',
	  langEn: es,
    }
  },
  computed: {
    //   copia() {
    //     this.nombresT =this.$props.nombres;
    //     this.apellidosT =this.$props.apellidos;
    //     this.direccionT =this.$props.direccion;
    //     this.idT =this.$props.id;
    //     this.generoT =this.$props.genero;
    //     this.fecha_nacimientoT =this.$props.fecha_nacimiento;
    //     this.CUIT =this.$props.CUI;
    //     this.numero_telefonoT =this.$props.numero_telefono;
    //     this.correoT =this.$props.correo;
    //     this.ruta_imagenT =this.$props.ruta_imagen;
	// 	this.sector_idT =this.$props.sector_id;
	// 	return true;	
	// }
  },
  methods: {
    async index(page, search){ //async para que se llame cada vez que se necesite
        let me = this;
        let id_recibido = this.$route.params.id;
        console.log("criterio   "+id_recibido);
		const response = await axios.get(
			`/api/padrino/get?&criterio=id&buscar=${id_recibido}&completo=true`)
		.then(function (response) {
			console.log(page)
			var respuesta= response.data;
            me.arrayData = respuesta.padrinos.data[0];
            me.nombresT = me.arrayData.datos.nombres;
            me.apellidosT = me.arrayData.datos.apellidos;
            // me.nombresT = me.arrayData.datos.nombres;
            // me.nombresT = me.arrayData.datos.nombres;
            // me.nombresT = me.arrayData.datos.nombres;
            // me.nombresT = me.arrayData.datos.nombres;
            // me.nombresT = me.arrayData.datos.nombres;
            // me.nombresT = me.arrayData.datos.nombres;
            // me.nombresT = me.arrayData.datos.nombres;
            // me.nombresT = me.arrayData.datos.nombres;
            console.log(me. nombresT);
            console.log(me.arrayData);
			me.pagination= respuesta.pagination;
		})
		.catch(function (error) {
			console.log(error);
		});
    },
    async importarSectores(){ //async para que se llame cada vez que se necesite
		let me = this;
		const response = await axios.get(
			`/api/sector/get?completo=select`)
		.then(function (response) {
			var respuesta= response.data;
            me.sectoresT = respuesta.sectores.data;
            console.log(me.sectoresT);
			me.pagination= respuesta.pagination;
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
      // alert('Form submitted!');
      axios.put("/api/padrino/update/",{
		    nombres:this.nombresT,
            apellidos:this.apellidosT,
            CUI:this.CUIT,
            numero_telefono:this.numero_telefonoT,
            correo:this.correoT,
            ruta_imagen:this.ruta_imagenT,
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
        // this.$vs.notify({
        //   color:'success',
        //   title:`${titulo}`,
        //   text:'La acción se realizo exitósamente'
        // });
        // this.$router.push('/apadrinamiento/padrino');
    },
    successUpload(){
      this.$vs.notify({color:'success',title:'Fotografía',text:'Fotografía importada'})
    },
    getIDfromURL(){
    return window.location.pathname.split('/')[2];
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
    this.index(1, this.search);
    this.importarSectores();
  },
  
}
</script>
