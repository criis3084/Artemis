<template>
		<div class="vx-row">
				<div class="vx-col w-full sm:w-1/2 lg:w-1/5 mb-base" v-if="amplio">
					<vx-card>
						<template slot="actions">
								<vx-tooltip text = "Expandir"> <vs-button radius type="gradient" icon="chevron_right" color = "primary" size="small" @click="abrir(amplio)"></vs-button>  </vx-tooltip>
						</template>
						<div class="text-center">
							<h4> <b> {{nombreCompleto}} </b></h4>
							<div v-if ="fotoPerfil != null">
								<vs-avatar class="mx-auto my-6 block" size="80px" :src="fotoPerfil"/>
							</div>
							<div v-if ="codigoPersona != null">
								<p>Codigo: {{codigoPersona}} </p>
							</div>
								<br>
						</div>

						<span>
							<p class="text-xl font-semibold">  {{ genero == 1 ? 'Masculino' : 'Femenino'}}  </p>
							<small class="text-grey">Genero</small>
						</span>

						<span>
							<p class="text-xl font-semibold"> {{tipoPaciente}} </p>
							<small class="text-grey">Tipo de Paciente</small>
						</span>
					</vx-card>
					<br>
						<vx-card
							title="Información Medica"
							title-color="primary"
							collapse-action
							v-if="!primero"
							>
							<div class="flex items-center mt-0">
								<vs-button color="success" icon="filter_center_focus" radius type="flat" size="large" class="mt-0" disabled></vs-button>
								<div v-if="ultimo_peso!= null" class="vx-col w-full text-right text-success mt-0"><h6> {{ultimo_peso}} <small> Lbs.</small></h6></div>
								<div v-else class="vx-col w-full text-right text-success mt-0"><h6> No Medido </h6></div>
							</div>
							<vs-divider class="mt-0"/>
							<div class="flex items-center mt-0">
								<vs-button color="success" icon="vertical_align_top" radius type="flat" size="large" class="mt-0" disabled></vs-button>
								<div v-if="ultima_talla!= null" class="vx-col w-full text-right text-success mt-0"><h6> {{ultima_talla}} <small> Mts. </small></h6></div>
								<div v-else class="vx-col w-full text-right text-success mt-0"><h6> No Medido </h6></div>
							</div>
							<vs-divider class="mt-0"/>
							<div class="flex items-center mt-0">
								<vs-button color="success" icon="favorite" radius type="flat" size="large" class="mt-0" disabled></vs-button>
								<div v-if="ultimo_pulso!= null" class="vx-col w-full text-right text-success mt-0"><h6>{{ultimo_pulso}} <small> Lbs.</small></h6></div>
								<div v-else class="vx-col w-full text-right text-success mt-0"><h6> No Medido </h6></div>
							</div>
							<vs-divider class="mt-0"/>
							<div class="flex items-center mt-0">
								<vs-button type="flat" radius color="success" icon-pack="feather" icon="icon-thermometer" size="large" class="mt-0" disabled ></vs-button>
								<div v-if="ultima_temperatura!=null" class="vx-col w-full text-right text-success mt-0"><h6>{{ultima_temperatura}} <small> °C</small></h6></div>
								<div v-else class="vx-col w-full text-right text-success mt-0"><h6> No Medido </h6></div>
							</div>
							<vs-divider class="mt-0"/>
							<div class="flex items-center mt-0">
								<vs-button color="success" icon="directions_run" radius type="flat" size="large" class="mt-0" disabled></vs-button>
								<div v-if="ultima_respiracion!=null" class="vx-col w-full text-right text-success mt-0"><h6>{{ultima_respiracion}} <small> r/m</small></h6></div>
								<div v-else class="vx-col w-full text-right text-success mt-0"><h6> No Medido </h6></div>
							</div>
							<vs-divider class="mt-0"/>
							<div class="flex items-center mt-0">
								<vs-button color="success" icon="timer" radius type="flat" size="large" class="mt-0" disabled></vs-button>
								<div v-if="ultima_presion!=null" class="vx-col w-full text-right text-success mt-0"><h6>{{ultima_presion}} <small> NC</small></h6></div>
								<div v-else class="vx-col w-full text-right text-success mt-0"><h6> No Medido </h6></div>
							</div>
							<vs-divider class="mt-0" v-if="ultima_semanas!= null"/>
							<div class="flex items-center mt-0" v-if="ultima_semanas!= null">
								<vs-button color="danger" icon="pregnant_woman" radius type="flat" size="large" class="mt-0" disabled></vs-button>
								<div class="vx-col w-full text-right text-danger mt-0"><h6>{{ultima_semanas}}<small> Semanas</small></h6> </div>
							</div>

							<vs-divider class="mt-0" v-if="ultima_glicemia!= null"/>
							<div class="flex items-center mt-0" v-if="ultima_glicemia!= null">
								<vs-button color="danger" icon="local_pharmacy" radius type="flat" size="large" class="mt-0" disabled></vs-button>
								<div class="vx-col w-full text-right text-danger mt-0"><h6>{{ultima_glicemia}} <small> mg/dl</small></h6></div>
							</div>
							<vs-divider class="mt-0" v-if="ultima_glicemia!= null"/>
						</vx-card>
				</div>
				<div class="vx-col w-full sm:w-1/2 lg:w-1/4 mb-base" v-else>
					<vx-card>
						<template slot="actions">
								<vx-tooltip text="Contraer"> <vs-button radius type="gradient" icon="chevron_left" color = "primary" size="small" @click="abrir(amplio)"></vs-button>  </vx-tooltip>
						</template>
						<div class="text-center">
							<h4> <b> {{nombreCompleto}} </b></h4>
							<div v-if ="fotoPerfil != null">
								<vs-avatar class="mx-auto my-6 block" size="80px" :src="fotoPerfil"/>
							</div>
							<div v-if ="codigoPersona != null">
								<p>Codigo: {{codigoPersona}} </p>
							</div>
								<br>
						</div>
						<div class="flex justify-between text-center">
							<span>
								<p class="text-xl font-semibold">  {{ genero == 1 ? 'Masculino' : 'Femenino'}}  </p>
								<small class="text-grey">Genero</small>
							</span>
							<span>
								<p class="text-xl font-semibold"> {{tipoPaciente}} </p>
								<small class="text-grey">Tipo de Paciente</small>
							</span>
						</div>
					</vx-card>
					<br>
					<vx-card
						title="Información Personal"
						title-color="primary"
						collapse-action
						:open="false"
					>
						<div class="flex items-center mt-0">
							<vs-button color="warning" icon="cake" radius type="flat" size="large" class="mt-0" disabled></vs-button><h5 class="text-warning">Edad:</h5>
							<div class="vx-col w-full text-right text-warning mt-0"><h6>{{calculateAge(informacion.fecha_nacimiento)}}</h6></div>
						</div>
						<vs-divider class="mt-0"/>
						<div class="flex items-center mt-0" v-if="informacion.CUI != null">
							<vs-button type="flat" radius color="warning" icon-pack="feather" icon="icon-credit-card" size="large" class="mt-0" disabled ></vs-button><h5 class="text-warning">DPI:</h5>
							<div class="vx-col w-full text-right text-warning mt-0"><h6> {{informacion.CUI}} </h6></div>
						</div>
							<vs-divider class="mt-0" v-if="informacion.CUI != null"/>
						<div class="flex items-center mt-0" v-if="informacion.numero_telefono != null">
							<vs-button type="flat" radius color="warning" icon-pack="feather" icon="icon-phone-call" size="large" class="mt-0" disabled ></vs-button><h5 class="text-warning">Telefono:</h5>
							<div class="vx-col w-full text-right text-warning mt-0"><h6> {{informacion.numero_telefono}} </h6></div>
						</div>
							<vs-divider class="mt-0" v-if="informacion.numero_telefono != null"/>
						<div class="flex items-center mt-0">
							<vs-button type="flat" radius color="warning" icon-pack="feather" icon="icon-map-pin" size="large" class="mt-0" disabled ></vs-button><h5 class="text-warning">Dirección:</h5>
						</div>
								<h6> {{ informacion.direccion }} </h6>
					</vx-card>
					<br>
						<vx-card
						title="Información Medica"
						title-color="primary"
						collapse-action
						v-if="!primero"
						>
							<div class="flex items-center mt-0">
								<vs-button color="success" icon="filter_center_focus" radius type="flat" size="large" class="mt-0" disabled></vs-button><h5 class="text-success">Peso:</h5>
								<div v-if="ultima_presion!=null" class="vx-col w-full text-right text-success mt-0" ><h6> {{ultimo_peso}} <small> Lbs.</small></h6></div>
								<div v-else class="vx-col w-full text-right text-success mt-0"><h6> No Medido </h6></div>
							</div>
							<vs-divider class="mt-0"/>
							<div class="flex items-center mt-0">
								<vs-button color="success" icon="vertical_align_top" radius type="flat" size="large" class="mt-0" disabled></vs-button><h5 class="text-success">Talla:</h5>
								<div v-if="ultima_presion!=null" class="vx-col w-full text-right text-success mt-0"><h6> {{ultima_talla}} <small> Mts. </small></h6></div>
								<div v-else class="vx-col w-full text-right text-success mt-0"><h6> No Medido </h6></div>
							</div>
							<vs-divider class="mt-0"/>
							<div class="flex items-center mt-0">
								<vs-button color="success" icon="favorite" radius type="flat" size="large" class="mt-0" disabled></vs-button><h5 class="text-success">Pulso:</h5>
								<div v-if="ultima_presion!=null" class="vx-col w-full text-right text-success mt-0"><h6>{{ultimo_pulso}} <small> Lbs.</small></h6></div>
								<div v-else class="vx-col w-full text-right text-success mt-0"><h6> No Medido </h6></div>
							</div>
							<vs-divider class="mt-0"/>
							<div class="flex items-center mt-0">
								<vs-button type="flat" radius color="success" icon-pack="feather" icon="icon-thermometer" size="large" class="mt-0" disabled ></vs-button><h5 class="text-success">Temperatura:</h5>
								<div v-if="ultima_presion!=null" class="vx-col w-full text-right text-success mt-0"><h6>{{ultima_temperatura}} <small> °C</small></h6></div>
								<div v-else class="vx-col w-full text-right text-success mt-0"><h6> No Medido </h6></div>
							</div>
							<vs-divider class="mt-0"/>
							<div class="flex items-center mt-0">
								<vs-button color="success" icon="directions_run" radius type="flat" size="large" class="mt-0" disabled></vs-button><h5 class="text-success">Respiración:</h5>
								<div v-if="ultima_presion!=null" class="vx-col w-full text-right text-success mt-0"><h6>{{ultima_respiracion}} <small> r/m</small></h6></div>
								<div v-else class="vx-col w-full text-right text-success mt-0"><h6> No Medido </h6></div>
							</div>
							<vs-divider class="mt-0"/>
							<div class="flex items-center mt-0">
								<vs-button color="success" icon="timer" radius type="flat" size="large" class="mt-0" disabled></vs-button><h5 class="text-success">Presión arterial:</h5>
								<div v-if="ultima_presion != null" class="vx-col w-full text-right text-success mt-0"><h6>{{ultima_presion}} <small> NC</small></h6></div>
								<div v-else class="vx-col w-full text-right text-success mt-0"><h6> No Medido </h6></div>
							</div>
							<vs-divider class="mt-0"/>
							<div class="flex items-center mt-0" v-if="ultima_semanas != null">
								<vs-button color="danger" icon="pregnant_woman" radius type="flat" size="large" class="mt-0" disabled></vs-button><h5 class="text-danger">Semanas de embarazo:</h5>
								<div class="vx-col w-full text-right text-danger mt-0"><h6>{{ultima_semanas}}<small> Semanas</small></h6> </div>
							</div>

							<vs-divider class="mt-0" v-if="ultima_glicemia != null"/>
							<div class="flex items-center mt-0" v-if="ultima_glicemia != null">
								<vs-button color="danger" icon="local_pharmacy" radius type="flat" size="large" class="mt-0" disabled></vs-button><h5 class="text-danger">Glicemia:</h5>
								<div class="vx-col w-full text-right text-danger mt-0"><h6>{{ultima_glicemia}} <small> mg/dl</small></h6></div>
							</div>
							<vs-divider class="mt-0" v-if="ultima_glicemia != null"/>
						</vx-card>
					<br>
				</div>
				<div class="vx-col w-full sm:w-1/2 mb-base" :class="amplio == true ? 'lg:w-2/5': 'lg:w-2/4'">
					<vx-card
						title="Historial Medico"
						title-color="primary"
						>
							<template slot="actions">
								<vx-tooltip text = "Agregar registro"> <router-link to="/clinica/consultorio"> <vs-button radius type="gradient" icon="add" color = "primary" size="large" ></vs-button> </router-link>  </vx-tooltip>
							</template>
							<div v-if="primerHistorial">
									  <ul class="vx-timeline">
											<li v-for="historial in historialCompleto" :key="historial.id">
												<div v-if="historial.tipoH==1">
													<div class="timeline-icon bg-warning">
														<feather-icon icon="FilterIcon" svgClasses="text-white stroke-current w-5 h-5" />
													</div>
													<div class="timeline-info">
														<h5 class="text-dark"> <b class="text-warning">Descripción: </b> {{ historial.examen.descripcion }}</h5>
														<span class="activity-desc"><b>Resultado </b>{{ historial.examen.resultado }}</span>
													</div>
													<span class="text-grey activity-e-time">Fecha: {{ historial.examen.created_at }}</span>
													<vs-divider class="mt-5"/>
												</div>
												<div v-else>
													<div class="timeline-icon bg-primary">
														<feather-icon icon="FileTextIcon" svgClasses="text-white stroke-current w-5 h-5" />
													</div>
													<div class="timeline-info">
														<h5 class="text-dark"> <b class="text-primary">Descripción: </b> {{ historial.descripcion }}</h5>
														<span class="activity-desc"><b>Medico encargado: </b>{{ historial.doctor[0].nombres + ' ' + historial.doctor[0].apellidos }}</span>
														<br>
														<span class="activity-desc"><b>Objetivo: </b>{{ historial.objetivo }}</span>
														<br>
														<span class="activity-desc"><b>Subjetivo: </b>{{ historial.subjetivo }}</span>
													</div>
													<span class="text-grey activity-e-time">Fecha: {{ historial.created_at }}</span>
													<div class="flex items-center mt-0">
														<vs-button color="primary" type="border" icon="visibility" size="small" @click="openDetalle(historial)">Ver consulta</vs-button>
														<vs-button color="primary" type="border" icon="visibility" class="vs-align-right" size="small" @click="openDetalle(historial)">Ver receta</vs-button>
													</div>
													<vs-divider class="mt-5"/>
												</div>
											</li>
										</ul>

								<vs-prompt

									:buttons-hidden="true"
									title="Detalle de la consulta"
									:active.sync="abrirDetalle">
										<div v-if="detalleConsulta!= null">
											<h5> <b> Doctor: </b> {{detalleConsulta.doctor[0].nombres + ' ' + detalleConsulta.doctor[0].apellidos}}</h5>
											<h5> <b> Descripción: </b> {{detalleConsulta.descripcion}}</h5>
											<h5> <b> Objetivo: </b> {{detalleConsulta.objetivo}}</h5>
											<h5> <b> Subjetivo: </b> {{detalleConsulta.subjetivo}}</h5>
											<br>
											<h4 class="text-center text-primary"> <b> Signos Vitales Medidos: </b></h4>
											<br>
											<div class="flex items-center mt-0">
												<vs-button color="success" icon="filter_center_focus" radius type="flat" size="large" class="mt-0" disabled></vs-button><h6 class="text-success">Peso:</h6>
												<div v-if="detalleConsulta.peso_actual != null" class="vx-col w-full text-right text-success mt-0"><h6> {{detalleConsulta.peso_actual}} <small> Lbs.</small></h6></div>
												<div v-else class="vx-col w-full text-right text-success mt-0"><h6> No Medido </h6></div>
											</div>
											<vs-divider class="mt-0"/>
											<div class="flex items-center mt-0">
												<vs-button color="success" icon="vertical_align_top" radius type="flat" size="large" class="mt-0" disabled></vs-button><h6 class="text-success">Talla:</h6>
												<div v-if="detalleConsulta.talla != null" class="vx-col w-full text-right text-success mt-0"><h6> {{detalleConsulta.talla}} <small> Mts. </small></h6></div>
												<div v-else class="vx-col w-full text-right text-success mt-0"><h6> No Medido </h6></div>
											</div>
											<vs-divider class="mt-0"/>
											<div class="flex items-center mt-0">
												<vs-button color="success" icon="favorite" radius type="flat" size="large" class="mt-0" disabled></vs-button><h6 class="text-success">Pulso:</h6>
												<div v-if="detalleConsulta.pulso != null" class="vx-col w-full text-right text-success mt-0"><h6>{{detalleConsulta.pulso}} <small> Lbs.</small></h6></div>
												<div v-else class="vx-col w-full text-right text-success mt-0"><h6> No Medido </h6></div>
											</div>
											<vs-divider class="mt-0"/>
											<div class="flex items-center mt-0">
												<vs-button type="flat" radius color="success" icon-pack="feather" icon="icon-thermometer" size="large" class="mt-0" disabled ></vs-button><h6 class="text-success">Temperatura:</h6>
												<div v-if="detalleConsulta.temperatura != null" class="vx-col w-full text-right text-success mt-0"><h6>{{detalleConsulta.temperatura}} <small> °C</small></h6></div>
												<div v-else class="vx-col w-full text-right text-success mt-0"><h6> No Medido </h6></div>
											</div>
											<vs-divider class="mt-0"/>
											<div class="flex items-center mt-0">
												<vs-button color="success" icon="directions_run" radius type="flat" size="large" class="mt-0" disabled></vs-button><h6 class="text-success">Respiración:</h6>
												<div v-if="detalleConsulta.respiracion != null" class="vx-col w-full text-right text-success mt-0"><h6>{{detalleConsulta.respiracion}} <small> r/m</small></h6></div>
												<div v-else class="vx-col w-full text-right text-success mt-0"><h6> No Medido </h6></div>
											</div>
											<vs-divider class="mt-0"/>
											<div class="flex items-center mt-0">
												<vs-button color="success" icon="timer" radius type="flat" size="large" class="mt-0" disabled></vs-button><h6 class="text-success">Presión arterial:</h6>
												<div v-if="detalleConsulta.presion_arterial != null" class="vx-col w-full text-right text-success mt-0"><h6>{{detalleConsulta.presion_arterial}} <small> NC</small></h6></div>
												<div v-else class="vx-col w-full text-right text-success mt-0"><h6> No Medido </h6></div>
											</div>
											<vs-divider class="mt-0"/>
											<div class="flex items-center mt-0" v-if="detalleConsulta.semanas_embarazo != null">
												<vs-button color="danger" icon="pregnant_woman" radius type="flat" size="large" class="mt-0" disabled></vs-button><h6 class="text-danger">Semanas de embarazo:</h6>
												<div class="vx-col w-full text-right text-danger mt-0"><h6>{{detalleConsulta.semanas_embarazo}}<small> Semanas</small></h6> </div>
											</div>

											<vs-divider class="mt-0" v-if="detalleConsulta.glicemia != null"/>
											<div class="flex items-center mt-0" v-if="detalleConsulta.glicemia != null">
												<vs-button color="danger" icon="local_pharmacy" radius type="flat" size="large" class="mt-0" disabled></vs-button><h6 class="text-danger">Glicemia:</h6>
												<div class="vx-col w-full text-right text-danger mt-0"><h6>{{detalleConsulta.glicemia}} <small> mg/dl</small></h6></div>
											</div>
											<vs-divider class="mt-0" v-if="detalleConsulta.glicemia != null"/>

										</div>
								</vs-prompt>

								</div>
								<div v-else>
									<h3>El paciente no tiene registros en su historial medico</h3>
								</div>
					</vx-card>
				</div>
				<div class="vx-col w-full sm:w-1/2 mb-base" :class="amplio == true ? 'lg:w-2/5': 'lg:w-1/4'">
					<vx-card
						title="Citas Programadas"
						title-color="primary"
					>
						<template slot="actions">
								<vx-tooltip text = "Agregar registro"> <router-link to="/clinica/citas"> <vs-button radius type="gradient" icon="add" color = "primary" size="large" ></vs-button> </router-link>  </vx-tooltip>
						</template>
					<table style="width:100%" class="border-collapse" v-if="!conCitas">
						<tr v-for="(cita) in citas" :key="cita.id" class="mr-0 ml-0">
							<td class="pointer-events-none text-center">
								<vx-card
									card-background="cornflowerblue"
									class="mt-2"
								>
										<p class="calender-day text-white">
											<b>
											{{cita.dia}}
											</b>
										</p>
										<p class="calender-date text-white">
											<b>
											{{cita.fecha.split('-',3)[2]}}
											</b>
										</p>
										<p class="calender-month-year text-white">
											<b>
												{{cita.mes}}
											</b>
										</p>
										<p><small class="text-white">{{cita.fecha.split('-',3)[0]}}</small></p>
								</vx-card>
							</td>
							<td class="pointer-events-none text-left">
								<vx-card class="mt-2">
								<b> Descripcion: </b> {{cita.descripcion}}
								<p>
								<small> 
									<b> Medico: </b> {{cita.datos_clinico[0].nombres + ' ' + cita.datos_clinico[0].apellidos}}
								</small>
								</p>
								</vx-card>
							</td>
						</tr>
					</table>

					<div v-else>
						<h3>El paciente no tiene citas en su historial</h3>
					</div>
					</vx-card>
				</div>
		</div>
</template>
<script>
import axios from 'axios'
import VxTimeline from '@/components/timeline/VxTimeline.vue'
export default {
	data() {
		return {
			active:true,
			url:'/clinica/consultorio',
			id_recibido:null,
			informacion:null,
			paciente_normal:false,
			informacion_completa:null,
			historiales:null,
			primero:true,
			ultimo_historial:null,
			citas:null,
			conCitas:true,
			amplio:true,
			examenes:null,
			primerExamen:false,
			historialCompleto:null,
			primerHistorial:true,
			nombreCompleto:'',
			tipoPaciente:'',
			genero:0,
			fotoPerfil:null,
			codigoPersona:null,
			detalleConsulta:null,
			abrirDetalle:false,
			//--------- Ultimos -------/
			ultimo_peso:null,
			ultima_talla:null,
			ultimo_pulso:null,
			ultima_temperatura:null,
			ultima_presion:null,
			ultima_glicemia:null,
			ultima_semanas:null,
			ultima_respiracion:null,
		}
	},
	components:{
		VxTimeline
	},
	methods: {
		abrir(){
			this.amplio=!this.amplio	
		},
		openDetalle(detalleC){
			console.log
			// this.listado(tutor)
			this.abrirDetalle=true;
			this.detalleConsulta=detalleC
		},
		async traerPaciente(){
			const me = this
			me.id_recibido = me.$route.params.id
			const response = await axios.get(
			`/api/paciente/get?criterio=id&buscar=${me.id_recibido}&completo=true`)
			.then(function (response) {
				const respuesta = response.data
				me.informacion_completa = respuesta.pacientes.data[0]
				me.informacion = me.informacion_completa.datos

				if (me.informacion_completa.tipo_paciente_id==1){
					me.paciente_normal=true
				}
				me.buscarNino(me.informacion.id)
				me.nombreCompleto = me.informacion.nombres + ' ' + me.informacion.apellidos
				me.genero = me.informacion.genero
				me.tipoPaciente = me.informacion_completa.tipo_paciente.nombre
			})
			.catch(function (error) {
			console.log(error)
			})
		},
		buscarNino(idPersona){
			let me = this
			axios.get(
			`/api/nino/get?criterio=persona_sin_acceso_id&buscar=${idPersona}&completo=true`)
			.then(function (response) {
				const respuesta = response.data
				let buscador = respuesta.ninos.data
				if (buscador.length==0){
					me.buscarEncargado(idPersona)
				}
				else{
					me.fotoPerfil=buscador[0].ruta_imagen
					me.codigoPersona=buscador[0].codigo
				}
			})
			.catch(function (error) {
			console.log(error)
			})
		},
		buscarEncargado(idPersona){
			let me = this
			axios.get(
			`/api/encargado/get?criterio=persona_sin_acceso_id&buscar=${idPersona}&completo=true`)
			.then(function (response) {
				const respuesta = response.data
				let buscador = respuesta.encargados.data
				if (buscador.length==0){
					me.fotoPerfil=null
				}
				else{
					me.fotoPerfil=buscador[0].ruta_imagen
					me.buscarRelacion(buscador[0].id)
				}
			})
			.catch(function (error) {
			console.log(error)
			})
		},
		buscarRelacion(idPersona){
			let me = this
			axios.get(
			`/api/relacion/get?criterio=encargado_id&buscar=${idPersona}&completo=true`)
			.then(function (response) {
				const respuesta = response.data
				let buscador = respuesta.relaciones.data
				if (buscador.length==0){
					me.codigoPersona=null
				}
				else{
					me.codigoPersona=buscador[0].codigo
				}
			})
			.catch(function (error) {
			console.log(error)
			})
		},

		calculateAge(fechaN) {
			let currentDate = new Date();
			let fecha_nacimientoTt = new Date(fechaN); 
			let difference = currentDate - fecha_nacimientoTt;
			let age = Math.floor(difference/31557600000);
			return age
		},
		async traerHistorial(){
			const me = this
			me.id_recibido = me.$route.params.id
			const response = await axios.get(
			`/api/historialClinico/get?criterio=paciente_id&buscar=${me.id_recibido}&completo=true`)
			.then(function (response) {
				const respuesta = response.data
				me.historiales = respuesta.historialClinicos.data
				console.log('Datos de historial clinico')
				console.log(me.historiales)
				if (me.historiales.length>0){
					me.primero=false
				}
				for (let i in me.historiales) {
					me.historiales[i].tipoH = 0
				}
				me.traerExamenes(me.historiales)
			})
			.catch(function (error) {
				console.log(error)
			})
		},
		async traerExamenes(listaMedica){
			const me = this
			me.id_recibido = me.$route.params.id
			const response = await axios.get(
			`/api/historialExamen/get?criterio=paciente_id&buscar=${me.id_recibido}&completo=true`)
			.then(function (response) {
				const respuesta = response.data
				me.examenes = respuesta.historialExamenes.data
				console.log('Datos de historial de examenes')
				console.log(me.examenes)
				if (me.examenes.length > 0){
					me.primerExamen=true
				}
				for (let i in me.examenes) {
					me.examenes[i].tipoH = 1
				}
				me.unionExamenes(me.examenes,listaMedica)
			})
			.catch(function (error) {
				console.log(error)
			})
		},
		async traerCitas(){
			const me = this
			me.id_recibido = me.$route.params.id
			const response = await axios.get(
			`/api/cita/get?criterio=paciente_id&buscar=${me.id_recibido}&completo=true`)
			.then(function (response) {
				const respuesta = response.data
				me.citas = me.toFecha(respuesta.citas.data)
				if (me.citas.length>0){
					me.conCitas=false
				}
			})
			.catch(function (error) {
				console.log(error)
			})
		},
		unionExamenes(clinico,examenes){
			const tabla = clinico.concat(examenes);
			console.log('arrayjuntos');
			if (tabla.length !=0){
				for (let i in tabla) {
					let elemento = tabla[i]
					tabla[i].fechaH = new Date(elemento.created_at)
				}

				for (let i in tabla) {
					let elemento = tabla[i]
					let n = tabla.length
					let aux={}
					for (let k = 1; k < n; k++) {
						for (let i = 0; i < (n - k); i++) {
							if (tabla[i].fechaH < tabla[i + 1].fechaH) {
								aux = tabla[i];
								tabla[i] = tabla[i + 1];
								tabla[i + 1] = aux;
							}
						}
					}
				}
				let masReciente=false
				for (let i in tabla) {
					if (tabla[i].tipoH == 0 && masReciente ==false){
						this.ultimo_historial = tabla[i]
						this.ultimo_peso = tabla[i].peso_actual
						this.ultima_talla=tabla[i].talla
						this.ultimo_pulso=tabla[i].pulso
						this.ultima_temperatura=tabla[i].temperatura
						this.ultima_presion=tabla[i].presion_arterial
						this.ultima_glicemia=tabla[i].glicemia
						this.ultima_semanas=tabla[i].semanas_embarazo
						this.ultima_respiracion=tabla[i].respiracion
						masReciente = true
					}
				}
				this.primerHistorial=true
				this.historialCompleto = tabla
			}
			else{
				this.primerHistorial=false
			}
				/*
				let valor = tabla[i]
				if (valor.lotes.length >0){
					let lotesActivos=[]
					for (let j in valor.lotes) {
						let elemento = valor.lotes[j]
						if(elemento.estado == 1)
						{
							elemento.fecha_expiracion = new Date(parseInt(elemento.fecha_expiracion.split('-',3)[0]),parseInt(elemento.fecha_expiracion.split('-',3)[1]),parseInt(elemento.fecha_expiracion.split('-',3)[2]))
							lotesActivos.push(elemento)
						}
					}
					let n = lotesActivos.length
					let aux=0
					    for (let k = 1; k < n; k++) {
							for (let i = 0; i < (n - k); i++) {
								if (lotesActivos[i].fecha_expiracion > lotesActivos[i + 1].fecha_expiracion) {
									aux = lotesActivos[i];
									lotesActivos[i] = lotesActivos[i + 1];
									lotesActivos[i + 1] = aux;
								}
							}
						}
					tabla[i].lotes =lotesActivos
				}
			}
			*/
		},
		traerNombreMedicamento(tabla){
			for (let i in tabla) {
				let valor = tabla[i]
				tabla[i].nombre_completo = valor.nombre + ' - ' + valor.casa_medica.nombre
				if (valor.lotes.length >0){
					let lotesActivos=[]
					for (let j in valor.lotes) {
						let elemento = valor.lotes[j]
						if(elemento.estado == 1)
						{
							elemento.fecha_expiracion = new Date(parseInt(elemento.fecha_expiracion.split('-',3)[0]),parseInt(elemento.fecha_expiracion.split('-',3)[1]),parseInt(elemento.fecha_expiracion.split('-',3)[2]))
							lotesActivos.push(elemento)
						}
					}
					let n = lotesActivos.length
					let aux=0
					    for (let k = 1; k < n; k++) {
							for (let i = 0; i < (n - k); i++) {
								if (lotesActivos[i].fecha_expiracion > lotesActivos[i + 1].fecha_expiracion) {
									aux = lotesActivos[i];
									lotesActivos[i] = lotesActivos[i + 1];
									lotesActivos[i + 1] = aux;
								}
							}
						}
					tabla[i].lotes =lotesActivos
				}
			}
			return tabla
			},
		
		nombreMes(numero){
			numero = parseInt(numero)+1
			let nombre=''
			switch (numero) {
				case 1:
					nombre='Enero' 
					break;
				case 2:
					nombre='Febrero'
					break;
				case 3:
					nombre='Marzo'
					break;
				case 4:
					nombre='Abril' 
					break;
				case 5:
					nombre='Mayo' 
					break;
				case 6:
					nombre='Junio' 
					break;
				case 7:
					nombre='Julio' 
					break;
				case 8:
					nombre='Agosto' 
					break;
				case 9:
					nombre='Septiembre' 
					break;
				case 10:
					nombre='Octubre'
					break;
				case 11:
					nombre='Noviembre'
					break;
				case 12:
					nombre='Diciembre'
					break;
			
				default:
					nombre ='Nulo'
					break;
			}
			return nombre
		},
		toFecha(tabla){
			for (let i in tabla) {
				let valor = tabla[i]
				const todaySin = new Date(parseInt(valor.fecha.split('-',3)[0]),parseInt(valor.fecha.split('-',3)[1]),parseInt(valor.fecha.split('-',3)[2]))
				valor.dia = this.diaEspaniol(todaySin.getDay())
				valor.mes = this.nombreMes(todaySin.getMonth())
			};
			return tabla
		},
		diaEspaniol(dia){
			dia = parseInt(dia)
			let nombre=''
			switch (dia) {
				case 0:
					nombre='Domingo'
					break;
				case 1:
					nombre='Lunes'
					break;
				case 2:
					nombre='Martes'
					break;
				case 3:
					nombre='Miercoles'
					break;
				case 4:
					nombre='Jueves'
					break;
				case 5:
					nombre='Viernes'
					break;
				case 6:
					nombre='Sabado'
					break;
				default:
					nombre ='Nulo'
				break;
			}
			return nombre
		}
	},
	mounted(){
		this.traerPaciente()
		this.traerHistorial()
		this.traerCitas()
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
		font-size:9px;
	}
	.calender-month-year{
		font-size: 9px;
	}
	.calender-date{
		font-size:25px;
		padding-top:0px;
		padding-bottom: 0;
	}
</style>