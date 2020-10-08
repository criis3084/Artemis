<template>
	<div>
		<template>
			<div class="vx-row mb-2">
				<vs-list>
					<h4> 
					<vs-list-header title="1. ¿Cuántos miembros del hogar tienen 13 años de edad o menos?"></vs-list-header>
					</h4>
					<ul class="centerx mt-3">
							<vs-radio color="success" class="m-3" v-model="respuesta1" vs-value="133">  0  </vs-radio>
							<vs-radio color="success" class="m-3" v-model="respuesta1" vs-value="123">  1  </vs-radio>
							<vs-radio color="success" class="m-3" v-model="respuesta1" vs-value="117">  2  </vs-radio>
							<vs-radio color="success" class="m-3" v-model="respuesta1" vs-value="112">  3  </vs-radio>
							<vs-radio color="success" class="m-3" v-model="respuesta1" vs-value="110">  4  </vs-radio>
							<vs-radio color="success" class="m-3" v-model="respuesta1" vs-value="100">  5  </vs-radio>
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
						<vs-radio color="success" class="m-3" v-model="respuesta2" vs-value="206">  Sí  </vs-radio>
						<vs-radio color="success" class="m-3" v-model="respuesta2" vs-value="200">  No  </vs-radio>
						<vs-radio color="success" class="m-3" v-model="respuesta2" vs-value="202">  No hay niños de 7-13 años </vs-radio>
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
					<vs-radio color="success" class="m-3" v-model="respuesta3" vs-value="306">  Sí  </vs-radio>
					<vs-radio color="success" class="m-3" v-model="respuesta3" vs-value="300">  No  </vs-radio>
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
					<vs-radio color="success" class="m-3" v-model="respuesta4" vs-value="400">  Sí  </vs-radio>
					<vs-radio color="success" class="m-3" v-model="respuesta4" vs-value="405">  No  </vs-radio>
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
					<vs-radio color="success" class="m-3" v-model="respuesta5" vs-value="500">  Tierra  </vs-radio>
					<vs-radio color="success" class="m-3" v-model="respuesta5" vs-value="503">  Torta  </vs-radio>
					<vs-radio color="success" class="m-3" v-model="respuesta5" vs-value="509">  Ladrillo de cemento</vs-radio>
					<vs-radio color="success" class="m-3" v-model="respuesta5" vs-value="515">  Cerámico </vs-radio>
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
					<vs-radio color="success" class="m-3" v-model="respuesta6" vs-value="609">  Sí  </vs-radio>
					<vs-radio color="success" class="m-3" v-model="respuesta6" vs-value="600">  No  </vs-radio>
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
					<vs-radio color="success" class="m-3" v-model="respuesta7" vs-value="708">  Sí  </vs-radio>
					<vs-radio color="success" class="m-3" v-model="respuesta7" vs-value="700">  No  </vs-radio>
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
					<vs-radio color="success" class="m-3" v-model="respuesta8" vs-value="800">  En su casa  </vs-radio>
					<vs-radio color="success" class="m-3" v-model="respuesta8" vs-value="803">  Al molino </vs-radio>
				</ul>
			</vs-list>
		</div>
		<vs-divider></vs-divider>
		<div class="vx-row mb-2">
			<vs-list>
				<h4> 
				<vs-list-header title="9. ¿En su casa hay plancha eléctrica?"></vs-list-header>
				</h4>
				<ul class="centerx mt-3">
					<vs-radio color="success" class="m-3" v-model="respuesta9" vs-value="908">  Sí  </vs-radio>
					<vs-radio color="success" class="m-3" v-model="respuesta9" vs-value="900">  No  </vs-radio>
				</ul>
			</vs-list>
		</div>
		<vs-divider></vs-divider>
		<div class="vx-row mb-2">
			<vs-list>
				<h4> 
				<vs-list-header title="10. ¿Alguien en el hogar tiene una empresa de agricultura?"></vs-list-header>
				</h4>
				<ul class="centerx mt-3">
					<vs-radio color="success" class="m-3" v-model="respuesta10" vs-value="1003">  Sí  </vs-radio>
					<vs-radio color="success" class="m-3" v-model="respuesta10" vs-value="1000">  No  </vs-radio>
				</ul>
			</vs-list>
		</div>
		<vs-divider></vs-divider>
		<vx-card
			:title="titulo"
			title-color="#fff"
			:card-background="valorT<34 ? 'success':'danger'"
			content-color="#fff"
			>

			<p v-if="valorT>34"> PPI no aceptable para el programa</p>
			<p v-else>	PPI aceptable  para el programa	 </p>
		</vx-card>

	</div>
</template>

<script>

import { es } from 'vuejs-datepicker/src/locale'
import axios from 'axios'
import { Validator } from 'vee-validate';
import Datepicker from 'vuejs-datepicker'

export default {
	props:{
		ingresar:{
			default:false
		},
	},
  	data() {
		return {
			respuesta1:null,
			respuesta2:null,
			respuesta3:null,
			respuesta4:null,
			respuesta5:null,
			respuesta6:null,
			respuesta7:null,
			respuesta8:null,
			respuesta9:null,
			respuesta10:null,
			resultado:null,
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
		}
	},
	watch: {
		ingresar: function(newVal, oldVal) {
			if (newVal == true){
				this.ingresarPpi()
			}
		},
		respuesta1(value) {
			this.validator.validate('respuesta1', value);
			this.calcularTotal
			this.validateForm();
		},
		respuesta2(value) {
			this.validator.validate('respuesta2', value);
			this.calcularTotal
			this.validateForm();
		},
		respuesta3(value) {
			this.validator.validate('respuesta3', value);
			this.calcularTotal
			this.validateForm();
		},
		respuesta4(value) {
			this.validator.validate('respuesta4', value);
			this.calcularTotal
			this.validateForm();
		},
		respuesta5(value) {
			this.validator.validate('respuesta5', value);
			this.calcularTotal
			this.validateForm();
		},
		respuesta6(value) {
			this.validator.validate('respuesta6', value);
			this.calcularTotal
			this.validateForm();
		},
		respuesta7(value) {
			this.validator.validate('respuesta7', value);
			this.calcularTotal
			this.validateForm();
		},
		respuesta8(value) {
			this.validator.validate('respuesta8', value);
			this.calcularTotal
			this.validateForm();
		},
		respuesta9(value) {
			this.validator.validate('respuesta9', value);
			this.calcularTotal
			this.validateForm();
		},
		respuesta10(value) {
			this.validator.validate('respuesta10', value);
			this.calcularTotal
			this.validateForm();
		},
	}, 
	methods:{
		enviando(id){
			this.$emit('recibirPpi',{ppi_id:id});
		},
		ingresarPpi(){
			let me = this;
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
		},
		getDate(datetime) {
			let date = new Date(datetime);
			let dateString = `${date.getFullYear()}/${date.getMonth() + 1}/${date.getDate()}`;
			return dateString;
		},
		validateForm() {
			this.validator.validateAll({
				respuesta1: this.respuesta1,
				respuesta2: this.respuesta2,
				respuesta3: this.respuesta3,
				respuesta4: this.respuesta4,
				respuesta5: this.respuesta5,
				respuesta6: this.respuesta6,
				respuesta7: this.respuesta7,
				respuesta8: this.respuesta8,
				respuesta9: this.respuesta9,
				respuesta10: this.respuesta10,
			}).then((result) => {
				if (result ){
					this.$emit('validado',200);
					return;
				}
				this.$emit('validado',400);
			});
		},
		mError(valor){
			if(valor<34)
			{
				return true
			}
			return false
		}
	},
	computed: {
		calcularTotal(){
			this.valor1 = (this.respuesta1==0 || this.respuesta1 == null) ? 0 :this.respuesta1-100;
			this.valor2 = (this.respuesta2==0 || this.respuesta2 == null) ? 0 :this.respuesta2-200;
			this.valor3 = (this.respuesta3==0 || this.respuesta3 == null) ? 0 :this.respuesta3-300;
			this.valor4 = (this.respuesta4==0 || this.respuesta4 == null) ? 0 :this.respuesta4-400;
			this.valor5 = (this.respuesta5==0 || this.respuesta5 == null) ? 0 :this.respuesta5-500;
			this.valor6 = (this.respuesta6==0 || this.respuesta6 == null) ? 0 :this.respuesta6-600;
			this.valor7 = (this.respuesta7==0 || this.respuesta7 == null) ? 0 :this.respuesta7-700;
			this.valor8 = (this.respuesta8==0 || this.respuesta8 == null) ? 0 :this.respuesta8-800;
			this.valor9 = (this.respuesta9==0 || this.respuesta9 == null) ? 0 :this.respuesta9-900;
            this.valor10= (this.respuesta10==0 || this.respuesta10 == null)  ? 0 :this.respuesta10-1000;
			this.valorT =this.valor1+this.valor2+this.valor3+this.valor4+this.valor5+this.valor6+this.valor7+this.valor8+this.valor9+this.valor10
			this.titulo
			return this.valorT
		},
		titulo(){
			return "Total: " + this.valorT
		},
	},
	components: {
		Datepicker,
	},
	created() {
		this.validator = new Validator({
			respuesta1: 'required',
			respuesta2: 'required',
			respuesta3: 'required',
			respuesta4: 'required',
			respuesta5: 'required',
			respuesta6: 'required',
			respuesta7: 'required',
			respuesta8: 'required',
			respuesta9: 'required',
			respuesta10: 'required',
		});
	}
}
</script>