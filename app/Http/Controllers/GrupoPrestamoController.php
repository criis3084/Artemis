<?php

namespace App\Http\Controllers;

use Exception;
use App\GrupoPrestamo;
use App\DetalleIntegrante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class GrupoPrestamoController extends Controller
{
    public function index(Request $request)
    {
		// Filtro por un criterio y estado
		$buscar = $request->buscar;
		$criterio = $request->criterio;
		$completo = (isset($request->completo)) ? $request->completo :'false';
		$count = GrupoPrestamo::all()->count();
		if ($completo == 'false')
		{
			if ($buscar==''){
				$grupoPrestamo = GrupoPrestamo::orderBy('id', 'desc')->where('estado',1)->paginate($count);
			}
			else{
				$grupoPrestamo = GrupoPrestamo::where([[$criterio, 'like',$buscar],['estado',1]])->orderBy('id', 'desc')->paginate($count);
			}
		} else if ($completo == 'true'){
			if ($buscar==''){
				$grupoPrestamo = GrupoPrestamo::orderBy('id', 'desc')->paginate($count);
			}
			else{
				$grupoPrestamo = GrupoPrestamo::where($criterio,'like',$buscar)->orderBy('id', 'desc')->paginate($count);
			}
		}
		return [
			"grupoPrestamos"=>$grupoPrestamo
		];
	}
	
	public function store(Request $request)
    {
		#if(!$request->ajax())return redirect('/');
        try {
			$grupoPrestamo = new GrupoPrestamo();
			$grupoPrestamo->nombre = $request->nombre;
			$grupoPrestamo->descripcion = $request->descripcion;
			$grupoPrestamo->cantidad_ultimo_prestamo = $request->cantidad_ultimo_prestamo;
			$grupoPrestamo->cantidad_prestamo_actual = $request->cantidad_prestamo_actual;
			$grupoPrestamo->interes_ultimo_prestamo = $request->interes_ultimo_prestamo;
			$grupoPrestamo->save();
			
			return ['id'=>$grupoPrestamo->id];
		} catch (Exception $e) {
            return Response::json(['message' => $e->getMessage()], 400);
		}
    }

    public function update(Request $request)
    {
		#if(!$request->ajax())return redirect('/');
        try {
		$grupoPrestamo = GrupoPrestamo::findOrFail($request->id);
		$grupoPrestamo->nombre = $request->nombre;
		$grupoPrestamo->descripcion = $request->descripcion;
		#$grupoPrestamo->cantidad_ultimo_prestamo = $request->cantidad_ultimo_prestamo;
		#$grupoPrestamo->cantidad_ultimo_prestamo = $request->cantidad_ultimo_prestamo;
		$grupoPrestamo->save();
		return Response::json(['message' => 'GrupoPrestamo Actualizada'], 200);
		} catch (Exception $e) {
			return Response::json(['message' => $e->getMessage()], 400);
		}
	}
	public function activar(Request $request)
	{
        #if(!$request->ajax())return redirect('/');
        $grupoPrestamo = GrupoPrestamo::findOrFail($request->id);
        $grupoPrestamo->estado = '1';
        $grupoPrestamo->save();
		return Response::json(['message' => 'GrupoPrestamo Activada'], 200);
	}
	
	public function desactivar(Request $request)
	{
		#if(!$request->ajax())return redirect('/');
		$grupoPrestamo = GrupoPrestamo::findOrFail($request->id);
		$grupoPrestamo->estado = '0';
		$grupoPrestamo->save();
		return Response::json(['message' => 'GrupoPrestamo Desactivada'], 200);
	}
}