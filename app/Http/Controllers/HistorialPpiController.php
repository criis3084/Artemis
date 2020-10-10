<?php

namespace App\Http\Controllers;

use App\HistorialClinico;
use App\HistorialPpi;
use App\Ppi;
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
		$completo = (isset($request->completo)) ? $request->completo : 'false';
		$count = HistorialPpi::all()->count();
		if ($completo == 'false')
		{
			if ($buscar==''){
				$historialPpi = HistorialPpi::with('nino')->with('ppi')->with('datos_nino')->orderBy('id', 'desc')->where('estado',1)->paginate($count);
			}
			else{
				$historialPpi = HistorialPpi::with('nino')->with('ppi')->with('datos_nino')->where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate($count);
			}
		} else if ($completo == 'true'){
			if ($buscar==''){
				$historialPpi = HistorialPpi::with('nino')->with('ppi')->with('datos_nino')->orderBy('id', 'desc')->paginate($count);
			}
			else{
				$historialPpi = HistorialPpi::with('nino')->with('ppi')->with('datos_nino')->where([$criterio, 'like', '%'. $buscar . '%'],['estado',1])->orderBy('id', 'desc')->paginate($count);

			}
		}
		return [
			"historialPpis"=>$historialPpi
		];
    }

    public function store(Request $request)
    {
		if (!isset($request->ppi_id))
		{
			$ppi = new Ppi();
			$ppi->respuesta1 = $request->respuesta1;
			$ppi->respuesta2 = $request->respuesta2;
			$ppi->respuesta3 = $request->respuesta3;
			$ppi->respuesta4 = $request->respuesta4;
			$ppi->respuesta5 = $request->respuesta5;
			$ppi->respuesta6 = $request->respuesta6;
			$ppi->respuesta7 = $request->respuesta7;
			$ppi->respuesta8 = $request->respuesta8;
			$ppi->respuesta9 = $request->respuesta9;
			$ppi->respuesta10 = $request->respuesta10;
			$ppi->total = $request->total;
			$ppi->save();
			$ppiT=$ppi->id;
		}
		else{
			$ppiT = $request->ppi_id;
		}
		try {
			$historialPpi = new HistorialPpi();
			$historialPpi->fecha_estudio = $request->fecha_estudio;
			$historialPpi->nino_id = $request->nino_id;
			$historialPpi->ppi_id = $ppiT;
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
        $historialPpi->estado = '1';
        $historialPpi->save();
		return Response::json(['message' => 'PPI Activado'], 200);
	}
	public function desactivar(Request $request)
    {
        #if(!$request->ajax())return redirect('/');
        $historialPpi = HistorialPpi::findOrFail($request->id);
        $historialPpi->estado = '0';
        $historialPpi->save();
		return Response::json(['message' => 'PPI Desactivado'], 200);
	}

}
