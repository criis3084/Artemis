<template>
	<div>
		<vs-prompt
			@cancel="clearValMultiple"
			@accept="editarAldea"
			@close="close"
			accept-text="Aceptar"
			cancel-text="Cancelar"
			:is-valid="copia"
			:title= "titulo"
			:active.sync="identificador"
		>
			
			<div class="con-exemple-prompt">
				<b></b>
					
				<vs-input placeholder="Nombre del sector" v-model="nombreT" class="mt-4 mb-2 col-1 w-full" />

				<vs-alert color="danger" vs-icon="new_releases" class="mt-4" >
					LLene todos los campos
				</vs-alert>
			</div>

			<template>
				<v-select label="nombre" :options="listado_aldeas" v-model="aldea_idT" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
			</template> 
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
		aldea_id:{default: 0},
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
			aldea_idT:0,
			listado_aldeas: [],
			selected: '',
			titulo:'Actualizar Sector'
		}
	},
  computed:{
		validName(){
			return true;
		},
		copia() {
			this.nombreT =this.$props.nombre;
			this.idT =this.$props.id;
			this.aldea_idT =this.$props.aldea_id;
			return true;	
		}
	},
  methods:{
	async importar_aldeas(){ 
		let me = this;
		const response = await axios.get(
			`/api/aldea/get?todos=false`)
		.then(function (response) {
			var respuesta= response.data;
			me.listado_aldeas = respuesta.aldeas.data;
			me.pagination= respuesta.pagination;
		})
		.catch(function (error) {
			console.log(error);
		});
	},
	editarAldea () {
		axios.put("/api/sector/update/",{
			id:this.idT,
			nombre:this.nombreT,
			aldea_id:this.aldea_idT.id
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
			title:'Closed',
			text:'You close a dialog!'
		})
	},
	clearValMultiple () {
		this.nombreT='';
		this.$emit('cerrado','Se cerró el formulario');
	},
  },
  mounted(){
    this.importar_aldeas();
  },
}
</script>