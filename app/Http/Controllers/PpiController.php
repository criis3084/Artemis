<?php

namespace App\Http\Controllers;

use App\Fotografia;
use App\Ppi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Exception;

class PpiController extends Controller
{
	public function index(Request $request)
    {
		#if(!$request->ajax())return redirect('/');
		// Filtro por un criterio y estado
		$buscar = $request->buscar;
		$criterio = $request->criterio;
		$completo = (isset($request->completo)) ? $request->completo : $completo = 'false';
		$count = Ppi::all()->count();
		
		if ($completo == 'false')
		{
			if ($buscar==''){
				/*
				$persona_sin_acceso = PersonaSinAcceso::join('sectors', 'sectors.id', '=', 'persona_sin_accesos.id')
				->select('persona_sin_accesos.*','sectors.nombre as nombre_sector','aldeas.nombre as nombre_aldea')
				->orderBy('id', 'desc')->paginate(20);
				*/
				$ppi = Ppi::orderBy('id', 'desc')->where('estado',1)->paginate($count);
			}
			else{
				$ppi = Ppi::where([[$criterio, 'like', $buscar],['estado',1]])->orderBy('id', 'desc')->paginate($count);
			}
		} else if ($completo == 'true'){
			if ($buscar==''){
				$ppi = Ppi::orderBy('id', 'desc')->paginate($count);
			}
			else{
				$ppi = Ppi::where($criterio, 'like', $buscar)->orderBy('id', 'desc')->paginate($count);
			}
		}

		return [
			"ppis"=>$ppi
		];
    }
    public function store(Request $request)
    {
		#if(!$request->ajax())return redirect('/');
        try {
			$ppi = new Ppi();
			$ppi->respuesta1 = $request->respuesta1;
			$ppi->respuesta2 = $request->respuesta2;
			$ppi->respuesta3 = $request->respuesta3;
			$ppi->respuesta4 = $request->respuesta4;
			$ppi->respuesta5 = $request->respuesta5;
			$ppi->respuesta6 = $request->respuesta6;
			$ppi->respuesta7 = $request->respuesta7;
			$ppi->respuesta8 = $request->respuesta8;
			$ppi->respuesta9 = $request->respuesta9;
			$ppi->respuesta10 = $request->respuesta10;
			$ppi->total = $request->total;
			$ppi->save();
			return ['id' => $ppi->id];
		} catch (Exception $e) {
            return Response::json(['message' => $e->getMessage()], 400);
		}
    }

    public function show(Ppi $ppi)
    {
		return [
			'id'=> $ppi->id,
			'respuesta1'=> $ppi->respuesta1,
			'respuesta2'=> $ppi->respuesta2,
			'respuesta3'=> $ppi->respuesta3,
			'respuesta4'=> $ppi->respuesta4,
			'respuesta5'=> $ppi->respuesta5,
			'respuesta6'=> $ppi->respuesta6,
			'respuesta7'=> $ppi->respuesta7,
			'respuesta8'=> $ppi->respuesta8,
			'respuesta9'=> $ppi->respuesta9,
			'respuesta10'=> $ppi->respuesta10,
			'total'=> $ppi->total
		];
    }

    public function update(Request $request)
    {
		$ppi = Ppi::findOrFail($request->id);
		$ppi->respuesta1 = $request->respuesta1;
		$ppi->respuesta2 = $request->respuesta2;
		$ppi->respuesta3 = $request->respuesta3;
		$ppi->respuesta4 = $request->respuesta4;
		$ppi->respuesta5 = $request->respuesta5;
		$ppi->respuesta6 = $request->respuesta6;
		$ppi->respuesta7 = $request->respuesta7;
		$ppi->respuesta8 = $request->respuesta8;
		$ppi->respuesta9 = $request->respuesta9;
		$ppi->respuesta10 = $request->respuesta10;
		$ppi->total = $request->total;
		$ppi->save();
		return Response::json(['message' => 'Ppi Actualizado'], 200);
    }

    public function activar(Request $request)
    {
		$ppi = Ppi::findOrFail($request->id);
        $ppi->estado = '0';
		$ppi->save();
		return Response::json(['message' => 'Ppi Activado'], 200);
    }
    public function desactivar(Request $request)
    {
		$ppi = Ppi::findOrFail($request->id);
        $ppi->estado = '0';
		$ppi->save();
		return Response::json(['message' => 'Ppi Desactivado'], 200);
    }
}
