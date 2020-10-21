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
            <span>Cantidad de abono(Q)</span>
          </div>
          <div class="vx-col sm:w-2/3 w-full">
            <vs-input type="number" class="w-full" v-model="cantidad_abono"  name="cantidad" v-validate="'required|max:7'"/>
            <span class="text-danger text-sm" v-show="errors.has('cantidad')">{{ errors.first('cantidad') }}</span>
            <span v-if ="dias > 0 && mes === 0" >{{ 'Dias atrasados:'+ ' ' + dias+ ' '}}</span>
            <span v-if="mes > 0" >{{'Meses atrasados:'+' '+ mes}} </span>
            <span v-if="mes === 0 && dias === 0" > </span>
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
                                <span class="font-medium text-primary cursor-pointer">{{nRecibo}}</span>
                            </div>
                            <div class="flex justify-between mb-2">
                                <span class="text-grey">{{nombreSeleccionado}}</span>
                                <span class="text-grey">{{getDate(fecha_pago)}}</span>
                            </div>
                            <vs-divider />

                            <p class="font-semibold mb-3">Detalles</p>
                            <div class="flex justify-between mb-2">
                                <span class="text-grey">Total del prestamo</span>
                                <span>{{currency(totalPrestamo)}}</span>
                            </div>
                            <div class="flex justify-between mb-2">
                                <span class="text-grey">Pendiente por pagar</span>
                                <span v-if="deuda > 0">{{currency(deuda)}}</span>
                                <span v-else>{{currency(totalPrestamo)}} </span>
                            </div>
                            <div class="flex justify-between mb-2">
                                <span class="text-grey">Cantidad de abono</span>
                                <span class="text-success">-{{currency(cantidad_abono)}}</span>
                            </div>
                            <div class="flex justify-between mb-2">
                                <span class="text-grey">Mora por atraso</span>
                                <span class="text-success" v-if="pagarMora==true">{{currency(mora)}}</span>
                                <span class="text-success" v-else>{{currency(0)}}</span>
                            </div>
                             <div class="flex justify-between mb-2">
                                <span class="text-grey">Deuda pendiente</span>
                                <span>{{currency(total)}}</span>
                            </div>

                            <vs-divider />

                            <div class="flex justify-between font-semibold mb-3">
                                <span>Total a pagar </span>
                                <span>{{currency(this.cantidad_abono)}}</span>
                            </div>

                           
                        </vx-card>
                         <vs-button class="w-full" v-if="Imprimir==true" @click="printInvoice" >Imprimir</vs-button>
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
      max:'No se aceptan más de 5 números'
    },
    descripcion: {
      required:'Información requerida',
      max:'No se aceptan más de 60 caracteres'
    },
    encargado:{
      required:'Seleccione un propietario porfavor'
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
      mora_nueva:'',
      detalle_integrante_id:'',
      detalle:'',
      nRecibo:'',
      usuario_id:'',
      alerta:false,
      Ngrupo:'',
      arrayA:'',
      deuda:'',
      total:'',
      mes:'',
      dias:'',
      AbonoTotal:'',
      microprestamo_id:'',
      Imprimir:false,
      pagarMora:false,
      NuevaFechaPago:'',
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
    async importarEncargados () { //importa a todos las personas que tenga un grupo asignado
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
	
    
    getDate (datetime) { //funcion para dar formato a la fecha
      const date = new Date(datetime)
      const dateString = `${date.getFullYear()}/${date.getMonth() + 1}/${date.getDate()}`
      return dateString
    },

    guardar () { //funcion para guardar el abono
      const me = this
      axios.post('/api/abonoPrestamo/post/', {
        cantidad_abono:this.cantidad_abono,
        cantidad_restante:this.total,
        descripcion:this.descripcion,
        fecha_pago:this.getDate(this.fecha_pago),
        mora:this.mora,
        detalle_integrante_id:this.detalle.id,
        usuario_id:8
      }).then(function (response) {
        console.log(response.data.id)
        me.seterResponse(response.data.id)
        me.ActualizarFechaPago()
        me.Imprimir = true
        alert('Ingreso correctamente')
  
      })
        .catch(function (error) {
          console.log(error)
          alert('Erro al ingresar')
        })
      
    },
    buscarDatos () { //funcion para traer datos del prestamista, desde el la opcion que se selecciona en el select
      console.log(this.detalle.id)
      this.nombreSeleccionado = `${this.detalle.encargado_nombres  } ${  this.detalle.encargado_apellidos}`
      this.totalPrestamo = this.detalle.prestamo_individual
      this.microprestamo_id = this.detalle.microprestamo.id
      this.dia_pago = this.detalle.dia_pago
      this.duracion = this.detalle.microprestamo.duracion
      this.mora = this.detalle.microprestamo.mora_por_atraso
      this.cantidad_abono = this.detalle.pago_mes
      this.Ngrupo = this.detalle.grupos.nombre
      console.log(`Total Prestamo  ${this.totalPrestamo}`)
      console.log(`Id microprestamo   ${this.microprestamo_id}`)
      console.log(`Dia pago   ${this.dia_pago}`)
      console.log(`duracion  ${this.duracion}`)
      console.log(`mora   ${this.mora}`)
      console.log(`Pago mes   ${this.cantidad_abono}`)
      console.log(`NombreG   ${this.Ngrupo}`)
      this.deuda = 0
      this.pagarMora = false
      this.mes = 0
      this.dias = 0
      this.MoraPorfechas()
    },
    async buscarAbonos () { //funcion para verificar si se ya tiene abonos realizados
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
        me.Calcular()
      })
        .catch(function (error) {
          console.log(error)

        })
        
    },
    
    MoraPorfechas () { //funcion que evalua la fecha de pago, para asignar la mora
      const today = new Date()
      const FechaHoy = `${today.getFullYear()}-${today.getMonth() + 1}-${today.getDate()}`
      console.log(today)
      const FechaPago = new Date(this.dia_pago)
      console.log(FechaPago)
      
      if (today <= FechaPago) {
        console.log('Fecha sin mora')
        this.mora = 0
        this.mora_nueva = parseFloat(this.deuda) + 0
      } else {
        console.log('Fecha con mora')
        const diferencia = new Date(FechaHoy) - new Date(FechaPago)
        const mes = Math.floor(diferencia / 2629750000)
        const dias = Math.floor(diferencia / 86400000)
        this.mes = mes
        this.dias = dias
        console.log(mes)
        console.log(dias)

        if (dias > 0 && mes === 0) {
          this.pagarMora = true
          this.mora_nueva = parseFloat(this.deuda) + parseFloat(this.mora) 
          console.log('Mora por dia')
        } else if (mes >= 1) {
          this.pagarMora = true
          this.mora = parseFloat(this.mora) * parseFloat(this.mes)
          this.mora_nueva = parseFloat(this.deuda) + parseFloat(this.mora) 
          console.log('Mora por mes')
          console.log(this.mora)
        } 
        
        
      }
      return this.mora_nueva
      
    },
    seterResponse (id) { //funcion para resivir el numero de recibo
      this.nRecibo = id
    },
    ActualizarFechaPago () { //funcion para actualizar la fecha de pago cada que haga un abono
      axios.put('/api/detalleIntegrante/updatefecha/', {
        id:this.detalle.id,
        dia_pago:this.getDate(this.NuevaFechaPago)
		   
      }).then(function (response) {
        console.log(response)
      })
        .catch(function (error) {
          console.log(error)
        })
    },
    getNow () {
      const today = new Date()
      const date = `${today.getFullYear()}-${today.getMonth() + 1}-${today.getDate()}`
      const time = `${today.getHours()  }:${  today.getMinutes()  }:${  today.getSeconds()}`
      const dateTime = `${date } ${ time}`
      this.fecha_pago = dateTime
    },
    Calcular () { //funcion para calcular la cantidad pendinte de la deuda
      this.NuevaFecha()
      console.log('Calcular')
      if (this.deuda === 0) {
        this.total = this.totalPrestamo - this.cantidad_abono + this.mora_nueva
      } else this.total = this.deuda - this.cantidad_abono + this.mora_nueva

      return this.total
    },
    NuevaFecha () { //funcion para asignar la nueva fecha de pago al prestamista cada que haga un abono
      const today = new Date()
      
      const FechaPago = this.dia_pago
      const todaySin = new Date(parseInt(FechaPago.split('-',3)[0]),parseInt(FechaPago.split('-',3)[1]),parseInt(FechaPago.split('-',3)[2]))
      console.log('Fecha pago')
      //console.log(todaySin)
      //const diaPago = FechaPago.getDate()

      const diferencia = new Date(today) - new Date(this.dia_pago)
      const anio = Math.floor(diferencia / 31557000000)
      console.log('hay anio?')
      console.log(anio)
      if (anio <= 0) {
        this.NuevaFechaPago = todaySin
        //this.NuevaFechaPago = FechaPago.setMonth(FechaPago.getMonth() + 1)
        //this.NuevaFechaPago = FechaPago.setDate(FechaPago.getDate() + 1)
      } else {
        this.NuevaFechaPago = new Date(today)
        this.NuevaFechaPago.setMonth(FechaPago.getMonth() + 1)
        this.NuevaFechaPago.setDate(FechaPago.getDate() + 1)
      }
      console.log(this.getDate(this.NuevaFechaPago))
    },

    limpiar () {
      this.AbonoTotal = 0
      this.deuda = 0
      this.mora = 0
      this.cantidad_abono = 0
      this.nombreSeleccionado = ''
      this.nRecibo = 0
    },

    desactivar () {
      
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
