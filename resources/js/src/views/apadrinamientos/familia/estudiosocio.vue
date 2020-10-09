<template>
	<div>
		<vx-card :title="'codigo de la familia: ' + codigo_familiar">
			<h1> Valor de PPI {{total_ppi}}</h1>
			<h1> Fecha de ultimo PPI: {{fecha_ppi}}</h1>

			<vx-card
    		title="Información de los niños"
    		title-color="warning"
			>
				<vs-list>
					<vs-list-header icon-pack="feather" icon="icon-user" title="Niños apadrinados" color="success"></vs-list-header>
						<div v-for="(nino,id) in listadoNinos" :key="id">
							<div v-if="nino.nino.estado==1">
								<vs-list-item :title="nino.datos_nino[0].nombres + ' ' +nino.datos_nino[0].apellidos" :subtitle="nino.nino.codigo">
									<template slot="avatar">
									<vs-avatar :src="nino.nino.ruta_imagen" color="primary" @click="$router.push('/ver/nino/'+nino.nino_id)"/>
									</template>
								</vs-list-item>
							</div>
						</div>
				</vs-list>
				<vs-list>
					<vs-list-header icon-pack="feather" icon="icon-user" title="Niños no apadrinados" color="danger"></vs-list-header>
						<div v-for="(nino,id) in listadoNinos" :key="id">
							<div v-if="nino.nino.estado==0">
								<vs-list-item :title="nino.datos_nino[0].nombres + ' ' +nino.datos_nino[0].apellidos" :subtitle="nino.nino.codigo">
									<template slot="avatar">
									<vs-avatar :src="nino.nino.ruta_imagen" color="primary" @click="$router.push('/ver/nino/'+nino.nino_id)"/>
									</template>
								</vs-list-item>
							</div>
						</div>
				</vs-list>
			</vx-card>
			<vx-card
			class="mt-6"
    		title="Datos de los familiares"
    		title-color="warning"
			>
				<vs-list>
					<div v-for="(encargado,index2) in listadoFamilia" :key="index2">
						<vs-list-item :title="encargado.datos_encargado[0].nombres + ' ' + encargado.datos_encargado[0].apellidos" :subtitle="encargado.relacion">
							<template slot="avatar">
									<vs-avatar :src="encargado.encargado.ruta_imagen" color="primary" @click="$router.push(url)"/>
							</template>
						</vs-list-item>
					</div>
				</vs-list>
			</vx-card>

			<vx-card
			class="mt-6"
    		title="Información de la familia"
    		title-color="warning"
			>
				<h4>Total de ingresos Q.{{datosEstudio.total_ingresos}} </h4>
				<h4>Alimentación:{{datosEstudio.alimentacion}} </h4>
				<h4>Situacion de la vivienda: {{datosEstudio.situacion_vivienda == 1 ? 'Propia' : datosEstudio.situacion_vivienda== 2 ? 'Alquilada' : 'Prestada' }} </h4>

					<vs-list-header title="Servicios con los que cuenta la vivienda"></vs-list-header>
					<ul class="centerx mt-3">
							<vs-checkbox color="dark" icon-pack="feather" class="mt-2" :icon="datosEstudio.luz ==0 ? 'icon-x' : 'icon-check' " v-model="datosEstudio.luz"     disabled="true">Luz</vs-checkbox>
							<vs-checkbox color="dark" icon-pack="feather" class="mt-2" :icon="datosEstudio.agua ==0 ? 'icon-x' : 'icon-check' " v-model="datosEstudio.agua"    disabled="true">Agua</vs-checkbox>
							<vs-checkbox color="dark" icon-pack="feather" class="mt-2" :icon="datosEstudio.drenaje ==0 ? 'icon-x' : 'icon-check' " v-model="datosEstudio.drenaje" disabled="true">Drenaje</vs-checkbox>
					</ul>
			</vx-card>
		</vx-card>
	</div>
</template>
<script>
import axios from 'axios';
export default {
	data() {
		return {
			nino_id:0,
			codigo_familiar:'',
			historial_id:'',
			datosEstudio:[],
			listadoFamilia:[],
			listadoNinos:[],
			fecha_ppi:'',
			total_ppi:0,
		}
	},
	methods: {
		async index(){
			let datos = this.$route.params.id;
			let me = this;
 			const response = await axios.get(`/api/relacion/get?criterio=codigo&buscar=${datos}&completo=informacion`)
			.then(function (response) {
				var respuesta= response.data;
				me.arrayData = respuesta.relaciones.data;
			})
			.catch(function (error) {
				console.log(error);
			});
		},
		async buscarFamilia(codigo){
			let consulta=[]
			let me = this
			const response = await axios.get(`/api/relacion/get?criterio=codigo&buscar=${codigo}&completo=informacion`)
			.then(function (response) {
				var respuesta= response.data;
				consulta = respuesta.relaciones.data;
				let hash = {};
				let hash2 = {};
				me.listadoFamilia = consulta.filter(o => hash[o.encargado_id] ? false : hash[o.encargado_id] = true);
				me.listadoNinos	  = consulta.filter(o => hash[o.nino_id] ? false : hash[o.nino_id] = true);				
				console.log('listado de ninos')
				console.log(me.listadoNinos)
			})
			.catch(function (error) {
				console.log(error);
			});
		},
		buscarCodigo(){
			let nino_id = this.$route.params.id;
			this.historial_id = this.$route.params.estudio;
			let me = this;
 			axios.get(`/api/relacion/get?criterio=nino_id&buscar=${nino_id}&completo=informacion`)
			.then(function (response) {
				var respuesta= response.data;
				me.arrayData = respuesta.relaciones.data;
				me.codigo_familiar=me.arrayData[0].codigo
				me.buscarFamilia(me.arrayData[0].codigo)
			})
			.catch(function (error) {
				console.log(error);
			});

			axios.get(`/api/historialEstudio/get?criterio=id&buscar=${this.historial_id }&completo=false`)
			.then(function (response){
				var respuesta= response.data;
				me.datosEstudio = respuesta.historialEstudios.data[0].estudio_socieconomico;
				console.log('datos estudio')
				console.log(me.datosEstudio)
			})
			.catch(function (error) {
				console.log(error);
			});

			axios.get(`/api/historialPpi/get?criterio=nino_id&buscar=${nino_id}&completo=false`)
			.then(function (response) {
				var respuesta= response.data.historialPpis.data[0];
				console.log('historialPPI')
				me.fecha_ppi=respuesta.fecha_estudio
				me.total_ppi=respuesta.ppi.total
				console.log(respuesta)
			})
			.catch(function (error) {
				console.log(error);
			});
		},
	},
	mounted() {
		this.buscarCodigo()
		// this.index()
	},

}
</script>