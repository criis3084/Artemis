<template>
	<div>
		<div class="demo-alignment">
				<h2>Sectores</h2>
				<vx-tooltip text="Agregar nuevo registro"><vs-button radius type="gradient" icon-pack="feather" icon="icon-plus" @click="abrirPrompt = true" color="primary" size='large' ></vs-button> </vx-tooltip>
		</div>

		<vs-prompt
			@cancel="close"
			@accept="guardarSector"
			@close="close"
			accept-text="Aceptar"
			cancel-text="Cancelar"
			:is-valid="validName"
			:title= "titulo"
			:active.sync="abrirPrompt"
		>
			<div class="con-exemple-prompt">
				<b></b>				
				<vs-input type="text" placeholder="Nombre del sector" v-model="sector" class="mt-4 mb-2 col-1 w-full" />
			</div>

			<template>
				<v-select label="nombre" :options="listado_aldeas" v-model="aldea_id" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
			</template>
			 
			<vs-alert :active="!validName" color="danger" vs-icon="new_releases" class="mt-4" >
				LLene todos los campos
			</vs-alert>
		</vs-prompt>
	</div>
</template>

<script>
import Datepicker from 'vuejs-datepicker'
import axios from 'axios'
import Dropdown from '@/views/components/vuesax/dropdown/Dropdown.vue'
import vSelect from 'vue-select'


export default {
	components: {
		Dropdown,
		Datepicker,
		vSelect,
	//	VeeValidate,
		//Vue,
	},
	data () {
		return {
			abrirPrompt:false,
			sector:'',
			aldea_id:0,
			listado_aldeas: [],
			selected: '',
			titulo:'Nuevo Sector'
		}
	},
	computed:{
		validName () {
			return this.sector.length > 0 && this.aldea_id != 0 
		}
	},
	methods:{
		async importar_aldeas(){ //async para que se llame cada vez que se necesite
			let me = this;
			const response = await axios.get(`/api/aldea/get?completo=false`)
			.then(function (response) {
				var respuesta= response.data;
				me.listado_aldeas = respuesta.aldeas.data;
			})
			.catch(function (error) {
				console.log(error);
			});
		},
		close () {
			this.sector = ''
			this.$emit('cerrado','Se cerro el formulario');
		},
		guardarSector(){
			axios.post("/api/sector/post/",{
				nombre:this.sector,
				aldea_id:this.aldea_id.id
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
			 this.sector = '';
			  this.aldea_id = '';
			this.$emit('cerrado','Se cerro el formulario');
		},
	},
	mounted(){
		this.importar_aldeas();
	}
}
</script>