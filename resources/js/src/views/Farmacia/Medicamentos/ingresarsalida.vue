<template>
  	<vx-card>
		<div class="vx-col w-full">
			<div class="md:w-1/3 w-full mt-3">
				<div class="w-full">
					<h4 class="date-label">Paciente:</h4>
					<v-select label="nombre_completo" :options="listado_pacientes" v-model="paciente_select" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
				</div>
			</div>
			<div class="md:w-1/3 w-full mt-3" v-if="opcionesSalidas">
				<div class="w-full">
					<h4 class="date-label">Destino:</h4>
					<v-select label="nombre" :options="tipo_salida" v-model="tipo_salida_select" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
				</div>
			</div>
			<div class="md:w-1/3 w-full mt-3" v-if="detalleSalida">
				<div class="w-full">
					<h4 class="date-label">Opciones:</h4>
					<v-select label="mostrar" :options="listado_pendientes" v-model="opcion_selected" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
				</div>
			</div>
		</div>
		<div v-if="paciente_select != null">
		<vs-divider position="center">Medicamentos</vs-divider>
			<div class="vx-col md:w-1/2 w-full mt-3">
				<div class="vx-col w-full">
					<h4 class="date-label">Lista de medicamentos:</h4>
					<v-select label="nombre_completo" :options="listado_medicamentos" class="mt-1"  v-model="medicamento_id" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
					<small class="date-label" v-if="medicamento_id != null"><p class="text-danger">Existencia: {{stockId}}</p></small>
				</div>
			</div>

			<vs-divider position="center">Lista de entrega</vs-divider>
			<vs-list>
					<div class="vx-col w-full mb-base">
							<table style="width:100%" class="border-collapse">
									<tr>
										<th class="p-2 border border-solid d-theme-border-grey-light text-center">Eliminar</th>
										<th class="p-2 border border-solid d-theme-border-grey-light text-center">Nombre Medicamento</th>
										<th class="p-2 border border-solid d-theme-border-grey-light text-center">Cantidad</th>
									</tr>
									<tr v-for="(producto,index) in carrito" :key="index">
										<td class="border border-solid d-theme-border-grey-light flex items-center">
											<vs-button color="danger" type="border" icon-pack="feather" class="center" icon="icon-x-circle" @click="borrarIntegrante(index)"></vs-button>
										</td>
										<td class="border border-solid d-theme-border-grey-light text-center"> {{producto.nombre_completo}}</td>
										<td class="border border-solid d-theme-border-grey-light flex items-center">
											<vs-input style="text-align:right" v-model="listaCantidades[index]" name="cantidad" v-validate="'required|numeric|max:4'"/>
										</td>
									</tr>
							</table>
					</div>
			</vs-list>

			<div class="vx-row mb-6">
				<div class="vx-col w-full">
					<small>Descripción</small>
					<vs-textarea class="w-full" icon-pack="feather" icon="icon-user" icon-no-border v-model="descripcion" name="descripcion" v-validate="'required|max:60'"/>
					<span class="text-danger text-sm" v-show="errors.has('descripcion')">{{ errors.first('descripcion') }}</span>
				</div>
			</div>

			<div class="vx-row">
          		<div class="vx-col sm:w-2/3 w-full ml-auto vs-align-right">
            		<vs-button class="mr-3 mb-2" @click="registrarSalida">Registrar Salida</vs-button>
            		<!-- <vs-button color="warning" type="border" class="mb-2" @click="limpiar">Limipiar</vs-button> -->
          		</div>
	        </div>
		</div>
	</vx-card>
</template>
<script>
import axios from 'axios'
import vSelect from 'vue-select'
export default {
	data() {
		return {
			listado_pacientes:[],
			listado_pendientes:[],
			listado_medicamentos:[],
			tipo_salida:[],
			carrito:[],
			listaCantidades:[],
			tipo_salida_select:null,
			paciente_select:null,
			opcion_selected:null,
			medicamento_id:null,
			opcionesSalidas:false,
			detalleSalida:false,
			stockId:0,
			descripcion:'',
		}
	},
	components: {
		vSelect,
	},
	watch:{
		tipo_salida_select(){
			if(this.tipo_salida_select !=null)
			{
				if ( this.tipo_salida_select.id !=0)
				{
					if(this.tipo_salida_select.id== 1)
					{
						this.detalleSalida=true
						this.listado_pendientes =this.paciente_select.lista_recetas
					}
					if(this.tipo_salida_select.id== 2)
					{
						this.detalleSalida=true
						this.listado_pendientes =this.paciente_select.beneficios
						console.log('cambiando la lista de pendientes')
						console.log(this.listado_pendientes.slice())
					}
					this.opcion_selected=null
				}
			}
			if(this.tipo_salida_select==null){
				this.detalleSalida=false
			}
			else if(this.tipo_salida_select.id==0)
			{
				this.detalleSalida=false
			}
		},

    	paciente_select(){
			this.tipo_salida=[];
			if(this.paciente_select != null)
			{
				this.opcionesSalidas=true;
				let primero = {id:0,nombre:'Normal'}
				this.tipo_salida.push(primero);
				if (this.paciente_select.tipo_paciente_id != 1) {
					if (this.paciente_select.lista_recetas.length >0) {
						this.tipo_salida.push({id:1,nombre:'Receta'})
					}
					if (this.paciente_select.beneficios.length >0) {
						this.tipo_salida.push({id:2,nombre:'Apoyo Mensual'})
					}
				}
				this.tipo_salida_select=primero
			}
			if(this.paciente_select ==null)
			{
				this.opcionesSalidas=false
			}
		},
		medicamento_id(){
			this.stockId = this.medicamento_id.stock_general
			if (this.medicamento_id != null)
			{
				this.carrito.push(this.medicamento_id)
				this.listaCantidades.push(0)
			}
		}
	},
	methods: {
		borrarIntegrante (index) {
			this.carrito.splice(index, 1)
			this.listaCantidades.splice(index, 1)
			console.log(this.carrito)
			console.log(this.listaCantidades)
		},
		validarStock(){
			let validado=true
			let cantidades = this.listaCantidades

			for (let x in this.carrito) {
				let v1 = parseInt(this.carrito[x].stock_general)
				let v2 = parseInt(cantidades[x])
				console.log(v1+ ' - ' + v2)
				if (v1 < v2)
				{
					validado=false
				}
			}
			console.log(validado)
			return validado
		},
		registroDetalle(idSalida){
			console.log('en salida')
			console.log(idSalida)
			let cantidades = this.listaCantidades
			for (let x in this.carrito) {
				let elemento =  this.carrito[x]
				let cantidadStock = parseInt(elemento.stock_general)
				let cantidadIngreso = parseInt(cantidades[x])
				if (cantidadStock > cantidadIngreso)
				{
					let cuentaSaldada = false
					for (let i in elemento.lotes){
						let lote = elemento.lotes[i] 
						console.log('lotes activos')
						console.log(lote)
						if (cuentaSaldada ==false)
						{
							if(lote.stock > cantidadIngreso)
							{
								console.log('de ese lote')
								cuentaSaldada = true
								let ingresar  = lote.stock - cantidadIngreso
								lote.stock  = lote.stock - cantidadIngreso
								axios.put("/api/lote/update/",{
									id:lote.id,
									stock:ingresar
								}).then(function(response) {
									console.log(response)
								})
								.catch(function(error) {
									console.log(error)
								});
							}
							else if(lote.stock < cantidadIngreso){
								cantidadIngreso = cantidadIngreso-lote.stock
								console.log('hay que hacer un for')
								axios.put("/api/lote/update/",{
									id:lote.id,
									stock:0,
									estado:0
								}).then(function(response) {
									console.log(response)
								})
								.catch(function(error) {
									console.log(error)
								});
							}
							else{
								console.log('salida de un lote y a cero')
								cuentaSaldada = true
								lote.stock  = lote.stock - cantidadIngreso
								axios.put("/api/lote/update/",{
									id:lote.id,
									stock:0,
									estado:0
								}).then(function(response) {
									console.log(response)
								})
								.catch(function(error) {
									console.log(error)
								});
							}
						}
						/*
						axios.put("/api/lote/update/",{
							id:lote.id,
							stock:lote.stock-,
						}).then(function(response) {
							console.log(response)
						})
						.catch(function(error) {
							console.log(error)
						});
						*/
					}
				}
			}
		},
		registrarSalida(){
			let val = this.validarStock()
			if(val == true)
			{
				let me = this
				const today = new Date()
				const fecha_salida = me.getDate(today)
				axios.post('/api/salidaMedicamento/post/', {
					fecha_salida: fecha_salida,
					tipo_salida: me.tipo_salida_select.id,
					descripcion: me.descripcion,
					usuario_id: 1,
					paciente_id: me.paciente_select.id,

				}).then(function (response) {
					console.log(response)
					me.registroDetalle(response.data.id)
				})
				.catch(function (error) {
					console.log(error)
					alert('Error al ingresar')
				})
			}
			else{
				console.log('stock invalido')
			}
		},
		getDate (datetime) {
			const date = new Date(datetime)
			const dateString = `${date.getFullYear()}/${date.getMonth() + 1}/${date.getDate()}`
			return dateString
		},
		limpiarRecetas(tabla){
			tabla.forEach(function(valor, indice, array){
				let recetasAcivas=[]
				valor.lista_recetas.forEach(function(elemento, indice2, array2){
					if(elemento.estado == 1)
					{
						const date = new Date(elemento.created_at)
						const dateString = `${date.getFullYear()}/${date.getMonth() + 1}/${date.getDate()}`
						elemento.mostrar = 'Receta: ' + elemento.id + ' de el: ' + dateString
						recetasAcivas.push(elemento)
					}
				});
				valor.lista_recetas = recetasAcivas
			});
			return tabla
		},
		limpiarBeneficios(tabla){
			tabla.forEach(function(valor, indice, array){
				let beneficiosActivos=[]
				valor.beneficios.forEach(function(elemento, indice2, array2){
					if(elemento.estado == 1)
					{
						let numero = parseInt(elemento.fecha_entrega.split('-',3)[1])
						let nombre=''
						switch (numero) {
							case 1:
								nombre='enero' 
								break;
							case 2:
								nombre='febrero'
								break;
							case 3:
								nombre='marzo'
								break;
							case 4:
								nombre='abril' 
								break;
							case 5:
								nombre='mayo' 
								break;
							case 6:
								nombre='junio' 
								break;
							case 7:
								nombre='julio' 
								break;
							case 8:
								nombre='agosto' 
								break;
							case 9:
								nombre='septiembre' 
								break;
							case 10:
								nombre='octubre'
								break;
							case 11:
								nombre='noviembre'
								break;
							case 12:
								nombre='diciembre'
								break;
						
							default:
								nombre ='Nulo'
								break;
						}
						elemento.mostrar='Entrega de '+nombre + ' del ' + elemento.fecha_entrega.split('-',3)[0]
						beneficiosActivos.push(elemento)
					}
				});
				valor.beneficios = beneficiosActivos
			});
			return tabla
		},
		traerNombreMedicamento(tabla){
			tabla.forEach(function(valor, indice, array){
				valor.nombre_completo = valor.nombre + ' - ' + valor.casa_medica.nombre
				if (valor.lotes.length >0){
					let lotesActivos=[]
					valor.lotes.forEach(function(elemento, indice2, array2){
						if(elemento.estado == 1)
						{
							lotesActivos.push(elemento)
						}
					});
					valor.lotes=lotesActivos
				}
			});
			return tabla
		},
		traerNombre(tabla){
			tabla.forEach(function(valor, indice, array){
				valor.nombres = valor.datos.nombres
				valor.apellidos = valor.datos.apellidos
				valor.nombre_completo = valor.datos.nombres + ' '+ valor.datos.apellidos
			});
			return tabla			
		},
		async importarPacientes() {
			let me = this;
			const response = await axios.get(
				`/api/paciente/get?completo=false`)
			.then(function (response) {
				const respuesta = response.data
				me.listado_pacientes = me.traerNombre(respuesta.pacientes.data)
				me.listado_pacientes = me.limpiarRecetas(me.listado_pacientes)
				me.listado_pacientes = me.limpiarBeneficios(me.listado_pacientes)
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
		nombreMes(numero){
			numero = parseInt(numero)
			let nombre=''
			switch (numero) {
				case 1:
					nombre='enero' 
					break;
				case 2:
					nombre='febrero'
					break;
				case 3:
					nombre='marzo'
					break;
				case 4:
					nombre='abril' 
					break;
				case 5:
					nombre='mayo' 
					break;
				case 6:
					nombre='junio' 
					break;
				case 7:
					nombre='julio' 
					break;
				case 8:
					nombre='agosto' 
					break;
				case 9:
					nombre='septiembre' 
					break;
				case 10:
					nombre='octubre'
					break;
				case 11:
					nombre='noviembre'
					break;
				case 12:
					nombre='diciembre'
					break;
			
				default:
					nombre ='Nulo'
					break;
			}
			return nombre
		},
	},
	mounted(){
		this.importarPacientes()
		this.importarMedicamentos()
	}
}
</script>