<?php

namespace App\Http\Controllers;

use App\Aldea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Exception;

class AldeaController extends Controller
{
    public function index(Request $request)
    {
		#if (!$request->ajax()) return redirect('/');

		$buscar = $request->buscar;
		$completo = (isset($request->completo)) ? $request->completo : 'false';

		if ($completo == 'false')
		{
			$count = Aldea::where('estado',1)->count();
			if ($buscar==''){
				$aldea = Aldea::orderBy('id', 'desc')->where('estado',1)->paginate($count);
			}
			else{
				$aldea = Aldea::where('estado',1)->where('nombre', 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate($count);
			}
		} else if ($completo == 'true'){
			$count = Aldea::all()->count();
			if ($buscar==''){
				$aldea = Aldea::orderBy('id', 'desc')->paginate($count);
			}
			else{
				$aldea = Aldea::where('nombre', 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate($count);
			}
		}
		else if($completo == 'select')
		{
			$count = Aldea::where('estado', 1)->count();
			$aldea = Aldea::orderBy('id', 'desc')->where('estado',1)->paginate($count);
		}
        return [
            'aldeas' => $aldea
		];
    }
    public function store(Request $request)
    {
		#if(!$request->ajax())return redirect('/');
        try {
			$aldea = new Aldea();
			$aldea->nombre = $request->nombre;
			$aldea->save();
			return Response::json(['message' => 'Aldea Creada'], 200);
		} catch (Exception $e) {
            return Response::json(['message' => $e->getMessage()], 400);
		}
    }

    public function show(Aldea $aldea)
    {
		#if(!$request->ajax())return redirect('/');
		return [
			'id'=> $aldea->id,
			'nombre'=> $aldea->nombre,
			'sectores'=> $aldea->sectores,
		];
    }

    public function update(Request $request)
    {
		#if(!$request->ajax())return redirect('/');
        try {
		$aldea = Aldea::findOrFail($request->id);
		$aldea->nombre = $request->nombre;
		$aldea->save();
		return Response::json(['message' => 'Aldea Actualizada'], 200);
		} catch (Exception $e) {
			return Response::json(['message' => $e->getMessage()], 400);
		}
	}
	public function activar(Request $request)
	{
        #if(!$request->ajax())return redirect('/');
        $aldea = Aldea::findOrFail($request->id);
        $aldea->estado = '1';
        $aldea->save();
		return Response::json(['message' => 'Aldea Activada'], 200);
	}
	
	public function desactivar(Request $request)
	{
		#if(!$request->ajax())return redirect('/');
		$aldea = Aldea::findOrFail($request->id);
		$aldea->estado = '0';
		$aldea->save();
		return Response::json(['message' => 'Aldea Desactivada'], 200);
	}
}
