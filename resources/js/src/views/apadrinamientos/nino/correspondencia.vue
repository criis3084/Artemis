	<template>
			<div>
				<div class = "demo-alignment">
					<h2>Historial de Correspondencia</h2>
					<vx-tooltip text = "Agregar nueva "> 
                      <vs-button @click="$router.push('/ingresar/correspondencia/'+id_recibido)" radius type="gradient" icon-pack="feather" icon="icon-file-plus" color = "primary" size = "large"> </vs-button>
                    </vx-tooltip>
				</div>
                <div class = "demo-alignment">
			        <h5> <b>Nombre del niño: </b> </h5><h5>{{nombres_nino}}</h5><h5>{{apellidos_nino}}</h5>
		        </div>
                <div class = "demo-alignment">
                    <h5> <b>Nombre del padrino: </b> </h5><h5>{{nombres_padrino}}</h5><h5>{{apellidos_padrino}}</h5>
                </div>
				<br>
				<vx-card class="mb-base">
					<vs-table pagination max-items="5" search :data="arrayData">

						<template slot="thead">
							<vs-th>Imagen</vs-th>
							<vs-th>Descripción</vs-th>
							<vs-th>Fecha</vs-th>
							<vs-th>Estado</vs-th>
						</template>

						<template slot-scope="{data}">
							<vs-tr v-for="historialCorrespondencia in arrayData" :key="historialCorrespondencia.id">
								<vs-td>
									<img :src="historialCorrespondencia.correspondencia.ruta_imagen" alt="content-img" class="responsive card-img-top">
								</vs-td>	
								<vs-td v-text="historialCorrespondencia.correspondencia.descripcion" ></vs-td>
								<vs-td v-text="getDate(historialCorrespondencia.correspondencia.created_at)" ></vs-td>
								<!-- <vs-td>{{getDate(data[indextr].correspondencia.descripcion)}}</vs-td>					 -->
								<!-- <vs-td >{{getDate(data[indextr].created_at)}}</vs-td> -->
								<vs-td>
									<vs-switch color="success" v-model="historialCorrespondencia.estado" @click="abrirDialog(historialCorrespondencia.id, historialCorrespondencia.estado)">
										<span slot="on" >Activo</span>
										<span slot="off">Desactivo</span>
									</vs-switch>
								</vs-td>
							</vs-tr>
						</template>
						
					</vs-table>
				</vx-card>
				<div class="vx-col md:w-1/2 w-full mt-5">
  <router-link to="/apadrinamiento/apadrinamiento/"><vs-button class="w-full" icon-pack="feather" icon="icon-corner-up-left" icon-no-border>Regresar</vs-button></router-link>
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
	// traerNombres(tabla){
	// 	tabla.forEach(function(valor, indice, array){
    //   valor.nombress=valor.datos_nino[0].nombres
    //   valor.apellidoss=valor.datos_nino[0].apellidos
    //   valor.nombres = valor.datos_padrino[0].nombres
    //   valor.apellidos = valor.datos_padrino[0].apellidos
    //   this.nombres_nino = valor.nombress
    // this.apellidos_nino = valor.apellidoss
    // this.nombres_padrino = valor.nombres
    // this.apellidos_padrino = valor.apellidos           
    // }); 
    // console.log(tabla);
	// 	return tabla
    // },

	getDate(datetime) {
        let date = new Date(datetime);
        let dateString = `${date.getFullYear()}/${date.getMonth() + 1}/${date.getDate()}`;
        return dateString;
	},
	async index(page, search){ //async para que se llame cada vez que se necesite
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
            me.importarApadrinamiento(me.apadrinamiento_idT);
            me.correspondencia_idT = me.arrayData.correspondencia_id;
            console.log("historial");
            console.log(me.arrayData);
		})
		.catch(function (error) {
			console.log(error);
		});
		me.ya=true;
    },
    importarApadrinamiento(apadrinamiento){ //async para que se llame cada vez que se necesite
        let me = this;
        console.log("id apa");
        console.log(apadrinamiento);
        me.id_recibido = this.$route.params.id;
		axios.get(
			`/api/apadrinamiento/get?&criterio=id&buscar=${apadrinamiento}&completo=true`)
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
        // this.importarApadrinamiento();
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
