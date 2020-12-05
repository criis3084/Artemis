<template>
  <vx-card>
      <div class="vx-col md:w-1/3 w-full mt-5">
        <router-link to="/vivienda/vivienda"><vs-button type="border" radius class="w-full" icon-pack="feather" icon="icon-corner-up-left" icon-no-border></vs-button></router-link>
      </div>
    <div class="mt-5">
      <form-wizard color="rgba(var(--vs-primary), 1)" errorColor="rgba(var(--vs-danger), 1)" title="INGRESO DE CONSTRUCCIÓN DE VIVIENDA" :subtitle="null" finishButtonText="Enviar" back-button-text="Atrás" next-button-text="Siguiente" @on-complete="formSubmitted">
				<vs-divider position="right">PID&#174;</vs-divider>
        
        <tab-content title="Registro" class="mb-5" icon="feather icon-home" :before-change="validateStep1">

          <!-- tab 1 content -->
          <form data-vv-scope="step-1">
          <div class="vx-row">

              <div class="vx-col md:w-1/2 w-full mt-5">
				<small class="date-label">Destinatario</small>
				<v-select name="encargado" v-validate="'required'" label="encargado_nombreCompleto" :options="encargados" v-model="encargado_id" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
        <span class="text-danger">{{ errors.first('step-1.encargado') }}</span>
			</div>
            <div class="vx-col md:w-1/2 w-full mt-5">
				<small class="date-label">Constructor</small>
				<v-select name="constructor" v-validate="'required'" label="constructor_nombreCompleto" :options="constructors" v-model="constructor_id" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
        <span class="text-danger">{{ errors.first('step-1.constructor') }}</span>
			</div>
            <div class="vx-col md:w-1/2 w-full mt-5">
				<small class="date-label">Tipo de vivienda</small>
				<v-select name="tipo" v-validate="'required'" label="nombre" :options="tipoViviendas" v-model="tipo_vivienda_id" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
        <span class="text-danger">{{ errors.first('step-1.tipo') }}</span>
			</div>

            <div class="vx-col md:w-1/2 w-full mt-5">
              <vs-input name="direccion" v-validate="'required|max:254'" label="dirección" v-model="direccion" class="w-full" icon-pack="feather" icon="icon-map-pin"/>
              <span class="text-danger">{{ errors.first('step-1.direccion') }}</span>
            </div>

            <div class="vx-col md:w-1/2 w-full mt-5">
			  <small class="date-label">Fecha de inicio</small>
			  <datepicker name="fecha" v-validate="'required'" :language="$vs.rtl ? langEn : langEn"  v-model="fecha_inicio"></datepicker>
        <span class="text-danger">{{ errors.first('step-1.fecha') }}</span>
			</div>

            <div class="vx-col md:w-1/2 w-full mt-5">
              <vs-input-number name="meses" v-validate="'required|numeric|max:2'" label="Meses de duración del pago:"  v-model="duracion" icon-inc="expand_less" icon-dec="expand_more" class="w-full"/>
              <span class="text-danger">{{ errors.first('step-1.meses') }}</span>
            </div>

			  <div class="vx-col md:w-1/2 w-full mt-5">
        <small class="date-label">Costo total</small>
          <vx-input-group class="mb-base">
   				<template slot="prepend">	
            <div class="prepend-text bg-primary" >
            <span>Q</span>	
            </div>
			      <div class="vx-col w-full">
              <vs-input  v-model="costo_total" class="w-full" name="costo" v-validate="'required|numeric|max:6'" />
              <span class="text-danger">{{ errors.first('step-1.costo') }}</span>
              
            </div>
          </template>
  				</vx-input-group>
          <div class="vx-col md:w-1/2 w-full mt-5">
					<template>
						<vs-upload automatic action="/api/vivienda/imagen" limit='1' :headers="head" fileName='photos' @on-success="respuesta" @on-delete="vaciar" text="Imagen de vivienda"/>
					</template>
			</div>
			  </div>
            <div class="vx-col md:w-1/2 w-full mt-5">
			  <small class="date-label">Nombre del donador de vivienda</small>
			  <vs-input class="w-full" name="donante" v-validate="'required'"  v-model="donante"></vs-input>
        <span class="text-danger">{{ errors.first('step-1.donante') }}</span>
			</div>

          </div>
          </form>
        </tab-content>
      </form-wizard>
    </div>
    <div class="vx-col md:w-1/3 w-full mt-5">
  <router-link to="/vivienda/vivienda"><vs-button type="gradient" class="w-full" icon-pack="feather" icon="icon-corner-up-left" icon-no-border>Regresar</vs-button></router-link>
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
    encargado: {
      required: 'El campo destinatario es requerido',
    },
    constructor: {
      required: 'El campo constructor es requerido',
    },
    tipo: {
      required: 'El campo tipo de vivienda es requerido',
    },
    direccion: {
	  required: 'El campo dirección es requerido',
	  max: 'Este campo solo acepta hasta 254 caracteres',
    },
    fecha: {
      required: 'El campo fecha de inicio es requerido',
    },
    meses: {
	  required: 'El campo meses de duración es requerido',
	  max: 'Este campo solo acepta hasta 2 dígitos',
    },
    costo: {
      required: 'El campo costo total es requerido',
      max: 'Este campo solo acepta hasta 6 dígitos',
      numeric: 'El campo solo debe de contener números',
    },
    donante: {
	  required: 'Porfavor ingrese el nombre del donante',
	  max: 'Este campo solo acepta hasta 2 dígitos'
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
      fecha_inicio:"",
      imagen_final:'',
      costo_total:'',
      encargados: [],
        encargado_id:'',
     constructors: [],
       constructor_id:'',
      tipoViviendas: [],
      donante:'',
        tipo_vivienda_id:'',
        encargado_nombres:'',
        encargado_apellidos:'',
        constructor_nombres:'',
        constructor_apellidos:'',
    langEn: es,
    head:{
			"imagenanterior":""	
		}
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
  vaciar(){
		this.imagen_final='';
	},
  respuesta(e){
	this.imagen_final=e.currentTarget.response.replace(/['"]+/g, '')
		this.head.imagenanterior=this.imagen_final
		this.$vs.notify({
					color:'success',
					title:'Imagen subida',
					text:'Acción realizada exitósamente!'
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
  this.$validator.validateAll().then(result => {
  if(result) {
      // alert('Form submitted!');
      console.log(this.tipo_vivienda_id);
      console.log(this.tipo_vivienda_id.id);
      console.log(this.duracion);
      const me = this
      axios.post("/api/vivienda/post/",{
		direccion:this.direccion,
        duracion:this.duracion,
        imagen_final: '/storage/public/viviendas/' + this.imagen_final,
        costo_total:this.costo_total,
		fecha_inicio:this.getDate(this.fecha_inicio),
        encargado_id:this.encargado_id.id,
        constructor_id:this.constructor_id.id,
        tipo_vivienda_id:this.tipo_vivienda_id.id,
        donante:this.donante
	}).then(function(response) {
      console.log(response)
       me.$vs.notify({
					color:'success',
					title:'Vivienda registrada',
					text:'Acción realizada exitósamente'
				});
        me.$router.push('/vivienda/vivienda');
		})
		.catch(function(error) {
    console.log(error)
    me.$vs.notify({
			color:'danger',
			title:'Error!',
			text:'Error al registrar los datos'
			});
        });
        this.$emit('cerrado','Se cerró el formulario');
       
  }
  else{
        this.$vs.notify({
			color:'danger',
			title:'Error en validación!',
			text:'Ingrese todos los campos correctamente'
			});
      }
    })
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
