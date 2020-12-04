<template>
  <div id="page-user-view">
    
    
    <div class = "demo-alignment">
      <div class="vx-col md:w-1/4 w-full mt-5">
	<router-link to="/microprestamo/grupo"><vs-button type="border" radius class="w-full" icon-pack="feather" icon="icon-corner-up-left" icon-no-border></vs-button></router-link>
    </div>
    <h2><b>Nombre del grupo:</b></h2>
   <h2>{{nombreG}}</h2>
    </div><br>
  <span class="text-primary"> Fecha de inicio {{fecha}} </span>
   <vs-divider position="right">PID&#174;</vs-divider>
    <div id="user-data" v-for="(detalles,index) in arrayData" :key="index">
      
      <vx-card title="Información de integrante" class="mb-base">

        <!-- Avatar -->
        <div class="vx-row">

          <!-- Avatar Col -->
          <div class="vx-col" id="avatar-col">
            <div class="img-container mb-4">
              <vs-avatar src="" class="flex-shrink-0 mr-5" color="primary" icon-pack="feather" icon="icon-user" size="90px"/>
            </div>
          </div>

          <!-- Information - Col 1 -->
          <div class="vx-col flex-1" id="account-info-col-1">
            <table>
              <tr>
                <td class="font-semibold">Nombre Completo</td>
                <td>{{ detalles.datos_prestamista[0].nombres +" "+ detalles.datos_prestamista[0].apellidos}}</td>
              </tr>
              <tr>
                <td class="font-semibold">Dirección</td>
                <td>{{detalles.datos_prestamista[0].direccion}}</td>
              </tr>
              <tr>
                <td class="font-semibold">Teléfono</td>
                <td>{{detalles.datos_prestamista[0].numero_telefono}}</td>
              </tr>
            </table>
          </div>
          <!-- /Information - Col 1 -->

          <!-- Information - Col 2 -->
          <div class="vx-col flex-1" id="account-info-col-2">
            <table>
              <tr>
                <td class="font-semibold">Total de préstamo</td>
                <td>{{currency(detalles.prestamo_individual)}}</td>
              </tr>
              <tr>
                <td class="font-semibold">Destino de inversión</td>
                <td>{{detalles.destino.nombre }}</td>
              </tr>
              <tr>
                <td class="font-semibold">Duración del pago</td>
                <td>{{ detalles.microprestamo.duracion }} Meses</td>
              </tr>
              <tr>
                <vs-chip v-if="detalles.estado == 1" color="warning" class="ag-grid-cell-chip" style="font-size:16px">Micropréstamo en curso</vs-chip>
                <vs-chip v-if="detalles.estado == 0" color="success" class="ag-grid-cell-chip" style="font-size:16px" >Sin micropréstamo </vs-chip>
              </tr>
            </table>
          </div>
          <!-- /Information - Col 2 -->
          <div class="vx-col w-full flex" id="account-manage-buttons">
            <vs-button type="gradient"  color="success" icon="payments" @click="$router.push('/microprestamo/historial/'+detalles.id)">Ver pagos</vs-button>
          </div>

        </div>

      </vx-card>
    </div>
    <div class="vx-col md:w-1/3 w-full mt-5">
    <vs-button @click="goBack" class="mr-4" type="gradient" icon-pack="feather" color="primary" icon="icon-corner-up-left"> Regresar</vs-button>
    </div>
  </div>
</template>


<script>
import Axios from 'axios'

export default {
  data () {
    return {
      arrayData:[],
      nombreG:'',
      fecha:''
    }
  },

  methods:{
    goBack () {
      this.$router.go(-1)
    },
    currency (numero) {
      const formatter = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'GTQ'
      })
      const mil = formatter.format(numero)
      return mil
    },
    async index () {
      const me = this
      this.id_recibido = this.$route.params.id
      const response = await Axios.get(`/api/detalleIntegrante/get?&criterio=grupo_prestamo_id&buscar=${this.id_recibido}&completo=true`) 
        .then(function (response) {
          const respuesta = response.data
          me.arrayData = respuesta.detalleIntegrantes.data
          me.nombreG = respuesta.detalleIntegrantes.data[0].grupos.nombre
          me.fecha = respuesta.detalleIntegrantes.data[0].microprestamo.fecha_inicio
        })
    }
  },
  mounted () {
    this.index()
  }
}
</script>
<style lang="scss">
#avatar-col {
  width: 10rem;
}

#page-user-view {
  table {
    td {
      vertical-align: top;
      min-width: 140px;
      padding-bottom: .8rem;
      word-break: break-all;
    }

    &:not(.permissions-table) {
      td {
        @media screen and (max-width:380px) {
          display: block;
        }
      }
    }
  }
}

@media screen and (min-width:1201px) and (max-width:1211px),
only screen and (min-width:636px) and (max-width:991px) {
  #account-info-col-1 {
    width: calc(100% - 15rem) !important;
  }
}

</style>
