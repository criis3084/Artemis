<template>
	<div>
		<vx-card>
			<div class="vx-col md:w-1/2 w-full mt-1">
				<div class="my-4">
					<small class="date-label">Fecha de estudio</small>
					<datepicker :language="$vs.rtl ? langEn : langEn" name="fecha_estudio" v-model="fecha_estudio"></datepicker>
				</div>
			</div>

			<div class="vx-col md:w-1/2 w-full mt-6">
				<div class="vx-col w-full">
					<small class="date-label">Total de ingresos mensuales</small>
					<vs-input class="w-full" icon-pack="feather" icon="icon-dollar-sign" icon-no-border name='total_ingresos' v-model="total_ingresos"/>
				</div>
			</div>

			<div class="vx-col md:w-1/2 w-full mt-6">
				<div class="vx-col w-full">
					<small class="date-label">Alimentación</small>
					<vs-textarea class="w-full" icon-pack="feather" icon="icon-user" icon-no-border name='alimentacion' v-model="alimentacion"/>
				</div>
			</div>

			<vs-list>
					<h4> 
					<vs-list-header title="Situación de la vivienda"></vs-list-header>
					</h4>
					<ul class="centerx mt-3">
							<vs-radio color="success" class="m-3" v-model="situacion_vivienda" vs-value="101"> Propia </vs-radio>
							<vs-radio color="success" class="m-3" v-model="situacion_vivienda" vs-value="102"> Alquilada  </vs-radio>
							<vs-radio color="success" class="m-3" v-model="situacion_vivienda" vs-value="103"> Prestada </vs-radio>
					</ul>
			</vs-list>

			<div class="vx-col md:w-1/2 w-full mt-6">
				<div class="vx-col w-full">
					<vs-input class="w-full" icon-pack="feather" icon="icon-dollar-sign" icon-no-border label-placeholder="Costos de la vivienda" name='descripcion_costo' v-model="descripcion_costo"/>
				</div>
			</div>

			<vs-list class="mt-6">
					<h4> 
					<vs-list-header title="Servicios con los que cuenta la vivienda"></vs-list-header>
					</h4>
					<ul class="centerx mt-3">
							<vs-checkbox color="dark" class="mt-2" v-model="luz">Luz</vs-checkbox>
							<vs-checkbox color="dark" class="mt-2" v-model="agua">Agua</vs-checkbox>
							<vs-checkbox color="dark" class="mt-2" v-model="drenaje">Drenaje</vs-checkbox>
					</ul>
			</vs-list>


			<div class="vx-col md:w-1/2 w-full mt-6">
				<div class="vx-col w-full">
					<small class="date-label">Número de cuartos</small>
					<vs-input class="w-full" icon-pack="feather" icon="icon-box" icon-no-border name='cantidad_cuartos' v-model="cantidad_cuartos"/>
				</div>
			</div>

			<div class="vx-col md:w-1/2 w-full mt-6">
				<div class="vx-col w-full">
					<small class="date-label">Baño</small>
					<vs-input class="w-full" icon-pack="feather" icon="icon-droplet" icon-no-border name='bano' v-model="bano"/>
				</div>
			</div>

			<h4>
				<vs-list-header class="mt-6" title="Materiales de construcción"></vs-list-header>
			</h4>

			<div class="vx-col md:w-1/2 w-full mt-6">
				<div class="vx-col w-full">
					<small class="date-label">paredes</small>
					<vs-input class="w-full" icon-pack="feather" icon="icon-grid" icon-no-border name='paredes' v-model="paredes"/>
				</div>
			</div>
			<div class="vx-col md:w-1/2 w-full mt-6">
				<div class="vx-col w-full">
					<small class="date-label">Techo</small>
					<vs-input class="w-full" icon-pack="feather" icon="icon-arrow-up" icon-no-border name='techo' v-model="techo"/>
				</div>
			</div>
			<div class="vx-col md:w-1/2 w-full mt-6">
				<div class="vx-col w-full">
					<small class="date-label">Piso</small>
					<vs-input class="w-full" icon-pack="feather" icon="icon-arrow-down" icon-no-border name='piso' v-model="piso"/>
				</div>
			</div>

			<div class="vx-col w-full mt-6">
				<div class="vx-col w-full">
					<small class="date-label">Evaluación general de diagnostico</small>
					<vs-textarea class="w-full" icon-pack="feather" icon="icon-edit" icon-no-border name='evaluacion_diagnostico' v-model="evaluacion_diagnostico"/>
				</div>
			</div>

				<div class="flex flex-wrap items-center justify-between mt-2">
					<vx-input-group class="mb-base mr-3">
						<vs-button type="gradient" icon-pack="feather" color="success" @click="$router.push('/apadrinamiento/estudiosocio/'+id)">Regesar</vs-button>  
					</vx-input-group>
	
					<div class="flex items-center">
						<vs-button  class="mb-base mr-3" @click="ingresarEstudio">Registrar Estudio socioeconomico</vs-button>
					</div>
				</div>
		</vx-card>


	</div>
</template>

<script>

import { es } from 'vuejs-datepicker/src/locale'
import axios from 'axios'
import Datepicker from 'vuejs-datepicker'

export default {
	data() {
		return {
			estudio_id:0,
			fecha_estudio:'',
			total_ingresos:0,
			alimentacion:'',
			situacion_vivienda:0,
			descripcion_costo:'',
			luz:0,
			agua:0,
			drenaje:0,
			cantidad_cuartos:0,
			bano:'',
			paredes:'',
			techo:'',
			piso:'',
			evaluacion_diagnostico:'',
			langEn: es,
			codigo_familiar:0,
			id:0
		}
	},
	methods: {
		getDate(datetime) {
			let date = new Date(datetime);
			let dateString = `${date.getFullYear()}/${date.getMonth() + 1}/${date.getDate()}`;
			return dateString;
		},
		enviando(id){
			this.estudio_id=id;
		},
		buscarHermanos(codigoT){
			let me = this;
			console.log('Buscando hermanos del codigo ' + codigoT)
			axios.get(`/api/relacion/get?criterio=codigo&buscar=${codigoT}&completo=informacion`)
			.then(function (response) {
				var respuesta= response.data;
				me.arrayData = respuesta.relaciones.data;
				me.setearValor(me.arrayData)
			})
			.catch(function (error) {
				console.log(error);
			});
		},
		setearValor(unArreglo){
			this.listadoNinos=unArreglo.slice();
			let hash = {};
			this.listadoNinos = this.listadoNinos.filter(o => hash[o.nino_id] ? false : hash[o.nino_id] = true);
			let estudioT=this.estudio_id
			this.listadoNinos.forEach(function(elemento, indice, array) {
					axios.post("/api/historialEstudio/post/",{
						nino_id:elemento.nino_id,
						estudio_id:estudioT,
					}).then(function(response) {
							console.log('es aqui donde se traba?')
							console.log(response)
					})
						.catch(function(error) {
						console.log(error)
					});
			})
			this.$router.push('/apadrinamiento/estudiosocio/'+this.id);
		},
		buscarCodigo(){
			let nino_id = this.$route.params.id;
			let me = this;
			axios.get(`/api/relacion/get?criterio=nino_id&buscar=${nino_id}&completo=informacion`)
			.then(function (response) {
				var respuesta= response.data;
				me.arrayData = respuesta.relaciones.data;

				me.buscarHermanos(me.arrayData[0].codigo)
			})
			.catch(function (error) {
				console.log(error);
			});
		},
		ingresarEstudio(){
			let me = this;
			axios.post("/api/estudioSocioeconomico/post/",{
				fecha_estudio:this.getDate(this.fecha_estudio),
				total_ingresos:this.total_ingresos,
				alimentacion:this.alimentacion,
				situacion_vivienda:this.situacion_vivienda-100,
				descripcion_costo:this.descripcion_costo,
				luz:this.luz,
				agua:this.agua,
				drenaje:this.drenaje,
				cantidad_cuartos:this.cantidad_cuartos,
				bano:this.bano,
				paredes:this.paredes,
				techo:this.techo,
				piso:this.piso,
				evaluacion_diagnostico:this.evaluacion_diagnostico
			}).then(function(response) {
				console.log('respuesta del estudio')
				console.log(response)
				me.enviando(response.data.id)
			})
			.catch(function(error) {
				console.log(error)
			});
			this.buscarCodigo()
		},
	},
	components:{
		Datepicker,
	},
	mounted() {
		this.id=parseInt(this.$route.params.id)
	},
}
</script>