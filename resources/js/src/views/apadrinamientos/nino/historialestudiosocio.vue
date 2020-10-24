	<template>
			<div>
				<vx-card  class="mb-base">
				<div class = "demo-alignment">
					<div class="vx-col md:w-1/5 w-full mt-5">
						<router-link :to="this.ruta"><vs-button type="border" radius class="w-full" icon-pack="feather" icon="icon-corner-up-left" icon-no-border></vs-button></router-link>
					</div>
					<h2>Historial de Estudio Socioeconómico</h2>
					<vx-tooltip text = "Agregar nuevo Estudio Socioeconómico"> 
                      <vs-button @click="$router.push('/ingresar/estudiosocio/'+id_recibido)" radius type="gradient" icon-pack="feather" icon="icon-file-plus" color = "primary" size = "large"> </vs-button>
                    </vx-tooltip>
				</div>
				<vs-divider position="right">PID&#174;</vs-divider>
				<div class = "demo-alignment">
			<h5> <b>Nombre del niño: </b> </h5><h5>{{nombre}}</h5><h5>{{apellido}}</h5>
		</div>
		<div class = "demo-alignment">
			<h5> <b>Código: </b> </h5><h5>{{codigo}}</h5>
		</div>
					<vs-table pagination max-items="5" search :data="arrayData">

						<template slot="thead">
							<vs-th>Ver</vs-th>
							<vs-th>Fecha</vs-th>
							<vs-th>Estado</vs-th>
						</template>

						<template slot-scope="{data}">
							<vs-tr :data="tr" :key="indextr" v-for="(tr, indextr) in data" >
								<vs-td>
									<vx-tooltip text="Mostrar información completa"><vs-button @click="$router.push('/apadrinamiento/estudiosocio/'+id_recibido+'/'+data[indextr].id)" radius color="dark" type="flat" icon="visibility" size="large"> </vs-button></vx-tooltip>
								</vs-td > 							
								<vs-td >{{getDate(data[indextr].created_at)}}</vs-td>
								<vs-td>
									<vs-switch color="success" v-model="data[indextr].estado" @click="abrirDialog(data[indextr].id, data[indextr].estado)">
										<span slot="on" >Activo</span>
										<span slot="off">Desactivo</span>
									</vs-switch>
								</vs-td>
							</vs-tr>
						</template>
					</vs-table>
					<div class="vx-col md:w-1/3 w-full mt-5">
						<router-link :to="this.ruta"><vs-button type="gradient" class="w-full" icon-pack="feather" icon="icon-corner-up-left" icon-no-border>Regresar</vs-button></router-link>
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
import ChartjsComponentLineChart from '@/views/charts-and-maps/charts/chartjs/charts-components/ChartjsComponentLineChart.vue'
import { Line } from 'vue-chartjs'
import axios from 'axios'

export default {
  extends: Line,
  data () {
    return {
		rols: [],
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
		id_recibido: 0,
		nombre: '',
		apellido: '',
		switch2:false,
		id: 0,
		ruta:'',
		estadof:null,
		estado: null,
		ya:false,
		datos:{},
		opciones:{}
    }
  },
  components: {
    VueApexCharts,
    StatisticsCardLine,
    ChangeTimeDurationDropdown,
    VxTimeline,
	ChartjsComponentLineChart,
  },
  methods: {
	  goBack(){
      this.$router.go(-1)
    },
	titulo(){
		return 'Nombre: '+this.nombre +' '+ this.apellido + "     "+ ' Código: ' +this.codigo
	},
	getDate(datetime) {
        let date = new Date(datetime);
        let dateString = `${date.getFullYear()}/${date.getMonth() + 1}/${date.getDate()}`;
        return dateString;
	},
	async index(page, search){ //async para que se llame cada vez que se necesite
        let me = this;
        me.id_recibido = this.$route.params.id;
		const response = await axios.get(
			`/api/historialEstudio/get?&criterio=nino_id&buscar=${me.id_recibido}&completo=false`)
		.then(function (response) {
			var respuesta= response.data;
            me.arrayData = respuesta.historialEstudios.data;
            // me.nombre = respuesta.historialEstudios.data[0].datos_nino[0].nombres;
            // me.apellido = respuesta.historialEstudios.data[0].datos_nino[0].apellidos;
			// me.codigo = respuesta.historialEstudios.data[0].nino.codigo;
			// me.estadof = respuesta.historialEstudios.data[0].nino.estado;
			
			// me.id = respuesta.historialEstudios.data[0].datos_nino[0].id;
            // me.pagination= respuesta.pagination;
            // console.log("array");
			// console.log(me.arrayData);
			// if (me.estadof==1) {
			// 	me.ruta='/apadrinamiento/nino'
			// } else {
			// 	me.ruta='/apadrinamiento/ninono'
			// }
		})
		.catch(function (error) {
			console.log(error);
		});
		me.ya=true;
	},
	async index2(){ //async para que se llame cada vez que se necesite
        let me = this;
        me.id_recibido = this.$route.params.id;
		const response = await axios.get(
			`/api/nino/get?&criterio=nino_id&buscar=${me.id_recibido}&completo=false`)
		.then(function (response) {
			var respuesta= response.data;
            me.arrayData = respuesta.ninos.data;
            me.nombre = respuesta.ninos.data[0].datos.nombres;
            me.apellido = respuesta.ninos.data[0].datos.apellidos;
			me.codigo = respuesta.ninos.data[0].codigo;
			me.estadof = respuesta.ninos.data[0].estado;
			me.id = respuesta.ninos.data[0].datos.id;
            me.pagination= respuesta.pagination;
            console.log("array");
			console.log(me.arrayData);
			if (me.estadof==1) {
				me.ruta='/apadrinamiento/nino'
			} else {
				me.ruta='/apadrinamiento/ninono'
			}
		})
		.catch(function (error) {
			console.log(error);
		});
		me.ya=true;
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
			accept: this.cambiarEstado,
			cancel: this.close
		})

	},
	cambiarEstado(color){
		let titulo = ''

		if(this.estado === 0 || this.estado === false){
			titulo = 'Activado exitósamente'
			console.log(this.id)
			axios.put('/api/historialEstudio/activar/', {
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
			console.log(this.id)
			axios.put('/api/historialEstudio/desactivar/', {
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
		location.reload();
	},
	close(){
		let titulo = "Cancelado"
		let texto = "Cambio de estado cancelado"
		this.$vs.notify({
			color:'danger',
			title:`${titulo}`,
			text:`${titulo}`
		})
		this.index(this.pagination.current_page, this.search);
	}
	},
	mounted(){
		this.index(1, this.search);
	}
}
</script>

<style lang="scss">
/*! rtl:begin:ignore */
#dashboard-analytics {
  .greet-user{
    position: relative;

    .decore-left{
      position: absolute;
      left:0;
      top: 0;
    }
    .decore-right{
      position: absolute;
      right:0;
      top: 0;
    }
  }

  @media(max-width: 576px) {
    .decore-left, .decore-right{
      width: 140px;
    }
  }
}
/*! rtl:end:ignore */
</style>
