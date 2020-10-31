<template>
	<div>
		<vs-prompt
			@cancel="close"
			@accept="actualizarEscuela"
			@close="close"
			accept-text="Aceptar"
			cancel-text="Cancelar"
			:is-valid="copia"
			:title= "titulo"
			:active.sync="identificador"
		>
			<div class="con-exemple-prompt">
				<b></b>
				<vs-input placeholder="Nombre del Tipo de Cita: " v-model="nombreT" class="mt-4 mb-2 col-1 w-full" />
				<vs-input placeholder="Descripción" v-model="descripcionT" class="mt-4 mb-2 col-1 w-full" />
				<vs-alert color="danger" vs-icon="new_releases" class="mt-4" >
					LLene todos los campos
				</vs-alert>
			</div>
		</vs-prompt>
	</div>
</template>

<script>
import Datepicker from 'vuejs-datepicker'
import axios from 'axios'
//C:\laragon\www\PFV1\resources\js\src\views\components\vuesax\dropdown\Dropdown.vue
import Dropdown from '@/views/components/vuesax/dropdown/Dropdown.vue'
import vSelect from 'vue-select'

export default {
	props:{
		identificador:{
			default:false
		},
	    id:{default: 0},
		nombre:String,
		descripcion:String,
	},
	components: {
	Dropdown,
	Datepicker,
	vSelect,
  },
  data () {
	return {
	  val:'',
	  valMultipe:{
		value1:'',
		value2:''
	  },
	  idT:0,
      nombreT:'',
      descripcionT:'',
	  selected: '',
	  switch2:true,
	  titulo:'Actualizar Tipo de Cita'
	}
  },
  computed:{
	copia() {
        this.nombreT =this.$props.nombre;
        this.descripcionT =this.$props.descripcion;
		this.idT =this.$props.id;
		return true;	
	}
  },
  methods:{
	actualizarEscuela () {
	axios.put("/api/tipoCita/update/",{
		id:this.idT,
        nombre:this.nombreT,
        descripcion:this.descripcionT,
		}).then(function(response) {
			console.log(response)
		})
		.catch(function(error) {
			console.log(error)
		});
		this.$emit('cerrado','Se cerró el formulario');
	},
	close () {
		this.$emit('cerrado','Se cerró el formulario');
		this.$vs.notify({
			color:'danger',
			title:'Cerrado',
			text:'Diálogo cerrado!'
	  	})
	},
	clearValMultiple () {
		this.$emit('cerrado','Se cerró el formulario');
	},
  },
  mounted(){
  },
}
</script>