<!-- =========================================================================================
  File Name: DashboardAnalytics.vue
  Description: Dashboard Analytics
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
========================================================================================== -->
<!-- Este es el componente inicial -->
<template>

</template>

<script>


import VueApexCharts from 'vue-apexcharts'
import StatisticsCardLine from '@/components/statistics-cards/StatisticsCardLine.vue'
import analyticsData from './ui-elements/card/analyticsData.js'
import ChangeTimeDurationDropdown from '@/components/ChangeTimeDurationDropdown.vue'
import VxTimeline from '@/components/timeline/VxTimeline'
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
          'to' : 0,
      },
      offset : 3,
      search : 'maco puto',
      arrayData: [],
      nombre: '',
    }
  },
  components: {
    VueApexCharts,
    StatisticsCardLine,
    ChangeTimeDurationDropdown,
    VxTimeline
  },
    computed:{
      isActived : function(){
          return this.pagination.current_page;
      },
      pagesNumber : function(){
          if(!this.pagination.to){
              return [];
          }
          var from = this.pagination.current_page - this.offset;
          if(from < 1){
              from = 1;
          }
          var to = from + (this.offset * 2);
          if(to >= this.pagination.last_page)
          {
              to = this.pagination.last_page;
          }
          var pagesArray = [];
          while(from <= to){
              pagesArray.push(from);
              from++;
          }
          return pagesArray;
      },
  },
  methods: {
      cambiarPagina(page,search){
        let me = this;
        //Actualiza la página actual
        me.pagination.current_page = page;
        //Envia la petición para visualizar la data de esa página
        me.index(page,search);
      },
      async index(page, search){ //async para que se llame cada vez que se necesite
        let me = this;
        const response = await axios.get(
            `/api/rol/get?page=${page}&search=${search}`)
        .then(function (response) {
            console.log(response)
            var respuesta= response.data;
            me.arrayData = respuesta.roles.data;
            me.pagination= respuesta.pagination;
        })
        .catch(function (error) {
            console.log(error);
        });
      },
      guardar(){
        axios
        .post("/api/rol/post", {
            //Esto sirve para enviar parametros al controlador
            nombre: this.nombre,
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
      actualizar(id){
          axios
          .put("/api/rol/update", {
            //Esto sirve para enviar parametros al controlador
            nombre: this.nombre,
            id: id, //Este id es el que le entra a la funcion para buscar el registro en BD
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
      activar(){
        axios.put('/api/rol/activar', {
            id: this.id
        })
        .then(function (response) {
            toastr.success(response.data.message, 'Listo')
            me.closeModal()
        })
        .catch(function (error) {
            toastr.error(error.response.data.message, 'Error')
        });
      },
      desactivar(){
        axios.put('/api/rol/desactivar', {
            id: this.id
        })
        .then(function (response) {
            toastr.success(response.data.message, 'Listo')
            me.closeModal()
        })
        .catch(function (error) {
            toastr.error(error.response.data.message, 'Error')
        });
      }
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
