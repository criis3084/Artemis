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
		#if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
		if ($buscar==''){
			$tipoVivienda = TipoVivienda::orderBy('id', 'desc')->paginate(20);
			#$tipoVivienda = TipoVivienda::leftJoin('sectors', 'sectors.aldea_id', '=', 'aldeas.id')->select('aldeas.nombre as tipoVivienda', 'sectors.nombre as sector')->orderBy('aldeas.id', 'desc')->paginate(20);
		}
		else{
			$tipoVivienda = TipoVivienda::where('nombre', 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(20);
		}
		
        return [
            'pagination' => [
                'total'        => $tipoVivienda->total(),
                'current_page' => $tipoVivienda->currentPage(),
                'per_page'     => $tipoVivienda->perPage(),
                'last_page'    => $tipoVivienda->lastPage(),
                'from'         => $tipoVivienda->firstItem(),
                'to'           => $tipoVivienda->lastItem(),
            ],
            'destinosInversiones' => $tipoVivienda
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
			return Response::json(['message' => 'TipoVivienda Creada'], 200);
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