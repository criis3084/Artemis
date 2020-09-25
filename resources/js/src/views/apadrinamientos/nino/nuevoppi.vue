<template>
	<div>
		<vx-card>
			<div>

			<template>
				<div class="vx-row mb-2">
					<vs-list>
						<h4> 
						<vs-list-header title="1. ¿Cuántos miembros del hogar tienen 13 años de edad o menos?"></vs-list-header>
						</h4>
						<ul class="centerx mt-3">
							<!--
								<input type="radio" value="33" v-model="respuesta11">
								<input type="radio" value="23" v-model="respuesta11">
								<input type="radio" value="17" v-model="respuesta11">
								<input type="radio" value="12" v-model="respuesta11">
								<input type="radio" value="0" v-model="respuesta11">
								-->
								
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
			<div class="vx-row mb-2 md:w-1/2">
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
			<div class="vx-row mb-2 md:w-1/2">
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
			<vs-alert color="dark" active="true">Total : {{calcularTotal}}	</vs-alert>

			<vs-divider></vs-divider>

			</div>
		</vx-card>
	</div>
</template>

<script>
export default {
  data() {
    return {
		respuesta1:100,
		respuesta2:200,
		respuesta3:300,
		respuesta4:400,
		respuesta5:500,
		respuesta6:600,
		respuesta7:700,
		respuesta8:800,
		respuesta9:900,
		respuesta10:1000,
		resultado:0,
	}
  },
  methods:{
	  mostrar(){
		  console.log(parseInt(this.respuesta1)-100+ parseInt(this.respuesta2)-200 +parseInt(this.respuesta3)-300+parseInt(this.respuesta4)-400+parseInt(this.respuesta5)-500+parseInt(this.respuesta6)-600+parseInt(this.respuesta7)-700+parseInt(this.respuesta8)-800+parseInt(this.respuesta9)-900+parseInt(this.respuesta10)-1000);
		  this.resultado=parseInt(this.respuesta1)-100+ parseInt(this.respuesta2)-200 +parseInt(this.respuesta3)-300+parseInt(this.respuesta4)-400+parseInt(this.respuesta5)-500+parseInt(this.respuesta6)-600+parseInt(this.respuesta7)-700+parseInt(this.respuesta8)-800+parseInt(this.respuesta9)-900+parseInt(this.respuesta10)-1000
	  }
  },computed: {
    calcularTotal: function () {
      this.resultado=parseInt(this.respuesta1)-100+ parseInt(this.respuesta2)-200 +parseInt(this.respuesta3)-300+parseInt(this.respuesta4)-400+parseInt(this.respuesta5)-500+parseInt(this.respuesta6)-600+parseInt(this.respuesta7)-700+parseInt(this.respuesta8)-800+parseInt(this.respuesta9)-900+parseInt(this.respuesta10)-1000		
      return parseInt(this.respuesta1)-100+ parseInt(this.respuesta2)-200 +parseInt(this.respuesta3)-300+parseInt(this.respuesta4)-400+parseInt(this.respuesta5)-500+parseInt(this.respuesta6)-600+parseInt(this.respuesta7)-700+parseInt(this.respuesta8)-800+parseInt(this.respuesta9)-900+parseInt(this.respuesta10)-1000; 
    }
  }
}
</script>