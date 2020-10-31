<template>
  <div>
    <vx-card>
		<Formulario v-on:cerrado="index();"></Formulario>
				<vs-divider position="right">PID&#174;</vs-divider>

		<vs-prompt title="Exportar a Excel" class="export-options" @cancle="clearFields" @accept="exportToExcel" accept-text="Exportar" cancel-text="Cancelar" @close="clearFields" :active.sync="activePrompt">
   
     
        <vs-input v-model="fileName" placeholder="Nombre de archivo" class="w-full" />
        <v-select v-model="selectedFormat" :options="formats" class="my-4" />
        <div class="flex">
			<span class="mr-4">Ancho automático de celda:</span>
			<vs-switch v-model="cellAutoWidth">Cell Auto Width</vs-switch>
        </div>
    </vs-prompt>
      <vs-table stripe title="Apadrinamientos" pagination max-items="7" search :data="arrayData" noDataText="No hay datos disponibles">
         <template slot="header">
          <vs-button @click="activePrompt=true">Exportar</vs-button>
        </template>
        <template slot="thead">
		  	    <vs-th>Nombre Niño</vs-th>
            <vs-th>Género Niño</vs-th>
            <vs-th>Nombre Padrino</vs-th>
			      <vs-th>Estado</vs-th>
            <vs-th>Acciones</vs-th>
        </template>

        <template slot-scope="{ data }">
          <vs-tr :data="tr" :key="indextr" v-for="(tr, indextr) in data">
            
            <vs-td>{{ data[indextr].datos_nino[0].nombres + " " +  data[indextr].datos_nino[0].apellidos}}</vs-td>
            <vs-td>
              {{
                data[indextr].datos_nino[0].genero == 1 ? 'Maculino' : 'Femenino'
              }}
              </vs-td>
            <vs-td>{{ data[indextr].datos_padrino[0].nombres + " " + data[indextr].datos_padrino[0].apellidos}}</vs-td>
              <vs-td :data="data[indextr].estado">
                <vs-switch
                  color="success"
                  v-model="data[indextr].estado"
                  @click="abrirDialog(data[indextr].id, data[indextr].estado)"
                >
                  <span slot="on">Activo</span>
                  <span slot="off">Desactivo</span>
                </vs-switch>
              </vs-td>
            <vs-td>
              <div class="flex items-center">
                <vx-tooltip text="Editar"> <vs-button @click="cambiar(data[indextr])" radius color="dark" type="flat" icon="edit" size="large"> </vs-button>  </vx-tooltip>
                <vx-tooltip text="Historial de Correspondencia"> <vs-button @click="$router.push('/apadrinamiento/correspondencia/'+data[indextr].id)" radius color="dark" type="flat" icon="mail" size="large" > </vs-button> </vx-tooltip>
              </div>
            </vs-td>
          </vs-tr>
        </template>
      </vs-table>
     <editar
			v-bind:identificador="abrir_editar"
			v-bind:id="id"
	  	v-bind:nino_id="nino_id"
			v-bind:padrino_id="padrino_id"
			v-on:cerrado="index();"
		></editar> -->
    </vx-card>
  </div>
</template>

   
<script>
import VueApexCharts from "vue-apexcharts";
import StatisticsCardLine from "@/components/statistics-cards/StatisticsCardLine.vue";
//import analyticsData from './ui-elements/card/analyticsData.js'
import ChangeTimeDurationDropdown from "@/components/ChangeTimeDurationDropdown.vue";
import VxTimeline from "@/components/timeline/VxTimeline";
import Formulario from './formularioapadrina.vue';
import editar from './apadrinamientoedit.vue';
import axios from "axios";
import vSelect from 'vue-select'
export default {
  data() {
    return {
      //Aqui van a guardar todas su variables.
      //rols: [],
     
      offset: 3,
      search: "",
      arrayData: [],
       fileName: '',
      formats:['xlsx', 'csv', 'txt'],
      cellAutoWidth: true,
	    selectedFormat: 'xlsx',
	    headerVal: ['id', 'nombress','apellidoss', 'nombres','apellidos', 'estado' ],
	    headerTitle: ['Id', 'Nombres Niño','Apellidos nino', 'Nombre Padrino', 'Apellido Padrino', 'Estado'],
      activePrompt: false,
      nombre: "",
      fecha: "",
      genero: "",
      switch2: false,
      nino_id:0,
      padrino_id:0,
      abrir_editar:false,
      id: 0,
      estado: null
    };
  },
  components: {
    VueApexCharts,
    StatisticsCardLine,
    ChangeTimeDurationDropdown,
    VxTimeline,
    Formulario,
    vSelect,
    editar
  },
  methods: {
    traerNombres(tabla){
		tabla.forEach(function(valor, indice, array){
      valor.nombress=valor.datos_nino[0].nombres
      valor.apellidoss=valor.datos_nino[0].apellidos
      valor.nombres = valor.datos_padrino[0].nombres
      valor.apellidos = valor.datos_padrino[0].apellidos
    }); 
    console.log(tabla);
		return tabla
    },

    cambiar(apadrinamiento){
		this.id = apadrinamiento.id;
		this.nino_id = apadrinamiento.nino_id;
		this.padrino_id = apadrinamiento.padrino_id;
		this.abrir_editar = true;
	},
    getDate(datetime) {
        let date = new Date(datetime);
        let dateString = `${date.getFullYear()}/${date.getMonth() + 1}/${date.getDate()}`;
        return dateString;
    },

    abrirDialog(id, estado) {
      let titulo = "";
      let color = "";
      if (estado === 0 || estado === false) {
        // cambiar de color al boton
        color = "success";
        titulo = "Confirmar activación";
      } else if (estado === 1 || estado === true) {
        color = "danger";
        titulo = "Confirmar desactivación";
      }
      this.id = id;
      this.estado = estado;
      this.$vs.dialog({
        type: "confirm",
        color: `${color}`,
        title: `${titulo}`,
        text: "¿Está seguro de llevar a cabo esta acción?",
        accept: this.cambiarEstado,
        cancel: this.close
      });
    },
    cambiarEstado(color) {
      let titulo = "";

      if (this.estado === 0 || this.estado === false) {
        titulo = "Activado exitósamente";
        axios
          .put("/api/apadrinamiento/activar", {
            id: this.id
          })
          .then(function(response) {
            console.log(response.data.message);
          })
          .catch(function(error) {
            console.log(error.response.data.message);
          });
      } else if (this.estado === 1 || this.estado === true) {
        titulo = "Desactivado exitósamente";
        axios
          .put("/api/apadrinamiento/desactivar", {
            id: this.id
          })
          .then(function(response) {
            console.log(response.data.message);
          })
          .catch(function(error) {
            console.log(error.response.data.message);
          });
      }

      this.$vs.notify({
        color: "success",
        title: `${titulo}`,
        text: "La acción se realizo exitósamente"
      });
    },
    close() {
      let titulo = "Cancelado";
      let texto = "Cambio de estado cancelado";
      this.$vs.notify({
        color: "danger",
        title: `${titulo}`,
        text: `${titulo}`
      });
      this.index();
    },
    async index() {
      //async para que se llame cada vez que se necesite
      let me = this;
      this.abrir_editar=false
      const response = await axios
        .get(`/api/apadrinamiento/get?completo=true`)
        .then(function(response) {
          var respuesta = response.data;
          me.arrayData = respuesta.apadrinamientos.data;
          me.padrino = me.traerNombres(me.arrayData)
          me.pagination = respuesta.pagination;
        })
        .catch(function(error) {
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

  },
  mounted() {
    this.index();
  }
};
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