<template>
  <div class="vx-row">
    <!-- Formulario Grupo -->
    <div class="vx-col md:w-1/2 w-full mb-base">
      <vx-card title="Nuevo Grupo" >
        <div class="vx-row mb-6">
          <div class="vx-col w-full">
            <vs-input class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label="Nombre de grupo" v-model="nombre" />
          </div>
        </div>
        <div class="vx-row mb-6">
          <div class="vx-col w-full">
            <small>Descripción</small>
            <vs-textarea class="w-full" icon-pack="feather" icon="icon-user" icon-no-border v-model="descripcion" />
          </div>
        </div>
        <div class="vx-row mb-6">
          <div class="vx-col w-full">
           <vs-input class="w-full" icon-pack="feather" icon="icon-dollar-sign" icon-no-border label="Cantidad de préstamo" v-model="cantidad_prestamo_actual" />
          </div>
        </div>
        <div class="vx-row mb-6">
          <div class="vx-col w-full">
            <vs-input class="w-full" icon-pack="feather" icon="icon-dollar-sign" icon-no-border label="Cantidad de préstamo anterior" v-model="cantidad_ultimo_prestamo" />
          </div>
        </div>
         <div class="vx-row mb-6">
          <div class="vx-col w-full">
            <vs-input class="w-full" icon-pack="feather" icon="icon-dollar-sign" icon-no-border label="Interés" v-model="interes_ultimo_prestamo" />
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
            <v-select label="nombre_completo" :options="encargados" v-model="encargado"  @input="agregar" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
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
            <vs-button class="mr-3 mb-2" @click="guardarGrupo">Guardar grupo</vs-button>
            
      </div>
    </div>
  </div>
</template>

<script>
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
      nombresE:[]
    }
  },
  methods:{
    traerNombre (tabla) {
      tabla.forEach(function (valor, indice, array) {
        valor.encargado_nombres = valor.datos.nombres
        valor.encargado_apellidos = valor.datos.apellidos
        valor.nombre_completo = `${valor.encargado_nombres  } ${  valor.encargado_apellidos}`
    
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
        })
          .catch(function (error) {
            console.log(error)
          })
      })

    },
    guardarGrupo () {
      let me = this
      axios.post('/api/grupoPrestamo/post/', {
        //tablaGrupo
        nombre: this.nombre,
        descripcion:this.descripcion,
        cantidad_ultimo_prestamo:this.cantidad_ultimo_prestamo,
        cantidad_prestamo_actual:this.cantidad_prestamo_actual,
        interes_ultimo_prestamo:this.interes_ultimo_prestamo

      }).then(function (response) {
        console.log(response.data.id)
        me.guardarDetalle(response.data.id)
      })
        .catch(function (error) {
          console.log(error)
        })
 
    },
    async traerPersona () {
      const me = this
      const response = await axios.get('/api/encargado/get?completo=true')
        .then(function (response) {
          const respuesta = response.data
          me.encargados = respuesta.encargados.data
          me.encargados = me.traerNombre(me.encargados)
          console.log(me.encargados)
        })
        .catch(function (error) {
          console.log(error)
        })

    },
    /*async Inversion () {
      const me = this
      const response = await axios.get('/api/destinoInversion/get?completo=true')
        .then(function (response) {
          const respuesta = response.data
          me.inversiones = respuesta.destinosInversiones.data
          console.log(me.encargados)
        })
        .catch(function (error) {
          console.log(error)
        })

    },*/
    agregar () {
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
          // if form have no errors
          alert('form submitted!')
        } else {
          // form have errors
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
  }
}
</script>