<?php

namespace App\Http\Controllers;

use App\Apadrinamiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Exception;

class ApadrinamientoController extends Controller
{
    public function index(Request $request)
    {
		// Filtro por un criterio y estado
		$buscar = $request->buscar;
		$criterio = $request->criterio;
		$completo = (isset($request->completo)) ? $request->completo : 'false';
		
		if ($completo == 'false')
		{
			if ($buscar==''){
				$apadrinamiento = Apadrinamiento::with('nino')->with('padrino')->with('datos_padrino')->with('datos_nino')->orderBy('id', 'desc')->where('estado',1)->paginate(20);
			}
			else{
				$apadrinamiento = Apadrinamiento::with('nino')->with('padrino')->with('datos_padrino')->with('datos_nino')->where($criterio, 'like', '%'. $buscar . '%')->where('estado',1)->orderBy('id', 'desc')->paginate(20);
			}
		} else if ($completo == 'true'){
			if ($buscar==''){
				$apadrinamiento = Apadrinamiento::with('nino')->with('padrino')->with('datos_padrino')->with('datos_nino')->orderBy('id', 'desc')->paginate(20);
			}
			else{
				$apadrinamiento = Apadrinamiento::with('nino')->with('padrino')->with('datos_padrino')->with('datos_nino')->where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(20);
			}
		}
		return [
			'pagination' => [
				'total'        => $apadrinamiento->total(),
				'current_page' => $apadrinamiento->currentPage(),
				'per_page'     => $apadrinamiento->perPage(),
				'last_page'    => $apadrinamiento->lastPage(),
				'from'         => $apadrinamiento->firstItem(),
				'to'           => $apadrinamiento->lastItem(),
			],
			"apadrinamientos"=>$apadrinamiento
		];
    }

    public function store(Request $request)
    {
		//if(!$request->ajax())return redirect('/');
		try {
			$apadrinamiento = new Apadrinamiento();
			$apadrinamiento->nino_id = $request->nino_id;
			$apadrinamiento->padrino_id = $request->padrino_id;
			$apadrinamiento->save();
			return Response::json(['message' => 'Apadrinamiento Creada'], 200);
			#return ['id' => $nino->id];
		} catch (Exception $e) {
			return Response::json(['message' => $e->getMessage()], 400);
		}
    }

    public function show(Apadrinamiento $apadrinamiento)
    {
        //
    }

    public function update(Request $request, Apadrinamiento $apadrinamiento)
    {
		//if(!$request->ajax())return redirect('/');
		$relacion = Apadrinamiento::findOrFail($request->id);
		$apadrinamiento->nino_id = $request->nino_id;
		$apadrinamiento->padrino_id = $request->padrino_id;
		// Actualizar direccion del ni;o del encargado
		// Pendiente
		$relacion->save();
		
		return Response::json(['message' => 'Relazion Acualizada'], 200);
	}
	
	public function activar(Request $request)
    {
        #if(!$request->ajax())return redirect('/');
        $Apadrinamiento = Apadrinamiento::findOrFail($request->id);
        $Apadrinamiento->estado = '1';
        $Apadrinamiento->save();
		return Response::json(['message' => 'Apadrinamiento Activado'], 200);
	}

	public function desactivar(Request $request)
    {
        #if(!$request->ajax())return redirect('/');
        $Apadrinamiento = Apadrinamiento::findOrFail($request->id);
        $Apadrinamiento->estado = '0';
        $Apadrinamiento->save();
		return Response::json(['message' => 'Apadrinamiento Desactivado'], 200);
	}
}
