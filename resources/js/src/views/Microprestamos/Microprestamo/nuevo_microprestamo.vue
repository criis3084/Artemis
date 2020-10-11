<template>
	<vx-card>
		<h1>nuevo microprestamo</h1>
		<v-select label="nombre" :options="listado_grupos" v-model="grupo_select" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
	</vx-card>
</template>
<script>
import axios from "axios";
import vSelect from 'vue-select'
export default {
	data() {
		return {
			listado_grupos:[],
			grupo_select:{},
		};
	},
	components: {
		vSelect
	},
	methods: {
		async importarGrupos(){ 
				let me = this;
				const response = await axios.get(`/api/grupoPrestamo/get?completo=false`)
				.then(function (response) {
					var respuesta= response.data;
					console.log(respuesta)
					me.listado_grupos = respuesta.grupos.data;
					console.log(me.listado_grupos)
				})
				.catch(function (error) {
					console.log(error);
				});
		},
	},
	mounted(){
		this.importarGrupos();
		//this.importarIntegra();
	},
}
</script>