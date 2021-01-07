<template>
	<vx-card>
		<div class = "demo-alignment">
			<div class="vx-col md:w-1/3 w-full mt-5">
				<router-link to="/microprestamo/microprestamo"><vs-button type="border" radius class="w-full" icon-pack="feather" icon="icon-corner-up-left" icon-no-border></vs-button></router-link>
			</div>
			<div class="flex-1 ">
				<h2>Nuevo micropréstamo</h2>
			</div>
		</div>
				<vs-divider position="right">PID&#174;</vs-divider>
		
		<div class="vx-col md:w-1/2 w-full mt-3">
			<div class="vx-col w-full">
				<h5 class="date-label">Grupo para micropréstamo:</h5>
				<v-select label="nombre" :options="listado_grupos" v-model="grupo_select" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
			</div>
			<span v-if="lista_encargados_plus.length <1" class="text-succes">Seleccione un grupo </span>
		</div>
		<div class="mt-8">
				<form>

				<h5> <b> Cantidad del préstamo anterior: </b> {{this.currency(prestamoAnterior)}} &nbsp; &nbsp; <b>Interés del préstamo anterior: </b> {{currency(interesAnterior)}} </h5>
				<br>
				<h5> <b> Límite sugerido del préstamo actual: </b> {{limiteActual()}}</h5>
				<br>

				<div class="vx-row">
					<div class="vx-col md:w-1/2 w-full">
						<div class="my-4">
							<small class="date-label">Fecha de inicio</small>
							<datepicker :language="$vs.rtl ? langEn : langEn" name="fecha" v-validate="'required'" :disabled="bloqueado" v-model="fecha_inicio"></datepicker>
							<span class="text-danger">{{ errors.first('fecha') }}</span>
						</div>
					</div>
					<div class="vx-col md:w-1/2 w-full">
						<div class="my-4">
							<small class="date-label mt-5">Fecha de primer pago grupal</small>
							<datepicker :language="$vs.rtl ? langEn : langEn" name="dia_pago" v-validate="'required'" :disabled="bloqueado" v-model="dia_pago"></datepicker>
							<span class="text-danger">{{ errors.first('dia_pago') }}</span>
						</div>
					</div>
				</div>
					<div class="vx-row">
						<div class="vx-col md:w-1/3 w-full mt-4">
							<div class="vx-col w-full">
								<vs-input  name="meses" v-validate="'required|numeric|max:2'" class="w-full" icon="date_range" icon-no-border label-placeholder="Cantidad de meses para pagar" :disabled="bloqueado" v-model="duracion"/>
								<span class="text-danger">{{ errors.first('meses') }}</span>

							</div>
						</div>
						<div class="vx-col md:w-1/3 w-full mt-4">
							<div class="vx-col w-full">
								<vs-input name="interes" v-validate="'required|max:2|numeric'" class="w-full" icon-pack="feather" icon-no-border icon="icon-percent"  label-placeholder="Porcentaje de interés" :disabled="bloqueado" v-model="interes"/>
								<span class="text-danger">{{ errors.first('interes') }}</span>

							</div>
						</div>
						<div class="vx-col md:w-1/3 w-full mt-4">
							<div class="vx-col w-full">
								<vs-input  name="mora" v-validate="'required|numeric|max:5'" class="w-full" icon="local_atm" icon-no-border label-placeholder="Mora por atraso" :disabled="bloqueado" v-model="mora_por_atraso"/>
								<span class="text-danger">{{ errors.first('mora') }}</span>
							</div>
						</div>
					</div>

					<div v-if="!bloqueado">

						<vs-divider class="mt-8"> Detalle de prestamo por integrante</vs-divider>

						<table style="width:100%" class="border-collapse mt-6">
								<tr>
									<th class="pointer-events-none text-center"> <h5> Integrante </h5> </th>
									<th class="pointer-events-none text-center"> <h5> Destino de inversión</h5> </th>
									<th class="pointer-events-none text-center" style="width:15%"> <h5> Cantidad de préstamo </h5> </th>
									<th class="pointer-events-none text-center" style="width:15%"> <h5> Pago mensual </h5> </th>
								</tr>
								<tr v-for="(integrante,id) in lista_encargados_plus" :key="id" class="mt-4">
									<td style="text-align:center"> {{integrante.datos_encargado.datos.nombres+" "+ integrante.datos_encargado.datos.apellidos}} </td>
									<td style="text-align:center"> <v-select name="destino" v-validate="'required'" style="width:95%" label="nombre" :options="destinos_inversion" v-model="listaInversiones[id]" :dir="$vs.rtl ? 'rtl' : 'ltr'" /> </td>
									<td style="text-align:right"> <vs-input style="text-align:right" v-model="listaCantidades[id]" name="cantidad" v-validate="'required|numeric|max:5'"/> </td>
									<td style="text-align:center"> Q {{pagoEstimado(listaCantidades[id])}}.00 </td>
								</tr>
						</table>
								<span class="text-danger">{{ errors.first('destino') }}</span><br>
								<span class="text-danger">{{ errors.first('cantidad') }}</span>
						<vs-divider/>
						<div class="vx-row leading-loose p-base">
							<div class="vx-col w-1/2">
								<h5><b>Total de préstamo <small>(Con intereses)</small> :</b> </h5>
							</div>
							<div class="vx-col w-1/2 text-right">
								<h4> <b> Q {{sumarCantidades()}}.00 </b>  </h4>
							</div>
						</div>

					</div>
						<div class="vx-row mt-8">
							<div class="vx-col sm:w-2/3 w-full ml-auto">
								<vs-button type="gradient" icon-pack="feather" icon="icon-save" class="mr-3 mb-2" @click="guardarPrestamo" :disabled="bloqueado">Guardar</vs-button>
							</div>
						</div>

			</form>
		</div>
	</vx-card>
</template>
<script>
import axios from "axios";
import vSelect from 'vue-select'
import Datepicker from 'vuejs-datepicker'
import { es } from 'vuejs-datepicker/src/locale'
import { Validator } from 'vee-validate';
const dict = {
  custom: {
	  fecha: {
      required: 'El campo fecha de inicio es requerido',
	},
	interes: {
	  required: 'El campo interés es requerido',
	  max: 'Este campo solo acepta hasta 2 dígitos',
	  numeric: 'El campo solo debe de contener números',
    },
	dia_pago: {
      required: 'El campo día de pago es requerido',
	},
	mora: {
	  required: 'El campo mora por atraso es requerido',
	  max: 'Este campo solo acepta hasta 5 dígitos',
	  numeric: 'El campo solo debe de contener números',
    },
	meses: {
	  required: 'El campo cantidad de meses para pagar es requerido',
	  max: 'Este campo solo acepta hasta 2 dígitos',
	  numeric: 'El campo solo debe de contener números',
    },
	destino: {
      required: 'Todos los campos de destino de inversión son requeridos',
	},
	cantidad: {
	  required: 'Todos los campos de cantidad de préstamo son requeridos',
	  max: 'Este campo solo acepta hasta 5 dígitos',
	  numeric: 'El campo solo debe de contener números',
	},
  }
}

Validator.localize('en', dict);
export default {
	data() {
		return {
			listado_grupos:[],
			grupo_select:null,
			integrantes:[],
			lista_encargados:[],
			lista_encargados_plus:[],
			listaCantidades:[],
			listaInversiones:[],
			destinos_inversion:[],
			prestamoTotal:0,
			dia_pago:null,
			interes:null,
			fecha_inicio:'',
			mora_por_atraso:null,
			duracion:null,
			langEn: es,
			bloqueado:true,
			prestamoAnterior:0,
			interesAnterior:0
		};
	},
	components: {
		vSelect,
		Datepicker,
	},
	watch:{
    	grupo_select () {
			if(this.grupo_select != null)
			{
				this.bloqueado=false
				this.buscarIntegrantes()
			}
			else{
				this.prestamoAnterior=0
				this.interesAnterior=0
				this.bloqueado=true
			}
    	},
	},
	methods: {
		currency(numero) {
		const formatter = new Intl.NumberFormat('en-US', {
			style: 'currency',
			currency: 'GTQ'
		})
		const mil = formatter.format(numero)
		return mil
		},
		pagoEstimado(prestamoI){
			let duracionT=0
			let interesT=0
			if(prestamoI == '' || prestamoI == null || prestamoI == NaN || prestamoI == undefined){
				prestamoI = 0
			}
			else{
				prestamoI= parseFloat(prestamoI)
			}
			if(this.duracion == '' || this.duracion == null){
				duracionT = 0
			}
			else{
				duracionT = this.duracion
			}
			if(this.interes == '' || this.interes == null){
				interesT = 0
			}
			else{
				interesT = this.interes
			}
			duracionT=parseFloat(duracionT)
			interesT=parseFloat(interesT)
			if (duracionT==0 || interesT==0 || prestamoI ==0)
			{
				return 0
			}
			else{
				let pago = Math.round(((prestamoI * (interesT / 100)) + prestamoI)/ duracionT)
				return pago
			}
		},
		getDate(datetime) {
			let date = new Date(datetime);
			let dateString = `${date.getFullYear()}/${date.getMonth() + 1}/${date.getDate()}`;
			return dateString;
		},
		ingresarIntegrantes(idMicroprestamo){
			const diaPago = this.getDate(this.dia_pago)
			let contador=0
			let listaCantidadesO=this.listaCantidades
			let listaInversionesO=this.listaInversiones
			let interesT = this.interes
			this.lista_encargados_plus.forEach(function(elemento, indice, array){
				contador = contador+1
				let pIndividual = Math.round((parseInt(listaCantidadesO[indice])*(parseInt(interesT)/100)) + parseInt(listaCantidadesO[indice]))
				axios.put("/api/detalleIntegrante/update/",{
					id:elemento.id,
					prestamo_individual:pIndividual,
					destino_inversion_id:listaInversionesO[indice].id,
					microprestamo_id:idMicroprestamo,
					dia_pago:diaPago,
					estado:1
				}).then(function(response) {
					console.log(response)
				})
				.catch(function(error) {
					console.log(error)
				});
			})
			this.actualizarGrupo()
			this.$vs.notify({
					color:'success',
					title:'Micropréstamo registrado',
					text:'Acción realizada exitósamente'
				});
		},
		actualizarGrupo () {
			const me = this
			let idGrupo = me.grupo_select.id
			axios.put('/api/grupoPrestamo/update/', {
				id: idGrupo,
				cantidad_prestamo_actual: me.sumarCantidades(),
				estado: 0,
			}).then(function (response) {
				console.log(response)
					me.$vs.notify({
					color:'success',
					title:'Exito!',
					text:'Acción realizada exitósamente'
				})
			})
			.catch(function (error) {
				me.$vs.notify({
					color:'danger',
					title:'Error en actualizar grupo',
					text:'Error de conexión'
				})
			})
			me.$router.push('/microprestamo/microprestamo/');
		},
		guardarPrestamo(){
			this.$validator.validateAll().then(result => {
				if(result) {
					let me = this
					axios.post("/api/microprestamo/post/",{
						nombreMicroprestamo:this.grupo_select.nombre,
						total:this.sumarCantidades(),
						interes:this.interes,
						fecha_inicio:this.getDate(this.fecha_inicio),
						duracion:this.duracion,
						dia_pago:this.getDate(this.dia_pago),
						mora_por_atraso:this.mora_por_atraso,
						pago_mes:0
					}).then(function(response) {
						me.ingresarIntegrantes(response.data.id)
					})
					.catch(function(error) {
						console.log(error)
					});
				}
				else{
					this.$vs.notify({
						color:'danger',
						title:'Error en validación!',
						text:'Ingrese todos los campos correctamente'
					});
				}
			})
		},
		async importarGrupos(){ 
			let me = this;
			const response = await axios.get(`/api/grupoPrestamo/get?completo=false`)
			.then(function (response) {
				var respuesta= response.data;
				me.listado_grupos = respuesta.grupoPrestamos.data;
			})
			.catch(function (error) {
				console.log(error);
			});
			this.fecha_inicio= new Date()
			const today = new Date()
			let	fecha_pago=new Date(today.getFullYear(),today.getMonth()+1,today.getDate())
			this.dia_pago = fecha_pago
		},
		async importarEncargados(){ 
			let me = this;
			this.abrir_editar=false
			const response = await axios.get(
				`/api/encargado/get?completo=false`)
			.then(function (response) {
				var respuesta= response.data;
				me.lista_encargados = respuesta.encargados.data;
			})
			.catch(function (error) {
				console.log(error);
			});
		},
		async importarDestinos(){ 
			let me = this;
			const response = await axios.get(
				`/api/destinoInversion/get?completo=false`)
			.then(function (response) {
				var respuesta= response.data;
				me.destinos_inversion = respuesta.destinoInversions.data;
			})
			.catch(function (error) {
				console.log(error);
			});
		},
		buscarIntegrantes () {
			let lista = this.grupo_select.integrantes
			this.prestamoAnterior = this.grupo_select.cantidad_ultimo_prestamo
			this.interesAnterior = this.grupo_select.interes_ultimo_prestamo
			let lista_encargadosT = this.lista_encargados
			let listaCantidadesT=[]
			let listaInversionesT=[]
			let listaPlusT=[]
			lista.forEach(function(elemento, indice, array) {
				const resultado = lista_encargadosT.find( encargado => encargado.id === elemento.encargado_id );
				if(resultado!==undefined)
				{
					elemento.datos_encargado=resultado
					listaPlusT.push(elemento)
					///////////////////////////////////////////
					//Se modificaron las siguientes lineas de codigo para que aparezcan validaciones
					// listaCantidadesT.push(0)
					// listaInversionesT.push(0)
				}
			})
			this.listaCantidades=listaCantidadesT
			this.listaInversiones=listaInversionesT
			this.lista_encargados_plus=listaPlusT
		},
		sumarCantidades(){
			let prestamoTotal=0
			this.listaCantidades.forEach(function(elemento, indice, array) {
				if (elemento==undefined || elemento == ''){
					elemento=0
				}else{
					prestamoTotal = prestamoTotal +  parseFloat (elemento)
				}
			})
			let interes =0
			if (this.interes != null && this.interes != NaN && this.interes != undefined && this.interes !=''){
				interes = parseFloat(this.interes)
			}
			else{
				interes =0
			}
			prestamoTotal = Math.round((parseInt(prestamoTotal)*(parseInt(interes)/100)) + parseInt(prestamoTotal))
			return prestamoTotal
		},
		limiteActual(){
			if (this.grupo_select != null){
				let ultimaCantidad = this.prestamoAnterior
				let ultimoInteres =this.interesAnterior/100
				let sugerido = (ultimaCantidad * ultimoInteres) + ultimaCantidad
				return this.currency(sugerido)
			}
			else{
				return this.currency(0)
			}
		}
	},
	mounted(){
		this.importarGrupos();
		this.importarEncargados();
		this.importarDestinos();
		//this.importarIntegra();
	},
}
</script>