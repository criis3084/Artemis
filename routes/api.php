<?php

use App\PersonaSinAcceso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RolController;
use App\Http\Controllers\PersonaSinAccesoController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/*
Route::apiResource('rol', 'RolController')->only([
    'index', 'show','update','destroy','store'
]);
*/

Route::apiResources([
	'rol'                   => 'RolController',
	'personaSinAcceso'      => 'PersonaSinAccesoController',
	'aldea'                 => 'AldeaController',
	'escuela'               => 'EscuelaController',
	'ppi'                   => 'PpiController',
	'fotografia'            => 'FotografiaController',
	'grupoPrestamo'         => 'GrupoPrestamoController',
	'destinoInversion'      => 'DestinoInversionController',
	'tipoVivienda'          => 'TipoViviendaController',
	'tipoExamen'            => 'TipoExamenController',
	'tipoCita'              => 'TipoCitaController',
	'tipoPaciente'          => 'TipoPacienteController',
	'profesion'             => 'ProfesionController',
	'casaMedica'            => 'CasaMedicaController',
	'categoriaMedicamento'  => 'CategoriaMedicamentoController',
	'usuario'               => 'UsuarioController',
	'nino'                  => 'NinoController',
	'encargado'             => 'EncargadoController',
	'padrino'               => 'PadrinoController',
	'sector'                => 'SectorController',
	'constructor'           => 'ConstructorController',
	'microprestamo'         => 'MicroprestamoController',
	'medicamento'           => 'MedicamentoController',
	'proveedor'             => 'ProveedorController',
	'paciente'              => 'PacienteController',
	'tutor'                 => 'TutorController',
	'administrativo'        => 'AdministrativoController',
	'clinico'               => 'ClinicoController',
	'apadrinamiento'        => 'ApadrinamientoController',
	'relacion'              => 'RelacionController',
	'vivienda'              => 'ViviendaController',
	'historialPpi'          => 'HistorialPpiController',
	'historialFotografia'   => 'HistorialFotografiaController',
	'detalleIntegrante'     => 'DetalleIntegranteController',
	'examen'                => 'ExamenController',
	'beneficio'             => 'BeneficioController',
	'lote'                  => 'LoteController',
	'ingresoMedicamento'    => 'IngresoMedicamentoController',
	'salidaMedicamento'     => 'SalidaMedicamentoController',
	'tutoria'               => 'TutoriaController',
	'correspondencia'       => 'CorrespondenciaController',
	'abonoPrestamo'         => 'AbonoPrestamoController',
	'abonoVivienda'         => 'AbonoViviendaController',
	'cita'                  => 'CitaController',
	'detalleBeneficio'      => 'DetalleBeneficioController',
	'detalleIngreso'        => 'DetalleIngresoController',
	'detalleSalida'         => 'DetalleSalidaController',
	'historialExamen'       => 'HistorialExamenController',
	'historialClinico'      => 'HistorialClinicoController',
	'receta'                => 'RecetaController',
	'asignacionMedicamento' => 'AsignacionMedicamentoController'
]);

//Rutas en api.php

//Aqui afuera pueden escribir todas las demas rutas.
Route::group(['prefix' => 'rol'], function () {
    Route::get('/get', [
        'as' => 'admin.rol', 'uses' => 'RolController@index'
    ]);
    Route::post('/post', [
        'as' => 'admin.rol', 'uses' => 'RolController@store'
    ]);
    Route::put('/update', [
        'as' => 'admin.rol', 'uses' => 'RolController@update'
    ]);
    Route::put('/activar', [
        'as' => 'admin.rol', 'uses' => 'RolController@activar'
    ]);
    Route::put('/desactivar', [
        'as' => 'admin.rol', 'uses' => 'RolController@desactivar'
    ]);
});


Route::group(['prefix' => 'admin', 'middleware' => 'api.auth'], function () {
    //Aqui pueden meter las rutas que necesitan que alguien este autenticado

    Route::group(['prefix' => 'rol'], function () {
        Route::get('/get', [
            'as' => 'admin.rol', 'uses' => 'RolController@index'
        ]);
        Route::post('/post', [
            'as' => 'admin.rol', 'uses' => 'RolController@store'
        ]);
        Route::put('/update', [
            'as' => 'admin.rol', 'uses' => 'RolController@update'
        ]);
        Route::put('/activar', [
            'as' => 'admin.rol', 'uses' => 'RolController@activar'
        ]);
        Route::put('/desactivar', [
            'as' => 'admin.rol', 'uses' => 'RolController@desactivar'
        ]);
    });

} );
