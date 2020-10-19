<template>
	<div>
		<vx-card>
			<div v-for="(beneficio,id) in listado_beneficios" :key="id">
					<!-- <vs-checkbox color="dark" icon-pack="feather" class="mt-2" :icon="datosEstudio.luz ==0 ? 'icon-x' : 'icon-check'" v-model="check" disabled="true"> <b> Luz </b></vs-checkbox> -->
					<vs-checkbox class="mt-2" color="dark" icon-pack="feather" icon="icon-check" v-model="estados[id]"> Entrega del mes de <b>{{ nombreMes(beneficio.fecha_entrega.split('-',3)[1]) }} </b> </vs-checkbox>
			</div>
		</vx-card>
	</div>
</template>
<script>
import axios from 'axios'
export default {
	data() {
		return {
			id_recibido:0,
			beneficios:{
				completos:[]
			},
			listado_beneficios:[],
			estados:[],
			copia:[],
			fecha_beneficio:0,
			id:0,
			estado:false
		}
	},
	watch:{
		estados () {
			let estadosT=this.estados.slice()
			let seCambio=false
			let indiceCambiado=0
			this.copia.forEach(function(elemento, indice, array){
				if (elemento != estadosT[indice]){
					seCambio=true
					indiceCambiado=indice
				}
			})
			if (seCambio==true){
				this.abrirDialog(indiceCambiado,!this.estados[indiceCambiado])
			}

    	},    
	},
	methods: {
		async importarBeneficios() {
			let me = this;
	        me.id_recibido = this.$route.params.id;
			const response = await axios
			.get(`/api/beneficio/get?&criterio=paciente_id&buscar=${me.id_recibido}&completo=true`)
			.then(function(response) {
				var respuesta = response.data;
				me.listado_beneficios = respuesta.beneficios.data;
				me.listado_beneficios.forEach(function(elemento, indice, array){
					me.estados.push(elemento.estado==1?true:false)
				})
				me.copia=me.estados.slice()
				me.dia_apoyo=me.listado_beneficios[0].fecha_entrega.split('-',3)[2]
			})
			.catch(function(error) {
				console.log(error);
			});
		},
		getNow(){
			let fecha_pago=''
			let ultima_fecha = this.listado_beneficios[0].fecha_entrega
			const todaySin = new Date(parseInt(ultima_fecha.split('-',3)[0]),parseInt(ultima_fecha.split('-',3)[1]),parseInt(ultima_fecha.split('-',3)[2]))
			todaySin.setMonth(todaySin.getMonth())
			return this.getDate(todaySin)
		},
		abrirDialog(id, estado){
			console.log('id')
			console.log(id)
			console.log('estado')
			console.log(estado)

			let titulo = '';
			let color = '';
			if(estado === 0 || estado === false){
				color = 'success'
				titulo = 'Confirmar activación'
			}
			else if(estado === 1 || estado === true){
				color = 'danger'
				titulo = 'Confirmar desactivación'
			}
			this.id = id
			this.estado = estado

			this.$vs.dialog({
				type:'confirm',
				color: `${color}`,
				title: `${titulo}`,
				text: '¿Está seguro de llevar a cabo esta acción?',
				accept: this.cambiarEstado,
				cancel: this.close
			})

		},
		cambiarEstado(color){
			let titulo = ''
			console.log('entra?')
			let me =this
			if(me.estado === 0 || me.estado === false){
				titulo = 'Activado exitósamente'
				axios.put('/api/beneficio/activar', {
					id: me.listado_beneficios[me.id].id
				})
				.then(function (response) {

					console.log(response)
					me.$vs.notify({
						color:'success',
						title:'Exitoso',
						text:'El beneficio se registro exitósamente'
					})
				})
				.catch(function (error) {
					console.log(error)
				});
			}
			else if(me.estado === 1 || me.estado === true){
				titulo = 'Desactivado exitósamente'
				axios.put('/api/beneficio/desactivar', {
					id: me.listado_beneficios[me.id].id
				})
				.then(function (response) {
					me.copia=me.estados.slice()
					me.$vs.notify({
						color:'success',
						title:'Exitoso',
						text:'El beneficio se desactivo exitósamente'
					})
				})
				.catch(function (error) {
					console.log(error)
				});
			}
			this.copia=this.estados.slice()			
			let algunoFalso=true
			this.estados.forEach(function(elemento, indice, array){
				if (elemento ==false)
				{
					algunoFalso=false
				}
			})
			if (algunoFalso==true){
				this.nuevoBeneficio()
			}
		},
		close(){
			this.estados = this.copia.slice()
			let titulo = "Cancelado"
			let texto = "Cambio de estado cancelado"
			this.$vs.notify({
				color:'danger',
				title:`${titulo}`,
				text:`${titulo}`
			})
		},
		nuevoBeneficio(){
			let fechaT = this.getNow()
			let me2=this
			axios.post('/api/beneficio/post/', {
				fecha_entrega:fechaT,
				descripcion:'Beneficio del nuevo mes',
				paciente_id:me2.id_recibido
			}).then(function (response){
				console.log(response)
				me2.importarBeneficios()
			})
		},
		getDate (datetime) {
			const date = new Date(datetime)
			const dateString = `${date.getFullYear()}/${date.getMonth() + 1}/${date.getDate()}`
			return dateString
		},
		nombreMes(numero){
			numero = parseInt(numero)
			let nombre=''
			switch (numero) {
				case 1:
					nombre='enero' 
					break;
				case 2:
					nombre='febrero'
					break;
				case 3:
					nombre='marzo'
					break;
				case 4:
					nombre='abril' 
					break;
				case 5:
					nombre='mayo' 
					break;
				case 6:
					nombre='junio' 
					break;
				case 7:
					nombre='julio' 
					break;
				case 8:
					nombre='agosto' 
					break;
				case 9:
					nombre='septiembre' 
					break;
				case 10:
					nombre='octubre'
					break;
				case 11:
					nombre='noviembre'
					break;
				case 12:
					nombre='diciembre'
					break;
			
				default:
					nombre ='Nulo'
					break;
			}
			return nombre
		},
	},
	mounted() {
		this.importarBeneficios();
	},
}
</script>