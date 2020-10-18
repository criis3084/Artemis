<?php

namespace App\Http\Controllers;

use App\TipoCita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Exception;

class TipoCitaController extends Controller
{
    public function index(Request $request)
    {
		$buscar = $request->buscar;
		$criterio = $request->criterio;
		$completo = (isset($request->completo)) ? $request->completo :'false';
		$count = TipoCita::all()->count();
		if ($completo == 'false')
		{
			if ($buscar==''){
				$tipoCita = TipoCita::orderBy('id', 'desc')->where('estado',1)->paginate($count);
			}
			else{
				$tipoCita = TipoCita::where([[$criterio, 'like',$buscar],['estado',1]])->orderBy('id', 'desc')->paginate($count);
			}
		} else if ($completo == 'true'){
			if ($buscar==''){
				$tipoCita = TipoCita::orderBy('id', 'desc')->paginate($count);
			}
			else{
				$tipoCita = TipoCita::where($criterio,'like',$buscar)->orderBy('id', 'desc')->paginate($count);
			}
		}
		return [
			"tipoCitas"=>$tipoCita
		];
    }
    public function store(Request $request)
    {
		#if(!$request->ajax())return redirect('/');
        try {
			$tipoCita = new TipoCita();
			$tipoCita->nombre = $request->nombre;
			$tipoCita->descripcion = $request->descripcion;
			$tipoCita->save();
			return Response::json(['message' => 'TipoCita Creado'], 200);
		} catch (Exception $e) {
            return Response::json(['message' => $e->getMessage()], 400);
		}
    }

    public function update(Request $request)
    {
		#if(!$request->ajax())return redirect('/');
        try {
		$tipoCita = TipoCita::findOrFail($request->id);
		$tipoCita->nombre = $request->nombre;
		$tipoCita->descripcion = $request->descripcion;
		$tipoCita->save();
		return Response::json(['message' => 'TipoCita Actualizada'], 200);
		} catch (Exception $e) {
			return Response::json(['message' => $e->getMessage()], 400);
		}
	}
	public function activar(Request $request)
	{
        #if(!$request->ajax())return redirect('/');
        $tipoCita = TipoCita::findOrFail($request->id);
        $tipoCita->estado = '1';
        $tipoCita->save();
		return Response::json(['message' => 'TipoCita Activado'], 200);
	}
	
	public function desactivar(Request $request)
	{
		#if(!$request->ajax())return redirect('/');
		$tipoCita = TipoCita::findOrFail($request->id);
		$tipoCita->estado = '0';
		$tipoCita->save();
		return Response::json(['message' => 'TipoCita Desactivado'], 200);
	}
}