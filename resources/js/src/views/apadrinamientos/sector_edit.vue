<template>
 <div>

    <vs-prompt
      @cancel="clearValMultiple"
      @accept="acceptAlert"
      @close="close"
	  accept-text="Aceptar"
	  cancel-text="Cancelar"
      :is-valid="copia"
	  :title= "titulo"
      :active.sync="identificador">
      <div class="con-exemple-prompt">
        <b></b>
			
		<vs-input placeholder="Nombre del sector" v-model="nombreT" class="mt-4 mb-2 col-1 w-full" />

		<vs-alert color="danger" vs-icon="new_releases" class="mt-4" >
			LLene todos los campos
		</vs-alert>
      </div>

		<template>
		<v-select label="nombre" :options="aldeasT" v-model="aldea_idT" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
		</template> 
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
	props:{
		identificador:{
			default:false
		},
	    id:{default: 0},
	    nombre:String,
	    aldea_id:{default: 0},
	},
	components: {
	Dropdown,
	Datepicker,
	vSelect,
  },
  data () {
	return {
	  val:'',
	  valMultipe:{
		value1:'',
		value2:''
	  },
	  idT:0,
	  nombreT:'',
	  aldea_idT:0,
	  aldeasT: [],
	  selected: '',
	  switch2:true,
	  titulo:'Nuevo Sector'
	}
  },
  computed:{
	validName(){
		return true;
	},
	copia() {
		this.nombreT =this.$props.nombre;
		this.idT =this.$props.id;
		this.aldea_idT =this.$props.aldea_id;
		return true;	
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
	axios.put("/api/sector/update/",{
		id:this.idT,
		nombre:this.nombreT,
		aldea_id:this.aldea_idT.id
	}).then(function(response) {
			console.log(response)
		})
		.catch(function(error) {
		console.log(error)
		});
	this.$emit('cerrado','Se cerro el formulario');
	},
	close () {
	this.$emit('cerrado','Se cerro el formulario');
	  this.$vs.notify({
		color:'danger',
		title:'Closed',
		text:'You close a dialog!'
	  })
	},
	clearValMultiple () {
	this.$emit('cerrado','Se cerro el formulario');
	  this.valMultipe.value1 = ''
	  this.valMultipe.value2 = ''
	  this.valMultipe.value3 = ''
	  this.valMultipe.value4 = ''
	  this.valMultipe.value5 = ''
	  this.fechaN = ''
	},
  },
  mounted(){
    this.index2(1, this.search);
  },
}
</script>