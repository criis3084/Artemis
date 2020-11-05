<?php

namespace App\Http\Controllers;

use App\Examen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Exception;

class ExamenController extends Controller
{
	public function index(Request $request)
	{
		$buscar = $request->buscar;
		$criterio = $request->criterio;
		$completo = (isset($request->completo)) ? $request->completo :'false';
		$count = Examen::all()->count();
		if ($completo == 'false')
		{
			if ($buscar==''){
				$examen = Examen::with('tipoExamen')->with('laboratorista')->orderBy('id', 'desc')->where('estado',1)->paginate($count);
			}
			else{
				$examen = Examen::with('tipoExamen')->with('laboratorista')->where([[$criterio, 'like',$buscar],['estado',1]])->orderBy('id', 'desc')->paginate($count);
			}
		} else if ($completo == 'true'){
			if ($buscar==''){
				$examen = Examen::with('tipoExamen')->with('laboratorista')->orderBy('id', 'desc')->paginate($count);
			}
			else{
				$examen = Examen::with('tipoExamen')->with('laboratorista')->where($criterio,'like',$buscar)->orderBy('id', 'desc')->paginate($count);
			}
		}
		return [
			"examenes"=>$examen
		];
	}

	public function store(Request $request)
	{
		try {
			$examen = new Examen();
			$examen->descripcion = $request->descripcion;
			$examen->resultado = $request->resultado;
			$examen->fecha_examen = $request->fecha_examen;
			$examen->tipo_examen_id = $request->tipo_examen_id;
			$examen->clinico_id = $request->clinico_id;
			$examen->save();
			#return Response::json(['message' => 'Examen Creada'], 200);
			return ['id' => $examen->id];
		} catch (Exception $e) {
			return Response::json(['message' => $e->getMessage()], 400);
		}
	}

	public function update(Request $request)
	{
		$examen = Examen::findOrFail($request->id);
		$examen->descripcion = $request->descripcion;
		$examen->resultado = $request->resultado;
		$examen->fecha_examen = $request->fecha_examen;
		$examen->tipo_examen_id = $request->tipo_examen_id;
		$examen->clinico_id = $request->clinico_id;
		$examen->save();
		return Response::json(['message' => 'Examen Actualizado'], 200);
		
	}

	public function activar(Request $request)
	{
		$examen = Examen::findOrFail($request->id);
        $examen->estado = '1';
        $examen->save();
		return Response::json(['message' => 'examen Activado'], 200);
	}

	public function desactivar(Request $request)
	{
		$examen = Examen::findOrFail($request->id);
        $examen->estado = '0';
        $examen->save();
		return Response::json(['message' => 'examen desactivado'], 200);
	}
}