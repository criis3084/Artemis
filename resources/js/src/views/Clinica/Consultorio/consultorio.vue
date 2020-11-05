<template>
	<div>

	  <div class="vx-row" v-if="!verForm">
		<div class="vx-col w-full">
			<div id="invoice-page">
				<vx-card id="invoice-container">
					<div class="vx-row leading-loose p-base">
		                <div class="vx-col w-1/2">
							<img src="@assets/images/logo/logopid.png" alt="pid-logo">
						</div>
						<div class="vx-col w-1/2 text-right">
							<p class="text-primary">Partners In Development</p>
							<p class="text-dark">Aldea Concepción Ixtacapa, San Antonio</p>
							<p class="text-dark">Suchitepéquez, Guatemala</p>
							<p><span class="text-grey"> {{getDate(fecha_consulta)}}</span></p>
						</div>
					</div>
					<div class="flex-1 text-center">
						<h3><span class="font-semibold">Receta Medica</span></h3>
					</div>
					<div class="mt-4">
						<span class="font-semibold">Receta No.</span>{{ id_receta }}
						<br>
						<span class="font-semibold">Doctor/a: </span>Juan paco pedro de la mar
						<br>
						<span class="font-semibold">Paciente: </span>{{paciente_select.nombre_completo}}
					</div>
					<vs-list>
						<div class="vx-col w-full mb-base mt-4">
							<table style="width:100%" class="border-collapse">
								<tr>
									<th class="p-2 border border-solid d-theme-border-grey-light text-center">Nombre Medicamento</th>
									<th class="p-2 border border-solid d-theme-border-grey-light text-center">Cantidad</th>
									<th class="p-2 border border-solid d-theme-border-grey-light text-center">Frecuencia</th>
								</tr>
								<tr v-for="(producto,index) in carrito" :key="index">
									<td class="border border-solid d-theme-border-grey-light text-center">{{producto.nombre_completo}}</td>
									<td class="border border-solid d-theme-border-grey-light text-center">{{listaCantidades[index]}}</td>
									<td class="border border-solid d-theme-border-grey-light text-center">{{listaFrecuencias[index]}}</td>
								</tr>
							</table>
						</div>
					</vs-list>
					<p><b>Anotaciones: </b> </p>
					<p>{{ listado }} </p>
					
					<div class="flex justify-between font-semibold mb-3 mt-10">
						<span>Firma del doctor/a: _________________________________________________ </span>
					</div>
				</vx-card>
					</div>

			</div>
			<div class="flex flex-wrap items-center justify-between mt-2">
				<vx-input-group class="mb-base mr-3">
				</vx-input-group>

				<div class="flex vs-align-right">
					<vs-button class="mb-base mr-3" type="gradient" icon-pack="feather" color="success" @click="recargar">Regresar</vs-button>  
				</div>
			</div>
		</div>

	<vx-card v-if="verForm" >
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
			<vs-button type="gradient" color="success" icon-pack="feather" icon="icon-save" class="mr-base mb-2" @click="printInvoice" v-if="verReceta == true && verForm == true" :disabled="deshabilitado">Registrar e imprimir receta</vs-button>
			<vs-button type="gradient" icon-pack="feather" icon="icon-save" class="mr-base mb-2" @click="registrar" :disabled="deshabilitado">Registrar</vs-button>
          </div>
		</div>
    			<!-- Diseño de la impresion de la receta  -->
		<!-- <div class="vx-col w-full"> -->

	</vx-card>
	</div>

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
			// ---- Impresion de receta ----//
			verForm:true,
			id_receta:null,
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
				this.diabetico=false
				this.embarazada=false
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
		recargar(){
			location.reload();
		},
		anadirReceta(){
			this.verReceta=!this.verReceta
		},
		aImprimir(){
			this.verForm = !this.verForm
			setTimeout(function () {
				window.print()
			}, 100);
	    },
		printInvoice(){
			this.imprimir=true,
			this.registrar();
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
		async registrar(){
			let me = this
			await axios.post("/api/historialClinico/post/",{
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
				if (me.verReceta==true) {
					me.registrarReceta(response.data.id)
				}
				else{
					location.reload();
				}

			})
			.catch(function(error) {
				console.log(error)
			});
		},
		async registrarReceta(id_historial){
			let me = this
			await axios.post("/api/receta/post/",{
				listado:me.listado,
				historial_clinico_id:id_historial,
			}).then(function(response){
				console.log(response)
				me.id_receta=response.data.id
				me.detalleReceta(response.data.id)
			})
			.catch(function(error) {
				console.log(error)
			});
		},
		async detalleReceta(idReceta){
			let me = this
			let carritoT = me.carrito
			let todos=true
			for (let i in carritoT) {
				let elemento = carritoT[i]
				await axios.post("/api/asignacionMedicamento/post/",{
					cantidad:parseInt(me.listaCantidades[i]),
					frecuencia:me.listaFrecuencias[i],
					medicamento_id:carritoT[i].id,
					receta_id:idReceta
				}).then(function(response){
					console.log(response)
					if (i==carritoT.length-1 && me.imprimir == true){
						me.aImprimir();
					}
					else if (i==carritoT.length-1 && me.imprimir == false){
						location.reload();
					}
				})
				.catch(function(error) {
					false
					console.log(error)
				});
			}
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
		this.$emit('setAppClasses', 'invoice-page')
	},
}
</script>


<style lang="scss">
@media print {
  .invoice-page {
    * {
      visibility: hidden;
    }

    #content-area {
      margin: 0 !important;
    }

    .vs-con-table {
      .vs-con-tbody {
        overflow: hidden !important;
      }
    }

    #invoice-container,
    #invoice-container * {
      visibility: visible;
    }
    #invoice-container {
      position: absolute;
      left: 0;
      top: 0;
      box-shadow: none;
    }
  }
}

@page {
  size: auto;
}
</style>
