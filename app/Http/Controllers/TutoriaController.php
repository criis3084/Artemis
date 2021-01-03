<?php

namespace App\Http\Controllers;

use Exception;
use App\Tutoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class TutoriaController extends Controller
{
	public function index(Request $request)
	{
		// Filtro por un criterio y estado
		$buscar = $request->buscar;
		$criterio = $request->criterio;
		$completo = (isset($request->completo)) ? $request->completo : $completo = 'false';
		$count = Tutoria::all()->count();
		if ($completo == 'false')
		{
			if ($buscar==''){
				$tutoria = Tutoria::with('nino')->with('tutor')->with('datos_tutor')->with('datos_nino')->orderBy('id', 'desc')->where('estado',1)->paginate($count);
			}
			else{
				$tutoria = Tutoria::with('nino')->with('tutor')->with('datos_tutor')->with('datos_nino')->where([[$criterio, 'like', $buscar ],['estado',1]])->orderBy('id', 'desc')->paginate($count);
			}
		} else if ($completo == 'true'){
			if ($buscar==''){
				$tutoria = Tutoria::with('nino')->with('tutor')->with('datos_tutor')->with('datos_nino')->orderBy('id', 'desc')->paginate($count);
			}
			else{
				$tutoria = Tutoria::with('nino')->with('tutor')->with('datos_tutor')->with('datos_nino')->where($criterio, 'like', $buscar)->orderBy('id', 'desc')->paginate($count);
			}
		}
		return [
			"tutorias"=>$tutoria
		];
	}

	public function store(Request $request)
	{
		//if(!$request->ajax())return redirect('/');
		try {
			$tutoria = new Tutoria();
			$tutoria->nombre = $request->nombre;
			$tutoria->fecha = $request->fecha;
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
		//if(!$request->ajax())return redirect('/');
		$tutoria = Tutoria::findOrFail($request->id);
		$tutoria->nombre = $request->nombre;
		$tutoria->fecha = $request->fecha;
		$tutoria->nino_id = $request->nino_id;
		$tutoria->tutor_id = $request->tutor_id;
		$tutoria->save();
		return Response::json(['message' => 'tutoría  Acualizada'], 200);
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

	public function tutoriasmen (Request $request)
	{
		$completo= $request->completo;
		$anio = $request->anio;
        if ($completo =='true'){
			if($anio==''){
				$consulta = DB::table('tutorias')
				->selectRaw('YEAR(fecha) AS anio, COUNT(*) AS total')
				->groupBy('anio')
				->get();
				return response()->json($consulta);
			}
			else
			{
				$consulta = DB::table('tutorias')
				->selectRaw('MONTH(fecha) AS mes, COUNT(*) AS total')
				->where('estado',1)
				->whereYear('fecha',$anio)
				->groupBy('fecha')
				->get();
				return response()->json($consulta);
			}
		} 

	}
}