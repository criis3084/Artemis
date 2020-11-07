<template>
	<div>
			<div class="vx-col md:w-1/2 w-full mt-1">
				<div class="my-4">
					<small class="date-label">Fecha de Estudio</small>
					<datepicker :language="$vs.rtl ? langEn : langEn" name="fecha_boleta" v-model="fecha_boleta"></datepicker>
            		<div v-if="VALfecha_boleta"><span class="text-danger">{{ VALfecha_boleta }}</span><br></div>
				
				</div>
			</div>

			<div class="vx-col md:w-1/2 w-full mt-6">
				<small class="date-label">Total de ingresos mensuales</small>
				<vx-input-group class="mb-base">
   				 <template slot="prepend">	
				<div class="prepend-text bg-primary" >
					<span>Q</span>	
				</div>
				<div class="vx-col w-full">
					<vs-input class="w-full" icon-no-border name='total_ingresos' v-model="total_ingresos"/>
            		<div v-if="VALtotal_ingresos"><span class="text-danger">{{ VALtotal_ingresos }}</span><br></div>
            		<div v-if="VALtotal_ingresos2"><span class="text-danger">{{ VALtotal_ingresos2 }}</span><br></div>
            		<div v-if="VALtotal_ingresos3"><span class="text-danger">{{ VALtotal_ingresos3 }}</span><br></div>


				</div>
				</template>
  				</vx-input-group>
			</div>

			<div class="vx-col md:w-1/2 w-full mt-6">
				<div class="vx-col w-full">
					<small class="date-label">Alimentación</small>
					<vs-textarea class="w-full" icon-pack="feather" icon="icon-user" icon-no-border name='alimentacion' v-model="alimentacion"/>
					<div v-if="VALalimentacion"><span class="text-danger">{{ VALalimentacion }}</span><br></div>
            		<div v-if="VALalimentacion2"><span class="text-danger">{{ VALalimentacion2 }}</span><br></div>

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
            		<div v-if="VALsituacion_vivienda"><span class="text-danger">{{ VALsituacion_vivienda }}</span><br></div>
			</vs-list>

			<div class="vx-col md:w-1/2 w-full mt-6">
				<small class="date-label">Costos de la vivienda</small>
				<vx-input-group class="mb-base">
   				 <template slot="prepend">	
				<div class="prepend-text bg-primary" >
					<span>Q</span>	
				</div>
				<div class="vx-col w-full">
					<vs-input class="w-full" name='descripcion_costo' v-model="descripcion_costo"/>
					<div v-if="VALdescripcion_costo"><span class="text-danger">{{ VALdescripcion_costo }}</span><br></div>
            		<div v-if="VALdescripcion_costo2"><span class="text-danger">{{ VALdescripcion_costo2 }}</span><br></div>
            		<div v-if="VALdescripcion_costo3"><span class="text-danger">{{ VALdescripcion_costo3 }}</span><br></div>

				</div>
				</template>
  				</vx-input-group>
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
					<div v-if="VALcantidad_cuartos"><span class="text-danger">{{ VALcantidad_cuartos }}</span><br></div>
            		<div v-if="VALcantidad_cuartos2"><span class="text-danger">{{ VALcantidad_cuartos2 }}</span><br></div>
            		<div v-if="VALcantidad_cuartos3"><span class="text-danger">{{ VALcantidad_cuartos3 }}</span><br></div>

				</div>
			</div>

			<div class="vx-col md:w-1/2 w-full mt-6">
				<div class="vx-col w-full">
					<small class="date-label">Baño</small>
					<vs-input class="w-full" icon-pack="feather" icon="icon-droplet" icon-no-border name='bano' v-model="bano"/>
					<div v-if="VALbano"><span class="text-danger">{{ VALbano }}</span><br></div>
            		<div v-if="VALbano2"><span class="text-danger">{{ VALbano2 }}</span><br></div>

				</div>
			</div>

			<h4>
				<vs-list-header class="mt-6" title="Materiales de construcción"></vs-list-header>
			</h4>

			<div class="vx-col md:w-1/2 w-full mt-6">
				<div class="vx-col w-full">
					<small class="date-label">paredes</small>
					<vs-input class="w-full" icon-pack="feather" icon="icon-grid" icon-no-border name='paredes' v-model="paredes"/>
					<div v-if="VALparedes"><span class="text-danger">{{ VALparedes }}</span><br></div>
            		<div v-if="VALparedes2"><span class="text-danger">{{ VALparedes2 }}</span><br></div>

				</div>
			</div>
			<div class="vx-col md:w-1/2 w-full mt-6">
				<div class="vx-col w-full">
					<small class="date-label">Techo</small>
					<vs-input class="w-full" icon-pack="feather" icon="icon-arrow-up" icon-no-border name='techo' v-model="techo"/>
					<div v-if="VALtecho"><span class="text-danger">{{ VALtecho }}</span><br></div>
            		<div v-if="VALtecho2"><span class="text-danger">{{ VALtecho2 }}</span><br></div>

				</div>
			</div>
			<div class="vx-col md:w-1/2 w-full mt-6">
				<div class="vx-col w-full">
					<small class="date-label">Piso</small>
					<vs-input class="w-full" icon-pack="feather" icon="icon-arrow-down" icon-no-border name='piso' v-model="piso"/>
					<div v-if="VALpiso"><span class="text-danger">{{ VALpiso }}</span><br></div>
            		<div v-if="VALpiso2"><span class="text-danger">{{ VALpiso2 }}</span><br></div>

				</div>
			</div>

			<div class="vx-col w-full mt-6">
				<div class="vx-col w-full">
					<small class="date-label">Evaluación general de diagnóstico</small>
					<vs-textarea class="w-full" icon-pack="feather" icon="icon-edit" icon-no-border name='evaluacion_diagnostico' v-model="evaluacion_diagnostico"/>
					<div v-if="VALevaluacion_diagnostico"><span class="text-danger">{{ VALevaluacion_diagnostico }}</span><br></div>
            		<div v-if="VALevaluacion_diagnostico2"><span class="text-danger">{{ VALevaluacion_diagnostico2 }}</span><br></div>

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
			VALfecha_boleta:'',
			VALtotal_ingresos:'',
			VALtotal_ingresos2:'',
			VALtotal_ingresos3:'',
			VALalimentacion:'',
			VALalimentacion2:'',
			VALsituacion_vivienda:'',
			VALdescripcion_costo:'',
			VALdescripcion_costo2:'',
			VALdescripcion_costo3:'',
			VALluz:'',
			VALagua:'',
			VALdrenaje:'',
			VALcantidad_cuartos:'',
			VALcantidad_cuartos2:'',
			VALcantidad_cuartos3:'',
			VALbano:'',
			VALbano2:'',
			VALparedes:'',
			VALparedes2:'',
			VALtecho:'',
			VALtecho2:'',
			VALpiso:'',
			VALpiso2:'',
			VALevaluacion_diagnostico:'',
			VALevaluacion_diagnostico2:'',



			fecha_boleta:null,
			total_ingresos:null,
			alimentacion:null,
			situacion_vivienda:null,
			descripcion_costo:null,
			luz:0,
			agua:0,
			drenaje:0,
			cantidad_cuartos:null,
			bano:null,
			paredes:null,
			techo:null,
			piso:null,
			evaluacion_diagnostico:null,
			langEn: es,
		}
	},
	watch: {
		ingresar: function(newVal, oldVal) {
			if (newVal == true){
				this.ingresarEstudio()
			}
		},
		fecha_boleta(value) {
			this.validator.validate('fecha_boleta', value);
			this.validateForm();
			this.fecha_boleta = value;
			this.validatefecha_boleta(value);
		},
		total_ingresos(value) {
			this.validator.validate('total_ingresos', value);
			this.validateForm();
			this.total_ingresos = value;
			this.validatetotal_ingresos(value);
		},
		alimentacion(value) {
			this.validator.validate('alimentacion', value);
			this.validateForm();
			this.alimentacion = value;
			this.validatealimentacion(value);
		},
		situacion_vivienda(value) {
			this.validator.validate('situacion_vivienda', value);
			this.validateForm();
			this.situacion_vivienda = value;
			this.validatesituacion_vivienda(value);
		},
		descripcion_costo(value) {
			this.validator.validate('descripcion_costo', value);
			this.validateForm();
			this.descripcion_costo = value;
			this.validatedescripcion_costo(value);
		},
		cantidad_cuartos(value) {
			this.validator.validate('cantidad_cuartos', value);
			this.validateForm();
			this.cantidad_cuartos = value;
			this.validatecantidad_cuartos(value);
		},
		bano(value) {
			this.validator.validate('bano', value);
			this.validateForm();
			this.bano = value;
			this.validatebano(value);
		},
		paredes(value) {
			this.validator.validate('paredes', value);
			this.validateForm();
			this.paredes = value;
			this.validateparedes(value);
		},
		techo(value) {
			this.validator.validate('techo', value);
			this.validateForm();
			this.techo = value;
			this.validatetecho(value);
		},
		piso(value) {
			this.validator.validate('piso', value);
			this.validateForm();
			this.piso = value;
			this.validatepiso(value);
		},
		evaluacion_diagnostico(value) {
			this.validator.validate('evaluacion_diagnostico', value);
			this.validateForm();
			this.evaluacion_diagnostico = value;
			this.validateevaluacion_diagnostico(value);
		},
	},
	methods:{
		camposCambioEstado(){
			this.fecha_boleta="1"
			this.total_ingresos="1"
			this.alimentacion="1"
			this.situacion_vivienda="1"
			this.descripcion_costo="1"
			this.cantidad_cuartos="1"
			this.bano="1"
			this.paredes="1"
			this.techo="1"
			this.piso="1"
			this.evaluacion_diagnostico="1"
		},
		camposCambioEstado2(){
			this.fecha_boleta=""
			this.total_ingresos=""
			this.alimentacion=""
			this.situacion_vivienda=""
			this.descripcion_costo=""
			this.cantidad_cuartos=""
			this.bano=""
			this.paredes=""
			this.techo=""
			this.piso=""
			this.evaluacion_diagnostico=""
		},
	validatefecha_boleta(value){
	if (value=="")
		{
			this.VALfecha_boleta = 'El campo fecha de estudio es requerido';
		} else{
			this.VALfecha_boleta = '';
		} 
	},
	validatesituacion_vivienda(value){
	if (value=="")
		{
			this.VALsituacion_vivienda = 'Seleccione una opción';
		} else{
			this.VALsituacion_vivienda = '';
		} 
	},
	validatetotal_ingresos(value){
    if (/^[0-9 ]*$/.test(value))
		{
			this.VALtotal_ingresos = '';
		} else{
			this.VALtotal_ingresos = 'El campo solo debe de contener números';
		} 
	if (value.length<7)
		{
			this.VALtotal_ingresos2 = '';
		} else{
			this.VALtotal_ingresos2 = 'Este campo solo acepta hasta 6 caracteres';
		} 
	if (value=="")
		{
			this.VALtotal_ingresos3 = 'El campo total de ingresos mensuales es requerido';
		} else{
			this.VALtotal_ingresos3 = '';
		} 
	},
	validatedescripcion_costo(value){
    if (/^[0-9 ]*$/.test(value))
		{
			this.VALdescripcion_costo = '';
		} else{
			this.VALdescripcion_costo = 'El campo solo debe de contener números';
		} 
	if (value.length<7)
		{
			this.VALdescripcion_costo2 = '';
		} else{
			this.VALdescripcion_costo2 = 'Este campo solo acepta hasta 6 caracteres';
		} 
	if (value=="")
		{
			this.VALdescripcion_costo3 = 'El campo costos de la vivienda es requerido';
		} else{
			this.VALdescripcion_costo3 = '';
		} 
	},
	validatecantidad_cuartos(value){
		if (/^[0-9 ]*$/.test(value))
		{
			this.VALcantidad_cuartos = '';
		} else{
			this.VALcantidad_cuartos = 'El campo solo debe de contener números';
		} 
	if (value.length<151)
		{
			this.VALcantidad_cuartos2 = '';
		} else{
			this.VALcantidad_cuartos2 = 'Este campo solo acepta hasta 2 dígitos';
		} 
	if (value=="")
		{
			this.VALcantidad_cuartos3 = 'El campo número de cuartos es requerido';
		} else{
			this.VALcantidad_cuartos3 = '';
		} 
	},
	validatealimentacion(value){
	if (value.length<255)
		{
			this.VALalimentacion = '';
		} else{
			this.VALalimentacion = 'Este campo solo acepta hasta 254 caracteres';
		} 
	if (value=="")
		{
			this.VALalimentacion2 = 'El campo alimentación es requerido';
		} else{
			this.VALalimentacion2 = '';
		} 
	},
	validatebano(value){
	if (value.length<151)
		{
			this.VALbano = '';
		} else{
			this.VALbano = 'Este campo solo acepta hasta 150 caracteres';
		} 
	if (value=="")
		{
			this.VALbano2 = 'El campo baño es requerido';
		} else{
			this.VALbano2 = '';
		} 
	},
	validateparedes(value){
	if (value.length<151)
		{
			this.VALparedes = '';
		} else{
			this.VALparedes = 'Este campo solo acepta hasta 150 caracteres';
		} 
	if (value=="")
		{
			this.VALparedes2 = 'El campo paredes es requerido';
		} else{
			this.VALparedes2 = '';
		} 
	},
	validatetecho(value){
	if (value.length<151)
		{
			this.VALtecho = '';
		} else{
			this.VALtecho = 'Este campo solo acepta hasta 150 caracteres';
		} 
	if (value=="")
		{
			this.VALtecho2 = 'El campo techo es requerido';
		} else{
			this.VALtecho2 = '';
		} 
	},
	validatepiso(value){
	if (value.length<151)
		{
			this.VALpiso = '';
		} else{
			this.VALpiso = 'Este campo solo acepta hasta 150 caracteres';
		} 
	if (value=="")
		{
			this.VALpiso2 = 'El campo piso es requerido';
		} else{
			this.VALpiso2 = '';
		} 
	},
	validateevaluacion_diagnostico(value){
	if (value.length<255)
		{
			this.VALevaluacion_diagnostico = '';
		} else{
			this.VALevaluacion_diagnostico = 'Este campo solo acepta hasta 254 caracteres';
		} 
	if (value=="")
		{
			this.VALevaluacion_diagnostico2 = 'El campo evaluación general de diagnóstico es requerido';
		} else{
			this.VALevaluacion_diagnostico2 = '';
		} 
	},
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
				fecha_boleta:this.getDate(this.fecha_boleta),
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
				fecha_boleta: this.fecha_boleta,
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
	},
	mounted(){
		this.camposCambioEstado();
		this.camposCambioEstado2();
	},
	created() {
		this.validator = new Validator({
			fecha_boleta: 'required',
			total_ingresos: 'required|numeric|max:6',
			alimentacion: 'required|max:254',
			situacion_vivienda: 'required',
			descripcion_costo: 'required|numeric|max:6',
			cantidad_cuartos: 'required|numeric|max:150',
			bano: 'required|max:150',
			paredes: 'required|max:150',
			techo: 'required|max:150',
			piso: 'required|max:150',
			evaluacion_diagnostico: 'required|max:254',
		});
	},
	components: {
		Datepicker,
	},
}
</script>