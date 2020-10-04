<?php

namespace App\Http\Controllers;

use App\HistorialAbonoVivienda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Exception;

class HistorialAbonoViviendaController extends Controller
{
    public function index(Request $request)
    {
		// Filtro por un criterio y estado
		$buscar = $request->buscar;
		$criterio = $request->criterio;
		$completo = (isset($request->completo)) ? $request->completo : $completo = 'false';
		$count = HistorialAbonoVivienda::all()->count();
		if ($completo == 'false')
		{
			if ($buscar==''){
				$historialAbonoVivienda = HistorialAbonoVivienda::with('abono')->with('vivienda')->orderBy('id', 'desc')->where('estado',1)->paginate($count);
			}
			else{
				$historialAbonoVivienda = HistorialAbonoVivienda::with('abono')->with('vivienda')->where($criterio, 'like', '%'. $buscar . '%')->where('estado',1)->orderBy('id', 'desc')->paginate($count);
			}
		} else if ($completo == 'true'){
			if ($buscar==''){
				$historialAbonoVivienda = HistorialAbonoVivienda::with('abono')->with('vivienda')->orderBy('id', 'desc')->paginate($count);
			}
			else{
				$historialAbonoVivienda = HistorialAbonoVivienda::with('abono')->with('vivienda')->where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate($count);
			}
		}
		return [
			"historialAbonoViviendas"=>$historialAbonoVivienda
		];
    }

    public function store(Request $request)
    {
		//if(!$request->ajax())return redirect('/');
		try {
			$historialAbonoVivienda = new HistorialAbonoVivienda();
			$historialAbonoVivienda->abono_vivienda_id = $request->abono_vivienda_id;
			$historialAbonoVivienda->vivienda_id = $request->vivienda_id;
			$historialAbonoVivienda->save();

			return Response::json(['message' => 'Historial Abono vivienda creado'], 200);
			#return ['id' => $nino->id];
		} catch (Exception $e) {
			return Response::json(['message' => $e->getMessage()], 400);
		}
	}
	
	public function activar(Request $request)
    {
        #if(!$request->ajax())return redirect('/');
        $historialAbonoVivienda = HistorialAbonoVivienda::findOrFail($request->id);
        $historialAbonoVivienda->estado = '1';
        $historialAbonoVivienda->save();
		return Response::json(['message' => 'Historial Activado'], 200);
	}
	public function desactivar(Request $request)
    {
        #if(!$request->ajax())return redirect('/');
        $historialAbonoVivienda = HistorialAbonoVivienda::findOrFail($request->id);
        $historialAbonoVivienda->estado = '0';
        $historialAbonoVivienda->save();
		return Response::json(['message' => 'historial Desactivado'], 200);
	}
}
