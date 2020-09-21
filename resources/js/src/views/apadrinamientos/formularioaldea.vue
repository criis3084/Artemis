<template>
 <div>
		<div class="demo-alignment">
			<h2>Aldeas</h2>
			<vx-tooltip text="Agregar nuevo registro"><vs-button radius type="gradient" icon-pack="feather" icon="icon-plus" @click="activePrompt2 = true" color="primary" size='large' ></vs-button> </vx-tooltip>
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
        <b></b>
			
		<vs-input placeholder="Nombre de la aldea" v-model="valMultipe.value1" class="mt-4 mb-2 col-1 w-full" />

		<vs-alert :active="!validName" color="danger" vs-icon="new_releases" class="mt-4" >
			LLene todos los campos
		</vs-alert>
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
  components: {
	Dropdown,
	Datepicker,
	vSelect,
  },
  data () {
	return {
	  activePrompt2:false,
	  val:'',
	  valMultipe:{
		value1:'',
		value2:''
	  },
	 aldeasT: [],
	 selected: '',
	 switch2:true,
	 titulo:'Nueva Aldea'
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
			`/api/aldea/get?page=${page}&buscar=${this.valMultipe.value2}&todos='true'`)
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
	console.log(this.valMultipe.value2.id);
	axios.post("/api/aldea/post/",{
		nombre:this.valMultipe.value1,
		aldea_id:this.valMultipe.value2.id
	}).then(function(response) {
			console.log(response)
		})
		.catch(function(error) {
		console.log(error)
		});
	this.$emit('cerrado','Se cerro el formulario');
	},
	close () {
		console.log('modal cerrado')
	  this.$vs.notify({
		color:'danger',
		title:'Closed',
		text:'You close a dialog!'
	  })
	  this.$emit('cerrado','Se cerro el formulario');
	},
	clearValMultiple () {
	  this.valMultipe.value1 = ''
      this.$emit('cerrado','Se cerro el formulario');
	},
	saveProduct(){
	axios.post("/api/aldea/post/",{
		nombre:this.valMultipe.value1,
		aldea_id:this.valMultipe.value2
	}).then(function(response) {
			console.log(response)
		})
		.catch(function(error) {
		console.log(error)
		});
	},
	mostrar(id){
		console.log($id);
	}

  },
  mounted(){
    this.index2(1, this.search);
  }

}
</script>