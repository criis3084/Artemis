<template>
	<vx-card>
			<div class="vx-row leading-loose p-base">
			<div class="vx-col w-1/2">
				<h1><b>Datos del Paciente:</b></h1>
				<h2><b>Nombre:   </b> {{nombrePaciente}} </h2>
				<h2><b>Dirección: </b> 	{{direccion}} </h2>
				<h2><b>Tipo de salida: </b> {{tipo_salida}} </h2>
			</div>
			<div class="vx-col w-1/2 text-right">
				<h1><b>Numero de salida:</b></h1>
					<h2> {{numero_id}} </h2>
				<h3> <b>Fecha de salida:</b> </h3>
					<h3> {{fecha_salida}} </h3>
			</div>
			<br>
			<table style="width:100%" class="border-collapse mt-8">
				<tr>
					<th class="p-2 border border-solid d-theme-border-grey-light text-center"> <h4><b>Descripción de la salida: </b> </h4></th>
				</tr>
				<tr>
					<th class="p-2 border border-solid d-theme-border-grey-light text-center"> {{descripcion_salida}} </th>
				</tr>
			</table>

			<vs-divider position="center">Listado de Medicamentos</vs-divider>

			<vs-list>
				<div class="vx-col w-full mb-base">
						<table style="width:100%" class="border-collapse">
								<tr>
									<th class="p-2 border border-solid d-theme-border-grey-light text-center">Medicamento</th>
									<th class="p-2 border border-solid d-theme-border-grey-light text-center">Cantidad entregada</th>
								</tr>
								<tr v-for="(producto,index) in detalleSalida" :key="index">
										<td class="border border-solid d-theme-border-grey-light text-center"> {{producto.datos_medicamento[0].nombre}}</td>
										<td class="border border-solid d-theme-border-grey-light text-center"> {{producto.cantidad}}</td>
								</tr>
						</table>
				</div>
		</vs-list>
		</div>
	</vx-card>
</template>
<script>
import axios from 'axios';
export default {
	data() {
		return {
			detalleSalida:[],
			datosSalida:[],

			numero_id:0,
			descripcion_salida:'',
			nombrePaciente:'',
			direccion:'',
			fecha_salida:'',
			tipo_salida:'',
		}
	},
	methods: {
		async index(){
			let me2 = this;
			let datos = me2.$route.params.id;
			me2.numero_id = datos
 			const response = await axios.get(`/api/detalleSalida/get?criterio=salida_medicamento_id&buscar=${datos}&completo=true`)
			.then(function (response) {
				var respuesta= response.data;
				me2.detalleSalida = respuesta.detalleSalidas.data;
				console.log('datos de los detalles')
				console.log(me2.detalleSalida)
				me2.importarDatos(datos)
			})
			.catch(function (error) {
				console.log(error);
			});
		},
		async importarDatos(idBuscar){
			let me = this;
			const response = await axios
			.get(`/api/salidaMedicamento/get?criterio=id&buscar=${idBuscar}&completo=true`)
			.then(function(response) {
				var respuesta = response.data;
				me.datosSalida = respuesta.salidaMedicamentos.data[0];
				console.log('datos de la salida')
				console.log(me.datosSalida)
				me.nombrePaciente = me.datosSalida.datos_persona[0].nombres+' ' + me.datosSalida.datos_persona[0].apellidos
				me.direccion = me.datosSalida.datos_persona[0].direccion
				me.fecha_salida= me.datosSalida.fecha_salida
				me.descripcion_salida= me.datosSalida.descripcion
				me.tipo_salida = me.datosSalida.tipo_salida == 0 ? 'Normal' : me.datosSalida.tipo_salida == 1 ? 'Receta' : 'Apoyo Mensual'
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
		}
	},
	mounted() {
		this.index()
	},
}
</script>
