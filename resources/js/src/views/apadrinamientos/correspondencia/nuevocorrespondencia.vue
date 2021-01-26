<template>
	<div>
		<vx-card>

			<div class = "demo-alignment">
				<div class="vx-col md:w-1/3 w-full mt-5">
            		<vs-button @click="regresar" class="w-full" type="border" radius icon-pack="feather" icon="icon-corner-up-left" icon-no-border></vs-button>
        		</div>
				<div class="flex-1 ">
				<h2>Nueva correspondencia</h2>
				</div>
            </div>
				<vs-divider position="right">PID&#174;</vs-divider>
			<div>
			  <div class = "demo-alignment">
			        <h5> <b>Nueva correspondencia del niño: </b> </h5><h5>{{nombres_nino}}</h5><h5>{{apellidos_nino}}</h5>
		        </div>
                <div class = "demo-alignment">
                    <h5> <b>Padrino: </b> </h5><h5>{{nombres_padrino}}</h5><h5>{{apellidos_padrino}}</h5>
                </div>
			<form data-vv-scope="step-2">
			<div class="vx-row">
				<div class="vx-col md:w-1/2 w-full mt-5">
					<template>
						<vs-upload v-validate="'required'" name="foto" automatic action="/api/historialCorrespondencia/imagen" limit='1' :headers="head" fileName='photos' @on-success="respuesta" @on-delete="vaciar" text="Fotografía de la correspondencia" />
					</template>
					<span class="text-danger">{{ this.valImagen }}</span>

				</div>
			</div>

            <div class="vx-col md:w-1/2 w-full mt-5">
				<div class="vx-col w-full">
					<vs-input class="w-full" icon-pack="feather" icon="icon-image" icon-no-border label-placeholder="Descripción de fotografía" v-model="descripcion"/>
				</div>
			</div>

			

		</form>

        <br>
		<vs-button icon-pack="feather" type="gradient" icon="icon-save" @click.prevent="guardar">Registrar imagen</vs-button>
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
    foto: {
	  required: 'La imagen es requerida',
	},
  }
};
Validator.localize('en', dict);
export default {
  data() {
    return {
		ruta_imagen:'',
		descripcion:'',
		titulo:'',
		arrayData: [],
		arrayDataT: [],
        codigo: '',
        id:'',
        nombre: '',
		apellido: '',
        id_recibido:'',
        apadrinamiento_idT: '',
        correspondencia_idT: '',
        nombres_nino:'',
        apellidos_nino:'',
		nombres_padrino:'',
		correspondencia_id:0,
		valImagen:'',
		apellidos_padrino:'',
		boolVal:null,
		head:{
			"imagenanterior":""	
		},
	}
  },
  methods:{
	regresar(){
		let id_recibido = this.$route.params.id;
		this.$router.push('/apadrinamiento/correspondencia/'+id_recibido);
	},
	enviando(id){
		this.correspondencia_id=id;
	},
	guardar(){
	this.$validator.validateAll().then(result => {
	if(result && this.boolVal==true) {
		this.id=this.$route.params.id;
		axios.post("/api/historialCorrespondencia/post/",{
            apadrinamiento_id:this.id,
			ruta_imagen:'/storage/public/' +this.ruta_imagen,
			descripcion:this.descripcion,
		}).then(function(response) {
			me.enviando(response.data.id)
				console.log(response)
				
			})
			.catch(function(error) {
			console.log(error)
		});
		this.$vs.notify({
					color:'success',
					title:'Correspondencia registrada!',
					text:'La acción se realizo exitósamente'
				});
		this.$router.push('/apadrinamiento/correspondencia/'+this.id);
	}
	else if(!result && this.boolVal==true){
		this.boolVal=true;
	}
	else{
		this.boolVal=false;
		this.$vs.notify({
				color:'danger',
				title:`Error en validación!`,
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
	importarApadrinamiento(){ //async para que se llame cada vez que se necesite
        let me = this;
        me.id_recibido = this.$route.params.id;
		axios.get(
			`/api/apadrinamiento/get?&criterio=id&buscar=${me.id_recibido}&completo=true`)
		.then(function (response) {
			var respuesta= response.data;
            me.arrayDataT = respuesta.apadrinamientos.data;
            me.nombres_nino = me.arrayDataT[0].datos_nino[0].nombres;
            me.apellidos_nino = me.arrayDataT[0].datos_nino[0].apellidos;
            me.nombres_padrino = me.arrayDataT[0].datos_padrino[0].nombres;
            me.apellidos_padrino = me.arrayDataT[0].datos_padrino[0].apellidos;
		})
		.catch(function (error) {
			console.log(error);
		});
		me.ya=true;
    },
	vaciar(){
		this.ruta_imagen='';
	},
	respuesta(e){
		this.ruta_imagen=e.currentTarget.response.replace(/['"]+/g, '')
		this.head.imagenanterior=this.ruta_imagen
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
    this.importarApadrinamiento();
  },
}
</script>