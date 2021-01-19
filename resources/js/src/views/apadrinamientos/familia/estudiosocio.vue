<template>
	<div>
		<div id="invoice-page">
			<vx-card id="invoice-container">
			<vs-button @click="goBack" class="mr-4 mt-3" type="border" radius icon-pack="feather" color="primary" icon="icon-corner-up-left"> </vs-button>

				<div class="vx-row leading-loose p-base">
					<div class="vx-col w-1/2 mt-base">
						<h1><b>Estudio Socioeconómico</b> </h1>
						<br/>
						<h2><b>Familia: </b> {{codigo_familiar}} </h2>
					</div>
					<div class="vx-col w-1/2 text-right">
						<h3> <b>PPI Familiar</b>  </h3>
							<br/>
							<h6><b>Valor de último PPI:</b> {{total_ppi}} </h6>
							<br/>
							<h6><b>Fecha de último PPI:</b> {{fecha_ppi}} </h6>
					</div>
				</div>
				<vs-divider position="right">PID&#174;</vs-divider>

				<vx-card
				title="Información de los niños"
				title-color="warning"
				>
					<vs-list>
						<vs-list-header icon-pack="feather" icon="icon-user" title="Niños apadrinados" color="success"></vs-list-header>
							<div class="p-base">
								<div v-for="(nino,id) in listadoNinos" :key="id">
									<div v-if="nino.nino.estado==1">
										<div class="flex items-center">
											<vs-avatar :src="nino.nino.ruta_imagen" color="primary" class="flex-shrink-0 mr-2" size="60px"/>
											<h2>&nbsp; <b> Código:</b> {{nino.nino.codigo}}</h2> 
											<div class="vx-col w-full text-right">
											<h3><b>Fecha de apadrinamiento: </b> {{nino.nino.fecha_ingreso}}  </h3>
											</div>
										</div>
										<table style="width:100%" class="border-none mt-2">
											<tr>
												<th class="pointer-events-none text-center"> <h4> {{nino.datos_nino[0].nombres}}   </h4> </th>
												<th class="pointer-events-none text-center"> <h4> {{nino.datos_nino[0].apellido1}} </h4> </th>
												<th class="pointer-events-none text-center"> <h4> {{nino.datos_nino[0].apellido2}} </h4> </th>
											</tr>
											<tr>
												<td class="pointer-events-none text-center">Nombres</td>
												<td class="pointer-events-none text-center">Apellido Paterno</td>
												<td class="pointer-events-none text-center">Apellido Materno</td>
											</tr>
										</table>
										<vs-divider/>
										<p><b>Fecha de Nacimiento: </b> el {{ nino.datos_nino[0].fecha_nacimiento.split('-',3)[2] }} de {{ nombreMes(nino.datos_nino[0].fecha_nacimiento.split('-',3)[1]) }}  del  {{ nino.datos_nino[0].fecha_nacimiento.split('-',3)[0] }}</p>
										<vs-divider/>
											<table style="width:75%" class="border-collapse mt-2">
													<tr>
														<td class="pointer-events-none text-left"><b>Escuela:</b> {{ nino.nino.escuela_nombre }}  </td>
														<td class="pointer-events-none text-left"> <b>Grado: </b>  {{nino.nino.grado}} </td>
													</tr>
											</table>
										<vs-divider/>
										<p><b>Actividades:</b> {{ nino.nino.actividades }} </p>
										<vs-divider/>
									</div>
								</div>
							</div>
					</vs-list>
					
					<vs-list>
						<vs-list-header icon-pack="feather" icon="icon-user" title="Niños no apadrinados" color="danger"></vs-list-header>
							<div class="p-base">
								<div v-for="(nino,id) in listadoNinos" :key="id">
									<div v-if="nino.nino.estado==0">
										<div class="flex items-center">
											<vs-avatar :src="nino.nino.ruta_imagen" color="primary" class="flex-shrink-0 mr-2" size="60px"/>
											<h2> {{"  "}} <b>Código:</b> {{nino.nino.codigo}} </h2> 
										</div>
										
										<table style="width:100%" class="border-none mt-2">
											<tr>
												<th class="pointer-events-none text-center"> <h4> {{nino.datos_nino[0].nombres}} </h4> </th>
												<th class="pointer-events-none text-center"> <h4> {{nino.datos_nino[0].apellido1}} </h4> </th>
												<th class="pointer-events-none text-center"> <h4> {{nino.datos_nino[0].apellido2}} </h4> </th>
											</tr>
											<tr>
												<td class="pointer-events-none text-center">Nombres</td>
												<td class="pointer-events-none text-center">Apellido Paterno</td>
												<td class="pointer-events-none text-center">Apellido Materno</td>
											</tr>
										</table>
										<vs-divider/>
										<p><b>Fecha de Nacimiento: </b> el {{ nino.datos_nino[0].fecha_nacimiento.split('-',3)[2] }} de {{ nombreMes(nino.datos_nino[0].fecha_nacimiento.split('-',3)[1]) }}  del  {{ nino.datos_nino[0].fecha_nacimiento.split('-',3)[0] }}</p>
										<vs-divider/>
											<table style="width:75%" class="border-collapse mt-2">
													<tr>
														<td class="pointer-events-none text-left"><b>Escuela:</b> {{ nino.nino.escuela_nombre }}  </td>
														<td class="pointer-events-none text-left"> <b>Grado: </b>  {{nino.nino.grado}} </td>
													</tr>
											</table>
										<vs-divider/>
										<p><b>Actividades:</b> {{ nino.nino.actividades }} </p>
										<vs-divider/>
									</div>
								</div>
							</div>

					</vs-list>
				</vx-card>
				<vx-card
				class="mt-6"
				title="Datos de los familiares"
				title-color="warning"
				>
					<vs-list>
						<div class="vx-col w-full mb-base">
							<table style="width:100%" class="border-collapse">
								<tr>
									<th class="p-2 border border-solid d-theme-border-grey-light text-center">Fotografía</th>
									<th class="p-2 border border-solid d-theme-border-grey-light text-center">Nombre completo</th>
									<th class="p-2 border border-solid d-theme-border-grey-light text-center">Edad</th>
									<th class="p-2 border border-solid d-theme-border-grey-light text-center">Parentesco</th>
									<th class="p-2 border border-solid d-theme-border-grey-light text-center">Escolaridad</th>
									<th class="p-2 border border-solid d-theme-border-grey-light text-center">Ocupación</th>
									<th class="p-2 border border-solid d-theme-border-grey-light text-center">Teléfono</th>
									<th class="p-2 border border-solid d-theme-border-grey-light text-center">Ingresos</th>
								</tr>
								<tr v-for="(encargado,index2) in listadoFamilia" :key="index2">
									<td class="border border-solid d-theme-border-grey-light text-center">	<vs-avatar :src="encargado.encargado.ruta_imagen" :alt="encargado.ruta_imagen" color="primary" class="flex-shrink-0 mr-2" size="30px"/> </td>
									<td class="border border-solid d-theme-border-grey-light text-center"> {{encargado.datos_encargado[0].nombres}} {{encargado.datos_encargado[0].apellidos}} </td>
									<td class="border border-solid d-theme-border-grey-light text-center"> {{calculateAge(encargado.datos_encargado[0].fecha_nacimiento)}}</td>
									<td class="border border-solid d-theme-border-grey-light text-center"> {{encargado.relacion}}</td>
									<td class="border border-solid d-theme-border-grey-light text-center"> {{encargado.encargado.escolaridad}}</td>
									<td class="border border-solid d-theme-border-grey-light text-center"> {{encargado.encargado.ocupacion}}</td>
									<td class="border border-solid d-theme-border-grey-light text-center"> {{encargado.datos_encargado[0].numero_telefono}}</td>
									<td class="border border-solid d-theme-border-grey-light text-center"> {{encargado.encargado.ingresos}}</td>
								</tr>
							</table>
						</div>
					</vs-list>
				</vx-card>

				<vx-card
				class="mt-6"
				title="Información de la familia"
				title-color="warning"
				>
					<p><b>Total de ingresos familiares: </b> Q.{{ datosEstudio.total_ingresos }} </p>
					<vs-divider/>
					<p><b>Alimentación:</b> {{ datosEstudio.alimentacion }} </p>
					<vs-divider/>

					<table style="width:65%" class="border-collapse mt-2">
						<tr>
							<td class="pointer-events-none text-left"> <b>Dirección de la vivienda: </b> {{direccion}} </td>
							<td class="pointer-events-none text-left"> <b>Sector: </b> {{sector}} </td>
						</tr>
					</table>
					<vs-divider/>
						<table style="width:75%" class="border-collapse mt-2">
							<tr>
								<td class="pointer-events-none text-left"> <b>Situación de la vivienda: </b> {{datosEstudio.situacion_vivienda == 1 ? 'Propia' : datosEstudio.situacion_vivienda== 2 ? 'Alquilada' : 'Prestada' }}  </td>
								<td class="pointer-events-none text-left"> <b> Costos de la vivienda:   </b>  {{datosEstudio.descripcion_costo}} </td>
							</tr>
						</table>
					<vs-divider/>

					<p><b>Servicios con los que cuenta la vivienda:</b></p>

						<table style="width:50%" class="border-collapse mt-2">
							<tr>
								<td class="pointer-events-none text-left"> 	<vs-checkbox color="dark" icon-pack="feather" class="mt-2" :icon="datosEstudio.luz ==0 ? 'icon-x' : 'icon-check'" v-model="check" disabled="true"> <b> Luz </b></vs-checkbox> </td>
								<td class="pointer-events-none text-left"> 	<vs-checkbox color="dark" icon-pack="feather" class="mt-2" :icon="datosEstudio.agua ==0 ? 'icon-x' : 'icon-check'" v-model="check" disabled="true"><b> Agua</b> </vs-checkbox> </td>
								<td class="pointer-events-none text-left"> 	<vs-checkbox color="dark" icon-pack="feather" class="mt-2" :icon="datosEstudio.drenaje ==0 ? 'icon-x' : 'icon-check'" v-model="check" disabled="true"><b>Drenaje</b></vs-checkbox> </td>
							</tr>
						</table>
					<vs-divider/>
					<p><b>Número de cuartos: </b> {{ datosEstudio.cantidad_cuartos }} </p>
					<vs-divider/>
					<p><b>Baño: </b> {{ datosEstudio.bano }} </p>
					<vs-divider/>
					<p><b> Materiales de construcción: </b> </p>
						<table style="width:70%" class="border-collapse mt-2">
								<tr>
									<td class="pointer-events-none text-left"><b>Paredes: </b> {{datosEstudio.paredes}}</td>
									<td class="pointer-events-none text-left"><b> Techo:  </b> {{datosEstudio.techo}}</td>
									<td class="pointer-events-none text-left"><b> Piso:   </b> {{datosEstudio.piso}}</td>
								</tr>
						</table>
					<vs-divider/>
					<p><b>Evaluación general del diagnóstico: </b> </p>
					<p> {{ datosEstudio.evaluacion_diagnostico }} </p>
				</vx-card>
			</vx-card>
		</div>

		<div class="flex flex-wrap items-center justify-between mt-2">
			<div class="flex items-center">
					<vs-button @click="goBack" class="mb-base mr-3" type="gradient" icon-pack="feather" color="primary" icon="icon-corner-up-left"> Regresar</vs-button>			
					<vs-button class="mb-base mr-3" type="gradient" icon-pack="feather" icon="icon-printer" color="success"  @click="printInvoice">Imprimir</vs-button>
			</div>
		</div>
	</div>
</template>
<script>
import axios from 'axios';
export default {
	data() {
		return {
			nino_id:0,
			codigo_familiar:'',
			historial_id:'',
			datosEstudio:[],
			listadoFamilia:[],
			listadoNinos:[],
			fecha_ppi:'',
			total_ppi:0,
			check:1,
			fecha:'',
			apellidos:[],
			escuelas:[],
			direccion:'',
			sector:'',
		}
	},
	methods: {
		goBack(){
			this.$router.go(-1)
		},
		printInvoice () {
			window.print()
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
		async traerEscuelas(){
			let me = this;
			const response = await axios.get(`/api/escuela/get?completo=true`)
			.then(function (response) {
			var respuesta= response.data;
				me.escuelas = respuesta.escuelas.data;
			})
			.catch(function (error) {
				console.log(error);
			});
		},
		getNow () {
			const today = new Date()
			const date = `${today.getFullYear()}-${today.getMonth() + 1}-${today.getDate()}`
			const time = `${today.getHours()  }:${  today.getMinutes()  }:${  today.getSeconds()}`
			this.fecha = date
		},
		calculateAge(fechaN) {
			let currentDate = new Date();
			let fecha_nacimientoTt = new Date(fechaN); 
			let difference = currentDate - fecha_nacimientoTt;
			let age = Math.floor(difference/31557600000);
			return age
        },
		async index(){
			let datos = this.$route.params.id;
			let me = this;
 			const response = await axios.get(`/api/relacion/get?criterio=codigo&buscar=${datos}&completo=informacion`)
			.then(function (response) {
				var respuesta= response.data;
				me.arrayData = respuesta.relaciones.data;
			})
			.catch(function (error) {
				console.log(error);
			});
		},
		async buscarFamilia(codigo){
			let consulta=[]
			let me = this
			const response = await axios.get(`/api/relacion/get?criterio=codigo&buscar=${codigo}&completo=informacion`)
			.then(function (response) {
				var respuesta= response.data;
				consulta = respuesta.relaciones.data;
				let hash = {};
				let hash2 = {};
				me.listadoFamilia = consulta.filter(o => hash[o.encargado_id] ? false : hash[o.encargado_id] = true);
				me.listadoNinos	  = consulta.filter(o => hash[o.nino_id] ? false : hash[o.nino_id] = true);
				me.direccion=me.listadoFamilia[0].direccion
				me.sector=me.listadoFamilia[0].sector.nombre

				me.listadoNinos.forEach(function(elemento, indice, array) {
					let nombreT=elemento.datos_nino[0].apellidos
					nombreT=nombreT.split(' ',2)
					elemento.datos_nino[0].apellido1=nombreT[0]
					if (nombreT.length>1){
						elemento.datos_nino[0].apellido2=nombreT[1]
					}
					else
					{
						elemento.datos_nino[0].apellido2=''
					}
					const resultado = me.escuelas.find( escuela => escuela.id === elemento.nino.escuela_id );
					elemento.nino.escuela_nombre = resultado.nombre
				})

			})
			.catch(function (error) {
				console.log(error);
			});
		},
		buscarCodigo(){
			let nino_id = this.$route.params.id;
			this.historial_id = this.$route.params.estudio;
			let me = this;
 			axios.get(`/api/relacion/get?criterio=nino_id&buscar=${nino_id}&completo=informacion`)
			.then(function (response) {
				var respuesta= response.data;
				me.arrayData = respuesta.relaciones.data;
				me.codigo_familiar=me.arrayData[0].codigo
				me.buscarFamilia(me.arrayData[0].codigo)
			})
			.catch(function (error) {
				console.log(error);
			});

			axios.get(`/api/historialEstudio/get?criterio=estudio_socioeconomico_id&buscar=${this.historial_id}&completo=false`)
			.then(function (response){
				var respuesta= response.data;
				me.datosEstudio = respuesta.historialEstudios.data[0].estudio_socieconomico;
			})
			.catch(function (error) {
				console.log(error);
			});

			axios.get(`/api/historialPpi/get?criterio=nino_id&buscar=${nino_id}&completo=false`)
			.then(function (response) {
				var respuesta= response.data.historialPpis.data[0];
				me.fecha_ppi=respuesta.fecha_estudio
				me.total_ppi=respuesta.ppi.total
			})
			.catch(function (error) {
				console.log(error);
			});
		},
	},
	mounted() {
		this.traerEscuelas()
		this.buscarCodigo()
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