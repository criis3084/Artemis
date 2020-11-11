<template>
	<div>
		<div class="demo-alignment">
			<h2>Aldeas</h2>
			<vx-tooltip text="Agregar nuevo registro"><vs-button radius type="gradient" icon-pack="feather" icon="icon-plus" @click="activePrompt2 = true" color="primary" size='large' ></vs-button> </vx-tooltip>
		</div>
		<vs-prompt
			@cancel="close"
			@close="close"
			@accept="acceptAlert"
			:is-valid="validName"
			:title= "titulo"
			accept-text="Aceptar"
			cancel-text="Cancelar"
			:active.sync="activePrompt2"
		>
			<div class="con-exemple-prompt">
				<b></b>
<small>Nombre</small>
				<vs-input placeholder="Nombre de la aldea" v-model="valMultipe.value1" class="mt-4 mb-2 col-1 w-full" />

				<vs-alert :active="!validName" color="danger" vs-icon="new_releases" class="mt-4" >
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
  components: {
	Dropdown,
	Datepicker,
	vSelect,
  },
  data () {
	return {
	  activePrompt2:false,
	  valMultipe:{
		value1:''
	  },
	 titulo:'Nueva aldea'
	}
  },
  computed:{
	validName () {
	  return this.valMultipe.value1.length >0
	}
  },
  methods:{
	acceptAlert () {
		axios.post("/api/aldea/post/",{
			nombre:this.valMultipe.value1,
		}).then(function(response) {
			console.log(response)
		})
		.catch(function(error) {
			console.log(error)
		});
		let titulo = 'Aldea registrada';
			this.$vs.notify({
			color:'success',
			title:`${titulo}`,
			text:'La acción se realizo exitósamente'
		})
		this.valMultipe.value1 = '';
		this.$emit('cerrado','Se cerro el formulario');
	},
	close(){
		this.valMultipe.value1 = ''
		this.$emit('cerrado','Se cerro el formulario');
		this.$vs.notify({
        color: "danger",
        title: "Cerrado",
        text: "Diálogo cerrado!",
      })
	},
  }
}
</script>