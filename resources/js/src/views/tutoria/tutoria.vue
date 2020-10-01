<template>
  <div>
    <vx-card>
		<formulariotutoria v-on:cerrado="index(pagination.current_page, search);"></formulariotutoria>
		<vs-prompt title="Exportar a Excel" class="export-options" @cancle="clearFields" @accept="exportToExcel" accept-text="Exportar" cancel-text="Cancelar" @close="clearFields" :active.sync="activePrompt">
   
     
        <vs-input v-model="fileName" placeholder="Nombre de archivo" class="w-full" />
        <v-select v-model="selectedFormat" :options="formats" class="my-4" />
        <div class="flex">
			<span class="mr-4">Ancho automatico de celda:</span>
			<vs-switch v-model="cellAutoWidth">Cell Auto Width</vs-switch>
        </div>
    </vs-prompt>
      <vs-table pagination max-items="10" search :data="arrayData">
         <template slot="header">
          <vs-button @click="activePrompt=true">Exportar</vs-button>
        </template>
        <template slot="thead">
          <vs-th>Razón tutoría</vs-th>
          <vs-th>Nombres Niño</vs-th>
          <vs-th>Apellidos Niño</vs-th>
          <vs-th>Género Niño</vs-th>
          <vs-th>Nombres Tutor</vs-th>
          <vs-th>Apellidos Tutor</vs-th>
          <vs-th>Fecha</vs-th>
          <vs-th>Estado</vs-th>
          <vs-th>Acciones</vs-th>
        </template>

        <template slot-scope="{ data }">
          <vs-tr :data="tr" :key="indextr" v-for="(tr, indextr) in data">
            <vs-td>{{ data[indextr].nombre }}</vs-td>
            <vs-td>{{ data[indextr].datos_nino[0].nombres }}</vs-td>
            <vs-td>{{ data[indextr].datos_nino[0].apellidos }}</vs-td>
            <vs-td>
              {{
                data[indextr].datos_nino[0].genero == 1
                  ? "Masculino"
                  : "Femenino"
              }}</vs-td
            >
            <vs-td>{{ data[indextr].datos_tutor[0].nombres }}</vs-td>
            <vs-td>{{ data[indextr].datos_tutor[0].apellidos }}</vs-td>
            <vs-td>{{ data[indextr].fecha }}</vs-td>
            <vs-td>
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
              
            </vs-td>
            	<vx-tooltip text="Editar"> <vs-button @click="cambiar(data[indextr])" radius color="dark" type="flat" icon="edit" size="large"> </vs-button>  </vx-tooltip>	
            <vs-td>
            </vs-td>
          </vs-tr>
        </template>
      </vs-table>
     		<turoriaEdit
			v-bind:identificador="abrir_editar"
			v-bind:id="id"
			v-bind:nombre="nombre"
      v-bind:fecha="fecha"
			v-on:cerrado="index(1,'');"
		></turoriaEdit>
    </vx-card>
  </div>
</template>

   
<script>
import VueApexCharts from "vue-apexcharts";
import StatisticsCardLine from "@/components/statistics-cards/StatisticsCardLine.vue";
//import analyticsData from './ui-elements/card/analyticsData.js'
import ChangeTimeDurationDropdown from "@/components/ChangeTimeDurationDropdown.vue";
import VxTimeline from "@/components/timeline/VxTimeline";
import Formulariotutoria from "./formulariotutoria.vue";
import tutoriaEdit from "./tutoriaEdit.vue";
import axios from "axios";
import vSelect from 'vue-select'
export default {
  data() {
    return {
      //Aqui van a guardar todas su variables.
      //rols: [],
      pagination: {
        total: 0,
        current_page: 0,
        per_page: 0,
        last_page: 0,
        from: 0,
        to: 0
      },
      offset: 3,
      search: "",
      arrayData: [],
       fileName: '',
      formats:['xlsx', 'csv', 'txt'],
      cellAutoWidth: true,
	    selectedFormat: 'xlsx',
	    headerVal: ['id', 'nombres', 'fecha', 'nino.id','tutor.id', 'estado' ],
	    headerTitle: ['Id', 'Nombre', 'Fecha', 'Id Niño', 'Id tutor', 'Estado'],
      activePrompt: false,
      nombre: "",
      fecha: "",
      switch2: false,
      nino_id:0,
      tutor_id:0,
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
    Formulariotutoria,
    vSelect,
    tutoriaEdit,
  },
  methods: {
    traerNombre(tabla){
		tabla.forEach(function(valor, indice, array){
			valor.nombres=valor.datos_tutor[0].nombres
		}); 
		return tabla
	  },
    async index2(page, search) {
      //async para que se llame cada vez que se necesite
      let me = this;
      const response = await axios
        .get(`/api/nino/get?completo=false`)
        .then(function(response) {
          var respuesta = response.data;
		  me.nino = respuesta.ninos.data;
		  me.nino = me.traerNombre(me.nino)
		  me.pagination = respuesta.pagination;
        })

        .catch(function(error) {
          console.log(error);
        });
    },
    async index3(page, search) {
      //async para que se llame cada vez que se necesite
      let me = this;
      const response = await axios
        .get(`/api/tutor/get?completo=false`)
        .then(function(response) {
          var respuesta = response.data;
		  me.tutor = respuesta.tutors.data;
		  me.tutor = me.traerNombre(me.tutor)
		  me.pagination = respuesta.pagination;
        })
        .catch(function(error) {
          console.log(error);
        });
    },

    cambiar(tutoria){
		this.id = tutoria.id;
		this.nombre = tutoria.nombre;
		this.fecha = tutoria.fecha;
		this.nino_id = tutoria.nino_id;
		this.tutor_id = tutoria.tutor_id;
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
          .put("/api/tutoria/activar", {
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
          .put("/api/tutoria/desactivar", {
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
      this.index(this.pagination.current_page, this.search);
    },
    async index(page, search) {
      //async para que se llame cada vez que se necesite
      let me = this;
      this.abrir_editar=false
      const response = await axios
        .get(`/api/tutoria/get?completo=true`)
        .then(function(response) {
          var respuesta = response.data;
          me.arrayData = respuesta.tutorias.data;
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


    guardar() {
      axios
        .post("/api/tutoria/post", {
          //Esto sirve para enviar parametros al controlador
          nombre: this.nombre
        })
        .then(function(response) {
          toastr.success(response.data.message, "Listo");
          l.stop();
          me.closeModal();
        })
        .catch(function(error) {
          l.stop();
          toastr.error(error.response.data.message, "Error");
        });
    },
    actualizar(id) {
      axios
        .put("/api/tutoria/update", {
          //Esto sirve para enviar parametros al controlador
          nombre: this.nombre,
          id: id //Este id es el que le entra a la funcion para buscar el registro en BD
        })
        .then(function(response) {
          toastr.success(response.data.message, "Listo");
          l.stop();
          me.closeModal();
        })
        .catch(function(error) {
          l.stop();
          toastr.error(error.response.data.message, "Error");
        });
    }
  },
  mounted() {
    this.index(1, this.search);
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
