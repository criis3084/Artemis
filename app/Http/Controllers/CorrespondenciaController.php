<?php

namespace App\Http\Controllers;

use App\Correspondencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Exception;

class CorrespondenciaController extends Controller
{
    public function index(Request $request)
    {
		// Filtro por un criterio y estado
		$buscar = $request->buscar;
		$criterio = $request->criterio;
		$completo = (isset($request->completo)) ? $request->completo : $completo = 'false';
		$count = Correspondencia::all()->count();
		
		if ($completo == 'false')
		{
			$count = Correspondencia::where('estado',1)->count();
			if ($buscar==''){
				$correspondencia = Correspondencia::orderBy('id', 'desc')->where('estado',1)->paginate($count);
			}
			else{
				$correspondencia = Correspondencia::where([[$criterio, 'like', $buscar],['estado',1]])->orderBy('id', 'desc')->paginate($count);
			}
		} else if ($completo == 'true'){
			if ($buscar==''){
				$correspondencia = Correspondencia::orderBy('id', 'desc')->paginate($count);
			}
			else{
				$correspondencia = Correspondencia::where($criterio, 'like', $buscar)->orderBy('id', 'desc')->paginate($count);
			}
		}
		return [
			"Correspondencias"=>$correspondencia
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
			return Response::json(['message' => 'Correspondencia Creada'], 200);
			#return ['id' => $nino->id];
		} catch (Exception $e) {
			return Response::json(['message' => $e->getMessage()], 400);
		}
    }

    public function show(Correspondencia $correspondencia)
    {
        //
    }

    public function edit(Correspondencia $correspondencia)
    {
        //
    }

    public function update(Request $request, Correspondencia $correspondencia)
    {
		$correspondencia = Correspondencia::findOrFail($request->id);
		$correspondencia->ruta_imagen = $request->ruta_imagen;
		$correspondencia->descripcion = $request->descripcion;
		$correspondencia->save();

		return Response::json(['message' => 'Correspondencia Actualizada'], 200);
	}
	
	public function activar(Request $request)
    {
        #if(!$request->ajax())return redirect('/');
        $correspondencia = Correspondencia::findOrFail($request->id);
        $correspondencia->estado = '1';
        $correspondencia->save();
		return Response::json(['message' => 'Correspondencia Activada'], 200);
	}

	public function desactivar(Request $request)
    {
        #if(!$request->ajax())return redirect('/');
        $correspondencia = Correspondencia::findOrFail($request->id);
        $correspondencia->estado = '0';
        $correspondencia->save();
		return Response::json(['message' => 'Correspondencia Desactivada'], 200);
	}
}
