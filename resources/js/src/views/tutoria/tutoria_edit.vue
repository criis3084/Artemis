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
				<small class="date-label">Razón de la tutoría</small>		
				<vs-input v-model="nombreTT" class="mt-4 mb-2 col-1 w-full" />
					<div class="vx-col md:w-1/2 w-full mt-5">
						<div class="my-4">
							<small class="date-label">Fecha de nacimiento</small>
							<datepicker :format="dateFormat" name="end-date" v-model="fechaT"></datepicker>
						</div>
					</div>
				<vs-alert  color="danger" vs-icon="new_releases" class="mt-4" >
					LLene todos los campos
				</vs-alert>
				<br>
		</div>
			<template>
				<small class="date-label">Nombre del niño</small>
				<v-select label="nombrecompleto" :options="nino" v-model="nino_idT" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
				<br>
				<small class="date-label">Nombre del tutor</small>
				<v-select label="nombrecompleto" :options="tutor" v-model="tutor_idT" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
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
        tutor_id:{default:0}
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
		value3: "",
		value4: "",
		value5: ""
      },
	  idT:0,
	  nombreT:'',
	  nombreTT:'',
	  nombreTTT:'',
	  fechaT:this.getDate(this.fecha),
	  nino_id:0,
	  nino_nombreE:'',
	  nino_idT:{id:-1,nombres:''},
	  tutor_nombreE:'',
	  tutor_idT:{id:-1,nombres:''},
	  tutor: [],
	  nino: [],
	  titulo: "Editar Tutoría",
	  dateFormat : 'yyyy-MM-dd',
    };
  },
  computed: {
    validName() {
      return true;
    },
	copia() {
		this.importar_nino();
		this.importar_tutor();
        return true;
	}
  },
  methods: {
		traerNombreNino(tabla){
		console.log(typeof(tabla));
		tabla.forEach(function(valor, indice, array){
			valor.nombres=valor.datos.nombres
			valor.apellidos=valor.datos.apellidos
			valor.nombrecompleto=valor.nombres + " " +  valor.apellidos
		}); 
		return tabla
	},
	traerNombreTutor(tabla){
		tabla.forEach(function(valor, indice, array){
			valor.nombres=valor.datos.nombres
			valor.apellidos=valor.datos.apellidos
			valor.nombrecompleto=valor.nombres + " " +  valor.apellidos
		}); 
		return tabla
	},
    async importar_nino() {
		if(this.$props.identificador==true)
		{
			let me = this;
			let encontrado=false;
			let elementoE={}
			const response = await axios.get(`/api/nino/get?completo=true`)
			.then(function (response){
				var respuesta = response.data;
				me.nino = respuesta.ninos.data;
			    me.nino = me.traerNombreNino(me.nino);
				me.nino.forEach(function(elemento, indice, array) {
					if (elemento.id==me.$props.nino_id)
					{
						elementoE=elemento
						encontrado=true
					}
				})
					me.nino_idT = elementoE;
					me.idT = me.$props.id;
					me.nombreT = me.$props.nombrecompleto;
				})
				.catch(function(error) {
				console.log(error);
				});
				me.nombreTT = this.$props.nombre
				me.fechaT = this.$props.fecha	
		}
	},
    async importar_tutor() {
		if(this.$props.identificador==true)
		{
		let me = this;
			let encontrado=false;
			let elementoE={}
			const response = await axios.get(`/api/tutor/get?completo=false`)
			.then(function (response){
				var respuesta = response.data;
				me.tutor = respuesta.tutors.data;
				me.tutor = me.traerNombreTutor(me.tutor);
				me.tutor.forEach(function(elemento, indice, array) {
					if (elemento.id==me.$props.tutor_id)
					{	
						elementoE=elemento
						encontrado=true
					}
				})
				
					me.tutor_idT = encontrado == true ? elementoE:{id:me.$props.tutor_id,nombres:'Tutor desactivado'} 
			})
			.catch(function(error) {
			console.log(error);
			});
		}
    },
	acceptAlert () {
		axios.put("/api/tutoria/update/",{
			id:this.idT,
			nombre: this.nombreTT,
			fecha: this.getDate(this.fechaT),
			nino_id: this.nino_idT.id,
			tutor_id: this.tutor_idT.id,
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
			title: "Cerrado",
			text: "Diálogo cerrado!",
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
    this.importar_nino();
    this.importar_tutor();
  },
};
</script>