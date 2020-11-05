<template>
	<vx-card>
		<div class="vx-row">
			<div class="vx-col md:w-1/2 w-full mt-6">
				<div class="w-full">
					<small class="date-label">Paciente:</small>
					<v-select v-validate="'required'" label="nombre_completo" :options="listado_pacientes" v-model="paciente_select" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
					<span class="text-danger">{{ errors.first('paciente') }}</span>
				</div>
			</div>
			<div class="vx-col md:w-1/2 w-full mt-6">
				<div class="w-full">
					<small class="date-label">Tipo de Examen:</small>
					<v-select v-validate="'required'" label="nombre" :options="listado_examenes" v-model="tipo_examen" :dir="$vs.rtl ? 'rtl' : 'ltr'"  :disabled="deshabilitado"/>
					<span class="text-danger">{{ errors.first('paciente') }}</span>
				</div>
			</div>	
			<div class="vx-col md:w-1/2 w-full mt-4">
				<div class="vx-col w-full">
					<vs-input v-model="descripcion" name="descripcion" class="w-full" icon-pack="feather" icon="icon-briefcase" icon-no-border label-placeholder="Descripcion" :disabled="deshabilitado" />
				</div>
			</div>
			<div class="vx-col md:w-1/2 w-full mt-3">
				<small class="date-label">Fecha</small>
				<datepicker :language="$vs.rtl ? langHe : langEn" name="end-date" v-model="fecha_examen" :disabled="deshabilitado"></datepicker>
			</div>
			<div class="vx-col w-full mb-base mt-3">
				<small class="date-label">Resultado de examen</small>
				<vs-textarea class="w-full" icon-pack="feather" icon="icon-coffee" icon-no-border name='resultado' v-model="resultado" :disabled="deshabilitado"/>
			</div>
		</div>

		<div class="flex flex-wrap items-center justify-between">
			<vx-input-group class="mb-base mr-3">
			</vx-input-group>
			<div class="flex items-center">
				<vs-button class="mb-base mr-3" type="gradient" icon-pack="feather" color="primary" @click="registrar" :disabled="deshabilitado">Registrar</vs-button>  
			</div>
		</div>

		<!-- <div class="flex flex-wrap items-center justify-between">
          <div class="flex vs-align-left">
			<vs-button type="gradient" icon-pack="feather" icon="icon-save" class="mr-base mb-2" @click="registrar" ></vs-button>
          </div>
		</div> -->
	</vx-card>
</template>
<script>
import axios from 'axios'
import vSelect from 'vue-select'
import { Validator } from 'vee-validate';
import Datepicker from 'vuejs-datepicker'
const dict = {
  custom: {
	paciente: {
	  required: 'El campo paciente es requerido',
	},
	resultado: {
	  required: 'El campo medicamento es requerido',
	},
	descripcion: {
	  required: 'El campo medicamento es requerido',
	},
	tipo_examen: {
	  required: 'El campo medicamento es requerido',
	},
  }
}
Validator.localize('es', dict)
import { es } from 'vuejs-datepicker/src/locale'
export default {
	data() {
		return {
			listado_pacientes:[],
			listado_examenes:[],
			tipo_examen:null,
			paciente_select:null,
			deshabilitado:true,
			fecha_examen:null,
			descripcion:'',
			resultado:'',
			langEn: es,
		}
	},
	watch: {
		paciente_select(){
			if(this.paciente_select !=null)
			{
				this.deshabilitado = false
			}
			else{
				this.deshabilitado = true
			}		
		}
	},
	components:{
		vSelect,
		Datepicker,
	},
	methods: {
		getDate(datetime) {
			let date = new Date(datetime);
			let dateString = `${date.getFullYear()}/${date.getMonth() + 1}/${date.getDate()}`;
			return dateString;
		},
		async importarPacientes() {
			let me = this;
			const response = await axios.get(
				`/api/paciente/get?completo=false`)
			.then(function (response) {
				const respuesta = response.data
				me.listado_pacientes = me.traerNombre(respuesta.pacientes.data)
			})
			.catch(function (error) {
				console.log(error)
			})
			this.fecha_examen= new Date()
		},
		traerNombre(tabla){
			tabla.forEach(function(valor, indice, array){
				valor.nombres = valor.datos.nombres
				valor.apellidos = valor.datos.apellidos
				valor.nombre_completo = valor.datos.nombres + ' '+ valor.datos.apellidos
			});
			return tabla
		},
		registrar(){
			let me = this
			axios.post("/api/examen/post/",{
				descripcion:me.descripcion,
				resultado:me.resultado,
				fecha_examen:me.getDate(me.fecha_examen),
				tipo_examen_id:this.tipo_examen.id,
				clinico_id:1,
			}).then(function(response){
				console.log(response)
				me.registrarHistorial(response.data.id)
			})
			.catch(function(error) {
				console.log(error)
			});
		},
		registrarHistorial(idExamen){
			let me = this
			axios.post("/api/historialExamen/post/",{
				examen_id:idExamen,
				paciente_id:me.paciente_select.id,
			}).then(function(response){
				console.log(response)
				location.reload();
			})
			.catch(function(error) {
				console.log(error)
			});
		},

		async importarTipos(){
			let me = this;
			this.abrir_editar=false
			const response = await axios.get(
				`/api/tipoExamen/get?completo=false`)
			.then(function (response) {
				var respuesta= response.data;
				me.listado_examenes = respuesta.tipoExamenes.data;
			})
			.catch(function (error) {
				console.log(error);
			});
		},
	},
	mounted() {
		this.importarPacientes()
		this.importarTipos()
	},
}
</script>