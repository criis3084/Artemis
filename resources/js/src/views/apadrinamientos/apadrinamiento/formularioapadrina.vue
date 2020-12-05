<template>
 <div>
		<div class="demo-alignment">
			<h2>Apadrinamientos</h2>
			<vx-tooltip text="Agregar nuevo registro"><vs-button radius type="gradient" icon="group_add" @click="activePrompt2 = true" color="primary" size='large' ></vs-button> </vx-tooltip>
		</div>
  
    <vs-prompt
      @cancel="close"
      @accept="acceptAlert"
      @close="close"
	  accept-text="Aceptar"
	  cancel-text="Cancelar"
      :is-valid="validName"
	  :title= "titulo"
      :active.sync="activePrompt2">
      <div class="con-exemple-prompt">
        <b></b>
		</div>
		<template>
      <small class="date-label">Niño:</small>
		<v-select label="nombrecompleto" :options="nino" v-model="valMultipe.value3" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
		<br>
    
    <small class="date-label">Padrino:</small>
		<v-select label="nombrecompleto" :options="padrino" v-model="valMultipe.value4" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
		
    <vs-alert :active="!validName" color="danger" vs-icon="new_releases" class="mt-4" >
			LLene todos los campos
		</vs-alert>
		</template> 
	</vs-prompt>


	  </div>
</template>

<script>
import Datepicker from "vuejs-datepicker";
import axios from "axios";
//C:\laragon\www\PFV1\resources\js\src\views\components\vuesax\dropdown\Dropdown.vue
import Dropdown from "@/views/components/vuesax/dropdown/Dropdown.vue";
import vSelect from "vue-select";

export default {
  components: {
    Dropdown,
    Datepicker,
    vSelect,
  },
  data() {
    return {
      activePrompt2: false,
      val: "",
      valMultipe: {
        value1: "",
		value2: "",
		 fecha: "",
		value3: "",
		value4: ""
      },
	  nino: [],
	  datosNinos:[],
	  padrino: [],
      selected: "",
	  switch2: true,
	 
	  dateVal : new Date(),
	  titulo: "Apadrinamiento registrado",
	  dateFormat : 'yyyy-MM-dd',
    };
  },
  computed: {
    validName() {
	    return this.valMultipe.value3 != 0 && this.valMultipe.value4 != 0;

    },
  },
  methods: {
		traerNombre(tabla){
		tabla.forEach(function(valor, indice, array){
      valor.nombres=valor.datos.nombres
      valor.apellidos=valor.datos.apellidos
      valor.nombrecompleto=valor.nombres + " " + valor.apellidos
		}); 
		return tabla
	  },
    async index2() {
      let me = this;
      const response = await axios
        .get(`/api/nino/get?completo=ninono`)
        .then(function(response) {
          var respuesta = response.data;
		  me.nino = respuesta.ninos.data;
		  me.nino = me.traerNombre(me.nino)
        })

        .catch(function(error) {
          console.log(error);
        });
    },
    async index3() {
      let me = this;
      const response = await axios
        .get(`/api/padrino/get?completo=false`)
        .then(function(response) {
          var respuesta = response.data;
		  me.padrino = respuesta.padrinos.data;
		  me.padrino = me.traerNombre(me.padrino)
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    acceptAlert() {
		let fecha_apadrinamiento = this.getDate(new Date())
		let me = this
		let idT = me.valMultipe.value3.id
		axios.post("/api/apadrinamiento/post/", {
			nino_id: idT,
			padrino_id: me.valMultipe.value4.id,
        })
        .then(function(response) {
			// Actualizar fecha de apadrinamiento
			axios.put('/api/nino/apadrinar/', {
				id:idT,
				fecha_ingreso:fecha_apadrinamiento
			}).then(function (response2) {
				console.log(response2)
			})
			.catch(function (error2) {
				console.log(error2)
			})
			// Activar el niño
			axios.put('/api/nino/activar', {
				id: idT
			})
			.then(function (response) {
				console.log(response.data.message)
			})
			.catch(function (error) {
				console.log(error.response.data.message)
			});
        })
        .catch(function(error) {
          console.log(error);
		});
		this.$emit("cerrado", "Se cerro el formulario");
		this.valMultipe.value3 = "";
		this.valMultipe.value4 = "";
		let titulo = 'Apadrinamiento registrado';
			this.$vs.notify({
			color:'success',
			title:`${titulo}`,
			text:'La acción se realizo exitósamente'
		});
    },
    close() {
      this.$vs.notify({
        color: "danger",
        title: "Cerrado",
        text: "Diálogo cerrado!",
      });
      this.$emit("cerrado", "Se cerro el formulario");
    },
    clearValMultiple() {
      this.valMultipe.value1 = "";
      this.valMultipe.value2 = "";
      this.valMultipe.value3 = "";
      this.valMultipe.value4 = "";
	  this.valMultipe.value5 = "";
	  this.valMultipe.fecha = "";
      this.fechaN = "";
      this.$emit("cerrado", "Se cerro el formulario");
    },
	getDate(datetime) {
        let date = new Date(datetime);
        let dateString = `${date.getFullYear()}/${date.getMonth() + 1}/${date.getDate()}`;
        return dateString;
      },
  },
  mounted() {
    this.index2();
    this.index3();
  },
};
</script>