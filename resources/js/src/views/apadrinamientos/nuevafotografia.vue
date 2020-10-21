<template>
	<div>
		<vx-card>
			<div>
				<div class="vx-col md:w-1/2 w-full mt-5">
            		<vs-button @click="regresar" class="w-full" icon-pack="feather" icon="icon-corner-up-left" icon-no-border>Regresar</vs-button>
        		</div>
			</div>
			<div>
			 <div class = "demo-alignment">
                    <h5>Nueva fotografía para el niño:</h5><h5>{{nombre}}</h5><h5>{{apellido}}</h5>
            </div>
		<form>
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
					<vs-input name="titulo" v-validate="'required'" class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="Título de fotografía" v-model="titulo"/>
						<span class="text-danger">{{ errors.first('titulo') }}</span>

				</div>
			</div>

            <div class="vx-col md:w-1/2 w-full mt-5">
				<div class="vx-col w-full">
					<vs-input class="w-full" icon-pack="feather" icon="icon-image" icon-no-border label-placeholder="Descripción de fotografía" v-model="descripcion"/>
				</div>
			</div>

			<br>
			<vs-button @click.prevent="guardar">Registrar imagen</vs-button>
			

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
	if(result && this.ruta!="") {
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
	else {
		this.valImagen='La imagen es requerida',
		this.$vs.notify({
				color:'danger',
				title:`Error en validación`,
				text:'Ingrese correctamente todos los datos'
			})
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
		this.valImagen='';
	},
  },
  mounted(){
    this.index();
  },
}
</script>