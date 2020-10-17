<template>
  <div class="vx-row">
    <!-- Formulario Grupo -->
    <div class="vx-col md:w-1/2 w-full mb-base">
      <vx-card title="Nuevo Grupo" >
        <div class="vx-row mb-6">
          <div class="vx-col w-full">
            <vs-input class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label="Nombre de grupo" v-model="nombre" name="nombre" v-validate="'required|max:35'" />
            <span class="text-danger text-sm" v-show="errors.has('nombre')">{{ errors.first('nombre') }}</span>
          </div>
        </div>
        <div class="vx-row mb-6">
          <div class="vx-col w-full">
            <small>Descripción</small>
            <vs-textarea class="w-full" icon-pack="feather" icon="icon-user" icon-no-border v-model="descripcion" name="descripcion" v-validate="'required|max:60'"/>
            <span class="text-danger text-sm" v-show="errors.has('descripcion')">{{ errors.first('descripcion') }}</span>
          </div>
        </div>
        <div class="vx-row mb-6">
          <div class="vx-col w-full">
           <vs-input class="w-full" icon-pack="feather" icon="icon-dollar-sign" icon-no-border label="Cantidad de préstamo" v-model="cantidad_prestamo_actual" name="cantidad" v-validate="'required|numeric|max:4'"/>
           <span class="text-danger text-sm" v-show="errors.has('cantidad')">{{ errors.first('cantidad') }}</span>
          </div>
        </div>
        <div class="vx-row">
          <vs-button color="warning" type="border" class="mb-2" @click="nombre = descripcion = cantidad_prestamo_actual = cantidad_ultimo_prestamo = interes_ultimo_prestamo= ''">Limpiar</vs-button>
        </div>
      </vx-card>
      </div>

    <!-- Ver integrantes de grupo-->
    <div class="vx-col md:w-1/2 w-full mb-base">
      <vx-card title="Seleccione integrantes del grupo">
        <div class="vx-row mb-6">
          <div class="vx-col w-full">
            <small>Seleccióne una persona</small>
            <v-select label="nombre_completo" :options="NuevoEncargado" v-model="encargado"  @input="agregar" :dir="$vs.rtl ? 'rtl' : 'ltr'" name="encargado" v-validate="'required'" />
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
      <div class="vx-col w-full">
            <vs-button class="mr-3 mb-2" @click="enviarForm">Guardar grupo</vs-button>
            
      </div>
    </div>
  </div>
</template>

<script>
import { Validator } from 'vee-validate'
const dict = {
  custom: {
    nombre: {
      required: 'Este campo no puede quedar vacío',
      max:'No se aceptan más de 35 caracteres'
    },
    descripcion: {
      required:'Información requerida',
      max:'No se aceptan más de 60 caracteres'
    },
    encargado:{
      required:'Seleccióne miembros para el grupo porfavor'
    },
    cantidad:{
      required:'Porfavor ingrese una cantidad',
      numeric:'Solo se aceptan números',
      max:'No se aceptan cantidades mayores a 4 digitos'
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
      NuevoEncargado:[]
      
    }
  },
  methods:{
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


      this.integrantes.forEach(function (elemento, indice, array) {
        axios.post('/api/detalleIntegrante/post/', {
          //tablaDetalleIntegrante
          microprestamo_id: elemento.microprestamo_id,
          prestamo_individual:elemento.prestamo_individual,
          grupo_prestamo_id:id,
          encargado_id:elemento.encargado_id,
          destino_inversion_id:elemento.destino_inversion_id

        }).then(function (response) {
          console.log(response)
          alert('Integrantes agregados al grupo correctamente')
        })
          .catch(function (error) {
            console.log(error)
            alert('Error al ingresar')
          })
      })

    },
    guardarGrupo () {
      const me = this
      axios.post('/api/grupoPrestamo/post/', {
        //tablaGrupo
        nombre: this.nombre,
        descripcion:this.descripcion,
        cantidad_ultimo_prestamo:0,
        cantidad_prestamo_actual:this.cantidad_prestamo_actual,
        interes_ultimo_prestamo:0

      }).then(function (response) {
        console.log(response.data.id)
        alert('Grupo creado correctamente')
        me.guardarDetalle(response.data.id)
      })
        .catch(function (error) {
          console.log(error)
          alert('Error al crear al grupo')
        })
      
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
      const hash2 = {}
      const me = this
         axios.get(
        '/api/detalleIntegrante/get?completo=false')
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
      //const copiaDetalle = this.detalleIntegrante.slice()
      console.log(copia)
      console.log(copiaDetalle)
      var encontrado =''
      const NuevoEncargados = []
      copia.forEach(function (elemento, indice, array) {
        encontrado = copiaDetalle.find(element => element.encargado_id === elemento.id)
        if (encontrado == undefined) {
          NuevoEncargados.push(elemento)
        }
      })
      console.log(NuevoEncargados)
      this.NuevoEncargado = NuevoEncargados
    },

    agregar () { //funcion para agregar los elemntos en el array
      this.id = this.encargado.id
      this.nombreSeleccionado = `${this.encargado.encargado_nombres  } ${  this.encargado.encargado_apellidos}`
      console.log(this.encargado.id)
      //arreglo para guardar en la base de datos
      this.integrantes.push({encargado_id:this.id, microprestamo_id:1, destino_inversion_id:1, prestamo_individual:0})

      //Arreglo para mostrar nombres en frontend
      this.nombresE.push({nombres:this.nombreSeleccionado})
      console.log(this.nombresE)
      console.log(this.integrantes)
    },
    borrarIntegrante (index) {
      this.integrantes.splice(index, 1)
      this.nombresE.splice(index, 1)
      console.log(this.integrantes)
      console.log(this.nombresE)
    },

    enviarForm () {
      this.$validator.validateAll().then(result => {
        if (result) {
          this.guardarGrupo()
          this.$router.push('/microprestamo/grupo')
        } else {
          // form have errors
          this.$vs.notify({
            title:'Error',
            text:'Porfavor ingrese correctamente los datos',
            color:'warning',
            position:'bottom-center',
            icon:'priority_high'
          })
        }
      })
    }
  },
  computed:{

  },
  components:{
    vSelect
  },
  mounted () {
    this.traerPersona()
    /*this.importarEncargados()
    this.eliminarDuplicado()*/
  }
}
</script>