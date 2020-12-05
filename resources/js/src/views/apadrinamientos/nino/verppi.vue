<template>
	<div>
		<vx-card>
			<div>

			<div class="vx-col md:w-1/2 w-full mt-5">
				<div class="my-4">
					<small class="date-label">Fecha de Estudio</small>
					<datepicker :language="$vs.rtl ? langEn : langEn" name="end-date" v-model="fecha" disabled></datepicker>
				</div>
			</div>

			<template>
				<div class="vx-row mb-2">
					<vs-list>
						<h4> 
						<vs-list-header title="1. ¿Cuántos miembros del hogar tienen 13 años de edad o menos?"></vs-list-header>
						</h4>
						<ul class="centerx mt-3">
								<vs-radio color="success" disabled class="m-3" v-model="respuesta1" vs-value="133">  0  </vs-radio>
								<vs-radio color="success" disabled class="m-3" v-model="respuesta1" vs-value="123">  1  </vs-radio>
								<vs-radio color="success" disabled class="m-3" v-model="respuesta1" vs-value="117">  2  </vs-radio>
								<vs-radio color="success" disabled class="m-3" v-model="respuesta1" vs-value="112">  3  </vs-radio>
								<vs-radio color="success" disabled class="m-3" v-model="respuesta1" vs-value="110">  4  </vs-radio>
								<vs-radio color="success" disabled class="m-3" v-model="respuesta1" vs-value="100">  5  </vs-radio>
						</ul>
					</vs-list>
				</div>
			</template>
			
			<vs-divider></vs-divider>

			<template>
				<div class="vx-row mb-2">
					<vs-list>
						<h4> 
						<vs-list-header title="2. De los niños de 7-13 años de edad, ¿están todos estudiando?"></vs-list-header>
						</h4>
						<ul class="centerx mt-3">
							<vs-radio color="success" class="m-3" disabled v-model="respuesta2" vs-value="206">  Sí  </vs-radio>
							<vs-radio color="success" class="m-3" disabled v-model="respuesta2" vs-value="200">  No  </vs-radio>
							<vs-radio color="success" class="m-3" disabled v-model="respuesta2" vs-value="202">  No hay niños de 7-13 años </vs-radio>
						</ul>
					</vs-list>
				</div>
			</template>
			<vs-divider></vs-divider>
			<template>
			<div class="vx-row mb-2">
				<vs-list>
					<h4> 
					<vs-list-header title="3. ¿Sabe la madre leer y escribir?"></vs-list-header>
					</h4>
					<ul class="centerx mt-3">
						<vs-radio color="success" class="m-3" disabled v-model="respuesta3" vs-value="306">  Sí  </vs-radio>
						<vs-radio color="success" class="m-3" disabled v-model="respuesta3" vs-value="300">  No  </vs-radio>
					</ul>
				</vs-list>
			</div>
			</template>
			<vs-divider></vs-divider>
			<div class="vx-row mb-2">
				<vs-list>
					<h4> 
					<vs-list-header title="4. ¿Trabaja algún miembro de la familia como jornalero o empleado doméstcio?"></vs-list-header>
					</h4>
					<ul class="centerx mt-3">
						<vs-radio color="success" class="m-3" disabled v-model="respuesta4" vs-value="400">  Sí  </vs-radio>
						<vs-radio color="success" class="m-3" disabled v-model="respuesta4" vs-value="405">  No  </vs-radio>
					</ul>
				</vs-list>
			</div>
			<vs-divider></vs-divider>
			<div class="vx-row mb-2">
				<vs-list>
					<h4> 
					<vs-list-header title="5. ¿Qué tipo de piso tiene la casa?"></vs-list-header>
					</h4>
					<ul class="centerx mt-3">
						<vs-radio color="success" class="m-3" disabled v-model="respuesta5" vs-value="500">  Tierra  </vs-radio>
						<vs-radio color="success" class="m-3" disabled v-model="respuesta5" vs-value="503">  Torta  </vs-radio>
						<vs-radio color="success" class="m-3" disabled v-model="respuesta5" vs-value="509">  Ladrillo de cemento</vs-radio>
						<vs-radio color="success" class="m-3" disabled v-model="respuesta5" vs-value="515">  Cerámico </vs-radio>
					</ul>
				</vs-list>
			</div>
			<vs-divider></vs-divider>
			<div class="vx-row mb-2">
				<vs-list>
					<h4> 
					<vs-list-header title="6. ¿En su casa hay refrigerador?"></vs-list-header>
					</h4>
					<ul class="centerx mt-3">
						<vs-radio color="success" class="m-3" disabled v-model="respuesta6" vs-value="609">  Sí  </vs-radio>
						<vs-radio color="success" class="m-3" disabled v-model="respuesta6" vs-value="600">  No  </vs-radio>
					</ul>
				</vs-list>
			</div>
			<vs-divider></vs-divider>
			<div class="vx-row mb-2">
				<vs-list>
					<h4> 
					<vs-list-header title="7. ¿En su casa hay estufa eléctrica o de gas?"></vs-list-header>
					</h4>
					<ul class="centerx mt-3">
						<vs-radio color="success" class="m-3" disabled v-model="respuesta7" vs-value="708">  Sí  </vs-radio>
						<vs-radio color="success" class="m-3" disabled v-model="respuesta7" vs-value="700">  No  </vs-radio>
					</ul>
				</vs-list>
			</div>
			<vs-divider></vs-divider>
			<div class="vx-row mb-2">
				<vs-list>
					<h4> 
					<vs-list-header title="8. ¿Muele maíz en su casa o lo lleva al molino?"></vs-list-header>
					</h4>
					<ul class="centerx mt-3">
						<vs-radio color="success" class="m-3" disabled v-model="respuesta8" vs-value="800">  En su casa  </vs-radio>
						<vs-radio color="success" class="m-3" disabled v-model="respuesta8" vs-value="803">  Al molino </vs-radio>
					</ul>
				</vs-list>
			</div>
			<vs-divider></vs-divider>
			<div class="vx-row mb-2 md:w-1/2">
				<vs-list>
					<h4> 
					<vs-list-header title="9. ¿En su casa hay plancha eléctrica?"></vs-list-header>
					</h4>
					<ul class="centerx mt-3">
						<vs-radio color="success" class="m-3" disabled v-model="respuesta9" vs-value="908">  Sí  </vs-radio>
						<vs-radio color="success" class="m-3" disabled v-model="respuesta9" vs-value="900">  No  </vs-radio>
					</ul>
				</vs-list>
			</div>
			<vs-divider></vs-divider>
			<div class="vx-row mb-2 md:w-1/2">
				<vs-list>
					<h4> 
					<vs-list-header title="10. ¿Alguien en el hogar tiene una empresa de agricultura?"></vs-list-header>
					</h4>
					<ul class="centerx mt-3">
						<vs-radio color="success" class="m-3" disabled v-model="respuesta10" vs-value="1003">  Sí  </vs-radio>
						<vs-radio color="success" class="m-3" disabled v-model="respuesta10" vs-value="1000">  No  </vs-radio>
					</ul>
				</vs-list>
			</div>
			<vs-divider></vs-divider>

			<vs-alert v-if="calcularTotal>34" :title="titulo" color="success" icon="check_circle" >
				El PPI es optimo
			</vs-alert>
			<vs-alert :title="titulo" color="danger" v-else icon="error">
				El PPI es peligroso
			</vs-alert>
			<vs-divider></vs-divider>
				<router-link :to="ruta()"><vs-button class="w-full" icon-pack="feather" icon="icon-corner-up-left" icon-no-border>Regresar al historial</vs-button></router-link>
			</div>
		</vx-card>
	</div>
</template>

<script>

import { es } from 'vuejs-datepicker/src/locale'
import axios from 'axios'
import Datepicker from 'vuejs-datepicker'


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
		valor9:0,
		valor10:0,
		valorT:0,
		id:0,
		fecha:"",
		langEn: es,
		id_historial:0,
		id_ppi:0,
		id_nino:0,
	}
  },
  methods:{	
	async traerPpi(){ 
        let me = this;
        me.id_historial = this.$route.params.id;
		const response = await axios.get(
			`/api/historialPpi/get?&criterio=id&buscar=${me.id_historial}&completo=true`)
		.then(function (response) {
			var respuesta= response.data;
			var informacion = respuesta.historialPpis.data[0];
			me.respuesta1 = informacion.ppi.respuesta1+100;
			me.respuesta2 = informacion.ppi.respuesta2+200;
			me.respuesta3 = informacion.ppi.respuesta3+300;
			me.respuesta4 = informacion.ppi.respuesta4+400;
			me.respuesta5 = informacion.ppi.respuesta5+500;
			me.respuesta6 = informacion.ppi.respuesta6+600;
			me.respuesta7 = informacion.ppi.respuesta7+700;
			me.respuesta8 = informacion.ppi.respuesta8+800;
			me.respuesta9 = informacion.ppi.respuesta9+900;
			me.respuesta10 = informacion.ppi.respuesta10+1000;
			me.fecha = informacion.fecha_estudio;
			me.id_nino = informacion.nino_id;
		})
		.catch(function (error) {
			console.log(error);
		});
	},
	ruta(){
		return '/apadrinamiento/ppi/'+this.id_nino
	},
	guardar(){
		this.id=parseInt(this.$route.params.id)
		axios.post("/api/historialPpi/post/",{
			nino_id:this.id,
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
			fecha_estudio:this.getDate(this.fecha)
		}).then(function(response) {
				console.log(response)
				this.$vs.notify({
					color:'success',
					title:'Exito',
					text:'Registro Creado!'
				});
			})
			.catch(function(error) {
			console.log(error)
		});
		this.$router.push('/apadrinamiento/ppi/'+this.id);
	},
	getDate(datetime) {
        let date = new Date(datetime);
        let dateString = `${date.getFullYear()}/${date.getMonth() + 1}/${date.getDate()}`;
        return dateString;
	}
  },computed: {
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
  },
  mounted(){
    this.traerPpi();
  },
  components: {
	Datepicker,
  },
}
</script>