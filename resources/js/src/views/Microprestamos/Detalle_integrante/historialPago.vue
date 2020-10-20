<template>
 <vx-card>
	 <vs-prompt title="Exportar a Excel" class="export-options" @cancel="clearFields" @accept="exportToExcel" accept-text="Exportar" cancel-text="Cancelar" @close="clearFields" :active.sync="activePrompt">
        <vs-input v-model="fileName" placeholder="Nombre de archivo" class="w-full" />
        <v-select v-model="selectedFormat" :options="formats" class="my-4" />
        <div class="flex">
          <span class="mr-4">Ancho automatico de celda:</span>
          <vs-switch v-model="cellAutoWidth">Cell Auto Width</vs-switch>
        </div>
    </vs-prompt>
     <vs-table title="Sectores" pagination max-items="7" search :data="arrayData" noDataText="No hay datos disponibles" >
        <template slot="header">
          <vs-button @click="activePrompt=true">Exportar</vs-button>
        </template>
            <template slot="thead">
                <vs-th >No. Abono</vs-th>
                <vs-th >Descripción</vs-th>
                <vs-th >Cantidad de Abono</vs-th>
				        <vs-th >Mora</vs-th>
                <vs-th >Cantidad Restante</vs-th>
				        <vs-th >Fecha Pago</vs-th>
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
                        {{data[indextr].cantidad_abono}}
                    </vs-td>
                    <vs-td >
                        {{data[indextr].mora}}
                    </vs-td>
                    <vs-td>
                        {{data[indextr].cantidad_restante}}
                    </vs-td>
                    <vs-td>
                        {{data[indextr].fecha_pago}}
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
    

</vx-card>
</template>

<script>
import axios from 'axios'

export default {
  data () {
    return {
      arrayData:[],
      activePrompt: false,
	  fileName: '',
      formats:['xlsx', 'csv', 'txt'],
      cellAutoWidth: true,
	  selectedFormat: 'xlsx',
	  headerVal: ['id', 'nombre', 'direccion', 'estado'],
	  headerTitle: ['Id', 'Nombre', 'Direccion', 'Estado']
    }
  },
  methods:{
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
    }
  },
  mounted () {
    this.index()
  }
}


</script>