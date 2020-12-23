/*=========================================================================================
  File Name: router.js
  Description: Routes for vue-router. Lazy loading is enabled.
  Object Strucutre:
                    path => router path
                    name => router name
                    component(lazy loading) => component to load
                    meta : {
                      rule => which user can have access (ACL)
                      breadcrumb => Add breadcrumb to specific page
                      pageTitle => Display title besides breadcrumb
                    }
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/


//Aqui en el router es donde se montan todos los componentes de Vue que se estaran utilizando.

import Vue from 'vue'
import Router from 'vue-router'
import auth from '@/auth/authService'

import firebase from 'firebase/app'
import 'firebase/auth'

Vue.use(Router)

import Ls from '../src/services/ls';
var id = 0;

id = parseInt(Ls.get('auth.roles'));

const router = new Router({
	mode: 'history',
	base: '/',
	scrollBehavior () {
	return { x: 0, y: 0 }
	},
	routes: 
		id == 1 ?
		[
			{
				// =============================================================================
				// MAIN LAYOUT ROUTES
				// =============================================================================
				path: '',
				component: () => import('./layouts/main/Main.vue'),
				children: 
				[
					// =============================================================================
					// Theme Routes
					// =============================================================================
					{
					path: '/',
					redirect: '/bienvenido'
					},
					{
						path: '/bienvenido',
						name: 'inicio',
						component: () => import('./views/pages/Bienvenido.vue'),
						meta: {
							rule: 'editor'
						}
					},
					{
						path: '/apadrinamiento/nino',
						name: 'apadrinamiento-nino',
						component: () => import('./views/apadrinamientos/nino/nino.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/apadrinamiento/fotografia/:id',
						name: 'apadrinamiento-fotografia',
						component: () => import('./views/apadrinamientos/fotografia/fotografia.vue'),
						meta: {
						rule: 'editor'
						}
						},
					{			
						path: '/ingresar/nino',
						name: 'ingresar-nino',
						component: () => import('./views/apadrinamientos/nino/form-ingresar.vue'),
						meta: {
							rule: 'editor'
						}
					},
					{
						path: '/editar/nino/:id',
						name: 'datos-nino',
						component: () => import('./views/apadrinamientos/nino/editNino.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/ver/nino/:id',
						name: 'ver-nino',
						component: () => import('./views/apadrinamientos/nino/verNino.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/editar/ninono/:id',
						name: 'datos-ninono',
						component: () => import('./views/apadrinamientos/nino/ninonoEdit.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/ver/ninono/:id',
						name: 'ver-ninono',
						component: () => import('./views/apadrinamientos/nino/DetallesNinono.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{			
						path: '/ingresar/familia',
						name: 'ingresar-familia',
						component: () => import('./views/apadrinamientos/familia/ingresar.vue'),
						meta: {
							rule: 'editor'
						}
					},
					{			
						path: '/editar/familia/:id',
						name: 'editar-familia',
						component: () => import('./views/apadrinamientos/familia/editar_familia.vue'),
						meta: {
							rule: 'editor'
						}
					},
					{
						path: '/apadrinamiento/ppi/:id',
						name: 'apadrinamiento-ppi',
						component: () => import('./views/apadrinamientos/nino/ppi.vue'),
						meta: {
						rule: 'editor'
						}
					},
					//////////////////ESTUDIO SOCIO
					{
						path: '/apadrinamiento/estudiosocio/:id/:estudio',
						name: 'apadrinamiento-estudiosocio',
						component: () => import('./views/apadrinamientos/familia/estudiosocio.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/apadrinamiento/estudiosocio/:id',
						name: 'apadrinamiento-estudiosocio2',
						component: () => import('./views/apadrinamientos/nino/historialestudiosocio.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/ingresar/estudiosocio/:id',
						name: 'ingresar-estudiosocio',
						component: () => import('./views/apadrinamientos/nino/nuevoestudiosocio.vue'),
						meta: {
						rule: 'admin'
						}
					},
					/////////////////// PPI
					{			
						path: '/ingresar/ppi/:id',
						name: 'ingresar-ppi',
						component: () => import('./views/apadrinamientos/nino/nuevoppi.vue'),
						meta: {
							rule: 'editor'
						}
					},		
					{			
						path: '/ver/ppi/:id',
						name: 'ver-ppi',
						component: () => import('./views/apadrinamientos/nino/verppi.vue'),
						meta: {
						rule: 'editor'
						}
					},		
					{
						path: '/ingresar/fotografia/:id',
						name: 'ingresar-fotografia',
						component: () => import('./views/apadrinamientos/fotografia/nuevafotografia.vue'),
						meta: {
						rule: 'admin'
						}
					},
					{
						path: '/apadrinamiento/ninono',
						name: 'apadrinamiento-ninono',
						component: () => import('./views/apadrinamientos/nino/ninono.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/apadrinamiento/padrino',
						name: 'apadrinamiento-padrino',
						component: () => import('./views/apadrinamientos/padrino/padrino.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/ingresar/padrino',
						name: 'ingresar-padrino',
						component: () => import('./views/apadrinamientos/padrino/formulariopadrin.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/editar/padrino/:id',
						name: 'datos-padrino',
						component: () => import('./views/apadrinamientos/padrino/formulariopadrinedit.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/apadrinamiento/apadrinamiento',
						name: 'apadrinamiento-apadrinamiento',
						component: () => import('./views/apadrinamientos/apadrinamiento/apadrinamiento.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/apadrinamiento/encargado',
						name: 'apadrinamiento-encargado',
						component: () => import('./views/apadrinamientos/familiar/familiar.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/editar/familiar/:id',
						name: 'editar-familiar',
						component: () => import('./views/apadrinamientos/familiar/editar.vue'),
						meta: {
						rule: 'editor'
						}
					},

					{			
						path: '/ver/familiar/:id',
						name: 'ver-familiar',
						component: () => import('./views/apadrinamientos/familiar/ver.vue'),
						meta: {
						rule: 'editor'
						}
					},		

					{
						path: '/ingresar/familiar',
						name: 'ingresar-familiar',
						component: () => import('./views/apadrinamientos/familiar/formulario.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/apadrinamiento/familia',
						name: 'apadrinamiento-familia',
						component: () => import('./views/apadrinamientos/familia/relacion.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/ver/familia/:id',
						name: 'ver-familia',
						component: () => import('./views/apadrinamientos/familia/ver_familia.vue'),
						meta: {
						rule: 'admin'
						}
					},
					///////////////CORRESPONDENCIA
					{
						path: '/apadrinamiento/correspondencia/:id',
						name: 'apadrinamiento-correspondencia',
						component: () => import('./views/apadrinamientos/correspondencia/correspondencia.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{			
						path: '/ingresar/correspondencia/:id',
						name: 'ingresar-correspondencia',
						component: () => import('./views/apadrinamientos/correspondencia/nuevocorrespondencia.vue'),
						meta: {
						rule: 'editor'
						}
					},		
					{			
						path: '/ver/correspondencia/:id',
						name: 'ver-correspondencia',
						component: () => import('./views/apadrinamientos/correspondencia/vercorrespondencia.vue'),
						meta: {
						rule: 'editor'
						}
					},

					// =============================================================================
					// TUTORIA
					// =============================================================================
					{
						path: '/tutoria/tutoria',
						name: 'tutoria-tutoria',
						component: () => import('./views/tutoria/tutoria.vue'),
						meta: {
						rule: 'admin'
						}
					},
					{
						path: '/tutoria/tutor',
						name: 'tutoria-tutor',
						component: () => import('./views/tutoria/tutor.vue'),
						meta: {
						rule: 'admin'
						}
					},
					{			
						path: '/ingresar/tutor',
						name: 'ingresar-tutor',
						component: () => import('./views/tutoria/ingresar.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path:'/editar/tutor/:id',
						name: 'editar-tutor',
						component: () => import('./views/tutoria/tutorEdit.vue'),
						meta: {
						rule:'editor'
						}
					},
					{
						path:'/ver/tutor/:id',
						name: 'ver-tutor',
						component: () => import('./views/tutoria/verTutor.vue'),
						meta: {
						rule:'editor'
						}
					},
					// =============================================================================
					// MICROPRESTAMO
					// =============================================================================
					{
						path:'/microprestamo/ingresar',
						name: 'microprestamo-ingresar',
						component: () => import('./views/Microprestamos/Microprestamo/nuevo_microprestamo.vue'),
						meta: {
						rule:'editor'
						}
					},
					{
						path:'/microprestamo/abono',
						name: 'microprestamo-abono',
						component: () => import('./views/Microprestamos/Abono_prestamo/abonoPrestamo.vue'),
						meta: {
						rule:'editor'
						}
					},
					{
						path: '/microprestamo/destino',
						name: 'microprestamo-destino',
						component: () => import('./views/Microprestamos/Destino_inversion/destinoInversion.vue'),
						meta: {
						rule: 'admin'
						}
					},
					{	
						path: '/microprestamo/integrante',
						name: 'microprestamo-integrante',
						component: () => import('./views/Microprestamos/Detalle_integrante/detalleIntegrante.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/microprestamo/historial/:id',
						name: 'microprestamo-historial',
						component: () => import('./views/Microprestamos/Detalle_integrante/historialPago.vue'),
						meta: {
						rule: 'admin'
						}
					},
					{
						path:'/microprestamo/grupo',
						name: 'microprestamo-grupo',
						component: () => import('./views/Microprestamos/Grupo_prestamo/grupoPrestamo.vue'),
						meta: {
						rule:'editor'
						}
					},
					{
						path:'/microprestamo/Vergrupo/:id',
						name: 'microprestamo-Vergrupo',
						component: () => import('./views/Microprestamos/Grupo_prestamo/VerGrupo.vue'),
						meta: {
						rule:'editor'
						}
					},
					{
						path:'/microprestamo/editarGrupo/:id',
						name: 'microprestamo-editarGrupo',
						component: () => import('./views/Microprestamos/Grupo_prestamo/editarGrupo.vue'),
						meta: {
						rule:'editor'
						}
					},
					{
						path:'/microprestamo/Nuevogrupo',
						name: 'microprestamo-nuevo-grupo',
						component: () => import('./views/Microprestamos/Grupo_prestamo/ingresarGrupo.vue'),
						meta: {
						rule:'editor'
						}
					},
					{
						path: '/microprestamo/microprestamo',
						name: 'microprestamo-microprestamo',
						component: () => import('./views/Microprestamos/Microprestamo/microprestamo.vue'),
						meta: {
						rule: 'admin'
						}
					},
					{
						path: '/microprestamo/Vermicroprestamo/:id',
						name: 'microprestamo-Vermicroprestamo',
						component: () => import('./views/Microprestamos/Microprestamo/verMicroprestamo.vue'),
						meta: {
						rule: 'admin'
						}
					},
					// =============================================================================
					// VIVIENDA
					// =============================================================================
					// VIVIENDA
					{
						path:'/vivienda/vivienda',
						name: 'vivienda-vivienda',
						component: () => import('./views/Viviendas/Vivienda/vivienda.vue'),
						meta: {
						rule:'editor'
						}
					},
					{
						path:'/ingresar/vivienda',
						name: 'ingresar-vivienda',
						component: () => import('./views/Viviendas/Vivienda/ingresar.vue'),
						meta: {
						rule:'editor'
						}
					},
					{
						path:'/editar/vivienda/:id',
						name: 'editar-vivienda',
						component: () => import('./views/Viviendas/Vivienda/editar.vue'),
						meta: {
						rule:'editor'
						}
					},
					{
						path:'/ver/vivienda/:id',
						name: 'ver-vivienda',
						component: () => import('./views/Viviendas/Vivienda/ver.vue'),
						meta: {
						rule:'editor'
						}
					},
					// TIPO VIVIENDA
					{
						path:'/vivienda/tipo',
						name: 'vivienda-tipo',
						component: () => import('./views/Viviendas/Tipo_vivienda/tipoVivienda.vue'),
						meta: {
						rule:'editor'
						}
					},
					//CONSTRUCTOR
					{
						path:'/vivienda/constructor',
						name: 'vivienda-constructor',
						component: () => import('./views/Viviendas/Constructor/constructor.vue'),
						meta: {
						rule:'editor'
						}
					},
					{
						path:'/ingresar/constructor',
						name: 'ingresar-constructor',
						component: () => import('./views/Viviendas/Constructor/ingresar.vue'),
						meta: {
						rule:'editor'
						}
					},
					{
						path:'/editar/constructor/:id',
						name: 'editar-constructor',
						component: () => import('./views/Viviendas/Constructor/editar.vue'),
						meta: {
						rule:'editor'
						}
					},
					{
						path:'/ver/constructor/:id',
						name: 'ver-constructor',
						component: () => import('./views/Viviendas/Constructor/ver.vue'),
						meta: {
						rule:'editor'
						}
					},
					//ABONO
					{
						path:'/vivienda/abono/:id',
						name: 'vivienda-abono',
						component: () => import('./views/Viviendas/Abono_vivienda/abonoVivienda.vue'),
						meta: {
						rule:'editor'
						}
					},
					{
						path:'/abonar/vivienda/:id',  
						name: 'abonar-vivienda',
						component: () => import('./views/Viviendas/Abono_vivienda/abonar.vue'),
						meta: {
						rule:'editor'
						}
					},
					{
						path:'/vivienda/abono',  
						name: 'abonar-viviendas',
						component: () => import('./views/Viviendas/Abono_vivienda/v_Abonar'),
						meta: {
						rule:'editor'
						}
					},
					// =============================================================================
					// Datos Generales
					// =============================================================================
					
					{
						path: '/general/escuela',
						name: 'general-escuela',
						component: () => import('./views/apadrinamientos/escuela/escuela.vue'),
						meta: {
						rule: 'admin'
						}
					},
					{
						path: '/general/sector',
						name: 'general-sector',
						component: () => import('./views/apadrinamientos/sector/sector.vue'),
						meta: {
						rule: 'admin'
						}
					},
					{
						path: '/general/aldea',
						name: 'general-aldea',
						component: () => import('./views/apadrinamientos/aldea/aldea.vue'),
						meta: {
						rule: 'admin'
						}
					},
					// =============================================================================
					// =============================================================================
					// SALUD
					// =============================================================================
					// =============================================================================
					
					// FARMACIA
					// =============================================================================
					{
						path: '/farmacia/medicamentos',
						name: 'farmacia-medicamentos',
						component: () => import('./views/Farmacia/Medicamentos/medicamentos.vue'),
						meta: {
						rule: 'admin'
						}
					},
					{
						path: '/salida/medicamentos',
						name: 'salida-medicamentos',
						component: () => import('./views/Farmacia/Medicamentos/salidamedicamentos.vue'),
						meta: {
						rule: 'admin'
						}
					},
					{
						path: '/ingreso/medicamentos',
						name: 'ingreso-medicamentos',
						component: () => import('./views/Farmacia/Medicamentos/ingresomedicamentos.vue'),
						meta: {
						rule: 'admin'
						}
					},
					{			
						path: '/ingresar/ingresomedi',
						name: 'ingresar-ingresomedi',
						component: () => import('./views/Farmacia/Medicamentos/formularioingresomedi.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/ver/salida/:id',
						name: 'ver-detalleSalida',
						component: () => import('./views/Farmacia/Medicamentos/detallesalida.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{			
						path: '/ingresar/salidamedi',
						name: 'ingresar-salidamedi',
						component: () => import('./views/Farmacia/Medicamentos/ingresarsalida.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/ver/entrada/:id',
						name: 'ver-detalleEntrada',
						component: () => import('./views/Farmacia/Medicamentos/detalleentrada.vue'),
						meta: {
							rule: 'editor'
						}
					},
					{
						path: '/farmacia/proveedores',
						name: 'farmacia-proveedores',
						component: () => import('./views/Farmacia/Proveedores/proveedores.vue'),
						meta: {
						rule: 'admin'
						}
					},
					// =============================================================================
					// PROVEEDOR
					// =============================================================================

					{
						path: '/ver/proveedor/:id',
						name: 'ver-proveedor',
						component: () => import('./views/Farmacia/Proveedores/ver.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{			
						path: '/ingresar/proveedor',
						name: 'ingresar-proveedor',
						component: () => import('./views/Farmacia/Proveedores/ingresar.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/editar/proveedor/:id',
						name: 'datos-proveedor',
						component: () => import('./views/Farmacia/Proveedores/editar.vue'),
						meta: {
						rule: 'editor'
						}
					},
					// =============================================================================
					// CASAS
					// =============================================================================

					{
						path: '/farmacia/casas',
						name: 'farmacia-casas',
						component: () => import('./views/Farmacia/Casa_medica/casaMedica.vue'),
						meta: {
						rule: 'admin'
						}
					},
					{
						path: '/farmacia/categoria',
						name: 'farmacia-categoria',
						component: () => import('./views/Farmacia/Categorias/categorias.vue'),
						meta: {
						rule: 'admin'
						}
					}, 
					// =============================================================================
					// CLINICA
					// =============================================================================
					{
						path: '/clinica/consultorio',
						//path: ['/clinica/consultorio/:id','/clinica/consultorio'],
						name: 'clinica-consultorio',
						component: () => import('./views/Clinica/Consultorio/consultorio.vue'),
						meta: {
						rule: 'admin'
						}
					}, 
					{
						path: '/clinica/pacientes',
						name: 'clinica-pacientes',
						component: () => import('./views/Clinica/Pacientes/pacientes.vue'),
						meta: {
						rule: 'admin'
						}
					}, 
					{			
						path: '/ingresar/paciente',
						name: 'ingresar-paciente',
						component: () => import('./views/Clinica/Pacientes/ingresar.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/ver/paciente/:id',
						name: 'ver-paciente',
						component: () => import('./views/Clinica/Pacientes/ver_paciente.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/editar/paciente/:id',
						name: 'editar-paciente',
						component: () => import('./views/Clinica/Pacientes/editar_paciente.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/ver/beneficios/:id',
						name: 'ver-beneficios',
						component: () => import('./views/Clinica/Pacientes/ver_beneficios.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/clinica/citas',
						name: 'clinica-citas',
						component: () => import('./views/Clinica/Citas/citas.vue'),
						meta: {
						rule: 'admin'
						}
					}, 
					{
						path: '/clinica/tipoC',
						name: 'clinica-tipoC',
						component: () => import('./views/Clinica/Tipo_cita/tipoCita.vue'),
						meta: {
						rule: 'admin'
						}
					}, 
					{
						path: '/clinica/tipoP',
						name: 'clinica-tipoP',
						component: () => import('./views/Clinica/Tipo_paciente/tipoPaciente.vue'),
						meta: {
						rule: 'admin'
						}
					},
					// =============================================================================
					// LABORATORIO
					// =============================================================================
					{
						path: '/ingresar/examen/:id',
						name: 'ingresar-examenId',
						component: () => import('./views/Laboratorio/Examenes/examenes_pre.vue'),
						meta: {
						rule: 'admin'
						}
					}, 
					{
						path: '/laboratorio/examen',
						name: 'laboratorio-listado',
						component: () => import('./views/Laboratorio/Examenes/listado.vue'),
						meta: {
						rule: 'admin'
						}
					}, 
					{
						path: '/ingresar/examen',
						name: 'ingresar-examen',
						component: () => import('./views/Laboratorio/Examenes/examenes.vue'),
						meta: {
						rule: 'admin'
						}
					}, 
					{
						path: '/laboratorio/tipo',
						name: 'laboratorio-tipo',
						component: () => import('./views/Laboratorio/Tipo_examen/tipoExamen.vue'),
						meta: {
						rule: 'admin'
						}
					}, 
					// =============================================================================
					// Rol y Usuario
					// =============================================================================
					{
						path: '/admin/roles',
						name: 'roles',
						component: () => import('./views/RolYUsuario/roles.vue'),
						meta: {
						rule: 'admin'
						}
					},
					// =============================================================================
					// Personal Medico
					// =============================================================================
					{
						path: '/clinica/PersonalMedico',
						name: 'clinica-PersonalMedico',
						component: () => import('./views/Clinica/PersonalMedico/PersonalMedico.vue'),
						meta :{
						rule : 'admin'
						}
					},
					{
						path: '/clinica/ingresarPersonal',
						name: 'clinica-ingresar-personal',
						component: () => import('./views/Clinica/PersonalMedico/ingresar.vue'),
						meta :{
						rule : 'admin'
						}
					},
					{
						path: '/clinica/editarPersonal/:id',
						name: 'clinica-editar-personal',
						component: () => import('./views/Clinica/PersonalMedico/editar.vue'),
						meta :{
						rule : 'admin'
						}
					},
					{
						path: '/clinica/verPersonal/:id',
						name: 'clinica-verPersonal',
						component: () => import('./views/Clinica/PersonalMedico/verPersonal.vue'),
						meta :{
						rule : 'admin'
						}
					},
					{
						path: '/admin/usuarios',
						name: 'usuarios',
						component: () => import('./views/RolYUsuario/Usuarios.vue'),
						meta: {
						rule: 'admin'
						}
					},
					{
						path: '/admin/nuevoUsuario',
						name: 'nuevoUsuario',
						component: () => import('./views/RolYUsuario/ingresar.vue'),
						meta: {
						rule: 'admin'
						}
					},
					{
						path: '/admin/editarUsuario/:id',
						name: 'editarUsuario',
						component: () => import('./views/RolYUsuario/editar.vue'),
						meta: {
						rule: 'admin'
						}
					},
					{
						path: '/admin/verUsuario/:id',
						name: 'verUsuario',
						component: () => import('./views/RolYUsuario/verUsuario.vue'),
						meta: {
						rule: 'admin'
						}
					},

				]
			},
			// =============================================================================
			// FULL PAGE LAYOUTS
			// =============================================================================
			{
				path: '',
				component: () => import('@/layouts/full-page/FullPage.vue'),
				children: [
					// =============================================================================
					// PAGES
					// =============================================================================
					{
						path: '/callback',
						name: 'auth-callback',
						component: () => import('@/views/Callback.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/login',
						name: 'page-login',
						component: () => import('@/views/pages/login/Login.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/register',
						name: 'page-register',
						component: () => import('@/views/pages/register/Register.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/forgot-password',
						name: 'page-forgot-password',
						component: () => import('@/views/pages/ForgotPassword.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/reset-password',
						name: 'page-reset-password',
						component: () => import('@/views/pages/ResetPassword.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/lock-screen',
						name: 'page-lock-screen',
						component: () => import('@/views/pages/LockScreen.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/comingsoon',
						name: 'page-coming-soon',
						component: () => import('@/views/pages/ComingSoon.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/error-404',
						name: 'page-error-404',
						component: () => import('@/views/pages/Error404.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/error-500',
						name: 'page-error-500',
						component: () => import('@/views/pages/Error500.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/not-authorized',
						name: 'page-not-authorized',
						component: () => import('@/views/pages/NotAuthorized.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/maintenance',
						name: 'page-maintenance',
						component: () => import('@/views/pages/Maintenance.vue'),
						meta: {
						rule: 'editor'
						}
					}
				]
			},
			// Redirect to 404 page, if no match found
			{
				path: '*',
				redirect: '/pages/error-404'
			}
		]: id == 2 ?
		[
			{
				// =============================================================================
				// MAIN LAYOUT ROUTES
				// =============================================================================
				path: '',
				component: () => import('./layouts/main/Main.vue'),
				children: 
				[
					// =============================================================================
					// Theme Routes
					// =============================================================================
					{
						path: '/',
						redirect: '/bienvenido'
					},
					{
						path: '/bienvenido',
						name: 'inicio',
						component: () => import('./views/pages/Bienvenido.vue'),
						meta: {
							rule: 'editor'
						}
					},
					{
						path: '/apadrinamiento/nino',
						name: 'apadrinamiento-nino',
						component: () => import('./views/apadrinamientos/nino/nino.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/apadrinamiento/fotografia/:id',
						name: 'apadrinamiento-fotografia',
						component: () => import('./views/apadrinamientos/fotografia/fotografia.vue'),
						meta: {
						rule: 'editor'
						}
						},
					{			
						path: '/ingresar/nino',
						name: 'ingresar-nino',
						component: () => import('./views/apadrinamientos/nino/form-ingresar.vue'),
						meta: {
							rule: 'editor'
						}
					},
					{
						path: '/editar/nino/:id',
						name: 'datos-nino',
						component: () => import('./views/apadrinamientos/nino/editNino.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/ver/nino/:id',
						name: 'ver-nino',
						component: () => import('./views/apadrinamientos/nino/verNino.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/editar/ninono/:id',
						name: 'datos-ninono',
						component: () => import('./views/apadrinamientos/nino/ninonoEdit.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/ver/ninono/:id',
						name: 'ver-ninono',
						component: () => import('./views/apadrinamientos/nino/DetallesNinono.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{			
						path: '/ingresar/familia',
						name: 'ingresar-familia',
						component: () => import('./views/apadrinamientos/familia/ingresar.vue'),
						meta: {
							rule: 'editor'
						}
					},
					{			
						path: '/editar/familia/:id',
						name: 'editar-familia',
						component: () => import('./views/apadrinamientos/familia/editar_familia.vue'),
						meta: {
							rule: 'editor'
						}
					},
					{
						path: '/apadrinamiento/ppi/:id',
						name: 'apadrinamiento-ppi',
						component: () => import('./views/apadrinamientos/nino/ppi.vue'),
						meta: {
						rule: 'editor'
						}
					},
					//////////////////ESTUDIO SOCIO
					{
						path: '/apadrinamiento/estudiosocio/:id/:estudio',
						name: 'apadrinamiento-estudiosocio',
						component: () => import('./views/apadrinamientos/familia/estudiosocio.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/apadrinamiento/estudiosocio/:id',
						name: 'apadrinamiento-estudiosocio2',
						component: () => import('./views/apadrinamientos/nino/historialestudiosocio.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/ingresar/estudiosocio/:id',
						name: 'ingresar-estudiosocio',
						component: () => import('./views/apadrinamientos/nino/nuevoestudiosocio.vue'),
						meta: {
						rule: 'admin'
						}
					},
					/////////////////// PPI
					{			
						path: '/ingresar/ppi/:id',
						name: 'ingresar-ppi',
						component: () => import('./views/apadrinamientos/nino/nuevoppi.vue'),
						meta: {
							rule: 'editor'
						}
					},		
					{			
						path: '/ver/ppi/:id',
						name: 'ver-ppi',
						component: () => import('./views/apadrinamientos/nino/verppi.vue'),
						meta: {
						rule: 'editor'
						}
					},		
					{
						path: '/ingresar/fotografia/:id',
						name: 'ingresar-fotografia',
						component: () => import('./views/apadrinamientos/fotografia/nuevafotografia.vue'),
						meta: {
						rule: 'admin'
						}
					},
					{
						path: '/apadrinamiento/ninono',
						name: 'apadrinamiento-ninono',
						component: () => import('./views/apadrinamientos/nino/ninono.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/apadrinamiento/padrino',
						name: 'apadrinamiento-padrino',
						component: () => import('./views/apadrinamientos/padrino/padrino.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/ingresar/padrino',
						name: 'ingresar-padrino',
						component: () => import('./views/apadrinamientos/padrino/formulariopadrin.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/editar/padrino/:id',
						name: 'datos-padrino',
						component: () => import('./views/apadrinamientos/padrino/formulariopadrinedit.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/apadrinamiento/apadrinamiento',
						name: 'apadrinamiento-apadrinamiento',
						component: () => import('./views/apadrinamientos/apadrinamiento/apadrinamiento.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/apadrinamiento/encargado',
						name: 'apadrinamiento-encargado',
						component: () => import('./views/apadrinamientos/familiar/familiar.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/editar/familiar/:id',
						name: 'editar-familiar',
						component: () => import('./views/apadrinamientos/familiar/editar.vue'),
						meta: {
						rule: 'editor'
						}
					},

					{			
						path: '/ver/familiar/:id',
						name: 'ver-familiar',
						component: () => import('./views/apadrinamientos/familiar/ver.vue'),
						meta: {
						rule: 'editor'
						}
					},		

					{
						path: '/ingresar/familiar',
						name: 'ingresar-familiar',
						component: () => import('./views/apadrinamientos/familiar/formulario.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/apadrinamiento/familia',
						name: 'apadrinamiento-familia',
						component: () => import('./views/apadrinamientos/familia/relacion.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/ver/familia/:id',
						name: 'ver-familia',
						component: () => import('./views/apadrinamientos/familia/ver_familia.vue'),
						meta: {
						rule: 'admin'
						}
					},
					///////////////CORRESPONDENCIA
					{
						path: '/apadrinamiento/correspondencia/:id',
						name: 'apadrinamiento-correspondencia',
						component: () => import('./views/apadrinamientos/correspondencia/correspondencia.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{			
						path: '/ingresar/correspondencia/:id',
						name: 'ingresar-correspondencia',
						component: () => import('./views/apadrinamientos/correspondencia/nuevocorrespondencia.vue'),
						meta: {
						rule: 'editor'
						}
					},		
					{			
						path: '/ver/correspondencia/:id',
						name: 'ver-correspondencia',
						component: () => import('./views/apadrinamientos/correspondencia/vercorrespondencia.vue'),
						meta: {
						rule: 'editor'
						}
					},

					// =============================================================================
					// TUTORIA
					// =============================================================================
					{
						path: '/tutoria/tutoria',
						name: 'tutoria-tutoria',
						component: () => import('./views/tutoria/tutoria.vue'),
						meta: {
						rule: 'admin'
						}
					},
					{
						path: '/tutoria/tutor',
						name: 'tutoria-tutor',
						component: () => import('./views/tutoria/tutor.vue'),
						meta: {
						rule: 'admin'
						}
					},
					{			
						path: '/ingresar/tutor',
						name: 'ingresar-tutor',
						component: () => import('./views/tutoria/ingresar.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path:'/editar/tutor/:id',
						name: 'editar-tutor',
						component: () => import('./views/tutoria/tutorEdit.vue'),
						meta: {
						rule:'editor'
						}
					},
					{
						path:'/ver/tutor/:id',
						name: 'ver-tutor',
						component: () => import('./views/tutoria/verTutor.vue'),
						meta: {
						rule:'editor'
						}
					},
					// =============================================================================
					// MICROPRESTAMO
					// =============================================================================
					{
						path:'/microprestamo/ingresar',
						name: 'microprestamo-ingresar',
						component: () => import('./views/Microprestamos/Microprestamo/nuevo_microprestamo.vue'),
						meta: {
						rule:'editor'
						}
					},
					{
						path:'/microprestamo/abono',
						name: 'microprestamo-abono',
						component: () => import('./views/Microprestamos/Abono_prestamo/abonoPrestamo.vue'),
						meta: {
						rule:'editor'
						}
					},
					{
						path: '/microprestamo/destino',
						name: 'microprestamo-destino',
						component: () => import('./views/Microprestamos/Destino_inversion/destinoInversion.vue'),
						meta: {
						rule: 'admin'
						}
					},
					{	
						path: '/microprestamo/integrante',
						name: 'microprestamo-integrante',
						component: () => import('./views/Microprestamos/Detalle_integrante/detalleIntegrante.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/microprestamo/historial/:id',
						name: 'microprestamo-historial',
						component: () => import('./views/Microprestamos/Detalle_integrante/historialPago.vue'),
						meta: {
						rule: 'admin'
						}
					},
					{
						path:'/microprestamo/grupo',
						name: 'microprestamo-grupo',
						component: () => import('./views/Microprestamos/Grupo_prestamo/grupoPrestamo.vue'),
						meta: {
						rule:'editor'
						}
					},
					{
						path:'/microprestamo/Vergrupo/:id',
						name: 'microprestamo-Vergrupo',
						component: () => import('./views/Microprestamos/Grupo_prestamo/VerGrupo.vue'),
						meta: {
						rule:'editor'
						}
					},
					{
						path:'/microprestamo/editarGrupo/:id',
						name: 'microprestamo-editarGrupo',
						component: () => import('./views/Microprestamos/Grupo_prestamo/editarGrupo.vue'),
						meta: {
						rule:'editor'
						}
					},
					{
						path:'/microprestamo/Nuevogrupo',
						name: 'microprestamo-nuevo-grupo',
						component: () => import('./views/Microprestamos/Grupo_prestamo/ingresarGrupo.vue'),
						meta: {
						rule:'editor'
						}
					},
					{
						path: '/microprestamo/microprestamo',
						name: 'microprestamo-microprestamo',
						component: () => import('./views/Microprestamos/Microprestamo/microprestamo.vue'),
						meta: {
						rule: 'admin'
						}
					},
					{
						path: '/microprestamo/Vermicroprestamo/:id',
						name: 'microprestamo-Vermicroprestamo',
						component: () => import('./views/Microprestamos/Microprestamo/verMicroprestamo.vue'),
						meta: {
						rule: 'admin'
						}
					},
					// =============================================================================
					// VIVIENDA
					// =============================================================================
					// VIVIENDA
					{
						path:'/vivienda/vivienda',
						name: 'vivienda-vivienda',
						component: () => import('./views/Viviendas/Vivienda/vivienda.vue'),
						meta: {
						rule:'editor'
						}
					},
					{
						path:'/ingresar/vivienda',
						name: 'ingresar-vivienda',
						component: () => import('./views/Viviendas/Vivienda/ingresar.vue'),
						meta: {
						rule:'editor'
						}
					},
					{
						path:'/editar/vivienda/:id',
						name: 'editar-vivienda',
						component: () => import('./views/Viviendas/Vivienda/editar.vue'),
						meta: {
						rule:'editor'
						}
					},
					{
						path:'/ver/vivienda/:id',
						name: 'ver-vivienda',
						component: () => import('./views/Viviendas/Vivienda/ver.vue'),
						meta: {
						rule:'editor'
						}
					},
					// TIPO VIVIENDA
					{
						path:'/vivienda/tipo',
						name: 'vivienda-tipo',
						component: () => import('./views/Viviendas/Tipo_vivienda/tipoVivienda.vue'),
						meta: {
						rule:'editor'
						}
					},
					//CONSTRUCTOR
					{
						path:'/vivienda/constructor',
						name: 'vivienda-constructor',
						component: () => import('./views/Viviendas/Constructor/constructor.vue'),
						meta: {
						rule:'editor'
						}
					},
					{
						path:'/ingresar/constructor',
						name: 'ingresar-constructor',
						component: () => import('./views/Viviendas/Constructor/ingresar.vue'),
						meta: {
						rule:'editor'
						}
					},
					{
						path:'/editar/constructor/:id',
						name: 'editar-constructor',
						component: () => import('./views/Viviendas/Constructor/editar.vue'),
						meta: {
						rule:'editor'
						}
					},
					{
						path:'/ver/constructor/:id',
						name: 'ver-constructor',
						component: () => import('./views/Viviendas/Constructor/ver.vue'),
						meta: {
						rule:'editor'
						}
					},
					//ABONO
					{
						path:'/vivienda/abono/:id',
						name: 'vivienda-abono',
						component: () => import('./views/Viviendas/Abono_vivienda/abonoVivienda.vue'),
						meta: {
						rule:'editor'
						}
					},
					{
						path:'/abonar/vivienda/:id',  
						name: 'abonar-vivienda',
						component: () => import('./views/Viviendas/Abono_vivienda/abonar.vue'),
						meta: {
						rule:'editor'
						}
					},
					{
						path:'/vivienda/abono',  
						name: 'abonar-viviendas',
						component: () => import('./views/Viviendas/Abono_vivienda/v_Abonar'),
						meta: {
						rule:'editor'
						}
					},
					// =============================================================================
					// Datos Generales
					// =============================================================================
					
					{
						path: '/general/escuela',
						name: 'general-escuela',
						component: () => import('./views/apadrinamientos/escuela/escuela.vue'),
						meta: {
						rule: 'admin'
						}
					},
					{
						path: '/general/sector',
						name: 'general-sector',
						component: () => import('./views/apadrinamientos/sector/sector.vue'),
						meta: {
						rule: 'admin'
						}
					},
					{
						path: '/general/aldea',
						name: 'general-aldea',
						component: () => import('./views/apadrinamientos/aldea/aldea.vue'),
						meta: {
						rule: 'admin'
						}
					},
				]
			},
			{
				path: '',
				component: () => import('@/layouts/full-page/FullPage.vue'),
				children: [
					// =============================================================================
					// PAGES
					// =============================================================================
					{
						path: '/callback',
						name: 'auth-callback',
						component: () => import('@/views/Callback.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/login',
						name: 'page-login',
						component: () => import('@/views/pages/login/Login.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/register',
						name: 'page-register',
						component: () => import('@/views/pages/register/Register.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/forgot-password',
						name: 'page-forgot-password',
						component: () => import('@/views/pages/ForgotPassword.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/reset-password',
						name: 'page-reset-password',
						component: () => import('@/views/pages/ResetPassword.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/lock-screen',
						name: 'page-lock-screen',
						component: () => import('@/views/pages/LockScreen.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/comingsoon',
						name: 'page-coming-soon',
						component: () => import('@/views/pages/ComingSoon.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/error-404',
						name: 'page-error-404',
						component: () => import('@/views/pages/Error404.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/error-500',
						name: 'page-error-500',
						component: () => import('@/views/pages/Error500.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/not-authorized',
						name: 'page-not-authorized',
						component: () => import('@/views/pages/NotAuthorized.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/maintenance',
						name: 'page-maintenance',
						component: () => import('@/views/pages/Maintenance.vue'),
						meta: {
						rule: 'editor'
						}
					}
				]
			},
			// Redirect to 404 page, if no match found
			{
				path: '*',
				redirect: '/pages/error-404'
			}
		]: id == 3 ?
		[
			{
				path: '/',
				redirect: '/bienvenido'
			},
			{
				path: '',
				component: () => import('./layouts/main/Main.vue'),
				children: 
				[
					{
						path: '/',
						redirect: '/bienvenido'
					},
					{
						path: '/bienvenido',
						name: 'inicio',
						component: () => import('./views/pages/Bienvenido.vue'),
						meta: {
							rule: 'editor'
						}
					},
					// =============================================================================
					// MICROPRESTAMO
					// =============================================================================
					{
						path:'/microprestamo/ingresar',
						name: 'microprestamo-ingresar',
						component: () => import('./views/Microprestamos/Microprestamo/nuevo_microprestamo.vue'),
						meta: {
						rule:'editor'
						}
					},
					{
						path:'/microprestamo/abono',
						name: 'microprestamo-abono',
						component: () => import('./views/Microprestamos/Abono_prestamo/abonoPrestamo.vue'),
						meta: {
						rule:'editor'
						}
					},
					{
						path: '/microprestamo/destino',
						name: 'microprestamo-destino',
						component: () => import('./views/Microprestamos/Destino_inversion/destinoInversion.vue'),
						meta: {
						rule: 'admin'
						}
					},
					{	
						path: '/microprestamo/integrante',
						name: 'microprestamo-integrante',
						component: () => import('./views/Microprestamos/Detalle_integrante/detalleIntegrante.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/microprestamo/historial/:id',
						name: 'microprestamo-historial',
						component: () => import('./views/Microprestamos/Detalle_integrante/historialPago.vue'),
						meta: {
						rule: 'admin'
						}
					},
					{
						path:'/microprestamo/grupo',
						name: 'microprestamo-grupo',
						component: () => import('./views/Microprestamos/Grupo_prestamo/grupoPrestamo.vue'),
						meta: {
						rule:'editor'
						}
					},
					{
						path:'/microprestamo/Vergrupo/:id',
						name: 'microprestamo-Vergrupo',
						component: () => import('./views/Microprestamos/Grupo_prestamo/VerGrupo.vue'),
						meta: {
						rule:'editor'
						}
					},
					{
						path:'/microprestamo/editarGrupo/:id',
						name: 'microprestamo-editarGrupo',
						component: () => import('./views/Microprestamos/Grupo_prestamo/editarGrupo.vue'),
						meta: {
						rule:'editor'
						}
					},
					{
						path:'/microprestamo/Nuevogrupo',
						name: 'microprestamo-nuevo-grupo',
						component: () => import('./views/Microprestamos/Grupo_prestamo/ingresarGrupo.vue'),
						meta: {
						rule:'editor'
						}
					},
					{
						path: '/microprestamo/microprestamo',
						name: 'microprestamo-microprestamo',
						component: () => import('./views/Microprestamos/Microprestamo/microprestamo.vue'),
						meta: {
						rule: 'admin'
						}
					},
					{
						path: '/microprestamo/Vermicroprestamo/:id',
						name: 'microprestamo-Vermicroprestamo',
						component: () => import('./views/Microprestamos/Microprestamo/verMicroprestamo.vue'),
						meta: {
						rule: 'admin'
						}
					},
					// =============================================================================
					// VIVIENDA
					// =============================================================================
					// VIVIENDA
					{
						path:'/vivienda/vivienda',
						name: 'vivienda-vivienda',
						component: () => import('./views/Viviendas/Vivienda/vivienda.vue'),
						meta: {
						rule:'editor'
						}
					},
					{
						path:'/ingresar/vivienda',
						name: 'ingresar-vivienda',
						component: () => import('./views/Viviendas/Vivienda/ingresar.vue'),
						meta: {
						rule:'editor'
						}
					},
					{
						path:'/editar/vivienda/:id',
						name: 'editar-vivienda',
						component: () => import('./views/Viviendas/Vivienda/editar.vue'),
						meta: {
						rule:'editor'
						}
					},
					{
						path:'/ver/vivienda/:id',
						name: 'ver-vivienda',
						component: () => import('./views/Viviendas/Vivienda/ver.vue'),
						meta: {
						rule:'editor'
						}
					},
					// TIPO VIVIENDA
					{
						path:'/vivienda/tipo',
						name: 'vivienda-tipo',
						component: () => import('./views/Viviendas/Tipo_vivienda/tipoVivienda.vue'),
						meta: {
						rule:'editor'
						}
					},
					//CONSTRUCTOR
					{
						path:'/vivienda/constructor',
						name: 'vivienda-constructor',
						component: () => import('./views/Viviendas/Constructor/constructor.vue'),
						meta: {
						rule:'editor'
						}
					},
					{
						path:'/ingresar/constructor',
						name: 'ingresar-constructor',
						component: () => import('./views/Viviendas/Constructor/ingresar.vue'),
						meta: {
						rule:'editor'
						}
					},
					{
						path:'/editar/constructor/:id',
						name: 'editar-constructor',
						component: () => import('./views/Viviendas/Constructor/editar.vue'),
						meta: {
						rule:'editor'
						}
					},
					{
						path:'/ver/constructor/:id',
						name: 'ver-constructor',
						component: () => import('./views/Viviendas/Constructor/ver.vue'),
						meta: {
						rule:'editor'
						}
					},
					//ABONO
					{
						path:'/vivienda/abono/:id',
						name: 'vivienda-abono',
						component: () => import('./views/Viviendas/Abono_vivienda/abonoVivienda.vue'),
						meta: {
						rule:'editor'
						}
					},
					{
						path:'/abonar/vivienda/:id',  
						name: 'abonar-vivienda',
						component: () => import('./views/Viviendas/Abono_vivienda/abonar.vue'),
						meta: {
						rule:'editor'
						}
					},
					{
						path:'/vivienda/abono',  
						name: 'abonar-viviendas',
						component: () => import('./views/Viviendas/Abono_vivienda/v_Abonar'),
						meta: {
						rule:'editor'
						}
					},
					// =============================================================================
					// Datos Generales
					// =============================================================================
					
					{
						path: '/general/escuela',
						name: 'general-escuela',
						component: () => import('./views/apadrinamientos/escuela/escuela.vue'),
						meta: {
						rule: 'admin'
						}
					},
					{
						path: '/general/sector',
						name: 'general-sector',
						component: () => import('./views/apadrinamientos/sector/sector.vue'),
						meta: {
						rule: 'admin'
						}
					},
					{
						path: '/general/aldea',
						name: 'general-aldea',
						component: () => import('./views/apadrinamientos/aldea/aldea.vue'),
						meta: {
						rule: 'admin'
						}
					},
				]
			},
			{
				path: '',
				component: () => import('@/layouts/full-page/FullPage.vue'),
				children: [
					// =============================================================================
					// PAGES
					// =============================================================================
					{
						path: '/callback',
						name: 'auth-callback',
						component: () => import('@/views/Callback.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/login',
						name: 'page-login',
						component: () => import('@/views/pages/login/Login.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/register',
						name: 'page-register',
						component: () => import('@/views/pages/register/Register.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/forgot-password',
						name: 'page-forgot-password',
						component: () => import('@/views/pages/ForgotPassword.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/reset-password',
						name: 'page-reset-password',
						component: () => import('@/views/pages/ResetPassword.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/lock-screen',
						name: 'page-lock-screen',
						component: () => import('@/views/pages/LockScreen.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/comingsoon',
						name: 'page-coming-soon',
						component: () => import('@/views/pages/ComingSoon.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/error-404',
						name: 'page-error-404',
						component: () => import('@/views/pages/Error404.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/error-500',
						name: 'page-error-500',
						component: () => import('@/views/pages/Error500.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/not-authorized',
						name: 'page-not-authorized',
						component: () => import('@/views/pages/NotAuthorized.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/maintenance',
						name: 'page-maintenance',
						component: () => import('@/views/pages/Maintenance.vue'),
						meta: {
						rule: 'editor'
						}
					}
				]
			},
			// Redirect to 404 page, if no match found
			{
				path: '*',
				redirect: '/pages/error-404'
			}
		]: id == 4 ?
		[
			{
				path: '',
				component: () => import('./layouts/main/Main.vue'),
				children: 
				[
					{
						path: '/',
						redirect: '/bienvenido'
					},
					{
						path: '/bienvenido',
						name: 'inicio',
						component: () => import('./views/pages/Bienvenido.vue'),
						meta: {
							rule: 'editor'
						}
					},
					// =============================================================================
					// TUTORIA
					// =============================================================================
					{
						path: '/tutoria/tutoria',
						name: 'tutoria-tutoria',
						component: () => import('./views/tutoria/tutoria.vue'),
						meta: {
						rule: 'admin'
						}
					},
					{
						path: '/tutoria/tutor',
						name: 'tutoria-tutor',
						component: () => import('./views/tutoria/tutor.vue'),
						meta: {
						rule: 'admin'
						}
					},
					{			
						path: '/ingresar/tutor',
						name: 'ingresar-tutor',
						component: () => import('./views/tutoria/ingresar.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path:'/editar/tutor/:id',
						name: 'editar-tutor',
						component: () => import('./views/tutoria/tutorEdit.vue'),
						meta: {
						rule:'editor'
						}
					},
					{
						path:'/ver/tutor/:id',
						name: 'ver-tutor',
						component: () => import('./views/tutoria/verTutor.vue'),
						meta: {
						rule:'editor'
						}
					},
					// =============================================================================
					// Datos Generales
					// =============================================================================
					{
						path: '/general/escuela',
						name: 'general-escuela',
						component: () => import('./views/apadrinamientos/escuela/escuela.vue'),
						meta: {
						rule: 'admin'
						}
					},
					{
						path: '/general/sector',
						name: 'general-sector',
						component: () => import('./views/apadrinamientos/sector/sector.vue'),
						meta: {
						rule: 'admin'
						}
					},
					{
						path: '/general/aldea',
						name: 'general-aldea',
						component: () => import('./views/apadrinamientos/aldea/aldea.vue'),
						meta: {
						rule: 'admin'
						}
					},
				]
			},
			{
				path: '',
				component: () => import('@/layouts/full-page/FullPage.vue'),
				children: [
					// =============================================================================
					// PAGES
					// =============================================================================
					{
						path: '/callback',
						name: 'auth-callback',
						component: () => import('@/views/Callback.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/login',
						name: 'page-login',
						component: () => import('@/views/pages/login/Login.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/register',
						name: 'page-register',
						component: () => import('@/views/pages/register/Register.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/forgot-password',
						name: 'page-forgot-password',
						component: () => import('@/views/pages/ForgotPassword.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/reset-password',
						name: 'page-reset-password',
						component: () => import('@/views/pages/ResetPassword.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/lock-screen',
						name: 'page-lock-screen',
						component: () => import('@/views/pages/LockScreen.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/comingsoon',
						name: 'page-coming-soon',
						component: () => import('@/views/pages/ComingSoon.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/error-404',
						name: 'page-error-404',
						component: () => import('@/views/pages/Error404.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/error-500',
						name: 'page-error-500',
						component: () => import('@/views/pages/Error500.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/not-authorized',
						name: 'page-not-authorized',
						component: () => import('@/views/pages/NotAuthorized.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/maintenance',
						name: 'page-maintenance',
						component: () => import('@/views/pages/Maintenance.vue'),
						meta: {
						rule: 'editor'
						}
					}
				]
			},
			// Redirect to 404 page, if no match found
			{
				path: '*',
				redirect: '/pages/error-404'
			}
		]: id == 5 ?
		[
			{
				path: '',
				component: () => import('./layouts/main/Main.vue'),
				children: 
				[
					{
						path: '/',
						redirect: '/bienvenido'
					},
					{
						path: '/bienvenido',
						name: 'inicio',
						component: () => import('./views/pages/Bienvenido.vue'),
						meta: {
							rule: 'editor'
						}
					},
					// =============================================================================
					// CLINICA
					// =============================================================================
					{
						path: '/clinica/consultorio',
						//path: ['/clinica/consultorio/:id','/clinica/consultorio'],
						name: 'clinica-consultorio',
						component: () => import('./views/Clinica/Consultorio/consultorio.vue'),
						meta: {
						rule: 'admin'
						}
					}, 
					{
						path: '/clinica/pacientes',
						name: 'clinica-pacientes',
						component: () => import('./views/Clinica/Pacientes/pacientes.vue'),
						meta: {
						rule: 'admin'
						}
					}, 
					{			
						path: '/ingresar/paciente',
						name: 'ingresar-paciente',
						component: () => import('./views/Clinica/Pacientes/ingresar.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/ver/paciente/:id',
						name: 'ver-paciente',
						component: () => import('./views/Clinica/Pacientes/ver_paciente.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/editar/paciente/:id',
						name: 'editar-paciente',
						component: () => import('./views/Clinica/Pacientes/editar_paciente.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/ver/beneficios/:id',
						name: 'ver-beneficios',
						component: () => import('./views/Clinica/Pacientes/ver_beneficios.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/clinica/citas',
						name: 'clinica-citas',
						component: () => import('./views/Clinica/Citas/citas.vue'),
						meta: {
						rule: 'admin'
						}
					}, 
					{
						path: '/clinica/tipoC',
						name: 'clinica-tipoC',
						component: () => import('./views/Clinica/Tipo_cita/tipoCita.vue'),
						meta: {
						rule: 'admin'
						}
					}, 
					{
						path: '/clinica/tipoP',
						name: 'clinica-tipoP',
						component: () => import('./views/Clinica/Tipo_paciente/tipoPaciente.vue'),
						meta: {
						rule: 'admin'
						}
					}, 
					// =============================================================================
					// LABORATORIO
					// =============================================================================
					{
						path: '/ingresar/examen/:id',
						name: 'ingresar-examenId',
						component: () => import('./views/Laboratorio/Examenes/examenes_pre.vue'),
						meta: {
						rule: 'admin'
						}
					}, 
					{
						path: '/laboratorio/examen',
						name: 'laboratorio-listado',
						component: () => import('./views/Laboratorio/Examenes/listado.vue'),
						meta: {
						rule: 'admin'
						}
					}, 
					{
						path: '/laboratorio/examen',
						name: 'laboratorio-examen',
						component: () => import('./views/Laboratorio/Examenes/examenes.vue'),
						meta: {
						rule: 'admin'
						}
					}, 
					{
						path: '/laboratorio/tipo',
						name: 'laboratorio-tipo',
						component: () => import('./views/Laboratorio/Tipo_examen/tipoExamen.vue'),
						meta: {
						rule: 'admin'
						}
					}, 
				]
			},
			{
				path: '',
				component: () => import('@/layouts/full-page/FullPage.vue'),
				children: [
					// =============================================================================
					// PAGES
					// =============================================================================
					{
						path: '/callback',
						name: 'auth-callback',
						component: () => import('@/views/Callback.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/login',
						name: 'page-login',
						component: () => import('@/views/pages/login/Login.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/register',
						name: 'page-register',
						component: () => import('@/views/pages/register/Register.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/forgot-password',
						name: 'page-forgot-password',
						component: () => import('@/views/pages/ForgotPassword.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/reset-password',
						name: 'page-reset-password',
						component: () => import('@/views/pages/ResetPassword.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/lock-screen',
						name: 'page-lock-screen',
						component: () => import('@/views/pages/LockScreen.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/comingsoon',
						name: 'page-coming-soon',
						component: () => import('@/views/pages/ComingSoon.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/error-404',
						name: 'page-error-404',
						component: () => import('@/views/pages/Error404.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/error-500',
						name: 'page-error-500',
						component: () => import('@/views/pages/Error500.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/not-authorized',
						name: 'page-not-authorized',
						component: () => import('@/views/pages/NotAuthorized.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/maintenance',
						name: 'page-maintenance',
						component: () => import('@/views/pages/Maintenance.vue'),
						meta: {
						rule: 'editor'
						}
					}
				]
			},
			// Redirect to 404 page, if no match found
			{
				path: '*',
				redirect: '/pages/error-404'
			}
		]: id == 6 ?
		[
			{
				path: '',
				component: () => import('./layouts/main/Main.vue'),
				children: 
				[
					{
						path: '/',
						redirect: '/bienvenido'
					},
					{
						path: '/bienvenido',
						name: 'inicio',
						component: () => import('./views/pages/Bienvenido.vue'),
						meta: {
							rule: 'editor'
						}
					},
					// =============================================================================
					// FARMACIA
					// =============================================================================
					{
						path: '/farmacia/medicamentos',
						name: 'farmacia-medicamentos',
						component: () => import('./views/Farmacia/Medicamentos/medicamentos.vue'),
						meta: {
						rule: 'admin'
						}
					},
					{
						path: '/salida/medicamentos',
						name: 'salida-medicamentos',
						component: () => import('./views/Farmacia/Medicamentos/salidamedicamentos.vue'),
						meta: {
						rule: 'admin'
						}
					},
					{
						path: '/ingreso/medicamentos',
						name: 'ingreso-medicamentos',
						component: () => import('./views/Farmacia/Medicamentos/ingresomedicamentos.vue'),
						meta: {
						rule: 'admin'
						}
					},
					{			
						path: '/ingresar/ingresomedi',
						name: 'ingresar-ingresomedi',
						component: () => import('./views/Farmacia/Medicamentos/formularioingresomedi.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/ver/salida/:id',
						name: 'ver-detalleSalida',
						component: () => import('./views/Farmacia/Medicamentos/detallesalida.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{			
						path: '/ingresar/salidamedi',
						name: 'ingresar-salidamedi',
						component: () => import('./views/Farmacia/Medicamentos/ingresarsalida.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/ver/entrada/:id',
						name: 'ver-detalleEntrada',
						component: () => import('./views/Farmacia/Medicamentos/detalleentrada.vue'),
						meta: {
							rule: 'editor'
						}
					},
					{
						path: '/farmacia/proveedores',
						name: 'farmacia-proveedores',
						component: () => import('./views/Farmacia/Proveedores/proveedores.vue'),
						meta: {
						rule: 'admin'
						}
					},
					// =============================================================================
					// PROVEEDOR
					// =============================================================================

					{
						path: '/ver/proveedor/:id',
						name: 'ver-proveedor',
						component: () => import('./views/Farmacia/Proveedores/ver.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{			
						path: '/ingresar/proveedor',
						name: 'ingresar-proveedor',
						component: () => import('./views/Farmacia/Proveedores/ingresar.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/editar/proveedor/:id',
						name: 'datos-proveedor',
						component: () => import('./views/Farmacia/Proveedores/editar.vue'),
						meta: {
						rule: 'editor'
						}
					},
					// =============================================================================
					// CASAS
					// =============================================================================

					{
						path: '/farmacia/casas',
						name: 'farmacia-casas',
						component: () => import('./views/Farmacia/Casa_medica/casaMedica.vue'),
						meta: {
						rule: 'admin'
						}
					},
					{
						path: '/farmacia/categoria',
						name: 'farmacia-categoria',
						component: () => import('./views/Farmacia/Categorias/categorias.vue'),
						meta: {
						rule: 'admin'
						}
					}, 

				]
			},
			{
				path: '',
				component: () => import('@/layouts/full-page/FullPage.vue'),
				children: [
					// =============================================================================
					// PAGES
					// =============================================================================
					{
						path: '/callback',
						name: 'auth-callback',
						component: () => import('@/views/Callback.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/login',
						name: 'page-login',
						component: () => import('@/views/pages/login/Login.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/register',
						name: 'page-register',
						component: () => import('@/views/pages/register/Register.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/forgot-password',
						name: 'page-forgot-password',
						component: () => import('@/views/pages/ForgotPassword.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/reset-password',
						name: 'page-reset-password',
						component: () => import('@/views/pages/ResetPassword.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/lock-screen',
						name: 'page-lock-screen',
						component: () => import('@/views/pages/LockScreen.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/comingsoon',
						name: 'page-coming-soon',
						component: () => import('@/views/pages/ComingSoon.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/error-404',
						name: 'page-error-404',
						component: () => import('@/views/pages/Error404.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/error-500',
						name: 'page-error-500',
						component: () => import('@/views/pages/Error500.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/not-authorized',
						name: 'page-not-authorized',
						component: () => import('@/views/pages/NotAuthorized.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/maintenance',
						name: 'page-maintenance',
						component: () => import('@/views/pages/Maintenance.vue'),
						meta: {
						rule: 'editor'
						}
					}
				]
			},
			// Redirect to 404 page, if no match found
			{
				path: '*',
				redirect: '/pages/error-404'
			}
		]: id == 7 ?
		[
			{
				path: '/',
				redirect: '/bienvenido'
			},
			{
				path: '',
				component: () => import('./layouts/main/Main.vue'),
				children: 
				[
					{
						path: '/',
						redirect: '/bienvenido'
					},
					{
						path: '/bienvenido',
						name: 'inicio',
						component: () => import('./views/pages/Bienvenido.vue'),
						meta: {
							rule: 'editor'
						}
					},
					// =============================================================================
					// =============================================================================
					// SALUD
					// =============================================================================
					// =============================================================================
					
					// FARMACIA
					// =============================================================================
					{
						path: '/farmacia/medicamentos',
						name: 'farmacia-medicamentos',
						component: () => import('./views/Farmacia/Medicamentos/medicamentos.vue'),
						meta: {
						rule: 'admin'
						}
					},
					{
						path: '/salida/medicamentos',
						name: 'salida-medicamentos',
						component: () => import('./views/Farmacia/Medicamentos/salidamedicamentos.vue'),
						meta: {
						rule: 'admin'
						}
					},
					{
						path: '/ingreso/medicamentos',
						name: 'ingreso-medicamentos',
						component: () => import('./views/Farmacia/Medicamentos/ingresomedicamentos.vue'),
						meta: {
						rule: 'admin'
						}
					},
					{			
						path: '/ingresar/ingresomedi',
						name: 'ingresar-ingresomedi',
						component: () => import('./views/Farmacia/Medicamentos/formularioingresomedi.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/ver/salida/:id',
						name: 'ver-detalleSalida',
						component: () => import('./views/Farmacia/Medicamentos/detallesalida.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{			
						path: '/ingresar/salidamedi',
						name: 'ingresar-salidamedi',
						component: () => import('./views/Farmacia/Medicamentos/ingresarsalida.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/ver/entrada/:id',
						name: 'ver-detalleEntrada',
						component: () => import('./views/Farmacia/Medicamentos/detalleentrada.vue'),
						meta: {
							rule: 'editor'
						}
					},
					{
						path: '/farmacia/proveedores',
						name: 'farmacia-proveedores',
						component: () => import('./views/Farmacia/Proveedores/proveedores.vue'),
						meta: {
						rule: 'admin'
						}
					},
					// =============================================================================
					// PROVEEDOR
					// =============================================================================

					{
						path: '/ver/proveedor/:id',
						name: 'ver-proveedor',
						component: () => import('./views/Farmacia/Proveedores/ver.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{			
						path: '/ingresar/proveedor',
						name: 'ingresar-proveedor',
						component: () => import('./views/Farmacia/Proveedores/ingresar.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/editar/proveedor/:id',
						name: 'datos-proveedor',
						component: () => import('./views/Farmacia/Proveedores/editar.vue'),
						meta: {
						rule: 'editor'
						}
					},
					// =============================================================================
					// CASAS
					// =============================================================================

					{
						path: '/farmacia/casas',
						name: 'farmacia-casas',
						component: () => import('./views/Farmacia/Casa_medica/casaMedica.vue'),
						meta: {
						rule: 'admin'
						}
					},
					{
						path: '/farmacia/categoria',
						name: 'farmacia-categoria',
						component: () => import('./views/Farmacia/Categorias/categorias.vue'),
						meta: {
						rule: 'admin'
						}
					}, 
					// =============================================================================
					// CLINICA
					// =============================================================================
					{
						path: '/clinica/consultorio',
						//path: ['/clinica/consultorio/:id','/clinica/consultorio'],
						name: 'clinica-consultorio',
						component: () => import('./views/Clinica/Consultorio/consultorio.vue'),
						meta: {
						rule: 'admin'
						}
					}, 
					{
						path: '/clinica/pacientes',
						name: 'clinica-pacientes',
						component: () => import('./views/Clinica/Pacientes/pacientes.vue'),
						meta: {
						rule: 'admin'
						}
					}, 
					{			
						path: '/ingresar/paciente',
						name: 'ingresar-paciente',
						component: () => import('./views/Clinica/Pacientes/ingresar.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/ver/paciente/:id',
						name: 'ver-paciente',
						component: () => import('./views/Clinica/Pacientes/ver_paciente.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/editar/paciente/:id',
						name: 'editar-paciente',
						component: () => import('./views/Clinica/Pacientes/editar_paciente.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/ver/beneficios/:id',
						name: 'ver-beneficios',
						component: () => import('./views/Clinica/Pacientes/ver_beneficios.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/clinica/citas',
						name: 'clinica-citas',
						component: () => import('./views/Clinica/Citas/citas.vue'),
						meta: {
						rule: 'admin'
						}
					}, 
					{
						path: '/clinica/tipoC',
						name: 'clinica-tipoC',
						component: () => import('./views/Clinica/Tipo_cita/tipoCita.vue'),
						meta: {
						rule: 'admin'
						}
					}, 
					{
						path: '/clinica/tipoP',
						name: 'clinica-tipoP',
						component: () => import('./views/Clinica/Tipo_paciente/tipoPaciente.vue'),
						meta: {
						rule: 'admin'
						}
					}, 
					// =============================================================================
					// Personal Medico
					// =============================================================================
					{
						path: '/clinica/PersonalMedico',
						name: 'clinica-PersonalMedico',
						component: () => import('./views/Clinica/PersonalMedico/PersonalMedico.vue'),
						meta :{
						rule : 'admin'
						}
					},
					{
						path: '/clinica/ingresarPersonal',
						name: 'clinica-ingresar-personal',
						component: () => import('./views/Clinica/PersonalMedico/ingresar.vue'),
						meta :{
						rule : 'admin'
						}
					},
					{
						path: '/clinica/editarPersonal/:id',
						name: 'clinica-editar-personal',
						component: () => import('./views/Clinica/PersonalMedico/editar.vue'),
						meta :{
						rule : 'admin'
						}
					},
					{
						path: '/clinica/verPersonal/:id',
						name: 'clinica-verPersonal',
						component: () => import('./views/Clinica/PersonalMedico/verPersonal.vue'),
						meta :{
						rule : 'admin'
						}
					},
					// =============================================================================
					// LABORATORIO
					// =============================================================================
					{
						path: '/ingresar/examen/:id',
						name: 'ingresar-examenId',
						component: () => import('./views/Laboratorio/Examenes/examenes_pre.vue'),
						meta: {
						rule: 'admin'
						}
					}, 
					{
						path: '/laboratorio/examen',
						name: 'laboratorio-listado',
						component: () => import('./views/Laboratorio/Examenes/listado.vue'),
						meta: {
						rule: 'admin'
						}
					}, 
					{
						path: '/laboratorio/examen',
						name: 'laboratorio-examen',
						component: () => import('./views/Laboratorio/Examenes/examenes.vue'),
						meta: {
						rule: 'admin'
						}
					}, 
					{
						path: '/laboratorio/tipo',
						name: 'laboratorio-tipo',
						component: () => import('./views/Laboratorio/Tipo_examen/tipoExamen.vue'),
						meta: {
						rule: 'admin'
						}
					},
				]
			},
			{
				path: '',
				component: () => import('@/layouts/full-page/FullPage.vue'),
				children: [
					// =============================================================================
					// PAGES
					// =============================================================================
					{
						path: '/callback',
						name: 'auth-callback',
						component: () => import('@/views/Callback.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/login',
						name: 'page-login',
						component: () => import('@/views/pages/login/Login.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/register',
						name: 'page-register',
						component: () => import('@/views/pages/register/Register.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/forgot-password',
						name: 'page-forgot-password',
						component: () => import('@/views/pages/ForgotPassword.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/reset-password',
						name: 'page-reset-password',
						component: () => import('@/views/pages/ResetPassword.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/lock-screen',
						name: 'page-lock-screen',
						component: () => import('@/views/pages/LockScreen.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/comingsoon',
						name: 'page-coming-soon',
						component: () => import('@/views/pages/ComingSoon.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/error-404',
						name: 'page-error-404',
						component: () => import('@/views/pages/Error404.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/error-500',
						name: 'page-error-500',
						component: () => import('@/views/pages/Error500.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/not-authorized',
						name: 'page-not-authorized',
						component: () => import('@/views/pages/NotAuthorized.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/maintenance',
						name: 'page-maintenance',
						component: () => import('@/views/pages/Maintenance.vue'),
						meta: {
						rule: 'editor'
						}
					}
				]
			},
			// Redirect to 404 page, if no match found
			{
				path: '*',
				redirect: '/pages/error-404'
			}
		]:[
			{
				path: '/',
				redirect: '/pages/login'
			},
			{
				path: '',
				component: () => import('@/layouts/full-page/FullPage.vue'),
				children: [
					// =============================================================================
					// PAGES
					// =============================================================================
					{
						path: '/callback',
						name: 'auth-callback',
						component: () => import('@/views/Callback.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/login',
						name: 'page-login',
						component: () => import('@/views/pages/login/Login.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/register',
						name: 'page-register',
						component: () => import('@/views/pages/register/Register.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/forgot-password',
						name: 'page-forgot-password',
						component: () => import('@/views/pages/ForgotPassword.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/reset-password',
						name: 'page-reset-password',
						component: () => import('@/views/pages/ResetPassword.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/lock-screen',
						name: 'page-lock-screen',
						component: () => import('@/views/pages/LockScreen.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/comingsoon',
						name: 'page-coming-soon',
						component: () => import('@/views/pages/ComingSoon.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/error-404',
						name: 'page-error-404',
						component: () => import('@/views/pages/Error404.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/error-500',
						name: 'page-error-500',
						component: () => import('@/views/pages/Error500.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/not-authorized',
						name: 'page-not-authorized',
						component: () => import('@/views/pages/NotAuthorized.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/maintenance',
						name: 'page-maintenance',
						component: () => import('@/views/pages/Maintenance.vue'),
						meta: {
						rule: 'editor'
						}
					}
				]
			},
			// Redirect to 404 page, if no match found
			{
				path: '*',
				redirect: '/pages/error-404'
			}
		]
})

router.afterEach(() => {
	// Remove initial loading
	const appLoading = document.getElementById('loading-bg')
	if (appLoading) {
	appLoading.style.display = 'none'
	}
})

router.beforeEach((to, from, next) => {
	firebase.auth().onAuthStateChanged(() => {

	// get firebase current user
	const firebaseCurrentUser = firebase.auth().currentUser

	// if (
	//     to.path === "/pages/login" ||
	//     to.path === "/pages/forgot-password" ||
	//     to.path === "/pages/error-404" ||
	//     to.path === "/pages/error-500" ||
	//     to.path === "/pages/register" ||
	//     to.path === "/callback" ||
	//     to.path === "/pages/comingsoon" ||
	//     (auth.isAuthenticated() || firebaseCurrentUser)
	// ) {
	//     return next();
	// }

	// If auth required, check login. If login fails redirect to login page
	if (to.meta.authRequired) {
		if (!(auth.isAuthenticated() || firebaseCurrentUser)) {
		router.push({ path: '/pages/login', query: { to: to.path } })
		}
	}

	return next()
	// Specify the current path as the customState parameter, meaning it
	// will be returned to the application after auth
	// auth.login({ target: to.path });

	})
})

export default router
