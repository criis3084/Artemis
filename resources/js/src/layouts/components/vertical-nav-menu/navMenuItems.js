//1 = Directora
//2 = Trabajadora social
//3 = Secretaria
//4 = Tutora
//5 = Laboratorista
//6 = Farmaceutica
//7 = Medico 
import Ls from '../../../services/ls';
var id = 0;

id = parseInt(Ls.get('auth.roles'));

let regresar = false
const id1= {multi:'f'};
export default 
	//1 = Directora
	id==1 ?
	[
		// =============================================================================
		// APADRINAMIENTOS
		// =============================================================================
		{			
			header: 'Social',
			icon: 'PackageIcon',
			items: 
			[
				{
					url: null,
					name: 'Apadrinamiento',
					icon: 'UsersIcon',
					submenu:
					[
						{
							url: '/apadrinamiento/nino',
							name: 'Niños apadrinados',
							slug: 'apadrinamiento-nino',
						},
						{
							url: '/apadrinamiento/ninono',
							name: 'Niños no apadrinados',
							slug: 'apadrinamiento-ninono',
						},
						{
							url: '/apadrinamiento/padrino',
							name: 'Padrinos',
							slug: 'apadrinamiento-padrino',
						},
						{
							url: '/apadrinamiento/apadrinamiento',
							name: 'Apadrinamientos',
							slug: 'apadrinamiento-apadrinamiento',
						},
						{
							url: '/apadrinamiento/familia',
							name: 'Familias',
							slug: 'apadrinamiento-familia',
						},
						{
							url: '/apadrinamiento/encargado',
							name: 'Familiares',
							slug: 'apadrinamiento-encargado',
						}
						// {
						//   url: '/dashboard/ecommerce',
						//   name: 'eCommerce',
						//   slug: 'dashboard-ecommerce',
						//   i18n: 'Hola eCommerce'
						// }
					]
				},
				// =============================================================================
				// Tutoria
				// =============================================================================
				{
					url: null,
					name: 'Tutorías',
					icon: 'BookIcon',
					submenu: 
					[
						{
							url: '/tutoria/tutoria',
							name: 'Tutorías',
							slug: 'tutoria-tutoria',
						},
						{
							url: '/tutoria/tutor',
							name: 'Tutores',
							slug: 'tutoria-tutor',
						},
					]
				},
				// =============================================================================
				// MICROPRESTAMOS
				// =============================================================================
				{
					url: null,
					name: 'Micropréstamos',
					icon: 'DollarSignIcon',
					submenu: 
					[
						{
							url: '/microprestamo/microprestamo',
							name: 'Micropréstamos',
							slug: 'microprestamo-microprestamo',
						},
						{
							url: '/microprestamo/abono',
							name: 'Abonos',
							slug: 'microprestamo-abono',
						},
						{
							url: '/microprestamo/grupo',
							name: 'Grupos',
							slug: 'microprestamo-grupo',
						},
						// {
						//   url: '/microprestamo/integrante',
						//   name: 'integrante',
						//   slug: 'microprestamo-integrante',
						//   i18n: 'Integrantes'
						// },
						{
							url: '/microprestamo/destino',
							name: 'Destinos de inversión',
							slug: 'microprestamo-destino',
						}
					]
				},
				// =============================================================================
				// VIVIENDA
				// =============================================================================
				{
					url: null,
					name: 'Viviendas',
					icon: 'HomeIcon',
					submenu: 
					[
						{
							url: '/vivienda/vivienda',
							name: 'Viviendas',
							slug: 'vivienda-vivienda',
						},
						{
							url: '/vivienda/abono',
							name: 'Abonos',
							slug: 'vivienda-abono',
						},
						{
							url: '/vivienda/constructor',
							name: 'Constructores',
							slug: 'vivienda-constructor',
						},
						{
							url: '/vivienda/tipo',
							name: 'Tipos de vivienda',
							slug: 'vivienda-tipo',
						}
					]
				},
				// =============================================================================
				// Datos Generales
				// =============================================================================
				{
					url: null,
					name: 'Datos Generales',
					icon: 'LayersIcon',
					submenu:
					[
						{
							url: '/general/escuela',
							name: 'Escuelas',
							slug: 'general-escuela',
						},
						{
							url: '/general/sector',
							name: 'Sectores',
							slug: 'general-sector',
						},
						{
							url: '/general/aldea',
							name: 'Aldeas',
							slug: 'general-aldea',
						}
					]
				}
			]
		},
		{

		///////////////////////////////////////////////////////////////////////////////////////////
		///////////////////////////   SALUD
		///////////////////////////////////////////////////////////////////////////////////////////
			header: 'Salud',
			icon: 'PackageIcon',
			items: 
			[
				{
					url: null,
					name: 'Farmacia',
					icon: 'PlusCircleIcon',
					submenu:
					[
						{
								url: '/farmacia/medicamentos',
								name: 'Medicamentos',
								slug: 'farmacia-medicamentos',
						},
						{
							url: '/ingreso/medicamentos',
							name: 'Ingreso Medicamentos',
							slug: 'ingreso-medicamentos',
						},
						{
							url: '/salida/medicamentos',
							name: 'Salida Medicamentos',
							slug: 'salida-medicamentos',
						},
						{
							url: '/farmacia/proveedores',
							name: 'Proveedores',
							slug: 'farmacia-proveedores',
						},
						{
							url: '/farmacia/casas',
							name: 'Casas médicas',
							slug: 'farmacia-casas',
						},
						{
							url: '/farmacia/categoria',
							name: 'Categorías',
							slug: 'farmacia-categoria',
						}
					]
				},
				{
					url: null,
					name: 'Clínica',
					icon: 'ThermometerIcon',
					submenu:
					[
						{
							url: '/clinica/consultorio',
							name: 'Consultorio',
							slug: 'clinica-consultorio',
						},
						{
							url: '/clinica/pacientes',
							name: 'Pacientes',
							slug: 'clinica-pacientes',
						},
						{
							url: '/clinica/citas',
							name: 'Citas',
							slug: 'clinica-citas',
						},
						{
							url: '/clinica/tipoC',
							name: 'Tipo de citas',
							slug: 'clinica-tipo',
						},
						{
							url: '/clinica/tipoP',
							name: 'Tipo de pacientes',
							slug: 'clinica-tipo',
						},
					]
				},
				{
					url: null,
					name: 'Laboratorio',
					icon: 'FilterIcon',
					submenu:
					[
						{
							url: '/laboratorio/examen',
							name: 'Exámenes',
							slug: 'laboratorio-examen',
						},
						{
							url: '/laboratorio/tipo',
							name: 'Tipos de exámenes',
							slug: 'laboratorio-tipo',
						},
					]
				}
			]
		},
		// =============================================================================
		// ADMINISTRACION
		// =============================================================================
		{
			header: 'Administración',
			icon: 'PackageIcon',
			items: 
			[
				{
					url: null,
					name: 'Admin',
					icon: 'UserIcon',
					submenu:
					[
						{
							url: '/admin/usuarios',
							name: 'Usuarios',
							slug: 'admin-user',
						},
						{
							url: '/clinica/PersonalMedico',
							name: 'Personal Médico',
							icon: 'UserPlusIcon',
						},
						{
							url: '/admin/roles',
							name: 'Roles',
							slug: 'admin-rol',
						},

					]
				},

			]
		}
	]
	://2 = Trabajadora social
		id == 2 ? 
		[
			{
				header: 'Social',
				icon: 'PackageIcon',
				items:
				[
					{
						url: null,
						name: 'Apadrinamiento',
						icon: 'UsersIcon',
						submenu: 
						[
							{
								url: '/apadrinamiento/nino',
								name: 'Niños apadrinados',
								slug: 'apadrinamiento-nino',
							},
							{
								url: '/apadrinamiento/ninono',
								name: 'Niños no apadrinados',
								slug: 'apadrinamiento-ninono',
							},
							{
								url: '/apadrinamiento/padrino',
								name: 'Padrinos',
								slug: 'apadrinamiento-padrino',
							},
							{
								url: '/apadrinamiento/apadrinamiento',
								name: 'Apadrinamientos',
								slug: 'apadrinamiento-apadrinamiento',
							},
							{
								url: '/apadrinamiento/familia',
								name: 'Familias',
								slug: 'apadrinamiento-familia',
							},
							{
								url: '/apadrinamiento/encargado',
								name: 'Familiares',
								slug: 'apadrinamiento-encargado',
							},
						]
					},
					// =============================================================================
					// Tutoria
					// =============================================================================
					{
						url: null,
						name: 'Tutorías',
						icon: 'BookIcon',
						submenu: [
						{
							url: '/tutoria/tutoria',
							name: 'Tutorías',
							slug: 'tutoria-tutoria',
						},
						{
							url: '/tutoria/tutor',
							name: 'Tutores',
							slug: 'tutoria-tutor',
						},
						]
					},
					// =============================================================================
					// MICROPRESTAMOS
					// =============================================================================
					{
						url: null,
						name: 'Micropréstamos',
						icon: 'DollarSignIcon',
						submenu:
						[
							{
								url: '/microprestamo/microprestamo',
								name: 'Micropréstamos',
								slug: 'microprestamo-microprestamo',
							},
							{
								url: '/microprestamo/abono',
								name: 'Abonos',
								slug: 'microprestamo-abono',
							},
							{
								url: '/microprestamo/grupo',
								name: 'Grupos',
								slug: 'microprestamo-grupo',
							},
							// {
							//   url: '/microprestamo/integrante',
							//   name: 'integrante',
							//   slug: 'microprestamo-integrante',
							//   i18n: 'Integrantes'
							// },
							{
								url: '/microprestamo/destino',
								name: 'Destinos de inversión',
								slug: 'microprestamo-destino',
							},
						]
					},
					// =============================================================================
					// VIVIENDA
					// =============================================================================
					{
						url: null,
						name: 'Viviendas',
						icon: 'HomeIcon',
						submenu: 
						[
							{
								url: '/vivienda/vivienda',
								name: 'Viviendas',
								slug: 'vivienda-vivienda',
							},
							{
								url: '/vivienda/abono',
								name: 'Abonos',
								slug: 'vivienda-abono',
							},
							{
								url: '/vivienda/constructor',
								name: 'Constructores',
								slug: 'vivienda-constructor',
							},
							{
								url: '/vivienda/tipo',
								name: 'Tipos de vivienda',
								slug: 'vivienda-tipo',
							},
						]
					},
					// =============================================================================
					// Datos Generales
					// =============================================================================
					{
						url: null,
						name: 'Datos Generales',
						icon: 'LayersIcon',
						submenu:
						[
							{
								url: '/general/escuela',
								name: 'Escuelas',
								slug: 'general-escuela',
							},
							{
								url: '/general/sector',
								name: 'Sectores',
								slug: 'general-sector',
							},
							{
								url: '/general/aldea',
								name: 'Aldeas',
								slug: 'general-aldea',
							},
						]
					},
				]
			}
		]: //3 = Secretaria
			id == 3 ?
				[
					{
					// =============================================================================
					// MICROPRESTAMOS
					// =============================================================================
					
						url: null,
						name: 'Micropréstamos',
						icon: 'DollarSignIcon',
						submenu:
						[
							{
								url: '/microprestamo/microprestamo',
								name: 'Micropréstamos',
								slug: 'microprestamo-microprestamo',
							},
							{
								url: '/microprestamo/abono',
								name: 'Abonos',
								slug: 'microprestamo-abono',
							},
							{
								url: '/microprestamo/grupo',
								name: 'Grupos',
								slug: 'microprestamo-grupo',
							},
							// {
							//   url: '/microprestamo/integrante',
							//   name: 'integrante',
							//   slug: 'microprestamo-integrante',
							//   i18n: 'Integrantes'
							// },
							{
								url: '/microprestamo/destino',
								name: 'Destinos de inversión',
								slug: 'microprestamo-destino',
							},
						]
					},
					// =============================================================================
					// VIVIENDA
					// =============================================================================
					{
						url: null,
						name: 'Viviendas',
						icon: 'HomeIcon',
						submenu:
						[
							{
								url: '/vivienda/vivienda',
								name: 'Viviendas',
								slug: 'vivienda-vivienda',
							},
							{
								url: '/vivienda/abono',
								name: 'Abonos',
								slug: 'vivienda-abono',
							},
							{
								url: '/vivienda/constructor',
								name: 'Constructores',
								slug: 'vivienda-constructor',
							},
							{
								url: '/vivienda/tipo',
								name: 'Tipos de vivienda',
								slug: 'vivienda-tipo',
							},
						]
					},
					// =============================================================================
					// Datos Generales
					// =============================================================================
					{
						url: null,
						name: 'Datos Generales',
						icon: 'LayersIcon',
						submenu:
						[
							{
								url: '/general/escuela',
								name: 'Escuelas',
								slug: 'general-escuela',
							},
							{
								url: '/general/sector',
								name: 'Sectores',
								slug: 'general-sector',
							},
							{
								url: '/general/aldea',
								name: 'Aldeas',
								slug: 'general-aldea',
							},
						]
					}
				//4- Tutora
				]:
					id == 4 ?
					[
						{
						// =============================================================================
						// Tutoria
						// =============================================================================
							url: null,
							name: 'Tutorías',
							icon: 'BookIcon',
							submenu:
							[
								{
									url: '/tutoria/tutoria',
									name: 'Tutorías',
									slug: 'tutoria-tutoria',
								},
								{
									url: '/tutoria/tutor',
									name: 'Tutores',
									slug: 'tutoria-tutor',
								},
							]
						},
							// =============================================================================
						// Datos Generales
						// =============================================================================
						{ 
							url: null,
							name: 'Datos Generales',
							icon: 'LayersIcon',
							submenu:
							[
								{
									url: '/general/escuela',
									name: 'Escuelas',
									slug: 'general-escuela',
								},
								{
									url: '/general/sector',
									name: 'Sectores',
									slug: 'general-sector',
								},
								{
									url: '/general/aldea',
									name: 'Aldeas',
									slug: 'general-aldea',
								},
							]
						}
					//Laboratorista 
					]:
					id == 5 ?
					[
						{
							url: null,
							name: 'Clínica',
							icon: 'ThermometerIcon',
							submenu:
							[
								{
									url: '/clinica/consultorio',
									name: 'Consultorio',
									slug: 'clinica-consultorio',
								},
								{
									url: '/clinica/pacientes',
									name: 'Pacientes',
									slug: 'clinica-pacientes',
								},
								{
									url: '/clinica/citas',
									name: 'Citas',
									slug: 'clinica-citas',
								},
								{
									url: '/clinica/tipoC',
									name: 'Tipo de citas',
									slug: 'clinica-tipo',
								},
								{
									url: '/clinica/tipoP',
									name: 'Tipo de pacientes',
									slug: 'clinica-tipo',
								},
							]
						},
						{
							url: null,
							name: 'Laboratorio',
							icon: 'FilterIcon',
							submenu:
							[
								{
									url: '/laboratorio/examen',
									name: 'Exámenes',
									slug: 'laboratorio-examen',
								},
								{
									url: '/laboratorio/tipo',
									name: 'Tipos de exámenes',
									slug: 'laboratorio-tipo',
								},
							]
						}
					//6= Farmaceutica
					]: 
						id == 6 ?
						[
							///////////////////////////////////////////////////////////////////////////////////////////
							///////////////////////////   SALUD
							///////////////////////////////////////////////////////////////////////////////////////////
							{
								header: 'Salud',
								icon: 'PackageIcon',
								items: 
								[
									{
										url: null,
										name: 'Farmacia',
										icon: 'PlusCircleIcon',
										submenu:
										[
											{
												url: '/farmacia/medicamentos',
												name: 'Medicamentos',
												slug: 'farmacia-medicamentos',
											},
											{
												url: '/ingreso/medicamentos',
												name: 'Ingreso Medicamentos',
												slug: 'ingreso-medicamentos',
											},
											{
												url: '/salida/medicamentos',
												name: 'Salida Medicamentos',
												slug: 'salida-medicamentos',
											},
											{
												url: '/farmacia/proveedores',
												name: 'Proveedores',
												slug: 'farmacia-proveedores',
											},
											{
												url: '/farmacia/casas',
												name: 'Casas médicas',
												slug: 'farmacia-casas',
											},
											{
												url: '/farmacia/categoria',
												name: 'Categorías',
												slug: 'farmacia-categoria',
											},
										]
									}
								]
							}
						//7 = Medico 
						]:[
							///////////////////////////////////////////////////////////////////////////////////////////
							///////////////////////////   SALUD
							///////////////////////////////////////////////////////////////////////////////////////////
							{
								header: 'Salud',
								icon: 'PackageIcon',
								items: 
								[
									{
										url: null,
										name: 'Farmacia',
										icon: 'PlusCircleIcon',
										submenu:
										[
											{
													url: '/farmacia/medicamentos',
													name: 'Medicamentos',
													slug: 'farmacia-medicamentos',
											},
											{
												url: '/ingreso/medicamentos',
												name: 'Ingreso Medicamentos',
												slug: 'ingreso-medicamentos',
											},
											{
												url: '/salida/medicamentos',
												name: 'Salida Medicamentos',
												slug: 'salida-medicamentos',
											},
											{
													url: '/farmacia/proveedores',
													name: 'Proveedores',
													slug: 'farmacia-proveedores',
											},
											{
												url: '/farmacia/casas',
												name: 'Casas médicas',
												slug: 'farmacia-casas',
											},
											{
												url: '/farmacia/categoria',
												name: 'Categorías',
												slug: 'farmacia-categoria',
											},
										]
									},
									{
										url: null,
										name: 'Clínica',
										icon: 'ThermometerIcon',
										submenu: [
										{
											url: '/clinica/consultorio',
											name: 'Consultorio',
											slug: 'clinica-consultorio',
										},
										{
											url: '/clinica/pacientes',
											name: 'Pacientes',
											slug: 'clinica-pacientes',
										},
										{
											url: '/clinica/citas',
											name: 'Citas',
											slug: 'clinica-citas',
										},
										{
											url: '/clinica/tipoC',
											name: 'Tipo de citas',
											slug: 'clinica-tipo',
										},
										{
											url: '/clinica/tipoP',
											name: 'Tipo de pacientes',
											slug: 'clinica-tipo',
										},
										]
									},
									{
										url: null,
										name: 'Laboratorio',
										icon: 'FilterIcon',
										submenu: [
										{
											url: '/laboratorio/examen',
											name: 'Exámenes',
											slug: 'laboratorio-examen',
										},
										{
											url: '/laboratorio/tipo',
											name: 'Tipos de exámenes',
											slug: 'laboratorio-tipo',
										},
										]
									}
								]
							}
						]
