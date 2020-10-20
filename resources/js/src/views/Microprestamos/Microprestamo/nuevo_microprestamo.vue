<template>
	<vx-card>

		<div class="vx-col md:w-1/2 w-full mt-3">
			<div class="vx-col w-full">
				<small class="date-label">Grupo para micropréstamo</small>
				<v-select label="nombre" :options="listado_grupos" v-model="grupo_select" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
			</div>
		</div>
		<div v-if="lista_encargados_plus.length >0" class="mt-8">
		<h4> <b> Cantidad del préstamo anterior: </b> {{this.currency(grupo_select.cantidad_ultimo_prestamo)}} &nbsp; &nbsp; <b>Interés del préstamo anterior: </b> {{currency(grupo_select.interes_ultimo_prestamo)}} </h4>
		<br>
		<h4> <b> Límite sugerido del préstamo actual: </b> {{limiteActual()}}</h4>
		<br>
			<div class="vx-col md:w-1/2 w-full">
				<div class="my-4">
					<small class="date-label">Fecha de inicio</small>
					<datepicker :language="$vs.rtl ? langEn : langEn" name="fecha_nacimiento" v-model="fecha_inicio"></datepicker>
				</div>
			</div>
			<br>
			<div class="vx-col md:w-1/2 w-full">
				<div class="vx-col w-full">
					<vs-input class="w-full" icon-pack="feather" icon="icon-percent" icon-no-border label-placeholder="Porcentaje de interes" v-model="interes"/>
					<span class="text-danger">Porcentaje de interés</span>
				</div>
			</div>

			<div class="vx-col w-full mt-3">
					<small class="date-label mt-5">Día de pago</small>
					<datepicker :language="$vs.rtl ? langEn : langEn" name="dia_pago" v-model="dia_pago"></datepicker>
					<!-- <v-select style="width:30%" label="mostrar" :options="dia_del_mes" v-model="dia_pago" :dir="$vs.rtl ? 'rtl' : 'ltr'" /> -->
					<br>
					<vs-input  style="width:30%" icon="local_atm" icon-no-border label-placeholder="Mora por atraso" v-model="mora_por_atraso"/>
					<br>
					<vs-input  style="width:30%" icon="date_range" icon-no-border label-placeholder="Cantidad de meses para pagar" v-model="duracion"/>
					<br>
			</div>

			<table style="width:100%" class="border-collapse mt-2">
					<tr>
						<th class="pointer-events-none text-center"> <h5> Integrante </h5> </th>
						<th class="pointer-events-none text-center"> <h5> Destino de inversión</h5> </th>
						<th class="pointer-events-none text-center" style="width:30%"> <h5> Cantidad de préstamo </h5> </th>
						<th class="pointer-events-none text-center" style="width:30%"> <h5> Pago mensual </h5> </th>
					</tr>
					<tr v-for="(integrante,id) in lista_encargados_plus" :key="id" class="mt-4">
						<td style="text-align:left"> {{integrante.datos_encargado.datos.nombres}} </td>
						<td style="text-align:center"> <v-select style="width:95%" label="nombre" :options="destinos_inversion" v-model="listaInversiones[id]" :dir="$vs.rtl ? 'rtl' : 'ltr'" /> </td>
						<td style="text-align:right"> <vs-input style="text-align:right" v-model="listaCantidades[id]" name="cantidad" v-validate="'required|numeric|max:4'"/> </td>
						<td style="text-align:center"> Q {{pagoEstimado(listaCantidades[id])}}.00 </td>
					</tr>
			</table>
			<vs-divider/>
			<div class="vx-row leading-loose p-base">
				<div class="vx-col w-1/2">
                    <h4><b>Total de préstamo:</b> </h4>
                </div>
				<div class="vx-col w-1/2 text-right">
                    <h3> <b> Q {{sumarCantidades()}}.00 </b>  </h3>
                </div>
			</div>

			<div class="vx-row">
          		<div class="vx-col sm:w-2/3 w-full ml-auto">
            		<vs-button class="mr-3 mb-2" @click="guardarPrestamo">Guardar</vs-button>
            		<!-- <vs-button color="warning" type="border" class="mb-2" @click="limpiar">Limipiar</vs-button> -->
          		</div>
	        </div>

		</div>
	</vx-card>
</template>
<script>
import axios from "axios";
import vSelect from 'vue-select'
import Datepicker from 'vuejs-datepicker'
import { es } from 'vuejs-datepicker/src/locale'
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
			dia_del_mes:[],
			dia_pago:0,
			interes:0,
			fecha_inicio:'',
			mora_por_atraso:0,
			duracion:0,
			langEn: es,			
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
				console.log('buscando integrantes...')
				this.buscarIntegrantes()
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
			prestamoI= parseFloat(prestamoI)
			let duracionT=0
			let interesT=0
			if(prestamoI == '' || prestamoI == null){
				prestamoI =0
			}
			if(this.duracion == '' || this.duracion == null){
				duracionT =0
			}
			else{
				duracionT = this.duracion
			}

			if(this.interes == '' || this.interes == null){
				interesT=0
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
		diaMes(){
			for (let i = 1; i <= 28; i++) {
				this.dia_del_mes.push({id:i,mostrar:i})
			}
		},
		getDate(datetime) {
			let date = new Date(datetime);
			let dateString = `${date.getFullYear()}/${date.getMonth() + 1}/${date.getDate()}`;
			return dateString;
		},
		ingresarIntegrantes(idMicroprestamo){
			console.log('id desde funcion')
			console.log(idMicroprestamo)
			let contador=0
			let listaCantidadesO=this.listaCantidades
			let listaInversionesO=this.listaInversiones
			console.log(listaCantidadesO)
			console.log(listaInversionesO)
			this.lista_encargados_plus.forEach(function(elemento, indice, array){
				contador = contador+1
				console.log('inversiones')
				console.log(listaInversionesO[contador])
				axios.put("/api/detalleIntegrante/update/",{
					id:elemento.id,
					prestamo_individual:listaCantidadesO[indice],
					destino_inversion_id:listaInversionesO[indice].id,
					microprestamo_id:idMicroprestamo
				}).then(function(response) {
					console.log(response)
				})
				.catch(function(error) {
					console.log(error)
				});
			})
			this.$router.push('/microprestamo/microprestamo/');
		},
		guardarPrestamo(){
			let me = this
			axios.post("/api/microprestamo/post/",{
				total:this.sumarCantidades(),
				interes:this.interes,
				fecha_inicio:this.getDate(this.fecha_inicio),
				duracion:this.duracion,
				dia_pago:this.getDate(this.dia_pago),
				mora_por_atraso:this.mora_por_atraso,
				pago_mes:0
			}).then(function(response) {
				console.log('id de microprestamo')
				console.log(response.data.id)
				me.ingresarIntegrantes(response.data.id)
			})
			.catch(function(error) {
				console.log(error)
			});
		},
		async importarGrupos(){ 
			let me = this;
			const response = await axios.get(`/api/grupoPrestamo/get?completo=false`)
			.then(function (response) {
				var respuesta= response.data;
				me.listado_grupos = respuesta.grupoPrestamos.data;
				console.log(me.listado_grupos)
			})
			.catch(function (error) {
				console.log(error);
			});
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
			console.log(lista)
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
					listaCantidadesT.push(0)
					listaInversionesT.push(0)
				}

			})
			this.listaCantidades=listaCantidadesT
			this.listaInversiones=listaInversionesT
			this.lista_encargados_plus=listaPlusT
			console.log(this.lista_encargados_plus)
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
			return prestamoTotal
		},
		limiteActual(){
			let ultimaCantidad = this.grupo_select.cantidad_ultimo_prestamo
			let ultimoInteres = this.grupo_select.interes_ultimo_prestamo/100
			let sugerido = (ultimaCantidad * ultimoInteres) + ultimaCantidad
			return this.currency(sugerido)
		}
	},
	mounted(){
		this.diaMes();
		this.importarEncargados();
		this.importarDestinos();
		this.importarGrupos();
		//this.importarIntegra();
	},
}
</script>