<?php

namespace App\Http\Controllers;

use App\AbonoPrestamo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Exception;

class AbonoPrestamoController extends Controller
{
	public function index(Request $request)
	{
		// Filtro por un criterio y estado
		$buscar = $request->buscar;
		$criterio = $request->criterio;
		$completo = (isset($request->completo)) ? $request->completo : $completo = 'false';
		
		if ($completo == 'false')
		{
			if ($buscar==''){
				$abonoPrestamo = AbonoPrestamo::with('detalle_integrante')->with('usuario')->orderBy('id', 'desc')->where('estado',1)->paginate(20);
			}
			else{
				$abonoPrestamo = AbonoPrestamo::with('detalle_integrante')->with('usuario')->where($criterio, 'like', '%'. $buscar . '%')->where('estado',1)->orderBy('id', 'desc')->paginate(20);
			}
		} else if ($completo == 'true'){
			if ($buscar==''){
				$abonoPrestamo = AbonoPrestamo::with('detalle_integrante')->with('usuario')->orderBy('id', 'desc')->paginate(20);
			}
			else{
				$abonoPrestamo = AbonoPrestamo::with('detalle_integrante')->with('usuario')->where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(20);
			}
		}
		return [
			'pagination' => [
				'total'        => $abonoPrestamo->total(),
				'current_page' => $abonoPrestamo->currentPage(),
				'per_page'     => $abonoPrestamo->perPage(),
				'last_page'    => $abonoPrestamo->lastPage(),
				'from'         => $abonoPrestamo->firstItem(),
				'to'           => $abonoPrestamo->lastItem(),
			],
			"abonos"=>$abonoPrestamo
		];
	}

	public function store(Request $request)
	{
		//if(!$request->ajax())return redirect('/');
		try {
			$abonoPrestamo = new AbonoPrestamo();
			$abonoPrestamo->cantidad_abono = $request->cantidad_abono;
			$abonoPrestamo->cantidad_restante = $request->cantidad_restante;
			$abonoPrestamo->descripcion = $request->descripcion;
			$abonoPrestamo->fecha_pago = $request->fecha_pago;
			$abonoPrestamo->mora = $request->mora;
			// $abonoPrestamo->microprestamo_id = $request->microprestamo_id;
			$abonoPrestamo->detalle_integrante_id = $request->detalle_integrante_id;
			$abonoPrestamo->usuario_id = $request->usuario_id;
			$abonoPrestamo->save();
			return Response::json(['message' => 'Abono Prestamo Creada'], 200);
			#return ['id' => $nino->id];
		} catch (Exception $e) {
			return Response::json(['message' => $e->getMessage()], 400);
		}
	}

	public function update(Request $request)
	{
		//if(!$request->ajax())return redirect('/');
		$abonoPrestamo = AbonoPrestamo::findOrFail($request->id);
		$abonoPrestamo->cantidad_abono = $request->cantidad_abono;
		$abonoPrestamo->cantidad_restante = $request->cantidad_restante;
		$abonoPrestamo->descripcion = $request->descripcion;
		$abonoPrestamo->fecha_pago = $request->fecha_pago;
		$abonoPrestamo->mora = $request->mora;
		// revisar si se deben de modificar estos o no
		// $abonoPrestamo->microprestamo_id = $request->microprestamo_id;
		$abonoPrestamo->detalle_integrante_id = $request->detalle_integrante_id;
		$abonoPrestamo->usuario_id = $request->usuario_id;
		$abonoPrestamo->save();
		return Response::json(['message' => 'Abono Prestamo Actualizado'], 200);
	}

	public function activar(Request $request)
	{
        #if(!$request->ajax())return redirect('/');
        $abonoPrestamo = AbonoPrestamo::findOrFail($request->id);
        $abonoPrestamo->estado = '1';
        $abonoPrestamo->save();
		return Response::json(['message' => 'AbonoPrestamo Desactivada'], 200);
	}

	public function desactivar(Request $request)
	{
		#if(!$request->ajax())return redirect('/');
		$abonoPrestamo = AbonoPrestamo::findOrFail($request->id);
		$abonoPrestamo->estado = '0';
		$abonoPrestamo->save();
		return Response::json(['message' => 'AbonoPrestamo Desactivada'], 200);
	}
}