<?php

namespace App\Http\Controllers;

use App\DestinoInversion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Exception;

class DestinoInversionController extends Controller
{
    public function index(Request $request)
    {
		$buscar = $request->buscar;
		$criterio = $request->criterio;
		$completo = (isset($request->completo)) ? $request->completo :'false';
		$count = DestinoInversion::all()->count();
		if ($completo == 'false')
		{
			if ($buscar==''){
				$destinoInversion = DestinoInversion::orderBy('id', 'desc')->where('estado',1)->paginate($count);
			}
			else{
				$destinoInversion = DestinoInversion::where([[$criterio, 'like',$buscar],['estado',1]])->orderBy('id', 'desc')->paginate($count);
			}
		} else if ($completo == 'true'){
			if ($buscar==''){
				$destinoInversion = DestinoInversion::orderBy('id', 'desc')->paginate($count);
			}
			else{
				$destinoInversion = DestinoInversion::where($criterio,'like',$buscar)->orderBy('id', 'desc')->paginate($count);
			}
		}
		return [
			"destinoInversions"=>$destinoInversion
		];
    }
    public function store(Request $request)
    {
		#if(!$request->ajax())return redirect('/');
        try {
			$destinoInversion = new DestinoInversion();
			$destinoInversion->nombre = $request->nombre;
			$destinoInversion->save();
			return Response::json(['message' => 'DestinoInversion Creada'], 200);
		} catch (Exception $e) {
            return Response::json(['message' => $e->getMessage()], 400);
		}
    }
    public function update(Request $request)
    {
		#if(!$request->ajax())return redirect('/');
        try {
		$destinoInversion = DestinoInversion::findOrFail($request->id);
		$destinoInversion->nombre = $request->nombre;
		$destinoInversion->save();
		return Response::json(['message' => 'DestinoInversion Actualizada'], 200);
		} catch (Exception $e) {
			return Response::json(['message' => $e->getMessage()], 400);
		}
	}
	public function activar(Request $request)
	{
        #if(!$request->ajax())return redirect('/');
        $destinoInversion = DestinoInversion::findOrFail($request->id);
        $destinoInversion->estado = '1';
        $destinoInversion->save();
		return Response::json(['message' => 'DestinoInversion Activada'], 200);
	}
	
	public function desactivar(Request $request)
	{
		#if(!$request->ajax())return redirect('/');
		$destinoInversion = DestinoInversion::findOrFail($request->id);
		$destinoInversion->estado = '0';
		$destinoInversion->save();
		return Response::json(['message' => 'DestinoInversion Desactivada'], 200);
	}
}