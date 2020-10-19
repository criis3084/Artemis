<template>
  <vx-card title="Ingreso de construcción de vivienda" code-toggler>

    <div class="mt-5">
      <form-wizard color="rgba(var(--vs-primary), 1)" errorColor="rgba(var(--vs-danger), 1)" :title="null" :subtitle="null" finishButtonText="Enviar" back-button-text="Atrás" next-button-text="Siguiente" @on-complete="formSubmitted">
        <tab-content title="Registro" class="mb-5" icon="feather icon-home" :before-change="validateStep1">

          <!-- tab 1 content -->
          <form data-vv-scope="step-1">
          <div class="vx-row">

              <div class="vx-col md:w-1/2 w-full mt-5">
				<small class="date-label">Destinatario</small>
				<v-select label="encargado_nombreCompleto" :options="encargados" v-model="encargado_id" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
        <span class="text-danger">{{ errors.first('step-1.last_name') }}</span>
			</div>
            <div class="vx-col md:w-1/2 w-full mt-5">
				<small class="date-label">Constructor</small>
				<v-select label="constructor_nombreCompleto" :options="constructors" v-model="constructor_id" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
        <span class="text-danger">{{ errors.first('step-1.last_name') }}</span>
			</div>
            <div class="vx-col md:w-1/2 w-full mt-5">
				<small class="date-label">Tipo de vivienda</small>
				<v-select label="nombre" :options="tipoViviendas" v-model="tipo_vivienda_id" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
        <span class="text-danger">{{ errors.first('step-1.last_name') }}</span>
			</div>

            <div class="vx-col md:w-1/2 w-full mt-5">
              <vs-input label="dirección" v-model="direccion" class="w-full" icon-pack="feather" icon="icon-map-pin" name="first_name" v-validate="'required'" />
              <span class="text-danger">{{ errors.first('step-1.first_name') }}</span>
            </div>

            <div class="vx-col md:w-1/2 w-full mt-5">
			  <small class="date-label">Fecha de inicio</small>
			  <datepicker :language="$vs.rtl ? langEn : langEn"  v-model="fecha_inicio"></datepicker>
        <span class="text-danger">{{ errors.first('step-1.last_name') }}</span>
			</div>

            <div class="vx-col md:w-1/2 w-full mt-5">
              <vs-input-number label="Meses de duración del pago:"  v-model="duracion" icon-inc="expand_less" icon-dec="expand_more" class="w-full" name="last_name" v-validate="'required'" />
              <span class="text-danger">{{ errors.first('step-1.last_name') }}</span>
            </div>

			  <div class="vx-col md:w-1/2 w-full mt-5">
        <small class="date-label">Costo total</small>
          <vx-input-group class="mb-base">
   				<template slot="prepend">	
            <div class="prepend-text bg-primary" >
            <span>Q</span>	
            </div>
			      <div class="vx-col w-full">
              <vs-input  v-model="costo_total" class="w-full" name="correo" v-validate="'required'" />
              <span class="text-danger">{{ errors.first('step-1.last_name') }}</span>
            </div>
          </template>
  				</vx-input-group>
			  </div>
      

          </div>
          </form>
        </tab-content>
      </form-wizard>
    </div>
    <div class="vx-col md:w-1/2 w-full mt-5">
  <router-link to="/vivienda/vivienda"><vs-button class="w-full" icon-pack="feather" icon="icon-corner-up-left" icon-no-border>Regresar</vs-button></router-link>
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
    first_name: {
      required: 'Este campo es requerido',
      alpha: 'Solo se permiten letras'
    },
    last_name: {
      required: 'Este campo es requerido',
      alpha: 'Solo se permiten letras'
    },
    correo: {
      required: 'Este campo es requerido',
    },
    campo: {
      required: 'Este campo es requerido'
    }
  }
}

// register custom messages
Validator.localize('en', dict)

export default {
  data () {
    return {
      duracion: "",
      direccion: "",
      fecha_inicio:this.getDate(this.fecha_inicio),
      imagen_final:'',
      costo_total:'',
      encargados: [],
        encargado_id:'',
     constructors: [],
       constructor_id:'',
      tipoViviendas: [],
        tipo_vivienda_id:'',
        encargado_nombres:'',
        encargado_apellidos:'',
        constructor_nombres:'',
        constructor_apellidos:'',
	  langEn: es,
    }
  },
  methods: {
      traerDatosEncargados(tabla){

			tabla.forEach(function(valor, indice, array){
				valor.encargado_nombres=valor.datos.nombres
        valor.encargado_apellidos=valor.datos.apellidos
        valor.encargado_nombreCompleto= valor.encargado_nombres + " " + valor.encargado_apellidos
            }); 

			return tabla
        },
    traerDatosConstructor(tabla){
        console.log(tabla);
			tabla.forEach(function(valor, indice, array){
				valor.constructor_nombres=valor.datos.nombres
        valor.constructor_apellidos=valor.datos.apellidos
        valor.constructor_nombreCompleto = valor.constructor_nombres + " " + valor.constructor_apellidos
            });
            console.log(tabla); 
			return tabla
	},
    getDate(datetime) {
        let date = new Date(datetime);
        let dateString = `${date.getFullYear()}/${date.getMonth() + 1}/${date.getDate()}`;
        return dateString;
      },
	async importarTipo(){ //async para que se llame cada vez que se necesite
		let me = this;
		const response = await axios.get(
			`/api/tipoVivienda/get?completo=false`)
		.then(function (response) {
			var respuesta= response.data;
            me.tipoViviendas = respuesta.tipoViviendas.data;
            console.log(me.tipoViviendas);
			me.pagination= respuesta.pagination;
		})
		.catch(function (error) {
			console.log(error);
		});
    },
    async importarConstructor(){ //async para que se llame cada vez que se necesite
		const me = this
		const response = await axios.get(
		`/api/constructor/get?completo=true`)
		.then(function (response) {
			const respuesta = response.data
			me.arrayData = respuesta.constructors.data
            me.constructors = me.traerDatosConstructor(me.arrayData)
		})
		.catch(function (error) {
			console.log(error)
		})
    },
    async importarEncargados(){ //async para que se llame cada vez que se necesite
		const me = this
		const response = await axios.get(
		`/api/encargado/get?completo=true`)
		.then(function (response) {
			const respuesta = response.data
			me.arrayData = respuesta.encargados.data
            me.encargados = me.traerDatosEncargados(me.arrayData)
		})
		.catch(function (error) {
			console.log(error)
		})
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
    formSubmitted () {
      // alert('Form submitted!');
      console.log(this.tipo_vivienda_id);
      console.log(this.tipo_vivienda_id.id);
      console.log(this.duracion);
      axios.post("/api/vivienda/post/",{
		direccion:this.direccion,
        duracion:this.duracion,
        imagen_final:this.imagen_final,
        costo_total:this.costo_total,
		fecha_inicio:this.getDate(this.fecha_inicio),
        encargado_id:this.encargado_id.id,
        constructor_id:this.constructor_id.id,
        tipo_vivienda_id:this.tipo_vivienda_id.id
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
        this.$router.push('/vivienda/vivienda');
    },
  },
  components: {
    FormWizard,
	  TabContent,
  	Datepicker,
	  vSelect,
  },
	mounted(){
    this.importarEncargados();
    this.importarConstructor();
    this.importarTipo();
  },
}
</script>
