<template>
	<vx-card>
		<vs-row	vs-align="center" vs-type="flex" vs-justify="space-around" vs-w="12">
				<div class="vx-col md:w-1/4 w-full mt-5">
					<vx-card noShadow class="center" title="INGRESAR FAMILIA" title-color="primary">
					</vx-card>
				</div>
		</vs-row>
		<form-wizard color="rgba(var(--vs-primary), 1)" :title="null" :subtitle="null" finishButtonText="Submit" on-validate @on-complete="envioFormularios">
			<!-- tab 1 content -->
			<tab-content title="Niños" class="mb-5" icon="feather icon-user" :before-change="validateStep1">

				<div class="vx-row">
					<div v-for="(numero,index) in cantidad_ninos" :key="index">
						<div v-if="numero.visible">
							<vs-divider class="mt-10"  v-if="numero.id!=1"></vs-divider>
							<vs-button radius color="danger" type="gradient" @click="quitar_nino(numero.id)" v-if="numero.id!=1" icon="X"></vs-button>
							<formIngresarNino
								v-bind:direccion="direccion"
								v-bind:sector_id="sector_id"
								v-bind:ingresar="ingresar"
								v-bind:id_formulario="numero.id"
								v-on:validado="validandoNino"
								v-on:recibirNinos="recibirNinos"
							>
							</formIngresarNino>
						</div>
					</div>
				</div>
				<vs-row	vs-align="center" vs-type="flex"  class="m-10" vs-justify="space-around" vs-w="12">
					<div class="vx-col md:w-1/4 w-full mt-5">
							<vs-button @click="sumar_nino">Agregar nuevo niño</vs-button>
					</div>
				</vs-row>
			
			</tab-content>

			<!-- tab 2 content -->
			<tab-content title="Familiares" class="mb-5" icon="feather icon-users" :before-change="validateStep2">

					<div class="vx-row">
						<div v-for="(numero,index) in cantidad_familia" :key="index">
							<div v-if="numero.visible">
								<vs-divider class="mt-10"  v-if="numero.id!=1"></vs-divider>
									<vs-button radius color="danger" type="gradient" @click="quitar_familia(numero.id)" v-if="numero.id!=1" icon="X"></vs-button>
									<formIngresarFamilia
										v-bind:direccion="direccion"
										v-bind:sector_id="sector_id"
										v-bind:ingresar="ingresar"
										v-bind:id_formulario="numero.id"
										v-on:validado="validandoFamilia"
										v-on:recibirFamiliares="recibirFamiliares"
									>
									</formIngresarFamilia>
							</div>
						</div>
					</div>

					<vs-divider position="center" class="mt-6">Datos Generales</vs-divider>
					<div class="vx-row">

						<div class="vx-col md:w-1/2 w-full mt-3">
							<div class="vx-col w-full">
								<small class="date-label">Sector de Vivienda</small>
								<v-select label="nombre" :options="sectores" class="mt-1"  v-model="sector_id" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
							</div>
						</div>

						<div class="vx-col md:w-1/2 w-full mt-5">
							<div class="vx-col w-full">
								<vs-input class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="Dirección Familiar" v-model="direccion"/>
								<span class="text-danger">La dirección es requerida</span>
							</div>
						</div>

						<div class="vx-col md:w-1/2 w-full">
							<div class="vx-col w-full">
								<vs-input class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="Codigo de la Familia" v-model="codigo_familia"/>
								<span class="text-danger">El codigo de la familia es requerida</span>
							</div>
						</div>

					</div>

					<vs-row	vs-align="center" vs-type="flex" vs-justify="space-around" vs-w="12" >
						<div class="vx-col md:w-1/4 w-full mt-5">
								<vs-button @click="sumar_familia">Agregar nuevo familiar del niño</vs-button>
						</div>
					</vs-row>

			</tab-content>

			<!-- tab 3 content -->
			<tab-content title="PPI" class="mb-5" icon="feather icon-trending-up" :before-change="validateStep3">
				<ppiFamilia
					v-bind:ingresar="ingresar"
					v-on:validado="validandoPpi"
					v-on:recibirPpi="recibirPpi"
				></ppiFamilia>
			</tab-content>

			<!-- tab 4 content -->
			<tab-content title="Estudio Socieconomico" class="mb-5" icon="feather icon-file-text">
				<estudioFamilia
					v-bind:ingresar="ingresar"
					v-on:validado="validandoEstudio"
					v-on:recibirEstudio="recibirEstudio"
				></estudioFamilia>
			</tab-content>

			
		</form-wizard>
	</vx-card>
</template>

<script>
import formIngresarNino from './form_ingresar_nino.vue'
import formIngresarPadrino from './form_ingresar_padrino.vue'
import formIngresarFamilia from './form_ingresar_familia.vue'
import ppiFamilia from './ppi_familia.vue'
import estudioFamilia from './estudio_familia.vue'
import {FormWizard, TabContent} from 'vue-form-wizard'
import 'vue-form-wizard/dist/vue-form-wizard.min.css'
import vSelect from 'vue-select'
import axios from 'axios'


export default {
  data() {
		return {
			sectores:[],
			sector_id:0,
			direccion:'',
			codigo_familia:'',
			
			ingresar:false,
			
			cantidad_ninos:[],
			cantidad_familia:[],
			
			ninosIngresados:[],
			famililaresIngresados:[],
			
			ppi_id:0,
			estudio_id:0,
			
			ppi_validado:false,
			estudio_validado:false,
			
			ninosI:1,
			familiaresI:1
		}
	},
	watch: {
		ninosIngresados: function(newVal, oldVal) {
			console.log('Se ingreso un niño')
			console.log('Nuevo valor: ', newVal, ' | valor cambiado: ', oldVal)
		},
		famililaresIngresados: function(newVal, oldVal) {
			console.log('Se ingreso un familiar')
			console.log('Nuevo valor: ', newVal, ' | valor cambiado: ', oldVal)
		},
		ppi_id: function(newVal, oldVal) {
			console.log('Se ingreso ppi')
			console.log('Nuevo valor: ', newVal, ' | valor cambiado: ', oldVal)
		},
		estudio_id: function(newVal, oldVal) {
			console.log('Se ingreso estudio')
			console.log('Nuevo valor: ', newVal, ' | valor cambiado: ', oldVal)
		}
	},
  	methods: {
		recibirNinos(e){
			this.ninosIngresados.push(e.id_nino)
			this.ingresoRelaciones()
		},
		recibirFamiliares(e){
			this.famililaresIngresados.push(e.id_familiar)
			this.ingresoRelaciones()
		},
		recibirPpi(e){
			this.ppi_id=e.ppi_id
			this.ingresoRelaciones()
		},
		recibirEstudio(e){
			this.estudio_id=e.id_estudio
			this.ingresoRelaciones()
		},
		validandoNino(e){
			this.cantidad_ninos.forEach(function(elemento, indice, array) {
				if (elemento.visible==true && elemento.id==e.id_form)
				{
					elemento.validado = e.validado
					console.log('Niño' + elemento.id + ' - ' + elemento.validado)
				}
			})
		},
		validandoFamilia(e){
			this.cantidad_familia.forEach(function(elemento, indice, array) {
				if (elemento.visible==true && elemento.id==e.id_form)
				{
					elemento.validado = e.validado
					console.log('Familiar ' + elemento.id + ' - ' + elemento.validado)
				}
			})
		},
		validandoPpi(e){
			console.log(e)
			if(e==200)
			{
				this.ppi_validado=true
			}
		},
		validandoEstudio(e){
			if(e==200)
			{
				this.estudio_validado=true
			}
		},
		envioFormularios(){
			if(this.estudio_validado==false){
				this.$vs.notify({
					color:'danger',
					title:`Error en validación`,
					text:'Ingrese correctamente los campos para continuar'
				})
			}
			else{
				this.ingresar=true;
				console.log('haciendo el envio')
			}
		},
		ingresoRelaciones(){
			if(this.ninosI==this.ninosIngresados.length && this.familiaresI == this.famililaresIngresados.length && this.ppi_id !=0 && this.estudio_id !=0)
			{
				console.log('*****************************')
				console.log('Todo correcto')
				console.log(this.ninosIngresados)
				console.log(this.famililaresIngresados)
				console.log(this.ppi_id)
				console.log(this.estudio_id)
				console.log('*****************************')
			}
			/*
			axios.post("/api/relacion/post/",{
				relacion:this.relacion,
				direccion:this.direccion,
				codigo:this.codigo,
				nino_id:this.nino_id,
				sector_id:this.sector_id,
				encargado_id:this.encargado_id,
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
			*/
		},
		sumar_nino(){
			this.cantidad_ninos.push({id:this.cantidad_ninos.length+1,visible:true,validado:false})
			this.ninosI+=1
		},
		sumar_familia(){
			this.cantidad_familia.push({id:this.cantidad_familia.length+1,visible:true,validado:false})
			this.familiaresI +=1
			console.log(this.familiaresI)
		},
		quitar_nino(id){
			this.cantidad_ninos.forEach(function(elemento, indice, array) {
				if (elemento.id==id && elemento.visible==true)
				{
					elemento.visible=false;
				}
			})
			this.ninosI-=1
		},
		quitar_familia(id){
			this.cantidad_familia.forEach(function(elemento, indice, array) {
				if (elemento.id==id)
				{
					elemento.visible=false;
				}
			})
			this.familiaresI-=1
			console.log(this.familiaresI)
		},
		validateStep1() {
			let retornar=true
			this.cantidad_ninos.forEach(function(elemento, indice, array) {
				console.log(elemento.id + ' - ' + elemento.validado + ' - ' + elemento.visible)
				if (elemento.visible==true && elemento.validado==false)
				{
					retornar = false
				}
			})
			if (retornar == false){
				this.$vs.notify({
				color:'danger',
				title:`Error en validación`,
				text:'Ingrese correctamente los campos para continuar'
			})
			}
			return retornar
		},
		validateStep2() {
			let retornar=true
				this.cantidad_familia.forEach(function(elemento, indice, array) {
					console.log(elemento.id + ' - ' + elemento.validado + ' - ' + elemento.visible)
					if (elemento.visible==true && elemento.validado==false)
					{
						retornar = false
					}
				})
				if (retornar == false){
					this.$vs.notify({
					color:'danger',
					title:`Error en validación`,
					text:'Ingrese correctamente los campos para continuar'
				})
			}
			return retornar
		},
		validateStep3() {
			if(this.ppi_validado==false){
				this.$vs.notify({
					color:'danger',
					title:`Error en validación`,
					text:'Ingrese correctamente los campos para continuar'
				})
			}
			return this.ppi_validado
		},
		async importarSectores(){ //async para que se llame cada vez que se necesite
			let me = this;
			const response = await axios.get(
			`/api/sector/get?&completo=select`)
			.then(function (response) {
				var respuesta= response.data;
				me.sectores = respuesta.sectores.data;
			})
			.catch(function (error) {
				console.log(error);
			});
		},
	},
	components: {
		FormWizard,
		TabContent,
		formIngresarNino,
		formIngresarPadrino,
		formIngresarFamilia,
		ppiFamilia,
		estudioFamilia,
		vSelect,
	},
	mounted(){
		this.importarSectores();
		this.cantidad_ninos.push({id:1,visible:true,validado:false})
		this.cantidad_familia.push({id:1,visible:true,validado:false})
	},
}
</script>
        