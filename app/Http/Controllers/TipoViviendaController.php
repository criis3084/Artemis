<?php

namespace App\Http\Controllers;

use App\TipoVivienda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Exception;

class TipoViviendaController extends Controller
{
    public function index(Request $request)
    {
		$buscar = $request->buscar;
		$criterio = $request->criterio;
		$completo = (isset($request->completo)) ? $request->completo : $completo = 'false';
		$count = TipoVivienda::all()->count();
		
		if ($completo == 'false')
		{
			if ($buscar==''){
				$tipoVivienda = TipoVivienda::with('viviendas')->orderBy('id', 'desc')->where('estado',1)->paginate($count);
			}
			else{
				$tipoVivienda = TipoVivienda::with('viviendas')->where([[$criterio, 'like', $buscar],['estado',1]])->orderBy('id', 'desc')->paginate($count);
			}
		} else if ($completo == 'true'){
			if ($buscar==''){
				$tipoVivienda = TipoVivienda::with('viviendas')->orderBy('id', 'desc')->paginate($count);
			}
			else{
				$tipoVivienda = TipoVivienda::with('viviendas')->where($criterio, 'like', $buscar)->orderBy('id', 'desc')->paginate($count);
			}
		}
		return [
			"tipoViviendas"=>$tipoVivienda
		];
    }
    public function store(Request $request)
    {
		#if(!$request->ajax())return redirect('/');
        try {
			$tipoVivienda = new TipoVivienda();
			$tipoVivienda->nombre = $request->nombre;
			$tipoVivienda->descripcion = $request->descripcion;
			$tipoVivienda->save();
			return Response::json(['message' => 'Tipo de vivienda Creada'], 200);
		} catch (Exception $e) {
			return Response::json(['message' => $e->getMessage()], 400);
		}
    }
    public function update(Request $request)
    {
		#if(!$request->ajax())return redirect('/');
        try {
			$tipoVivienda = TipoVivienda::findOrFail($request->id);
			$tipoVivienda->nombre = $request->nombre;
			$tipoVivienda->descripcion = $request->descripcion;
		$tipoVivienda->save();
		return Response::json(['message' => 'TipoVivienda Actualizada'], 200);
		} catch (Exception $e) {
			return Response::json(['message' => $e->getMessage()], 400);
		}
	}
	public function activar(Request $request)
	{
        #if(!$request->ajax())return redirect('/');
        $tipoVivienda = TipoVivienda::findOrFail($request->id);
        $tipoVivienda->estado = '1';
        $tipoVivienda->save();
		return Response::json(['message' => 'TipoVivienda Activada'], 200);
	}
	
	public function desactivar(Request $request)
	{
		#if(!$request->ajax())return redirect('/');
		$tipoVivienda = TipoVivienda::findOrFail($request->id);
		$tipoVivienda->estado = '0';
		$tipoVivienda->save();
		return Response::json(['message' => 'TipoVivienda Desactivada'], 200);
	}
}