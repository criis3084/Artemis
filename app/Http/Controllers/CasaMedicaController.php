<?php

namespace App\Http\Controllers;

use App\CasaMedica;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Exception;

class CasaMedicaController extends Controller
{
    public function index(Request $request)
    {
		#if (!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
		if ($buscar==''){
			$casaMedica = CasaMedica::orderBy('id', 'desc')->paginate(20);
			#$casaMedica = CasaMedica::leftJoin('sectors', 'sectors.aldea_id', '=', 'aldeas.id')->select('aldeas.nombre as casaMedica', 'sectors.nombre as sector')->orderBy('aldeas.id', 'desc')->paginate(20);
		}
		else{
			$casaMedica = CasaMedica::where('nombre', 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(20);
		}
		
        return [
            'pagination' => [
                'total'        => $casaMedica->total(),
                'current_page' => $casaMedica->currentPage(),
                'per_page'     => $casaMedica->perPage(),
                'last_page'    => $casaMedica->lastPage(),
                'from'         => $casaMedica->firstItem(),
                'to'           => $casaMedica->lastItem(),
            ],
            'casaMedicas' => $casaMedica
		];
    }
    public function store(Request $request)
    {
		#if(!$request->ajax())return redirect('/');
        try {
			$casaMedica = new CasaMedica();
			$casaMedica->nombre = $request->nombre;
			$casaMedica->save();
			return Response::json(['message' => 'CasaMedica Creada'], 200);
		} catch (Exception $e) {
            return Response::json(['message' => $e->getMessage()], 400);
		}
    }

    public function show(CasaMedica $casaMedica)
    {
		#if(!$request->ajax())return redirect('/');
		return [
			'id'=> $casaMedica->id,
			'nombre'=> $casaMedica->nombre,
		];
    }

    public function update(Request $request)
    {
		#if(!$request->ajax())return redirect('/');
        try {
		$casaMedica = CasaMedica::findOrFail($request->id);
		$casaMedica->nombre = $request->nombre;
		$casaMedica->save();
		return Response::json(['message' => 'CasaMedica Actualizada'], 200);
		} catch (Exception $e) {
			return Response::json(['message' => $e->getMessage()], 400);
		}
	}
	public function activar(Request $request)
	{
        #if(!$request->ajax())return redirect('/');
        $casaMedica = CasaMedica::findOrFail($request->id);
        $casaMedica->estado = '1';
        $casaMedica->save();
		return Response::json(['message' => 'CasaMedica Activada'], 200);
	}
	
	public function desactivar(Request $request)
	{
		#if(!$request->ajax())return redirect('/');
		$casaMedica = CasaMedica::findOrFail($request->id);
		$casaMedica->estado = '0';
		$casaMedica->save();
		return Response::json(['message' => 'CasaMedica Desactivada'], 200);

	}
}