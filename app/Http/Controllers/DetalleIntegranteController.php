<?php

namespace App\Http\Controllers;

use App\DetalleIntegrante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Exception;

class DetalleIntegranteController extends Controller
{
	public function index(Request $request)
	{
		#if(!$request->ajax())return redirect('/');
		// Filtro por un criterio y estado
		$buscar = $request->buscar;
		$criterio = $request->criterio;
		$completo = (isset($request->completo)) ? $request->completo : $completo = 'false';
		
		$count = DetalleIntegrante::all()->count();
		if ($completo == 'false')
		{
			if ($buscar==''){
				$detalleIntegrante = DetalleIntegrante::with('prestamista')->with('grupos')->with('abonos')->with('destino')->orderBy('id', 'desc')->where('estado',1)->paginate($count);
			}
			else{
				$detalleIntegrante = DetalleIntegrante::with('prestamista')->with('grupos')->with('abonos')->with('destino')->where($criterio, 'like', $buscar )->where('estado',1)->orderBy('id', 'desc')->paginate($count);
			}
		} else if ($completo == 'true'){
			if ($buscar==''){
				$detalleIntegrante = DetalleIntegrante::with('prestamista')->with('grupos')->with('abonos')->with('destino')->orderBy('id', 'desc')->paginate($count);
			}
			else{
				$detalleIntegrante = DetalleIntegrante::with('prestamista')->with('grupos')->with('abonos')->with('destino')->where($criterio, 'like', $buscar )->orderBy('id', 'desc')->paginate($count);
			}
		}else if($completo="true"){
			$detalleIntegrante = DetalleIntegrante::with('prestamista')->with('grupos')->with('abonos')->with('destino')->where('estado',0)->orderBy('id', 'desc')->paginate($count);
		}
		return [
			"detalleIntegrantes"=>$detalleIntegrante
		];
	}

	public function store(Request $request)
	{
		try {	
            $detalleIntegrante = new DetalleIntegrante();
            $detalleIntegrante->prestamo_individual = $request->prestamo_individual;
            $detalleIntegrante->encargado_id = $request->encargado_id;
            $detalleIntegrante->grupo_prestamo_id = $request->grupo_prestamo_id;
			$detalleIntegrante->destino_inversion_id = $request->destino_inversion_id;
			$detalleIntegrante->microprestamo_id = $request->microprestamo_id;
			$detalleIntegrante->save();
			
			return ['id' => $detalleIntegrante->id];
            #return Response::json(['message' => 'Nino Creado'], 200);
            #return ['id' => $nino->id];
        } catch (Exception $e) {
            return Response::json(['message' => $e->getMessage()], 400);
		}
	}

	public function update(Request $request)
	{
		$detalleIntegrante = DetalleIntegrante::findOrFail($request->id);
		$detalleIntegrante->prestamo_individual        = $request->prestamo_individual;
		$detalleIntegrante->encargado_id = $request->encargado_id;
		$detalleIntegrante->grupo_prestamo_id  = $request->grupo_prestamo_id;
		$detalleIntegrante->destino_inversion_id   = $request->destino_inversion_id;
		$detalleIntegrante->microprestamo_id = $request->microprestamo_id;
		$detalleIntegrante->save();
		
		return Response::json(['message' => 'detalleIntegrante Actualizada'], 200);
	}

	public function activar(Request $request)
	{
				$detalleIntegrante = DetalleIntegrante::findOrFail($request->id);
		
				$detalleIntegrante->estado = '1';
				$detalleIntegrante->save();
	}

	public function desactivar(Request $request)
	{
		$detalleIntegrante = DetalleIntegrante::findOrFail($request->id);
		
				$detalleIntegrante->estado = '0';
				$detalleIntegrante->save();
	}
}