<template>
	<div>
		<div class = "demo-alignment">
			<h2> Historial de Fotografías</h2>
			<vx-tooltip text = "Agregar nueva fotografía"> 
				<vs-button @click="$router.push('/ingresar/fotografia/'+id_recibido)" radius type="gradient" icon-pack="feather" icon="icon-file-plus" color = "primary" size = "large"> </vs-button> 
			</vx-tooltip>
			<vs-divider/>
		</div>
		<div class = "demo-alignment">
			<h5> <b>Nombre del niño: </b> </h5><h5>{{nombre}}</h5><h5>{{apellido}}</h5>
		</div>
		<div class = "demo-alignment">
			<h5> <b>Código: </b> </h5><h5>{{codigo}}</h5>
		</div>
			<br>

		<!-- <div class = "demo-alignment">
		<div id="demo-basic-card"  v-for="historialfotografia in arrayData" :key="historialfotografia.id">
			<div class="vx-row" >
				<div class="vx-col w-full sm:w-1/2 lg:w-1/3 mb-base" >
				<vx-card >
					<div slot="no-body">
						<img :src="url" alt="content-img" class="responsive card-img-top">
					</div>
					<h5 v-text="historialfotografia.fotografia.titulo"></h5>
					<p class="text-grey" v-text="historialfotografia.nino_id"></p>
					<p class="text-grey" v-text="historialfotografia.fotografia.descripcion"></p>
					<p class="text-grey" v-text="getDate(historialfotografia.created_at)"></p>
				</vx-card>
				</div>
			</div>
		</div>
		</div> -->
		<vx-card>
			<vs-table stripe max-items="5" :data="arrayData">
				<template slot="thead">
					<vs-th>Imagen</vs-th>
					<vs-th>Título</vs-th>
					<vs-th>Descripción</vs-th>
					<vs-th>Fecha</vs-th>
					<vs-th>Estado</vs-th>
				</template>

				<template>
					<vs-tr v-for="historialfotografia in arrayData" :key="historialfotografia.id">
						<!-- <vs-td v-text="historialfotografia.fotografia.ruta" ></vs-td> -->
						<vs-td>
							<img :src="historialfotografia.fotografia.ruta" alt="content-img" class="responsive card-img-top">
						</vs-td>
						<vs-td v-text="historialfotografia.fotografia.titulo" ></vs-td>
						<vs-td v-text="historialfotografia.fotografia.descripcion" ></vs-td>
						<vs-td v-text="getDate(historialfotografia.created_at)" ></vs-td>
						<vs-td>
							<vs-switch color="success" v-model="historialfotografia.estado" @click="abrirDialog(historialfotografia.id, historialfotografia.estado)">
							<span slot="on" >Activo</span>
							<span slot="off">Desactivo</span>
							</vs-switch>
						</vs-td>
					</vs-tr>
				</template>
			</vs-table>
	
		</vx-card>
		<div class="vx-col md:w-1/2 w-full mt-5">
			<router-link to="/apadrinamiento/nino"><vs-button class="w-full" icon-pack="feather" icon="icon-corner-up-left" icon-no-border>Regresar</vs-button></router-link>
		</div>
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
  data () {
    return {
         pagination : {
        'total' : 0,
          'current_page' : 0,
          'per_page' : 0,
          'last_page' : 0,
          'from' : 0,
          'to' : 0
      },
      offset : 3,
      search : '',
      arrayData: [],
      codigo: '',
      nombre: '',
      apellido: '',
	  switch2:false,
	  id: 0,
	  id_recibido:0,
      estado: null,
      url:"https://pbs.twimg.com/profile_images/1305883698471018496/_4BfrCaP.jpg",
    }
  },
  components: {
    VueApexCharts,
    StatisticsCardLine,
    ChangeTimeDurationDropdown,
    VxTimeline,
  },
  methods: {
    getDate(datetime) {
        let date = new Date(datetime);
        let dateString = `${date.getFullYear()}/${date.getMonth() + 1}/${date.getDate()}`;
        return dateString;
    },
    async index(page, search){ //async para que se llame cada vez que se necesite
        let me = this;
		me.id_recibido = this.$route.params.id
		const response = await axios.get(
			`/api/historialFotografia/get?&criterio=nino_id&buscar=${me.id_recibido}&completo=true`)
		.then(function (response) {
			var respuesta= response.data;
            me.arrayData = respuesta.historialfotografias.data;
            me.nombre = respuesta.historialfotografias.data[0].datos_nino[0].nombres;
            me.apellido = respuesta.historialfotografias.data[0].datos_nino[0].apellidos;
            me.codigo = respuesta.historialfotografias.data[0].nino.codigo;
            me.id = respuesta.historialfotografias.data[0].datos_nino[0].id;
			me.pagination= respuesta.pagination;

		})
		.catch(function (error) {
			console.log(error);
		});
    },
    abrirDialog(id, estado){

		let titulo = '';
		let color = '';

		if(estado === 0 || estado === false){
			// cambiar de color al boton
			color = 'success'
			titulo = 'Confirmar activación'
		}

		else if(estado === 1 || estado === true){
			color = 'danger'
			titulo = 'Confirmar desactivación'
		}
		
		this.id = id
		this.estado = estado

		this.$vs.dialog({
			type:'confirm',
			color: `${color}`,
			title: `${titulo}`,
			text: '¿Está seguro de llevar a cabo esta acción?',
			accept: this.cambiarEstado
		})

		this.index(this.pagination.current_page, this.search);
    },
    cambiarEstado(color){
		let titulo = ''
		
		if(this.estado === 0 || this.estado === false){
			titulo = 'Activado exitósamente'
			axios.put('/api/historialFotografia/activar', {
				id: this.id
			})
			.then(function (response) {
				console.log(response.data.message)
			})
			.catch(function (error) {
				console.log(error.response.data.message)
			});
		}
		else if(this.estado === 1 || this.estado === true){
			titulo = 'Desactivado exitósamente'
			axios.put('/api/historialFotografia/desactivar', {
				id: this.id
			})
			.then(function (response) {
				console.log(response.data.message)
			})
			.catch(function (error) {
				console.log(error.response.data.message)
			});
		}
		this.$vs.notify({
          color:'success',
          title:`${titulo}`,
          text:'La acción se realizo exitósamente'
        })
        this.index(this.pagination.current_page, this.search);
	},
  },
  mounted(){
    this.index(1, this.search);
  },
  computed:{

  }
}
</script>