<?php

namespace App\Http\Controllers;

use App\Profesion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Exception;

class ProfesionController extends Controller
{
    public function index(Request $request)
    {
		$buscar = $request->buscar;
		$criterio = $request->criterio;
		$completo = (isset($request->completo)) ? $request->completo :'false';
		$count = Profesion::all()->count();
		if ($completo == 'false')
		{
			if ($buscar==''){
				$profesion = Profesion::orderBy('id', 'desc')->where('estado',1)->paginate($count);
			}
			else{
				$profesion = Profesion::where([[$criterio, 'like',$buscar],['estado',1]])->orderBy('id', 'desc')->paginate($count);
			}
		} else if ($completo == 'true'){
			if ($buscar==''){
				$profesion = Profesion::orderBy('id', 'desc')->paginate($count);
			}
			else{
				$profesion = Profesion::where($criterio,'like',$buscar)->orderBy('id', 'desc')->paginate($count);
			}
		}
		else if($completo == 'select')
		{
			$profesion = Profesion::orderBy('id', 'desc')->where('estado',1)->paginate($count);
		}
        return [
            'profesiones' => $profesion
		];
    }
    public function store(Request $request)
    {
		#if(!$request->ajax())return redirect('/');
        try {
			$profesion = new Profesion();
			$profesion->nombre = $request->nombre;
			$profesion->save();
			return Response::json(['message' => 'Profesion Creada'], 200);
		} catch (Exception $e) {
            return Response::json(['message' => $e->getMessage()], 400);
		}
    }

    public function update(Request $request)
    {
		#if(!$request->ajax())return redirect('/');
        try {
		$profesion = Profesion::findOrFail($request->id);
		$profesion->nombre = $request->nombre;
		$profesion->save();
		return Response::json(['message' => 'Profesion Actualizada'], 200);
		} catch (Exception $e) {
			return Response::json(['message' => $e->getMessage()], 400);
		}
	}
	public function activar(Request $request)
	{
        #if(!$request->ajax())return redirect('/');
        $profesion = Profesion::findOrFail($request->id);
        $profesion->estado = '1';
        $profesion->save();
		return Response::json(['message' => 'Profesion Activada'], 200);
	}
	
	public function desactivar(Request $request)
	{
		#if(!$request->ajax())return redirect('/');
		$profesion = Profesion::findOrFail($request->id);
		$profesion->estado = '0';
		$profesion->save();
		return Response::json(['message' => 'Profesion Desactivada'], 200);
	}
}