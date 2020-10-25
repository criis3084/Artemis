<template>
	<div>
		<vx-card>
		<div>
			<div>	
			<div class = "demo-alignment">
				 <div class="vx-col md:w-1/3 w-full mt-5">
            		<vs-button @click="regresar" type="border" radius class="w-full" icon-pack="feather" icon="icon-corner-up-left" icon-no-border></vs-button>
        		</div>
				<div class="flex-1 ">
				<h2>Nueva fotografía</h2>
				</div>
            </div>
			
			</div>
				<vs-divider position="right">PID&#174;</vs-divider>
			
		<form>
			<div class = "demo-alignment">
			<h5><b>Nombre del niño:</b></h5><h5>{{nombre}}</h5><h5>{{apellido}}</h5>
			</div>
			<div class="vx-row">
				<div class="vx-col md:w-1/2 w-full mt-5">
					<template>
						<vs-upload name="ruta" automatic action="/api/historialFotografia/imagen" limit='1' :headers="head" fileName='photos' @on-success="respuesta" @on-delete="vaciar" text="Fotografía del niño" />
						<span class="text-danger">{{ this.valImagen }}</span>
					</template>
				</div>
			</div>

			<div class="vx-col md:w-1/2 w-full mt-5">
				<div class="vx-col w-full">
					<vs-input name="titulo" v-validate="'required|max:150'" class="w-full" icon-pack="feather" icon="icon-bold" icon-no-border label-placeholder="Título de fotografía" v-model="titulo"/>
						<span class="text-danger">{{ errors.first('titulo') }}</span>

				</div>
			</div>

            <div class="vx-col md:w-1/2 w-full mt-5">
				<div class="vx-col w-full">
					<vs-input name="descripcion" v-validate="'max:254'" class="w-full" icon-pack="feather" icon="icon-image" icon-no-border label-placeholder="Descripción de fotografía" v-model="descripcion"/>
						<span class="text-danger">{{ errors.first('descripcion') }}</span>

				</div>
			</div>

			<br>
			<vs-button icon-pack="feather" type="gradient" icon="icon-save" @click.prevent="guardar">Registrar imagen</vs-button>
			

		</form>

        
			</div>
		</vx-card>
	</div>
</template>

<script>
import VueApexCharts from 'vue-apexcharts'
import StatisticsCardLine from '@/components/statistics-cards/StatisticsCardLine.vue'
//import analyticsData from './ui-elements/card/analyticsData.js'
import ChangeTimeDurationDropdown from '@/components/ChangeTimeDurationDropdown.vue'
import VxTimeline from '@/components/timeline/VxTimeline'
import axios from 'axios'
import { Validator } from 'vee-validate';
const dict = {
  custom: {
    ruta: {
	  required: 'La imagen es requerida',
	},
	 titulo: {
	  required: 'El título es requerido',
	  max: 'Este campo solo acepta hasta 150 caracteres',
	},
	 descripcion: {
	  max: 'Este campo solo acepta hasta 254 caracteres',
    },
  }
};
Validator.localize('en', dict);
export default {
  data() {
    return {
		ruta:'',
		descripcion:'',
		titulo:'',
        arrayData: [],
        codigo: '',
        id:'',
        nombre: '',
		apellido: '',
		id_recibido:'',
		valImagen:'',
		boolVal:null,
		head:{
			"imagenanterior":""	
		},
	}
  },
  methods:{
	regresar(){
		let id_recibido = this.$route.params.id;
		this.$router.push('/apadrinamiento/fotografia/'+id_recibido);
	},
	guardar(){
	this.$validator.validateAll().then(result => {
	if(result && this.boolVal==true) {
		this.id=parseInt(this.$route.params.id)
		console.log(this.getDate(this.fecha))
		console.log(this.id,this.valorT,this.valor1)
		axios.post("/api/historialFotografia/post/",{
			nino_id:this.id,
			ruta:  '/storage/public/historialFotografias/' +this.ruta,
			descripcion:this.descripcion,
			titulo:this.titulo,
		}).then(function(response) {
				console.log(response)
			})
			.catch(function(error) {
			console.log(error)
		});
		this.$vs.notify({
					color:'success',
					title:'Éxito',
					text:'Registro Creado!'
				});
		this.$router.push('/apadrinamiento/fotografia/'+this.id);
	}
	else if(!result && this.boolVal==true){
		this.boolVal=true;
	}
	else{
		this.boolVal=false;
		this.$vs.notify({
				color:'danger',
				title:`Error en validación`,
				text:'Ingrese correctamente todos los datos'
			})
		this.valImagen='La imagen es requerida';
	}
	})
	},
	getDate(datetime) {
        let date = new Date(datetime);
        let dateString = `${date.getFullYear()}/${date.getMonth() + 1}/${date.getDate()}`;
        return dateString;
	},
	async index(){ //async para que se llame cada vez que se necesite
        let me = this;
        me.id_recibido = this.$route.params.id;
		const response = await axios.get(
			`/api/historialFotografia/get?&criterio=nino_id&buscar=${me.id_recibido}&completo=true`)
		.then(function (response) {
			var respuesta= response.data;
            me.arrayData = respuesta.historialfotografias.data;
            me.nombre = respuesta.historialfotografias.data[0].datos_nino[0].nombres;
            me.apellido = respuesta.historialfotografias.data[0].datos_nino[0].apellidos;
            me.codigo = respuesta.historialfotografias.data[0].nino.codigo;
            me.id = respuesta.historialfotografias.data[0].nino.id;
		})
		.catch(function (error) {
			console.log(error);
		});
	},
	vaciar(){
			this.ruta='';
	},
	respuesta(e){
		this.ruta=e.currentTarget.response.replace(/['"]+/g, '')
		this.head.imagenanterior=this.ruta
		this.$vs.notify({
					color:'success',
					title:'Imagen subida',
					text:'Acción realizada exitósamente!'
				});
		this.boolVal=true;
		this.valImagen='';
	},
  },
  mounted(){
    this.index();
  },
}
</script>