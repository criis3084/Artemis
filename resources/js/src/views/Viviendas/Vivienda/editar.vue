<template>
  <vx-card title="Actualización de constructor" code-toggler>

    <div class="mt-5">
      <form-wizard color="rgba(var(--vs-primary), 1)" errorColor="rgba(var(--vs-danger), 1)" :title="null" :subtitle="null" finishButtonText="Enviar" back-button-text="Atrás" next-button-text="Siguiente" @on-complete="formSubmitted">
      <tab-content title="Registro" class="mb-5" icon="feather icon-home" :before-change="validateStep1">

          <!-- tab 1 content -->
          <form data-vv-scope="step-1">
          <div class="vx-row">

              <div class="vx-col md:w-1/2 w-full mt-5">
				<small class="date-label">Destinatario</small>
				<v-select label="encargado_nombres" :options="encargadosT" v-model="encargado_idT" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
			</div>
            <div class="vx-col md:w-1/2 w-full mt-5">
				<small class="date-label">Constructor</small>
				<v-select label="constructor_nombres" :options="constructorsT" v-model="constructor_idT" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
			</div>
            <div class="vx-col md:w-1/2 w-full mt-5">
				<small class="date-label">Tipo de vivienda</small>
				<v-select label="nombre" :options="tipoViviendasT" v-model="tipo_vivienda_idT" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
			</div>

            <div class="vx-col md:w-1/2 w-full mt-5">
              <vs-input label="dirección" v-model="direccionT" class="w-full" icon-pack="feather" icon="icon-map-pin" name="first_name" v-validate="'required'" />
              <span class="text-danger">{{ errors.first('step-1.first_name') }}</span>
            </div>

            <div class="vx-col md:w-1/2 w-full mt-5">
			  <small class="date-label">Fecha de inicio</small>
			  <datepicker :language="$vs.rtl ? langEn : langEn"  v-model="fecha_inicioT"></datepicker>
			</div>

            <div class="vx-col md:w-1/2 w-full mt-5">
              <vs-input-number label="Meses de duración del pago"  v-model="duracionT" class="w-full" icon-pack="feather" icon="icon-calendar" name="last_name" v-validate="'required'" />
              <span class="text-danger">{{ errors.first('step-1.last_name') }}</span>
            </div>

			<div class="vx-col md:w-1/2 w-full mt-5">
              <vs-input label="Costo total"  v-model="costo_totalT" class="w-full" icon-pack="feather" icon="icon-dollar-sign" name="correo" v-validate="'required'" />
              <span class="text-danger">{{ errors.first('step-1.last_name') }}</span>
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

  data () {
    return {
            duracionT: "",
      direccionT: "",
      fecha_inicioT:this.getDate(this.fecha_inicio),
      imagen_finalT:'',
      costo_totalT:'',
      encargadosT: [],
        encargado_idT:'',
     constructorsT: [],
       constructor_idT:'',
      tipoViviendasT: [],
        tipo_vivienda_idT:'',
        encargado_nombres:'',
        encargado_apellidos:'',
        constructor_nombres:'',
        constructor_apellidos:'',
    langEn: es,
    id_recibido:'',
    titulo:'Actualización registrada',
    }
  },
  computed: {
  },
  methods: {
    async index(page, search){ //async para que se llame cada vez que se necesite
        let me = this;
        this.id_recibido = this.$route.params.id;
        console.log("criterio   "+this.id_recibido);
		const response = await axios.get(
			`/api/vivienda/get?&criterio=id&buscar=${this.id_recibido}&completo=true`)
		.then(function (response) {
			console.log(page)
			var respuesta= response.data;
              me.arrayData = respuesta.viviendas.data[0];
              me.duracionT = me.arrayData.duracion;
              me.imagen_finalT = me.arrayData.imagen_final;
              me.direccionT = me.arrayData.direccion;
              me.costo_totalT = me.arrayData.costo_total;
              me.fecha_inicioT = me.arrayData.fecha_inicio;
              me.encargado_idT = me.arrayData.encargado_id;
              me.constructor_idT = me.arrayData.constructor_id;
              me.tipo_vivienda_idT = me.arrayData.tipo_vivienda_id;
            console.log(me.arrayData);
			me.pagination= respuesta.pagination;
		})
		.catch(function (error) {
			console.log(error);
		});
    },
    traerDatosEncargados(tabla){

			tabla.forEach(function(valor, indice, array){
				valor.encargado_nombres=valor.datos.nombres
				valor.encargado_apellidos=valor.datos.apellidos
            }); 

			return tabla
        },
    traerDatosConstructor(tabla){
        console.log(tabla);
			tabla.forEach(function(valor, indice, array){
				valor.constructor_nombres=valor.datos.nombres
				valor.constructor_apellidos=valor.datos.apellidos
            });
            console.log(tabla); 
			return tabla
	},
    async importarTipo(){ //async para que se llame cada vez que se necesite
		let me = this;
		const response = await axios.get(
			`/api/tipoVivienda/get?completo=select`)
		.then(function (response) {
			var respuesta= response.data;
            me.tipoViviendasT = respuesta.tipoViviendas.data;
            console.log(me.tipoViviendasT);
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
            me.constructorsT = me.traerDatosConstructor(me.arrayData)
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
            me.encargadosT = me.traerDatosEncargados(me.arrayData)
		})
		.catch(function (error) {
			console.log(error)
		})
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

    formSubmitted () {
      // alert('Form submitted!');
      axios.put("/api/vivienda/update/",{
        id:this.id_recibido,
		    costo_total:this.costo_totalT,
            duracion:this.duracionT,
            imagen_final:this.imagen_finalT,
		    fecha_inicio:this.getDate(this.fecha_inicioT),
		    direccion:this.direccionT,
        encargado_id:this.encargado_idT.id,
        constructor_id:this.constructor_idT.id,
        tipo_vivienda_id:this.tipo_vivienda_idT.id

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
    this.importarTipo();
    this.importarConstructor();
    this.importarEncargados();
    this.index(1, this.search);
  },
  
}
</script>
