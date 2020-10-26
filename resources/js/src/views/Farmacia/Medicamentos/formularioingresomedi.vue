<template>
	<vx-card>
		<vs-divider position="center">Datos de Ingreso</vs-divider>
		<div class="vx-col md:w-1/2 w-full mt-3">
			<div class="vx-col w-full">
				<h4 class="date-label">Proveedor:</h4>
				<v-select label="nombre_completo" :options="lista_proveedores" v-model="proveedor_id" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
			</div>
		</div>
		<div class="vx-col md:w-1/2 w-full">
			<div class="my-4">
				<small class="date-label">Fecha de ingreso</small>
				<datepicker :language="$vs.rtl ? langEn : langEn" name="fecha_ingreso" v-model="fecha_ingreso"></datepicker>
			</div>
		</div>
		<vs-divider position="center">Listado de Medicamentos</vs-divider>

			<div class="vx-col md:w-1/2 w-full mt-3">
				<div class="vx-col w-full">
					<h4 class="date-label">Lista de medicamentos:</h4>
					<v-select label="nombre_completo" :options="listado_medicamentos" class="mt-1"  v-model="medicamento_id" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
				</div>
			</div>

			<vs-list>
				<div class="vx-col w-full mb-base">
						<table style="width:100%" class="border-collapse">
								<tr>
									<th class="p-2 border border-solid d-theme-border-grey-light text-center">Eliminar</th>
									<th class="p-2 border border-solid d-theme-border-grey-light text-center">Nombre Medicamento</th>
									<th class="p-2 border border-solid d-theme-border-grey-light text-center">Fecha de Expiración</th>
									<th class="p-2 border border-solid d-theme-border-grey-light text-center">Numero de Lote/Referencia</th>
									<th class="p-2 border border-solid d-theme-border-grey-light text-center">Cantidad de entrada</th>
								</tr>
								<tr v-for="(producto,index) in listado_entrada" :key="index">
									<td class="border border-solid d-theme-border-grey-light">
										<vs-button color="danger" type="border" icon-pack="feather" class="center" icon="icon-x-circle" @click="borrarIntegrante(index)"></vs-button>
									</td>
									<td class="border border-solid d-theme-border-grey-light text-center"> {{producto.nombre_completo}}</td>
									
									<td class="border border-solid d-theme-border-grey-light">
										<datepicker :language="$vs.rtl ? langEn : langEn" name="fecha_ingreso" v-model="listaFechas[index]"></datepicker>
									</td>
									<td class="border border-solid d-theme-border-grey-light">
										<vs-input style="text-align:right" v-model="listaReferencias[index]" name="referencia" v-validate="'required|numeric|max:4'"/>
									</td>
									<td class="border border-solid d-theme-border-grey-light">
										<vs-input style="text-align:right" v-model="listaCantidades[index]" name="cantidad" v-validate="'required|numeric|max:4'"/>
									</td>
								</tr>
						</table>
				</div>
		</vs-list>

		<div class="vx-row mb-6">
			<div class="vx-col w-full">
				<small>Descripción</small>
				<vs-textarea class="w-full" icon-pack="feather" icon="icon-user" icon-no-border v-model="descripcion" name="descripcion"/>
				<span class="text-danger text-sm" v-show="errors.has('descripcion')">{{ errors.first('descripcion') }}</span>
			</div>
		</div>

		<div class="vx-row">
			<div class="vx-col sm:w-2/3 w-full ml-auto">
				<vs-button class="mr-3 mb-2" @click="guardarIngreso">Guardar</vs-button>
				<!-- <vs-button color="warning" type="border" class="mb-2" @click="limpiar">Limipiar</vs-button> -->
			</div>
		</div>

	</vx-card>
</template>

<script>

import Datepicker from 'vuejs-datepicker'
import vSelect from 'vue-select'
import axios from "axios";
import { es } from 'vuejs-datepicker/src/locale'
export default {
	data() {
		return {
			listado_medicamentos:[],
			lista_proveedores:[],

			listado_entrada:[],
			listaCantidades:[],
			listaFechas:[],
			listaReferencias:[],
			
			medicamento_id:null,
			proveedor_id:null,
			
			fecha_ingreso:'',
			descripcion:'',
			langEn: es,
		}
	},
	components: {
		vSelect,
		Datepicker,
	},
	watch: {
		medicamento_id(){
			if (this.medicamento_id != null)
			{
				this.listado_entrada.push(this.medicamento_id)
				this.listaCantidades.push(0)
				this.listaFechas.push('')
				this.listaReferencias.push('')
			}
		}
	},	
	methods: {
		borrarIntegrante(index) {
			this.listado_entrada.splice(index, 1)
			this.listaCantidades.splice(index, 1)
			this.listaFechas.splice(index, 1)
			this.listaReferencias.splice(index, 1)
		},
		getDate(datetime) {
			let date = new Date(datetime);
			let dateString = `${date.getFullYear()}/${date.getMonth() + 1}/${date.getDate()}`;
			return dateString;
		},
		async importarProveedores () {
			const me = this
			const response = await axios.get(
			`/api/proveedor/get?completo=true`)
			.then(function (response) {
				const respuesta = response.data
				me.lista_proveedores = respuesta.proveedores.data
				me.lista_proveedores = me.traerNombre(me.lista_proveedores)
			})
			.catch(function (error) {
				console.log(error)
			})
		},
		async importarMedicamentos() {
			let me = this;
			const response = await axios
			.get(`/api/medicamento/get?completo=false`)
			.then(function(response) {
				var respuesta = response.data;
				me.listado_medicamentos = respuesta.medicamentos.data;
				me.listado_medicamentos = me.traerNombreMedicamento(me.listado_medicamentos)
			})
			.catch(function(error) {
				console.log(error);
			});
		},
		traerNombre (tabla) {
			tabla.forEach(function (valor, indice, array) {
				valor.nombre_completo = valor.datos.nombres + ' ' + valor.datos.apellidos
			})
			return tabla
		},
		traerNombreMedicamento(tabla){
			tabla.forEach(function(valor, indice, array){
				valor.nombre_completo = valor.nombre + ' - ' + valor.casa_medica.nombre
			});
			return tabla
		},
		guardarIngreso(){
			let me = this
			axios.post("/api/ingresoMedicamento/post/",{
				proveedor_id:me.proveedor_id.id,
				fecha_ingreso:me.getDate(me.fecha_ingreso),
				descripcion:me.descripcion,
				usuario_id:1,
			}).then(function(response) {
				me.guardarLote(response.data.id)
			})
			.catch(function(error) {
				console.log(error)
			});
		},
		guardarLote(idIngreso){
			console.log('guardando lote...')
			console.log(idIngreso)
			let me = this
			for (let x in me.listado_entrada) {				
				let elemento =  me.listado_entrada[x]
				axios.post("/api/lote/post/",{
					stock:me.listaCantidades[x],
					fecha_expiracion:me.getDate(me.listaFechas[x]),
					numero_referencia:me.listaReferencias[x],
					medicamento_id:elemento.id ,
				}).then(function(response) {
					me.guardarDetalle(idIngreso,response.data.id)
				})
				.catch(function(error) {
					console.log(error)
				});
				axios.put("/api/medicamento/update/",{
					id:elemento.id,
					stock_general:parseInt(elemento.stock_general) + parseInt(me.listaCantidades[x])
				}).then(function(response) {
					console.log(response)
				})
				.catch(function(error) {
					console.log(error)
				});

			}
		},
		guardarDetalle(idIngreso,lote){
			axios.post("/api/detalleIngreso/post/",{
				ingreso_medicamento_id:idIngreso,
				lote_id:lote ,
			}).then(function(response) {
				console.log('se ha ingresado un detalle de ingreso')
				this.$router.push('/ingreso/medicamentos')
			})
			.catch(function(error) {
				console.log(error)
			});
		}
	},
	mounted(){
		this.importarProveedores()
		this.importarMedicamentos()
	}
}
</script>