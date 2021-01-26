<template>
	<vx-card>
		<div class = "demo-alignment">
			<div class="vx-col md:w-1/3 w-full mt-5">
			</div>
			<h3>INGRESO DE EXAMEN</h3>
		</div>

		<vs-divider position="right">PID&#174;</vs-divider>

		<form>
			<div class="vx-row">
				<div class="vx-col md:w-1/2 w-full mt-6">
					<div class="w-full">
						<small class="date-label">Paciente:</small>
						<v-select v-validate="'required'" name="paciente" label="nombre_completo" :options="listado_pacientes" v-model="paciente_select" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
						<span class="text-danger">{{ errors.first('paciente') }}</span>
					</div>
				</div>
				<div class="vx-col md:w-1/2 w-full mt-6">
					<div class="w-full">
						<small class="date-label">Tipo de examen</small>
						<v-select v-validate="'required'" name="tipo" label="nombre" :options="listado_examenes" v-model="tipo_examen" :dir="$vs.rtl ? 'rtl' : 'ltr'"  :disabled="deshabilitado"/>
						<span class="text-danger">{{ errors.first('tipo') }}</span>
					</div>
				</div>	
				<div class="vx-col md:w-1/2 w-full mt-4">
					<div class="vx-col w-full">
						<small class="date-label">Descripción</small>
						<vs-input v-validate="'required'" v-model="descripcion" name="descripcion" class="w-full" icon-pack="feather" icon-no-border :disabled="deshabilitado" />
						<span class="text-danger">{{ errors.first('descripcion') }}</span>
					</div>
				</div>
				<div class="vx-col md:w-1/2 w-full mt-3">
					<small class="date-label">Fecha</small>
					<datepicker v-validate="'required'" :language="$vs.rtl ? langHe : langEn" name="fecha" v-model="fecha_examen" :disabled="deshabilitado"></datepicker>
					<span class="text-danger">{{ errors.first('fecha') }}</span>
				</div>
				<div class="vx-col w-full mb-base mt-3">
					<small class="date-label">Resultado de examen</small>
					<vs-textarea v-validate="'required'" class="w-full" icon-pack="feather" icon="icon-coffee" icon-no-border name='resultado' v-model="resultado" :disabled="deshabilitado"/>
					<span class="text-danger">{{ errors.first('resultado') }}</span>
				</div>
				<vs-upload name="" automatic action="/api/examen/imagen" limit='1' :headers="head" fileName='photos' @on-success="respuesta" @on-delete="vaciar" text="Fotografía de resultado" />
			</div>


			<div class="flex flex-wrap items-center justify-between">
				<vx-input-group class="mb-base mr-3">
				</vx-input-group>
				<div class="flex items-center">
					<vs-button  icon-pack="feather" icon="icon-save" class="mb-base mr-3" type="gradient" color="primary" @click="registrar" :disabled="deshabilitado">Registrar</vs-button>  
				</div>
			</div>
		</form>
	</vx-card>
</template>
<script>
import axios from 'axios'
import vSelect from 'vue-select'
import Datepicker from 'vuejs-datepicker'
import Ls from '../../../services/ls';
// For custom error message
import { Validator } from 'vee-validate'
const dict = {
 custom: {
	fecha: {
      required: 'El campo fecha de nacimiento es requerido',
	},
	paciente:{
	  required: 'El campo paciente es requerido',
	},
	tipo:{
	  required: 'El campo tipo de examen es requerido',
	},	
	descripcion: {
      required: 'El campo descripción es requerido',
    },
	resultado: {
		required: 'El campo resultado de examen es requerido',
	},
  }
}

// register custom messages
Validator.localize('en', dict)
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
			descripcion:null,
			resultado:null,
			langEn: es,
			arrayPersonal:[],
			idMedico:null,
			head:{
				"imagenanterior":""	
			},
			ruta:'',
			fileName: '',
			 formats:['xlsx', 'csv', 'txt'],
      cellAutoWidth: true,
	  selectedFormat: 'xlsx',
	  headerVal: ['id', 'dia_apoyo', 'nombres', 'apellidos', 'numero_telefono', 'nombre_tp'],
	  headerTitle: ['Id', 'Día Apoyo', 'Nombre', 'Apellidos', 'Telefono', 'Tipo Paciente']
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
		vaciar(){
			this.ruta='';
		},
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
				valor.nombre_completo = valor.datos.nombres + ' ' + valor.datos.apellidos
			});
			return tabla
		},
		registrar(){

			if (this.ruta === '' || this.ruta == null){
				this.ruta=null
			}
			else{
				this.ruta = '/storage/public/'  + this.ruta
			}
			this.$validator.validateAll().then(result => {
			if(result) {
				let me = this
				axios.post("/api/examen/post/",{
					descripcion:me.descripcion,
					resultado:me.resultado,
					fecha_examen:me.getDate(me.fecha_examen),
					tipo_examen_id:me.tipo_examen.id,
					ruta_imagen:me.ruta,
					clinico_id:me.idMedico,
				}).then(function(response){
					console.log(response)
					me.registrarHistorial(response.data.id)
					me.$vs.notify({
						color:'success',
						title:'Examen registrado!',
						text:'La acción se realizo exitósamente'
					});
				})
				.catch(function(error) {
					console.log(error)
				});
			}else{
				this.$vs.notify({
					color:'danger',
					title:'Error en validación!',
					text:'Ingrese todos los campos correctamente'
					});
				}
			})
		},
		async buscarDoctor(){
			let idUsuario = parseInt(Ls.get('auth.id_usuario'))
			const me = this
			const response = await axios.get(
				`/api/clinico/get?&criterio=user_id&buscar=${idUsuario}&completo=true`
				)
				.then(function (response) {
					const respuesta = response.data
					me.idMedico = respuesta.clinicos.data[0].id
				})
				.catch(function (error) {
				console.log(error)
				})
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
		respuesta(e){
			this.ruta=e.currentTarget.response.replace(/['"]+/g, '')
			this.head.imagenanterior=this.ruta
			this.$vs.notify({
						color:'success',
						title:'Imagen subida',
						text:'Acción realizada exitósamente!'
					});
			this.boolVal=true;
			this.valImagen='';
		},
	},
	mounted() {
		this.importarPacientes()
		this.importarTipos()
		this.buscarDoctor()
	},
}
</script>