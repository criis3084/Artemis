<template>
  <div class="vx-row">

    <!-- HORIZONTAL LAYOUT -->
    <div class="vx-col md:w-1/2 w-full mb-base">
       <vs-alert v-if="alerta==true" color="success" title="Información" active="true">
           El pago de la vivienda se ha completado 
        </vs-alert>
      <vx-card title="Ingresar Abono">
        <div class="vx-row mb-6">
          <div class="vx-col sm:w-1/3 w-full">
            <span>Nombre del propietario</span>
          </div>
          <div class="vx-col sm:w-2/3 w-full">
            <v-select label="encargado_nombreCompleto" :options="encargados" v-model="vivienda_id"  @input="buscar" @change="onChange($event)" :dir="$vs.rtl ? 'rtl' : 'ltr'" name="encargado" v-validate="'required'"/>
            <span class="text-danger text-sm" v-show="errors.has('encargado')">{{ errors.first('encargado') }}</span>
            <span></span>
          </div>
        </div>
        <div class="vx-row mb-6">
          <div class="vx-col sm:w-1/3 w-full">
            <span>Cantidad de abono</span>
          </div>
          <div class="vx-col sm:w-2/3 w-full">
            <vs-input class="w-full"  v-model="cantidad" name="cantidad" v-validate="'required|numeric|max:5'"/>
            <span class="text-danger text-sm" v-show="errors.has('cantidad')">{{ errors.first('cantidad') }}</span>
          </div>
        </div>
        <div class="vx-row mb-6">
          <div class="vx-col sm:w-1/3 w-full">
            <span>Descripción</span>
          </div>
          <div class="vx-col sm:w-2/3 w-full">
            <vs-textarea class="w-full" name="descripcion" v-model="descripcion" v-validate="'required|max:60'" />
            <span class="text-danger text-sm" v-show="errors.has('descripcion')">{{ errors.first('descripcion') }}</span>
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
            <vs-button class="mr-3 mb-2" @click="enviarForm">Aceptar</vs-button>
            <vs-button color="warning" type="border" class="mb-2" @click="limpiar">Limipiar</vs-button>
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
                          <div class="flex justify-between mb-2">
                               <img src="@assets/images/logo/logopid.png" alt="vuexy-logo">
                               <p class="text-primary">Partners in Development</p>
                               
                            </div>

                            <span>Comprobante pago de vivienda</span>
                            <div class="flex justify-between mb-2">
                                <span class="font-semibold">Comprobante No.</span>
                                <span class="font-medium text-primary cursor-pointer">{{nRecibo}}</span>
                            </div>
                            <div class="flex justify-between mb-2">
                                <span class="text-grey"> {{nombreSeleccionado }} </span>
                                <span class="text-grey"> {{getDate(fecha)}}</span>
                            </div>
                            <vs-divider />

                            <p class="font-semibold mb-3">Detalles</p>
                            <div class="flex justify-between mb-2">
                                <span class="text-grey">Número de vivienda</span>
                                <span>{{vivienda_id.id}}</span>
                            </div>
                            <div class="flex justify-between mb-2">
                                <span class="text-grey">Costo total de vivienda</span>
                                <span>{{currency(costoV)}}</span>
                            </div>
                            <div class="flex justify-between mb-2">
                                <span class="text-grey">Pendiente por pagar</span>
                                <span v-if="deuda > 0">{{currency(deuda)}}</span>
                                <span v-else> {{currency(costoV)}}</span>
                            </div>
                            <div class="flex justify-between mb-2">
                                <span class="text-grey">Cantidad de abono</span>
                                <span class="text-success">-{{currency(cantidad)}}</span>
                            </div>

                            <vs-divider />

                            <div class="flex justify-between font-semibold mb-3">
                                <span>Total de deuda </span>
                                <span>{{currency(total)}}</span>
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
//validar
import { Validator } from 'vee-validate'
const dict = {
  custom: {
    cantidad: {
      required: 'Este campo no puede quedar vacío',
      numeric: 'Solo aceptan números',
      max:'No se aceptan más de 4 números'
    },
    descripcion: {
      required:'Información requerida',
      max:'No se aceptan más de 60 caracteres'
    },
    encargado:{
      required:'Seleccióne un propietario porfavor'
    }
  }
}
Validator.localize('es', dict)

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
      encargadoVivienda_id:'',
      total:'',
      deuda:'',
      costoV:'',
      nRecibo:'',
      alerta:false,
      configdateTimePicker: {
        date: null,
        inline: true
	  },
	  nombreSeleccionado:'Nombre de la persona'
    }
  },
  created () {
    setInterval(this.getNow, 1000)
  },
  methods:{
    enviarForm () {
      this.$validator.validateAll().then(result => {
        if (result) {
          this.guardar()
        } else {
          this.$vs.notify({
            title:'Error',
            text:'Porfavor ingrese correctamente los datos',
            color:'warning',
            position:'bottom-center',
            icon:'priority_high'
          })
        }
      })

    },
    currency (numero) {
      const formatter = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'GTQ'
      })
      const mil = formatter.format(numero)
      return mil
    },
    traerDatosEncargados (tabla) {

      tabla.forEach(function (valor, indice, array) {
        valor.encargado_nombres = valor.datos_residente[0].nombres
	    	valor.encargado_apellidos = valor.datos_residente[0].apellidos
		    valor.encargado_nombreCompleto = `${valor.encargado_nombres  } ${  valor.encargado_apellidos}`
      }) 

      return tabla
    },
    async importarEncargados () { //async para que se llame cada vez que se necesite
      const me = this
      const response = await axios.get(
        '/api/vivienda/get?completo=false')
        .then(function (response) {
          const respuesta = response.data
          me.arrayData = respuesta.viviendas.data
          console.log('importacion de viviendas')
          console.log(me.arrayData)
          me.encargados = me.traerDatosEncargados(me.arrayData)
        })
        .catch(function (error) {
          console.log(error)
        })
    },
	
    async buscar () {
      const me = this
	  this.id_recibido = this.vivienda_id.id
	  this.nombreSeleccionado = `${this.vivienda_id.encargado_nombres  } ${  this.vivienda_id.encargado_apellidos}`
      const response = await axios.get(
        `/api/vivienda/get?&criterio=id&buscar=${this.id_recibido}&completo=true`)
        .then(function (response) {
          const respuesta = response.data
          me.arrayV = respuesta.viviendas.data[0]
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
      this.id_recibido = this.vivienda_id.id
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
      const me = this
      axios.post('/api/historialAbonoVivienda/post/', {
        cantidad_abono:this.cantidad,
        cantidad_restante:this.total,
        descripcion:this.descripcion,
        fecha_pago:this.getDate(this.fecha),
        usuario_id:81,
        vivienda_id:this.vivienda_id.id

      }).then(function (response) {
        console.log(response.data.id)
        me.seterResponse(response.data.id)
        me.desactivar()
        alert('Ingreso correctamente')
      })
        .catch(function (error) {
          console.log(error)
          alert('Erro al ingresar')
        })
      
    },
    desactivar () {
      this.id_recibido = this.vivienda_id.id
      if (this.total === 0) {
        console.log(`Desactivar  ${this.id_recibido}`)
        this.alerta = true
        axios.put('/api/vivienda/desactivar', {
          id: this.id_recibido
        })
          .then(function (response) {
            console.log(response.data.message)
            
          })
          .catch(function (error) {
            console.log(error.response.data.message)
          })
      }

    },
    limpiar () {
      this.deuda = 0
      this.total = 0
      this.vivienda_id = ''
      this.cantidad = 0
      this.costoV = 0
      this.descripcion = ''
      this.alerta = false
    },
    seterResponse (id) {
      this.nRecibo = id
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
