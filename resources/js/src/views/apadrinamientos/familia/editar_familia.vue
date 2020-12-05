<template>
  	<vx-card>
		<div class="vx-col md:w-1/2 w-full">
			<div class="vx-col w-full">
				<vs-input v-validate="'required|alpha_num|max:20'" class="w-full" icon-pack="feather" icon="icon-hash" icon-no-border label-placeholder="Código de la Familia" v-model="codigo_familia" disabled/>
				<!-- <div v-if="VALcodigo"><span class="text-danger">{{ VALcodigo }}</span><br></div> -->
				<!-- <div v-if="VALcodigo2"><span class="text-danger">{{ VALcodigo2 }}</span><br></div> -->
				<!-- <div v-if="VALcodigo3"><span class="text-danger">{{ VALcodigo3 }}</span></div> -->
			</div>
		</div>
		<div class="vx-row">
			<div class="vx-col md:w-1/2 w-full mt-3">
				<div class="vx-col w-full">
					<small class="date-label">Sector de Vivienda</small>
					<v-select name="sector" v-validate="'required'" label="nombre" :options="sectores" class="mt-1"  v-model="sector_id" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
					<!-- <div v-if="VALsector"><span class="text-danger">{{ VALsector }}</span><br></div> -->
				
				</div>
			</div>

			<div class="vx-col md:w-1/2 w-full mt-5">
				<div class="vx-col w-full">
					<vs-input name="direccion" v-validate="'required|max:254'" class="w-full" icon-pack="feather" icon="icon-map-pin" icon-no-border label-placeholder="Dirección Familiar" v-model="direccion"/>
					<!-- <div v-if="VALdireccion"><span class="text-danger">{{ VALdireccion }}</span><br></div> -->
				</div>
			</div>
		</div>
		<div class="flex flex-wrap items-center justify-between mt-5">
          <div class="flex items-start">
			<vs-button type="gradient" color="success" icon-pack="feather" icon="icon-save" class="mr-base mb-2" @click="anadirNino">Añadir niño</vs-button>
			<vs-button type="gradient" color="success" icon-pack="feather" icon="icon-save" class="mr-base mb-2" @click="anadirPariente">Añadir Pariente</vs-button>
          </div>
          <div class="flex items-center">
			<vs-button type="gradient" icon-pack="feather" icon="icon-save" class="mr-base mb-2" @click="registrar">Registrar</vs-button>
          </div>
		</div>

		<vx-card
			class="mt-6"
    		title="Niños apadrinados"
    		title-color="success"
			>
			<vs-list>
				<div class="vx-col w-full mb-base">
					<table style="width:100%" class="border-collapse">
						<tr>
							<th class="p-2 border border-solid d-theme-border-grey-light text-center">Fotografia</th>
							<th class="p-2 border border-solid d-theme-border-grey-light text-center">Codigo</th>
							<th class="p-2 border border-solid d-theme-border-grey-light text-center">Nombre completo</th>
							<th class="p-2 border border-solid d-theme-border-grey-light text-center">Fecha de apadrinamiento</th>
							<th class="p-2 border border-solid d-theme-border-grey-light text-center">Editar información</th>
						</tr>
						<tr v-for="(nino,id) in ninosActivos" :key="id">
								<td class="border border-solid d-theme-border-grey-light text-center">	<vs-avatar :src="nino.nino.ruta_imagen" color="primary" class="flex-shrink-0 mr-2" size="30px"/> </td>
								<td class="border border-solid d-theme-border-grey-light text-center"> {{nino.nino.codigo}}</td>
								<td class="border border-solid d-theme-border-grey-light text-center"> {{nino.datos_nino[0].nombres + ' '+nino.datos_nino[0].apellidos}}</td>
								<td class="border border-solid d-theme-border-grey-light text-center"> {{nino.nino.fecha_ingreso}}</td>
								<td class="border border-solid d-theme-border-grey-light text-center"><vs-button color="warning" type="border" icon-pack="feather" class="flex-shrink-0 mr-2" icon="icon-edit-2" @click="$router.push('/editar/nino/'+nino.nino.id)"></vs-button> </td>
						</tr>
					</table>
				</div>
			</vs-list>
		</vx-card>
		<vx-card
			class="mt-6"
    		title="Niños no apadrinados"
    		title-color="danger"
			>
			<vs-list>
				<div class="vx-col w-full mb-base">
					<table style="width:100%" class="border-collapse">
						<tr>
							<th class="p-2 border border-solid d-theme-border-grey-light text-center">Fotografia</th>
							<th class="p-2 border border-solid d-theme-border-grey-light text-center">Codigo</th>
							<th class="p-2 border border-solid d-theme-border-grey-light text-center">Nombre completo</th>
							<th class="p-2 border border-solid d-theme-border-grey-light text-center">Editar información</th>
						</tr>
						<tr v-for="(nino,id) in ninosNoActivos" :key="id">
							<td class="border border-solid d-theme-border-grey-light text-center">	<vs-avatar :src="nino.nino.ruta_imagen" color="primary" class="flex-shrink-0 mr-2" size="30px"/> </td>
							<td class="border border-solid d-theme-border-grey-light text-center"> {{nino.nino.codigo}}</td>
							<td class="border border-solid d-theme-border-grey-light text-center"> {{nino.datos_nino[0].nombres + ' '+nino.datos_nino[0].apellidos}}</td>
							<td class="border border-solid d-theme-border-grey-light text-center"><vs-button color="warning" type="border" icon-pack="feather" class="flex-shrink-0 mr-2" icon="icon-edit-2" @click="$router.push('/editar/ninono/'+nino.nino.id)"></vs-button> </td>
						</tr>
					</table>
				</div>
			</vs-list>
		</vx-card>

		<vx-card
			class="mt-6"
			title="Datos de los familiares"
			title-color="primary"
			>
			<vs-list>
				<div class="vx-col w-full mb-base">
					<table style="width:100%" class="border-collapse">
						<tr>
							<th class="p-2 border border-solid d-theme-border-grey-light text-center">Fotografia</th>
							<th class="p-2 border border-solid d-theme-border-grey-light text-center">Nombre completo</th>
							<th class="p-2 border border-solid d-theme-border-grey-light text-center">Telefono</th>
							<th class="p-2 border border-solid d-theme-border-grey-light text-center">Parentesco</th>
							<th class="p-2 border border-solid d-theme-border-grey-light text-center">Editar información</th>
							<th class="p-2 border border-solid d-theme-border-grey-light text-center">Editar Parentesco</th>
							<th class="p-2 border border-solid d-theme-border-grey-light text-center">Eliminar Pariente</th>
						</tr>
						<tr v-for="(encargado,index2) in listadoFamilia" :key="index2">
							<td class="border border-solid d-theme-border-grey-light text-center"><vs-avatar :src="encargado.ruta_imagen" :alt="encargado.ruta_imagen" color="primary" class="flex-shrink-0 mr-2" size="30px"/> </td>
							<td class="border border-solid d-theme-border-grey-light text-center"> {{encargado.datos_encargado[0].nombres}} {{encargado.datos_encargado[0].apellidos}} </td>
							<td class="border border-solid d-theme-border-grey-light text-center"> {{encargado.datos_encargado[0].numero_telefono}}</td>
							<td class="border border-solid d-theme-border-grey-light text-center"> {{encargado.relacion}}</td>
							<td class="border border-solid d-theme-border-grey-light text-center"><vs-button color="warning" type="border" icon-pack="feather" class="flex-shrink-0 mr-2" icon="icon-edit-2" @click="$router.push('/editar/familiar/'+encargado.encargado_id)"></vs-button> </td>
							<td class="border border-solid d-theme-border-grey-light text-center"><vs-button color="primary" type="border" icon-pack="feather" class="flex-shrink-0 mr-2" icon="icon-edit-2" @click="editarParentesco(encargado)"></vs-button> </td>
							<td class="border border-solid d-theme-border-grey-light text-center"><vs-button color="danger" type="border" icon-pack="feather" class="flex-shrink-0 mr-2" icon="icon-x-circle" @click="eliminarParicente(encargado)"></vs-button> </td>
						</tr>
					</table>
				</div>
			</vs-list>
		</vx-card>

		<vs-prompt
			class="calendar-event-dialog"
			title="Editar parentesco"
			accept-text= "Editar"
			cancel-text = "Cerrar"
			button-cancel = "border"
			@cancel="removeEvent"
			@accept="confirmarEditar"
			:active.sync="activePromptEditEvent">
			<div v-if="activePromptEditEvent">
				<h3 class="text-primary"> Familiar: {{encargadoT.datos_encargado[0].nombres + ' ' + encargadoT.datos_encargado[0].apellidos}} </h3>
				<br>
				<h5 class="text-success"> Parentesco actual: {{encargadoT.relacion}} </h5>
				<br>
				<h4 class="date-label">Nuevo Parentesco:</h4>
				<vs-input name="descripcion" v-validate="'required'" class="w-full" v-model="nuevo_parentesco"></vs-input>
				<span class="text-danger">{{ errors.first('descripcion') }}</span><br>
			</div>
		</vs-prompt>

		<vs-prompt
			color="danger"
			title="Confirmación"
			accept-text="Aceptar"
			cancel-text="Cancelar"
			@cancel="removeEvent"
			@accept="confirmarEliminar"
			@close="removeEvent"
			:active.sync="activePrompt">
			<div class="con-exemple-prompt" v-if="activePrompt">
				<span>¿Está seguro que desea eliminar a {{encargadoT.datos_encargado[0].nombres + ' ' + encargadoT.datos_encargado[0].apellidos}} de la familia? </span>
			</div>
		</vs-prompt>
		
	</vx-card>
</template>
<script>
import axios from 'axios'
import vSelect from 'vue-select'

export default {
	data() {
		return {
			id_recibido:null,
			listadoNinos:[],
			listadoFamilia:[],
			arrayData:[],
			codigo:0,
			ninoP:[],
			sectores:[],
			sector_id:null,
			VALsector:'',
			VALdireccion:'',
			VALcodigo:'',
			direccion:'',
			codigo_familia:'',
			ninosActivos:[],
			ninosNoActivos:[],
			activePromptEditEvent: false,
			nuevo_parentesco:'',
			encargadoT:{},
			listadosId:[],
			activePrompt:false,
		}
	},
	methods: {
		anadirNino(){

		},
		anadirPariente(){

		},
		eliminarParicente(encargado){
			this.encargadoT = encargado
			this.activePrompt = true
		},
		confirmarEliminar(){
			let me = this;
			axios.put("/api/relacion/eliminar/",{
				id:me.encargadoT.encargado_id
			}).then(function(response) {
				console.log(response)
			})
			.catch(function (error) {
				console.log(error);
			});
		},
		registrar(){
			let me = this;
			axios.put("/api/relacion/update/",{
				codigo:me.codigo_familia,
				sector_id:me.sector_id.id,
				direccion:me.direccion,
				personas:me.listadosId,
				tipo:'datos'
			}).then(function(response) {
				console.log(response)
			})
			.catch(function (error) {
				console.log(error);
			});
		},
		editarParentesco(encargado){
			this.encargadoT = encargado
			this.activePromptEditEvent = true
		},
		confirmarEditar(){
			let me = this;
			axios.put("/api/relacion/update/",{
				encargado_id:me.encargadoT.encargado_id,
				relacion:me.nuevo_parentesco,
				tipo:'relacion'
			}).then(function(response) {
				console.log(response)
			})
			.catch(function (error) {
				console.log(error);
			});
		},
		removeEvent () {
			this.$vs.notify({
				color: 'danger',
				title: 'Cerrado',
				text: 'Operación cancelada'
			})
			this.nuevo_parentesco=''
		},
		importaDatos(){
			let datos = this.$route.params.id;
			let me = this;
 			axios.get(`/api/relacion/get?criterio=codigo&buscar=${datos}&completo=informacion`)
			.then(function (response) {
				var respuesta= response.data;
				me.arrayData = respuesta.relaciones.data;
				me.codigo = respuesta.relaciones.data[0].codigo;
				me.setearValor(me.arrayData)
			})
			.catch(function (error) {
				console.log(error);
			});
		},
		setearValor(unArreglo){
			this.listadoFamilia=unArreglo.slice();
			this.listadoNinos=unArreglo.slice();
			let hash = {};
			this.listadoNinos = this.listadoNinos.filter(o => hash[o.nino_id] ? false : hash[o.nino_id] = true);
			let hash2 = {};
			this.listadoFamilia = this.listadoFamilia.filter(o => hash2[o.encargado_id] ? false : hash2[o.encargado_id] = true);
			this.ninoP=this.listadoNinos[0].nino_id
			for (let i in this.listadoNinos){
				let elemento = this.listadoNinos[i]
				this.listadosId.push(elemento.nino.persona_sin_acceso_id)
				if (elemento.nino.estado == 1)
				{
					this.ninosActivos.push(elemento)
				}
				else{
					this.ninosNoActivos.push(elemento)
				}
			}
			for (let i in this.listadoFamilia){
				let elemento = this.listadoFamilia[i]
				this.listadosId.push(elemento.encargado.persona_sin_acceso_id)
			}
			this.codigo_familia=this.listadoFamilia[0].codigo
			this.direccion=this.listadoFamilia[0].direccion
			this.importarSectores(this.listadoFamilia[0].sector_id)
		},
		importarSectores(sectorId){ 
			let me = this;
			axios.get(
			`/api/sector/get?&completo=select`)
			.then(function (response) {
				var respuesta= response.data;
				me.sectores = respuesta.sectores.data;
				let elementoE={}
				let encontrado=false
				me.sectores.forEach(function(elemento, indice, array) {
					if (elemento.id==sectorId)
					{
						elementoE=elemento
						encontrado=true
					}
				})
				me.sector_id = encontrado == true ? elementoE:{id:sectorId,nombre:'Sector desactivado'} 
			})
			.catch(function (error) {
				console.log(error);
			});
		},
	},
	mounted() {
		this.importaDatos();
	},
	components:{
		vSelect,
	}
}
</script>