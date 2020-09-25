<template>
	<div>
		<vx-card>
			<formulariotutor v-on:cerrado="index(pagination.current_page, search);">></formulariotutor>
			<h5>Tabla bonita</h5>
					<div class = "demo-alignment">
						<h2>Tutores</h2>
						<vx-tooltip text = "Agregar nuevo registro"> <router-link to="/ingresar/tutor"> <vs-button radius type = "gradient" icon-pack = "feather" icon = "icon-user-plus" @click="aNuevo" color = "primary" size = 'large' ></vs-button> </router-link>  </vx-tooltip>
					</div>
					<br>
			<vs-table stripe max-items="5" :data="arrayData">

				<template slot="thead">
                    <vs-th>Ver</vs-th>
                    <vs-th>Nombres</vs-th>
                    <vs-th>Apellidos</vs-th>
					<vs-th>Especialidad</vs-th>
                    <vs-th>Teléfono</vs-th>
                    <vs-th>Estado</vs-th>
					<vs-th>Fecha de creación</vs-th>
					<vs-th>Fecha de actualización</vs-th>
					<vs-th></vs-th>
                    <vs-th></vs-th>
				</template>

				<template>
					<vs-tr v-for="tutor in arrayData" :key="tutor.id">
                        <vs-td>
						    <vx-tooltip text="Información Completa"> <vs-button color="dark" type="flat" icon="visibility" size="large"></vs-button></vx-tooltip>			
					    </vs-td>
						<vs-td v-text="tutor.datos.nombres" ></vs-td>
                        <vs-td v-text="tutor.datos.apellidos" ></vs-td>
                        <vs-td v-text="tutor.especialidad" ></vs-td>
                        <vs-td v-text="tutor.datos.numero_telefono" ></vs-td>
						<vs-td>
							<vs-switch color="success" v-model="tutor.estado" @click="abrirDialog(tutor.id, tutor.estado)">
								<span slot="on" >Activo</span>
								<span slot="off">Desactivo</span>
							</vs-switch>
						</vs-td>
						<vs-td v-text="tutor.created_at" ></vs-td>
						<vs-td v-text="tutor.updated_at" ></vs-td>
						<vs-td>
							<vx-tooltip text="Editar"> <vs-button  color="dark" type="flat" icon="edit" size="large"> </vs-button>  </vx-tooltip>
						</vs-td>
                        <vs-td>
							<vx-tooltip text="Listado de alumnos"> <vs-button  color="dark" type="flat" icon="list" size="large"> </vs-button>  </vx-tooltip>
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
import Formulariotutor from './formulariotutor.vue'
import axios from 'axios'

export default {
  data () {
    return {
      //Aqui van a guardar todas su variables.
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
      nombre: '',
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
    Formulariotutor
  },
  methods: {
	  muestra(){
		  console.log('Se ha cerrado el dialog')
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
			axios.put('/api/tutor/activar', {
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
			axios.put('/api/tutor/desactivar', {
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
          text:'La acción se realizó exitósamente'
		})
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
    },
	async index(page, search){ //async para que se llame cada vez que se necesite
		let me = this;
		const response = await axios.get(
			`/api/tutor/get?page=${page}&search=${search}&completo=true`)
		.then(function (response) {
			console.log(page)
			var respuesta= response.data;
			me.arrayData = respuesta.tutors.data;
			me.pagination= respuesta.pagination;
		})
		.catch(function (error) {
			console.log(error);
		});
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
