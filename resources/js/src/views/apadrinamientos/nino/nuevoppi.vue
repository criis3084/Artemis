 <template>
	<div>
		<form>
		<vx-card>
			<div>

				<div class = "demo-alignment">
				<div class="vx-col md:w-1/3 w-full mt-5">
            		<vs-button @click="regresar" type="border" radius class="w-full" icon-pack="feather" icon="icon-corner-up-left" icon-no-border></vs-button>
        		</div>
				<div class="flex items-center">
				<h2>Nuevo PPI</h2>
				</div>
				</div>
				<vs-divider position="right">PID&#174;</vs-divider>
			<div class = "demo-alignment">
			<h4><b>Nombre del niño:</b></h4><h4>{{nombre}}</h4><h4>{{apellido}}</h4>
			</div><br>
			<div class="vx-col md:w-1/2 w-full mt-5">
				<div class="my-4">
					<h5 class="text-primary"><b>Fecha de Estudio</b></h5>
					<datepicker :language="$vs.rtl ? langEn : langEn" name="fecha" v-model="fecha" v-validate="'required'"></datepicker>
					<span class="text-danger">{{ errors.first('fecha') }}</span>
				</div>
			</div>

			<template>
				<div class="vx-row mb-2">
					<vs-list>
						<h5> 
						<vs-list-header title="1. ¿Cuántos miembros del hogar tienen 13 años de edad o menos?"></vs-list-header>
						</h5>
						<ul class="centerx mt-3">
								<vs-radio v-validate="'required|included:133,123,117,112,110,100'" name="respuesta1" color="success" class="m-3" v-model="respuesta1" vs-value="133">  0  </vs-radio>
								<vs-radio name="respuesta1" color="success" class="m-3" v-model="respuesta1" vs-value="123">  1  </vs-radio>
								<vs-radio name="respuesta1" color="success" class="m-3" v-model="respuesta1" vs-value="117">  2  </vs-radio>
								<vs-radio name="respuesta1" color="success" class="m-3" v-model="respuesta1" vs-value="112">  3  </vs-radio>
								<vs-radio name="respuesta1" color="success" class="m-3" v-model="respuesta1" vs-value="110">  4  </vs-radio>
								<vs-radio name="respuesta1" color="success" class="m-3" v-model="respuesta1" vs-value="100">  5  </vs-radio>
						</ul>
					</vs-list>
					<span class="text-danger">{{ errors.first('respuesta1') }}</span>

				</div>
			</template>
			
			<vs-divider></vs-divider>

			<template>
				<div class="vx-row mb-2">
					<vs-list>
						<h5> 
						<vs-list-header title="2. De los niños de 7-13 años de edad, ¿están todos estudiando?"></vs-list-header>
						</h5>
						<ul class="centerx mt-3">
							<vs-radio v-validate="'required|included:206,200,202'" name="respuesta2" color="success" class="m-3" v-model="respuesta2" vs-value="206">  Sí  </vs-radio>
							<vs-radio name="respuesta2" color="success" class="m-3" v-model="respuesta2" vs-value="200">  No  </vs-radio>
							<vs-radio name="respuesta2" color="success" class="m-3" v-model="respuesta2" vs-value="202">  No hay niños de 7-13 años </vs-radio>
						</ul>
					</vs-list>
					<span class="text-danger">{{ errors.first('respuesta2') }}</span>

				</div>
			</template>
			<vs-divider></vs-divider>
			<template>
			<div class="vx-row mb-2">
				<vs-list>
					<h5> 
					<vs-list-header title="3. ¿Sabe la madre leer y escribir?"></vs-list-header>
					</h5>
					<ul class="centerx mt-3">
						<vs-radio v-validate="'required|included:306,300'" name="respuesta3" color="success" class="m-3" v-model="respuesta3" vs-value="306">  Sí  </vs-radio>
						<vs-radio name="respuesta3" color="success" class="m-3" v-model="respuesta3" vs-value="300">  No  </vs-radio>
					</ul>
				</vs-list>
				<span class="text-danger">{{ errors.first('respuesta3') }}</span>
			</div>
			</template>
			<vs-divider></vs-divider>
			<div class="vx-row mb-2">
				<vs-list>
					<h5> 
					<vs-list-header title="4. ¿Trabaja algún miembro de la familia como jornalero o empleado doméstico?"></vs-list-header>
					</h5>
					<ul class="centerx mt-3">
						<vs-radio v-validate="'required|included:400,405'" name="respuesta4" color="success" class="m-3" v-model="respuesta4" vs-value="400">  Sí  </vs-radio>
						<vs-radio name="respuesta4" color="success" class="m-3" v-model="respuesta4" vs-value="405">  No  </vs-radio>
					</ul>
				</vs-list>
				<span class="text-danger">{{ errors.first('respuesta4') }}</span>

			</div>
			<vs-divider></vs-divider>
			<div class="vx-row mb-2">
				<vs-list>
					<h5> 
					<vs-list-header title="5. ¿Qué tipo de piso tiene la casa?"></vs-list-header>
					</h5>
					<ul class="centerx mt-3">
						<vs-radio v-validate="'required|included:500,503,509,515'" name="respuesta5" color="success" class="m-3" v-model="respuesta5" vs-value="500">  Tierra  </vs-radio>
						<vs-radio name="respuesta5" color="success" class="m-3" v-model="respuesta5" vs-value="503">  Torta  </vs-radio>
						<vs-radio name="respuesta5" color="success" class="m-3" v-model="respuesta5" vs-value="509">  Ladrillo de cemento</vs-radio>
						<vs-radio name="respuesta5" color="success" class="m-3" v-model="respuesta5" vs-value="515">  Cerámico </vs-radio>
					</ul>
				</vs-list>
				<span class="text-danger">{{ errors.first('respuesta5') }}</span>

			</div>
			<vs-divider></vs-divider>
			<div class="vx-row mb-2">
				<vs-list>
					<h5> 
					<vs-list-header title="6. ¿En su casa hay refrigerador?"></vs-list-header>
					</h5>
					<ul class="centerx mt-3">
						<vs-radio v-validate="'required|included:609,600'" name="respuesta6" color="success" class="m-3" v-model="respuesta6" vs-value="609">  Sí  </vs-radio>
						<vs-radio name="respuesta6" color="success" class="m-3" v-model="respuesta6" vs-value="600">  No  </vs-radio>
					</ul>
				</vs-list>
				<span class="text-danger">{{ errors.first('respuesta6') }}</span>

			</div>
			<vs-divider></vs-divider>
			<div class="vx-row mb-2">
				<vs-list>
					<h5> 
					<vs-list-header title="7. ¿En su casa hay estufa eléctrica o de gas?"></vs-list-header>
					</h5>
					<ul class="centerx mt-3">
						<vs-radio v-validate="'required|included:708,700'" name="respuesta7" color="success" class="m-3" v-model="respuesta7" vs-value="708">  Sí  </vs-radio>
						<vs-radio name="respuesta7" color="success" class="m-3" v-model="respuesta7" vs-value="700">  No  </vs-radio>
					</ul>
				</vs-list>
				<span class="text-danger">{{ errors.first('respuesta7') }}</span>

			</div>
			<vs-divider></vs-divider>
			<div class="vx-row mb-2">
				<vs-list>
					<h5> 
					<vs-list-header title="8. ¿Muele maíz en su casa o lo lleva al molino?"></vs-list-header>
					</h5>
					<ul class="centerx mt-3">
						<vs-radio v-validate="'required|included:800,803'" name="respuesta8" color="success" class="m-3" v-model="respuesta8" vs-value="800">  En su casa  </vs-radio>
						<vs-radio name="respuesta8" color="success" class="m-3" v-model="respuesta8" vs-value="803">  Al molino </vs-radio>
					</ul>
				</vs-list>
				<span class="text-danger">{{ errors.first('respuesta8') }}</span>

			</div>
			<vs-divider></vs-divider>
			<div class="vx-row mb-2 md:w-1/2">
				<vs-list>
					<h5> 
					<vs-list-header title="9. ¿En su casa hay plancha eléctrica?"></vs-list-header>
					</h5>
					<ul class="centerx mt-3">
						<vs-radio v-validate="'required|included:908,900'" name="respuesta9" color="success" class="m-3" v-model="respuesta9" vs-value="908">  Sí  </vs-radio>
						<vs-radio name="respuesta9" color="success" class="m-3" v-model="respuesta9" vs-value="900">  No  </vs-radio>
					</ul>
				</vs-list>
				<span class="text-danger">{{ errors.first('respuesta9') }}</span>

			</div>
			<vs-divider></vs-divider>
			<div class="vx-row mb-2 md:w-1/2">
				<vs-list>
					<h5> 
					<vs-list-header title="10. ¿Alguien en el hogar tiene una empresa de agricultura?"></vs-list-header>
					</h5>
					<ul class="centerx mt-3">
						<vs-radio v-validate="'required|included:1003,1000'" name="respuesta10" color="success" class="m-3" v-model="respuesta10" vs-value="1003">  Sí  </vs-radio>
						<vs-radio name="respuesta10" color="success" class="m-3" v-model="respuesta10" vs-value="1000">  No  </vs-radio>
					</ul>
				</vs-list>
				<span class="text-danger">{{ errors.first('respuesta10') }}</span>

			</div>
			<vs-divider></vs-divider>

			<vs-alert v-if="calcularTotal>34" :title="titulo" color="success" icon="check_circle" >
				PPI no aceptable para el programa
			</vs-alert>
			<vs-alert :title="titulo" color="danger" v-else icon="error">
				PPI aceptable para el programa
			</vs-alert>
			<vs-divider></vs-divider>

			<vs-button type="gradient" icon-pack="feather" icon="icon-save" @click.prevent="guardar">Registrar PPI</vs-button>
			</div>
		</vx-card>
		</form>
	</div>
</template>

<script>

import { es } from 'vuejs-datepicker/src/locale'
import axios from 'axios'
import Datepicker from 'vuejs-datepicker'
// For custom error message
import { Validator } from 'vee-validate';
const dict = {
  custom: {
    fecha: {
	  required: 'La fecha es requerida',
	},
	respuesta1: {
	  required: 'Seleccione una opción',
	  included: 'Seleccione una opción',
	},
	respuesta2: {
	  required: 'Seleccione una opción',
	  included: 'Seleccione una opción',
	},
	respuesta3: {
	  required: 'Seleccione una opción',
	  included: 'Seleccione una opción',
	},
	respuesta4: {
	  required: 'Seleccione una opción',
	  included: 'Seleccione una opción',
	},
	respuesta5: {
	  required: 'Seleccione una opción',
	  included: 'Seleccione una opción',
	},
	respuesta6: {
	  required: 'Seleccione una opción',
	  included: 'Seleccione una opción',
	},
	respuesta7: {
	  required: 'Seleccione una opción',
	  included: 'Seleccione una opción',
	},
	respuesta8: {
	  required: 'Seleccione una opción',
	  included: 'Seleccione una opción',
	},
	respuesta9: {
	  required: 'Seleccione una opción',
	  included: 'Seleccione una opción',
	},
	respuesta10: {
	  required: 'Seleccione una opción',
	  included: 'Seleccione una opción',
	},
  }
};
Validator.localize('en', dict);
export default {
	data() {
		return {
			respuesta1:0,
			respuesta2:0,
			respuesta3:0,
			respuesta4:0,
			respuesta5:0,
			respuesta6:0,
			respuesta7:0,
			respuesta8:0,
			respuesta9:0,
			respuesta10:0,
			resultado:0,
			valor1:0,
			valor2:0,
			valor3:0,
			valor4:0,
			valor5:0,
			valor6:0,
			valor7:0,
			valor8:0,
			nombre: '',
			apellido: '',
			valor9:0,
			valor10:0,
			valorT:0,
			id:0,
			fecha:"",
			langEn: es,
			ppi_id:0,
			codigo_familiar:0,
			listadoNinos:[]
		}
	},
	methods:{
		enviando(id){
			this.ppi_id=id;
		},
		guardar(){	
		this.$validator.validateAll().then(result => {
        if(result) {
			let me = this;
			this.id=parseInt(this.$route.params.id)
			axios.post("/api/ppi/post/",{
				respuesta1:this.valor1,
				respuesta2:this.valor2,
				respuesta3:this.valor3,
				respuesta4:this.valor4,
				respuesta5:this.valor5,
				respuesta6:this.valor6,
				respuesta7:this.valor7,
				respuesta8:this.valor8,
				respuesta9:this.valor9,
				respuesta10:this.valor10,
				total:this.valorT,
			}).then(function(response) {
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
					text:'Ingrese correctamente todas las respuestas'
				})
        	}
			})
		},
		setearValor(unArreglo){
			this.listadoNinos=unArreglo.slice();
			let hash = {};
			this.listadoNinos = this.listadoNinos.filter(o => hash[o.nino_id] ? false : hash[o.nino_id] = true);
			let ppiT=this.ppi_id
			let today = this.getDate(this.fecha)
			this.listadoNinos.forEach(function(elemento, indice, array) {
				axios.post("/api/historialPpi/post/",{
					nino_id:elemento.nino_id,
					ppi_id:ppiT,
					fecha_estudio:today
				}).then(function(response) {
						console.log(response)
				})
					.catch(function(error) {
					console.log(error)
				});
			})
			let titulo = 'PPI registrado!';
			this.$vs.notify({
			color:'success',
			title:`${titulo}`,
			text:'La acción se realizo exitósamente'
			});
			this.$router.push('/apadrinamiento/ppi/'+this.id);
		},
		buscarHermanos(codigoT){
			let me = this;
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
		regresar(){
			let id_recibido = this.$route.params.id;
			this.$router.push('/apadrinamiento/ppi/'+id_recibido);
		},
		getDate(datetime) {
			let date = new Date(datetime);
			let dateString = `${date.getFullYear()}/${date.getMonth() + 1}/${date.getDate()}`;
			return dateString;
		},
		async index2(){
			this.fecha=new Date()
			let me = this;
			me.id_recibido = this.$route.params.id;
			const response = await axios.get(
			`/api/nino/get?&criterio=id&buscar=${me.id_recibido}&completo=true`)
			.then(function (response) {
				var respuesta= response.data;
				me.arrayData = respuesta.ninos.data;
				me.nombre = respuesta.ninos.data[0].datos.nombres;
				me.apellido = respuesta.ninos.data[0].datos.apellidos;
				me.codigo = respuesta.ninos.data[0].codigo;
				me.id = respuesta.ninos.data[0].datos.id;
			})
			.catch(function (error) {
				console.log(error);
			});
		},
	},
	computed: {
		calcularTotal: function () {
			this.valor1 = this.respuesta1==0 ? 0 : this.respuesta1-100;
			this.valor2 = this.respuesta2==0 ? 0 : this.respuesta2-200;
			this.valor3 = this.respuesta3==0 ? 0 : this.respuesta3-300;
			this.valor4 = this.respuesta4==0 ? 0 : this.respuesta4-400;
			this.valor5 = this.respuesta5==0 ? 0 : this.respuesta5-500;
			this.valor6 = this.respuesta6==0 ? 0 : this.respuesta6-600;
			this.valor7 = this.respuesta7==0 ? 0 : this.respuesta7-700;
			this.valor8 = this.respuesta8==0 ? 0 : this.respuesta8-800;
			this.valor9 = this.respuesta9==0 ? 0 : this.respuesta9-900;
			this.valor10 = this.respuesta10==0 ? 0 : this.respuesta10-1000;
			this.valorT =this.valor1+this.valor2+this.valor3+this.valor4+this.valor5+this.valor6+this.valor7+this.valor8+this.valor9+this.valor10
			return this.valorT
		},
		titulo(){
			this.valor1 = this.respuesta1==0 ? 0 : this.respuesta1-100;
			this.valor2 = this.respuesta2==0 ? 0 : this.respuesta2-200;
			this.valor3 = this.respuesta3==0 ? 0 : this.respuesta3-300;
			this.valor4 = this.respuesta4==0 ? 0 : this.respuesta4-400;
			this.valor5 = this.respuesta5==0 ? 0 : this.respuesta5-500;
			this.valor6 = this.respuesta6==0 ? 0 : this.respuesta6-600;
			this.valor7 = this.respuesta7==0 ? 0 : this.respuesta7-700;
			this.valor8 = this.respuesta8==0 ? 0 : this.respuesta8-800;
			this.valor9 = this.respuesta9==0 ? 0 : this.respuesta9-900;
			this.valor10 = this.respuesta10==0 ? 0 : this.respuesta10-1000;
			
			return "Total: " + (this.valor1+this.valor2+this.valor3+this.valor4+this.valor5+this.valor6+this.valor7+this.valor8+this.valor9+this.valor10)
		},
	// 	async index(){ //async para que se llame cada vez que se necesite
    //     let me = this;
    //     me.id_recibido = this.$route.params.id;
	// 	const response = await axios.get(
	// 		`/api/historialFotografia/get?&criterio=nino_id&buscar=${me.id_recibido}&completo=true`)
	// 	.then(function (response) {
	// 		var respuesta= response.data;
    //         me.arrayData = respuesta.historialfotografias.data;
    //         me.nombre = respuesta.historialfotografias.data[0].datos_nino[0].nombres;
    //         me.apellido = respuesta.historialfotografias.data[0].datos_nino[0].apellidos;
    //         me.codigo = respuesta.historialfotografias.data[0].nino.codigo;
    //         me.id = respuesta.historialfotografias.data[0].nino.id;
	// 	})
	// 	.catch(function (error) {
	// 		console.log(error);
	// 	});
	// },

	},
	components: {
		Datepicker,
	},
	mounted(){
    this.index2();
  },
}
</script>