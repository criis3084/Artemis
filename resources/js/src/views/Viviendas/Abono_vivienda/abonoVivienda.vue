<template>
			  <div>
          <vx-card>
                <div class = "demo-alignment">
                  <div class="vx-col md:w-1/3 w-full mt-5">
                    <router-link to="/vivienda/vivienda"><vs-button class="w-full" icon-pack="feather" icon="icon-corner-up-left" type="border" radius icon-no-border></vs-button></router-link>
                  </div>
						        <h2> Historial de abonos</h2>
						        <vx-tooltip text = "Agregar nuevo abono"> 
                      <!-- <vs-button @click="$router.push('/abonar/vivienda/'+id_recibido)" radius type="gradient" icon="account_balance_wallet" color = "primary" size = "large"> </vs-button>  -->
                    </vx-tooltip>
				        </div>
			<vs-divider position="right">PID&#174;</vs-divider>
                <div class = "demo-alignment">
                    <h5> <b>Nombre del propietario: </b> </h5><h5>{{nombre}}</h5><h5>{{apellido}}</h5>
                </div>
                <div class = "demo-alignment">
                    <h5> <b>Dirección: </b> </h5><h5>{{direccion}}</h5>
                </div>
                <div class = "demo-alignment">
                    <h5> <b>Costo total: </b> </h5><h5>{{currency(costo_total)}}</h5>
                </div><br>
        

        	<vs-prompt title="Exportar a Excel" class="export-options" @cancle="clearFields" @accept="exportToExcel" accept-text="Exportar" cancel-text="Cancelar" @close="clearFields" :active.sync="activePrompt">
   
     
        <vs-input v-model="fileName" placeholder="Nombre de archivo" class="w-full" />
        <v-select v-model="selectedFormat" :options="formats" class="my-4" />
        <div class="flex">
			<span class="mr-4">Ancho automático de celda:</span>
			<vs-switch v-model="cellAutoWidth">Cell Auto Width</vs-switch>
        </div>
    </vs-prompt>

          <vs-table stripe pagination max-items="7" search :data="arrayHistorial" noDataText="No se han realizado abonos">
					
          
          	<template slot="header">
          <vs-button @click="activePrompt=true">Exportar</vs-button>
            </template>
            <template slot="thead">
							<vs-th>Fecha</vs-th>
							<vs-th>Monto abono</vs-th>
							<vs-th>Resto de deuda</vs-th>
              <vs-th>Descripción</vs-th>
							<vs-th>Estado</vs-th>
						</template>

						<template slot-scope="{data}">
							<vs-tr :data="tr" :key="indextr" v-for="(tr, indextr) in data" >							
								<vs-td >{{data[indextr].abono.fecha_pago}}</vs-td>
								<vs-td>{{currency(data[indextr].abono.cantidad_abono)}}</vs-td>
                <vs-td>{{currency(data[indextr].abono.cantidad_restante)}}</vs-td>
                <vs-td>{{data[indextr].abono.descripcion}}</vs-td>
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
  <router-link to="/vivienda/vivienda"><vs-button type="gradient" class="w-full" icon-pack="feather" icon="icon-corner-up-left" icon-no-border>Regresar</vs-button></router-link>
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
      arrayHistorial:[],
      direccion: '',
      nombre: '',
      apellido: '',
      costo_total:'',
      id:'',
	  switch2:false,
	  id: 0,
	  id_recibido:0,
      estado: null,
      url:'https://pbs.twimg.com/profile_images/1305883698471018496/_4BfrCaP.jpg',

      fileName: '',
      formats:['xlsx', 'csv', 'txt'],
      cellAutoWidth: true,
	    selectedFormat: 'xlsx',
	    headerVal: ['id', 'cantidad_abono', 'cantidad_restante', 'descripcion', 'fecha_pago'],
	    headerTitle: ['Id de abono', 'Cantidad de abono', 'Deuda pendiente', 'Descripción', 'Fecha de pago'],
      activePrompt: false
    }
  },
  components: {
    VueApexCharts,
    StatisticsCardLine,
    ChangeTimeDurationDropdown,
    VxTimeline
  },
  methods: {
    getDate (datetime) {
      const date = new Date(datetime)
      const dateString = `${date.getFullYear()}/${date.getMonth() + 1}/${date.getDate()}`
      return dateString
    },
    currency (numero) {
      const formatter = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'GTQ'
      })
      const mil = formatter.format(numero)
      return mil
    },
    async index () { //async para que se llame cada vez que se necesite
      const me = this
      this.id_recibido = this.$route.params.id
      const response = await axios.get(
        `/api/historialAbonoVivienda/get?&criterio=vivienda_id&buscar=${me.id_recibido}&completo=true`)
        .then(function (response) {
          const respuesta = response.data
          me.arrayHistorial = respuesta.historialAbonoViviendas.data
          me.datos = me.traerDatos(me.arrayHistorial)
        })
        .catch(function (error) {
          console.log(error)
        })
    },
    async index2 () { //async para que se llame cada vez que se necesite
      const me = this
      this.id_recibido = this.$route.params.id
      const response = await axios.get(
        `/api/vivienda/get?&criterio=id&buscar=${this.id_recibido}&completo=true`)
        .then(function (response) {
          const respuesta = response.data
          me.arrayData = respuesta.viviendas.data
          me.id = respuesta.viviendas.data[0].datos_residente[0].id
          me.nombre = respuesta.viviendas.data[0].datos_residente[0].nombres
          me.apellido = respuesta.viviendas.data[0].datos_residente[0].apellidos
          me.direccion = respuesta.viviendas.data[0].direccion
          me.costo_total = respuesta.viviendas.data[0].costo_total
        })
        .catch(function (error) {
          console.log(error)
        })
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
        acceptText: 'Aceptar',
        cancelText: 'Cancelar'
      })
    

      this.index()
    },
    cambiarEstado (color) {
      let titulo = ''
		
      if (this.estado === 0 || this.estado === false) {
        titulo = 'Activado exitósamente'
        axios.put('/api/historialAbonoVivienda/activar', {
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
        axios.put('/api/historialAbonoVivienda/desactivar', {
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
        text:'La acción se realizo exitósamente'
      })
      this.index()
    },
    exportToExcel () {
      import('@/vendor/Export2Excel').then(excel => {
        const list = this.arrayHistorial
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
    },
    	traerDatos (tabla) {
      tabla.forEach(function (valor, indice, array) {
        valor.id = valor.abono.id
        valor.cantidad_abono = valor.abono.cantidad_abono
        valor.descripcion = valor.abono.descripcion
        valor.fecha_pago = valor.abono.fecha_pago
        valor.cantidad_restante = valor.abono.cantidad_restante
      })
      return tabla
    }
  },
  mounted () {
    this.index()
    this.index2()
  },
  computed:{

  }
}
</script>

<style lang="scss">
/*! rtl:begin:ignore */
#dashboard-analytics {
  .greet-user {
    position: relative;

    .decore-left {
      position: absolute;
      left: 0;
      top: 0;
    }
    .decore-right {
      position: absolute;
      right: 0;
      top: 0;
    }
  }

  @media (max-width: 576px) {
    .decore-left,
    .decore-right {
      width: 140px;
    }
  }
}
/*! rtl:end:ignore */
</style>