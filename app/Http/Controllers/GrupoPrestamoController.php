<?php

namespace App\Http\Controllers;

use App\GrupoPrestamo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Exception;

class GrupoPrestamoController extends Controller
{
    public function index(Request $request)
    {
		#if (!$request->ajax()) return redirect('/');
		$buscar = $request->buscar;
		$count = GrupoPrestamo::all()->count();
		if ($buscar==''){
			$grupoPrestamo = GrupoPrestamo::with('integrantes')->orderBy('id', 'desc')->paginate($count);
			#$grupoPrestamo = GrupoPrestamo::leftJoin('sectors', 'sectors.aldea_id', '=', 'aldeas.id')->select('aldeas.nombre as grupoPrestamo', 'sectors.nombre as sector')->orderBy('aldeas.id', 'desc')->paginate(20);
		}
		else{
			$grupoPrestamo = GrupoPrestamo::with('integrantes')->where('nombre', 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate($count);
		}
		
        return [
            'grupos' => $grupoPrestamo
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
			$grupoPrestamo->save();
			return Response::json(['message' => 'GrupoPrestamo Creada'], 200);
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