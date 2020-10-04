<?php

namespace App\Http\Controllers;

use App\HistorialEstudio;
use Illuminate\Http\Request;

class HistorialEstudioController extends Controller
{

    public function index()
    {
        $buscar = $request->buscar;
		$criterio = $request->criterio;
		$completo = (isset($request->completo)) ? $request->completo : $completo = 'false';
		
		if ($completo == 'false')
		{
			$count = HistorialEstudio::where('estado',1)->count();
			if ($buscar==''){
				$historialEstudio = HistorialEstudio::with('estudioSocieconomico')->with('relacion')->orderBy('id', 'desc')->where('estado',1)->paginate($count);
			}
			else{
				$historialEstudio = HistorialEstudio::with('estudioSocieconomico')->with('relacion')->where($criterio, 'like', '%'. $buscar . '%')->where('estado',1)->orderBy('id', 'desc')->paginate($count);
			}
		} else if ($completo == 'true'){
			$count = HistorialEstudio::all()->count();
			if ($buscar==''){
				$historialEstudio = HistorialEstudio::with('estudioSocieconomico')->with('relacion')->orderBy('id', 'desc')->paginate($count);
			}
			else{
				$historialEstudio = HistorialEstudio::with('estudioSocieconomico')->with('relacion')->where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate($count);
			}
		}
		return [
			"historialEstudios"=>$historialEstudio
		];
    }

    public function store(Request $request)
    {
        try {
			$historialEstudio = new HistorialEstudio();
			$historialEstudio->estudio_socioeconomico_id = $request->estudio_socioeconomico_id;
			$historialEstudio->relacion_id = $request->relacion_id;
			$historialEstudio->save();
			return Response::json(['message' => 'Historial de estudio Creada'], 200);
			#return ['id' => $nino->id];
		} catch (Exception $e) {
			return Response::json(['message' => $e->getMessage()], 400);
		}
    }

    public function update(Request $request, HistorialEstudio $historialEstudio)
    {
        $historialEstudio = HistorialEstudio::findOrFail($request->id);
        $historialEstudio->estudio_socioeconomico_id = $request->estudio_socioeconomico_id;
        $historialEstudio->relacion_id = $request->relacion_id;
		$historialEstudio->save();
		return Response::json(['message' => 'Historial de estudio Actualizado'], 200);
    }

    public function activar(Request $request)
	{
        #if(!$request->ajax())return redirect('/');
        $historialEstudio = HistorialEstudio::findOrFail($request->id);
        $historialEstudio->estado = '1';
        $historialEstudio->save();
		return Response::json(['message' => 'Historial de estudio Activada'], 200);
	}
	
	public function desactivar(Request $request)
	{
		#if(!$request->ajax())return redirect('/');
		$historialEstudio = HistorialEstudio::findOrFail($request->id);
		$historialEstudio->estado = '0';
		$historialEstudio->save();
		return Response::json(['message' => 'Historial de estudio Desactivada'], 200);

	}
}
