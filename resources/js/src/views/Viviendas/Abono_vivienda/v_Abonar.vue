<template>
  <div class="vx-row">

    <!-- HORIZONTAL LAYOUT -->
    <div class="vx-col md:w-1/2 w-full mb-base">
      <vx-card title="Ingresar Abono">
        <div class="vx-row mb-6">
          <div class="vx-col sm:w-1/3 w-full">
            <span>Nombre</span>
          </div>
          <div class="vx-col sm:w-2/3 w-full">
            <v-select label="encargado_nombreCompleto" :options="encargados" v-model="encargado_id"  @input="buscar" @change="onChange($event)" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
            <span></span>
          </div>
        </div>
        <div class="vx-row mb-6">
          <div class="vx-col sm:w-1/3 w-full">
            <span>Cantidad de abono</span>
          </div>
          <div class="vx-col sm:w-2/3 w-full">
            <vs-input class="w-full" type="number" v-model="cantidad" name="cantidad"/>
            <span></span>
          </div>
        </div>
        <div class="vx-row mb-6">
          <div class="vx-col sm:w-1/3 w-full">
            <span>Descripcion</span>
          </div>
          <div class="vx-col sm:w-2/3 w-full">
            <vs-textarea class="w-full" v-model="descripcion" />
            <span></span>
          </div>
        </div>
        <div class="vx-row mb-6">
          <div class="vx-col sm:w-1/3 w-full">
            <span>Fecha</span>
          </div>
          <div class="vx-col sm:w-2/3 w-full">
            <span class="text-2xl leading-none font-medium text-primary mr-4"> {{fecha}}</span>
          </div>
        </div>
        <div class="vx-row">
          <div class="vx-col sm:w-2/3 w-full ml-auto">
            <vs-button class="mr-3 mb-2" @click="guardar">Aceptar</vs-button>
            <vs-button color="warning" type="border" class="mb-2">Limipiar</vs-button>
          </div>
        </div>
      </vx-card>
    </div>

    <!-- HORIZONTAL LAYOUT WITH ICON
    <div class="vx-col md:w-1/2 w-full mb-base">
      
        <div class="vx-row mb-6">
          <div class="vx-col sm:w-1/2 w-full">
             
          </div>
        </div>
      
    </div>-->
    
    <div class="vx-col lg:w-1/3 w-full">
    <div id="invoice-page">
                        <vx-card id="invoice-container">
                            <p class="text-primary mb-3">Información adicional</p>
                            <div class="flex justify-between">
                                <span class="font-semibold"></span>
                                <span class="font-medium text-primary cursor-pointer"></span>
                            </div>
                            <div class="flex justify-between mb-2">
                                <span class="text-grey"> {{nombreSeleccionado }} </span>
                            </div>
                            <vs-divider />

                            <p class="font-semibold mb-3">Detalles</p>
                            <div class="flex justify-between mb-2">
                                <span class="text-grey">Número de vivienda</span>
                                <span>{{vivienda_id}}</span>
                            </div>
                            <div class="flex justify-between mb-2">
                                <span class="text-grey">Costo total de vivienda</span>
                                <span>{{costoV}}</span>
                            </div>
                            <div class="flex justify-between mb-2">
                                <span class="text-grey">Pendiente por pagar</span>
                                <span v-if="deuda > 0">{{deuda}}</span>
                                <span v-else> {{costoV}}</span>
                            </div>
                            <div class="flex justify-between mb-2">
                                <span class="text-grey">Cantidad de abono</span>
                                <span class="text-success">-{{cantidad}}</span>
                            </div>

                            <vs-divider />

                            <div class="flex justify-between font-semibold mb-3">
                                <span>Total de deuda </span>
                                <span>Q.{{total}}</span>
                            </div>

                           
                        </vx-card>
                         <vs-button class="w-full" @click="printInvoice" >Imprimir</vs-button>
                    </div>
                  </div>
  </div>
</template>

<script>
import Datepicker from 'vuejs-datepicker'
import flatPickr from 'vue-flatpickr-component'
import 'flatpickr/dist/flatpickr.css'
import { es } from 'vuejs-datepicker/src/locale'
import vSelect from 'vue-select'
import axios from 'axios'


export default{
  data () {
    return {
      arrayData:[],
      encargados: [],
      arrayV:[],
      arrayA:[],
      cantidad:'',
      descripcion:'',
      fecha:'',
      langEn: es,
      input30: '',
      date: null,
      vivienda_id:'',
      nombre_vivienda:'',
      encargado_nombres:'',
      encargado_id:'',
      total:'',
      deuda:'',
      costoV:'',
      configdateTimePicker: {
        date: null,
        inline: true
	  },
	  nombreSeleccionado:'Nombre de la persona',
    }
  },
  created () {
    setInterval(this.getNow, 1000)
  },
  methods:{
    traerDatosEncargados (tabla) {

      tabla.forEach(function (valor, indice, array) {
        valor.encargado_nombres = valor.datos_residente[0].nombres
		valor.encargado_apellidos = valor.datos_residente[0].apellidos
		valor.encargado_nombreCompleto= valor.encargado_nombres + " " + valor.encargado_apellidos
      }) 

      return tabla
    },
    async importarEncargados () { //async para que se llame cada vez que se necesite
      const me = this
      const response = await axios.get(
        '/api/vivienda/get?completo=true')
        .then(function (response) {
          const respuesta = response.data
          me.arrayData = respuesta.viviendas.data
          me.encargados = me.traerDatosEncargados(me.arrayData)
          console.log(me.encargados)
        })
        .catch(function (error) {
          console.log(error)
        })
	},
	
    async buscar () {
      const me = this
	  this.id_recibido = this.encargado_id.id
	  this.nombreSeleccionado=this.encargado_id.encargado_nombres + " " + this.encargado_id.encargado_apellidos
      const response = await axios.get(
        `/api/vivienda/get?&criterio=encargado_id&buscar=${this.id_recibido}&completo=true`)
        .then(function (response) {
          const respuesta = response.data
          me.arrayV = respuesta.viviendas.data[0]
          me.vivienda_id = me.arrayV.id
          me.nombre_vivienda = me.arrayV.direccion
          me.costoV = me.arrayV.costo_total
          // console.log(me.arrayV)
        })
        .catch(function (error) {
          console.log(error)
        })
      this.deuda = 0
    },
    async buscarAbono () {
      const me = this
      this.id_recibido = this.vivienda_id
      console.log(`BuscarAbono   ${this.id_recibido}`)
      const response = await axios.get(
        `/api/historialAbonoVivienda/get?&criterio=vivienda_id&buscar=${this.id_recibido}&completo=true`)
        .then(function (response) {
          const respuesta = response.data
          me.arrayA = respuesta.historialAbonoViviendas.data[0]
          me.deuda = me.arrayA.abono.cantidad_restante
          console.log(me.deuda)
        })
        .catch(function (error) {
          console.log(error)
        })
    },
    
    getDate (datetime) {
      const date = new Date(datetime)
      const dateString = `${date.getFullYear()}/${date.getMonth() + 1}/${date.getDate()}`
      return dateString
    },

    guardar () {
      axios.post('/api/historialAbonoVivienda/post/', {
        cantidad_abono:this.cantidad,
        cantidad_restante:this.total,
        descripcion:this.descripcion,
        fecha_pago:this.getDate(this.fecha),
        usuario_id:81,
        vivienda_id:this.vivienda_id

      }).then(function (response) {
        console.log(response)
      })
        .catch(function (error) {
          console.log(error)
        })
      this.deuda = 0
      this.total = 0
      this.vivienda_id = ''
      this.cantidad = 0
      this.costoV = 0
      this.descripcion = ''
    },
    buscarTotal () {
    
    },
    Calcular () {
      console.log('Calcular')
      if (this.deuda === 0) {
        this.total = this.costoV - this.cantidad
      } else this.total = this.deuda - this.cantidad
      return this.total
    },
    getNow () {
      const today = new Date()
      const date = `${today.getFullYear()}-${today.getMonth() + 1}-${today.getDate()}`
      const time = `${today.getHours()  }:${  today.getMinutes()  }:${  today.getSeconds()}`
      const dateTime = `${date } ${ time}`
      this.fecha = dateTime
    },
    printInvoice () {
      window.print()
    }

  },
  mounted () {
    this.importarEncargados()
    this.$emit('setAppClasses', 'invoice-page')
  },
  watch:{
    vivienda_id () {
      this.buscarAbono()
    },

    cantidad () {
      this.Calcular()
    }
    
  },
  computed:{
  },
  components: {
    Datepicker,
    flatPickr,
    vSelect
  }
}
</script>

<style lang="scss">
@media print {
  .invoice-page {
    * {
      visibility: hidden;
    }

    #content-area {
      margin: 0 !important;
    }

    .vs-con-table {
      .vs-con-tbody {
        overflow: hidden !important;
      }
    }

    #invoice-container,
    #invoice-container * {
      visibility: visible;
    }
    #invoice-container {
      position: absolute;
      left: 0;
      top: 0;
      box-shadow: none;
    }
  }
}

@page {
  size: auto;
}
</style>
