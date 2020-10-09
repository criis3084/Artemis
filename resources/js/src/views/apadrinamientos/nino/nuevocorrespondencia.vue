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
			        <h5> <b>Nueva correspondencia del niño: </b> </h5><h5>{{nombres_nino}}</h5><h5>{{apellidos_nino}}</h5>
		        </div>
                <div class = "demo-alignment">
                    <h5> <b>Padrino: </b> </h5><h5>{{nombres_padrino}}</h5><h5>{{apellidos_padrino}}</h5>
                </div>
			<form data-vv-scope="step-2">
			<div class="vx-row">
				<div class="vx-col md:w-1/2 w-full mt-5">
					<template>
						<vs-upload automatic action="/api/historialCorrespondencia/imagen" limit='1' :headers="head" fileName='photos' @on-success="respuesta" @on-delete="vaciar" text="Fotografia de la correspondencia" />
					</template>
				</div>
			</div>
			
            <div class="vx-col md:w-1/2 w-full mt-5">
				<div class="vx-col w-full">
					<vs-input class="w-full" icon-pack="feather" icon="icon-mail" icon-no-border label-placeholder="Ruta de fotografía" v-model="ruta_imagen"/>
				</div>
			</div>

            <div class="vx-col md:w-1/2 w-full mt-5">
				<div class="vx-col w-full">
					<vs-input class="w-full" icon-pack="feather" icon="icon-image" icon-no-border label-placeholder="Descripción de fotografía" v-model="descripcion"/>
				</div>
			</div>

			

		</form>

        <br>
		<vs-button @click="guardar">Registrar imagen</vs-button>
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
export default {
  data() {
    return {
		ruta_imgane:'',
		descripcion:'',
		titulo:'',
        arrayData: [],
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
        apellidos_padrino:'',
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
	guardar(){
		this.id=parseInt(this.$route.params.id)
		axios.post("/api/historialCorrespondencia/post/",{
            apadrinamiento_id:this.id,
			ruta_imagen:  '/storage/public/correspondencia/' +this.ruta_imagen,
			descripcion:this.descripcion,
		}).then(function(response) {
				console.log(response)
				this.$vs.notify({
					color:'success',
					title:'Exito',
					text:'Registro Creado!'
				});
			})
			.catch(function(error) {
			console.log(error)
		});
		this.$router.push('/apadrinamiento/correspondencia/'+this.id);
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
            me.arrayData = respuesta.apadrinamientos.data;
            console.log("aca");
            console.log(me.arrayData);
            // me.padrino = me.traerNombres(me.arrayData);
            me.nombres_nino = me.arrayData[0].datos_nino[0].nombres;
            me.apellidos_nino = me.arrayData[0].datos_nino[0].apellidos;
            me.nombres_padrino = me.arrayData[0].datos_padrino[0].nombres;
            me.apellidos_padrino = me.arrayData[0].datos_padrino[0].apellidos;
            console.log("variables");
            console.log(me.nombres_nino);
            console.log(me.apellidos_nino);
            console.log(me.apellidos_padrino);
            console.log(me.nombres_padrino);
            console.log("Apadrinamiento");
            console.log(me.arrayData);
		})
		.catch(function (error) {
			console.log(error);
		});
		me.ya=true;
    },
	vaciar(){
			this.ruta='';
	},
	respuesta(e){
		this.ruta_imgane=e.currentTarget.response.replace(/['"]+/g, '')
		this.head.imagenanterior=this.ruta_imagen
	},
  },
  mounted(){
    this.importarApadrinamiento();
  },
}
</script>