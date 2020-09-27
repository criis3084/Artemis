<?php

namespace App\Http\Controllers;

use App\HistorialClinico;
use App\HistorialPpi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Exception;

class HistorialPpiController extends Controller
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
				$historialPpi = HistorialPpi::with('nino')->with('ppi')->with('datos_nino')->orderBy('id', 'desc')->where('estado',1)->paginate(20);
			}
			else{
				$historialPpi = HistorialPpi::with('nino')->with('ppi')->with('datos_nino')->where($criterio, 'like', '%'. $buscar . '%')->where('estado',1)->orderBy('id', 'desc')->paginate(20);
			}
		} else if ($completo == 'true'){
			if ($buscar==''){
				$historialPpi = HistorialPpi::with('nino')->with('ppi')->with('datos_nino')->orderBy('id', 'desc')->paginate(20);
			}
			else{
				$historialPpi = HistorialPpi::with('nino')->with('ppi')->with('datos_nino')->where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(20);
			}
		}
		return [
			'pagination' => [
				'total'        => $historialPpi->total(),
				'current_page' => $historialPpi->currentPage(),
				'per_page'     => $historialPpi->perPage(),
				'last_page'    => $historialPpi->lastPage(),
				'from'         => $historialPpi->firstItem(),
				'to'           => $historialPpi->lastItem(),
			],
			"historialPpis"=>$historialPpi
		];
    }

    public function store(Request $request)
    {
		//if(!$request->ajax())return redirect('/');
		try {
			$historialPpi = new HistorialPpi();
			$historialPpi->nino_id = $request->nino_id;
			$historialPpi->ppi_id = $request->ppi_id;
			$historialPpi->save();
			return Response::json(['message' => 'Historial Ppi Creado'], 200);
			#return ['id' => $nino->id];
		} catch (Exception $e) {
			return Response::json(['message' => $e->getMessage()], 400);
		}
    }

    public function show(HistorialPpi $historialPpi)
    {
        //
    }

	public function activar(Request $request)
    {
        #if(!$request->ajax())return redirect('/');
        $historialPpi = HistorialPpi::findOrFail($request->id);
        $historialPpi->estado = '0';
        $historialPpi->save();
		return Response::json(['message' => 'Relacion Desactivada'], 200);
	}
	public function desactivar(Request $request)
    {
        #if(!$request->ajax())return redirect('/');
        $historialPpi = HistorialPpi::findOrFail($request->id);
        $historialPpi->estado = '0';
        $historialPpi->save();
		return Response::json(['message' => 'Relacion Desactivada'], 200);
	}

}
