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


	</div>
</template>

<script>

import { es } from 'vuejs-datepicker/src/locale'
import axios from 'axios'
import Datepicker from 'vuejs-datepicker'
import { Validator } from 'vee-validate';

export default {
	props:{
		ingresar:{
			default:false
		},
	},
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
	watch: {
		ingresar: function(newVal, oldVal) {
			if (newVal == true){
				this.ingresarEstudio()
			}
		},
		fecha_ingreso(value) {
			this.validator.validate('fecha_ingreso', value);
			this.validateForm();
		},
		total_ingresos(value) {
			this.validator.validate('total_ingresos', value);
			this.validateForm();
		},
		alimentacion(value) {
			this.validator.validate('alimentacion', value);
			this.validateForm();
		},
		situacion_vivienda(value) {
			this.validator.validate('situacion_vivienda', value);
			this.validateForm();
		},
		descripcion_costo(value) {
			this.validator.validate('descripcion_costo', value);
			this.validateForm();
		},
		cantidad_cuartos(value) {
			this.validator.validate('cantidad_cuartos', value);
			this.validateForm();
		},
		bano(value) {
			this.validator.validate('bano', value);
			this.validateForm();
		},
		paredes(value) {
			this.validator.validate('paredes', value);
			this.validateForm();
		},
		techo(value) {
			this.validator.validate('techo', value);
			this.validateForm();
		},
		piso(value) {
			this.validator.validate('piso', value);
			this.validateForm();
		},
		evaluacion_diagnostico(value) {
			this.validator.validate('evaluacion_diagnostico', value);
			this.validateForm();
		},
	},
	methods:{
		getDate(datetime) {
			let date = new Date(datetime);
			let dateString = `${date.getFullYear()}/${date.getMonth() + 1}/${date.getDate()}`;
			return dateString;
		},
		enviando(id){
			this.$emit('recibirEstudio',{id_estudio:id});
		},
		ingresarEstudio(){
			let me = this;
			axios.post("/api/estudioSocioeconomico/post/",{
				fecha_ingreso:this.getDate(this.fecha_ingreso),
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
				me.enviando(response.data.id)
			})
			.catch(function(error) {
				console.log(error)
			});
		},
		validateForm() {
			this.validator.validateAll({
				fecha_ingreso: this.fecha_ingreso,
				total_ingresos: this.total_ingresos,
				alimentacion: this.alimentacion,
				situacion_vivienda: this.situacion_vivienda,
				descripcion_costo: this.descripcion_costo,
				cantidad_cuartos: this.cantidad_cuartos,
				bano: this.bano,
				paredes: this.paredes,
				techo: this.techo,
				piso: this.piso,
				evaluacion_diagnostico: this.evaluacion_diagnostico,
			}).then((result) => {
				if (result ){
					this.$emit('validado',200);
					return;
				}
				this.$emit('validado',400);
			});
		},
		getDate(datetime) {
			let date = new Date(datetime);
			let dateString = `${date.getFullYear()}/${date.getMonth() + 1}/${date.getDate()}`;
			return dateString;
		}
	},
	created() {
		this.validator = new Validator({
			fecha_ingreso: 'required',
			total_ingresos: 'required|numeric',
			alimentacion: 'required',
			situacion_vivienda: 'required',
			descripcion_costo: 'required',
			cantidad_cuartos: 'required|numeric',
			bano: 'required',
			paredes: 'required',
			techo: 'required',
			piso: 'required',
			evaluacion_diagnostico: 'required',
		});
	},
	components: {
		Datepicker,
	},
}
</script>