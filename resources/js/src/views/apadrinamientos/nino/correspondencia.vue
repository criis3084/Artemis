	<template>
			<div>
				<vx-card class="mb-base">
				<div class = "demo-alignment">
					<div class="vx-col md:w-1/4 w-full mt-5">
					<router-link to="/apadrinamiento/apadrinamiento/"><vs-button class="w-full" type="border" radius icon-pack="feather" icon="icon-corner-up-left" icon-no-border></vs-button></router-link>
					</div>
					<h2>Historial de Correspondencia</h2>
					<vx-tooltip text = "Agregar nueva "> 
                      <vs-button @click="$router.push('/ingresar/correspondencia/'+id_recibido)" radius type="gradient" icon-pack="feather" icon="icon-file-plus" color = "primary" size = "large"> </vs-button>
                    </vx-tooltip>
				</div>
				<vs-divider position="right">PID&#174;</vs-divider>

                <div class = "demo-alignment">
			        <h5> <b>Nombre del niño: </b> </h5><h5>{{nombres_nino}}</h5><h5>{{apellidos_nino}}</h5>
		        </div>
                <div class = "demo-alignment">
                    <h5> <b>Nombre del padrino: </b> </h5><h5>{{nombres_padrino}}</h5><h5>{{apellidos_padrino}}</h5>
                </div>
				<br>
				
					<vs-table stripe pagination max-items="2" search :data="arrayData" noDataText="No hay datos disponibles">

						<template slot="thead">
						<div class="flex mb-4">
						<div class="w-1/2">
							<vs-th>Imagen</vs-th>
						</div>
						<div class="w-1/4">
							<vs-th>Descripción</vs-th>
						</div>
						<div class="w-1/4">
							<vs-th>Fecha</vs-th>
						</div>
						<!-- <div class="w-1/4">
							<vs-th>Estado</vs-th>
						</div> -->
						</div>
						</template>

						<template slot-scope="{data}">
						<vs-tr :data="tr" :key="indextr" v-for="(tr, indextr) in data" >
						<div class="flex mb-4">
						<div class="w-1/2">
								<vs-td>
									<img :src="data[indextr].correspondencia.ruta_imagen" :alt="data[indextr].correspondencia.ruta_imagen" class="responsive card-img-top">
								</vs-td>
						</div>
						<div class="w-1/4">	
								<vs-td v-text="data[indextr].correspondencia.descripcion" ></vs-td>
						</div>
						<div class="w-1/4">
								<vs-td v-text="getDate(data[indextr].correspondencia.created_at)" ></vs-td>
						</div>
						<!-- <div class="w-1/4">
								<vs-td>
									<vs-switch color="success" v-model="data[indextr].estado" @click="abrirDialog(data[indextr].id, data[indextr].estado)">
										<span slot="on" >Activo</span>
										<span slot="off">Desactivo</span>
									</vs-switch>
								</vs-td>
						</div> -->
						</div>
							</vs-tr>
						</template>
						
					</vs-table>
				</vx-card>
				<div class="vx-col md:w-1/3 w-full mt-5">
  <router-link to="/apadrinamiento/apadrinamiento/"><vs-button type="gradient" class="w-full" icon-pack="feather" icon="icon-corner-up-left" icon-no-border>Regresar</vs-button></router-link>
    </div>
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
		arrayDataT: [],
		codigo: '',
		id_recibido: 0,
		id_ppi: 0,
		apadrinamiento_idT: '',
        correspondencia_idT: '',
        nombres_nino:'',
        apellidos_nino:'',
        nombres_padrino:'',
        apellidos_padrino:'',
		switch2:false,
		id: 0,
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
	titulo(){
		return 'Nombre: '+this.nombre +' '+ this.apellido + "     "+ ' Codigo: ' +this.codigo
	},

	getDate(datetime) {
        let date = new Date(datetime);
        let dateString = `${date.getFullYear()}/${date.getMonth() + 1}/${date.getDate()}`;
        return dateString;
	},
	async index(){ //async para que se llame cada vez que se necesite
        let me = this;
        me.id_recibido = this.$route.params.id;
        console.log("criterio");
        console.log(me.id_recibido);
		const response = await axios.get(
			`/api/historialCorrespondencia/get?&criterio=apadrinamiento_id&buscar=${me.id_recibido}&completo=true`)
		.then(function (response) {
			var respuesta= response.data;
            me.arrayData = respuesta.historialCorrespondencias.data;
            me.apadrinamiento_idT = me.arrayData[0].apadrinamiento_id;
            // me.importarApadrinamiento(me.apadrinamiento_idT);
            me.correspondencia_idT = me.arrayData.correspondencia_id;
            console.log("historial");
            console.log(me.arrayData);
		})
		.catch(function (error) {
			console.log(error);
		});
		me.ya=true;
    },
    importarApadrinamiento(){ //async para que se llame cada vez que se necesite
        let me = this;
        me.id_recibido = this.$route.params.id;
		axios.get(
			`/api/apadrinamiento/get?&criterio=id&buscar=${this.id_recibido}&completo=true`)
		.then(function (response) {
			var respuesta= response.data;
            me.arrayDataT = respuesta.apadrinamientos.data;
            // console.log("aca");
            // console.log(me.arrayDataT);
            // me.padrino = me.traerNombres(me.arrayDataT);
            me.nombres_nino = me.arrayDataT[0].datos_nino[0].nombres;
            me.apellidos_nino = me.arrayDataT[0].datos_nino[0].apellidos;
            me.nombres_padrino = me.arrayDataT[0].datos_padrino[0].nombres;
            me.apellidos_padrino = me.arrayDataT[0].datos_padrino[0].apellidos;
            // console.log("variables");
            // console.log(me.nombres_nino);
            // console.log(me.apellidos_nino);
            // console.log(me.apellidos_padrino);
            // console.log(me.nombres_padrino);
            // console.log("Apadrinamiento");
            // console.log(me.arrayDataT);
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
			axios.put('/api/historialCorrespondencia/activar/', {
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
			axios.put('/api/historialCorrespondencia/desactivar/', {
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
	close(){
		let titulo = "Cancelado"
		let texto = "Cambio de estado cancelado"
		this.$vs.notify({
			color:'danger',
			title:`${titulo}`,
			text:`${titulo}`
		})
		this.index();
	}
	},
	mounted(){
        this.index();
        this.importarApadrinamiento();
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
