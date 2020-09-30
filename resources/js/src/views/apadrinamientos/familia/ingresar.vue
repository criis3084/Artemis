<template>
	<vx-card>
		<vs-row	vs-align="center" vs-type="flex" vs-justify="space-around" vs-w="12">
				<div class="vx-col md:w-1/4 w-full mt-5">
					<vx-card noShadow class="center" title="INGRESAR FAMILIA" title-color="primary">
					</vx-card>
				</div>
		</vs-row>
		<form-wizard color="rgba(var(--vs-primary), 1)" :title="null" :subtitle="null" finishButtonText="Submit" on-validate @on-complete="formSubmitted">
			<!-- tab 1 content -->
			<tab-content title="Step 1" class="mb-5" icon="feather icon-home">

				<div class="vx-row">
					<formIngresarPadrino></formIngresarPadrino>
						<div v-if="cantidad_ingresos_padrino.length">
							<div v-for="(numero,index) in cantidad_ingresos_padrino" :key="index">
								<vs-divider class="mt-10" ></vs-divider>
								<vs-button radius color="danger" type="gradient" @click="quitar_padrino(index)" icon="icon_x"></vs-button>
								<formIngresarPadrino></formIngresarPadrino>
							</div>
						</div>

					<vs-row	vs-align="center" vs-type="flex"  class="m-10" vs-justify="space-around" vs-w="12">
						<div class="vx-col md:w-1/4 w-full mt-5">
								<vs-button @click="sumar_padrino">Agregar nuevo Padrino</vs-button>
						</div>
					</vs-row>

				</div>
			
			</tab-content>

			<!-- tab 2 content -->
			<tab-content title="Step 2" class="mb-5" icon="feather icon-briefcase">

				<div class="vx-row">
					<formIngresarNino ></formIngresarNino>
						<div v-if="cantidad_ingresos_nino.length">
							<div v-for="(numero,index) in cantidad_ingresos_nino" :key="index">
								<vs-divider class="mt-10" ></vs-divider>
								<vs-button radius color="danger" type="gradient" @click="quitar_nino(numero)" icon="icon_x"></vs-button>
								<formIngresarNino></formIngresarNino>
							</div>
						</div>
				</div>
				<vs-row	vs-align="center" vs-type="flex"  class="m-10" vs-justify="space-around" vs-w="12">
					<div class="vx-col md:w-1/4 w-full mt-5">
							<vs-button @click="sumar_nino">Agregar nuevo niño apadrinado</vs-button>
					</div>
				</vs-row>

			</tab-content>

			<!-- tab 3 content -->
			<tab-content title="Step 3" class="mb-5" icon="feather icon-image">
				<div class="vx-row">

					<formIngresarFamilia>  </formIngresarFamilia>
					<div v-if="cantidad_ingresos_familia.length">
						<div v-for="(numero,index) in cantidad_ingresos_familia" :key="index">
							<vs-divider class="mt-10" ></vs-divider>
							<vs-button radius color="danger" type="gradient" @click="quitar_familia(index)" icon="icon_x"></vs-button>
							<formIngresarFamilia v-if="cantidad_ingresos_familia[numero]==numero"></formIngresarFamilia>
						</div>
					</div>

					<div class="vx-col md:w-1/2 w-full mt-5">
						<div class="vx-col w-full">
							<vs-input class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="Dirección Familiar" v-model="direccion"/>
							<span class="text-danger">La dirección es requerida</span>
						</div>
					</div>

					<div class="vx-col md:w-1/2 w-full mt-3">
						<small class="date-label">Sector de Vivienda</small>
						<v-select label="nombre" :options="sectores" class="mt-1"  v-model="sector_id" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
					</div>

					<div class="vx-col md:w-1/2 w-full mt-5">
						<div class="vx-col w-full">
							<vs-input class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="Codigo de la Familia" v-model="codigo_familia"/>
							<span class="text-danger">El codigo de la familia es requerida</span>
						</div>
					</div>

					<vs-row	vs-align="center" vs-type="flex" vs-justify="space-around" vs-w="12">
						<div class="vx-col md:w-1/4 w-full mt-5">
								<vs-button @click="sumar_familia">Agregar nuevo familiar del niño</vs-button>
						</div>
					</vs-row>

				</div>
			</tab-content>

		</form-wizard>
	</vx-card>
</template>

<script>
import formIngresarNino from './form_ingresar_nino.vue'
import formIngresarPadrino from './form_ingresar_padrino.vue'
import formIngresarFamilia from './form_ingresar_familia.vue'
import {FormWizard, TabContent} from 'vue-form-wizard'
import 'vue-form-wizard/dist/vue-form-wizard.min.css'
import vSelect from 'vue-select'
import axios from 'axios'


export default {
  props: {
	// para las confirmaciones del niño
    confirmacion1: {
		type: String,
  	  default: 'false'
    },
	// para las confirmaciones del padrino
    confirmacion2: {
		type: String,
  	  default: 'false'
    },
	// para las confirmaciones de la familia
    confirmacion3: {
      type: String,
  	  default: 'false'
    }
  },
  data() {
    return {
	  firstName: "",
	  cantidad_ingresos_nino:[],
	  cantidad_ingresos_padrino:[],
	  cantidad_ingresos_familia:[],
	  sectores:[],
	  sector_id:0,
	  direccion:'',
	  codigo_familia:''
    }
  },
  methods: {
	async importarSectores(){ //async para que se llame cada vez que se necesite
		let me = this;
		const response = await axios.get(
		`/api/sector/get?&completo=select`)
		.then(function (response) {
			var respuesta= response.data;
			me.sectores = respuesta.sectores.data;
			me.pagination= respuesta.pagination;
		})
		.catch(function (error) {
			console.log(error);
		});
	},
    formSubmitted(){
		// aqui traeremos un dato del componente hijo para validar todo el formulario
		/*
		// alert('Form submitted!');
		axios.post("/api/nino/post/",{
				codigo:this.codigoT,
				nombres:this.nombresT,
				apellidos:this.apellidosT,
				genero:this.generoT,
				ruta_imagen:this.ruta_imagenT,
				fecha_nacimiento:this.getDate(this.fecha_nacimientoT),
				fecha_ingreso:this.getDate(this.fecha_ingresoT),
				direccion:this.direccionT,
				sector_id:this.sector_idT.id,
				escuela_id:this.escuela_idT.id
		}).then(function(response) {
		console.log(response)
			})
			.catch(function(error) {
			console.log(error)
			});
			this.$emit('cerrado','Se cerró el formulario');
			this.$vs.notify({
			color:'success',
			title:`${this.titulo}`,
			text:'La acción se realizo exitósamente'
			});
			this.$router.push('/apadrinamiento/nino');
		},
		*/
	},
	sumar_nino(){
		this.cantidad_ingresos_nino.push(this.cantidad_ingresos_nino.length+1);
		console.log(this.cantidad_ingresos_nino)
	},
	sumar_padrino(){
		this.cantidad_ingresos_padrino.push(this.cantidad_ingresos_padrino.length+1);
	},
	sumar_familia(){
		this.cantidad_ingresos_familia.push(this.cantidad_ingresos_familia.length+1);
	},
	quitar_nino(id){
		this.cantidad_ingresos_nino.splice(id-1,1)
		this.cantidad_ingresos_nino = this.reordenar(this.cantidad_ingresos_nino)
		console.log(this.cantidad_ingresos_nino)
	},
	quitar_padrino(id){
		console.log(id)
		console.log(this.cantidad_ingresos_padrino)
		this.cantidad_ingresos_padrino.splice(id,1)
		//this.cantidad_ingresos_padrino = this.reordenar(this.cantidad_ingresos_padrino)
		console.log(this.cantidad_ingresos_padrino)
	},
	quitar_familia(id){
		this.cantidad_ingresos_familia.splice(id,1)
	},
	reordenar (arreglo)
	{
		let tam = arreglo.length
		arreglo =[]
		for (var i = 1; i <= tam; i++) {
			arreglo.push(i);
		}
		return arreglo
	}
  },
  components: {
    FormWizard,
	TabContent,
	formIngresarNino,
	formIngresarPadrino,
	formIngresarFamilia,
	vSelect,
  },
  mounted(){
    this.importarSectores();
  },
}
</script>
        