<?php

namespace App\Http\Controllers;

use App\HistorialFotografia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Exception;

class HistorialFotografiaController extends Controller
{

    public function index(Request $request)
    {
		// Filtro por un criterio y estado
		$buscar = $request->buscar;
		$criterio = $request->criterio;
		$completo = (isset($request->completo)) ? $request->completo : $completo = 'false';
		
		if ($completo == 'false')
		{
			if ($buscar==''){
				$historialFotografias = HistorialFotografia::with('nino')->with('fotografia')->orderBy('id', 'desc')->where('estado',1)->paginate(20);
			}
			else{
				$historialFotografias = HistorialFotografia::with('nino')->with('fotografia')->where($criterio, 'like', '%'. $buscar . '%')->where('estado',1)->orderBy('id', 'desc')->paginate(20);
			}
		} else if ($completo == 'true'){
			if ($buscar==''){
				$historialFotografias = HistorialFotografia::with('nino')->with('fotografia')->orderBy('id', 'desc')->paginate(20);
			}
			else{
				$historialFotografias = HistorialFotografia::with('nino')->with('fotografia')->where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(20);
			}
		}
		return [
			'pagination' => [
				'total'        => $historialFotografias->total(),
				'current_page' => $historialFotografias->currentPage(),
				'per_page'     => $historialFotografias->perPage(),
				'last_page'    => $historialFotografias->lastPage(),
				'from'         => $historialFotografias->firstItem(),
				'to'           => $historialFotografias->lastItem(),
			],
			"HistorialPpis"=>$historialFotografias
		];
    }

    public function store(Request $request)
    {
		//if(!$request->ajax())return redirect('/');
		try {
			$historialFotografias = new HistorialFotografia();
			$historialFotografias->nino_id = $request->nino_id;
			$historialFotografias->fotografia_id = $request->fotografia_id;
			$historialFotografias->save();
			return Response::json(['message' => 'Historial Fotografia Creada'], 200);
			#return ['id' => $nino->id];
		} catch (Exception $e) {
			return Response::json(['message' => $e->getMessage()], 400);
		}
    }

    public function show(HistorialFotografia $historialFotografia)
    {
        //
    }

	public function activar(Request $request)
    {
        #if(!$request->ajax())return redirect('/');
        $historialFotografias = HistorialFotografia::findOrFail($request->id);
        $historialFotografias->estado = '1';
        $historialFotografias->save();
		return Response::json(['message' => 'Relacion Activada'], 200);
	}
	public function desactivar(Request $request)
    {
        #if(!$request->ajax())return redirect('/');
        $historialFotografias = HistorialFotografia::findOrFail($request->id);
        $historialFotografias->estado = '0';
        $historialFotografias->save();
		return Response::json(['message' => 'Relacion Desactivada'], 200);
	}

}