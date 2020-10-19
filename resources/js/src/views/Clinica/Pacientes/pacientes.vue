<template>
	<div>
		<vx-card>
					<div class = "demo-alignment">
						<h2>Pacientes</h2>
						<vx-tooltip text = "Agregar nuevo registro"> <vs-button radius type = "gradient" icon-pack = "feather" icon = "icon-user-plus" @click="aNuevo" color = "primary" size = "large" ></vs-button>  </vx-tooltip>
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

			<vs-table title="Pacientes" pagination max-items="7" search :data="arrayData">
	   <template slot="header">
          <vs-button @click="activePrompt=true">Exportar</vs-button>
        </template>
				<template slot="thead">
                    <vs-th>Ver</vs-th>
                    <vs-th>Nombres</vs-th>
                    <vs-th>Apellidos</vs-th>
                    <vs-th>Teléfono</vs-th>
                    <vs-th>Tipo de Paciente</vs-th>
                    <vs-th>Día Apoyo</vs-th>
                    <vs-th>Estado de Apoyo</vs-th>
                    <vs-th>Estado</vs-th>
					<vs-th>Acciones</vs-th>
				</template>

				<template slot-scope="{data}">
					<vs-tr :data="tr" :key="indextr" v-for="(tr, indextr) in data">
                        <vs-td>
						    <vx-tooltip text="Información Completa"> <vs-button radius color="dark" type="flat" icon="visibility" size="large" @click="$router.push('/ver/constructor/'+data[indextr].id)"></vs-button></vx-tooltip>			
					    </vs-td>
						<vs-td>{{data[indextr].datos.nombres}}</vs-td>
		            	<vs-td>{{data[indextr].datos.apellidos}}</vs-td>
                        <vs-td>{{data[indextr].datos.numero_telefono}}</vs-td>
                        <vs-td>{{data[indextr].tipo_paciente.nombre}}</vs-td>
                        <vs-td>{{data[indextr].dia_apoyo}}</vs-td>
                        <vs-td>
							<vs-chip class="ag-grid-cell-chip" :color="data[indextr].beneficio.estado == 0 ? 'warning' : data[indextr].beneficio.estado == 1 ? 'success': data[indextr].beneficio.estado == 2 ? 'danger' : 'dark'">
							<span>{{data[indextr].beneficio.estado}}</span>
							</vs-chip>
						</vs-td>
						<vs-td>
							<vs-switch color="success" v-model="data[indextr].estado" @click="abrirDialog(data[indextr].id, data[indextr].estado)">
								<span slot="on" >Activo</span>
								<span slot="off">Desactivo</span>
							</vs-switch>
						</vs-td>
						<vs-td>
							<div class="flex items-center">
							<vx-tooltip text="Editar"> <vs-button radius color="dark" type="flat" icon="edit" size="large" @click="$router.push('/editar/paciente/'+data[indextr].id)"> </vs-button>  </vx-tooltip>
							<vx-tooltip text="Listado de pacientes"> <vs-button radius color="dark" type="flat" icon="list" size="large" @click="$router.push('/ver/beneficios/'+data[indextr].id)"> </vs-button>  </vx-tooltip>
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
import vSelect from 'vue-select'
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
	  estadoBeneficios: [],
	  listaBeneficiosxMes:[],
      nombre: '',
	  switch2:false,
	  id: 0,
	  estado: null,
	  activePrompt: false,
	  abrirListado: false,
	  fileName: '',
	  listadoConstrucciones:[],
      formats:['xlsx', 'csv', 'txt'],
      cellAutoWidth: true,
	  selectedFormat: 'xlsx',
	  headerVal: ['id','dia_apoyo', 'nombres', 'apellidos', 'numero_telefono','nombre'],
	  headerTitle: ['Id','Día Apoyo', 'Nombre', 'Apellidos', 'Telefono','Tipo Paciente']
    }
  },
  components: {
    VueApexCharts,
    StatisticsCardLine,
    ChangeTimeDurationDropdown,
    VxTimeline,
    vSelect
  },
  methods: {
    openAlert(color,constructor){
		this.listado(constructor)
	},
	getDate(datetime){
		const date = new Date(datetime)
		const dateString = `${date.getFullYear()}-${date.getMonth() + 1}`
		return dateString
	},
	aDate(fechaS){
		const fechaDate = new Date(parseInt(fechaS.split('-',3)[0]),parseInt(fechaS.split('-',3)[1]),parseInt(fechaS.split('-',3)[2]))
		fechaDate=fechaDate.setMonth(fechaDate.getMonth()+1)
		return fechaDate
	},
	traerBeneficios(pacientes){
		const today = new Date()
		const todaySin = this.getDate(today)
		let m2=this
		axios.get(
			`/api/beneficio/get?completo=fecha&buscar=${todaySin}`)
			.then(function (response) {
				const respuesta = response.data
				m2.listaBeneficiosxMes=respuesta.beneficios.data
				m2.mesActual(pacientes,m2.listaBeneficiosxMes)
			})
			.catch(function (error) {
				console.log(error)
			})
	},
	mesActual(pacientes,beneficios){
		console.log('buscando a los pacientes con su beneficio')
		let encontrado=''
		console.log(beneficios)
		let diaEntrega=0
		const today = new Date()
		console.log('dia de hoy')
		let diadeHoy =today.getDate()
		console.log(diadeHoy)
		beneficios.forEach(function (elemento, indice, array) {
			encontrado = pacientes.find(element => element.id === elemento.paciente_id)
			console.log(encontrado.id)
			if (encontrado !== undefined) {
				pacientes.map(function(paciente){
					if(paciente.id == encontrado.id){
						if (elemento.estado !=1){
							if(paciente.dia_apoyo < diadeHoy){
								elemento.estado = 2
							}
						}
						paciente.beneficio = elemento;
					}
				})
			}
		})
		encontrado = pacientes.find(element => element.id === 485)
		console.log('encontrado al 485')
		console.log(encontrado)
		/*
		const today = new Date()
		const todaySin = this.getDate(today)
		console.log(' a veeeeer?')
*/
	},
    abrirDialog (id, estado) {
		let titulo = ''
		let color = ''

		if (estado === 0 || estado === false) {
			// cambiar de color al boton
			color = 'success'
			titulo = 'Confirmar activación'
		} else if (estado === 1 || estado === true) {
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
    cambiarEstado (color) {
		let titulo = ''
		
		if (this.estado === 0 || this.estado === false) {
		titulo = 'Activado exitósamente'
		axios.put('/api/paciente/activar', {
			id: this.id
		})
			.then(function (response) {
			console.log(response.data.message)
			})
			.catch(function (error) {
			console.log(error.response.data.message)
			})
		} else if (this.estado === 1 || this.estado === true) {
			titulo = 'Desactivado exitósamente'
			axios.put('/api/paciente/desactivar', {
			id: this.id
		})
		.then(function (response) {
			console.log(response.data.message)
			})
		.catch(function (error) {
			console.log(error.response.data.message)
			})
		}
		this.$vs.notify({
			color:'success',
			title:`${titulo}`,
			text:'La acción se realizó exitósamente'
		})
    },
    close () {
      	const titulo = 'Cancelado'
      	const texto = 'Cambio de estado cancelado'
		this.$vs.notify({
			color:'danger',
			title:`${titulo}`,
			text:`${titulo}`
		})
		this.index()
    },
    async index () { //async para que se llame cada vez que se necesite
		const me = this
		const response = await axios.get(
		`/api/paciente/get?completo=true`)
		.then(function (response) {
			const respuesta = response.data
			me.arrayData = respuesta.pacientes.data
			me.paciente = me.traerNombre(me.arrayData)
    		me.traerBeneficios(me.paciente)

		})
		.catch(function (error) {
			console.log(error)
		})
    },
    aNuevo () {
		 this.$router.push('/ingresar/paciente')
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
			valor.numero_telefono = valor.datos.numero_telefono
			valor.beneficio={estado:3}
		}) 
		return tabla
	},
	traerDatos(tabla){
		tabla.forEach(function(valor, indice, array){
			valor.tipo_paciente=valor.tipo_paciente.nombre
			
		}); 
		return tabla
	},
	
	  
  },
  mounted () {
    this.index()
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
