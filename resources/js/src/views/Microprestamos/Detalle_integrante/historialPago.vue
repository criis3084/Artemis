<template>
 <vx-card>
    <div class = "demo-alignment">
      <div class="vx-col md:w-1/3 w-full mt-5">
          <vs-button @click="goBack" class="mr-4" type="border" radius icon-pack="feather" color="primary" icon="icon-corner-up-left"></vs-button>
      </div>
      <div class="flex-1 ">
          <h2> Historial de abonos</h2>
      </div>
    </div>
			<vs-divider position="right">PID&#174;</vs-divider>

	 <vs-prompt title="Exportar a Excel" class="export-options" @cancel="clearFields" @accept="exportToExcel" accept-text="Exportar" cancel-text="Cancelar" @close="clearFields" :active.sync="activePrompt">
        <vs-input v-model="fileName" placeholder="Nombre de archivo" class="w-full" />
        <v-select v-model="selectedFormat" :options="formats" class="my-4" />
        <div class="flex">
          <span class="mr-4">Ancho automatico de celda:</span>
          <vs-switch v-model="cellAutoWidth">Cell Auto Width</vs-switch>
        </div>
    </vs-prompt>
    <div class = "demo-alignment">
      <h4></h4>
    </div>
     <vs-table stripe title="Sectores" pagination max-items="7" search :data="arrayData" noDataText="No se han realizado abonos">
        <template slot="header">
          <vs-button @click="activePrompt=true">Exportar</vs-button>
        </template>
            <template slot="thead">
                <vs-th >No. Abono</vs-th>
                <vs-th >Descripción</vs-th>
                <vs-th >Cantidad de abono</vs-th>
				        <vs-th >Mora</vs-th>
                <vs-th >Cantidad restante</vs-th>
				        <vs-th >Fecha de pago</vs-th>
                <vs-th>Abono recibido por</vs-th>
                <vs-th >Estado</vs-th>
        </template>

            <template slot-scope="{data}">
                <vs-tr :data="tr" :key="indextr" v-for="(tr, indextr) in data">

                    <vs-td :data="data[indextr].id">
                        {{data[indextr].id}}
                    </vs-td>

                    <vs-td>
                        {{data[indextr].descripcion}}
                    </vs-td>

                    <vs-td >
                        {{currency(data[indextr].cantidad_abono)}}
                    </vs-td>
                    <vs-td >
                        {{currency(data[indextr].mora)}}
                    </vs-td>
                    <vs-td>
                        {{currency(data[indextr].cantidad_restante)}}
                    </vs-td>
                    <vs-td>
                        {{data[indextr].fecha_pago}}
                    </vs-td>
                    <vs-td>
                        {{data[indextr].user.nombres + ' '+ data[indextr].user.apellidos}}
                    </vs-td>

                    <vs-td :data="data[indextr].estado">
                        <vs-switch color="success" v-model="data[indextr].estado" @click="abrirDialog(data[indextr].id, data[indextr].estado)">
				                  <span slot="on" >Activo</span>
				                  <span slot="off">Desactivo</span>
			                  </vs-switch>
                    </vs-td>
					
                </vs-tr>
            </template>
        </vs-table>
    <vs-button @click="goBack" class="mr-4" type="gradient" icon-pack="feather" color="primary" icon="icon-corner-up-left"> Regresar</vs-button>

</vx-card>
</template>

<script>
import axios from 'axios'

export default {
  data () {
    return {
      arrayData:[],
      nombre:'',
      apellido:'',
      activePrompt: false,
	  fileName: '',
      formats:['xlsx', 'csv', 'txt'],
      cellAutoWidth: true,
	  selectedFormat: 'xlsx',
	  headerVal: ['id', 'cantidad_abono', 'cantidad_restante', 'descripcion', 'fecha_pago', 'mora'],
	  headerTitle: ['Id de abono', 'Cantidad de abono', 'Cantidad restante', 'Descripción', 'Fecha de pago', 'Mora']
    }
  },
  methods:{
    currency(numero) {
		const formatter = new Intl.NumberFormat('en-US', {
			style: 'currency',
			currency: 'GTQ'
		})
		const mil = formatter.format(numero)
		return mil
		},
    goBack () {
      this.$router.go(-1)
    },
    async index () {
      const me = this
      me.id_recibido = this.$route.params.id
      const response = await axios.get(
        `/api/abonoPrestamo/get?&criterio=detalle_integrante_id&buscar=${me.id_recibido}&completo=true`
      ).then(function (response) {
        const respuesta = response.data
        me.arrayData = respuesta.abonos.data
      })
        .catch(function (error) {
          console.log(error)
        })
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
  mounted () {
    this.index()
  }
}


</script>