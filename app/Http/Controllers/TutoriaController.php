<?php

namespace App\Http\Controllers;

use App\Tutoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Exception;

class TutoriaController extends Controller
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
				$tutoria = Tutoria::with('nino')->with('tutor')->with('datos_tutor')->with('datos_nino')->orderBy('id', 'desc')->where('estado',1)->paginate(20);
			}
			else{
				$tutoria = Tutoria::with('nino')->with('tutor')->with('datos_tutor')->with('datos_nino')->where($criterio, 'like', '%'. $buscar . '%')->where('estado',1)->orderBy('id', 'desc')->paginate(20);
			}
		} else if ($completo == 'true'){
			if ($buscar==''){
				$tutoria = Tutoria::with('nino')->with('tutor')->with('datos_tutor')->with('datos_nino')->orderBy('id', 'desc')->paginate(20);
			}
			else{
				$tutoria = Tutoria::with('nino')->with('tutor')->with('datos_tutor')->with('datos_nino')->where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(20);
			}
		}
		return [
			'pagination' => [
				'total'        => $tutoria->total(),
				'current_page' => $tutoria->currentPage(),
				'per_page'     => $tutoria->perPage(),
				'last_page'    => $tutoria->lastPage(),
				'from'         => $tutoria->firstItem(),
				'to'           => $tutoria->lastItem(),
			],
			"tutorias"=>$tutoria
		];
	}

	public function store(Request $request)
	{
		//if(!$request->ajax())return redirect('/');
		try {
			$tutoria = new Tutoria();
			$tutoria->nino_id = $request->nino_id;
			$tutoria->tutor_id = $request->tutor_id;
			$tutoria->save();
			return Response::json(['message' => 'Tutoría Creada'], 200);
			#return ['id' => $nino->id];
		} catch (Exception $e) {
			return Response::json(['message' => $e->getMessage()], 400);
		}
	}

	public function update(Request $request)
	{
		//
	}

	public function activar(Request $request)
	{
		#if(!$request->ajax())return redirect('/');
        $tutoria = Tutoria::findOrFail($request->id);
        $tutoria->estado = '1';
        $tutoria->save();
		return Response::json(['message' => 'tutoría Activado'], 200);	 
	}

	public function desactivar(Request $request)
	{
		#if(!$request->ajax())return redirect('/');
        $tutoria = Tutoria::findOrFail($request->id);
        $tutoria->estado = '0';
        $tutoria->save();
		return Response::json(['message' => 'Tutoría Desactivado'], 200);
	}
}