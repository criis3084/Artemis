<?php

namespace App\Http\Controllers;

use App\SalidaMedicamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Exception;

class SalidaMedicamentoController extends Controller
{
	public function index(Request $request)
	{
		$buscar = $request->buscar;
		$criterio = $request->criterio;
		$completo = (isset($request->completo)) ? $request->completo :'false';
		$count = SalidaMedicamento::all()->count();
		if ($completo == 'false')
		{
			if ($buscar==''){
				$salidaMedicamento = SalidaMedicamento::with('usuario')->with('paciente')->orderBy('id', 'desc')->where('estado',1)->paginate($count);
			}
			else{
				$salidaMedicamento = SalidaMedicamento::with('usuario')->with('paciente')->where([[$criterio, 'like',$buscar],['estado',1]])->orderBy('id', 'desc')->paginate($count);
			}
		} else if ($completo == 'true'){
			if ($buscar==''){
				$salidaMedicamento = SalidaMedicamento::with('usuario')->with('paciente')->orderBy('id', 'desc')->paginate($count);
			}
			else{
				$salidaMedicamento = SalidaMedicamento::with('usuario')->with('paciente')->where($criterio,'like',$buscar)->orderBy('id', 'desc')->paginate($count);
			}
		}
		return [
			"salidaMedicamentos"=>$salidaMedicamento
		];
	}

	public function store(Request $request)
	{
		try {
			$salidaMedicamento = new SalidaMedicamento();
			$salidaMedicamento->fecha_salida = $request->fecha_salida;
			$salidaMedicamento->descripcion = $request->descripcion;
			$salidaMedicamento->usuario_id = $request->usuario_id;
			$salidaMedicamento->paciente_id = $request->paciente_id;
			$salidaMedicamento->save();
			return Response::json(['message' => 'Salida Medicamento Creada'], 200);
			#return ['id' => $nino->id];
		} catch (Exception $e) {
			return Response::json(['message' => $e->getMessage()], 400);
		}
	}

	public function update(Request $request)
	{
		$salidaMedicamento = SalidaMedicamento::findOrFail($request->id);
		$salidaMedicamento->fecha_salida = $request->fecha_salida;
		$salidaMedicamento->descripcion = $request->descripcion;
		$salidaMedicamento->usuario_id = $request->usuario_id;
		$salidaMedicamento->paciente_id = $request->paciente_id;
		$salidaMedicamento->save();
		return Response::json(['message' => 'Salida Medicamento Actualizado'], 200);

	}

	public function activar(Request $request)
	{
		$salidaMedicamento = SalidaMedicamento::findOrFail($request->id);
        $salidaMedicamento->estado = '1';
        $salidaMedicamento->save();
		return Response::json(['message' => 'salidaMedicamento Activado'], 200);
	}

	public function desactivar(Request $request)
	{
		$salidaMedicamento = SalidaMedicamento::findOrFail($request->id);
        $salidaMedicamento->estado = '0';
        $salidaMedicamento->save();
		return Response::json(['message' => 'salidaMedicamento Desactivado'], 200);
	}
}