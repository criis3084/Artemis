	<template>
			<div>
				<div class = "demo-alignment">
					<h2>Historial de PPI</h2>
					<vx-tooltip text = "Agregar nuevo PPI"> 
                      <vs-button @click="$router.push('/ingresar/ppi/'+id_recibido)" radius type="gradient" icon-pack="feather" icon="icon-file-plus" color = "primary" size = "large"> </vs-button>
                    </vx-tooltip>
				</div>
				<br>
				<vx-card :title="titulo()" class="mb-base">
					<vs-button @click="actualizar">Actualizar Grafica</vs-button>

					<chartjs-component-line-chart :height="250" :data="datos" :options="opciones"></chartjs-component-line-chart>
				<vs-divider></vs-divider>
				<!--
				<chartjs-line-chart :height="250" :data="datos" :options="optiones" ></chartjs-line-chart>
				-->
					<vs-table stripe max-items="5" :data="arrayData">

						<template slot="thead">
							<vs-th>Ver</vs-th>
							<vs-th>Fecha</vs-th>
							<vs-th>Total</vs-th>
							<vs-th>Estado</vs-th>
						</template>

						<template>
							<vs-tr v-for="historialPpi in arrayData" :key="historialPpi.id">
								<vs-td>
									<vx-tooltip text="Mostrar información completa"><vs-button @click="$router.push('/ver/ppi/'+historialPpi.id)" radius color="dark" type="flat" icon="visibility" size="large"> </vs-button></vx-tooltip>
								</vs-td>							
								<vs-td v-text="getDate(historialPpi.created_at)" ></vs-td>
								<vs-td v-text="historialPpi.ppi.total" ></vs-td>
								<vs-td>
									<vs-switch color="success" v-model="historialPpi.estado" @click="abrirDialog(historialPpi.id, historialPpi.estado)">
										<span slot="on" >Activo</span>
										<span slot="off">Desactivo</span>
									</vs-switch>
								</vs-td>
							</vs-tr>
						</template>
					</vs-table>
					<div>
						<vs-pagination :total="pagination.last_page" :max="9" v-model="pagination.current_page" @change="index(pagination.current_page, search);" prev-icon="arrow_back" next-icon="arrow_forward"></vs-pagination>
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
		id_ppi: 0,
		nombre: '',
		apellido: '',
		switch2:false,
		id: 0,
		estado: null,
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
	titulo(){
		return 'Nombre: '+this.nombre +' '+ this.apellido + "     "+ ' Codigo: ' +this.codigo
	},
	actualizar(){
		this.arrayData
		this.datos=this.traerData(this.arrayData)
		this.opciones=this.traerOptions(this.arrayData)
		this.renderChart(this.datos, this.opciones)
	},
	traerNombre(tabla){
		console.log('Datos de los ninos')
		tabla.forEach(function(valor, indice, array){
			valor.nombres=valor.datos.nombres
		}); 
		console.log(tabla)
		return tabla
	},
	traerData(arreglo){
		console.log('*********************************************************************************')
		let valores =[]
		let fechas =[]
		if (arreglo === undefined)
		{
			arreglo.forEach(function(valor, indice, array){
				valores.push(valor.ppi.total)
				fechas.push(valor.fecha_estudio)
			});
		}
		let data =  {
	        labels: fechas,
    	    datasets: [
				{
					data: valores,
					label: 'Registros',
					borderColor: '#7367F0',
					fill: false
				}
			]
		}
		return data
	},
	traerOptions(arreglo){
		let options={
				title: {
					display: true,
					text: 'Registro de Avance de PPI'
				}
		}
		return options
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
			`/api/historialPpi/get?&criterio=nino_id&buscar=${me.id_recibido}&completo=true`)
		.then(function (response) {
			var respuesta= response.data;
            me.arrayData = respuesta.historialPpis.data;
            me.nombre = respuesta.historialPpis.data[0].datos_nino[0].nombres;
            me.apellido = respuesta.historialPpis.data[0].datos_nino[0].apellidos;
            me.codigo = respuesta.historialPpis.data[0].nino.codigo;
			me.id = respuesta.historialPpis.data[0].datos_nino[0].id;
			me.pagination= respuesta.pagination;
		})
		.catch(function (error) {
			console.log(error);
		});
		me.datos = me.traerData(me.arrayData)
		me.opciones = me.traerOptions(me.arrayData)
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
			axios.put('/api/historialPpi/activar', {
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
			axios.put('/api/historialPpi/desactivar', {
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
	},
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
