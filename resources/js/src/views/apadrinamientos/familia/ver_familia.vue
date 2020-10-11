<template>
	<vx-card>
		<div>

			<!-- <vs-list>
				<vs-list-header icon-pack="feather" icon="icon-users" title="Familiares" color="danger"></vs-list-header>
				<div v-for="(encargado,index2) in listadoFamilia" :key="index2">
					<vs-list-item :title="encargado.datos_encargado[0].nombres + ' ' + encargado.datos_encargado[0].apellidos" :subtitle="encargado.relacion">
						<template slot="avatar">
								<vs-avatar :src="encargado.encargado.ruta_imagen" color="primary" @click="$router.push(url)"/>
						</template>
					</vs-list-item>
				</div>
			</vs-list> -->

			<div id="demo-basic-card">
			<!-- USER PRODFILE CARD -->
			<h1>Familiares</h1>
			<div class="vx-row">
            <div  class="vx-col w-full lg:w-1/3 sm:w-1/2 mb-base">
                <vx-card v-for="(encargado,index2) in listadoFamilia" :key="index2" class="p-2">
                    <div class="text-center">
                        <h4>{{ encargado.datos_encargado[0].nombres + ' ' + encargado.datos_encargado[0].apellidos }}</h4>
                        <p class="text-grey">{{ encargado.datos_encargado[0].codigo }}</p>
                    </div>
                    <vs-avatar @click="$router.push('/ver/familiar/'+encargado.encargado_id)" class="mx-auto my-6 block" size="80px" :src="encargado.encargado.ruta_imagen" />
                </vx-card>
            </div>
			</div>
			<vs-divider/>
			<!-- USER PRODFILE CARD -->
			<h1>Niños</h1>
            <div v-for="(nino,idn) in listadoNinos" :key="idn" class="vx-col w-full lg:w-1/3 sm:w-1/2 mb-base">
                <vx-card class="p-2">
                    <div class="text-center">
                        <h4>{{ nino.datos_nino[0].nombres + ' ' +nino.datos_nino[0].apellidos }}</h4>
                        <p class="text-grey">{{ nino.nino.codigo }}</p>
                    </div>
                    <vs-avatar @click="$router.push('/ver/nino/'+nino.nino_id)" class="mx-auto my-6 block" size="80px" :src="nino.nino.ruta_imagen" />
                </vx-card>
            </div>
			</div>
			<!-- <vs-list>
				<vs-list-header icon-pack="feather" icon="icon-user" title="Niños" color="warning"></vs-list-header>
				<div v-for="(nino,idn) in listadoNinos" :key="idn">
					<vs-list-item :title="nino.datos_nino[0].nombres + ' ' +nino.datos_nino[0].apellidos" :subtitle="nino.nino.codigo">
						<template slot="avatar">
						<vs-avatar :src="nino.nino.ruta_imagen" color="primary" @click="$router.push('/ver/nino/'+nino.nino_id)"/>
						</template>
					</vs-list-item>
				</div>
			</vs-list> -->

			<vs-button class="mr-4" type="gradient" icon-pack="feather" color="success" icon="icon-edit" @click="$router.push('/apadrinamiento/ppi/'+ninoP)">Registros del PPI</vs-button>
			<vs-button class="mr-4 mt-3" type="gradient" icon-pack="feather" color="success" icon="icon-edit" @click="$router.push('/apadrinamiento/estudiosocio/'+ninoP)">Registros de Estudios Socioeconomicos</vs-button>  
			<vs-button @click="goBack" class="mr-4 mt-3" type="gradient" icon-pack="feather" color="primary" icon="icon-corner-down-left"> Regesar</vs-button>
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
		goBack(){
      		this.$router.go(-1)
    	},
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