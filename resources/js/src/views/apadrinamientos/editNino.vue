<template>
 <div>
		<div class="demo-alignment">
			<vx-tooltip text="Editar"> <vs-button  @click="activePrompt2 = true" color="dark" type="flat" icon="edit" size="large"> </vs-button>  </vx-tooltip>
		</div>
	<br>

    <vs-prompt
      @cancel="clearValMultiple"
      @accept="acceptAlert"
      @close="close"
      :is-valid="validName"
	  :title= "titulo"
      :active.sync="activePrompt2">
      <div class="con-exemple-prompt">
        <b>Información del nuevo niño</b>
		<br>

		  <div class="vx-row mb-2">
			<div class="vx-col w-full">
				<vs-input class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="Nombres" v-model="nombres"/>
			</div>
		  </div>
		  <div class="vx-row mb-2">
			<div class="vx-col w-full">
				<vs-input class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="apellidos" v-model="apellidos"/>
			</div>
		  </div>
		  <div class="vx-row mb-2">
			<div class="vx-col w-full">
				<vs-input class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="genero" v-model="genero"/>
			</div>
		  </div>
		  <div class="vx-row mb-2">
			<div class="vx-col w-full">
				<vs-input class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="fecha_nacimiento" v-model="fecha_nacimiento"/>
			</div>
		  </div>
		  <div class="vx-row mb-2">
			<div class="vx-col w-full">
				<vs-input class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="direccion" v-model="direccion"/>
			</div>
		  </div>
		  <div class="vx-row mb-2">
			<div class="vx-col w-full">
				<vs-input class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="codigo" v-model="codigo"/>
			</div>
		  </div>
		  <div class="vx-row mb-2">
			<div class="vx-col w-full">
				<vs-input class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="fecha_ingreso" v-model="fecha_ingreso"/>
			</div>
		  </div>
		  <div class="vx-row mb-2">
			<div class="vx-col w-full">
				<vs-input class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="imagen" v-model="ruta_imagen"/>
			</div>
		  </div>

		<template>
			<h1>Sectores</h1>
			<v-select label="nombre" :options="sectores" v-model="sector_id" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
		</template> 

		<template>
			<h1>Escuelas</h1>
			<v-select label="nombre" :options="escuelas" v-model="escuela_id" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
		</template> 

<!--
		<vs-alert :active="!validName" color="danger" vs-icon="new_releases" class="mt-4" >
			LLene todos los campos
		</vs-alert>
-->
      </div>
	</vs-prompt>


	  </div>
</template>

<script>
import Datepicker from 'vuejs-datepicker'
import axios from 'axios'
//C:\laragon\www\PFV1\resources\js\src\views\components\vuesax\dropdown\Dropdown.vue
import Dropdown from '@/views/components/vuesax/dropdown/Dropdown.vue'
import vSelect from 'vue-select'

export default {
	props:['identificador'],
  components: {
	Dropdown,
	Datepicker,
	vSelect,
  },
  data () {
	return {
	  activePrompt2:false,
	  val:'',
	  nombres:'',
	  apellidos:'',
	  genero:'',
	  codigo:'',
	  fecha_ingreso:'',
	  fecha_nacimiento:'',
	  direccion:'',
	  ruta_imagen:'',
	  sectores: [],
	  escuelas: [],
	  sector_id:'',
	  escuela_id:'',
	  selected: '',
	  switch2:true,
	  titulo:'Editar Niño'
	}
  },
  computed:{
	validName () {

	}
  },
  methods:{
	async index2(page, search){ //async para que se llame cada vez que se necesite
		let me = this;
		const response = await axios.get(
			`/api/sector/get?page=${page}&buscar=${''}&todos='true'`)
		.then(function (response) {
			var respuesta= response.data;
			me.sectores = respuesta.sectores.data;
			me.pagination= respuesta.pagination;
		})
		.catch(function (error) {
			console.log(error);
		});
		console.log(this.identificador);
		
	},async index3(page, search){ //async para que se llame cada vez que se necesite
		let me = this;
		const response = await axios.get(
			`/api/escuela/get?page=${page}&buscar=${''}&todos='true'`)
		.then(function (response) {
			var respuesta= response.data;
			me.escuelas = respuesta.escuelas.data;
			me.pagination= respuesta.pagination;
		})
		.catch(function (error) {
			console.log(error);
		});
	},
	acceptAlert(){
	axios.put(`/api/nino/update/${this.nino.id}/`, this.valMultipe,{
	//axios.put("/api/nino/update/",{
		//id:this.id,
		nombres:this.nombres,
		apellidos:this.apellidos,
		genero:this.genero,
		fecha_nacimiento:this.fecha_nacimiento,
		direccion:this.direccion,
		codigo:this.codigo,
		fecha_ingreso:this.fecha_ingreso,
		ruta_imagen:this.ruta_imagen,
		escuela_id:this.escuela_id.id,
		sector_id:this.sector_id.id
	}).then(function(response) {
			console.log(response)
		})
		.catch(function(error) {
		console.log(error)
		});
	},
	close () {
	  this.$vs.notify({
		color:'danger',
		title:'Closed',
		text:'You close a dialog!'
	  })
	},
	clearValMultiple () {
	  this.nombres = ''
	},
  },
	mounted(){
    this.index2(1, this.search);
    this.index3(1, this.search);
  }

}
</script>