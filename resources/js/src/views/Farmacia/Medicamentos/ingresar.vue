<template>
 <div>
		<div class="demo-alignment">
			<h2>Medicamentos</h2>
			<vx-tooltip text="Agregar nuevo registro"><vs-button radius type="gradient" icon-pack="feather" icon="icon-plus" @click="activePrompt2 = true" color="primary" size='large' ></vs-button> </vx-tooltip>
		</div>
	<br>
  
    <vs-prompt
      @cancel="clearValMultiple"
      @accept="acceptAlert"
      @close="close"
	  accept-text="Aceptar"
	  cancel-text="Cancelar"
      :is-valid="validName"
	  :title= "titulo"
      :active.sync="activePrompt2">
      <div class="con-exemple-prompt">
        <b></b>
			
		<vs-input placeholder="Nombre del Medicamento: " v-model="valMultipe.value1" class="mt-4 mb-2 col-1 w-full" />
		<vs-input placeholder="Descripción del Medicamento: " v-model="valMultipe.value2" class="mt-4 mb-2 col-1 w-full" />
		<vs-input placeholder="Cantidad del Medicamento: " v-model="valMultipe.value3" class="mt-4 mb-2 col-1 w-full" />
		
		<vs-alert :active="!validName" color="danger" vs-icon="new_releases" class="mt-4" >
			LLene todos los campos
		</vs-alert>
		<br>
      </div>
		<template>
      <small class="date-label">Categoría:</small>
		<v-select label="nombre" :options="categoria" v-model="valMultipe.value4" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
		<br>
    <small class="date-label">Casa Médica:</small>
		<v-select label="nombre" :options="casa_medica" v-model="valMultipe.value5" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
		
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
        value4: "",
        value5: "",
      },
	  nino: [],
	  datosNinos:[],
	  tutor: [],
      selected: "",
	  switch2: true,
	 
	  disabledDates:{
        to: new Date(Date.now() - 8640000)
      },

	  titulo: "Nuevo Medicamento",
	  dateFormat : 'yyyy-MM-dd',
    };
  },
  computed: {
    validName() {
      return this.valMultipe.value1.length > 0 && this.valMultipe.value2.length > 0 && this.valMultipe.value3 != 0 && this.valMultipe.value4 != 0 && this.valMultipe.value5 != 0;
    },
  },
  methods: {
	  traerNombre(tabla){
		tabla.forEach(function(valor, indice, array){
                valor.nombre=valor.categoria.nombre
                valor.nombre=valor.casa_medica.nombre
			}); 
		return tabla
	  },
    async index2() {
      //async para que se llame cada vez que se necesite
      let me = this;
      const response = await axios
        .get(`/api/casaMedica/get?completo=false`)
        .then(function(response) {
          var respuesta = response.data;
		  me.casa_medica = respuesta.casaMedicas.data;
		  me.casa_medica = me.traerNombre(me.casa_medica)
		  me.pagination = respuesta.pagination;
        })

        .catch(function(error) {
          console.log(error);
        });
    },
    async index3() {
      //async para que se llame cada vez que se necesite
      let me = this;
      const response = await axios
        .get(`/api/categoriaMedicamento/get?completo=false`)
        .then(function(response) {
          var respuesta = response.data;
		  me.categoria = respuesta.categoriaMedicamentos.data;
		  me.categoria = me.traerNombre(me.categoria)
		  me.pagination = respuesta.pagination;
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    acceptAlert() {
      axios
        .post("/api/medicamento/post/", {
          nombre: this.valMultipe.value1,
          descripcion: this.valMultipe.value2,
          stock_general: this.valMultipe.value3,
		  categoria_medicamento_id: this.valMultipe.value4.id,
          casa_medica_id: this.valMultipe.value5.id,

        })
        .then(function(response) {
          console.log(response);
        })
        .catch(function(error) {
          console.log(error);
        });
      this.valMultipe.value1 = "";
      this.valMultipe.value2 = "";
      this.valMultipe.value3 = "";
      this.valMultipe.value4 = "";
	  this.valMultipe.value5 = "";
      this.$emit("cerrado", "Se cerro el formulario");
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
  },
  mounted() {
    this.index2(1, '');
    this.index3(1, '');
  },
};
</script>