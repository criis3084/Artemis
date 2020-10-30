<template>
	<div>
		<vx-card class="mb-base">
		
		<div class = "demo-alignment">
			<div class="vx-col md:w-1/3 w-full mt-5">
			<router-link to="/apadrinamiento/nino"><vs-button type="border" radius class="w-full" icon-pack="feather" icon="icon-corner-up-left" icon-no-border></vs-button></router-link>
			</div>
			<h2> Historial de fotografías</h2>
			<vx-tooltip text = "Agregar nueva fotografía"> 
				<vs-button @click="$router.push('/ingresar/fotografia/'+id_recibido)" radius type="gradient" icon-pack="feather" icon="icon-file-plus" color = "primary" size = "large"> </vs-button> 
			</vx-tooltip>
			<vs-divider position="right">PID&#174;</vs-divider>
		</div>
		<div class = "demo-alignment">
			<h5> <b>Nombre del niño: </b> </h5><h5>{{nombre}}</h5><h5>{{apellido}}</h5>
		</div>
		<div class = "demo-alignment">
			<h5> <b>Código: </b> </h5><h5>{{codigo}}</h5>
		</div>
			<br>
		<br>
			<vs-table stripe pagination max-items="2" search :data="arrayData" noDataText="No hay datos disponibles">
				<template slot="thead">
					<div class="flex mb-4">
						<div class="w-1/2">
					<vs-th>Imagen</vs-th>
						</div>
						<div class="w-1/6">
					<vs-th>Título</vs-th>
						</div>
						<div class="w-1/6">
					<vs-th>Descripción</vs-th>
						</div>
						<div class="w-1/6">
					<vs-th>Fecha</vs-th>
						</div>
					<!-- <vs-th>Estado</vs-th> -->
					</div>
				</template>

				<template slot-scope="{data}">
						<vs-tr :data="tr" :key="indextr" v-for="(tr, indextr) in data" >
						<!-- <vs-td v-text="historialfotografia.fotografia.ruta" ></vs-td> -->
						<div class="flex mb-4">
						<div class="w-1/2">
						<vs-td>
							<img :src="data[indextr].fotografia.ruta" alt="content-img" class="responsive card-img-top">
						</vs-td>
						</div>
						<div class="w-1/6">
						<vs-td v-text="data[indextr].fotografia.titulo" ></vs-td>
						</div>
						<div class="w-1/6">
						<vs-td v-text="data[indextr].fotografia.descripcion" ></vs-td>
						</div>
						<div class="w-1/6">
						<vs-td v-text="getDate(data[indextr].created_at)" ></vs-td>
						</div>
						</div>
						
						<!-- <vs-td>
							<vs-switch color="success" v-model="historialfotografia.estado" @click="abrirDialog(historialfotografia.fotografia.id, historialfotografia.fotografia.estado)">
							<span slot="on" >Activo</span>
							<span slot="off">Desactivo</span>
							</vs-switch>
						</vs-td> -->
					</vs-tr>
				</template>
			</vs-table>
		<div class="vx-col md:w-1/3 w-full mt-5">
		<router-link to="/apadrinamiento/nino"><vs-button type="gradient" class="w-full" icon-pack="feather" icon="icon-corner-up-left" icon-no-border>Regresar</vs-button></router-link>
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
	goBack(){
		this.$router.go(-1)
    },
    getDate(datetime) {
        let date = new Date(datetime);
        let dateString = `${date.getFullYear()}/${date.getMonth() + 1}/${date.getDate()}`;
        return dateString;
    },
    async index(){ //async para que se llame cada vez que se necesite
        let me = this;
		me.id_recibido = this.$route.params.id
		const response = await axios.get(
			`/api/historialFotografia/get?&criterio=nino_id&buscar=${me.id_recibido}&completo=true`)
		.then(function (response) {
			var respuesta= response.data;
            me.arrayData = respuesta.historialfotografias.data;
		})
		.catch(function (error) {
			console.log(error);
		});
	},
	async index2(){ //async para que se llame cada vez que se necesite
        let me = this;
		me.id_recibido = this.$route.params.id
		const response = await axios.get(
			`/api/nino/get?&criterio=id&buscar=${me.id_recibido}&completo=true`)
		.then(function (response) {
			var respuesta= response.data;
            me.arrayData = respuesta.ninos.data;
            me.nombre = respuesta.ninos.data[0].datos.nombres;
            me.apellido = respuesta.ninos.data[0].datos.apellidos;
			me.codigo = respuesta.ninos.data[0].codigo;
			me.id = respuesta.ninos.data[0].datos.id;
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
			accept: this.cambiarEstado(color)
		})

		this.index();
    },
    cambiarEstado(color){
		let titulo = ''
		
		if(this.estado === 0 || this.estado === false){
			titulo = 'Activado exitósamente'
			axios.put('/api/fotografia/activar', {
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
			axios.put('/api/fotografia/desactivar', {
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
        this.index();
	},
  },
  mounted(){
	this.index();
	this.index2();
  },
  computed:{

  }
}
</script>