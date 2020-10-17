<?php

namespace App\Http\Controllers;

use App\DetalleBeneficio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Exception;

class DetalleBeneficioController extends Controller
{
	public function index(Request $request)
	{
		$buscar = $request->buscar;
		$criterio = $request->criterio;
		$completo = (isset($request->completo)) ? $request->completo :'false';
		$count = DetalleBeneficio::all()->count();
		if ($completo == 'false')
		{
			if ($buscar==''){
				$detalleBeneficio = DetalleBeneficio::with('beneficio')->with('medicamento')->orderBy('id', 'desc')->where('estado',1)->paginate($count);
			}
			else{
				$detalleBeneficio = DetalleBeneficio::with('beneficio')->with('medicamento')->where([[$criterio, 'like',$buscar],['estado',1]])->orderBy('id', 'desc')->paginate($count);
			}
		} else if ($completo == 'true'){
			if ($buscar==''){
				$detalleBeneficio = DetalleBeneficio::with('beneficio')->with('medicamento')->orderBy('id', 'desc')->paginate($count);
			}
			else{
				$detalleBeneficio = DetalleBeneficio::with('beneficio')->with('medicamento')->where($criterio,'like',$buscar)->orderBy('id', 'desc')->paginate($count);
			}
		}
		return [
			"detalleBeneficios"=>$detalleBeneficio
		];
	}

	public function store(Request $request)
	{
		try {
			$detalleBeneficio = new DetalleBeneficio();
			$detalleBeneficio->cantidad = $request->cantidad;
			$detalleBeneficio->beneficio_id = $request->beneficio_id;
			$detalleBeneficio->medicamento_id = $request->medicamento_id;
			$detalleBeneficio->save();
			return Response::json(['message' => 'Detalle Beneficio Creada'], 200);
			#return ['id' => $nino->id];
		} catch (Exception $e) {
			return Response::json(['message' => $e->getMessage()], 400);
		}
	}

	public function update(Request $request)
	{
		$detalleBeneficio = DetalleBeneficio::findOrFail($request->id);
		$detalleBeneficio->cantidad = $request->cantidad;
		$detalleBeneficio->beneficio_id = $request->beneficio_id;
		$detalleBeneficio->medicamento_id = $request->medicamento_id;
		$detalleBeneficio->save();
		return Response::json(['message' => 'Detalle Beneficio Actualizado'], 200);

	}

	public function activar(Request $request)
	{
		$detalleBeneficio = DetalleBeneficio::findOrFail($request->id);
        $detalleBeneficio->estado = '1';
        $detalleBeneficio->save();
		return Response::json(['message' => 'Detalle Beneficio Activado'], 200);
	}

	public function desactivar(Request $request)
	{
		$detalleBeneficio = DetalleBeneficio::findOrFail($request->id);
        $detalleBeneficio->estado = '0';
        $detalleBeneficio->save();
		return Response::json(['message' => 'Detalle Beneficio Desactivado'], 200);
	}
}