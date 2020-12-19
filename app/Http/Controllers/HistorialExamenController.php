<?php

namespace App\Http\Controllers;

use App\HistorialExamen;
use App\Examen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Exception;

class HistorialExamenController extends Controller
{
	public function index(Request $request)
	{
		$buscar = $request->buscar;
		$criterio = $request->criterio;
		$completo = (isset($request->completo)) ? $request->completo :'false';
		$count = HistorialExamen::all()->count();
		if ($completo == 'false')
		{
			if ($buscar==''){
				$historialExamen = HistorialExamen::with('examen')->with('tipo_examen')->with('paciente')->orderBy('id', 'desc')->where('estado',1)->paginate($count);
			}
			else{
				$historialExamen = HistorialExamen::with('examen')->with('tipo_examen')->with('paciente')->where([[$criterio, 'like',$buscar],['estado',1]])->orderBy('id', 'desc')->paginate($count);
			}
		} else if ($completo == 'true'){
			if ($buscar==''){
				$historialExamen = HistorialExamen::with('examen')->with('tipo_examen')->with('paciente')->orderBy('id', 'desc')->paginate($count);
			}
			else{
				$historialExamen = HistorialExamen::with('examen')->with('tipo_examen')->with('paciente')->where($criterio,'like',$buscar)->orderBy('id', 'desc')->paginate($count);
			}
		}
		return [
			"historialExamenes"=>$historialExamen
		];
	}

	public function store(Request $request)
	{
		try {
			$historialExamen = new HistorialExamen();
			$historialExamen->examen_id = $request->examen_id;
			$historialExamen->paciente_id = $request->paciente_id;
			$historialExamen->save();
			
			return Response::json(['message' => 'Historial examen Creada'], 200);
			#return ['id' => $nino->id];
		} catch (Exception $e) {
			return Response::json(['message' => $e->getMessage()], 400);
		}
	}
	public function programar(Request $request)
	{
		try {
			$examen = new Examen();
			$examen->tipo_examen_id = $request->tipo_examen_id;
			$examen->clinico_id = $request->clinico_id;
			$examen->save();
			
			$historialExamen = new HistorialExamen();
			$historialExamen->examen_id = $examen->id;
			$historialExamen->paciente_id = $request->paciente_id;
			$historialExamen->save();
			
			return Response::json(['message' => 'Historial examen Creada'], 200);
			#return ['id' => $nino->id];
		} catch (Exception $e) {
			return Response::json(['message' => $e->getMessage()], 400);
		}
	}

	public function update(Request $request)
	{
		$historialExamen = HistorialExamen::findOrFail($request->id);
		$historialExamen->notas = $request->notas;
		$historialExamen->examen_id = $request->examen_id;
		$historialExamen->paciente_id = $request->paciente_id;
		$historialExamen->save();
		return Response::json(['message' => 'Historial examen Actualizado'], 200);

	}

	public function activar(Request $request)
	{
		$historialExamen = HistorialExamen::findOrFail($request->id);
        $historialExamen->estado = '1';
        $historialExamen->save();
		return Response::json(['message' => 'historialExamen Activado'], 200);
	}

	public function desactivar(Request $request)
	{
		$historialExamen = HistorialExamen::findOrFail($request->id);
        $historialExamen->estado = '0';
        $historialExamen->save();
		return Response::json(['message' => 'historialExamen Desactivado'], 200);
	}
}