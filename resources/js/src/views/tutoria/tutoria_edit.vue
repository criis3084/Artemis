<template>
	<div>
		<vs-prompt
		@cancel="clearValMultiple"
		@accept="acceptAlert"
		@close="close"
		accept-text="Aceptar"
		cancel-text="Cancelar"
		:is-valid="copia"
		:title= "titulo"
		:active.sync="identificador">

		<div class="con-exemple-prompt">
				<b></b>
				
				<vs-input placeholder="Razón de la tutoría" v-model="valMultipe.value1" class="mt-4 mb-2 col-1 w-full" />
					<div class="vx-col md:w-1/2 w-full mt-5">
						<div class="my-4">
							<small class="date-label">Fecha de nacimiento</small>
							<datepicker :format="dateFormat" name="end-date" v-model="valMultipe.fecha"></datepicker>
						</div>
					</div>
				<vs-alert  color="danger" vs-icon="new_releases" class="mt-4" >
					LLene todos los campos
				</vs-alert>
				<br>
		</div>
			<template>
				<v-select label="nino_nombres" :options="nino" v-model="valMultipe.value3" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
				<br>
				<v-select label="tutor_nombres" :options="tutor" v-model="valMultipe.value4" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
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
    props:{
		identificador:{
			default:false
		},
	    id:{default: 0},
        nombre:String,
        fecha:String,
        nino_id:{default: 0},
        tutor_id:{default: 0},
        
	},
  components: {
    Dropdown,
    Datepicker,
    vSelect,
  },
  data() {
    return {
      valMultipe: {
        value1: "",
		value2: "",
		 fecha: "",
		value3: "",
		value4: ""
      },
      idT:0,
	  nino: [],
	  datosNinos:[],
	  tutor: [],
      selected: "",
	  switch2: true,
   // nombre:"",
   // fecha:"",
    //nino_id:0,
    //tutor_id:0,
	  dateVal : new Date(),
	  titulo: "Nueva tutoría",
	  dateFormat : 'yyyy-MM-dd',
    };
  },
  computed: {
    validName() {
      return true;
    },
	copia() {
		this.idT =this.$props.id;
        this.valMultipe.value1 =this.$props.nombre;
        this.valMultipe.fecha =this.$props.fecha;
        this.valMultipe.value3 =this.$props.nino_id;
        this.valMultipe.value4 =this.$props.tutor_id;
        return true;
	}
  },
  methods: {
	traerNombreNino(tabla){
		tabla.forEach(function(valor, indice, array){
			valor.nino_nombres=valor.datos.nombres
		}); 
		return tabla
	},
	traerNombreTutor(tabla){
		tabla.forEach(function(valor, indice, array){
			valor.tutor_nombres=valor.datos.nombres
		}); 
		return tabla
	},
    async index2() {
      //async para que se llame cada vez que se necesite
      let me = this;
      const response = await axios.get(`/api/nino/get?completo=false`)
        .then(function(response) {
          var respuesta = response.data;
		  me.nino = respuesta.ninos.data;
		  me.nino = me.traerNombreNino(me.nino)
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
        .get(`/api/tutor/get?completo=false`)
        .then(function(response) {
          var respuesta = response.data;
		  me.tutor = respuesta.tutors.data;
		  me.tutor = me.traerNombreTutor(me.tutor)
		  me.pagination = respuesta.pagination;
        })
        .catch(function(error) {
          console.log(error);
        });
    },
	acceptAlert () {
		axios.put("/api/tutoria/update/",{
			id:this.idT,
			nombre: this.valMultipe.value1,
			fecha: this.getDate(this.valMultipe.fecha),
			nino_id: this.valMultipe.value3.id,
			tutor_id: this.valMultipe.value4.id,
		}).then(function(response) {
				console.log(response)
			})
			.catch(function(error) {
			console.log(error)
			});
		this.$vs.notify({
				color:'success',
				title:'Actualizado',
				text:'El registro ha sido actualizado'
		})
		this.$emit("cerrado", "Se cerro el formulario");
	},
    close() {
	this.$emit("cerrado", "Se cerro el formulario");
		this.$vs.notify({
			color: "danger",
			title: "Closed",
			text: "You close a dialog!",
		});
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