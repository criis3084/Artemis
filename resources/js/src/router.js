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

const router = new Router({
  mode: 'history',
  base: '/',
  scrollBehavior () {
    return { x: 0, y: 0 }
  },
  routes: [

    {
    // =============================================================================
    // MAIN LAYOUT ROUTES
    // =============================================================================
      path: '',
      component: () => import('./layouts/main/Main.vue'),
      children: [
        // =============================================================================
        // Theme Routes
        // =============================================================================
        {
          path: '/',
          redirect: '/apadrinamiento/nino'
        },
        {
          path: '/apadrinamiento/nino',
          name: 'apadrinamiento-nino',
          component: () => import('./views/apadrinamientos/nino.vue'),
          meta: {
            rule: 'editor'
          }
        },
        {
          path: '/apadrinamiento/fotografia/:id',
          name: 'apadrinamiento-fotografia',
          component: () => import('./views/apadrinamientos/fotografia.vue'),
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
          component: () => import('./views/apadrinamientos/ninonoEdit.vue'),
          meta: {
            rule: 'editor'
          }
        },
        {
          path: '/ver/ninono/:id',
          name: 'ver-ninono',
          component: () => import('./views/apadrinamientos/DetallesNinono.vue'),
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
          name: 'apadrinamiento-estudiosocio',
          component: () => import('./views/apadrinamientos/nino/historialestudiosocio.vue'),
          meta: {
            rule: 'editor'
          }
        },
        {
          path: '/ver/estudiosocio/:id',
          name: 'ver-estudiosocio',
          component: () => import('./views/apadrinamientos/nino/verestudiosocio.vue'),
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
          component: () => import('./views/apadrinamientos/nuevafotografia.vue'),
          meta: {
            rule: 'admin'
          }
        },
        {
          path: '/apadrinamiento/ninono',
          name: 'apadrinamiento-ninono',
          component: () => import('./views/apadrinamientos/ninono.vue'),
          meta: {
            rule: 'editor'
          }
        },
        {
          path: '/apadrinamiento/padrino',
          name: 'apadrinamiento-padrino',
          component: () => import('./views/apadrinamientos/padrino.vue'),
          meta: {
            rule: 'editor'
          }
        },
        {
          path: '/ingresar/padrino',
          name: 'datos-padrino',
          component: () => import('./views/apadrinamientos/formulariopadrin.vue'),
          meta: {
            rule: 'editor'
          }
        },
        {
          path: '/editar/padrino/:id',
          name: 'datos-padrino',
          component: () => import('./views/apadrinamientos/formulariopadrinedit.vue'),
          meta: {
            rule: 'editor'
          }
        },
        {
          path: '/apadrinamiento/apadrinamiento',
          name: 'apadrinamiento-apadrinamiento',
          component: () => import('./views/apadrinamientos/apadrinamiento.vue'),
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
          name: 'datos-familiar',
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
          name: 'datos-familiar',
          component: () => import('./views/apadrinamientos/familiar/formulario.vue'),
          meta: {
            rule: 'editor'
          }
        },
        {
          path: '/apadrinamiento/familia',
          name: 'apadrinamiento-familia',
          component: () => import('./views/apadrinamientos/relacion.vue'),
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
        
        {
          path: '/dashboard/ecommerce',
          name: 'dashboard-ecommerce',
          component: () => import('./views/DashboardECommerce.vue'),
          meta: {
            rule: 'admin'
          }
        },
        ///////////////CORRESPONDENCIA
        {
          path: '/apadrinamiento/correspondencia/:id',
          name: 'apadrinamiento-correspondencia',
          component: () => import('./views/apadrinamientos/nino/correspondencia.vue'),
          meta: {
            rule: 'editor'
          }
        },
        {			
          path: '/ingresar/correspondencia/:id',
          name: 'ingresar-correspondencia',
          component: () => import('./views/apadrinamientos/nino/nuevocorrespondencia.vue'),
          meta: {
            rule: 'editor'
          }
        },		
        {			
          path: '/ver/correspondencia/:id',
          name: 'ver-correspondencia',
          component: () => import('./views/apadrinamientos/nino/vercorrespondencia.vue'),
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
          component: () => import('./views/Microprestamos/microprestamo/nuevo_microprestamo.vue'),
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
          name: 'microprestamo-grupo',
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
          component: () => import('./views/apadrinamientos/escuela.vue'),
          meta: {
            rule: 'admin'
          }
        },
        {
          path: '/general/sector',
          name: 'general-sector',
          component: () => import('./views/apadrinamientos/sector.vue'),
          meta: {
            rule: 'admin'
          }
        },
        {
          path: '/general/aldea',
          name: 'general-aldea',
          component: () => import('./views/apadrinamientos/aldea.vue'),
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
          name: 'clinica-PersonalMedico',
          component: () => import('./views/Clinica/PersonalMedico/ingresar.vue'),
          meta :{
            rule : 'admin'
          }
        },
        {
          path: '/clinica/editarPersonal/:id',
          name: 'clinica-PersonalMedico',
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
        // LABORATORIO
        // =============================================================================
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


        // =============================================================================
        // Application Routes
        // =============================================================================
        {
          path: '/apps/todo',
          redirect: '/apps/todo/all',
          name: 'todo'
        },
        {
          path: '/apps/todo/:filter',
          component: () => import('./views/apps/todo/Todo.vue'),
          meta: {
            rule: 'editor',
            parent: 'todo',
            no_scroll: true
          }
        },
        {
          path: '/apps/chat',
          name: 'chat',
          component: () => import('./views/apps/chat/Chat.vue'),
          meta: {
            rule: 'editor',
            no_scroll: true
          }
        },
        {
          path: '/apps/email',
          redirect: '/apps/email/inbox',
          name: 'email'
        },
        {
          path: '/apps/email/:filter',
          component: () => import('./views/apps/email/Email.vue'),
          meta: {
            rule: 'editor',
            parent: 'email',
            no_scroll: true
          }
        },
        {
          path: '/apps/calendar/vue-simple-calendar',
          name: 'calendar-simple-calendar',
          component: () => import('./views/apps/calendar/SimpleCalendar.vue'),
          meta: {
            rule: 'editor',
            no_scroll: true
          }
        },
        {
          path: '/apps/eCommerce/shop',
          name: 'ecommerce-shop',
          component: () => import('./views/apps/eCommerce/ECommerceShop.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'eCommerce'},
              { title: 'Shop', active: true }
            ],
            pageTitle: 'Shop',
            rule: 'editor'
          }
        },
        {
          path: '/apps/eCommerce/wish-list',
          name: 'ecommerce-wish-list',
          component: () => import('./views/apps/eCommerce/ECommerceWishList.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'eCommerce', url:'/apps/eCommerce/shop'},
              { title: 'Wish List', active: true }
            ],
            pageTitle: 'Wish List',
            rule: 'editor'
          }
        },
        {
          path: '/apps/eCommerce/checkout',
          name: 'ecommerce-checkout',
          component: () => import('./views/apps/eCommerce/ECommerceCheckout.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'eCommerce', url:'/apps/eCommerce/shop'},
              { title: 'Checkout', active: true }
            ],
            pageTitle: 'Checkout',
            rule: 'editor'
          }
        },
        /*
                  Below route is for demo purpose
                  You can use this route in your app
                    {
                        path: '/apps/eCommerce/item/',
                        name: 'ecommerce-item-detail-view',
                        redirect: '/apps/eCommerce/shop',
                    }
                */
        {
          path: '/apps/eCommerce/item/',
          redirect: '/apps/eCommerce/item/5546604'
        },
        {
          path: '/apps/eCommerce/item/:item_id',
          name: 'ecommerce-item-detail-view',
          component: () => import('./views/apps/eCommerce/ECommerceItemDetailView.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'eCommerce'},
              { title: 'Shop', url: {name: 'ecommerce-shop'} },
              { title: 'Item Details', active: true }
            ],
            parent: 'ecommerce-item-detail-view',
            pageTitle: 'Item Details',
            rule: 'editor'
          }
        },
        {
          path: '/apps/user/user-list',
          name: 'app-user-list',
          component: () => import('@/views/apps/user/user-list/UserList.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'User' },
              { title: 'List', active: true }
            ],
            pageTitle: 'User List',
            rule: 'editor'
          }
        },
        {
          path: '/apps/user/user-view/:userId',
          name: 'app-user-view',
          component: () => import('@/views/apps/user/UserView.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'User' },
              { title: 'View', active: true }
            ],
            pageTitle: 'User View',
            rule: 'editor'
          }
        },
        {
          path: '/apps/user/user-edit/:userId',
          name: 'app-user-edit',
          component: () => import('@/views/apps/user/user-edit/UserEdit.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'User' },
              { title: 'Edit', active: true }
            ],
            pageTitle: 'User Edit',
            rule: 'editor'
          }
        },
        // =============================================================================
        // UI ELEMENTS
        // =============================================================================
        {
          path: '/ui-elements/data-list/list-view',
          name: 'data-list-list-view',
          component: () => import('@/views/ui-elements/data-list/list-view/DataListListView.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Data List'},
              { title: 'List View', active: true }
            ],
            pageTitle: 'List View',
            rule: 'editor'
          }
        },
        {
          path: '/ui-elements/data-list/thumb-view',
          name: 'data-list-thumb-view',
          component: () => import('@/views/ui-elements/data-list/thumb-view/DataListThumbView.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Data List'},
              { title: 'Thumb View', active: true }
            ],
            pageTitle: 'Thumb View',
            rule: 'editor'
          }
        },
        {
          path: '/ui-elements/grid/vuesax',
          name: 'grid-vuesax',
          component: () => import('@/views/ui-elements/grid/vuesax/GridVuesax.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Grid'},
              { title: 'Vuesax', active: true }
            ],
            pageTitle: 'Grid',
            rule: 'editor'
          }
        },
        {
          path: '/ui-elements/grid/tailwind',
          name: 'grid-tailwind',
          component: () => import('@/views/ui-elements/grid/tailwind/GridTailwind.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Grid'},
              { title: 'Tailwind', active: true }
            ],
            pageTitle: 'Tailwind Grid',
            rule: 'editor'
          }
        },
        {
          path: '/ui-elements/colors',
          name: 'colors',
          component: () => import('./views/ui-elements/colors/Colors.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Colors', active: true }
            ],
            pageTitle: 'Colors',
            rule: 'editor'
          }
        },
        {
          path: '/ui-elements/card/basic',
          name: 'basic-cards',
          component: () => import('./views/ui-elements/card/CardBasic.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Card' },
              { title: 'Basic Cards', active: true }
            ],
            pageTitle: 'Basic Cards',
            rule: 'editor'
          }
        },
        {
          path: '/ui-elements/card/statistics',
          name: 'statistics-cards',
          component: () => import('./views/ui-elements/card/CardStatistics.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Card' },
              { title: 'Statistics Cards', active: true }
            ],
            pageTitle: 'Statistics Card',
            rule: 'editor'
          }
        },
        {
          path: '/ui-elements/card/analytics',
          name: 'analytics-cards',
          component: () => import('./views/ui-elements/card/CardAnalytics.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Card' },
              { title: 'Analytics Card', active: true }
            ],
            pageTitle: 'Analytics Card',
            rule: 'editor'
          }
        },
        {
          path: '/ui-elements/card/card-actions',
          name: 'card-actions',
          component: () => import('./views/ui-elements/card/CardActions.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Card' },
              { title: 'Card Actions', active: true }
            ],
            pageTitle: 'Card Actions',
            rule: 'editor'
          }
        },
        {
          path: '/ui-elements/card/card-colors',
          name: 'card-colors',
          component: () => import('./views/ui-elements/card/CardColors.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Card' },
              { title: 'Card Colors', active: true }
            ],
            pageTitle: 'Card Colors',
            rule: 'editor'
          }
        },
        {
          path: '/ui-elements/table',
          name: 'table',
          component: () => import('./views/ui-elements/table/Table.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Table', active: true }
            ],
            pageTitle: 'Table',
            rule: 'editor'
          }
        },
        {
          path: '/ui-elements/ag-grid-table',
          name: 'ag-grid-table',
          component: () => import('./views/ui-elements/ag-grid-table/AgGridTable.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'agGrid Table', active: true }
            ],
            pageTitle: 'agGrid Table',
            rule: 'editor'
          }
        },

        // =============================================================================
        // COMPONENT ROUTES
        // =============================================================================
        {
          path: '/components/alert',
          name: 'component-alert',
          component: () => import('@/views/components/vuesax/alert/Alert.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Components' },
              { title: 'Alert', active: true }
            ],
            pageTitle: 'Alert',
            rule: 'editor'
          }
        },
        {
          path: '/components/avatar',
          name: 'component-avatar',
          component: () => import('@/views/components/vuesax/avatar/Avatar.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Components' },
              { title: 'Avatar', active: true }
            ],
            pageTitle: 'Avatar',
            rule: 'editor'
          }
        },
        {
          path: '/components/breadcrumb',
          name: 'component-breadcrumb',
          component: () => import('@/views/components/vuesax/breadcrumb/Breadcrumb.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Components' },
              { title: 'Breadcrumb', active: true }
            ],
            pageTitle: 'Breadcrumb',
            rule: 'editor'
          }
        },
        {
          path: '/components/button',
          name: 'component-button',
          component: () => import('@/views/components/vuesax/button/Button.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Components' },
              { title: 'Button', active: true }
            ],
            pageTitle: 'Button',
            rule: 'editor'
          }
        },
        {
          path: '/components/button-group',
          name: 'component-button-group',
          component: () => import('@/views/components/vuesax/button-group/ButtonGroup.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Components' },
              { title: 'Button Group', active: true }
            ],
            pageTitle: 'Button Group',
            rule: 'editor'
          }
        },
        {
          path: '/components/chip',
          name: 'component-chip',
          component: () => import('@/views/components/vuesax/chip/Chip.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Components' },
              { title: 'Chip', active: true }
            ],
            pageTitle: 'Chip',
            rule: 'editor'
          }
        },
        {
          path: '/components/collapse',
          name: 'component-collapse',
          component: () => import('@/views/components/vuesax/collapse/Collapse.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Components' },
              { title: 'Collapse', active: true }
            ],
            pageTitle: 'Collapse',
            rule: 'editor'
          }
        },
        {
          path: '/components/dialogs',
          name: 'component-dialog',
          component: () => import('@/views/components/vuesax/dialogs/Dialogs.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Components' },
              { title: 'Dialogs', active: true }
            ],
            pageTitle: 'Dialogs',
            rule: 'editor'
          }
        },
        {
          path: '/components/divider',
          name: 'component-divider',
          component: () => import('@/views/components/vuesax/divider/Divider.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Components' },
              { title: 'Divider', active: true }
            ],
            pageTitle: 'Divider',
            rule: 'editor'
          }
        },
        {
          path: '/components/dropdown',
          name: 'component-drop-down',
          component: () => import('@/views/components/vuesax/dropdown/Dropdown.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Components' },
              { title: 'Dropdown', active: true }
            ],
            pageTitle: 'Dropdown',
            rule: 'editor'
          }
        },
        {
          path: '/components/list',
          name: 'component-list',
          component: () => import('@/views/components/vuesax/list/List.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Components' },
              { title: 'List', active: true }
            ],
            pageTitle: 'List',
            rule: 'editor'
          }
        },
        {
          path: '/components/loading',
          name: 'component-loading',
          component: () => import('@/views/components/vuesax/loading/Loading.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Components' },
              { title: 'Loading', active: true }
            ],
            pageTitle: 'Loading',
            rule: 'editor'
          }
        },
        {
          path: '/components/navbar',
          name: 'component-navbar',
          component: () => import('@/views/components/vuesax/navbar/Navbar.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Components' },
              { title: 'Navbar', active: true }
            ],
            pageTitle: 'Navbar',
            rule: 'editor'
          }
        },
        {
          path: '/components/notifications',
          name: 'component-notifications',
          component: () => import('@/views/components/vuesax/notifications/Notifications.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Components' },
              { title: 'Notifications', active: true }
            ],
            pageTitle: 'Notifications',
            rule: 'editor'
          }
        },
        {
          path: '/components/pagination',
          name: 'component-pagination',
          component: () => import('@/views/components/vuesax/pagination/Pagination.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Components' },
              { title: 'Pagination', active: true }
            ],
            pageTitle: 'Pagination',
            rule: 'editor'
          }
        },
        {
          path: '/components/popup',
          name: 'component-popup',
          component: () => import('@/views/components/vuesax/popup/Popup.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Components' },
              { title: 'Popup', active: true }
            ],
            pageTitle: 'Popup',
            rule: 'editor'
          }
        },
        {
          path: '/components/progress',
          name: 'component-progress',
          component: () => import('@/views/components/vuesax/progress/Progress.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Components' },
              { title: 'Progress', active: true }
            ],
            pageTitle: 'Progress',
            rule: 'editor'
          }
        },
        {
          path: '/components/sidebar',
          name: 'component-sidebar',
          component: () => import('@/views/components/vuesax/sidebar/Sidebar.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Components' },
              { title: 'Sidebar', active: true }
            ],
            pageTitle: 'Sidebar',
            rule: 'editor'
          }
        },
        {
          path: '/components/slider',
          name: 'component-slider',
          component: () => import('@/views/components/vuesax/slider/Slider.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Components' },
              { title: 'Slider', active: true }
            ],
            pageTitle: 'Slider',
            rule: 'editor'
          }
        },
        {
          path: '/components/tabs',
          name: 'component-tabs',
          component: () => import('@/views/components/vuesax/tabs/Tabs.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Components' },
              { title: 'Tabs', active: true }
            ],
            pageTitle: 'Tabs',
            rule: 'editor'
          }
        },
        {
          path: '/components/tooltip',
          name: 'component-tooltip',
          component: () => import('@/views/components/vuesax/tooltip/Tooltip.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Components' },
              { title: 'Tooltip', active: true }
            ],
            pageTitle: 'Tooltip',
            rule: 'editor'
          }
        },
        {
          path: '/components/upload',
          name: 'component-upload',
          component: () => import('@/views/components/vuesax/upload/Upload.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Components' },
              { title: 'Upload', active: true }
            ],
            pageTitle: 'Upload',
            rule: 'editor'
          }
        },


        // =============================================================================
        // FORMS
        // =============================================================================
        // =============================================================================
        // FORM ELEMENTS
        // =============================================================================
        {
          path: '/forms/form-elements/select',
          name: 'form-element-select',
          component: () => import('./views/forms/form-elements/select/Select.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Form Elements' },
              { title: 'Select', active: true }
            ],
            pageTitle: 'Select',
            rule: 'editor'
          }
        },
        {
          path: '/forms/form-elements/switch',
          name: 'form-element-switch',
          component: () => import('./views/forms/form-elements/switch/Switch.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Form Elements' },
              { title: 'Switch', active: true }
            ],
            pageTitle: 'Switch',
            rule: 'editor'
          }
        },
        {
          path: '/forms/form-elements/checkbox',
          name: 'form-element-checkbox',
          component: () => import('./views/forms/form-elements/checkbox/Checkbox.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Form Elements' },
              { title: 'Checkbox', active: true }
            ],
            pageTitle: 'Checkbox',
            rule: 'editor'
          }
        },
        {
          path: '/forms/form-elements/radio',
          name: 'form-element-radio',
          component: () => import('./views/forms/form-elements/radio/Radio.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Form Elements' },
              { title: 'Radio', active: true }
            ],
            pageTitle: 'Radio',
            rule: 'editor'
          }
        },
        {
          path: '/forms/form-elements/input',
          name: 'form-element-input',
          component: () => import('./views/forms/form-elements/input/Input.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Form Elements' },
              { title: 'Input', active: true }
            ],
            pageTitle: 'Input',
            rule: 'editor'
          }
        },
        {
          path: '/forms/form-elements/number-input',
          name: 'form-element-number-input',
          component: () => import('./views/forms/form-elements/number-input/NumberInput.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Form Elements' },
              { title: 'Number Input', active: true }
            ],
            pageTitle: 'Number Input',
            rule: 'editor'
          }
        },
        {
          path: '/forms/form-elements/textarea',
          name: 'form-element-textarea',
          component: () => import('./views/forms/form-elements/textarea/Textarea.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Form Elements' },
              { title: 'Textarea', active: true }
            ],
            pageTitle: 'Textarea',
            rule: 'editor'
          }
        },
        // -------------------------------------------------------------------------------------------------------------------------------------------
        {
          path: '/forms/form-layouts',
          name: 'forms-form-layouts',
          component: () => import('@/views/forms/FormLayouts.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Forms' },
              { title: 'Form Layouts', active: true }
            ],
            pageTitle: 'Form Layouts',
            rule: 'editor'
          }
        },
        {
          path: '/forms/form-wizard',
          name: 'extra-component-form-wizard',
          component: () => import('@/views/forms/form-wizard/FormWizard.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Extra Components' },
              { title: 'Form Wizard', active: true }
            ],
            pageTitle: 'Form Wizard',
            rule: 'editor'
          }
        },
        {
          path: '/forms/form-validation',
          name: 'extra-component-form-validation',
          component: () => import('@/views/forms/form-validation/FormValidation.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Extra Components' },
              { title: 'Form Validation', active: true }
            ],
            pageTitle: 'Form Validation',
            rule: 'editor'
          }
        },
        {
          path: '/forms/form-input-group',
          name: 'extra-component-form-input-group',
          component: () => import('@/views/forms/form-input-group/FormInputGroup.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Extra Components' },
              { title: 'Form Input Group', active: true }
            ],
            pageTitle: 'Form Input Group',
            rule: 'editor'
          }
        },

        // =============================================================================
        // Pages Routes
        // =============================================================================
        {
          path: '/pages/profile',
          name: 'page-profile',
          component: () => import('@/views/pages/Profile.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Pages' },
              { title: 'Profile', active: true }
            ],
            pageTitle: 'Profile',
            rule: 'editor'
          }
        },
        {
          path: '/pages/user-settings',
          name: 'page-user-settings',
          component: () => import('@/views/pages/user-settings/UserSettings.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Pages' },
              { title: 'User Settings', active: true }
            ],
            pageTitle: 'Settings',
            rule: 'editor'
          }
        },
        {
          path: '/pages/faq',
          name: 'page-faq',
          component: () => import('@/views/pages/Faq.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Pages' },
              { title: 'FAQ', active: true }
            ],
            pageTitle: 'FAQ',
            rule: 'editor'
          }
        },
        {
          path: '/pages/knowledge-base',
          name: 'page-knowledge-base',
          component: () => import('@/views/pages/KnowledgeBase.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Pages' },
              { title: 'KnowledgeBase', active: true }
            ],
            pageTitle: 'KnowledgeBase',
            rule: 'editor'
          }
        },
        {
          path: '/pages/knowledge-base/category',
          name: 'page-knowledge-base-category',
          component: () => import('@/views/pages/KnowledgeBaseCategory.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Pages' },
              { title: 'KnowledgeBase', url: '/pages/knowledge-base' },
              { title: 'Category', active: true }
            ],
            parent: 'page-knowledge-base',
            rule: 'editor'
          }
        },
        {
          path: '/pages/knowledge-base/category/question',
          name: 'page-knowledge-base-category-question',
          component: () => import('@/views/pages/KnowledgeBaseCategoryQuestion.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Pages' },
              { title: 'KnowledgeBase', url: '/pages/knowledge-base' },
              { title: 'Category', url: '/pages/knowledge-base/category' },
              { title: 'Question', active: true }
            ],
            parent: 'page-knowledge-base',
            rule: 'editor'
          }
        },
        {
          path: '/pages/search',
          name: 'page-search',
          component: () => import('@/views/pages/Search.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Pages' },
              { title: 'Search', active: true }
            ],
            pageTitle: 'Search',
            rule: 'editor'
          }
        },
        {
          path: '/pages/invoice',
          name: 'page-invoice',
          component: () => import('@/views/pages/Invoice.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Pages' },
              { title: 'Invoice', active: true }
            ],
            pageTitle: 'Invoice',
            rule: 'editor'
          }
        },

        // =============================================================================
        // CHARTS & MAPS
        // =============================================================================
        {
          path: '/charts-and-maps/charts/apex-charts',
          name: 'extra-component-charts-apex-charts',
          component: () => import('@/views/charts-and-maps/charts/apex-charts/ApexCharts.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Charts & Maps' },
              { title: 'Apex Charts', active: true }
            ],
            pageTitle: 'Apex Charts',
            rule: 'editor'
          }
        },
        {
          path: '/charts-and-maps/charts/echarts',
          name: 'extra-component-charts-echarts',
          component: () => import('@/views/charts-and-maps/charts/echarts/Echarts.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Charts & Maps' },
              { title: 'echarts', active: true }
            ],
            pageTitle: 'echarts',
            rule: 'editor'
          }
        },
        {
          path: '/charts-and-maps/maps/google-map',
          name: 'extra-component-maps-google-map',
          component: () => import('@/views/charts-and-maps/maps/google-map/GoogleMap.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Charts & Maps' },
              { title: 'Google Map', active: true }
            ],
            pageTitle: 'Google Map',
            rule: 'editor'
          }
        },


        // =============================================================================
        // EXTENSIONS
        // =============================================================================
        {
          path: '/extensions/select',
          name: 'extra-component-select',
          component: () => import('@/views/components/extra-components/select/Select.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Extra Components' },
              { title: 'Select', active: true }
            ],
            pageTitle: 'Select',
            rule: 'editor'
          }
        },
        {
          path: '/extensions/quill-editor',
          name: 'extra-component-quill-editor',
          component: () => import('@/views/components/extra-components/quill-editor/QuillEditor.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Extra Components' },
              { title: 'Quill Editor', active: true }
            ],
            pageTitle: 'Quill Editor',
            rule: 'editor'
          }
        },
        {
          path: '/extensions/drag-and-drop',
          name: 'extra-component-drag-and-drop',
          component: () => import('@/views/components/extra-components/drag-and-drop/DragAndDrop.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Extra Components' },
              { title: 'Drag & Drop', active: true }
            ],
            pageTitle: 'Drag & Drop',
            rule: 'editor'
          }
        },
        {
          path: '/extensions/datepicker',
          name: 'extra-component-datepicker',
          component: () => import('@/views/components/extra-components/datepicker/Datepicker.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Extra Components' },
              { title: 'Datepicker', active: true }
            ],
            pageTitle: 'Datepicker',
            rule: 'editor'
          }
        },
        {
          path: '/extensions/datetime-picker',
          name: 'extra-component-datetime-picker',
          component: () => import('@/views/components/extra-components/datetime-picker/DatetimePicker.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Extra Components' },
              { title: 'Datetime Picker', active: true }
            ],
            pageTitle: 'Datetime Picker',
            rule: 'editor'
          }
        },
        {
          path: '/extensions/access-control',
          name: 'extra-component-access-control',
          component: () => import('@/views/components/extra-components/access-control/AccessControl.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Extensions' },
              { title: 'Access Control', active: true }
            ],
            pageTitle: 'Access Control',
            rule: 'editor'
          }
        },
        {
          path: '/extensions/i18n',
          name: 'extra-component-i18n',
          component: () => import('@/views/components/extra-components/I18n.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Extensions' },
              { title: 'I18n', active: true }
            ],
            pageTitle: 'I18n',
            rule: 'editor'
          }
        },
        {
          path: '/extensions/carousel',
          name: 'extra-component-carousel',
          component: () => import('@/views/components/extra-components/carousel/Carousel.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Extensions' },
              { title: 'Carousel', active: true }
            ],
            pageTitle: 'Carousel',
            rule: 'editor'
          }
        },
        {
          path: '/extensions/clipboard',
          name: 'extra-component-clipboard',
          component: () => import('@/views/components/extra-components/clipboard/Clipboard.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Extensions' },
              { title: 'Clipboard', active: true }
            ],
            pageTitle: 'Clipboard',
            rule: 'editor'
          }
        },
        {
          path: '/extensions/context-menu',
          name: 'extra-component-context-menu',
          component: () => import('@/views/components/extra-components/context-menu/ContextMenu.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Extensions' },
              { title: 'Context Menu', active: true }
            ],
            pageTitle: 'Context Menu',
            rule: 'editor'
          }
        },
        {
          path: '/extensions/star-ratings',
          name: 'extra-component-star-ratings',
          component: () => import('@/views/components/extra-components/star-ratings/StarRatings.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Extensions' },
              { title: 'Star Ratings', active: true }
            ],
            pageTitle: 'Star Ratings',
            rule: 'editor'
          }
        },
        {
          path: '/extensions/autocomplete',
          name: 'extra-component-autocomplete',
          component: () => import('@/views/components/extra-components/autocomplete/Autocomplete.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Extensions' },
              { title: 'Autocomplete', active: true }
            ],
            pageTitle: 'Autocomplete',
            rule: 'editor'
          }
        },
        {
          path: '/import-export/import',
          name: 'import-excel',
          component: () => import('@/views/components/extra-components/import-export/Import.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Extensions' },
              { title: 'Import/Export' },
              { title: 'Import', active: true }
            ],
            pageTitle: 'Import Excel',
            rule: 'editor'
          }
        },
        {
          path: '/import-export/export',
          name: 'export-excel',
          component: () => import('@/views/components/extra-components/import-export/Export.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Extensions' },
              { title: 'Import/Export' },
              { title: 'Export', active: true }
            ],
            pageTitle: 'Export Excel',
            rule: 'editor'
          }
        },
        {
          path: '/import-export/export-selected',
          name: 'export-excel-selected',
          component: () => import('@/views/components/extra-components/import-export/ExportSelected.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Extensions' },
              { title: 'Import/Export' },
              { title: 'Export Selected', active: true }
            ],
            pageTitle: 'Export Excel',
            rule: 'editor'
          }
        }
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
