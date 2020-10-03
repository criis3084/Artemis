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
			</div>
				<template>
					<v-select label="nombre" :options="listado_aldea" v-model="aldea_idT" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
				</template> 
				<vs-alert color="danger" vs-icon="new_releases" class="mt-4" >
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
			aldea_idE:0,
			aldea_nombreE:'',
			aldea_idT:{id:-1,nombre:''},
			listado_aldea: [],
			titulo:'Actualizar Sector',
		}
	},
  	computed:{
		copia() {
			this.importar_aldea()
			return true 
		}
	},
	methods:{
		async importar_aldea(){ 
			if(this.$props.identificador==true)
			{
				let me = this;
				let encontrado=false;
				let elementoE={}
				const response = await axios.get(`/api/aldea/get?completo=false`)
				.then(function (response) {
					var respuesta= response.data;
					me.listado_aldea = respuesta.aldeas.data;
					
					me.listado_aldea.forEach(function(elemento, indice, array) {
						if (elemento.id==me.$props.aldea_id)
						{
							elementoE=elemento
							encontrado=true
						}
					})
					me.aldea_idT = encontrado == true ? elementoE:{id:me.$props.aldea_id,nombre:'Aldea desactivada'} 
					me.idT =me.$props.id;
					me.nombreT =me.$props.nombre;

				})
				.catch(function (error) {
					console.log(error);
				});
			}
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