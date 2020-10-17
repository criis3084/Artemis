<?php

namespace App\Http\Controllers;

use App\Cita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Exception;

class CitaController extends Controller
{
	public function index(Request $request)
	{
		$buscar = $request->buscar;
		$criterio = $request->criterio;
		$completo = (isset($request->completo)) ? $request->completo :'false';
		$count = Cita::all()->count();
		if ($completo == 'false')
		{
			if ($buscar==''){
				$cita = Cita::with('clinico')->with('paciente')->with('tipoCita')->orderBy('id', 'desc')->where('estado',1)->paginate($count);
			}
			else{
				$cita = Cita::with('clinico')->with('paciente')->with('tipoCita')->where([[$criterio, 'like',$buscar],['estado',1]])->orderBy('id', 'desc')->paginate($count);
			}
		} else if ($completo == 'true'){
			if ($buscar==''){
				$cita = Cita::with('clinico')->with('paciente')->with('tipoCita')->orderBy('id', 'desc')->paginate($count);
			}
			else{
				$cita = Cita::with('clinico')->with('paciente')->with('tipoCita')->where($criterio,'like',$buscar)->orderBy('id', 'desc')->paginate($count);
			}
		}
		return [
			"citas"=>$cita
		];
	}

	public function store(Request $request)
	{
		try {
			$cita = new Cita();
			$cita->fecha = $request->fecha;
			$cita->descripcion = $request->descripcion;
			$cita->clinico_id = $request->clinico_id;
			$cita->paciente_id = $request->paciente_id;
			$cita->tipo_cita_id = $request->tipo_cita_id;
			$cita->save();
			return Response::json(['message' => 'Cita Creada'], 200);
			#return ['id' => $nino->id];
		} catch (Exception $e) {
			return Response::json(['message' => $e->getMessage()], 400);
		}
	}

	public function update(Request $request)
	{
		$cita = Cita::findOrFail($request->id);
		$cita->fecha = $request->fecha;
		$cita->descripcion = $request->descripcion;
		$cita->clinico_id = $request->clinico_id;
		$cita->paciente_id = $request->paciente_id;
		$cita->tipo_cita_id = $request->tipo_cita_id;
		$cita->save();
		return Response::json(['message' => 'Cita Actualizado'], 200);

	}

	public function activar(Request $request)
	{
		$cita = Cita::findOrFail($request->id);
        $cita->estado = '1';
        $cita->save();
		return Response::json(['message' => 'Cita Activado'], 200);
	}

	public function desactivar(Request $request)
	{
		$cita = Cita::findOrFail($request->id);
        $cita->estado = '0';
        $cita->save();
		return Response::json(['message' => 'Cita Desactivado'], 200);
	}
}