<template>
  <div class="vx-row">

    <!-- HORIZONTAL LAYOUT -->
    <div class="vx-col md:w-1/2 w-full mb-base">
       <vs-alert v-if="alerta==true" color="success" title="Información" active="true">
           El abono al micropréstamo se ha competado
        </vs-alert>
      <vx-card title="Ingresar Abono">
				<vs-divider position="right">PID&#174;</vs-divider>

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
            <vs-input type="number" class="w-full" v-model="cantidad_abono"  name="cantidad" v-validate="'required|max:5|numeric'"/>
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
            <vs-textarea class="w-full" name="descripcion" v-model="descripcion" v-validate="'required|max:150'" />
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
        <div class="vx-row mb-6">
          <div class="vx-col sm:w-2/3 w-full ml-auto">
            <vs-button type="gradient" icon-pack="feather" icon="icon-save" class="mr-3 mb-2" @click="enviarForm">Guardar</vs-button>
            <vs-button color="warning" icon="format_clear" type="border" class="mb-2" @click="limpiar">Limpiar</vs-button>
          </div>
        </div>
      </vx-card>
    </div>
    
    <div class="vx-col lg:w-1/3 w-full">
    <div id="invoice-page">
                        <vx-card id="invoice-container">
                          <div class="flex justify-between mb-2">
                               <img src="@assets/images/logo/logopid.png" height="90px" width="150px">
                               <p class="text-primary">Partners in Development</p>
                               
                            </div>

                            <span>Comprobante pago de micropréstamo</span>
                            <div class="flex justify-between mb-2">
                                <span class="font-semibold">Comprobante No.</span>
                                <span class="font-medium text-primary cursor-pointer">{{nRecibo}}</span>
                            </div>
                            <div class="flex justify-between mb-2">
                                <span class="text-grey">{{nombreSeleccionado}}</span>
                                <span class="text-grey">{{getDate(fecha_pago)}}</span>
                            </div>
                            				<vs-divider position="right">PID&#174;</vs-divider>


                            <p class="font-semibold mb-3">Detalles</p>
                            <div class="flex justify-between mb-2">
                                <span class="text-grey">Total del préstamo</span>
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
                                <span class="text-grey">Descripción</span>
                                <span>{{descripcion}}</span>
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

                           
                        </vx-card><br>
                         <vs-button type="gradient" icon-pack="feather" icon="icon-printer" class="w-full" v-if="Imprimir==true" @click="printInvoice" >Imprimir</vs-button>
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
import Ls from '../../../services/ls';
//validar
import { Validator } from 'vee-validate'
const dict = {
  custom: {
    cantidad: {
      	  required: 'El campo cantidad de abono es requerido',
      	  numeric: 'El campo solo debe de contener números',
      max: 'Este campo solo acepta hasta 5 dígitos'
    },
    descripcion: {
      required:'El campo descripción es requerido',
      max:'No se aceptan más de 150 caracteres'
    },
    encargado:{
      required:'Seleccione una persona'
    }
  }
}
Validator.localize('es', dict)

export default{
  data () {
    return {
      arrayGrupo:[],
      arrayData:[],
      encargados: [],
      cantidad_abono:'',
      GrupoId:'',
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
      user_id:'',
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
            color:'danger',
            title:'Error en validación!',
            text:'Ingrese correctamente todos los datos'
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
    async importarEncargados () { //importa a todos las personas que tenga un microprestamo asignado
      const me = this
      const hash2 = {}
      const response = await axios.get(
        '/api/detalleIntegrante/get?completo=false')
        .then(function (response) {
          const respuesta = response.data
          me.arrayData = respuesta.detalleIntegrantes.data
          me.arrayData = me.arrayData.filter(o => hash2[o.encargado_id] ? false : hash2[o.encargado_id] = true)
          //console.log('importacion de personas asignadas a grupo')
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
        user_id:parseInt(Ls.get('auth.id_usuario'))
      }).then(function (response) {
        me.seterResponse(response.data.id)
        me.ActualizarFechaPago()
        me.desactivar()
        me.Imprimir = true
        // alert('Ingreso de abono correctamente')
        me.$vs.notify({
          color:'success',
          title:'Abono registrado!',
          text:'La acción se realizo exitósamente'
        })
      })
        .catch(function (error) {
          console.log(error)
          me.$vs.notify({
            color:'danger',
            title:'Error en ingreso!',
            text:'Ocurrio un error al guardar el abono'
          })
        })
    },
    buscarDatos () { 
      this.nombreSeleccionado = `${this.detalle.encargado_nombres  } ${  this.detalle.encargado_apellidos}`
      this.totalPrestamo = this.detalle.prestamo_individual
      this.microprestamo_id = this.detalle.microprestamo.id
      this.dia_pago = this.detalle.dia_pago
      this.duracion = this.detalle.microprestamo.duracion
      this.mora = this.detalle.microprestamo.mora_por_atraso
      this.cantidad_abono = this.detalle.pago_mes
      this.Ngrupo = this.detalle.grupos.nombre
      this.GrupoId = this.detalle.grupos.id
      //console.log(`Total Prestamo  ${this.totalPrestamo}`)
      //console.log(`Id microprestamo   ${this.microprestamo_id}`)
      //onsole.log(`Dia pago   ${this.dia_pago}`)
      //console.log(`duracion  ${this.duracion}`)
      //console.log(`mora   ${this.mora}`)
      //console.log(`Pago mes   ${this.cantidad_abono}`)
      //console.log(`NombreG   ${this.Ngrupo}`)
      //console.log(this.GrupoId)
      this.deuda = 0
      this.pagarMora = false
      this.mes = 0
      this.dias = 0
      this.Imprimir = false
      this.alerta = false
      this.descripcion = ''
      this.MoraPorfechas()
    },
    async buscarAbonos () { //funcion para verificar si se ya tiene abonos realizados
      const me = this
      this.id_recibido = this.detalle.id
      //console.log(`BuscarAbono   ${this.id_recibido}`)
      const response = await axios.get(
        `/api/abonoPrestamo/get?&criterio=detalle_integrante_id&buscar=${this.id_recibido}&completo=true` 
      ).then(function (response) {
        const respuesta = response.data
        me.arrayA = respuesta.abonos.data
        me.deuda = me.arrayA[0].cantidad_restante
        me.Calcular()
      })
        .catch(function (error) {
          console.log(error)

        })
        
    },
    
    MoraPorfechas () { //funcion que evalua la fecha de pago, para asignar la mora
      const today = new Date()
      const FechaHoy = `${today.getFullYear()}-${today.getMonth() + 1}-${today.getDate()}`
      //console.log(today)
      const FechaPago = new Date(this.dia_pago)
      //console.log(FechaPago)
      
      if (today <= FechaPago) {
        //console.log('Fecha sin mora')
        this.mora = 0
        this.mora_nueva = parseFloat(this.deuda) + 0
      } else {
        //console.log('Fecha con mora')
        const diferencia = new Date(FechaHoy) - new Date(FechaPago)
        const mes = Math.floor(diferencia / 2629750000)
        const dias = Math.floor(diferencia / 86400000)
        this.mes = mes
        this.dias = dias
        if (dias > 0 && mes === 0) {
          this.pagarMora = true
          this.mora_nueva = parseFloat(this.deuda) + parseFloat(this.mora) 
          //console.log('Mora por dia')
        } else if (mes >= 1) {
          this.pagarMora = true
          this.mora = parseFloat(this.mora) * parseFloat(this.mes)
          this.mora_nueva = parseFloat(this.deuda) + parseFloat(this.mora) 
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
      //console.log('Calcular')
      if (this.deuda === 0) {
        this.total = this.totalPrestamo - this.cantidad_abono + this.mora_nueva
      } else this.total = this.deuda - this.cantidad_abono + this.mora_nueva

      return this.total
    },
    NuevaFecha () { //funcion para asignar la nueva fecha de pago al prestamista cada que haga un abono
      const today = new Date()
      
      const FechaPago = this.dia_pago
      const todaySin = new Date(parseInt(FechaPago.split('-', 3)[0]), parseInt(FechaPago.split('-', 3)[1]), parseInt(FechaPago.split('-', 3)[2]))
      //console.log('Fecha pago')
      //console.log(todaySin)
      //const diaPago = FechaPago.getDate()

      const diferencia = new Date(today) - new Date(this.dia_pago)
      const anio = Math.floor(diferencia / 31557000000)
      // console.log('hay anio?')
      //console.log(anio)
      if (anio <= 0) {
        this.NuevaFechaPago = todaySin
        //this.NuevaFechaPago = FechaPago.setMonth(FechaPago.getMonth() + 1)
        //this.NuevaFechaPago = FechaPago.setDate(FechaPago.getDate() + 1)
      } else {
        this.NuevaFechaPago = new Date(today)
        this.NuevaFechaPago.setMonth(FechaPago.getMonth() + 1)
        this.NuevaFechaPago.setDate(FechaPago.getDate() + 1)
      }
    },

    limpiar () {
      this.AbonoTotal = ''
      this.deuda = ''
      this.mora = ''
      this.mes = ''
      this.dia = ''
      this.cantidad_abono = ''
      this.nombreSeleccionado = ''
      this.descripcion = ''
      this.nRecibo = ''
    },

    desactivar () {
      const me = this
      this.id_recibido = this.detalle.id
      if (this.total === 0) {
       // console.log(`Desactivar  ${this.id_recibido}`)
        
        axios.put('/api/detalleIntegrante/desactivar', {
          id: this.id_recibido
        })
          .then(function (response) {
            console.log(response.data.message)
            me.alerta = true 
            me.buscarGrupo() 
            //me.evaluarGrupo()      
          })
          .catch(function (error) {
            console.log(error.response.data.message)
            me.$vs.notify({
              color:'danger',
              title:'Error!',
              text:'Erro al actualizar la finalización del pago completo del prestamo'
            })
          })
      }

    },
    buscarGrupo () { //busca los integrantes de un grupo
      const me = this
      //console.log('Buscar Grupo')
      //console.log(this.GrupoId)
      const response =  axios.get(`/api/detalleIntegrante/get?&criterio=grupo_prestamo_id&buscar=${this.GrupoId}&completo=true`) 
        .then(function (response) {
          const respuesta = response.data
          me.arrayGrupo = respuesta.detalleIntegrantes.data
          me.evaluarGrupo(me.arrayGrupo)
          //console.log(me.arrayGrupo)
          //me.evaluarGrupo(me.arrayGrupo)
        })
    },

    evaluarGrupo (copiaGrupo) { //evalua si todos los integrantes ya no tienen deuda para activar el grupo
    const me = this
    //const copiaGrupo = this.arrayGrupo
    //console.log(copiaGrupo)
      let contador = 0
      //console.log('Evaluando grupos')
      copiaGrupo.forEach(function (elemento, indice) {
        if (elemento.estado === 0) {
          contador = contador + 1
          //console.log('estado')
          //console.log(contador)
          //console.log('Cantidad arreglo')
          //console.log(copiaGrupo.length)
          if (contador === copiaGrupo.length && me.alerta === true) {
            
            axios.put('/api/grupoPrestamo/activar', {
              id: me.GrupoId
            })
              .then(function (response) {
                console.log(response.data.message)
                me.$vs.notify({
                  color:'success',
                  title:'Información!',
                  text:'El grupo ha finalizado el pago'
                })       
              })
              .catch(function (error) {
                console.log(error.response.data.message)
                me.$vs.notify({
                  color:'danger',
                  title:'Error!',
                  text:'Error al actualizar el grupo por finalización de pago'
                })
              })
          } else {
            console.log('No')
          }
        }
        
      })
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
