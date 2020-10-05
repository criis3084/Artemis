<template>
	<div>

			<div class="vx-col md:w-1/2 w-full mt-1">
				<div class="my-4">
					<small class="date-label">Fecha de Ingreso</small>
					<datepicker :language="$vs.rtl ? langEn : langEn" name="fecha_ingreso" v-model="fecha_ingreso"></datepicker>
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

			<vs-list>
					<h4> 
					<vs-list-header title="Servicios con los que cuenta la vivienda"></vs-list-header>
					</h4>
					<ul class="centerx mt-3">
							<vs-checkbox color="dark" v-model="luz">Luz</vs-checkbox>
							<vs-checkbox color="dark" v-model="agua">Agua</vs-checkbox>
							<vs-checkbox color="dark" v-model="drenaje">Drenaje</vs-checkbox>
					</ul>
			</vs-list>


			<div class="vx-col md:w-1/2 w-full mt-6">
				<div class="vx-col w-full">
					<small class="date-label">Número de cuartos</small>
					<vs-input class="w-full" icon-pack="feather" icon="icon-box" icon-no-border name='numero_cuartos' v-model="numero_cuartos"/>
				</div>
			</div>

			<div class="vx-col md:w-1/2 w-full mt-6">
				<div class="vx-col w-full">
					<small class="date-label">Baño</small>
					<vs-input class="w-full" icon-pack="feather" icon="icon-droplet" icon-no-border name='bano' v-model="bano"/>
				</div>
			</div>

			<h3 class="date-label">Materiales de construcción</h3>

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


	</div>
</template>

<script>

import { es } from 'vuejs-datepicker/src/locale'
import axios from 'axios'
import Datepicker from 'vuejs-datepicker'


export default {
/*
	props:{
		id_ninos:{
			default:[]
		},
		ingresar:{
			default:false
		},
	},
 */
 	data() {
		return {
			fecha_ingreso:'',
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
		}
	},
	methods:{
		guardar(){
			console.log(this.$props.id_ninos)
			/*
			this.id=parseInt(this.$route.params.id)
			console.log(this.getDate(this.fecha))
			console.log(this.id,this.valorT,this.valor1)
			axios.post("/api/historialPpi/post/",{
				nino_id:this.id,
				respuesta1:this.valor1,
				respuesta2:this.valor2,
				respuesta3:this.valor3,
				respuesta4:this.valor4,
				respuesta5:this.valor5,
				respuesta6:this.valor6,
				respuesta7:this.valor7,
				respuesta8:this.valor8,
				respuesta9:this.valor9,
				respuesta10:this.valor10,
				total:this.valorT,

				fecha_estudio:Date.now() this.getDate(this.fecha)

			}).then(function(response) {
					console.log(response)
					this.$vs.notify({
						color:'success',
						title:'Exito',
						text:'Registro Creado!'
					});
				})
				.catch(function(error) {
				console.log(error)
			});
			*/
		},
		getDate(datetime) {
			let date = new Date(datetime);
			let dateString = `${date.getFullYear()}/${date.getMonth() + 1}/${date.getDate()}`;
			return dateString;
		}
		},
	computed: {

	},
	components: {
		Datepicker,
	},
}
</script>