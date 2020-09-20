<template>
 <div>
	<div class="demo-alignment">
	  <vs-button @click="activePrompt2 = true" color="primary" type="border">Agregar</vs-button>
	</div>

    <vs-prompt
      @cancel="clearValMultiple"
      @accept="acceptAlert"
      @close="close"
      :is-valid="validName"
      :active.sync="activePrompt2">
      <div class="con-exemple-prompt">
        Ingrese la informacion  <b>a continuación</b>.
			
		<vs-input placeholder="Nombre" v-model="valMultipe.value1" class="mt-4 mb-2 col-1 w-full" />
		<vs-input placeholder="Apellido" v-model="valMultipe.value2" class="mt-4 mb-2 col-2 w-full" />

		<vs-alert :active="!validName" color="danger" vs-icon="new_releases" class="mt-4" >
			Fields can not be empty please enter the data
		</vs-alert>
      </div>

		<div class="demo-alignment">
			<vs-dropdown @click="mostrar()" >
			
				<a class="flex items-center" href="#">
					Aldeas
					<i class="material-icons"> expand_more </i>
				</a>
				<vs-dropdown-menu v-for="aldea in aldeasT" :key="aldea.id">
					<div v-for="aldea in aldeasT" :key="aldea.id">
						<vs-dropdown-item > {{aldea.nombre}}</vs-dropdown-item>
					</div>
				</vs-dropdown-menu>

			</vs-dropdown>

		</div>


	  <vs-alert :active="!validName" color="danger" vs-icon="new_releases" class="mt-4" >
		Fields can not be empty please enter the data
	  </vs-alert>


	</vs-prompt>
	  </div>
</template>

<script>
import Datepicker from 'vuejs-datepicker'
import axios from 'axios'
//C:\laragon\www\PFV1\resources\js\src\views\components\vuesax\dropdown\Dropdown.vue
import Dropdown from '@/views/components/vuesax/dropdown/Dropdown.vue'

export default {
  components: {
	Dropdown,
	Datepicker
  },
  data () {
	return {
	  activePrompt2:false,
	  val:'',
	  valMultipe:{
		value1:'asdf',
		value2:'da'
	  },
	 aldeasT: [],
	}
  },
  computed:{
	validName () {
	  return this.valMultipe.value1.length >0
	}
  },
  methods:{
	async index2(page, search){ //async para que se llame cada vez que se necesite
		let me = this;
		const response = await axios.get(
			`/api/aldea/get?page=${page}&buscar=${this.valMultipe.value2}`)
		.then(function (response) {
			var respuesta= response.data;
			me.aldeasT = respuesta.aldeas.data;
			me.pagination= respuesta.pagination;
		})
		.catch(function (error) {
			console.log(error);
		});
	},
	acceptAlert () {
	axios.post("/api/sector/post/",{
		nombre:this.valMultipe.value1,
		aldea_id:this.valMultipe.value2
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
	  this.valMultipe.value1 = ''
	  this.valMultipe.value2 = ''
	  this.valMultipe.value3 = ''
	  this.valMultipe.value4 = ''
	  this.valMultipe.value5 = ''
	  this.fechaN = ''
	},
	saveProduct(){
	axios.post("/api/sector/post/",{
		nombre:this.valMultipe.value1,
		aldea_id:this.valMultipe.value2
	}).then(function(response) {
			console.log(response)
		})
		.catch(function(error) {
		console.log(error)
		});
	},
	mostrar(){
		console.log(this.aldeasT);
	}

  },
  mounted(){
    this.index2(1, this.search);
  }

}
</script>