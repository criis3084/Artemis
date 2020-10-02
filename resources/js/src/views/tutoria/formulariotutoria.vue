<template>
 <div>
		<div class="demo-alignment">
			<h2>Tutoría</h2>
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
			
		<vs-input placeholder="Razón de la tutoría" v-model="valMultipe.value1" class="mt-4 mb-2 col-1 w-full" />
		<div class="vx-col md:w-1/2 w-full mt-5">
			<div class="my-4">
				<small class="date-label">Fecha de Tutoría</small>
				<datepicker :format="dateFormat" :disabledDates="disabledDates" name="end-date" v-model="valMultipe.fecha" ></datepicker>
			</div>
		</div>
		<vs-alert :active="!validName" color="danger" vs-icon="new_releases" class="mt-4" >
			LLene todos los campos
		</vs-alert>
		<br>
      </div>
		<template>
      <small class="date-label">Niño:</small>
		<v-select label="nombres" :options="nino" v-model="valMultipe.value3" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
		<br>
    <small class="date-label">Tutor:</small>
		<v-select label="nombres" :options="tutor" v-model="valMultipe.value4" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
		
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
	  tutor: [],
      selected: "",
	  switch2: true,
	 
	  disabledDates:{
        to: new Date(Date.now() - 8640000)
      },

	  titulo: "Nueva tutoría",
	  dateFormat : 'yyyy-MM-dd',
    };
  },
  computed: {
    validName() {
      return this.valMultipe.value1.length > 0 && this.valMultipe.value3 != 0 && this.valMultipe.value4 != 0 && this.valMultipe.fecha != "";
    },
  },
  methods: {
	  traerNombre(tabla){
		tabla.forEach(function(valor, indice, array){
			valor.nombres=valor.datos.nombres
		}); 
		return tabla
	  },
    async index2(page, search) {
      //async para que se llame cada vez que se necesite
      let me = this;
      const response = await axios
        .get(`/api/nino/get?completo=false`)
        .then(function(response) {
          var respuesta = response.data;
		  me.nino = respuesta.ninos.data;
		  me.nino = me.traerNombre(me.nino)
		  me.pagination = respuesta.pagination;
        })

        .catch(function(error) {
          console.log(error);
        });
    },
    async index3(page, search) {
      //async para que se llame cada vez que se necesite
      let me = this;
      const response = await axios
        .get(`/api/tutor/get?completo=false`)
        .then(function(response) {
          var respuesta = response.data;
		  me.tutor = respuesta.tutors.data;
		  me.tutor = me.traerNombre(me.tutor)
		  me.pagination = respuesta.pagination;
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    acceptAlert() {
      axios
        .post("/api/tutoria/post/", {
		  nombre: this.valMultipe.value1,
		  fecha: this.getDate(this.valMultipe.fecha),
		  nino_id: this.valMultipe.value3.id,
          tutor_id: this.valMultipe.value4.id,

        })
        .then(function(response) {
          console.log(response);
        })
        .catch(function(error) {
          console.log(error);
        });
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
    saveProduct() {
      axios
        .post("/api/tutoria/post/", {
		  nombre: this.valMultipe.value1,
		  fecha: this.valMultipe.fecha,
		  nino_id: this.valMultipe.value3.id,
        //  tutor_id: this.valMultipe.value4.id,

        })
        .then(function(response) {
          console.log(response);
        })
        .catch(function(error) {
          console.log(error);
        });
	},
	getDate(datetime) {
        let date = new Date(datetime);
        let dateString = `${date.getFullYear()}/${date.getMonth() + 1}/${date.getDate()}`;
        return dateString;
      }
      

  },
  mounted() {
    this.index2(1, '');
    this.index3(1, '');
  },
};
</script>