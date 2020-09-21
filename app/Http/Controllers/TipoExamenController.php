<?php

namespace App\Http\Controllers;

use App\TipoExamen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Exception;

class TipoExamenController extends Controller
{
    public function index(Request $request)
    {
		#if (!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
		if ($buscar==''){
			$tipoExamen = TipoExamen::orderBy('id', 'desc')->paginate(20);
			#$tipoExamen = TipoExamen::leftJoin('sectors', 'sectors.aldea_id', '=', 'aldeas.id')->select('aldeas.nombre as tipoExamen', 'sectors.nombre as sector')->orderBy('aldeas.id', 'desc')->paginate(20);
		}
		else{
			$tipoExamen = TipoExamen::where('nombre', 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(20);
		}
		
        return [
            'pagination' => [
                'total'        => $tipoExamen->total(),
                'current_page' => $tipoExamen->currentPage(),
                'per_page'     => $tipoExamen->perPage(),
                'last_page'    => $tipoExamen->lastPage(),
                'from'         => $tipoExamen->firstItem(),
                'to'           => $tipoExamen->lastItem(),
            ],
            'aldeas' => $tipoExamen
		];
    }
    public function store(Request $request)
    {
		#if(!$request->ajax())return redirect('/');
        try {
			$tipoExamen = new TipoExamen();
			$tipoExamen->nombre = $request->nombre;
			$tipoExamen->save();
			return Response::json(['message' => 'TipoExamen Creado'], 200);
		} catch (Exception $e) {
            return Response::json(['message' => $e->getMessage()], 400);
		}
    }

    public function update(Request $request)
    {
		#if(!$request->ajax())return redirect('/');
        try {
		$tipoExamen = TipoExamen::findOrFail($request->id);
		$tipoExamen->nombre = $request->nombre;
		$tipoExamen->save();
		return Response::json(['message' => 'TipoExamen Actualizada'], 200);
		} catch (Exception $e) {
			return Response::json(['message' => $e->getMessage()], 400);
		}
	}
	public function activar(Request $request)
	{
        #if(!$request->ajax())return redirect('/');
        $tipoExamen = TipoExamen::findOrFail($request->id);
        $tipoExamen->estado = '1';
        $tipoExamen->save();
		return Response::json(['message' => 'TipoExamen Activado'], 200);
	}
	
	public function desactivar(Request $request)
	{
		#if(!$request->ajax())return redirect('/');
		$tipoExamen = TipoExamen::findOrFail($request->id);
		$tipoExamen->estado = '0';
		$tipoExamen->save();
		return Response::json(['message' => 'TipoExamen Desactivado'], 200);
	}
}