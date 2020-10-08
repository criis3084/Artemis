<?php

namespace App\Http\Controllers;

use App\EstudioSocioeconomico;
use App\HistorialEstudio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Exception;

class HistorialEstudioController extends Controller
{

    public function index(Request $request)
    {
        $buscar = $request->buscar;
		$criterio = $request->criterio;
		$completo = (isset($request->completo)) ? $request->completo : $completo = 'false';
		
		if ($completo == 'false')
		{
			$count = HistorialEstudio::where('estado',1)->count();
			if ($buscar==''){
				$historialEstudio = HistorialEstudio::with('estudioSocieconomico')->with('datos_nino')->with('nino')->orderBy('id', 'desc')->where('estado',1)->paginate($count);
			}
			else{
				$historialEstudio = HistorialEstudio::with('estudioSocieconomico')->with('datos_nino')->with('nino')->where($criterio, 'like', '%'. $buscar . '%')->where('estado',1)->orderBy('id', 'desc')->paginate($count);
			}
		} else if ($completo == 'true'){
			$count = HistorialEstudio::all()->count();
			if ($buscar==''){
				$historialEstudio = HistorialEstudio::with('estudioSocieconomico')->with('datos_nino')->with('nino')->orderBy('id', 'desc')->paginate($count);
			}
			else{
				$historialEstudio = HistorialEstudio::with('estudioSocieconomico')->with('datos_nino')->with('nino')->where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate($count);
			}
		}
		return [
			"historialEstudios"=>$historialEstudio
		];
    }

    public function store(Request $request)
    {
		if (!isset($request->estudio_id))
		{
			$estudioSocioeconomico = new EstudioSocioeconomico();
			$estudioSocioeconomico->fecha_boleta = $request->fecha_boleta;
			$estudioSocioeconomico->fecha_ingreso = $request->fecha_ingreso;
			$estudioSocioeconomico->total_ingresos = $request->total_ingresos;
			$estudioSocioeconomico->alimentacion = $request->alimentacion;
			$estudioSocioeconomico->situacion_vivienda = $request->situacion_vivienda;
			$estudioSocioeconomico->descripcion_costo = $request->descripcion_costo;
			$estudioSocioeconomico->luz = $request->luz;
			$estudioSocioeconomico->agua = $request->agua;
			$estudioSocioeconomico->drenaje = $request->drenaje;
			$estudioSocioeconomico->cantidad_cuartos = $request->cantidad_cuartos;
			$estudioSocioeconomico->bano = $request->bano;
			$estudioSocioeconomico->paredes = $request->paredes;
			$estudioSocioeconomico->techo = $request->techo;
			$estudioSocioeconomico->piso = $request->piso;
			$estudioSocioeconomico->evaluacion_diagnostico = $request->evaluacion_diagnostico;
			$estudioSocioeconomico->save();
			$estudioT = $estudioSocioeconomico->id;
		}else
		{
			$estudioT = $request->estudio_id;
		}
		try {
			$historialEstudio = new HistorialEstudio();

			$historialEstudio->estudio_socioeconomico_id = $estudioT;
			$historialEstudio->relacion_id = $request->relacion_id;

			$historialEstudio->save();

			return Response::json(['message' => 'Historial Estudio Creado'], 200);
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
