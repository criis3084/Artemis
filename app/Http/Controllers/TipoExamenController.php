<?php

namespace App\Http\Controllers;

use App\TipoExamen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Exception;

class TipoExamenController extends Controller
{
    public function index(Request $request)
    {
		$buscar = $request->buscar;
		$criterio = $request->criterio;
		$completo = (isset($request->completo)) ? $request->completo :'false';
		$count = TipoExamen::all()->count();
		if ($completo == 'false')
		{
			if ($buscar==''){
				$tipoExamen = TipoExamen::orderBy('id', 'desc')->where('estado',1)->paginate($count);
			}
			else{
				$tipoExamen = TipoExamen::where([[$criterio, 'like',$buscar],['estado',1]])->orderBy('id', 'desc')->paginate($count);
			}
		} else if ($completo == 'true'){
			if ($buscar==''){
				$tipoExamen = TipoExamen::orderBy('id', 'desc')->paginate($count);
			}
			else{
				$tipoExamen = TipoExamen::where($criterio,'like',$buscar)->orderBy('id', 'desc')->paginate($count);
			}
		}
		return [
			"tipoExamenes"=>$tipoExamen
		];
    }
    public function store(Request $request)
    {
		#if(!$request->ajax())return redirect('/');
        try {
			$tipoExamen = new TipoExamen();
			$tipoExamen->nombre = $request->nombre;
			$tipoExamen->save();
			return Response::json(['message' => 'TipoExamen Creado'], 200);
		} catch (Exception $e) {
            return Response::json(['message' => $e->getMessage()], 400);
		}
    }

    public function update(Request $request)
    {
		#if(!$request->ajax())return redirect('/');
        try {
		$tipoExamen = TipoExamen::findOrFail($request->id);
		$tipoExamen->nombre = $request->nombre;
		$tipoExamen->save();
		return Response::json(['message' => 'TipoExamen Actualizada'], 200);
		} catch (Exception $e) {
			return Response::json(['message' => $e->getMessage()], 400);
		}
	}
	public function activar(Request $request)
	{
        #if(!$request->ajax())return redirect('/');
        $tipoExamen = TipoExamen::findOrFail($request->id);
        $tipoExamen->estado = '1';
        $tipoExamen->save();
		return Response::json(['message' => 'TipoExamen Activado'], 200);
	}
	
	public function desactivar(Request $request)
	{
		#if(!$request->ajax())return redirect('/');
		$tipoExamen = TipoExamen::findOrFail($request->id);
		$tipoExamen->estado = '0';
		$tipoExamen->save();
		return Response::json(['message' => 'TipoExamen Desactivado'], 200);
	}
}