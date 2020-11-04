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
				<small class="date-label">Fecha</small>
				<datepicker :language="$vs.rtl ? langHe : langEn" name="end-date" v-model="fecha_consulta" :disabled="deshabilitado"></datepicker>
			</div>
		</div>
		<div class="vx-col md:w-1/2 w-full mt-8">
			<div class="vx-col w-full">
				<vs-input v-model="descripcion" name="descripcion" class="w-full" icon-pack="feather" icon="icon-briefcase" icon-no-border label-placeholder="Descripcion" :disabled="deshabilitado" />
			</div>
		</div>
		<div class="vx-row">
			<div class="vx-col md:w-1/3 w-full mt-6" v-if="embarazada">
				<div class="vx-col w-full">
					<small class="date-label">Semanas de embarazo</small>
					<vs-input class="w-full" icon-pack="feather" icon="icon-arrow-down" icon-no-border name='semanas_embarazo' v-model="semanas_embarazo" :disabled="deshabilitado"/>
				</div>
			</div>
			<div class="vx-col md:w-1/3 w-full mt-6" v-if="diabetico">
				<div class="vx-col w-full">
					<small class="date-label">Glicemia</small>
					<vs-input class="w-full" icon-pack="feather" icon="icon-arrow-down" icon-no-border name='glicemia' v-model="glicemia" :disabled="deshabilitado"/>
				</div>
			</div>
		</div>
		<div class="vx-row">
			<div class="vx-col md:w-1/3 w-full mt-6">
				<div class="vx-col w-full">
					<small class="date-label">Peso</small>
					<vs-input class="w-full" icon-pack="feather" icon="icon-arrow-down" icon-no-border name='peso_actual' v-model="peso_actual" :disabled="deshabilitado"/>
				</div>
			</div>
			<div class="vx-col md:w-1/3 w-full mt-6">
				<div class="vx-col w-full">
					<small class="date-label">Talla</small>
					<vs-input class="w-full" icon-pack="feather" icon="icon-arrow-down" icon-no-border name='talla' v-model="talla" :disabled="deshabilitado"/>
				</div>
			</div>
			<div class="vx-col md:w-1/3 w-full mt-6">
				<div class="vx-col w-full">
					<small class="date-label">Temperatura</small>
					<vs-input class="w-full" icon-pack="feather" icon="icon-arrow-down" icon-no-border name='temperatura' v-model="temperatura" :disabled="deshabilitado"/>
				</div>
			</div>
		</div>
		<div class="vx-row">
			<div class="vx-col md:w-1/3 w-full mt-6">
				<div class="vx-col w-full">
					<small class="date-label">Respiración</small>
					<vs-input class="w-full" icon-pack="feather" icon="icon-arrow-down" icon-no-border name='respiracion' v-model="respiracion" :disabled="deshabilitado"/>
				</div>
			</div>
			<div class="vx-col md:w-1/3 w-full mt-6">
				<div class="vx-col w-full">
					<small class="date-label">Pulso</small>
					<vs-input class="w-full" icon-pack="feather" icon="icon-arrow-down" icon-no-border name='pulso' v-model="pulso" :disabled="deshabilitado"/>
				</div>
			</div>
			<div class="vx-col md:w-1/3 w-full mt-6">
				<div class="vx-col w-full">
					<small class="date-label">Presion Arterial</small>
					<vs-input class="w-full" icon-pack="feather" icon="icon-arrow-down" icon-no-border name='presion_arterial' v-model="presion_arterial" :disabled="deshabilitado"/>
				</div>
			</div>
		</div>

		<div class="vx-row mt-5">
			<small class="date-label ml-4">Objetivo de la consulta</small>
			<vs-textarea class="w-full mr-4 ml-4" icon-pack="feather" icon="icon-coffee" icon-no-border name='objetivo' v-model="objetivo" :disabled="deshabilitado"/>
		</div>
		<div class="vx-row">
			<small class="date-label ml-4">Subjetivo de la consulta</small>
			<vs-textarea class="w-full mr-4 ml-4" icon-pack="feather" icon="icon-coffee" icon-no-border name='objetivo' v-model="subjetivo" :disabled="deshabilitado"/>
		</div>

		<div v-if="verReceta">
			<vs-divider position="center" class="mt-6" > Medicamentos Recetados </vs-divider>
			<div class="vx-col md:w-1/2 w-full mt-3">
				<div class="vx-col w-full">
					<small class="date-label">Lista de medicamentos:</small>
					<v-select v-if="this.carrito.length==0" name="medicamento" v-validate="'required'" label="nombre_completo" :options="listado_medicamentos" class="mt-1"  v-model="medicamento_id" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
					<v-select v-if="this.carrito.length>0" name="medicamento" label="nombre_completo" :options="listado_medicamentos" class="mt-1"  v-model="medicamento_id" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
					<span class="text-danger">{{ errors.first('medicamento') }}</span>
					<small class="date-label" v-if="medicamento_id != null"><p class="text-danger">Existencia: {{stockId}}</p></small>
				</div>
			</div>
			<br>
			<vs-list>
				<div class="vx-col w-full mb-base">
						<table style="width:100%" class="border-collapse">
								<tr>
									<th class="p-2 border border-solid d-theme-border-grey-light text-center">Eliminar</th>
									<th class="p-2 border border-solid d-theme-border-grey-light text-center">Nombre Medicamento</th>
									<th class="p-2 border border-solid d-theme-border-grey-light text-center">Cantidad</th>
									<th class="p-2 border border-solid d-theme-border-grey-light text-center">Frecuencia</th>
								</tr>
								<tr v-for="(producto,index) in carrito" :key="index">
									<td class="border border-solid d-theme-border-grey-light flex items-center">
										<vs-button color="danger" type="border" icon-pack="feather" class="center" icon="icon-x-circle" @click="borrarIntegrante(index)"></vs-button>
									</td>
									<td class="border border-solid d-theme-border-grey-light text-center"> {{producto.nombre_completo}}<small class="date-label"><p class="text-warning">(Stock actual: {{producto.stock_general}})</p></small></td>
									<td class="border border-solid d-theme-border-grey-light">
										<vs-input name="cantidad" v-validate="'required|max:5|numeric'" style="text-align:right" v-model="listaCantidades[index]" />
									</td>
									<td class="border border-solid d-theme-border-grey-light">
										<vs-input name="frecuencia" v-validate="'required|max:5|numeric'" style="text-align:right" v-model="listaFrecuencias[index]" />
									</td>
								</tr>
						</table>
					<span class="text-danger">{{ errors.first('cantidad') }}</span>
				</div>
			</vs-list>
			<div class="vx-row">
				<small class="date-label ml-4">Anotaciones de la receta</small>
				<vs-textarea class="w-full mr-4 ml-4" icon-pack="feather" icon="icon-coffee" icon-no-border name='listado' v-model="listado"/>
			</div>
		</div>

        <div class="flex flex-wrap items-center justify-between mt-5">
			<vs-button type="gradient" color="success" icon-pack="feather" icon="icon-save" class="mr-base mb-2" @click="anadirReceta" v-if="!verReceta" :disabled="deshabilitado">Añadir receta</vs-button>
			<vs-button type="gradient" color="danger" icon-pack="feather" icon="icon-save" class="mr-base mb-2" @click="anadirReceta" v-if="verReceta" :disabled="deshabilitado">Eliminar Receta</vs-button>
          <div class="flex items-center">
			<vs-button type="gradient" color="success" icon-pack="feather" icon="icon-save" class="mr-base mb-2" @click="anadirReceta" v-if="imprimir" :disabled="deshabilitado">Imprimir</vs-button>
			<vs-button type="gradient" icon-pack="feather" icon="icon-save" class="mr-base mb-2" @click="registrar" v-if="!imprimir" :disabled="deshabilitado">Registrar</vs-button>
          </div>
        </div>

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
	medicamento: {
	  required: 'El campo medicamento es requerido',
	},
	cantidad: {
	  required: 'Todos los campos de cantidad son requeridos',
	  numeric: 'Los campos de cantidad solo deben de contener números',
	    max: 'Los campos de cantidad solo aceptan hasta 5 caracteres',
    },	
  }
}
Validator.localize('es', dict)
import { es } from 'vuejs-datepicker/src/locale'
export default {
	data() {
		return {
			listado_pacientes:[],
			paciente_select:null,
			objetivo:'',
			subjetivo:'',
			descripcion:'',
			peso_actual:null,
			talla:null,
			temperatura:null,
			respiracion:null,
			pulso:null,
			presion_arterial:null,
			semanas_embarazo:null,
			glicemia:null,
			deshabilitado:true,
			embarazada:false,
			diabetico:false,
			fecha_consulta:'',
			langEn: es,
			listado_medicamentos:null,
			verReceta:false,
			// ---- Receta ----//
			listaCantidades:[],
			listaFrecuencias:[],
			medicamento_id:null,
			carrito:[],
			listado:'',
			imprimir:false,
		}
	},
	components:{
		vSelect,
		Datepicker,
	},
	watch:{ 
		paciente_select(){
			if(this.paciente_select !=null)
			{
				this.deshabilitado = false
				console.log(this.paciente_select)
				if(this.paciente_select.tipo_paciente_id==3)
				{
					this.embarazada=true
					this.diabetico=false
				}
				else if( this.paciente_select.tipo_paciente_id==4)
				{
					this.diabetico=true
					this.embarazada=false
				}
				else{
					this.diabetico=false
					this.embarazada=false
				}
			}
			else{
				this.verReceta=false
				this.deshabilitado = true
			}
		},
		medicamento_id(){
			this.stockId = this.medicamento_id.stock_general
			if (this.medicamento_id != null)
			{
				this.carrito.push(this.medicamento_id)
				console.log('carrito y cantidades')
				console.log(this.listaCantidades)
				console.log(this.listaFrecuencias)
				// this.listaCantidades.push(0)
			}
		}
	},
	methods: {
		anadirReceta(){
			this.verReceta=!this.verReceta
		},
		borrarIntegrante (index) {
			this.carrito.splice(index, 1)
			this.listaCantidades.splice(index, 1)
			this.listaFrecuencias.splice(index, 1)
			console.log(this.carrito)
			console.log(this.listaCantidades)
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
			this.fecha_consulta= new Date()
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
			axios.post("/api/historialClinico/post/",{
				fecha_consulta: me.getDate(me.fecha_consulta),
				descripcion:me.descripcion,
				peso_actual:me.peso_actual,
				glicemia:me.glicemia,
				semanas_embarazo:me.semanas_embarazo,
				talla:me.talla,
				pulso:me.pulso,
				respiracion:me.respiracion,
				temperatura:me.temperatura,
				presion_arterial:me.presion_arterial,
				objetivo:me.objetivo,
				subjetivo:me.subjetivo,
				clinico_id:1,
				paciente_id:me.paciente_select.id,
			}).then(function(response){
				console.log(response)
				location.reload();
			})
			.catch(function(error) {
				console.log(error)
			});
		},
		getDate(datetime) {
			let date = new Date(datetime);
			let dateString = `${date.getFullYear()}/${date.getMonth() + 1}/${date.getDate()}`;
			return dateString;
		},
		async importarMedicamentos() {
			let me = this;
			const response = await axios
			.get(`/api/medicamento/get?completo=true`)
			.then(function(response) {
				var respuesta = response.data;
				me.listado_medicamentos = respuesta.medicamentos.data;
				me.listado_medicamentos = me.traerNombreMedicamento(me.listado_medicamentos)
			})
			.catch(function(error) {
				console.log(error);
			});
		},
		traerNombreMedicamento(tabla){
			for (let i in tabla) {
				let valor = tabla[i]
				tabla[i].nombre_completo = valor.nombre + ' - ' + valor.casa_medica.nombre
			}
			return tabla
		},
	},
	mounted() {
		this.importarPacientes()
		this.importarMedicamentos()
	},
}
</script>