<!-- =========================================================================================
  File Name: DashboardAnalytics.vue
  Description: Dashboard Analytics
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
========================================================================================== -->
<!-- Este es el componente inicial -->
	<template>
			<div>
				<div class = "demo-alignment">
					<h2>Historial de PPI</h2>
					<vx-tooltip text = "Agregar nuevo PPI"> 
                      <vs-button @click="$router.push('/ingresar/ppi/'+id)" radius type="gradient" icon-pack="feather" icon="icon-file-plus" color = "primary" size = "large"> </vs-button> 
                    </vx-tooltip>
				</div>
				<div class = "demo-alignment">
                    <h5>Nombre del niño:</h5><h5>{{nombre}}</h5><h5>{{apellido}}</h5>
                </div>
                <div class = "demo-alignment">
                    <h5>Código:</h5><h5>{{codigo}}</h5>
                </div>
                <br>

				<vx-card>
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
									<vx-tooltip text="Información Completa"> <vs-button radius color="dark" type="flat" icon="visibility" size="large"></vs-button></vx-tooltip>
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
import axios from 'axios'

export default {
  data () {
    return {
      //Aqui van a guardar todas su variables.
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
      id: '',
      nombre: '',
      apellido: '',
	  switch2:false,
	  id: 0,
	  estado: null,
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
        let x = this.$route.params.id;
        console.log("hola"+x);
		const response = await axios.get(
			`/api/historialPpi/get?&criterio=nino_id&buscar=${x}&completo=true`)
		.then(function (response) {
			console.log(page)
			var respuesta= response.data;
            me.arrayData = respuesta.historialPpis.data;
            me.nombre = respuesta.historialPpis.data[0].datos_nino[0].nombres;
            me.apellido = respuesta.historialPpis.data[0].datos_nino[0].apellidos;
            me.codigo = respuesta.historialPpis.data[0].nino.codigo;
            me.id = respuesta.historialPpis.data[0].datos_nino[0].id;
            console.log(me.nombre);
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
