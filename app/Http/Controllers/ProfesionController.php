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
		#if (!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
		if ($buscar==''){
			$profesion = Profesion::orderBy('id', 'desc')->paginate(20);
			#$profesion = Profesion::leftJoin('sectors', 'sectors.aldea_id', '=', 'aldeas.id')->select('aldeas.nombre as profesion', 'sectors.nombre as sector')->orderBy('aldeas.id', 'desc')->paginate(20);
		}
		else{
			$profesion = Profesion::where('nombre', 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(20);
		}
		
        return [
            'pagination' => [
                'total'        => $profesion->total(),
                'current_page' => $profesion->currentPage(),
                'per_page'     => $profesion->perPage(),
                'last_page'    => $profesion->lastPage(),
                'from'         => $profesion->firstItem(),
                'to'           => $profesion->lastItem(),
            ],
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