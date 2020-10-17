<template>
	<div>
		<div class="demo-alignment">
			<h2>Categorías Medicamentos</h2>
			<vx-tooltip text="Agregar nuevo registro"><vs-button radius type="gradient" icon-pack="feather" icon="icon-plus" @click="activePrompt2 = true" color="primary" size='large' ></vs-button> </vx-tooltip>
		</div>
		<br>
		<vs-prompt
			@cancel="close"
			@close="close"
			@accept="acceptAlert"
			:is-valid="validName"
			:title= "titulo"
			:active.sync="activePrompt2"
		>
			<div class="con-exemple-prompt">
				<b></b>

				<vs-input placeholder="Nombre de la Categoría" v-model="valMultipe.value1" class="mt-4 mb-2 col-1 w-full" />
                <vs-input placeholder="Descripción" v-model="valMultipe.value2" class="mt-4 mb-2 col-1 w-full" />

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
        value1:'',
        value2:''
	  },
	 titulo:'Nueva Categoría'
	}
  },
  computed:{
	validName () {
	  return this.valMultipe.value1.length >0 && this.valMultipe.value2.length >0
	}
  },
  methods:{
	acceptAlert () {
		axios.post("/api/categoriaMedicamento/post/",{
            nombre:this.valMultipe.value1,
            descripcion:this.valMultipe.value2,
		}).then(function(response) {
			console.log(response)
		})
		.catch(function(error) {
			console.log(error)
		});
		this.$vs.notify({
			color:'success',
			title:'Creado',
			text:'El registro ha sido creado!'
		})
        this.valMultipe.value1 = '';
        this.valMultipe.value2 = ''
		this.$emit('cerrado','Se cerro el formulario');
	},
	close(){
        this.valMultipe.value1 = ''
        this.valMultipe.value2 = ''
		this.$emit('cerrado','Se cerro el formulario');
	},
  }
}
</script>