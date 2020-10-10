<?php

namespace App\Http\Controllers;

use App\HistorialCorrespondencia;
use App\Correspondencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Exception;
use Illuminate\Support\Facades\File;

class HistorialCorrespondenciaController extends Controller
{
    public function index(Request $request)
    {
		// Filtro por un criterio y estado
		$buscar = $request->buscar;
		$criterio = $request->criterio;
		$completo = (isset($request->completo)) ? $request->completo : $completo = 'false';
		if ($completo == 'false')
		{
			$count = HistorialCorrespondencia::where('estado',1)->count();
			if ($buscar==''){
				$historialCorrespondencia = HistorialCorrespondencia::with('correspondencia')->with('apadrinamiento')->orderBy('id', 'desc')->where('estado',1)->paginate($count);
			}
			else{
				$historialCorrespondencia = HistorialCorrespondencia::with('correspondencia')->with('apadrinamiento')->where($criterio, 'like', '%'. $buscar . '%')->where('estado',1)->orderBy('id', 'desc')->paginate($count);
			}
		} else if ($completo == 'true'){
			$count = HistorialCorrespondencia::all()->count();
			if ($buscar==''){
				$historialCorrespondencia = HistorialCorrespondencia::with('correspondencia')->with('apadrinamiento')->orderBy('id', 'desc')->paginate($count);
			}
			else{
				$historialCorrespondencia = HistorialCorrespondencia::with('correspondencia')->with('apadrinamiento')->where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate($count);
			}
		}
		return [
			"historialCorrespondencias"=>$historialCorrespondencia
		];
    }

    public function store(Request $request)
    {
		//if(!$request->ajax())return redirect('/');
		try {
			$correspondencia = new Correspondencia();
			$correspondencia->ruta_imagen = $request->ruta_imagen;
			$correspondencia->descripcion = $request->descripcion;
			$correspondencia->save();

			$historialCorrespondencia = new HistorialCorrespondencia();
			$historialCorrespondencia->correspondencia_id = $correspondencia->id;
			$historialCorrespondencia->apadrinamiento_id = $request->apadrinamiento_id;
			$historialCorrespondencia->save();

			return Response::json(['message' => 'Historial Creado'], 200);
			#return ['id' => $nino->id];
		} catch (Exception $e) {
			return Response::json(['message' => $e->getMessage()], 400);
		}
    }

	public function activar(Request $request)
    {
        #if(!$request->ajax())return redirect('/');
        $historialCorrespondencia = HistorialCorrespondencia::findOrFail($request->id);
        $historialCorrespondencia->estado = '1';
        $historialCorrespondencia->save();
		return Response::json(['message' => 'Historial Activado'], 200);
	}
	public function desactivar(Request $request)
    {
        #if(!$request->ajax())return redirect('/');
        $historialCorrespondencia = HistorialCorrespondencia::findOrFail($request->id);
        $historialCorrespondencia->estado = '0';
        $historialCorrespondencia->save();
		return Response::json(['message' => 'Historial Desactivado'], 200);
	}
	public function imagen(Request $request){
		$imagen = $request->photos;
		$nombreEliminar = public_path('storage\public\correspondencia\\') .  $request->header("imagenanterior");
		if (File::exists($nombreEliminar)) {
			File::delete($nombreEliminar);
		}
		$completo = time() . "." . $imagen->extension();
		$imagen->move(public_path('storage/public/correspondencia/'), $completo);
		return Response::json($completo, 200);
	}

}
