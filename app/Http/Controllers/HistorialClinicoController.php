<?php

namespace App\Http\Controllers;

use App\HistorialClinico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Exception;

class HistorialClinicoController extends Controller
{
	public function index(Request $request)
	{
		$buscar = $request->buscar;
		$criterio = $request->criterio;
		$completo = (isset($request->completo)) ? $request->completo :'false';
		$count = HistorialClinico::all()->count();
		if ($completo == 'false')
		{
			if ($buscar==''){
				$historialClinico = HistorialClinico::with('clinico')->with('doctor')->with('paciente')->orderBy('id', 'desc')->where('estado',1)->paginate($count);
			}
			else{
				$historialClinico = HistorialClinico::with('clinico')->with('doctor')->with('paciente')->where([[$criterio, 'like',$buscar],['estado',1]])->orderBy('id', 'desc')->paginate($count);
			}
		} else if ($completo == 'true'){
			if ($buscar==''){
				$historialClinico = HistorialClinico::with('clinico')->with('doctor')->with('paciente')->orderBy('id', 'desc')->paginate($count);
			}
			else{
				$historialClinico = HistorialClinico::with('clinico')->with('doctor')->with('paciente')->where($criterio,'like',$buscar)->orderBy('id', 'desc')->paginate($count);
			}
		}
		return [
			"historialClinicos"=>$historialClinico
		];
	}

	public function store(Request $request)
	{
		try {
			$historialClinico = new HistorialClinico();
			$historialClinico->fecha_consulta = $request->fecha_consulta;
			$historialClinico->descripcion = $request->descripcion;
			$historialClinico->peso_actual = $request->peso_actual;
			$historialClinico->glicemia = $request->glicemia;
			$historialClinico->semanas_embarazo = $request->semanas_embarazo;
			$historialClinico->talla = $request->talla;
			$historialClinico->pulso = $request->pulso;
			$historialClinico->respiracion = $request->respiracion;
			$historialClinico->temperatura = $request->temperatura;
			$historialClinico->presion_arterial = $request->presion_arterial;
			$historialClinico->objetivo = $request->objetivo;
			$historialClinico->subjetivo = $request->subjetivo;
			$historialClinico->paciente_id = $request->paciente_id;
			$historialClinico->clinico_id = $request->clinico_id;
			$historialClinico->save();
			
			return Response::json(['message' => 'Historial clinico Creada'], 200);
			#return ['id' => $nino->id];
		} catch (Exception $e) {
			return Response::json(['message' => $e->getMessage()], 400);
		}
	}

	public function update(Request $request)
	{
		$historialClinico = HistorialClinico::findOrFail($request->id);
		$historialClinico->fecha_consulta = $request->fecha_consulta;
		$historialClinico->descripcion = $request->descripcion;
		$historialClinico->peso_actual = $request->peso_actual;
		$historialClinico->glicemia = $request->glicemia;
		$historialClinico->semanas_embarazo = $request->semanas_embarazo;
		$historialClinico->talla = $request->talla;
		$historialClinico->pulso = $request->pulso;
		$historialClinico->respiracion = $request->respiracion;
		$historialClinico->temperatura = $request->temperatura;
		$historialClinico->presion_arterial = $request->presion_arterial;
		$historialClinico->objetivo = $request->objetivo;
		$historialClinico->subjetivo = $request->subjetivo;
		$historialClinico->paciente_id = $request->paciente_id;
		$historialClinico->clinico_id = $request->clinico_id;
		$historialClinico->save();
		return Response::json(['message' => 'Historial clinico Actualizado'], 200);

	}

	public function activar(Request $request)
	{
		$historialClinico = HistorialClinico::findOrFail($request->id);
        $historialClinico->estado = '1';
        $historialClinico->save();
		return Response::json(['message' => 'Historial clinico Activado'], 200);
	}

	public function desactivar(Request $request)
	{
		$historialClinico = HistorialClinico::findOrFail($request->id);
        $historialClinico->estado = '0';
        $historialClinico->save();
		return Response::json(['message' => 'Historial clinico Activado'], 200);
	}
}