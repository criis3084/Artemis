<?php

namespace App\Http\Controllers;

use App\AsignacionMedicamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Exception;

class AsignacionMedicamentoController extends Controller
{
	public function index(Request $request)
	{
		$buscar = $request->buscar;
		$criterio = $request->criterio;
		$completo = (isset($request->completo)) ? $request->completo :'false';
		$count = AsignacionMedicamento::all()->count();
		if ($completo == 'false')
		{
			if ($buscar==''){
				$asignacionMedicamento = AsignacionMedicamento::with('medicamento')->with('receta')->orderBy('id', 'desc')->where('estado',1)->paginate($count);
			}
			else{
				$asignacionMedicamento = AsignacionMedicamento::with('medicamento')->with('receta')->where([[$criterio, 'like',$buscar],['estado',1]])->orderBy('id', 'desc')->paginate($count);
			}
		} else if ($completo == 'true'){
			if ($buscar==''){
				$asignacionMedicamento = AsignacionMedicamento::with('medicamento')->with('receta')->orderBy('id', 'desc')->paginate($count);
			}
			else{
				$asignacionMedicamento = AsignacionMedicamento::with('medicamento')->with('receta')->where($criterio,'like',$buscar)->orderBy('id', 'desc')->paginate($count);
			}
		}
		return [
			"asignacionMedicamentos"=>$asignacionMedicamento
		];
	}

	public function store(Request $request)
	{
		try {
			$asignacionMedicamento = new AsignacionMedicamento();
			$asignacionMedicamento->cantidad = $request->cantidad;
			$asignacionMedicamento->frecuencia = $request->frecuencia;
			$asignacionMedicamento->medicamento_id = $request->medicamento_id;
			$asignacionMedicamento->receta_id = $request->receta_id;
			$asignacionMedicamento->save();
			return Response::json(['message' => 'Asignacion de medicamento Creada'], 200);
			#return ['id' => $nino->id];
		} catch (Exception $e) {
			return Response::json(['message' => $e->getMessage()], 400);
		}
	}

	public function update(Request $request)
	{
		$asignacionMedicamento = AsignacionMedicamento::findOrFail($request->id);
		$asignacionMedicamento->cantidad = $request->cantidad;
		$asignacionMedicamento->frecuencia = $request->frecuencia;
		$asignacionMedicamento->medicamento_id = $request->medicamento_id;
		$asignacionMedicamento->receta_id = $request->receta_id;
		$asignacionMedicamento->save();
		return Response::json(['message' => 'Asignacion de medicamento Actualizado'], 200);

	}

	public function activar(Request $request)
	{
		$asignacionMedicamento = AsignacionMedicamento::findOrFail($request->id);
        $asignacionMedicamento->estado = '1';
        $asignacionMedicamento->save();
		return Response::json(['message' => 'Asignacion Medicamento Activado'], 200);
	}

	public function desactivar(Request $request)
	{
		$asignacionMedicamento = AsignacionMedicamento::findOrFail($request->id);
        $asignacionMedicamento->estado = '0';
        $asignacionMedicamento->save();
		return Response::json(['message' => 'Asignacion Medicamento Desactivado'], 200);
	}
}