<template>
	<vx-card>
		<formulariosector v-on:cerrado="index();"></formulariosector>
		<vs-prompt title="Exportar a Excel" class="export-options" @cancle="clearFields" @accept="exportToExcel" accept-text="Exportar" cancel-text="Cancelar" @close="clearFields" :active.sync="activePrompt">
			<vs-input v-model="fileName" placeholder="Nombre de archivo" class="w-full" />
			<v-select v-model="selectedFormat" :options="formats" class="my-4" />
			<div class="flex">
			<span class="mr-4">Ancho automatico de celda:</span>
			<vs-switch v-model="cellAutoWidth">Cell Auto Width</vs-switch>
			</div>
		</vs-prompt>
		<vs-table title="Sectores" pagination max-items="10" search :data="arrayData" noDataText="No hay datos disponibles">
			<template slot="header">
			<vs-button @click="activePrompt=true">Exportar</vs-button>
			</template>
				<template slot="thead">
					<vs-th >Id</vs-th>
					<vs-th >Nombre</vs-th>
					<vs-th >Aldea</vs-th>
					<vs-th >Estado</vs-th>
					<vs-th >Acciones</vs-th>
				</template>

				<template slot-scope="{data}">
					<vs-tr :data="tr" :key="indextr" v-for="(tr, indextr) in data">

						<vs-td :data="data[indextr].id">
							{{data[indextr].id}}
						</vs-td>

						<vs-td :data="data[indextr].nombre">
							{{data[indextr].nombre}}
						</vs-td>

						<vs-td :data="data[indextr].aldea_nombre">
							{{data[indextr].aldea_nombre}}
						</vs-td>

						<vs-td :data="data[indextr].estado">
							<vs-switch color="success" v-model="data[indextr].estado" @click="abrirDialog(data[indextr].id, data[indextr].estado)">
								<span slot="on" >Activo</span>
								<span slot="off">Desactivo</span>
							</vs-switch>
						</vs-td>
						<vs-td>
							<vx-tooltip text="Editar"> <vs-button @click="cambiar(data[indextr])" radius color="dark" type="flat" icon="edit" size="large"> </vs-button>  </vx-tooltip>
						</vs-td>
					</vs-tr>
				</template>
			</vs-table>

			<sectorEdit
				v-bind:identificador="abrir_editar"
				v-bind:id="id"
				v-bind:nombre="nombre"
				v-bind:aldea_id="aldea_id"
				v-on:cerrado="index();"
			></sectorEdit>
	</vx-card>
</template>



<script>
import VueApexCharts from 'vue-apexcharts'
import sectorEdit from './sector_edit.vue'
import StatisticsCardLine from '@/components/statistics-cards/StatisticsCardLine.vue'
//import analyticsData from './ui-elements/card/analyticsData.js'
import ChangeTimeDurationDropdown from '@/components/ChangeTimeDurationDropdown.vue'
import VxTimeline from '@/components/timeline/VxTimeline'
import Formulariosector from './formulariosector.vue'
import vSelect from 'vue-select'
import axios from 'axios'


export default {
	data () {
		return {
			//Aqui van a guardar todas su variables.
			search : '',
			arrayData: [],
			id: 0,
			aldea_id:0,
			nombre:'',
			estado: null,
			abrir_editar:false,
			fileName: '',
			formats:['xlsx', 'csv', 'txt'],
			cellAutoWidth: true,
			selectedFormat: 'xlsx',
			headerVal: ['id', 'nombre', 'aldea_nombre','estado'],
			headerTitle: ['Id', 'Nombre', 'Aldea', 'Estado'],
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
		Formulariosector,
		vSelect,
		sectorEdit    
	},
	methods: {
		traerNombre(tabla){
			tabla.forEach(function(valor, indice, array){
				valor.aldea_nombre=valor.aldea.nombre
			}); 
			return tabla
		},
		cambiar(sector){
				this.id = sector.id;
				this.nombre = sector.nombre;
				this.aldea_id = sector.aldea_id;
				this.abrir_editar = true;
		},
		getDate(datetime) {
			let date = new Date(datetime);
			let dateString = `${date.getFullYear()}/${date.getMonth() + 1}/${date.getDate()}`;
			return dateString;
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
				axios.put('/api/sector/activar', {
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
				axios.put('/api/sector/desactivar', {
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
		close(){
			let titulo = "Cancelado"
			let texto = "Cambio de estado cancelado"
			this.$vs.notify({
			color:'danger',
			title:`${titulo}`,
			text:`${titulo}`
			})
		this.index();
		},
		async index(){
			let me = this;
			this.abrir_editar=false
			const response = await axios.get(`/api/sector/get?completo=true`)
			.then(function (response) {
				var respuesta= response.data;
				me.arrayData = respuesta.sectores.data;
				me.arrayData = me.traerNombre(me.arrayData)
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
			return v[j]
			}))
		},
		clearFields () {
			this.filename = ''
			this.cellAutoWidth = true
			this.selectedFormat = 'xlsx'
		}
	},
  	mounted(){
    	this.index();
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