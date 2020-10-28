<template>
	<div>
		<vx-card>

			<div class = "demo-alignment">
				<div class="vx-col md:w-1/3 w-full mt-5">
            		<vs-button @click="$router.push('/apadrinamiento/estudiosocio/'+id)" type="border" radius class="w-full" icon-pack="feather" icon="icon-corner-up-left" icon-no-border></vs-button>
        		</div>
				<div class="flex items-center">
				<h2>Nuevo estudio socioeconómico</h2>
				</div>
				</div>
				<vs-divider position="right">PID&#174;</vs-divider>
			<div class = "demo-alignment">
			<h5><b>Nombre del niño:</b></h5><h5>{{nombre}}</h5><h5>{{apellido}}</h5>
			</div><br>

			<form>
			<div class="vx-col md:w-1/2 w-full mt-1">
				<div class="my-4">
					<small class="date-label">Fecha de estudio</small>
					<datepicker v-validate="'required'" :language="$vs.rtl ? langEn : langEn" name="fecha_boleta" v-model="fecha_boleta"></datepicker>
					<span class="text-danger">{{ errors.first('fecha_boleta') }}</span>

				</div>
			</div>

			<div class="vx-col md:w-1/2 w-full mt-6">
				<small class="date-label">Total de ingresos mensuales</small>
				<vx-input-group class="mb-base">
   				 <template slot="prepend">	
				<div class="prepend-text bg-primary" >
					<span>Q</span>	
				</div>
				<div class="vx-col w-full">
					<vs-input v-validate="'required|numeric|max:6'" class="w-full" icon-no-border name='total' v-model="total_ingresos"/>
					<span class="text-danger">{{ errors.first('total') }}</span>

				</div>
				</template>
  				</vx-input-group>

			</div>

			<div class="vx-col md:w-1/2 w-full mt-6">
				<div class="vx-col w-full">
					<small class="date-label">Alimentación</small>
					<vs-textarea v-validate="'required|max:254'" class="w-full" icon-pack="feather" icon="icon-user" icon-no-border name='alimentacion' v-model="alimentacion"/>
					<span class="text-danger">{{ errors.first('alimentacion') }}</span>

				</div>
			</div>

			<vs-list>
					<h4> 
					<vs-list-header title="Situación de la vivienda"></vs-list-header>
					</h4>
					<ul class="centerx mt-3">
							<vs-radio v-validate="'required|included:101,102,103'" name="radio" color="success" class="m-3" v-model="situacion_vivienda" vs-value="101"> Propia </vs-radio>
							<vs-radio name="radio" color="success" class="m-3" v-model="situacion_vivienda" vs-value="102"> Alquilada  </vs-radio>
							<vs-radio name="radio" color="success" class="m-3" v-model="situacion_vivienda" vs-value="103"> Prestada </vs-radio>
					</ul>
					<span class="text-danger">{{ errors.first('radio') }}</span>

			</vs-list>

			<div class="vx-col md:w-1/2 w-full mt-6">
			<small class="date-label">Costos de la vivienda</small>
				<vx-input-group class="mb-base">
   				 <template slot="prepend">	
				<div class="prepend-text bg-primary" >
					<span>Q</span>	
				</div>
				<div class="vx-col w-full">
					<vs-input v-validate="'required'" class="w-full" name='costo' v-model="descripcion_costo"/>
					<span class="text-danger">{{ errors.first('costo') }}</span>

				</div>
				</template>
  				</vx-input-group>
			</div>

			<vs-list class="mt-6">
					<h4> 
					<vs-list-header title="Servicios con los que cuenta la vivienda"></vs-list-header>
					</h4>
					<ul class="centerx mt-3">
							<vs-checkbox color="dark" class="mt-2" v-model="luz">Luz</vs-checkbox>
							<vs-checkbox color="dark" class="mt-2" v-model="agua">Agua</vs-checkbox>
							<vs-checkbox color="dark" class="mt-2" v-model="drenaje">Drenaje</vs-checkbox>
					</ul>
			</vs-list>


			<div class="vx-col md:w-1/2 w-full mt-6">
				<div class="vx-col w-full">
					<small class="date-label">Número de cuartos</small>
					<vs-input  v-validate="'required|max:150'" class="w-full" icon-pack="feather" icon="icon-box" icon-no-border name='cuartos' v-model="cantidad_cuartos"/>
					<span class="text-danger">{{ errors.first('cuartos') }}</span>

				</div>
			</div>

			<div class="vx-col md:w-1/2 w-full mt-6">
				<div class="vx-col w-full">
					<small class="date-label">Baño</small>
					<vs-input v-validate="'required|max:150'" class="w-full" icon-pack="feather" icon="icon-droplet" icon-no-border name='bano' v-model="bano"/>
					<span class="text-danger">{{ errors.first('bano') }}</span>
				</div>
			</div>

			<h4>
				<vs-list-header class="mt-6" title="Materiales de construcción"></vs-list-header>
			</h4>

			<div class="vx-col md:w-1/2 w-full mt-6">
				<div class="vx-col w-full">
					<small class="date-label">paredes</small>
					<vs-input v-validate="'required|max:150'" class="w-full" icon-pack="feather" icon="icon-grid" icon-no-border name='paredes' v-model="paredes"/>
					<span class="text-danger">{{ errors.first('paredes') }}</span>

				</div>
			</div>
			<div class="vx-col md:w-1/2 w-full mt-6">
				<div class="vx-col w-full">
					<small class="date-label">Techo</small>
					<vs-input v-validate="'required|max:150'" class="w-full" icon-pack="feather" icon="icon-arrow-up" icon-no-border name='techo' v-model="techo"/>
					<span class="text-danger">{{ errors.first('techo') }}</span>

				</div>
			</div>
			<div class="vx-col md:w-1/2 w-full mt-6">
				<div class="vx-col w-full">
					<small class="date-label">Piso</small>
					<vs-input v-validate="'required|max:150'" class="w-full" icon-pack="feather" icon="icon-arrow-down" icon-no-border name='piso' v-model="piso"/>
					<span class="text-danger">{{ errors.first('piso') }}</span>

				</div>
			</div>

			<div class="vx-col w-full mt-6">
				<div class="vx-col w-full">
					<small class="date-label">Evaluación general de diagnóstico</small>
					<vs-textarea v-validate="'required|max:254'" class="w-full" icon-pack="feather" icon="icon-edit" icon-no-border name='evaluacion' v-model="evaluacion_diagnostico"/>
					<span class="text-danger">{{ errors.first('evaluacion') }}</span>

				</div>
			</div>

				
	<br>
					<div class="vx-col md:w-1/3 w-full mt-5">
						<vs-button  type="gradient" class="mb-base mr-3" icon-pack="feather" icon="icon-file-plus" @click.prevent="ingresarEstudio">Registrar Estudio socioeconómico</vs-button>
					</div>
				
			</form>
		</vx-card>


	</div>
</template>

<script>

import { es } from 'vuejs-datepicker/src/locale'
import axios from 'axios'
import Datepicker from 'vuejs-datepicker'
import { Validator } from 'vee-validate';
const dict = {
  custom: {
    fecha_boleta: {
	  required: 'La fecha de estudio es requerida',
    },
    cuartos: {
	  required: 'El campo número de cuartos es requerido',
	  max: 'Este campo solo acepta hasta 150 caracteres',
	},
	bano: {
	  required: 'El campo baño es requerido',
	  max: 'Este campo solo acepta hasta 150 caracteres',
	},
	paredes: {
	  required: 'El campo paredes es requerido',
	  max: 'Este campo solo acepta hasta 150 caracteres',
	},
	techo: {
	  required: 'El campo techo es requerido',
	  max: 'Este campo solo acepta hasta 150 caracteres',
	},
	piso: {
	  required: 'El campo piso es requerido',
	  max: 'Este campo solo acepta hasta 150 caracteres',
	},
	alimentacion: {
	  required: 'El campo alimentación es requerido',
	  max: 'Este campo solo acepta hasta 254 caracteres',
	},
	evaluacion: {
	  required: 'El campo evaluación es requerido',
	  max: 'Este campo solo acepta hasta 254 caracteres',
    },
    total: {
	  required: 'El campo total de ingresos mensuales es requerido',
	  numeric: 'El campo solo debe de contener números',
	  max: 'Este campo solo acepta hasta 6 dígitos',
	},
	costo: {
	  required: 'El campo costos de la vivienda es requerido',
	},
	radio: {
	  required: 'Seleccione una opción',
	  included: 'Seleccione una opción',
    },
  }
};
Validator.localize('en', dict);
export default {
	data() {
		return {
			estudio_id:0,
			fecha_boleta:'',
			total_ingresos:0,
			alimentacion:'',
			situacion_vivienda:0,
			descripcion_costo:'',
			luz:0,
			agua:0,
			drenaje:0,
			cantidad_cuartos:0,
			bano:'',
			paredes:'',
			techo:'',
			piso:'',
			evaluacion_diagnostico:'',
			langEn: es,
			codigo_familiar:0,
			id:0,
			 nombre: '',
		apellido: '',
		}
	},
	methods: {
		getDate(datetime) {
			let date = new Date(datetime);
			let dateString = `${date.getFullYear()}/${date.getMonth() + 1}/${date.getDate()}`;
			return dateString;
		},
		enviando(id){
			this.estudio_id=id;
		},
		buscarHermanos(codigoT){
			let me = this;
			console.log('Buscando hermanos del codigo ' + codigoT)
			axios.get(`/api/relacion/get?criterio=codigo&buscar=${codigoT}&completo=informacion`)
			.then(function (response) {
				var respuesta= response.data;
				me.arrayData = respuesta.relaciones.data;
				me.setearValor(me.arrayData)
			})
			.catch(function (error) {
				console.log(error);
			});
		},
		setearValor(unArreglo){
			this.listadoNinos=unArreglo.slice();
			let hash = {};
			this.listadoNinos = this.listadoNinos.filter(o => hash[o.nino_id] ? false : hash[o.nino_id] = true);
			let estudioT=this.estudio_id
			this.listadoNinos.forEach(function(elemento, indice, array) {
					axios.post("/api/historialEstudio/post/",{
						nino_id:elemento.nino_id,
						estudio_id:estudioT,
					}).then(function(response) {
							console.log('es aqui donde se traba?')
							console.log(response)
					})
						.catch(function(error) {
						console.log(error)
					});
			})
			let titulo = 'Estudio socioeconómico registrado!';
			this.$vs.notify({
			color:'success',
			title:`${titulo}`,
			text:'La acción se realizo exitósamente'
			});
			this.$router.push('/apadrinamiento/estudiosocio/'+this.id);
		},
		buscarCodigo(){
			let nino_id = this.$route.params.id;
			let me = this;
			axios.get(`/api/relacion/get?criterio=nino_id&buscar=${nino_id}&completo=informacion`)
			.then(function (response) {
				var respuesta= response.data;
				me.arrayData = respuesta.relaciones.data;

				me.buscarHermanos(me.arrayData[0].codigo)
			})
			.catch(function (error) {
				console.log(error);
			});
		},
		ingresarEstudio(){
		this.$validator.validateAll().then(result => {
        if(result) {
			let me = this;
			axios.post("/api/estudioSocioeconomico/post/",{
				fecha_boleta:this.getDate(this.fecha_boleta),
				total_ingresos:this.total_ingresos,
				alimentacion:this.alimentacion,
				situacion_vivienda:this.situacion_vivienda-100,
				descripcion_costo:this.descripcion_costo,
				luz:this.luz,
				agua:this.agua,
				drenaje:this.drenaje,
				cantidad_cuartos:this.cantidad_cuartos,
				bano:this.bano,
				paredes:this.paredes,
				techo:this.techo,
				piso:this.piso,
				evaluacion_diagnostico:this.evaluacion_diagnostico
			}).then(function(response) {
				console.log('respuesta del estudio')
				console.log(response)
				me.enviando(response.data.id)
			})
			.catch(function(error) {
				console.log(error)
			});
			this.buscarCodigo()
		}
		else {
          this.$vs.notify({
					color:'danger',
					title:`Error en validación!`,
					text:'Ingrese correctamente todos los campos'
				})
        }
		})
		},
		async index(){ //async para que se llame cada vez que se necesite
        let me = this;
        me.id_recibido = this.$route.params.id;
		const response = await axios.get(
			`/api/historialFotografia/get?&criterio=nino_id&buscar=${me.id_recibido}&completo=true`)
		.then(function (response) {
			var respuesta= response.data;
            me.arrayData = respuesta.historialfotografias.data;
            me.nombre = respuesta.historialfotografias.data[0].datos_nino[0].nombres;
            me.apellido = respuesta.historialfotografias.data[0].datos_nino[0].apellidos;
            me.codigo = respuesta.historialfotografias.data[0].nino.codigo;
            me.id = respuesta.historialfotografias.data[0].nino.id;
		})
		.catch(function (error) {
			console.log(error);
		});
	},
	},
	components:{
		Datepicker,
	},
	mounted() {
		this.id=parseInt(this.$route.params.id);
		this.index();
	},
}
</script>