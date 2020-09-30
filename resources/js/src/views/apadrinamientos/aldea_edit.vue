<template>
 <div>
    <vs-prompt
      @cancel="clearValMultiple"
      @accept="actualizarAldea"
      @close="close"
	  accept-text="Aceptar"
	  cancel-text="Cancelar"
      :is-valid="copia"
	  :title= "titulo"
      :active.sync="identificador">
      <div class="con-exemple-prompt">
        <b></b>
			
		<vs-input placeholder="Nombre de la aldea" v-model="nombreT" class="mt-4 mb-2 col-1 w-full" />

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
	},
	components: {
	Dropdown,
	Datepicker,
	vSelect,
	},
	data () {
		return {
			idT:0,
			nombreT:'',
			titulo:'Actualizar Aldea'
		}
	},
	computed:{
		validName(){
			return true;
		},
		copia() {
			this.nombreT =this.$props.nombre;
			this.idT =this.$props.id;
			return true;	
		}
	},
	methods:{
		actualizarAldea () {
			axios.put("/api/aldea/update/",{
				id:this.idT,
				nombre:this.nombreT,
			}).then(function(response) {
				console.log(response)
			})
			.catch(function(error) {
				console.log(error)
			});
			this.$vs.notify({
				color:'success',
				title:'Creado',
				text:'El registro ha sido actualizado'
			})
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
	}
}
</script>