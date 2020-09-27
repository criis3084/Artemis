<template>
  <div>
    <vx-card>
      <formulariotutoria></formulariotutoria>

      <vs-table pagination max-items="10" search :data="arrayData">
        <template slot="thead">
          <vs-th>Razón tutoría</vs-th>
          <vs-th>Nombres Niño</vs-th>
          <vs-th>Apelidos Niño</vs-th>
          <vs-th>Genero Niño</vs-th>
          <vs-th>Nombres Tutor</vs-th>
          <vs-th>Apellidos Tutor</vs-th>
          <vs-th>Fecha</vs-th>
          <vs-th>Estado</vs-th>
          <vs-th></vs-th>
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
            <vs-td>
              <vx-tooltip text="Editar">
                <vs-button color="dark" type="flat" icon="edit" size="large">
                </vs-button>
              </vx-tooltip>
            </vs-td>
          </vs-tr>
        </template>
      </vs-table>
      <div>
        <vs-pagination
          :total="pagination.last_page"
          :max="9"
          v-model="pagination.current_page"
          @change="index(pagination.current_page, search)"
          prev-icon="arrow_back"
          next-icon="arrow_forward"
        ></vs-pagination>
      </div>
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
import axios from "axios";

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
      nombre: "",
      fecha: "",
      switch2: false,
      id: 0,
      estado: null
    };
  },
  components: {
    VueApexCharts,
    StatisticsCardLine,
    ChangeTimeDurationDropdown,
    VxTimeline,
    Formulariotutoria
  },
  methods: {
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
      const response = await axios
        .get(`/api/tutoria/get?completo=true`)
        .then(function(response) {
          console.log(page);
          var respuesta = response.data;
          me.arrayData = respuesta.tutorias.data;
          me.pagination = respuesta.pagination;
        })
        .catch(function(error) {
          console.log(error);
        });
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
