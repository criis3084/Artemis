<template>
			<div>
				<vx-card>
					<div class = "demo-alignment">
						<h2>Niños Apadrinados</h2>
					<!--	<vx-tooltip text = "Agregar nuevo registro"> <router-link to="/ingresar/nino"> <vs-button radius type = "gradient" icon-pack = "feather" icon = "icon-user-plus" color = "primary" size = 'large' ></vs-button> </router-link>  </vx-tooltip>
					-->
					</div>
					<br>
					<vs-prompt title="Exportar a Excel" class="export-options" @cancle="clearFields" @accept="exportToExcel" accept-text="Exportar" cancel-text="Cancelar" @close="clearFields" :active.sync="activePrompt">
        				<vs-input v-model="fileName" placeholder="Nombre de archivo" class="w-full" />
        				<v-select v-model="selectedFormat" :options="formats" class="my-4" />
        				<div class="flex">
          					<span class="mr-4">Ancho automatico de celda:</span>
          					<vs-switch v-model="cellAutoWidth">Cell Auto Width</vs-switch>
        				</div>
    				</vs-prompt>
					<vs-table title="Padrinos" pagination max-items="7" search :data="arrayData" noDataText="No hay datos disponibles">
        				<template slot="header">
							<vs-button @click="activePrompt=true">Exportar</vs-button>
        				</template>
						<template slot="thead">
							<vs-th>Ver</vs-th>
							<vs-th>Código</vs-th>
							<vs-th>Nombres</vs-th>
							<vs-th>Apelidos</vs-th>
							<vs-th>Género</vs-th>
							<vs-th>Fecha de Nacimiento</vs-th>
							<vs-th>Fecha de Ingreso</vs-th>
							<vs-th>Acciones</vs-th>
						</template>
						<template slot-scope="{data}">
                			<vs-tr :data="tr" :key="indextr" v-for="(tr, indextr) in data">
								<vs-td>
									<vx-tooltip text="Información Completa"> <vs-button radius color="dark" type="flat" icon="visibility" size="large"  @click="$router.push('/ver/nino/'+data[indextr].id)" ></vs-button></vx-tooltip>
								</vs-td>
		    					<!--
								<router-link :to="url" @click.stop.prevent class="text-inherit hover:text-primary">{{ params.value }}</router-link>
								-->
								<vs-td>{{data[indextr].codigo}}</vs-td>
								<vs-td>
									<div class="flex items-center">
										<vs-avatar :src="data[indextr].ruta_imagen" color="primary" :text="data[indextr].nombres" class="flex-shrink-0 mr-2" size="30px"/>
										{{data[indextr].datos.nombres}}
									</div>
								</vs-td>
								<!-- <vs-td>{{data[indextr].datos.nombres}}</vs-td> -->
								<vs-td>{{data[indextr].datos.apellidos}}</vs-td>
								<vs-td>{{data[indextr].datos.genero== 1 ? 'Masculino' : 'Femenino'}}</vs-td>
								<vs-td>{{data[indextr].datos.fecha_nacimiento}}</vs-td>
								<vs-td>{{data[indextr].fecha_ingreso}}</vs-td>
								<vs-td>
									  <div class="flex items-center">
										<vx-tooltip text="Editar"><vs-button @click="$router.push('/editar/nino/'+data[indextr].id)" radius color="dark" type="flat" icon="edit" size="large">  </vs-button>  </vx-tooltip>
										<vx-tooltip text="Historial de PPI">  <vs-button @click="$router.push('/apadrinamiento/ppi/'+data[indextr].id)" radius color="dark" type="flat" icon="poll" size="large"> </vs-button></vx-tooltip>
										<vx-tooltip text="Historial de Fotografias"> <vs-button @click="$router.push('/apadrinamiento/fotografia/'+data[indextr].id)" radius color="dark" type="flat" icon="camera_alt" size="large" > </vs-button> </vx-tooltip>
									  	<vx-tooltip text="Estudio Socioeconómico"> <vs-button @click="$router.push('/apadrinamiento/estudiosocio/'+data[indextr].id)" radius color="dark" type="flat" icon="assignment" size="large" > </vs-button> </vx-tooltip>
									  </div>
								</vs-td>
							</vs-tr>
						</template>
					</vs-table>
				</vx-card>
			</div>
</template>


<script>

import VueApexCharts from 'vue-apexcharts'
import StatisticsCardLine from '@/components/statistics-cards/StatisticsCardLine.vue'
//import analyticsData from './ui-elements/card/analyticsData.js'
import ChangeTimeDurationDropdown from '@/components/ChangeTimeDurationDropdown.vue'
import VxTimeline from '@/components/timeline/VxTimeline'
import Formulario from './formulario.vue'
import EditNino from './nino/editNino.vue'
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
      nombre: '',
	  switch2:false,
	  estado: null,
	  abrir_editar:false,
		id:'',
		nombres:'',
		apellidos:'',
		genero:'',
		codigo:'',
		fecha_ingreso:'',
		fecha_nacimiento:'',
		direccion:'',
		ruta_imagen:'',
	    imagenProfile:'https://img.pngio.com/profile-icon-png-image-free-download-searchpngcom-profile-icon-png-673_673.png',
	  fileName: '',
      formats:['xlsx', 'csv', 'txt'],
      cellAutoWidth: true,
	  selectedFormat: 'xlsx',
	  headerVal: ['id', 'nombres', 'apellidos', 'fecha_nacimiento', 'fecha_ingreso', 'estado'],
	  headerTitle: ['Id', 'Nombre', 'Apellidos', 'Fecha de nacimiento', 'Fecha de ingreso', 'Estado'],
      activePrompt: false,
      'selected': [],
      'tableList': [
        'vs-th: Component',
        'vs-tr: Component',
        'vs-td: Component',
        'thread: Slot',
        'tbody: Slot',
        'header: Slot'
      ]
	}
  },
  components: {
    VueApexCharts,
    StatisticsCardLine,
    ChangeTimeDurationDropdown,
    VxTimeline,
    Formulario,
    EditNino
  },
  methods: {
	  cambiar(Nino){
		  this.id = Nino.id;
		  this.nombres = Nino.datos.nombres;
		  this.apellidos = Nino.datos.apellidos;
		  this.genero = Nino.datos.genero;
		  this.codigo = Nino.codigo;
		  this.fecha_ingreso = Nino.fecha_ingreso;
		  this.fecha_nacimiento = Nino.datos.fecha_nacimiento;
		  this.direccion = Nino.datos.direccion;
		  this.ruta_imagen = Nino.ruta_imagen;
		  this.abrir_editar = true;
	  },
	  aNuevo(){
		 this.$router("/ingresar/nino");
	  },
	  aEditar(){
		 this.$router.push("/apps/user/user-edit/");
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
		});
		this.index();
	},
	cambiarEstado(color){
		let titulo = ''
		console.log(this.id)
		if(this.estado === 0 || this.estado === false){
			titulo = 'Activado exitósamente'
			axios.put('/api/nino/activar', {
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
			axios.put('/api/nino/desactivar', {
				id: this.id
			})
			.then(function (response) {co
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
		});
		this.index();
	},
	async index(){ //async para que se llame cada vez que se necesite
		let me = this;
		this.abrir_editar=false
		const response = await axios.get(
			`/api/nino/get?completo=false`)
		.then(function (response) {
			var respuesta= response.data;
			me.arrayData = respuesta.ninos.data;
			me.nino = me.traerNombre(me.arrayData)
		})
		.catch(function (error) {
			console.log(error);
		});
	},
	exportToExcel () {
      import('@/vendor/Export2Excel').then(excel => {
		const list = this.arrayData
        const data = this.formatJson(this.headerVal, list)
        excel.export_json_to_excel({
          header: this.headerTitle,
          data,
          filename: this.fileName,
          autoWidth: this.cellAutoWidth,
          bookType: this.selectedFormat
		})

        this.clearFields()
      })
    },
    formatJson (filterVal, jsonData) {
      return jsonData.map(v => filterVal.map(j => {
        // Add col name which needs to be translated
        // if (j === 'timestamp') {
        //   return parseTime(v[j])
        // } else {
        //   return v[j]
        // }

        return v[j]
      }))
    },
	clearFields () {
      this.filename = ''
      this.cellAutoWidth = true
      this.selectedFormat = 'xlsx'
	},
	traerNombre (tabla) {
      tabla.forEach(function (valor, indice, array) {
	  valor.nombres = valor.datos.nombres
	  valor.apellidos = valor.datos.apellidos
	  valor.fecha_nacimiento = valor.datos.fecha_nacimiento
      }) 
	  return tabla
    }
  },
  mounted(){

    this.index();
  },
  computed:{

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
