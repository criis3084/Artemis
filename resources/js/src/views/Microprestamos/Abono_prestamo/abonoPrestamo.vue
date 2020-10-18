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
            <span>Seleccione el nombre</span>
          </div>
          <div class="vx-col sm:w-2/3 w-full">
            <v-select label="encargado_nombreCompleto" :options="encargados" v-model="detalle" @input="buscarDatos" :dir="$vs.rtl ? 'rtl' : 'ltr'" name="encargado" v-validate="'required'"/>
            <span class="text-danger text-sm" v-show="errors.has('encargado')">{{ errors.first('encargado') }}</span>
            <span></span>
          </div>
        </div>
        <div class="vx-row mb-6">
          <div class="vx-col sm:w-1/3 w-full">
            <span>Cantidad de abono</span>
          </div>
          <div class="vx-col sm:w-2/3 w-full">
            <vs-input class="w-full" v-model="cantidad_abono"  name="cantidad" v-validate="'required|numeric|max:5'"/>
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
            <span class="text-2xl leading-none font-medium text-primary mr-4">{{this.fecha_pago}} </span>
          </div>
        </div>
        <div class="vx-row">
          <div class="vx-col sm:w-2/3 w-full ml-auto">
            <vs-button class="mr-3 mb-2" @click="guardar">Aceptar</vs-button>
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
                               <img src="@assets/images/logo/logo.png" alt="vuexy-logo">
                               <p class="text-primary">Partners in Development</p>
                               
                            </div>

                            <span>Comprobante pago de microprestamo</span>
                            <div class="flex justify-between mb-2">
                                <span class="font-semibold">Comprobante No.</span>
                                <span class="font-medium text-primary cursor-pointer"></span>
                            </div>
                            <div class="flex justify-between mb-2">
                                <span class="text-grey">{{nombreSeleccionado}}</span>
                                <span class="text-grey">{{getDate(fecha_pago)}}</span>
                            </div>
                            <vs-divider />

                            <p class="font-semibold mb-3">Detalles</p>
                            <div class="flex justify-between mb-2">
                                <span class="text-grey">Total del prestamo</span>
                                <span>{{totalPrestamo}}</span>
                            </div>
                            <div class="flex justify-between mb-2">
                                <span class="text-grey">Pendiente por pagar</span>
                                <span v-if="deuda > 0">{{deuda}}</span>
                                <span v-else>{{totalPrestamo}} </span>
                            </div>
                            <div class="flex justify-between mb-2">
                                <span class="text-grey">Cantidad de abono</span>
                                <span class="text-success">-{{cantidad_abono}}</span>
                            </div>
                            <div class="flex justify-between mb-2">
                                <span class="text-grey">Mora por atraso</span>
                                <span class="text-success" v-if="pagarMora==true">{{mora}}</span>
                                <span class="text-success" v-else>0</span>
                            </div>
                             <div class="flex justify-between mb-2">
                                <span class="text-grey">Deuda pendiente</span>
                                <span>{{total}}</span>
                            </div>

                            <vs-divider />

                            <div class="flex justify-between font-semibold mb-3">
                                <span>Total a pagar </span>
                                <span>{{this.AbonoTotal}}</span>
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
      cantidad_abono:'',
      descripcion:'',
      fecha_pago:'',
      dia_pago:'',
      mora:'',
      interes:'',
      detalle_id:'',
      duracion:'',
      encargado_nombres:'',
      totalPrestamo:'',
      cantidad_restante:'',
      detalle_integrante_id:'',
      detalle:'',
      nRecibo:'',
      usuario_id:'',
      alerta:false,
      Ngrupo:'',
      arrayA:'',
      deuda:'',
      total:'',
      AbonoTotal:'',
      pagarMora:false,
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
        valor.encargado_nombres = valor.datos_prestamista[0].nombres
	    	valor.encargado_apellidos = valor.datos_prestamista[0].apellidos
		    valor.encargado_nombreCompleto = `${valor.encargado_nombres  } ${  valor.encargado_apellidos}`
      }) 

      return tabla
    },
    async importarEncargados () { //async para que se llame cada vez que se necesite
      const me = this
      const hash2 = {}
      const response = await axios.get(
        '/api/detalleIntegrante/get?completo=false')
        .then(function (response) {
          const respuesta = response.data
          me.arrayData = respuesta.detalleIntegrantes.data
          me.arrayData = me.arrayData.filter(o => hash2[o.encargado_id] ? false : hash2[o.encargado_id] = true)
          console.log('importacion de personas asignadas a grupo')
          console.log(me.arrayData)
          me.encargados = me.traerDatosEncargados(me.arrayData)
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
      axios.post('/api/abonoPrestamo/post/', {
        cantidad_abono:this.AbonoTotal,
        cantidad_restante:this.total,
        descripcion:this.descripcion,
        fecha_pago:this.getDate(this.fecha_pago),
        mora:this.mora,
        detalle_integrante_id:this.detalle.id,
        usuario_id:8
      }).then(function (response) {
        console.log(response.data.id)
        me.seterResponse(response.data.id)
        alert('Ingreso correctamente')
      })
        .catch(function (error) {
          console.log(error)
          alert('Erro al ingresar')
        })
      
    },
    buscarDatos () {
      console.log(this.detalle.id)
      this.nombreSeleccionado = `${this.detalle.encargado_nombres  } ${  this.detalle.encargado_apellidos}`
      this.totalPrestamo = this.detalle.microprestamo.total
      this.interes = this.detalle.microprestamo.interes
      this.dia_pago = this.detalle.microprestamo.dia_pago
      this.duracion = this.detalle.microprestamo.duracion
      this.mora = this.detalle.microprestamo.mora_por_atraso
      this.Ngrupo = this.detalle.grupos.nombre
      console.log(`Total Prestamo  ${this.totalPrestamo}`)
      console.log(`interes   ${this.interes}`)
      console.log(`Dia pago   ${this.dia_pago}`)
      console.log(`duracion  ${this.duracion}`)
      console.log(`mora   ${this.mora}`)
      console.log(`NombreG   ${this.Ngrupo}`)
      this.deuda = 0
      this.pagarMora = false
    },
    async buscarAbonos () {
      const me = this
      this.id_recibido = this.detalle.id
      console.log(`BuscarAbono   ${this.id_recibido}`)
      const response = await axios.get(
        `/api/abonoPrestamo/get?&criterio=detalle_integrante_id&buscar=${this.id_recibido}&completo=true` 
      ).then(function (response) {
        const respuesta = response.data
        me.arrayA = respuesta.abonos.data
        me.deuda = me.arrayA[0].cantidad_restante
        console.log(me.arrayA)
        console.log(me.deuda)
      })
        .catch(function (error) {
          console.log(error)
        })
        
    },
    
    fechas () {
      const FechaHoy = new Date(this.fecha_pago)
      console.log(FechaHoy)
      const fecha = FechaHoy.getDate()
      console.log(fecha)
      console.log(this.dia_pago)
      //const FechaPago = `${fecha.getFullYear()}/${fecha.getMonth() + 1}/${this.dia_pago}`
      
      if (fecha <= this.dia_pago) {
        console.log('Fecha sin mora')
        this.mora = 0
        this.AbonoTotal = parseFloat(this.cantidad_abono) + 0
      } else {
        console.log('Fecha con mora')
        this.pagarMora = true
        this.AbonoTotal = parseFloat(this.cantidad_abono) + parseFloat(this.mora)
      }
      return this.AbonoTotal
      
    },
    seterResponse (id) {
      this.nRecibo = id
    },
    getNow () {
      const today = new Date()
      const date = `${today.getFullYear()}-${today.getMonth() + 1}-${today.getDate()}`
      const time = `${today.getHours()  }:${  today.getMinutes()  }:${  today.getSeconds()}`
      const dateTime = `${date } ${ time}`
      this.fecha_pago = dateTime
    },
    Calcular () {
      this.fechas()
      console.log('Calcular')
      if (this.deuda === 0) {
        this.total = this.totalPrestamo - this.cantidad_abono 
      } else this.total = this.deuda - this.cantidad_abono 

      return this.total
    },
    limpiar () {
         
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
    detalle () {
      this.buscarAbonos()
    },
    cantidad_abono () {
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
