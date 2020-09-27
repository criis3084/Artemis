<template>
	<div>
		<vx-card>
			<div>
			 <div class = "demo-alignment">
                    <h5>Nueva fotografía para el niño:</h5><h5>{{nombre}}</h5><h5>{{apellido}}</h5>
            </div>
			<form data-vv-scope="step-2">
			<div class="vx-row">
				<div class="vx-col md:w-1/2 w-full mt-5">
					<template>
						<vs-upload action="https://jsonplaceholder.typicode.com/posts/" @on-success="successUpload" />
					</template>
				</div>
			</div>
			
            <div class="vx-col md:w-1/2 w-full mt-5">
				<div class="vx-col w-full">
					<vs-input class="w-full" icon-pack="feather" icon="icon-mail" icon-no-border label-placeholder="Ruta de imagen" v-model="ruta"/>
				</div>
			</div>

            <div class="vx-col md:w-1/2 w-full mt-5">
				<div class="vx-col w-full">
					<vs-input class="w-full" icon-pack="feather" icon="icon-image" icon-no-border label-placeholder="Descripcion" v-model="descripcion"/>
				</div>
			</div>

			<div class="vx-col md:w-1/2 w-full mt-5">
				<div class="vx-col w-full">
					<vs-input class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="Título" v-model="titulo"/>
				</div>
			</div>

		</form>

        <div class="vx-col md:w-1/2 w-full mt-5">
            <vs-button @click="$router.push('/apadrinamiento/fotografia/'+id)" class="w-full" icon-pack="feather" icon="icon-corner-up-left" icon-no-border>Regresar</vs-button>
        </div>

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
      successUpload(){
      this.$vs.notify({color:'success',title:'Fotografia',text:'Fotografia importada'})
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
}
</script>