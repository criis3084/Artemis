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
		if ($buscar==''){
			$aldea = Aldea::orderBy('id', 'desc')->where('estado',1)->paginate(20);
			#$aldea = Aldea::leftJoin('sectors', 'sectors.aldea_id', '=', 'aldeas.id')->select('aldeas.nombre as aldea', 'sectors.nombre as sector')->orderBy('aldeas.id', 'desc')->paginate(20);
		}
		else{
			$aldea = Aldea::where('nombre', 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(3);
		}
		
        return [
            'pagination' => [
                'total'        => $aldea->total(),
                'current_page' => $aldea->currentPage(),
                'per_page'     => $aldea->perPage(),
                'last_page'    => $aldea->lastPage(),
                'from'         => $aldea->firstItem(),
                'to'           => $aldea->lastItem(),
            ],
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
		$aldea = Aldea::findOrFail($request->id);
		$aldea->nombre = $request->nombre;
		$aldea->save();
		return Response::json(['message' => 'Aldea Actualizada'], 200);
    }

	public function activar(Request $request)
	{
		//
	}
	public function desactivar(Request $request)
	{
		//
	}
}
