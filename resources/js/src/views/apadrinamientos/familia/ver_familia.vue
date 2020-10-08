<template>
	<vx-card>
		<div>

			<vs-list>
				<vs-list-header icon-pack="feather" icon="icon-users" title="Familiares" color="danger"></vs-list-header>
				<div v-for="(encargado,index2) in listadoFamilia" :key="index2">
					<vs-list-item :title="encargado.datos_encargado[0].nombres + ' ' + encargado.datos_encargado[0].apellidos" :subtitle="encargado.relacion">
						<template slot="avatar">
								<vs-avatar :src="encargado.encargado.ruta_imagen" color="primary" @click="$router.push(url)"/>
						</template>
					</vs-list-item>
				</div>
					<!-- Division :v -->
			</vs-list>

			<vs-list>
				<vs-list-header icon-pack="feather" icon="icon-user" title="Niños" color="warning"></vs-list-header>
				<div v-for="(nino,idn) in listadoNinos" :key="idn">
					<vs-list-item :title="nino.datos_nino[0].nombres + ' ' +nino.datos_nino[0].apellidos" :subtitle="nino.nino.codigo">
						<template slot="avatar">
						<vs-avatar :src="nino.nino.ruta_imagen" color="primary" @click="$router.push('/ver/nino/'+nino.nino_id)"/>
						</template>
					</vs-list-item>
				</div>
			</vs-list>

			<vs-button class="mr-4" type="gradient" icon-pack="feather" color="success" icon="icon-edit" @click="$router.push('/apadrinamiento/ppi/'+ninoP)">Registros del PPI</vs-button>
			<vs-button class="mr-4 mt-3" type="gradient" icon-pack="feather" color="success" icon="icon-edit" @click="$router.push('/editar/ninono/'+ninoP)">Registros de Estudios Socioeconomicos</vs-button>  
                    <router-link to="/apadrinamiento/familia"><vs-button class="mr-4 mt-3" type="gradient" icon-pack="feather" color="primary" icon="icon-corner-down-left"> Regesar</vs-button></router-link>
		</div>
	</vx-card>
</template>
<script>
import axios from 'axios'

export default {
	data(){
		return{
			arrayData:[],
			listadoFamilia:[],
			listadoNinos:[],
			ninoP:0
		}
	},
	computed:{
		verNino(nino) {
    		  return '/ver/nino/'+nino
	    }
	},
	components:{

	},
	methods:{
		setearValor(unArreglo){
			this.listadoFamilia=unArreglo.slice();
			this.listadoNinos=unArreglo.slice();
			let hash = {};
			this.listadoNinos = this.listadoNinos.filter(o => hash[o.nino_id] ? false : hash[o.nino_id] = true);
			let hash2 = {};
			this.listadoFamilia = this.listadoFamilia.filter(o => hash2[o.encargado_id] ? false : hash2[o.encargado_id] = true);
			this.ninoP=this.listadoNinos[0].nino_id
		},
		async index(){
			let datos = this.$route.params.id;
			let me = this;
 			const response = await axios.get(`/api/relacion/get?criterio=codigo&buscar=${datos}&completo=informacion`)
			.then(function (response) {
				var respuesta= response.data;
				me.arrayData = respuesta.relaciones.data;
				me.setearValor(me.arrayData)
			})
			.catch(function (error) {
				console.log(error);
			});
		},
	},
	mounted(){
    	this.index();
  	}
}
</script>