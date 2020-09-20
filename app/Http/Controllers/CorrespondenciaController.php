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
		
		if ($completo == 'false')
		{
			if ($buscar==''){
				$correspondencia = Correspondencia::with('apadrinamiento')->orderBy('id', 'desc')->where('estado',1)->paginate(20);
			}
			else{
				$correspondencia = Correspondencia::with('apadrinamiento')->where($criterio, 'like', '%'. $buscar . '%')->where('estado',1)->orderBy('id', 'desc')->paginate(20);
			}
		} else if ($completo == 'true'){
			if ($buscar==''){
				$correspondencia = Correspondencia::with('apadrinamiento')->orderBy('id', 'desc')->paginate(20);
			}
			else{
				$correspondencia = Correspondencia::with('apadrinamiento')->where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(20);
			}
		}
		return [
			'pagination' => [
				'total'        => $correspondencia->total(),
				'current_page' => $correspondencia->currentPage(),
				'per_page'     => $correspondencia->perPage(),
				'last_page'    => $correspondencia->lastPage(),
				'from'         => $correspondencia->firstItem(),
				'to'           => $correspondencia->lastItem(),
			],
			"Correspondencias"=>$correspondencia
		];
    }

    public function store(Request $request)
    {
		//if(!$request->ajax())return redirect('/');
		try {
			$correspondencia = new Correspondencia();
			$correspondencia->mensaje = $request->mensaje;
			$correspondencia->encabezado = $request->encabezado;
			$correspondencia->piePagina = $request->piePagina;
			$correspondencia->apadrinamiento_id = $request->apadrinamiento_id;
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
		$correspondencia->mensaje = $request->mensaje;
		$correspondencia->encabezado = $request->encabezado;
		$correspondencia->piePagina = $request->piePagina;
		$correspondencia->apadrinamiento_id = $request->apadrinamiento_id;
		$correspondencia->save();

		return Response::json(['message' => 'Correspondencia Actualizada'], 200);
	}
	
	public function activar(Request $request)
    {
        #if(!$request->ajax())return redirect('/');
        $correspondencia = Correspondencia::findOrFail($request->id);
        $correspondencia->estado = '1';
        $correspondencia->save();
		return Response::json(['message' => 'Correspondencia Desactivada'], 200);
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
