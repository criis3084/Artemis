<?php

namespace App\Http\Controllers;

use App\Vivienda;
use App\Encargado;
use App\Constructor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Exception;

class ViviendaController extends Controller
{
	public function index(Request $request)
	{
		// Filtro por un criterio y estado
		$buscar = $request->buscar;
		$criterio = $request->criterio;
		$completo = (isset($request->completo)) ? $request->completo : $completo = 'false';
		
		if ($completo == 'false')
		{
			$count = Vivienda::where('estado',1)->count();
			if ($buscar==''){
				$vivienda = Vivienda::with('tipoVivienda')->with('datos_constructor')->with('datos_residente')->orderBy('id', 'desc')->where('estado',1)->paginate($count);
			}
			else{
				$vivienda = Vivienda::with('tipoVivienda')->with('datos_constructor')->with('datos_residente')->where($criterio, 'like', '%'. $buscar . '%')->where('estado',1)->orderBy('id', 'desc')->paginate($count);
			}
		} else if ($completo == 'true'){
			$count = Vivienda::all()->count();
			if ($buscar==''){
				$vivienda = Vivienda::with('tipoVivienda')->with('datos_constructor')->with('datos_residente')->orderBy('id', 'desc')->paginate($count);
			}
			else{
				$vivienda = Vivienda::with('tipoVivienda')->with('datos_constructor')->with('datos_residente')->where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate($count);
			}
		}
		return [
			"viviendas"=>$vivienda
		];
	}

	public function store(Request $request)
	{
		try {
			$vivienda = new Vivienda();
			$vivienda->costo_total = $request->costo_total;
			$vivienda->direccion = $request->direccion;
			$vivienda->fecha_inicio = $request->fecha_inicio;
			$vivienda->duracion = $request->duracion;
			$vivienda->imagen_final = $request->imagen_final;
			$vivienda->encargado_id = $request->encargado_id;
			$vivienda->constructor_id = $request->constructor_id;
			$vivienda->tipo_vivienda_id = $request->tipo_vivienda_id;
			$vivienda->save();
			return Response::json(['message' => 'Vivienda Creada'], 200);
			#return ['id' => $nino->id];
		} catch (Exception $e) {
			return Response::json(['message' => $e->getMessage()], 400);
		}
	}

	public function update(Request $request)
	{
		$vivienda = Vivienda::findOrFail($request->id);
			$vivienda->costo_total = $request->costo_total;
			$vivienda->direccion = $request->direccion;
			$vivienda->fecha_inicio = $request->fecha_inicio;
			$vivienda->duracion = $request->duracion;
			$vivienda->imagen_final = $request->imagen_final;
			$vivienda->encargado_id = $request->encargado_id;
			$vivienda->constructor_id = $request->constructor_id;
			$vivienda->tipo_vivienda_id = $request->tipo_vivienda_id;
		$vivienda->save();
		
			return Response::json(['message' => 'Vivienda Actualizada'], 200);
	}

	public function activar(Request $request)
	{
		$Vivienda = Vivienda::findOrFail($request->id);
        $Vivienda->estado = '1';
        $Vivienda->save();
		return Response::json(['message' => 'Vivienda Activada'], 200);
	}

	public function desactivar(Request $request)
	{
		$Vivienda = Vivienda::findOrFail($request->id);
        $Vivienda->estado = '0';
        $Vivienda->save();
		return Response::json(['message' => 'Vivienda Desactivada'], 200);
	}

	// public function imagen(Request $request){
	// 	$imagen = $request->photos;
	// 	$nombreEliminar = public_path('storage\public\viviendas\\') .  $request->header("imagenanterior");
	// 	if (File::exists($nombreEliminar)) {
	// 		File::delete($nombreEliminar);
	// 	}
	// 	$completo = time() . "." . $imagen->extension();
	// 	$imagen->move(public_path('storage/public/viviendas/'), $completo);
	// 	return Response::json($completo, 200);
	// }
}