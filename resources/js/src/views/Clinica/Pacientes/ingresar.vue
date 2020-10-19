<template>
	<vx-card>

		<h1>Ingreso de nuevo paciente</h1>


		<div class="vx-col md:w-1/2 w-full mt-5">
			<small class="date-label">Información</small>
			<ul class="demo-alignment">
					<li>
						<vs-radio color="success" v-model="tipo_lectura" vs-value="1">Paciente comun</vs-radio>
					</li>
						<vs-radio color="success" v-model="tipo_lectura" vs-value="2">Paciente de Modulo de apadrinamiento</vs-radio>
					<li>
					</li>
			</ul>
		</div>

		<div v-if="tipo_lectura==1">
			<div class="vx-row">

				<div class="vx-col md:w-1/2 w-full mt-5">
					<div class="vx-col w-full">
						<vs-input class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="Nombres" name="nombres" v-model="nombres" v-validate="'required'"/>
						<span class="text-danger">{{ errors.first('step-1.nombres') }}</span>
					</div>
				</div>

				<div class="vx-col md:w-1/2 w-full mt-5">
					<div class="vx-col w-full">
						<vs-input class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="Apellidos" v-model="apellidos" name="apellidos" v-validate="'required'"/>
						<span class="text-danger">{{ errors.first('step-1.apellidos') }}</span>
					</div>
				</div>
				<div class="vx-col md:w-1/2 w-full mt-5">
					<div class="vx-col w-full">
						<vs-input class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="DPI" v-model="CUI" name="CUI" v-validate="'required'"/>
						<span class="text-danger">{{ errors.first('step-1.dpi') }}</span>
					</div>
				</div>

				<div class="vx-col md:w-1/2 w-full mt-5">
					<small class="date-label">Género</small>
					<ul class="demo-alignment">
							<li>
								<vs-radio color="rgb(0, 170, 228)" v-model="genero" vs-value="1">Masculino</vs-radio>
							</li>
							<li>
								<vs-radio color="rgb(255, 0, 128)" v-model="genero" vs-value="0">Femenino</vs-radio>
							</li>
					</ul>
				</div>

				<div class="vx-col md:w-1/2 w-full mt-1">
					<div class="my-4">
						<small class="date-label">Fecha Nacimiento</small>
						<datepicker :language="$vs.rtl ? langEn : langEn" name="fecha_nacimiento" v-model="fecha_nacimiento"></datepicker>
					</div>
				</div>

				<div class="vx-col md:w-1/2 w-full mt-5">
					<div class="vx-col w-full">
						<vs-input class="w-full" icon-pack="feather" icon="icon-phone" icon-no-border label-placeholder="Dirección" v-model="direccion"/>
					</div>
				</div>

				<div class="vx-col md:w-1/2 w-full mt-5">
					<div class="vx-col w-full">
						<vs-input class="w-full" icon-pack="feather" icon="icon-phone" icon-no-border label-placeholder="Número de teléfono" v-model="numero_telefono"/>
					</div>
				</div>

				
				<div class="vx-col md:w-1/2 w-full mt-3">
					<div class="vx-col w-full">
						<small class="date-label">Sector de Vivienda</small>
						<v-select label="nombre" :options="sectores" class="mt-1"  v-model="sector_id" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
					</div>
				</div>
			</div>
		</div>
		<div v-else>

				<div class="vx-col md:w-1/2 w-full mt-3">
					<div class="vx-col w-full">
						<small class="date-label">Personas en el programa</small>
						<v-select label="nombreCompleto" :options="listado_personas" class="mt-1"  v-model="persona_id" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
					</div>
				</div>

				<div v-if="persona_id!==null">
					<div class="vx-col md:w-1/2 w-full mt-5">
						<small class="date-label">Tipo de paciente</small>
						<v-select label="nombre" :options="listado_tipos" class="mt-1"  v-model="tipo_paciente_id" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
					</div>

					<div v-if="tipo_paciente_id.id!=1" class="mt-8">
						<div class="vx-col md:w-1/2 w-full mt-3">
							<small class="date-label mt-6">Día de entrega de beneficios</small>
								<v-select style="width:30%" label="mostrar" :options="dia_del_mes" v-model="dia_apoyo" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
							<br>
						</div>
						<div class="vx-col md:w-1/2 w-full mt-3">
							<div class="vx-col w-full">
								<small class="date-label">Listado de medicamento de entrega</small>
								<v-select label="nombre" :options="listado_medicamentos" class="mt-1"  v-model="medicamento_id" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
							</div>
						</div>

						<div class="vx-col w-full mt-6">
							<div class="vx-col w-full">
								<small class="date-label">Descripción de los beneficios</small>
								<vs-textarea class="w-full" icon-pack="feather" icon="icon-edit" icon-no-border name='descripcion' v-model="descripcion"/>
							</div>
						</div>
					</div>
				</div>
		</div>
			<div class="vx-row">
          		<div class="vx-col sm:w-2/3 w-full ml-auto">
            		<vs-button class="mr-3 mb-2" @click="guardarPersona">Guardar</vs-button>
          		</div>
	        </div>
	</vx-card>
</template>

<script>
import axios from 'axios'
import vSelect from 'vue-select'
import Datepicker from 'vuejs-datepicker'
import { es } from 'vuejs-datepicker/src/locale'

export default {
	data() {
		return {
			nombres:'',
			apellidos:'',
			CUI:'',
			genero:'',
			fecha_nacimiento:'',
			direccion:'',
			numero_telefono:'',
			descripcion:'',
			sectores:[],
			listado_ninos:[],
			listado_encargados:[],
			listado_personas:[],
			listado_tipos:[],
			listado_pacientes:[],
			sector_id:null,
			persona_id:null,
			medicamento_id:null,
			tipo_paciente_id:null,
			langEn: es,
			tipo_lectura:1,
			tipo_paciente:1,
			dia_del_mes:[],
			dia_apoyo:0,
			fecha_apoyo:'',
			listado_medicamentos:[],
		}
	},
	watch: {
		persona_id(){
    	},  
	},
	methods: {
		getDate (datetime) {
			const date = new Date(datetime)
			const dateString = `${date.getFullYear()}/${date.getMonth() + 1}/${date.getDate()}`
			return dateString
		},
		getNow(){
			let fecha_pago=''
			const today = new Date()
			const todaySin = new Date(today.getFullYear(),today.getMonth(),today.getDate())
			const datePago = todaySin
			datePago.setDate(this.dia_apoyo.id)
			console.log(todaySin)
			if (todaySin >= datePago) {
				fecha_pago=todaySin.setMonth(todaySin.getMonth()+1)
			}
			else{
				fecha_pago=datePago
			}
			return fecha_pago
		},
		guardarDetalleBeneficios(beneficios){
			console.log('Intentando guardar el detalle de beneficios de')
			console.log(beneficios)
		},
		guardarBeneficios(paciente){
			let me2=this
			let pagoT= me2.getDate(me2.getNow());
			axios.post('/api/beneficio/post/', {
				fecha_entrega:pagoT,
				descripcion:me2.descripcion,
				paciente_id:paciente,
			}).then(function (response){
				me2.guardarDetalleBeneficios(response.data.id)
			})
		},
		guardarPaciente(persona){
			let tipoT= this.tipo_paciente_id.id
			if (tipoT ==1)
			{
				axios.post('/api/paciente/post/', {
					dia_apoyo:0,
					persona_sin_acceso_id:persona,
					tipo_paciente_id:tipoT,
				}).then(function (response){
					console.log('paciente guardado')
				})
			}
			else if (tipoT !== 1){
				let me=this
				axios.post('/api/paciente/post/', {
					dia_apoyo:me.dia_apoyo.id,
					persona_sin_acceso_id:persona,
					tipo_paciente_id:tipoT,
				}).then(function (response){
					me.guardarBeneficios(response.data.id)
				})
			}
		},
		guardarPersona(){
			let me = this
			if(this.tipo_lectura==1){
				axios.post('/api/personaSinAcceso/post/', {
					nombres:me.nombres,
					apellidos:me.apellidos,
					CUI:me.CUI,
					genero:me.genero,
					direccion:me.direccion,
					numero_telefono:me.numero_telefono,
					sector_id:me.sector_id.id,
					fecha_nacimiento:me.getDate(me.fecha_nacimiento),
				}).then(function (response){
					me.guardarPaciente(response.data.id)
				})
			}else{
					me.guardarPaciente(this.persona_id.persona_sin_acceso_id)
			}
		},
		diaMes(){
			for (let i = 1; i <= 28; i++) {
				this.dia_del_mes.push({id:i,mostrar:i})
			}
		},
		traerNombre (tabla) {
			tabla.forEach(function (valor, indice, array){
				valor.id_encargado = null
				valor.nombres = valor.datos.nombres
				valor.apellidos = valor.datos.apellidos
				valor.nombreCompleto = valor.datos.nombres + ' '+ valor.datos.apellidos
				valor.fecha_nacimiento = valor.datos.fecha_nacimiento
			})
			return tabla
		},
		traerNombreE (tabla) {
			tabla.forEach(function (valor, indice, array) {
				valor.id_encargado = valor.id
				valor.id = valor.id+100000
				valor.apellidos = valor.datos.apellidos
				valor.nombreCompleto = valor.datos.nombres + ' '+ valor.datos.apellidos
				valor.fecha_nacimiento = valor.datos.fecha_nacimiento
			}) 
			return tabla
		},
		async importarSectores(){
			let me = this;
			const response = await axios.get(
			`/api/sector/get?&completo=select`)
			.then(function (response) {
				var respuesta= response.data;
				me.sectores = respuesta.sectores.data;
			})
			.catch(function (error) {
				console.log(error);
			});
		},
		async importarNinos(){
			let me = this;
			const response = await axios.get(
				`/api/nino/get?completo=false`)
			.then(function (response) {
				var respuesta= response.data;
				me.listado_ninos = respuesta.ninos.data;
				me.nino = me.traerNombre(me.listado_ninos)
				me.importarEncargados(me.nino)
			})
			.catch(function (error) {
				console.log(error);
			});
		},
		async importarTiposPaciente(){
			let me = this;
			const response = await axios.get(
				`/api/tipoPaciente/get?completo=false`)
			.then(function (response) {
				var respuesta= response.data;
				me.listado_tipos = respuesta.tipoPacientes.data;
				me.tipo_paciente_id=me.listado_tipos[me.listado_tipos.length-1]
			})
			.catch(function (error) {
				console.log(error);
			});
		},
		importarEncargados(ninos){
			let me = this;
			let listadoCompleto=[]
			axios.get(`/api/encargado/get?completo=false`)
			.then(function (response) {
				var respuesta= response.data;
				me.listado_encargados = respuesta.encargados.data;
				me.encargado = me.traerNombreE(me.listado_encargados)
				listadoCompleto = listadoCompleto.concat(ninos,me.encargado);
				me.importarPacientes(listadoCompleto)
				me.listado_personas = listadoCompleto
			})
			.catch(function (error) {
				console.log(error);
			});
		},
		importarPacientes(personas){
			let me3=this
			let hash2 = {}
			axios.get(`/api/paciente/get?completo=false`)
			.then(function (response) {
				var respuesta= response.data;
				me3.listado_pacientes = respuesta.pacientes.data
				me3.listado_pacientes = me3.listado_pacientes.filter(o => hash2[o.persona_sin_acceso_id] ? false : hash2[o.persona_sin_acceso_id] = true)
				me3.listadoPlus(me3.listado_pacientes,personas)
			})
			.catch(function (error) {
				console.log(error);
			});
		},
		async importarMedicamentos() {
			let me = this;
			const response = await axios
			.get(`/api/medicamento/get?completo=true`)
			.then(function(response) {
				var respuesta = response.data;
				me.listado_medicamentos = respuesta.medicamentos.data;
			})
			.catch(function(error) {
				console.log(error);
			});
		},
		listadoPlus (pacientes,personas) {
			var encontrado =''
			const nuevasPersonas = []
			personas.forEach(function (elemento, indice, array) {
				encontrado = pacientes.find(element => element.persona_sin_acceso_id === elemento.persona_sin_acceso_id)
				if (encontrado == undefined) {
					nuevasPersonas.push(elemento)
				}
			})
			this.listado_personas=nuevasPersonas
		},
	},
	mounted() {
		this.diaMes();
		this.importarSectores();
		this.importarNinos();
		this.importarMedicamentos();
		this.importarTiposPaciente();
	},
	components:{
		Datepicker,
	    vSelect
	}
}
</script>