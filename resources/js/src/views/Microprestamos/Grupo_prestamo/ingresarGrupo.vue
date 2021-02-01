<template>
  <div class="vx-row">
    <!-- Formulario Grupo -->
    <div class="vx-col md:w-1/2 w-full mb-base">
      <vx-card title="Nuevo Grupo" >
        <div class="vx-row mb-6">
          <div class="vx-col w-full">
            <vs-input class="w-full" icon-no-border label="Nombre de grupo" v-model="nombre" name="nombre" v-validate="'required|max:30'" />
            <span class="text-danger text-sm" v-show="errors.has('nombre')">{{ errors.first('nombre') }}</span>
          </div>
        </div>
        <div class="vx-row mb-6">
          <div class="vx-col w-full">
            <small>Descripción</small>
            <vs-textarea class="w-full" icon-pack="feather" icon="icon-user" icon-no-border v-model="descripcion" name="descripcion" v-validate="'required|max:150'"/>
            <span class="text-danger text-sm" v-show="errors.has('descripcion')">{{ errors.first('descripcion') }}</span>
          </div>
        </div>

        <div class="vx-row">
          <vs-button icon="format_clear" color="warning" type="border" class="mb-2" @click="nombre = descripcion = cantidad_prestamo_actual = cantidad_ultimo_prestamo = interes_ultimo_prestamo= ''">Limpiar</vs-button>
        </div>
      </vx-card>
      </div>

    <!-- Ver integrantes de grupo-->
    <div class="vx-col md:w-1/2 w-full mb-base">
      <vx-card title="Integrantes del grupo">
        <div class="vx-row mb-6">
          <div class="vx-col w-full">
            <small>Seleccione una persona</small>
            <v-select label="nombre" :options="NuevoEncargado" v-model="encargado"  @input="agregar" :dir="$vs.rtl ? 'rtl' : 'ltr'" name="encargado" v-validate="'required'" />
            <span class="text-danger text-sm" v-show="errors.has('encargado')">{{ errors.first('encargado') }}</span>
          </div>
        </div>
        <vs-divider/>
         <vs-list>
         <vs-list-header title="Integrantes" color="success"></vs-list-header>
         <div v-for="(encargado,index) in nombresE" :key="index">
           <vs-list-item :title="encargado.nombres" subtitle="">
             <vs-button color="danger" type="border" icon-pack="feather" icon="icon-x-circle" @click="borrarIntegrante(index)"></vs-button>
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
    },
    encargado:{
      required:'Seleccione miembros para el grupo'
    }
  }
}
Validator.localize('es', dict)

import axios from 'axios'
import vSelect from 'vue-select'

export default {
  data () {
    return {
      nombre:'',
      descripcion:'',
      cantidad_ultimo_prestamo:'',
      cantidad_prestamo_actual:'',
      interes_ultimo_prestamo:'',
      encargados:[],
      inversiones:[],
      cantidad_encargados:[],
      encargadosI:1,
      encargado:'',
      integrantes:[],
      inversion:'',
      nombresE:[],
      detalleIntegrante:[],
      encargadosDetalle:[],
      NuevoEncargado:[],
      dia_pago: new Date()
      
    }
  },
  methods:{
    getDate (datetime) { //funcion para dar formato a la fecha
      const date = new Date(datetime)
      const dateString = `${date.getFullYear()}/${date.getMonth() + 1}/${date.getDate()}`
      return dateString
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
    guardarDetalle (id) {
      /*let nombreG = this.nombre
      let descripcionG = this.descripcion
      let cantidad_ultimo_prestamoG = this.cantidad_ultimo_prestamo
      let cantidad_prestamo_actualG = this.cantidad_prestamo_actual
      let interes_ultimo_prestamoG = this.interes_ultimo_prestamo*/
      const me = this

      this.integrantes.forEach(function (elemento, indice, array) {
        if (elemento.detalle_integrante_id === undefined) {
          axios.post('/api/detalleIntegrante/post/', { //si el registro no tiene detalle integrante hace un post
          //tablaDetalleIntegrante
            microprestamo_id: elemento.microprestamo_id,
            prestamo_individual:elemento.prestamo_individual,
            grupo_prestamo_id:id,
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
            grupo_prestamo_id:id
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
    guardarGrupo () {
      const me = this
      axios.post('/api/grupoPrestamo/post/', {
        //tablaGrupo
        nombre: this.nombre,
        descripcion:this.descripcion,
        cantidad_ultimo_prestamo:0,
        cantidad_prestamo_actual:0,
        interes_ultimo_prestamo:0

      }).then(function (response) {
        me.$vs.notify({
          color:'success',
          title:'Grupo registrado',
          text:'Acción realizada exitósamente'
        })
        me.guardarDetalle(response.data.id)
      })
        .catch(function (error) {
          console.log(error)
          me.$vs.notify({
            color:'danger',
            title:'Error en ingreso de grupo!',
            text:'Erro al registrar el grupo'
          })
        })
    },
    async traerPersona () { //tabla encargados
    
      const me = this
      const response = await axios.get('/api/encargado/get?completo=false')
        .then(function (response) {
          const respuesta = response.data
          me.encargados = respuesta.encargados.data
          me.encargados = me.traerNombre(me.encargados)
          me.importarEncargados()
  
        })
        .catch(function (error) {
          console.log(error)
        })

    },
    importarEncargados () { //tabla detalle Integrante
      const hash2 = {}
      const me = this
      axios.get(
        '/api/detalleIntegrante/get?completo=true')
        .then(function (response) {
          const respuesta = response.data
          me.detalleIntegrante = respuesta.detalleIntegrantes.data
          me.detalleIntegrante = me.detalleIntegrante.filter(o => hash2[o.encargado_id] ? false : hash2[o.encargado_id] = true)
          me.encargadosDetalle = me.traerDatosEncargados(me.detalleIntegrante)
          me.eliminarDuplicado(me.detalleIntegrante)
        })
        .catch(function (error) {
          console.log(error)
        })
    },
    eliminarDuplicado (copiaDetalle) {
      const copia = this.encargados.slice()
      let encontrado = ''
      const NuevoEncargados = []
      copia.forEach(function (elemento, indice, array) {
        encontrado = copiaDetalle.find(element => element.encargado_id === elemento.id)
        if (encontrado === undefined) {

          NuevoEncargados.push({encargado_id:elemento.id,
            nombre:`${elemento.datos.nombres  } ${  elemento.datos.apellidos}`,
            detalle_integrante_id:elemento.detalle_integrante_id})
        }
      })

      copiaDetalle.forEach(function (elemento) {
        if (elemento.grupo_prestamo_id === 1) {

          NuevoEncargados.push({encargado_id:elemento.encargado_id,
            nombre:elemento.encargado_nombreCompleto,
            detalle_integrante_id:elemento.id})
        }
      })
      this.NuevoEncargado = NuevoEncargados
    },

    agregar () { //funcion para agregar los elemntos en el array
      this.id = this.encargado.encargado_id
      
      this.nombreSeleccionado = this.encargado.nombre
      this.detalle_integrante_id = this.encargado.detalle_integrante_id
      //arreglo para guardar en la base de datos
      this.integrantes.push({encargado_id:this.id, microprestamo_id:1, destino_inversion_id:1, prestamo_individual:0, estado:0, detalle_integrante_id:this.detalle_integrante_id})

      //Arreglo para mostrar nombres en frontend
      this.nombresE.push({nombres:this.nombreSeleccionado})
    },
    borrarIntegrante (index) {
      this.integrantes.splice(index, 1)
      this.nombresE.splice(index, 1)
    },

    enviarForm () {
      this.$validator.validateAll().then(result => {
        if (result) {
          this.guardarGrupo()
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
  components:{
    vSelect
  },
  mounted () {
    this.traerPersona()
  }
}
</script>