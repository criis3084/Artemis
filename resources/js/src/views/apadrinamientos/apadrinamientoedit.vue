<template>
	<div>
		<vs-prompt
		@cancel="close"
		@accept="acceptAlert"
		@close="close"
		accept-text="Aceptar"
		cancel-text="Cancelar"
		:is-valid="copia"
		:title= "titulo"
		:active.sync="identificador">

		<div class="con-exemple-prompt">
		</div>
			<template>
				<small class="date-label">Nombre del niño</small>
				<v-select label="nombrecompleto" :options="nino" v-model="nino_idT" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
				<br>
				<small class="date-label">Nombre del padrino</small>
				<v-select label="nombrecompleto" :options="padrino" v-model="padrino_idT" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
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
        nino_id:{default: 0},
        padrino_id:{default:0}
	},
  components: {
    Dropdown,
    Datepicker,
    vSelect,
  },
  data() {
    return {
    
	  idT:0,
	  nombreT:'',
	  nombreTT:'',
	  nombreTTT:'',
      nino_id:0,
      padrino_id:0,
	  nino_nombreE:'',
	  nino_idT:{id:-1,nombres:''},
	  padrino_nombreE:'',
	  padrino_idT:{id:-1,nombres:''},
	  padrino: [],
	  nino: [],
	  titulo: "Editar Apadrinamiento",
	  dateFormat : 'yyyy-MM-dd',
    };
  },
  computed: {
    validName() {
      return true;
    },
	copia() {
		this.importar_nino();
		this.importar_padrino();
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
	traerNombrePadrino(tabla){
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
		}
	},
    async importar_padrino() {
		if(this.$props.identificador==true)
		{
		let me = this;
			let encontrado=false;
			let elementoE={}
			const response = await axios.get(`/api/padrino/get?completo=false`)
			.then(function (response){
				var respuesta = response.data;
				me.padrino = respuesta.padrinos.data;
				me.padrino = me.traerNombrePadrino(me.padrino);
				me.padrino.forEach(function(elemento, indice, array) {
					if (elemento.id==me.$props.padrino_id)
					{	
						elementoE=elemento
						encontrado=true
					}
				})
				
					me.padrino_idT = encontrado == true ? elementoE:{id:me.$props.padrino_id,nombres:'Padrino desactivado'} 
			})
			.catch(function(error) {
			console.log(error);
			});
		}
    },
	acceptAlert () {
        console.log(this.nino_idT)
        console.log(this.padrino_idT)
		axios.put("/api/apadrinamiento/update/",{
			id:this.idT,
			nino_id: this.nino_idT.id,
			padrino_id: this.padrino_idT.id,
		}).then(function(response) {
				console.log(response)
			})
			.catch(function(error) {
			console.log(error)
			});
		this.$vs.notify({
				color:'success',
				title:'Actualización registrada!',
				text:'La acción se realizo exitósamente'
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

      this.$emit("cerrado", "Se cerro el formulario");
    },
	
  },
  mounted() {
    this.importar_nino();
    this.importar_padrino();
  },
};
</script>