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
           <div class="flex items-center">
         <vs-list-header title="Integrantes" color="success"></vs-list-header><p></p>
         <vs-button @click="agregarIntegrante" type="border" icon-pack="feather" icon="icon-plus" color = "primary" radius size="small"> </vs-button> 
           </div>
           <h5>Nombres</h5>
           <!-- <div v-for="(numero,index) in cantidad_encargados" :key="index">
              <vs-list-item :title="encargado.datos_encargado[0].nombres + ' ' +encargado.datos_encargado[0].apellidos" subtitle="">
                <vs-button color="danger" type="border" icon-pack="feather" icon="icon-x-circle" radius size="small"></vs-button>
              </vs-list-item>
           </div> -->
         </vs-list>
      </vx-card>
      <div class="vx-col w-full">
            <vs-button class="mr-3 mb-2">Guardar grupo</vs-button>
            
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
      inversion:''
    }
  },
  methods:{
    sumar_encargado(){
			this.cantidad_encargados.push({id:this.cantidad_encargados.length+1,visible:true,validado:false})
			this.encargadosI+=1
		},
    traerNombre (tabla) {
      tabla.forEach(function (valor, indice, array) {
        valor.nombres = valor.datos.nombres
        valor.apellidos = valor.datos.apellidos
        valor.nombre_completo = `${valor.nombres  } ${  valor.apellidos}`
    
      }) 
      return tabla
	  },
    guardar () {
      axios.post('/api/grupoPrestamo/post/', {
        nombre:this.nombre,
        descripcion:this.descripcion,
        cantidad_ultimo_prestamo:this.cantidad_ultimo_prestamo,
        cantidad_prestamo_actual:this.cantidad_prestamo_actual
      }).then(function (response) {
        console.log(response)
      })
        .catch(function (error) {
          console.log(error)
        })
		
      this.$vs.notify({
        color:'success',
        title:'Exito',
        text:'Registro Creado!'
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
       console.log(this.encargado.id)
       
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