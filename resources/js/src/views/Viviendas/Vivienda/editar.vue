<template>
  <vx-card>
    <div class="vx-col md:w-1/3 w-full mt-5">
        <vs-button @click="goBack" type="border" radius class="w-full" icon-pack="feather" icon="icon-corner-up-left" icon-no-border></vs-button>
    </div>
    <div class="mt-5">
      <form-wizard color="rgba(var(--vs-primary), 1)" errorColor="rgba(var(--vs-danger), 1)" title="ACTUALIZACIÓN DE VIVIENDA" :subtitle="null" finishButtonText="Enviar" back-button-text="Atrás" next-button-text="Siguiente" @on-complete="formSubmitted">
				<vs-divider position="right">PID&#174;</vs-divider>
        
      <tab-content title="Registro" class="mb-5" icon="feather icon-home" :before-change="validateStep1">

          <!-- tab 1 content -->
          <form data-vv-scope="step-1">
      <div class="vx-row">
        <div class="vx-col md:w-1/2 w-full mt-5">
          <small class="date-label">Destinatario</small>
          <v-select name="encargado" v-validate="'required'" label="conjuntoEncargado" :options="encargadosT" v-model="encargado_idT" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
          <span class="text-danger">{{ errors.first('step-1.encargado') }}</span>
      </div>
      <div class="vx-col md:w-1/2 w-full mt-5">
				<small class="date-label">Constructor</small>
				<v-select name="constructor" v-validate="'required'" label="conjuntoConstructor" :options="constructorsT" v-model="constructor_idT" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
        <span class="text-danger">{{ errors.first('step-1.constructor') }}</span>
    	</div>
      <div class="vx-col md:w-1/2 w-full mt-5">
				<small class="date-label">Tipo de vivienda</small>
				<v-select name="tipo" v-validate="'required'" label="nombre" :options="tipoViviendasT" v-model="tipo_vivienda_idT" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
        <span class="text-danger">{{ errors.first('step-1.tipo') }}</span>
      </div>

            <div class="vx-col md:w-1/2 w-full mt-5">
              <vs-input name="direccion" v-validate="'required|max:254'" label="dirección" v-model="direccionT" class="w-full" icon-pack="feather" icon="icon-map-pin" />
              <span class="text-danger">{{ errors.first('step-1.direccion') }}</span>
            </div>

      <div class="vx-col md:w-1/2 w-full mt-5">
			  <small class="date-label">Fecha de inicio</small>
			  <datepicker name="fecha" v-validate="'required'" :language="$vs.rtl ? langEn : langEn"  v-model="fecha_inicioT"></datepicker>
        <span class="text-danger">{{ errors.first('step-1.fecha') }}</span>
      </div>
            <div class="vx-col md:w-1/2 w-full mt-5">
            <vs-input-number name="meses" v-validate="'required|numeric|max:2'" label="Meses de duración del pago:"  v-model="duracionT" icon-inc="expand_less" icon-dec="expand_more" class="w-full"/>
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
              <vs-input name="costo" v-validate="'required|numeric|max:6'" v-model="costo_totalT" class="w-full"/>
              <span class="text-danger">{{ errors.first('step-1.costo') }}</span>
            </div>
        </template>
        </vx-input-group>
        <div class="vx-col md:w-1/2 w-full mt-5">
										<img :src="imagen_perfil_antigua"  width="100" height="100" class="responsive">
										<vx-tooltip text="Editar Imagen"> <vs-button class="mr-4" type="border" icon-pack="feather" color="#1551b1" icon="icon-edit" radius  @click="editarImagen"></vs-button> </vx-tooltip>
										<vs-upload v-if="mostrarEditar" automatic action="/api/vivienda/imagen" limit="1" :headers="head" fileName="photos" @on-success="respuesta" @on-delete="vaciar" text="Imagen de perfil"/>
								</div>
      </div>
          </div>
          </form>
        </tab-content>
      </form-wizard>
    </div>
    <div class="vx-col md:w-1/3 w-full mt-5">
 <vs-button @click="goBack" type="gradient" class="w-full" icon-pack="feather" icon="icon-corner-up-left" icon-no-border>Regresar</vs-button>
    </div>

  </vx-card>
</template>

<script>
import { FormWizard, TabContent } from 'vue-form-wizard'
import 'vue-form-wizard/dist/vue-form-wizard.min.css'
import vSelect from 'vue-select'
import Datepicker from 'vuejs-datepicker'
import axios from 'axios'
import { es } from 'vuejs-datepicker/src/locale'
import VueRouter from 'vue-router'

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
        imagen_perfil_antigua:'',
        encargado_apellidos:'',
        conjuntoEncargado:'',
        constructor_nombres:'',
        constructor_apellidos:'',
    langEn: es,
    id_recibido:'',
    titulo:'Actualización registrada',
    head:{
        'imagenanterior':''	
      },
      mostrarEditar:false
    }
  },
  computed: {
  },
  methods: {
    goBack(){
      this.$router.go(-1)
    },
    editarImagen () {
      this.mostrarEditar = true
    },
    vaciar () {
      this.imagen_finalT = ''
    },
    respuesta (e) {
      this.imagen_finalT = e.currentTarget.response.replace(/['"]+/g, '')
      this.head.imagenanterior = this.imagen_finalT
    },
    async index(){ //async para que se llame cada vez que se necesite
        let me = this;
        this.id_recibido = this.$route.params.id;
		const response = await axios.get(
			`/api/vivienda/get?&criterio=id&buscar=${this.id_recibido}&completo=true`)
		.then(function (response) {
			var respuesta= response.data;
              me.arrayData = respuesta.viviendas.data[0];
              me.duracionT = me.arrayData.duracion;
              me.imagen_perfil_antigua = me.arrayData.imagen_final;
              me.direccionT = me.arrayData.direccion;
              me.costo_totalT = me.arrayData.costo_total;
              me.fecha_inicioT = me.arrayData.fecha_inicio;
              me.encargado_idT = me.arrayData.encargado_id;
              me.constructor_idT = me.arrayData.constructor_id;
              me.tipo_vivienda_idT = me.arrayData.tipo_vivienda_id;
		})
		.catch(function (error) {
			console.log(error);
		});
    },
    traerDatosEncargados(tabla){
		tabla.forEach(function(valor, indice, array){
		valor.encargado_nombres=valor.datos.nombres
		valor.encargado_apellidos=valor.datos.apellidos
		valor.conjuntoEncargado=valor.encargado_nombres + ' '+ valor.encargado_apellidos
		}); 
		return tabla
	},
    traerDatosConstructor(tabla){
		tabla.forEach(function(valor, indice, array){
		valor.constructor_nombres=valor.datos.nombres
        valor.constructor_apellidos=valor.datos.apellidos
        valor.conjuntoConstructor=valor.constructor_nombres + ' '+ valor.constructor_apellidos
		});
		return tabla
	},
    async importarTipo(){ //async para que se llame cada vez que se necesite
    let me = this;
    let encontrado=false;
		let elementoE={}
		const response = await axios.get(
			`/api/tipoVivienda/get?completo=true`)
		.then(function (response) {
			var respuesta= response.data;
            me.tipoViviendasT = respuesta.tipoViviendas.data;
            me.tipoViviendasT.forEach(function(elemento, indice, array) {
				if (elemento.id==me.tipo_vivienda_idT)
				{
					elementoE=elemento
					encontrado=true
				}
			})
			me.tipo_vivienda_idT = encontrado == true ? elementoE : {id:me.tipo_vivienda_idT,nombre:'tipo de vivienda desactivado'} 
		})
		.catch(function (error) {
			console.log(error);
		});
    },
    async importarConstructor(){ //async para que se llame cada vez que se necesite
    const me = this
    let encontrado=false;
		let elementoE={}
		const response = await axios.get(
		`/api/constructor/get?completo=true`)
		.then(function (response) {
			const respuesta = response.data
			me.arrayData = respuesta.constructors.data
			me.constructorsT = me.traerDatosConstructor(me.arrayData)
			me.constructorsT.forEach(function(elemento, indice, array) {
				if (elemento.id==me.constructor_idT)
				{
					elementoE=elemento
					encontrado=true
				}
			})
			me.constructor_idT = encontrado == true ? elementoE : {id:me.constructor_idT,nombre:'Constructor desactivado'} 
		})
		.catch(function (error) {
			console.log(error)
		})
    },
    async importarEncargados(){ //async para que se llame cada vez que se necesite
    const me = this
    let encontrado=false;
		let elementoE={}
		const response = await axios.get(
		`/api/encargado/get?completo=true`)
		.then(function (response) {
			const respuesta = response.data
			me.arrayData = respuesta.encargados.data
			me.encargadosT = me.traerDatosEncargados(me.arrayData)
			me.encargadosT.forEach(function(elemento, indice, array) {
				if (elemento.id==me.encargado_idT)
				{
					elementoE=elemento
					encontrado=true
				}
			})
			me.encargado_idT = encontrado == true ? elementoE : {id:me.encargado_idT,nombre:'Encargado desactivado'} 
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
       const me = this
      if (this.imagen_finalT === '') {
        this.imagen_finalT = this.imagen_perfil_antigua
      } else {
        this.imagen_finalT = `/storage/public/viviendas/${  this.imagen_finalT}`
      }
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
       me.$vs.notify({
			color:'success',
			title:'Actualización registrada!',
			text:'La acción se realizo exitósamente'
			});
        me.$router.push('/vivienda/vivienda');
		})
		.catch(function(error) {
    console.log(error)
    me.$vs.notify({
			color:'danger',
			title:'Error!',
			text:'Error al actualizar los datos'
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
    this.index();
    this.importarTipo();
    this.importarConstructor();
    this.importarEncargados();
  },
  
}
</script>
