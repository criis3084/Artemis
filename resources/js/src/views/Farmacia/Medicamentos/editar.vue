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
				
		<vs-input placeholder="Nombre del Medicamento: " v-model="nombreTT" class="mt-4 mb-2 col-1 w-full" />
		<vs-input placeholder="Descripción del Medicamento: " v-model="descripcionT" class="mt-4 mb-2 col-1 w-full" />
		<vs-input placeholder="Cantidad del Medicamento: " v-model="stock_generalT" class="mt-4 mb-2 col-1 w-full" />
		
		<vs-alert :active="!validName" color="danger" vs-icon="new_releases" class="mt-4" >
			LLene todos los campos
		</vs-alert>
		<br>
      </div>
		<template>
      <small class="date-label">Categoría:</small>
		<v-select label="nombre" :options="categoriaMedicamento" v-model="categoria_idT" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
		<br>
    <small class="date-label">Casa Médica:</small>
		<v-select label="nombre" :options="casaMedica" v-model="casa_idT" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
		
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
        descripcion:String,
        stock_general:0,
        categoria_medicamento_id:{default: 0},
        casa_medica_id:{default:0}
        
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
	  descripcionT:'',
	  stock_generalT:'',
	  casa_idE:0,
	  casa_nombreE:'',
	  casa_idT:{id:-1,nombre:''},
	  categoria_nombreE:'',
	  categoria_idT:{id:-1,nombre:''},
	  categoriaMedicamento: [],
	  datosNinos:[],
	  casaMedica: [],
	  titulo: "Editar Medicamento",
	  dateFormat : 'yyyy-MM-dd',
    };
  },
  computed: {
    validName() {
      return true;
    },
	copia() {
		this.importar_casa();
		this.importar_categoria();
        return true;
	}
  },
  methods: {
		traerNombreCategoria(tabla){
		console.log(typeof(tabla));
		tabla.forEach(function(valor, indice, array){
			valor.nombre_categoria=valor.categoriaMedicamento.nombre
		}); 
		return tabla
	},
	traerNombreCasa(tabla){
		tabla.forEach(function(valor, indice, array){
			valor.nombre_casa=valor.casaMedica.nombre
		}); 
		return tabla
	},
    async importar_casa() {
		if(this.$props.identificador==true)
		{
			let me = this;
			let encontrado=false;
			let elementoE={}
			const response = await axios.get(`/api/casaMedica/get?completo=false`)
			.then(function (response){
				var respuesta = response.data;
				me.casaMedica = respuesta.casaMedicas.data;
				me.casaMedica.forEach(function(elemento, indice, array) {
					if (elemento.id==me.$props.casa_medica_id)
					{
						
						elementoE=elemento
						encontrado=true
					}
				})
					me.casa_idT = encontrado == true ? elementoE:{id:me.$props.casa_medica_id,nombre:'Casa desactivada'}
					me.idT = me.$props.id;
					me.nombreT = me.$props.nombre;
				})
				.catch(function(error) {
				console.log(error);
				});

				me.nombreTT = this.$props.nombre
				me.descripcionT = this.$props.descripcion
				me.stock_generalT = this.$props.stock_general
				
		}
	},
    async importar_categoria() {
		if(this.$props.identificador==true)
		{
		let me = this;
			let encontrado=false;
			let elementoE={}
			const response = await axios.get(`/api/categoriaMedicamento/get?completo=false`)
			.then(function (response){
				var respuesta = response.data;
				me.categoriaMedicamento = respuesta.categoriaMedicamentos.data;
				me.categoriaMedicamento.forEach(function(elemento, indice, array) {
					if (elemento.id==me.$props.categoria_medicamento_id)
					{
						
						elementoE=elemento
						encontrado=true
					}
				})
					me.categoria_idT = encontrado == true ? elementoE:{id:me.$props.categoria_medicamento_id,nombre:'Aldea desactivada'} 
					me.idT =me.$props.id;
					me.nombreTTT =me.$props.nombre;

			})
			.catch(function(error) {
			console.log(error);
			});
		}
    },
	acceptAlert () {
		axios.put("/api/medicamento/update/",{
			id:this.idT,
			nombre: this.nombreT,
            descripcion: this.descripcionT,
            stock_general: this.stock_generalT,
			categoria_medicamento_id: this.categoria_idT.id,
			casa_medica_id: this.casa_idT.id,
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
    this.importar_casa();
    this.importar_categoria();
  },
};
</script>