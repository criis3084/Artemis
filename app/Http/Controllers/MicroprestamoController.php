<?php

namespace App\Http\Controllers;

use App\Microprestamo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Exception;

class MicroprestamoController extends Controller
{
	public function index(Request $request)
    {
		$buscar = $request->buscar;
        $criterio = $request->criterio;
		$completo = (isset($request->completo)) ? $request->completo : 'false';
		$count = Microprestamo::all()->count();
		if ($completo == 'false')
		{
			if ($buscar==''){
				$microprestamo = Microprestamo::orderBy('id', 'desc')->where('estado',1)->paginate($count);
			}
			else{
				$microprestamo = Microprestamo::where([['estado',1],[$criterio, 'like', $buscar]])->orderBy('id', 'desc')->paginate($count);
			}
		}
		else if ($completo == 'true'){
			if ($buscar==''){
				$microprestamo = Microprestamo::orderBy('id', 'desc')->paginate($count);
			}
			else{
				$microprestamo = Microprestamo::where($criterio, 'like', $buscar)->orderBy('id', 'desc');
			}
		}
		else if($completo == 'select')
		{
			$microprestamo = Microprestamo::orderBy('id', 'desc')->where('estado',1)->paginate($count);
		}
        return[
            'microprestamos' => $microprestamo
		];
    }

    public function store(Request $request)
    {
        try {
			$microprestamo = new Microprestamo();
		    $microprestamo->nombreMicroprestamo = $request->nombreMicroprestamo;			
			$microprestamo->total = $request->total;
			$microprestamo->interes = $request->interes;
			$microprestamo->fecha_inicio = $request->fecha_inicio;
			$microprestamo->duracion = $request->duracion;
			$microprestamo->dia_pago = $request->dia_pago;
			$microprestamo->pago_mes = $request->pago_mes;
			$microprestamo->mora_por_atraso = $request->mora_por_atraso;
			//$microprestamo->destino_inversion_id = $request->destino_inversion_id;
			$microprestamo->save();
			return ['id' => $microprestamo->id];
		} catch (Exception $e) {
            return Response::json(['message' => $e->getMessage()], 400);
		}
    }

    public function show(Microprestamo $microprestamo)
    {
		#if(!$request->ajax())return redirect('/');
		return [
			'id'=> $microprestamo->id,
			'nombreMicroprestamo' => $microprestamo->nombreMicroprestamo,
			'total'=> $microprestamo->total,
			'interes'=> $microprestamo->interes,
			'fecha_inicio'=> $microprestamo->fecha_inicio,
			'duracion'=> $microprestamo->duracion,
			'dia_pago'=> $microprestamo->dia_pago,
			'pago_mes'=>$microprestamo->pago_mes,
			'mora_por_atraso'=> $microprestamo->mora_por_atraso,
			//'destino_inversion_id'=> $microprestamo->destino_inversion_id,
			'destino_inversion_nombre'=> $microprestamo->destino_inversion->nombre,
		];
    }

    public function update(Request $request)
    {
		#if(!$request->ajax())return redirect('/');
		try {
		$microprestamo = Microprestamo::findOrFail($request->id);
		$microprestamo->nombreMicroprestamo = $request->nombre;
		//$microprestamo->dia_pago = $request->dia_pago;
		$microprestamo->save();
		return Response::json(['message' => 'Microprestamo Actualizada'], 200);
		} catch (Exception $e) {
			return Response::json(['message' => $e->getMessage()], 400);
		}
	}

	public function activar(Request $request)
	{
		//if(!$request->ajax())return redirect('/');
		$microprestamo = Microprestamo::findOrFail($request->id);
		$microprestamo->estado = '1';
		$microprestamo->save();
		return Response::json(['message' => 'Microprestamo Activado'], 200);
	}
    public function desactivar(Request $request)
    {
		//if(!$request->ajax())return redirect('/');
        $microprestamo = Microprestamo::findOrFail($request->id);
        $microprestamo->estado = '0';
		$microprestamo->save();
		return Response::json(['message' => 'Microprestamo Desactivado'], 200);
    }
}