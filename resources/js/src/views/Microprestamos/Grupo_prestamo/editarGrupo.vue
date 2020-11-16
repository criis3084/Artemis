<template>
  <div class="vx-row">
    <!-- Formulario Grupo -->
    <div class="vx-col md:w-1/2 w-full mb-base">
      <vx-card title="Editar grupo" >
        <div class="vx-row mb-6">
          <div class="vx-col w-full">
            <vs-input class="w-full" icon-no-border label="Nombre de grupo" v-model="nombreG" name="nombre" v-validate="'required|max:30'" />
            <span>{{this.microprestamo_id}}</span>
            <span class="text-danger text-sm" v-show="errors.has('nombre')">{{ errors.first('nombre') }}</span>
          </div>
        </div>
        <div class="vx-row mb-6">
          <div class="vx-col w-full">
            <small>Descripción</small>
            <vs-textarea class="w-full" icon-pack="feather" icon="icon-user" icon-no-border v-model="descripcion" name="descripcion" v-validate="'required|max:150'"/>
            <span class="text-danger text-sm" v-show="errors.has('descripcion')">{{ errors.first('descripcion') }}</span>
          </div>
          <vs-button icon="format_clear" color="warning" type="border" class="mb-2" @click="nombre = descripcion = ''">Limpiar</vs-button>
        </div>
         <vs-divider/>
         <vs-list>
         <vs-list-header title="Integrantes actuales" color="success"></vs-list-header>
         <div v-for="(integrante,index) in IntegrantesActuales" :key="index">
           <vs-list-item :title="integrante.nombre" :subtitle="Estado(integrante.estado)">
             <vs-button color="danger" icon-pack="feather" @click="eliminarIntegranteActual(integrante,index)" >Eliminar</vs-button>
             
           </vs-list-item>
          </div>
         </vs-list>
         
         <vs-divider/>
         <vs-list v-if="eliminar== true">
         <vs-list-header title="Integrantes para eliminar" color="danger"></vs-list-header>
         <div v-for="(integrante,index) in IntegrantesEliminados" :key="index">
           <vs-list-item :title="integrante.nombre" :subtitle="Estado(integrante.estado)">
           </vs-list-item>
          </div>
          <vs-divider/>
          <span class="text-danger">Confirme para eliminar</span>
           <vs-button color="danger" type="border" icon-pack="feather" @click="activePrompt = true" >Confirmación</vs-button>
         </vs-list>
        <div class="vx-row">

        </div>
      </vx-card>
      </div>

      <vs-prompt
      color="danger"
      title="Confirmación"
      accept-text="Aceptar"
      cancel-text="Cancelar"
      @cancel="cerrarPrompt"
      @accept="eliminarIntegrante"
      @close="cerrarPrompt"
      :active.sync="activePrompt">
      <div class="con-exemple-prompt">
        <span>Está seguro de eliminar a los integrantes seleccionados </span>
      </div>
    </vs-prompt>

    <!-- Ingresar integrantes de grupo-->
    <div class="vx-col md:w-1/2 w-full mb-base">
      <vx-card title="Agregar nuevos integrantes ">
        <div class="vx-row mb-6">
          <div class="vx-col w-full">
            <small>Seleccione una persona</small>
            <v-select label="nombre" :options="NuevoEncargado" v-model="encargado"  @input="agregar" :dir="$vs.rtl ? 'rtl' : 'ltr'" name="encargado"/>
          </div>
        </div>
        <vs-divider/>
         <vs-list>
         <vs-list-header title="NUevos integrantes" color="success"></vs-list-header>
        <div v-for="(encargado,index) in NuevosIntegrantes" :key="index">
           <vs-list-item :title="encargado.nombre" subtitle="">
             <vs-button color="danger" type="border" icon-pack="feather" icon="icon-x-circle" @click="borrarNuevoIntegrante(index)"></vs-button>
           </vs-list-item>
          </div>
         </vs-list>
      </vx-card>
      <br>

      <div class="vx-col w-full">
            <vs-button type="gradient" icon-pack="feather" icon="icon-save" class="mr-3 mb-2" @click="enviarForm">Guardar grupo</vs-button>
            
      </div>
    </div>
  </div>
</template>


<script>
import { Validator } from 'vee-validate'
const dict = {
  custom: {
    nombre: {
  	  required: 'El campo nombre de grupo es requerido',
      max: 'Este campo solo acepta hasta 30 caracteres'
    },
    descripcion: {
      required:'El campo descripción es requerido',
      max:'Este campo solo acepta hasta 150 caracteres'
    }
  }
}
import axios from 'axios'
import vSelect from 'vue-select'
export default {
  data () {
    return {
      activePrompt:false,
      eliminar:false,
      arrayData:[],
      nombreG:'',
      encargado:'',
      descripcion:'',
      IntegrantesEliminados:[],
      IntegrantesActuales:[],
      Deuda:'',
      encargados:[],
      encargadosSinGrupo:[],
      NuevoEncargado:[],
      detalleIntegrante:[],
      encargadosDetalle:[],
      NuevosIntegrantes:[],
      microprestamo_id:''
            
    }
  },
  components:{
    vSelect,
    Validator
  },
  methods:{ 
    cerrarPrompt () {
      this.$vs.notify({
        color:'primary',
        title:'Cerrado',
        text:'Operación cancelada'
      })
      this.IntegrantesEliminados = []
      this.eliminar = false
      this.buscarIntegrante()
    },
    traerNombre (tabla) {
      tabla.forEach(function (valor, indice, array) { //Para tabla encargado
        valor.encargado_nombres = valor.datos.nombres
        valor.encargado_apellidos = valor.datos.apellidos
        valor.nombre_completo = `${valor.encargado_nombres  } ${  valor.encargado_apellidos}`
    
      }) 
      return tabla
    },
    traerDatosEncargados (tabla) { //para tabla DetalleIntegrante

      tabla.forEach(function (valor, indice, array) {
        valor.encargado_nombres = valor.datos_prestamista[0].nombres
	    	valor.encargado_apellidos = valor.datos_prestamista[0].apellidos
		    valor.encargado_nombreCompleto = `${valor.encargado_nombres  } ${  valor.encargado_apellidos}`
      }) 

      return tabla
    },
    
    async traerPersona () { //tabla encargados
      const me = this
      const response = await axios.get('/api/encargado/get?completo=false')
        .then(function (response) {
          const respuesta = response.data
          me.encargados = respuesta.encargados.data
          
          me.encargados = me.traerNombre(me.encargados)
          //console.log(me.encargados)
          me.importarEncargados()
          
        })
        .catch(function (error) {
          console.log(error)
        })

    },
    importarEncargados () { //tabla detalle Integrante
      const hash2 = []
      const me = this
      axios.get(
        '/api/detalleIntegrante/get?completo=true')
        .then(function (response) {
          const respuesta = response.data
          me.detalleIntegrante = respuesta.detalleIntegrantes.data
          me.detalleIntegrante = me.detalleIntegrante.filter(o => hash2[o.encargado_id] ? false : hash2[o.encargado_id] = true)
          me.eliminarDuplicado(me.detalleIntegrante)
          me.encargadosDetalle = me.traerDatosEncargados(me.detalleIntegrante)
          
          //console.log(me.detalleIntegrante)
        })
        .catch(function (error) {
          console.log(error)
        })
    },
    eliminarDuplicado (copiaDetalle) {
      const copia = this.encargados.slice()
      const NuevoEncargados = []
      //const copiaDetalle = this.detalleIntegrante.slice()
      //console.log(copia)
      //console.log(copiaDetalle)
      let encontrado = ''
      
      copia.forEach(function (elemento, indice, array) {
        encontrado = copiaDetalle.find(element => element.encargado_id === elemento.id)
        //console.log(encontrado)
        if (encontrado === undefined) {
          NuevoEncargados.push({encargado_id:elemento.id,
            nombre:`${elemento.datos.nombres  } ${  elemento.datos.apellidos}`,
            detalle_integrante_id:elemento.detalle_integrante_id})
        } 
      })
      copiaDetalle.forEach(function (elemento) {
        if (elemento.grupo_prestamo_id === 1) {

          NuevoEncargados.push({encargado_id:elemento.encargado_id,
            nombre:`${elemento.datos_prestamista[0].nombres  } ${  elemento.datos_prestamista[0].apellidos}`,
            detalle_integrante_id:elemento.id})
        }
      })
      console.log(NuevoEncargados)
      this.NuevoEncargado = NuevoEncargados
    },

    Estado (estado) {
      if (estado === 1)   return 'Deuda pendiente'
      if (estado === 0) return 'Sin pagos pendientes'
    },
    async buscarIntegrante () { //buscar miembros de grupo
      const me = this
      this.id_recibido = this.$route.params.id
      console.log(this.id_recibido)
      const response = await axios.get(`/api/detalleIntegrante/get?&criterio=grupo_prestamo_id&buscar=${this.id_recibido}&completo=true`) 
        .then(function (response) {
          const respuesta = response.data
          me.arrayData = respuesta.detalleIntegrantes.data
          me.GrupoActual(me.arrayData)
        //console.log(me.nombreG)
        // console.log(me.arrayData)
        })
    },
    GrupoActual (grupo) {
      const Integrantes = []
      grupo.forEach(function (valor, indice, array) {
        valor.encargado_nombres = valor.datos_prestamista[0].nombres
	    valor.encargado_apellidos = valor.datos_prestamista[0].apellidos
        valor.nombreCompleto = `${valor.encargado_nombres  } ${  valor.encargado_apellidos}`
        valor.encargado_id = valor.encargado_id
        valor.microprestamo_id = valor.microprestamo_id 
        valor.destino_inversion_id = valor.destino_inversion_id   
        valor.grupo_id = valor.grupo_prestamo_id
        valor.prestamo_individual = valor.prestamo_individual
        valor.estado_integrante = valor.estado

        Integrantes.push({nombre:valor.nombreCompleto,
          id:valor.id,
          encargado_id:valor.encargado_id,
          microprestamo_id:valor.microprestamo_id,
          destino_inversion_id:valor.destino_inversion_id,
          grupo_id:valor.grupo_id,
          prestamo_individual:valor.prestamo_individual,
          estado:valor.estado_integrante})
      }) 
      this.IntegrantesActuales = Integrantes
      console.log(this.IntegrantesActuales)
    },

    eliminarIntegranteActual (integrante, index) {
      this.IntegrantesEliminados.push({
        nombre:integrante.nombre,
        detalle_integrante_id:integrante.id,
        encargado_id:integrante.encargado_id,
        microprestamo_id:integrante.microprestamo_id,
        destino_inversion_id:integrante.destino_inversion_id,
        //grupo_id:integrante.grupo_prestamo_id,
        prestamo_individual:integrante.prestamo_individual,
        dia_pago:integrante.dia_pago
      })
      this.IntegrantesActuales.splice(index, 1)
      this.eliminar = true
      console.log(this.IntegrantesActuales)
      console.log('Personas eliminadas')
      console.log(this.IntegrantesEliminados)
    },
    agregar () { //funcion para agregar los elemntos en el array
      this.id_recibido = this.$route.params.id
      this.id = this.encargado.encargado_id
      this.detalle_integrante_id = this.encargado.detalle_integrante_id
      this.nombreSeleccionado = this.encargado.nombre
      console.log(this.encargado.encargado_id)
      //arreglo para guardar en la base de datos
      this.NuevosIntegrantes.push({nombre:this.nombreSeleccionado, encargado_id:this.id, grupo_prestamo_id:this.id_recibido, microprestamo_id:1, destino_inversion_id:1, prestamo_individual:0, estado:0, detalle_integrante_id:this.detalle_integrante_id})
      
      console.log(this.NuevosIntegrantes)
    },
    
    borrarNuevoIntegrante (index) {
      this.NuevosIntegrantes.splice(index, 1)
      
      console.log(this.NuevosIntegrantes)
      
    },

    guardarDetalle () { //guarda en tabla detalleIntegrante 
      const me = this

      this.NuevosIntegrantes.forEach(function (elemento, indice, array) {
        if (elemento.detalle_integrante_id === undefined) {
          axios.post('/api/detalleIntegrante/post/', { //si el registro no tiene detalle integrante hace un post
          //tablaDetalleIntegrante
            microprestamo_id: elemento.microprestamo_id,
            prestamo_individual:elemento.prestamo_individual,
            grupo_prestamo_id:elemento.grupo_prestamo_id,
            encargado_id:elemento.encargado_id,
            destino_inversion_id:elemento.destino_inversion_id,
            estado:elemento.estado,
            dia_pago: '2020/4/2'
          }).then(function (response) {
            console.log(response)
            me.$vs.notify({
              color:'success',
              title:'Integrantes del grupo registrados',
              text:'Acción realizada exitósamente'
            })
          })
            .catch(function (error) {
              console.log(error)
              me.$vs.notify({
                color:'danger',
                title:'Error de conexión!',
                text:'Error al registrar integrante'
              })
            })
        } else {
          axios.put('/api/detalleIntegrante/updateGrupo/', { //si el registro tiene detalle integrante actualiza el grupo
            id:elemento.detalle_integrante_id,
            grupo_prestamo_id:elemento.grupo_prestamo_id
          }).then(function (response) {
            console.log(response)
            me.$vs.notify({
              color:'success',
              title:'Integrante del grupo registrado',
              text:'Acción realizada exitósamente'
            })
          })
            .catch(function (error) {
              console.log(error)
              me.$vs.notify({
                color:'danger',
                title:'Error de conexión!',
                text:'Error al registrar integrante'
              })
            })
        }
       
      })

    },

    eliminarIntegrante () {
      const me = this
      this.IntegrantesEliminados.forEach(function (elemento) {
        axios.put('/api/detalleIntegrante/updateGrupo/', {
          id:elemento.detalle_integrante_id,
          grupo_prestamo_id:1
        }).then(function (response) {
          console.log(response)
          me.$vs.notify({
            color:'primary',
            title:'Integrante eliminado',
            text:'Acción realizada exitósamente'
          })
        })
          .catch(function (error) {
            console.log(error)
            me.$vs.notify({
              color:'danger',
              title:'Error de conexión!',
              text:'No se pudo eliminar el integrante'
            })
          })
      })
    },
    async datosGrupo () {
      const me = this
      this.id_recibido = this.$route.params.id
      console.log(this.id_recibido)
      const response = await axios.get(`/api/grupoPrestamo/get?&criterio=id&buscar=${this.id_recibido}&completo=true`) 
        .then(function (response) {
          const respuesta = response.data
          me.arrayGrupo = respuesta.grupoPrestamos.data[0]
          me.nombreG = respuesta.grupoPrestamos.data[0].nombre
          me.descripcion = respuesta.grupoPrestamos.data[0].descripcion
          me.microprestamo_id = respuesta.grupoPrestamos.data[0].integrantes[0].microprestamo_id
          console.log(me.microprestamo_id)
          //console.log(me.nombreG)
        })
    },
    
    actualizarNombreGrupo () {
      const me = this
      this.id_recibido = this.$route.params.id
      axios.put('/api/grupoPrestamo/updateDatos/', {
        id: this.id_recibido,
        nombre: this.nombreG,
        descripcion: this.descripcion
      }).then(function (response) {
        console.log(response)
        me.$vs.notify({
          color:'success',
          title:'Exito!',
          text:'Acción realizada exitósamente'
        })
        me.actualizarMicroprestamo()
        me.guardarDetalle()
      })
        .catch(function (error) {
          console.log(error)
          me.$vs.notify({
            color:'danger',
            title:'Error en actualizar grupo',
            text:'Error de conexión'
          })
        })
    },
     actualizarMicroprestamo () {
      const me = this
      this.id_recibido = this.$route.params.id
      axios.put('/api/microprestamo/update', {
        id: this.microprestamo_id,
        nombre: this.nombreG
      }).then(function (response) {
        console.log(response)
        me.$vs.notify({
          color:'success',
          title:'Exito!',
          text:'Nombre microprestamo actualizado'
        })
      })
        .catch(function (error) {
          console.log(error)
          me.$vs.notify({
            color:'danger',
            title:'Error de conexión',
            text:'Error en actualizar grupo'
          })
        })
    },
    enviarForm () {
      this.$validator.validateAll().then(result => {
        if (result) {
          this.actualizarNombreGrupo()
          this.$router.push('/microprestamo/grupo')
        } else {
          // form have errors
          this.$vs.notify({
            color:'danger',
            title:'Error en validación!',
            text:'Ingrese todos los campos correctamente'
          })
        }
      })
    }
      
  },
  watch:{
     
  },
  mounted () {
    this.buscarIntegrante()
    this.traerPersona()
    this.datosGrupo()
  }
  
}
</script>