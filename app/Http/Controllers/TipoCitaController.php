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
		#if (!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
		if ($buscar==''){
			$tipoCita = TipoCita::orderBy('id', 'desc')->paginate(20);
			#$tipoCita = TipoCita::leftJoin('sectors', 'sectors.aldea_id', '=', 'aldeas.id')->select('aldeas.nombre as tipoCita', 'sectors.nombre as sector')->orderBy('aldeas.id', 'desc')->paginate(20);
		}
		else{
			$tipoCita = TipoCita::where('nombre', 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(20);
		}
		
        return [
            'pagination' => [
                'total'        => $tipoCita->total(),
                'current_page' => $tipoCita->currentPage(),
                'per_page'     => $tipoCita->perPage(),
                'last_page'    => $tipoCita->lastPage(),
                'from'         => $tipoCita->firstItem(),
                'to'           => $tipoCita->lastItem(),
            ],
            'aldeas' => $tipoCita
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