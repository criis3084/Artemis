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
			<form data-vv-scope="step-2">
			<div class="vx-row">
				<div class="vx-col md:w-1/2 w-full mt-5">
					<template>
						<vs-upload :action="hola(this)" id='laImagen' v-on:change="aVeer(this)" limit='1' text="Subir fotografía" />
					</template>
				</div>
			</div>
			
            <div class="vx-col md:w-1/2 w-full mt-5">
				<div class="vx-col w-full">
					<vs-input class="w-full" icon-pack="feather" icon="icon-mail" icon-no-border label-placeholder="Ruta de fotografía" v-model="ruta"/>
				</div>
			</div>

			<div class="vx-col md:w-1/2 w-full mt-5">
				<div class="vx-col w-full">
					<vs-input class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="Título de fotografía" v-model="titulo"/>
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
		ruta:'',
		descripcion:'',
		titulo:'',
        arrayData: [],
        codigo: '',
        id:'',
        nombre: '',
		apellido: '',
		id_recibido:''
	}
  },
  methods:{
	  regresar(){
		let id_recibido = this.$route.params.id;
		this.$router.push('/apadrinamiento/fotografia/'+id_recibido);
	},
	  guardar(){
		this.id=parseInt(this.$route.params.id)
		console.log(this.getDate(this.fecha))
		console.log(this.id,this.valorT,this.valor1)
		axios.post("/api/historialFotografia/post/",{
			nino_id:this.id,
			ruta:this.ruta,
			descripcion:this.descripcion,
			titulo:this.titulo,
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
		this.$router.push('/apadrinamiento/fotografia/'+this.id);
	},
	getDate(datetime) {
        let date = new Date(datetime);
        let dateString = `${date.getFullYear()}/${date.getMonth() + 1}/${date.getDate()}`;
        return dateString;
	},
	  hola(ob){
			//localStorage.imagen = 'guardada';
			console.log(ob)
	  },
	  aVeer(ob){
		  console.log(ob)
	  },
      successUpload(){
      this.$vs.notify({color:'success',title:'Fotografía',text:'Fotografía importada'})
    },
     async index(page, search){ //async para que se llame cada vez que se necesite
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
			me.pagination= respuesta.pagination;
		})
		.catch(function (error) {
			console.log(error);
		});
    },
  },
  mounted(){
    this.index(1, this.search);
  },
  computed:{
	  obtenerNombre(){
		  console.log('?? - '+document.getElementById("laImagen"));
		  return true
	  }
  }
}
</script>