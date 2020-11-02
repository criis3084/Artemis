<template>
		<div class="vx-row">
				<div class="vx-col w-full sm:w-1/2 lg:w-1/4 mb-base">
					<vx-card>
						<div class="text-center">
							<h4>Mi Nombre Completo</h4>
							<p>Codigo: ASDFSDD</p>
						</div>
						<vs-avatar class="mx-auto my-6 block" size="80px" src="https://images.unsplash.com/photo-1511367461989-f85a21fda167?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1489&q=80"/>
						<div class="flex justify-between text-center">
							<span>
								<p class="text-xl font-semibold">Masculino</p>
								<small class="text-grey">Genero</small>
							</span>
							<span>
								<p class="text-xl font-semibold">Normal</p>
								<small class="text-grey">Tipo de Paciente</small>
							</span>
						</div>
					</vx-card>
					<br>
					<vx-card
						title="Información Personal"
						title-color="primary"
						collapse-action
					>
						<div class="flex items-center mt-0">
							<vs-button type="flat" radius color="warning" icon-pack="feather" icon="icon-credit-card" size="large" class="mt-0" disabled ></vs-button><h5 class="text-warning">DPI:</h5>
							<div class="vx-col w-full text-right text-warning mt-0"><h6>3127309181408</h6></div>
						</div>
						<vs-divider class="mt-0"/>
						<div class="flex items-center mt-0">
							<vs-button type="flat" radius color="warning" icon-pack="feather" icon="icon-phone-call" size="large" class="mt-0" disabled ></vs-button><h5 class="text-warning">Telefono:</h5>
							<div class="vx-col w-full text-right text-warning mt-0"><h6>40434818</h6></div>
						</div>
						<vs-divider class="mt-0"/>
						<div class="flex items-center mt-0">
							<vs-button type="flat" radius color="warning" icon-pack="feather" icon="icon-map-pin" size="large" class="mt-0" disabled ></vs-button><h5 class="text-warning">Dirección:</h5>
						</div>
								<h6>sdhflkajsdfhlaksjdfhalskdjfhaslkdjfh</h6>
					</vx-card>
					<br>
						<vx-card
						title="Información Medica"
						title-color="primary"
						collapse-action
						>
							<div class="flex items-center mt-0">
								<vs-button color="success" icon="filter_center_focus" radius type="flat" size="large" class="mt-0" disabled></vs-button><h5 class="text-success">Peso:</h5>
								<div class="vx-col w-full text-right text-success mt-0"><h6>47 <small> Lbs.</small></h6></div>
							</div>
							<vs-divider class="mt-0"/>
							<div class="flex items-center mt-0">
								<vs-button color="success" icon="vertical_align_top" radius type="flat" size="large" class="mt-0" disabled></vs-button><h5 class="text-success">Talla:</h5>
								<div class="vx-col w-full text-right text-success mt-0"><h6>1.65 <small> Mts.</small></h6></div>
							</div>
							<vs-divider class="mt-0"/>
							<div class="flex items-center mt-0">
								<vs-button color="success" icon="favorite" radius type="flat" size="large" class="mt-0" disabled></vs-button><h5 class="text-success">Pulso:</h5>
								<div class="vx-col w-full text-right text-success mt-0"><h6>47 <small> Lbs.</small></h6></div>
							</div>
							<vs-divider class="mt-0"/>
							<div class="flex items-center mt-0">
								<vs-button type="flat" radius color="success" icon-pack="feather" icon="icon-thermometer" size="large" class="mt-0" disabled ></vs-button><h5 class="text-success">Temperatura:</h5>
								<div class="vx-col w-full text-right text-success mt-0"><h6>47 <small> °C</small></h6></div>
							</div>
							<vs-divider class="mt-0"/>
							<div class="flex items-center mt-0">
								<vs-button color="success" icon="directions_run" radius type="flat" size="large" class="mt-0" disabled></vs-button><h5 class="text-success">Respiración:</h5>
								<div class="vx-col w-full text-right text-success mt-0"><h6>47 <small> r/m</small></h6></div>
							</div>
							<vs-divider class="mt-0"/>
							<div class="flex items-center mt-0">
								<vs-button color="success" icon="timer" radius type="flat" size="large" class="mt-0" disabled></vs-button><h5 class="text-success">Presión Arterial:</h5>
								<div class="vx-col w-full text-right text-success mt-0"><h6>47 <small> NC</small></h6></div>
							</div>
							<vs-divider class="mt-0"/>
						</vx-card>
					<br>
				</div>
				<div class="vx-col w-full sm:w-1/2 lg:w-2/4 mb-base">
					<vx-card>
						<vs-tabs alignment="center">
							<vs-tab label="Historial clinico">
								<div>

									  <ul class="vx-timeline">
											<li v-for="item in timelineData" :key="item.title">
												<!-- <div class="timeline-icon" :class="`bg-${item.color}`"> -->
												<div class="timeline-icon bg-primary">
													<feather-icon icon="FileTextIcon" svgClasses="text-white stroke-current w-5 h-5" />
												</div>
												<div class="timeline-info">
													<p class="font-semibold"> <b>Descripcion: </b> {{ item.title }}</p>
													<span class="activity-desc"><b>Objetivo: </b>{{ item.desc }}</span>
													<br>
													<span class="activity-desc"><b>Subjetivo: </b>{{ item.desc }}</span>
												</div>
												<small class="text-grey activity-e-time">Fecha: {{ item.time }}</small>
												<div class="flex items-center mt-0">
													<router-link :to="url" @click.stop.prevent class="vx-col w-full text-inherit text-left hover:text-primary">Ver Detalle</router-link>
													<router-link :to="url" @click.stop.prevent class="vx-col w-full text-inherit text-right hover:text-primary">Ver Receta</router-link>
													<!-- <div class="vx-col w-full text-left text-success mt-0"><h6>Ver Detalle</h6></div>
													<div class="vx-col w-full text-right text-success mt-0"><h6>Ver Receta</h6></div> -->
												</div>
												<vs-divider class="mt-5"/>
											</li>
										</ul>
								</div>
							</vs-tab>
							<vs-tab label="Historial de examenes">
								<div></div>
							</vs-tab>
						</vs-tabs>
					</vx-card>
				</div>
				<div class="vx-col w-full sm:w-1/2 lg:w-1/4 mb-base">
					<vx-card
						title="Citas Programadas"
						title-color="primary"
					>


					<table style="width:100%" class="border-collapse">
										<!-- <tr v-for="(encargado,index2) in listadoFamilia" :key="index2"> -->
										<tr>
											<td class="pointer-events-none text-center">
												<vx-card
													card-background="cornflowerblue"
													class="mt-1"
												>
														<p class="calender-day text-white">
															<b>
															Martes
															</b>
														</p>
														<p class="calender-date text-white">
															<b>
															15
															</b>
														</p>
														<p class="calender-month-year text-white">
															<b>
															Diciembre
															</b>
														</p>
												</vx-card>
											</td>
											<td class="pointer-events-none text-left">
												<vx-card class="mt-1">
												<b> Descripcion: </b> Se tienen que  si sigue vivo
												<p>
												<small> 
													<b> Medico: </b> Lo tienen que resivar juan
												</small>
												</p>
												</vx-card>
											</td>
										</tr>

					</table>

						<div class="vx-col sm:w-1/8 lg:w-1/8 mb-base">
							<br>

								<br>
						</div>

					</vx-card>
				</div>
		</div>
</template>
<script>
import axios from 'axios'
import VxTimeline          from '@/components/timeline/VxTimeline.vue'
export default {
	data() {
		return {
			active:true,
			timelineData: [
				{
					color : 'primary',
					icon  : 'FileTextIcon',
					title : 'New Task Added',
					desc  : 'Bonbon macaroon jelly beans gummi bears jelly lollipop apple',
					time  : '25 Days Ago'
				},
				{
					color : 'primary',
					icon  : 'FileTextIcon',
					title : 'Task Update Found',
					desc  : 'Cupcake gummi bears soufflé caramels candy',
					time  : '15 Days Ago'
				},
				{
					color : 'primary',
					icon  : 'FileTextIcon',
					title : 'Task Finished',
					desc  : 'Candy ice cream cake. Halvah gummi bears',
					time  : '20 mins ago'
				},
				{
					color : 'primary',
					icon  : 'FileTextIcon',
					title : 'Task Finished',
					desc  : 'Candy ice cream cake. Halvah gummi bears',
					time  : '20 mins ago'
				},
				{
					color : 'primary',
					icon  : 'FileTextIcon',
					title : 'Task Finished',
					desc  : 'Candy ice cream cake. Halvah gummi bears',
					time  : '20 mins ago'
				},
				{
					color : 'primary',
					icon  : 'FileTextIcon',
					title : 'Task Finished',
					desc  : 'Candy ice cream cake. Halvah gummi bears',
					time  : '20 mins ago'
				},
				{
					color : 'primary',
					icon  : 'FileTextIcon',
					title : 'Task Finished',
					desc  : 'Candy ice cream cake. Halvah gummi bears',
					time  : '20 mins ago'
				},
				{
					color : 'primary',
					icon  : 'FileTextIcon',
					title : 'Task Finished',
					desc  : 'Candy ice cream cake. Halvah gummi bears',
					time  : '20 mins ago'
				},
				{
					color : 'primary',
					icon  : 'FileTextIcon',
					title : 'Task Finished',
					desc  : 'Candy ice cream cake. Halvah gummi bears',
					time  : '20 mins ago'
				},
				{
					color : 'primary',
					icon  : 'FileTextIcon',
					title : 'Task Finished',
					desc  : 'Candy ice cream cake. Halvah gummi bears',
					time  : '20 mins ago'
				},
				{
					color : 'primary',
					icon  : 'FileTextIcon',
					title : 'Task Finished',
					desc  : 'Candy ice cream cake. Halvah gummi bears',
					time  : '20 mins ago'
				},
			],
			url:'/clinica/consultorio'
		}
	},
	components:{
		VxTimeline
	},
	methods: {
	},
	mounted() {
		//this.calender()
	},
}
</script>


<style lang="scss">
@import "@sass/vuexy/components/vxTimeline.scss";
</style>
<style>
	.calender{
		position: absolute;
		top: 50%;
		left: 50%;
		transform: translate(-50%,-50%);
		width: 70px;
		height: 80px;
		background-color: cornflowerblue;
		border:#fff;
		border-radius: 5%;
		box-shadow: 0 4px 4px 0 rgba(50,50,50,0.4);
	}
	.calender>p{
		font-family: Verdana, Geneva, Tahoma, sans-serif;
		padding: 0px 0;
		margin: 0;
		color:#fff;
		text-align: center;
	}
	.calender-day{
		font-size:13px;
	}
	.calender-month-year{
		font-size: 11px;
	}
	.calender-date{
		font-size:30px;
		padding-top:0px;
		padding-bottom: 0;
	}
</style>