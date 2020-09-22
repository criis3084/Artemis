<template>
 <div>
		<div class="demo-alignment">
			<h2>Tutores</h2>
			<vx-tooltip text="Agregar nuevo registro"><vs-button radius type="gradient" icon-pack="feather" icon="icon-user-plus" @click="activePrompt2 = true" color="primary" size='large' ></vs-button> </vx-tooltip>
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
        <b>Información del nuevo tutor</b>
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
				<vs-input class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="especialidad" v-model="especialidad"/>
			</div>
		  </div>

          <div class="vx-row mb-2">
			<div class="vx-col w-full">
				<vs-input class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="CUI" v-model="CUI"/>
			</div>
		  </div>
		  <div class="vx-row mb-2">
			<div class="vx-col w-full">
				<vs-input class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="género" v-model="genero"/>
			</div>
		  </div>
          <div class="vx-row mb-2">
			<div class="vx-col w-full">
				<vs-input class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="número de teléfono" v-model="numero_telefono"/>
			</div>
		  </div>
          <div class="vx-row mb-2">
			<div class="vx-col w-full">
				<vs-input class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="correo" v-model="correo"/>
			</div>
		  </div>
          <div class="vx-row mb-2">
			<div class="vx-col w-full">
				<vs-input class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="direccion" v-model="direccion"/>
			</div>
		  </div>
		  <div class="vx-row mb-2">
			<div class="vx-col w-full">
				<vs-input class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="fecha_nacimiento" v-model="fecha_nacimiento"/>
			</div>
		  </div>
          <div class="vx-row mb-2">
			<div class="vx-col w-full">
				<vs-input class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="ruta de imagen" v-model="imagen_perfil"/>
			</div>
		  </div>
          <div class="vx-row mb-2">
			<div class="vx-col w-full">
				<vs-input class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="descripción" v-model="descripcion"/>
			</div>
		  </div>
          <div class="vx-row mb-2">
			<div class="vx-col w-full">
				<vs-input class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="nombre de usuario" v-model="usuario"/>
			</div>
		  </div>
          <div class="vx-row mb-2">
			<div class="vx-col w-full">
				<vs-input class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="contraseña" v-model="password"/>
			</div>
		  </div>
        <template>
		    <h3>Roles</h3>
			<v-select label="nombre" :options="roles" v-model="rol_id" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
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
      especialidad:'',
      genero:'',
      CUI:'',
      numero_telefono:'',
      correo:'',
      imagen_perfil:'',
      usuario:'',
      password:'',
      descripcion:'',
	  fecha_nacimiento:'',
	  direccion:'',
	  roles: [],
	  rol_id:'',
	  selected: '',
	  switch2:true,
	  titulo:'Nuevo Tutor'
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
			`/api/rol/get?page=${page}&buscar=${''}`)
		.then(function (response) {
			var respuesta= response.data;
            me.roles = respuesta.roles.data;
            console.log(me.roles);
			me.pagination= respuesta.pagination;
		})
		.catch(function (error) {
			console.log(error);
		});
	},
	acceptAlert(){
	axios.post("/api/tutor/post/",{
		nombres:this.nombres,
        apellidos:this.apellidos,
        especialidad:this.especialidad,
        CUI:this.CUI,
        numero_telefono:this.numero_telefono,
        correo:this.correo,
        imagen_perfil:this.imagen_perfil,
        usuario:this.usuario,
        password:this.password,
        descripcion:this.descripcion,
		genero:this.genero,
		fecha_nacimiento:this.fecha_nacimiento,
		direccion:this.direccion,
		rol_id:this.rol_id.id
	}).then(function(response) {
			console.log(response)
		})
		.catch(function(error) {
		console.log(error)
        });
        this.$emit('cerrado','Se cerro el formulario');
	},
	close () {
	  this.$vs.notify({
		color:'danger',
		title:'Closed',
        text:'Cerró el formulario!'
      })
      this.$emit('cerrado','Se cerro el formulario');
	},
	clearValMultiple () {
      this.nombres = '';
      this.$emit('cerrado','Se cerro el formulario');
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